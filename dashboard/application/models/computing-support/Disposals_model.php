<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Disposals_model extends CI_Model {

    public function __construct() {
        $this->load->model('computing-support/Disposals_model', 'disposals_model');
    }

    public function dispose($logged, $make, $model, $sn) {

        $data = array(
            'logged' => $_SESSION['ldap']['full_name'],
            'logged_at' => date("Y-m-d H:i:s", time()),
            'make' => $this->input->post('make'),
            'model' => $this->input->post('model'),
            'sn' => $this->input->post('sn'),
        );

        return $this->db->insert('disposals', $data);
    }

    public function complete_account() {

        $data = array(
            'completed' => date("Y-m-d H:i:s", time())
        );
        $this->db->where('completed', null, true);
        return $this->db->update('disposals', $data);
    }
}
