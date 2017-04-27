<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function update_active_ad_users() {

        $ldap_password = $this->config->item('ldapbindpass');
        $ldap_username = $this->config->item('ldapshortdomain').$this->config->item('ldapbindun');
        $ldap_connection = ldap_connect($this->config->item('ldapserver'));

        ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
        ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0);

        if (TRUE === ldap_bind($ldap_connection, $ldap_username, $ldap_password)) {
            $search_filter = '(&(objectCategory=person)(samaccountname=*))';
            $attributes = array();
            $attributes[] = 'givenname';
            $attributes[] = 'samaccountname';
            $attributes[] = 'sn';
            $attributes[] = 'mail';
            $ad_users = array();

            //empty database
            $this->db->truncate('users_ad');

            $result_admin = ldap_search($ldap_connection, $this->config->item('ldapuserjobouone'), $search_filter, $attributes);
            if (FALSE !== $result_admin) {
                $entries = ldap_get_entries($ldap_connection, $result_admin);
                for ($x = 0; $x < $entries['count']; $x++) {
                    if (!empty($entries[$x]['givenname'][0]) &&
                            !empty($entries[$x]['samaccountname'][0]) &&
                            !empty($entries[$x]['sn'][0]) &&
                            !empty($entries[$x]['mail'][0])) {  
                        $ad_users[] = array('first_name' => trim($entries[$x]['givenname'][0]), 'last_name' => trim($entries[$x]['sn'][0]), 'full_name' => trim($entries[$x]['givenname'][0]).' '. trim($entries[$x]['sn'][0]), 'username' => trim($entries[$x]['samaccountname'][0]), 'email' => trim($entries[$x]['mail'][0]));
                    }
                }
            }
            $result_canterbury = ldap_search($ldap_connection, $this->config->item('ldapuserjoboutwo'), $search_filter, $attributes);
            if (FALSE !== $result_canterbury) {
                $entries = ldap_get_entries($ldap_connection, $result_canterbury);
                for ($x = 0; $x < $entries['count']; $x++) {
                    if (!empty($entries[$x]['givenname'][0]) &&
                            !empty($entries[$x]['samaccountname'][0]) &&
                            !empty($entries[$x]['sn'][0]) &&
                            !empty($entries[$x]['mail'][0])) {
                        $ad_users[] = array('first_name' => trim($entries[$x]['givenname'][0]), 'last_name' => trim($entries[$x]['sn'][0]), 'full_name' => trim($entries[$x]['givenname'][0]).' '. trim($entries[$x]['sn'][0]), 'username' => trim($entries[$x]['samaccountname'][0]), 'email' => trim($entries[$x]['mail'][0]));
                    }
                }
            }
            $result_sheppy = ldap_search($ldap_connection, $this->config->item('ldapuserjobouthree'), $search_filter, $attributes);
            if (FALSE !== $result_sheppy) {
                $entries = ldap_get_entries($ldap_connection, $result_sheppy);
                for ($x = 0; $x < $entries['count']; $x++) {
                    if (!empty($entries[$x]['givenname'][0]) &&
                            !empty($entries[$x]['samaccountname'][0]) &&
                            !empty($entries[$x]['sn'][0]) &&
                            !empty($entries[$x]['mail'][0])) {
                        $ad_users[] = array('first_name' => trim($entries[$x]['givenname'][0]), 'last_name' => trim($entries[$x]['sn'][0]), 'full_name' => trim($entries[$x]['givenname'][0]).' '. trim($entries[$x]['sn'][0]), 'username' => trim($entries[$x]['samaccountname'][0]), 'email' => trim($entries[$x]['mail'][0]));
                    }
                }
            }
            $result_nicks = ldap_search($ldap_connection, $this->config->item('ldapuserjoboufour'), $search_filter, $attributes);
            if (FALSE !== $result_nicks) {
                $entries = ldap_get_entries($ldap_connection, $result_nicks);
                for ($x = 0; $x < $entries['count']; $x++) {
                    if (!empty($entries[$x]['givenname'][0]) &&
                            !empty($entries[$x]['samaccountname'][0]) &&
                            !empty($entries[$x]['sn'][0]) &&
                            !empty($entries[$x]['mail'][0])) {
                        $ad_users[] = array('first_name' => trim($entries[$x]['givenname'][0]), 'last_name' => trim($entries[$x]['sn'][0]), 'full_name' => trim($entries[$x]['givenname'][0]).' '. trim($entries[$x]['sn'][0]), 'username' => trim($entries[$x]['samaccountname'][0]), 'email' => trim($entries[$x]['mail'][0]));
                    }
                }
            }
            $result_nicks = ldap_search($ldap_connection, $this->config->item('ldapuserjoboufive'), $search_filter, $attributes);
            if (FALSE !== $result_nicks) {
                $entries = ldap_get_entries($ldap_connection, $result_nicks);
                for ($x = 0; $x < $entries['count']; $x++) {
                    if (!empty($entries[$x]['givenname'][0]) &&
                            !empty($entries[$x]['samaccountname'][0]) &&
                            !empty($entries[$x]['sn'][0]) &&
                            !empty($entries[$x]['mail'][0])) {
                        $ad_users[] = array('first_name' => trim($entries[$x]['givenname'][0]), 'last_name' => trim($entries[$x]['sn'][0]), 'full_name' => trim($entries[$x]['givenname'][0]).' '. trim($entries[$x]['sn'][0]), 'username' => trim($entries[$x]['samaccountname'][0]), 'email' => trim($entries[$x]['mail'][0]));
                    }
                }
            }

            ldap_unbind($ldap_connection);
        }

        if ($this->db->insert_batch('users_ad', $ad_users)) {
            
            $ip = $_SERVER['REMOTE_ADDR'];
            $data = array(
                'timestamp' => date("Y-m-d H:i:s", time()),
                'ip' => $ip,
                'job' => 'Users updated successfully.',
            );

            return $this->db->insert('job_log', $data);
        } else {
            
            $ip = $_SERVER['REMOTE_ADDR'];
            $data = array(
                'timestamp' => date("Y-m-d H:i:s", time()),
                'ip' => $ip,
                'job' => 'Users updated failed.',
            );
            return $this->db->insert('job_log', $data);
        }
    }
}