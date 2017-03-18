<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Temporary_account extends My_Force_Login {

    public function __construct() {
        parent::__construct();
        $this->load->model('computing-support/Temporary_account_model', 'temporary_account_model');
    }

    public function index() {

        $this->load->helper('form');
        $this->load->library('form_validation');

        $data = array();
        $data['faculty'] = $this->temporary_account_model->get_faculty();
        $data['department'] = $this->temporary_account_model->get_department();
        $data['tempid'] = "tempuser" . $this->temporary_account_model->get_next_temp();

        //validation
        $this->form_validation->set_rules('faculty', 'Faculty', 'trim|required');
        $this->form_validation->set_rules('requester', 'Staff requester', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('first_name', 'Users first name', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('last_name', 'Users last name', 'trim|required|min_length[3]');

        if ($this->form_validation->run() === FALSE) {

            $this->load->view('templates/header');
            $this->load->view('computing-support/temporary-account/view', $data);
            $this->load->view('templates/footer');
        } else {

            $logged = $this->input->post('logged');
            $faculty = $this->input->post('faculty');
            $department = $this->input->post('department');
            $requester = $this->input->post('requester');
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
            $username = $this->input->post('username');
            $expiry = $this->input->post('expiry');

            if ($this->temporary_account_model->create($logged, $faculty, $department, $requester, $first_name, $last_name, $email, $username, $expiry)) {

                $this->email->from('noreply@intranet.cant-col.ac.uk', 'Temporary Logon Account Request');
                $this->email->to('w.bargent@canterburycollege.ac.uk');
                $this->email->subject('Temporary Logon Account Request');
                $this->email->message('A temporary network account has been requested by ' . $_SESSION['ldap']['full_name']
                        . ' for ' . $this->input->post('requester')
                        . ''
                        . 'the user will be: ' . $this->input->post('first_name') . ' ' . $this->input->post('last_name')
                        . ''
                        . 'Approve https://intranet.cant-col.ac.uk/dashboard/computing-support/temporary-account/approve');
                $this->email->send();

                $this->load->view('templates/header');
                $this->load->view('computing-support/temporary-account/complete');
                $this->load->view('templates/footer');
            } else {

                $data = array();
                $data = new stdClass();
                $data->error = 'There was a problem requesting this account. Please try again.';

                // failed to create user
                $this->load->view('templates/header');
                $this->load->view('computing-support/temporary-account/view', $data);
                $this->load->view('templates/footer');
            }
        }
    }
    
    public function history() {

        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $data = array();
            $data['temporary_account'] = $this->temporary_account_model->get_all();

            $this->load->view('templates/header');
            $this->load->view('computing-support/temporary-account/history', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('permissions');
        }
    }
    
    public function check() {

        $data = array();
        $data['temporary_account'] = $this->temporary_account_model->check_status();

        $this->load->view('templates/header');
        $this->load->view('computing-support/temporary-account/check', $data);
        $this->load->view('templates/footer');
    }

    public function pending() {

        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $data = array();
            $data['temporary_account'] = $this->temporary_account_model->get_pending();

            $this->load->view('templates/header');
            $this->load->view('computing-support/temporary-account/pending', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('permissions');
        }
    }
    
    public function cancel() {
        
        $id = $_GET['id'];
        $check_user = $this->temporary_account_model->match_id_user($id);
        if ($check_user[0]['logged'] == $_SESSION['ldap']['full_name'] || $check_user[0]['requested'] == $_SESSION['ldap']['full_name']) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->temporary_account_model->cancel($id);

                $function = 'temp_account_CANCEL_' . $id;
                $this->user_model->function_log($function);

                redirect($_SERVER['HTTP_REFERER']);
            }
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function reject() {

        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                $this->temporary_account_model->reject($id);

                $function = 'temp_account_REJECT_' . $id;
                $this->user_model->function_log($function);

                redirect($_SERVER['HTTP_REFERER']);
            }

            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function approve() {

        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            if (isset($_GET['id'])) {
                
                $id = $_GET['id'];
                //$this->temporary_account_model->approve($id);

                $function = 'temp_account_APPROVED_' . $id;
                $this->user_model->function_log($function);
        
                    $data = array();
                    $data['AD'] = $this->temporary_account_model->get_account($id);

                    //AD account start
                    //AD Server
                    $AD_server = $this->config->item('ldapserver');
                    $AD_Auth_User = $this->config->item('ldapshortdomain').$this->config->item('ldapadminun'); //Administrative user
                    $AD_Auth_PWD = $this->config->item('ldapadminpass'); //The password
                    //Create Active Directory timestamp
                    date_default_timezone_set($this->config->item('timezone'));

                    //Format dd-mm-yyyy
                    //Expiry is beginning of day (thats why +1 day
                    $dateFromForm = date('d-m-Y', strtotime($data['AD'][0]['expiry']. ' +1 day'));

                    //Format hh:mm:ss
                    $timeFromForm = "00:00:00";

                    $dateWithTime = $dateFromForm . " " . $timeFromForm;

                    function convertDateToUnix($input) {
                        $format = 'd-m-Y H:i:s';
                        $date = DateTime::createFromFormat($format, $input);
                        $UNIXTimestamp = $date->getTimestamp();
                        return $UNIXTimestamp;
                    }

                    function convertUnixtoWin($input) {
                        return ($input + 11644473600) * 10000000;
                    }

                    //$UNIX = convertDateToUnix($dateWithTime);
                    //$WIN = convertUnixtoWin($UNIX);

                    //Create Unicode password
                    $passwordWithQuotes = '"' . $data['AD'][0]['password'] . '"';
                    $ldaprecord = array();
                    $ldaprecord["unicodepwd"] = iconv('UTF-8', 'UTF-16LE', $passwordWithQuotes);

                    //Build Active Directory record     
                    $ldaprecord["cn"] = $data['AD'][0]['username'];
                    $ldaprecord["givenName"] = $data['AD'][0]['first_name'];
                    $ldaprecord["sn"] = $data['AD'][0]['last_name'];
                    $ldaprecord["mail"] = $data['AD'][0]['email'];
                    $ldaprecord["sAMAccountName"] = $data['AD'][0]['username'];
                    $ldaprecord["displayName"] = $data['AD'][0]['first_name'] . " " . $data['AD'][0]['last_name'];
                    $ldaprecord["l"] = "Canterbury";
                    $ldaprecord["description"] = "Temp account created by dashboard for " . $ldaprecord["displayName"];
                    //$ldaprecord["accountExpires"] = $WIN;
                    $ldaprecord["UserAccountControl"] = "512"; //512 - Enabled Account
                    $ldaprecord['userPrincipalName'] = $data['AD'][0]['username'] . '@cant-col.ac.uk';
                    $ldaprecord['objectclass'][0] = "top";
                    $ldaprecord['objectclass'][1] = "person";
                    $ldaprecord['objectclass'][2] = "organizationalPerson";
                    $ldaprecord['objectclass'][3] = "user";
                    $dn = 'CN=' . $ldaprecord["cn"] . ',OU=Temp Accounts,OU=Students,OU=Accounts,DC=cant-col,DC=ac,DC=uk';

                    // Connect to Active Directory
                    $ds = ldap_connect('ldaps://' . $AD_server);

                    if ($ds) {
                        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
                        ldap_bind($ds, $AD_Auth_User, $AD_Auth_PWD); //Bind
                        ldap_add($ds, $dn, $ldaprecord); //Create account
                        ldap_close($ds); //Close connection
                        $this->temporary_account_model->created_account($id);
                    } else {
                        //redirect('computing-support/temporary-account/error?id='.$id);
                    }
                    //AD account end.
            
                //redirect($_SERVER['HTTP_REFERER']);
                    $this->load->view('templates/header');
            $this->load->view('computing-support/temporary-account/view');
            $this->load->view('templates/footer');
                    
            }

            //redirect($_SERVER['HTTP_REFERER']);
        } else {
            //redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function error() {

        if (in_array('CN=DG06,OU=Distribution Groups,OU=Email Groups,OU=Accounts,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $this->load->view('templates/header');
            $this->load->view('computing-support/temporary-account/error', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('permissions');
        }
    }
}
