<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_profile extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }

    public function index(){
        $this->profilepage();
    }

    public function profilepage(){
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id = $data['school_id'] =   $details['school']->school_id;
		$branch_id = $data['branch_id'] =   $details['school']->branch_id;
		$school_academic = $details['school']->school_academic;
		$school_academic_form_to    =   $details['school']->school_academic_form_to;
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Profile Details..!";
		$data['scltypes'] = $this->Model_default->selectconduction('sms_formdata',array('type'=>'reg'));
		$data['countries'] = $this->Model_default->selectconduction('sms_countries',array('status'=>1));
        $this->loadViews('admin/profile/sms_profile',$data);
    }

    public function updateProfileData(){
        extract($_REQUEST);
        //$this->print_r($_REQUEST);
        //$this->print_r($_FILES);
        //exit;
        $userdata = $this->Model_default->selectconduction('sms_regusers',array('sno'=>$id,'reg_id'=>$reg_id));
        //$this->print_r($userdata);
        if(count($userdata) != 0){
            
            if(!empty($_FILES['profileimage']['name'])){
                $path = 'uploads/registerusers/'.$reg_id.'/';
                $this->createdir($path,$path);
                $uploadimage = $this->uploadfiles($path,'profileimage','jpg|png|jpeg',TRUE,'','');
                //$this->print_r($uploadimage);
                if($uploadimage['status'] == 1){
                    $upload = $path.$uploadimage['uploaddata']['file_name'];
                }else{
                    if($uploadedProfileImage != ''){
                        $upload = $uploadedProfileImage;
                    }else{
                        $upload = '';
                    }
                }
            }else{
                $upload = $uploadedProfileImage;
            }
            $conduction =   array('sno'=>$id,'reg_id'=>$reg_id);
            $updatedata =   array(
                'fname'         =>  $firstname,
                'lname'         =>  $lastname,
                'mailid'        =>  $email,
                'mobile'        =>  $mobile,
                'country_id'    =>  $CountryName,
                'state_id'      =>  $StateName,
                'city_id'       =>  $CityName,
                'address'       =>  $Address,
                'pincode'       =>  $pincode,
                'updated'       =>  date('Y-m-d H:i:s'),
                'profile_pic'   =>  $upload
            );
            $updatedetails = $this->Model_dashboard->updatedata($updatedata,$conduction,'sms_regusers');
            if($updatedetails != 0){
				$this->Model_dashboard->updatedata(array('mailid'=>$email,'updated' => date('Y-m-d H:i:s')),array('reg_id'=>$reg_id),'sms_reg');
                $this->successalert('Successfully Update Details..!',$firstname.' details as updated successfully..!');
                redirect(base_url('dashboard/profile?update=success'));
            }else{
                $this->failedalert('Failed to Update Details..!',$firstname.' details as failed to updated..!');
                redirect(base_url('dashboard/profile?update=failed'));
            }
        }else{
            //other users to update profile
        }
    }
    
    public function updatePassword(){
        extract($_REQUEST);
        //$this->print_r($_REQUEST);
        $userdata = $this->Model_default->selectconduction('sms_regusers',array('sno'=>$id,'reg_id'=>$reg_id));
//        $this->print_r($userdata);
//        exit;
        if(count($userdata) != 0){
            if($userdata[0]->password == md5($old_password)){
                
                if($new_password == $confirm_password){
                    $conduction =   array('sno'=>$id,'reg_id'=>$reg_id);
                    $updatedata =   array(
                        'password'         =>  md5($new_password),
                        'updated'          =>  date('Y-m-d H:i:s'),
                    );
                    $updatedetails = $this->Model_dashboard->updatedata($updatedata,$conduction,'sms_regusers');
                    if($updatedetails != 0){
                        $this->successalert('Successfully Update Details..!',$userdata[0]->fname.' details as updated successfully..!');
                        $this->logout();
                        //redirect(base_url('dashboard/profile?update=success'));
                    }else{
                        $this->failedalert('Failed to Update Details..!',$userdata[0]->fname.' details as failed to update..!');
                        redirect(base_url('dashboard/profile?update=failed'));
                    }
                }else{
                     $this->failedalert('Failed to Update Details..!',$userdata[0]->fname.' please check new password & confirm password must be same..!');
                     redirect(base_url('dashboard/profile?update=failed'));
                }
                
            }else{
                $this->failedalert('Failed to Update Details..!',$userdata[0]->fname.' please enter currect  old password..!');
                redirect(base_url('dashboard/profile?update=failed'));
            }
            
                    
        }else{
            //other users to update profile
        }
    }
    
    public function updateSchooldetails(){
        extract($_REQUEST);
        $userdata = $this->Model_default->selectconduction('sms_regusers',array('reg_id'=>$reg_id));
        $schooldata = $this->Model_default->selectconduction('sms_schoolinfo',array('reg_id'=>$reg_id,'school_id'=>$school_id,'branch_id'=>$branch_id));
        $spiltname  = $this->Model_integrate->initials($school_name);
        
        if(count($userdata) != 0 && count($schooldata) != 0){
            //upload logo
            if(!empty($_FILES['school_logo']['name'])){
                $path = 'uploads/files/schooldata/logos/'.$branch_id.'/'.$school_id.'/';
                $this->createdir($path,$path);
                $uploadimage = $this->uploadfiles($path,'school_logo','jpg|png|jpeg',TRUE,'','');
                //$this->print_r($uploadimage);
                if($uploadimage['status'] == 1){
                    $upload = $path.$uploadimage['uploaddata']['file_name'];
                }else{
                    if($school_uploaded_logo != ''){
                        $uploadschool_logo = $school_uploaded_logo;
                    }else{
                        $uploadschool_logo = $school_uploaded_logo;
                    }
                }
            }else{
                $uploadschool_logo = $school_uploaded_logo;
            }
            //upload stamp pad
            if(!empty($_FILES['school_stamp_pad']['name'])){
                $path = 'uploads/files/schooldata/stamp_pads/'.$branch_id.'/'.$school_id.'/';
                $this->createdir($path,$path);
                $uploadimage = $this->uploadfiles($path,'school_stamp_pad','jpg|png|jpeg',TRUE,'','');
                //$this->print_r($uploadimage);
                if($uploadimage['status'] == 1){
                    $stamp_upload = $path.$uploadimage['uploaddata']['file_name'];
                }else{
                    if($school_uploaded_stamppad != ''){
                        $stamp_upload = $school_uploaded_stamppad;
                    }else{
                        $stamp_upload = $school_uploaded_stamppad;
                    }
                }
            }else{
                $stamp_upload = $school_uploaded_stamppad;
            }
           
            $conduction =   array('sno'=>$id,'reg_id'=>$reg_id,'school_id'=>$school_id,'branch_id'=>$branch_id);
            $updatedata = array(
                'schoolname'        =>  $school_name,
                'school_logo'       =>  $uploadschool_logo,
                'school_mobile'     =>  $school_mobile,
                'school_phone'      =>  $school_phone_number,
                'school_mail'       =>  $school_mail_id,
                'country_id'        =>  $sclCountryName,
                'state_id'          =>  $sclStateName,
                'city_id'           =>  $sclCityName,
                'school_address'    =>  $school_address,
                'school_pincode'    =>  $school_pincode,
                'school_tinnumber'  =>  $govt_reg_id,
                'branchname'        =>  $school_branch_name,
                'displayname'       =>  $spiltname,
                'updated'           =>  date('Y-m-d H:i:s'),
                'school_website'    =>  $school_website,
                'stamp_pad'         =>  $stamp_upload
            );
            $updatedetails = $this->Model_dashboard->updatedata($updatedata,$conduction,'sms_schoolinfo');
            if($updatedetails != 0){
                $this->successalert('Successfully Update Details..!',$school_name.' details as updated successfully..!');
                redirect(base_url('dashboard/profile?update=success'));
            }else{
                $this->failedalert('Failed to Update Details..!',$school_name.' details as failed to updated..!');
                redirect(base_url('dashboard/profile?update=failed'));
            }
        }else{
            $this->failedalert('Failed to Update Details..!',$school_name.' details not found or Invalid request..!');
            redirect(base_url('dashboard/profile?update=invalid-request'));
        }
    }
}
