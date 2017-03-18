<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends My_Force_Login {
    
    public function __construct() {
	parent::__construct();
        
    }
    
    public function index() {

        $this->load->view('templates/header');
        $this->load->view('computing-support/view');
        $this->load->view('templates/footer');
    }
} // END controller
