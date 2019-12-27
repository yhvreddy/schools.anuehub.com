<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_branchs extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
        $data['userdata'] = $this->Model_integrate->userdata();
    }

    //only for super-admin
    public function index(){
        $data['PageTitle'] = "Register New branch..!";
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['countries'] = $this->Model_dashboard->selectdata('sms_countries',array('status'=>1));
        $this->loadViews('admin/branchs/sms_registernewaccount_page',$data);
    }

    //only for super-admin
    public function branchlist(){
        //school data
        $schooldata = $this->session->userdata['school'];
        $data['schooldata'] = $schooldata;
        $registerid = $schooldata->reg_id;
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['reg'] = $this->Model_dashboard->selectdata('sms_reg',array('upper_reg_id'=>$registerid),'sno');
        $data['PageTitle'] = "Registered branch list..!";
        $this->loadViews('admin/branchs/sms_registeraccountslist_page',$data);
    }

    //saving register account details
    public function SaveBranchDetails(){
        extract($_REQUEST);
        //error_reporting(0);
        
        $ipaddress = $this->input->ip_address();
        $mainbranchid = $this->session->userdata['regid'];
        $scl = $this->session->userdata['school']->schoolname; //regesrer main branch school name 
        $regid  = $this->Model_integrate->initials($scl); // getting mainbarnch school name starting letters
        $code   = md5(uniqid(rand()));
        $uname  = strtoupper(substr(@$RegFname, 0, 3));
        $rand   = $this->Model_integrate->generateRandom(0000,9999);
        $otp    = $rand*26;
        $regid  = "ASMS".$rand.date('d').$uname;

        //check accout register or not
        $query = "SELECT * FROM sms_reg WHERE mailid='$Regemail' OR mobile=$RegMobile OR aadhaar='$RegAadhaar'";
        $regmainbranch = $this->Model_dashboard->selectdata('sms_regusers',array('reg_id'=>$mainbranchid,'scl_mode'=>'GB'));
        $regsecuritypin = $regmainbranch['0']->pinnum;
		$data = array('key'=>1,'message'=>$regsecuritypin);
        $inputsecuritypin = $pin_1.$pin_2.$pin_3.$pin_4;
        $regstatus = $this->Model_dashboard->customquery($query);

        if(count($regstatus) != 0){
            //mailid,mobile,aadhaar check
            if($regstatus['0']->mailid == $Regemail && $regstatus['0']->mobile == $RegMobile && $regstatus['0']->aadhaar == $RegAadhaar){
                $data = array('key'=>0,'message'=>'Details are already register..!');
            }else if($regstatus['0']->mailid == $Regemail){
                $data = array('key'=>0,'message'=>'Mail id already register..!');
            }else if($regstatus['0']->mobile == $RegMobile){
                $data = array('key'=>0,'message'=>'Mobile already register..!');
            }else if($regstatus['0']->aadhaar == $RegAadhaar){
                $data = array('key'=>0,'message'=>'Aadhaar Number already register..!');
            }else{
                $data = array('key'=>0,'message'=>'Invalid Register Details..!');
            }
			//$data = array('key'=>0,'message'=>'Exists');
        }else{

            if($inputsecuritypin === $regsecuritypin){

                $formdata = array(
                    'reg_id'        =>  $regid,
                    'upper_reg_id'  =>  $mainbranchid,
                    'branch_name'   =>  $SclbranchName,
                    'scl_mode'      =>  $SchoolType,
                    'fname'         =>  $RegFname,
                    'lname'         =>  $RegLname,
                    'mailid'        =>  $Regemail,
                    'mobile'        =>  $RegMobile,
                    'address'       =>  $RegAddress,
                    'country_id'    =>  $CountryName,
                    'state_id'      =>  $StateName,
                    'city_id'       =>  $CityName,
                    'pincode'       =>  $RegPincode,
                    'aadhaar'       =>  $RegAadhaar,
                    'conformcode'   =>  $code,
                    'cstatus'       =>  0,
                    'updated'       =>  date('Y-m-d'),
                    'otp'           =>  $otp,
                    'ip_address'    =>  $ipaddress
                );
                
                $storedata = $this->Model_dashboard->insertdata('sms_reg',$formdata);
                if($storedata != 0){
                    //mail function
                    $maildata['maildata'] = $formdata;
                    $maildata['mailtitle'] = 'Conformation Mail';
                    $this->sendemail('email/mail_conformregister',$maildata,SERVICE_PROVIDER_MAIL,$Regemail,'Conformation Mail form '.SERVICE_PROVIDER_NAME,'',SERVICE_PROVIDER_NAME,$RegFname);
                    $data = array('key'=>1,'message'=>'You have successfully register..!');
                }else{
                    $data = array('key'=>0,'message'=>'Failed to register.please try again..!');
                }
                
            }else{
                $data = array('key'=>3,'message'=>'Invalid security Pin..');
            }
			//$data = array('key'=>0,'message'=>$_REQUEST);
        }

        echo json_encode($data);
    }

    //saving register account details
    public function saveeditbranchdetails(){
        extract($_REQUEST);
        $ipaddress = $this->input->ip_address();
        $mainbranchid = $this->session->userdata['regid'];
        $scl = $this->session->userdata['school']->schoolname; //regesrer main branch school name 
        $regid  = $this->Model_integrate->initials($scl); // getting mainbarnch school name starting letters
        $code   = md5(uniqid(rand()));
        //$uname  = strtoupper(substr($RegFname, 0, 3));

        $rand   = $this->Model_integrate->generateRandom(0000,9999);
        $otp    = $rand*26;
        //$regid  = "ASMS".$rand.$uname;

        //check accout register or not
        $query = "SELECT * FROM sms_reg WHERE reg_id = '$Registerid' AND sno = $Regid";
        $checkpin = "SELECT * FROM sms_regusers WHERE reg_id = '$mainbranchid' AND scl_mode = 'GB'";
        $checkpindata = $this->Model_dashboard->customquery($checkpin);
        $regsecuritypin = $checkpindata['0']->pinnum;
        $inputsecuritypin = $pin_1.$pin_2.$pin_3.$pin_4;
        $regstatus = $this->Model_dashboard->customquery($query);
        
        if(count($regstatus) == 0){
            
            $data = array('key'=>0,'message'=>'No Register Details Found..!');
            
        }else{

            if($inputsecuritypin === $regsecuritypin){

                $wheredata = array(
                    'reg_id'        =>  $Registerid,
                    'sno'           =>  $Regid
                );

                $setdata = array(
                    'branch_name'   =>  $SclbranchName,
                    'scl_mode'      =>  $SchoolType,
                    'fname'         =>  $RegFname,
                    'lname'         =>  $RegLname,
                    'mailid'        =>  $Regemail,
                    'mobile'        =>  $RegMobile,
                    'address'       =>  $RegAddress,
                    'country_id'    =>  $CountryName,
                    'state_id'      =>  $StateName,
                    'city_id'       =>  $CityName,
                    'pincode'       =>  $RegPincode,
                    'aadhaar'       =>  $RegAadhaar,
                    'conformcode'   =>  $code,
                    'cstatus'       =>  0,
                    'updated'       =>  date('Y-m-d'),
                    'otp'           =>  $otp,
                    'ip_address'    =>  $ipaddress
                );
                
                $storedata = $this->Model_dashboard->updatedata($setdata,$wheredata,'sms_reg');
                if($storedata != 0){
                    //mail function
                    /*$maildata['maildata'] = $formdata;
                    $maildata['mailtitle'] = 'Conformation Mail';
                    $this->sendemail('email/mail_conformregister',$maildata,'info@anuehub.online',$Regemail,'Conformation Mail form anuehub.');*/
                    $data = array('key'=>1,'message'=>'You have successfully updated..!');
                }else{
                    $data = array('key'=>0,'message'=>'Failed to updated.please try again..!');
                }
            }else{
                $data = array('key'=>3,'message'=>'Invalid security Pin..');
            }
        }

        echo json_encode($data);
    }

    //conform register account by mail verification
    public function conformaccount(){
        $code = $this->input->get('token');
        $type = $this->input->get('type');
        $access = $this->input->get('access');
        //checking token is there or not
        if(isset($code) && !empty($code)) {
            //getting data from reg table by conformation token
            $getdata = $this->Model_dashboard->selectdata('sms_reg', array('conformcode' => $code));
            //checking conformation token is matching or not
            if ((count($getdata) != 0) && ($getdata['0']->conformcode == $code)) {

                $setdata = array('cstatus' => 1, 'updated' => date('Y-m-d h:i:s'));
                $wheredata = array('conformcode' => $code);
                $updatecreg = $this->Model_dashboard->updatedata($setdata, $wheredata, 'sms_reg');

                if ($updatecreg != 0) {

                    //licence key assigned
                    $licence = $this->Model_dashboard->customquery("SELECT * FROM `sms_productkeys` WHERE licence_status = 0 AND status = 1 ORDER BY id ASC LIMIT 1");
                    $licencekey = $licence['0']->licencekey;
                    $licenceid  = $licence['0']->id;

                    $user = explode('@',$getdata['0']->mailid);
                    $regdata = array(
                        'reg_id'        => $getdata['0']->reg_id,
                        'scl_mode'      => $getdata['0']->scl_mode,
                        'fname'         => $getdata['0']->fname,
                        'lname'         => $getdata['0']->lname,
                        'mailid'        => $getdata['0']->mailid,
                        'mobile'        => $getdata['0']->mobile,
                        'password'      => md5($getdata['0']->otp),
                        'username'      => $user['0'],
                        'usermode'      => 'superadmin',
                        'address'       => $getdata['0']->address,
                        //'city'          => $getdata['0']->city,
                        'country_id'    =>  $getdata['0']->country_id,
                        'state_id'      =>  $getdata['0']->state_id,
                        'city_id'       =>  $getdata['0']->city_id,
                        'pincode'       => $getdata['0']->pincode,
                        'aadhaar'       => $getdata['0']->aadhaar,
                        'accmode'       => 1,
                        'ipaddress'     => $this->getipaddress(),
                        'updated'       => date('Y-m-d h:i:s'),
                        'licence_id'    => $licenceid,
                    );
                    //check user exiesting or not by mail id
                    $checkreg = $this->Model_dashboard->selectdata('sms_regusers', array('reg_id' => $getdata['0']->reg_id, 'mailid' => $getdata['0']->mailid));

                    if (count($checkreg) == 0) {
                        //insert data to sms_regusers when verifed
                        $insertdata = $this->Model_dashboard->insertdata('sms_regusers', $regdata);

                        if ($insertdata != 0) {
                            //update licence table which can assign to user.. 
                            $licencewhere   =   array('id'=>$licenceid,'licencekey'=>$licencekey);
                            $licenceupdate  =   array('licence_status'=>1,'reg_id'=>$getdata['0']->reg_id);
                            $updatelicence = $this->Model_dashboard->updatedata($licenceupdate,$licencewhere, 'sms_productkeys');

                            $this->session->set_flashdata('success', 'Your account as successfully activated..Login your account');
                            redirect(base_url());
                            //echo "Successfully redirect to login page";
                        } else {
                            $this->session->set_flashdata('error', 'Your account as not activated.Activate manual.');
                            redirect(base_url() . 'register/conformaccount?access=' . $code . '&type=register');
                            //echo "Failed to Activate account..redirect to manual activate page";
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Your account as already activated..Please Login your account.');
                        redirect(base_url());
                    }
                } else {
                    $this->session->set_flashdata('error', 'Your account as not activated.Activate manual.');
                    redirect(base_url() . 'register/conformaccount?access=' . $code . '&type=activate');
                }

            } else {
                echo "oops..! invalid request.!";
            }

        }else if ((isset($type) && !empty($type)) && (isset($access) && !empty($access))){

            if($type == 'activate'){
                $data['code'] = array('type'=>'activate','access'=>$access);
            }else if($type=='register'){
                $data['code'] = array('type'=>'register','access'=>$access);
            }
            $data['scltypes'] = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'reg'));
            $data['getdata'] = $this->Model_dashboard->selectdata('sms_reg', array('conformcode' => $access));
            $data['PageTitle']  =   "Acativate account as manual method..! ";
            $this->load->view('setup/sms_conformregisteraccount',$data);

        }else{
            echo "invalid request";
        }
    }

    //conform register account by manual process.
    public function conformmanualregister(){
        $code = $this->input->post('conformcode');
        $regid = $this->input->post('registerid');
        $getdata = $this->Model_dashboard->selectdata('sms_reg', array('otp' => $code,'reg_id'=>$regid));
        if ((count($getdata) != 0) && ($getdata['0']->otp == $code) && ($getdata['0']->reg_id == $regid)) {

            $setdata = array('cstatus' => 1, 'updated' => date('Y-m-d h:i:s'));
            $wheredata = array('otp' => $code,'reg_id'=>$regid);
            $updatecreg = $this->Model_dashboard->updatedata($setdata, $wheredata, 'sms_reg');
            if ($updatecreg != 0) {

                //licence key assigned
                $licence = $this->Model_dashboard->customquery("SELECT * FROM `sms_productkeys` WHERE licence_status = 0 AND status = 1 ORDER BY id ASC LIMIT 1");
                $licencekey = $licence['0']->licencekey;
                $licenceid  = $licence['0']->id;


                $user = explode('@',$getdata['0']->mailid);
                $regdata = array(
                    'reg_id'        => $getdata['0']->reg_id,
                    'scl_mode'      => $getdata['0']->scl_mode,
                    'fname'         => $getdata['0']->fname,
                    'lname'         => $getdata['0']->lname,
                    'mailid'        => $getdata['0']->mailid,
                    'mobile'        => $getdata['0']->mobile,
                    'password'      => md5($getdata['0']->otp),
                    'username'      => $user['0'],
                    'usermode'      => 'superadmin',
                    'address'       => $getdata['0']->address,
                    //'city' => $getdata['0']->city,
                    'country_id'    =>  $getdata['0']->country_id,
                    'state_id'      =>  $getdata['0']->state_id,
                    'city_id'       =>  $getdata['0']->city_id,
                    'pincode'       => $getdata['0']->pincode,
                    'aadhaar'       => $getdata['0']->aadhaar,
                    'accmode'       => 1,
                    'ipaddress'     => $this->getipaddress(),
                    'updated'       => date('Y-m-d h:i:s'),
                    'licence_id'    => $licenceid,
                );

                $checkreg = $this->Model_dashboard->selectdata('sms_regusers', array('reg_id' => $getdata['0']->reg_id, 'mailid' => $getdata['0']->mailid));

                if (count($checkreg) == 0) {
                    //insert user details sms_regusers
                    $insertdata = $this->Model_dashboard->insertdata('sms_regusers', $regdata);

                    if ($insertdata != 0) {
                         //update licence table which can assign to user.. 
                        $licencewhere  = array('id'=>$licenceid,'licencekey'=>$licencekey);
                        $licenceupdate = array('licence_status'=>1,'reg_id'=>$getdata['0']->reg_id);
                        $updatelicence = $this->Model_dashboard->updatedata($licenceupdate,$licencewhere, 'sms_productkeys');

                        //$this->session->set_flashdata('success', 'Your account as successfully activated..Login your account');
                        //redirect(base_url());
                        //echo "Successfully redirect to login page";
                        $url = base_url();
                        $data = array('key'=>1,'message'=>'Your account as successfully activated..Login your account','url'=>$url);
                    } else {
                        //$this->session->set_flashdata('error', 'Your account as not activated.Activate manual.');
                        //redirect(base_url() . 'register/conformaccount?access=' . $code . '&type=register');
                        //echo "Failed to Activate account..redirect to manual activate page";
                        $url = base_url() . 'register/conformaccount?access=' . $code . '&type=register';
                        $data = array('key'=>0,'message'=>'Your account as not activating by manual.','url'=>$url);
                    }
                } else {
                    //$this->session->set_flashdata('error', 'Your account as already activated..Please Login your account.');
                    //redirect(base_url());
                    $url = base_url();
                    $data = array('key'=>1,'message'=>'Your account as already activated..Please Login your account.','url'=>$url);
                }
            } else {
                //$this->session->set_flashdata('error', 'Your account as not activated.Activate manual.');
                //redirect(base_url() . 'register/conformaccount?access=' . $code . '&type=activate');
                $url = base_url() . 'register/conformaccount?access=' . $code . '&type=activate';
                $data = array('key'=>0,'message'=>'Your account is not activating by manual process..please contact admin','url'=>$url);
            }

        } else {
            $url = base_url();
            $data = array('key'=>0,'message'=>'oops..! invalid request.! please try again.','url'=>$url);
        }

        echo json_encode($data);
    }

    //branch account on or off 
    public function accountonoff(){
        $one = $this->uri->segment(4);
        $two = $this->uri->segment(5);
        $three = $this->uri->segment(6);

        if($three == 'off'){
            $status = 0;
            $message = 'Deactivate';
        }else{
            $status = 1;
            $message = 'Activate';
        }
        if((isset($one) && $one != '') && (isset($two) && $two != '') && (isset($three) && $three != '')) {
			$check = $this->Model_dashboard->selectdata('sms_regusers', array('reg_id' => $two, 'sno' => $one));
			if (count($check) != 0) {
				$setdata = array('accmode' => $status,'updated'=> date('Y-m-d H:i:s'));
				$wheredata = array('reg_id' => $two, 'sno' => $one);
				$updatedata = $this->Model_dashboard->updatedata($setdata, $wheredata, 'sms_regusers');
				if ($updatedata != 0) {
					$this->Model_dashboard->updatedata(array('status' => $status,'updated'=> date('Y-m-d H:i:s')), array('reg_id' => $two), 'sms_reg');
					$this->successalert('Successfully ' . $message . ' Account..!', $two . ' account as successfully '.$message.'..!');
					redirect(base_url('dashboard/branch/branchlist'));
				} else {
					$this->failedalert('Failed to ' . $message . ' Account..!', 'Sorry ' . $two . ' account as Failed to activate..!');
					redirect(base_url('dashboard/branch/branchlist'));
				}
			} else {
				$this->failedalert('No Account Details Found..!', 'Sorry we are unable to found account details on ' . $two . '..!');
				redirect(base_url('dashboard/branch/branchlist'));
			}
		}else{
			$this->failedalert('Invalid request to '.$message.' account..!', 'Invalid requist to '.$message.' Account or Opps error..@');
			redirect(base_url('dashboard/branch/branchlist'));
		}
    }

    //branch view
    public function branchdetailsview(){
        $one = $this->uri->segment(4);
        $two = $this->uri->segment(5);
		$data['userdata'] = $this->Model_integrate->userdata();
        $data['regusers'] = $this->Model_dashboard->selectdata('sms_regusers',array('reg_id'=>$two,'sno'=>$one));
        $data['schoolinfo'] = $this->Model_dashboard->selectdata('sms_schoolinfo',array('reg_id'=>$two));
        $data['PageTitle'] = $two." Branch Details";
        $this->loadViews('admin/branchs/sms_registeraccountsdetails_page',$data);
    }

    //branch Edit
    public function branchdetailsedit(){
        $one = $this->uri->segment(4);
        $two = $this->uri->segment(5);
        $three = $this->uri->segment(6);
		$data['userdata'] = $this->Model_integrate->userdata();
        $data['countries'] = $this->Model_dashboard->selectdata('sms_countries',array('status'=>1));
        $data['regusers'] = $this->Model_dashboard->selectdata('sms_reg',array('reg_id'=>$two));
        $data['PageTitle'] = 'Edit '.$two." Register Details";
        $this->loadViews('admin/branchs/sms_registereditaccount_page',$data);
    }

    //Delete Recent Branch
	public function DeleteRecentBranch(){
		$reg_sno	=	$this->uri->segment(4);
		$reg_id		=	$this->uri->segment(5);
		$option		=	$this->uri->segment(6);
		error_reporting(0);
		if((isset($reg_id) && $reg_id != '') && (isset($reg_sno) && $reg_sno != '') && (isset($option) && $option == 'delete')){


			$regusers = $this->Model_dashboard->selectdata('sms_reg',array('reg_id'=>$reg_id));
			$reguser = $regusers[0];

			$registeruserdata = $this->Model_dashboard->selectdata('sms_regusers',array('reg_id'=>$reg_id,'gbsid'=>$reguser->upper_reg_id),'updated');
			$registerusers	=	$registeruserdata[0];

			$schooldata = $schoolinfo = $this->Model_dashboard->selectdata('sms_schoolinfo',array('reg_id'=>$reg_id,'scltype'=>'GSB'),'updated');
			$school	=	$schooldata[0];

			//$this->print_r($school);

			//data collection
			$reguser_conduction			=	array('reg_id'=>$reg_id);
			$reguser_tablename			=	'sms_reg';

			$registreduser_conduction	=	array('reg_id'=>$reg_id,'gbsid'=>$reguser->upper_reg_id);
			$registreduser_tablename	=	'sms_regusers';

			$schooldata_conduction		=	array('reg_id'=>$reg_id,'scltype'=>'GSB');
			$schooldata_tablename		=	'sms_schoolinfo';

			if(count($schooldata) != 0) {
				$admissions = $this->Model_dashboard->selectdata('sms_admissions', array('school_id' => $school->school_id, 'branch_id' => $school->branch_id), 'updated');
				$employees = $this->Model_dashboard->selectdata('sms_admissions', array('school_id' => $school->school_id, 'branch_id' => $school->branch_id), 'updated');
				$enquirys = $this->Model_dashboard->selectdata('sms_admissions', array('school_id' => $school->school_id, 'branch_id' => $school->branch_id), 'updated');

				$admissions_conduction = array('school_id' => $school->school_id, 'branch_id' => $school->branch_id);
				$admissions_updatedata = array('status' => 1, 'updated' => date('Y-m-d H:i:s'));
				$admissions_tablename = 'sms_admissions';

				$employee_conduction = array('school_id' => $school->school_id, 'branch_id' => $school->branch_id);
				$employee_updatedata = array('status' => 1, 'updated' => date('Y-m-d H:i:s'));
				$employee_tablename = 'sms_employee';

				$enquiry_conduction = array('school_id' => $school->school_id, 'branch_id' => $school->branch_id);
				$enquiry_updatedata = array('status' => 1, 'updated' => date('Y-m-d H:i:s'));
				$enquiry_tablename = 'sms_enquiry';
			}

			$reguser_action	= $this->Model_dashboard->deletedata($reguser_conduction,$reguser_tablename);

			if(count($registeruserdata) != 0) {
				$registreduser_action = $this->Model_dashboard->deletedata($registreduser_conduction,$registreduser_tablename);
			}else{ $registreduser_action = 1; }

			if(count($schooldata) != 0) {
				$schooldata_action = $this->Model_dashboard->deletedata($schooldata_conduction,$schooldata_tablename);
			}else{ $schooldata_action = 1; }

			if(count($schooldata) != 0) {
				if (count($admissions) != 0) {
					$admissions_action = $this->Model_dashboard->deletedata($admissions_conduction, $admissions_tablename);
				} else {
					$admissions_action = 1;
				}

				if (count($employees) != 0) {
					$employee_action = $this->Model_dashboard->deletedata($employee_conduction, $employee_tablename);
				} else {
					$employee_action = 1;
				}

				if (count($enquirys) != 0) {
					$enquiry_action = $this->Model_dashboard->deletedata($enquiry_conduction, $enquiry_tablename);
				} else {
					$enquiry_action = 1;
				}
			}else{
				$enquiry_action = 1;$employee_action = 1;$admissions_action = 1;
			}

			//echo  $reguser_action.' '.$registreduser_action.' '.$schooldata_action.' '.$admissions_action.' '.$employee_action.' '.$enquiry_action;
			
			if($reguser_action != 0 && $registreduser_action != 0 && $schooldata_action != 0 && $admissions_action != 0 && $employee_action != 0 && $enquiry_action != 0){
				$this->successalert('Successfully delete  branch.',' branch successfully deleted with all data.');
				redirect(base_url('dashboard/branch/branchlist'));
			}else{
				$this->failedalert('Failed to delete  branch.',' branch not deleted with all related data.');
				redirect(base_url('dashboard/branch/branchlist'));
			}

		}else{
			$this->failedalert('Sorry unable to delete branch.','Invalid request to deleted branch or opps error..!');
			redirect(base_url('dashboard/branch/branchlist'));
		}

	}

    //Delete Branch Data List
	public function DeleteBranchDataList(){
    	extract($_REQUEST);
    	//$this->print_r($_REQUEST);

    	$reg_sno	=	$this->uri->segment(4);
    	$reg_id		=	$this->uri->segment(5);
    	$option		=	$this->uri->segment(6);
    	if((isset($reg_id) && $reg_id != '') && (isset($reg_sno) && $reg_sno != '') && (isset($option) && $option == 'delete') && (isset($delete) && $delete != '')){


			$regusers = $this->Model_dashboard->selectdata('sms_reg',array('reg_id'=>$reg_id));
			$reguser = $regusers[0];

			$registeruserdata = $this->Model_dashboard->selectdata('sms_regusers',array('reg_id'=>$reg_id,'gbsid'=>$reguser->upper_reg_id),'updated');
			$registerusers	=	$registeruserdata[0];

			$schooldata = $schoolinfo = $this->Model_dashboard->selectdata('sms_schoolinfo',array('reg_id'=>$reg_id,'scltype'=>'GSB'),'updated');
			$school	=	$schooldata[0];

			//$this->print_r($school);

			$admissions	=	$this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$school->school_id,'branch_id'=>$school->branch_id),'updated');
			$employees	=	$this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$school->school_id,'branch_id'=>$school->branch_id),'updated');
			$enquirys	=	$this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$school->school_id,'branch_id'=>$school->branch_id),'updated');

			//data collection
			$reguser_conduction			=	array('reg_id'=>$reg_id);
			$reguser_updatedata			=	array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
			$reguser_tablename			=	'sms_reg';

			$registreduser_conduction	=	array('reg_id'=>$reg_id,'gbsid'=>$reguser->upper_reg_id);
			$registreduser_updatedata	=	array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
			$registreduser_tablename	=	'sms_regusers';

			$schooldata_conduction		=	array('reg_id'=>$reg_id,'scltype'=>'GSB');
			$schooldata_updatedata		=	array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
			$schooldata_tablename		=	'sms_schoolinfo';

			$admissions_conduction		=	array('school_id'=>$school->school_id,'branch_id'=>$school->branch_id);
			$admissions_updatedata		=	array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
			$admissions_tablename		=	'sms_admissions';

			$employee_conduction		=	array('school_id'=>$school->school_id,'branch_id'=>$school->branch_id);
			$employee_updatedata		=	array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
			$employee_tablename			=	'sms_employee';

			$enquiry_conduction			=	array('school_id'=>$school->school_id,'branch_id'=>$school->branch_id);
			$enquiry_updatedata			=	array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
			$enquiry_tablename			=	'sms_enquiry';


    		if($delete == 'temp'){

    			$type	=	'Temporary';

				$reguser_action				=	$this->Model_dashboard->updatedata($reguser_updatedata,$reguser_conduction,$reguser_tablename);

				$registreduser_action		=	$this->Model_dashboard->updatedata($registreduser_updatedata,$registreduser_conduction,$registreduser_tablename);

				$schooldata_action			=	$this->Model_dashboard->updatedata($schooldata_updatedata,$schooldata_conduction,$schooldata_tablename);

				if(count($admissions) != 0) {
					$admissions_action = $this->Model_dashboard->updatedata($admissions_updatedata, $admissions_conduction, $admissions_tablename);
				}else{ $admissions_action = 1; }

				if(count($employees) != 0) {
					$employee_action = $this->Model_dashboard->updatedata($employee_updatedata, $employee_conduction, $employee_tablename);
				}else{ $employee_action = 1; }

				if(count($enquirys) != 0) {
					$enquiry_action = $this->Model_dashboard->updatedata($enquiry_updatedata, $enquiry_conduction, $enquiry_tablename);
				}else{ $enquiry_action = 1; }


			}else if($delete == 'permanent'){
				$type	=	'Permanent';
			}else{
				$this->failedalert('Sorry unable to delete branch.','Invalid request to delete '.$branch_name.'branch');
				redirect(base_url('dashboard/branch/branchlist'));
			}

    		//echo  $reguser_action.' '.$registreduser_action.' '.$schooldata_action.' '.$admissions_action.' '.$employee_action.' '.$enquiry_action;

    		if($reguser_action != 0 && $registreduser_action != 0 && $schooldata_action != 0 && $admissions_action != 0 && $employee_action != 0 && $enquiry_action != 0){
    			$this->successalert('Successfully delete '.$branch_name.' branch.',$branch_name.' branch successfully deleted with all data as '.$type.'.');
				redirect(base_url('dashboard/branch/branchlist'));
			}else{
				$this->failedalert('Failed to delete '.$branch_name.' branch.',$branch_name.' branch not deleted with all related data '.$type.'.');
				redirect(base_url('dashboard/branch/branchlist'));
			}
		}else{
    		$this->failedalert('Sorry unable to delete branch.','Invalid request to delete '.$branch_name.'branch or opps error..!');
    		redirect(base_url('dashboard/branch/branchlist'));
		}
	}

	//Restore Branch Data
	public function RestoreBranchData(){
		extract($_REQUEST);
		//$this->print_r($_REQUEST);

		$reg_sno	=	$this->uri->segment(4);
		$reg_id		=	$this->uri->segment(5);
		$option		=	$this->uri->segment(6);
		
		if((isset($reg_id) && $reg_id != '') && (isset($reg_sno) && $reg_sno != '') && (isset($option) && $option == 'restore')){


			$regusers = $this->Model_dashboard->selectdata('sms_reg',array('reg_id'=>$reg_id));
			$reguser = $regusers[0];

			$registeruserdata = $this->Model_dashboard->selectdata('sms_regusers',array('reg_id'=>$reg_id,'gbsid'=>$reguser->upper_reg_id),'updated');
			$registerusers	=	$registeruserdata[0];

			$schooldata = $schoolinfo = $this->Model_dashboard->selectdata('sms_schoolinfo',array('reg_id'=>$reg_id,'scltype'=>'GSB'),'updated');
			$school	=	$schooldata[0];

			//$this->print_r($school);

			$admissions	=	$this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$school->school_id,'branch_id'=>$school->branch_id),'updated');
			$employees	=	$this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$school->school_id,'branch_id'=>$school->branch_id),'updated');
			$enquirys	=	$this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$school->school_id,'branch_id'=>$school->branch_id),'updated');

			//data collection
			$reguser_conduction			=	array('reg_id'=>$reg_id);
			$reguser_updatedata			=	array('status'=>1,'updated'=>date('Y-m-d H:i:s'));
			$reguser_tablename			=	'sms_reg';

			$registreduser_conduction	=	array('reg_id'=>$reg_id,'gbsid'=>$reguser->upper_reg_id);
			$registreduser_updatedata	=	array('status'=>1,'updated'=>date('Y-m-d H:i:s'));
			$registreduser_tablename	=	'sms_regusers';

			$schooldata_conduction		=	array('reg_id'=>$reg_id,'scltype'=>'GSB');
			$schooldata_updatedata		=	array('status'=>1,'updated'=>date('Y-m-d H:i:s'));
			$schooldata_tablename		=	'sms_schoolinfo';

			$admissions_conduction		=	array('school_id'=>$school->school_id,'branch_id'=>$school->branch_id);
			$admissions_updatedata		=	array('status'=>1,'updated'=>date('Y-m-d H:i:s'));
			$admissions_tablename		=	'sms_admissions';

			$employee_conduction		=	array('school_id'=>$school->school_id,'branch_id'=>$school->branch_id);
			$employee_updatedata		=	array('status'=>1,'updated'=>date('Y-m-d H:i:s'));
			$employee_tablename			=	'sms_employee';

			$enquiry_conduction			=	array('school_id'=>$school->school_id,'branch_id'=>$school->branch_id);
			$enquiry_updatedata			=	array('status'=>1,'updated'=>date('Y-m-d H:i:s'));
			$enquiry_tablename			=	'sms_enquiry';


			$reguser_action				=	$this->Model_dashboard->updatedata($reguser_updatedata,$reguser_conduction,$reguser_tablename);

			$registreduser_action		=	$this->Model_dashboard->updatedata($registreduser_updatedata,$registreduser_conduction,$registreduser_tablename);

			$schooldata_action			=	$this->Model_dashboard->updatedata($schooldata_updatedata,$schooldata_conduction,$schooldata_tablename);

			if(count($admissions) != 0) {
				$admissions_action = $this->Model_dashboard->updatedata($admissions_updatedata, $admissions_conduction, $admissions_tablename);
			}else{ $admissions_action = 1; }

			if(count($employees) != 0) {
				$employee_action = $this->Model_dashboard->updatedata($employee_updatedata, $employee_conduction, $employee_tablename);
			}else{ $employee_action = 1; }

			if(count($enquirys) != 0) {
				$enquiry_action = $this->Model_dashboard->updatedata($enquiry_updatedata, $enquiry_conduction, $enquiry_tablename);
			}else{ $enquiry_action = 1; }


			//echo  $reguser_action.' '.$registreduser_action.' '.$schooldata_action.' '.$admissions_action.' '.$employee_action.' '.$enquiry_action;

			if($reguser_action != 0 && $registreduser_action != 0 && $schooldata_action != 0 && $admissions_action != 0 && $employee_action != 0 && $enquiry_action != 0){
				$this->successalert('Successfully restore  branch.',' branch successfully restore with all data.');
				redirect(base_url('dashboard/branch/branchlist'));
			}else{
				$this->failedalert('Failed to restore  branch.',' branch not restore with all related data.');
				redirect(base_url('dashboard/branch/branchlist'));
			}

		}else{
			$this->failedalert('Sorry unable to restore branch.','Invalid request to restore branch or opps error..!');
			redirect(base_url('dashboard/branch/branchlist'));
		}
	}
}
