<!-- begin #content -->
<style>
	#profileImage_picname,#profileImage_picname2,#profileImage_picname21{
		font-size: 40px;
		color: white;
		background: #512da8;
		padding: 27px;
		text-align: center;
	}

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
</style>
<div id="content" class="content content-full-width">
	<?php
		$session = $this->session->userdata();
		if($session['type'] == 'admin'){
			$userdetails = $this->Model_dashboard->selectdata('sms_regusers',array('sno'=>$session['id'],'reg_id'=>$session['regid']));
			$userdetails = $userdetails[0];
			$firstname 	= 	$userdetails->fname;
			$lastname	=	$userdetails->lname;
			$email		=	$userdetails->mailid;
			$role		=	'admin';
			$registerid	=	$userdetails->reg_id;
			$mobileno	=	$userdetails->mobile;
			$address	=	$userdetails->address;
			$pincode	=	$userdetails->pincode;
            $idnumber	=	$userdetails->sno;
		}
			//echo '<pre>';
			//print_r($session);
			//print_r($userdetails);
			//echo '</pre>';
		?>
	<!-- begin profile -->
	<div class="profile">
		<div class="profile-header">
			<!-- BEGIN profile-header-cover -->
			<div class="profile-header-cover"></div>
			<!-- END profile-header-cover -->
			<!-- BEGIN profile-header-content -->
			<div class="profile-header-content">
				<!-- BEGIN profile-header-img -->
				<div class="profile-header-img">
					<?php
						if(isset($userdetails->profile_pic)){
							$profile_image = $userdetails->profile_pic;
						}else if(isset($userdata->student_image)){
							$profile_image = $userdetails->student_image;
						}elseif(isset($userdetails->employee_pic)){
							$profile_image = $userdetails->employee_pic;
						}

						if(isset($userdetails->fname)){
							$fname = $userdetails->fname;
							$lname = $userdetails->lname;
						}else{
							$fname = $userdetails->firstname;
							$lname = $userdetails->lastname;
						}
					?>
					<script>
						$(document).ready(function(){
							var PfirstName = '<?=$fname?>';
							var PlastName = '<?=$lname?>';
							var intials = PfirstName.charAt(0) + PlastName.charAt(0);
							var PprofileImage = $('#profileImage_picname').text(intials);
						});
					</script>
					<?php if(isset($profile_image) && !empty($profile_image)){ ?>
						<img src="<?=base_url($profile_image)?>" style="width: 100%;height: 112px;" alt="">
					<?php }else{ ?>
						<div id="profileImage_picname" class="text-uppercase"></div>
					<?php } ?>
				</div>
				<!-- END profile-header-img -->
				<!-- BEGIN profile-header-info -->
				<div class="profile-header-info">
					<h4 class="m-t-10 m-b-5"><?= ucwords($firstname).'.'.strtoupper(substr($lastname,0,1)) ?></h4>
					<p class="m-b-10"> <i class="fa fa-envelope"></i> : <?=$email?></p>
					<p class="m-b-10"> &nbsp;<i class="fa fa-user"></i> : <?=ucwords($role)?></p>
<!--					<a href="#" class="btn btn-xs btn-yellow">Edit Profile</a>-->
				</div>
				<!-- END profile-header-info -->
			</div>
			<!-- END profile-header-content -->
			<!-- BEGIN profile-header-tab -->
			<ul class="profile-header-tab nav nav-tabs">

				<li class="nav-item"><a href="#profiledetails" class="nav-link active" data-toggle="tab">Profile</a></li>
				<?php if($session['type'] == 'admin'){ ?>
					<li class="nav-item"><a href="#schoolDetails" class="nav-link" data-toggle="tab">School Details</a></li>
					<li class="nav-item"><a href="#settingDetails" class="nav-link" data-toggle="tab">Settings</a></li>
				<?php } ?>
			</ul>
			<!-- END profile-header-tab -->
		</div>
	</div>
	<!-- end profile -->
	<!-- begin profile-content -->
	<div class="profile-content">
		<!-- begin tab-content -->
		<div class="tab-content p-0">
			<!-- begin #profile-post tab -->
			<div class="tab-pane fade show active" id="profiledetails">
				<div class="row">
					<div class="col-4">
						<div class="panel panel-inverse">
							<div class="panel-heading">
								<div class="panel-heading-btn">
<!--										<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>-->
<!--										<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>-->
								</div>
								<span class="panel-title">User Profile Details</span>
							</div>
							<div class="panel-body">
								<div class="row align-content-center justify-content-center">
									<script>
										$(document).ready(function(){
											var PfirstName = '<?=$fname?>';
											var PlastName = '<?=$lname?>';
											var intials = PfirstName.charAt(0) + PlastName.charAt(0);
											var PprofileImage = $('#profileImage_picname2').text(intials);
										});
									</script>
									<?php if(isset($profile_image) && !empty($profile_image)){ ?>
										<img src="<?=base_url($profile_image)?>" style="width: 140px;height: 140px" alt="">
									<?php }else{ ?>
										<div id="profileImage_picname2" class="text-uppercase"></div>
									<?php } ?>
									<div class="col-12 text-capitalize text-center mt-3">
										<label><?= ucwords($firstname).'.'.ucwords($lastname); ?></label>
									</div>
								</div>
								<div class="row mt-3">
									<div class="col-md-12">
										<label> Register Id :</label> <span class="text-capitalize"><?=$registerid?></span><br>
										<label> First Name :</label> <span class="text-capitalize"><?=$firstname?></span><br>
										<label> Last Name :</label> <span class="text-capitalize"><?=$lastname?></span><br>
										<label> Mobile :</label> <span class="text-capitalize"><?=$mobileno?></span><br>
										<label> eMail :</label> <span class="text-capitalize"><?=$email?></span><br>
										<label> Address :</label> <span class="text-capitalize"><?=$address?></span><br>
										<label> Pincode :</label> <span class="text-capitalize"><?=$pincode?></span><br>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-8">
						<div class="panel panel-inverse">
							<div class="panel-heading">
								<div class="panel-heading-btn">
									<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
									<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
								</div>
								<span class="panel-title">Update Profile Details</span>
							</div>
							<div class="panel-body">
								<h5 class="text-success">Registered Details : </h5>
								<form method="post" class="col-12" action="<?= base_url('dashboard/profile/updateprofiledata/'.$idnumber) ?>" enctype="multipart/form-data">
									<input type="hidden" name="reg_id" value="<?=$registerid?>">
									<input type="hidden" name="id" value="<?=$userdetails->sno?>">
									<div class="row">
										<?php if(isset($userdetails->scl_mode) && $userdetails->scl_mode != 'GSB'){ ?>
											<div class="col-md-3 form-group">
												<label for="SchoolType">Select School Type</label>
												<select name="schooltype" id="SchoolType" class="form-control select2 p-0" disabled required>
													<option value="">Select Business Type</option>
													<?php foreach ($scltypes as $type){ ?>
														<option <?php if($userdetails->scl_mode == $type->shortname){ echo 'selected'; } ?> value="<?= $type->shortname ?>"><?= $type->name ?></option>
													<?php } ?>
												</select>
											</div>
										<?php } ?>
										<div class="col-md-5 form-group">
											<label for="Fname">Enter First Name</label>
											<input type="text" name="firstname" class="form-control" required id="Fname" value="<?=$firstname?>" placeholder="Enter First Name">
										</div>
										<div class="col-md-4 form-group">
											<label for="Lname">Enter Last Name</label>
											<input type="text" name="lastname" class="form-control" required id="Lname" value="<?=$lastname?>" placeholder="Enter Last Name">
										</div>
										<div class="col-md-3 form-group">
											<label for="Mobile">Enter Mobile Number</label>
											<input type="tel" minlength="10" style="width:100%;" placeholder="Enter Mobile Number" required value="<?=$mobileno?>" name="mobile" class="form-control" id="Mobile">
										</div>
										<div class="col-md-5 form-group">
											<label for="Mailid">Enter Mail id</label>
											<input type="email" required placeholder="Enter Mail id" name="email" class="form-control" value="<?=$email?>" id="eMailid">
										</div>
										<div class="col-md-4 form-group">
											<label for="CountryName">Select country Name <span class="text-danger">*</span></label>
											<select name="CountryName" id="CountryName" class="form-control select2 p-0" required>
												<option value="">Select country Name</option>
												<?php foreach ($countries as $country){ ?>
													<option <?php if($userdetails->country_id == $country->id){ echo 'selected'; } ?> value="<?= $country->id ?>"><?= $country->name ?></option>
												<?php } ?>
												<!-- <option value='other'> Other country </option> -->
											</select>
										</div>
										<div class="col-md-4 form-group">
											<label for="StateName">Select State Name <span class="text-danger">*</span></label>
											<select name="StateName" id="StateName" class="select2 form-control p-0" required>
												<option value="">Select State Name</option>
												<?php $statelist = $this->Model_dashboard->selectdata('sms_states',array("country_id"=>$userdetails->country_id,'status'=>1));
												foreach ($statelist as $sitem) { ?>
													<option <?php if($userdata->state_id == $sitem->id){ echo 'selected'; } ?> value="<?=$sitem->id?>"><?=$sitem->name?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-4 form-group">
											<label for="CityName">Select City / Dist Name <span class="text-danger">*</span></label>
											<select name="CityName" id="CityName" class="select2 form-control p-0" required>
												<option value="">Select City / Dist Name</option>
												<?php  $citylist = $this->Model_dashboard->selectdata('sms_cities',array('state_id'=>$userdetails->state_id,'status'=>1));
												foreach ($citylist as $citem) { ?>
													<option <?php if($userdata->city_id == $citem->id){ echo 'selected'; } ?> value="<?=$citem->id?>"><?=$citem->name?></option>
												<?php } ?>
											</select>
											<small id="selectcityerror"></small>
										</div>
										<div class="col-md-4 form-group">
											<label for="Address">Enter Address</label>
											<input type="text" required name="Address" class="form-control" value="<?=$address?>" id="address" placeholder="Enter Address">
										</div>
										<div class="col-md-3 form-group">
											<label for="pincode">Enter Pincode / Zip Code</label>
											<input type="text" maxlength="" required name="pincode" placeholder="Enter Pincode / Zip Code" class="form-control" id="pincode" value="<?=$pincode?>">
										</div>
										<div class="col-md-3 form-group">

											<label for="userprofileimage">Upload User Image</label>
											<input type="file" class="form-control dropify" name="profileimage" id="userprofileimage" accept=".jpg,.png">

											
								            <input type="hidden" name="uploadedProfileImage" value="<?=$profile_image?>">
											
										</div>
										<div class="col-md-12 form-group">
											<input type="submit" id="UpdateregisterAccount" class="btn btn-success pull-right" value="Update Details" />
										</div>
									</div>
								</form>
							    <p>
                                    <span class="text-danger">Note : </span> If don't want to change your profile image just leave it as empty.
                                </p>
                            </div>
						</div>

						<div class="panel panel-inverse">
							<div class="panel-heading">
								<div class="panel-heading-btn">
									<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
									<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
								</div>
								<span class="panel-title">Change Password</span>
							</div>
							<div class="panel-body">
								<div class="row">
									<h5 class="col-12 text-success">Change Account Password : </h5>
									<form method="post" class="col-12" action="<?= base_url('dashboard/profile/updatepassword/'.$idnumber) ?>">
										<input type="hidden" name="reg_id" value="<?=$registerid?>">
										<input type="hidden" name="id" value="<?=$userdetails->sno?>">
										<div class="row">
											<div class="col-md-4 form-group">
												<label for="old_password">Old Password</label>
												<input type="password" name="old_password" class="form-control" required id="old_password" placeholder="Enter old Password">
											</div>
											<div class="col-md-4 form-group">
												<label for="new_password">New Password</label>
												<input type="password" name="new_password" class="form-control" required id="new_password" placeholder="Enter New Password">
											</div>
											<div class="col-md-4 form-group">
												<label for="confirm_password">Confirm Password</label>
												<input type="password" placeholder="Enter confirm Password" required name="confirm_password" class="form-control" id="confirm_password">
											</div>
											<div class="col-md-12 form-group">
												<input type="submit" class="btn btn-success pull-right mt-2" value="Change Password" />
											</div>
										</div>
									</form>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end #profile-post tab -->
			<?php if($session['type'] == 'admin'){
					$schooldetails	=	$this->Model_dashboard->selectdata('sms_schoolinfo',array('reg_id'=>$session['regid']));
					$schooldetails	=	$schooldetails[0];
				?>
				<!-- begin #profile-about tab -->
				<div class="tab-pane fade" id="schoolDetails">
					<div class="row">
						<div class="col-4">
							<div class="panel panel-inverse">
								<div class="panel-heading">
									<div class="panel-heading-btn">
										<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
										<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
									</div>
									<span class="panel-title">Organization Details</span>
								</div>
								<div class="panel-body">
									<div class="row align-content-center justify-content-center">
										<script>
											$(document).ready(function(){
												var OfirstName  = '<?=$schooldetails->schoolname?>';
												var Ointials     = OfirstName.charAt(0);
												var OprofileImage = $('#profileImage_picname21').text(Ointials);
											});
										</script>
										<?php if(isset($schooldetails->school_logo) && !empty($schooldetails->school_logo)){ ?>
											<img src="<?=base_url($schooldetails->school_logo)?>" alt="" style="width:140px;height:140px">
										<?php }else{ ?>
											<div id="profileImage_picname21" class="text-uppercase"></div>
										<?php } ?>
										<div class="col-12 text-capitalize text-center mt-3">
											<label><?=$schooldetails->schoolname?></label>
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-md-12">
											<label> Organization Name :</label> <span class="text-capitalize"><?=$schooldetails->schoolname?></span><br>
											<label> Organization Id :</label> <span class="text-capitalize"><?=$schooldetails->school_id?></span><br>
											<label> Mobile :</label> <span class="text-capitalize"><?=$schooldetails->school_mobile?></span><br>
											<label> eMail :</label> <span class="text-capitalize"><?=$schooldetails->school_mail?></span><br>
											<label> Address :</label> <span class="text-capitalize"><?=$schooldetails->school_address?></span><br>
											<label> Pincode :</label> <span class="text-capitalize"><?=$schooldetails->school_pincode?></span><br>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-8">
							<div class="panel panel-inverse">
								<div class="panel-heading">
									<div class="panel-heading-btn">
										<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
										<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
									</div>
									<span class="panel-title">Update School Details</span>
								</div>
								<div class="panel-body">
									<div class="row">
										<h5 class="col-12 text-success">School Details : </h5>
										<div class="col-md-12">
											<form method="post" enctype="multipart/form-data" action="<?=base_url('dashboard/profile/updateschooldetails/'.$schooldetails->sno)?>" class="row">
												<input type="hidden" name="reg_id" value="<?=$schooldetails->reg_id?>">
												<input type="hidden" name="branch_id" value="<?=$schooldetails->branch_id?>">
												<input type="hidden" name="school_id" value="<?=$schooldetails->school_id?>">
												<input type="hidden" name="id" value="<?=$schooldetails->sno?>">
												<div class="col-md-12">
													<div class="row">
														<div class="col-md-5 form-group">
															<label for="schoolname">Enter School  Name <span class="text-danger">*</span></label>
															<input type="text" required name="school_name" data-parsley-group="step-2" data-parsley-required="true" class="form-control" id="schoolname" value="<?=$schooldetails->schoolname?>" placeholder="Enter School Name">
															<small id="schoolnameerror"></small>
														</div>
														<div class="col-md-3 form-group">
															<label for="sclregid"> Govt Reg id <span class="text-danger">*</span></label>
															<input type="text" data-parsley-required="true" required name="govt_reg_id" class="form-control" value="<?=$schooldetails->school_tinnumber?>" id="schoolregister_id" placeholder="Govt Register id">
															<small id="sclregiderror"></small>
														</div>
														<div class="col-md-4 form-group">
															<label for="Mobile">School Mobile number <span class="text-danger">*</span></label>
															<input type="tel" data-parsley-required="true" id="sMobile" mimlength="10" data-parsley-type="number" value="<?=$schooldetails->school_mobile?>" name="school_mobile" required class="form-control" placeholder="School Mobile Number">
															<small id="sclmobileerror"></small>
														</div>
														<div class="col-md-4 form-group">
															<label for="Sclphonenumber">Alter Phone number</label>
															<input type="tel" <?php if($schooldetails->school_phone != 0){ ?> value="<?=$schooldetails->school_phone?>" <?php } ?>  data-parsley-type="number" name="school_phone_number" class="form-control" id="Sclphonenumber" placeholder="Alter Phone Number">
															<small id="sclphoneerror"></small>
														</div>
														<div class="col-md-4 form-group">
															<label for="Sclmailid">Enter School Mail id <span class="text-danger">*</span></label>
															<input type="email" value="<?=$schooldetails->school_mail?>" data-parsley-required="true" required name="school_mail_id" id="Schoolmailid" class="form-control" placeholder="School email id">
															<small id="sclmailiderror"></small>
														</div>
														<div class="col-md-4 form-group">
															<label for="SclbranchName">School Branch Name <span class="text-danger">*</span></label>
															<input type="text" value="<?=$schooldetails->branchname?>" data-parsley-required="true" id="SclbranchName" required name="school_branch_name" class="form-control" placeholder="School Branch Name">
															<small id="Sclbranchnameerror"></small>
														</div>
														<div class="col-md-4 form-group">
															<label for="CountryName">Select country Name <span class="text-danger">*</span></label>
															<select name="sclCountryName" id="CountryName1" style="width:100%" class="form-control select2 p-0" required>
																<option value="">Select country Name</option>
																<?php foreach ($countries as $country){ ?>
																	<option <?php if($schooldetails->country_id == $country->id){ echo 'selected'; } ?> value="<?= $country->id ?>"><?= $country->name ?></option>
																<?php } ?>
																<!-- <option value='other'> Other country </option> -->
															</select>
														</div>
														<div class="col-md-4 form-group">
															<label for="StateName">Select State Name <span class="text-danger">*</span></label>
															<select name="sclStateName" style="width:100%" id="StateName1" class="select2 form-control p-0" required>
																<option value="">Select State Name</option>
																<?php $statelist = $this->Model_dashboard->selectdata('sms_states',array("country_id"=>$schooldetails->country_id,'status'=>1));
																foreach ($statelist as $sitem) { ?>
																	<option <?php if($schooldetails->state_id == $sitem->id){ echo 'selected'; } ?> value="<?=$sitem->id?>"><?=$sitem->name?></option>
																<?php } ?>
															</select>
														</div>
														<div class="col-md-4 form-group">
															<label for="CityName">Select City / Dist Name <span class="text-danger">*</span></label>
															<select name="sclCityName" id="CityName1" style="width:100%" class="select2 form-control p-0" required>
																<option value="">Select City / Dist Name</option>
																<?php  $citylist = $this->Model_dashboard->selectdata('sms_cities',array('state_id'=>$schooldetails->state_id,'status'=>1));
																foreach ($citylist as $citem) { ?>
																	<option <?php if($schooldetails->city_id == $citem->id){ echo 'selected'; } ?> value="<?=$citem->id?>"><?=$citem->name?></option>
																<?php } ?>
															</select>
															<small id="selectcityerror"></small>
														</div>
														<div class="col-md-5 form-group">
															<label for="Scladdress">Enter Organization address <span class="text-danger">*</span></label>
															<input type="text" value="<?=$schooldetails->school_address?>" data-parsley-required="true" required name="school_address" placeholder="School Address" class="form-control" id="Scladdress">
															<small id="scladdresserror"></small>
														</div>
														<!-- <div class="col-md-4 form-group">
                                                            <input type="text" required name="sclcity" id="Sclcity" class="form-control">
                                                            <span class="bar"></span>
                                                            <label for="Sclcity">Enter city or town</label>
                                                            <small id="sclcityerror"></small>
                                                        </div> -->
														<div class="col-md-3 form-group">
															<label for="Sclpincode">Enter Pincode / Zip Code <span class="text-danger">*</span></label>
															<input type="text" value="<?=$schooldetails->school_pincode?>" data-parsley-required="true" placeholder="Enter Pincode / Zip Code" id="Sclpincode" required name="school_pincode" class="form-control">
														</div>
														<div class="col-md-4 form-group">
															<label for="webaddress">Enter School Website <span class="text-danger">*</span></label>
															<input type="url" value="<?=$schooldetails->school_website?>" name="school_website" placeholder="School website" class="form-control" id="webaddress">
														</div>
														<div class="col-md-12">
															<div class="row justify-content-center align-items-center">
																<!-- end form-group -->
																<?php if($schooldetails->scltype != 'GSB'){ ?>
																	<div class="col-lg-4 col-md-4 ">
																		<label for="uploadLogo" class="text-info" style="top:-20px;font-size:12px">Upload Logo</label>
																		<input type="file" id="uploadLogo" name="school_logo" class="dropify" data-show-remove="false" accept=".png" />
																	</div>
																	<input type="hidden" value="<?= $schooldetails->school_logo ?>" name="school_uploaded_logo">
																<?php }else{ ?>
																	<!-- <input type="hidden" value="<?//=$schooldata->school_regdocuments ?>" name="school_documents"> -->
																	<input type="hidden" value="<?= $schooldetails->school_logo ?>" name="school_uploaded_logo">
																<?php } ?>



																<div class="col-lg-4 col-md-4 ">
																	<label for="uploadLogo" class="text-info" style="top:-20px;font-size:12px">Upload Stamp Pad</label>
																	<input type="file" id="org_stamp_pad" name="school_stamp_pad" class="dropify" data-show-remove="false" accept=".png" />
																</div>
																<input type="hidden" value="<?= $schooldetails->stamp_pad ?>" name="school_uploaded_stamppad">

															</div>
														</div>
														<div class="col-md-12 mt-3 form-group">
															<input type="submit" class="btn btn-success pull-right" value="Update Details">
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- end #profile-about tab -->
				<!-- begin #profile-photos tab -->
				<div class="tab-pane fade" id="settingDetails">
					<center><h2>Comming soon..!</h2></center>
				</div>
				<!-- end #profile-photos tab -->
			<?php } ?>
		</div>
		<!-- end tab-content -->
	</div>
	<!-- end profile-content -->
</div>
<!-- end #content -->
