<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs_logs extends My_Force_Admin {

    public function __construct() {
        parent::__construct();
        $this->load->library('grocery_CRUD');
    }

    public function index() {

        $this->load->view('templates/header');
        $this->load->view('admin/jobs-logs/view');
        $this->load->view('templates/footer');
    }
    
    public function intranet() {
        
        $this->db = $this->load->database('intranet',true);
        
        $crud = new grocery_CRUD();
        $crud->set_table('Logs');
        $crud->set_subject('Logs', 'Logs');
        $crud->unset_delete();
        $crud->unset_read();
        $crud->unset_add();
        $crud->unset_edit();
        $output = $crud->render();
        
        $this->db = $this->load->database('default',true);
        
        $this->load->view('templates/header.php');
        $this->load->view('admin/jobs-logs/intranet', $output);
        $this->load->view('templates/footer.php');
        $this->load->view('templates/table_assets.php', $output);
        
    }
    
    public function dashboard() {

        $crud = new grocery_CRUD();
        $crud->set_table('users_log');
        $crud->set_subject('Dashboard Logs', 'Dashboard Logs');
        $crud->unset_columns('id');
        $crud->display_as('ip','IP')->display_as('url','URL');
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_add();
        $crud->unset_read();
        $output = $crud->render();

        $this->load->view('templates/header.php');
        $this->load->view('admin/jobs-logs/dashboard', $output);
        $this->load->view('templates/footer.php');
        $this->load->view('templates/table_assets.php', $output);
    }
    
    public function passkey() {

        $crud = new grocery_CRUD();
        $crud->set_table('passkey_log');
        $crud->set_subject('Passkey', 'Passkey');
        $crud->unset_columns('id');
        $crud->display_as('ip','IP')->display_as('passid','PassID');
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_add();
        $crud->unset_read();
        $output = $crud->render();

        $this->load->view('templates/header.php');
        $this->load->view('admin/jobs-logs/passkey', $output);
        $this->load->view('templates/footer.php');
        $this->load->view('templates/table_assets.php', $output);
    }
    
    public function ad_user_sync() {

        $crud = new grocery_CRUD();
        $crud->set_table('users_ad_log');
        $crud->set_subject('AD User Sync', 'AD User Sync');
        $crud->unset_columns('id');
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_add();
        $crud->unset_read();
        $output = $crud->render();

        $this->load->view('templates/header.php');
        $this->load->view('admin/jobs-logs/ad-user-sync', $output);
        $this->load->view('templates/footer.php');
        $this->load->view('templates/table_assets.php', $output);
    }
}

// END controller
