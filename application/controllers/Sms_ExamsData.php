<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_ExamsData extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
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
		$this->loadViews('admin/examinations/sms_resultsupload',$data);
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
		$this->loadViews('admin/examinations/sms_resultsupload_list',$data);
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

	//Delete exam result by only admin
	public function DeleteExamResultData(){
		$sessiondata = $this->session->userdata();
		$schooldata	 = $sessiondata['school'];

		$insert_id	=	$this->uri->segment(4);
		$branch_id	=	$this->uri->segment(5);
		$school_id	=	$this->uri->segment(6);
		
		if((isset($insert_id) && $insert_id!='') && (isset($branch_id) && $branch_id!='') && (isset($school_id) && $school_id!='')){

			$deleterelateddata = array('branch_id'=>$branch_id,'school_id'=>$school_id,'sno'=>$insert_id);
			$delete_existing_data	=	$this->Model_default->deleterecord('sms_markslist',$deleterelateddata);
			if($delete_existing_data != 0){
				$this->successalert('Successfully  delete exam result list..!','You have successfully delete exam result list..!');
				redirect(base_url('dashboard/exams/uploaded/resultslist'));
			}else{
				$this->failedalert('Failed to delete exam result list..!','Sorry you have Failed to delete exam result list or Invalid Request.');
				redirect(base_url('dashboard/exams/uploaded/resultslist'));
			}
		}else{
			$this->failedalert('Unable to delete Exam Result List..!','Sorry you have unable to delete Exam Result List.Invalid Request or Opps Error.');
			redirect(base_url('dashboard/exams/uploaded/resultslist'));
		}
	}


}
