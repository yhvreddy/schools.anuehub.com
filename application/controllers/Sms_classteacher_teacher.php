<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_classteacher_teacher extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
        $data['userdata'] = $this->Model_integrate->userdata();
    }

    //students list
    public function StudentsList(){
		$data['PageTitle'] = "Students List";
		//getting school data in session
		$data['userdata'] = $userdata = $this->Model_integrate->userdata();
		$schooldata = $this->session->userdata['school'];
		$data['schoolid'] = $schoolid = $schooldata->school_id;
		$data['branchid'] = $branchid = $schooldata->branch_id;
		$academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
		$batch = $academicyear[0]->academic_year; //adminssion accadmic batch
		$data['adminssions'] = $this->Model_dashboard->selectdata('sms_admissions',array('branch_id'=>$branchid,'school_id'=>$schoolid,'class_type' => $userdata->employee_syllabus, 'class' => $userdata->employeeclass,'status'=>1,'batch'=>$batch),'updated,sno');
		$this->loadViews('classteacher/students/sms_admissionlist_page',$data);
    }

    //students details
    public function StudentDetails(){
		$person_id	=	$this->uri->segment(4);
		$branch_id	=	$this->uri->segment(5);
		$school_id	=	$this->uri->segment(6);

		$data['requst_type'] 	=	$this->uri->segment(7);

		$data['userdata'] = $this->Model_integrate->userdata();
		if(isset($person_id) && !empty($person_id) && isset($branch_id) && !empty($branch_id) && isset($school_id) && !empty($school_id)){
			$data['PageTitle'] = "Student details..!";
			$admissiondetails = $this->Model_default->selectdata('sms_admissions', array('school_id' => $school_id, 'branch_id' => $branch_id, 'sno' => $person_id), 'sno DESC');
			if(count($admissiondetails) != 0){
				$data['admissiondetails'] = $admissiondetails;
				$this->loadViews('classteacher/students/sms_admissiondetails_page',$data);
			}else{
				$this->failedalert('Invalid request of Admission details..!','Your request to display details of admission not found..!');
				redirect(base_url('classteacher/studentslist'));
			}
		}else{
			$this->failedalert('Invalid request..!','Invalid request to display admission details..!');
			redirect(base_url('classteacher/studentslist'));
		}
    }

    //Check Assign Sec RollNo
	public function CheckAssignSecRollNo(){
		extract($_REQUEST);
		//$this->print_r($_REQUEST);
		$assignsecrollno = $this->Model_dashboard->selectdata('sms_admissions',array('branch_id'=>$branch_id,'school_id'=>$school_id,'section'=>$Std_section,'class_type'=>$class_type,'class'=>$class_name,'rollno'=>$Std_RollNo),'sno');
		if(count($assignsecrollno) != 0){
			$data = array('code_id' => 1,'message'=>'Already assigned section or RollNo.');
		}else{
			$data = array('code_id' => 0,'message'=>'Assigning Section & RollNo. Please wait..!');
		}
		echo json_encode($data);
	}

    //Assign Sec RollNo
	public function AssignSecRollNo(){
    	extract($_REQUEST);
    	//$this->print_r($_REQUEST);
		$updatedata = array('section'=>$Std_section,'rollno'=>$Std_RollNo,'updated'=>date('Y-m-d H:i:s'));
		$conduction	= array('sno'=>$sno,'id_num'=>$id_num,'branch_id'=>$branch_id,'school_id'=>$school_id);
		$editemployee = $this->Model_dashboard->updatedata($updatedata,$conduction,'sms_admissions');
		if($editemployee != 0){
			//$this->successalert('Successfully assign rollno & sec..!','You have successfully assign Section : '.$Std_section.' & Rollno : '.$Std_RollNo.' to '.$id_num;
			//redirect(base_url('classteacher/studentslist'));
			$data = array('code_id' => 1,'message'=>'You have successfully assign Section : '.$Std_section.' & Rollno : '.$Std_RollNo.' to '.$id_num);
		}else{
			//$this->failedalert('Failed to assign rollno & sec..!','You have failed to assign rollno & sec'.$id_num;
			//redirect(base_url('classteacher/studentslist'));
			$data = array('code_id' => 0,'message'=>'You have failed to assign Section : '.$Std_section.' & Rollno : '.$Std_RollNo.' to '.$id_num);
		}
		echo json_encode($data);
	}

	//Employee list
	public function EmployeesList(){
		$data['PageTitle'] = "Employee List";
		//getting school data in session
		$schooldata = $this->session->userdata['school'];
		$data['schoolid'] = $schoolid = $schooldata->school_id;
		$data['branchid'] = $branchid = $schooldata->branch_id;
		$data['userdata']  = $userdata = $this->Model_integrate->userdata();
		$data['syllabus']  = $this->Model_dashboard->syllabustypes($schoolid,$branchid);
		$data['employees'] = $this->Model_default->manualselect("SELECT * FROM `sms_employee` WHERE  school_id = '$schoolid' AND branch_id = '$branchid' AND (assign_classes_list LIKE '%$userdata->employeeclass%') AND status = 1 ORDER BY sno DESC");

		$this->loadViews('classteacher/employee/sms_employeelist_page',$data);
	}

	//view employee details
	public function employeedetails(){
		$person_id	=	$this->uri->segment(4);
		$branch_id	=	$this->uri->segment(5);
		$school_id	=	$this->uri->segment(6);
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['requst_type'] 	=	$this->uri->segment(7);
		if(isset($person_id) && !empty($person_id) && isset($branch_id) && !empty($branch_id) && isset($school_id) && !empty($school_id)){
			$data['PageTitle'] = "Employee details..!";
			$employeedetails = $this->Model_default->selectdata('sms_employee', array('school_id' => $school_id, 'branch_id' => $branch_id, 'sno' => $person_id), 'sno DESC');
			if(count($employeedetails) != 0){
				$data['customlink']	=	'classteacher/employee/details/'.$person_id.'/'.$branch_id.'/'.$school_id;
				$data['employeedetails'] = $employeedetails;
				$this->loadViews('classteacher/employee/sms_employeedetails_page',$data);
			}else{
				$this->failedalert('Invalid request of Admission details..!','Your request to display details of admission not found..!');
				redirect(base_url('employee/employeelist'));
			}
		}else{
			$this->failedalert('Invalid request..!','Invalid request to display admission details..!');
			redirect(base_url('employee/employeelist'));
		}
	}

	//Notices List
	public function NoticesList(){
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Notice List..!";
		//getting school data in session
		$schooldata = $this->session->userdata['school'];
		$classteacher = $this->session->userdata['type'];
		$currentdate = date('Y-m-d');
		$data['noticelist'] =	$this->Model_dashboard->customquery("SELECT * FROM sms_notice WHERE school_id = '$schooldata->school_id' AND branch_id = '$schooldata->branch_id' AND notice_to LIKE '%".$classteacher."%' AND notice_publish < '$currentdate' ORDER BY updated DESC");
		$data['schooldata'] = $schooldata;
		$this->loadViews('classteacher/noticeboard/notice_list',$data);
	}

	//notice  details
	public function Noticedetails(){
		extract($_REQUEST);
		$schooldata = $this->session->userdata['school'];
		$data['schoolid']   = $schooldata->school_id;
		$data['branchid']   = $schooldata->branch_id;
		$sno  = $this->uri->segment(3);
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['customlink']	=	'classteacher/notice/'.$sno;
		$data['noticelist'] = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'sno'=>$sno),'updated');
		$data['PageTitle'] = "Notice : ".$data['noticelist'][0]->notice_title;
		$this->loadViews('classteacher/noticeboard/notice_details',$data);
	}

	//timings
	public function timings(){
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Classteacher Timings..!";
		//getting school data in session
		$schooldata = $data['schooldata'] = $this->session->userdata['school'];
		//sending syllabus data to views and getting class data by ajax
		$data['syllabus'] = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
		$data['timingslist'] = $this->Model_dashboard->selectdata('sms_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'updated');
		$data['timings'] = $this->Model_dashboard->selectorderby('sms_formdata',array('type'=>'timings','status'=>1),'id');
		$data['schooldata'] = $schooldata;
		$this->loadViews('classteacher/timings/sms_timings_page',$data);
	}

	//academic calendar
	public function academiccalendar(){
		$data['PageTitle'] = "Academic Calendar & events";
		$data['userdata'] = $this->Model_integrate->userdata();
		//getting school data in session
		$schooldata = $this->session->userdata['school'];
		//sending syllabus data to views and getting class data by ajax
		$data['syllabus'] = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
		$data['schooldata'] = $schooldata;

		$data['events']   =  $this->Model_dashboard->selectdata('sms_events',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1));
		$data['notices'] = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'sno');
		$data['admissions'] = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'sno');
		$data['employees'] = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'sno');
		$this->loadViews('classteacher/calendar/sms_academiccalendar_page',$data);
	}

	//Add Attendence
	public function addnewAttendence(){
		$data['schooldata'] = $schooldata = $this->session->userdata['school'];
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['PageTitle'] = "New Attendence..!";
		//getting school data in session
		$data['syllabus']   = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
		$this->loadViews('classteacher/attendence/attendence_add',$data);
	}

	//save attendence
	public function stdattendanceSave(){
		extract($_REQUEST);
		$schooldata = $this->session->userdata['school'];
		$student_sno = array_filter($student_sno);
		$student_id  = array_filter($student_id);
		$insert = '';
		$schooltimngs = $this->Model_dashboard->selectdata('sms_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1));

		/*if(count($schooltimngs) != 0){
            $schooltimngs = $schooltimngs[0];
            $attfrom = $schooltimngs->fromtime; //school start time
            $attfrom = date('h:i', strtotime($attfrom));

            $sclmto = new DateTime($attfrom);
            $sclmto->add(new DateInterval('PT1H'));
            $attend = $sclmto->format('h:i');

            $scllate = new DateTime($attend);
            $scllate->add(new DateInterval('PT15M'));
            $attlate = $scllate->format('h:i');

            $curtime = date("h:i"); // A = AM/PM


        }*/
		$AMPM = date('A');
		//set attendence value to array
		for($i=0;count($student_sno) > $i;$i++){
			$attendence[] = @${'student_attendence_' . $i};
		}
		//$this->print_r($students);
		foreach ($student_sno as $student => $value){
			$insertdata[$student] = array(
				'school_id' =>  $schooldata->school_id,
				'branch_id' =>  $schooldata->branch_id,
				'att_date'  =>  date('Y-m-d',strtotime($seldate)),
				'class'     =>  $selclass,
				'syllubas'  =>  $selsyllubas,
				'att_type'  =>  $attendencetype,
				'id_num'    =>  $student_id[$student],
				'att_mode'  =>  $attendence[$student],
				'id'        =>  $value,
				'att_timeon'=>  $AMPM,
				'updated'   =>  date('Y-m-d H:i:s')
			);
		}
		for($i=0;count($insertdata) > $i;$i++){
			$value = trim($attendence[$i]);
			if(empty($value)) {
				unset($insertdata[$value]);
			}else {
				//echo json_encode($insertdata[$i]);
				$insert = $this->Model_dashboard->insertdata('sms_attendence',$insertdata[$i]);
				if($insert != 0){
					$countsuccessvalues[] = $insert;
					$output = array('code'=>1,'msg'=>'successfully saved Attendence Data..!','text'=>'');
				}else{
					$output = array('code'=>0,'msg'=>'Failed to saved Attendence Data..!','text'=>'');
				}
			}
		}
		echo json_encode($output);
//        echo count(@$countfailedvalues).' failed to insert,';
//        echo count(@$countsuccessvalues).' Success';
		//$this->print_r($insertdata);
	}

	public function empattendanceSave(){
		extract($_REQUEST);
//        $this->print_r($_REQUEST);
//        exit;
		$schooldata = $this->session->userdata['school'];
		$employee_sno = array_filter($employee_sno);
		$employee_id  = array_filter($employee_id);
		$insert = '';
		$schooltimngs = $this->Model_dashboard->selectdata('sms_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1));

		/*if(count($schooltimngs) != 0){
            $schooltimngs = $schooltimngs[0];
            $attfrom = $schooltimngs->fromtime; //school start time
            $attfrom = date('h:i', strtotime($attfrom));

            $sclmto = new DateTime($attfrom);
            $sclmto->add(new DateInterval('PT1H'));
            $attend = $sclmto->format('h:i');

            $scllate = new DateTime($attend);
            $scllate->add(new DateInterval('PT15M'));
            $attlate = $scllate->format('h:i');

            $curtime = date("h:i"); // A = AM/PM


        }*/
		$AMPM = date('A');
		//set attendence value to array
		for($i=0;count($employee_sno) > $i;$i++){
			$attendence[] = @${'employeeattendence_'. $i};
		}
		//$this->print_r($students);
		foreach ($employee_sno as $employee => $value){
			$insertdata[$employee] = array(
				'school_id' =>  $schooldata->school_id,
				'branch_id' =>  $schooldata->branch_id,
				'att_date'  =>  date('Y-m-d',strtotime($seldate)),
				'att_type'  =>  $attendencetype,
				'id_num'    =>  $employee_id[$employee],
				'att_mode'  =>  $attendence[$employee],
				'id'        =>  $value,
				'att_timeon'=>  $AMPM,
				'updated'   =>  date('Y-m-d H:i:s')
			);
		}
		for($i=0;count($insertdata) > $i;$i++){
			$value = trim($attendence[$i]);
			if(empty($value)) {
				unset($insertdata[$value]);
			}else {
				//echo json_encode($insertdata[$i]);
				$insert = $this->Model_dashboard->insertdata('sms_attendence',$insertdata[$i]);
				if($insert != 0){
					$countsuccessvalues[] = $insert;
					$output = array('code'=>1,'msg'=>'successfully saved Attendence Data..!','text'=>'');
				}else{
					$output = array('code'=>0,'msg'=>'Failed to saved Attendence Data..!','text'=>'');
				}
			}
		}
		echo json_encode($output);
//        echo count(@$countfailedvalues).' failed to insert,';
//        echo count(@$countsuccessvalues).' Success';
		//$this->print_r($insertdata);
	}

	public function attendenceList(){
		$data['schooldata'] = $schooldata = $this->session->userdata['school'];
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Attendence List..!";
		//getting school data in session
		$data['syllabus']   = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
		$this->loadViews('classteacher/attendence/attendence_list',$data);
	}

	public function attendanceDatalistfetch(){
		extract($_REQUEST);
		//$this->print_r($_REQUEST);
		$schooldata = $this->session->userdata['school'];
		//student data
		if((isset($attendancetype) && $attendancetype == 'std') && (isset($stdclass) && $stdclass != '') && (isset($selecteddate) && $selecteddate != '') && (isset($stdsyllubas) && $stdsyllubas != '')){

			$academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
			$batch = $academicyear[0]->academic_year;

			$students = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'batch'=>$batch,'class_type'=>$stdsyllubas,'class'=>$stdclass));
			//$attendence = $this->Model_dashboard->selectdata('sms_attendence',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'att_type'=>'student','class_type'=>$stdsyllubas,'class'=>$stdclass));

			if(count($students) == 0){ ?>
				<center>
					<img src="<?=base_url()?>assets/images/norecordfound.png" style="width:450px;margin:40px 0px">
				</center>
			<?php }else{ ?>
				<style>
					table.table-bordered.dataTable tbody td {
						line-height: 28px;
					}
				</style>

				<?php
				$dft = date('Y-m',strtotime($selecteddate));
				//displaying dates of month
				$date = $dft;//date('Y-M');
				$end = date('Y-m-',strtotime($selecteddate)).date('t', strtotime($date));
				//get month and year form selected data
				$selectedmonth = date('m',strtotime($selecteddate));
				$selectedyear  = date('Y',strtotime($selecteddate));
				?>
				<div id="StudentNewAttendence">
					<div class="clearfix">
						<h4 class="text-info text-center"><?=$stdclass.' Students Attendence List'?></h4>
					</div>
					<div class="clearfix">
						<table class="table table-striped table-bordered table-responsive" id="attendancelist">
							<thead>
							<th></th>
							<th width="">Student Id</th>
							<?php while(strtotime($date) <= strtotime($end)) {
								$day_num = date('d', strtotime($date));
								$day_name = date('l', strtotime($date));
								$date = date("Y-m-d", strtotime("+1 day", strtotime($date))); ?>
								<th style="font-size:12px"><?php echo $day_num ?><br/><?php //echo $day_name ?></th>
							<?php } ?>
							</thead>
							<tbody>
							<?php foreach($students as $student){ ?>

								<tr>
									<script>
										$(document).ready(function(){
											var firstName = '<?=$student->firstname?>';
											var lastName = '<?=$student->lastname?>';
											var intials = firstName.charAt(0) + lastName.charAt(0);
											var profileImage = $('#profileImage<?=$student->sno?>').text(intials);
										});
									</script>
									<td align="center">
										<?php if(!empty($student->student_image)){ ?>
											<img src="<?=base_url($student->student_image)?>" class="profileImage">
										<?php }else{ ?>
											<div id="profileImage<?=$student->sno;?>" class="profileImage text-uppercase"></div>
										<?php } ?>
									</td>
									<td><a href="javascript:;" data-toggle="tooltip" title="<?=$student->firstname.'.'.substr($student->lastname,0,1); ?>"><?=$student->id_num; ?></a></td>
									<?php for($i = 1;date('d',strtotime($end)) >= $i;$i++) {
										//$attdata['att_type'];
										$date = $dft.'-'.$i;
										$day_num = date('d', strtotime($date));
										$day_name = date('l', strtotime($date));
										$dateon =  date('Y-m-d', strtotime($date));
										$attendencedata = $this->Model_dashboard->customquery("SELECT * FROM `sms_attendence` WHERE school_id = '$schooldata->school_id' AND branch_id = '$schooldata->branch_id' AND id_num ='$student->id_num' AND att_date  like '%$dateon%' AND att_type = 'student' AND id = $student->sno");
										$cdate = date('d');

										if (count($attendencedata) != 0) {
											$attdata = $attendencedata[0];
											$old_date = $attdata->att_date;
											$eee = date('Y-m-d', strtotime($old_date));
											$ananyt = explode('-', $eee);
											if ($day_num == $ananyt[2] && $day_num <= $cdate) {
												if ($attdata->att_mode == 'P') {
													$adata = "<label class='text-success'>P</label>";
												} else if ($attdata->att_mode == 'A') {
													$adata = "<label class='text-danger'>A</label>";
												} else if ($attdata->att_mode == 'L') {
													$adata = "<label class='text-warning'>L</label>";
												} else if ($attdata->att_mode == 'HF') {
													$adata = "<label class='text-info'>H</label>";
												}
											}
										} else {
											if($day_num <= $cdate){
												$adata = "<label class='text-danger'>A</label>";
											}else{
												$adata = '';
											}
										}

										?>
										<td style="font-size:12px"><?=$adata;?></td>
									<?php } ?>
								</tr>
							<?php }  ?>
							</tbody>
						</table>
					</div>
				</div>
				<script>
					$('#attendancelist').DataTable({
						'paging'      : false,
						'lengthChange': false,
						'searching'   : true,
						'ordering'    : false,
						'info'        : true,
						'autoWidth'   : true,
						'bSort' : true,
						//scrollY:        "300px",
						//scrollX:        true,
						fixedHeader: true,
						scrollCollapse: true,
						fixedColumns  :   {
							leftColumns: 2
						},
						buttons: [
							'copy', 'excel', 'pdf'
						]
					});
					$('[data-toggle="tooltip"]').tooltip();
				</script>
			<?php }
		}

		//employee data
		if((isset($atttype) && $atttype == 'emp') && (isset($seldate) && $seldate != '') && (isset($attmode) && $attmode != '')){

			$academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
			$batch = $academicyear[0]->academic_year;

			$employees = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1));
			$selecteddate   =   $seldate;
			if(count($employees) == 0){ ?>
				<center>
					<img src="<?=base_url()?>assets/images/norecordfound.png" style="width:450px;margin:40px 0px">
				</center>
			<?php }else if(count($employees) != 0){ ?>
				<style>
					table.table-bordered.dataTable tbody td {
						line-height: 28px;
					}
				</style>
				<?php
				$dft = date('Y-m',strtotime($selecteddate));
				//displaying dates of month
				$date = $dft;//date('Y-M');
				$end = date('Y-m-',strtotime($selecteddate)).date('t', strtotime($date));
				//get month and year form selected data
				$selectedmonth = date('m',strtotime($selecteddate));
				$selectedyear  = date('Y',strtotime($selecteddate));
				?>
				<div id="EmployeeNewAttendence">
					<div class="clearfix">
						<h4 class="text-center pt-2 text-info"><?="Employee's Attendence List"?></h4>
					</div>
					<div class="clearfix">
						<table class="table table-striped table-bordered table-responsive" id="attendancelist">
							<thead>
							<th></th>
							<th width="">Employee Id</th>
							<?php while(strtotime($date) <= strtotime($end)) {
								$day_num = date('d', strtotime($date));
								$day_name = date('l', strtotime($date));
								$date = date("Y-m-d", strtotime("+1 day", strtotime($date))); ?>
								<th style="font-size:12px"><?php echo $day_num ?><br/><?php //echo $day_name ?></th>
							<?php } ?>
							</thead>
							<tbody>
							<?php foreach($employees as $employee){ ?>

								<tr>
									<script>
										$(document).ready(function(){
											var firstName = '<?=$employee->firstname?>';
											var lastName = '<?=$employee->lastname?>';
											var intials = firstName.charAt(0) + lastName.charAt(0);
											var profileImage = $('#profileImage<?=$employee->sno?>').text(intials);
										});
									</script>
									<td align="center">
										<?php if(!empty($employee->student_image)){ ?>
											<img src="<?=base_url($employee->student_image)?>" class="profileImage">
										<?php }else{ ?>
											<div id="profileImage<?=$employee->sno;?>" class="profileImage text-uppercase"></div>
										<?php } ?>
									</td>
									<td><a href="javascript:;" data-toggle="tooltip" title="<?=$employee->firstname.'.'.substr($employee->lastname,0,1); ?>"><?=$employee->id_num; ?></a></td>
									<?php for($i = 1;date('d',strtotime($end)) >= $i;$i++) {
										//$attdata['att_type'];
										$date = $dft.'-'.$i;
										$day_num = date('d', strtotime($date));
										$day_name = date('l', strtotime($date));
										$dateon =  date('Y-m-d', strtotime($date));
										$attendencedata = $this->Model_dashboard->customquery("SELECT * FROM `sms_attendence` WHERE school_id = '$schooldata->school_id' AND branch_id = '$schooldata->branch_id' AND id_num ='$employee->id_num' AND att_date  like '%$dateon%' AND att_type = 'employee' AND id = $employee->sno");
										$cdate = date('d');

										if (count($attendencedata) != 0) {
											$attdata = $attendencedata[0];
											$old_date = $attdata->att_date;
											$eee = date('Y-m-d', strtotime($old_date));
											$ananyt = explode('-', $eee);
											if($day_num == $ananyt[2] && $day_num <= $cdate) {
												if ($attdata->att_mode == 'P') {
													$adata = "<label class='text-success'>P</label>";
												} else if ($attdata->att_mode == 'A') {
													$adata = "<label class='text-danger'>A</label>";
												} else if ($attdata->att_mode == 'L') {
													$adata = "<label class='text-warning'>L</label>";
												} else if ($attdata->att_mode == 'HF') {
													$adata = "<label class='text-info'>H</label>";
												}
											}
										} else {
											if($day_num <= $cdate){
												$adata = "<label class='text-danger'>A</label>";
											}else{
												$adata = '';
											}
										}

										?>
										<td style="font-size:12px"><?=$adata;?></td>
									<?php } ?>
								</tr>
							<?php }  ?>
							</tbody>
						</table>
					</div>
				</div>
				<script>
					$('#attendancelist').DataTable({
						'paging'      : false,
						'lengthChange': false,
						'searching'   : true,
						'ordering'    : false,
						'info'        : true,
						'autoWidth'   : true,
						'bSort' : true,
						//scrollY:        "300px",
						//scrollX:        true,
						fixedHeader: true,
						scrollCollapse: true,
						fixedColumns  :   {
							leftColumns: 2
						},
						buttons: [
							'copy', 'excel', 'pdf'
						]
					});
					$('[data-toggle="tooltip"]').tooltip();
				</script>
			<?php }
		}
	}

	//Examination Timings list Details
	public function ExaminationTimingslistDetails(){
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Examination Timetable..!";
		//getting school data in session
		$schooldata = $data['schooldata'] = $this->session->userdata['school'];
		//sending syllabus data to views and getting class data by ajax
		$data['syllabus'] = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
		$data['timingslist'] = $this->Model_dashboard->selectdata('sms_examtimings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'updated');
		$data['timings'] = $this->Model_dashboard->selectorderby('sms_formdata',array('type'=>'timings','status'=>1),'id');
		$data['schooldata'] = $schooldata;
		$this->loadViews('classteacher/timings/sms_exam_timetable_page',$data);
	}

	//Examination Results upload
	public function ResultsUpload(){
		$data['PageTitle'] = "Upload Examination Results";
		$schooldata = $data['schooldata'] = $this->session->userdata['school'];
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['schoolid'] = $schoolid = $schooldata->school_id;
		$data['branchid'] = $branchid = $schooldata->branch_id;
		$data['scltype']  = $schooldata->scltype;
		$data['slabslist']= $this->Model_dashboard->selectorderby('sms_examination_slabs_list',array('school_id'=>$schoolid,'branch_id'=>$branchid,'status'=>1),'updated');
		$this->loadViews('classteacher/examinations/sms_resultsupload',$data);
	}

	//Uploaded Results List
	public function UploadedResultsList(){
		$data['PageTitle'] = "Uploaded Results List";
		$schooldata = $data['schooldata'] = $this->session->userdata['school'];
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['schoolid'] = $schoolid = $schooldata->school_id;
		$data['branchid'] = $branchid = $schooldata->branch_id;
		$data['scltype']  = $schooldata->scltype;
		$data['slabslist']= $this->Model_dashboard->selectorderby('sms_examination_slabs_list',array('school_id'=>$schoolid,'branch_id'=>$branchid,'status'=>1),'updated');
		$data['resultslist']= $this->Model_dashboard->selectorderby('sms_markslist',array('school_id'=>$schoolid,'branch_id'=>$branchid),'updated DESC');
		$this->loadViews('classteacher/examinations/sms_resultsupload_list',$data);
	}

	//students List To Upload Results
	public function StudentsListToUpload(){
		extract($_REQUEST);
		//$this->print_r($_REQUEST);
		$schooldata = $data['schooldata'] = $this->session->userdata['school'];
		$data['userdata'] = $this->Model_integrate->userdata();


		$scl_types = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$syllabustype));

		$slabslist = $this->Model_dashboard->selectorderby('sms_examination_slabs_list',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'sno'=>$examslab_id,'status'=>1),'updated');

		if(isset($classsection) && $classsection != 'all') {
			//echo "Sections A,B,...";
			@$examtimings = $this->Model_default->selectdata('sms_examtimings', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'class' => $classname, 'syllabus_type' => $syllabustype, 'section' => $classsection, 'exam_slab' => $examslab_id));

			@$studentslist = $this->Model_default->selectdata('sms_admissions', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'class' => $classname, 'class_type' => $syllabustype,'section'=>$classsection));
			@$examination 	=	$examtimings[0];
		}else if($classsection == 'all' && isset($classsection)){
			//echo "All";
			@$examtimings = $this->Model_default->selectdata('sms_examtimings', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'class' => $classname, 'syllabus_type' => $syllabustype, 'exam_slab' => $examslab_id));

			@$studentslist = $this->Model_default->selectdata('sms_admissions', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'class' => $classname, 'class_type' => $syllabustype));

			@$examination 	=	$examtimings[0];
			//$this->print_r($examtimings);

		}else{
			//echo 'null';
			$examtimings = array();
			$studentslist = array();
		}

		if(count($examtimings) != 0){  ?>
			<h4 class="col-md-12 text-center text-success">Upload <?=$scl_types[0]->type.'  '.$classname?> - <?=$slabslist['0']->slab_name?> Examination Results...!</h4>

			<style>
				table tbody td {
					line-height: 28px;
				}
			</style>

			<div class="col-md-12 col-xs-12 col-sm-12">
				<?php if(count($studentslist) != 0){ ?>
					<table id="myTable" class="table table-bordered table-striped">
						<thead>
						<tr>
							<th>#</th>
							<th></th>
							<th>Admission Id</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Gender</th>
							<th>Syllabus</th>
							<th>Section</th>
							<th>Mobile</th>
							<th class="text-center">Upload</th>
						</tr>
						</thead>
						<tbody>
						<?php $i=1; foreach ($studentslist as $adminssion) {

							$markslistrecords = $this->Model_dashboard->selectorderby('sms_markslist',array('branch_id'=>$adminssion->branch_id,'school_id'=>$adminssion->school_id,'slab_id'=>$examslab_id,'class'=>$classname,'student_id'=>$adminssion->sno,'admission_id'=>$adminssion->id_num,'examination_id'=>$examination->sno,'exam_id'=>$examination->examination_id),'updated');
							if(count($markslistrecords) <= 0){
								?>
								<tr>
									<td><?=$i;?></td>
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
									<td><a href="<?=base_url('dashboard/admission/details/'.$adminssion->sno.'/'.$adminssion->branch_id.'/'.$adminssion->school_id)?>"> <?=$adminssion->id_num?> </a></td>
									<td><?=$adminssion->firstname?></td>
									<td><?=$adminssion->lastname?></td>
									<td><?php if($adminssion->gender == 'FM'){ echo 'Female'; }else{ echo 'Male'; } ?></td>
									<td><?=$scl_types[0]->type?> - <?=$adminssion->class?></td>
									<td><?php if(!empty($adminssion->section)){ echo $adminssion->section; }else{ echo 'Not Assign'; } ?></td>
									<td><?=$adminssion->mobile?></td>
									<td align="center">
										<?php $popup = base_url('dashboard/upload/results/'.$adminssion->sno.'/'.$examination->sno.'/'.$schooldata->branch_id.'/'.$schooldata->school_id.'/'.$adminssion->id_num.'?exam='.$examination->examination_id.'&classreq='.$classsection.'&upload=true'); ?>
										<a href="#" onclick='window.open("<?=$popup?>", "mywindow", "scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=800,height=500,left=100,top=100");' data-backdrop="static" data-keyboard="false" class="font-20"><i class="fa fa-upload fa-dx"></i></a>
									</td>
								</tr>
							<?php }  $i++; }?>
						</tbody>
					</table>

					<!--
						<tr>
								<td colspan="10">
									<h6 class="text-center mt-3">No Students to upload results or already uploaded please check once <a href="<?php //echo base_url('dashboard/exams/uploaded/resultslist') ?>"> Results List </a>.</h6>
								</td>
							</tr>
					-->
				<?php }else{  $this->Model_dashboard->norecords();  } ?>

			</div>


		<?php }else { ?>

			<div class="row justify-content-center align-content-center">
				<div class="col-md-12 col-xs-12 col-sm-12 pt-5 pb-5">
					<h3 class="text-center">Unable to upload <?=$slabslist['0']->slab_name?> Examination results. </h3>
					<h4 class="text-center"><?= $scl_types[0]->type . ' ' . $classname.' - '.$slabslist['0']->slab_name.' Examination Records Are Not Found..!'; ?>
					</h4>
				</div>
			</div>

		<?php }
	}

	//Upload Student Marks
	public function UploadStudentMarks(){
		extract($_REQUEST);
		//$this->print_r($_REQUEST);

		$schooldata = $data['schooldata'] = $this->session->userdata['school'];
		$userdata = $this->Model_integrate->userdata();
		$PageTitle = "Upload Examination Results";

		$student_id	=	$this->uri->segment(4);
		$admission	=	$this->uri->Segment(8);
		$examination=	$this->uri->segment(5);
		$branch_id	=	$this->uri->segment(6);
		$school_id	=	$this->uri->segment(7);
		$examination_id	=	$exam;
		$classreq	=	$classreq
		?>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
		<style>
			.loader{
				/*top: 40%;*/
				position: fixed;
				/*left: 50%;*/
				z-index: 111111111;
				width:100%;
				height:100vh;
			}
			.loader center img{
				width: 10%;
				position: relative;
				top:250px;
				right:0%;
			}
		</style>
		<script>
			function marksvalidation(marks) {
				var field = $(this);
				var marksRegX = /A|a|[0-9]/i;
				if(marks.match(marksRegX)) {
					console.log(marks);
				}else{
					console.log("Not match input value");
					marks.replace(marksRegX,'');
					return marks;
				}
			}
		</script>
		<div class="loader" id="loader" style="display:none">
			<center>
				<img src="<?= base_url() ?>assets/images/loader.gif">
			</center>
		</div>
		<?php if((isset($exam) && $exam != '') && (isset($student_id) && $student_id != '') && (isset($upload) && $upload == 'true')) {

			$studentlist = $this->Model_default->selectdata('sms_admissions', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'sno' => $student_id));

			$examtimings = $this->Model_default->selectdata('sms_examtimings', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'sno' => $examination, 'examination_id' => $examination_id));

			$syllabusmode = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$studentlist['0']->class_type));

			?>
			<h5 class="col-md-12 mt-3 text-center text-uppercase text-success">Upload Examination Results</h5>
			<?php
			$examtimings 	= 	$examtimings[0];
			$savedtimings	=	unserialize($examtimings->exam_timings);
			$savedsubjects	=	array();

			$slab_id	=	$examtimings->exam_slab;
			$class		=	$examtimings->class;
			$totalmarks	=	$examtimings->total_marks;
			$syllabustype	=	$studentlist[0]->class_type;


			$markscarry =	array();
			foreach ($savedtimings as $key => $savedtiming){
				$savedsubjects[] =	$savedtiming['subject'];
				$markscarry[]    = 	$savedtiming['marks'];
			}
			?>
			<div class="col-sm-12 col-md-12 col-xs-12 mt-5">
				<h5>Student Details :</h5>
				<div class="row">
					<div class="col-md-5">
						<span class="text-success">Name :</span> <?=substr($studentlist['0']->lastname,0,1).'.'.$studentlist['0']->firstname?>
					</div>
					<div class="col-md-3">
						<span class="text-success">Gender :</span> <?php if($studentlist[0]->gender == 'M'){ echo 'Male'; }else{ echo 'Female'; } ?>
					</div>
					<div class="col-md-4">
						<span class="text-success">Class :</span> <?=$syllabusmode[0]->type.' - '.$studentlist['0']->class.' '.$studentlist[0]->section?>
					</div>
				</div>
			</div>

			<form class="col-md-12 col-sm-12 col-xs-12 pt-2" method="post" id="uploadStudentResults">
				<h5>Upload Marks : Total Marks : <small><?= $totalmarks ?></small></h5>
				<div class="row">
					<?php foreach ($savedsubjects as $key => $subject) { ?>
						<div class="col-md-4 col-xs-12 col-sm-12">
							<div class="row justify-content-center align-content-center" id="SelectedId_<?= $subject ?>">
								<input type="hidden" value="<?=$schooldata->school_id?>" name="school_id">
								<input type="hidden" value="<?=$schooldata->branch_id?>" name="branch_id">
								<input type="hidden" value="<?=$slab_id?>" name="slab_id">
								<input type="hidden" value="<?=$class?>" name="classname">
								<input type="hidden" value="<?=$student_id?>" name="student_id">
								<input type="hidden" value="<?=$admission?>" name="admission_id">
								<input type="hidden" value="<?=$examination?>" name="examination_id">
								<input type="hidden" value="<?=$examination_id?>" name="exam_id">
								<div class="col-md-4 pt-2">
									<input type="hidden" value="<?=$subject?>" name="subject_names[]">
									<label class="text-uppercase text-success"><?= $subject ?></label>
								</div>
								<input type="hidden" value="<?=$markscarry[$key]?>" name="marks_by[]">
								<div class="col-md-8 form-group">
									<input type="text" required="required" class="form-control marksdata"  name="subject_marks[]" onkeyup="return marksvalidation(this.value)" placeholder=" Marks / <?=$markscarry[$key]?>" id="SelectedMarks_<?= $subject ?>">
								</div>
							</div>
						</div>
					<?php } ?>
				</div>

				<div class="col-md-12 mb-3 custom-control custom-checkbox" id="ortherSubjectsAddons">
					<input type="checkbox" class="custom-control-input" id="otheramountlist" name="example1">
					<label class="custom-control-label" for="otheramountlist">Check To Upload Marks Like Handwriting, performance,..</label>
				</div>

				<div class="row justify-content-center align-content-center mt-3">
					<div class="col-md-12" id="otheramountlistbox">
						<div class="row justify-content-center align-items-center">
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-5 form-group">
										<input type="text" name="other_subjectnames[]" placeholder="Subject Name" class="form-control">
									</div>
									<div class="col-md-3 form-group">
										<input type="tel" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="form-control number" name="other_marks[]" placeholder="Marks">
									</div>
									<div class="col-md-3 form-group">
										<input type="tel" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="form-control number" name="total_marks_by[]" placeholder="Total Marks">
									</div>
									<div class="col-md-1" style="padding-top: 2px">
										<a href="javascript:void(0);" id="AddNewfield"
										   class="btn btn-success btn-sm"> + </a>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12" id="appendfeefields"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script>

					$(document).ready(function () {
						$('#otheramountlistbox').hide();
						$("#otheramountlist").click(function (e) {
							if ($('#otheramountlist').is(":checked")) {
								$("#otheramountlist").val('yes');
								$("#otheramountlistbox").show();
								$("input[name='other_subjectnames[]'],input[name='other_marks[]'],input[name='total_marks_by[]']").attr('required','required');
							} else {
								$("#otheramountlist").val('no');
								$("#otheramountlistbox").hide();
								$("#appendfeefields").empty();
								$("input[name='other_subjectnames[]'],input[name='other_marks[]'],input[name='total_marks_by[]']").val('');
								$("input[name='other_subjectnames[]'],input[name='other_marks[]'],input[name='total_marks_by[]']").removeAttr('required');
							}
						});

						$("#AddNewfield").click(function (e) {

							$("input[name='other_subjectnames[]'],input[name='other_marks[]'],input[name='other_subjectnames[]']").attr('required','required');
							var Newfields = '<div class="row"><div class="col-md-5 form-group"><input type="text" name="other_subjectnames[]" placeholder="Subject Name" class="form-control"></div><div class="col-md-3 form-group"><input type="tel" class="form-control" name="other_marks[]" onkeyup="if (/\\D/g.test(this.value)) this.value = this.value.replace(/\\D/g,\'\')" placeholder="Marks"></div><div class="col-md-3 form-group"><input type="tel" onkeyup="if (/\\D/g.test(this.value)) this.value = this.value.replace(/\\D/g,\'\')" class="form-control number" name="total_marks_by[]" placeholder="Total Marks"></div><div class="col-md-1"><a href="javascript:void(0);" id="AddNewfield" class="btn btn-danger btn-sm RemoveField"> - </a></div></div>';

							$("#appendfeefields").append(Newfields);
						});

						$("#appendfeefields").on('click', '.RemoveField', function (e) {
							e.preventDefault();
							$(this).parent().parent().remove();
						})
					});
				</script>
				<div class="col-12">
					<div class="row justify-content-center align-items-center" id="SaveButtonClass">
						<input type="submit" name="uploadmarks_btn" value="Uplaod Examination Marks" class="btn btn-success">
					</div>
				</div>
			</form>

			<script>
				$(document).ready(function () {

					//function sendRequest(classsections,selectedexamslab,subject_classtimings_for,syllabus_to_getdata){
					//	if(subject_classtimings_for != '' && syllabus_to_getdata != ''){
					//		console.log(syllabus_to_getdata + ' - ' + subject_classtimings_for);
					//		var request = $.ajax({
					//			url: "<?//=base_url('dashboard/exams/studentslistTouplaod')?>//",
					//			type: "POST",
					//			data: {classname : subject_classtimings_for,syllabustype : syllabus_to_getdata,requesttype:'examtimetable',classsection:classsections,examslab_id:selectedexamslab},
					//			//dataType: "json"
					//		});
					//
					//		request.done(function(datareserved) {
					//			$("#ExaminationTimingsList").html(datareserved);
					//			/*setTimeout(function(){
					//                sendRequest(classsections,selectedexamslab,subject_classtimings_for,syllabus_to_getdata); //this will send request again and again;
					//            }, 5000);*/
					//		});
					//
					//		request.fail(function(jqXHR, textStatus) {
					//			$("#ExaminationTimingsList").html( "Request failed: " + textStatus );
					//		});
					//	}else{
					//		alert('Please select syllabus and class..!');
					//	}
					//}

					var  classsections 		= '<?=$classreq?>';
					var  selectedexamslab   =	'<?=$slab_id?>';
					var  subject_classtimings_for	=	'<?=$class?>';
					var  syllabus_to_getdata		=   '<?=$syllabustype?>';

					$('#uploadStudentResults').submit(function (events) {
						events.preventDefault();
						$("#loader").show();
						var data = $("#uploadStudentResults").serialize();
						//console.log(data);
						$.ajax({
							type: "POST",
							url: "<?=base_url('dashboard/upload/results/uplaodData')?>",// where you wanna post
							data: data,
							//processData: false,
							//contentType: false,
							dataType:	'json',
							success: function (data) {
								$('#loader').hide();
								if(data.response == 0){
									swal({
										title: "Sorry..!",
										text: data.message,
										icon: "warning",
										buttons: true,
										dangerMode: true,
									})
										.then((willDelete) => {
											if (willDelete) {
												// swal("Poof! Your imaginary file has been deleted!", {
												// 	icon: "success",
												// });
												window.close();
											}else {
												swal({
													title: "Do you want to modify result data..!",
													icon: "warning",
													buttons: true,
													dangerMode: true,
												}).then((willDelete) => {
													if(willDelete){

													}else{
														window.close();
													}
												});
											}
										});
									//window.close();
								}else if(data.response == 1){
									swal({
										title: "Success..!",
										text: data.message,
										icon: "success",
										buttons: true,
										dangerMode: true,
									})
										.then((willDelete) => {
											if (willDelete) {
												// swal("Poof! Your imaginary file has been deleted!", {
												// 	icon: "success",
												// });
												window.close();
											}else {
												swal({
													title: "Do you want to modify result data..!",
													icon: "warning",
													buttons: true,
													dangerMode: true,
												}).then((willDelete) => {
													if(willDelete){

													}else{
														window.close();
													}
												});
											}
										});
								}
								console.log('Submission was successful.');
								console.log(data);
							},
							error: function (jqXHR, textStatus, data) {
								$('#loader').hide();
								console.log('An error occurred.');
								console.log(data);
							}
						});
					});
				})
			</script>


		<?php }else if((isset($exam) && $exam != '') && (isset($student_id) && $student_id != '') && (isset($request) && $request == 'update') && (isset($uploaded_id) && $uploaded_id != '')){

			$studentlist = $this->Model_default->selectdata('sms_admissions', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'sno' => $student_id));

			$examtimings = $this->Model_default->selectdata('sms_examtimings', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'sno' => $examination, 'examination_id' => $examination_id));

			$syllabusmode = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$studentlist['0']->class_type));

			$sms_markslist =  $this->Model_default->selectdata('sms_markslist', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id,'sno'=>$uploaded_id));
			$resultsdatalist	=	unserialize($sms_markslist[0]->markslist);
			$mainmarkslist 	= 	array();
			$etcmarks		=	array();
			$maintotalmarks	=	'';$etctotalmarks	=	'';

			foreach ($resultsdatalist as $key => $resultvalue){
				if($resultvalue['type'] == 'main') {
					$mainmarkslist[] = array('subject' => $resultvalue['subject'], 'marks' => $resultvalue['marks'],'by'=>$resultvalue['by']);
					@$maintotalmarks +=  $resultvalue['marks'];

				}else if($resultvalue['type'] == 'etc'){
					$etcmarks[] = array('subject' => $resultvalue['subject'], 'marks' => $resultvalue['marks'],'by'=>$resultvalue['by']);
					@$etctotalmarks +=  $resultvalue['marks'];
				}
			}
			?>

			<h5 class="col-md-12 mt-3 text-center text-uppercase text-success">Update Examination Result</h5>
			<?php
			$examtimings 	= 	$examtimings[0];
			$savedtimings	=	unserialize($examtimings->exam_timings);
			$savedsubjects	=	array();

			$slab_id	=	$examtimings->exam_slab;
			$class		=	$examtimings->class;
			$totalmarks	=	$examtimings->total_marks;
			$syllabustype	=	$studentlist[0]->class_type;


			$markscarry =	array();
			foreach ($savedtimings as $key => $savedtiming){
				$savedsubjects[] =	$savedtiming['subject'];
				$markscarry[]    = 	$savedtiming['marks'];
			}
			?>
			<div class="col-sm-12 col-md-12 col-xs-12 mt-5">
				<h5>Student Details :</h5>
				<div class="row">
					<div class="col-md-5">
						<span class="text-success">Name :</span> <?=substr($studentlist['0']->lastname,0,1).'.'.$studentlist['0']->firstname?>
					</div>
					<div class="col-md-3">
						<span class="text-success">Gender :</span> <?php if($studentlist[0]->gender == 'M'){ echo 'Male'; }else{ echo 'Female'; } ?>
					</div>
					<div class="col-md-4">
						<span class="text-success">Class :</span> <?=$syllabusmode[0]->type.' - '.$studentlist['0']->class.' '.$studentlist[0]->section?>
					</div>
				</div>
			</div>

			<form class="col-md-12 col-sm-12 col-xs-12 pt-2" method="post" id="uploadStudentResults">
				<h5>Upload Marks : Total Marks : <small><?= $totalmarks ?></small></h5>
				<div class="row">
					<?php foreach ($savedsubjects as $key => $subject) { ?>
						<div class="col-md-4 col-xs-12 col-sm-12">
							<div class="row justify-content-center align-content-center" id="SelectedId_<?= $subject ?>">
								<input type="hidden" value="<?=$schooldata->school_id?>" name="school_id">
								<input type="hidden" value="<?=$schooldata->branch_id?>" name="branch_id">
								<input type="hidden" value="<?=$slab_id?>" name="slab_id">
								<input type="hidden" value="<?=$class?>" name="classname">
								<input type="hidden" value="<?=$student_id?>" name="student_id">
								<input type="hidden" value="<?=$admission?>" name="admission_id">
								<input type="hidden" value="<?=$examination?>" name="examination_id">
								<input type="hidden" value="<?=$examination_id?>" name="exam_id">
								<div class="col-md-4 pt-2">
									<input type="hidden" value="<?=$subject?>" name="subject_names[]">
									<label class="text-uppercase text-success"><?= $subject ?></label>
								</div>
								<input type="hidden" value="<?=$markscarry[$key]?>" name="marks_by[]">

								<?php
								if($subject == $mainmarkslist[$key]['subject']){
									$marks	=	$mainmarkslist[$key]['marks'];
								}else{
									$marks	=	'';
								}
								?>

								<div class="col-md-8 form-group">
									<input type="text" required="required" class="form-control marksdata"  name="subject_marks[]" value="<?=$marks?>" onkeyup="return marksvalidation(this.value)" placeholder=" Marks / <?=$markscarry[$key]?>" id="SelectedMarks_<?= $subject ?>">
								</div>
							</div>
						</div>
					<?php } ?>
				</div>

				<div class="col-md-12 mb-3 custom-control custom-checkbox" id="ortherSubjectsAddons">
					<input type="checkbox" <?php if(count($etcmarks) != 0){ echo 'checked'; } ?> class="custom-control-input" id="otheramountlist" name="example1">
					<label class="custom-control-label" for="otheramountlist">Check To Upload Marks Like Handwriting, performance,..</label>
				</div>

				<div class="row justify-content-center align-content-center mt-3">
					<div class="col-md-12" id="otheramountlistbox">
						<div class="row justify-content-center align-items-center">
							<div class="col-md-8">
								<?php if(count($etcmarks) == 0){ ?>
									<div class="row">
										<div class="col-md-5 form-group">
											<input type="text" name="other_subjectnames[]" placeholder="Subject Name" class="form-control">
										</div>
										<div class="col-md-3 form-group">
											<input type="tel" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="form-control number" name="other_marks[]" placeholder="Marks">
										</div>
										<div class="col-md-3 form-group">
											<input type="tel" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="form-control number" name="total_marks_by[]" placeholder="Total Marks">
										</div>
										<div class="col-md-1" style="padding-top: 2px">
											<a href="javascript:void(0);" id="AddNewfield"
											   class="btn btn-success btn-sm"> + </a>
										</div>
									</div>
								<?php }else{ $ex = 1; foreach ($etcmarks as $key => $etcmark){ ?>
									<div class="row">
										<div class="col-md-5 form-group">
											<input type="text" name="other_subjectnames[]" placeholder="Subject Name" class="form-control" value="<?=$etcmark['subject']?>">
										</div>
										<div class="col-md-3 form-group">
											<input type="tel" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" value="<?=$etcmark['marks']?>" class="form-control number" name="other_marks[]" placeholder="Marks">
										</div>
										<div class="col-md-3 form-group">
											<input type="tel" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" value="<?=$etcmark['by']?>" class="form-control number" name="total_marks_by[]" placeholder="Total Marks">
										</div>
										<div class="col-md-1" style="padding-top: 2px">
											<?php if($ex == 1){ ?>
												<a href="javascript:void(0);" id="AddNewfield"
												   class="btn btn-success btn-sm"> + </a>
											<?php } ?>
										</div>
									</div>
									<?php $ex++; } } ?>
							</div>
						</div>
						<div class="row justify-content-center align-content-center">
							<div class="col-md-8" id="appendfeefields"></div>
						</div>
					</div>
				</div>
				<script>

					$(document).ready(function () {
						$('#otheramountlistbox').hide();
						if ($('#otheramountlist').is(":checked")) {
							$("#otheramountlist").val('yes');
							$("#otheramountlistbox").show();
							$("input[name='other_subjectnames[]'],input[name='other_marks[]'],input[name='total_marks_by[]']").attr('required','required');
						} else {
							$("#otheramountlist").val('no');
							$("#otheramountlistbox").hide();
							$("#appendfeefields").empty();
							$("input[name='other_subjectnames[]'],input[name='other_marks[]'],input[name='total_marks_by[]']").val('');
							$("input[name='other_subjectnames[]'],input[name='other_marks[]'],input[name='total_marks_by[]']").removeAttr('required');
						}
						$("#otheramountlist").click(function (e) {
							if ($('#otheramountlist').is(":checked")) {
								$("#otheramountlist").val('yes');
								$("#otheramountlistbox").show();
								$("input[name='other_subjectnames[]'],input[name='other_marks[]'],input[name='total_marks_by[]']").attr('required','required');
							} else {
								$("#otheramountlist").val('no');
								$("#otheramountlistbox").hide();
								$("#appendfeefields").empty();
								$("input[name='other_subjectnames[]'],input[name='other_marks[]'],input[name='total_marks_by[]']").val('');
								$("input[name='other_subjectnames[]'],input[name='other_marks[]'],input[name='total_marks_by[]']").removeAttr('required');
							}
						});

						$("#AddNewfield").click(function (e) {

							$("input[name='other_subjectnames[]'],input[name='other_marks[]'],input[name='other_subjectnames[]']").attr('required','required');
							var Newfields = '<div class="row"><div class="col-md-5 form-group"><input type="text" name="other_subjectnames[]" placeholder="Subject Name" class="form-control"></div><div class="col-md-3 form-group"><input type="tel" class="form-control" name="other_marks[]" onkeyup="if (/\\D/g.test(this.value)) this.value = this.value.replace(/\\D/g,\'\')" placeholder="Marks"></div><div class="col-md-3 form-group"><input type="tel" onkeyup="if (/\\D/g.test(this.value)) this.value = this.value.replace(/\\D/g,\'\')" class="form-control number" name="total_marks_by[]" placeholder="Total Marks"></div><div class="col-md-1"><a href="javascript:void(0);" id="AddNewfield" class="btn btn-danger btn-sm RemoveField"> - </a></div></div>';

							$("#appendfeefields").append(Newfields);
						});

						$("#appendfeefields").on('click', '.RemoveField', function (e) {
							e.preventDefault();
							$(this).parent().parent().remove();
						})
					});
				</script>
				<div class="col-12">
					<div class="row justify-content-center align-items-center" id="SaveButtonClass">
						<input type="submit" name="uploadmarks_btn" value="Uplaod Examination Marks" class="btn btn-success">
					</div>
				</div>
			</form>

			<script>
				$(document).ready(function () {

					//function sendRequest(classsections,selectedexamslab,subject_classtimings_for,syllabus_to_getdata){
					//	if(subject_classtimings_for != '' && syllabus_to_getdata != ''){
					//		console.log(syllabus_to_getdata + ' - ' + subject_classtimings_for);
					//		var request = $.ajax({
					//			url: "<?//=base_url('dashboard/exams/studentslistTouplaod')?>//",
					//			type: "POST",
					//			data: {classname : subject_classtimings_for,syllabustype : syllabus_to_getdata,requesttype:'examtimetable',classsection:classsections,examslab_id:selectedexamslab},
					//			//dataType: "json"
					//		});
					//
					//		request.done(function(datareserved) {
					//			$("#ExaminationTimingsList").html(datareserved);
					//			/*setTimeout(function(){
					//                sendRequest(classsections,selectedexamslab,subject_classtimings_for,syllabus_to_getdata); //this will send request again and again;
					//            }, 5000);*/
					//		});
					//
					//		request.fail(function(jqXHR, textStatus) {
					//			$("#ExaminationTimingsList").html( "Request failed: " + textStatus );
					//		});
					//	}else{
					//		alert('Please select syllabus and class..!');
					//	}
					//}

					var  classsections 		= '<?=$classreq?>';
					var  selectedexamslab   =	'<?=$slab_id?>';
					var  subject_classtimings_for	=	'<?=$class?>';
					var  syllabus_to_getdata		=   '<?=$syllabustype?>';

					$('#uploadStudentResults').submit(function (events) {
						events.preventDefault();
						$("#loader").show();
						var data = $("#uploadStudentResults").serialize();
						//console.log(data);
						$.ajax({
							type: "POST",
							url: "<?=base_url('dashboard/upload/results/uplaodData')?>",// where you wanna post
							data: data,
							//processData: false,
							//contentType: false,
							dataType:	'json',
							success: function (data) {
								$('#loader').hide();
								if(data.response == 0){
									swal({
										title: "Sorry..!",
										text: data.message,
										icon: "warning",
										buttons: true,
										dangerMode: true,
									})
										.then((willDelete) => {
											if (willDelete) {
												// swal("Poof! Your imaginary file has been deleted!", {
												// 	icon: "success",
												// });
												window.close();
											}else {
												swal({
													title: "Do you want to modify result data..!",
													icon: "warning",
													buttons: true,
													dangerMode: true,
												}).then((willDelete) => {
													if(willDelete){

													}else{
														window.close();
													}
												});
											}
										});
									//window.close();
								}else if(data.response == 1){
									swal({
										title: "Success..!",
										text: data.message,
										icon: "success",
										buttons: true,
										dangerMode: true,
									})
										.then((willDelete) => {
											if (willDelete) {
												// swal("Poof! Your imaginary file has been deleted!", {
												// 	icon: "success",
												// });
												window.close();
											}else {
												swal({
													title: "Do you want to modify result data..!",
													icon: "warning",
													buttons: true,
													dangerMode: true,
												}).then((willDelete) => {
													if(willDelete){

													}else{
														window.close();
													}
												});
											}
										});
								}
								console.log('Submission was successful.');
								console.log(data);
							},
							error: function (jqXHR, textStatus, data) {
								$('#loader').hide();
								console.log('An error occurred.');
								console.log(data);
							}
						});
					});
				})
			</script>

		<?php }else{ ?>
			<div class="row justify-content-center align-content-center">
				<div class="col-md-12 col-xs-12 col-sm-12 pt-5 pb-5">
					<h3 class="text-center">Unable to upload  Examination results. </h3>
					<h4 class="text-center">Examination Records Are Not Found..!</h4>
				</div>
			</div>
		<?php } ?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<?php
	}

	//Uplaod Result Data
	public function UplaodResultData(){
		extract($_REQUEST);
		error_reporting(0);
		$schooldata = $this->session->userdata['school'];
		$submarkslist 	= array();
		$othermarklist  = array();
		$totalmarks_by = '';

		$markslistrecords = $this->Model_dashboard->selectorderby('sms_markslist',array('branch_id'=>$branch_id,'school_id'=>$school_id,'slab_id'=>$slab_id,'class'=>$classname,'student_id'=>$student_id,'admission_id'=>$admission_id,'examination_id'=>$examination_id,'exam_id'=>$exam_id),'updated');
		if(count($markslistrecords) != 0){

			foreach ($subject_names as $key => $subject) {
				$submarkslist[] = array('type' => 'main', 'subject' => $subject, 'marks' => $subject_marks[$key],'by'=>$marks_by[$key]);
				@$totalmarks_by += $marks_by[$key];
			}

			$othertotalmarks_by = '';
			if ($other_subjectnames[0] != '' && $other_marks[0] != '' && $total_marks_by[0] != '') {
				foreach ($other_subjectnames as $key => $other_subjectname) {
					$othermarklist[] = array('type' => 'etc', 'subject' => $other_subjectname, 'marks' => $other_marks[$key],'by'=>$total_marks_by[$key]);
					@$othertotalmarks_by += $total_marks_by[$key];
				}
			}

			//total per marks
			$totalsubjectsmarks = $totalmarks_by + $othertotalmarks_by;

			//student gained marks
			$totalmarks = '';
			$markslist = array_merge($submarkslist, $othermarklist);
			$totalsubject = count($markslist);
			foreach ($markslist as $value) {
				@$totalmarks += $value['marks'];
			}
			$markslist = serialize($markslist);

			$conduction	=	array('branch_id' => $branch_id, 'school_id' => $school_id, 'slab_id' => $slab_id, 'class' => $classname, 'student_id' => $student_id, 'admission_id' => $admission_id, 'examination_id' => $examination_id, 'exam_id' => $exam_id);

			$insertdata = array('markslist' => $markslist, 'totalmarks' => $totalsubjectsmarks, 'gainedmarks' => $totalmarks, 'totalsubjects' => $totalsubject, 'updated' => date('Y-m-d H:i:s'));
			$inserteddata	=	$this->Model_dashboard->updatedata($insertdata,$conduction,'sms_markslist');

			if($inserteddata != 0){
				$data = array('response' => 1, 'message' => 'Successfully updated results..!', 'data' => 'You have updated results successfully..!');
			}else{
				$data = array('response' => 0, 'message' => 'Failed to update results.please try again later..!', 'data' => '');
			}


			//$data 	=	array('response'=>0,'message'=>'Already Updated Marks Records.please check it..!','data'=>'');
		}else {

			foreach ($subject_names as $key => $subject) {
				$submarkslist[] = array('type' => 'main', 'subject' => $subject, 'marks' => $subject_marks[$key],'by'=>$marks_by[$key]);
				@$totalmarks_by += $marks_by[$key];
			}

			$othertotalmarks_by = '';
			if ($other_subjectnames[0] != '' && $other_marks[0] != '' && $total_marks_by[0] != '') {
				foreach ($other_subjectnames as $key => $other_subjectname) {
					$othermarklist[] = array('type' => 'etc', 'subject' => $other_subjectname, 'marks' => $other_marks[$key],'by'=>$total_marks_by[$key]);
					@$othertotalmarks_by += $total_marks_by[$key];
				}
			}

			//total per marks
			$totalsubjectsmarks = $totalmarks_by + $othertotalmarks_by;

			//student gained marks
			$totalmarks = '';
			$markslist = array_merge($submarkslist, $othermarklist);
			$totalsubject = count($markslist);
			foreach ($markslist as $value) {
				@$totalmarks += $value['marks'];
			}
			$markslist = serialize($markslist);

			$insertdata = array('branch_id' => $branch_id, 'school_id' => $school_id, 'slab_id' => $slab_id, 'class' => $classname, 'student_id' => $student_id, 'admission_id' => $admission_id, 'examination_id' => $examination_id, 'exam_id' => $exam_id, 'markslist' => $markslist, 'totalmarks' => $totalsubjectsmarks, 'gainedmarks' => $totalmarks, 'totalsubjects' => $totalsubject, 'updated' => date('Y-m-d H:i:s'));
			$inserteddata	=	$this->Model_dashboard->insertdata('sms_markslist',$insertdata);

			if($inserteddata != 0){
				$data = array('response' => 1, 'message' => 'Successfully upload results..!', 'data' => '');
			}else{
				$data = array('response' => 0, 'message' => 'Failed to upload results.please try again later..!', 'data' => '');
			}
		}

		echo json_encode($data);

	}

	public function userprofileDetails(){
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id = $data['school_id'] =   $details['school']->school_id;
		$branch_id = $data['branch_id'] =   $details['school']->branch_id;
		$school_academic = $details['school']->school_academic;
		$school_academic_form_to    =   $details['school']->school_academic_form_to;
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Profile Details..!";
		$data['scltypes'] = $this->Model_default->selectconduction('sms_formdata',array('type'=>'reg'));
		$data['countries'] = $this->Model_default->selectconduction('sms_countries',array('status'=>1));
		$data['gender']     = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'gender','status'=>1));
		$this->loadViews('classteacher/profile/sms_profile',$data);
	}

	public function updateProfileData(){
		extract($_REQUEST);
//		$this->print_r($_REQUEST);
//		$this->print_r($_FILES);
//		exit;
		$userdata = $this->Model_default->selectconduction('sms_employee',array('sno'=>$id,'id_num'=>$reg_id,'branch_id'=>$branch_id,'school_id'=>$school_id));
		//$this->print_r($userdata);
		if(count($userdata) != 0){
            $this->createdir('./uploads/files/employee/profile/'.$branch_id.'/'.$school_id.'/'.$reg_id,'./uploads/files/employee/profile/'.$branch_id.'/'.$school_id.'/'.$reg_id.'');
			if(!empty($_FILES['profileimage']['name'])){
				$path = 'uploads/files/employee/profile/'.$branch_id.'/'.$school_id.'/'.$reg_id.'/';
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
			$conduction =   array('sno'=>$id,'id_num'=>$reg_id,'branch_id'=>$branch_id,'school_id'=>$school_id);
			$updatedata =   array(
				'firstname'   =>  $firstname,
				'lastname'    =>  $lastname,
                'gender'      =>  $empgender,  
                'phone'       =>  $empphone,  
                'religion'    =>  $empreligion,
                'nationality' =>  $empnationality,
				'mail_id'     =>  $email,
				'mobile'      =>  $mobile,
				'country_id'  =>  $CountryName,
				'state_id'    =>  $StateName,
				'city_id'     =>  $CityName,
				'address'     =>  $Address,
				'pincode'     =>  $pincode,
				'updated'     =>  date('Y-m-d H:i:s'),
				'profile'     =>  $upload
			);
			$updatedetails = $this->Model_dashboard->updatedata($updatedata,$conduction,'sms_employee');
			if($updatedetails != 0){
				$this->Model_dashboard->updatedata(array('mailid'=>$email,'updated' => date('Y-m-d H:i:s')),array('reg_id'=>$reg_id),'sms_reg');
				$this->successalert('Successfully Update Details..!',$firstname.' details as updated successfully..!');
				redirect(base_url('classteacher/profile?update=success'));
			}else{
				$this->failedalert('Failed to Update Details..!',$firstname.' details as failed to updated..!');
				redirect(base_url('classteacher/profile?update=failed'));
			}
		}else{
			//other users to update profile
            $this->failedalert('Failed to Update Details..!',$firstname.' details are not found or invalid request or oops error..!');
            redirect(base_url('classteacher/profile?update=failed'));
		}
	}

	public function updatePassword(){
		extract($_REQUEST);
		$schooldata = $this->session->userdata['school'];
		$school_id = $schooldata->school_id;
		$branch_id = $schooldata->branch_id;
		$userdata = $this->Model_default->selectconduction('sms_employee',array('sno'=>$id,'id_num'=>$reg_id));
		$useraccount = $this->Model_default->selectconduction('sms_users',array('school_id'=>$school_id,'usertype'=>'classteacher','branch_id'=>$branch_id,'id_num'=>$reg_id));
		if(count($userdata) != 0){
			if($useraccount[0]->password == md5($old_password)){
				if($new_password == $confirm_password){
					$conduction =   array('school_id'=>$school_id,'usertype'=>'classteacher','branch_id'=>$branch_id,'id_num'=>$reg_id);
					$updatedata =   array(
						'password'         =>  md5($new_password),
						'updated'          =>  date('Y-m-d H:i:s'),
					);
					$updatedetails = $this->Model_dashboard->updatedata($updatedata,$conduction,'sms_users');
					if($updatedetails != 0){
						$this->successalert('Successfully Update Details..!',$userdata[0]->firstname.' details as updated successfully..!');
						$this->logout();
						//redirect(base_url('dashboard/profile?update=success'));
					}else{
						$this->failedalert('Failed to Update Details..!',$userdata[0]->firstname.' details as failed to update..!');
						redirect(base_url('classteacher/profile?update=failed'));
					}
				}else{
					$this->failedalert('Failed to Update Details..!',$userdata[0]->firstname.' please check new password & confirm password must be same..!');
					redirect(base_url('classteacher/profile?update=failed'));
				}

			}else{
				$this->failedalert('Failed to Update Details..!',$userdata[0]->fname.' please enter currect  old password..!');
				redirect(base_url('classteacher/profile?update=failed'));
			}


		}else{
			//other users to update profile
		}
	}

}
