<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_enquiry extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
        $this->isLoggedIn();
    }

    public function index($externaldata = NULL){
        $this->enquiry();
    }

    //enquiry list and new
    public function enquiry(){
        $data['PageTitle'] = "New enquiry";
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $schoolid = $data['schoolid'] = $schooldata->school_id;
        $branchid = $data['branchid'] = $schooldata->branch_id;
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['gender'] = $this->Model_default->selectdata('sms_formdata',array('type'=>'gender','status'=>1));
        $data['countries'] = $this->Model_default->selectdata('sms_countries',array('status'=>1));
        //sending syllabus data to views and getting class data by ajax
        $data['eNotelist'] = $this->Model_default->selectdata('sms_enote',array('school_id'=>$schoolid,'branch_id'=>$branchid,'status'=>1),'id');
        $data['schooldata'] = $schooldata;
        $data['syllabus'] = $this->Model_default->syllabustypes($schoolid,$branchid);
        $data['enquirydata'] = $this->Model_default->selectdata('sms_enquiry',array('school_id'=>$schoolid,'branch_id'=>$branchid,'status'=>1),'sno DESC');
        $this->loadViews('admin/enquiry/sms_enquiry_page',$data);
    }

    // Enquiry details of student
	public function enquiryDetails(){
    	$id 		= 	$this->uri->segment(4);
    	$branch_id  =	$this->uri->segment(5);
		$school_id  =	$this->uri->segment(6);
		$data['userdata'] = $this->Model_integrate->userdata();
		if(isset($id) && !empty($id) && isset($branch_id) && !empty($branch_id) && isset($school_id) && !empty($school_id)) {
			$data['PageTitle'] = "Enquiry details of ";
			$enquirydetails = $this->Model_default->selectdata('sms_enquiry', array('school_id' => $school_id, 'branch_id' => $branch_id, 'status' => 1, 'sno' => $id), 'sno DESC');
			if(count($enquirydetails) != 0){
				$data['enquirydetails'] = $enquirydetails;
				$this->loadViews('admin/enquiry/sms_enquirydetails_page',$data);
			}else{
				$this->failedalert('Invalid request of enquiry details..!','Your request to display details of enquiry not found..!');
				redirect(base_url('dashboard/enquiry/newenquiry'));
			}

		}else{
			$this->failedalert('Invalid request of enquiry details..!','Your request to display details of enquiry..!');
			redirect(base_url('dashboard/enquiry/newenquiry'));
		}
	}

	//save enquiry details of student
    public function SaveEnquiryDetails($value='')
    {
        //getting school data in session
        extract($_REQUEST);

        $schooldata = $this->session->userdata['school'];
        $schoolid = $schooldata->school_id;
        $branchid = $schooldata->branch_id;
        $reg = $schooldata->reg_id;
		$academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
		$academicbatch = $academicyear[0]->academic_year; //adminssion accadmic batch
		//sms_enquiry students
		$enquiry = $this->Model_dashboard->selectdata('sms_enquiry',array('school_id'=>$schoolid,'branch_id'=>$branchid,'enqueryyear'=>$academicbatch));
		$countlist = count($enquiry) + 1;

        $schoolname  = $schooldata->schoolname;
        $studentname = $StdfName.' '.$StdlName;
        $regid    = $this->manualgenerate_id($schoolname,date('y'),$studentname,$countlist);
        if($StdfName != '' && $StdlName != '' && $StdSyllubas != '' && $StdClass != '' && $StdEmail != '' && $StdMobile != '' && $CountryName != '' && $CityName != '' && $StdAddress != '' && $StdPincode != ''){
            $saveenquiry = array(
                'branch_id' =>  $branchid,
                'school_id' =>  $schoolid,
                'id_num'    =>  $regid,
                'firstname' =>  $StdfName,
                'lastname'  =>  $StdlName,
                'fathername'=>  $StdGName,
                'class_type'=>  $StdSyllubas,
                'class'     =>  $StdClass,
                'gender'    =>  $stdgender,
                'dob'       =>  date('Y-m-d',strtotime($dob)),
                'mail_id'   =>  $StdEmail,
                'mobile'    =>  $StdMobile,
                'country_id'=>  $CountryName,
                'state_id'  =>  $StateName,
                'city_id'   =>  $CityName,
                'address'   =>  $StdAddress,
                'pincode'   =>  $StdPincode,
                //'aadhaar'   =>  $RegAadhaar,
                'enqby'     =>  $reg,
                'ip_address'=>  $this->input->ip_address(),
                'enqueryyear'=> $academicbatch
            );
            $enquiry = $this->Model_default->insertdata('sms_enquiry',$saveenquiry);
            if($enquiry != 0){
            	$this->successalert('Successfully save Details..!','You have successfully saved '.$StdfName.' Details..!');
                redirect(base_url('dashboard/enquiry/newenquiry'));
            }else{
            	$this->failedalert('Failed to save Details..!','You have failed to save '.$StdfName.' Details..!');
                redirect(base_url('dashboard/enquiry/newenquiry'));
            }
        }else{
			$this->failedalert('Please fill all required fileds..!','You have to fill all required details of person..!');
            redirect(base_url('dashboard/enquiry/newenquiry'));
        }
    }

    //delete enqury data of student
    public function deletedata(){
        $one = $this->uri->segment(4);
        $two = $this->uri->segment(5);
        $three = $this->uri->segment(6);

        $check = $this->Model_default->selectdata('sms_enquiry',array('sno'=>$one,'school_id'=>$two,'branch_id'=>$three));
        if(count($check) != 0){
            $enquiry = $this->Model_default->updatedata(array('status'=>0),array('sno'=>$one,'school_id'=>$two,'branch_id'=>$three),'sms_enquiry');
            if($enquiry != 0){
				$this->successalert('Successfully delete all Details..!','You have successfully Delete all details of '.$check[0]->firstname);
                redirect(base_url('dashboard/enquiry/newenquiry'));
            }else{
				$this->failedalert('Failed to delete details..!','You have failed delete details of '.$check[0]->firstname);
                redirect(base_url('dashboard/enquiry/newenquiry'));
            }
        }else{
			$this->failedalert('Failed to delete details..!','Your requested details are not found..!');
            redirect(base_url('dashboard/enquiry/newenquiry'));
        }
    }

    //edit enquery details of student
    public function editdata(){
        $one = $this->uri->segment(4);
        $two = $this->uri->segment(5);
        $three = $this->uri->segment(6);
        $data['userdata'] = $this->Model_integrate->userdata();
        $check = $this->Model_default->selectdata('sms_enquiry',array('sno'=>$one,'school_id'=>$two,'branch_id'=>$three));
        if(count($check) != 0){
            $data['PageTitle'] = "Edit enquiry Details";
            //getting school data in session
            $schooldata = $this->session->userdata['school'];
            $schoolid = $schooldata->school_id;
            $branchid = $schooldata->branch_id;
            $data['gender'] = $this->Model_default->selectdata('sms_formdata',array('type'=>'gender','status'=>1));
            $data['countries'] = $this->Model_default->selectdata('sms_countries',array('status'=>1));
            //sending syllabus data to views and getting class data by ajax
            $data['syllabus'] = $this->Model_default->syllabustypes($schoolid,$branchid);
            $data['schooldata'] = $schooldata;
            $data['classes'] = $this->Model_default->selectdata('sms_class',array('school_id'=>$schoolid,'branch_id'=>$branchid));
            $data['enquirydata'] = $check;
            $this->loadViews('admin/enquiry/sms_enquiryedit_page',$data);
        }else{
            $this->session->set_flashdata('error', 'No Data Found..! Add New enquiry.');
            redirect(base_url('dashboard/enquiry/newenquiry'));
        }
    }

    //save update data of student
    public function saveupdates($value='')
    {
        //getting school data in session
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $schoolid = $schooldata->school_id;
        $branchid = $schooldata->branch_id;
        $reg = $schooldata->reg_id;
        $schoolname  = $schooldata->schoolname;

        if($StdfName != '' && $StdlName != '' && $StdSyllubas != '' && $StdClass != '' && $StdEmail != '' && $StdMobile != '' && $CountryName != '' && $CityName != '' && $StdAddress != '' && $StdPincode != ''){
            $setdata = array(
                'firstname' =>  $StdfName,
                'lastname'  =>  $StdlName,
                'fathername'=>  $StdGName,
                'class_type'=>  $StdSyllubas,
                'class'     =>  $StdClass,
                'gender'    =>  $stdgender,
                'dob'       =>  $dob,
                'mail_id'   =>  $StdEmail,
                'mobile'    =>  $StdMobile,
                'country_id'=>  $CountryName,
                'state_id'  =>  $StateName,
                'city_id'   =>  $CityName,
                'address'   =>  $StdAddress,
                'pincode'   =>  $StdPincode,
                //'aadhaar'   =>  $RegAadhaar,
            );
            $wheredata = array('school_id'=>$schoolid,'branch_id'=>$branchid,'sno'=>$id);
            $enquiry = $this->Model_default->updatedata('sms_enquiry',$setdata,$wheredata);
			if($enquiry != 0){
				$this->successalert('Successfully Update Details..!','You have successfully Updated '.$StdfName.' Details..!');
				redirect(base_url('dashboard/enquiry/newenquiry'));
			}else{
				$this->failedalert('Failed to Update Details..!','You have failed to Updated '.$StdfName.' Details..!');
				redirect(base_url('dashboard/enquiry/newenquiry'));
			}
        }else{
			$this->failedalert('Please fill all required fileds..!','You have to fill all required details of person..!');
            redirect(base_url('dashboard/enquiry/newenquiry'));
        }
    }
}
