<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Disposals extends My_Force_Login {

    public function __construct() {
        parent::__construct();
        $this->load->helper('download');
        $this->load->library('grocery_CRUD');
        $this->load->model('computing-support/Disposals_model', 'disposals_model');
        
    }

    public function index() {
        
        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
        
            $this->load->helper('form');
            $this->load->library('form_validation');

            // validation rules
            $this->form_validation->set_rules('make', 'Device Make', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('model', 'Device Model', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('sn', 'Device Serial Number', 'trim|required|min_length[3]');

            if ($this->form_validation->run() === false) {

                $this->load->view('templates/header');
                $this->load->view('computing-support/disposals/view');
                $this->load->view('templates/footer');

            } else {

                $logged = $this->input->post('logged');
                $make = $this->input->post('make');
                $model = $this->input->post('model');
                $sn = $this->input->post('sn');
            
                if ($this->disposals_model->dispose($logged, $make, $model, $sn)) {

                    $function = 'disposals_submitted';
                    $this->user_model->function_log($function);

                    // user created
                    $this->load->view('templates/header');
                    $this->load->view('computing-support/disposals/created');
                    $this->load->view('templates/footer');

                } else {
                    
                    $function = 'disposals_error';
                    $this->user_model->function_log($function);

                    $data = new stdClass();
                    $data->error = 'There was a problem submitting this disposal record. Please try again.';

                    // failed to create user
                    $this->load->view('templates/header');
                    $this->load->view('computing-support/disposals/view', $data);
                    $this->load->view('templates/footer');

                }	
            }    
        } else {
            redirect('permissions');
        }
    }
    
    public function history() {
        
        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
        
            $crud = new grocery_CRUD();
            $crud->set_table('disposals');
            $crud->set_subject('disposals', 'Disposals');
            $crud->display_as('sn','Serial Number');
            $crud->unset_columns('id'); 
            $crud->unset_add();
            $crud->unset_read();
            $crud->unset_delete();
            $output = $crud->render();

            $this->load->view('templates/header.php');
            $this->load->view('computing-support/disposals/history', $output);
            $this->load->view('templates/footer.php');
            $this->load->view('templates/table_assets.php', $output);
            
        } else {
            redirect('permissions');
        }
        
    }
    
    public function current() {
        
        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
        
            $crud = new grocery_CRUD();
            $crud->set_table('disposals_current');
            $crud->set_subject('disposals', 'Disposals');
            $crud->set_primary_key('id');
            $crud->display_as('sn','Serial Number');
            $crud->unset_columns('id'); 
            $crud->unset_add();
            $crud->unset_read();
            $crud->unset_delete();
            $output = $crud->render();

            $this->load->view('templates/header.php');
            $this->load->view('computing-support/disposals/current', $output);
            $this->load->view('templates/footer.php');
            $this->load->view('templates/table_assets.php', $output);
            
        } else {
            redirect('permissions');
        }
        
    }

    public function complete() {
        
        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
            
            $function = 'complete_disposals';
            $this->user_model->function_log($function);
        
            $this->disposals_model->complete_account();

            $this->load->view('templates/header');
            $this->load->view('computing-support/disposals/complete');
            $this->load->view('templates/footer');
            
        } else {
            redirect('permissions');
        }
    }
    
    // If changed are made, duplicate in New_staff_export.php controller.
     
    function export_current() {
        
        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
            
            $function = 'export current_disposals';
            $this->user_model->function_log($function);
        
            $this->load->dbutil();
            //MySQL View - only export incomplete
            $query = $this->db->query("SELECT * FROM disposals WHERE completed IS NULL");
            $delimiter = ",";
            $newline = "\n";
            $output = $this->dbutil->csv_from_result($query, $delimiter, $newline);

            function clean_export($string) {
                $string = str_replace('"', '', $string); // Replaces all spaces with hyphens - Required by SAD02-46 script.
                return $string;
            }

            $output = clean_export($output);
            force_download("current_disposals.csv", $output);
            
        } else {
            redirect('permissions');
        }
    }
}