<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_searchdata extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
        $data['userdata'] = $this->Model_integrate->userdata();
    }

    //only for super-admin
    public function SearchResult(){
    	extract($_REQUEST);
        $data['PageTitle'] = "Search Result..!";
        $data['userdata'] = $this->Model_integrate->userdata();
		$schooldata = $this->session->userdata['school'];
		$data['school_id'] = $schoolid = $schooldata->school_id;
		$data['branch_id'] = $branchid = $schooldata->branch_id;
        $data['searchdata'] = $_REQUEST;
        $this->loadViews('admin/search/sms_searchresult_page',$data);
    }
    
}
