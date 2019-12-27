<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_importexport extends BaseController{

	public $array = array();
	public function __construct(){
		parent::__construct();
		$this->isLoggedIn();
		$this->load->model('Model_default');
		$this->load->model('Model_integrate');
		$this->load->model('Model_dashboard');
		// load excel library
		$this->load->library('excel');
	}



	public function index(){
		$this->exportData();
	}

	public function exportData(){
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id = $data['school_id'] =   $details['school']->school_id;
		$branch_id = $data['branch_id'] =   $details['school']->branch_id;
		$school_academic = $details['school']->school_academic;
		$school_academic_form_to    =   $details['school']->school_academic_form_to;
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Export Data..!";
		$data['syllabus']   = $this->Model_dashboard->syllabustypes($school_id,$branch_id);
		$data['gender']     = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'gender','status'=>1));
		$data['employee']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'employee','status'=>1));
		$data['staff']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'staff','status'=>1));
		$data['worker']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'worker','status'=>1));
		$data['office']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'office','status'=>1));
		$this->loadViews('admin/imports_exports/sms_exports_page',$data);
	}

	public function RequestSendData(){
		//error_reporting(0);
		extract($_REQUEST);
		//sessions unset
		$admissions     = 	$this->session->userdata('accessdata');
		$enquirylist    = 	$this->session->userdata('enquerydata');
		$feelistdata	=	$this->session->userdata('feelistdata');
		if(isset($admissions)){ $this->session->unset_userdata('accessdata'); }
		if(isset($enquirylist)){ $this->session->unset_userdata('enquerydata'); }
		if(isset($feelistdata)){ $this->session->unset_userdata('feelistdata'); }

		//$this->print_r($_REQUEST);

		if(!empty($from_date)){ $from_date = date('Y-m-d',strtotime($from_date)); }
		if(!empty($to_date)){ $to_date = date('Y-m-d',strtotime($to_date)); }

		if(!empty($from_month)){ $from_month = date('Y-m',strtotime($from_month)); }
		if(!empty($to_month)){ $to_month = date('Y-m',strtotime($to_month)); }

		//header('Content-Type: application/json');
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id = $data['school_id'] =   $details['school']->school_id;
		$branch_id = $data['branch_id'] =   $details['school']->branch_id;
		$school_academic = $details['school']->school_academic;
		$school_academic_form_to    =   $details['school']->school_academic_form_to;
		$userdata = $this->Model_integrate->userdata();
		$academicyear = $this->Model_integrate->academicyear($school_academic_form_to);
		$batch = $academicyear[0]->academic_year; //adminssion accadmic batch

		if($export_type == 1 && $sorted_type == 'A0'){
			//admission list all
			$admissions = $this->Model_dashboard->selectdata('sms_admissions',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch),'updated,sno');
			$title = 'of batch '.$batch;
			$this->admissionsviews($title,$admissions);
			$this->session->set_userdata('accessdata',$admissions);
		}else if($export_type == 1 && $sorted_type == 'A1'){

			//data based on conductions
			if($selected_gender == 'all' && ($StdSyllubas == '' && $StdClass == '' && $from_date == '' && $to_date == '')){
				$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch);
				$title = 'gender : all';
			}else if(($selected_gender == 'M' || $selected_gender == 'FM') && ($StdSyllubas == '' && $StdClass == '' && $from_date == '' && $to_date == '')){
				$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch,'gender'=>$selected_gender);
				if($selected_gender == 'M'){ $gender = 'Male'; }else if($selected_gender == 'FM'){ $gender = 'Female'; }
				$title = 'Gender : '.$gender;
			}else if($StdSyllubas != '' && $StdClass == '' && $selected_gender == '' && $from_date == '' && $to_date == ''){
				$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch,'class_type'=>$StdSyllubas);
				$syllubas = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$StdSyllubas),'id');
				$title = 'Syllubas : '.$syllubas[0]->type;
			}else if($StdSyllubas != '' && $StdClass != '' && $selected_gender == '' && $from_date == '' && $to_date == ''){
				$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch,'class_type'=>$StdSyllubas,'class'=>$StdClass);
				$syllubas = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$StdSyllubas),'id');
				$title = 'Syllubas : '.$syllubas[0]->type.' - Class : '.$StdClass;
			}else if($StdSyllubas != '' && $StdClass != '' && $selected_gender != '' && $from_date == '' && $to_date == ''){
				if($selected_gender == 'all'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch,'class_type'=>$StdSyllubas,'class'=>$StdClass);

				}else if($selected_gender == 'M' || $selected_gender == 'FM'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch,'class_type'=>$StdSyllubas,'class'=>$StdClass,'gender'=>$selected_gender);
				}
				if($selected_gender == 'M'){ $gender = 'Male'; }else if($selected_gender == 'FM'){ $gender = 'Female'; }else if($selected_gender == 'all'){ $gender ='All'; }
				$syllubas = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$StdSyllubas),'id');
				$title = 'Gender : '.$gender.' - Syllubas : '.$syllubas[0]->type.' - Class : '.$StdClass;
			}else if($StdSyllubas != '' && $StdClass == '' && $selected_gender != '' && $from_date == '' && $to_date == ''){
				if($selected_gender == 'all'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch,'class_type'=>$StdSyllubas);

				}else if($selected_gender == 'M' || $selected_gender == 'FM'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch,'class_type'=>$StdSyllubas,'gender'=>$selected_gender);
				}
				if($selected_gender == 'M'){ $gender = 'Male'; }else if($selected_gender == 'FM'){ $gender = 'Female'; }else if($selected_gender == 'all'){ $gender ='All'; }
				$syllubas = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$StdSyllubas),'id');
				$title = 'Gender : '.$gender.' - Syllubas : '.$syllubas[0]->type;
			}else if($from_date != '' && $to_date == '' && $StdSyllubas == '' && $StdClass == '' && $selected_gender == '')
			{
				$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch,'DATE(created)'=>$from_date);
				$title = 'Date : '.$from_date;
			}else if($from_date != '' && $to_date != '' && $StdSyllubas == '' && $StdClass == '' && $selected_gender == '')
			{
				$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch,'DATE(created) >='=>$from_date,'DATE(created) <='=>$to_date);
				$title = 'Date From : '.$from_date.' - To : '.$to_date;
			}else if($from_date != '' && $to_date != '' && $StdSyllubas == '' && $StdClass == '' && $selected_gender != ''){
				if($selected_gender == 'all'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch,'DATE(created) >='=>$from_date,'DATE(created) <='=>$to_date);

				}else if($selected_gender == 'M' || $selected_gender == 'FM'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch,'DATE(created) >='=>$from_date,'DATE(created) <='=>$to_date,'gender'=>$selected_gender);
				}
				if($selected_gender == 'M'){ $gender = 'Male'; }else if($selected_gender == 'FM'){ $gender = 'Female'; }else if($selected_gender == 'all'){ $gender ='All'; }
				$title = 'Gender : '.$gender.', Date From : '.$from_date.' - To : '.$to_date;
			}else if($from_date != '' && $to_date != '' && $StdSyllubas != '' && $StdClass == '' && $selected_gender != ''){
				if($selected_gender == 'all'){
					$conduction = array('branch_id'=>$branch_id, 'school_id'=>$school_id, 'status'=>1, 'batch'=>$batch, 'DATE(created) >='=>$from_date,'DATE(created) <='=>$to_date, 'class_type'=>$StdSyllubas);

				}else if($selected_gender == 'M' || $selected_gender == 'FM'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch,'DATE(created) >='=>$from_date, 'DATE(created) <='=>$to_date, 'gender'=>$selected_gender, 'class_type'=>$StdSyllubas);
				}
				if($selected_gender == 'M'){ $gender = 'Male'; }else if($selected_gender == 'FM'){ $gender = 'Female'; }else if($selected_gender == 'all'){ $gender ='All'; }
				$syllubas = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$StdSyllubas),'id');
				$title = 'Gender : '.$gender.' Syllubas : '.$syllubas[0]->type.', Date From : '.$from_date.' - To : '.$to_date;
			}else if($from_date != '' && $to_date != '' && $StdSyllubas != '' && $StdClass != '' && $selected_gender != ''){
				if($selected_gender == 'all'){
					$conduction = array('branch_id'=>$branch_id, 'school_id'=>$school_id, 'status'=>1, 'batch'=>$batch, 'DATE(created) >='=>$from_date,'DATE(created) <='=>$to_date, 'class_type'=>$StdSyllubas,'class'=>$StdClass);

				}else if($selected_gender == 'M' || $selected_gender == 'FM'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'batch'=>$batch,'DATE(created) >='=>$from_date, 'DATE(created) <='=>$to_date, 'gender'=>$selected_gender, 'class_type'=>$StdSyllubas, 'class'=>$StdClass);
				}
				if($selected_gender == 'M'){ $gender = 'Male'; }else if($selected_gender == 'FM'){ $gender = 'Female'; }else if($selected_gender == 'all'){ $gender ='All'; }
				$syllubas = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$StdSyllubas),'id');
				$title = 'Gender : '.$gender.', Syllubas : '.$syllubas[0]->type.', Class : '.$StdClass.', Date From : '.$from_date.' - To : '.$to_date;
			}

			$admissions = $this->Model_dashboard->selectdata('sms_admissions',$conduction,'updated,sno');
			$this->admissionsviews($title,$admissions);
			$this->session->set_userdata('accessdata',$admissions);

		}else if($export_type == 2 && $sorted_type == 'A0'){

			//admission list all
			$enquirydata = $this->Model_dashboard->selectdata('sms_enquiry',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1),'sno');
			$title = '';
			$this->enqueryviews($title,$enquirydata);
			$this->session->set_userdata('enquerydata',$enquirydata);

		}else if($export_type == 2 && $sorted_type == 'A1'){

			//data based on conductions
			if($selected_gender == 'all' && ($StdSyllubas == '' && $StdClass == '' && $from_date == '' && $to_date  == '')){
				$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1);
				$title = 'gender : all';
			}else if(($selected_gender == 'M' || $selected_gender == 'FM') && ($StdSyllubas == '' && $StdClass == '' && $from_date == '' && $to_date == '')){
				$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'gender'=>$selected_gender);
				if($selected_gender == 'M'){ $gender = 'Male'; }else if($selected_gender == 'FM'){ $gender = 'Female'; }
				$title = 'Gender : '.$gender;
			}else if($StdSyllubas != '' && $StdClass == '' && $selected_gender == '' && $from_date == '' && $to_date == ''){
				$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'class_type'=>$StdSyllubas);
				$syllubas = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$StdSyllubas),'id');
				$title = 'Syllubas : '.$syllubas[0]->type;
			}else if($StdSyllubas != '' && $StdClass != '' && $selected_gender == '' && $from_date == '' && $to_date == ''){
				$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'class_type'=>$StdSyllubas,'class'=>$StdClass);
				$syllubas = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$StdSyllubas),'id');
				$title = 'Syllubas : '.$syllubas[0]->type.' - Class : '.$StdClass;
			}else if($StdSyllubas != '' && $StdClass != '' && $selected_gender != '' && $from_date == '' && $to_date == ''){
				if($selected_gender == 'all'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'class_type'=>$StdSyllubas,'class'=>$StdClass);

				}else if($selected_gender == 'M' || $selected_gender == 'FM'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'class_type'=>$StdSyllubas,'class'=>$StdClass,'gender'=>$selected_gender);
				}
				if($selected_gender == 'M'){ $gender = 'Male'; }else if($selected_gender == 'FM'){ $gender = 'Female'; }else if($selected_gender == 'all'){ $gender ='All'; }
				$syllubas = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$StdSyllubas),'id');
				$title = 'Gender : '.$gender.' - Syllubas : '.$syllubas[0]->type.' - Class : '.$StdClass;
			}else if($StdSyllubas != '' && $StdClass == '' && $selected_gender != '' && $from_date == '' && $to_date == ''){
				if($selected_gender == 'all'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'class_type'=>$StdSyllubas);

				}else if($selected_gender == 'M' || $selected_gender == 'FM'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'class_type'=>$StdSyllubas,'gender'=>$selected_gender);
				}
				if($selected_gender == 'M'){ $gender = 'Male'; }else if($selected_gender == 'FM'){ $gender = 'Female'; }else if($selected_gender == 'all'){ $gender ='All'; }
				$syllubas = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$StdSyllubas),'id');
				$title = 'Gender : '.$gender.' - Syllubas : '.$syllubas[0]->type;
			}else if($from_date != '' && $to_date == '' && $StdSyllubas == '' && $StdClass == '' && $selected_gender == ''){
				$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'DATE(created)'=>$from_date);
				$title = 'Date : '.$from_date;
			}else if($from_date != '' && $to_date != '' && $StdSyllubas == '' && $StdClass == '' && $selected_gender == ''){
				$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'DATE(created) >='=>$from_date,'DATE(created) <='=>$to_date);
				$title = 'Date From : '.$from_date.' - To : '.$to_date;
			}else if($from_date != '' && $to_date != '' && $StdSyllubas == '' && $StdClass == '' && $selected_gender != ''){
				if($selected_gender == 'all'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'DATE(created) >='=>$from_date,'DATE(created) <='=>$to_date);

				}else if($selected_gender == 'M' || $selected_gender == 'FM'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'DATE(created) >='=>$from_date,'DATE(created) <='=>$to_date,'gender'=>$selected_gender);
				}
				if($selected_gender == 'M'){ $gender = 'Male'; }else if($selected_gender == 'FM'){ $gender = 'Female'; }else if($selected_gender == 'all'){ $gender ='All'; }
				$title = 'Gender : '.$gender.', Date From : '.$from_date.' - To : '.$to_date;
			}else if($from_date != '' && $to_date != '' && $StdSyllubas != '' && $StdClass == '' && $selected_gender != ''){
				if($selected_gender == 'all'){
					$conduction = array('branch_id'=>$branch_id, 'school_id'=>$school_id, 'status'=>1, 'DATE(created) >='=>$from_date,'DATE(created) <='=>$to_date, 'class_type'=>$StdSyllubas);

				}else if($selected_gender == 'M' || $selected_gender == 'FM'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'DATE(created) >='=>$from_date, 'DATE(created) <='=>$to_date, 'gender'=>$selected_gender, 'class_type'=>$StdSyllubas);
				}
				if($selected_gender == 'M'){ $gender = 'Male'; }else if($selected_gender == 'FM'){ $gender = 'Female'; }else if($selected_gender == 'all'){ $gender ='All'; }
				$syllubas = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$StdSyllubas),'id');
				$title = 'Gender : '.$gender.' Syllubas : '.$syllubas[0]->type.', Date From : '.$from_date.' - To : '.$to_date;
			}else if($from_date != '' && $to_date != '' && $StdSyllubas != '' && $StdClass != '' && $selected_gender != ''){
				if($selected_gender == 'all'){
					$conduction = array('branch_id'=>$branch_id, 'school_id'=>$school_id, 'status'=>1, 'DATE(created) >='=>$from_date,'DATE(created) <='=>$to_date, 'class_type'=>$StdSyllubas,'class'=>$StdClass);

				}else if($selected_gender == 'M' || $selected_gender == 'FM'){
					$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'DATE(created) >='=>$from_date, 'DATE(created) <='=>$to_date, 'gender'=>$selected_gender, 'class_type'=>$StdSyllubas, 'class'=>$StdClass);
				}
				if($selected_gender == 'M'){ $gender = 'Male'; }else if($selected_gender == 'FM'){ $gender = 'Female'; }else if($selected_gender == 'all'){ $gender ='All'; }
				$syllubas = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$StdSyllubas),'id');
				$title = 'Gender : '.$gender.', Syllubas : '.$syllubas[0]->type.', Class : '.$StdClass.', Date From : '.$from_date.' - To : '.$to_date;
			}

			$enquirydata = $this->Model_dashboard->selectdata('sms_enquiry',$conduction,'sno');
			$this->enqueryviews($title,$enquirydata);
			$this->session->set_userdata('enquerydata',$enquirydata);


		}else if($export_type == 3 && $sorted_type == 'A0'){
			// all fee details
			$internalconduction = array('cust_type' => 'all');
			$feecollectiondata = $this->Model_dashboard->selectdata('sms_feelist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1),'sno');
			$title = '';
			$this->feecollectionviews($title,$internalconduction,$feecollectiondata);
			$this->session->set_userdata('feelistdata',$feecollectiondata);

		}else if(($export_type == 3 && $sorted_type == 'A1') || ($export_type == 3 && $sorted_type == 'A1' && $export_datetype == '')){

			if(($export_datetype == "00" && $sorted_type == 'A1') || ($sorted_type == 'A0') || ($sorted_type == 'A1' && $export_datetype == '') || ($sorted_type == 'A1' && $export_datetype == '00')){

				$internalconduction = array('type'=>'all');
				$feecollectiondata = $this->Model_dashboard->selectdata('sms_feelist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1),'sno');
				$title = ' - All data';
				$this->feecollectionviews($title,$internalconduction,$feecollectiondata);
				$this->session->set_userdata('feelistdata',$feecollectiondata);

			}else if($export_datetype == "01" && $from_date != "" && $to_date == ""){

				$internalconduction = array('type'	=>'date','from_date' => $from_date,'to_data' => $to_date);
				$feecollectiondata = $this->Model_dashboard->selectdata('sms_feelist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'DATE(paiddate)' => $from_date),'sno');
				$title = ' - All data - Date : '.$from_date;
				$this->feecollectionviews($title,$internalconduction,$feecollectiondata);
				$this->session->set_userdata('feelistdata',$feecollectiondata);

			}else if($export_datetype == "01" && $from_date != "" && $to_date != ""){

				$internalconduction = array('type' =>'date','from_date'=>$from_date,'to_data' => $to_date);
				$feecollectiondata = $this->Model_dashboard->selectdata('sms_feelist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'DATE(paiddate) >='=>$from_date,'DATE(paiddate) <='=>$to_date),'sno');
				$title = ' - All data - Date : '.$from_date.' - ' .$to_date;
				$this->feecollectionviews($title,$internalconduction,$feecollectiondata);
				$this->session->set_userdata('feelistdata',$feecollectiondata);

			}else if($export_datetype == "02" && $from_month != "" && $to_month == ""){

				echo $from_month;

				$internalconduction = array('type'	=>	'month','from_month' => $from_month,'to_month' => '');
				$feecollectiondata = $this->Model_dashboard->selectdata('sms_feelist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=> 1,'MONTH(paiddate)'=>date('m',strtotime($from_month)),'YEAR(paiddate)'=>date('Y',strtotime($from_month))),'sno');
				$title = ' - All data - Month '.$from_month;
				$this->feecollectionviews($title,$internalconduction,$feecollectiondata);
				$this->session->set_userdata('feelistdata',$feecollectiondata);

			}else if ($export_datetype == "02" && $from_month != "" && $to_month != ""){

				$internalconduction = array('type'	=>	'month','from_month' => $from_month,'to_month' => $to_month);
				$feecollectiondata = $this->Model_dashboard->selectdata('sms_feelist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'MONTH(paiddate) >='=>date('m',strtotime($from_month)),'MONTH(paiddate) <='=>date('m',strtotime($to_month)),'YEAR(paiddate) >='=>date('Y',strtotime($from_month)),'YEAR(paiddate) <='=>date('Y',strtotime($to_month))),'sno');
				$title = ' - All data';
				$this->feecollectionviews($title,$internalconduction,$feecollectiondata);
				$this->session->set_userdata('feelistdata',$feecollectiondata);

			}else if($export_datetype == "03" && $from_year != "" && $to_year == ""){

				$internalconduction = array('type'	=>	'month','from_month' => $from_month,'to_month' => '');
				$feecollectiondata = $this->Model_dashboard->selectdata('sms_feelist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=> 1,'YEAR(paiddate)'=>$from_year),'sno');
				$title = ' - All data - Year : '.$from_year;
				$this->feecollectionviews($title,$internalconduction,$feecollectiondata);
				$this->session->set_userdata('feelistdata',$feecollectiondata);

			}else if ($export_datetype == "03" && $from_year != "" && $to_year != ""){

				$internalconduction = array('type'	=>	'month','from_month' => $from_month,'to_month' => $to_month);
				$feecollectiondata = $this->Model_dashboard->selectdata('sms_feelist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'YEAR(paiddate) >='=>$from_year,'YEAR(paiddate) <='=>$to_year),'sno');
				$title = ' - All data of Year - From : '.$from_year.' - To : '.$to_year;
				$this->feecollectionviews($title,$internalconduction,$feecollectiondata);
				$this->session->set_userdata('feelistdata',$feecollectiondata);

			}else{

				$internalconduction = array('type'=>'all','from_date'=>'','to_data'=>'','error'=>'null');
				$feecollectiondata = $this->Model_dashboard->selectdata('sms_feelist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1),'sno');
				$title = ' - All data';
				$this->feecollectionviews($title,$internalconduction,$feecollectiondata);
				$this->session->set_userdata('feelistdata',$feecollectiondata);
			}


		}else if($export_type == 4 && $sorted_type == 'A0'){
            //all salary list
            $internalconduction = array('cust_type' => 'all');
			$employeesalarydata = $this->Model_dashboard->selectdata('sms_empsalarylist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1),'sno');
			$title = 'All records';
            $this->employeesalaryviews($title,$internalconduction,$employeesalarydata);
			$this->session->set_userdata('employeesalary',$employeesalarydata);
			
		}else if($export_type == 4 && $sorted_type == 'A1'){
            //conductions on salary list
			if(($export_datetype == "00" && $sorted_type == 'A1') || ($sorted_type == 'A0') || ($sorted_type == 'A1' && $export_datetype == '') || ($sorted_type == 'A1' && $export_datetype == '00')){

				$internalconduction = array('type'=>'all');
				$employeesalarydata = $this->Model_dashboard->selectdata('sms_empsalarylist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1),'sno');
				$title = ' - All data';
				$this->employeesalaryviews($title,$internalconduction,$employeesalarydata);
				$this->session->set_userdata('employeesalary',$employeesalarydata);

			}else if($export_datetype == "01" && $from_date != "" && $to_date == ""){

				$internalconduction = array('type'	=>'date','from_date' => $from_date,'to_data' => $to_date);
				$employeesalarydata = $this->Model_dashboard->selectdata('sms_empsalarylist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'DATE(paiddate)' => $from_date),'sno');
				$title = ' - All data - Date : '.$from_date;
				$this->employeesalaryviews($title,$internalconduction,$employeesalarydata);
				$this->session->set_userdata('employeesalary',$employeesalarydata);

			}else if($export_datetype == "01" && $from_date != "" && $to_date != ""){

				$internalconduction = array('type' =>'date','from_date'=>$from_date,'to_data' => $to_date);
				$employeesalarydata = $this->Model_dashboard->selectdata('sms_empsalarylist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'DATE(paiddate) >='=>$from_date,'DATE(paiddate) <='=>$to_date),'sno');
				$title = ' - All data - Date : '.$from_date.' - ' .$to_date;
				$this->employeesalaryviews($title,$internalconduction,$employeesalarydata);
				$this->session->set_userdata('employeesalary',$employeesalarydata);

			}else if($export_datetype == "02" && $from_month != "" && $to_month == ""){

				$internalconduction = array('type'	=>	'month','from_month' => $from_month,'to_month' => '');
				$employeesalarydata = $this->Model_dashboard->selectdata('sms_empsalarylist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=> 1,'MONTH(paiddate)'=>date('m',strtotime($from_month)),'YEAR(paiddate)'=>date('Y',strtotime($from_month))),'sno');
				$title = ' - All data - Month '.$from_month;
				$this->employeesalaryviews($title,$internalconduction,$employeesalarydata);
				$this->session->set_userdata('employeesalary',$employeesalarydata);

			}else if ($export_datetype == "02" && $from_month != "" && $to_month != ""){

				$internalconduction = array('type'	=>	'month','from_month' => $from_month,'to_month' => $to_month);
				$employeesalarydata = $this->Model_dashboard->selectdata('sms_empsalarylist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'MONTH(paiddate) >='=>date('m',strtotime($from_month)),'MONTH(paiddate) <='=>date('m',strtotime($to_month)),'YEAR(paiddate) >='=>date('Y',strtotime($from_month)),'YEAR(paiddate) <='=>date('Y',strtotime($to_month))),'sno');
				$title = ' - All data';
				$this->employeesalaryviews($title,$internalconduction,$employeesalarydata);
				$this->session->set_userdata('employeesalary',$employeesalarydata);

			}else if($export_datetype == "03" && $from_year != "" && $to_year == ""){

				$internalconduction = array('type'	=>	'month','from_month' => $from_month,'to_month' => '');
				$employeesalarydata = $this->Model_dashboard->selectdata('sms_empsalarylist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=> 1,'YEAR(paiddate)'=>$from_year),'sno');
				$title = ' - All data - Year : '.$from_year;
				$this->employeesalaryviews($title,$internalconduction,$employeesalarydata);
				$this->session->set_userdata('employeesalary',$employeesalarydata);

			}else if ($export_datetype == "03" && $from_year != "" && $to_year != ""){

				$internalconduction = array('type'	=>	'month','from_month' => $from_month,'to_month' => $to_month);
				$employeesalarydata = $this->Model_dashboard->selectdata('sms_empsalarylist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1,'YEAR(paiddate) >='=>$from_year,'YEAR(paiddate) <='=>$to_year),'sno');
				$title = ' - All data of Year - From : '.$from_year.' - To : '.$to_year;
				$this->employeesalaryviews($title,$internalconduction,$employeesalarydata);
				$this->session->set_userdata('employeesalary',$employeesalarydata);

			}else{

				$internalconduction = array('type'=>'all','from_date'=>'','to_data'=>'','error'=>'null');
				$employeesalarydata = $this->Model_dashboard->selectdata('sms_empsalarylist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'status'=>1),'sno');
				$title = ' - All data';
				$this->employeesalaryviews($title,$internalconduction,$employeesalarydata);
				$this->session->set_userdata('employeesalary',$employeesalarydata);
			}
			
		}else if(($export_type == 5 && $sorted_type == 'A0') || ($export_type == 5 && $sorted_type == 'A1')){
            //employee list
            
		}else if(($export_type == 6 && $sorted_type == 'A0') || ($export_type == 6 && $sorted_type == 'A1')){
            //attendence list
            
		}
	}


	//views
	public function admissionsviews($title,$admissions){
		?>

		<div class="row">
			<h4 class="col-md-12 text-center">All Admission List -  <?= $title ?> </h4>
			<div class="col-md-12">
				<?php if(count($admissions) != 0){ ?>

					<div class="row">
						<div class="col-md-12">
							<a href="<?=base_url('dashboard/data/downloadadmissions')?>" onClick="return confirm('You want to export admission details.')" class="btn btn-success btn-sm pull-right mb-2">Export data</a>
						</div>
					</div>
					<div class="table-responsive">
						<table id="myTable" class="table table-bordered table-striped">
							<thead>
							<tr>
								<th>SNo</th>
								<th></th>
								<th>Admission Id</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Gender</th>
								<th>DOB</th>
								<!--                                    <th>Syllabus</th>-->
								<th>class</th>
								<th>Mobile</th>
								<th>Batch</th>
							</tr>
							</thead>
							<tbody>
							<?php $i=1; foreach ($admissions as $adminssion) { ?>
								<tr>
									<td><?=$i++;?></td>
									<script>
										$(document).ready(function(){
											var firstName = '<?=$adminssion->firstname?>';
											var lastName = '<?=$adminssion->lastname?>';
											var intials = firstName.charAt(0) + lastName.charAt(0);
											var profileImage = $('#profileImage<?=$adminssion->sno?>').text(intials);
										});
									</script>
									<td align="center">
										<?php if(!empty($adminssion->student_image)){ ?>
											<img src="<?=base_url($adminssion->student_image)?>" class="profileImage">
										<?php }else{ ?>
											<div id="profileImage<?=$adminssion->sno;?>" class="profileImage text-uppercase"></div>
										<?php } ?>
									</td>
									<td><?=$adminssion->id_num?></td>
									<td><?=$adminssion->firstname?></td>
									<td><?=$adminssion->lastname?></td>
									<td><?php if($adminssion->gender == 'FM'){ echo 'Female'; }else{ echo 'Male'; } ?></td>
									<td><?php echo date('Y-m-d',strtotime($adminssion->dob));?></td>
									<!--<td><?php //$syllabusname = $this->Model_dashboard->syllabusname(array('id'=>$adminssion->class_type)); echo $syllabusname['0']->type; ?></td>-->
									<td><?=$adminssion->class?></td>
									<td><?=$adminssion->mobile?></td>
									<td><?php $batch = explode('-',$adminssion->batch); echo $batch[0].'-'.substr($batch[1],-2)?></td>

								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
					
				<?php }else{ ?>
					<?= $this->Model_dashboard->norecords(); ?>
				<?php } ?>
			</div>
		</div>

	<?php }

	public function enqueryviews($title,$enquirydata){

		?>

		<div class="row">
			<h4 class="col-md-12 text-center">All Enquiry List  <?= $title ?> </h4>
			<div class="col-md-12">
				<?php if(count($enquirydata) != 0){ ?>

					<div class="row">
						<div class="col-md-12">
							<a href="<?=base_url('dashboard/data/downloadenquirydata')?>" onClick="return confirm('You want to export enquiry details.')" class="btn btn-success btn-sm pull-right mb-2">Export data</a>
						</div>
					</div>

					<div class="table-responsive">
						<table id="myTable" class="table table-bordered table-striped">
							<thead>
							<tr>
								<th>Sno</th>
								<th>Reg id</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Class</th>
								<th>Mobile</th>
								<th>Mail Id</th>
								<th>Date of Birth</th>
							</tr>
							</thead>
							<tbody>
							<?php $i=1; foreach ($enquirydata as $enquiry) { ?>
								<tr>
									<td><?=$i;?></td>
									<td><?=$enquiry->id_num?></td>
									<td><?=$enquiry->firstname?></td>
									<td><?=$enquiry->lastname?></td>
									<td><?=$enquiry->class?></td>
									<td><?=$enquiry->mobile?></td>
									<td><?=$enquiry->mail_id?></td>
									<td><?=$enquiry->dob?></td>
								</tr>
								<?php $i++; } ?>
							</tbody>
						</table>
					</div>
					
				<?php }else{ ?>
					<?= $this->Model_integrate->norecords(); ?>
				<?php } ?>
			</div>
		</div>

	<?php }

	public function feecollectionviews($title,$internalconduction,$feecollectiondata){

		//print_r($internalconduction);
		//echo count($feecollectiondata);


		$gresult = array();
		foreach ($feecollectiondata as $gelement) {
			$gresult[$gelement->id_num][] = $gelement;
		}

		//$this->print_r($gresult);

		?>
		<div class="row">
			<h4 class="col-md-12 text-center">Students Fee List  <?= $title ?> </h4>
			<div class="col-md-12">
				<?php if(count($gresult) != 0){ ?>
					<div class="row">
						<div class="col-md-12">
							<a href="<?=base_url('dashboard/data/downloadfeepaymentdata/recent')?>" class="btn btn-success btn-sm pull-right mb-2 ml-2">Export Records</a>
							<a href="<?=base_url('dashboard/data/downloadfeepaymentdata/allrecords')?>" class="btn btn-success btn-sm pull-right mb-2" style="display: none">Export Detail records</a>
						</div>
					</div>
					
					<div class="table-responsive">
						<table class="table table-bordered table-striped" id="myTable">
							<thead>
							<tr>
								<!--<th>
                                  <input type="checkbox" id="remember_me" class="filled-in">
                                  <label for="remember_me" style="padding: 5px;margin:-5px 0px -5px 0px;"></label>
                                </th>-->
								<th></th>
								<th>Reg id</th>
								<th>Name</th>
								<th>Class</th>
								<th>Total</th>
								<th>Paid</th>
								<th>Balance</th>
								<th>Lastpaid</th>
								<th>Paid Date</th>
								<th>Paid By</th>
							</tr>
							</thead>
							<tbody>
							<?php $i = 1;

								
								foreach($gresult as $key => $value){
									$fatch = $value[0];
									$id_num = $fatch->id_num;

									$conductions =  array('branch_id'=>$fatch->branch_id,'id_num'=>$id_num,'school_id'=>$fatch->school_id,'status'=>1);
									
									$admissions = $this->Model_dashboard->selectdata('sms_admissions',$conductions,'sno');
									$fatchs = $admissions[0];

									if($fatchs->id_num == $id_num) {
										?>
										<tr class="<?php if ($fatch->balancefee == 0) {
											echo 'text-success';
										} else {
											echo 'text-danger';
										} ?>">
											<!--<td>
											<input type="checkbox" id="remember_<?php //echo $i;
											?>" name="multiid[]" value="<?php //echo $fatch['sno'];
											?>" class="filled-in case checkbox">
											<input type="hidden" value="<?php //echo $fatch['id_num'];
											?>" name="stdids[]">
											<label for="remember_<?php //echo $i;
											?>" class="case checkbox" style="padding: 5px;margin:0px 5px -5px 0px;"></label>
										</td>-->
											<script>
												$(document).ready(function () {
													var firstName = '<?=$fatchs->firstname?>';
													var lastName = '<?=$fatchs->lastname?>';
													var intials = firstName.charAt(0) + lastName.charAt(0);
													var profileImage = $('#profileImage<?=$fatchs->sno?>').text(intials);
												});
											</script>
											<td align="center">
												<?php if (!empty($fatchs->student_image)) { ?>
													<img src="<?= base_url($fatchs->student_image) ?>"
														 class="profileImage">
												<?php } else { ?>
													<div id="profileImage<?= $fatchs->sno; ?>"
														 class="profileImage text-uppercase"></div>
												<?php } ?>
											</td>
											<td>
												<a href="<?= base_url('dashboard/feepayments/feepaymentdetails/'. $fatchs->school_id .'/'. $fatchs->branch_id.'/'.$fatchs->id_num. '?id='.$fatchs->sno) ?>" target="_blank"><?php echo $fatchs->id_num; ?></a>
											</td>
											<td><?php echo substr($fatchs->lastname, 0, 1) . ' . ' . $fatchs->firstname; ?></td>
											<td><?php echo $fatchs->class; ?></td>
											<td class="text-center"><?php echo $fatchs->totalfee . ' /-'; ?></td>
											<td class="text-center"><?= $fatch->paidfee . ' /-' ?> </td>
											<td class="text-center"><?php if ($fatch->balancefee == 0) {
													echo 'paid';
												} else {
													echo $fatch->balancefee . ' /-';
												} ?></td>
											<td class=""><?= $fatch->lastpaidfee . ' /-' ?></td>
											<td><?php echo $fatch->paiddate; ?></td>
											<td class="text-capitalize"><?= $fatch->payment_type ?></td>
										</tr>
										<?php $i++;
									}

								}
							?>
							</tbody>
						</table>
						<!--<input type="submit" class="btn btn-danger btn-xs pull-left" value="DELETE ALL" onClick="return confirm('Are you want to delete..?');" name="deleteall">-->
					</div>
				<?php }else{ ?>
					<?= $this->Model_integrate->norecords(); ?>
				<?php } ?>
			</div>
		</div>

		<script>
			$(document).ready(function() {
				//$('#myTable').DataTable();
			});
		</script>
	<?php }

    public function employeesalaryviews($title,$internalconduction,$employeesalarydata){
        //$this->print_r($employeesalarydata);
		$gresult = array();
		foreach ($employeesalarydata as $gelement) {
			$gresult[$gelement->id_num][] = $gelement;
		}
        ?>
        <div class="col-md-12">
			<h4 class="col-md-12 text-center"> Employee Salary List  <?= $title ?> </h4>
            <?php if(count($gresult) != 0){ ?>
				<div class="row">
					<div class="col-md-12">
						<a href="<?=base_url('dashboard/data/downloadsalarypaymentdata/recent')?>" class="btn btn-success btn-sm pull-right mb-2 ml-2">Export Records</a>
						<a href="#" class="btn btn-success btn-sm pull-right mb-2" style="display: none">Export Detail records</a>
					</div>
				</div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                        <tr>
                            <!--<th>
                              <input type="checkbox" id="remember_me" class="filled-in">
                              <label for="remember_me" style="padding: 5px;margin:-5px 0px -5px 0px;"></label>
                            </th>-->
                            <th></th>
                            <th>Reg id</th>
                            <th>Name</th>
                            <th>emp position</th>
							<th>Month</th>
                            <th>T Salary <small>per/m</small></th>
                            <th>T Paid</th>
                            <th>Paid Salary</th>
                            <th>Balance</th>
                            <th>Paid Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;
                        foreach($gresult as $key => $value){

							$fatch = $value[0];
							$id_num = $fatch->id_num;

							$conductions =  array('branch_id'=>$fatch->branch_id,'id_num'=>$id_num,'school_id'=>$fatch->school_id,'status'=>1);

							$employees = $this->Model_dashboard->selectdata('sms_employee',$conductions,'sno');
							$fatchs = $employees[0];


                            if($fatchs->id_num == $id_num){ ?>
                                <tr>
                                    <!--<td>
                                        <input type="checkbox" id="remember_<?php //echo $i; ?>" name="multiid[]" value="<?php //echo $fatch['sno']; ?>" class="filled-in case checkbox">
                                        <input type="hidden" value="<?php //echo $fatch['id_num']; ?>" name="stdids[]">
                                        <label for="remember_<?php //echo $i; ?>" class="case checkbox" style="padding: 5px;margin:0px 5px -5px 0px;"></label>
                                    </td>-->
                                    <script>
                                        $(document).ready(function(){
                                            var firstName = '<?=$fatchs->firstname?>';
                                            var lastName = '<?=$fatchs->lastname?>';
                                            var intials = firstName.charAt(0) + lastName.charAt(0);
                                            var profileImage = $('#profileImage<?=$fatchs->sno?>').text(intials);
                                        });
                                    </script>
                                    <td align="center">
                                        <?php if(!empty($fatchs->employee_pic)){ ?>
                                            <img src="<?=base_url($fatchs->employee_pic)?>" class="profileImage">
                                        <?php }else{ ?>
                                            <div id="profileImage<?=$fatchs->sno;?>" class="profileImage text-uppercase"></div>
                                        <?php } ?>
                                    </td>
                                    <td><a href="<?=base_url('dashboard/salary/salarypaymentdetails/'.$fatch->school_id.'/'.$fatch->branch_id.'/'.$fatch->id_num.'?id='.$fatchs->sno)?>" target="_blank"><?php echo $fatch->id_num; ?></a></td>
                                    <td><?php echo substr($fatchs->lastname,0,1).' . '.$fatchs->firstname; ?></td>
                                    <td class="text-capitalize"><?php echo $fatchs->emoloyeeposition; ?></td>
									<td class="text-capitalize"><?=date('F',strtotime($fatch->paiddate))?></td>
                                    <td align="center"><?php echo $fatchs->salary." /-"; ?></td>
                                    <?php

                                    ?>
                                    <td align="center"><?=$fatch->paidsalary.' /-'?></td>
                                    <td align="center"><?=$fatch->lastmonthpaid.' /-'?></td>
                                    <td align="center"><?php if(@$fatch->balancesalary == 0){ echo "<small class='text-green'> Paid ".date('F',strtotime($fatch->paiddate))." </small>"; }else{ echo @$fatch->balancesalary.' /-'; }?></td>
                                    <td><?=date('d-m-Y',strtotime($fatch->paiddate))?></td>
                                </tr>
                                <?php $i++;
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <!--<input type="submit" class="btn btn-danger btn-xs pull-left" value="DELETE ALL" onClick="return confirm('Are you want to delete..?');" name="deleteall">-->
                </div>
            <?php }else{ ?>
				<?= $this->Model_integrate->norecords(); ?>
			<?php } ?>
        </div>
        <?php
    }


	// admissions xlsx
	public function createXLS() {
		$details      =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id    =   $details['school']->school_id;
		$branch_id    =   $details['school']->branch_id;
		$serial_no    =   $details['school']->sno;

		$school_academic_form_to    =   $details['school']->school_academic_form_to;
		$academicyear = $this->Model_integrate->academicyear($school_academic_form_to);
		$batch = $academicyear[0]->academic_year; //adminssion accadmic batch

		$dataprint = $this->session->userdata('accessdata');
		//$this->print_r($dataprint);
		// create file name
		if(count($dataprint) != 0){
			$fileName = 'Admission-data_'.$serial_no.'-'.time(). '.xlsx';
			$this->load->library('excel');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			// set Header
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Admission Id');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Enrolment id');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'First Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Last Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Email');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Mobile');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Father');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'gender');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Class');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Roll No');
			$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Section');
			$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Date of Birth');
			$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Address');
			$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Pincode');
			$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Service');
			$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Moles');
			$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Aadhaar');
			$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Nationality');
			$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Religion');
			$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Blood Group');
			$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Fee Amount');
			$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Batch');
			$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Joining Date');

			// set Row
			$rowCount = 2;
			foreach ($dataprint as $element) {
				//$this->print_r($element->firstname);
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element->id_num);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element->em_id);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element->firstname);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element->lastname);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element->mail_id);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element->mobile);
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element->fathername);
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element->gender);
				$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element->class);
				$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element->rollno);
				$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element->section);
				$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element->dob);
				$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element->address);
				$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element->pincode);
				$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, ucwords($element->service));
				$objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $element->moles);
				$objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $element->aadhaar);
				$objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $element->nationality);
				$objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $element->religion);
				$objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $element->blood_group);
				$objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $element->totalfee);
				$objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $element->batch);
				$objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, date('d-m-Y',strtotime($element->created)));
				$rowCount++;
			}
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$path = 'uploads/exports/admissions/'.$branch_id.'/'.$school_id.'/'.$batch.'/';
			$this->createdir($path,$path);
			$objWriter->save($path . $fileName);
			// download file
			header("Content-Type: application/vnd.ms-excel");
			redirect(base_url().$path. $fileName);
		}else{
			$this->failedalert('Failed to export admission data..!','You have timeout to export admissions data.please try again..!','assets/images/failed.png');
			redirect(base_url('dashboard/data/exportdata'));
		}
	}
	// enquiry xlsx
	public function enquiryexportxls() {
		$details      =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id    =   $details['school']->school_id;
		$branch_id    =   $details['school']->branch_id;
		$serial_no    =   $details['school']->sno;

		$school_academic_form_to    =   $details['school']->school_academic_form_to;
		$academicyear = $this->Model_integrate->academicyear($school_academic_form_to);
		$batch = $academicyear[0]->academic_year; //adminssion accadmic batch

		$dataprint = $this->session->userdata('enquerydata');

		// create file name
		if(count($dataprint) != 0){
			$fileName = 'Enquiry_data_'.$serial_no.'-'.time(). '.xlsx';
			$this->load->library('excel');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			// set Header
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Admission Id');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'First Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Last Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Father Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Mobile');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Email id');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Gender');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Class');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Date of Birth');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Address');
			$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Pincode');
			$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Aadhaar');
			$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Enquiry Date');
			// set Row
			$rowCount = 2;
			foreach ($dataprint as $element) {
				//$this->print_r($element->firstname);
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element->id_num);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element->firstname);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element->lastname);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element->fathername);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element->mobile);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element->mail_id);
				$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element->gender);
				$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element->class);
				$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element->dob);
				$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element->address);
				$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element->pincode);
				$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element->aadhaar);
				$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, date('d-m-Y',strtotime($element->created)));
				$rowCount++;
			}
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$path = 'uploads/exports/enquiry/'.$branch_id.'/'.$school_id.'/';
			$this->createdir($path,$path);
			$objWriter->save($path . $fileName);
			// download file
			header("Content-Type: application/vnd.ms-excel");
			redirect(base_url().$path. $fileName);
		}else{
			$this->failedalert('Failed to export enquiry data..!','You have timeout to export enquiry data.please try again..!','assets/images/failed.png');
			redirect(base_url('dashboard/data/exportdata'));
		}
	}
	// fee payments xlxs
	public function feepaymentsexportxls(){
		echo $request = $this->uri->segment(4);

		$details      =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id    =   $details['school']->school_id;
		$branch_id    =   $details['school']->branch_id;
		$serial_no    =   $details['school']->sno;

		$school_academic_form_to    =   $details['school']->school_academic_form_to;
		$academicyear = $this->Model_integrate->academicyear($school_academic_form_to);
		$batch = $academicyear[0]->academic_year; //adminssion accadmic batch

		$dataprint = $this->session->userdata('feelistdata');
		$gresult = array();
		foreach ($dataprint as $gelement) {
			$gresult[$gelement->id_num][] = $gelement;
		}
//		$this->print_r($gresult);
//		exit;
		// create file name

		if(count($gresult) != 0){
			$fileName = 'studentsfee_data_'.$serial_no.'-'.time(). '.xlsx';
			$this->load->library('excel');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			// set Header
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Admission Id');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Invoice id');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Student Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Class');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Mobile');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Email id');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Total Fee');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Paid Amount');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Balance Amount');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Last Paid Amount');
			$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Pay Date');
			$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Pay by');

			// set Row
			$rowCount = 2;
                $ss = 0;
			foreach ($gresult as $key => $value) {
				


				if(isset($request) && $request == 'recent'){
					$element = $value[0];
					$id_num = $element->id_num;
                    
                    $conductions =  array('branch_id'=>$element->branch_id,'id_num'=>$id_num,'school_id'=>$element->school_id,'status'=>1);
				    $admissions = $this->Model_dashboard->selectdata('sms_admissions',$conductions,'sno');
				    $fatchs = $admissions[0];
				}else if(isset($request) && $request == 'allrecords'){
					$element = $value;
                    echo $key;
                    $this->print_r($element);
					$id_num = $key;
                    $conductions =  array('branch_id'=>$element->branch_id,'id_num'=>$id_num,'school_id'=>$element->school_id,'status'=>1);
				    $admissions = $this->Model_dashboard->selectdata('sms_admissions',$conductions,'sno');
				    $fatchs = $admissions[0];
				}

				



				if($element->id_num == $id_num) {
					//$this->print_r($element->firstname);
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element->id_num);
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element->feelistid);
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $fatchs->firstname.'.'.$fatchs->lastname);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element->class);
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $fatchs->mobile);
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $fatchs->mail_id);
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element->totalfee);
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element->paidfee);
					$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element->balancefee);
					$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element->lastpaidfee);
					$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, date('d-m-Y',strtotime($element->paiddate)));
					$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element->payment_type);
				}
                $ss++;
				$rowCount++;
			}
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$path = 'uploads/exports/feedetails/'.$branch_id.'/'.$school_id.'/';
			$this->createdir($path,$path);
			$objWriter->save($path . $fileName);
			// download file
			header("Content-Type: application/vnd.ms-excel");
			redirect(base_url().$path. $fileName);
		}else{
			$this->failedalert('Failed to export Fee data..!','You have timeout to export Students Fee data.please try again..!','assets/images/failed.png');
			redirect(base_url('dashboard/data/exportdata'));
		}

	}
	//salary payments xlxs
	public function salarypaymentsexportxls(){
		echo $request = $this->uri->segment(4);

		$details      =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id    =   $details['school']->school_id;
		$branch_id    =   $details['school']->branch_id;
		$serial_no    =   $details['school']->sno;

		$school_academic_form_to    =   $details['school']->school_academic_form_to;
		$academicyear = $this->Model_integrate->academicyear($school_academic_form_to);
		$batch = $academicyear[0]->academic_year; //adminssion accadmic batch

		$dataprint = $this->session->userdata('employeesalary');
		$gresult = array();
		foreach ($dataprint as $gelement) {
			$gresult[$gelement->id_num][] = $gelement;
		}
//		$this->print_r($gresult);
//		exit;
		// create file name

		if(count($gresult) != 0){
			$fileName = 'salaryreport_data_'.$serial_no.'-'.time(). '.xlsx';
			$this->load->library('excel');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			// set Header
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Employee Id');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Invoice id');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Employee Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Position');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Mobile');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Email id');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Month');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Salary per/month');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'TotalPaid Amount');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'LastPaid Amount');
			$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Balance Amount');
			$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Pay Date');
			$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Pay by');

			// set Row
			$rowCount = 2;
			$ss = 0;
			foreach ($gresult as $key => $value) {

				if(isset($request) && $request == 'recent'){
					$element = $value[0];
					$id_num = $element->id_num;

					$conductions =  array('branch_id'=>$element->branch_id,'id_num'=>$id_num,'school_id'=>$element->school_id,'status'=>1);
					$employees = $this->Model_dashboard->selectdata('sms_employee',$conductions,'sno');
					$fatchs = $employees[0];
				}else if(isset($request) && $request == 'allrecords'){
					$element = $value;
					$this->print_r($element);
					$id_num = $key;
					$conductions =  array('branch_id'=>$element->branch_id,'id_num'=>$id_num,'school_id'=>$element->school_id,'status'=>1);
					$employees = $this->Model_dashboard->selectdata('sms_employee',$conductions,'sno');
					$fatchs = $employees[0];
				}
				
				if($element->id_num == $id_num) {
					//$this->print_r($element->firstname);
					$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element->id_num);
					$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element->salary_payslip_id);
					$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $fatchs->firstname.'.'.$fatchs->lastname);
					$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, ucwords($fatchs->emoloyeeposition));
					$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $fatchs->mobile);
					$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $fatchs->mail_id);
					$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, date('F',strtotime($element->paiddate)));
					$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $fatchs->salary);
					$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element->paidsalary);
					$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element->lastmonthpaid);
					$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element->balancesalary);
					$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, date('d-m-Y',strtotime($element->paiddate)));
					$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element->payment_type);
				}
				$ss++;
				$rowCount++;
			}
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$path = 'uploads/exports/salarydetails/'.$branch_id.'/'.$school_id.'/';
			$this->createdir($path,$path);
			$objWriter->save($path . $fileName);
			// download file
			header("Content-Type: application/vnd.ms-excel");
			redirect(base_url().$path. $fileName);
		}else{
			$this->failedalert('Failed to export Fee data..!','You have timeout to export Students Fee data.please try again..!','assets/images/failed.png');
			redirect(base_url('dashboard/data/exportdata'));
		}
	}

	
}
