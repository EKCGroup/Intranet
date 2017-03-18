<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {

    public function __construct() {
    }
    
    public function new_staff_account() {
        
        $this->db->select('id');
        $this->db->from('new_account');
        $this->db->where('complete', NULL);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function status() {
        
        $this->db->select('id');
        $this->db->from('status');
        $this->db->where('status', 0);
        $this->db->or_where('auto_status', 0);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function status_view() {
    
        $query = $this->db->get('status');
        return $query->result_array();
    }
}
?>


