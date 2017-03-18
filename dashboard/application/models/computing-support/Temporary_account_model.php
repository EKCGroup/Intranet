<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Temporary_account_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('date');
    }

    public function create($logged, $faculty, $department, $requester, $first_name, $last_name, $email, $username, $expiry) {
        
        $firstchar = substr($this->input->post('first_name'), 0, 1);
        $builtUsername = strtolower($firstchar) . strtolower($this->input->post('last_name'));
        
        //check user name is new
        $username = $this->config->item('ldapshortdomain') . $builtUsername;
        // specify the LDAP server to connect to
        $conn = ldap_connect($this->config->item('ldapserver')) or die("Oh no can't create LDAP connection");
        // bind to the LDAP server specified above
        if (!ldap_bind($conn, $this->config->item('ldapbindun'),"@".$this->config->item('ldapdomain'), $this->config->item('ldapbindpass')))
            echo "Invalid credentials.";
        // Search for user in directory
        $cred = explode('\\', $username);
        list($domain, $user) = $cred;

        $result = ldap_search($conn, $this->config->item('ldapuserou'), "samaccountname=$user");
        // get entry data as array
        $info = ldap_count_entries($conn, $result);

        if ($info != 0) {
            $builtUsername = $builtUsername . "2";
        }

        function randomPassword() {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 6; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
        }
        $generatedpassword = randomPassword();

        /** Returns UNIX timestamp and Active Directory timestamp for given date and time */
        //Format dd-mm-yyyy
        $dateFromForm = $this->input->post('expiry');

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

        $data = array(
            'logged' => $_SESSION['ldap']['full_name'],
            'logged_at' => date("Y-m-d H:i:s", time()),
            'requester' => $this->input->post('requester'),
            'faculty' => $this->input->post('faculty'),
            'department' => $this->input->post('department'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'expiry' => $this->input->post('expiry'),
            'password' => $generatedpassword,
            //'wintime' => $WIN,
            //'unixtime' => $UNIX,
            'status' => 0);

        return $this->db->insert('temporary_account', $data);
    }

    public function get_next_temp() {
        $query = $this->db->query("SELECT id FROM temporary_account ORDER BY id DESC LIMIT 1;");
        foreach ($query->result() as $row) {
            return $row->id + 1;
        }
    }

    function get_faculty() {
        $this->db->from('faculty');
        $this->db->order_by('faculty');
        $result = $this->db->get();
        $return = array();
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $return[$row['cat_id']] = $row['faculty'];
            }
        }

        return $return;
    }

    function get_department() {
        if (!isset($_GET['cat'])) {
            $_GET['cat'] = '1';
        }
        $result = $this->db->get_where('facultysub', array('cat_id' => $_GET['cat']));
        $return = array();
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $return[$row['cat_key']] = $row['subfaculty'];
            }
        }

        return $return;
    }
    
    public function get_pending() {
        $this->db->where('status', '0');
        $query = $this->db->get('temporary_account');
        return $query->result_array();
    }
    
    public function get_all() {
        $query = $this->db->get('temporary_account');
        return $query->result_array();
    }
    
    public function check_status() {
        $this->db->where('logged', $_SESSION['ldap']['full_name'])->or_where('requester', $_SESSION['ldap']['full_name']);
        $query = $this->db->get('temporary_account');
        return $query->result_array();
    }
    
    public function match_id_user($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('temporary_account');
        return $query->result_array();
    }
    
    public function cancel($id) {
            
        $this->db->where('id', $id);
	$this->db->from('temporary_account');
        $data = array(
            'status' => '3',
        );
        return $this->db->update('temporary_account', $data);
    }
    
    public function reject($id) {
            
        $this->db->where('id', $id);
	$this->db->from('temporary_account');
        $data = array(
            'status' => '2',
            'status_at' => date("Y-m-d H:i:s", time()),
            'status_by' => $_SESSION['ldap']['full_name'],
        );
        return $this->db->update('temporary_account', $data);
    }
    
    public function approve($id) {
            
        $this->db->where('id', $id);
	$this->db->from('temporary_account');
        $data = array(
            'status' => '1',
            'status_at' => date("Y-m-d H:i:s", time()),
            'status_by' => $_SESSION['ldap']['full_name'],
        );
        
        return $this->db->update('temporary_account', $data);
    }
    
    public function created_account($id) {
            
        $this->db->where('id', $id);
	$this->db->from('temporary_account');
        $data = array(
            'created' => '1',
        );
        return $this->db->update('temporary_account', $data);
    }
    
    public function get_account($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('temporary_account');
        return $query->result_array();
    }
}