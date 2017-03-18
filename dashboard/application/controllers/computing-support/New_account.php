<?php defined('BASEPATH') OR exit('No direct script access allowed');

class New_account extends My_Force_Login {

    public function __construct() {
        parent::__construct();
        $this->load->helper('download');
        $this->load->library('grocery_CRUD');
        $this->load->model('computing-support/New_account_model', 'new_account_model');
        
    }

    public function index() {
        
        if (in_array('CN=Dashboard_New_Staff_Account,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) || 
            in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
            in_array('CN=Intranet_Edit_HR,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
        
            $this->load->helper('form');
            $this->load->library('form_validation');

            $data['faculty'] = $this->new_account_model->get_faculty();
            $data['department'] = $this->new_account_model->get_department();

            // validation rules
            $this->form_validation->set_rules('faculty', 'Faculty', 'trim|required');
            $this->form_validation->set_rules('first_name', 'First name', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('last_name', 'Last name', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('ern', 'Employee Reference no.', 'trim|required|min_length[7]');
            $this->form_validation->set_rules('position', 'Position', 'required');
            $this->form_validation->set_rules('room', 'Room', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('ext', 'Phone Number', 'trim|required|numeric|min_length[4]');
            $this->form_validation->set_rules('con_start', 'Contract start date', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('site', 'Site', 'trim|required|min_length[5]');

            if ($this->form_validation->run() === false) {

                $this->load->view('templates/header');
                $this->load->view('computing-support/new-account/view', $data);
                $this->load->view('templates/footer');

            } else {

                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $ern = $this->input->post('ern');
                $position = $this->input->post('position');
                $faculty = $this->input->post('faculty');
                $department = $this->input->post('department');
                $room = $this->input->post('room');
                $ext = $this->input->post('ext');
                $con_start = $this->input->post('con_start');
                $con_end = $this->input->post('con_end');
                $password = $this->input->post('password');
                $site = $this->input->post('site');

                if ($this->new_account_model->create($first_name, $last_name, $ern, $position, $faculty, $department, $room, $ext, $con_start, $con_end, $password, $site)) {

                    $function = 'new_staff_account_submitted';
                    $this->user_model->function_log($function);
                 
                    $this->email->from('noreply@intranet.cant-col.ac.uk', 'New Staff Account');
                    $this->email->to('helpdesk@canterburycollege.ac.uk');
                    $this->email->bcc('ns@canterburycollege.ac.uk');
                    $this->email->subject('New Staff Account');
                    $this->email->message('A new staff account has been requested by '.$_SESSION['username'].'
                       Name: ' . $this->input->post('first_name') . ' ' . $this->input->post('last_name') . '
                       Position: ' . $this->input->post('position') . '
                       Department: ' . $this->input->post('department') . '
                           
                       By: ' . $_SESSION['ldap']['full_name'] . '


                       The script will automaticly download user details and mark as created.
                       Please create T-Drive when you recieve the PowerStaffScript email.');
                    $this->email->send();
                    
                    $this->email->from('noreply@intranet.cant-col.ac.uk', 'New Staff Account');
                    $this->email->to($_SESSION['ldap']['email']);
                    $this->email->subject('New Staff Account');
                    $this->email->message('You have submitted a new staff account request for
                       Name: ' . $this->input->post('first_name') . ' ' . $this->input->post('last_name') . '
                       Position: ' . $this->input->post('position') . '
                           
                       There password is: '.$password.'
                       Check their username here: https://intranet.cant-col.ac.uk/dashboard/computing-support/new-account/pending

                       This account will be available for the user tomorrow.');
                    $this->email->send();

                    // user created
                    $this->load->view('templates/header');
                    $this->load->view('computing-support/new-account/created');
                    $this->load->view('templates/footer');

                } else {
                    
                    $function = 'new_staff_account_error';
                    $this->user_model->function_log($function);

                    $data = new stdClass();
                    $data->error = 'There was a problem creating this account. Please try again.';

                    // failed to create user
                    $this->load->view('templates/header');
                    $this->load->view('computing-support/new-account/view', $data);
                    $this->load->view('templates/footer');

                }	
            }    
        } else {
            redirect('permissions');
        }
    }
    
    public function history() {
        
        if (in_array('CN=Dashboard_New_Staff_Account,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) || 
            in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
            in_array('CN=Intranet_Edit_HR,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
        
            $crud = new grocery_CRUD();
            $crud->set_table('new_account');
            $crud->set_subject('new_account', 'New Account');
            $crud->display_as('ern','ER no.')->display_as('ext','Phone Number')->display_as('con_start','Contract Start')->display_as('con_end','Contract End');
            $crud->edit_fields('complete');
            $crud->unset_add();
            $crud->unset_read();
            $crud->unset_delete();
            $output = $crud->render();

            $this->load->view('templates/header.php');
            $this->load->view('computing-support/new-account/history', $output);
            $this->load->view('templates/footer.php');
            $this->load->view('templates/table_assets.php', $output);
            
        } else {
            redirect('permissions');
        }
        
    }
    
    public function pending() {
        
        if (in_array('CN=Dashboard_New_Staff_Account,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) || 
            in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
            in_array('CN=Intranet_Edit_HR,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
        
            $crud = new grocery_CRUD();
            $crud->set_table('new_account_pending');
            $crud->set_subject('pending', 'Pending');
            $crud->set_primary_key('id');
            $crud->unset_edit_fields('id', 'password', 'username');
            $crud->unset_add();
            $crud->unset_read();
            $output = $crud->render();

            $this->load->view('templates/header.php');
            $this->load->view('computing-support/new-account/pending', $output);
            $this->load->view('templates/footer.php');
            $this->load->view('templates/table_assets.php', $output);
            
        } else {
            redirect('permissions');
        }
        
    }
    
    // If changed are made, duplicate in New_staff_export.php controller.

    public function complete() {
        
        if (in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
            
            $function = 'complete_staff_accounts_manual';
            $this->user_model->function_log($function);
        
            $this->new_account_model->complete_account();

            $this->load->view('templates/header');
            $this->load->view('computing-support/new-account/complete');
            $this->load->view('templates/footer');
            
        } else {
            redirect('permissions');
        }
    }
    
    // If changed are made, duplicate in New_staff_export.php controller.
     
    function export() {
        
        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
            
            $function = 'export_staff_account_manual';
            $this->user_model->function_log($function);
        
            $this->load->dbutil();
            //MySQL View - only export incomplete
            $query = $this->db->query("SELECT * FROM new_account_export");
            $delimiter = ",";
            $newline = "\n";
            $output = $this->dbutil->csv_from_result($query, $delimiter, $newline);

            function clean_export($string) {
                $string = str_replace('"', '', $string); // Replaces all spaces with hyphens - Required by SAD02-46 script.
                return $string;
            }

            $output = clean_export($output);
            force_download("newstaff.csv", $output);
            
        } else {
            redirect('permissions');
        }
    }
    
    public function disable_account() {
        
        if (in_array('CN=Dashboard_New_Staff_Account,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) || 
            in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
            in_array('CN=Intranet_Edit_HR,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
        
            $this->load->helper('form');
            $this->load->library('form_validation');

            // validation rules
            $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('last', 'Last Day', 'trim|required');

            if ($this->form_validation->run() === false) {

                $this->load->view('templates/header');
                $this->load->view('computing-support/new-account/disable');
                $this->load->view('templates/footer');

            } else {

                $full_name = $this->input->post('full_name');
                $last = $this->input->post('last');
                $full_name2 = $this->input->post('full_name2');
                $last2 = $this->input->post('last2');
                $full_name3 = $this->input->post('full_name3');
                $last3 = $this->input->post('last3');
                $full_name4 = $this->input->post('full_name4');
                $last4 = $this->input->post('last4');
                $full_name5 = $this->input->post('full_name5');
                $last5 = $this->input->post('last5');
                $full_name6 = $this->input->post('full_name6');
                $last6 = $this->input->post('last6');
                $full_name7 = $this->input->post('full_name7');
                $last7 = $this->input->post('last7');
                $full_name8 = $this->input->post('full_name8');
                $last8 = $this->input->post('last8');
                $full_name9 = $this->input->post('full_name9');
                $last9 = $this->input->post('last9');
                $full_name10 = $this->input->post('full_name10');
                $last10 = $this->input->post('last10');

                if ($this->new_account_model->disable($full_name, $last)) {
                    
                    $function = 'disable_staff_account_submittion';
                    $this->user_model->function_log($function);
                
                    if (isset($full_name2)) {
                        $full_name = $full_name2;
                        $last = $last2;
                        $this->new_account_model->disable($full_name, $last);
                    } if (isset($full_name3)) {
                        $full_name = $full_name3;
                        $last = $last3;
                        $this->new_account_model->disable($full_name, $last);
                    } if (isset($full_name4)) {
                        $full_name = $full_name4;
                        $last = $last4;
                        $this->new_account_model->disable($full_name, $last);
                    } if (isset($full_name5)) {
                        $full_name = $full_name5;
                        $last = $last5;
                        $this->new_account_model->disable($full_name, $last);
                    } if (isset($full_name6)) {
                        $full_name = $full_name6;
                        $last = $last6;
                        $this->new_account_model->disable($full_name, $last);
                    } if (isset($full_name7)) {
                        $full_name = $full_name7;
                        $last = $last7;
                        $this->new_account_model->disable($full_name, $last);
                    } if (isset($full_name8)) {
                        $full_name = $full_name8;
                        $last = $last8;
                        $this->new_account_model->disable($full_name, $last);
                    } if (isset($full_name9)) {
                        $full_name = $full_name9;
                        $last = $last9;
                        $this->new_account_model->disable($full_name, $last);
                    } if (isset($full_name10)) {
                        $full_name = $full_name10;
                        $last = $last10;
                        $this->new_account_model->disable($full_name, $last);
                    }

                    $this->email->from('noreply@intranet.cant-col.ac.uk', 'Disable Staff Account');
                    $this->email->to('ns@canterburycollege.ac.uk');
                    $this->email->subject('Disable Staff Account');
                    $this->email->message('A staff account needs to be disabled and has been requested by '.$_SESSION['username'].'
                       Name: ' . $this->input->post('full_name') . '
                       Last Day: ' . $this->input->post('last') . '
                           
                       By: ' . $_SESSION['ldap']['full_name'].'
                           
                       https://intranet.cant-col.ac.uk/dashboard/computing-support/new-account/disable-account/pending');
                    $this->email->send();

                    $this->load->view('templates/header');
                    $this->load->view('computing-support/new-account/disabled');
                    $this->load->view('templates/footer');

                } else {
                    
                    $function = 'disable_staff_account_error';
                    $this->user_model->function_log($function);

                    $data = new stdClass();
                    $data->error = 'There was a problem making this request. Please try again.';

                    // failed to create user
                    $this->load->view('templates/header');
                    $this->load->view('computing-support/new-account/disable', $data);
                    $this->load->view('templates/footer');

                }	
            }    
        } else {
            redirect('permissions');
        }
    }
    
    public function history_disabled_account() {
        
        if (in_array('CN=Dashboard_New_Staff_Account,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) || 
            in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
            in_array('CN=Intranet_Edit_HR,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
        
            $crud = new grocery_CRUD();
            $crud->set_table('disable_account');
            $crud->set_subject('disable_account', 'Disable Account');
            $crud->unset_add();
            $crud->unset_read();
            $crud->unset_delete();
            $output = $crud->render();

            $this->load->view('templates/header.php');
            $this->load->view('computing-support/new-account/disable_history', $output);
            $this->load->view('templates/footer.php');
            $this->load->view('templates/table_assets.php', $output);
            
        } else {
            redirect('permissions');
        }
        
    }
    
    public function pending_disabled_account() {
        
        if (in_array('CN=Dashboard_New_Staff_Account,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) || 
            in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups']) ||
            in_array('CN=Intranet_Edit_HR,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
        
            $crud = new grocery_CRUD();
            $crud->set_table('disable_account_pending');
            $crud->set_subject('pending', 'Pending');
            $crud->set_primary_key('id');
            $crud->unset_columns('id'); 
            $crud->unset_add();
            $crud->unset_read();
            $output = $crud->render();

            $this->load->view('templates/header.php');
            $this->load->view('computing-support/new-account/disable_pending', $output);
            $this->load->view('templates/footer.php');
            $this->load->view('templates/table_assets.php', $output);
            
        } else {
            redirect('permissions');
        }
        
    }
}
