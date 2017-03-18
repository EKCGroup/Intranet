<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends My_Force_Admin {

    public function __construct() {
        
	parent::__construct();
            $this->load->library('encrypt');
            $this->load->library('grocery_CRUD');
            $this->load->model('user_model');
            
    }
    
    public function index() {
        
        redirect('admin/user/intranet');
    }
    
    public function intranet() {
        
        $this->db = $this->load->database('intranet',true);
        
        $crud = new grocery_CRUD();
        $crud->set_table('Users');
        $crud->set_subject('User', 'Users');
        $crud->columns('uID','uName', 'uEmail', 'uDateAdded','uLastLogin','uNumLogins');
        $crud->display_as('uID','Intranet UID')->display_as('uName', 'Username')->display_as('uEmail', 'Email Address')
              ->display_as('uDateAdded', 'First Login')->display_as('uLastLogin', 'Last Login')->display_as('uNumLogins', 'Logins');
        $crud->unset_delete();
        $crud->unset_read();
        $crud->unset_add();
        $crud->unset_edit();
        $output = $crud->render();
        
        $this->db = $this->load->database('default',true);
        
        $this->load->view('templates/header.php');
        $this->load->view('admin/user/view.php', $output);
        $this->load->view('templates/footer.php');
        $this->load->view('templates/table_assets.php', $output);
        
    }
    
    public function dashboard() {
        
        $crud = new grocery_CRUD();
        $crud->set_table('users');
        $crud->set_subject('users', 'Dashboard Users');
        $crud->display_as('uid','Intranet UID')->display_as('ip_last', 'Last IP')->display_as('ip_internal', 'Last internal IP')->display_as('ip_external', 'Last external IP')
              ->display_as('os', 'OS')->display_as('last_external', 'Last active external');
        $crud->unset_read();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_add();
        $output = $crud->render();
        
        $this->load->view('templates/header.php');
        $this->load->view('admin/user/view.php', $output);
        $this->load->view('templates/footer.php');
        $this->load->view('templates/table_assets.php', $output);
        
    } // END index
    
    public function passkey() {
        
        $crud = new grocery_CRUD();
        $crud->set_table('passkey');
        $crud->set_subject('passkey', 'Passkey');
        $crud->display_as('passid','PassID')->display_as('passkey', 'Passkey')->display_as('url', 'URL');
        $crud->unset_columns('id'); 
        $crud->unset_edit_fields('id'); 
        $crud->unset_read();
        $crud->unset_print();
        $crud->unset_export();
        $crud->callback_before_insert(array($this,'encrypt_password_callback'));
        $crud->callback_before_update(array($this,'encrypt_password_callback'));
        $crud->callback_edit_field('passkey',array($this,'decrypt_password_callback'));
        $output = $crud->render();
        
        $this->load->view('templates/header.php');
        $this->load->view('admin/user/passkey.php', $output);
        $this->load->view('templates/footer.php');
        $this->load->view('templates/table_assets.php', $output);
        
    }
    
    function encrypt_password_callback($post_array, $primary_key = null) {
        $post_array['passkey'] = $this->encrypt->encode($post_array['passkey']);
        return $post_array;
    }
    
    function decrypt_password_callback($value) {
        
        $decrypted_password = $this->encrypt->decode($value);
        return "<input type='text' name='password' value='$decrypted_password' />";
    }
} // END controller
