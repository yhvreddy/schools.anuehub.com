<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_front_office extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }
    
    //front office seup
    public function setupfrontoffice(){
        $schooldata = $this->session->userdata['school'];
        $data['PageTitle'] = "Front office setup..!";
        $schoolid   = $schooldata->school_id;
        $branchid   = $schooldata->branch_id;
        $data['visiters'] = $this->Model_dashboard->selectdata('sms_frontoffice_types',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'type'=>'visiters'));
        $data['userdata'] = $this->Model_integrate->userdata();
        $this->loadViews('admin/front_office/sms_frontofficesetup',$data);
    }

    public function visiterSetup(){
        extract($_REQUEST);
        //$this->print_r($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $data['PageTitle'] = "Front office setup..!";
        $schoolid   = $schooldata->school_id;
        $branchid   = $schooldata->branch_id;
        $visiters = $this->Model_dashboard->selectdata('sms_frontoffice_types',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'name'=>ucwords($visiterperposetype)));
        if(count($visiters) != 0){
            $this->session->set_flashdata('error', 'Already Exits..!');
            redirect(base_url('dashboard/setupfrontoffice'));
        }else{
            $savedata = array(
                'school_id' =>  $schoolid,
                'branch_id' =>  $branchid,
                'name'      =>  $visiterperposetype,
                'note'      =>  $visiterperposenote,
                'type'      =>  'visiters',
                'updated'   =>  date('Y-m-d H:i:s'),
            );
            $eNote = $this->Model_dashboard->insertdata('sms_frontoffice_types',$savedata);
            if($eNote != 0){
                $this->session->set_flashdata('success', 'Successfully saved..!');
                redirect(base_url('dashboard/setupfrontoffice'));
            }else{
                $this->session->set_flashdata('error', 'Failed to saved..!');
                redirect(base_url('dashboard/setupfrontoffice'));
            }
        }
    }

    public function visiterEditSetup(){
        extract($_REQUEST);
        //$this->print_r($_REQUEST);
        $sno = $this->uri->segment(4);
        if(isset($sno) && !empty($sno)){
            $conduction = array('sno'=>$sno,'type'=>'visiters');
            $savedata = array(
                'name'      =>  $visiterperposetype,
                'note'      =>  $visiterperposenote,
                'updated'   =>  date('Y-m-d H:i:s'),
            );
            $visiteredit = $this->Model_dashboard->updatedata($savedata,$conduction,'sms_frontoffice_types');
            if($visiteredit != 0){
                $this->session->set_flashdata('success', 'Successfully saved..!');
                redirect(base_url('dashboard/setupfrontoffice'));
            }else{
                $this->session->set_flashdata('error', 'Failed to saved..!');
                redirect(base_url('dashboard/setupfrontoffice'));
            }
        }else{
            $this->session->set_flashdata('error', 'Invalid Request to edit..!');
            redirect(base_url('dashboard/setupfrontoffice'));
        }
    }                    

    //front office visiters
    public function visiters(){
        $schooldata = $this->session->userdata['school'];
        $data['PageTitle'] = "Front office setup..!";
        $schoolid   = $schooldata->school_id;
        $branchid   = $schooldata->branch_id;
        $data['visiters'] = $this->Model_dashboard->selectdata('sms_frontoffice_types',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'type'=>'visiters'));
        $data['visitersdata'] = $this->Model_dashboard->selectdata('sms_visiters_data',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'updated');
        $data['userdata'] = $this->Model_integrate->userdata();
        $this->loadViews('admin/front_office/sms_frontoffice_visiters',$data);
    }

    //save visiters data
    public function visitersDataSave(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $schoolid   = $schooldata->school_id;
        $branchid   = $schooldata->branch_id;
        $this->print_r($_REQUEST);
        //country code
        if(isset($full_phone)){
            $full_phone = explode($mobile,$full_phone);
            $country_code  = $full_phone[0];
            if($country_code != '+undefined'){
                $country_code = $country_code;
            }else{
                $country_code = '';
            }
        }else{ $country_code = ''; }


        if(!empty($outtme)){
			$outtme = date('H:i',strtotime($outtme));
		}else{
			$outtme = '';
		}

		if(!empty($intme)){
			$intme = date('H:i',strtotime($intme));
		}else{
			$intme = '';
		}


        $insertdata =   array(
            'branch_id' =>  $branchid,
            'school_id' =>  $schoolid,
            'name'      =>  $visitername,
            'purpose'   =>  $perposetype,
            'visiting_data' =>  date('Y-d-m',strtotime($visitingdate)),
            'mobile'        =>  $mobile,
            'country_code'  =>  $country_code,
            'note'          =>  $note,
            'intime'        =>  $intme,
            'outtime'       =>  $outtme,
            'referral_id'   =>  $referralid,
            'nopersons'     =>  $numofpersons,
            'updated'       => date('Y-m-d H:i:s')
        );
        $visiters = $this->Model_dashboard->insertdata('sms_visiters_data',$insertdata);
        if($visiters != 0){
            $this->session->set_flashdata('success', 'Successfully saved..!');
            redirect(base_url('dashboard/frontoffice/visiters'));
        }else{
            $this->session->set_flashdata('error', 'Failed to saved..!');
            redirect(base_url('dashboard/frontoffice/visiters'));
        }
    }

    //update visiters data
    public function visitersDataEdit(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $schoolid   = $schooldata->school_id;
        $branchid   = $schooldata->branch_id;
        $sno = $this->uri->segment(5);
        if(!empty($outtme)) {
			$outtime = date('H:i', strtotime($outtme));
		}else{
			$outtime = '';
		}

		if(!empty($intme)) {
			$intime = date('H:i', strtotime($intme));
		}else{
			$intime = '';
		}
		
        if(isset($sno) && !empty($sno)) {
            $conduction = array(
                'branch_id' => $branchid,
                'school_id' => $schoolid,
                'sno' => $sno
            );
            $insertdata = array(
                'name' => $visitername,
                'purpose' => $perposetype,
                'visiting_data' => date('Y-d-m', strtotime($visitingdate)),
                'mobile' => $mobile,
                'note' => $note,
                'intime' => $intime,
                'outtime' => $outtime,
                'referral_id' => $referralid,
                'nopersons' => $numofpersons,
                'updated' => date('Y-m-d H:i:s')
            );
            $visiters = $visiteredit = $this->Model_dashboard->updatedata($insertdata, $conduction, 'sms_visiters_data');
            if ($visiters != 0) {
                $this->session->set_flashdata('success', 'Successfully saved..!');
                redirect(base_url('dashboard/frontoffice/visiters'));
            } else {
                $this->session->set_flashdata('error', 'Failed to saved..!');
                redirect(base_url('dashboard/frontoffice/visiters'));
            }
        }else{
            $this->session->set_flashdata('error', 'Invalid Request..!');
            redirect(base_url('dashboard/frontoffice/visiters'));
        }
    }

    //delete visters data temp
    public function visiterDataDelete(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $schoolid   = $schooldata->school_id;
        $branchid   = $schooldata->branch_id;
        $sno = $this->uri->segment(5);
        if(isset($sno) && !empty($sno)) {
            $conduction = array(
                'branch_id' => $branchid,
                'school_id' => $schoolid,
                'sno' => $sno
            );
            $insertdata = array(
                'status'    =>  0,
                'updated' => date('Y-m-d H:i:s')
            );
            $visiters = $visiteredit = $this->Model_dashboard->updatedata($insertdata, $conduction, 'sms_visiters_data');
            if ($visiters != 0) {
                $this->session->set_flashdata('success', 'Successfully Deleted..!');
                redirect(base_url('dashboard/frontoffice/visiters'));
            } else {
                $this->session->set_flashdata('error', 'Failed to Delete..!');
                redirect(base_url('dashboard/frontoffice/visiters'));
            }
        }else{
            $this->session->set_flashdata('error', 'Invalid Request..!');
            redirect(base_url('dashboard/frontoffice/visiters'));
        }
    }

    //visiter timeout
    public function visitertimeout(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $schoolid   = $schooldata->school_id;
        $branchid   = $schooldata->branch_id;
        $sno = $this->uri->segment(5);
        $tmno = $this->uri->segment(6);

		if(!empty($outtme)) {
			$outtime = date('H:i', strtotime($outtme));
		}else{
			$outtime = date('Y-m-d H:i:s');
		}

		if(!empty($intme)) {
			$intime = date('H:i', strtotime($intme));
		}else{
			$intime = '';
		}

        if(isset($sno) && isset($tmno)) {
            $conduction = array(
                'branch_id' => $branchid,
                'school_id' => $schoolid,
                'sno' => $sno
            );
            $insertdata = array(
                'status'    =>  1,
                'inout'     =>  0,
				'outtime' 	=> $outtime,
                'updated' 	=> date('Y-m-d H:i:s')
            );
            $visiters = $visiteredit = $this->Model_dashboard->updatedata($insertdata, $conduction, 'sms_visiters_data');
            if ($visiters != 0) {
                $this->session->set_flashdata('success', 'Successfully Saved time out..!');
                redirect(base_url('dashboard/frontoffice/visiters'));
            } else {
                $this->session->set_flashdata('error', 'Failed to Save Time Out..!');
                redirect(base_url('dashboard/frontoffice/visiters'));
            }
        }else{
            $this->session->set_flashdata('error', 'Invalid Request..!');
            redirect(base_url('dashboard/frontoffice/visiters'));
        }
    }

}
