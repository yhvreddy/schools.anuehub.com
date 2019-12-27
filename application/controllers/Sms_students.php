<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_students extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
        $data['userdata'] = $this->Model_integrate->userdata();
    }

    //My Information Details
    public function MyInformationDetails(){
    	$data['PageTitle'] = "My Details List..!";
		//getting school data in session
		$data['userdata'] = $userdata = $this->Model_integrate->userdata();
		$schooldata = $this->session->userdata['school'];
		$data['schoolid'] = $schoolid = $schooldata->school_id;
		$data['branchid'] = $branchid = $schooldata->branch_id;
		$academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
		$batch = $academicyear[0]->academic_year; //adminssion accadmic batch
        $data['countries'] = $this->Model_default->selectconduction('sms_countries',array('status'=>1));
		$data['gender']     = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'gender','status'=>1));
        $this->loadViews('student/profile/sms_mydetails_page',$data);
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
        $assignclass = explode(',',$userdata->assign_classes_list);
        $assignclasslist = '';
        foreach ($assignclass as $assignclassdata){
            @$assignclasslist .= 'class LIKE "%'.$assignclassdata.'%" OR ';
        }
        $assignclasslist = rtrim($assignclasslist,'OR ');
        $data['adminssions'] = $admission = $this->Model_default->manualselect("SELECT * FROM `sms_admissions` WHERE  school_id = '$schoolid' AND branch_id = '$branchid' AND (".$assignclasslist.") AND batch = '$batch' ORDER BY sno DESC");
		$this->loadViews('student/students/sms_admissionlist_page',$data);
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
				$this->loadViews('teacher/students/sms_admissiondetails_page',$data);
			}else{
				$this->failedalert('Invalid request of Admission details..!','Your request to display details of admission not found..!');
				redirect(base_url('teacher/studentslist'));
			}
		}else{
			$this->failedalert('Invalid request..!','Invalid request to display admission details..!');
			redirect(base_url('teacher/studentslist'));
		}
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
		$this->loadViews('student/employee/sms_employeelist_page',$data);
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
				$data['customlink']	=	'student/employee/details/'.$person_id.'/'.$branch_id.'/'.$school_id;
				$data['employeedetails'] = $employeedetails;
				$this->loadViews('teacher/employee/sms_employeedetails_page',$data);
			}else{
				$this->failedalert('Invalid request of Admission details..!','Your request to display details of admission not found..!');
				redirect(base_url('teacher/employeelist'));
			}
		}else{
			$this->failedalert('Invalid request..!','Invalid request to display admission details..!');
			redirect(base_url('teacher/employeelist'));
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
		$data['noticelist'] =	$this->Model_dashboard->customquery("SELECT * FROM sms_notice WHERE school_id = '$schooldata->school_id' AND branch_id = '$schooldata->branch_id' AND (notice_to LIKE '%teacher%' AND notice_to NOT LIKE '%classteacher%') AND notice_publish < '$currentdate' ORDER BY updated DESC");
		$data['schooldata'] = $schooldata;
		$this->loadViews('student/noticeboard/notice_list',$data);
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
		$this->loadViews('student/noticeboard/notice_details',$data);
	}

	//timings
	public function timings(){
		$data['userdata'] = $userdata = $this->Model_integrate->userdata();;
		$data['PageTitle'] = "School, Bus, Class Timings..!";
		//getting school data in session
		$schooldata = $data['schooldata'] = $this->session->userdata['school'];
		//sending syllabus data to views and getting class data by ajax
		$data['syllabus'] = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
		$data['timingslist'] = $this->Model_dashboard->selectdata('sms_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'updated');
		$data['timings'] = $this->Model_dashboard->selectorderby('sms_formdata',array('type'=>'timings','status'=>1),'id');
        $data['bustimingslist'] = $this->Model_dashboard->selectdata('sms_bus_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'sno');
        $data['classtimings'] = $this->Model_dashboard->customquery("SELECT * FROM sms_timings GROUP BY section,class HAVING branch_id = '".$schooldata->branch_id."' AND school_id = '".$schooldata->school_id."' AND timingsfor = 'class' AND class = '".$userdata->class."' AND syllabus_type = $userdata->class_type ORDER BY section,class, COUNT(sno) ASC");
		$data['schooldata'] = $schooldata;
		$this->loadViews('student/timings/sms_timings_page',$data);
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
		$this->loadViews('student/calendar/sms_academiccalendar_page',$data);
	}

	//Add Attendence
	public function addnewAttendence(){
		$data['schooldata'] = $schooldata = $this->session->userdata['school'];
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['PageTitle'] = "New Attendence..!";
		//getting school data in session
		$data['syllabus']   = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
		$this->loadViews('student/attendence/attendence_add',$data);
	}

    //Dairy Works
    public function dairyWorks(){
        $data['PageTitle']  = "Dairy..!";
        $schooldata = $this->session->userdata['school'];
		$data['school_id'] = $school_id  = $schooldata->school_id;
		$data['branch_id'] = $branch_id  = $schooldata->branch_id;
		$data['userdata']  = $userdata   = $this->Model_integrate->userdata();
        $data['homeworks'] = $this->Model_dashboard->selectdata('sms_homework_reports', array('school_id'=>$school_id, 'branch_id'=>$branch_id, 'status'=>1, 'publish'=>1, 'class'=>$userdata->class, 'section'=>$userdata->section, 'syllabus'=>$userdata->class_type), 'hw_date');
        $this->loadViews('student/dairy/homework_dairy_list',$data);
    }
    
	public function attendenceList(){
		$data['schooldata'] = $schooldata = $this->session->userdata['school'];
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Attendence List..!";
		//getting school data in session
		$data['syllabus']   = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
		$this->loadViews('student/attendence/attendence_list',$data);
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
		$this->loadViews('student/timings/sms_exam_timetable_page',$data);
	}
    
    //Uploaded Marks List
    public function UploadedMarksList(){
        $data['PageTitle'] = "Uploaded Marks List";
		$schooldata = $data['schooldata'] = $this->session->userdata['school'];
		$data['userdata'] = $userdata = $this->Model_integrate->userdata();
		$data['schoolid'] = $schoolid = $schooldata->school_id;
		$data['branchid'] = $branchid = $schooldata->branch_id;
		$data['scltype']  = $schooldata->scltype;
		$data['slabslist']= $this->Model_dashboard->selectorderby('sms_examination_slabs_list',array('school_id'=>$schoolid,'branch_id'=>$branchid,'status'=>1),'updated');
		$data['uploadedmarks']= $this->Model_dashboard->selectorderby('sms_marks_uploaded_list',array('school_id'=>$schoolid,'branch_id'=>$branchid,'id_num'=>$userdata->id_num,'c_status'=>0,'a_status'=>0,'status'=>1),'updated DESC');
		$this->loadViews('student/examinations/sms_marksupload_list',$data);
    }
    
    //user profile
	public function userprofileDetails(){
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id = $data['school_id'] =   $details['school']->school_id;
		$branch_id = $data['branch_id'] =   $details['school']->branch_id;
		$school_academic = $details['school']->school_academic;
		$school_academic_form_to    =   $details['school']->school_academic_form_to;
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Profile Details..!";
		$data['countries'] = $this->Model_default->selectconduction('sms_countries',array('status'=>1));
		$data['gender']     = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'gender','status'=>1));
		$this->loadViews('student/profile/sms_profile',$data);
	}

	public function updateProfileData(){
		extract($_REQUEST);
		$userdata = $this->Model_default->selectconduction('sms_admissions',array('sno'=>$id,'id_num'=>$reg_id,'branch_id'=>$branch_id,'school_id'=>$school_id));
		
        if(count($userdata) != 0){
            $this->createdir('./uploads/files/admissions/'.$branch_id.'/'.$school_id.'/'.$reg_id,'./uploads/files/admissions/'.$branch_id.'/'.$school_id.'/'.$reg_id.'');
			if(!empty($_FILES['profileimage']['name'])){
				$path = 'uploads/files/admissions/'.$branch_id.'/'.$school_id.'/'.$reg_id.'/';
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
                'altermobile' =>  $empphone,  
                'dob'         =>  date('Y-m-d',strtotime($empdob)),
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
			$updatedetails = $this->Model_dashboard->updatedata($updatedata,$conduction,'sms_admissions');
			if($updatedetails != 0){
				$this->Model_dashboard->updatedata(array('mailid'=>$email,'updated' => date('Y-m-d H:i:s')),array('reg_id'=>$reg_id),'sms_reg');
				$this->successalert('Successfully Update Details..!',$firstname.' details as updated successfully..!');
				redirect(base_url('student/profile'));
			}else{
				$this->failedalert('Failed to Update Details..!',$firstname.' details as failed to updated..!');
				redirect(base_url('student/profile?update=failed'));
			}
		}else{
			//other users to update profile
            $this->failedalert('Failed to Update Details..!',$firstname.' details are not found or invalid request or oops error..!');
            redirect(base_url('student/profile?update=failed'));
		}
	}

	public function updatePassword(){
		extract($_REQUEST);
		$schooldata = $this->session->userdata['school'];
		$school_id = $schooldata->school_id;
		$branch_id = $schooldata->branch_id;
		$userdata = $this->Model_default->selectconduction('sms_admissions',array('sno'=>$id,'id_num'=>$reg_id));
		$useraccount = $this->Model_default->selectconduction('sms_users',array('school_id'=>$school_id,'usertype'=>'student','branch_id'=>$branch_id,'id_num'=>$reg_id));
		if(count($userdata) != 0){
			if($useraccount[0]->password == md5($old_password)){
				if($new_password == $confirm_password){
					$conduction =   array('school_id'=>$school_id,'branch_id'=>$branch_id,'id_num'=>$reg_id);
					$updatedata =   array(
						'password'         =>  md5($new_password),
						'updated'          =>  date('Y-m-d H:i:s'),
					);
					$updatedetails = $this->Model_dashboard->updatedata($updatedata,$conduction,'sms_users');
					if($updatedetails != 0){
						$this->successalert('Successfully Update Password..!',' Details as updated successfully..!');
						$this->logout();
						//redirect(base_url('teacher/profile?update=success'));
					}else{
						$this->failedalert('Failed to Update Password..!',' Details as failed to update..!');
						redirect(base_url('student/profile'));
					}
				}else{
					$this->failedalert('Failed to Update Password..!',' Please check new password & confirm password must be same..!');
					redirect(base_url('student/profile'));
				}

			}else{
				$this->failedalert('Failed to Update Password..!',' Please enter currect  old password..!');
				redirect(base_url('student/profile'));
			}


		}else{
			//other users to update profile
            $this->failedalert('Failed to Update Password..!','Details are not found or invalid request or oops error..!');
            redirect(base_url('teacher/profile'));
		}
	}

	public function attendenceReports()
	{
		
	}

}
