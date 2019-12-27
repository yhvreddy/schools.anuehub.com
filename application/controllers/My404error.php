<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require APPPATH . '/libraries/BaseController.php';
class My404error extends CI_Controller{
	
    public function __construct() { 
      parent::__construct(); // load base_url 
      $this->load->helper('url'); 
   }
 
   public function index(){ 
   	$data['pageTitle']	=	'School Management';
      $this->output->set_status_header('404'); 
      $this->load->view('error404',$data); 
   } 
}