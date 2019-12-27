<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Forget_password extends BaseController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
	}

	//login account access page
    public function index(){
        $this->forgetpassword();
	}

    //forgetpassword
	public function forgetpassword(){
		$data['pageTitle']	= 'Forget password to reset..!';
		$this->load->view('forgetpassword_page',$data);
	}

	//save and send forget pasword request..
	public function savepasswordrequest(){
		error_reporting(0);
		extract($_REQUEST);

		$studentdata = $this->Model_default->manualselect("SELECT * FROM sms_admissions WHERE mail_id = '$reg_email' OR local_mail_id = '$reg_email'");
		if(count($studentdata) == 0){
			$employeedata = $this->Model_default->manualselect("SELECT * FROM sms_employee WHERE mail_id = '$reg_email' OR local_mail_id = '$reg_email'");
			if(count($employeedata) == 0){
				$registerusers 	= 	$this->Model_default->selectdata('sms_regusers',array('mailid'=> $reg_email));
				$usersdata	=	$registerusers['0'];
				$schooldetails	=	$this->Model_default->selectdata('sms_schoolinfo',array('reg_id'=> $usersdata->reg_id));
				$schooldetails	=	$schooldetails[0];
				$id_num	=	$usersdata->reg_id;
				$school_id	=	$schooldetails->school_id;
				$branch_id	=	$schooldetails->branch_id;
			}else{
				$usersdata	=	$employeedata['0'];
				$id_num	=	$usersdata->id_num;
				$school_id	=	$usersdata->school_id;
				$branch_id	=	$usersdata->branch_id;
			}
		}else{
			$usersdata	=	$studentdata['0'];
			$id_num	=	$usersdata->id_num;
			$school_id	=	$usersdata->school_id;
			$branch_id	=	$usersdata->branch_id;
		}


		if(count($usersdata)){
			//sms_forget_password_request
			$token = md5(uniqid(rand(), true));
			$requestdata = array(
				'school_id'		=>	$school_id,
				'branch_id'     =>	$branch_id,
				'id_num'        =>	$id_num,
				'id'            =>	$usersdata->sno,
				'mail_id'		=>	$reg_email,
				'token_id'      =>	$token,
				'request_type'	=>	'password',
				'request_date'  =>	date('Y-m-d H:i:s'),
				'updated'       =>	date('Y-m-d H:i:s')
			);
			
			$newrequest = $this->Model_dashboard->insertdata('sms_forget_password_request',$requestdata);

			if($newrequest != 0){
				$maildata['requesturl'] = base_url('users/changepassword/'.$newrequest.'/'.$branch_id.'/'.$school_id.'/'.$usersdata->sno.'/'.$id_num.'?token='.$token);
				$maildata['userdetails'] = $usersdata;
				$this->sendemail('email/mail_resetpassword_request',$maildata,'info@anuehub.online',$reg_email,'Reg : Request to reset your password..!');
				$this->session->set_flashdata('success','Your request as successfully taken.Please check your mail.');
				redirect(base_url());
			}else{
				$this->session->set_flashdata('error','Sorry we are unable to take your request right now.please try later..!');
				redirect(base_url('users/forgetpassword'));
			}

		}else{
			$this->session->set_flashdata('error','Please enter your register mail id..!');
			redirect(base_url('users/forgetpassword'));
		}

	}

	//Change password
	public function Changepassword(){
		extract($_REQUEST);
		$one 	= $this->uri->segment(3);   //request id
		$two 	= $this->uri->segment(4);   //branch id
		$three 	= $this->uri->segment(5);   //school id
		$four 	= $this->uri->segment(6);   //user sno
		$five 	= $this->uri->segment(7);   //user id_num
		
		if((isset($one) && $one != '') && (isset($two) && $two != '') && (isset($three) && $three != '') && (isset($four) && $four != '') && (isset($token) && $token!= '') && (isset($five) && $five != '')) {
			$regusers = $this->Model_default->selectconduction('sms_forget_password_request',array('token_id'=>$token,'sno'=>$one,'branch_id'=>$two,'school_id'=>$three,'id_num'=>$five,'id'=>$four));
			if(count($regusers) != 0) {
				$data['pageTitle'] 	= 'Change Account Password.';
				$data['sno_id'] 	= $regusers[0]->id;
				$data['mail_id'] 	= $regusers[0]->mail_id;
				$data['id_num'] 	= $regusers[0]->id_num;
				$data['token_id'] 	= $token;
				$this->load->view('changepassword_page', $data);
			}else{
				$this->session->set_flashdata('error', 'Invalid Request to change password');
				redirect('users/forgetpassword');
			}
		}else{
			$this->session->set_flashdata('error', 'Invalid Request to change password');
			redirect('users/forgetpassword');
		}
	}

	//save new Change Password
	public function saveChangePassword(){
		error_reporting(0);
		extract($_REQUEST);
		$reg_idnum = $id_num;
		$request = $this->Model_default->selectdata('sms_forget_password_request',array('mail_id' => $mail_id,'token_id' => $token_id,'id' => $sno_id,'id_num'=>$id_num,'status'=>1,'used'=>0));
		$requestconduction  = array('mail_id' => $mail_id,'token_id' => $token_id,'id' => $sno_id,'id_num'=>$id_num,'status'=>1,'used'=>0);
		$requestupdatedata  = array('status'=>0,'used'=>1,'updated'=>date('Y-m-d H:i:s'));
		$requesttablename	=	'sms_forget_password_request';

		if(count($request) != 0) {

			$studentdata = $this->Model_default->manualselect("SELECT * FROM sms_admissions WHERE (mail_id = '$mail_id' OR local_mail_id = '$mail_id') AND sno = $sno_id AND id_num = '$reg_idnum'");
			if (count($studentdata) == 0) {

				$employeedata = $this->Model_default->manualselect("SELECT * FROM sms_employee WHERE (mail_id = '$mail_id' OR local_mail_id = '$mail_id') AND sno = $sno_id AND id_num = '$reg_idnum'");
				if (count($employeedata) == 0) {
					$registerusers = $this->Model_default->selectdata('sms_regusers', array('mailid' => $mail_id, 'sno' => $sno_id, 'reg_id' => $reg_idnum));
					$usersdata = $registerusers['0'];
					$schooldetails = $this->Model_default->selectdata('sms_schoolinfo', array('reg_id' => $usersdata->reg_id));
					$schooldetails = $schooldetails[0];
					$id_num = $usersdata->reg_id;
					$school_id = $schooldetails->school_id;
					$branch_id = $schooldetails->branch_id;
					$updateconduction 	= 	array('sno' => $sno_id,'reg_id' => $reg_idnum,'mailid' => $mail_id);
					$updatapassword		=	array('password'=>md5($new_password),'updated'=>date('Y-m-d H:i:s'));
					$updatetablename	=	'sms_regusers';
					
				}else{
					$usersdata = $employeedata['0'];
					$id_num = $usersdata->id_num;
					$school_id = $usersdata->school_id;
					$branch_id = $usersdata->branch_id;
					$updateconduction 	= 	array('id_num' => $reg_idnum,'school_id'=>$school_id,'branch_id'=>$branch_id);
					$updatapassword		=	array('password'=>md5($new_password),'updated'=>date('Y-m-d H:i:s'));
					$updatetablename	=	'sms_users';
				}
			}else{
				$usersdata = $studentdata['0'];
				$id_num = $usersdata->id_num;
				$school_id = $usersdata->school_id;
				$branch_id = $usersdata->branch_id;
				$updateconduction 	= 	array('id_num' => $reg_idnum,'school_id'=>$school_id,'branch_id'=>$branch_id);
				$updatapassword		=	array('password'=>md5($new_password),'updated'=>date('Y-m-d H:i:s'));
				$updatetablename	=	'sms_users';
			}

			if(count($usersdata) != 0) {
				if ($new_password === $confirm_password) {
					$updata = $this->Model_default->updatedata($updatetablename,$updatapassword,$updateconduction);
					if($updata != 0){
						$this->Model_default->updatedata($requesttablename,$requestupdatedata,$requestconduction);
						$this->session->set_flashdata('success', 'Your account Password successfully changed.');
						redirect(base_url());
					}else{
						$this->session->set_flashdata('error', 'Failed to change Account password.please try again.');
						redirect('users/forgetpassword');
					}
				} else {
					$this->session->set_flashdata('error', 'New Passowrd and confirm password should be same.');
					redirect($this->previous_page());
				}
			}
			
		}else{
			$this->session->set_flashdata('error', 'Failed to change Account password.Invalid request..!');
			redirect(base_url());
		}

	}

	//forget 4digits pin
	public function Forgetpin(){
		$data['pageTitle']	= 'Forget 4-digits pin to reset..!';
		$this->load->view('forgetpin_page',$data);
	}

	//save and send forget 4 digits pin
	public function savePinRequest(){
		error_reporting(0);
		extract($_REQUEST);

		$studentdata = $this->Model_default->manualselect("SELECT * FROM sms_admissions WHERE mail_id = '$reg_email' OR local_mail_id = '$reg_email'");
		if(count($studentdata) == 0){
			$employeedata = $this->Model_default->manualselect("SELECT * FROM sms_employee WHERE mail_id = '$reg_email' OR local_mail_id = '$reg_email'");
			if(count($employeedata) == 0){
				$registerusers 	= 	$this->Model_default->selectdata('sms_regusers',array('mailid'=> $reg_email));
				$usersdata	=	$registerusers['0'];
				$schooldetails	=	$this->Model_default->selectdata('sms_schoolinfo',array('reg_id'=> $usersdata->reg_id));
				$schooldetails	=	$schooldetails[0];
				$id_num	=	$usersdata->reg_id;
				$school_id	=	$schooldetails->school_id;
				$branch_id	=	$schooldetails->branch_id;
			}else{
				$usersdata	=	$employeedata['0'];
				$id_num	=	$usersdata->id_num;
				$school_id	=	$usersdata->school_id;
				$branch_id	=	$usersdata->branch_id;
			}
		}else{
			$usersdata	=	$studentdata['0'];
			$id_num	=	$usersdata->id_num;
			$school_id	=	$usersdata->school_id;
			$branch_id	=	$usersdata->branch_id;
		}

		if(count($usersdata)){
			//sms_forget_password_request
			$token = md5(uniqid(rand(), true));
			$requestdata = array(
				'school_id'		=>	$school_id,
				'branch_id'     =>	$branch_id,
				'id_num'        =>	$id_num,
				'id'            =>	$usersdata->sno,
				'mail_id'		=>	$reg_email,
				'token_id'      =>	$token,
				'request_type'	=>	'pin',
				'request_date'  =>	date('Y-m-d H:i:s'),
				'updated'       =>	date('Y-m-d H:i:s')
			);

			$newrequest = $this->Model_dashboard->insertdata('sms_forget_password_request',$requestdata);

			if($newrequest != 0){
				$maildata['requesturl'] = base_url('users/changepin/'.$newrequest.'/'.$branch_id.'/'.$school_id.'/'.$usersdata->sno.'/'.$id_num.'?token='.$token);
				$maildata['userdetails'] = $usersdata;
				$this->sendemail('email/mail_resetpin_request',$maildata,'info@anuehub.online',$reg_email,'Reg : Request to reset your 4-digits pin..!');
				$this->session->set_flashdata('success','Your request as successfully taken.Please check your mail.');
				redirect(base_url());
			}else{
				$this->session->set_flashdata('error','Sorry we are unable to take your request right now.please try later..!');
				redirect(base_url('users/forgetpin'));
			}

		}else{
			$this->session->set_flashdata('error','Please enter your register mail id..!');
			redirect(base_url('users/forgetpin'));
		}

	}

	//Change pin
	public function ChangePin(){
		extract($_REQUEST);
		$one 	= $this->uri->segment(3);   //request id
		$two 	= $this->uri->segment(4);   //branch id
		$three 	= $this->uri->segment(5);   //school id
		$four 	= $this->uri->segment(6);   //user sno
		$five 	= $this->uri->segment(7);   //user id_num

		if((isset($one) && $one != '') && (isset($two) && $two != '') && (isset($three) && $three != '') && (isset($four) && $four != '') && (isset($token) && $token!= '') && (isset($five) && $five != '')) {
			$regusers = $this->Model_default->selectconduction('sms_forget_password_request',array('token_id'=>$token,'sno'=>$one,'branch_id'=>$two,'school_id'=>$three,'id_num'=>$five,'id'=>$four));
			if(count($regusers) != 0) {
				$data['pageTitle'] 	= 'Change Account 4-digits pin.';
				$data['sno_id'] 	= $regusers[0]->id;
				$data['mail_id'] 	= $regusers[0]->mail_id;
				$data['id_num'] 	= $regusers[0]->id_num;
				$data['token_id'] 	= $token;
				$this->load->view('changepin_page', $data);
			}else{
				$this->session->set_flashdata('error', 'Invalid Request to change 4-digits pin');
				redirect('users/forgetpin');
			}
		}else{
			$this->session->set_flashdata('error', 'Invalid Request to change 4-digits pin');
			redirect('users/forgetpin');
		}
	}

	//save new Change Pin
	public function saveChangePin(){
		error_reporting(0);
		extract($_REQUEST);
		$reg_idnum = $id_num;

		$request = $this->Model_default->selectdata('sms_forget_password_request',array('mail_id' => $mail_id,'token_id' => $token_id,'id' => $sno_id,'id_num'=>$id_num,'status'=>1,'used'=>0));
		$requestconduction  = array('mail_id' => $mail_id,'token_id' => $token_id,'id' => $sno_id,'id_num'=>$id_num,'status'=>1,'used'=>0);
		$requestupdatedata  = array('status'=>0,'used'=>1,'updated'=>date('Y-m-d H:i:s'));
		$requesttablename	=	'sms_forget_password_request';

		if(count($request) != 0) {

			$studentdata = $this->Model_default->manualselect("SELECT * FROM sms_admissions WHERE (mail_id = '$mail_id' OR local_mail_id = '$mail_id') AND sno = $sno_id AND id_num = '$reg_idnum'");
			if (count($studentdata) == 0) {

				$employeedata = $this->Model_default->manualselect("SELECT * FROM sms_employee WHERE (mail_id = '$mail_id' OR local_mail_id = '$mail_id') AND sno = $sno_id AND id_num = '$reg_idnum'");
				if (count($employeedata) == 0) {
					$registerusers = $this->Model_default->selectdata('sms_regusers', array('mailid' => $mail_id, 'sno' => $sno_id, 'reg_id' => $reg_idnum));
					$usersdata = $registerusers['0'];
					$schooldetails = $this->Model_default->selectdata('sms_schoolinfo', array('reg_id' => $usersdata->reg_id));
					$schooldetails = $schooldetails[0];
					$id_num = $usersdata->reg_id;
					$school_id = $schooldetails->school_id;
					$branch_id = $schooldetails->branch_id;
					$updateconduction 	= 	array('sno' => $sno_id,'reg_id' => $reg_idnum,'mailid' => $mail_id);
					$updatapassword		=	array('pinnum'=>$new_pin,'updated'=>date('Y-m-d H:i:s'));
					$updatetablename	=	'sms_regusers';

				}else{
					$usersdata = $employeedata['0'];
					$id_num = $usersdata->id_num;
					$school_id = $usersdata->school_id;
					$branch_id = $usersdata->branch_id;
					$updateconduction 	= 	array('id_num' => $reg_idnum,'school_id'=>$school_id,'branch_id'=>$branch_id);
					$updatapassword		=	array('pinnum'=>$new_pin,'updated'=>date('Y-m-d H:i:s'));
					$updatetablename	=	'sms_users';
				}
			}else{
				$usersdata = $studentdata['0'];
				$id_num = $usersdata->id_num;
				$school_id = $usersdata->school_id;
				$branch_id = $usersdata->branch_id;
				$updateconduction 	= 	array('id_num' => $reg_idnum,'school_id'=>$school_id,'branch_id'=>$branch_id);
				$updatapassword		=	array('pinnum'=>$new_pin,'updated'=>date('Y-m-d H:i:s'));
				$updatetablename	=	'sms_users';
			}

			if(count($usersdata) != 0) {
				if ($new_pin === $confirm_pin) {
					$updata = $this->Model_default->updatedata($updatetablename,$updatapassword,$updateconduction);
					if($updata != 0){
						$this->Model_default->updatedata($requesttablename,$requestupdatedata,$requestconduction);
						$this->session->set_flashdata('success', 'Your account pin successfully changed.');
						redirect(base_url());
					}else{
						$this->session->set_flashdata('error', 'Failed to change Account pin.please try again.');
						redirect('users/forgetpin');
					}
				} else {
					$this->session->set_flashdata('error', 'New pin and confirm pin should be same.');
					redirect($this->previous_page());
				}
			}

		}else{
			$this->session->set_flashdata('error', 'Failed to change Account pin.Invalid request..!');
			redirect(base_url());
		}

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
		$this->print_r($userlogindata);
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
