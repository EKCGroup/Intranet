<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ownership extends My_Force_Login {

    public function __construct() {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->load->model('computing-support/Ownership_model', 'ownership_model');
    }

    public function index() {

        $this->load->helper('form');
        $this->load->library('form_validation');

        // validation rules
        $this->form_validation->set_rules('staff_full', 'Staff Full Name', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('make', 'Device Make', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('model', 'Device Model', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('sn', 'Device Serial Number', 'trim|required|min_length[3]');

        if ($this->form_validation->run() === false) {

            $this->load->view('templates/header');
            $this->load->view('computing-support/ownership/view');
            $this->load->view('templates/footer');
        } else {

            $logged = $this->input->post('logged');
            $staff_full = $this->input->post('staff_full');
            $make = $this->input->post('make');
            $model = $this->input->post('model');
            $sn = $this->input->post('sn');

            if ($this->ownership_model->create($logged, $staff_full, $make, $model, $sn)) {
                
                $staff_email = $this->ownership_model->email_id($staff_full);
                
                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Ownership Transfer');
                $this->email->to($staff_email[0]['email']);
                $this->email->subject('Ownership Transfer Request');
                $this->email->message('An IT equipment ownership transfer request has been submitted.'
                        . 'You must accept the terms and conditions at the following link before it can be approved by Computing Support.'
                        . ''
                        . 'https://intranet.cant-col.ac.uk/dashboard/computing-support/ownership/check'
                        . ''
                        . 'Use the same link to cancel the request or/and check the progress.');
                $this->email->send();

                $function = 'ownership_application';
                $this->user_model->function_log($function);

                // user created
                $this->load->view('templates/header');
                $this->load->view('computing-support/ownership/requested');
                $this->load->view('templates/footer');
            } else {

                $function = 'ownership_error';
                $this->user_model->function_log($function);

                $data = new stdClass();
                $data->error = 'There was a problem submitting this request. Please try again.';

                // failed to create user
                $this->load->view('templates/header');
                $this->load->view('computing-support/ownership/view', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function history() {

        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $data['ownership'] = $this->ownership_model->get_all_ownership();

            $this->load->view('templates/header');
            $this->load->view('computing-support/ownership/history', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('permissions');
        }
    }

    public function review() {

        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $data['ownership'] = $this->ownership_model->get_pending_ownership();

            $this->load->view('templates/header');
            $this->load->view('computing-support/ownership/review', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('permissions');
        }
    }

    public function check() {

        $data['ownership'] = $this->ownership_model->check_ownership();

        $this->load->view('templates/header');
        $this->load->view('computing-support/ownership/check', $data);
        $this->load->view('templates/footer');
    }

    public function approve() {

        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->ownership_model->approve($id);
                
                $check_user = $this->ownership_model->match_id_user($id);
                $staff_full = $check_user[0]['staff_full'];
                
                $staff_email = $this->ownership_model->email_id($staff_full);
                
                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Ownership Transfer');
                $this->email->to($staff_email[0]['email']);
                $this->email->subject('Ownership Transfer Request');
                $this->email->message('Your IT equipment ownership request has been approved.'
                        . ''
                        . 'https://intranet.cant-col.ac.uk/dashboard/computing-support/ownership/check'
                        . ''
                        . 'Check the progress of other requests and the history of your transfers.');
                $this->email->send();

                $function = 'ownership_APPROVE_' . $id;
                $this->user_model->function_log($function);

                redirect($_SERVER['HTTP_REFERER']);
            }

            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function reject() {

        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->ownership_model->reject($id);
                
                $check_user = $this->ownership_model->match_id_user($id);
                $staff_full = $check_user[0]['staff_full'];
                
                $staff_email = $this->ownership_model->email_id($staff_full);
                
                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Ownership Transfer');
                $this->email->to($staff_email[0]['email']);
                $this->email->subject('Ownership Transfer Request');
                $this->email->message('Your IT equipment ownership request has been rejected.'
                        . ''
                        . 'https://intranet.cant-col.ac.uk/dashboard/computing-support/ownership/check');
                $this->email->send();

                $function = 'ownership_REJECT_' . $id;
                $this->user_model->function_log($function);

                redirect($_SERVER['HTTP_REFERER']);
            }

            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function cancel() {
        
        $id = $_GET['id'];
        $check_user = $this->ownership_model->match_id_user($id);
        if ($check_user[0]['staff_full'] == $_SESSION['ldap']['full_name']) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->ownership_model->cancel($id);

                $function = 'ownership_CANCEL_' . $id;
                $this->user_model->function_log($function);

                redirect($_SERVER['HTTP_REFERER']);
            }
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function terms() {
        
        $id = $_GET['id'];
        $check_user = $this->ownership_model->match_id_user($id);
        if ($check_user[0]['staff_full'] == $_SESSION['ldap']['full_name']) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->ownership_model->terms($id);
                
                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Ownership Transfer');
                $this->email->to('ns@canterburycollege.ac.uk');
                $this->email->bcc('r.hayes@canterburycollege.ac.uk');
                $this->email->subject('Ownership Transfer Request');
                $this->email->message('A new IT equipment ownership transfer request has been submitted.'
                        . ''
                        . 'Review all pending requests below.'
                        . ''
                        . 'https://intranet.cant-col.ac.uk/dashboard/computing-support/ownership/review');
                $this->email->send();

                $function = 'ownership_TERMS_' . $id;
                $this->user_model->function_log($function);

                redirect($_SERVER['HTTP_REFERER']);
            }
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
