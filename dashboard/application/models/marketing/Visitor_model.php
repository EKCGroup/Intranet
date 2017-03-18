<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Visitor_model extends CI_Model {

    public function __construct() {
    }

    public function post($first_name, $last_name, $email, $postcode, $dob, $current, $current_other, $subject, $hear, $year) {
        
        $data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'postcode' => $this->input->post('postcode'),
            'date_birth' => $this->input->post('dob_d') .'/'. $this->input->post('dob_m') .'/'. $this->input->post('dob_y'),
            'current_school' => $this->input->post('current'),
            'current_other' => $this->input->post('current_other'),
            'subject_interest' => implode(', ', $this->input->post('subject')),
            'hear_open_day' => implode(', ', $this->input->post('hear')),
            'year_interest' => $this->input->post('year'),
        );
        
        return $this->db->insert('visitor', $data);
        
    }
}
?>


