<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Register extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }

    //register new account
    public function index($externaldata = NULL){
        $data['PageTitle'] = 'Register account';
        $data['scltypes'] = $this->Model_default->selectconduction('sms_formdata',array('type'=>'reg'));
        $data['countries'] = $this->Model_default->selectconduction('sms_countries',array('status'=>1));
        $this->load->view('setup/sms_registeraccount',$data);
        $genkey=$this->Model_integrate->generateproductkeys();
    }

   
    
    
}