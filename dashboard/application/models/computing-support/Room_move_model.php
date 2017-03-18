<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Room_move_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function create($requester, $move, $from, $to, $furniture, $reason, $full_name, $full_name2, $full_name3, $full_name4, $full_name5, $full_name6, $full_name7, $full_name8, $full_name9, $full_name10) {
        
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
                
        if ($furniture == "No Furniture"){
            $status = "1";
        } else {
            $status = "0";
        }
        
        $data = array(
            'requester' => $_SESSION['ldap']['full_name'],
            'requester_un' => $_SESSION['username'],
            'requested_at' => date("Y-m-d H:i:s", time()),
            'move' => $this->input->post('move'),
            'from' => $this->input->post('from'),
            'to' => $this->input->post('to'),
            'furniture' => $this->input->post('furniture'),
            'reason' => $this->input->post('reason'),
            'staff_involved' => $this->input->post('full_name'),
            'staff_involved_un' => $user_un,
            'staff_involved2' => $this->input->post('full_name2'),
            'staff_involved_un2' => $user_un2,
            'staff_involved3' => $this->input->post('full_name3'),
            'staff_involved_un3' => $user_un3,
            'staff_involved4' => $this->input->post('full_name4'),
            'staff_involved_un4' => $user_un4,
            'staff_involved5' => $this->input->post('full_name5'),
            'staff_involved_un5' => $user_un5,
            'staff_involved6' => $this->input->post('full_name6'),
            'staff_involved_un6' => $user_un6,
            'staff_involved7' => $this->input->post('full_name7'),
            'staff_involved_un7' => $user_un7,
            'staff_involved8' => $this->input->post('full_name8'),
            'staff_involved_un8' => $user_un8,
            'staff_involved9' => $this->input->post('full_name9'),
            'staff_involved_un9' => $user_un9,
            'staff_involved10' => $this->input->post('full_name10'),
            'staff_involved_un10' => $user_un10,
            'status' => $status,
        );

        return $this->db->insert('room_move', $data);
    }
    
    public function get_pending() {
        $this->db->where('status', '0')->or_where('status', '1');
        $query = $this->db->get('room_move');
        return $query->result_array();
    }
    
    public function get_all() {
        $query = $this->db->get('room_move');
        return $query->result_array();
    }
    
    public function check_status() {
        $this->db->where('requester_un', $_SESSION['username'])
                 ->or_where('staff_involved_un', $_SESSION['username'])
                 ->or_where('staff_involved_un2', $_SESSION['ldap']['full_name'])
                 ->or_where('staff_involved_un3', $_SESSION['ldap']['full_name'])
                 ->or_where('staff_involved_un4', $_SESSION['ldap']['full_name'])
                 ->or_where('staff_involved_un5', $_SESSION['ldap']['full_name'])
                 ->or_where('staff_involved_un6', $_SESSION['ldap']['full_name'])
                 ->or_where('staff_involved_un7', $_SESSION['ldap']['full_name'])
                 ->or_where('staff_involved_un8', $_SESSION['ldap']['full_name'])
                 ->or_where('staff_involved_un9', $_SESSION['ldap']['full_name'])
                 ->or_where('staff_involved_un10', $_SESSION['ldap']['full_name']);
        $query = $this->db->get('room_move');
        return $query->result_array();
    }
    
    public function match_id_user($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('room_move');
        return $query->result_array();
    }
    
    public function get_email_username($username) {        
        
        $this->db->select('email');
        $this->db->from('users_ad');
        $this->db->where('username', $username);
        return $this->db->get()->row('email');
    }
    
    public function get_request($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('room_move');
        return $query->result_array();
    }
    
    public function cancel($id) {
            
        $this->db->where('id', $id);
	$this->db->from('room_move');
        $data = array(
            'status' => '4',
            'canceled_by' => $_SESSION['ldap']['full_name'],
            'canceled_at' => date("Y-m-d H:i:s", time()),
        );
        return $this->db->update('room_move', $data);
    }
    
    public function eh_reject($id) {
            
        $this->db->where('id', $id);
	$this->db->from('room_move');
        $data = array(
            'status' => '2',
            'estates_at' => date("Y-m-d H:i:s", time()),
            'estates_by' => $_SESSION['ldap']['full_name'],
        );
        return $this->db->update('room_move', $data);
    }
    
    public function eh_approve($id) {
            
        $this->db->where('id', $id);
	$this->db->from('room_move');
        $data = array(
            'status' => '1',
            'estates_at' => date("Y-m-d H:i:s", time()),
            'estates_by' => $_SESSION['ldap']['full_name'],
        );
        
        return $this->db->update('room_move', $data);
    }
    
    public function cs_reject($id) {
            
        $this->db->where('id', $id);
	$this->db->from('room_move');
        $data = array(
            'status' => '3',
            'cs_at' => date("Y-m-d H:i:s", time()),
            'cs_by' => $_SESSION['ldap']['full_name'],
        );
        return $this->db->update('room_move', $data);
    }
    
    public function cs_approve($id) {
            
        $this->db->where('id', $id);
	$this->db->from('room_move');
        $data = array(
            'status' => '5',
            'cs_at' => date("Y-m-d H:i:s", time()),
            'cs_by' => $_SESSION['ldap']['full_name'],
        );
        
        return $this->db->update('room_move', $data);
    }
    
    public function cs_complete($id) {
            
        $this->db->where('id', $id);
	$this->db->from('room_move');
        $data = array(
            'status' => '6',
            'completed_at' => date("Y-m-d H:i:s", time()),
            'completed_by' => $_SESSION['ldap']['full_name'],
        );
        
        return $this->db->update('room_move', $data);
    }
}