<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Room_move extends My_Force_Login {

    public function __construct() {
        parent::__construct();
        $this->load->model('computing-support/Room_move_model', 'room_move_model');
    }

    public function index() {

        $this->load->helper('form');
        $this->load->library('form_validation');

        //validation
        $this->form_validation->set_rules('move', 'Move date', 'trim|required');
        $this->form_validation->set_rules('from', 'Room from', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('to', 'Room to', 'trim|required');
        $this->form_validation->set_rules('furniture', 'Furniture', 'trim|required');
        $this->form_validation->set_rules('reason', 'Reason for move', 'required');
        $this->form_validation->set_rules('full_name', 'Staff Involved', 'trim|required');

        if ($this->form_validation->run() === FALSE) {

            $this->load->view('templates/header');
            $this->load->view('computing-support/room-move/view');
            $this->load->view('templates/footer');
        } else {

            $requester = $this->input->post('logged');
            $move = $this->input->post('move');
            $from = $this->input->post('from');
            $to = $this->input->post('to');
            $furniture = $this->input->post('furniture');
            $reason = $this->input->post('reason');
            $full_name = $this->input->post('full_name');
            $full_name2 = $this->input->post('full_name2');
            $full_name3 = $this->input->post('full_name3');
            $full_name4 = $this->input->post('full_name4');
            $full_name5 = $this->input->post('full_name5');
            $full_name6 = $this->input->post('full_name6');
            $full_name7 = $this->input->post('full_name7');
            $full_name8 = $this->input->post('full_name8');
            $full_name9 = $this->input->post('full_name9');
            $full_name10 = $this->input->post('full_name10');

            if ($this->room_move_model->create($requester, $move, $from, $to, $furniture, $reason, $full_name, $full_name2, $full_name3, $full_name4, $full_name5, $full_name6, $full_name7, $full_name8, $full_name9, $full_name10)) {

                $this->load->view('templates/header');
                $this->load->view('computing-support/room-move/complete');
                $this->load->view('templates/footer');
                
                if ($furniture == "No Furniture"){

                    $to_add = array('r.hayes@canterburycollege.ac.uk', 'ns@canterburycollege.ac.uk', 'a.pezelet@canterburycollege.ac.uk');
                    
                    $this->email->from('noreply@intranet.cant-col.ac.uk', 'Room Move Request');
                    $this->email->to($to_add);
                    $this->email->subject('Room Move Request');
                    $this->email->message('A room move request has been submitted by '.$requester.' and does not need Estates approval.

                    Move date: '.$move.'
                    Room from: '.$from.'
                    Room to: '.$to.'
                    Furniture: '.$furniture.'

                    Reason for move: 
                    '.$reason.'

                    Use the following link to view more information or to approve and reject the request:
                    https://intranet.cant-col.ac.uk/dashboard/computing-support/room-move/pending');
                    $this->email->send();
                    
                } else {
                    
                    $to_add = array('estateshelpdesk@canterburycollege.ac.uk', 'a.pezelet@canterburycollege.ac.uk');

                    $this->email->from('noreply@intranet.cant-col.ac.uk', 'Room Move Request');
                    $this->email->to($to_add);
                    $this->email->subject('Room Move Request');
                    $this->email->message('A room move request has been submitted by '.$requester.'

                    Move date: '.$move.'
                    Room from: '.$from.'
                    Room to: '.$to.'
                    Furniture: '.$furniture.'

                    Reason for move: 
                    '.$reason.'

                    Use the following link to view more information or to approve and reject the request:
                    https://intranet.cant-col.ac.uk/dashboard/computing-support/room-move/pending');
                    $this->email->send();
                    
                    $to = array('r.hayes@canterburycollege.ac.uk', 'ns@canterburycollege.ac.uk');
                    
                    $this->email->from('noreply@intranet.cant-col.ac.uk', 'Room Move Request');
                    $this->email->to($to);
                    $this->email->subject('Room Move Request');
                    $this->email->message('A room move request has been submitted by '.$requester.' BUT needs Estates approval.

                    Move date: '.$move.'
                    Room from: '.$from.'
                    Room to: '.$to.'

                    Reason for move: 
                    '.$reason.'

                    Use the following link to view more information or to approve and reject the request:
                    https://intranet.cant-col.ac.uk/dashboard/computing-support/room-move/pending');
                    $this->email->send();
                
                }
                
                preg_match('#\((.*?)\)#', $this->input->post('full_name'), $user_un);
                $user_un = $user_un[1];
                if (isset($full_name2)) {
                    preg_match('#\((.*?)\)#', $this->input->post('full_name2'), $user_un2);
                    $user_un2 = $user_un2[1];
                } else { $user_un2 = NULL; } if (isset($full_name3)) {
                    preg_match('#\((.*?)\)#', $this->input->post('full_name3'), $user_un3);
                    $user_un3 = $user_un3[1];
                } else { $user_un3 = NULL; } if (isset($full_name4)) {
                    preg_match('#\((.*?)\)#', $this->input->post('full_name4'), $user_un4);
                    $user_un4 = $user_un4[1];
                } else { $user_un4 = NULL; } if (isset($full_name5)) {
                    preg_match('#\((.*?)\)#', $this->input->post('full_name5'), $user_un5);
                    $user_un5 = $user_un5[1];
                } else { $user_un5 = NULL; } if (isset($full_name6)) {
                    preg_match('#\((.*?)\)#', $this->input->post('full_name6'), $user_un6);
                    $user_un6 = $user_un6[1];
                } else { $user_un6 = NULL; } if (isset($full_name7)) {
                    preg_match('#\((.*?)\)#', $this->input->post('full_name7'), $user_un7);
                    $user_un7 = $user_un7[1];
                } else { $user_un7 = NULL; } if (isset($full_name8)) {
                    preg_match('#\((.*?)\)#', $this->input->post('full_name8'), $user_un8);
                    $user_un8 = $user_un8[1];
                } else { $user_un8 = NULL; } if (isset($full_name9)) {
                    preg_match('#\((.*?)\)#', $this->input->post('full_name9'), $user_un9);
                    $user_un9 = $user_un9[1];
                } else { $user_un9 = NULL; } if (isset($full_name10)) {
                    preg_match('#\((.*?)\)#', $this->input->post('full_name10'), $user_un10);
                    $user_un10 = $user_un10[1];
                } else { $user_un10 = NULL; }
                
                $requester_email = $_SESSION['ldap']['email'];
                
                $staff_involved_un = $user_un;
                $staff_involved_email = $this->room_move_model->get_email_username($staff_involved_un);
                
                $staff_involved_un2 = $user_un2;
                $staff_involved_email2 = $this->room_move_model->get_email_username($staff_involved_un2);
                
                $staff_involved_un3 = $user_un3;
                $staff_involved_email3 = $this->room_move_model->get_email_username($staff_involved_un3);
                
                $staff_involved_un4 = $user_un4;
                $staff_involved_email4 = $this->room_move_model->get_email_username($staff_involved_un4);
                
                $staff_involved_un5 = $user_un5;
                $staff_involved_email5 = $this->room_move_model->get_email_username($staff_involved_un5);
                
                $staff_involved_un6 = $user_un6;
                $staff_involved_email6 = $this->room_move_model->get_email_username($staff_involved_un6);
                
                $staff_involved_un7= $user_un7;
                $staff_involved_email7 = $this->room_move_model->get_email_username($staff_involved_un7);
                
                $staff_involved_un8 = $user_un8;
                $staff_involved_email8 = $this->room_move_model->get_email_username($staff_involved_un8);
                
                $staff_involved_un9 = $user_un9;
                $staff_involved_email9 = $this->room_move_model->get_email_username($staff_involved_un9);
                
                $staff_involved_un10 = $user_un10;
                $staff_involved_email10 = $this->room_move_model->get_email_username($staff_involved_un10);
                
                $cc = array($staff_involved_email, $staff_involved_email2, $staff_involved_email3, $staff_involved_email4, $staff_involved_email5, $staff_involved_email6, $staff_involved_email7, $staff_involved_email8, $staff_involved_email9, $staff_involved_email10);
                
                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Room Move Request');
                $this->email->to($requester_email);
                $this->email->cc($cc);
                $this->email->subject('Room Move Request');
                $this->email->message('A room move request has been requested by '.$requester.'.
                
                Move date: '.$move.'
                Room from: '.$from.'
                Room to: '.$to.'
                    
                Use the following link to view more information:
                https://intranet.cant-col.ac.uk/dashboard/computing-support/room-move/check');
                $this->email->send();
                
            } else {

                $data = new stdClass();
                $data->error = 'There was a problem requesting this move. Please try again.';

                // failed to create user
                $this->load->view('templates/header');
                $this->load->view('computing-support/room-move/view', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function history() {

        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                in_array('CN=Dashboard_Estates_Room_Move,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $data = array();
            $data['room_move'] = $this->room_move_model->get_all();

            $this->load->view('templates/header');
            $this->load->view('computing-support/room-move/history', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('permissions');
        }
    }

    public function check() {

        $data = array();
        $data['room_move'] = $this->room_move_model->check_status();

        $this->load->view('templates/header');
        $this->load->view('computing-support/room-move/check', $data);
        $this->load->view('templates/footer');
    }

    public function pending() {

        if (in_array('CN=Dashboard_CS_NS,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                in_array('CN=Dashboard_Estates_Room_Move,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $data = array();
            $data['room_move'] = $this->room_move_model->get_pending();

            $this->load->view('templates/header');
            $this->load->view('computing-support/room-move/pending', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('permissions');
        }
    }

    public function cancel() {

        $id = $_GET['id'];
        $check_user = $this->room_move_model->match_id_user($id);
        if ($check_user[0]['requester_un'] == $_SESSION['username']) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->room_move_model->cancel($id);

                $function = 'room_move_CANCEL_' . $id;
                $this->user_model->function_log($function);
                
                $get_request = $this->room_move_model->get_request($id);
                
                $requester_un = $get_request[0]['requester_un'];
                $requester_email = $this->room_move_model->get_email_username($requester_un);
                
                $staff_involved_un = $get_request[0]['staff_involved_un'];
                $staff_involved_email = $this->room_move_model->get_email_username($staff_involved_un);
                
                $staff_involved_un2 = $get_request[0]['staff_involved_un2'];
                $staff_involved_email2 = $this->room_move_model->get_email_username($staff_involved_un2);
                
                $staff_involved_un3 = $get_request[0]['staff_involved_un3'];
                $staff_involved_email3 = $this->room_move_model->get_email_username($staff_involved_un3);
                
                $staff_involved_un4 = $get_request[0]['staff_involved_un4'];
                $staff_involved_email4 = $this->room_move_model->get_email_username($staff_involved_un4);
                
                $staff_involved_un5 = $get_request[0]['staff_involved_un5'];
                $staff_involved_email5 = $this->room_move_model->get_email_username($staff_involved_un5);
                
                $staff_involved_un6 = $get_request[0]['staff_involved_un6'];
                $staff_involved_email6 = $this->room_move_model->get_email_username($staff_involved_un6);
                
                $staff_involved_un7= $get_request[0]['staff_involved_un7'];
                $staff_involved_email7 = $this->room_move_model->get_email_username($staff_involved_un7);
                
                $staff_involved_un8 = $get_request[0]['staff_involved_un8'];
                $staff_involved_email8 = $this->room_move_model->get_email_username($staff_involved_un8);
                
                $staff_involved_un9 = $get_request[0]['staff_involved_un9'];
                $staff_involved_email9 = $this->room_move_model->get_email_username($staff_involved_un9);
                
                $staff_involved_un10 = $get_request[0]['staff_involved_un10'];
                $staff_involved_email10 = $this->room_move_model->get_email_username($staff_involved_un10);
                
                $to = array('helpdesk@canterburycollege.ac.uk', 'estateshelpdesk@canterburycollege.ac.uk', $requester_email);
                $cc = array($staff_involved_email, $staff_involved_email2, $staff_involved_email3, $staff_involved_email4, $staff_involved_email5, $staff_involved_email6, $staff_involved_email7, $staff_involved_email8, $staff_involved_email9, $staff_involved_email10);
                
                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Room Move Request');
                $this->email->to($to);
                $this->email->cc($cc);
                $this->email->subject('Room Move Request');
                $this->email->message('A room move request has been canceled by '.$get_request[0]['requester'].'
                
                Move date: '.$get_request[0]['move'].'
                Room from: '.$get_request[0]['from'].'
                Room to: '.$get_request[0]['to']);
                $this->email->send();

                $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
                redirect($url);
            }
            $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
            redirect($url);
        } else {
            $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
            redirect($url);
        }
    }

    public function eh_reject() {

        if (in_array('CN=Dashboard_Estates_Room_Move,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->room_move_model->eh_reject($id);

                $function = 'room_move_EH_REJECT_' . $id;
                $this->user_model->function_log($function);
                
                $get_request = $this->room_move_model->get_request($id);
                
                $requester_un = $get_request[0]['requester_un'];
                $requester_email = $this->room_move_model->get_email_username($requester_un);
                
                $staff_involved_un = $get_request[0]['staff_involved_un'];
                $staff_involved_email = $this->room_move_model->get_email_username($staff_involved_un);
                
                $staff_involved_un2 = $get_request[0]['staff_involved_un2'];
                $staff_involved_email2 = $this->room_move_model->get_email_username($staff_involved_un2);
                
                $staff_involved_un3 = $get_request[0]['staff_involved_un3'];
                $staff_involved_email3 = $this->room_move_model->get_email_username($staff_involved_un3);
                
                $staff_involved_un4 = $get_request[0]['staff_involved_un4'];
                $staff_involved_email4 = $this->room_move_model->get_email_username($staff_involved_un4);
                
                $staff_involved_un5 = $get_request[0]['staff_involved_un5'];
                $staff_involved_email5 = $this->room_move_model->get_email_username($staff_involved_un5);
                
                $staff_involved_un6 = $get_request[0]['staff_involved_un6'];
                $staff_involved_email6 = $this->room_move_model->get_email_username($staff_involved_un6);
                
                $staff_involved_un7= $get_request[0]['staff_involved_un7'];
                $staff_involved_email7 = $this->room_move_model->get_email_username($staff_involved_un7);
                
                $staff_involved_un8 = $get_request[0]['staff_involved_un8'];
                $staff_involved_email8 = $this->room_move_model->get_email_username($staff_involved_un8);
                
                $staff_involved_un9 = $get_request[0]['staff_involved_un9'];
                $staff_involved_email9 = $this->room_move_model->get_email_username($staff_involved_un9);
                
                $staff_involved_un10 = $get_request[0]['staff_involved_un10'];
                $staff_involved_email10 = $this->room_move_model->get_email_username($staff_involved_un10);
                
                $to = array('r.hayes@canterburycollege.ac.uk', 'ns@canterburycollege.ac.uk', $requester_email);
                $cc = array($staff_involved_email, $staff_involved_email2, $staff_involved_email3, $staff_involved_email4, $staff_involved_email5, $staff_involved_email6, $staff_involved_email7, $staff_involved_email8, $staff_involved_email9, $staff_involved_email10);
                
                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Room Move Request');
                $this->email->to($to);
                $this->email->cc($cc);
                $this->email->subject('Room Move Request');
                $this->email->message('A room move request has been rejected by Estates.
                
                Requested by: '.$get_request[0]['requester'].'
                Move date: '.$get_request[0]['move'].'
                Room from: '.$get_request[0]['from'].'
                Room to: '.$get_request[0]['to']);
                $this->email->send();

                $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
                redirect($url);
            }

            $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
            redirect($url);
        } else {
            $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
            redirect($url);
        }
    }

    public function eh_approve() {

        if (in_array('CN=Dashboard_Estates_Room_Move,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->room_move_model->eh_approve($id);

                $function = 'room_move_EH_APPROVED_' . $id;
                $this->user_model->function_log($function);
                
                $get_request = $this->room_move_model->get_request($id);
                
                $to = array('r.hayes@canterburycollege.ac.uk', 'ns@canterburycollege.ac.uk');
                
                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Room Move Request');
                $this->email->to($to);
                $this->email->subject('Room Move Request');
                $this->email->message('A room move request has been approved by Estates.
                
                Requested by: '.$get_request[0]['requester'].'
                Move date: '.$get_request[0]['move'].'
                Room from: '.$get_request[0]['from'].'
                Room to: '.$get_request[0]['to'].'
                    
                Reason for move: 
                '.$get_request[0]['reason']);
                $this->email->send();

                $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
                redirect($url);
            }
            $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
            redirect($url);
        } else {
            $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
            redirect($url);
        }
    }

    public function cs_reject() {

        if (in_array('CN=Dashboard_CS_NS,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $reason = $_GET['reason'];
                $this->room_move_model->cs_reject($id);

                $function = 'room_move_CS_REJECT_' . $id;
                $this->user_model->function_log($function);
                
                $get_request = $this->room_move_model->get_request($id);
                
                $requester_un = $get_request[0]['requester_un'];
                $requester_email = $this->room_move_model->get_email_username($requester_un);
                
                $staff_involved_un = $get_request[0]['staff_involved_un'];
                $staff_involved_email = $this->room_move_model->get_email_username($staff_involved_un);
                
                $staff_involved_un2 = $get_request[0]['staff_involved_un2'];
                $staff_involved_email2 = $this->room_move_model->get_email_username($staff_involved_un2);
                
                $staff_involved_un3 = $get_request[0]['staff_involved_un3'];
                $staff_involved_email3 = $this->room_move_model->get_email_username($staff_involved_un3);
                
                $staff_involved_un4 = $get_request[0]['staff_involved_un4'];
                $staff_involved_email4 = $this->room_move_model->get_email_username($staff_involved_un4);
                
                $staff_involved_un5 = $get_request[0]['staff_involved_un5'];
                $staff_involved_email5 = $this->room_move_model->get_email_username($staff_involved_un5);
                
                $staff_involved_un6 = $get_request[0]['staff_involved_un6'];
                $staff_involved_email6 = $this->room_move_model->get_email_username($staff_involved_un6);
                
                $staff_involved_un7= $get_request[0]['staff_involved_un7'];
                $staff_involved_email7 = $this->room_move_model->get_email_username($staff_involved_un7);
                
                $staff_involved_un8 = $get_request[0]['staff_involved_un8'];
                $staff_involved_email8 = $this->room_move_model->get_email_username($staff_involved_un8);
                
                $staff_involved_un9 = $get_request[0]['staff_involved_un9'];
                $staff_involved_email9 = $this->room_move_model->get_email_username($staff_involved_un9);
                
                $staff_involved_un10 = $get_request[0]['staff_involved_un10'];
                $staff_involved_email10 = $this->room_move_model->get_email_username($staff_involved_un10);
                
                $to = array($requester_email, 'estateshelpdesk@canterburycollege.ac.uk');
                $cc = array($staff_involved_email, $staff_involved_email2, $staff_involved_email3, $staff_involved_email4, $staff_involved_email5, $staff_involved_email6, $staff_involved_email7, $staff_involved_email8, $staff_involved_email9, $staff_involved_email10);
                
                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Room Move Request');
                $this->email->to($to);
                $this->email->cc($cc);
                $this->email->subject('Room Move Request');
                $this->email->message('A room move request has been rejected by Computing Support.
                
                Requested by: '.$get_request[0]['requester'].'
                Move date: '.$get_request[0]['move'].'
                Room from: '.$get_request[0]['from'].'
                Room to: '.$get_request[0]['to']);
                $this->email->send();
                
                $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
                redirect($url);
            }

            $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
            redirect($url);
        } else {
            $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
            redirect($url);
        }
    }

    public function cs_approve() {

        if (in_array('CN=Dashboard_CS_NS,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->room_move_model->cs_approve($id);

                $function = 'room_move_CS_APPROVED_' . $id;
                $this->user_model->function_log($function);
                
                $get_request = $this->room_move_model->get_request($id);
                
                $requester_un = $get_request[0]['requester_un'];
                $requester_email = $this->room_move_model->get_email_username($requester_un);
                
                $staff_involved_un = $get_request[0]['staff_involved_un'];
                $staff_involved_email = $this->room_move_model->get_email_username($staff_involved_un);
                
                $staff_involved_un2 = $get_request[0]['staff_involved_un2'];
                $staff_involved_email2 = $this->room_move_model->get_email_username($staff_involved_un2);
                
                $staff_involved_un3 = $get_request[0]['staff_involved_un3'];
                $staff_involved_email3 = $this->room_move_model->get_email_username($staff_involved_un3);
                
                $staff_involved_un4 = $get_request[0]['staff_involved_un4'];
                $staff_involved_email4 = $this->room_move_model->get_email_username($staff_involved_un4);
                
                $staff_involved_un5 = $get_request[0]['staff_involved_un5'];
                $staff_involved_email5 = $this->room_move_model->get_email_username($staff_involved_un5);
                
                $staff_involved_un6 = $get_request[0]['staff_involved_un6'];
                $staff_involved_email6 = $this->room_move_model->get_email_username($staff_involved_un6);
                
                $staff_involved_un7= $get_request[0]['staff_involved_un7'];
                $staff_involved_email7 = $this->room_move_model->get_email_username($staff_involved_un7);
                
                $staff_involved_un8 = $get_request[0]['staff_involved_un8'];
                $staff_involved_email8 = $this->room_move_model->get_email_username($staff_involved_un8);
                
                $staff_involved_un9 = $get_request[0]['staff_involved_un9'];
                $staff_involved_email9 = $this->room_move_model->get_email_username($staff_involved_un9);
                
                $staff_involved_un10 = $get_request[0]['staff_involved_un10'];
                $staff_involved_email10 = $this->room_move_model->get_email_username($staff_involved_un10);
                
                $to = array('helpdesk@canterburycollege.ac.uk', 'estateshelpdesk@canterburycollege.ac.uk', $requester_email);
                $cc = array($staff_involved_email, $staff_involved_email2, $staff_involved_email3, $staff_involved_email4, $staff_involved_email5, $staff_involved_email6, $staff_involved_email7, $staff_involved_email8, $staff_involved_email9, $staff_involved_email10);
                
                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Room Move Request');
                $this->email->to($to);
                $this->email->cc($cc);
                $this->email->subject('Room Move Request');
                $this->email->message('A room move request has been accepted by Computing Support.
                
                Requested by: '.$get_request[0]['requester'].'
                Move date: '.$get_request[0]['move'].'
                Room from: '.$get_request[0]['from'].'
                Room to: '.$get_request[0]['to']);
                $this->email->send();

                $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
                redirect($url);
            }
            $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
            redirect($url);
        } else {
            $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
            redirect($url);
        }
    }

    public function cs_complete() {

        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->room_move_model->cs_complete($id);

                $function = 'room_move_CS_COMPLETE_' . $id;
                $this->user_model->function_log($function);
                
                $get_request = $this->room_move_model->get_request($id);
                
                $requester_un = $get_request[0]['requester_un'];
                $requester_email = $this->room_move_model->get_email_username($requester_un);
                
                $staff_involved_un = $get_request[0]['staff_involved_un'];
                $staff_involved_email = $this->room_move_model->get_email_username($staff_involved_un);
                
                $staff_involved_un2 = $get_request[0]['staff_involved_un2'];
                $staff_involved_email2 = $this->room_move_model->get_email_username($staff_involved_un2);
                
                $staff_involved_un3 = $get_request[0]['staff_involved_un3'];
                $staff_involved_email3 = $this->room_move_model->get_email_username($staff_involved_un3);
                
                $staff_involved_un4 = $get_request[0]['staff_involved_un4'];
                $staff_involved_email4 = $this->room_move_model->get_email_username($staff_involved_un4);
                
                $staff_involved_un5 = $get_request[0]['staff_involved_un5'];
                $staff_involved_email5 = $this->room_move_model->get_email_username($staff_involved_un5);
                
                $staff_involved_un6 = $get_request[0]['staff_involved_un6'];
                $staff_involved_email6 = $this->room_move_model->get_email_username($staff_involved_un6);
                
                $staff_involved_un7= $get_request[0]['staff_involved_un7'];
                $staff_involved_email7 = $this->room_move_model->get_email_username($staff_involved_un7);
                
                $staff_involved_un8 = $get_request[0]['staff_involved_un8'];
                $staff_involved_email8 = $this->room_move_model->get_email_username($staff_involved_un8);
                
                $staff_involved_un9 = $get_request[0]['staff_involved_un9'];
                $staff_involved_email9 = $this->room_move_model->get_email_username($staff_involved_un9);
                
                $staff_involved_un10 = $get_request[0]['staff_involved_un10'];
                $staff_involved_email10 = $this->room_move_model->get_email_username($staff_involved_un10);
                
                $to = array('r.hayes@canterburycollege.ac.uk', 'estateshelpdesk@canterburycollege.ac.uk', $requester_email);
                $cc = array($staff_involved_email, $staff_involved_email2, $staff_involved_email3, $staff_involved_email4, $staff_involved_email5, $staff_involved_email6, $staff_involved_email7, $staff_involved_email8, $staff_involved_email9, $staff_involved_email10);
                                
                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Room Move Request');
                $this->email->to($to);
                $this->email->cc($cc);
                $this->email->subject('Room Move Request');
                $this->email->message('A room move request has been completed.
                
                Requested by: '.$get_request[0]['requester'].'
                Move date: '.$get_request[0]['move'].'
                Room from: '.$get_request[0]['from'].'
                Room to: '.$get_request[0]['to']);
                $this->email->send();

                $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
                redirect($url);
            }
            $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
            redirect($url);
        } else {
            $url = preg_replace('/\?.*/', '', $_SERVER['HTTP_REFERER']);
            redirect($url);
        }
    }

}
