<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends My_Public {
    
    // Each function is run using cron.
    
    public function __construct() {
	parent::__construct();
        $this->load->model('core/Jobs_model', 'jobs_model');
    }
    
    public function ad_users_sync() {

        $this->jobs_model->update_active_ad_users();
        $this->load->view('templates/job');
        
        $function = 'AD_users_sync_SUCESSFUL';
        $this->user_model->function_log($function);
    }
} // END controller
