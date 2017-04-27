<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('encrypt');
    }

    function resolve_user_login($username, $password) {

        $ldap = ldap_connect($this->config->item('ldapserver'));

        $ldaprdn = $this->config->item('ldapshortdomain') . $username;

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        //bind with users creds
        $bind = @ldap_bind($ldap, $ldaprdn, $password);

        if ($bind) {
            $filter = "(sAMAccountName=$username)";
            $result = ldap_search($ldap, $this->config->item('ldapuserou'), $filter);
            ldap_sort($ldap, $result, "sn");
            $info = ldap_get_entries($ldap, $result);
            for ($i = 0; $i < $info["count"]; $i++) {
                return TRUE;
            }
            @ldap_close($ldap);
            if (@ldap_close($ldap) === false) {
                echo "Could not close LDAP connection";
            }
        } else {
            return FALSE;
        }
    }

    function user_exist($username) {

        $db_intranet = $this->load->database('intranet', TRUE);

        $db_intranet->select('uID');
        $db_intranet->from('Users');
        $db_intranet->where('uName', $username);

        $query = $db_intranet->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

        $this->db->close();
    }

    function user_ldap($username) {

        $ldap = ldap_connect($this->config->item('ldapserver'));

        //bind with ldapquery
        $ldaprdn = $this->config->item('ldapshortdomain').$this->config->item('ldapbindun');
        $ldappass = $this->config->item('ldapbindpass');

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        $bind = @ldap_bind($ldap, $ldaprdn, $ldappass);

        if ($bind) {
            $filter = "(sAMAccountName=$username)";
            $result = ldap_search($ldap, $this->config->item('ldapuserou'), $filter);
            ldap_sort($ldap, $result, "sn");
            $info = ldap_get_entries($ldap, $result);
            for ($i = 0; $i < $info["count"]; $i++) {
                if ($info['count'] > 1)
                    break;

                //clean
                $groups = $info[$i]["memberof"];
                unset($groups['count']);

                //only dashboard groups
                foreach ($groups as $key => $value) {
                    $exp_key = explode(',', $value);
                    if ($exp_key[1] == $this->config->item('ldapdashboardgroupsou')) {
                        $dashboard_groups = array();
                        $dashboard_groups[] = $value;
                    }
                }

                // if no dashboard groups
                if (isset($dashboard_groups) === FALSE) {
                    $dashboard_groups = 0;
                }

                return array(
                    'useraccountcontrol' => $info[$i]["useraccountcontrol"][0],
                    'full_name' => $info[$i]["displayname"][0],
                    'first_name' => $info[$i]["givenname"][0],
                    'last_name' => isset($info[$i]["sn"][0]),
                    'username' => $username,
                    'email' => $info[$i]["mail"][0],
                    'phone' => isset($info[$i]["telephonenumber"][0]),
                    'position' => isset($info[$i]["title"][0]),
                    'department' => isset($info[$i]["department"][0]),
                    'ern' => isset($info[$i]["employeeid"][0]),
                    'groups' => $groups,
                    'dashboard_groups' => $dashboard_groups,
                );
            }
            @ldap_close($ldap);
            if (@ldap_close($ldap) === false) {
                echo "Could not close LDAP connection";
            }
        } else {
            return FALSE;
        }
    }

    public function get_uid_from_username($username) {

        $db_intranet = $this->load->database('intranet', TRUE);

        $db_intranet->select('uID');
        $db_intranet->from('Users');
        $db_intranet->where('uName', $username);

        return $db_intranet->get()->row('uID');
    }

    public function set_user($uid, $username, $ip) {

        $this->db->where('uid', $uid);
        $query = $this->db->get('users');
        $current = $query->result_array();

        // always available in model
        $two_hour_login = strtotime("-2 hours");
        $current_timestamp = date("Y-m-d H:i:s", time());
        $login_count = 1;
        $browser = $this->agent->browser() . ' ' . $this->agent->version();

        if ($query->num_rows() > 0) {

            // model overide
            $last_timestamp = strtotime($current[0]['last_login']);
            $login_count = $current[0]['login_count'] + 1;

            if ($this->user_model->ip_is_private($ip) === FALSE) {
                // add 1 if external ip
                $external_login = $current[0]['external_login'] + 1;
                $ip_external = $ip;
                $ip_internal = $current[0]['ip_internal'];
                $last_external = $current_timestamp;
            } else {
                $external_login = $current[0]['external_login'];
                $ip_external = $current[0]['ip_external'];
                $ip_internal = $ip;
                $last_external = $current[0]['last_external'];
            }

            if ($last_timestamp <= $two_hour_login) {
                // update very 2 hours only
                $this->db->where('uid', $uid);
                return $this->db->update('users', array('last_login' => $current_timestamp,
                            'login_count' => $login_count,
                            'external_login' => $external_login,
                            'ip_last' => $ip,
                            'ip_internal' => $ip_internal,
                            'ip_external' => $ip_external,
                            'external_login' => $external_login,
                            'browser' => $browser,
                            'os' => $this->agent->platform(),
                            'last_external' => $last_external,
                ));
            } else {
                // always up-to-date
                $this->db->where('uid', $uid);
                return $this->db->update('users', array('ip_last' => $ip,
                            'ip_internal' => $ip_internal,
                            'ip_external' => $ip_external,
                            'external_login' => $external_login,
                            'browser' => $browser,
                            'os' => $this->agent->platform(),
                            'last_active' => $current_timestamp,
                            'last_external' => $last_external,
                ));
            }
        } else {

            if ($this->user_model->ip_is_private($ip) === FALSE) {
                // add 1 if external ip
                $external_login = 1;
                $ip_external = $ip;
                $ip_internal = 0;
                $last_external = $current_timestamp;
            } else {
                $external_login = 0;
                $ip_external = 0;
                $ip_internal = $ip;
                $last_external = NULL;
            }

            // first time login
            return $this->db->insert('users', array('uid' => $uid,
                        'username' => $username,
                        'last_login' => $current_timestamp,
                        'login_count' => '1',
                        'external_login' => $external_login,
                        'ip_last' => $ip,
                        'ip_internal' => $ip_internal,
                        'ip_external' => $ip_external,
                        'browser' => $browser,
                        'os' => $this->agent->platform(),
                        'last_active' => $current_timestamp,
                        'last_external' => $last_external,
            ));
        }
    }

    function clean($string) {
        return preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $string);
    }

    function decrypt($key, $cookie) {

        define('IV_SIZE', mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

        $combo = base64_decode($cookie);
        $iv = substr($combo, 0, IV_SIZE);
        $crypt = substr($combo, IV_SIZE, strlen($combo));
        $username = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $crypt, MCRYPT_MODE_CBC, $iv);

        return $this->user_model->clean($username);
    }

    function encrypt($key, $encrypt_item) {

        $iv = mcrypt_create_iv(IV_SIZE, MCRYPT_DEV_URANDOM);
        $crypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $encrypt_item, MCRYPT_MODE_CBC, $iv);
        $combo = $iv . $crypt;
        $output = base64_encode($iv . $crypt);

        return $output;
    }

    function ip_is_private($ip) {
       $safe_ip = array(
           $this->config->item('safeipone'),
           $this->config->item('safeiptwo'),
           $this->config->item('safeipthree'),
           $this->config->item('safeipfour'),
           $this->config->item('safeipfive'),
           $this->config->item('safeipsix'),
           $this->config->item('safeipseven'),
           $this->config->item('safeipeight'),
           $this->config->item('safeipnine'),
           $this->config->item('safeipten'),
       );      
      
      if (in_array($_SERVER['REMOTE_ADDR'], $safe_ip)) {
            return true;
        } else {
            return false;
        }  
       
    }

    function external_login_blocked($uid) {

        $this->db->select('external_login_block');
        $this->db->from('users');
        $this->db->where('uid', $uid);

        $query = $this->db->get()->result_array();

        if ($query[0]['external_login_block'] === '0') {
            return true;
        } else {
            return false;
        }
    }

    function external_login_fail($uid) {

        $this->db->where('uid', $uid);
        $query = $this->db->get('users');
        $current = $query->result_array();

        if ($current[0]['external_login_block'] == '0') {
            $new = 0;
        } else {
            $new = $current[0]['external_login_block'] - 1;
        }

        $this->db->where('uid', $uid);
        return $this->db->update('users', array('external_login_block' => $new));
    }

    function external_login_reset($uid) {

        $this->db->where('uid', $uid);
        return $this->db->update('users', array('external_login_block' => 5));
    }

    public function user_log() {
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $data = array(
            'timestamp' => date("Y-m-d H:i:s", time()),
            'ip' => $ip,
            'username' => $_SESSION['username'],
            'url' => current_url(),
        );

        return $this->db->insert('users_log', $data);
    }
    
    public function function_log($function) {

        $ip = $_SERVER['REMOTE_ADDR'];
        
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        } else {
            $username = NULL;
        }
        
        $data = array(
            'timestamp' => date("Y-m-d H:i:s", time()),
            'ip' => $ip,
            'username' => $username,
            'url' => current_url(),
            'function' => $function
        );

        return $this->db->insert('users_log', $data);
    }

    public function resolve_passkey($passid, $passkey) {

        $this->db->select('passkey');
        $this->db->from('passkey');
        $this->db->where('passid', $passid);
        $decrypt = $this->db->get()->row('passkey');

        $hash = $this->encrypt->decode($decrypt);

        return password_verify($passkey, password_hash($hash, PASSWORD_BCRYPT));
        ;
    }

    public function get_passkey_details($passid) {

        $query = $this->db->get_where('passkey', array('passid' => $passid));
        return $query->result_array();
    }

    public function log_passkey($ip, $passid) {

        if (isset($_SESSION['username']) === TRUE) {
            $username = $_SESSION['username'];
        } else {
            $username = NULL;
        }

        $data = array(
            'timestamp' => date("Y-m-d H:i:s", time()),
            'ip' => $ip,
            'passid' => $passid,
            'username' => $username,
        );

        return $this->db->insert('passkey_log', $data);
    }

}

// END model
