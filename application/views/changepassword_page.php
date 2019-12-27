
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title><?=$pageTitle?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/plugins/font-awesome/5.3/css/all.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/default/style.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/default/style-responsive.min.css" rel="stylesheet" />
    <link href="<?=base_url()?>assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?=base_url()?>assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
    <style>
        .customalert{
            width: max-content;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1111111111;
        }
    </style>
</head>
<body class="pace-top">
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
    <div class="login-cover-image" style="background-image: url(<?=base_url()?>assets/img/login-bg/login-bg-16.jpg)" data-id="login-cover-image"></div>
    <div class="login-cover-bg"></div>
</div>

<!-- begin #page-container -->
<div id="page-container" class="fade">
    <!-- begin login -->
    <div class="login login-v2" data-pageload-addclass="animated fadeIn">
        <!-- begin brand -->
        <div class="login-header">
            <div class="brand">
                <span class="logo"></span> <b>Change </b> Password
                <small>Change Forget Password..!</small>
            </div>
            <div class="icon">
                <i class="fa fa-lock"></i>
            </div>
        </div>
        <!-- end brand -->
        <!-- begin login-content -->
        <div class="login-content">
            <form action="<?= base_url('users/savenewchangepassword') ?>" method="POST" class="margin-bottom-0">
                <input type="hidden" name="sno_id" value="<?=$sno_id?>">
                <input type="hidden" name="mail_id" value="<?=$mail_id?>">
                <input type="hidden" name="id_num" value="<?=$id_num?>">
				<input type="hidden" name="token_id" value="<?=$token_id?>">
                <div class="form-group m-b-20">
                    <input type="password" class="form-control form-control-lg" placeholder="Enter New Password" required  id="new_password" name="new_password" autofocus="autofocus" value="">
                </div>

                <div class="form-group m-b-20">
                    <input type="password" class="form-control form-control-lg" placeholder="Enter confirm Password" required  id="confirm_password" name="confirm_password" autofocus="autofocus" value="">
                </div>

                <div class="login-buttons">
                    <button type="submit" class="btn btn-success btn-block btn-lg">Change Password</button>
                </div>

				<div class="m-t-5">
					<span class="pull-left">Login my account <a href="<?=base_url()?>"> Click here</a>.!</span>
				</div>
            </form>
        </div>
        <!-- end login-content -->
    </div>
    <!-- end login -->
</div>
<!-- end page container -->
<!-- ================== BEGIN BASE JS ================== -->
<script src="<?=base_url()?>assets/plugins/jquery/jquery-3.3.1.min.js"></script>
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
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        LoginV2.init();
    });
</script>
</body>
</html>
