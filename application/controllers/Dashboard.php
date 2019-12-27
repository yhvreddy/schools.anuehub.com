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
        $this->userdata = $this->Model_integrate->userdata();
    }
    //admin and superadmin sections
    //Homepage for all users..
    public function index($externaldata = NULL){
        extract($_REQUEST);
       
        if(isset($this->session->userdata)){
            //$this->printr($this->session->userdata);
            $details    =   $this->session->userdata;   // all session data will send to setdetails..
            $school_id = $data['school_id'] =   $details['school']->school_id;
            $branch_id = $data['branch_id'] =   $details['school']->branch_id;
            $school_academic = $details['school']->school_academic;
            $school_academic_form_to    =   $details['school']->school_academic_form_to; 
            $userdata = $this->userdata;
			$data['events']   =  $this->Model_dashboard->selectdata('sms_events',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));
			$data['notices'] = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1),'sno');
			$data['admissions'] = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1),'sno');
			$data['employees'] = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1),'sno');
			if(isset($userdata->reg_id)){
				$send_from = $userdata->local_mail_id;
			}else{
				$send_from = $userdata->local_mail_id;
			}
			//$this->print_r($send_from);
			//exit;
            
			$data['mailsents'] = $this->Model_dashboard->customquery("SELECT * FROM `sms_mail_box` INNER JOIN  `sms_mail_reports` ON sms_mail_reports.id = sms_mail_box.mail_ids AND sms_mail_reports.mail_id = sms_mail_box.mail_id WHERE sms_mail_box.school_id = '$school_id' AND sms_mail_box.branch_id = '$branch_id' AND sms_mail_box.sent_to = '$send_from' AND sms_mail_box.inbox_status = 1 AND sms_mail_box.trash_status = 0 AND sms_mail_box.important_status = 0 AND sms_mail_box.label_status = 0 AND sms_mail_box.status = 1 ORDER BY sms_mail_box.id DESC LIMIT 5");
			//$this->print_r($data['mailsents']);
			//exit;
            if($school_academic != 0 && $school_academic_form_to != ''){
                $data['userdata']  = $this->userdata;
                $data['PageTitle'] = 'Welcome '.$details['school']->schoolname;
                $this->loadViews('dashboard', $data);
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



    //trails for demo
	public function mailtemplatedemo(){
    	$data['mail_title'] = 'Demo for template';
		$data['requesturl'] = '';
    	$this->load->view('email/mail_viewtest',$data);
	}
}
