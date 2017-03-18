<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends My_Force_Admin {
    
    public function __construct() {
	parent::__construct();
            
    }
    
    public function index() {

        $this->load->view('templates/header');
        $this->load->view('admin/view');
        $this->load->view('templates/footer');
    }
} // END controller
