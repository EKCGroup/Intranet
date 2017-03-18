<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Address_book extends My_Force_Login {

    public function __construct() {
        parent::__construct();
        $this->load->library('grocery_CRUD');
        $this->load->model('computing-support/Address_book_model', 'address_book_model');
    }

    public function index() {

        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['faculty'] = $this->address_book_model->get_faculty();
        $data['department'] = $this->address_book_model->get_department();

        // validation rules
        $this->form_validation->set_rules('phone', 'Phone', 'trim|numeric');

        if ($this->form_validation->run() === false) {

            $this->load->view('templates/header');
            $this->load->view('computing-support/address-book/view', $data);
            $this->load->view('templates/footer');
        } else {

            $faculty = $this->input->post('faculty');
            $department = $this->input->post('department');
            $name = $this->input->post('name');
            $room = $this->input->post('room');
            $phone = $this->input->post('phone');
            $position = $this->input->post('position');
            
            $faculty = $this->address_book_model->get_faculty_from_number($faculty);
            $department = $this->address_book_model->get_department_from_number($department);

            if ($this->address_book_model->change($faculty, $department, $name, $room, $phone, $position)) {
                
                $function = 'address_book_update';
                $this->user_model->function_log($function);
                
                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Address Book Update');
                $this->email->to('helpdesk@canterburycollege.ac.uk');
                $this->email->subject('Address Book Update');
                $this->email->message('A global address book update request been made by ' . $_SESSION['ldap']['full_name'] . '
                       Change name to: ' . $name . '
                       Change Faculty to: ' . $faculty[0]['faculty'] . '  
                       Change Department to: ' . $department[0]['subfaculty'] . '  
                       Change Room to : ' . $room . '
                       Change Telephone to : ' . $phone.'
                       Change Position to : ' . $position);

                $this->email->send();

                // user created
                $this->load->view('templates/header');
                $this->load->view('computing-support/address-book/complete');
                $this->load->view('templates/footer');
            } else {
                
                $function = 'address_book_error';
                $this->user_model->function_log($function);

                $data = new stdClass();
                $data->error = 'There was a problem requesting these changes. Please try again.';

                // failed to create user
                $this->load->view('templates/header');
                $this->load->view('computing-support/address-book/view', $data);
                $this->load->view('templates/footer');
            }
        }
    }
    
    public function history() {
        
        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
        
            $crud = new grocery_CRUD();
            $crud->set_table('address_book');
            $crud->set_subject('Address Book Updates', 'Address Book Updates');
            $crud->unset_columns('id'); 
            $crud->unset_edit();
            $crud->unset_delete(); 
            $crud->unset_add();
            $crud->unset_read();
            $output = $crud->render();

            $this->load->view('templates/header.php');
            $this->load->view('computing-support/address-book/history', $output);
            $this->load->view('templates/footer.php');
            $this->load->view('templates/table_assets.php', $output);
            
        } else {
            redirect('permissions');
        }
        
    } // END user permissions
}
