<?php defined('BASEPATH') OR exit('No direct script access allowed');

class New_account_model extends CI_Model {

    public function __construct() {
        $this->load->model('computing-support/New_account_model', 'new_account_model');
    }

    public function create($first_name, $last_name, $ern, $position, $faculty, $department, $room, $ext, $con_start, $con_end, $password, $site) {

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



        $this->email->from('noreply@cant-col.ac.uk', 'New Staff Account');
        $this->email->to($_SESSION['ldap']['email']);
        $this->email->subject('New Staff Account');
        $this->email->message('A new staff account has been requested by yourself
                      
        Account Details:
        Name: ' . $this->input->post('first_name') . ' ' . $this->input->post('last_name') . '
        Position: ' . $this->input->post('position') . '
        ERN: ' . $this->input->post('ern') . '
        Faculty: ' . $this->input->post('faculty') . '
        Department: ' . $this->input->post('department') . '
        Room: ' . $this->input->post('room') . '
        Phone: ' . $this->input->post('ext') . '
        Site: ' . $this->input->post('site') . '
                           
        Username: ' . $builtUsername . '
        Password: ' . $this->input->post('password') . '


        If this account was made by mistake please contact Computing Support.
        If you notice a mistake please edit it below.
        https://intranet.cant-col.ac.uk/dashboard/computing-support/new-account/history');
        $this->email->send();


        $this->db->where('cat_id', $this->input->post('faculty'));
        $faculty_query = $this->db->get('faculty')->result_array();

        $this->db->where('cat_key', $this->input->post('department'));
        $department_query = $this->db->get('facultysub')->result_array();
        
        $this->db->where('cat_key', $this->input->post('department'));
        $costarea_query = $this->db->get('facultysub')->result_array();

        $data = array(
            'logged' => $_SESSION['username'],
            'created' => date("Y-m-d H:i:s", time()),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'username' => $builtUsername,
            'ern' => $this->input->post('ern'),
            'position' => $this->input->post('position'),
            'faculty' => $faculty_query[0]['faculty'],
            'department' => $department_query[0]['subfaculty'],
            'room' => $this->input->post('room'),
            'ext' => $this->input->post('ext'),
            'con_start' => $this->input->post('con_start'),
            'con_end' => $this->input->post('con_end'),
            'password' => $this->input->post('password'),
            'site' => $this->input->post('site'),
            'costarea' => $costarea_query[0]['costarea'],
            'complete' => NULL
        );

        return $this->db->insert('new_account', $data);
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

    public function complete_account() {

        $data = array(
            'complete' => date("Y-m-d H:i:s", time())
        );
        $this->db->where('complete', null, true);
        return $this->db->update('new_account', $data);
    }

    public function disable($full_name, $last) {
        
        $data = array(
            'logged' => $_SESSION['username'],
            'requested' => date("Y-m-d H:i:s", time()),
            'full_name' => $full_name,
            'last' => $last,
        );

        return $this->db->insert('disable_account', $data);
    }

}
