<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Defaultmethods extends BaseController{

    public function __construct(){
        parent::__construct();
        //$this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
        $this->session->set_userdata('redirect_back', $this->agent->referrer()); 
    }

    //defaut ajax data for all usefull forms or pages..
    public function stateslist(){
        extract($_REQUEST);
        $statelist = $this->Model_default->selectconduction('sms_states',array("country_id"=>$Countryid,'status'=>1));
        $data = $statelist;
        echo json_encode($data);
    }

    //citoes
    public function citieslist(){
        extract($_REQUEST);
        $citylist = $this->Model_default->selectconduction('sms_cities',array('state_id'=>$Stateid,'status'=>1));
        $data = $citylist;
        echo json_encode($data);
    }

    //all class list by syllubas type
    public function syllubasbyclasses(){
        extract($_REQUEST);
        $data = $this->Model_integrate->classeslist($schoolid,$branchid,$syllabustype);
        echo json_encode($data);
    }

    //sections list by class
	public function SectionsList(){
		extract($_REQUEST);
		$data = $this->Model_integrate->classSectionslist($schoolid,$branchid,$syllabustype,$classname);
		echo json_encode($data);
	}

    //lock screen via ajax
    public function lockscreen(){
        $data['sessiondata'] = $this->session->userdata;
        $this->load->view('sms_lockscreen',$data);
    }

    //unlock screen
    public function lockscreentounlock(){
        extract($_REQUEST);
        if($userid != '' && $password != ''){
            //check data admins
            $checkmail = $this->Model_login->checkUserExist($userid);
            if(count($checkmail) !=0){
                $password = md5($password);
            }else{
                $data = array('code' => 1,'message'=>'Email id not exists');
            }
            $result = $this->Model_login->loginlockscreen($userid,$password);
            if(count($result['userdata']) != 0) {
                if($result['userdata']['0']->status == 1 && $result['userdata']['0']->accmode == 1){
                    $sessionArray=array();
                    foreach ($result['userdata'] as $res) {
                        //getting school details for checking school details
                        $schooldata = $this->Model_default->selectconduction('sms_schoolinfo',array('reg_id'=>$res->reg_id));
                       //check usermode is superadmin or admin
                        if ($res->usermode == 'super-admin' || $res->usermode == 'superadmin' || $res->usermode == 'admin') {

                            //check licence details
                            $licence = $this->Model_default->checklicence($res->reg_id,$res->licence_id);
                            $today      = date('Y-m-d h:i:s');
                            $start      = strtotime($today);
                            $expary     = $licence['0']->todate;
                            $enddate    = strtotime($licence['0']->todate);
                            $totaldays  = $licence['0']->package_nodays;
                            $expering   = $licence['0']->package_expdays;

                            //total no of days
                            $datediff = $this->Model_integrate->datediff($today,$expary); 
                            $remainds = $datediff['diff'];
                            
                            if(($enddate <= $start) && ($totaldays <= $remainds)){
                                //redirect to licence upgrade
                                $data = array('code'=>0,'message'=>'licence upgrade');
                            }else{
                                $schoolinfo = $schooldata['0'];
                                $sessionArray = array(
                                    'regid' => $res->reg_id,
                                    'name' => $res->fname . '.' . $res->lname,
                                    'fname' => $res->fname,
                                    'lname' => $res->lname,
                                    'email' => $res->mailid,
                                    'type' => $res->usermode,
                                    'mobile' => $res->mobile,
                                    'sclmode' => $res->scl_mode,
                                    'licenceid'=>$res->licence_id,
                                    'licenceplan'=>$licence['0']->licence_plan,
                                    'school'    =>  $schoolinfo,
                                    'isLoggedIn' => TRUE,
                                    //'sessionData'=> $result['result2']
                                );
                            }
                            
                        }else{
                            $sessionArray = array(
                                'userId' => $res->reg_id,
                                'name' => $res->fname . '.' . $res->lname,
                                'email' => $res->mailid,
                                'type' => $res->usermode,
                                'mobile' => $res->mobile,
                                'isLoggedIn' => TRUE,
                                //'sessionData'=> $result['result2']
                            );
                        }
                        
                    }
                    $this->session->set_userdata($sessionArray);
                    $data = array('code'=>1,'message'=>'successfully login..please wait..');
                }else{
                    $data = array('code' => 0,'message'=>'Account is Deactivated..');
                }
            }
        }else{
            $data = array('code' => 0,'message'=>'invalid input data..');
        }
        echo json_encode($data);
    }

    //fee details of class & service
    public function feedetailsofclass(){
        extract($_REQUEST);
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $schoolid = $schooldata->school_id;
        $branchid = $schooldata->branch_id;
        if($schoolid == '' || $branchid == '' || $syllabus == '' || $classname == ''){
            $data = array('code'=>0,'message'=>'Should not leave empty fields..!');
        }else{
            $feedata = $this->Model_default->selectconduction('sms_class_fee_structure',array('scl_types'=>$syllabus,'class'=>$classname,'status'=>1,'branch_id'=>$branchid,'school_id'=>$schoolid));
            if($service == 'hostel'){
            	$servicefee = $feedata['0']->hostelfee;	
            }else if($service == 'vehicle'){
            	$servicefee = $feedata['0']->busfee;
            }else if($service == 'school'){
            	$servicefee = 0;
            }
            $schoolfee  = $feedata['0']->schoolfee;
            $otherfee   = unserialize($feedata['0']->otherfee);
            // foreach ($otherfee as $key => $value) {
            // 	$totalother .= $value;
            // }
            $total = $schoolfee + $servicefee;
            $feedata    = array('school'=>$schoolfee,'servicefee'=>$servicefee,'other'=>$otherfee);
            $data = array('code'=>1,'message'=>'Data found','data'=>$feedata,'total'=>$total);
        }
        echo json_encode($data);
    }

    //check envernmental id
    public function envernmentalid(){
    	extract($_REQUEST);
    	//getting school data in session
      $schooldata = $this->session->userdata['school'];
      $schoolid = $schooldata->school_id;
      $branchid = $schooldata->branch_id;
    	$check = $this->Model_default->selectconduction('sms_admissions',array('school_id'=>$schoolid,'branch_id'=>$branchid,'em_id'=>$environmentid));
    	if(count($check) != 0){
    		$data = array('code'=>1,'message'=>'environmentid is registered..');
    	}else{
    		$data = array('code'=>0,'message'=>'environmentid is accepeted');
    	}
    	echo json_encode($data);
    }

    //Notification's Main dashboard
	public function NotificationsDataList(){
        $this->isLoggedIn();
        $session = $this->session->userdata;
        $schooldata = $this->session->userdata['school'];
        $userdata = $this->Model_integrate->userdata();
		$school_id = $schooldata->school_id;
		$branch_id = $schooldata->branch_id;
        //$this->print_r($userdata);
        if($session['type'] == 'admin'){ 
            //exams
            $notificationstaffuploads = $this->Model_default->manualselect("SELECT * FROM `sms_marks_uploaded_list` WHERE school_id = '$school_id' AND branch_id = '$branch_id' AND status = 1 AND (c_status = 1 OR a_status = 1) GROUP BY exam_slab, syllabus, syllabus_class, upload_sno, upload_id_num ORDER BY updated DESC LIMIT 1");
            //$this->print_r($notificationstaffuploads);
            
            
            
            $notificationcount = count($notificationstaffuploads);
        ?>
			<li class="dropdown-header">NOTIFICATIONS (<?=$notificationcount?>)</li>
            <?php if(count($notificationstaffuploads) != 0){  
                    foreach($notificationstaffuploads as $staffupload){ 
                        $note_employeedetails = $this->Model_default->manualselect("SELECT * FROM `sms_employee` WHERE school_id = '$school_id' AND branch_id = '$branch_id' AND sno = '$staffupload->upload_sno' AND id_num = '$staffupload->upload_id_num' ORDER BY sno DESC");
                        $employeedetails = $note_employeedetails[0];
                        $n_syllabusname = $this->Model_dashboard->syllabusname(array('id'=>$staffupload->syllabus));
                        $n_syllabusname = $n_syllabusname[0];
                ?>
                     <li class="media">
                        <a href="javascript:;">
                            <div class="media-left">
                                <i class="fa fa-cogs media-object bg-silver-darker"></i>
                            </div>
                            <div class="media-body">
                                <h6 class="media-heading"><?=ucwords($employeedetails->firstname).' : Upload '.$n_syllabusname->type.'-'.$staffupload->syllabus_class?>class marks.</h6>
                                <div class="text-muted f-s-11"><?=$this->Model_dashboard->daysago($staffupload->updated)?></div>
                            </div>
                        </a>
                    </li>			
            <?php } } ?>

		<?php }else if($session['type'] == 'superadmin'){ ?>

            <li class="dropdown-header">NOTIFICATIONS (5)</li>
			<li class="media">
				<a href="javascript:;">
					<div class="media-left">
						<i class="fa fa-bug media-object bg-silver-darker"></i>
					</div>
					<div class="media-body">
						<h6 class="media-heading">Server Error Reports <i class="fa fa-exclamation-circle text-danger"></i></h6>
						<div class="text-muted f-s-11">3 minutes ago</div>
					</div>
				</a>
			</li>		

        <?php }else if($session['type'] == 'classteacher'){ 
                //exam results uploaded
                $notificationstaffuploads = $this->Model_default->manualselect("SELECT * FROM `sms_marks_uploaded_list` WHERE school_id = '$school_id' AND branch_id = '$branch_id' AND status = 1 AND c_status = 1 AND syllabus = $userdata->employee_syllabus AND syllabus_class = '$userdata->employeeclass' GROUP BY exam_slab, syllabus, syllabus_class, upload_sno, upload_id_num ORDER BY updated DESC LIMIT 1");
                //print_r($notificationstaffuploads);
            
            $notificationcount = count($notificationstaffuploads);
            ?>
            <li class="dropdown-header">NOTIFICATIONS (<?=$notificationcount?>)</li>
            <?php if(count($notificationstaffuploads) != 0){  
                    foreach($notificationstaffuploads as $staffupload){ 
                        $note_employeedetails = $this->Model_default->manualselect("SELECT * FROM `sms_employee` WHERE school_id = '$school_id' AND branch_id = '$branch_id' AND sno = '$staffupload->upload_sno' AND id_num = '$staffupload->upload_id_num' ORDER BY sno DESC");
                        $employeedetails = $note_employeedetails[0];
                        $n_syllabusname = $this->Model_dashboard->syllabusname(array('id'=>$staffupload->syllabus));
                        $n_syllabusname = $n_syllabusname[0];
                ?>
                     <li class="media">
                        <a href="javascript:;">
                            <div class="media-left">
                                <i class="fa fa-cogs media-object bg-silver-darker"></i>
                            </div>
                            <div class="media-body">
                                <h6 class="media-heading"><?=ucwords($employeedetails->firstname).' : Upload '.$n_syllabusname->type.'-'.$staffupload->syllabus_class?>class marks.</h6>
                                <div class="text-muted f-s-11"><?=$this->Model_dashboard->daysago($staffupload->updated)?></div>
                            </div>
                        </a>
                    </li>			
            <?php } } ?>
			
        <?php }else if($session['type'] == 'teacher'){ ?>
            <li class="dropdown-header">NOTIFICATIONS (5)</li>
			<li class="media">
				<a href="javascript:;">
					<div class="media-left">
						<i class="fa fa-bug media-object bg-silver-darker"></i>
					</div>
					<div class="media-body">
						<h6 class="media-heading">Server Error Reports <i class="fa fa-exclamation-circle text-danger"></i></h6>
						<div class="text-muted f-s-11">3 minutes ago</div>
					</div>
				</a>
			</li>			
			<li class="dropdown-footer text-center">
				<a href="javascript:;">View more</a>
			</li>
        <?php }else if($session['type'] == 'student'){ ?>
            <li class="dropdown-header">NOTIFICATIONS (5)</li>
			<li class="media">
				<a href="javascript:;">
					<div class="media-left">
						<i class="fa fa-bug media-object bg-silver-darker"></i>
					</div>
					<div class="media-body">
						<h6 class="media-heading">Server Error Reports <i class="fa fa-exclamation-circle text-danger"></i></h6>
						<div class="text-muted f-s-11">3 minutes ago</div>
					</div>
				</a>
			</li>			
			<li class="dropdown-footer text-center">
				<a href="javascript:;">View more</a>
			</li>
        <?php }else if($session['type'] == 'accountant'){ ?>
            <li class="dropdown-header">NOTIFICATIONS (5)</li>
			<li class="media">
				<a href="javascript:;">
					<div class="media-left">
						<i class="fa fa-bug media-object bg-silver-darker"></i>
					</div>
					<div class="media-body">
						<h6 class="media-heading">Server Error Reports <i class="fa fa-exclamation-circle text-danger"></i></h6>
						<div class="text-muted f-s-11">3 minutes ago</div>
					</div>
				</a>
			</li>			
			<li class="dropdown-footer text-center">
				<a href="javascript:;">View more</a>
			</li>
        <?php }
	}

    
    //notification count
    public function NotificationsDatacountList(){
		$this->isLoggedIn();
        $session = $this->session->userdata;
        $schooldata = $this->session->userdata['school'];
        $userdata = $this->Model_integrate->userdata();
		$school_id = $schooldata->school_id;
		$branch_id = $schooldata->branch_id;
        //$this->print_r($userdata);
        if($session['type'] == 'admin'){ 
            //exams
            $notificationstaffuploads = $this->Model_default->manualselect("SELECT * FROM `sms_marks_uploaded_list` WHERE school_id = '$school_id' AND branch_id = '$branch_id' AND status = 1 AND (c_status = 1 OR a_status = 1) GROUP BY exam_slab, syllabus, syllabus_class, upload_sno, upload_id_num ORDER BY updated DESC LIMIT 1");
            //$this->print_r($notificationstaffuploads);
            $notificationcount = count($notificationstaffuploads);
        
        }else if($session['type'] == 'superadmin'){
            $notificationcount = 0;
        }else if($session['type'] == 'classteacher'){ 
                //exam results uploaded
                $notificationstaffuploads = $this->Model_default->manualselect("SELECT * FROM `sms_marks_uploaded_list` WHERE school_id = '$school_id' AND branch_id = '$branch_id' AND status = 1 AND c_status = 1 AND syllabus = $userdata->employee_syllabus AND syllabus_class = '$userdata->employeeclass' GROUP BY exam_slab, syllabus, syllabus_class, upload_sno, upload_id_num ORDER BY updated DESC LIMIT 1");
                //print_r($notificationstaffuploads);
                $notificationcount = count($notificationstaffuploads);
        }else if($session['type'] == 'teacher'){
            $notificationcount = 0;
        }else if($session['type'] == 'student'){
            $notificationcount = 0;
        }else if($session['type'] == 'accountant'){
            $notificationcount = 0;
        }else{
            $notificationcount = 0;
        } ?>
			<i class="fa fa-bell"></i>
			<span class="label"><?= $notificationcount ?></span>
    <?php
	}
    
    //GetClassForSyllabus
    public function GetClassForSyllabus(){
        extract($_REQUEST);
		$data = $this->Model_integrate->classeslist($school_id,$branch_id,$syllabus);
		if(isset($selectdemp_class)){
			$class 	=	$selectdemp_class;
		}
		?>
            <label class="col-md-12">Select class to deal.</label>
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="row">
                        <?php if(count($data) != 0){ ?>
                            <?php foreach($data as $value){ ?>
                            <div class="custom-control custom-radio col-md-1">
                                <input type="radio" class="custom-control-input" id="customCheck_<?= $value ?>" value="<?= $value ?>" name="syllabus_class" <?php if(isset($selectdemp_class) && $selectdemp_class == $value){ echo "checked"; } ?> >
                                <label class="custom-control-label" style="padding: 3px;" for="customCheck_<?= $value ?>"> <?= $value ?></label>
                            </div>
                            <script>
                                $(document).ready(function(){

                                	<?php if((isset($selectdemp_class) && $selectdemp_class != '') && (isset($dealingsub) && $dealingsub != '')){ ?>
										var selectedclass    =   '<?=$selectdemp_class?>';
										var selectedsyllabus =   '<?=$syllabus?>';
										var school_id        =   '<?=$school_id?>';
										var branch_id        =   '<?=$branch_id?>';
										var selectedsubjects =	 '<?=$dealingsub?>';
										$.ajax("<?=base_url('dashboard/employee/syllabus/getSubjects')?>?syllabus="+selectedsyllabus+"&school_id="+school_id+"&branch_id="+branch_id+"&class="+selectedclass+"&subjectslist="+selectedsubjects,{  success: function (data, status, xhr) {
												$('#SyllabusClassSubjectsList').html("");
												$('#SyllabusClassSubjectsList').html(data);
											} }
										);
                                    <?php } ?>

                                    $("#customCheck_<?= $value ?>").change(function(){
                                        var selectedclass    =    $(this).val();
                                        var selectedsyllabus =   '<?=$syllabus?>';
                                        var school_id        =   '<?=$school_id?>';
                                        var branch_id        =   '<?=$branch_id?>';
                                        if(selectedsyllabus != '' && school_id != '' && branch_id != ''){
                                           $.ajax("<?=base_url('dashboard/employee/syllabus/getSubjects')?>?syllabus="+selectedsyllabus+"&school_id="+school_id+"&branch_id="+branch_id+"&class="+selectedclass,{  success: function (data, status, xhr) {
                                               $('#SyllabusClassSubjectsList').html("");
                                               $('#SyllabusClassSubjectsList').html(data); 
                                           		} }
										   );
                                        }else{
                                            alert("please select class..!");
                                        }
                                    });

                                });
                            </script>
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="col-md-12">
                                <h5 class="pt-1 pb-1 text-center">No Class Found. Add Class <a href="<?=base_url('setup/classes')?>">Click here</a></h5>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php
    }
    
    //GetClassSubjectsForSyllabus
    public function GetClassSubjectsForSyllabus(){
        extract($_REQUEST);

        $assignsubjectslist = $this->Model_default->selectconduction('sms_subjects',array('branch_id'=>$branch_id,'school_id'=>$school_id,'class'=>$class,'scl_types'=>$syllabus,'status'=>1),'updated DESC');
        //$this->print_r($_REQUEST);
        ?>
        <label class="col-md-12 mt-2">Select Subject to deal.</label>
        <div class="col-md-12">
            <div class="row">
                <?php if(count($assignsubjectslist) != 0){ ?>
					<?php $assignedsubjects = unserialize($assignsubjectslist[0]->subject);
						foreach ($assignedsubjects as $list){ ?>
							<div class="custom-control custom-checkbox mr-3 ml-3">
								<input type="checkbox" class="custom-control-input" id="customCheck_<?=str_replace('"','',$list)?>" value="<?=str_replace('"','',$list)?>" name="syllabus_class_subject[]">
								<label class="custom-control-label" style="padding: 3px;" for="customCheck_<?=str_replace('"','',$list)?>"> <?=str_replace('"','',$list)?></label>
							</div>
					<?php } }else{ ?>
                    <div class="col-md-12">
                        <h5 class="pt-1 pb-1 text-center">No Subjects Found for <?=$class?> Class. Add Subjects <a href="<?=base_url('setup/subjects')?>">Click here</a></h5>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php }

    //Assign Class For Syllabus
	public function AssignClassForSyllabus(){
		extract($_REQUEST);
		$data = $this->Model_integrate->classeslist($school_id,$branch_id,$syllabus);
		?>
		<label class="col-md-12">Select class to Assign.</label>
		<div class="col-md-12">
			<div class="col-md-12">
				<div class="row">
					<?php if(count($data) != 0){ ?>
						<?php foreach($data as $value){ ?>
						<div class="custom-control custom-checkbox col-md-2">
							<input type="checkbox" class="custom-control-input" id="customCheck_<?= $value ?>" value="<?= $value ?>" name="assigning_syllabus_class[]" <?php if(isset($selectdemp_class) && $selectdemp_class == $value){ echo "checked"; } ?> >
							<label class="custom-control-label" for="customCheck_<?= $value ?>"> <?= $value ?></label>
						</div>
					<?php } ?>
					<?php }else{ ?>
						<div class="col-md-12">
							<h5 class="pt-1 pb-1 text-center">No Class Found. Add Class <a href="<?=base_url('setup/classes')?>">Click here</a></h5>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php
	}
}
