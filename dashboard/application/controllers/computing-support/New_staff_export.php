<?php defined('BASEPATH') OR exit('No direct script access allowed');

class New_staff_export extends My_Public {

    public function __construct() {
        parent::__construct();
        $this->load->helper('download');
        $this->load->model('computing-support/New_account_model', 'new_account_model');
        
    }
    
    // URLs for both funtions locked using htpasswd in Apache config.
    // Script on SAD02-46 accesses these using the htpasswd account.
    // Used to download new staff csv and complete staff after creation.
    
    // This controller must be PUBLIC
    
    // If changed are made, duplicate in New_account.php controller.
     
    function index() {
        
            $function = 'SAD-02_export_staff_accounts';
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
        
    }

    public function complete() {
        
            $function = 'SAD-02_complete_staff_accounts';
            $this->user_model->function_log($function);
        
            $this->new_account_model->complete_account();

            $this->load->view('templates/header');
            $this->load->view('computing-support/new-account/complete');
            $this->load->view('templates/footer');
    }
}