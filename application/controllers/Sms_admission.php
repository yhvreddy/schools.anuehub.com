<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_admission extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }

    //New Admission
    public function index($externaldata = NULL){
        $data['PageTitle'] = "New Admissions";
        //getting school data in session
        $data['userdata'] = $this->Model_integrate->userdata();
        $schooldata = $this->session->userdata['school'];
        $data['schoolid'] = $schoolid = $schooldata->school_id;
        $data['branchid'] = $branchid = $schooldata->branch_id;
        $data['scltype']  = $schooldata->scltype;  
        //print_r($schooldata);
		$academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
		$batch = $academicyear[0]->academic_year; //adminssion accadmic batch
		$enquiry = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$schoolid,'branch_id'=>$branchid,'batch'=>$batch));
		$countlist = count($enquiry) + 1;

		$schoolname  = $schooldata->schoolname;
		$randnumber  = $this->Model_integrate->generateRandom(0,99);
		$letters =  random_string('alpha', 1);
		$alfnums =  random_string('alnum', 1);
		$studentname = strtoupper($letters).' '.strtoupper($alfnums);
		$data['environment_id']    = $this->manualgenerate_id($schoolname,date('y'),$studentname,$countlist);
		$data['gender']     = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'gender','status'=>1));
        $data['bloodgroups']     = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'blood','status'=>1));
        $data['services']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'service','status'=>1));
        $data['countries']  = $this->Model_dashboard->selectdata('sms_countries',array('status'=>1));
        //sending syllabus data to views and getting class data by ajax
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($schoolid,$branchid);
        $data['branchlist'] = $this->Model_dashboard->selectdata('sms_schoolinfo',array('scltype'=>'GSB','branch_id'=>$branchid));
        $data['schooldata'] = $schooldata;
        $this->loadViews('admin/admissions/sms_admission_page',$data);
    }

    //Add enquiry to admission
    public function admissionbyenquiry($externaldata = NULL){
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "New Admissions";
        $one    = $this->uri->segment(4); //id or sno
        $two    = $this->uri->segment(5); //school id
        $three  = $this->uri->segment(6); // branch id
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $data['schoolid'] = $schoolid = $schooldata->school_id;
        $data['branchid'] = $branchid = $schooldata->branch_id;
        $data['scltype']  = $schooldata->scltype;
		$academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
		$batch = $academicyear[0]->academic_year; //adminssion accadmic batch
		$enquiry = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$schoolid,'branch_id'=>$branchid,'batch'=>$batch));
		$countlist = count($enquiry) + 1;

		$schoolname  = $schooldata->schoolname;
		$randnumber  = $this->Model_integrate->generateRandom(0,99);
		$letters =  random_string('alpha', 1);
		$alfnums =  random_string('alnum', 1);
		$studentname = strtoupper($letters).' '.strtoupper($alfnums);
		$data['environment_id']    = $this->manualgenerate_id($schoolname,date('y'),$studentname,$countlist);
        $data['gender']     = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'gender','status'=>1));
        $data['bloodgroups']     = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'blood','status'=>1));
        $data['services']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'service','status'=>1));
        $data['countries']  = $this->Model_dashboard->selectdata('sms_countries',array('status'=>1));
        //sending syllabus data to views and getting class data by ajax
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($schoolid,$branchid);
        $data['classes'] = $this->Model_dashboard->selectdata('sms_class',array('school_id'=>$schoolid,'branch_id'=>$branchid));
        $data['enquirydata'] = $this->Model_dashboard->selectdata('sms_enquiry',array('sno'=>$one,'school_id'=>$two,'branch_id'=>$three));
        $data['schooldata'] = $schooldata;
        $this->loadViews('admin/admissions/sms_admissionformenquiry_page',$data);
    }

    //Admissions list
    public function admissionlist($externaldata = NULL){
        $data['PageTitle'] = "Admissions List";
        //getting school data in session
        $data['userdata'] = $this->Model_integrate->userdata();
        $schooldata = $this->session->userdata['school'];
        $data['schoolid'] = $schoolid = $schooldata->school_id;
        $data['branchid'] = $branchid = $schooldata->branch_id;
        $academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
        $batch = $academicyear[0]->academic_year; //adminssion accadmic batch
        $data['adminssions'] = $this->Model_dashboard->selectdata('sms_admissions',array('branch_id'=>$branchid,'school_id'=>$schoolid,'status'=>1,'batch'=>$batch),'updated,sno');
        $this->loadViews('admin/admissions/sms_admissionlist_page',$data);
    }

    //Save new admission details
    public function saveadmissions(){
        extract($_REQUEST);
		$regid = $environmentid; // student admission id
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $scltype  = $schooldata->scltype;
        if($scltype == 'GB'){ $schoolid = $schoolid; }else{ $schoolid = $schooldata->school_id; }
        $branchid = $schooldata->branch_id;
        $academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
        $batch = $academicyear[0]->academic_year; //adminssion accadmic batch
        $registerby = $schooldata->reg_id;


        //generate school mail id
		$schoolname  = $this->Model_integrate->initials($schooldata->schoolname);
		$alfnums =  random_string('alnum', 1);
		$studentname	= str_replace(' ','',$stdfname);
		$generatemail = strtolower($this->generate_mails($studentname.date('m').$alfnums,$schoolname));

        $this->createdir('./uploads/files/admissions/'.$branchid.'/'.$schoolid.'/'.$regid,'./uploads/files/admissions/'.$branchid.'/'.$schoolid.'/'.$regid.'');
        //Qr-code Gen
        $qrcode = $this->qrcodegen($branchid,$schoolid,$regid,$batch,'uploads/files/admissions/'.$branchid.'/'.$schoolid.'/'.$regid.'/');
        if($qrcode['code'] == 1){
            $qrcode = $qrcode['path'];
        }else{
            $qrcode = '';
        }
        //student image upload
        if($_FILES['stdimage']['name'] != '') {
            $studentimage = $this->uploadfiles('./uploads/files/admissions/' . $branchid . '/' . $schoolid . '/' . $regid, 'stdimage', '*', TRUE, '', '');
            $student_image = 'uploads/files/admissions/' . $branchid . '/' . $schoolid . '/' . $regid . '/' . $studentimage['uploaddata']['file_name'];
        }else{ $student_image = ''; }
        //parent image upload
        if($_FILES['stdparentimage']['name'] != '') {
            $parentimage = $this->uploadfiles('./uploads/files/admissions/' . $branchid . '/' . $schoolid . '/' . $regid, 'stdparentimage', '*', FALSE, '', '');
            $pimage = 'uploads/files/admissions/' . $branchid . '/' . $schoolid . '/' . $regid . '/' . $parentimage['uploaddata']['file_name'];
        }else{ $pimage = '';}

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

        if(isset($enquiryid)){ $enquiryid  =   $enquiryid; }else{ $enquiryid = ''; }

        //grouping fee amount
        $feeamountlist=array();
        foreach ($feetype as $key => $value) {
            $feeamountlist[$value] = $feeamount[$key];
        }

        $checkadmission = $this->Model_dashboard->selectwithorconduction('sms_admissions',array('school_id'=>$schoolid,'branch_id'=>$branchid,'em_id'=>$environmentid));
        
        if(count($checkadmission) != 0){
        	$this->failedalert('Admission as already exits..!','Admission as already exits please check once and try later..!');
            redirect(base_url('dashboard/admissions/newadmissions'));
        }else{
            $saveadmissionsdata = array(
                'branch_id'     =>  $branchid,
                'school_id'     =>  $schoolid,
                'em_id'         =>  $environmentid,
                'id_num'        =>  $regid,
                'enq_id'        =>  $enquiryid,
                'firstname'     =>  $stdfname,
                'lastname'      =>  $stdlname,
                'fathername'    =>  $stdfmname,
                'gender'        =>  $stdgender,
                'class_type'    =>  $StdSyllubas,
                'local_mail_id'	=>	$generatemail,
                'class'         =>  $StdClass,
                'dob'           =>  date('Y-m-d',strtotime($DOB)),
                'mobile'        =>  $mobile,
                'altermobile'   =>  $altermobile,
                'mail_id'       =>  $emailid,
                'address'       =>  $address,
                'country_id'    =>  $CountryName,
                'state_id'      =>  $StateIdName,
                'city_id'       =>  $CityIdName,
                'pincode'       =>  $pincode,
                'service'       =>  $stdservice,
                'moles'         =>  $moles,
                'student_image' =>  $student_image,
                'blood_group'   =>  $stdbloodgroup,
                'country_code'  =>  $country_code,
                'nationality'   =>  $Nationality,
                'religion'      =>  $Religion,
                'pname'         =>  $parentsname,
                'pdegination'   =>  $occupation,
                'pphone'        =>  $parentsmobile,
                'pmailid'       =>  $parentsmailid,
                'paddress'      =>  $parentsaddress,
                'ppincode'      =>  $parentspincode,
                'pimage'        =>  $pimage,
                'feeamount'     =>  serialize($feeamountlist),
                'totalfee'      =>  $totalfee,
                'batch'         =>  $batch,
                'qr_code'       =>  $qrcode,
                'ip_address'    =>  $this->input->ip_address(),
                'usermode'      =>  'student',
                'created_by'    =>  $registerby,
                'updated'       =>  date('Y-m-d H:i:s')
            );
            $newadminssion = $this->Model_dashboard->insertdata('sms_admissions',$saveadmissionsdata);
            if($newadminssion != 0){
            	$this->successalert('Student as successfully admitted..!',$stdfname.'.'.$stdlname.' as successfully admitted at our school..!');
                redirect(base_url('dashboard/admissions/admissionslist'));
            }else{
            	$this->failedalert('Failed to save the admission details.!','Details are not saved successfully.please try again..!');
                redirect(base_url('dashboard/admissions/newadmissions'));
            }
        }
        //$this->print_r($saveadmissionsdata);
    }

    //Edit Admission
    public function editadmission($externaldata = NULL){
        $data['PageTitle'] = "Edit Admission Details";
        $data['userdata'] = $this->Model_integrate->userdata();
        $one    = $this->uri->segment(4); //id or sno
        $two    = $this->uri->segment(5); //school id
        $three  = $this->uri->segment(6); // branch id
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $data['schoolid'] = $schoolid = $schooldata->school_id;
        $data['branchid'] = $branchid = $schooldata->branch_id;
        $data['scltype']  = $schooldata->scltype;  
        //print_r($schooldata);
        $data['gender']     = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'gender','status'=>1));
        $data['services']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'service','status'=>1));
        $data['bloodgroups']     = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'blood','status'=>1));
        $data['countries']  = $this->Model_dashboard->selectdata('sms_countries',array('status'=>1));
        //sending syllabus data to views and getting class data by ajax
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($schoolid,$branchid);
        $data['classes'] = $this->Model_dashboard->selectdata('sms_class',array('school_id'=>$schoolid,'branch_id'=>$branchid));
        $data['branchlist'] = $this->Model_dashboard->selectdata('sms_schoolinfo',array('scltype'=>'GSB','branch_id'=>$branchid));
        $data['enquirydata'] = $this->Model_dashboard->selectdata('sms_admissions',array('sno'=>$one,'school_id'=>$two,'branch_id'=>$three));
        $data['schooldata'] = $schooldata;
        $this->loadViews('admin/admissions/sms_admissionformedit_page',$data);
    }

    //save edit details
    public function saveeditadmissions(){
        extract($_REQUEST);
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $scltype  = $schooldata->scltype;
        if($scltype == 'GB'){ $schoolid = $schoolid; }else{ $schoolid = $schooldata->school_id; }
        $branchid = $schooldata->branch_id;        
        //$batch = $this->Model_dashboard->adminssionbatch(); //adminssion accadmic batch
        $academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
        $batch = $academicyear[0]->academic_year; //adminssion accadmic batch
        $directory = $this->createdir('./uploads/files/admissions/'.$branchid.'/'.$schoolid.'/'.$enquiryid,'./uploads/files/admissions/'.$branchid.'/'.$schoolid.'/'.$enquiryid.'');
        //Qr-code Gen
        $qrcode = $this->qrcodegen($branchid,$schoolid,$enquiryid,$batch,'uploads/files/admissions/'.$branchid.'/'.$schoolid.'/'.$enquiryid.'/');
        if($qrcode['code'] == 1){ $qrcode = $qrcode['path']; }else{ $qrcode = ''; }
        //student image upload
        if($_FILES['stdimage']['name'] != '') {
            $studentimage = $this->uploadfiles('./uploads/files/admissions/' . $branchid . '/' . $schoolid . '/' . $enquiryid, 'stdimage', '*', TRUE, '', '');
            $student_image = 'uploads/files/admissions/' . $branchid . '/' . $schoolid . '/' . $enquiryid . '/' . $studentimage['uploaddata']['file_name'];
        }else{ $student_image = $uploadedstudent_image; }
        //parent image upload
        if($_FILES['stdparentimage']['name'] != '') {
            $parentimage = $this->uploadfiles('./uploads/files/admissions/' . $branchid . '/' . $schoolid . '/' . $enquiryid, 'stdparentimage', '*', FALSE, '', '');
            $pimage = 'uploads/files/admissions/' . $branchid . '/' . $schoolid . '/' . $enquiryid . '/' . $parentimage['uploaddata']['file_name'];
        }else{ $pimage = $uploadedparent_image;}
        
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

        //grouping fee amount
        $feeamountlist=array();
        foreach ($feetype as $key => $value) {
            $feeamountlist[$value] = $feeamount[$key];
        }
        $checkadmission = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$schoolid,'branch_id'=>$branchid,'id_num'=>$enquiryid));
        if(count($checkadmission) != 0){
            
            $conduction = array(
                'branch_id'     =>  $branchid,
                'school_id'     =>  $schoolid,
                'id_num'        =>  $enquiryid,
                'sno'           =>  $admission_sno_id,
            );

            $saveadmissionsdata = array(
                'firstname'     =>  $stdfname,
                'lastname'      =>  $stdlname,
                'fathername'    =>  $stdfmname,
                'gender'        =>  $stdgender,
                'class_type'    =>  $StdSyllubas,
                'class'         =>  $StdClass,
                'dob'           =>  date('Y-m-d',strtotime($DOB)),
                'mobile'        =>  $mobile,
                'altermobile'   =>  $altermobile,
                'mail_id'       =>  $emailid,
                'address'       =>  $address,
                'country_id'    =>  $CountryName,
                'state_id'      =>  $StateIdName,
                'city_id'       =>  $CityIdName,
                'pincode'       =>  $pincode,
                'service'       =>  $stdservice,
                'moles'         =>  $moles,
                'student_image' =>  $student_image,
                'blood_group'   =>  $stdbloodgroup,
                'country_code'  =>  $country_code,
                'nationality'   =>  $Nationality,
                'religion'      =>  $Religion,
                'pname'         =>  $parentsname,
                'pdegination'   =>  $occupation,
                'pphone'        =>  $parentsmobile,
                'pmailid'       =>  $parentsmailid,
                'paddress'      =>  $parentsaddress,
                'ppincode'      =>  $parentspincode,
                'pimage'        =>  $pimage,
                'feeamount'     =>  serialize($feeamountlist),
                'totalfee'      =>  $totalfee,
                'batch'         =>  $batch,
                'qr_code'       =>  $qrcode,
                'ip_address'    =>  $this->input->ip_address(),
                'updated'       =>  date('Y-m-d H:i:s')
            );

            $updateadminssion = $this->Model_dashboard->updatedata($saveadmissionsdata,$conduction,'sms_admissions');
            if($updateadminssion != 0){
            	$this->successalert('Admission as successfully update..!',$stdfname.'.'.$stdlname.' Details as updated.');
                redirect(base_url('dashboard/admissions/admissionslist'));
            }else{
				$this->failedalert('Admission as Failed update..!',$stdfname.'.'.$stdlname.' details as failed to updated.');
                redirect(base_url('dashboard/admissions/newadmissions'));
            }
        }else{
			$this->failedalert('Admission as not exist..!','Invalid request to update details...');
            redirect(base_url('dashboard/admissions/admissionslist'));
        }
    }

    //delete data
    public function deletedata(){
        $one = $this->uri->segment(4);
        $two = $this->uri->segment(5);
        $three = $this->uri->segment(6);

        $check = $this->Model_dashboard->selectdata('sms_admissions',array('sno'=>$one,'school_id'=>$two,'branch_id'=>$three));
        if(count($check) != 0){

        	//delete enquiry record
        	if(!empty($check[0]->enq_id)){
				$this->Model_dashboard->updatedata(array('status'=>0),array('id_num'=>$check[0]->enq_id,'school_id'=>$two,'branch_id'=>$three),'sms_enquiry');
			}

        	$useraccount = $this->Model_dashboard->selectdata('sms_users',array('id_num'=>$check[0]->id_num,'school_id'=>$two,'branch_id'=>$three));
        	if(count($useraccount) != 0){
				$this->Model_dashboard->updatedata(array('status'=>0),array('id_num'=>$check[0]->id_num,'school_id'=>$two,'branch_id'=>$three),'sms_users');
			}
        	
        	//delete user account
			if(!empty($check[0]->enq_id)){
				$this->Model_dashboard->updatedata(array('status'=>0),array('id_num'=>$check[0]->enq_id,'school_id'=>$two,'branch_id'=>$three),'sms_enquiry');
			}

			//delete admission
            $admissiondelete = $this->Model_dashboard->updatedata(array('status'=>0),array('sno'=>$one,'school_id'=>$two,'branch_id'=>$three),'sms_admissions');
            if($admissiondelete != 0){
            	$this->successalert('Successfully delete Details..!',$check[0]->firstname.'Admission records as sucessfully deleted..!');
                redirect(base_url('dashboard/admissions/admissionslist'));
            }else{
				$this->failedalert('Failed to delete records..!',$check[0]->firstname.'Admission records as failed to deleted..!');
                redirect(base_url('dashboard/admissions/newadmissions'));
            }
        }else{
			$this->failedalert('Failed to delete records..!','Invaild request or records or not found to delete..!');
			redirect(base_url('dashboard/admissions/newadmissions'));
        }
    }

    //view details
	public function admissionsdetails(){
    	$person_id	=	$this->uri->segment(4);
    	$branch_id	=	$this->uri->segment(5);
    	$school_id	=	$this->uri->segment(6);

		$data['requst_type'] 	=	$this->uri->segment(7);

		$data['userdata'] = $this->Model_integrate->userdata();
    	if(isset($person_id) && !empty($person_id) && isset($branch_id) && !empty($branch_id) && isset($school_id) && !empty($school_id)){
			$data['PageTitle'] = "Admission details..!";
			$admissiondetails = $this->Model_default->selectdata('sms_admissions', array('school_id' => $school_id, 'branch_id' => $branch_id, 'sno' => $person_id), 'sno DESC');
			if(count($admissiondetails) != 0){
				$data['admissiondetails'] = $admissiondetails;
				$this->loadViews('admin/admissions/sms_admissiondetails_page',$data);
			}else{
				$this->failedalert('Invalid request of Admission details..!','Your request to display details of admission not found..!');
				redirect(base_url('dashboard/admissions/admissionslist'));
			}
		}else{
    		$this->failedalert('Invalid request..!','Invalid request to display admission details..!');
			redirect(base_url('dashboard/admissions/admissionslist'));
		}
	}



    //testing functions
    public function syllabustypes(){
        $schoolid = $this->session->userdata['school']->school_id;
        $branchid = $this->session->userdata['school']->branch_id;
        $data = $this->Model_dashboard->syllabustypes($schoolid,$branchid);
    }

    //defaut ajax data for all usefull forms or pages..
    public function stateslist(){
        extract($_REQUEST);
        $statelist = $this->Model_dashboard->selectdata('sms_states',array("country_id"=>$Countryid,'status'=>1));
        $data = $statelist;
        echo json_encode($data);
    }

    public function citieslist(){
        extract($_REQUEST);
        $citylist = $this->Model_dashboard->selectdata('sms_cities',array('state_id'=>$Stateid,'status'=>1));
        $data = $citylist;
        echo json_encode($data);
    }

    public function sampleqrcode(){
        $qrcode = $this->qrcodegen('SRPSY19JH20','SRPSY19JH12','SRPSY19D18HA51','2019-2020','uploads/files/admissions/SRPSY19JH20/SRPSY19JH12/SRPSY19D18HA51/');
        $this->print_r($qrcode);
    }
}
