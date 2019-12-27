<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_reports extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }

    //Add new report
    public function AdminAddReports(){
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "New Reports..!";
        $data['schooldata'] = $this->session->userdata['school'];
        $this->loadViews('admin/reports/reports_add',$data);
    }

    //ajax for reporting list
    public function addRepresentsList(){
        extract($_REQUEST);
        $data['userdata'] = $this->Model_integrate->userdata();
        $schooldata = $this->session->userdata['school'];
        $school_id = $schooldata->school_id;
        $branch_id = $schooldata->branch_id;
        $feachdata=array();
        if($report_to != 'student'){
            $employeesdata = $this->Model_default->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'emoloyeeposition'=>$report_to));
            foreach ($employeesdata as $key => $value) {
                # code...
                $feachdata[] = array('sno'=>$value->sno,'id_num'=>$value->id_num,'firstname'=>$value->firstname,'lastname'=>$value->lastname);
            }
            $usersdata = $feachdata;
        }else if($report_to == 'student'){
            $studentsdata = $this->Model_default->selectdata('sms_admissions',array('school_id'=>$school_id,'branch_id'=>$branch_id));
            foreach ($studentsdata as $key => $value) {
                # code...
                $feachdata[] = array('sno'=>$value->sno,'id_num'=>$value->id_num,'firstname'=>$value->firstname,'lastname'=>$value->lastname);
            }
            $usersdata = $feachdata;
        }
        if(count($usersdata) != 0){
            echo json_encode($usersdata);
        }else{
            $usersdata = array();
            echo json_encode($usersdata);
        }
    }

    //Homework Report
    public function addNewHomeworkReport(){
        $data['userdata'] = $this->Model_integrate->userdata();
        $schooldata = $this->session->userdata['school'];
        $data['school_id']  =  $school_id = $schooldata->school_id;
        $data['branch_id']  =  $branch_id = $schooldata->branch_id;
        $data['PageTitle']  = "Homework Reports..!";
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($school_id,$branch_id);
        $data['homeworks']	=$this->Model_dashboard->selectdata('sms_homework_reports',array('school_id'=>$school_id,'branch_id'=>$branch_id,'hw_date'=>date('Y-m-d')),'hw_date');//,
        $data['schooldata'] = $this->session->userdata['school'];
        $this->loadViews('admin/dairy/homework_dairy_add',$data);
    }

    //Homework List
    public function homeworkReportsList(){
        $data['userdata'] = $this->Model_integrate->userdata();
        $schooldata = $this->session->userdata['school'];
        $data['school_id']  =  $school_id = $schooldata->school_id;
        $data['branch_id']  =  $branch_id = $schooldata->branch_id;
        $data['PageTitle']  = "Homework Reports List..!";
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($school_id,$branch_id);
        $data['homeworks']  = $this->Model_dashboard->selectdata('sms_homework_reports',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1),'id');
        $data['schooldata'] = $this->session->userdata['school'];
        $this->loadViews('admin/dairy/homework_dairy_list',$data);
    }
    
    //delete Homework
    public function deleteHomeworkReport(){
        $id = $this->uri->segment(4);
        $conduction = array('id'=>$id);
		$updatedata = array('status'=>0,'publish'=>0,'updated'=>date('Y-m-d H:i:s'));
        $insertdairydata = $this->Model_dashboard->updatedata($updatedata,$conduction,'sms_homework_reports');
        if ($insertdairydata != 0) {
            $this->successalert('Homework Successfully Deleted..!', 'Homework as deleted and you can not able to retrive back. Add New Homework..!');
            redirect('dashboard/reports/homeworkslist');
        } else {
            $this->successalert('Homework failed to Deleted..!', ' Homework as failed to Deleted and check once retry..!');
            redirect('dashboard/reports/homeworkslist');
        }
    }
    
    //save edit Homework details
    public function saveEditHomeworkDetails(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $school_id  = $schooldata->school_id;
        $branch_id  = $schooldata->branch_id;
        //get or check data is existing  -- subject -- subject_hw
        $checkdata  = $this->Model_dashboard->selectdata('sms_homework_reports',array('school_id'=>$school_id,'branch_id'=>$branch_id,'syllabus'=>$syllabus,'class'=>$syllabus_class,'section'=>$class_section,'hw_date'=>date('Y-m-d',strtotime($report_date)),'status'=>1));
        
        $hwdetails = unserialize($checkdata[0]->hw_details);
                                                                                                     
        for($i = 0; $i < count($hwdetails); $i++){
            foreach($hwdetails[$i] as $key => $hwdetail){ 
                if($key == $subject){
                    $hw = $subject_hw;
                }else{
                    $hw = $hwdetail;
                }
                //$key.$hwdetail;
                $hwdetails[$i] =  array($key => $hw);
            }
        }
        
        
        $conduction = array('school_id'=>$school_id, 'branch_id'=>$branch_id, 'syllabus'=>$syllabus, 'class'=>$syllabus_class, 'section'=>$class_section, 'hw_date'=>date('Y-m-d',strtotime($report_date)), 'status'=>1, 'id'=>$checkdata[0]->id);
		$updatedata = array('hw_details' => serialize($hwdetails),'updated' => date('Y-m-d H:i:s'));;
        $insertdairydata = $this->Model_dashboard->updatedata($updatedata,$conduction,'sms_homework_reports');
        if($insertdairydata != 0){
            $data = array('responce'=>1,'message'=>'Homework Data as Successfully Updated..!');
        }else{
            $data = array('responce'=>0,'message'=>'Homework Data as Failed to Updated..!');
        }
        
        echo json_encode($data);
    }
    
    //get subjects for homework
    public function dairySubjectsList(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $school_id  = $schooldata->school_id;
        $branch_id  = $schooldata->branch_id;
        $subjectsList = $this->Model_dashboard->selectdata('sms_subjects',array('school_id'=>$school_id,'branch_id'=>$branch_id,'scl_types'=>$syllabustype,'class'=>$classname,'status'=>1));
        // $this->print_r($_REQUEST);
        // exit;
        if(count($subjectsList) != 0){
            $subjectsdetails   =    $subjectsList[0];
            $subjectslist      =    unserialize($subjectsdetails->subject);
            //$this->print_r($subjectslist);
        ?>
        <style type="text/css">
            .myborderstyle{
                border-style: hidden !important;
                border-bottom-style: dashed !important;
                /* border-bottom: 1px solid #a0a0a0 !important; */
                border-radius: unset;
            }
        </style>
            <div class="col-md-12 form-group">
                <span style="text-align: center" id="ReportdataStatus"></span>
                <div class="row">
                    <div class="col-md-3 font-weight-bold">Subject Name</div>
                    <div class="col-md-9 font-weight-bold">
                        Today's Homework
                    </div>
                </div>
            </div>
        <?php 
			$reportslist = $this->Model_dashboard->selectdata('sms_homework_reports', array('school_id'=>$school_id, 'branch_id'=>$branch_id, 'syllabus'=>$syllabustype, 'class'=>$classname, 'section'=>$Section, 'hw_date'=>date('Y-m-d',strtotime($reportdate))));
        	//$this->print_r($reportslist);
            if(count($reportslist) != 0){ 
                //Section check
    //			$this->print_r($reportslist);
    //				if($reportslist[0]->section == 'all' && $Section == 'all'){
    //			}

				$subjecthomework = unserialize($reportslist[0]->hw_details);
				foreach ($subjectslist as $key => $value) {
        ?>
					<div class="col-md-12 form-group">
						<div class="row">
							<div class="col-md-3"><label style="color: #56585a;font-size: 13px;margin: 6px 0px;"><?=$value?> </label><span style="float: right;color: #56585a;font-size: 13px;margin: 6px 0px;"> : </span></div>
							<div class="col-md-8">
								<input type="hidden" value="<?=$value?>" id="subjectName_<?=$subjectslist[$key]?>" name="homework_subjects[]">
								<input type="text" value="<?= $subjecthomework[$key][$value]; ?>" readonly name="homework_details[]" id="subjectvalue_<?=$subjectslist[$key]?>" class="form-control myborderstyle" placeholder="Today's <?=$value?> Homework...">
							</div>
							<div class="col-md-1">
								<a href="javascript:;" id="editsubject_<?=$subjectslist[$key]?>"><i class="fa fa-edit fa-dx"></i></a>
								<a href="javascript:;" style="display: none" id="confirmsubject_<?=$subjectslist[$key]?>"><i class="fa fa-check fa-dx"></i></a>

							</div>
						</div>
					</div>
					<script>
						$(document).ready(function () {
							$('#editsubject_<?=$subjectslist[$key]?>').click(function () {
								var value = $("#subjectvalue_<?=$subjectslist[$key]?>").val();
								$("#confirmsubject_<?=$subjectslist[$key]?>").show();
                                $('#editsubject_<?=$subjectslist[$key]?>').hide();
                                $("#subjectvalue_<?=$subjectslist[$key]?>").removeAttr('readonly');
                                $("#ReportdataStatus").text('');
                            })

							$("#confirmsubject_<?=$subjectslist[$key]?>").click(function () {
								//save edited subject data via ajax
                                $("#ReportdataStatus").text('');
                                var subject_value  = $("#subjectvalue_<?=$subjectslist[$key]?>").val();
                                var subject_name   = $("#subjectName_<?=$subjectslist[$key]?>").val();
                                var syllabus       = '<?=$syllabustype?>';
                                var syllabusclass  = '<?=$classname?>';
                                var syllabusection = '<?=$Section?>';
                                var reportdate     = $('#reportHomeworkDate').val();
                                
                                var savedata = {'subject':subject_name,'subject_hw':subject_value,'syllabus':syllabus,'syllabus_class':syllabusclass,'class_section':syllabusection,'report_date':reportdate};
                                
                                if(reportdate != '' && syllabus != '' && syllabusclass != '' && syllabusection != ''){
                                    //alert(savedata);
                                    $("#loader").show();
                                    $.ajax({
                                        method:"POST",
                                        data:savedata,
                                        url: "<?=base_url('dashboard/reports/saveEditHomeworkDetails')?>",
                                        dataType : 'json',
                                        success : function(responcedata){
                                            console.log(responcedata);
                                            $("#loader").hide();
                                            if(responcedata.responce == 1){
                                                $("#ReportdataStatus").css('color','green');
                                                $("#ReportdataStatus").text(responcedata.message);
                                               
                                            }else{
                                                $("#ReportdataStatus").css('color','red');
                                                $("#ReportdataStatus").text(responcedata.message);
                                            }
                                            $("#confirmsubject_<?=$subjectslist[$key]?>").hide();
                                            $('#editsubject_<?=$subjectslist[$key]?>').show();
                                            $("#subjectvalue_<?=$subjectslist[$key]?>").attr('readonly','');
                                        },
                                        error: function(eresponcedata){
                                            console.log(eresponcedata);
                                        }
                                    })
                                    
                                }else{
                                    alert("please fill all fields..?");
                                }
                                
                                
                            })
                        })
					</script>
        <?php }

            }else {
				foreach ($subjectslist as $key => $value) { ?>
					<div class="col-md-12 form-group">
						<div class="row">
							<div class="col-md-3"><label
									style="color: #56585a;font-size: 13px;margin: 6px 0px;"><?= $value ?> </label><span
									style="float: right;color: #56585a;font-size: 13px;margin: 6px 0px;"> : </span>
							</div>
							<div class="col-md-9">
								<input type="hidden" value="<?= $value ?>" name="homework_subjects[]">
								<input type="text" name="homework_details[]" class="form-control myborderstyle"
									   placeholder="Today's <?= $value ?> Homework...">
							</div>
						</div>
					</div>
			<?php } ?>
			<div class="col-md-12">
				<div class="row justify-content-center align-content-center">
					<input type="submit" value="Save Homework" name="hw_submit" class="btn btn-success">
				</div>
			</div>
			<?php
			}
			
        }else{
            ?>
            <div class="col-md-12 form-group">
                <div class="row align-content-center justify-content-center">
                    <div class="col-md-8 font-weight-bold text-center">
                        No subjects found to give Homework <br> <a href="<?=base_url('setup/subjects')?>" onclick="return confirm('Do you want add subjects to <?=$classname?> class..?');"> Add subjects to <?=$classname?> class</a>.
                    </div>
                </div>
            </div>
            <?php
        }
    }

    //save homework details
	public function saveHomeworkDetails(){
    	extract($_REQUEST);
    	$userdata = $this->Model_integrate->userdata();
		$schooldata = $this->session->userdata['school'];
		$data['school_id']  =  $school_id = $schooldata->school_id;
		$data['branch_id']  =  $branch_id = $schooldata->branch_id;
		$homework_subjectwithdetails = array();
		if(isset($userdata->id_num)){
			$id_num = $userdata->id_num;
		}else{
			$id_num = $userdata->reg_id;
		}
		foreach ($homework_subjects as $key => $homework_subject){
			$homework_subjectwithdetails[] =  array($homework_subject => $homework_details[$key]);
		}

        if(!empty($reportHomeworkDate)){
            $homeworkreportdate = date('Y-m-d',strtotime($reportHomeworkDate));   
        }else{
            $homeworkreportdate = date('Y-m-d');
        }

		$chechdairyreport = $this->Model_dashboard->selectdata('sms_homework_reports',array('school_id'=>$school_id,'branch_id'=>$branch_id,'syllabus'=>$StdSyllubas,'class'=>$StdClass,'section'=>$StdClassSection,'hw_date'=>$homeworkreportdate));
		if(count($chechdairyreport) != 0){
			//update

		}else {
			$inserting_data = array('school_id' => $school_id, 'branch_id' => $branch_id, 'syllabus' => $StdSyllubas, 'class' => $StdClass, 'section' => $StdClassSection, 'hw_date' => $homeworkreportdate, 'hw_details' => serialize($homework_subjectwithdetails), 'uploaded_by' => $id_num, 'updated' => date('Y-m-d H:i:s'));
			$insertdairydata = $this->Model_dashboard->insertdata('sms_homework_reports', $inserting_data);
			if($insertdairydata != 0){
				$this->successalert('Homework Successfully saved..!',$StdClass.' Homework as successfully submitted and check once publish it..!');
				redirect('dashboard/reports/newdailyhomeworks');
			}else{
				$this->successalert('Homework failed to save..!',$StdClass.' Homework as failed to submitted and check once retry..!');
				redirect('dashboard/reports/newdailyhomeworks');
			}
		}
	}

	//publish or Unpublish Homework Report
	public function publishUnpublishHwReport(){
		$schooldata = $this->session->userdata['school'];
		$data['school_id']  =  $school_id = $schooldata->school_id;
		$data['branch_id']  =  $branch_id = $schooldata->branch_id;
		$sno_id	= $this->uri->segment(4);
		$status	= $this->uri->segment(5);
		$type	= $this->uri->segment(6);
		$conduction = array('branch_id'=>$branch_id,'school_id'=>$school_id,'id'=>$sno_id);
		$updatedata = array('publish'=>$status,'updated'=>date('Y-m-d H:i:s'));
		if($type == 'publish') {
			$insertdairydata = $this->Model_dashboard->updatedata($updatedata,$conduction,'sms_homework_reports');
			if ($insertdairydata != 0) {
				$this->successalert('Homework Successfully publish..!', ' Homework as successfully publish and please check once..!');
				redirect('dashboard/reports/newdailyhomeworks');
			} else {
				$this->successalert('Homework failed to publish..!', ' Homework as failed to publish and check once retry..!');
				redirect('dashboard/reports/newdailyhomeworks');
			}
		}else{
			$insertdairydata = $this->Model_dashboard->updatedata($updatedata,$conduction,'sms_homework_reports');
			if ($insertdairydata != 0) {
				$this->successalert('Homework Successfully Unpublished..!', ' Homework as successfully Unpublished and please check once..!');
				redirect('dashboard/reports/newdailyhomeworks');
			} else {
				$this->successalert('Homework failed to Unpublished..!', ' Homework as failed to Unpublished and check once retry..!');
				redirect('dashboard/reports/newdailyhomeworks');
			}
		}
	}

    //save new notice data
    public function savenotice(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        //event id
        $schoolname =  $schooldata->schoolname;
		$noticeslist = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id));
		$countlist = count($noticeslist) + 1;
		$letters =  random_string('alpha', 1);
		$alfnums =  random_string('alnum', 1);
		$studentname = strtoupper($letters).' '.strtoupper($alfnums);
		$noticeid   = $this->manualgenerate_id($schoolname,date('y'),$studentname,$countlist);

        $noticeto = implode(',',$noticeto);
        //$this->print_r($noticeto);
        //exit;
        $noticesdir = $this->createdir('./uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $noticeid,'./uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $noticeid.'');
        //image upload
        if($_FILES['noticeupload']['name'] != '') {
            $parentimage = $this->uploadfiles('./uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $noticeid, 'noticeupload', '*', FALSE, '', '');
            $noticeimage = 'uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $noticeid . '/' . $parentimage['uploaddata']['file_name'];
        }else{ $noticeimage = '';}

        $noticesotherfilesdir = $this->createdir('./uploads/notice_files/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $noticeid,'./uploads/notice_files/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $noticeid);
        //multi files

		if($_FILES['noticeOtheruploads']['name'][0] != ''){
			$noticefiles = $this->multiuploadfiles('uploads/notice_files/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num.'/','noticeOtheruploads','*',FALSE,'','');
			$noticefiles = $noticefiles['uploaddata'];
		}else{  $noticefiles = ''; };


        if(date('Y-m-d',strtotime($noticepublishdate)) < date('Y-m-d')){
            $publish_status = 1;
        }else{
            $publish_status = 2;
        }

        $insertdata = array(
            'branch_id'     =>  $schooldata->branch_id,
            'school_id'     =>  $schooldata->school_id,
            'id_num'        =>  $noticeid,
            'notice_title'  =>  $noticetitle,
            'notice_type'   =>  'info',
            'notice_img'    =>  $noticeimage,
            'notice_files'  =>  $noticefiles,
            'notice_content'=>  $noticecontent,
            'notice_to'     =>  $noticeto,
            'publish_status'=>  $publish_status,
            'notice_date'   =>  date('Y-m-d',strtotime($noticedate)),
            'notice_publish'=>  date('Y-m-d',strtotime($noticepublishdate)),
            'updated'       =>  date('Y-m-d H:i:s')
        );

        $notice = $this->Model_dashboard->insertdata('sms_notice',$insertdata);
        if($notice != 0){
        	$this->successalert('Successfully placed on notice board..','You have placed notice '.$noticetitle);
            redirect(base_url('dashboard/notice/noticelist'));
        }else{
			$this->successalert('Failed to placed on notice board..','Failed to placed notice '.$noticetitle);
            redirect(base_url('dashboard/notice/addnotice'));
        }
    }

    //display list of reports
    public function AdminReportsList(){
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "Reports List..!";
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $data['noticelist'] = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'updated');
        $data['schooldata'] = $schooldata;
        $this->loadViews('admin/reports/reports_list',$data);
    }

    //delete notice record
    public function deletenotice(){
        $schooldata = $this->session->userdata['school'];
        $sno = $this->uri->segment(4);
        $schoolid   = $schooldata->school_id;
        $branchid   = $schooldata->branch_id;
        if(isset($sno) && !empty($sno)){
            $conduction = array(
                'branch_id' => $branchid,
                'school_id' => $schoolid,
                'sno' => $sno
            );
            $insertdata = array(
                'status'        =>  0,
                'publish_status'=>  0,
                'updated' => date('Y-m-d H:i:s')
            );
            $visiters = $visiteredit = $this->Model_dashboard->updatedata($insertdata, $conduction,'sms_notice');
            if ($visiters != 0) {
            	$this->successalert('Successfully delete notice..!','Notice as deleted successfully..!');
                redirect(base_url('dashboard/notice/noticelist'));
            } else {
				$this->failedalert('Failed to delete notice..!','Notice as failed to deleted..!');
                redirect(base_url('dashboard/notice/noticelist'));
            }
        }else{
			$this->failedalert('Invalid request to delete notice..!','Notice as not deleted or invalid request..!');
            redirect(base_url('dashboard/notice/noticelist'));
        }
    }

    //edit notice record
    public function editNotice(){
        $schooldata = $this->session->userdata['school'];
        $sno  = $this->uri->segment(4);
        $edit = $this->uri->segment(5);
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['noticelist'] = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'sno'=>$sno,'id_num'=>$edit),'updated');
        $data['PageTitle'] = "Edit Notice : ".$data['noticelist'][0]->id_num;
        $this->loadViews('admin/noticeboard/notice_edit',$data);
    }

    //save notice record
    public function saveEditNotice(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        //$this->print_r($_REQUEST);
        //$this->print_r($_FILES);

        $schoolid   = $schooldata->school_id;
        $branchid   = $schooldata->branch_id;
        if(isset($sno) && !empty($sno) && isset($id_num) && !empty($id_num)){
            $data = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'sno'=>$sno,'id_num'=>$id_num),'updated');
            if(count($data) != 0) {
                $noticeto = implode(',',$noticeto);
                $noticesdir = $this->createdir('./uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num,'./uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num.'');
                
                //image upload
                if($_FILES['noticeupload']['name'] != '') {
                    $parentimage = $this->uploadfiles('./uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num, 'noticeupload', '*', FALSE, '', '');
                    $noticeimage = 'uploads/notices/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num . '/' . $parentimage['uploaddata']['file_name'];
                }else{ $noticeimage = $UplaodedNoticeImage; }

                $noticesotherfilesdir = $this->createdir('./uploads/notice_files/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num,'./uploads/notice_files/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num);

                //multi files
                if($_FILES['noticeOtheruploads']['name'][0] != ''){
                	//echo "++++++++++++++";
                    $noticefiles = $this->multiuploadfiles('uploads/notice_files/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num.'/','noticeOtheruploads','*',FALSE,'','');
                    $noticefiles = $noticefiles['uploaddata'];
                    $this->print_r($noticefiles);
                }else{ $noticefiles = $UplaodedNoticeOtherFiles; }

                if(date('Y-m-d',strtotime($noticepublishdate)) < date('Y-m-d')){
                    $publish_status = 1;
                }else{
                    $publish_status = 2;
                }

                $insertdata = array(
                    'notice_title'  =>  $noticetitle,
                    'notice_type'   =>  'info',
                    'notice_img'    =>  $noticeimage,
                    'notice_files'  =>  $noticefiles,
                    'notice_content'=>  $noticecontent,
                    'notice_to'     =>  $noticeto,
                    'publish_status'=>  $publish_status,
                    'notice_date'   =>  date('Y-m-d',strtotime($noticedate)),
                    'notice_publish'=>  date('Y-m-d',strtotime($noticepublishdate)),
                    'updated'       =>  date('Y-m-d H:i:s')
                );

                $conduction = array(
                    'branch_id' => $branchid,
                    'school_id' => $schoolid,
                    'sno'       => $sno,
                    'id_num'    => $id_num,
                );

                $noticeedit = $this->Model_dashboard->updatedata($insertdata, $conduction, 'sms_notice');
				if($noticeedit != 0){
					$this->successalert('Successfully updated notice board..','You have updated notice '.$noticetitle);
					redirect(base_url('dashboard/notice/noticelist'));
				}else{
					$this->failedalert('Failed to updated on notice board..','Failed to updated notice '.$noticetitle);
					redirect(base_url('dashboard/notice/addnotice'));
				}
            }else{
				$this->failedalert('Failed to updated on notice board..','Notice Not Found or Invalid Request to update..!');
                redirect(base_url('dashboard/notice/noticelist'));
            }
        }else{
			$this->failedalert('Invalid to updated on notice board..','Notice Not Found or Invalid Request to update..!');
            redirect(base_url('dashboard/notice/noticelist'));
        }
    }

    //display details of notice
    public function Noticedetails(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $data['schoolid']   = $schooldata->school_id;
        $data['branchid']   = $schooldata->branch_id;
        $sno  = $this->uri->segment(3);
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['noticelist'] = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'sno'=>$sno),'updated');
        $data['PageTitle'] = "Notice : ".$data['noticelist'][0]->notice_title;
        $this->loadViews('admin/noticeboard/notice_details',$data);
    }
}
