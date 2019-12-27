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
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/plugins/animate/animate.min.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/css/default/style.min.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/css/default/style-responsive.min.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
	<!-- ================== END BASE CSS STYLE ================== -->

	<!-- ================== BEGIN PAGE CSS STYLE ================== -->
	<link href="<?=base_url()?>assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
	<link href="<?=base_url()?>assets/plugins/bootstrap-wysihtml5/src/bootstrap3-wysihtml5.css" rel="stylesheet" />
	<!-- ================== END PAGE CSS STYLE ================== -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/dropify-master/dist/css/dropify.min.css">
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?=base_url()?>assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
	<script src="<?=base_url()?>assets/plugins/jquery/jquery-3.3.1.min.js"></script>
	<script src="<?=base_url()?>assets/plugins/ckeditor/ckeditor.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css">
	<link href="<?=base_url()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
	<script src="<?=base_url()?>assets/plugins/gritter/js/jquery.gritter.js"></script>
	<style>
		.intl-tel-input{
			width:100%;
		}
		.form-control{
			border: 1px solid #d2c9c9 !important;
		}
		.form-group label{
			color: #000000;
		}
		.text-black{
			color: #000000;
		}
		table.dataTable thead .sorting:after,table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting_desc:after {
			content:none;
		}
		.customalert{
			width: max-content;
			z-index: 11111111111;
			position: absolute;
			border-radius: 0px;
			right: 5px;
			top: 75px;
		}
		.text-red{
			color:red !important;
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
		.vh-100 {
			min-height: 100vh;
		}
		.fa-dx{
			font-size: 16px;
		}
		.profileImage {
			width: 25px;
			height: 25px;
			border-radius: 50%;
			background: #512DA8;
			font-size: 12px;
			color: #fff;
			text-align: center;
			line-height: 26px;
			/* margin: 20px 0; */
		}
		.profileImage_pic,#profileImage_pic{
			border-radius: 50%;
			background: #512DA8;
			font-size: 12px;
			color: #fff;
			text-align: center;
			padding: 5px;
		}

		.dropify-wrapper{
			height: 35px !important;
			font-size:15px !important;
			width: 170px !important;
		}
		.dropify-message{
			padding-bottom: 8px;
		}
		.dropify-wrapper .dropify-message span.fas {
			font-size: 18px;
			float: left;
			padding: 0px;
			margin: -5px 8px;
		}
		.dropify-wrapper .dropify-message .default_message{
			margin: 5px 0 0 !important;
			float: left;
			font-size: 12px;
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
		.list-email .email-time {
			padding: 19px 0px !important;
			font-size: 12px;
			width: fit-content;
		}
		.list-email .email-time {
			padding: 20px 20px !important;
			font-size: 10px;
			width: fit-content;
		}
	</style>
</head>
<body>
<?php
if(isset($this->session->userdata['__ci_last_regenerate'])){
	$sessiondata = $this->session->userdata;
	//echo "<pre>"; print_r($sessiondata); echo "</pre>";
}else{
	$this->session->sess_destroy ();
	redirect (base_url());
}
?>

<?php function gluttarNotification($title='',$text = NULL,$image = NULL){ ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$.gritter.add({
				title:"<?=$title?>",
				text:"<?=$text?>",
				<?php if($image != ''){ ?>
				image:"<?=$image?>", //assets/img/user/user-12.jpg
				<?php } ?>
				sticky:false,
				time:'',
				//fade_in_speed: 100,
				//fade_out_speed: 100,
				class_name:"my-sticky-class"
			});
			return false;
		});
	</script>
<?php } ?>
<?php if($this->session->flashdata('error')){
	gluttarNotification($this->session->flashdata('error'),$this->session->flashdata('text'),$this->session->flashdata('image'));
}else if($this->session->flashdata('success')){
	gluttarNotification($this->session->flashdata('success'),$this->session->flashdata('text'),$this->session->flashdata('image'));
} ?>
<!-- begin #page-loader -->
<div id="page-loader" class="fade show"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed page-content-full-height">

	<!-- begin #header -->
	<div id="header" class="header navbar-default">
		<!-- begin navbar-header -->
		<div class="navbar-header">
			<a href="index.html" class="navbar-brand"><span class="navbar-logo"></span>
				<b class="hidden-sm hidden-xs visible-md-block visible-lg-block">
					<?= strtoupper($sessiondata['school']->schoolname); ?></b>
				<b class="visible-xs-block visible-sm-block hidden-md hidden-lg">
					<?php if(empty($sessiondata['school']->displayname)){ echo "Dashboard"; }else{ echo strtoupper($sessiondata['school']->displayname); } ?></b>
			</a>
			<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<!-- end navbar-header -->

		<!-- begin header-nav -->
		<ul class="navbar-nav navbar-right">

			<li>
				<form class="navbar-form" method="post" action="#">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search mail.." />
						<button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
					</div>
				</form>
			</li>
			

			<li class="dropdown">
				<a href="javascript:;" data-toggle="dropdown" id="CountNotification" class="dropdown-toggle f-s-14">
					<script>
						$(document).ready(function(){
							function NotificatioDatajax(){
								$.get("<?=base_url('user/mail/notificationscountlist')?>", function(data, status){
									//alert("Data: " + data + "\nStatus: " + status);
									$("#CountNotification").html(data);
								});
							}
							NotificatioDatajax();
							setInterval(function() {
								NotificatioDatajax();
							},2500);
						});
					</script>
				</a>
				<ul class="dropdown-menu media-list dropdown-menu-right" id="NotificationData"></ul>
				<script>
					$(document).ready(function(){
						function NotificatioDatajax(){
							$.get("<?=base_url('user/mail/notifications')?>", function(data, status){
								//alert("Data: " + data + "\nStatus: " + status);
								$("#NotificationData").html(data);
							});
						}
						NotificatioDatajax();
						setInterval(function() {
							NotificatioDatajax();
						},2500);
					});
				</script>

			</li>

			<li class="dropdown navbar-user">

				<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
					<?php
					if(isset($userdata->profile_pic)){
						$profile_image = $userdata->profile_pic;
					}else if(isset($userdata->student_image)){
						$profile_image = $userdata->student_image;
					}elseif(isset($userdata->employee_pic)){ $profile_image = $userdata->employee_pic; }

					if(isset($userdata->fname)){ $fname = $userdata->fname;$lname = $userdata->lname; }else{ $fname = $userdata->firstname;$lname = $userdata->lastname; }
					?>
					<script>
						$(document).ready(function(){
							var PfirstName = '<?=$fname?>';
							var PlastName = '<?=$lname?>';
							var intials = PfirstName.charAt(0) + PlastName.charAt(0);
							var PprofileImage = $('#profileImage_pic').text(intials);
						});
					</script>
					<?php if(!empty($profile_image)){ ?>
						<img src="<?=base_url($profile_image)?>">
					<?php }else{ ?>
						<span id="profileImage_pic" class="profileImage_pic text-uppercase"></span>
					<?php } ?>
					<!--                    <img src="--><?//=base_url()?><!--assets/img/user/user-13.jpg" alt="" />-->
					<span class="d-none d-md-inline text-capitalize">
                        <?php if(isset($userdata->fname)){ echo $userdata->fname; }else{ echo $userdata->firstname; } ?>
                    </span> <b class="caret"></b>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<a href="<?= base_url() ?>logout" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
				</div>
			</li>
		</ul>
		<!-- end header navigation right -->
	</div>
	<!-- end #header -->

    <?php include 'menu_mail.php'; ?>
