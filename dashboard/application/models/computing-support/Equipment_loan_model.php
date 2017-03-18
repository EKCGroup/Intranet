<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Equipment_loan_model extends CI_Model {

    public function __construct() {
    }

    public function loan($logged, $full_name, $ern, $make, $model, $sn) {
        
        $data = array(
            'logged' => $this->input->post('logged'),
            'full_name' => $this->input->post('full_name'),
            'ern' => $this->input->post('ern'),
            'make' => $this->input->post('make'),
            'model' => $this->input->post('model'),
            'sn' => $this->input->post('sn'),
            'date' => date("Y-m-d H:i:s", time()),
        );
        
        return $this->db->insert('equipment_loan', $data);
        
    }

}
?>


