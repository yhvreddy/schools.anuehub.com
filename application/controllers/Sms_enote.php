<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_enote extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }
    
    //enote for superadmin or admin only to save guide for like prof
    public function index($externaldata = NULL){
        $this->enote();
    }
    
    //eNote for admin and superadmin
    public function enote(){
        if($this->uri->segment(3) !=''){
            extract($_REQUEST);
            //print_r($_REQUEST);
            if(!empty($schoolmail) && !empty($parentmail)){
                //getting school data in session
                $schooldata = $this->session->userdata['school'];
                //sending syllabus data to views and getting class data by ajax
                $eNotelist = $this->Model_dashboard->selectdata('sms_enote',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'id'=>$regeNote),'id');
                //mail function
                // $maildata['maildata'] = $$eNotelist['0'];
                // $maildata['mailtitle'] = 'Conformation Mail';
                // $this->sendemail('email/mail_conformregister',$maildata,'info@anuehub.online',$mailid,'Conformation Mail form anuehub.');
            }else{
                $this->session->set_flashdata('error', 'Sender Mail_id Should Not Empty');
                redirect(base_url('dashboard/enote'));   
            }
        }else{
            $data['userdata'] = $this->Model_integrate->userdata();
            $data['PageTitle'] = "eNote for enquiry..!";
            //getting school data in session
            $schooldata = $this->session->userdata['school'];
            //sending syllabus data to views and getting class data by ajax
            $data['syllabus'] = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
            $data['eNotelist'] = $this->Model_dashboard->selectdata('sms_enote',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'id');
            $data['schooldata'] = $schooldata;
            $this->loadViews('admin/front_office/sms_enotebook_page',$data);
        }
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
                'enotedate'     =>  date('Y-m-d',strtotime($eNoteDate)),
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
                // $maildata['maildata'] = $eNotedata;
                // $maildata['mailtitle'] = 'Conformation Mail';
                // $this->sendemail('email/mail_conformregister',$maildata,'info@anuehub.online',$mailid,'Conformation Mail form anuehub.');
                $this->session->set_flashdata('success', 'Successfully save eNote..!');
                redirect(base_url('dashboard/enote'));
            }else{
                $this->session->set_flashdata('error', 'Failed to save eNote..!');
                redirect(base_url('dashboard/enote'));
            }
        }
    }
}
