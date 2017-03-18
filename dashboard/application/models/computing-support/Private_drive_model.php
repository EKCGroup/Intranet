<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Private_drive_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function create($requester, $user, $user_un, $path, $access, $approver) {
        
        $data = array(
            'requester' => $_SESSION['ldap']['full_name'],
            'requester_un' => $_SESSION['username'],
            'requested_at' => date("Y-m-d H:i:s", time()),
            'user' => $this->input->post('user'),
            'user_un' => $user_un,
            'path' => $this->input->post('path'),
            'access' => $this->input->post('access'),
            'approver' => $this->input->post('approver'),
        );

        return $this->db->insert('private_drive', $data);
    }
    
    public function get_pending() {
        $this->db->where('status', '0')->or_where('status', '1');
        $query = $this->db->get('private_drive');
        return $query->result_array();
    }
    
    public function get_all() {
        $query = $this->db->get('private_drive');
        return $query->result_array();
    }
    
    public function check_status() {
        $this->db->where('requester_un', $_SESSION['username'])->or_where('user_un', $_SESSION['username'])->or_where('approver', $_SESSION['ldap']['full_name']);
        $query = $this->db->get('private_drive');
        return $query->result_array();
    }
    
    public function match_id_user($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('private_drive');
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
        $query = $this->db->get('private_drive');
        return $query->result_array();
    }
    
    public function get_email_approver($full_name) {        
        
        $this->db->select('email');
        $this->db->from('users_ad');
        $this->db->where('full_name', $full_name);
        return $this->db->get()->row('email');
    }
    
    public function cancel($id) {
            
        $this->db->where('id', $id);
	$this->db->from('private_drive');
        $data = array(
            'status' => '5',
            'canceled_by' => $_SESSION['ldap']['full_name'],
            'canceled_at' => date("Y-m-d H:i:s", time()),
        );
        return $this->db->update('private_drive', $data);
    }
    
    public function fh_reject($id) {
            
        $this->db->where('id', $id);
	$this->db->from('private_drive');
        $data = array(
            'status' => '3',
            'approved_at' => date("Y-m-d H:i:s", time()),
        );
        return $this->db->update('private_drive', $data);
    }
    
    public function fh_approve($id) {
            
        $this->db->where('id', $id);
	$this->db->from('private_drive');
        $data = array(
            'status' => '1',
            'approved_at' => date("Y-m-d H:i:s", time()),
        );
        
        return $this->db->update('private_drive', $data);
    }
    
    public function cs_reject($id) {
            
        $this->db->where('id', $id);
	$this->db->from('private_drive');
        $data = array(
            'status' => '4',
            'actioned_at' => date("Y-m-d H:i:s", time()),
            'actioned_by' => $_SESSION['ldap']['full_name'],
        );
        return $this->db->update('private_drive', $data);
    }
    
    public function cs_approve($id) {
            
        $this->db->where('id', $id);
	$this->db->from('private_drive');
        $data = array(
            'status' => '2',
            'actioned_at' => date("Y-m-d H:i:s", time()),
            'actioned_by' => $_SESSION['ldap']['full_name'],
        );
        
        return $this->db->update('private_drive', $data);
    }
}