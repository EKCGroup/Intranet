<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Status_model extends CI_Model {
    
    public function __construct() {
	parent::__construct();		
    }
    
    public function view() {
            
        $this->db->order_by("category", "asc");
        $this->db->order_by("name", "asc");
        $query = $this->db->get('status');
        return $query->result_array();
    }
    
    public function auto() {
        
        $data = array(
            'id', 'name', 'status', 'url', 'auto_status'
	);
            
        $query = $this->db->get('status');
        return $query->result_array();
    }
    
    public function auto_update_ok($service_id, $service_status) {
            
        $data = array(
            'auto_status' => $service_status,
        );
            
        $this->db->where('id', $service_id);
        return $this->db->update('status', $data);
    }
    
    public function auto_update_bad($service_id, $service_status) {
            
        $data = array(
            'auto_status' => $service_status,
        );
            
        $this->db->where('id', $service_id);
        return $this->db->update('status', $data);
    }
    
    public function auto_update_timestamp($service_id) {
            
        $data = array(
            'status_since' => date("Y-m-d H:i:s", time()),
        );
            
        $this->db->where('id', $service_id);
        return $this->db->update('status', $data);
    }
    
    public function log($service_id, $service_status) {
        
        $data = array(
            'sid' => $service_id,
            'auto_status' => $service_status
	);	
        
	return $this->db->insert('status_logs', $data);
    }
    
    public function percentage($sid) {
        
        $this->db->select('sid');
        $this->db->where('sid', $sid);
        $this->db->order_by('id', 'DESC');
        $this->db->limit('5000');
	$this->db->from('status_logs');
        $total = $this->db->get()->num_rows();
        
        $this->db->select('sid');
        $this->db->where('sid', $sid);
        $this->db->where('auto_status', 1);
        $this->db->order_by('id', 'DESC');
        $this->db->limit('5000');
	$this->db->from('status_logs');
        $up = $this->db->get()->num_rows();
        
        if (empty($total)) { 
            
            $percentage = 'No Data';
            return $percentage;
            
        } else {
        
            $percentage = round($up / $total * 100, 1).'%';
            return $percentage;
        
        }
        
    }
    
    public function reset($sid) {
            
        $this->db->select('sid');
        $this->db->where('sid', $sid);
	$this->db->from('status_logs');
        $this->db->delete();
        
    }
    
    public function edit_get($sid) {
        
        $this->db->select();
        $this->db->where('id', $sid);
	$this->db->from('status');
        $query = $this->db->get();
        return $query->result_array();
    }
        
    public function edit_update($id, $name, $icon, $url, $comment, $category, $status, $username) {
        
        if (empty($comment)) {
            $comment = 'No information available';
        }
        
        $data = array(
            'name'   => $name,
            'icon'   => $icon,
            'url'   => $url,
            'comments'   => $comment,
            'category'   => $category,
            'status'   => $status,
            'auto_status'   => $status,
            'last_update'   => date("Y-m-d H:i:s", time()),
            'by'   => $username,
	);
        
        $this->db->where('id', $id);
	return $this->db->update('status', $data);
    }

    public function create($name, $icon, $url, $category, $status) {
        
        $data = array(
            'name'   => $name,
            'icon'   => $icon,
            'url'   => $url,
            'category'   => $category,
            'status'   => $status,
            'auto_status'   => $status,
            'last_update'   => date("Y-m-d H:i:s", time()),
            'by'   => $username,
	);
        
	return $this->db->insert('status', $data);
    }
    
    public function delete($sid) {
            
        $this->db->select('sid');
        $this->db->where('sid', $sid);
	$this->db->from('status_logs');
        $this->db->delete();
        
        $this->db->select('id');
        $this->db->where('id', $sid);
	$this->db->from('status');
        $this->db->delete();
        
    }
}