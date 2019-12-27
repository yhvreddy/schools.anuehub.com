<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_mailbox extends CI_Model{

	public function selectdata($tablename,$conduction,$orderby = NULL){
		$this->db->select('*');
		$this->db->from($tablename);
		$this->db->where($conduction);
		$this->db->order_by($orderby, "DESC");
		$returndata = $this->db->get();
		return $returndata->result();
	}

	//select custom data
	public function customquery($query){
		$dataquery = $this->db->query($query);
		$result = $dataquery->result();
		return $result;
	}

	public function sedetails($branchid,$schoolid,$regid){
		$students = $this->selectdata('sms_admissions',array('branch_id'=>$branchid,'school_id'=>$schoolid,'id_num'=>$regid));
		if(count($students) != 0){
			return $students[0];
		}else{
			$employee = $this->selectdata('sms_employee',array('branch_id'=>$branchid,'school_id'=>$schoolid,'id_num'=>$regid));
			return $employee[0];
		}
	}

	public function userdata(){
		$usertype = $this->session->userdata['type'];
		$reg_id  =   $this->session->userdata['regid'];
		//print_r($reg_id);
		//exit();
		$id     =   $this->session->userdata['id'];
		if($usertype == 'admin' || $usertype == 'superadmin' || $usertype == 'super-admin'){
			$data = $this->selectdata('sms_regusers',array('reg_id'=>$reg_id,'sno'=>$id));
			$data = $data[0];
		}else{
			$data[] = '';
			$school_id   =   $this->session->userdata['school']->school_id;
			$branch_id   =   $this->session->userdata['school']->branch_id;
			$data = $this->sedetails($branch_id,$school_id,$reg_id);
		}

		return $data;
	}

	public function get_Inboxcount(){
		$sessiondata = $this->session->userdata;
		$school_id	=	$sessiondata['school']->school_id;
		$branch_id	=	$sessiondata['school']->branch_id;
		$userdata = $this->userdata();
//		echo '<pre>';
//		print_r($sessiondata);
//		echo '</pre>';
//		exit();
		if(isset($userdata->reg_id)){
			$send_from = $userdata->local_mail_id;
		}else{
			$send_from = $userdata->local_mail_id;
		}
		$mailsents	=	$this->Model_dashboard->customquery("SELECT * FROM `sms_mail_box` INNER JOIN  `sms_mail_reports` ON sms_mail_reports.id = sms_mail_box.mail_ids AND sms_mail_reports.mail_id = sms_mail_box.mail_id WHERE sms_mail_box.school_id = '$school_id' AND sms_mail_box.branch_id = '$branch_id' AND sms_mail_box.sent_to = '$send_from' AND sms_mail_box.inbox_status = 1 ORDER BY sms_mail_box.id DESC");
		return $mailsents;
	}

	public function get_inboxdata($offset, $start) {
		$sessiondata = $this->session->userdata;
		$school_id	=	$sessiondata['school']->school_id;
		$branch_id	=	$sessiondata['school']->branch_id;
		$userdata = $this->userdata();
		if(isset($userdata->reg_id)){
			$send_from = $userdata->local_mail_id;
		}else{
			$send_from = $userdata->local_mail_id;
		}
		$mailsents	=	$this->customquery("SELECT * FROM `sms_mail_box` INNER JOIN  `sms_mail_reports` ON sms_mail_reports.id = sms_mail_box.mail_ids AND sms_mail_reports.mail_id = sms_mail_box.mail_id WHERE sms_mail_box.school_id = '$school_id' AND sms_mail_box.branch_id = '$branch_id' AND sms_mail_box.sent_to = '$send_from' AND sms_mail_box.inbox_status = 1 ORDER BY sms_mail_box.id DESC LIMIT $offset, $start");
		//$mailsents= $this->db->last_query($mailsents);
		//print_r($mailsents);
		//exit;
		return $mailsents;
	}

}
