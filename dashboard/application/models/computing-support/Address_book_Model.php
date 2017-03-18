<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Address_book_model extends CI_Model {

    public function __construct() {
    }

    public function change($faculty, $department, $name, $room, $phone, $position) {
        
        $data = array(
            'requested' => date("Y-m-d H:i:s", time()),
            'by' => $_SESSION['ldap']['full_name'],
            'new_faculty' => $faculty[0]['faculty'],
            'new_department' => $department[0]['subfaculty'],
            'new_name' => $this->input->post('name'),
            'new_room' => $this->input->post('room'),
            'new_phone' => $this->input->post('phone'),
            'new_position' => $this->input->post('position'),
        );
        
        return $this->db->insert('address_book', $data);
        
    }
    
    function get_faculty() {
        $this->db->from('faculty');
        $this->db->order_by('faculty');
        $result = $this->db->get();
        $return = array();
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $return[$row['cat_id']] = $row['faculty'];
            }
        }

        return $return;
    }

    function get_department() {
        if (!isset($_GET['cat'])) {
            $_GET['cat'] = '1';
        }
        $result = $this->db->get_where('facultysub', array('cat_id' => $_GET['cat']));
        $return = array();
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $return[$row['cat_key']] = $row['subfaculty'];
            }
        }

        return $return;
    }
    
    function get_faculty_from_number($faculty) {
        
        $this->db->select('faculty');
        $this->db->where('cat_id', $faculty);
	$this->db->from('faculty');
        return $this->db->get()->result_array();
    }
    
    function get_department_from_number($department) {
        
        $this->db->select('subfaculty');
        $this->db->where('cat_key', $department);
	$this->db->from('facultysub');
        return $this->db->get()->result_array();
    }
}
?>


