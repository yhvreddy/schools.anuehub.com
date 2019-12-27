<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- Mirrored from seantheme.com/color-admin-v4.2/admin/html/form_wizards_validation.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 23 Jan 2019 09:08:38 GMT -->
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
	<link href="<?=base_url()?>assets/plugins/font-awesome/5.3/css/all.min.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/plugins/animate/animate.min.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/css/default/style.min.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/css/default/style-responsive.min.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="<?=base_url()?>assets/plugins/jquery-smart-wizard/src/css/smart_wizard.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<link href="<?=base_url()?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/intl-tel-input-master/build/css/intlTelInput.css">
    <script src="<?=base_url()?>assets/plugins/pace/pace.min.js"></script>
    <link href="<?=base_url()?>assets/plugins/jquery-smart-wizard/src/css/smart_wizard.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/dropify-master/dist/css/dropify.min.css">
    <script src="<?=base_url()?>assets/plugins/jquery/jquery-3.3.1.min.js"></script>
	<script src="<?= base_url() ?>assets/js/angular.min.js"></script>
	<link href="<?= base_url() ?>assets/css/sweetalert.min.css" rel="stylesheet">
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
<body>
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
	<!-- begin #page-container -->
	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<div id="header" class="header navbar-default">
			<!-- begin navbar-header -->
			<div class="navbar-header">
				<a href="index.html" class="navbar-brand"><span class="navbar-logo"></span> <b><?=$schooldetails[0]->schoolname?></b></a>
				<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<!-- end navbar-header -->
			
			<!-- begin header-nav -->
			<ul class="navbar-nav navbar-right">
				<li class="dropdown navbar-user">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?=base_url()?>assets/img/user/user-13.jpg" alt="" /> 
						<span class="d-none d-md-inline text-capitalize"><?=$userdata[0]->fname?></span> <b class="caret"></b>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a href="<?=base_url('logout')?>" class="dropdown-item">Log Out</a>
					</div>
				</li>
			</ul>
			<!-- end header navigation right -->
		</div>
		<!-- end #header -->
        
		<!-- begin #content -->
		<div class="col-md-12 mt-5">
            <div class="row justify-content-center align-items-center">
			<!-- begin wizard-form -->
			<form action="javascript:;" id="schoolacademicyear" method="POST" name="form-wizard" class="form-control-with-bg col-md-8 mt-5">
				<input type="hidden" value="<?=$schooldetails[0]->school_id?>" name="school_id">
				<input type="hidden" value="<?=$schooldetails[0]->branch_id?>" name="branch_id">
				<!-- begin wizard -->
				<div id="wizard">
					<!-- begin wizard-step -->
					<ul>
						<li class="col-md-12 col-sm-12 col-12">
							<a href="#step-1">
								<span class="info text-ellipsis text-center">
									Start Your School Academic Year
									<!-- <small class="text-ellipsis">Set school academic year</small> -->
								</span>
							</a>
						</li>
					</ul>
					<!-- end wizard-step -->
					<!-- begin wizard-content -->
					<div>
						<!-- begin step-1 -->
						<div id="step-1">
							<!-- begin fieldset -->
							<fieldset>
								<!-- begin row -->
								<div class="row">
									<!-- begin col-8 -->
									<div class="col-md-8 offset-md-2">
										<legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse text-center">Start Academic Year</legend>
										<!-- begin form-group -->
										<div class="form-group row m-b-10">
											<div class="col-md-12">
												<div class="row row-space-6">
													<div class="col-md-6">
														<div class="row">
															<div class="col-6">
																<select class="form-control default-select2" data-parsley-group="step-1" data-parsley-required="true" name="start_year">
																	<option value="">Starting Year</option>
																	<?php 
																		$year = date('Y');
																		$min = $year - 60;
																		$max = $year;
																		for( $i=$max; $i>=$min; $i-- ) {
																			if($year == $i){
																				echo '<option selected value='.$i.'>'.$i.'</option>';
																			}else{
																				echo '<option value='.$i.'>'.$i.'</option>';
																			}
																		}
																	?>
																</select>
															</div>
															<div class="col-6">
																<select class="form-control default-select2" name="start_month">
																	<option value="">Starting Month</option>
																	<?php for( $m=1; $m<=12; ++$m ) { 
																		$month_label = date('F', mktime(0, 0, 0, $m, 1));
																		?>
																		<option value="<?php echo $m; ?>"><?php echo $month_label; ?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="row">
															<div class="col-6">
																<select class="form-control default-select2" data-parsley-group="step-1" data-parsley-required="true" name="end_year">
																	<option value="">Ending Year</option>
																	<?php 
																		$year = date('Y');
																		$min = $year - 60;
																		$max = date('Y',strtotime('+1year'));
																		for( $i=$max; $i>=$min; $i-- ) {
																			if($max == $i){
																				echo '<option selected value='.$i.'>'.$i.'</option>';
																			}else{
																				echo '<option value='.$i.'>'.$i.'</option>';
																			}
																		}
																	?>
																</select>
															</div>
															<div class="col-6">
																<select class="form-control default-select2" name="end_month">
																	<option value="">Ending Month</option>
																	<?php for( $m=1; $m<=12; ++$m ) { 
																		$month_label = date('F', mktime(0, 0, 0, $m, 1));
																		?>
																		<option value="<?php echo $m; ?>"><?php echo $month_label; ?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
													</div>
													<div class="col-md-12">
														<div class="row mt-5 justify-content-center align-items-center">
															<input type="submit" value="Start School Academic Year" name="start_acdemic" class="btn btn-primary">
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- end form-group -->
									</div>
									<!-- end col-8 -->
								</div>
								<!-- end row -->
							</fieldset>
							<!-- end fieldset -->
						</div>
						<!-- end step-1 -->
						
					</div>
					<!-- end wizard-content -->
				</div>
				<!-- end wizard -->
			</form>
            <!-- end wizard-form -->
            </div>
		</div>
		<!-- end #content -->
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
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
	<script src="<?=base_url()?>assets/plugins/select2/dist/js/select2.min.js"></script>
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="<?=base_url()?>assets/plugins/parsley/dist/parsley.js"></script>
	<script src="<?=base_url()?>assets/plugins/jquery-smart-wizard/src/js/jquery.smartWizard.js"></script>
	<script src="<?=base_url()?>assets/js/demo/form-wizards-validation.demo.min.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			App.init();
			FormWizardValidation.init();
		});
		$(document).ready(function() {
            $('.default-select2').select2();
        });
		$(document).ready(function(){
			$("#schoolacademicyear").submit(function(e){
				e.preventDefault();
				if(confirm('Are you want to start your academic year.')){
					//alert("Ok");
					$("#loader").show();
					// Create an FormData object 
					var form_data = new FormData(this);
					// If you want to add an extra field for the FormData
					form_data.append("CustomField", "This is some extra data, testing");
					// disabled the submit button
					$("#loader").show();
					$.ajax({
						type: 'POST',
						url: '<?=base_url("setup/saveschoolacademicdetails")?>',
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
									//window.location.href = dataresponce.url;
									// Your application has indicated there's an error
									$("#loader").show();
									window.setTimeout(function(){
										// Move to a new location or you can do something else
										window.location.href = dataresponce.url;
									}, 5000);                
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
				}else{
					alert("Cancel");
				}
			})
		});
	</script>
</body>
</html>