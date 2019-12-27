<!-- Container fluid  -->
<style>
    .dropify-wrapper{
        height: 35px !important;
        font-size:15px !important;
    }
    .dropify-message{
        padding-bottom: 8px;
    }
    .dropify-wrapper .dropify-message span.file-icon {
        font-size: 20px;
        display: initial;
    }
    .dropify-message p{
        margin: 0px !important;
        font-size: 6px;
        line-height: 1px;
    }
    .dropify-font:before{

    }
	div.tagsinput span.tag {
		border: 1px solid #c5c5c5;
		-moz-border-radius: 2px;
		-webkit-border-radius: 2px;
		display: block;
		float: left;
		padding: 0px 5px 0px 2px;
		text-decoration: none;
		background: #ffffff;
		color: #000000;
		margin-right: 5px;
		margin-bottom: 5px;
		font-family: helvetica;
		font-size: 13px;
	}
	#tags_1_tagsinput{
		width: auto;
		min-height: 35px !important;
		height: 35px !important;
		border-radius: 5px;
	}
</style>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Employee</a></li>
        <li class="breadcrumb-item active">Edit Employee</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Edit Employee <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Edit Employee Details</h4>
                </div>
                <div class="panel-body row">
                    <div class="col-md-12">
                        <?php $employee = $employeedata[0]; //print_r($employee); ?>
                        <form method="post" enctype="multipart/form-data" action="<?=base_url('dashboard/employee/saveeditemployeedata')?>" class="form-material">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h5 class="text-success">Employee Details</h5></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <?php if($scltype == 'GB'){ ?>
                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <label>Select Branch: <span class="text-red"> * </span></label>
                                                <div class="form-group">
                                                    <select class="form-control select2" name="" id="sclbranch" disabled>
                                                        <option selected value="<?= $schoolid; ?>">This Branch</option>
                                                        <?php foreach($branchlist as $branchs){ ?>
                                                            <option value="<?=$branchs->school_id?>"><?=$branchs->branchname.' - '.$branchs->school_id; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
											<input type='hidden' value="<?= $employee->school_id; ?>" name="schoolid">
                                        <?php }else{ ?>
                                            <input type='hidden' value="<?= $employee->school_id; ?>" name="schoolid">
                                        <?php } ?>
                                        <input type='hidden' value="<?= $employee->branch_id; ?>" name="branchid">
                                        <input  type="hidden" value="<?=$employee->id_num?>" name="regid">
                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <label for="Environmentid">Environment ID <span class="text-danger">*</span></label>
                                            <div class="form-group">
                                                <input type="text" placeholder="Environment id" class="form-control text-uppercase" name="environmentid" id="Environmentid" value="<?=$employee->em_id?>" readonly="readonly" required="" maxlength="12" minlength="10">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>First Name <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter First Name" name="empname" value="<?=$employee->firstname?>" required>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Last Name <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="text" class="form-control" required placeholder="Enter Last Name" name="emplname" value="<?=$employee->lastname?>">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Gender <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <select class="form-control show-tick" name="empgender" required>
                                                <option value="">Select Gender</option>
                                                <?php foreach ($gender as $genders) { ?>
                                                    <option <?php if($employee->gender == $genders->shortname){ echo 'selected'; } ?> value="<?= $genders->shortname ?>"><?= $genders->name ?></option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Date of Birth <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="text" id="mdate" class="form-control mydatepicker" placeholder="Please choose a date..." value="<?=$employee->dob?>" name="empdob" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Nationality</label>
                                            <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter Nationality" value="<?=$employee->nationality?>" name="empnationality">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Religion</label>
                                            <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter religion" name="empreligion" value="<?=$employee->religion?>">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Mobile Number <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="tel" class="form-control mobile-phone-number" placeholder="Enter Mobile Number" id="Mobileno" name="empmobile" maxlength="" value="<?=$employee->mobile?>" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Alter Number</label>
                                            <div class="form-group">
                                            <input type="tel" class="form-control mobile-phone-number" placeholder="Enter Alter Number" name="empphone" maxlength="13" value="<?=$employee->phone?>">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Email Address <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Enter Mail id" name="empmail" value="<?=$employee->mail_id?>" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Employee Type <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <select class="form-control" id="employeetype" name="emptype" required>
                                                <option value="" selected>Select Employee type</option>
                                                <?php foreach ($employees as $employees) { ?>
                                                    <option <?php if($employee->employeetype == $employees->shortname){ echo 'selected'; } ?> value="<?= $employees->shortname ?>"><?= $employees->name ?></option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 staff">
                                            <label>Staff Type</label>
                                            <div class="form-group">
                                            <select class="form-control" id="sct" name="emppti">
                                                <option value="">Select Staff type</option>
                                                <?php foreach ($staff as $staffs) { ?>
                                                    <option <?php if($employee->emoloyeeposition == $staffs->shortname){ echo 'selected'; } ?> value="<?= $staffs->shortname ?>"><?= $staffs->name ?></option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>

                                        
                                        <div class="col-xs-12 col-sm-6 col-md-3 empclass">
                                            <div class="row">
                                                <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <label for="sclsyllabuslist">School Syllabus</label>
                                                    <select type="text" name="StdSyllubas" id="sclsyllubaslist" class="form-control" style="padding:0px">
                                                        <option value="">Syllabus Type</option>
                                                           <?php foreach ($syllabus as $key => $value) { ?>
                                                            <option value="<?= $key ?>" <?php if($employee->employee_syllabus==$key){echo "selected";} ?> ><?= $value ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <?php
													$data=$this->Model_dashboard->selectdata('sms_class',array('class_type'=>$employee->employee_syllabus,'school_id'=>$schoolid,'branch_id'=>$branchid));
													if(count($data) != 0) {
														$selectedClass = unserialize($data[0]->class);
													}
                                                ?>

                                                <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <label for="SyllabusClasses">Select Class</label>
                                                    <select type="text" name="empclass" id="SyllabusClasses" class="form-control select2"  style="padding:0px 10px">
                                                        <option value="">Class</option>
                                                           <?php if(count($data) != 0) { foreach ($selectedClass as $key => $value) { ?>
                                                            <option value="<?= $key ?>" <?php if($employee->employeeclass==$value){echo "selected";} ?> ><?= $value ?></option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>

												<script>
													$(document).ready(function () {
														$("#SyllabusClasses").change(function () {
															var selectedclass_for_teacher 	= 	$(this).val();
															var selectedclass_by_syllabus	=	$("#sclsyllubaslist").val();
															//console.log(selectedclass_for_teacher + ' - ' + selectedclass_by_syllabus);
															if(selectedclass_by_syllabus != '' && selectedclass_for_teacher != ''){
																//ajax
																$.ajax({
																	url	:	"<?php echo base_url('dashboard/employee/classteacherstatus');?>",
																	type :	'POST',
																	data : {syllabus_type : selectedclass_by_syllabus,syllabus_class : selectedclass_for_teacher},
																	dataType:'json',
																	success:function (responcedata) {
																		console.log(responcedata.sigcode);
																		if(responcedata.sigcode == 1){
																			console.log(responcedata.message);
																			alert('Class teacher already exits for selected class..!');
																			$("#SyllabusClasses").css('border','1px solid red');
																		}else {
																			console.log(responcedata.message);
																			$("#SyllabusClasses").css('border','1px solid green');
																		}
																	},
																})
															}else{
																alert("Please select syllabus & class..!");
															}
														});
													})
												</script>

                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 workers">
                                            <label>Workers Type</label>
                                            <div class="form-group">
                                            <select class="form-control show-tick" name="emppoti">
                                                <option value="">Select worker type</option>
                                                <?php foreach ($worker as $workers) { ?>
                                                    <option <?php if($employee->emoloyeeposition == $workers->shortname){ echo 'selected'; } ?> value="<?= $workers->shortname ?>"><?= $workers->name ?></option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 assistant">
                                            <label>Office assistant Type </label>
                                            <div class="form-group">
                                            <select class="form-control show-tick" name="empoffic">
                                                <option value="">Select assistant type</option>
                                                <?php foreach ($office as $offices) { ?>
                                                    <option <?php if($employee->emoloyeeposition == $offices->shortname){ echo 'selected'; } ?> value="<?= $offices->shortname ?>"><?= $offices->name ?></option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Designation <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter Degination Ex: Bcom..." value="<?=$employee->designation?>" name="empdegination" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <label for="employeeimage">Upload Employee Image</label>
                                            <div class="form-group">
                                                <input type="file" class="form-control dropify" name="employeeimage" id="employeeimage" accept=".jpg,.png">
                                            </div>
                                        </div>
                                        <input type="hidden" value="<?=$employee->employee_pic?>" name="uploadedemployee_image">

                                         <div class="col-xs-12 col-sm-6 col-md-3 form-group">
                                            <label>Select country.. <span class="text-danger">*</span></label>
                                            <select name="CountryName" id="CountryName" class="form-control p-0" required>
                                                <option value="">Select Country</option>
                                                <?php foreach ($countries as $country){ ?>
                                                    <option <?php if($employee->country_id == $country->id){ echo 'selected'; } ?> value="<?= $country->id ?>"><?= $country->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-3 form-group">
                                            <label for="StateName">Select State Name <span class="text-danger">*</span></label>
                                            <select name="StateIdName" id="StateName" class="form-control p-0" required>
                                                <option value="">Select State Name</option>
                                                <?php
                                                $states = $this->Model_dashboard->selectdata('sms_states',array('country_id'=>$employee->country_id));
                                                foreach($states as $state){
                                                if($state->id == $employee->state_id){
                                                    ?>
                                                    <option selected="" value="<?= $state->id ?>"><?= $state->name ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $state->id ?>"><?= $state->name ?></option>
                                                <?php } }?>
                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-3 form-group">
                                            <label for="CityName">Select City or Dist <span class="text-danger">*</span></label>
                                            <select name="CityIdName" id="CityName" class="form-control p-0" required>
                                                <option value="">Select City or Dist</option>
                                                <?php
                                                $cities = $this->Model_dashboard->selectdata('sms_cities',array('state_id'=>$employee->state_id));
                                                foreach($cities as $city){
                                                if($city->id == $employee->city_id){
                                                    ?>
                                                    <option selected="" value="<?= $city->id ?>"><?= $city->name ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $city->id ?>"><?= $city->name ?></option>
                                                <?php } }?>
                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-5">
                                            <label>Address <span class="text-red">*</span></label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Enter Address" name="address" value="<?=$employee->address?>" id="padd" required="">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Pincode <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="tel" class="form-control" placeholder="Enter Pincode" minlength="" value="<?=$employee->pincode?>" maxlength="6" name="emppincode" required/>
                                            </div>
                                        </div>

                                        <!--<div class="col-xs-12 col-sm-6 col-md-3">
                                             <label>Aadhaar Card <span class="text-red">*</span></label>
                                             <div class="form-group">
                                             <input type="text" class="form-control credit-card" maxlength="14" placeholder="Enter Aadhaar" name="empaadhaar" id="AadhaarCard" required>
                                             </div>
                                         </div>-->

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Salary<small>(P/M)</small> <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="tel" maxlength="7" class="form-control" placeholder="Salary amount/- Month" value="<?=$employee->salary?>" name="empsalary" required>
                                            </div>
                                        </div>

										<div class="col-md-12 empsubjects" style="display:block;" id="ClassSubjectsToDeal">
                                            <!--<label>Enter subject deal<small> (Separate by ,)</small></label>
                                            <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter subject Names Ex : Maths,science,social,..etc" name="empsubjects" value="<?php //echo $employee->dealsubjects ?>" id="tags_1" required="required">
                                            </div>-->
											<label>Select class and subjects to deal.</label>
											<div class="col-md-12">
												<div class="row">
													<?php foreach ($syllabus as $key => $value) { ?>
														<div class="custom-control custom-radio col-md-2">
															<input type="radio" class="custom-control-input" id="customCheck_<?= $key ?>" value="<?= $key ?>" name="syllabus_name" <?php if($employee->deal_syllabus == $key){ echo 'checked'; } ?>>
															<label class="custom-control-label" style="padding: 3px;" for="customCheck_<?= $key ?>"> <?= $value ?></label>
														</div>
														<script>
															var temp_selected_syllabus 	= [];
															temp_selected_syllabus.push("<?=$employee->deal_syllabus?>");
															//console.log(temp_selected_syllabus);
															$(document).ready(function(){
																$("#customCheck_<?= $key ?>").change(function(){
																	$("#SyllabusClassList").html("");
																	$("#SyllabusClassSubjectsList").html("");
																	var selectedsyllabus =   $(this).val();
																	var school_id        =   '<?=$schoolid?>';
																	var branch_id        =   '<?=$branchid?>';
																	if(selectedsyllabus != '' && school_id != '' && branch_id != ''){
																		temp_selected_syllabus = [];
																		temp_selected_syllabus.push(selectedsyllabus);
																		//console.log(temp_selected_syllabus);
																		//console.log(selectedsyllabus);
																		$.ajax("<?=base_url('dashboard/employee/syllabus/getclass')?>?syllabus="+selectedsyllabus+"&school_id="+school_id+"&branch_id="+branch_id,{  success: function (gdata) {
																				$('#SyllabusClassList').html("");
																				$('#SyllabusClassList').html(gdata);
																			} }
																		);
																	}else{
																		alert("please select syllabus..!");
																	}
																})
															})
														</script>
													<?php } ?>
												</div>
											</div>
											<div class="col-md-12" id="SyllabusClassList">
												<?php if(!empty($employee->dealsubjects) && !empty($employee->deal_syllabus_class)){
													$classdata = $this->Model_integrate->classeslist($schoolid,$branchid,$employee->deal_syllabus);
													?>
													<label class="col-md-12">Select class to deal.</label>
													<div class="col-md-12">
														<div class="col-md-12">
															<div class="row">
																<?php if(count($classdata) != 0){ ?>
																	<?php foreach($classdata as $value){ ?>
																	<div class="custom-control custom-radio col-md-1">
																		<input type="radio" class="custom-control-input" id="customCheck_<?= $value ?>" value="<?= $value ?>" name="syllabus_class" <?php if(isset($employee->deal_syllabus_class) && !empty($employee->deal_syllabus_class) && $employee->deal_syllabus_class == $value){ echo "checked"; } ?> >
																		<label class="custom-control-label" style="padding: 3px;" for="customCheck_<?= $value ?>"> <?= $value ?></label>
																	</div>
																	<script>
																		$(document).ready(function(){

																			$("#customCheck_<?= $value ?>").change(function(){
																				var selectedclass    =    $(this).val();
																				console.log(temp_selected_syllabus);
																				var selectedsyllabus =   '<?=$employee->deal_syllabus?>';
																				var school_id        =   '<?=$schoolid?>';
																				var branch_id        =   '<?=$branchid?>';
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
												<?php } ?>
											</div>
											<div class="col-md-12" id="SyllabusClassSubjectsList">
												<?php if(!empty($employee->dealsubjects) && !empty($employee->deal_syllabus_class)){
													$assignsubjectslist = $this->Model_default->selectconduction('sms_subjects',array('branch_id'=>$branchid,'school_id'=>$schoolid,'class'=>$employee->deal_syllabus_class,'scl_types'=>$employee->deal_syllabus,'status'=>1),'updated DESC');
													?>
													<label class="col-md-12 mt-2">Select Subject to deal.</label>
													<div class="col-md-12">
														<div class="row">
															<?php if(count($assignsubjectslist) != 0){ ?>
																<?php $assignedsubjects = unserialize($assignsubjectslist[0]->subject);
																	$selected_subjects = explode(',',$employee->dealsubjects);
																foreach ($assignedsubjects as $list){ ?>
																	<div class="custom-control custom-checkbox mr-3 ml-3">
																		<input type="checkbox" class="custom-control-input" id="customCheck_<?=str_replace('"','',$list)?>" value="<?=str_replace('"','',$list)?>" name="syllabus_class_subject[]" <?php if(in_array(str_replace('"','',$list),$selected_subjects)){ echo "checked"; } ?> >
																		<label class="custom-control-label" style="padding: 3px;" for="customCheck_<?=str_replace('"','',$list)?>"> <?=str_replace('"','',$list)?></label>
																	</div>
																<?php } }else{ ?>
																<div class="col-md-12">
																	<h5 class="pt-1 pb-1 text-center">No Subjects Found for <?=$class?> Class. Add Subjects <a href="<?=base_url('setup/subjects')?>">Click here</a></h5>
																</div>
															<?php } ?>
														</div>
													</div>
												<?php } ?>
											</div>
										</div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading"><h5 class="text-capitalize text-success">Parents <small>or</small> Gaurdian Details</h5></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                             <label>Gaurdian Name</label>
                                             <div class="form-group">
                                             <input type="text" class="form-control" placeholder="Enter Name" name="emppname" value="<?=$employee->parentname?>">
                                             </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                             <label>Designation</label>
                                             <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter Degination" value="<?=$employee->parentdesignation?>" name="emppdegination">
                                             </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                             <label>Phone Number</label>
                                             <div class="form-group">
                                            <input type="tel" class="form-control mobile-phone-number" placeholder="Enter Mobile Number" name="emppmobile" maxlength="" value="<?=$employee->parentphone?>">
                                             </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Email Address</label>
                                            <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Enter mail id" name="emppmail" value="<?=$employee->parentemail?>">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                             <label>Address</label>
                                             <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter address" name="emppaddress" value="<?=$employee->parentaddress?>">
                                             </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                             <label>City</label>
                                             <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter city/Town Name" name="emppcity" value="<?=$employee->parentcity?>" />
                                             </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                             <label>Pincode</label>
                                             <div class="form-group">
                                            <input type="tel" class="form-control" placeholder="Enter 6 digits Pincode" maxlength="" value="<?=$employee->parentpincode?>"  name="empppincode"/>
                                             </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <button type="submit" class="btn btn-success pull-right" name="addnewemployee">
                                            UPDATE EMPLOYEE
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>    
                     </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
<script>

   $(document).ready(function(){
        var selemployeetype = $("#employeetype").val();
        if($('#employeetype').attr("value")==""){
            $('.staff').hide();
            $('.workers').hide();
            $('.assistant').hide();
            //$('#sclsyllubaslist').prop('selectedIndex',0);
            //$('#SyllabusClasses').prop('selectedIndex',0);
        }
        if($('#employeetype').attr("value")=="staff"){
            $('.staff').show();
            $('.workers').hide();
            $('.assistant').hide();
        }
        if($('#employeetype').attr("value")=="worker"){
            $('.staff').hide();
            $('.workers').show();
            $('.assistant').hide();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }
        if($('#employeetype').attr("value")=="office"){
            $('.staff').hide();
            $('.workers').hide();
            $('.assistant').show();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }




        var sct = $("#sct").val();
        if($('#sct').attr("value")==""){
            $('.empclass').hide();
            //$('#sclsyllubaslist').prop('selectedIndex',0);
            //$('#SyllabusClasses').prop('selectedIndex',0);
        }
        if($('#sct').attr("value")=="teacher"){
            $('.empclass').hide();
            //$('#sclsyllubaslist').prop('selectedIndex',0);
            //$('#SyllabusClasses').prop('selectedIndex',0);
        }
        if($('#sct').attr("value")=="classteacher"){
            $('.empclass').show();
        }
        if($('#sct').attr("value")=="tutor"){
            $('.empclass').hide();
            //$('#sclsyllubaslist').prop('selectedIndex',0);
            //$('#SyllabusClasses').prop('selectedIndex',0);
        }

        $("#employeetype").change(function(){
            $( "#employeetype option:selected").each(function(){
                if($(this).attr("value")==""){
                    $('.staff').hide();
                    $('.workers').hide();
                    $('.assistant').hide();
                    $('.empsubjects').hide();
                    $('.empclass').hide();
                    //$('#sclsyllubaslist').prop('selectedIndex',0);
                    //$('#SyllabusClasses').prop('selectedIndex',0);
                }
                if($(this).attr("value")=="staff"){
                    $('.staff').show();
                    $('.workers').hide();
                    $('.assistant').hide();
                    $('.empsubjects').show();

                }
                if($(this).attr("value")=="worker"){
                    $('.staff').hide();
                    $('.workers').show();
                    $('.assistant').hide();
                    $('.empsubjects').hide();
                    $('.empclass').hide();
                    //$('#sclsyllubaslist').prop('selectedIndex',0);
                    //$('#SyllabusClasses').prop('selectedIndex',0);
                }
                if($(this).attr("value")=="office"){
                    $('.staff').hide();
                    $('.workers').hide();
                    $('.assistant').show();
                    $('.empsubjects').hide();
                    $('.empclass').hide();
                    //$('#sclsyllubaslist').prop('selectedIndex',0);
                    //$('#SyllabusClasses').prop('selectedIndex',0);
                }
            })
        }).change();
   });

   $(document).ready(function(){
		$("#sct").change(function(){
			$( "#sct option:selected").each(function(){
				if($(this).attr("value")==""){
					$('.empclass').hide();
					$("#sctclass").val("");
					//$('#sclsyllubaslist').prop('selectedIndex',0);
					//$('#SyllabusClasses').prop('selectedIndex',0);
				}
				if($(this).attr("value")=="teacher"){
					$('.empclass').hide();
					$("#sctclass").val("");
					//$('#sclsyllubaslist').prop('selectedIndex',0);
					//$('#SyllabusClasses').prop('selectedIndex',0);
				}
				if($(this).attr("value")=="classteacher"){
					$('.empclass').show();
					$("#sctclass").val("");
					//$('#sclsyllubaslist').prop('selectedIndex',0);
					//$('#SyllabusClasses').prop('selectedIndex',0);
				}
				if($(this).attr("value")=="tutor"){
					$('.empclass').hide();
					$("#sctclass").val("");
					//$('#sclsyllubaslist').prop('selectedIndex',0);
					//$('#SyllabusClasses').prop('selectedIndex',0);
				}
			})
		}).change();
	});

</script>
