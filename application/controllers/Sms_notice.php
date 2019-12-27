<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_notice extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }
    
    //Add new notice
    public function index(){
        $this->addNotice();
    }
    
    //Add new notice
    public function addNotice(){
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "New Notice..!";
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $this->loadViews('admin/noticeboard/notice_add',$data);
    }

    //save new notice data
    public function savenotice(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        //event id
        $schoolname =  $schooldata->schoolname;
		$noticeslist = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id));
		$countlist = count($noticeslist) + 1;
		$letters =  random_string('alpha', 1);
		$alfnums =  random_string('alnum', 1);
		$studentname = strtoupper($letters).' '.strtoupper($alfnums);
		$noticeid   = $this->manualgenerate_id($schoolname,date('y'),$studentname,$countlist);

        $noticeto = implode(',',$noticeto);
        //$this->print_r($noticeto);
        //exit;
        $noticesdir = $this->createdir('./uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $noticeid,'./uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $noticeid.'');
        //image upload
        if($_FILES['noticeupload']['name'] != '') {
            $parentimage = $this->uploadfiles('./uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $noticeid, 'noticeupload', '*', FALSE, '', '');
            $noticeimage = 'uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $noticeid . '/' . $parentimage['uploaddata']['file_name'];
        }else{ $noticeimage = '';}

        $noticesotherfilesdir = $this->createdir('./uploads/notice_files/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $noticeid,'./uploads/notice_files/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $noticeid);
        //multi files

		if($_FILES['noticeOtheruploads']['name'][0] != ''){
			$noticefiles = $this->multiuploadfiles('uploads/notice_files/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num.'/','noticeOtheruploads','*',FALSE,'','');
			$noticefiles = $noticefiles['uploaddata'];
		}else{  $noticefiles = ''; };


        if(date('Y-m-d',strtotime($noticepublishdate)) < date('Y-m-d')){
            $publish_status = 1;
        }else{
            $publish_status = 2;
        }

        $insertdata = array(
            'branch_id'     =>  $schooldata->branch_id,
            'school_id'     =>  $schooldata->school_id,
            'id_num'        =>  $noticeid,
            'notice_title'  =>  $noticetitle,
            'notice_type'   =>  'info',
            'notice_img'    =>  $noticeimage,
            'notice_files'  =>  $noticefiles,
            'notice_content'=>  $noticecontent,
            'notice_to'     =>  $noticeto,
            'publish_status'=>  $publish_status,
            'notice_date'   =>  date('Y-m-d',strtotime($noticedate)),
            'notice_publish'=>  date('Y-m-d',strtotime($noticepublishdate)),
            'updated'       =>  date('Y-m-d H:i:s')
        );

        $notice = $this->Model_dashboard->insertdata('sms_notice',$insertdata);
        if($notice != 0){
        	$this->successalert('Successfully placed on notice board..','You have placed notice '.$noticetitle);
            redirect(base_url('dashboard/notice/noticelist'));
        }else{
			$this->successalert('Failed to placed on notice board..','Failed to placed notice '.$noticetitle);
            redirect(base_url('dashboard/notice/addnotice'));
        }
    }

    //display list of notices
    public function noticeList(){
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "Notice List..!";
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $data['noticelist'] = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'updated');
        $data['schooldata'] = $schooldata;
        $this->loadViews('admin/noticeboard/notice_list',$data);
    }

    //delete notice record
    public function deletenotice(){
        $schooldata = $this->session->userdata['school'];
        $sno = $this->uri->segment(4);
        $schoolid   = $schooldata->school_id;
        $branchid   = $schooldata->branch_id;
        if(isset($sno) && !empty($sno)){
            $conduction = array(
                'branch_id' => $branchid,
                'school_id' => $schoolid,
                'sno' => $sno
            );
            $insertdata = array(
                'status'        =>  0,
                'publish_status'=>  0,
                'updated' => date('Y-m-d H:i:s')
            );
            $visiters = $visiteredit = $this->Model_dashboard->updatedata($insertdata, $conduction,'sms_notice');
            if ($visiters != 0) {
            	$this->successalert('Successfully delete notice..!','Notice as deleted successfully..!');
                redirect(base_url('dashboard/notice/noticelist'));
            } else {
				$this->failedalert('Failed to delete notice..!','Notice as failed to deleted..!');
                redirect(base_url('dashboard/notice/noticelist'));
            }
        }else{
			$this->failedalert('Invalid request to delete notice..!','Notice as not deleted or invalid request..!');
            redirect(base_url('dashboard/notice/noticelist'));
        }
    }

    //edit notice record
    public function editNotice(){
        $schooldata = $this->session->userdata['school'];
        $sno  = $this->uri->segment(4);
        $edit = $this->uri->segment(5);
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['noticelist'] = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'sno'=>$sno,'id_num'=>$edit),'updated');
        $data['PageTitle'] = "Edit Notice : ".$data['noticelist'][0]->id_num;
        $this->loadViews('admin/noticeboard/notice_edit',$data);
    }

    //save notice record
    public function saveEditNotice(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        //$this->print_r($_REQUEST);
        //$this->print_r($_FILES);

        $schoolid   = $schooldata->school_id;
        $branchid   = $schooldata->branch_id;
        if(isset($sno) && !empty($sno) && isset($id_num) && !empty($id_num)){
            $data = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'sno'=>$sno,'id_num'=>$id_num),'updated');
            if(count($data) != 0) {
                $noticeto = implode(',',$noticeto);
                $noticesdir = $this->createdir('./uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num,'./uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num.'');
                
                //image upload
                if($_FILES['noticeupload']['name'] != '') {
                    $parentimage = $this->uploadfiles('./uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num, 'noticeupload', '*', FALSE, '', '');
                    $noticeimage = 'uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num . '/' . $parentimage['uploaddata']['file_name'];
                }else{ $noticeimage = $UplaodedNoticeImage; }

                $noticesotherfilesdir = $this->createdir('./uploads/notice_files/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num,'./uploads/notice_files/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num);

                //multi files
                if($_FILES['noticeOtheruploads']['name'][0] != ''){
                	//echo "++++++++++++++";
                    $noticefiles = $this->multiuploadfiles('uploads/notice_files/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num.'/','noticeOtheruploads','*',FALSE,'','');
                    $noticefiles = $noticefiles['uploaddata'];
                    $this->print_r($noticefiles);
                }else{ $noticefiles = $UplaodedNoticeOtherFiles; }

                if(date('Y-m-d',strtotime($noticepublishdate)) < date('Y-m-d')){
                    $publish_status = 1;
                }else{
                    $publish_status = 2;
                }

                $insertdata = array(
                    'notice_title'  =>  $noticetitle,
                    'notice_type'   =>  'info',
                    'notice_img'    =>  $noticeimage,
                    'notice_files'  =>  $noticefiles,
                    'notice_content'=>  $noticecontent,
                    'notice_to'     =>  $noticeto,
                    'publish_status'=>  $publish_status,
                    'notice_date'   =>  date('Y-m-d',strtotime($noticedate)),
                    'notice_publish'=>  date('Y-m-d',strtotime($noticepublishdate)),
                    'updated'       =>  date('Y-m-d H:i:s')
                );

                $conduction = array(
                    'branch_id' => $branchid,
                    'school_id' => $schoolid,
                    'sno'       => $sno,
                    'id_num'    => $id_num,
                );

                $noticeedit = $this->Model_dashboard->updatedata($insertdata, $conduction, 'sms_notice');
				if($noticeedit != 0){
					$this->successalert('Successfully updated notice board..','You have updated notice '.$noticetitle);
					redirect(base_url('dashboard/notice/noticelist'));
				}else{
					$this->failedalert('Failed to updated on notice board..','Failed to updated notice '.$noticetitle);
					redirect(base_url('dashboard/notice/addnotice'));
				}
            }else{
				$this->failedalert('Failed to updated on notice board..','Notice Not Found or Invalid Request to update..!');
                redirect(base_url('dashboard/notice/noticelist'));
            }
        }else{
			$this->failedalert('Invalid to updated on notice board..','Notice Not Found or Invalid Request to update..!');
            redirect(base_url('dashboard/notice/noticelist'));
        }
    }

    //display details of notice
    public function Noticedetails(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $data['schoolid']   = $schooldata->school_id;
        $data['branchid']   = $schooldata->branch_id;
        $sno  = $this->uri->segment(3);
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['noticelist'] = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'sno'=>$sno),'updated');
        $data['PageTitle'] = "Notice : ".$data['noticelist'][0]->notice_title;
        $this->loadViews('admin/noticeboard/notice_details',$data);
    }
}
