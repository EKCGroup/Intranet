<?php

class Equipment_loan extends My_Force_Login {

    public function __construct() {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->load->model('computing-support/Equipment_loan_model', 'equipment_loan_model');
    }

    public function index() {
        
        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $this->load->helper('form');
            $this->load->library('form_validation');

            // validation rules
            $this->form_validation->set_rules('full_name', 'First Name', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('ern', 'ERN', 'trim|required|min_length[7]');
            $this->form_validation->set_rules('make', 'Make', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('model', 'Model', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('sn', 'Serial Number', 'trim|required|min_length[3]');

            if ($this->form_validation->run() === false) {

                $this->load->view('templates/header');
                $this->load->view('computing-support/equipment-loan/view');
                $this->load->view('templates/footer');
            } else {

                $logged = $this->input->post('logged');
                $first_name = $this->input->post('full_name');
                $ern = $this->input->post('ern');
                $make = $this->input->post('make');
                $model = $this->input->post('model');
                $sn = $this->input->post('sn');

                if ($this->equipment_loan_model->loan($logged, $full_name, $ern, $make, $model, $sn)) {
                    
                    $function = 'new_loan';
                    $this->user_model->function_log($function);

                    // user created
                    $this->load->view('templates/header');
                    $this->load->view('computing-support/equipment-loan/complete');
                    $this->load->view('templates/footer');
                } else {
                    
                    $function = 'new_loan_error';
                    $this->user_model->function_log($function);

                    $data = new stdClass();
                    $data->error = 'There was a problem accepting the terms. Please try again.';

                    // failed to create user
                    $this->load->view('templates/header');
                    $this->load->view('computing-support/equipment-loan/view', $data);
                    $this->load->view('templates/footer');
                }
            }
        } else {
            redirect('permissions');
        }
    }
    
    public function history() {
        
        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) || 
            in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
        
            $crud = new grocery_CRUD();
            $crud->set_table('equipment_loan');
            $crud->set_subject('Equipment Loan', 'Equipment Loan');
            $crud->unset_columns('id'); 
            $crud->display_as('ern','ER no.')
                 ->display_as('sn','Serial Number');
            $crud->unset_edit_fields('logged', 'date'); 
            $crud->unset_add();
            $crud->unset_read();
            $output = $crud->render();

            $this->load->view('templates/header.php');
            $this->load->view('computing-support/equipment-loan/history', $output);
            $this->load->view('templates/footer.php');
            $this->load->view('templates/table_assets.php', $output);
            
        } else {
            redirect('permissions');
        }
        
    }
}
