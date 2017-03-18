<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Visitor extends My_Public {

    public function __construct() {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->load->model('marketing/visitor_model', 'visitor_model');
    }

    public function index() {

        if (isset($_COOKIE['CI_PASSKEY']) === TRUE && in_array('visitor', unserialize($_COOKIE['CI_PASSKEY'])) ||
                in_array('CN=Intranet_Edit_Marketing,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['dashboard_groups'])) {

            $this->load->helper('form');
            $this->load->library('form_validation');

            // validation rules
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[2]');
            $this->form_validation->set_rules('dob_d', 'Date of Birth Day', 'trim|required|numeric|min_length[2]');
            $this->form_validation->set_rules('dob_m', 'Date of Birth Month', 'trim|required|numeric|min_length[2]');
            $this->form_validation->set_rules('dob_y', 'Date of Birth Year', 'trim|required|numeric|min_length[4]');

            if ($this->form_validation->run() === false) {

                $this->load->view('templates/header');
                $this->load->view('marketing/visitor/view');
                $this->load->view('templates/footer');
            } else {

                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $email = $this->input->post('email');
                $postcode = $this->input->post('postcode');
                $dob = $this->input->post('dob_d') . '/' . $this->input->post('dob_m') . '/' . $this->input->post('dob_y');
                $current = $this->input->post('current');
                $current_other = $this->input->post('current_other');
                $subject = $this->input->post('subject');
                $hear = $this->input->post('hear');
                $year = $this->input->post('year');

                if ($this->visitor_model->post($first_name, $last_name, $email, $postcode, $dob, $current, $current_other, $subject, $hear, $year)) {

                    // user created
                    $this->load->view('templates/header');
                    $this->load->view('marketing/visitor/complete');
                    $this->load->view('templates/footer');
                } else {
                    
                    $function = 'ERROR_visitor_form_submition';
                    $this->user_model->function_log($function);

                    $data = new stdClass();
                    $data->error = 'There was a problem submitting this form. Please try again.';

                    // failed to create user
                    $this->load->view('templates/header');
                    $this->load->view('marketing/visitor/view', $data);
                    $this->load->view('templates/footer');
                }
            }
        } else {

            $this->session->set_userdata('last_url', current_url());
            redirect('authentication/passkey?id=visitor');
        }
    }

    public function history() {

        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                in_array('CN=Intranet_Edit_Marketing,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $crud = new grocery_CRUD();
            $crud->set_table('visitor');
            $crud->set_subject('visitor', 'Visitor - Open Day');
            $crud->unset_columns('id');
            $crud->unset_add();
            $crud->unset_read();
            $output = $crud->render();

            $this->load->view('templates/header.php');
            $this->load->view('marketing/visitor/history', $output);
            $this->load->view('templates/footer.php');
            $this->load->view('templates/table_assets.php', $output);
        } else {
            redirect('permissions');
        }
    }

    public function reset() {
        
        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                in_array('CN=Intranet_Edit_Marketing,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $this->db->empty_table('visitor');
            redirect($_SERVER['HTTP_REFERER']);
            
            $function = 'visitor_form_RESET';
            $this->user_model->function_log($function);
        }
    }
}