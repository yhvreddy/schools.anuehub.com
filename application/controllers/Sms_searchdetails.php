<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Dashboard extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
        $data['userdata'] = $this->Model_integrate->userdata();
    }
    //admin and superadmin sections
    //Homepage for all users..
    public function index($externaldata = NULL){
        extract($_REQUEST);
        if(isset($this->session->userdata)){
            //$this->printr($this->session->userdata);
            $details    =   $this->session->userdata;   // all session data will send to setdetails..
            $school_id  =   $details['school']->school_id;
            $branch_id  =   $details['school']->branch_id;
            $school_academic = $details['school']->school_academic;
            $school_academic_form_to    =   $details['school']->school_academic_form_to; 
            $data['userdata'] = $this->Model_integrate->userdata();
//            $this->print_r($data['userdata']);
//            exit;
            if($school_academic != 0 && $school_academic_form_to != ''){
                $data['PageTitle'] = 'Welcome Dashboard';
                $this->loadViews('dashboard_page', $data);
            }else{
                redirect('setup/academicdetails');
            }  
        }else{
            redirect(base_url());
        }
    }
    
    public function welcomepage(){
        $data['details']    =   $this->session->userdata;
        $data['PageTitle']  = 'Welcome Dashboard';
        $data['userdata'] = $this->Model_integrate->userdata();
        $this->load->view('welcomepage',$data);
    }

    
    //defaut ajax data for all usefull forms or pages..
    public function stateslist(){
        extract($_REQUEST);
        $statelist = $this->Model_default->selectdata('sms_states',array("country_id"=>$Countryid,'status'=>1));
        $data = $statelist;
        echo json_encode($data);
    }

    public function citieslist(){
        extract($_REQUEST);
        $citylist = $this->Model_default->selectdata('sms_cities',array('state_id'=>$Stateid,'status'=>1));
        $data = $citylist;
        echo json_encode($data);
    }
}
