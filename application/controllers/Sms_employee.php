<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_employee extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }

    //Homepage for all users..
    public function index($externaldata = NULL){
        extract($_REQUEST);
        $this->employee();
    }

	//Homepage for all users..
    public function employee($externaldata= NULL){
        $data['PageTitle'] = "New Employee";
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['schoolid'] = $schoolid = $schooldata->school_id;
        $data['branchid'] = $branchid = $schooldata->branch_id;
        $data['scltype']  = $schooldata->scltype;

		$academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
		$batch = $academicyear[0]->academic_year; //adminssion accadmic batch
		$enquiry = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$schoolid,'branch_id'=>$branchid));
		$countlist = count($enquiry) + 1;

		$schoolname  = $schooldata->schoolname;
		$randnumber  = $this->Model_integrate->generateRandom(0,99);
		$letters =  random_string('alpha', 1);
		$alfnums =  random_string('alnum', 1);
		$studentname = strtoupper($letters).' '.strtoupper($alfnums);
		$data['environment_id']    = $this->manualgenerate_id($schoolname,date('y'),$studentname,$countlist);

        $data['gender']     = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'gender','status'=>1));
        $data['services']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'service','status'=>1));
        $data['employee']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'employee','status'=>1));
        $data['staff']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'staff','status'=>1));
        $data['worker']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'worker','status'=>1));
        $data['office']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'office','status'=>1));
        $data['countries']  = $this->Model_dashboard->selectdata('sms_countries',array('status'=>1));
        //sending syllabus data to views and getting class data by ajax
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($schoolid,$branchid);
        $data['branchlist'] = $this->Model_dashboard->selectdata('sms_schoolinfo',array('scltype'=>'GSB','branch_id'=>$branchid));
        $data['schooldata'] = $schooldata;
        $this->loadViews('admin/employee/sms_employee_page',$data);
    }

    //employee list
    public function employeelist($externaldata= NULL){
        $data['PageTitle'] = "Employee List";
       //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $data['schoolid'] = $schoolid = $schooldata->school_id;
        $data['branchid'] = $branchid = $schooldata->branch_id;
        $data['userdata'] = $this->Model_integrate->userdata();
		$data['syllabus']   = $this->Model_dashboard->syllabustypes($schoolid,$branchid);
        $data['employees'] = $this->Model_dashboard->selectdata('sms_employee',array('branch_id'=>$branchid,'school_id'=>$schoolid,'status'=>1),'updated,sno');
        $this->loadViews('admin/employee/sms_employeelist_page',$data);
    }

    //save Employee Data
    public function employeesavedata($externaldata = NULL){
        extract($_REQUEST);
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $scltype  = $schooldata->scltype;
        if($scltype == 'GB'){
            $schoolid = $schoolid;
        }else{
            $schoolid = $schooldata->school_id;
        }
        $branchid = $schooldata->branch_id;
        $registerby = $schooldata->reg_id;
        $regid = $environmentid;


		$schoolname  = $this->Model_integrate->initials($schooldata->schoolname);
		$alfnums =  random_string('alnum', 1);
		$employeename	= str_replace(' ','',$empname);
		$generatemail = strtolower($this->generate_mails($employeename.date('n').$alfnums,$schoolname));


        $academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
        $batch = $academicyear[0]->academic_year; //adminssion accadmic batch
        $directory = $this->createdir('./uploads/files/employee/'.$branchid.'/'.$schoolid.'/'.$regid,'./uploads/files/employee/'.$branchid.'/'.$schoolid.'/'.$regid.'');
        //Qr-code Gen
        $qrcode = $this->qrcodegen($branchid,$schoolid,$regid,$batch,'uploads/files/employee/'.$branchid.'/'.$schoolid.'/'.$regid.'/');
        if($qrcode['code'] == 1){
            $qrcode = $qrcode['path'];
        }else{
            $qrcode = '';
        }
        //student image upload
        if($_FILES['employeeimage']['name'] != '') {
            $studentimage = $this->uploadfiles('./uploads/files/employee/' . $branchid . '/' . $schoolid . '/' . $regid, 'employeeimage', '*', TRUE, '', '');
            $employeeimg = 'uploads/files/employee/' . $branchid . '/' . $schoolid . '/' . $regid . '/' . $studentimage['uploaddata']['file_name'];
        }else{ $employeeimg = ''; }

        //country code
        if(isset($full_phone)){
            $full_phone = explode($empmobile,$full_phone);
            $country_code  = $full_phone[0];
            if($country_code != '+undefined'){
                $country_code = $country_code;
            }else{
                $country_code = '';
            }
        }else{ $country_code = ''; }

        $checkadmission = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$schoolid,'branch_id'=>$branchid,'id_num'=>$regid,'em_id'=>strtoupper($environmentid)));
        if(count($checkadmission) != 0){
        	$this->failedalert('Record already exits..!','Record as already exits. Please try again later..!');
            redirect(base_url('dashboard/employee/newemployee'));
        }else{

            if($empphone == ""){
                $empphone = $empmobile;
            }

            if($emptype == ''){
                $this->session->set_flashdata('error','Please select Employee Type..!');
                redirect(base_url('dashboard/employee/newemployee'));
            }else if($emptype == 'staff'){
                if($emppti == 'classteacher'){
                    $empposition = $emppti;
                    $empcls = $empclass;
                    $emp_Syllubas	=	$StdSyllubas;
                }else{
                    $empposition = $emppti;
                    $empcls = '';
					$emp_Syllubas	= '';
                }
                $syllabus_class	=	$syllabus_class;
                $syllabus_name	=	$syllabus_name;
				$empsubjects = implode(',',$syllabus_class_subject);
                $empsubjects = $empsubjects;
            }else if($emptype == 'worker'){
                $empposition = $emppoti;
                $empsubjects = '';
				$syllabus_class	=	'';
				$syllabus_name	=	'';
				$emp_Syllubas	= '';
				$empcls = '';
            }else if($emptype == 'office'){
                $empposition = $empoffic;
                $empsubjects = '';
				$syllabus_class	=	'';
				$syllabus_name	=	'';
				$emp_Syllubas	= '';
				$empcls = '';
            }
            if(empty($empppincode)){ $empppincode =''; }else{ $empppincode = $empppincode; }
            if(empty($emppmobile)){ $emppmobile =''; }else{ $emppmobile = $empppincode; }

            $saveemployeedata = array(
                'branch_id'     		=>  $branchid,
                'school_id'     		=>  $schoolid,
                'em_id'         		=>  strtoupper($environmentid),
                'id_num'        		=>  $regid,
                'firstname'     		=>  $empname,
                'lastname'      		=>  $emplname,
                'fathername'    		=>  '',
                'country_code'  		=>  $country_code,
                'employee_pic'  		=>  $employeeimg,
                'gender'        		=>  $empgender,
                'dob'           		=>  $empdob,
                'mobile'        		=>  $empmobile,
                'phone'         		=>  $empphone,
                'mail_id'       		=>  $empmail,
				'local_mail_id'			=>	$generatemail,
                'address'       		=>  $address,
                'country_id'    		=>  $CountryName,
                'state_id'      		=>  $StateIdName,
                'city_id'       		=>  $CityIdName,
                'pincode'       		=>  $emppincode,
                //'aadhaar_card'  		=>  $empaadhaar,
                'nationality'   		=>  $empnationality,
                'religion'      		=>  $empreligion,
                'employeetype'  		=>  $emptype,
                'emoloyeeposition' 		=>  $empposition,
                'employee_syllabus'		=>	$emp_Syllubas,
                'employeeclass' 		=>  $empcls,
                'designation'   		=>  $empdegination,
                'deal_syllabus'			=>  $syllabus_name,
				'deal_syllabus_class'	=>	$syllabus_class,
                'dealsubjects'  		=>  $empsubjects,
                'parentname'    		=>  $emppname,
                'parentdesignation' 	=>  $emppdegination,
                'parentphone'       	=>  $emppmobile,
                'parentemail'       	=>  $emppmail,
                'parentaddress'     	=>  $emppaddress,
                'parentcity'        	=>  $emppcity,
                'parentpincode'     	=>  $empppincode,
                'salary'        		=>  $empsalary,
                'ip_address'    		=>  $this->input->ip_address(),
                'joiningdate'   		=>  date('Y-m-d H:i:s'),
                'created_by'    		=>  $registerby,
                'updated'       		=>  date('Y-m-d H:i:s'),
                'qr_code'       		=>  $qrcode,
            );
            $newemployee = $this->Model_dashboard->insertdata('sms_employee',$saveemployeedata);
            if($newemployee != 0){
            	$this->successalert('Successfully saved details..!',$empname.'.'.$emplname.' details as saved successfully.');
                redirect(base_url('dashboard/employee/employeelist'));
            }else{
				$this->successalert('Failed to saved details..!',$empname.'.'.$emplname.' details as failed to saved.');
                redirect(base_url('dashboard/employee/newemployee'));
            }
        }
    }

    //Edit employee
    public function editemployee($externaldata = NULL){
        $data['PageTitle'] = "Edit Employee Details";
        $one    = $this->uri->segment(4); //id or sno
        $two    = $this->uri->segment(5); //school id
        $three  = $this->uri->segment(6); // branch id
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['schoolid'] = $schoolid = $schooldata->school_id;
        $data['branchid'] = $branchid = $schooldata->branch_id;
        $data['scltype']  = $schooldata->scltype;
        //print_r($schooldata);
        $data['gender']     = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'gender','status'=>1));
        $data['services']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'service','status'=>1));
        $data['employees']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'employee','status'=>1));
        $data['staff']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'staff','status'=>1));
        $data['worker']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'worker','status'=>1));
        $data['office']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'office','status'=>1));
        $data['countries']  = $this->Model_dashboard->selectdata('sms_countries',array('status'=>1));
        //sending syllabus data to views and getting class data by ajax
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($schoolid,$branchid);
        $data['branchlist'] = $this->Model_dashboard->selectdata('sms_schoolinfo',array('scltype'=>'GSB','branch_id'=>$branchid));
        $data['employeedata'] = $this->Model_dashboard->selectdata('sms_employee',array('sno'=>$one,'school_id'=>$two,'branch_id'=>$three));
        $data['schooldata'] = $schooldata;
        
        $this->loadViews('admin/employee/sms_employee_edit_page',$data);
    }

    //save edit details
	public function saveEditemployeedata($externaldata = NULL){
        extract($_REQUEST);

        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $scltype  = $schooldata->scltype;
        if($scltype == 'GB'){
            $schoolid = $schoolid;
        }else{
            $schoolid = $schooldata->school_id;
        }

        $branchid = $schooldata->branch_id;
        $registerby = $schooldata->reg_id;
        $regid  = $regid;
        
        $academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
        $batch = $academicyear[0]->academic_year; //adminssion accadmic batch
        
        $checkadmission = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$schoolid,'branch_id'=>$branchid,'id_num'=>$regid,'em_id'=>strtoupper($environmentid)));
        if(count($checkadmission) == 0){
            $this->failedalert('Employee details not exits..!','Invalid request to edit record..!');
            redirect(base_url('dashboard/employee/newemployee'));
        }else{

            $directory = $this->createdir('./uploads/files/employee/'.$branchid.'/'.$schoolid.'/'.$regid,'./uploads/files/employee/'.$branchid.'/'.$schoolid.'/'.$regid.'');

            //employee image upload
            if($_FILES['employeeimage']['name'] != '') {
                $studentimage = $this->uploadfiles('./uploads/files/employee/' . $branchid . '/' . $schoolid . '/' . $regid, 'employeeimage', '*', TRUE, '', '');
                $employeeimg = 'uploads/files/employee/' . $branchid . '/' . $schoolid . '/' . $regid . '/' . $studentimage['uploaddata']['file_name'];
            }else{ $employeeimg = $uploadedemployee_image; }

            //country code
            if(isset($full_phone)){
                $full_phone = explode($empmobile,$full_phone);
                $country_code  = $full_phone[0];
                if($country_code != '+undefined'){
                    $country_code = $country_code;
                }else{
                    $country_code = '';
                }
            }else{ $country_code = ''; }

            if($empphone == ""){
                $empphone = $empmobile;
            }

			if($emptype == ''){
				$this->session->set_flashdata('error','Please select Employee Type..!');
				redirect(base_url('dashboard/employee/newemployee'));
			}else if($emptype == 'staff'){
				if($emppti == 'classteacher'){
					$empposition = $emppti;
					$empcls = $empclass;
					$emp_Syllubas	=	$StdSyllubas;
				}else{
					$empposition = $emppti;
					$empcls = '';
					$emp_Syllubas	= '';
				}
				$syllabus_class	=	$syllabus_class;
				$syllabus_name	=	$syllabus_name;
				$empsubjects = implode(',',$syllabus_class_subject);
				$empsubjects = $empsubjects;
			}else if($emptype == 'worker'){
				$empposition = $emppoti;
				$empsubjects = '';
				$syllabus_class	=	'';
				$syllabus_name	=	'';
				$emp_Syllubas	= '';
				$empcls = '';
			}else if($emptype == 'office'){
				$empposition = $empoffic;
				$empsubjects = '';
				$syllabus_class	=	'';
				$syllabus_name	=	'';
				$emp_Syllubas	= '';
				$empcls = '';
			}

            if(empty($empppincode)){ $empppincode =''; }else{ $empppincode = $empppincode; }
            if(empty($emppmobile)){ $emppmobile =''; }else{ $emppmobile = $empppincode; }

            $conduction = array(
                'branch_id'     =>  $branchid,
                'school_id'     =>  $schoolid,
                'em_id'         =>  strtoupper($environmentid),
                'id_num'        =>  $regid,
            );
            $saveemployeedata = array(
                'firstname'     		=>  $empname,
                'lastname'      		=>  $emplname,
                'fathername'    		=>  '',
                'country_code'  		=>  $country_code,
                'employee_pic'  		=>  $employeeimg,
                'gender'        		=>  $empgender,
                'dob'           		=>  $empdob,
                'mobile'        		=>  $empmobile,
                'phone'         		=>  $empphone,
                'mail_id'       		=>  $empmail,
                'address'       		=>  $address,
                'country_id'    		=>  $CountryName,
                'state_id'      		=>  $StateIdName,
                'city_id'       		=>  $CityIdName,
                'pincode'       		=>  $emppincode,
                //'aadhaar_card'  		=>  $empaadhaar,
                'nationality'   		=>  $empnationality,
                'religion'      		=>  $empreligion,
                'employeetype'  		=>  $emptype,
                'emoloyeeposition' 		=>   $empposition,
				'employee_syllabus'		=>	$emp_Syllubas,
				'employeeclass' 		=>  $empcls,
				'designation'   		=>  $empdegination,
				'deal_syllabus'			=>  $syllabus_name,
				'deal_syllabus_class'	=>	$syllabus_class,
				'dealsubjects'  		=>  $empsubjects,
                'parentname'    		=>  $emppname,
                'parentdesignation' 	=>  $emppdegination,
                'parentphone'       	=>  $emppmobile,
                'parentemail'       	=>  $emppmail,
                'parentaddress'     	=>  $emppaddress,
                'parentcity'        	=>  $emppcity,
                'parentpincode'     	=>  $empppincode,
                'salary'        		=>  $empsalary,
                'ip_address'    		=>  $this->input->ip_address(),
                'updated'       		=>  date('Y-m-d H:i:s'),
            );
            $editemployee = $this->Model_dashboard->updatedata($saveemployeedata,$conduction,'sms_employee');
            if($editemployee != 0){
                $this->successalert('Successfully update record..!',$empname.' record as updated..!');
                redirect(base_url('dashboard/employee/employeelist'));
            }else{
				$this->failedalert('Failed to update record..!', 'Record as failed to updated..!');
                redirect(base_url('dashboard/employee/newemployee'));
            }
        }
    }

    //delete employee data
    public function deletedata($externaldata = NULL){
        $one = $this->uri->segment(4);
        $two = $this->uri->segment(5);
        $three = $this->uri->segment(6);

        $check = $this->Model_dashboard->selectdata('sms_employee',array('sno'=>$one,'school_id'=>$two,'branch_id'=>$three));
        if(count($check) != 0){

			$useraccount = $this->Model_dashboard->selectdata('sms_users',array('id_num'=>$check[0]->id_num,'school_id'=>$two,'branch_id'=>$three));

            $enquiry = $this->Model_dashboard->updatedata(array('status'=>0),array('sno'=>$one,'school_id'=>$two,'branch_id'=>$three),'sms_employee');
            if($enquiry != 0){

				if(count($useraccount) != 0){
					$this->Model_dashboard->updatedata(array('status'=>0),array('id_num'=>$check[0]->id_num,'school_id'=>$two,'branch_id'=>$three),'sms_users');
				}

                $this->successalert('Successfully delete Details..!','Employee details as successfully deleted..!');
                redirect(base_url('dashboard/employee/employeelist'));
            }else{
				$this->failedalert('Failed to delete Details..!','Employee details as failed to deleted..!');
                redirect(base_url('dashboard/employee/employeelist'));
            }
        }else{
			$this->failedalert('Invalid request to delete Details..!','Employee details as failed to deleted..!');
            redirect(base_url('dashboard/employee/employeelist'));
        }
    }

	//view employee details
	public function employeedetails($externaldata = NULL){
		$person_id	=	$this->uri->segment(4);
		$branch_id	=	$this->uri->segment(5);
		$school_id	=	$this->uri->segment(6);
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['requst_type'] 	=	$this->uri->segment(7);
		if(isset($person_id) && !empty($person_id) && isset($branch_id) && !empty($branch_id) && isset($school_id) && !empty($school_id)){
			$data['PageTitle'] = "Employee details..!";
			$employeedetails = $this->Model_default->selectdata('sms_employee', array('school_id' => $school_id, 'branch_id' => $branch_id, 'sno' => $person_id), 'sno DESC');
			if(count($employeedetails) != 0){
				$data['employeedetails'] = $employeedetails;
				$this->loadViews('admin/employee/sms_employeedetails_page',$data);
			}else{
				$this->failedalert('Invalid request of Admission details..!','Your request to display details of admission not found..!');
				redirect(base_url('dashboard/employee/employeelist'));
			}
		}else{
			$this->failedalert('Invalid request..!','Invalid request to display admission details..!');
			redirect(base_url('dashboard/employee/employeelist'));
		}
	}

	//check class teacher exists or not
	public function classteacherexitsatus(){
    	extract($_REQUEST);
		$data['PageTitle'] = "New Employee";
		//getting school data in session
		$schooldata = $this->session->userdata['school'];
		$school_id = $schooldata->school_id;
		$branch_id = $schooldata->branch_id;
		$classteacherexits = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'employee_syllabus'=>$syllabus_type,'employeeclass'=>$syllabus_class));
		if(count($classteacherexits) != 0){
			$data = array('sigcode' => 1,'message'=>'Already exits');
		}else{
			$data = array('sigcode' => 0,'message'=>'Add New');
		}
    	echo json_encode($data);
	}

	//Save Assign Class
	public function SaveAssignClass(){
    	extract($_REQUEST);
    	//$this->print_r($_REQUEST);
		//exit;
    	$syllabus_name	=	$syllabus_name;
    	$assigning_class = implode(',',$assigning_syllabus_class);
		//$this->print_r($assigning_class);
    	$updatedata = array('assign_class_syllabus'=>$syllabus_name,'assign_classes_list'=>$assigning_class,'updated'=>date('Y-m-d H:i:s'));
    	$conduction	= array('sno'=>$sno,'id_num'=>$id_num,'branch_id'=>$branch_id,'school_id'=>$school_id);
		$editemployee = $this->Model_dashboard->updatedata($updatedata,$conduction,'sms_employee');
		if($editemployee != 0){
			$this->successalert('Successfully assign class..!','You have successfully assign class '.$assigning_class.' to '.$id_num);
			redirect(base_url('dashboard/employee/employeelist'));
		}else{
			$this->failedalert('Failed to assign class..!','You have failed to assign class '.$assigning_class.' to '.$id_num);
			redirect(base_url('dashboard/employee/employeelist'));
		}
	}
}
