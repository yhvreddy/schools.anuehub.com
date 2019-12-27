<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Login extends BaseController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
	}
	//login account access page
    public function index(){
        $this->isLoggedIn();
	}

    //This function used to check the user is logged in or not
    function isLoggedIn(){
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE) {
            //$data['owner'] = $this->model_login->ownaccountcnt();
            $data['pageTitle']	= 'Login to Access Your Account.';
			$this->input->set_cookie('sms_project_name',SERVICE_PROVIDER_NAME, time() + (86400)); /* 86400 = 1 day */
		    $this->load->view('login_page',$data);
        }else {
            //  print_r($this->session->userdata);
            //  exit();
            $licenceplan = $this->session->userdata('licenceplan');
            //print_r($licenceplan);
            redirect(base_url().'dashboard');
        }
        
    }

	//Login account access
    public function loginAccessAccount(){
		error_reporting(0);
        extract($_REQUEST);
		$accessingdevice = $_SERVER['HTTP_USER_AGENT'];
        $this->Model_integrate->generateproductkeys();
        $this->form_validation->set_rules('userName', 'Email', 'required|max_length[350]|trim');
        $this->form_validation->set_rules('passWord', 'Password', 'required|max_length[32]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error', 'Invalid Login Details..!');
            redirect(base_url());
        }else{
            $userId = $this->input->post('userName');
            $UserIdCheck = $this->Model_default->checkUserExist($userId);
            
            if(count($UserIdCheck) != 0){
            	$userpassword	=	$this->input->post('passWord');
                $password1 =   $userpassword;
                $password1 = md5($password1);
            }else{
                $this->session->set_flashdata('error', "Couldn't find your Email Id");
                redirect(base_url());
            }
            
            $result = $this->Model_default->loginMe($userId,$password1);

            //check user is exist or not
            if(count($result['userdata']) != 0) {
                
                if($result['userdata']['0']->status == 1 && $result['userdata']['0']->accmode == 1){
					$this->input->set_cookie('sms_login_id',$userId, time() + (86400));
					$this->input->set_cookie('sms_login_password',$userpassword, time() + (86400));
                    $sessionArray=array();
                    foreach ($result['userdata'] as $res) {
                        //getting school details for checking school details
                        if(@$res->usermode == 'super-admin' || @$res->usermode == 'superadmin' || @$res->usermode == 'admin') {
                            $regdetails = array('id' => $res->sno, 'reg_id' => $res->reg_id, 'sclmode' => $res->scl_mode, 'type' => $res->usermode);
                            $schooldata = $this->Model_default->selectconduction('sms_schoolinfo',array('reg_id'=>$res->reg_id));
                            $licence    = $this->Model_integrate->checklicence($res->reg_id,$res->licence_id);
                            $today      = date('Y-m-d h:i:s');
                            $start      = strtotime($today);
                            $expary     = $licence['0']->todate;
                            $enddate    = strtotime($licence['0']->todate);
                            $totaldays  = $licence['0']->package_nodays;
                            $expering   = $licence['0']->package_expdays;
                            //total no of days
                            $datediff = $this->Model_integrate->datediff($today,$expary);
                            $remainds = $datediff['diff'];
                            $schoolinfo = $schooldata['0'];
                        }else{
                            $schooldata = $this->Model_default->selectconduction('sms_schoolinfo',array('school_id'=>$res->school_id,'branch_id'=>$res->branch_id));
                            $reguser =  $this->Model_default->selectconduction('sms_regusers',array('reg_id'=>$schooldata[0]->reg_id));
                            $regdetails =array('id'=>$res->sno,'reg_id'=>$res->id_num,'type'=>$res->usertype,'schooldata'=>$schooldata[0],'sclmode'=>$schooldata[0]->scltype);
                            $userdata = $this->Model_dashboard->sedetails($schooldata[0]->branch_id,$schooldata[0]->school_id,$res->id_num);

                            $licence    = $this->Model_integrate->checklicence($schooldata[0]->reg_id,$reguser[0]->licence_id);
                            $today      = date('Y-m-d h:i:s');
                            $start      = strtotime($today);
                            $expary     = $licence['0']->todate;
                            $enddate    = strtotime($licence['0']->todate);
                            $totaldays  = $licence['0']->package_nodays;
                            $expering   = $licence['0']->package_expdays;
                            //total no of days
                            $datediff = $this->Model_integrate->datediff($today,$expary);
                            $remainds = $datediff['diff'];
                            $schoolinfo = $schooldata['0'];
                        }


                        /*$this->print_r($userdata);
                        $this->print_r($reguser);
                        $this->print_r($regdetails);*/
                        //check first time password is changed or not
                        if($res->pwd_status	 == 1){
                            //check usermode is superadmin or admin
                            if (@$res->usermode == 'super-admin' || @$res->usermode == 'superadmin' || @$res->usermode == 'admin') {
                                //check school details is there or not..
                                if (count($schooldata) != 0) {
                                    //check licence details
                                    $sessionArray = array(
                                        'id'            =>  $res->sno,
                                        'regid'         =>  $res->reg_id,
                                        'type'          =>  $res->usermode,
                                        'sclmode'       =>  $res->scl_mode,
                                        'licenceid'     =>  $res->licence_id,
                                        'licenceplan'   =>  $licence['0']->licence_plan,
                                        'school'        =>  $schoolinfo,
                                        'batch'         =>  $schoolinfo->school_academic_form_to,
                                        'isLoggedIn'    =>  TRUE,
                                        //'sessionData'=> $result['result2']
                                    );
                                    if(($enddate <= $start) && ($totaldays <= $remainds)){
                                        //redirect to licence upgrade
										$logindetails	=	array(
											'branch_id'	=>	$schoolinfo->branch_id,
											'school_id'	=>	$schoolinfo->school_id,
											'id_num'	=>	$res->reg_id,
											'user_type'	=>	$res->usermode,
											'user_id'	=>	$res->sno,
											'login_date'=>	date('Y-m-d'),
											'login_time'=>	date('H:i:s'),
											'status'	=>	1,
											'updated'	=>	date('Y-m-d H:i:s'),
											'system_info'	=>	serialize($this->systemInfo()),
											'browser_info'	=>	$this->browser(),
											'device_info'	=>	$accessingdevice,
											'login_type'	=>	'P = licence upgrade',
											'ip_address'	=>	$this->input->ip_address()
										);
										$insertdata = $this->Model_dashboard->insertdata('sms_users_logs',$logindetails);
										if($insertdata != 0){
											//access code
											$this->session->set_userdata($sessionArray);

										}else{
											//$logoutdata = array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
											//$updatedata = $this->Model_dashboard->updatedata($logoutdata,array(''),'sms_users_logs');
											$this->session->sess_destroy();
											$this->session->set_flashdata('error', 'Failed to login to upgrade your licence.');
											redirect(base_url());
										}
                                    }else{

                                        if($schoolinfo->school_academic != 1){

                                            //redirect to installation page
											$logindetails	=	array(
												'branch_id'	=>	$schoolinfo->branch_id,
												'school_id'	=>	$schoolinfo->school_id,
												'id_num'	=>	$res->reg_id,
												'user_type'	=>	$res->usermode,
												'user_id'	=>	$res->sno,
												'login_date'=>	date('Y-m-d'),
												'login_time'=>	date('H:i:s'),
												'status'	=>	1,
												'updated'	=>	date('Y-m-d H:i:s'),
												'system_info'	=>	serialize($this->systemInfo()),
												'browser_info'	=>	$this->browser(),
												'device_info'	=>	$accessingdevice,
												'login_type'	=>	'T = setup-academic details'
											);
											$insertdata = $this->Model_dashboard->insertdata('sms_users_logs',$logindetails);
											if($insertdata != 0){
												$this->session->set_userdata('logdata',$logindetails);
												$this->session->set_userdata($sessionArray);
												//access code
												redirect('setup/academicdetails');
											}else{
												//$logoutdata = array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
												//$updatedata = $this->Model_dashboard->updatedata($logoutdata,array(''),'sms_users_logs');
												$this->session->sess_destroy();
												$this->session->set_flashdata('error', 'Failed to login to setup academic details.');
												redirect(base_url());
											}

                                        }else{

											$logindetails	=	array(
												'branch_id'	=>	$schoolinfo->branch_id,
												'school_id'	=>	$schoolinfo->school_id,
												'id_num'	=>	$res->reg_id,
												'user_type'	=>	$res->usermode,
												'user_id'	=>	$res->sno,
												'login_date'=>	date('Y-m-d'),
												'login_time'=>	date('H:i:s'),
												'status'	=>	1,
												'updated'	=>	date('Y-m-d H:i:s'),
												'system_info'	=>	serialize($this->systemInfo()),
												'browser_info'	=>	$this->browser(),
												'device_info'	=>	$accessingdevice,
												'login_type'	=>	'P = usage',
												'ip_address'	=>	$this->input->ip_address()
											);
											$insertdata = $this->Model_dashboard->insertdata('sms_users_logs',$logindetails);
											if($insertdata != 0){
												//access code
												$this->session->set_userdata($sessionArray);
												$this->session->set_userdata('logdata',$logindetails);
												$this->session->set_flashdata('success','Successfully Login');
												$this->session->set_flashdata('text','Welcome '.$res->fname.' . '.substr($res->lname,0,1).' you are successfully login our account..! @ '.date('h:m a'));
												redirect('dashboard?login=success');
											}else{
												//$logoutdata = array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
												//$updatedata = $this->Model_dashboard->updatedata($logoutdata,array(''),'sms_users_logs');
												$this->session->sess_destroy();
												$this->session->set_flashdata('error', 'Failed to login to setup academic details.');
												redirect(base_url());
											}

                                        }
                                    }
                                }else{

                                	$logindetails	=	array(
										'branch_id'	=>	$schoolinfo->branch_id,
										'school_id'	=>	$schoolinfo->school_id,
										'id_num'	=>	$res->reg_id,
										'user_type'	=>	$res->usermode,
										'user_id'	=>	$res->sno,
										'login_date'=>	date('Y-m-d'),
										'login_time'=>	date('H:i:s'),
										'status'	=>	1,
										'updated'	=>	date('Y-m-d H:i:s'),
										'system_info'	=>	serialize($this->systemInfo()),
										'browser_info'	=>	$this->browser(),
										'device_info'	=>	$accessingdevice,
										'login_type'	=>	'T = usage',
										'ip_address'	=>	$this->input->ip_address()
									);
									$insertdata = $this->Model_dashboard->insertdata('sms_users_logs',$logindetails);
									if($insertdata != 0){
										//access code
										$this->session->set_userdata($sessionArray);
										$this->session->set_userdata('logdata',$logindetails);
										$regdetails = array('reg_id' => $res->reg_id, 'sclmode' => $res->scl_mode, 'type' => $res->usermode);
										$this->session->set_userdata('userdetails', $regdetails);
										redirect(base_url() . 'setup/setschooldetails');
									}else{
										//$logoutdata = array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
										//$updatedata = $this->Model_dashboard->updatedata($logoutdata,array(''),'sms_users_logs');
										$this->session->sess_destroy();
										$this->session->set_flashdata('error', 'Failed to login to setup academic details.');
										redirect(base_url());
									}

                                }

                            }else{

                            	//$this->print_r($res);
                            	$studentdata = $this->Model_default->selectconduction('sms_admissions',array('id_num'=>$res->id_num,'branch_id'=>$res->branch_id,'school_id'=>$res->school_id));
                            	 $usersdata	=	$studentdata[0];
                            	//$this->print_r($studentdata);
                            	if(count($studentdata) == 0){
									$employeedata = $this->Model_default->selectconduction('sms_employee',array('id_num'=>$res->id_num,'branch_id'=>$res->branch_id,'school_id'=>$res->school_id));
									//$this->print_r($employeedata);
									$usersdata	=	$employeedata[0];
								}


                            	//check is already login or not

								$logindetails	=	array(
									'branch_id'	=>	$schoolinfo->branch_id,
									'school_id'	=>	$schoolinfo->school_id,
									'id_num'	=>	$usersdata->id_num,
									'user_type'	=>	$res->usertype,
									'user_id'	=>	$usersdata->sno,
									'login_date'=>	date('Y-m-d'),
									'login_time'=>	date('H:i:s'),
									'status'	=>	1,
									'updated'	=>	date('Y-m-d H:i:s'),
									'system_info'	=>	serialize($this->systemInfo()),
									'browser_info'	=>	$this->browser(),
									'device_info'	=>	$accessingdevice,
									'login_type'	=>	'P = usage',
									'ip_address'	=>	$this->input->ip_address()
								);
								$insertdata = $this->Model_dashboard->insertdata('sms_users_logs',$logindetails);
								if($insertdata != 0){

									$sessionArray = array(
										'id'            =>  $res->sno,
										'regid'         =>  $res->id_num,
										'type'          =>  $res->usertype,
										'sclmode'       =>  $schooldata[0]->scltype,
										'licenceid'     =>  $reguser[0]->licence_id,
										'licenceplan'   =>  $licence['0']->licence_plan,
										'school'        =>  $schoolinfo,
										'batch'         =>  $schoolinfo->school_academic_form_to,
										'isLoggedIn'    =>  TRUE,
										//'sessionData'=> $result['result2']
									);
									$this->session->set_userdata($sessionArray);
									//access code
									$this->session->set_userdata('logdata',$logindetails);
									//add login urls togo dashboard
									if(isset($usersdata->employee_pic) && !empty($usersdata->employee_pic)){
										$image = base_url($usersdata->employee_pic);
									}else if(isset($usersdata->student_image) && !empty($usersdata->student_image)){
										$image = base_url($usersdata->student_image);
									}else{
										$image = base_url('assets/images/avater_all.png');
									}

									$this->session->set_flashdata('success','Successfully Login');
									$this->session->set_flashdata('image',$image);
									$this->session->set_flashdata('text','Welcome '.$usersdata->firstname.' . '.substr($res->lastname,0,1).' you are successfully login our account..! @ '.date('h:m a'));

									if($res->usertype == 'student'){
										redirect('student/dashboard');
									}else if($res->usertype == 'classteacher'){
										redirect('classteacher/dashboard');
									}else if($res->usertype == 'teacher'){
										redirect('teacher/dashboard');
									}else if($res->usertype == 'accountant'){
										redirect('accountant/dashboard');
									}

								}else{
									//$logoutdata = array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
									//$updatedata = $this->Model_dashboard->updatedata($logoutdata,array(''),'sms_users_logs');
									$this->session->sess_destroy();
									$this->session->set_flashdata('error', 'Failed to login to setup academic details.');
									redirect(base_url());
								}

                            }
                        }else{
                            $this->session->set_userdata('userdetails', $regdetails);
                            redirect(base_url('changecredentials?password'));
                        }
                    }
                    // echo "<pre>";
                    // print_r($sessionArray);
                    // exit();
                }else{
                    $this->session->set_flashdata('error', 'Sorry Your account is temporarily termenated.<br>please contact authorized person..!');
                    redirect(base_url());
                }

            }else{
                $this->session->set_flashdata('error', 'wrong password');
                redirect(base_url());
            }
        }
        
    }

	//create new user account
	public function registerAccount(){
		$data['pageTitle']	= 'Create account to manage your school.';
		$data['scltypes'] 	= $this->Model_default->selectconduction('sms_formdata',array('type'=>'reg'));
        $data['countries'] 	= $this->Model_default->selectconduction('sms_countries',array('status'=>1));
        $this->load->view('setup/sms_registeraccount',$data);
        $genkey=$this->Model_integrate->generateproductkeys();
    }

	//save register Details
	public function newRegisterAccount(){
		extract($_REQUEST);
		//print_r($_REQUEST);
		$scltype =  $this->input->post('SchoolType');
        $fname   =  $this->input->post('Fname');
        $lname   =  $this->input->post('Lname');
        $mobile  =  $this->input->post('Mobile');
        $mailid  =  $this->input->post('Mailid');
        $address =  $this->input->post('Address');
        //$city    =  $this->input->post('city');
        $country =  $this->input->post('CountryName');
        $stateid =  $this->input->post('StateName');
        $citydist=  $this->input->post('CityName');
        $pincode =  $this->input->post('pincode');
        //$aadhaar =  $this->input->post('Aadhaar');
        $ipaddress =$this->input->ip_address();
        $code   = md5(uniqid(rand()));
        $uname  =  strtoupper(substr($fname, 0, 2)); 
        $rand   = $this->Model_integrate->generateRandom(0000,9999);
        $otp    = $rand*26;
        $regid  = "ASMS".$rand.date('d').$uname;

        //check accout register or not
        $query = "SELECT * FROM sms_reg WHERE mailid='$mailid' OR mobile=$mobile OR aadhaar='$address'";
        $regstatus = $this->Model_default->manualselect($query);
        
        if(count($regstatus) != 0){
            //mailid,mobile,aadhaar check
            if(($regstatus['0']->mailid == $mailid && $regstatus['0']->mobile == $mobile) || ($regstatus['0']->mailid == $mailid && $regstatus['0']->mobile == $mobile)){
                $data = array('key'=>0,'message'=>'Details are already register..!');
            }else if($regstatus['0']->mailid == $mailid){
                $data = array('key'=>0,'message'=>'Mail id already register..!');
            }else if($regstatus['0']->mobile == $mobile){
                $data = array('key'=>0,'message'=>'Mobile already register..!');
            }
        }else{

            $formdata = array(
                'reg_id'    =>  $regid,
                'scl_mode'  =>  $scltype,
                'fname'     =>  $fname,
                'lname'     =>  $lname,
                'mailid'    =>  $mailid,
                'mobile'    =>  $mobile,
                'address'   =>  $address,
                'country_id'=>  $country,
                'state_id'  =>  $stateid,
                'city_id'   =>  $citydist,
                'pincode'   =>  $pincode,
                //'aadhaar'   =>  $aadhaar,
                'conformcode'=> $code,
                'cstatus'   =>  0,
                'updated'   =>  date('Y-m-d'),
                'otp'       =>  $otp,
                'ip_address'=>  $ipaddress,
                'referral_code'=>  'ANUEHUB001'
            );
            
            $storedata = $this->Model_default->insertdata('sms_reg',$formdata);
            if($storedata != 0){
                //mail function
                $maildata['maildata'] = $formdata;
                $maildata['mailtitle'] = 'Conformation Mail';
                $this->sendemail('email/mail_conformregister',$maildata,SERVICE_PROVIDER_MAIL,$mailid,'Conformation Mail form anuehub.com','',SERVICE_PROVIDER_NAME,$fname);
                $data = array('key'=>1,'message'=>'You have successfully register..!');
            }else{
                $data = array('key'=>0,'message'=>'Failed to register.please try again..!');
            }

        }

        echo json_encode($data);	
	}

	//conform register account by mail vefification
    public function conformaccount(){
		extract($_REQUEST);

        $code = $token;
        $type = $this->input->get('type');
        $access = $this->input->get('access');

        //checking token is there or not
        if((isset($code) && !empty($code)) || (isset($token) && !empty($token))){

            //getting data from reg table by conformation token
            $getdata = $this->Model_default->selectconduction('sms_reg', array('conformcode' => $token,'cstatus'=>0));
            //echo $getdata['0']->conformcode;
            //checking conformation token is matching or not
            if(count($getdata) != 0 && $getdata['0']->conformcode == $code) {

                //$this->print_r($getdata);
                $sclmode = $getdata['0']->scl_mode;
                $upperid = $getdata['0']->upper_reg_id;
                if($sclmode == 'GSB'){
                    $gbsid  = $upperid;
                    $usermode = 'admin';
                }else if($sclmode == 'GB'){
                    $usermode = 'superadmin';
                    $gbsid = '';
                }else if($sclmode == 'NB'){
                    $usermode = 'admin';
                    $gbsid = '';
                }

				//generate school mail id
				$schoolname  = $this->Model_integrate->initials($schooldata->schoolname);
				$alfnums =  random_string('alnum', 1);
				$studentname	= str_replace(' ','',$getdata[0]->fname);
				$generatemail = strtolower($this->generate_mails($studentname.date('m').$alfnums,$schoolname));


                //if ($updatecreg != 0) {
                    //licence key assigned
                    $licence = $this->Model_default->manualselect("SELECT * FROM `sms_productkeys` WHERE licence_status = 0 AND status = 1 ORDER BY id ASC LIMIT 1");
                    $licencekey = $licence['0']->licencekey;
                    $licenceid  = $licence['0']->id;

                    $user = explode('@',$getdata['0']->mailid);
                    $regdata = array(
                        'reg_id'        => $getdata[0]->reg_id,
                        'scl_mode'      => $getdata[0]->scl_mode,
                        'fname'         => $getdata[0]->fname,
                        'lname'         => $getdata[0]->lname,
                        'mailid'        => $getdata[0]->mailid,
                        'local_mail_id'	=>	$generatemail,
                        'mobile'        => $getdata[0]->mobile,
                        'password'      => md5($getdata[0]->otp),
                        'username'      => $user[0],
                        'usermode'      => $usermode,
                        'address'       => $getdata[0]->address,
                        'gbsid'         => $gbsid,
                        //'city'          => $getdata[0]->city,
                        'country_id'    =>  $getdata[0]->country_id,
                        'state_id'      =>  $getdata[0]->state_id,
                        'city_id'       =>  $getdata[0]->city_id,
                        'pincode'       => $getdata[0]->pincode,
                        //'aadhaar'       => $getdata[0]->aadhaar,
                        'accmode'       => 1,
                        'referral_code' =>  $getdata[0]->referral_code,
                        'ip_address'    => $this->getipaddress(),
                        'updated'       => date('Y-m-d H:i:s'),
                        'licence_id'    => $licenceid,
                    );

                    //check user exiesting or not by mail id
                    $checkreg = $this->Model_default->selectconduction('sms_regusers', array('reg_id' => $getdata['0']->reg_id, 'mailid' => $getdata['0']->mailid));

                    if(count($checkreg) == 0){
                        //insert data to sms_regusers when verifed
                        $insertdata = $this->Model_default->insertdata('sms_regusers',$regdata);
                        // print_r($insertdata);
                        // exit;
                        if ($insertdata != 0) {
                            //upudate reg confirm status
                            $setdata = array('cstatus' => 1,'updated' => date('Y-m-d H:i:s'));
                            $wheredata = array('conformcode'=> $code);
                            $updatecreg = $this->Model_default->updatedata('sms_reg',$setdata, $wheredata);            
                            //update licence table which can assign to user.. 
                            $licencewhere   =   array('id'=>$licenceid,'licencekey'=>$licencekey);
                            $licenceupdate  =   array('licence_status'=>1,'reg_id'=>$getdata['0']->reg_id);
                            $this->Model_default->updatedata('sms_productkeys',$licenceupdate,$licencewhere);
                            $this->session->set_flashdata('success', 'Your account as successfully activated..Login your account');
                            redirect(base_url());
                            //echo "Successfully redirect to login page";
                        }else{
                            $this->session->set_flashdata('error', 'Your account as not activated.Activate manual.');
                            redirect(base_url('register/conformaccount?access=' . $code . '&type=register'));
                            //echo "Failed to Activate account..redirect to manual activate page";
                        }
                    }else{
                        $this->session->set_flashdata('error', 'Your account as already activated..Please Login your account..!');
                        redirect(base_url());
                    }
                // } else {
                //     $this->session->set_flashdata('error', 'Your account as not activated.Activate manual.');
                //     redirect(base_url() . 'register/conformaccount?access=' . $code . '&type=activate');
                // }

            }else{
				$this->session->set_flashdata('error', 'OOPS ERROR..! invalid request.!');
				redirect(base_url());
            }

			/*else if((isset($type) && !empty($type)) && (isset($access) && !empty($access))){
            if($type == 'activate'){
                $data['code'] = array('type'=>'activate','access'=>$access);
            }else if($type=='register'){
                $data['code'] = array('type'=>'register','access'=>$access);
            }
            $data['scltypes'] = $this->Model_default->selectconduction('sms_formdata',array('type'=>'reg'));
            $data['getdata'] = $this->Model_default->selectconduction('sms_reg', array('conformcode' => $access));
            $data['PageTitle']  =   "Acativate account as manual method..! ";
            $this->load->view('setup/sms_conformregisteraccount',$data);
        	}*/

        }else{
			$this->session->set_flashdata('error', 'OOPS ERROR..! invalid request..! or Access token missing..!');
			redirect(base_url());
        }
    }

    //conform register account by manual process..
    public function conformmanualregister(){
        $code = $this->input->post('conformcode');
        $regid = $this->input->post('registerid');
        
        $getdata = $this->Model_default->selectconduction('sms_reg', array('otp' => $code,'reg_id'=>$regid));
        $sclmode = $getdata['0']->scl_mode;
        $upperid = $getdata['0']->upper_reg_id;
        
        
        if ((count($getdata) != 0) && ($getdata['0']->otp == $code) && ($getdata['0']->reg_id == $regid)) {

            $checkreg = $this->Model_default->selectconduction('sms_regusers', array('reg_id' => $getdata['0']->reg_id, 'mailid' => $getdata['0']->mailid));
            if(count($checkreg) == 0) {
                
                if($sclmode == 'GSB'){
                    $gbsid  = $upperid;
                    $usermode = 'admin';
                }else if($sclmode == 'GB'){
                    $usermode = 'superadmin';
                    $gbsid = '';
                }else if($sclmode == 'NB'){
                    $usermode = 'admin';
                    $gbsid = '';
                }

                //licence key assigned
                $licence = $this->Model_default->manualselect("SELECT * FROM `sms_productkeys` WHERE licence_status = 0 AND status = 1 ORDER BY id ASC LIMIT 1");
                $licencekey = $licence['0']->licencekey;
                $licenceid  = $licence['0']->id;

                $user = explode('@',$getdata['0']->mailid);


				//generate school mail id
				$schoolname  = $this->Model_integrate->initials($schooldata->schoolname);
				$alfnums =  random_string('alnum', 1);
				$studentname	= str_replace(' ','',$getdata[0]->fname);
				$generatemail = strtolower($this->generate_mails($studentname.date('m').$alfnums,$schoolname));

                $regdata = array(
                    'reg_id'        => $getdata['0']->reg_id,
                    'scl_mode'      => $getdata['0']->scl_mode,
                    'fname'         => $getdata['0']->fname,
                    'lname'         => $getdata['0']->lname,
                    'mailid'        => $getdata['0']->mailid,
                    'local_mail_id'	=>	$generatemail,
                    'mobile'        => $getdata['0']->mobile,
                    'password'      => md5($getdata['0']->otp),
                    'username'      => $user['0'],
                    'usermode'      => $usermode,
                    'address'       => $getdata['0']->address,
                    'gbsid'         => $gbsid,
                    //'city' => $getdata['0']->city,
                    'country_id'    => $getdata['0']->country_id,
                    'state_id'      => $getdata['0']->state_id,
                    'city_id'       => $getdata['0']->city_id,
                    'pincode'       => $getdata['0']->pincode,
                    //'aadhaar'       => $getdata['0']->aadhaar,
                    'accmode'       => 1,
                    'referral_code' =>  $getdata[0]->referral_code,
                    'ip_address'     => $this->getipaddress(),
                    'updated'       => date('Y-m-d H:i:s'),
                    'licence_id'    => $licenceid,
                );
                //insert user details sms_regusers
                $insertdata = $this->Model_default->insertdata('sms_regusers', $regdata);

                if ($insertdata != 0) {
                    //update status of reg verified user account
                    $setdata = array('cstatus' => 1, 'updated' => date('Y-m-d h:i:s'));
                    $wheredata = array('otp' => $code,'reg_id'=>$regid);
                    $updatecreg = $this->Model_default->updatedata('sms_reg',$setdata, $wheredata);
                    //update licence table which can assign to user.. 
                    $licencewhere  = array('id'=>$licenceid,'licencekey'=>$licencekey);
                    $licenceupdate = array('licence_status'=>1,'reg_id'=>$getdata['0']->reg_id);
                    $updatelicence = $this->Model_default->updatedata('sms_productkeys',$licenceupdate,$licencewhere);

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
            $url = base_url();
            $data = array('key'=>0,'message'=>'oops..! invalid request.! please try again.','url'=>$url);
        }

        echo json_encode($data);
    }

	//change password view page
	public function ChangePassword(){
        $data['userdata'] = $this->session->userdata['userdetails'];
		$data['pageTitle']	= 'Change Password & Set Pin.';
		$this->load->view('setup/sms_setcredenctionals',$data);
	}

    //change password via ajax or post
    public function saveChangePassword(){
        extract($_REQUEST);
        //$this->print_r($_REQUEST);
        //get register details from session -> userdetails
        $regdetails = $this->session->userdetails; 
        $regid      = $regdetails['reg_id'];
        $sclmode    = $regdetails['sclmode'];
        $type       = $regdetails['type'];

        //check the recieve password is valid or not
        if($type == 'superadmin' || $type == 'admin' || $type == 'super-admin') {
            $checkdata = $this->Model_default->selectconduction('sms_regusers', array('reg_id' => $regid, 'pwd_status' => 0, 'scl_mode' => $sclmode));
            $updatedata         = array('pwd_status' => 1,'password'=>md5($newpassword));
            $updateconduction   = array('reg_id' => $regid,'scl_mode'=>$sclmode);
            $tablename  =   'sms_regusers';
        }else{
            $checkdata = $this->Model_default->selectconduction('sms_users', array('id_num' => $regid, 'pwd_status' => 0, 'sno' => $regdetails['id']));
            $updatedata         = array('pwd_status' => 1,'password'=>md5($newpassword),'updated'=>date('Y-m-d H:i:s'));
            $updateconduction   = array('id_num' => $regid,'sno'=>$regdetails['id']);
            $tablename  =   'sms_users';
        }
        //password encrypt by md5->temp and hash->perment
        $md5pwd = md5($oldpassword);
//        $this->print_r($checkdata);
//        exit;
        //print_r($md5pwd);
        // print_r($checkdata['0']->password);
        // exit();
        //$hashpwd = $this->Model_integrate->verifyhashpassword($oldpassword,$checkdata['0']->password);
        //checking password is correct(maching) or work
        if($md5pwd != $checkdata['0']->password){
            //send reponce data to user access
            $data = array('key' =>0,'message'=>'please enter correct old password..');

        }else if($md5pwd == $checkdata['0']->password){
            //update password and password status
            $update = $this->Model_default->updatedata($tablename,$updatedata,$updateconduction);
            if($update != 0){
                $url = base_url().'changecredentials?pin';
                $data = array('key' =>1,'message'=>'Password successfully changed.','url'=>$url);
            }else{
                $url = base_url().'changecredentials?password';
                $data = array('key' =>0,'message'=>'Failed to change password.try again.','url'=>$url);
            }
        }
    
        echo json_encode($data);
    }

    //create 4 digits pin number
    public function saveChangePinNumber($value=''){
        extract($_REQUEST);
        //get register details from session -> userdetails
        $regdetails = $this->session->userdetails; 
        $regid      = $regdetails['reg_id'];
        $sclmode    = $regdetails['sclmode'];
        $type       = $regdetails['type'];
        if($type == 'superadmin' || $type == 'admin' || $type == 'super-admin') {
            $checkdata = $this->Model_default->selectconduction('sms_regusers', array('reg_id' => $regid, 'pwd_status' => 0, 'scl_mode' => $sclmode));
            $updatedata         = array('pinnum'=>$setpinnumber);
            $updateconduction   = array('reg_id' => $regid,'scl_mode'=>$sclmode);
            $tablename  =   'sms_regusers';
        }else{
            $checkdata = $this->Model_default->selectconduction('sms_users', array('id_num' => $regid, 'pwd_status' => 0, 'sno' => $regdetails['id']));
            $updatedata         = array('pinnum'=>$setpinnumber,'updated'=>date('Y-m-d H:i:s'));
            $updateconduction   = array('id_num' => $regid,'sno'=>$regdetails['id']);
            $tablename  =   'sms_users';
        }
        //create pin number
        $update = $this->Model_default->updatedata($tablename,$updatedata,$updateconduction);
        if($update != 0){
            $url = base_url();
            $data = array('key' =>1,'message'=>'Successfully created pin number. Ok to Login','url'=>$url);
            $this->session->sess_destroy();
        }else{
            $url = base_url();
            $data = array('key' =>0,'message'=>'Failed to create 4 digits pin.','url'=>$url);
        }
        echo json_encode($data);
    }

    //logout page for successfully logout
    public function logoutaccesspage(){
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        //$this->Model_integrate->generateproductkeys();
        $data['pageTitle']	= 'Successfully logout..!';
        $this->load->view('logout_login_page',$data);
    }

    //session destroy
    public function logout(){
        //$this->session->sess_destroy();
		$userlogindata = $this->session->userdata();
		$logdata = $userlogindata['logdata'];
		//$this->print_r($userlogindata);
		$conduction	=array('branch_id'=>$logdata['branch_id'],'school_id'=>$logdata['school_id'],'id_num'=>$logdata['id_num'],'login_date'=>$logdata['login_date'],'login_time'=>$logdata['login_time']);
		$logoutdata = array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
		$updatedata = $this->Model_dashboard->updatedata($logoutdata,$conduction,'sms_users_logs');
		$previouslink = $this->previous_page();

		if($updatedata != 0) {
			$sessionArray = array('id', 'regid', 'type', 'sclmode', 'licenceid', 'licenceplan', 'school', 'batch', 'isLoggedIn');
			$this->session->unset_userdata($sessionArray);
			$this->session->set_flashdata('success', 'Your account is successfully Logout..!');
			//$this->logoutaccesspage();
			redirect(base_url());
		}else{
			$this->session->set_flashdata('success', 'Your account is failed to Logout..!');
			$this->session->set_flashdata('text', 'Failed to logout. Please try again or contact customer support..!');
			redirect($previouslink);
		}
    }
}
