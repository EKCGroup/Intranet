<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends My_Force_Login {
    
    public function __construct() {
	parent::__construct();
        
    }
    
    public function index() {

        $this->load->view('templates/header');
        $this->load->view('view');
        $this->load->view('templates/footer');
    }
    public function test() {
        
        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $this->load->view('templates/header');
            $this->load->view('test');
            $this->load->view('templates/footer');
        }
    }
} // END controller
