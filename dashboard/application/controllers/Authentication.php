<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends My_Public {

    public function __construct() {
        parent::__construct();
            $this->load->library('encrypt');
    }

    public function index() {

        redirect('home');
    }

    public function external_login() {

        $ip = $_SERVER['REMOTE_ADDR'];
        if ($this->user_model->ip_is_private($ip) === TRUE) {

            redirect('/');
        } else {
            
            if (isset($_SESSION['external_login']) === TRUE) {
                
                redirect('/');
            } else {

                $uid = $_SESSION['uid'];
                if ($this->user_model->external_login_blocked($uid) === TRUE) {

                    redirect('/authentication/user-lockout');
                } else {

                    $this->load->helper('form');
                    $this->load->library('form_validation');

                    // validation rules
                    $this->form_validation->set_rules('password', 'Password', 'required');

                    if ($this->form_validation->run() == false) {

                        $this->load->view('templates/header');
                        $this->load->view('templates/ldap');
                        $this->load->view('templates/footer');
                    } else {

                        $username = $_SESSION['username'];
                        $password = $this->input->post('password');

                        if ($this->user_model->resolve_user_login($username, $password)) {

                            $this->session->set_userdata('external_login', TRUE);
                            redirect($_SESSION['last_url']);
                        } else {

                            if ($this->user_model->external_login_blocked($uid) === TRUE) {

                                redirect('/authentication/user-lockout');
                                
                                $function = 'external_login_LOCKOUT';
                                $this->user_model->function_log($function);
                    
                            } else {
                                
                                $function = 'external_login_PASSWORD_INCORRECT';
                                $this->user_model->function_log($function);

                                $data = new stdClass();
                                $data->error = 'Wrong password please try again.';

                                // loose an attempt
                                $this->user_model->external_login_fail($uid);

                                $this->load->view('templates/header');
                                $this->load->view('templates/ldap', $data);
                                $this->load->view('templates/footer');
                            }
                        }
                    }
                }
            }
        }
    }

    public function logout() {

        if (isset($_COOKIE['CI-CONCRETE5']) === FALSE) {

            redirect('/');
        } else {

            // clear session
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }
            setcookie('CI-CONCRETE5', 'expired', time() - (1), "/");
            redirect($_COOKIE['CONCRETE5_LOGOUT']);
            
            $function = 'LOGOUT';
            $this->user_model->function_log($function);
        }
    }

// END logout	

    public function not_found() {

        $this->load->view('templates/error/404');
        $function = '404_page_not_found';
        $this->user_model->function_log($function);
    }

    public function permissions() {

        $this->load->view('templates/error/permissions');
        $function = 'PERMISSION_DENIED';
        $this->user_model->function_log($function);
    }

    public function internal() {

        $this->load->view('templates/error/internal');
        $function = 'INTERNAL_ACCESS_ONLY';
        $this->user_model->function_log($function);
    }

    public function passkey() {

        $ip = $_SERVER['REMOTE_ADDR'];
        if ($this->user_model->ip_is_private($ip) === FALSE) { 

            redirect('authentication/internal');
            
        } else {

            $this->load->helper('form');
            $this->load->library('form_validation');

            // validation rules
            $this->form_validation->set_rules('passid', 'PassID', 'required');
            $this->form_validation->set_rules('passkey', 'Passkey', 'required');

            if ($this->form_validation->run() == false) {

                $this->load->view('templates/header');
                $this->load->view('templates/passkey');
                $this->load->view('templates/footer');
            } else {

                $passid = $this->input->post('passid');
                $passkey = $this->input->post('passkey');

                if ($this->user_model->resolve_passkey($passid, $passkey)) {
                    
                    $this->user_model->log_passkey($ip, $passid);
                    $details = $this->user_model->get_passkey_details($passid);
                    
                    $function = 'passkey_SUCCESSFUL';
                    $this->user_model->function_log($function);
                    
                    if (isset($_COOKIE['CI_PASSKEY']) === FALSE) {
                        
                        $encrypt_item = array('passkey_array', $passid);
                    
                        setcookie('CI_PASSKEY', serialize($encrypt_item), time() + (18000), "/");
                        redirect($details[0]['url']);
                        
                    } else {
                        
                        $current_array = unserialize($_COOKIE['CI_PASSKEY']);
                        
                        if (!in_array($passid, $current_array)) {
                        
                            $current_array[] = $passid;

                            setcookie('CI_PASSKEY', serialize($current_array), time() + (18000), "/");
                            redirect($details[0]['url']);
                        
                        } else {
                            redirect($details[0]['url']);
                        }
                        
                    }
                } else {
                    
                    $function = 'passkey_INCORRECT';
                    $this->user_model->function_log($function);

                    $data = new stdClass();
                    $data->error = 'Wrong password please try again.';

                    $this->load->view('templates/header');
                    $this->load->view('templates/passkey', $data);
                    $this->load->view('templates/footer');
                }
            }
        }
    }

}

// END controller