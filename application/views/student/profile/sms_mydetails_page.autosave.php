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

//			echo '<pre>';
//			print_r($userdata);
//			echo '</pre>';
			$userdetails = $userdata;
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
							$profile_image = $userdetails->profile;
							$reg_admit_image = $userdetails->student_image;
						}elseif(isset($userdetails->employee_pic)){
							$profile_image = $userdetails->profile;
							$reg_admit_image = $userdetails->employee_pic;
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
					<h4 class="m-t-10 m-b-5"><?= ucwords($fname).'.'.strtoupper(substr($lname,0,1)) ?></h4>
					<p class="m-b-10"> <i class="fa fa-envelope"></i> : <?=$userdetails->mail_id?></p>
<!--					<a href="#" class="btn btn-xs btn-yellow">Edit Profile</a>-->
				</div>
				<!-- END profile-header-info -->
			</div>
			<!-- END profile-header-content -->
			<!-- BEGIN profile-header-tab -->
			<ul class="profile-header-tab nav nav-tabs">
				<li class="nav-item"><a href="#profiledetails" class="nav-link active" data-toggle="tab">Profile Details</a></li>
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
										<label><?= ucwords($fname).'.'.ucwords($lname); ?></label>
									</div>
								</div>
								<div class="row mt-3">
									<div class="col-md-12">
										<label> Register Id :</label> <span class="text-capitalize"><?=$userdetails->id_num?></span><br>
										<label> First Name :</label> <span class="text-capitalize"><?=$fname?></span><br>
										<label> Last Name :</label> <span class="text-capitalize"><?=$lname?></span><br>
										<label> Date of Birth :</label> <span class="text-capitalize"><?=date('d-m-Y',strtotime($userdetails->dob))?></span><br>
										<label> Mobile :</label> <span class="text-capitalize"><?=$userdetails->mobile?></span><br>
										<label> Reg eMail :</label> <span class="text-lowercase"><?=strtolower($userdetails->mail_id)?></span><br>
										<label> Local eMail :</label> <span class="text-lowercase"><?=strtolower($userdetails->local_mail_id)?></span><br>
										<label> Address :</label> <span class="text-capitalize"><?=$userdetails->address?></span><br>
										<label> Pincode :</label> <span class="text-capitalize"><?=$userdetails->pincode?></span><br>
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
								<form method="post" class="col-12" action="<?= base_url('student/profile/updateprofiledata/'.$userdetails->sno) ?>" enctype="multipart/form-data">
									<input type="hidden" name="reg_id" value="<?=$userdetails->id_num?>">
									<input type="hidden" name="id" value="<?=$userdetails->sno?>">
									<input type="hidden" name="branch_id" value="<?=$userdetails->branch_id?>">
									<input type="hidden" name="school_id" value="<?=$userdetails->school_id?>">
									<div class="row">

										<div class="col-md-5 form-group">
											<label for="Fname">Enter First Name</label>
											<input type="text" name="firstname" class="form-control" required id="Fname" value="<?=$fname?>" placeholder="Enter First Name">
										</div>

										<div class="col-md-4 form-group">
											<label for="Lname">Enter Last Name</label>
											<input type="text" name="lastname" class="form-control" required id="Lname" value="<?=$lname?>" placeholder="Enter Last Name">
										</div>

										<div class="col-md-3 form-group">
											<label for="Mobile">Enter Mobile Number</label>
											<input type="tel" minlength="10" style="width:100%;" placeholder="Enter Mobile Number" required value="<?=$userdetails->mobile?>" name="mobile" class="form-control" id="Mobile">
										</div>

										<div class="col-xs-12 col-sm-6 col-md-3">
											<label>Alter Number</label>
											<div class="form-group">
												<input type="tel" class="form-control mobile-phone-number" placeholder="Enter Alter Number" name="empphone" maxlength="13" value="<?=$userdetails->altermobile?>">
											</div>
										</div>

										<div class="col-xs-12 col-sm-6 col-md-3">
											<label>Gender <span class="text-red">*</span></label>
											<div class="form-group">
												<select class="form-control show-tick" name="empgender" required>
													<option value="">Select Gender</option>
													<?php foreach ($gender as $genders) { ?>
														<option <?php if($userdetails->gender == $genders->shortname){ echo 'selected'; } ?> value="<?= $genders->shortname ?>"><?= $genders->name ?></option>
													<?php } ?>
												</select>
											</div>
										</div>

										<div class="col-xs-12 col-sm-6 col-md-3">
											<label>Date of Birth <span class="text-red">*</span></label>
											<div class="form-group">
												<input type="text" id="mdate" class="form-control mydatepicker" placeholder="Please choose a date..." value="<?=date('m/d/Y',strtotime($userdetails->dob))?>" name="empdob" required>
											</div>
										</div>

										<div class="col-xs-12 col-sm-6 col-md-3">
											<label>Nationality</label>
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Enter Nationality" value="<?=$userdetails->nationality?>" name="empnationality">
											</div>
										</div>

										<div class="col-xs-12 col-sm-6 col-md-3">
											<label>Religion</label>
											<div class="form-group">
												<input type="text" class="form-control" placeholder="Enter religion" name="empreligion" value="<?=$userdetails->religion?>">
											</div>
										</div>

										<div class="col-md-5 form-group">
											<label for="Mailid">Enter Mail id</label>
											<input type="email" required placeholder="Enter Mail id" name="email" class="form-control" value="<?=$userdetails->mail_id?>" id="eMailid">
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
											<input type="text" required name="Address" class="form-control" value="<?=$userdetails->address?>" id="address" placeholder="Enter Address">
										</div>

										<div class="col-md-3 form-group">
											<label for="pincode">Enter Pincode / Zip Code</label>
											<input type="text" maxlength="" required name="pincode" placeholder="Enter Pincode / Zip Code" class="form-control" id="pincode" value="<?=$userdetails->pincode?>">
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
									<form method="post" class="col-12" action="<?= base_url('student/profile/updatepassword/'.$userdetails->sno) ?>">
										<input type="hidden" name="reg_id" value="<?=$userdetails->id_num?>">
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
		</div>
		<!-- end tab-content -->
	</div>
	<!-- end profile-content -->
</div>
<!-- end #content -->
