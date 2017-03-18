<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile_policy_model extends CI_Model {

    public function __construct() {
    }

    public function accept($full_name, $email, $mobile) {
        
        $data = array(
            'full_name' => $this->input->post('full_name'),
            'accepted' => date("Y-m-d H:i:s", time()),
            'email' => $this->input->post('email'),
            'mobile' => $this->input->post('mobile'),
        );
        
        return $this->db->insert('mobile_policy', $data);
        
    }

}
?>


