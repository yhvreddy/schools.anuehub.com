<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Setup extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
        //$this->isLoggedIn();
    }

    //set schooldetails  main page
    public function setschooldetails(){
        $data['PageTitle'] = "Set School details..!";
        //get register details from session -> userdetails
        $regdetails     = $this->session->userdetails; //accessing data
        $checksession   = $this->session->has_userdata('userdetails'); //

        if(isset($regdetails) && $checksession == 1){ 

            $regid      = $regdetails['reg_id'];
            $sclmode    = $regdetails['sclmode'];
            $type       = $regdetails['type'];
            $data['countries'] 	= $this->Model_default->selectconduction('sms_countries',array('status'=>1));
            $data['userdata'] = $this->Model_default->selectconduction('sms_regusers',array('reg_id' => $regid,'scl_mode'=>$sclmode));
			$data['reguserdata'] = $this->Model_default->selectconduction('sms_reg',array('reg_id' => $regid));
            $data['sclsyltypes'] = $this->Model_default->selectconduction('sms_scl_types',array('status' =>1));
            $data['scltypes'] = $this->Model_default->selectconduction('sms_formdata',array('status' =>1,'type'=>'reg'));
            //print_r($userdata);  
        }else{
            $this->session->sess_destroy();
            redirect(base_url());
        }
        $data['countries'] = $this->Model_default->selectconduction('sms_countries',array('status'=>1));
        $this->load->view('setup/sms_setschooldetails',$data);
    }
        
    //check licencekey valied or not
    public function licencevalidate(){
        extract($_REQUEST);
        //get register details from session -> userdetails
        $regdetails     = $this->session->userdetails; //accessing data
        $regid      = $regdetails['reg_id'];
        $sclmode    = $regdetails['sclmode'];
        $type       = $regdetails['type'];

        $reguser = $this->Model_default->selectconduction('sms_regusers',array('reg_id' => $regid,'scl_mode'=>$sclmode));
        //licence details
        $licenceid = $reguser[0]->licence_id;
        $reguser = $this->Model_default->selectconduction('sms_productkeys',array('id' =>$licenceid));
        $licencekey = $reguser[0]->licencekey;
        if(strtoupper($licencekeycode) == $licencekey){
            //Successfully valied licence key.
            $data = array('key'=>1,'message'=>'');
        }else if($licencekeycode != $licencekey){
            //Not Matching user licence == database licence
            $data = array('key'=>0,'message'=>'Enter valied registered Licence key..');
        }
        echo json_encode($data);
    }    

    //save school details
    public function saveschooldetails(){
        extract($_REQUEST);
        // print_r($register_id);
        // print_r($_FILES);
        //get register details from session -> userdetails
        $regdetails = $this->session->userdetails; //accessing data
        $regid      = $regdetails['reg_id'];
        $sclmode    = $regdetails['sclmode'];
        $type       = $regdetails['type'];
        //Registered user details
        $registerdata = array(
            'fname'     =>  $register_fname,
            'lname'     =>  $register_lname,
            'country_id'=>  $register_CountryName,
            'state_id'  =>  $register_StateName,
            'city_id'   =>  $register_CityName,
            'address'   =>  $register_Address,
            'pincode'   =>  $register_pincode,
            'updated'   =>  date('Y-m-d H:i:s')
        );
        //generate ids
        $randchar   = $this->Model_integrate->random_string(2);
        $spiltname  = $this->Model_integrate->initials($sclname);
        $randid     = $this->Model_integrate->generateRandom(0,9);
        $year       = date('y');  
        $sid        = $randid*3;
        $randid     = $randid*5;
        if(isset($sclmode) && $sclmode == 'GSB'){
            $regdata = $this->Model_default->selectconduction('sms_regusers',array('reg_id'=>$regid,'scl_mode'=>'GSB'));
            $regdata = $regdata['0'];
            $groupon = $regdata->gbsid;
            $schooldata = $this->Model_default->selectconduction('sms_schoolinfo',array('reg_id'=>$groupon,'scltype'=>'GB'));
            $schooldata = $schooldata['0'];
            $branchid   = $schooldata->branch_id;
            $schoolid   = $spiltname.'Y'.$year.$randchar.$sid;      //new school id
            //print_r($schooldata);
			$branchname	=	$school_branch_name;
			$mailname = $branchname;
        }else{
            //new generated ids of school & branch
            $branchid   = $spiltname.'Y'.$year.$randchar.$randid;   //new branch id
            $schoolid   = $spiltname.'Y'.$year.$randchar.$sid;      //new school id
			$branchname	=	'';
			$mailname = 'info';
        }

        //checking licence matching
        $reguser = $this->Model_default->selectconduction('sms_regusers',array('reg_id' => $regid));
        $reguser = $reguser[0];
        //licence details
        $licenceid = $reguser->licence_id;
        $reglicence = $this->Model_default->selectconduction('sms_productkeys',array('id' =>$licenceid));
        $reglicence = $reglicence['0'];
        $licencekey = $reglicence->licencekey;
        
        //check school information already reg or not
        $checkdata = $this->Model_default->selectconduction('sms_schoolinfo',array('reg_id'=>$regid));
        if(count($checkdata) == 0){
            if(strtoupper($licencekey) == $licencekey){
                //Successfully valied licence key.
                //set licence valid data for first time registration 1 month
                $startdate = date('Y-m-d h:i:s');
                //expand data for licence exp (change what you want)
                $offset = strtotime("+1 months");   
                $enddate = date('Y-m-d h:i:s',$offset);

                //total no of days
                $datedifference = $this->Model_integrate->datediff($startdate,$enddate); 
                $totaldays = $datedifference['diff'];

                //update licence details 
                $setdata = array('fromdate'=>$startdate,'todate'=>$enddate,'packagestatus'=>1,'packageplan'=>'trail','package_nodays'=>$totaldays,'package_expdays'=>$totaldays,'ip_address'=>$this->input->ip_address());
                $wheredata = array('reg_id'=>$regid,'licencekey'=>$licencekey,'id'=>$licenceid);
                $update = $this->Model_default->updatedata('sms_productkeys',$setdata,$wheredata);
                if($update != 0){
                    //creating dir for reg schools
                    $this->Model_integrate->createdir($branchid,$schoolid);
                    //joining all school types in to array - cbsc , state
                    $scltype ='';
                    foreach ($school_syllabus_type as $value) {
                        $scltype .= $value.',';
                    }
                    $scltype = rtrim($scltype,',');                    
                    //upload logo image
                    if (!empty($_FILES['school_logo']['name'])){
                        $config['upload_path']  = "./uploads/files/schooldata/logos/".$branchid.'/'.$schoolid.'/';
                        $config['allowed_types']= '*';
                        $config['encrypt_name'] = TRUE;

                        $this->upload->initialize($config);
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('school_logo')){               
                            $logoupload = 'uploads/files/schooldata/logos/'.$branchid.'/'.$schoolid.'/'.$this->upload->data('file_name');
                            //$data = array('key'=>1,'logoupload' => $logoupload);
                        }else{
                            $data = array('key'=>0,'message' => $this->upload->display_errors());
                        }
                    }else{
                        $logoupload = '';
                    }

					//generate school mail id

					$schoolname  = $this->Model_integrate->initials($sclname);
					$alfnums 	 =  random_string('alnum', 1);
					$studentname = str_replace(' ','',$mailname);
					$generatemail = strtolower($this->generate_mails($studentname.date('m').$alfnums,$schoolname));
					
                    //school data
                    $schooldetail = array(
                        'reg_id'            =>  $regid,
                        'school_id'         =>  $schoolid,
                        'branch_id'         =>  $branchid,
                        'scltype'           =>  $sclmode,
                        'schoolname'        =>  $sclname,
                        'scl_types'         =>  $scltype,
                        'branch_name'		=>	$branchname,
                        'school_logo'       =>  $logoupload,
                        'school_mobile'     =>  $school_mobile,
                        'school_phone'      =>  $school_phone_number,
                        'school_mail'       =>  $school_mail_id,
                        'local_mail_id'		=>	$generatemail,
                        'country_id'        =>  $school_country_name,
                        'state_id'          =>  $school_state_name,
                        'city_id'           =>  $school_city_name,
                        'school_address'    =>  $school_address,
                        //'school_city'       =>  $sclcity,
                        'school_pincode'    =>  $school_pincode,
                        'school_tinnumber'  =>  $sclregid,
                        'branchname'        =>  $school_branch_name,
                        //'school_regdocuments'=> $fileload,
                        'school_full_phone_number'  =>  $full_phone,
                        'displayname'       =>  $scldisplayname
                    );
                    
                    $insertdata = $this->Model_default->insertdata('sms_schoolinfo',$schooldetail);
                    if($insertdata != 0){
                        $registerdataconduction =   array('reg_id'=>$register_id,'mobile'=>$registrer_Mobile,'mailid'=>$register_mail_id);
                        $this->Model_default->updatedata('sms_regusers',$registerdata,$registerdataconduction);
                        $url = base_url();
                        $data = array('key'=>1,'message'=>'School details as successfully saved & upload documents under verification.','url'=>$url);
                    }else{
                        $data = array('key'=>0,'message'=>'failed to save your school details.');
                    }
                }else{
                    $data = array('key'=>1,'message'=>'failed to save your school details.');
                }
            }else if($licencekeycode != $licencekey){
                //Not Matching user licence == database licence
                $data = array('key'=>0,'message'=>'Enter valied registered Licence key..');
            }
        }else{
            $data = array('key'=>0,'message'=>'Your School details are already saved. Please check once.');
        }
        //$data = array('key'=>0,'schooldata'=>$schooldetail);
        echo json_encode($data);
    }
    
    //academicdetails
    public function academicdetails(){
        $this->isLoggedIn();
        $data['details'] = $details =   $this->session->userdata;   // all session data will send to setdetails..
        $data['userdata'] = $this->Model_default->selectdata('sms_regusers',array('reg_id' =>$details['regid'],'sno'=>$details['id']));
        $data['schooldetails'] = $this->Model_default->selectdata('sms_schoolinfo',array('reg_id' =>$details['school']->reg_id,'sno'=>$details['school']->sno));
        $data['PageTitle']  =   $data['schooldetails'][0]->schoolname.' School Academic Details';
        $this->load->view('setup/sms_schoolacademicdetails',$data); 
    }

    //save school academic details
    public function saveschoolacademicdetails(){
        extract($_REQUEST);
        $academicyear = $start_year.'-'.$end_year;
        $check = $this->Model_default->selectdata('sms_academic_years',array('school_id'=>$school_id,'branch_id'=>$branch_id,'academic_year'=>$academicyear,'academic_status'=>1,'status'=>1));
        if(count($check) != 0){
            $data = array('key'=>0,'message'=>'School Academic is already Started.Please check or contact admin.');
        }else{
            $insertdata = array(
				'school_id'=>$school_id,
				'branch_id'=>$branch_id,
				'from_year'=>$start_year,
				'from_month'=>$start_month,
				'to_year'=>$end_year,
				'to_month'=>$end_month,
				'academic_year'=>$academicyear,
				'academic_status'=>1,
				'updated'=>date('Y-m-d H:i:s')
			);
            $insertid = $this->Model_default->insertid('sms_academic_years',$insertdata);
            if($insertid != 0){
                $this->Model_default->updatedata('sms_schoolinfo',array('school_academic'=>1,'school_academic_form_to'=>$insertid),array('school_id'=>$school_id,'branch_id'=>$branch_id));
                $this->session->set_userdata('batch', $insertid);
                $this->session->sess_destroy();
                $url = base_url();
                $data = array('key'=>1,'message'=>'School Academic Successfully Start.','url'=>$url);
            }else{
                $data = array('key'=>0,'message'=>'failed to save your school details.','url'=>'');
            }
        }
        echo json_encode($data);
    }

    //enable and disable syllabus
	public function enableandDisable(){
    	extract($_REQUEST);
    	$syllubus_class = implode(',',$syllubus_class);
    	$conduction = array('school_id' => $schoolid, 'branch_id' => $branchid, 'reg_id' => $regid);
		$setdata = array('scl_types' => $syllubus_class);
		$savedata = $this->Model_default->updatedata('sms_schoolinfo',$setdata,$conduction);

		if($savedata != 0) {
			$this->successalert('You have successfully saved syllabus..!','You have saved syllabus and now ready to setup class.');
			redirect(base_url('setup/classes'));
		}else{
			$this->failedalert('You have failed to save syllabus..!','You have failed to save syllabus and unable to setup classes right now.');
			redirect(base_url('setup/classes'));
		}
	}

    //save class
    public function classdetails(){
        $data['PageTitle']  =   "Setup class details..!";
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['schoolstypes']   =   $this->Model_default->selectconduction('sms_scl_types',array('status'=>1));
        $data['classlist']  = $this->Model_default->selectconduction('sms_defaultclasses',array('status'=>1));
        $this->loadViews('setup/sms_setupclassdetails',$data);
    }

    //save class details list
    public function saveclassdetailslist(){
        extract($_REQUEST);
        //$this->print_r($_REQUEST);
        //exit;
        foreach ($schoolname as $scl) {
            //creating dynamic variable and filter array.
            $sclname = $scl . '_class';

            ${$sclname . 'data'} = array_filter(${$sclname});

            //get id for schools
            $datack = $this->Model_default->selectconduction('sms_scl_types', array('type' => $scl));
            $sclids = $datack['0']->id;

			$ckeckclass = $this->Model_default->selectconduction('sms_class', array('school_id' => $schoolid, 'branch_id' => $branchid, 'class_type' => $sclids));

			/*if(count($ckeckclass) != 0){
				$inseredclasses = unserialize($ckeckclass[$key]->class);
				$this->print_r($inseredclasses);
			}*/

            //converting array objects to json to save
            $encode = serialize(${$sclname . 'data'});
            $implodedata = implode(', ',${$sclname . 'data'});
            //$this->print_r($encode);
			@$syllabus	.= $sclname.' - '.$implodedata.', ';
			
			if(count($ckeckclass) != 0){
				$conduction = array('school_id' => $schoolid, 'branch_id' => $branchid, 'class_type' => $sclids);
				$setdata = array('class' => $encode);
				$savedata .= $this->Model_default->updatedata('sms_class',$setdata,$conduction);
			}else{
				$insertdata = array('school_id' => $schoolid, 'branch_id' => $branchid, 'class' => $encode, 'class_type' => $sclids);
				$this->print_r($insertdata);
				$savedata .= $this->Model_default->insertid('sms_class',$insertdata);
			}
        }

		if($savedata != 0) {
			$this->successalert('You have successfully setup class..!','You have set classes '.$syllabus);
			redirect(base_url('setup/classes'));
			//$data = array('key' => 1, 'message' => 'Classes saved & set sections to class');
		}else{
			$this->failedalert('You have failed setup class..!','You have failed to set classes '.$syllabus);
			redirect(base_url('setup/classes'));
			//$data = array('key' => 0, 'message' => 'Failed to save classes..try again.');
		}
    }

    //sections
    public function classSections(){
        $data['PageTitle']  =   "Setup class sections details..!";
		$schooldata = $this->session->userdata['school'];
		$schoolid = $schooldata->school_id;
		$branchid = $schooldata->branch_id;
		if(isset($schoolid) && !empty($schoolid) && isset($branchid) && !empty($branchid)) {
			$data['userdata'] = $this->Model_integrate->userdata();
			$data['schoolstypes'] = $this->Model_default->selectconduction('sms_scl_types', array('status' => 1));
			$data['classlist'] = $this->Model_default->selectconduction('sms_defaultclasses', array('status' => 1));
			$data['sections'] = $this->Model_default->selectconduction('sms_section', array('school_id' => $schoolid,'branch_id'=>$branchid,'status'=>1));
			$data['syllabus'] = $this->Model_dashboard->syllabustypes($schoolid, $branchid);
			$this->loadViews('setup/sms_setupclass_sectionsdetails', $data);
		}else{
			$this->logout();
		}
    }

    //Divide Class Sections
	public function DivideClassSections(){
    	//error_reporting(0);
		$syllabus = $this->input->post('syllabus');
		$schooldata = $this->session->userdata['school'];
		$schoolid = $schooldata->school_id;
		$branchid = $schooldata->branch_id;
		if(isset($schoolid) && !empty($schoolid) && isset($branchid) && !empty($branchid) && isset($syllabus) && !empty($syllabus)) {
			$classlist = $this->Model_default->selectconduction('sms_class', array('status' => 1,'school_id'=>$schoolid,'branch_id'=>$branchid,'class_type'=>$syllabus));
			$classes = unserialize($classlist[0]->class);
			$schoolstype = $this->Model_default->selectconduction('sms_scl_types', array('status' => 1,'id'=>$syllabus));
			$schoolstype = $schoolstype[0];
			$sms_section = $this->Model_default->selectconduction('sms_section', array('status' => 1,'school_id'=>$schoolid,'branch_id'=>$branchid,'class_type'=>$syllabus));
			if(count($sms_section) != 0){ ?>

				<div class="row">
					<h4 class="col-md-12 mt-3 text-success text-capitalize">Update section for <span class="text-uppercase">&quot; <?= $schoolstype->type; ?> &quot;</span> Class</h4>
					<input type="hidden" value="<?= $schoolstype->type; ?>" name="schoolname">
					<?php //$this->print_r($classes); ?>
					<?php foreach ($classes as $key => $class){
						$seclass = $this->Model_default->selectconduction('sms_section', array('status' => 1,'school_id'=>$schoolid,'branch_id'=>$branchid,'class_type'=>$syllabus,'class'=>$class));
						if(count($seclass) != 0){
							$regsectionslist = unserialize($seclass[0]->section);
							$regsections = "<span class='text-success'>".str_replace('"','',implode(', ',$regsectionslist))."</span>";
							$countsection = count($regsectionslist);
						}else{
							$regsections = "<span class='text-danger'>No sections</span>";
							$countsection = 0;
						}
						?>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-3 pt-2" style="padding-top: 11px !important;"><b><?= $class; ?> class</b></div>
								<div class="col-md-5 form-group mt-1 mb-1">
									<input type="hidden" name="<?= $schoolstype->type; ?>_sclass[]" value="<?= $class; ?>">
									<input type="number" minlength="0" min="0" name="<?= $schoolstype->type; ?>_secctions[]" class="form-control" value="<?=$countsection?>" placeholder="<?= 'No.of sections' ?>" required id="<?= 'Sec_'.$schoolstype->type.'_'.$class ?>">
									<span class="bar"></span>
								</div>
								<div class="col-md-4" style="padding-top: 12px;"><?=$regsections?></div>
							</div>
						</div>
					<?php } ?>
				</div>

			<?php }else{ ?>

				<div class="row">
					<h4 class="col-md-12 mt-3 text-success text-capitalize">Split section for <span class="text-uppercase">&quot; <?= $schoolstype->type; ?> &quot;</span> Class</h4>
						<input type="hidden" value="<?= $schoolstype->type; ?>" name="schoolname">
					<?php foreach ($classes as $class){  ?>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-3 pt-2" style="padding-top: 11px !important;"><b><?= $class; ?> class</b></div>
								<div class="col-md-5 form-group mt-1 mb-1">
									<input type="hidden" name="<?= $schoolstype->type; ?>_sclass[]" value="<?= $class; ?>">
									<input type="number" minlength="0" min="0" name="<?= $schoolstype->type; ?>_secctions[]" class="form-control" placeholder="<?= $class.' no.of sections' ?>" required id="<?= 'Sec_'.$schoolstype->type.'_'.$class ?>">
								</div>
								<div class="col-md-4"></div>
							</div>
						</div>
					<?php } ?>
				</div>

			<?php }?>
			<div class="row justify-content-center align-content-center">
				<input class="btn btn-success mt-4" type="submit" value="Save Sections" name="savesections">
			</div>
			<?php
		}else{ ?>
			<center>
				<h4>Invalied Request.Oops error..! Try again.</h4>
				<img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>">
			</center>
		<?php }
	}

    //save class to split sections..!
    public function savesectionslist(){
        extract($_REQUEST);
		$schooldata = $this->session->userdata['school'];
		$schoolid = $schooldata->school_id;
		$branchid = $schooldata->branch_id;
		//creating dynamic variable and filter array.
		$sclname = $schoolname. '_secctions';
		$sclclassname = $schoolname . '_sclass';

		$sectionsspilting = ${$sclname};
		${$sclname} = array_filter(${$sclname});
		${$sclclassname}    =   array_filter(${$sclclassname});
		$seclist = $schoolname.'secdata';
		${$seclist} =   array();

		//get id for schools
		$datack = $this->Model_default->selectconduction('sms_scl_types', array('type' => $schoolname));
		$sclids = $datack['0']->id;
		$i = 0;

		foreach (${$sclclassname} as $key => ${$sclclassname.'new'}) {

			$spiltdata = $sectionsspilting[$key];


			@${$sclname . 'new'} = ${$sclname}[$i];
			$spiltsections = $this->Model_integrate->generatletters(${$sclname . 'new'});
			$letters = explode(',', $spiltsections);

			${$seclist}[] = ${$sclclassname . 'new'} . '=>' . serialize($letters);
			@$storingdata .= ${$sclclassname . 'new'} . ' - ' . $spiltsections . ', ';

			//check data and insert or update..!
			$ckeckclass = $this->Model_default->selectconduction('sms_section', array('school_id' => $schoolid, 'branch_id' => $branchid, 'class_type' => $sclids, 'class' => ${$sclclassname . 'new'}));
			if(count($ckeckclass) <= 0) {
				if($spiltdata != 0) {
					${$sclclassname . 'data'} = array('branch_id' => $branchid, 'school_id' => $schoolid, 'class_type' => $sclids, 'class' => ${$sclclassname . 'new'}, 'section' => serialize($letters), 'updated' => date('Y-m-d H:i:s'));
					$savedata .= $this->Model_default->insertdata('sms_section', ${$sclclassname.'data'});
				}
			}else{
				if($spiltdata != 0) {
					$conduction = array('school_id' => $schoolid, 'branch_id' => $branchid, 'class_type' => $sclids, 'class' => ${$sclclassname . 'new'});
					$setdata = array('section' => serialize($letters), 'updated' => date('Y-m-d H:i:s'));
					$savedata .= $this->Model_default->updatedata('sms_section',$setdata,$conduction);
				}else{
					$conduction = array('school_id' => $schoolid, 'branch_id' => $branchid, 'class_type' => $sclids, 'class' => ${$sclclassname . 'new'});
					$savedata =	$this->Model_default->deleterecord('sms_section',$conduction);
				}
				
			}

			$i++;
		}

		$list = rtrim($storingdata,', ');

        if($savedata != 0){
        	$this->successalert('Sections are successfully spilt..!','You have spilt sections : '.$list);
        	redirect(base_url('setup/sections'));
        }else{
        	$this->failedalert('Failed to spilt sections..try again.','Failed to spilt sections : '.$list);
			redirect(base_url('setup/sections'));
        }
        
    }

    //delete sections
	public function DeletesectiononList(){
    	extract($_REQUEST);
    	$sno_id  	= $this->uri->segment(4);
		$branch_id  = 	$this->uri->segment(5);
		$school_id	=	$this->uri->segment(6);
		if(isset($action) && !empty($action)){
			$sections = $this->Model_default->selectconduction('sms_section', array('status' => 1,'sno'=>$sno_id,'school_id'=>$school_id,'branch_id'=>$branch_id));
			$this->print_r($sections);
			$conductions 	=	array('sno'=>$sno_id,'school_id'=>$school_id,'branch_id'=>$branch_id);
			//$updatedata		=	array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
			$savedata = $this->Model_default->deleterecord('sms_section',$conductions);
			if($savedata != 0){
				$this->successalert('Sections are successfully delete spilt sections..!','You have delete all spilt sections of class');
				redirect(base_url('setup/sections'));
			}else{
				$this->failedalert('Failed to delete spilt sections..try again.','Failed to delete spilt class sections..!');
				redirect(base_url('setup/sections'));
			}
		}else{
			$this->failedalert('Invalid request to delete section..!','Unable to delete section of class Oops error or token missing.!');
			redirect(base_url('setup/sections'));
		}
	}

    //subjects
    public function subjectsdetails(){
		$data['PageTitle']  =   "Setup Default Subjects details..!";
		$schooldata = $this->session->userdata['school'];
		$schoolid = $schooldata->school_id;
		$branchid = $schooldata->branch_id;
		if(isset($schoolid) && !empty($schoolid) && isset($branchid) && !empty($branchid)) {
			$data['userdata'] = $this->Model_integrate->userdata();
			$data['schoolstypes'] = $this->Model_default->selectconduction('sms_scl_types', array('status' => 1));
			$data['classlist'] = $this->Model_default->selectconduction('sms_defaultclasses', array('status' => 1));
			$data['sections'] = $this->Model_default->selectconduction('sms_section', array('school_id' => $schoolid,'branch_id'=>$branchid,'status'=>1));
			$data['syllabus'] = $this->Model_dashboard->syllabustypes($schoolid, $branchid);
			$data['defualtsubjects'] = $this->Model_default->selectconduction('sms_defualt_subjects', array('status' => 1,'school_id'=>$schoolid,'branch_id'=>$branchid),'updated DESC');
			$data['assignsubjectslist'] = $this->Model_default->selectconduction('sms_subjects',array('branch_id'=>$branchid,'school_id'=>$schoolid,'status'=>1),'updated DESC');
			$this->loadViews('setup/sms_setupclass_subjectsdetails',$data);
		}else{
			$this->logout();
		}
    }

    //Default subjects ajax
	public function classDefaultsubjects(){
    	extract($_REQUEST);
		$syllabus = $this->input->post('syllabus');
		$schooldata = $this->session->userdata['school'];
		$schoolid = $schooldata->school_id;
		$branchid = $schooldata->branch_id;
		if(isset($schoolid) && !empty($schoolid) && isset($branchid) && !empty($branchid) && isset($syllabus) && !empty($syllabus)) {
			$classlist = $this->Model_default->selectconduction('sms_class', array('status' => 1,'school_id'=>$schoolid,'branch_id'=>$branchid,'class_type'=>$syllabus));
			$classes = unserialize($classlist[0]->class);
			$schoolstype = $this->Model_default->selectconduction('sms_scl_types', array('status' => 1,'id'=>$syllabus));
			$schoolstype = $schoolstype[0];
			$sms_section = $this->Model_default->selectconduction('sms_section', array('status' => 1,'school_id'=>$schoolid,'branch_id'=>$branchid,'class_type'=>$syllabus));
			?>
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css">
			    <style>
					div.tagsinput span.tag {
						border: 1px solid #c5c5c5;
						-moz-border-radius: 2px;
						-webkit-border-radius: 2px;
						display: block;
						float: left;
						padding: 1px 6px 1px 6px;
						text-decoration: none;
						background: #ffffff;
						color: #000000;
						margin-right: 5px;
						margin-bottom: 5px;
						font-family: helvetica;
						font-size: 12px;
					}
					#tags_1_tagsinput{
						width: auto;
						min-height: 50px !important;
						border-radius: 5px;
					}
					div.tagsinput input{
						padding: 0px !important;
					}
				</style>
				<div class="row">
					<?php $sms_defualt_subjects = $this->Model_default->selectconduction('sms_defualt_subjects', array('status' => 1,'school_id'=>$schoolid,'branch_id'=>$branchid,'syllabus_type'=>$syllabus));
						if(count($sms_defualt_subjects) != 0){
							$subjects = implode(',',unserialize($sms_defualt_subjects[0]->subjects));
					?>
						<h4 class="col-md-12 mt-3 text-success text-capitalize">Edit Default Subjects for <span class="text-uppercase">&quot; <?= $schoolstype->type; ?> &quot;</span></h4>
						<input type="hidden" value="<?= $schoolstype->type; ?>" name="syllabustype">


						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12 form-group mt-1 mb-1">
									<textarea  id="tags_1" name="subjects" class="form-control" placeholder="Enter Subjects" required="required"><?=$subjects?></textarea>
									<span class="bar"></span>
								</div>
							</div>
						</div>
					<?php }else{ ?>
						<h4 class="col-md-12 mt-3 text-success text-capitalize">Enter Default Subjects for <span class="text-uppercase">&quot; <?= $schoolstype->type; ?> &quot;</span></h4>
						<input type="hidden" value="<?= $schoolstype->type; ?>" name="syllabustype">

						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12 form-group mt-1 mb-1">
									<textarea  id="tags_1" name="subjects" class="form-control" placeholder="Enter Subjects" required="required"></textarea>
									<span class="bar"></span>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>


			<div class="row justify-content-center align-content-center">
				<input class="btn btn-success mt-4" type="submit" value="Save Sections" name="savesections">
			</div>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.js"></script>
			<script>
				$(function() {

					$('#tags_1').tagsInput({
						// 'autocomplete_url': url_to_autocomplete_api,
						// 'autocomplete': { option: value, option: value},
						'height':'auto',
						'width':'auto',
						//'interactive':true,
						'defaultText':'subjects',
						// 'onAddTag':callback_function,
						// 'onRemoveTag':callback_function,
						// 'onChange' : callback_function,
						// 'delimiter': [',',';'],   // Or a string with a single delimiter. Ex: ';'
						// 'removeWithBackspace' : true,
						// 'minChars' : 0,
						// 'maxChars' : 0, // if not provided there is no limit
						'placeholderColor' : '#666666'
					});
					$('#tags_2').tagsInput({
						width: 'auto',
						onChange: function(elem, elem_tags)
						{
							var languages = ['php','ruby','javascript'];
							$('.tag', elem_tags).each(function()
							{
								if($(this).text().search(new RegExp('\\b(' + languages.join('|') + ')\\b')) >= 0)
									$(this).css('background-color', 'yellow');
							});
						}
					});
					$('#tags_3').tagsInput({
						width: 'auto',

						//autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
						autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
					});


// Uncomment this line to see the callback functions in action
//			$('input.tags').tagsInput({onAddTag:onAddTag,onRemoveTag:onRemoveTag,onChange: onChangeTag});

// Uncomment this line to see an input with no interface for adding new tags.
//			$('input.tags').tagsInput({interactive:false});
				});
			</script>
			<?php
		}else{ ?>
			<center>
				<h4>Invalied Request.Oops error..! Try again.</h4>
				<img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>">
			</center>
		<?php }
	}

	//save default subjects
	public function saveDefaultsubjects(){
    	extract($_REQUEST);
		$schooldata = $this->session->userdata['school'];
		$schoolid = $schooldata->school_id;
		$branchid = $schooldata->branch_id;
		$syllabus = $StdSyllubas;
		$sms_defualt_subjects = $this->Model_default->selectconduction('sms_defualt_subjects', array('status' => 1,'school_id'=>$schoolid,'branch_id'=>$branchid,'syllabus_type'=>$syllabus));
		$subjectslist = serialize(explode(',',$subjects));
		if(count($sms_defualt_subjects) != 0){
			$conduction = array('school_id'=>$schoolid,'branch_id'=>$branchid,'syllabus_type'=>$syllabus);
			$updatedata = array('syllabus_type'=>$syllabus,'subjects'=>$subjectslist,'updated'=>date('Y-m-d H:i:s'));
			$savedata = $this->Model_default->updatedata('sms_defualt_subjects',$updatedata,$conduction);
		}else{
			$insertdata = array('school_id'=>$schoolid,'branch_id'=>$branchid,'syllabus_type'=>$syllabus,'subjects'=>$subjectslist,'updated'=>date('Y-m-d H:i:s'));
			$this->print_r($insertdata);
			$savedata = $this->Model_default->insertdata('sms_defualt_subjects',$insertdata);
		}

		if($savedata != 0){
			$this->successalert('Successfully saved default Subjects..!','You have saved default subjects : '.$subjects);
			redirect(base_url('setup/subjects'));
		}else{
			$this->failedalert('Failed to saved default Subjects..!','You have failed to saved default subjects : '.$subjects);
			redirect(base_url('setup/subjects'));
		}
	}

	//Delete Default Subjects
	public function DeleteDefaultSubjects(){
		extract($_REQUEST);
		$sno_id  	= $this->uri->segment(4);
		$branch_id  = 	$this->uri->segment(5);
		$school_id	=	$this->uri->segment(6);
		if(isset($action) && !empty($action)){
			$sections = $this->Model_default->selectconduction('sms_defualt_subjects', array('status' => 1,'sno'=>$sno_id,'school_id'=>$school_id,'branch_id'=>$branch_id));
			$sections = $sections[0];
			$conductions 	=	array('sno'=>$sno_id,'school_id'=>$school_id,'branch_id'=>$branch_id);
			//$updatedata		=	array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
			//updatedata($tablename,$updatedata,$conduction)
			$savedata = $this->Model_default->deleterecord('sms_defualt_subjects',$conductions);
			if($savedata != 0){
				$this->successalert('Sections are successfully delete Default subjects..!','You have delete all default subjects...');
				redirect(base_url('setup/subjects'));
			}else{
				$this->failedalert('Failed to delete all default subjects..try again.','Failed to delete default subjects..!');
				redirect(base_url('setup/subjects'));
			}
		}else{
			$this->failedalert('Invalid request to delete default subjects..!','Unable to delete default subjects Oops error or token missing.!');
			redirect(base_url('setup/subjects'));
		}
	}

	//Assign List Subjects Ajax
	public function AssignListSubjectsAjax(){
    	extract($_REQUEST);
		$schooldata = $this->session->userdata['school'];
		$school_id = $schooldata->school_id;
		$branch_id = $schooldata->branch_id;
		$defaultsubjects = $this->Model_default->selectconduction('sms_defualt_subjects', array('status' => 1,'syllabus_type'=>$syllabuslist,'school_id'=>$school_id,'branch_id'=>$branch_id));
		if(count($defaultsubjects) != 0){
			$defaultsubjects = $defaultsubjects[0];
			$subjectslist = unserialize($defaultsubjects->subjects);
			$assignedsubjects = $this->Model_default->selectconduction('sms_subjects', array('school_id'=>$school_id,'branch_id'=>$branch_id,'scl_types'=>$syllabuslist,'class'=>$Classname));
			if(count($assignedsubjects) > 0){
				$assignedsubjectlist 	= 	$assignedsubjects[0];
				$assignedsubjects 	 	=   unserialize($assignedsubjectlist->subject);
				?>
				<h5 class="text-center mt-2 mb-4">Edit Assign Subjects To Class</h5>
				<div class="row">
					<?php foreach ($subjectslist as $values){ ?>
						<div class="col-md-3 pull-left">
							<div class="checkbox checkbox-css m-b-20">
								<input type="checkbox" <?php if(in_array($values,$assignedsubjects)){ echo 'checked'; } ?> value="<?= $values; ?>" id="syllubus_<?= $values ?>" name="syllubus_subjects[]" class="custom-control-input">
								<label for="syllubus_<?= $values ?>"><?= $values; ?></label>
							</div>
						</div>
					<?php  } ?>
				</div>
			<?php }else{ ?>
				<h5 class="text-center mt-2 mb-4">Assign Subjects To Class</h5>
				<div class="row">
					<?php foreach ($subjectslist as $values){ ?>
						<div class="col-md-3 pull-left">
							<div class="checkbox checkbox-css m-b-20">
								<input type="checkbox" value="<?= $values; ?>" id="syllubus_<?= $values ?>" name="syllubus_subjects[]" class="custom-control-input">
								<label for="syllubus_<?= $values ?>"><?= $values; ?></label>
							</div>
						</div>
					<?php  } ?>
				</div>
			<?php } ?>

			<div class="row align-content-center justify-content-center clearfix">
				<input type="submit" class="btn btn-success" value="Save Subjects" name="assignsubjects">
			</div>

		<?php }else{ ?>
			<div class="col-md-12 mt-3 mb-2">
				<h4 class="text-center p-2">No Subjects To Assign To Class..!</h4>
				<h5 class="text-center p-2">Please Add Default Subjects To Assign.</h5>
			</div>
		<?php }
	}

    //save assign subjects list as class vise...
    public function SaveAssignDefaultSubjects(){
        extract($_REQUEST);
		$schooldata = $this->session->userdata['school'];
		$schoolid = $schooldata->school_id;
		$branchid = $schooldata->branch_id;
        $subjects = serialize($syllubus_subjects);
		$classlistname	=	$SubjectAssignClasses;
		$scltypeslist 	=	$StdSyllubas;
		$regid	=	$schooldata->reg_id;
		
        if($branchid != '' && $schoolid != '' && $classlistname != '' && $subjects != '' && $scltypeslist != ''){

            //check class subjects existes or not
            $subjectcheck = $this->Model_default->selectconduction('sms_subjects',array('branch_id'=>$branchid,'school_id'=>$schoolid,'class'=>$classlistname,'scl_types'=>$scltypeslist));
            $subjectclasscheck = $this->Model_default->selectconduction('sms_subjects',array('branch_id'=>$branchid,'school_id'=>$schoolid,'scl_types'=>$scltypeslist));
            $enterclasssubjects = count($subjectclasscheck);
            $registerclass = $this->Model_default->selectconduction('sms_class',array('branch_id'=>$branchid,'school_id'=>$schoolid,'class_type'=>$scltypeslist));
            $regclass = $registerclass['0'];
            $totalregclass = count(unserialize($regclass->class));
            
			if(count($subjectcheck) != 0){
				//update list
				$conductiondata	=	array('branch_id' => $branchid, 'school_id' =>   $schoolid, 'class' =>   $classlistname,'scl_types' => $scltypeslist);
				$insertrecords = array(
					'subject'       =>   $subjects,
					'ip_address'    =>   $this->input->ip_address(),
					'updated'       =>   date('Y-m-d H:i:s'),
					'updated_by'    =>   $regid,
				);
				$inserteddata = $this->Model_default->updatedata('sms_subjects',$insertrecords,$conductiondata);
				if($inserteddata != 0){
					$this->successalert('Successfully Updated Assign Subjects..!',$classlistname.' Subjects as successfully assigned : '.implode(', ',$syllubus_subjects));
					redirect(base_url('setup/subjects'));
				}else{
					$this->failedalert('Failed To Updated Assign Subjects..!','Unable to assign '.$classlistname.' Subjects : '.implode(', ',$syllubus_subjects));
					redirect(base_url('setup/subjects'));
				}
			}else{

				$insertrecords = array(
					'branch_id'     =>   $branchid,
					'school_id'     =>   $schoolid,
					'class'         =>   $classlistname,
					'subject'       =>   $subjects,
					'scl_types'     =>   $scltypeslist,
					'ip_address'    =>   $this->input->ip_address(),
					'created_by'    =>   $regid,
					'updated'       =>   date('Y-m-d H:i:s'),
					'updated_by'    =>   $regid,
				);

				$inserteddata = $this->Model_default->insertdata('sms_subjects',$insertrecords);
				if($inserteddata != 0){
					$this->successalert('Successfully Assign Subjects..!',$classlistname.' Subjects as successfully assigned : '.implode(', ',$syllubus_subjects));
					redirect(base_url('setup/subjects'));
				}else{
					$this->failedalert('Failed To Assign Subjects..!','Unable to assign '.$classlistname.' Subjects : '.implode(', ',$syllubus_subjects));
					redirect(base_url('setup/subjects'));
				}

			}

        }else{
        	$this->failedalert('Failed to Assign Subjects to class','Required Fields Dont Keep Empty..!');
            redirect(base_url('setup/subjects'));
        }
    }

    //Delete Assign Subjects
    public function DeleteAssignSubjects(){
    	extract($_REQUEST);
		$sno_id  	= $this->uri->segment(4);
		$branch_id  = 	$this->uri->segment(5);
		$school_id	=	$this->uri->segment(6);
		if(isset($action) && !empty($action)){
			$sections = $this->Model_default->selectconduction('sms_subjects', array('status' => 1,'sno'=>$sno_id,'school_id'=>$school_id,'branch_id'=>$branch_id));
			$sections = $sections[0];
			$conductions 	=	array('sno'=>$sno_id,'school_id'=>$school_id,'branch_id'=>$branch_id);
			//$updatedata		=	array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
			//updatedata($tablename,$updatedata,$conduction)
			$savedata = $this->Model_default->deleterecord('sms_subjects',$conductions);
			if($savedata != 0){
				$this->successalert('Sections are successfully delete Assign subjects..!','You have delete all default subjects...');
				redirect(base_url('setup/subjects'));
			}else{
				$this->failedalert('Failed to delete all Assign subjects..try again.','Failed to delete Assign subjects..!');
				redirect(base_url('setup/subjects'));
			}
		}else{
			$this->failedalert('Invalid request to delete Assign subjects..!','Unable to delete Assign subjects Oops error or token missing.!');
			redirect(base_url('setup/subjects'));
		}
	}

	//Class as per Syllabus
	public function subjectsperclasses(){
		extract($_REQUEST);
		//get class list data
		$classdata = $this->Model_default->selectconduction('sms_class',array('school_id'=>$schoolid,'branch_id'=>$branchid,'class_type'=>$sclsyllubas));
		$classlist = unserialize($classdata['0']->class);
		//print_r($classlist);
		echo json_encode($classlist);
	}

	//Fee Curriculum Details list
    public function feedetails(){
        $data['PageTitle']  =   "Setup your school details..!";
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['schoolstypes']   =   $this->Model_default->selectconduction('sms_scl_types',array('status'=>1));
        $data['classlist']  = $this->Model_default->selectconduction('sms_defaultclasses',array('status'=>1));
        $this->loadViews('setup/sms_setupclass_feedetails',$data);
    }

    //Fee details fields ajaxs
    public function feedetailsfieldsajaxs(){
    	extract($_REQUEST);
		$schooldata = $this->session->userdata['school'];
		$schoolid = $schooldata->school_id;
		$branchid = $schooldata->branch_id;
		$feestructure =  $this->Model_dashboard->selectdata('sms_class_fee_structure', array('school_id'=>$schoolid,'branch_id'=>$branchid,'scl_types'=>$syllabuslist,'class'=>$Classname));
		$scl_types = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$syllabuslist,'status'=>1));
		if(count($feestructure) <= 0) {
			?>
			<div class="row" id="noofsubjectsmainbox">
				<h4 class="text-center col-md-12">Set Fee details</h4>
				<div class="col-md-12">
					<div class="row">
						<div class="col-12 mt-2">
							<div class="row">
								<div class="col-md-4 col-sm-12 col-12">
									<input type="number" min="0" name="schoolfee" required="" id="schoolfee"
										   placeholder="Enter school fee" class="form-control">
									<span class="bar"></span>
								</div>
								<div class="col-md-4 col-sm-12 col-12">
									<input type="number" min="0" name="vehiclefee" required="" id="vehiclefee"
										   placeholder="Enter vehicle fee" class="form-control">
									<span class="bar"></span>
								</div>
								<div class="col-md-4 col-sm-12 col-12">
									<input type="number" min="0" name="hostelfee" required="" placeholder="Enter Hostel fee"
										   id="hostelfee" class="form-control">
									<span class="bar"></span>
								</div>
							</div>
						</div>
						<div class="col-md-12 mt-1 mb-1">
							<div class="ml-1">
								<div class="checkbox checkbox-css m-b-20">
									<input type="checkbox" value="no" id="otheramountlist" name="otheramountlist"
										   class="custom-control-input">
									<label for="otheramountlist">Set Other Fee Expenses Details</label>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col-md-12" id="otheramountlistbox">
									<div class="row justify-content-center align-items-center">
										<div class="col-md-8">
											<div class="row">
												<div class="col-md-5 form-group">
													<input type="text" name="servicename[]" placeholder="Enter Name"
														   class="form-control">
												</div>
												<div class="col-md-5 form-group">
													<input type="number" min="0" name="serviceamount[]" placeholder="Enter Amount"
														   class="form-control">
												</div>
												<div class="col-md-2">
													<a href="javascript:void(0);" id="AddNewfield"
													   class="btn btn-success btn-sm">Add New</a>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12" id="appendfeefields"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-12 mt-3" id="savefeebtn">
							<center><input type="submit" class="btn btn-success" value="Save Fee Details"
										   name="savefeelist"></center>
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
						} else {
							$("#otheramountlist").val('no');
							$("#otheramountlistbox").hide();
							$("#appendfeefields").empty();
							$("input[name='servicename[]']").val('');
							$("input[name='serviceamount[]']").val('');
						}
					});

					$("#AddNewfield").click(function (e) {
						var Newfields = '<div class="row"><div class="col-md-5 form-group"><input type="text" name="servicename[]" placeholder="Enter Name" class="form-control"></div><div class="col-md-5 form-group"><input type="tel" name="serviceamount[]" placeholder="Enter Amount" class="form-control"></div><div class="col-md-2"><a href="javascript:void(0);" id="AddNewfield" class="btn btn-danger btn-sm RemoveField">Remove</a></div></div>'
						$("#appendfeefields").append(Newfields);
					});

					$("#appendfeefields").on('click', '.RemoveField', function (e) {
						e.preventDefault();
						$(this).parent().parent().remove();
					})


					$("#addlistofsubjects").click(function (event) {
						/* Act on the event */
						var scltypesmode = $("#scltypeslist").val();
						var classlisting = $("#classlisting").val();
						var subjectboxs = $("#noofsubjectboxs").val();
						if (scltypesmode != "" || classlisting != "" || subjectboxs != "") {
							$("#Addsubjects").show();
							var boxes = "";
							for (var i = 1; subjectboxs >= i; i++) {
								//swal("ok done..!");
								//console.log(i);
								boxes += '<div class="col-md-4"><div class="row"><div class="col-md-10 form-group"><input type="text" name="subjectname[]" class="form-control subjectname" placeholder="Enter subject name"></div><div class="col-md-1"><a href="javascript:void(0);" class="btn btn-sm btn-danger RemoveInput" id="removeinput">X</a></div></div></div>';
							}
							$("#Addsubjects").append(boxes);
							$("#savesubjectsbtn").show();
						} else {
							$("#savesubjectsbtn").hide();
							swal("Class , syllabus and no.of subjects type should not be empty..!");
						}
					});
				});
			</script>
			<?php
		}else{ ?>
			<div class="col-md-12 mt-3 mb-2">
				<h4 class="text-center p-2"><?=$scl_types[0]->type?> <?=$Classname?> Class Fee Curriculum as already added..!</h4>
				<h5 class="text-center p-2">Please Check In Curriculum List.To Edit Click On Edit Icon On Curriculum list.</h5>
			</div>
		<?php }
	}

    //Save fee list by class
    public function feelistbyclass(){
        extract($_REQUEST);
		$schooldata = $this->session->userdata['school'];
		$schoolid = $schooldata->school_id;
		$branchid = $schooldata->branch_id;
		$feestructure =  $this->Model_dashboard->selectdata('sms_class_fee_structure', array('school_id'=>$schoolid,'branch_id'=>$branchid,'scl_types'=>$scltypeslist,'class'=>$classlistname));
		$scl_types = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$scltypeslist));

        $otherfreelist = array();
        if(count($servicename) != 0 || !empty($servicename)){
            foreach ($servicename as $key => $service) {
                $otherfreelist[$service] = $serviceamount[$key];
            }
            $otherfreelist = serialize($otherfreelist);        
        }else{
            $otherfreelist = '';
        }

        if($branchid != '' && $schoolid != '' && $classlistname != '' && $schoolfee != '' && $scltypeslist != '' && $hostelfee != '' && $vehiclefee != ''){
            //check class subjects existes or not
            $subjectcheck = $this->Model_default->selectconduction('sms_class_fee_structure',array('branch_id'=>$branchid,'school_id'=>$schoolid,'class'=>$classlistname,'scl_types'=>$scltypeslist));
            $subjectclasscheck = $this->Model_default->selectconduction('sms_class_fee_structure',array('branch_id'=>$branchid,'school_id'=>$schoolid,'scl_types'=>$scltypeslist));
            $enterclasssubjects = count($subjectclasscheck);
            $registerclass = $this->Model_default->selectconduction('sms_class',array('branch_id'=>$branchid,'school_id'=>$schoolid,'class_type'=>$scltypeslist));
            $regclass = $registerclass['0'];
            $totalregclass = count(unserialize($regclass->class));

			if(count($subjectcheck) != 0){
				$this->failedalert('Already saved '.$classlistname.' Fee Curriculum..!',$scl_types[0]->type.' '.$classlistname.' Fee Curriculum already saved..please check it once..!');
				redirect('setup/feedetails');
			}else{
				$feedata = array(
					'branch_id'     =>      $branchid,
					'school_id'     =>      $schoolid,
					'class'         =>      $classlistname,
					'scl_types'     =>      $scltypeslist,
					'schoolfee'     =>      $schoolfee,
					'hostelfee'     =>      $hostelfee,
					'busfee'        =>      $vehiclefee,
					'otherfee'      =>      $otherfreelist,
					'ip_address'    =>      $this->input->ip_address(),
					'updated'       =>      date('Y-m-d H:i:s')
				);
				$inserteddata = $this->Model_default->insertdata('sms_class_fee_structure',$feedata);
				if($inserteddata != 0){
					$this->successalert($classlistname.' Fee Curriculum Successfully Saved..!',$scl_types[0]->type.' '.$classlistname.' Fee Curriculum Details Saved.');
					redirect('setup/feedetails');
				}else{
					$this->failedalert($classlistname.' Fee Curriculum Failed To Save..!',$scl_types[0]->type.' '.$classlistname.' Fee Curriculum Details Failed.Please Try again later.');
					redirect('setup/feedetails');
				}
			}
			
        }else{
			$this->failedalert($classlistname.' Fee Curriculum Failed To Save..!',$scl_types[0]->type.' '.$classlistname.' Please Fill Required Fields & Try Again Later.');
			redirect('setup/feedetails');
        }

    }

    //Delete Fee Record
	public function FeeRecordsDelete(){
    	extract($_REQUEST);
		$sno_id  	= $this->uri->segment(4);
		$branch_id  = 	$this->uri->segment(5);
		$school_id	=	$this->uri->segment(6);

		if(isset($type) && !empty($type) && $type == 'delete'){
			$sections = $this->Model_default->selectconduction('sms_class_fee_structure', array('sno'=>$sno_id,'school_id'=>$school_id,'branch_id'=>$branch_id));
			$sections = $sections[0];
			$conductions 	=	array('sno'=>$sno_id,'school_id'=>$school_id,'branch_id'=>$branch_id);
			//$updatedata		=	array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
			//updatedata($tablename,$updatedata,$conduction)
			$savedata = $this->Model_default->deleterecord('sms_class_fee_structure',$conductions);
			if($savedata != 0){
				$this->successalert('Fee curriculum are successfully deleted..!','You have deleted Fee Curriculum Record...');
				redirect(base_url('setup/feedetails'));
			}else{
				$this->failedalert('Failed to delete Fee Curriculum..Try Again.','Failed to delete Fee Curriculum Record..!');
				redirect(base_url('setup/feedetails'));
			}
		}else{
			$this->failedalert('Invalid request to delete Fee Curriculum..!','Unable to delete Fee Curriculum. Oops error or token missing.!');
			redirect(base_url('setup/feedetails'));
		}
	}

	//Update Fee Record List
	public function updataFeeRecordData(){
    	extract($_REQUEST);
		$feestructure =  $this->Model_dashboard->selectdata('sms_class_fee_structure', array('school_id'=>$schoolid,'branch_id'=>$branchid,'sno'=>$sno_id));
		$scltypeslist = $feestructure[0]->scl_types;
		$scl_types = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$scltypeslist));

		$otherfreelist = array();

		$servicename 	= 	'servicename_'.$sno_id;
		$serviceamount  =	'serviceamount_'.$sno_id;
		$classlistname  =	$feestructure[0]->class;

		$otherfreelist = array();
		if(count(${$servicename}) != 0 && count(${$serviceamount}) != 0){
			foreach (${$servicename} as $key => $service) {
				$otherfreelist[$service] = ${$serviceamount}[$key];
			}
			$otherfreelist = serialize($otherfreelist);
		}else{
			$otherfreelist = '';
		}


		if(count($feestructure) == 0){
			$this->failedalert('Failed to Update '.$classlistname.' Fee Curriculum..!',$scl_types[0]->type.' '.$classlistname.' Fee Curriculum Failed to save..please check it once..!');
			redirect('setup/feedetails');
		}else{
			$conduction = array(
				'branch_id'     =>      $branchid,
				'school_id'     =>      $schoolid,
				'class'         =>      $classlistname,
				'scl_types'     =>      $scl_types[0]->id,
				'sno'			=>		$sno_id,
			);
			$feedata = array(
				'schoolfee'     =>      $schoolfee,
				'hostelfee'     =>      $hostelfee,
				'busfee'        =>      $vehiclefee,
				'otherfee'      =>      $otherfreelist,
				'ip_address'    =>      $this->input->ip_address(),
				'updated'       =>      date('Y-m-d H:i:s')
			);
			$inserteddata = $this->Model_default->updatedata('sms_class_fee_structure',$feedata,$conduction);
			if($inserteddata != 0){
				$this->successalert($classlistname.' Fee Curriculum Successfully Updated..!',$scl_types[0]->type.' '.$classlistname.' Fee Curriculum Details Updated.');
				redirect('setup/feedetails');
			}else{
				$this->failedalert($classlistname.' Fee Curriculum Failed To Update..!',$scl_types[0]->type.' '.$classlistname.' Fee Curriculum Details Failed.Please Try again later.');
				redirect('setup/feedetails');
			}
		}



	}

    //set schools informationdata
    public function details(){
        $data['PageTitle']  =   "Setup your school details..!";

        $data['schoolstypes']   =   $this->Model_default->selectconduction('sms_scl_types',array('status'=>1));
        $data['classlist']  = $this->Model_default->selectconduction('sms_defaultclasses',array('status'=>1));  
        
        $this->load->view('setup/sms_setupschooldetails',$data);
    }

}
