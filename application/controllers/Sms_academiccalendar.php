<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_academiccalendar extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
		$this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }
    
    //enote for superadmin or admin only to save guide for like prof
    public function index($externaldata = NULL){
        $this->academiccalendar();
    }
    
    //eNote for admin and superadmin
    public function academiccalendar(){
        $data['PageTitle'] = "Academic Calendar & events";
        $data['userdata'] = $this->Model_integrate->userdata();
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        //sending syllabus data to views and getting class data by ajax
        $data['syllabus'] = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
        $data['schooldata'] = $schooldata;

        $data['events']   =  $this->Model_dashboard->selectdata('sms_events',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1));
		$data['notices'] = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'sno');
		$data['admissions'] = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'sno');
		$data['employees'] = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'sno');
        $this->loadViews('admin/sms_academiccalendar_page',$data);
    }

    //calendar addEvent
    public function calendaraddEvent(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $regid      =   $this->session->userdata['regid'];
        $schoolid   = $schooldata->school_id;
        $branchid   = $schooldata->branch_id;
        //event id
        $schoolname =  $schooldata->schoolname;
        $scl = $this->Model_integrate->initials($schoolname).date('y').date('m').date('d').'E0';
        $rnd = $this->Model_integrate->generateRandom(0,99);
        $evntid = $scl.$rnd;
        $saveevent = array('school_id'=>$schoolid,'branch_id'=>$branchid,'id_num'=>$evntid,'title'=>$title,'start'=>$start,'end'=>$end,'color'=>$color,'contant'=>$eventdescription);
        $enquiry = $this->Model_default->insertdata('sms_events',$saveevent);
        if($enquiry != 0){
        	$this->successalert('Successfully saved the event..!',$title.' event as successfully saved..!');
            redirect(base_url('dashboard/academiccalendar'));
        }else{
			$this->failedalert('Failed to save the event..!',$title.' event as failed to save..!');
        	redirect(base_url('dashboard/academiccalendar'));
        }
    }

    //calendar edit Event
    public function calendareditEvent(){
        extract($_REQUEST);
        //$this->print_r($_REQUEST);
        //exit;
        $schooldata = $this->session->userdata['school'];
        $regid      =   $this->session->userdata['regid'];
        $schoolid   = $schooldata->school_id;
        $branchid   = $schooldata->branch_id;
        $conduction = array('school_id'=>$schoolid,'branch_id'=>$branchid,'sno'=>$id);
        if(isset($delete) && $delete == 'yes'){
            $saveevent = array('status'=>0);
            $enquiry = $this->Model_default->updatedata('sms_events', $saveevent, $conduction);
			if($enquiry != 0){
				$this->successalert('Successfully deleted the event..!',$title.' event as successfully deleted..!');
				redirect(base_url('dashboard/academiccalendar'));
			}else{
				$this->failedalert('Failed to delete the event..!',$title.' event as failed to delete..!');
				redirect(base_url('dashboard/academiccalendar'));
			}
        }else{
            $saveevent = array('title'=>$title,'color'=>$color,'contant'=>$eventdescription);
            $enquiry = $this->Model_default->updatedata('sms_events', $saveevent, $conduction);
			if($enquiry != 0){
				$this->successalert('Successfully update the event..!',$title.' event as successfully updated..!');
				redirect(base_url('dashboard/academiccalendar'));
			}else{
				$this->failedalert('Failed to save the update..!',$title.' event as failed to update..!');
				redirect(base_url('dashboard/academiccalendar'));
			}
        }
    }

    //change event date
    public function changeEventdates(){
        extract($_REQUEST);
        //$this->print_r($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $schoolid   = $schooldata->school_id;
        $branchid   = $schooldata->branch_id;
        $id     = $Event[0];
        $start  = $Event[1];
        $end    = $Event[2];
        $conduction = array('school_id'=>$schoolid,'branch_id'=>$branchid,'sno'=>$id);
        $saveevent = array('start'=>$start,'end'=>$end);
        $enquiry = $this->Model_default->updatedata('sms_events', $saveevent, $conduction);
        if($enquiry != 0) {
            $json = array("key" => 1,"msg" => "Successfully saved Changes");
        }else{
            $json = array("key" => 1,"msg" => "Failed to save Changes");
        }
        header('content-type: application/json');
        echo json_encode($json);
    }

    //savenewenote
    public function savenewenote(){
        extract($_REQUEST);
        //getting school data in session
        $schooldata = $this->session->userdata['school'];

        if(empty($eNoteDate) || empty($eNoteStudentName) || empty($eNoteParentName) || empty($eNoteSyllubas) || empty($eNoteClasses) || empty($eNoteEmail) || empty($eNoteMobile) || empty($eNoteContent)){
            $this->session->set_flashdata('error', 'Plase fill all required fields..!');
            redirect(base_url('dashboard/enote'));
        }else{
            $eNotedata = array(
                'school_id'     =>  $schooldata->school_id,
                'branch_id'     =>  $schooldata->branch_id,
                'enotedate'     =>  $eNoteDate,
                'studentname'   =>  $eNoteStudentName,
                'parentname'    =>  $eNoteParentName,
                'class'         =>  $eNoteClasses,
                'scl_types'     =>  $eNoteSyllubas,
                'email'         =>  $eNoteEmail,
                'mobile'        =>  $eNoteMobile,
                'enote'         =>  $eNoteContent,
            );

            $eNote = $this->Model_dashboard->insertdata('sms_enote',$eNotedata);
			if($eNote != 0){
				$this->successalert('Successfully saved the enote..!','eNote as successfully saved..!');
				redirect(base_url('dashboard/enote'));
			}else{
				$this->failedalert('Failed to save the eNote..!',' eNote as failed to update..!');
				redirect(base_url('dashboard/enote'));
			}
        }
    }
    
}
