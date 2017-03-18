<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends My_Public {

    public function __construct() {
        parent::__construct();
        $this->load->model('computing-support/status_model', 'status_model');
    }

    public function index() {

        $data['status'] = $this->status_model->view();

        $this->load->view('templates/header', $data);
        $this->load->view('computing-support/status/view');
        $this->load->view('templates/footer');
    }

    public function display() {

        $data['status'] = $this->status_model->view();

        $this->load->view('templates/header', $data);
        $this->load->view('computing-support/status/display');
        $this->load->view('templates/footer');
    }

    public function auto() {

        $data['status'] = $this->status_model->auto();
        $this->load->view('computing-support/status/auto', $data);
    }

    public function reset() {

        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['sid'])) {

                $sid = $_GET['sid'];
                $this->status_model->reset($sid);
                
                $function = 'reset_status_monitor_'.$sid;
                $this->user_model->function_log($function);

                redirect($_SERVER['HTTP_REFERER']);
            }

            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function delete() {

        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['sid'])) {

                $sid = $_GET['sid'];
                $this->status_model->delete($sid);
                
                $function = 'delete_status_monitor_'.$sid;
                $this->user_model->function_log($function);

                redirect('computing-support/status');
            }

            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function edit() {

        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
                in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['sid'])) {
                $sid = $_GET['sid'];
                $data['get_current'] = $this->status_model->edit_get($sid);
            }
            $this->load->helper('form');
            $this->load->library('form_validation');

            // validation rules
            $this->form_validation->set_rules('name', 'Service name', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('icon', 'Icon', 'trim|required|min_length[4]');

            if ($this->form_validation->run() === false) {

                $this->load->view('templates/header');
                $this->load->view('computing-support/status/edit', $data);
                $this->load->view('templates/footer');
            } else {

                $id = $this->input->post('id');
                $name = $this->input->post('name');
                $icon = $this->input->post('icon');
                $url = $this->input->post('url');
                $comment = $this->input->post('comment');
                $category = $this->input->post('category');
                $status = $this->input->post('status');
                $username = $_SESSION['username'];

                if ($this->status_model->edit_update($id, $name, $icon, $url, $comment, $category, $status, $username)) {
                    
                    $function = 'edit_status_monitor_'.$sid;
                    $this->user_model->function_log($function);

                    $this->load->view('templates/header');
                    $this->load->view('computing-support/status/updated');
                    $this->load->view('templates/footer');
                } else {
                    
                    $function = 'edit_status_monitor_error_'.$sid;
                    $this->user_model->function_log($function);

                    $data = new stdClass();
                    $data->error = 'There was a problem editing this service. Please try again.';

                    // failed to create user
                    $this->load->view('templates/header');
                    $this->load->view('computing-support/status/edit', $data);
                    $this->load->view('templates/footer');
                }
            }
        }
    }

    public function create() {

        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $this->load->helper('form');
            $this->load->library('form_validation');

            // validation rules
            $this->form_validation->set_rules('name', 'Service name', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('icon', 'Icon', 'trim|required|min_length[4]');

            if ($this->form_validation->run() === false) {

                $this->load->view('templates/header');
                $this->load->view('computing-support/status/edit');
                $this->load->view('templates/footer');
            } else {

                $name = $this->input->post('name');
                $icon = $this->input->post('icon');
                $url = $this->input->post('url');
                $category = $this->input->post('category');
                $status = $this->input->post('status');
                $username = $_SESSION['username'];

                if ($this->status_model->create($name, $icon, $url, $category, $status, $username)) {
                    
                    $function = 'create_status_monitor_'.$sid;
                    $this->user_model->function_log($function);

                    $this->load->view('templates/header');
                    $this->load->view('computing-support/status/created');
                    $this->load->view('templates/footer');
                } else {
                    
                    $function = 'create_status_monitor_error_'.$sid;
                    $this->user_model->function_log($function);

                    $data = new stdClass();
                    $data->error = 'There was a problem editing this service. Please try again.';

                    // failed to create user
                    $this->load->view('templates/header');
                    $this->load->view('computing-support/status/edit', $data);
                    $this->load->view('templates/footer');
                }
            }
        }
    }

}

// END controller
