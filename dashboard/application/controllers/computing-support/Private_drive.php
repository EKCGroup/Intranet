<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Private_drive extends My_Force_Login {

    public function __construct() {
        parent::__construct();
        $this->load->model('computing-support/Private_drive_model', 'private_drive_model');
    }

    public function index() {

        if (in_array('CN=Dashboard_CS_NS,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                in_array('CN=Dashboard_Section_Manager,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                in_array('CN=Dashboard_Faculty_Head,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $this->load->helper('form');
            $this->load->library('form_validation');
            //validation
            $this->form_validation->set_rules('user', 'Staff requiring access', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('path', 'Path', 'trim|required|min_length[13]');
            $this->form_validation->set_rules('access', 'Access Level', 'trim|required');
            $this->form_validation->set_rules('approver', 'Approve by', 'trim|required');

            if ($this->form_validation->run() === FALSE) {

                $this->load->view('templates/header');
                $this->load->view('computing-support/private-drive/view');
                $this->load->view('templates/footer');
            } else {

                $requester = $this->input->post('logged');
                $user = $this->input->post('user');
                $path = $this->input->post('path');
                $access = $this->input->post('access');
                $approver = $this->input->post('approver');

                preg_match('#\((.*?)\)#', $user, $user_un);
                $user_un = $user_un[1];

                if ($this->private_drive_model->create($requester, $user, $user_un, $path, $access, $approver)) {

                    $username = $user_un;
                    $user_email = $this->private_drive_model->get_email_username($username);

                    $this->email->from('noreply@intranet.cant-col.ac.uk', 'Private Drive Access');
                    $this->email->to($user_email);
                    $this->email->cc($_SESSION['ldap']['email']);
                    $this->email->subject('Private Drive Access Request');
                    $this->email->message('Access to a private drive has been requested for ' . $user . ' by ' . $requester . '. 
                    This request is currently waiting for approval by ' . $approver . '. 
                            
                    You can check the status of the request at the following link:
                    https://intranet.cant-col.ac.uk/dashboard/computing-support/private-drive/check
                            
                    If this request was made by mistake; you can cancel the request using the same link.
                            
                    Folder path: ' . $path . '
                    Access level: ' . $access);
                    $this->email->send();

                    $full_name = $approver;
                    $faculty_email = $this->private_drive_model->get_email_approver($full_name);

                    $this->email->from('noreply@intranet.cant-col.ac.uk', 'Private Drive Access');
                    $this->email->to($faculty_email);
                    $this->email->subject('Private Drive Access Request');
                    $this->email->message('Access to a private drive has been requested for ' . $user . ' by ' . $requester . '.
                    You have been marked as the approver for this request.
                            
                    Please approve or reject this request using the following link:
                    https://intranet.cant-col.ac.uk/dashboard/computing-support/private-drive/check
                            
                    Folder path: ' . $path . '
                    Access level: ' . $access);
                    $this->email->send();

                    $this->load->view('templates/header');
                    $this->load->view('computing-support/private-drive/complete');
                    $this->load->view('templates/footer');
                } else {

                    $data = new stdClass();
                    $data->error = 'There was a problem requesting access. Please try again.';

                    // failed to create user
                    $this->load->view('templates/header');
                    $this->load->view('computing-support/private-drive/view', $data);
                    $this->load->view('templates/footer');
                }
            }
        } else {
            redirect('permissions');
        }
    }

    public function history() {

        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $data = array();
            $data['private_drive'] = $this->private_drive_model->get_all();

            $this->load->view('templates/header');
            $this->load->view('computing-support/private-drive/history', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('permissions');
        }
    }

    public function check() {

        $data = array();
        $data['private_drive'] = $this->private_drive_model->check_status();

        $this->load->view('templates/header');
        $this->load->view('computing-support/private-drive/check', $data);
        $this->load->view('templates/footer');
    }

    public function pending() {

        if (in_array('CN=Dashboard_CS_NS,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $data = array();
            $data['private_drive'] = $this->private_drive_model->get_pending();

            $this->load->view('templates/header');
            $this->load->view('computing-support/private-drive/pending', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('permissions');
        }
    }

    public function cancel() {

        $id = $_GET['id'];
        $check_user = $this->private_drive_model->match_id_user($id);
        if ($check_user[0]['requested'] == $_SESSION['ldap']['full_name'] || $check_user[0]['user'] == $_SESSION['ldap']['full_name'] || $check_user[0]['approver'] == $_SESSION['ldap']['full_name']) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->private_drive_model->cancel($id);

                $function = 'private_drive_CANCEL_' . $id;
                $this->user_model->function_log($function);

                redirect($_SERVER['HTTP_REFERER']);
            }
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function fh_reject() {

        if (in_array('CN=Dashboard_Faculty_Head,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->private_drive_model->fh_reject($id);

                $get_request = $this->private_drive_model->get_request($id);
                
                $requester_un = $get_request[0]['requester_un'];
                $requester_email = $this->private_drive_model->get_email_username($requester_un);
                
                $user_un = $get_request[0]['user_un'];
                $user_email = $this->private_drive_model->get_email_username($user_un);

                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Private Drive Access');
                $this->email->to($requester_email);
                $this->email->cc($user_email);
                $this->email->subject('Private Drive Access Request Rejected');
                $this->email->message('Access to a private drive has been requested for ' . $get_request[0]['user'] . ' by ' . $get_request[0]['requester'] . ' has been rejected by ' . $get_request[0]['approver'] . '.
                            
                You can view the status of this request and others like it using the below link:
                https://intranet.cant-col.ac.uk/dashboard/computing-support/private-drive/check
                            
                Folder path: ' . $get_request[0]['path'] . '
                Access level: ' . $get_request[0]['access']);
                $this->email->send();

                $function = 'private_drive_FH_REJECT_' . $id;
                $this->user_model->function_log($function);

                redirect($_SERVER['HTTP_REFERER']);
            }

            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function fh_approve() {

        if (in_array('CN=Dashboard_Faculty_Head,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->private_drive_model->fh_approve($id);
                
                $get_request = $this->private_drive_model->get_request($id);

                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Private Drive Access');
                $this->email->to('ns@canterburycollege.ac.uk');
                $this->email->cc('d.mitchell@canterburycollege.ac.uk');
                $this->email->subject('Private Drive Access Request Approved');
                $this->email->message('Access to a private drive has been requested for ' . $get_request[0]['user'] . ' by ' . $get_request[0]['requester'] . ' has been approved by ' . $get_request[0]['approver'] . '.
                            
                This request needs to be actioned
                            
                View the details of the request at the following link:
                https://intranet.cant-col.ac.uk/dashboard/computing-support/private-drive/pending
                            
                Folder path: ' . $get_request[0]['path'] . '
                Access level: ' . $get_request[0]['access']);
                $this->email->send();

                $function = 'private_drive_FH_APPROVED_' . $id;
                $this->user_model->function_log($function);

                redirect($_SERVER['HTTP_REFERER']);
            }
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function cs_reject() {

        if (in_array('CN=Dashboard_CS_NS,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->private_drive_model->cs_reject($id);
                
                $get_request = $this->private_drive_model->get_request($id);
                
                $requester_un = $get_request[0]['requester_un'];
                $requester_email = $this->private_drive_model->get_email_username($requester_un);
                
                $user_un = $get_request[0]['user_un'];
                $user_email = $this->private_drive_model->get_email_username($user_un);

                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Private Drive Access');
                $this->email->to($requester_email);
                $this->email->cc($user_email);
                $this->email->subject('Private Drive Access Request Rejected');
                $this->email->message('Access to a private drive has been requested for ' . $get_request[0]['user'] . ' by ' . $get_request[0]['requester'] . ' and approved by ' . $get_request[0]['approver'] . ' has been rejected by Computing Support.
                            
                You can view the status of this request and others like it using the below link:
                https://intranet.cant-col.ac.uk/dashboard/computing-support/private-drive/check
                            
                Folder path: ' . $get_request[0]['path'] . '
                Access level: ' . $get_request[0]['access']);
                $this->email->send();

                $function = 'private_drive_CS_REJECT_' . $id;
                $this->user_model->function_log($function);

                redirect($_SERVER['HTTP_REFERER']);
            }

            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function cs_approve() {

        if (in_array('CN=Dashboard_CS_NS,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->private_drive_model->cs_approve($id);
                
                $get_request = $this->private_drive_model->get_request($id);
                
                $requester_un = $get_request[0]['requester_un'];
                $requester_email = $this->private_drive_model->get_email_username($requester_un);
                
                $user_un = $get_request[0]['user_un'];
                $user_email = $this->private_drive_model->get_email_username($user_un);

                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Private Drive Access');
                $this->email->to($requester_email);
                $this->email->cc($user_email);
                $this->email->subject('Private Drive Access Request Actioned');
                $this->email->message('Access to a private drive has been requested for ' . $get_request[0]['user'] . ' by ' . $get_request[0]['requester'] . ' and approved by ' . $get_request[0]['approver'] . ' has been actioned by Computing Support.
                            
                For the permissions to be applied, you must log out and on again.
                
                You can view your other requests at the following link.
                https://intranet.cant-col.ac.uk/dashboard/computing-support/private-drive/check
                            
                Folder path: ' . $get_request[0]['path'] . '
                Access level: ' . $get_request[0]['access']);
                $this->email->send();

                $function = 'private_drive_CS_APPROVED_' . $id;
                $this->user_model->function_log($function);

                redirect($_SERVER['HTTP_REFERER']);
            }
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

}
