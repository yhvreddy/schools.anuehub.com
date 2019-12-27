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
        <li class="breadcrumb-item active">New Employee</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">New Employee <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">New Employee</h4>
                </div>
                <div class="panel-body row">
                    <div class="col-md-12">
                        <form method="post" enctype="multipart/form-data" action="<?=base_url('dashboard/employee/saveemployeedata')?>" class="form-material">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h5 class="text-success">Employee Details</h5></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <?php if($scltype == 'GB'){ ?>
                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <label>Select Branch: <span class="text-red"> * </span></label>
                                                <div class="form-group">
                                                    <select class="form-control select2" disabled name="" id="sclbranch" >
                                                        <option selected value="<?= $schoolid; ?>">This Branch</option>
                                                        <?php foreach($branchlist as $branchs){ ?>
                                                            <option value="<?=$branchs->school_id?>"><?=$branchs->branchname.' - '.$branchs->school_id; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
											<input type='hidden' value="<?= $schoolid; ?>" name="schoolid">
                                        <?php }else{ ?>
                                            <input type='hidden' value="<?= $schoolid; ?>" name="schoolid">
                                        <?php } ?>
                                        <input type='hidden' value="<?= $branchid; ?>" name="branchid">

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <label for="Environmentid">Environment ID <span class="text-danger">*</span></label>
                                            <div class="form-group">
                                                <input type="text" placeholder="Environment id"  value="<?=$environment_id?>" class="form-control text-uppercase" readonly name="environmentid" id="Environmentid" required="" maxlength="25" minlength="8">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>First Name <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter First Name" name="empname" required>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Last Name <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="text" class="form-control" required placeholder="Enter Last Name" name="emplname">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Gender <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <select class="form-control show-tick" name="empgender" required>
                                                <option value="">Select Gender</option>
                                                <?php foreach ($gender as $genders) { ?>
                                                    <option value="<?= $genders->shortname ?>"><?= $genders->name ?></option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Date of Birth <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="text" id="mdate" class="form-control mydatepicker" placeholder="Please choose a date..." name="empdob" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Nationality</label>
                                            <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter Nationality" name="empnationality">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Religion</label>
                                            <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter religion" name="empreligion">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Mobile Number <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="tel" class="form-control mobile-phone-number" placeholder="Enter Mobile Number" id="Mobileno" name="empmobile" maxlength="" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Alter Number</label>
                                            <div class="form-group">
                                            <input type="tel" class="form-control mobile-phone-number" placeholder="Enter Alter Number" name="empphone" maxlength="13">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Email Address <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Enter Mail id" name="empmail" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3" id="emp_type">
                                            <label>Employee Type <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <select class="form-control select2" id="employeetype" name="emptype" required>
                                                <option value="" selected>Select Employee type</option>
                                                <?php foreach ($employee as $employees) { ?>
                                                    <option value="<?= $employees->shortname ?>"><?= $employees->name ?></option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 staff" id="emp_staff_type">
                                            <label>Staff Type</label>
                                            <div class="form-group">
                                            <select class="form-control select2" id="emp_staff_type_select" name="emppti">
                                                <option value="">Select Staff type</option>
                                                <?php foreach ($staff as $staffs) { ?>
                                                    <option value="<?= $staffs->shortname ?>"><?= $staffs->name ?></option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 empclass" id="emp_staff_syllabusclass">
                                            <div class="row">
                                                <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <label for="sclsyllabuslist">School Syllabus</label>
                                                    <select type="text" name="StdSyllubas" id="sclsyllubaslist" class="form-control select2">
                                                        <option value="">Syllabus Type</option>
                                                        <?php foreach ($syllabus as $key => $value) { ?>
                                                            <option value="<?= $key ?>"><?= $value ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <label for="SyllabusClasses">Select Class</label>
                                                    <select type="text" name="empclass" id="SyllabusClasses" class="form-control select2" disabled="">
                                                        <option value="">Class</option>
                                                    </select>
                                                </div>
                                            </div>
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
                                        <div class="col-xs-12 col-sm-6 col-md-3 workers" id="emp_staff_works">
                                            <label>Workers Type</label>
                                            <div class="form-group">
                                            <select class="form-control select2" id="emp_staff_works_select" name="emppoti">
                                                <option value="">Select worker type</option>
                                                <?php foreach ($worker as $workers) { ?>
                                                    <option value="<?= $workers->shortname ?>"><?= $workers->name ?></option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 assistant" id="emp_staff_office">
                                            <label>Office assistant Type </label>
                                            <div class="form-group">
                                            <select class="form-control select2" id="emp_staff_office_select" name="empoffic">
                                                <option value="">Select assistant type</option>
                                                <?php foreach ($office as $offices) { ?>
                                                    <option value="<?= $offices->shortname ?>"><?= $offices->name ?></option>
                                                <?php } ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Designation <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter Degination Ex: Bcom..." name="empdegination" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <label for="employeeimage">Upload Employee Image</label>
                                            <div class="form-group">
                                                <input type="file" class="form-control dropify" name="employeeimage" id="employeeimage" accept=".jpg,.png">
                                            </div>
                                        </div>

                                         <div class="col-xs-12 col-sm-6 col-md-3 form-group">
                                            <label>Select country.. <span class="text-danger">*</span></label>
                                            <select name="CountryName" id="CountryName" class="form-control select2" required>
                                                <option value="">Select Country</option>
                                                <?php foreach ($countries as $country){ ?>
                                                    <option value="<?= $country->id ?>"><?= $country->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-6 col-md-3 form-group">
                                            <label for="StateName">Select State Name <span class="text-danger">*</span></label>
                                            <select name="StateIdName" id="StateName" class="form-control select2" required disabled="">
                                                <option value="">Select State Name</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-6 col-md-3 form-group">
                                            <label for="CityName">Select City or Dist <span class="text-danger">*</span></label>
                                            <select name="CityIdName" id="CityName" class="form-control select2" required disabled="">
                                                <option value="">Select City or Dist</option>
                                            </select>
                                        </div>
                                        
                                        <div class="" id="EmpAddressbox">
                                            <label>Address <span class="text-red">*</span></label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Enter Address" name="address" id="padd" required="">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Pincode <span class="text-red">*</span></label>
                                            <div class="form-group">
                                            <input type="tel" class="form-control" placeholder="Enter Pincode" minlength="6" maxlength="6" name="emppincode" required/>
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
                                            <input type="tel" maxlength="10" class="form-control" placeholder="Salary amount/- Month" name="empsalary" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12 empsubjects" style="display:none" id="ClassSubjectsToDeal">
                                            <!--<label>Enter subject deal<small> (Separate by ,)</small></label>
                                            <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter subject Names Ex : Maths,science,social,..etc" name="empsubjects" id="tags_1" style="">
                                            </div>-->

                                            <label>Select class and subjects to deal.</label>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <?php foreach ($syllabus as $key => $value) { //print_r($key); ?>
                                                        <div class="custom-control custom-radio col-md-2">
                                                            <input type="radio" class="custom-control-input" id="customCheck_<?= $key ?>" value="<?= $key ?>" name="syllabus_name">
                                                            <label class="custom-control-label" style="padding: 3px;" for="customCheck_<?= $key ?>"> <?= $value ?></label>
                                                        </div>
                                                        <script>
                                                            $(document).ready(function(){
                                                                $("#customCheck_<?= $key ?>").change(function(){
                                                                    $("#SyllabusClassList").html("");
                                                                    $("#SyllabusClassSubjectsList").html("");
                                                                    var selectedsyllabus =   $(this).val();
                                                                    var school_id        =   '<?=$schoolid?>';
                                                                    var branch_id        =   '<?=$branchid?>';
                                                                    if(selectedsyllabus != '' && school_id != '' && branch_id != ''){
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
                                            <div class="col-md-12" id="SyllabusClassList"></div>
                                            <div class="col-md-12" id="SyllabusClassSubjectsList"></div>
                                        </div>
										<?php //print_r($syllabus); ?>
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
                                             <input type="text" class="form-control" placeholder="Enter Name" name="emppname">
                                             </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                             <label>Designation</label>
                                             <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter Degination" name="emppdegination">
                                             </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                             <label>Phone Number</label>
                                             <div class="form-group">
                                            <input type="tel" class="form-control mobile-phone-number" placeholder="Enter Mobile Number" name="emppmobile" maxlength="10">
                                             </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <label>Email Address</label>
                                            <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Enter mail id" name="emppmail">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                             <label>Address</label>
                                             <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter address" name="emppaddress">
                                             </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                             <label>City</label>
                                             <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter city/Town Name" name="emppcity" />
                                             </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                             <label>Pincode</label>
                                             <div class="form-group">
                                            <input type="tel" class="form-control" placeholder="Enter 6 digits Pincode" maxlength="6"  name="empppincode"/>
                                             </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <button type="submit" class="btn btn-success pull-right" name="addnewemployee">
                                            ADD EMPLOYEE
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
        $('#EmpAddressbox').addClass('col-md-6');
		
        function EmployeeListingData(){
            //employee type show & null
            $("#emp_type").show();
            $('#employeetype').select2({ placeholder: "Please select employee type", allowClear: true });

            //staff hide & null
            $("#emp_staff_type").hide();
            $('#emp_staff_type_select').select2({ placeholder: "Please select staff type", allowClear: true });

                //staff class - syllabus hide & null
                $("#emp_staff_syllabusclass").hide();
                $('#sclsyllubaslist').select2({ placeholder: "Syllabus type", allowClear: true });
                $('#SyllabusClasses').select2({ placeholder: "Select class", allowClear: true });

            //workers hide & null
            $("#emp_staff_works").hide();
            $('#emp_staff_works_select').select2({ placeholder: "Please select workers type", allowClear: true });

            //office hide & null
            $("#emp_staff_office").hide();
            $('#emp_staff_office_select').select2({ placeholder: "Please select office type", allowClear: true });
			
        }
        
        EmployeeListingData();

        //main employees changes
        $('#employeetype').on('change',function(){
            var employee_type   =   $(this).val();
            //console.log(employee_type);

			$('#ClassSubjectsToDeal').hide();
			$("input[name='syllabus_name']").prop('checked', false);
			$("#SyllabusClassList").html("");
			$("#SyllabusClassSubjectsList").html("");

			$("#emp_staff_syllabusclass").hide();
			$('#sclsyllubaslist').removeAttr('required');
			$('#SyllabusClasses').removeAttr('required');

            if(employee_type == ''){
                //hide all depended options
                EmployeeListingData();

            }else if(employee_type == 'staff'){
                
                $("#emp_staff_office").hide();
                $("#emp_staff_works").hide();
                $("#emp_staff_type").show();
                
                //null values
                $('#emp_staff_office_select').select2({ placeholder: "Please select office type", allowClear: true });
                $('#emp_staff_works_select').select2({ placeholder: "Please select workers type", allowClear: true });
                
                //mandatry attr
                $("#emp_staff_works_select").removeAttr('required');
                $("#emp_staff_office_select").removeAttr('required');
                $("#emp_staff_type_select").attr('required','required');
                
            }else if(employee_type == 'worker'){
                
                $("#emp_staff_office").hide();
                $("#emp_staff_type").hide();
                $("#emp_staff_works").show();
                
                //null values
                $('#emp_staff_office_select').select2({ placeholder: "Please select office type", allowClear: true });
                $('#emp_staff_type_select').select2({ placeholder: "Please select staff type", allowClear: true });
                
                //mandatry attr
                $("#emp_staff_type_select").removeAttr('required');
                $("#emp_staff_office_select").removeAttr('required');
                $("#emp_staff_works_select").attr('required','required');
               
            }else if(employee_type == 'office'){
                
                $("#emp_staff_type").hide();
                $("#emp_staff_works").hide();
                $("#emp_staff_office").show();
                
                //null values
                $('#emp_staff_works_select').select2({ placeholder: "Please select workers type", allowClear: true });
                $('#emp_staff_type_select').select2({ placeholder: "Please select staff type", allowClear: true });
                
                //mandatry attr
                $("#emp_staff_works_select").removeAttr('required');
                $("#emp_staff_type_select").removeAttr('required');
                $("#emp_staff_office_select").attr('required','required');
              
            }
        })

		//staff changes
		$("#emp_staff_type_select").on('change',function () {
			var employee_staff	=	$(this).val();
			//console.log(employee_staff);
			if(employee_staff == ''){

				$("#emp_staff_syllabusclass").hide();
				$('#sclsyllubaslist').removeAttr('required');
				$('#SyllabusClasses').removeAttr('required');

				$('#ClassSubjectsToDeal').hide();
				$("input[name='syllabus_name']").prop('checked', false);
				$("#SyllabusClassList").html("");
				$("#SyllabusClassSubjectsList").html("");

			}else if(employee_staff == 'classteacher'){

				$("#emp_staff_syllabusclass").show();
				$('#sclsyllubaslist').attr('required','required');
				$('#SyllabusClasses').attr('required','required');

				$('#ClassSubjectsToDeal').show();
				$("input[name='syllabus_name']").prop('checked', false);
				$("#SyllabusClassList").html("");
				$("#SyllabusClassSubjectsList").html("");

			}else if(employee_staff == 'teacher'){

				$("#emp_staff_syllabusclass").hide();
				$('#sclsyllubaslist').removeAttr('required');
				$('#SyllabusClasses').removeAttr('required');

				$('#ClassSubjectsToDeal').show();
				$("input[name='syllabus_name']").prop('checked', false);
				$("#SyllabusClassList").html("");
				$("#SyllabusClassSubjectsList").html("");

			}else if(employee_staff == 'tutor'){

				$("#emp_staff_syllabusclass").hide();
				$('#sclsyllubaslist').removeAttr('required');
				$('#SyllabusClasses').removeAttr('required');

				$('#ClassSubjectsToDeal').show();
				$("input[name='syllabus_name']").prop('checked', false);
				$("#SyllabusClassList").html("");
				$("#SyllabusClassSubjectsList").html("");

			}
		})

    });
</script>
