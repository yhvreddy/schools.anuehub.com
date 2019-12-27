<!-- Container fluid  -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Branchs</a></li>
        <li class="breadcrumb-item active">New Branch</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">New Branch <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row justify-content-center align-items-center">
        <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            </div>
                            <h4 class="panel-title">New Branch</h4>
                        </div>
                        <div class="panel-body">
							<h6 id="ErrorMessageSubmiting" class="text-center text-warning"></h6>
							<form id="SetSubBranchSchooldetails" method="post" action="javascript:;">
								<input type="hidden" name="SchoolType" id="SchoolType" value="GSB">
								<div class="row mt-1 mb-3">
									<div class="form-group col-md-4">
										<label for="RegFname">Enter First Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control form-control-line" name="RegFname" id="RegFname" placeholder="Enter First Name" required>
										<span class="bar"></span>
										<small id="RegFnameerror"></small>
									</div>
									<div class="form-group col-md-4">
										<label id="RegLname">Enter Last Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control form-control-line RegLname" name="RegLname" id="RegLname" placeholder="Enter Last Name" required>
										<span class="bar"></span>
										<small id="RegLnameerror"></small>
									</div>
									<div class="form-group col-md-4">
										<label for="RegMobile">Enter Mobile Number <span class="text-danger">*</span></label>
										<input type="tel" maxlength="10" class="form-control form-control-line" id="RegMobile" name="RegMobile" placeholder="Enter Mobile Number" required>
										<span class="bar"></span>
										<small id="Regmobileerror"></small>
									</div>
									<div class="form-group col-md-4">
										<label for="Regemail">Email Id <span class="text-danger">*</span></label>
										<input type="email" class="form-control form-control-line" name="Regemail" id="Regemail" placeholder="Enter Email Id" required>
										<span class="bar"></span>
										<small id="Regmailerror"></small>
									</div>
									<div class="col-md-4 form-group">
										<label for="CountryName">Select country.. <span class="text-danger">*</span></label>
										<select name="CountryName" id="CountryName" class="form-control select2" required>
											<option value="">Select Country Name</option>
											<?php foreach ($countries as $country){ ?>
												<option value="<?= $country->id ?>"><?= $country->name ?></option>
											<?php } ?>
										</select>
										<span class="bar"></span>
										<small id="selectcountryerror"></small>
									</div>
									<div class="col-md-4 form-group">
										<label for="StateName">Select State Name <span class="text-danger">*</span></label>
										<select name="StateName" id="StateName" class="form-control select2" required disabled="">
											<option value="">Select State Name</option>
										</select>
										<span class="bar"></span>
										<small id="selectstateerror"></small>
									</div>
									<div class="col-md-4 form-group">
										<label for="CityName">Select City / Dist Name <span class="text-danger">*</span></label>
										<select name="CityName" id="CityName" class="form-control select2" required disabled="">
											<option value="">Select City / dist name</option>
										</select>
										<span class="bar"></span>
										<small id="selectcityerror"></small>
									</div>
									<div class="form-group col-md-8">
										<label for="RegAddress">Enter Address <span class="text-danger">*</span></label>
										<input type="text" class="form-control form-control-line" name="RegAddress" id="RegAddress" placeholder="Enter address" required>
										<span class="bar"></span>
										<small id="RegAddresserror"></small>
									</div>
									<!-- <div class="form-group col-md-4">
										<input type="text" class="form-control form-control-line" name="Regcity" required id="Regcity">
										<span class="bar"></span>
										<label for="Regcity">Enter City / town <span class="text-danger">*</span></label>
										<small id="Regcityerror"></small>
									</div> -->
									<div class="col-md-4 form-group">
										<label for="SclbranchName">Branch Name <span class="text-danger">*</span></label>
										<input type="text" id="SclbranchName" placeholder="Enter branch name" required name="SclbranchName" class="form-control">
										<span class="bar"></span>
										<small id="Sclbranchnameerror"></small>
									</div>
									<div class="form-group col-md-4">
										<label for="RegPincode">Enter pincode <span class="text-danger">*</span></label>
										<input type="tel" maxlength="6" class="form-control form-control-line" id="RegPincode" name="RegPincode" placeholder="Enter pincode" required>
										<span class="bar"></span>
										<small id="Regpincodeerror"></small>
									</div>
									<div class="form-group col-md-4">
										<label for="RegAadhaar">Enter Aadhaar Number <span class="text-danger">*</span></label>
										<input type="text" id="AadhaarCard" maxlength="14" class="form-control form-control-line text-center" placeholder="Enter aadhaar number" name="RegAadhaar" required>
										<span class="bar"></span>
										<small id="AadhaarCarderror"></small>
									</div>

									<div class="col-md-12 form-group">

										<label class="pull-left">
											<div class="checkbox checkbox-css checkbox-inline">
												<input id="Regcheckbox" type="checkbox" name="Regcheckbox" />
												<label for="Regcheckbox">I Accept Terms and conductions <a href="#">Click More.</a></label>
											</div>
										</label>

										<a href="javascript:void(0);" id="registerAccount" class="btn btn-success pull-right mt-2" data-toggle="modal" data-target="#FourdigpinRegisterAccount" data-backdrop="static" data-keyboard="false">Register Account</a>

										<!-- sample modal content -->
										<div id="FourdigpinRegisterAccount" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog" style="top:155px">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title">Enter your 4 digits pin..</h4>
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													</div>
													<div class="modal-body">
														<div class="col-md-12">
															<?php $this->Model_dashboard->fourDigitspin(); ?>
														</div>
														<div class="row align-content-center justify-content-center">
															<input type="submit" id="registernewAccount" class="btn btn-success pull-right mt-2" value="Confirm to register Account"/>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- /.modal -->

									</div>
									<!-- <div class="col-md-12">
										<input type="submit" name="NewRegister" value="Register Account" id="NewRegister" class="pull-right btn btn-success">
									</div> -->
								</div>
							</form>
						
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
<script type="text/javascript">
    $(document).ready(function() {
       /* regexp checkdata */
         var number =  /^[0-9]+$/;
         var regexnum = new RegExp(number);

        $("#SetSubBranchSchooldetails").submit(function(event) {
             event.preventDefault();

			var new_scltype 	=   $("#SchoolType").val();
			var new_firstname   =   $("#RegFname").val();
			var new_lastname 	=   $(".RegLname").val();
			var new_emailid  	=   $("#Regemail").val();
			var new_mobilenum  	=   $("#RegMobile").val();
			var new_address 	=   $("#RegAddress").val();
			//var city    =   $("#city").val();
			var new_country 	=   $("#CountryName").val();
			var new_stateid 	=   $("#StateName").val();
			var new_citydist	=   $("#CityName").val();
			var new_pincode 	=   $("#RegPincode").val();
			var new_aadhaar 	=   $("#AadhaarCard").val();
			var new_branch		=	$("#SclbranchName").val();
			
			var one		=	$("#Num_one").val();
			var two		= 	$("#Num_two").val();
			var three	=	$("#Num_three").val();
			var four	=	$("#Num_four").val();

			var databaind = 'fname = ' + new_firstname + ' lname = ' + new_lastname + ' mobile = ' + new_mobilenum + ' email = '+ new_emailid + ' address = '+ new_address + ' country = '+ new_country +' state = '+ new_stateid + ' city = '+ new_citydist +' pincode = ' + new_pincode + ' aadhaar = '+new_aadhaar + ' Branch = '+ new_branch;
			console.log(databaind);

			if(new_scltype !='' && new_firstname !='' && new_lastname !='' && new_mobilenum !='' && new_emailid != '' && new_address != '' && new_citydist != '' && new_country != '' && new_pincode != '' && new_stateid != '' && new_aadhaar != '' && new_branch != ''){

				if((regexnum.test(one) && one != '') && (regexnum.test(two) && two != '') && (regexnum.test(three) && three != '') && (regexnum.test(four) && four != '')) {
					$("#ErrorMessageSubmiting").text('');
					var fromdata = $("#SetSubBranchSchooldetails").serialize();
					$("#resmessage").text('');
					$("#loader").show();
					$.ajax({
						url: '<?=base_url();?>dashboard/branch/newbranch/saveregister',
						type: 'POST',
						dataType: 'json',
						data: fromdata,
					})
						.done(function (dataresponce) {
							$("#loader").hide();
							console.log(dataresponce);

							if (dataresponce.key == 0) {
								swal({
									title: "Sorry",
									text: dataresponce.message,
									type: "warning",
								});
								$(this).trigger('reset');
								//swal("Sorry", dataresponce.message , "warning");
							} else if (dataresponce.key == 1) {
								$("#4digpin-registerAccount").modal('hide');
								swal({
									title: "success",
									text: dataresponce.message,
									type: "success",
								}, function () {
									$(this).trigger('reset');
									window.location.href = "<?php echo base_url();?>dashboard/branch/branchlist";
								});
							} else {
								swal(dataresponce.message);
							}

						})
						.fail(function (errordata) {
							console.log(errordata);
							$("#loader").hide();
							swal("oops" + errordata + "error");
						});
				}else{
					$("#ErrorMessageSubmiting").text('');
					alert("Please enter valid pin..!");
					//$("#ErrorMessageFourDigitspin").text('Please enter valid pin..!').css('color', 'red');
				}

			}else{
				$('#FourdigpinRegisterAccount').modal('toggle');
				$("#Num_one,#Num_two,#Num_three,#Num_four").val('');
				$("#ErrorMessageSubmiting").text('Please fill all following required fields..!').css('color', 'red');
			}
		});
    });
</script>
