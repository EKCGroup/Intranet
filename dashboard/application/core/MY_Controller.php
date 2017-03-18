<?php defined('BASEPATH') OR exit('No direct script access allowed');

class My_Public extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');

        if (isset($_COOKIE['CI-CONCRETE5']) === TRUE) {

            $cookie = $_COOKIE['CI-CONCRETE5'];
            $key = $this->config->item('concrete5authkey');
            $username = $this->user_model->decrypt($key, $cookie);

            if ($this->user_model->user_exist($username) === FALSE) {

                //expire fake cookie
                setcookie('CI-CONCRETE5', 'expired', time() - (1), "/");
            } else {

                $user_ldap = $this->user_model->user_ldap($username);

                if ($user_ldap['useraccountcontrol'] == '66050') {
                    // disabled, password never expire
                    redirect('/authentication/user-disabled');
                } elseif ($user_ldap['useraccountcontrol'] == '514') {
                    // disabled
                    redirect('/authentication/user-disabled');
                } else {

                    if (!in_array('CN=Staff,OU=Groups,DC=cant-col,DC=ac,DC=uk', $user_ldap['groups'])) {

                        redirect('/authentication/user-disabled');
                    } else {

                        $ip = $_SERVER['REMOTE_ADDR'];
                        $is_private = $this->user_model->ip_is_private($ip);
                        $uid = $this->user_model->get_uid_from_username($username);
                        $this->user_model->set_user($uid, $username, $ip);

                        $this->session->set_userdata('username', $username);
                        $this->session->set_userdata('uid', $uid);
                        $this->session->set_userdata('ldap', $user_ldap);
                        $this->session->set_userdata('is_private', $is_private);
                        
                        //uses sessions
                        $this->user_model->user_log();

                        if ($is_private === TRUE) {

                            // reset as internal
                            $this->user_model->external_login_reset($uid);
                        }
                    }
                }
            }
        }
    }

}

class My_Force_Login extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (isset($_COOKIE['CI-CONCRETE5']) === FALSE) {

            $this->session->set_userdata('last_url', current_url());
            redirect('/authentication/dashboard?url=' . current_url());
        } else {

            $cookie = $_COOKIE['CI-CONCRETE5'];
            $key = $this->config->item('concrete5authkey');
            $username = $this->user_model->decrypt($key, $cookie);

            if ($this->user_model->user_exist($username) === FALSE) {

                //expire fake cookie
                setcookie('CI-CONCRETE5', 'expired', time() - (1), "/");
                $this->session->set_userdata('last_url', current_url());
                redirect('/authentication/dashboard?url=' . current_url());
            } else {

                $user_ldap = $this->user_model->user_ldap($username);

                if ($user_ldap['useraccountcontrol'] == '66050') {
                    // disabled, password never expire
                    redirect('/authentication/user-disabled');
                } elseif ($user_ldap['useraccountcontrol'] == '514') {
                    // disabled
                    redirect('/authentication/user-disabled');
                } else {

                    if (!in_array('CN=Staff,OU=Groups,DC=cant-col,DC=ac,DC=uk', $user_ldap['groups'])) {

                        redirect('/authentication/user-disabled');
                    } else {

                        $ip = $_SERVER['REMOTE_ADDR'];
                        $is_private = $this->user_model->ip_is_private($ip);
                        if ($is_private === FALSE) {

                            if (isset($_SESSION['external_login']) === FALSE) {

                                $this->session->set_userdata('last_url', current_url());
                                redirect('authentication/external-login');
                            } else {

                                $uid = $this->user_model->get_uid_from_username($username);
                                $this->user_model->set_user($uid, $username, $ip);
                                $this->user_model->external_login_reset($uid);
                                // reset as internal

                                $this->session->set_userdata('username', $username);
                                $this->session->set_userdata('uid', $uid);
                                $this->session->set_userdata('ldap', $user_ldap);
                                $this->session->set_userdata('is_private', $is_private);
                                
                                //uses sessions
                                $this->user_model->user_log();
                            }
                        } else {

                            $uid = $this->user_model->get_uid_from_username($username);
                            $this->user_model->set_user($uid, $username, $ip);
                            $this->user_model->external_login_reset($uid);
                            // reset as internal

                            $this->session->set_userdata('username', $username);
                            $this->session->set_userdata('uid', $uid);
                            $this->session->set_userdata('ldap', $user_ldap);
                            $this->session->set_userdata('is_private', $is_private);
                            
                            //uses sessions
                            $this->user_model->user_log();
                        }
                    }
                }
            }
        }
    }

}

class My_Force_Login_Internal extends My_Force_Login {

    function __construct() {
        parent::__construct();

        $ip = $_SERVER['REMOTE_ADDR'];
        $is_private = $this->user_model->ip_is_private($ip);
        if ($is_private === FALSE || !in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {
            
            redirect('/dashboard/authentication/internal');
        }
    }

}

class My_Force_Admin extends My_Force_Login {

    function __construct() {
        parent::__construct();

        if (!in_array('CN=Dashboard_Admin,OU=Dashboard_Group,OU=Intranet_Group,OU=Groups,DC=cant-col,DC=ac,DC=uk', $_SESSION['ldap']['groups'])) {

            $this->load->view('templates/error/permissions');
        }
    }

}
