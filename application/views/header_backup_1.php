<?php
//error_reporting(0);
// server should keep session data for AT LEAST 1 hour
//ini_set('session.gc_maxlifetime', 43200);
// each client should remember their session id for EXACTLY 1 hour
// session_set_cookie_params(43200);
// session_start();
// exit();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title><?= $PageTitle ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/animate/animate.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/default/style-responsive.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/default/style.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
    <script src="<?=base_url()?>assets/plugins/jquery/jquery-3.3.1.min.js"></script>
    <!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
    <link href="<?=base_url()?>assets/plugins/jquery-jvectormap/jquery-jvectormap.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/nvd3/build/nv.d3.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/bootstrap-wysihtml5/dist/bootstrap3-wysihtml5.min.css" rel="stylesheet" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <!-- ================== END PAGE LEVEL CSS STYLE ================== -->
    <link href="<?=base_url()?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?=base_url()?>assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="<?=base_url()?>assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link href="<?=base_url()?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
    <!-- ================== END PAGE LEVEL STYLE ================== -->
    <script type="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js"></script>
    <link href="<?=base_url()?>assets/plugins/superbox/css/superbox.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/lity/dist/lity.min.css" rel="stylesheet" />
    <script src="<?=base_url()?>assets/plugins/ckeditor/ckeditor.js"></script>
    <script src="<?=base_url()?>assets/plugins/bootstrap-wysihtml5/dist/bootstrap3-wysihtml5.all.min.js"></script>
    <script src="<?=base_url()?>assets/js/demo/form-wysiwyg.demo.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="<?= base_url() ?>assets/css/sweetalert.min.css" rel="stylesheet">
    <script src="<?= base_url() ?>assets/js/sweetalert.min.js"></script>
    <script src="<?= base_url() ?>assets/js/angular.min.js"></script>
    <link href="<?=base_url()?>assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/intl-tel-input-master/build/css/intlTelInput.css">
    <link href="<?=base_url()?>assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/dropify-master/dist/css/dropify.min.css">
    <link href="<?=base_url()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <script src="<?=base_url()?>assets/plugins/gritter/js/jquery.gritter.js"></script>
    <link rel="stylesheet" href="https://seantheme.com/color-admin-v4.3/admin/assets/plugins/bootstrap-datepicker/css/less/datepicker3.less" type="text/html">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.css">
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
		.select2{
			width: 100% !important;
		}
        .select2-container--default .select2-selection--single {
            border: 1px solid #d9d9d9 !important;
            padding: 0px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
        .select2-selection__clear{ display: none !important;}
    </style>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="<?= base_url()?>assets/js/micustom.js"></script>
    <script src="<?= base_url()?>assets/js/myscript.js"></script>
</head>
<body>
<!-- begin page-cover -->
<div class="page-cover"></div>
<!-- end page-cover -->
<div class="loader" id="loader" style="display:none">
    <center>
        <img src="<?= base_url() ?>assets/images/loader.gif">
    </center>
</div>
<div class="loader" id="paymenymentloader" style="display:none">
    <center>
        <img src="<?=base_url('assets/images/payment_gif_icon.gif')?>">
    </center>
</div>
<!-- begin #page-loader -->
<div id="page-loader" class="fade show"><span class="spinner"></span></div>
<!-- end #page-loader -->
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
<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
    <!-- begin #header -->
    <div id="header" class="header navbar-default">
        <!-- begin navbar-header -->
        <div class="navbar-header">
            <a href="<?=base_url()?>" class="navbar-brand"><span class="navbar-logo"></span>
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
            <?php if(isset($this->session->userdata['type']) && $this->session->userdata['type'] != 'student' && $this->session->userdata['type'] != 'teacher' && $this->session->userdata['type'] != 'classteacher' && $this->session->userdata['type'] != 'accountant'){ ?>
				<li class="hidden-sm hidden-xs visible-md-block visible-lg-block" style="display: none"><a href="#"><i class="fas fa-qrcode" data-toggle="tooltip" title="Search With QRcode."></i></a></li>
				<li>
					<form class="navbar-form" method="post" action="<?=base_url('dashboard/data/searchResult?search=yes')?>">
						<div class="form-group">
							<input type="text" class="form-control" name="search_name" placeholder="Search with Register Id or Mail or Mobile" />
							<button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
						</div>
					</form>
				</li>
            <?php } ?>
            <li class="dropdown">
				<a href="javascript:;" data-toggle="dropdown" id="CountNotification" class="dropdown-toggle f-s-14">
					<script>
						$(document).ready(function(){
							function NotificatioDatajax(){
								$.get("<?=base_url('all/notification/datacountlist')?>", function(data, status){
									//alert("Data: " + data + "\nStatus: " + status);
									$("#CountNotification").html(data);
								});
							}
							NotificatioDatajax();
							setInterval(function() {
								NotificatioDatajax();
							},1000);
						});
					</script>
				</a>
				<ul class="dropdown-menu media-list dropdown-menu-right" id="NotificationData"></ul>
                <script>
					$(document).ready(function(){
						function NotificatioDatajax(){
							$.get("<?=base_url('all/notification/datalist')?>", function(data, status){
								//alert("Data: " + data + "\nStatus: " + status);
								$("#NotificationData").html(data);
							});
						}
						//NotificatioDatajax();
						setInterval(function() {
							NotificatioDatajax();
						},1000);
					});
				</script>

            </li>

            <li class="dropdown navbar-user">

                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <?php 
                        
                        if(isset($userdata->profile_pic)){
                            $profile_image = $userdata->profile_pic;
                        }else if(isset($userdata->student_image)){
                            $profile_image = $userdata->profile;
                        }elseif(isset($userdata->employee_pic)){ 
                            $profile_image = $userdata->profile; 
                        }

                                  
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
					<?php if(isset($this->session->userdata['type']) && !empty($this->session->userdata['type'])){
							$profiletype = $this->session->userdata['type']; ?>
						<a href="<?=base_url($profiletype.'/profile')?>" class="dropdown-item">Profile</a>
						<a href="<?=base_url($profiletype.'/academiccalendar')?>" class="dropdown-item hide">Calendar</a>
					<?php } ?>
                    <a href="<?=base_url('user/mail/inbox')?>" target="_blank" class="dropdown-item"> Inbox</a>
                    <div class="dropdown-divider"></div>
                    <a href="<?= base_url() ?>logout" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                </div>
            </li>
        </ul>
        <!-- end header navigation right -->
    </div>
    <!-- end #header -->

    <!-- begin #sidebar -->
    <?php include 'menu.php'; ?>
    <!-- end #sidebar -->
