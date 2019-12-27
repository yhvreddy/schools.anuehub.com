<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title><?=$PageTitle?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/default/style.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/default/style-responsive.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
    <!-- <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet"> -->
    <link href="<?= base_url() ?>assets/css/sweetalert.min.css" rel="stylesheet">
    <!-- ================== END BASE CSS STYLE ================== -->
    <!-- ================== BEGIN BASE JS ================== -->
    <link href="<?=base_url()?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/intl-tel-input-master/build/css/intlTelInput.css">
    <script src="<?=base_url()?>assets/plugins/pace/pace.min.js"></script>
    <link href="<?=base_url()?>assets/plugins/jquery-smart-wizard/src/css/smart_wizard.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/dropify-master/dist/css/dropify.min.css">
    <script src="<?=base_url()?>assets/plugins/jquery/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/angular.min.js"></script>
    <script src="<?= base_url() ?>assets/js/sweetalert.min.js"></script>
    <!-- ================== END BASE JS ================== -->
    
    
    <style>
        /* .sw-main .nav-tabs{
            opacity: 0.8;
        } */
        
        /* .form-control{
            text-transform: capitalize !important;
        }  */
        .login.login-v2 label {
            color: #545454cc;
        }
        .form-control:disabled, .form-control[readonly]{
            color:#000 !important;
        }
        .login.login-v2 .form-control {
            background: rgba(255, 255, 255, 0.5);
            color: #000;
            border: 1px solid #8e8e8e73;
        }
        .intl-tel-input{
            width:100%;
        }
        .customalert{
            width: max-content;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1111111111;
        }
        .dropify-message{
            margin-top: 0px !important;
        }
        .dropify-message .file-icon{
            color:#3a89ff !important;
        }
        .dropify-wrapper{
            height: 85% !important;
            border-radius: 4% !important;
        }
        .dropify-wrapper .dropify-message p {
            margin: 4px 0 0 !important;
            padding: 0px 0px 9px 0px !important;
            font-size: smaller !important;
            line-height: normal !important;
        }
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
        .form-control:disabled, .form-control[readonly] {
            background-color: #ffffff !important;
            opacity: 1;
        }
        .login.login-v2 .form-control:focus {
            border-color: #cccccc;
            box-shadow: 0 0 0 0.125rem rgba(255,255,255,.3);
        }
        .select2-container,.select2{
            width:100% !important;
        }
    </style>
</head>
<body class="pace-top">
    <div class="loader" id="loader" style="display:none">
        <center>
            <img src="<?= base_url() ?>assets/images/loader.gif">
        </center>
    </div>
    <?php
        if($this->session->flashdata('error')){
            echo '<div class="alert-warning alert customalert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span style="padding-right:10px">'.$this->session->flashdata('error').'</span></div>';
        }else if($this->session->flashdata('success')){
            echo '<div class="alert-success alert customalert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span style="padding-right:10px">'.$this->session->flashdata('success').'</span></div>';
        }
    ?>
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <!-- end #page-loader -->

	<div class="login-cover">
		<div class="login-cover-image" style="background-image: url(<?=base_url()?>assets/images/background.jpg)" data-id="login-cover-image"></div>
		<div class="login-cover-bg"></div>
	</div>
    
    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login login-v2" style="width:80%;margin:30px auto 0 auto;top:0;left:0" data-pageload-addclass="animated fadeIn">
            <!-- begin brand -->
            <div class="login-header" style="margin: 0 auto;">
                <div class="brand">
                    <span class="logo"></span> <b>anu</b>ehub
                    <small>Complete Digital school with your hands...</small>
                </div>
                <div class="icon">
                    <i class="fa fa-lock"></i>
                </div>
            </div>
            <!-- end brand -->
            <!-- begin login-content -->
            <div class="login-content" style="width: 100%">
                <form action="javascript:;" id="registerNewSchoolDetails" enctype="multipart/form-data" method="POST" name="form-wizard" class="form-control-with-bg">
                    <!-- begin wizard -->
                    <?php $userdata = $userdata[0]; ?>
                    <div id="wizard">
                        <!-- begin wizard-step -->
                        <ul>
                            <li class="col-md-4 col-sm-4 col-6">
                                <a href="#step-1">
                                    <span class="number">1</span> 
                                    <span class="info text-ellipsis">
                                        Your Registered Details
                                        <small class="text-ellipsis">Confirm Your Details</small>
                                    </span>
                                </a>
                            </li>
                            <li class="col-md-4 col-sm-4 col-6">
                                <a href="#step-2">
                                    <span class="number">2</span> 
                                    <span class="info text-ellipsis">
                                        Enter School Details
                                        <small class="text-ellipsis">Name, Email, phone,.. is required.</small>
                                    </span>
                                </a>
                            </li>
                            <li class="col-md-4 col-sm-4 col-6">
                                <a href="#step-3">
                                    <span class="number">3</span> 
                                    <span class="info text-ellipsis">
                                        Apply License key
                                        <small class="text-ellipsis">Enter Productkey to Activate.</small>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <!-- end wizard-step -->
                        <!-- begin wizard-content -->
                        <div class="form-group">
                            <!-- begin step-1 -->
                            <div id="step-1">
                                <!-- begin fieldset -->
                                <fieldset>
                                    <!-- begin row -->
                                    <div class="row">
                                        <!-- begin col-8 -->
                                        <div class="col-md-12 col-sm-12">
                                            <!-- <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">Your Register Details </legend> -->
                                            <div class="note note-secondary mt-2" style="padding-bottom: 1px;">
                                                <p><b> Note : </b>
                                                <span>
                                                    If you want to modify register details you can make changes right now. But <span class="text-red"> you change registered email and mobile.</span> 
                                                </span></p>
                                            </div>
                                            <div class="row">    
                                                <!-- begin form-group -->
                                                <div class="col-md-3 mb-2">
                                                    <label for="register_id">Register Id</label>
                                                    <input type="text" readonly data-parsley-group="step-1" data-parsley-required="true" value="<?=$userdata->reg_id?>" name="register_id" class="form-control" required id="register_id" placeholder="Enter First Name">
                                                    <small id="register_id_error"></small>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label for="register_schoolType">Registred School Type</label>
                                                    <select name="register_schoolType" id="register_schoolType" disabled class="form-control p-0 default-select2"  required>
                                                        <?php foreach ($scltypes as $scltype){   ?>
															<option value="<?= $scltype->shortname ?>"
																<?php if($scltype->shortname == $userdata->scl_mode){ ?> selected <?php } ?> >
																<?= $scltype->name ?>
															</option>
                                                        <?php }  ?>
                                                    </select>
                                                    <small id="register_schoolType_error"></small>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label for="register_mail_id">Register eMail</label>
                                                    <input type="text" readonly data-parsley-group="step-1" data-parsley-required="true" value="<?=$userdata->mailid?>" name="register_mail_id" class="form-control" required id="register_mail_id" placeholder="Enter First Name">
                                                    <small id="register_mail_id_error"></small>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label for="registrer_Mobile">Enter Mobile Number</label>
                                                    <input type="tel" minlength="10" readonly style="width:100%;" required placeholder="Enter Mobile Number" value="<?=$userdata->mobile?>" required name="registrer_Mobile" class="form-control" id="registrer_Mobile">
                                                    <small id="registrer_Mobile_error"></small>
                                                    <span id="valid-msg" class="hide">✓ Valid</span>
                                                    <span id="error-msg" class="hide"></span>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label for="register_fname">First Name</label>
                                                    <input type="text" data-parsley-group="step-1" data-parsley-required="true" value="<?=$userdata->fname?>" name="register_fname" class="form-control" required id="register_fname" placeholder="Enter First Name">
                                                    <small id="register_fname_error"></small>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label for="register_lname">Last Name</label>
                                                    <input type="text" data-parsley-group="step-1" data-parsley-required="true" name="register_lname" value="<?=$userdata->lname?>" class="form-control" required id="register_lname" placeholder="Enter First Name">
                                                    <small id="register_lname_error"></small>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label for="register_CountryName">Select country Name <span class="text-danger">*</span></label>
                                                    <select name="register_CountryName" id="register_CountryName" class="form-control p-0 default-select2" data-parsley-group="step-1" data-parsley-required="true">
                                                        <option value="">Select country Name</option>
                                                        <?php foreach ($countries as $country){ 
                                                            if($country->id == $userdata->country_id){
                                                        ?>
                                                            <option selected value="<?= $country->id ?>"><?= $country->name ?></option>
                                                        <?php }else{ ?>
                                                            <option value="<?= $country->id ?>"><?= $country->name ?></option>
                                                        <?php } } ?>
                                                        <!-- <option value='other'> Other country </option> -->
                                                    </select>
                                                    <small id="register_CountryName_error"></small>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label for="register_StateName">Select State Name <span class="text-danger">*</span></label>
                                                    <select name="register_StateName" id="register_StateName" class="form-control p-0 default-select2" data-parsley-group="step-1" data-parsley-required="true">
                                                        <option value="">Select State Name</option>
                                                        <?php $states = $this->Model_default->selectconduction('sms_states',array('country_id'=>$userdata->country_id));
                                                            foreach($states as $state){ 
                                                            if($state->id == $userdata->state_id){
                                                            ?>
                                                            <option selected="" value="<?= $state->id ?>"><?= $state->name ?></option>
                                                        <?php }else{ ?>
                                                            <option value="<?= $state->id ?>"><?= $state->name ?></option>
                                                        <?php } }?>
                                                    </select>
                                                    <small id="register_StateName_error"></small>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label for="register_CityName">Select City / Dist Name <span class="text-danger">*</span></label>
                                                    <select name="register_CityName" id="register_CityName" class="form-control default-select2 p-0" data-parsley-group="step-1" data-parsley-required="true">
                                                        <option value="">Select City / Dist Name</option>
                                                        <?php $cities = $this->Model_default->selectconduction('sms_cities',array('state_id'=>$userdata->state_id));
                                                            foreach($cities as $city){ 
                                                            if($city->id == $userdata->city_id){
                                                            ?>
                                                            <option selected="" value="<?= $city->id ?>"><?= $city->name ?></option>
                                                        <?php }else{ ?>
                                                            <option value="<?= $city->id ?>"><?= $city->name ?></option>
                                                        <?php } }?>
                                                    </select>
                                                    <small id="register_CityName_error"></small>
                                                </div>
                                                <div class="col-md-3 mb-2">
                                                    <label for="register_Address">Enter Address</label>
                                                    <input type="text" data-parsley-group="step-1" value="<?=$userdata->address?>" data-parsley-required="true" name="register_Address" class="form-control" id="register_Address" placeholder="Enter Address">
                                                    <small id="register_Address_error"></small>
                                                </div>
                                                <!-- <div class="col-md-5 form-group">
                                                    <input type="text" required name="city" class="form-control" id="city">
                                                    <span class="bar"></span>
                                                    <label for="city">Enter city or town</label>
                                                    <small id="cityerror"></small>
                                                </div> -->
                                                <div class="col-md-3 mb-2">
                                                    <label for="register_pincode">Pincode / Zip Code</label>
                                                    <input type="text" data-parsley-group="step-1" value="<?=$userdata->pincode?>" data-parsley-required="true" name="register_pincode" placeholder="Enter Pincode / Zip Code" class="form-control" id="register_pincode">
                                                    <small id="register_pincode_error"></small>
                                                </div>
                                                <!-- <div class="col-md-3 mb-2">
                                                    <label for="register_AadhaarCard">Enter Aadhaar Number</label>                                
                                                    <input type="text" maxlength="14" data-parsley-group="step-1" data-parsley-required="true" value="<?//=$userdata->aadhaar?>" name="register_AadhaarCard" placeholder="Enter Aadhaar Number" id="register_AadhaarCard" class="form-control">
                                                    <small id="register_AadhaarCard_error"></small>
                                                </div> -->
                                                <!-- end form-group -->
                                            </div>
                                        </div>
                                        <!-- end col-8 -->
                                    </div>
                                    <!-- end row -->
                                </fieldset>
                                <!-- end fieldset -->
                            </div>
                            <!-- end step-1 -->
                            <!-- begin step-2 -->
                            <div id="step-2">
                                <?php 
                                    $regdata = $userdata;
                                    $registeron = $regdata->gbsid;
                                    if(isset($regdata->scl_mode) && $regdata->scl_mode == 'GSB'){
                                        $schooldata = $this->Model_dashboard->selectdata('sms_schoolinfo',array('reg_id'=>$registeron,'scltype'=>'GB'));
                                        $schooldata = $schooldata['0'];
                                        //print_r($schooldata);
										$branchname = $reguserdata[0]->branch_name;
                                        $schoolname = $schooldata->schoolname; 
                                    }else{
                                        $schoolname = '';
										$branchname = '';
                                    }
                                ?>
                                <!-- begin fieldset -->
                                <fieldset>
                                    <!-- begin row -->
                                    <div class="row">
                                        <!-- begin col-8 -->
                                        <div class="col-md-12">
                                            <!-- <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse">You contact info, so that we can easily reach you</legend> -->
                                            <!-- begin form-group -->
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="row">
                                                        <div class="col-md-5 form-group">
                                                            <label for="schoolname">Enter your school Name <span class="text-danger">*</span></label>
                                                            <input type="text" required name="sclname" data-parsley-group="step-2" data-parsley-required="true" class="form-control" id="schoolname" value="<?=$schoolname?>" placeholder="Enter School Name">
                                                            <small id="schoolnameerror"></small>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label for="schoolname">Enter school Display Name <span class="text-danger">*</span></label>
                                                            <input type="text" required name="scldisplayname" maxlength="25" data-parsley-group="step-2" data-parsley-required="true" class="form-control" id="schooldisplayname" value="<?=$schoolname?>" placeholder="Enter School Display Name">
                                                            <small id="schoolnameerror"></small>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label for="sclregid">School reg id by govt <span class="text-danger">*</span></label>
                                                            <input type="text" data-parsley-group="step-2" data-parsley-required="true" required name="sclregid" class="form-control" id="schoolregister_id" placeholder="Govt Register School Id">
                                                            <small id="sclregiderror"></small>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label for="Mobile">School Mobile number <span class="text-danger">*</span></label>
                                                            <input type="text" data-parsley-group="step-2" data-parsley-required="true" id="Mobile" mimlength="10" data-parsley-type="number" name="school_mobile" required class="form-control" placeholder="School Mobile Number">
                                                            <small id="sclmobileerror"></small>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label for="Sclphonenumber">School Phone number</label>
                                                            <input type="text" data-parsley-group="step-2" mimlength="10" data-parsley-type="number" name="school_phone_number" class="form-control" id="Sclphonenumber" placeholder="School Alter Phone Number">
                                                            <small id="sclphoneerror"></small>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label for="Sclmailid">Enter school Mail id <span class="text-danger">*</span></label>
                                                            <input type="email" data-parsley-group="step-2" data-parsley-required="true" required name="school_mail_id" id="Sclmailid" class="form-control" placeholder="School email id">
                                                            <small id="sclmailiderror"></small>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label for="SclbranchName">Branch Name or Area Name <span class="text-danger">*</span></label>
                                                            <input type="text" data-parsley-group="step-2" data-parsley-required="true" id="SclbranchName" required value="<?=$branchname?>" name="school_branch_name" class="form-control" placeholder="School Branch Name">
                                                            <small id="Sclbranchnameerror"></small>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label for="CountryName">Select country Name <span class="text-danger">*</span></label>
                                                            <select name="school_country_name" id="CountryName" class="form-control p-0 default-select2" data-parsley-group="step-2" data-parsley-required="true" required>
                                                                <option value="">Select Country Name</option>
                                                                <?php foreach ($countries as $country){ ?>
                                                                    <option value="<?= $country->id ?>"><?= $country->name ?></option>
                                                                <?php } ?>
                                                                <!-- <option value='other'> Other country </option> -->
                                                            </select>
                                                            <small id="selectcountryerror"></small>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label for="StateName">Select State Name <span class="text-danger">*</span></label>
                                                            <select name="school_state_name" id="StateName" class="form-control p-0 default-select2" required data-parsley-group="step-2" data-parsley-required="true" disabled="">
                                                                <option value="">Select State Name</option>
                                                            </select>
                                                            <small id="selectstateerror"></small>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label for="CityName">Select City / Dist Name <span class="text-danger">*</span></label>
                                                            <select name="school_city_name" id="CityName" class="form-control p-0 default-select2" required data-parsley-group="step-2" data-parsley-required="true" disabled="">
                                                                <option value="">Select City / Dist Name</option>
                                                            </select>
                                                            <small id="selectcityerror"></small>
                                                        </div>
                                                        <div class="col-md-5 form-group">
                                                            <label for="Scladdress">Enter School address <span class="text-danger">*</span></label>
                                                            <input type="text" data-parsley-group="step-2" data-parsley-required="true" required name="school_address" placeholder="School Address" class="form-control" id="Scladdress">
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
                                                            <input type="text" data-parsley-group="step-2" data-parsley-required="true" placeholder="Enter Pincode / Zip Code" id="Sclpincode" required name="school_pincode" class="form-control">
                                                            <small id="sclpincodeerror"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="row">
                                                        <!-- end form-group -->
                                                        <?php if($userdata->scl_mode != 'GSB'){ ?>
                                                            <!-- <div class="col-lg-4 col-md-12 mb-4">
                                                                <label for="uploadDocuments" class="text-info" style="top:-20px;font-size:12px">Reg Document copy<span class="text-warning">*</span></label>
                                                                <input type="file" id="uploadDocuments" name="school_documents" class="dropify" data-show-remove="false" required accept=".png,.jpg,.pdf,.jpeg,.doc,.docx" />
                                                            </div> -->
                                                            <div class="col-lg-12 col-md-12 justify-content-center align-items-center">
                                                                <label for="uploadLogo" class="text-info" style="top:-20px;font-size:12px">Upload Logo</label>
                                                                <input type="file" id="uploadLogo" name="school_logo" class="dropify" data-show-remove="false" accept=".png" />
                                                            </div>
                                                        <?php }else{ ?>
                                                            <!-- <input type="hidden" value="<?//=$schooldata->school_regdocuments ?>" name="school_documents"> -->
															<img src="<?= base_url($schooldata->school_logo); ?>" style="width: -webkit-fill-available;padding: 0px 15px;">
                                                            <input type="hidden" value="<?= $schooldata->school_logo ?>" name="school_logo">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12"> 
                                                    <div class="row">
                                                        <div class="col-12 form-group" style="margin-bottom:0px"><label>Select Your School Syllabus Type <span class="text-danger">*</span> : </label></div>
                                                            <?php
																foreach ($sclsyltypes as $scltype) { ?>
																	<div class="col-2 mb-0 form-group icheck-list">
																		<label>
																			<div class="checkbox checkbox-css">
																				<input type="checkbox" id="remember_checkbox" name="remember" class="custom-control-input">
																				<input type="checkbox" class="check" id="check<?= $scltype->id ?>" value="<?= $scltype->id ?>" name="school_syllabus_type[]">
																				<label for="check<?= $scltype->id ?>"><?= $scltype->type ?></label>
																			</div>
																		</label>
																	</div>
                                                            <?php } ?>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col-8 -->
                                    </div>
                                    <!-- end row -->
                                </fieldset>
                                <!-- end fieldset -->
                            </div>
                            <!-- end step-2 -->
                            <!-- begin step-3 -->
                            <div id="step-3">
                                <div class="jumbotron m-b-0 text-center">
                                    <h4 class="text-inverse">Enter registered licence key</h4>
                                    <div class="note note-secondary mt-2" style="padding-bottom: 1px;">
                                        <p><b> Note : </b>
                                        <span>
                                            Your licence Key sent to your registered Mail. <span class="text-red"> Please check your Inbox or spam.</span> 
                                        </span></p>
                                    </div>
                                    <div class="row mt-4 justify-content-center align-items-center">
                                        <div class="col-md-5 form-group">
                                            <input type="text" maxlength="19" required name="licencekey" id="Scllicencekey" class="form-control text-uppercase text-center" style="font-size: 18px;font-weight: 600;height: 45px;" placeholder="Enter Your Licence Key">
                                            <small id="scllicenceerror"></small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group justify-content-center align-items-center">
                                            <!-- <a href="<?//= base_url() ?>login/logout" class="btn btn-warning pull-left">Setup later</a> -->
                                            <input type="submit" class="btn btn-success mt-2 col-md-3" value="Submit School Details" id="submitRegisterSchoolData" style="height: 45px;font-size: 18px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end step-4 -->
                        </div>
                        <!-- end wizard-content -->
                    </div>
                    <!-- end wizard -->
                </form>
            </div>
            <!-- end login-content -->
        </div>
        <!-- end login -->
    </div>
    <!-- end page container -->
    
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?=base_url()?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <!--[if lt IE 9]>
        <script src="<?=base_url()?>assets/crossbrowserjs/html5shiv.js"></script>
        <script src="<?=base_url()?>assets/crossbrowserjs/respond.min.js"></script>
        <script src="<?=base_url()?>assets/crossbrowserjs/excanvas.min.js"></script>
    <![endif]-->
    <script src="<?=base_url()?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/js-cookie/js.cookie.js"></script>
    <script src="<?=base_url()?>assets/js/theme/default.min.js"></script>
    <script src="<?=base_url()?>assets/js/apps.min.js"></script>
    <!-- ================== END BASE JS ================== -->
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="<?=base_url()?>assets/js/demo/login-v2.demo.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/parsley/dist/parsley.js"></script>
	<script src="<?=base_url()?>assets/plugins/jquery-smart-wizard/src/js/jquery.smartWizard.js"></script>
	<script src="<?=base_url()?>assets/js/demo/form-wizards-validation.demo.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    <script src="<?=base_url()?>assets/plugins/intl-tel-input-master/build/js/intlTelInput.js"></script>
    <script src="<?=base_url()?>assets/plugins/dropify-master/dist/js/dropify.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/select2/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            //swal('+++++++++++++');
            $("#registerNewSchoolDetails").submit(function(e){
                e.preventDefault();
                // Create an FormData object 
                var form_data = new FormData(this);
                // If you want to add an extra field for the FormData
                form_data.append("CustomField", "This is some extra data, testing");
                // disabled the submit button
                $("#loader").show();
                $.ajax({
                    type: 'POST',
                    url: '<?=base_url("setup/saveschooldetails")?>',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    dataType:'json',
                    beforeSend: function(){
                        $("#submitRegisterSchoolData").prop("disabled", true);
                    },
                    success: function(dataresponce){
                        $("#loader").hide();
                        console.log(dataresponce);
                        if(dataresponce.key == 0){
                            swal({
                                title:"Sorry",
                                text: dataresponce.message,
                                type:"warning",
                            });
                            //swal("Sorry", dataresponce.message , "warning");
                        }else if(dataresponce.key == 1){
                            swal({
                                title:"success",
                                text: dataresponce.message,
                                type:"success",
                            },function() {
                                window.location.href = dataresponce.url;                
                            });
                            $("#registerNewSchoolDetails").trigger('reset');
                        }
                    },
                    faild: function(status){
                        //console.log("error : " + errordata);
                        console.log('Something went wrong', status, err);
                        $("#loader").hide();
                    }
                });

                //file type validation
                $("#uploadLogo").change(function() {
                    var file = this.files[0];
                    var imagefile = file.type;
                    var match= ["image/jpeg","image/png","image/jpg"];
                    if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
                        alert('Please select a valid image file (JPEG/JPG/PNG).');
                        $("#uploadLogo").val('');
                        return false;
                    }
                });
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $('.default-select2').select2();
        });

        $(document).ready(function() {
            App.init();
            FormWizardValidation.init();
        });
    </script>
    
    <script>
        var input = document.querySelector("#Mobile");
        var errorMsg = document.querySelector("#error-msg");
        var validMsg = document.querySelector("#valid-msg");
        
        var telInput = window.intlTelInput(input, {
            // allowDropdown: false,
            // autoHideDialCode: false,
            // autoPlaceholder: "off",
            // dropdownContainer: document.body,
            // excludeCountries: ["us"],
            // formatOnDisplay: false,
            geoIpLookup: function(callback) {
              $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
              });
            },
            // hiddenInput: "full_number",
            initialCountry: "auto",
            // localizedCountries: { 'de': 'Deutschland' },
            // nationalMode: false,
            // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
            // placeholderNumberType: "MOBILE",
            preferredCountries: ['In', 'US'],
            separateDialCode: true,
            hiddenInput: "full_phone",
            utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js'
            //"<?=base_url('assets/plugins/intl-tel-input-master/build/js/utils.js')?>",
        });

        // Error messages based on the code returned from getValidationError
        var errorMap = [ "Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        var reset = function() {
            input.classList.remove("error");
            errorMsg.innerHTML = "";
            errorMsg.classList.add("hide");
            validMsg.classList.add("hide");
        };

        // Validate on blur event
        input.addEventListener('blur', function() {
            reset();
            if(input.value.trim()){
                if(telInput.isValidNumber()){
                    validMsg.classList.remove("hide");
                    /* get code here*/
                    //alert(input);
                }else{
                    input.classList.add("error");
                    var errorCode = telInput.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("hide");
                }
            }
        });       
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            /* regexp checkdata */
            var name = /^[A-Za-z\s]*$/;
            var regex = new RegExp(name);
            var number =  /^[0-9]+$/;
            var regexnum = new RegExp(number);
            var email = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            var regezem = new RegExp(email);
            var carddetails = /^(?:\\d{4})|\d{4}-\d{4}$/;
            var regaad = new RegExp(carddetails);
            var tincard = /^[A-Za-z\s\0-9]+$/
            var regextin = new RegExp(tincard);
            //school name
            $("#schoolname").keyup(function(event) {
                /* Act on the event */
                var sclname = $(this).val();
                if(sclname === '' ){
                    $("#schoolnameerror").text('Enter your school name').css('color', 'red');
                }else if(!regex.test(sclname)){
                    $("#schoolnameerror").text('School name should be charters only..!').css('color', 'red');
                }else if(sclname != ''){
                    $("#schoolnameerror").text('');
                }
            });

            $("#SclbranchName").keyup(function(event) {
                /* Act on the event */
                var sclname = $(this).val();
                if(sclname === '' ){
                    $("#Sclbranchnameerror").text('Enter your Branch name or area name').css('color', 'red');
                }else if(!regex.test(sclname)){
                    $("#Sclbranchnameerror").text('branch Name should be charters only..!').css('color', 'red');
                }else if(sclname != ''){
                    $("#Sclbranchnameerror").text('');
                }
            });

            //school register id
            $("#sclregid").keyup(function(event) {
                /* Act on the event */
                var regsclid = $(this).val();
                if(regsclid === '' ){
                    $("#sclregiderror").text('Enter school register id by govt').css('color', 'red');
                }else if(!regextin.test(regsclid)){
                    $("#sclregiderror").text('Enter valied register id..!').css('color', 'red');
                }else if(regsclid != ''){
                    $("#sclregiderror").text('');
                }
            });

            //mobile number
            $("#Sclmobile").keyup(function(event) {
                /* Act on the event */
                var mobileno = $(this).val();
                if(mobileno === '' ){
                    $("#sclmobileerror").text('Enter Mobile number').css('color', 'red');
                }else if(!regexnum.test(mobileno)){
                    $("#sclmobileerror").text('Enter valied mobile number..!').css('color', 'red');
                }else if(mobileno.length != 10){
                    $("#sclmobileerror").text('Mobile should be 10 numbers..').css('color', 'red');
                }else if(mobileno != ''){
                    $("#sclmobileerror").text('');
                }
            });

            //phone number
            $("#Sclphonenumber").keyup(function(event) {
                /* Act on the event */
                var phoneno = $(this).val();
                if(phoneno === '' ){
                    //$("#sclphoneerror").text('Enter Mobile number').css('color', 'red');
                }else if(!regexnum.test(phoneno)){
                    $("#sclphoneerror").text('Enter valied phone number..!').css('color', 'red');
                }else if(phoneno.length < 10){
                    $("#sclphoneerror").text('Phone number should be max 10 numbers..').css('color', 'red');
                }else{
                    $("#sclphoneerror").text('');
                }
            });

            //mail id
            $("#Sclmailid").on('keyup',function () {
                var mailid   =   $(this).val();
                if(mailid === '' ){
                    $("#sclmailiderror").text('Enter your email id..!').css('color', 'red');
                }else if(!regezem.test(mailid)){
                    $("#sclmailiderror").text('Enter valid email id..!').css('color', 'red');
                }else if(mailid != ''){
                    $("#sclmailiderror").text('');
                }
            });

            //school pincode
            $("#Sclpincode").on('keyup',function () {
                var pincode   =   $(this).val();
                if(pincode === '' ){
                    $("#sclpincodeerror").text('Enter pincode number..!').css('color', 'red');
                }else if(!tincard.test(pincode)){
                    $("#sclpincodeerror").text('Enter valid pincode..!').css('color', 'red');
                }else if(pincode != ''){
                    $("#sclpincodeerror").text('');
                }
            });

            //school address
            $("#Scladdress").on('keyup',function () {
                var address   =   $(this).val();
                if(address == '' ){
                    $("#scladdresserror").text('Enter school Address..!').css('color', 'red');
                }else if(address != ''){
                    $("#scladdresserror").text('');
                }
            });

            //school city
            $("#Sclcity").on('keyup',function () {
                var city   =   $(this).val();
                if(city == '' ){
                    $("#sclcityerror").text('Enter City or town name..!').css('color', 'red');
                }else if(city != ''){
                    $("#sclcityerror").text('');
                }
            });

            $("#CountryName").change(function(event) {
                if($(this).val() == ''){
                    $(this).focus();
                    $("#selectcountryerror").text("Please select country name").css('color', 'red');
                }else{
                    $("#selectcountryerror").text("");
                }
            });

            $("#StateName").change(function(event) {
                if($(this).val() == ''){
                    $(this).focus();
                    $("#selectstateerror").text("Please select State Name").css('color', 'red');
                }else{
                    $("#selectstateerror").text("");
                }
            });

            $("#CityName").change(function(event) {
                if($(this).val() == ''){
                    $(this).focus();
                    $("#selectcityerror").text("Select city / dist name").css('color', 'red');
                }else{
                    $("#selectcityerror").text("");
                }
            });

            $("#submitRegisterSchoolData").hide();
            //licence key
            $('#Scllicencekey').keyup(function() {
                var foo = $(this).val().split("-").join(""); // remove hyphens
                if (foo.length > 0) {
                    foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
                }
                $(this).val(foo);
                var licencekey = $(this).val();
                if(licencekey != ""){
                // console.log(licencekey);
                    $('#scllicenceerror').text('');
                    $.ajax({
                        url: '<?= base_url() ?>setup/licencevalidate',
                        type: 'POST',
                        dataType: 'json',
                        data: {licencekeycode: licencekey},
                    })
                    .done(function(dataresponce) {
                        //console.log(dataresponce);
                        if(dataresponce.key == 0){
                            $("#scllicenceerror").text(dataresponce.message).css('color', 'red');
                            $("#submitRegisterSchoolData").hide();
                        }else if(dataresponce.key == 1){
                            $("#scllicenceerror").text(dataresponce.message).css('color', 'green');
                            $("#Scllicencekey").css('color', 'green');
                            $("#submitRegisterSchoolData").show();
                        }
                    })
                    .fail(function(errordata) {
                        console.log(errordata);
                        $("#submitRegisterSchoolData").hide();
                    })
                }else if(licencekey == ""){
                    $('#scllicenceerror').text('Enter Registered licence key..!').css('color', 'red');
                }
            });
        });

        $(document).ready(function(){
            //country to state
            $("#CountryName").change(function(){
                var CountryName = $(this).val();
                if(CountryName == ""){
                    $("#selectcountryerror").text("please select country name").css('color', 'red');
                    $("#StateName").prop('disabled','true');
                    $("#CountryName").focus();
                }else{
                    $("#selectcountryerror").text("");
                    $.ajax({
                        url: '<?= base_url() ?>defaultmethods/stateslist',
                        type: 'POST',
                        dataType: 'json',
                        data: {Countryid: CountryName},
                    })
                    .done(function(responcedata) {
                        console.log(responcedata);
                        $('#StateName').empty();
                        $("#StateName").removeAttr('disabled');
                        $("#StateName").append("<option value=''>Select State Name</option>");
                        for(var sl = 0;responcedata.length >= sl;sl++){
                            $("#StateName").append("<option value='"+ responcedata[sl].id +"'>"+ responcedata[sl].name +"</option>");
                        }
                        //$("#StateName").append("<option value='other'> Other State </option>");
                    })
                    .fail(function(req, status, err) {
                        console.log('Something went wrong', status, err);
                        $("#loader").hide();
                    }) 
                    
                }
            })
            //state to city or dist
            $("#StateName").change(function(){
                var StateName = $(this).val();
                if(StateName == ""){
                    $("#selectstateerror").text("please select state name").css('color', 'red');
                    $("#CityName").prop('disabled','true');
                    $("#StateName").focus();
                }else{
                    $("#selectstateerror").text("");
                    $.ajax({
                        url: '<?= base_url() ?>defaultmethods/citieslist',
                        type: 'POST',
                        dataType: 'json',
                        data: {Stateid: StateName},
                    })
                    .done(function(responcedata) {
                        //console.log(responcedata);
                        $('#CityName').empty();
                        $("#CityName").removeAttr('disabled');
                        $("#CityName").append("<option value=''>Select City Name</option>");
                        for(var sl = 0;responcedata.length >= sl;sl++){
                            $("#CityName").append("<option value='"+ responcedata[sl].id +"'>"+ responcedata[sl].name +"</option>");
                        }
                        //$("#CityName").append("<option value='other'> Other City / Dist </option>");
                        
                    })
                    .fail(function(req, status, err) {
                        //console.log("error : " + errordata);
                        console.log('Something went wrong', status, err);
                        $("#loader").hide();
                    }) 
                    
                }
            })

            //Register country to state
            $("#register_CountryName").change(function(){
                var CountryName = $(this).val();
                if(CountryName == ""){
                    $("#register_CountryName_error").text("please select country name").css('color', 'red');
                    $("#register_StateName").prop('disabled','true');
                    $("#register_CountryName").focus();
                }else{
                    $("#register_CountryName_error").text("");
                    $.ajax({
                        url: '<?= base_url() ?>defaultmethods/stateslist',
                        type: 'POST',
                        dataType: 'json',
                        data: {Countryid: CountryName},
                    })
                    .done(function(responcedata) {
                        console.log(responcedata);
                        $('#register_StateName').empty();
                        $("#register_StateName").removeAttr('disabled');
                        $("#register_StateName").append("<option value=''>Select State Name</option>");
                        for(var sl = 0;responcedata.length >= sl;sl++){
                            $("#register_StateName").append("<option value='"+ responcedata[sl].id +"'>"+ responcedata[sl].name +"</option>");
                        }
                        //$("#StateName").append("<option value='other'> Other State </option>");
                    })
                    .fail(function(req, status, err) {
                        console.log('Something went wrong', status, err);
                        $("#loader").hide();
                    }) 
                    
                }
            })
            //Register state to city or dist
            $("#register_StateName").change(function(){
                var StateName = $(this).val();
                if(StateName == ""){
                    $("#register_StateName_error").text("please select state name").css('color', 'red');
                    $("#register_CityName").prop('disabled','true');
                    $("#register_StateName").focus();
                }else{
                    $("#register_StateName_error").text("");
                    $.ajax({
                        url: '<?= base_url() ?>defaultmethods/citieslist',
                        type: 'POST',
                        dataType: 'json',
                        data: {Stateid: StateName},
                    })
                    .done(function(responcedata) {
                        //console.log(responcedata);
                        $('#register_CityName').empty();
                        $("#register_CityName").removeAttr('disabled');
                        $("#register_CityName").append("<option value=''>Select City Name</option>");
                        for(var sl = 0;responcedata.length >= sl;sl++){
                            $("#register_CityName").append("<option value='"+ responcedata[sl].id +"'>"+ responcedata[sl].name +"</option>");
                        }
                    })
                    .fail(function(req, status, err) {
                        //console.log("error : " + errordata);
                        console.log('Something went wrong', status, err);
                        $("#loader").hide();
                    }) 
                    
                }
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            // Basic
            $('.dropify').dropify();

            // Translated
            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez',
                    replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                    remove: 'Supprimer',
                    error: 'Désolé, le fichier trop volumineux'
                }
            });

            // Used events
            var drEvent = $('#input-file-events').dropify();

            drEvent.on('dropify.beforeClear', function(event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });

            drEvent.on('dropify.afterClear', function(event, element) {
                alert('File deleted');
            });

            drEvent.on('dropify.errors', function(event, element) {
                console.log('Has Errors');
            });

            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function(e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                } else {
                    drDestroy.init();
                }
            })
        });
    </script>
</body>
</html>
