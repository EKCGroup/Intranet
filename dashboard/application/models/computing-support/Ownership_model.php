<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ownership_model extends CI_Model {

    public function __construct() {
    }

    public function create($logged, $staff_full, $make, $model, $sn) {
        
        $data = array(
            'logged' => $this->input->post('logged'),
            'logged_at' => date("Y-m-d H:i:s", time()),
            'staff_full' => $this->input->post('staff_full'),
            'make' => $this->input->post('make'),
            'model' => $this->input->post('model'),
            'sn' => $this->input->post('sn'),
        );
        
        return $this->db->insert('ownership', $data);
        
    }
    
    public function get_all_ownership() {
        $query = $this->db->get('ownership');
        return $query->result_array();
    }
    
    public function get_pending_ownership() {
        $this->db->where('status', '0')->or_where('status', '1');
        $query = $this->db->get('ownership');
        return $query->result_array();
    }
    
    public function check_ownership() {
        $this->db->where('staff_full', $_SESSION['ldap']['full_name']);
        $query = $this->db->get('ownership');
        return $query->result_array();
    }
    
    public function match_id_user($id) {
        $this->db->select('staff_full');
        $this->db->where('id', $id);
        $query = $this->db->get('ownership');
        return $query->result_array();
    }
    
    public function email_id($staff_full) {
        $this->db->select('email');
        $this->db->where('full_name', $staff_full);
        $query = $this->db->get('users_ad');
        return $query->result_array();
    }
    
    public function approve($id) {
            
        $this->db->where('id', $id);
	$this->db->from('ownership');
        $data = array(
            'status' => '3',
            'transfer' => date("Y-m-d H:i:s", time()),
            'transfer_by' => $_SESSION['ldap']['full_name'],
        );
        return $this->db->update('ownership', $data);
        
    }
    
    public function reject($id) {
            
        $this->db->where('id', $id);
	$this->db->from('ownership');
        $data = array(
            'status' => '2',
            'transfer' => date("Y-m-d H:i:s", time()),
            'transfer_by' => $_SESSION['ldap']['full_name'],
        );
        return $this->db->update('ownership', $data);
        
    }
    
    public function cancel($id) {
            
        $this->db->where('id', $id);
	$this->db->from('ownership');
        $data = array(
            'status' => '4',
        );
        return $this->db->update('ownership', $data);
        
    }
    
    public function terms($id) {
            
        $this->db->where('id', $id);
	$this->db->from('ownership');
        $data = array(
            'status' => '1',
            'policy_accepted' => date("Y-m-d H:i:s", time()),
        );
        return $this->db->update('ownership', $data);
        
    }
}
?>


