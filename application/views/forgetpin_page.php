
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
        <div class="login-cover-image" style="background-image: url(<?=base_url()?>assets/images/background.jpg)" data-id="login-cover-image"></div>
        <div class="login-cover-bg"></div>
    </div>
    
    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login login-v2" data-pageload-addclass="animated fadeIn">
            <!-- begin brand -->
            <div class="login-header">
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
            <div class="login-content">
				<h4 class="text-center text-white">Forget 4 digits pin</h4>
                <form action="<?= base_url('users/save/forgetpin/request') ?>" method="POST" class="margin-bottom-0">
                    <div class="form-group m-b-20">
						<label>Enter Regster Mail id</label>
                        <input type="email" class="form-control form-control-lg" placeholder="Please enter register email id" required  id="reg_email" name="reg_email" autofocus="autofocus" value="">
                    </div>
                    <!--<div class="checkbox checkbox-css m-b-20">
                        <input type="checkbox" id="remember_checkbox" name="remember" class="custom-control-input">
                        <label for="remember_checkbox">
                            Remember Me
                        </label>
                    </div>-->
					<div class="m-t-20 mb-5">
						<span class="pull-left">Login my account <a href="<?=base_url()?>"> Click here</a>.!</span>
						<span class="pull-right">Forget password..?  <a href="<?=base_url('users/forgetpassword')?>"> Click here</a>.!</span>
					</div>
					<div class="login-buttons">
                        <button type="submit" class="btn btn-success btn-block btn-lg">Reset 4-digits Pin</button>
                    </div>

                </form>
            </div>
            <!-- end login-content -->
        </div>
        <!-- end login -->
    </div>
    <!-- end page container -->
    
    <!-- <ul class="login-bg-list clearfix">
        <li class="active"><a href="javascript:;" data-click="change-bg" data-img="<?=base_url()?>assets/img/login-bg/login-bg-17.jpg" style="background-image: url(<?=base_url()?>assets/img/login-bg/login-bg-17.jpg)"></a></li>
        <li><a href="javascript:;" data-click="change-bg" data-img="<?=base_url()?>assets/img/login-bg/login-bg-16.jpg" style="background-image: url(<?=base_url()?>assets/img/login-bg/login-bg-16.jpg)"></a></li>
        <li><a href="javascript:;" data-click="change-bg" data-img="<?=base_url()?>assets/img/login-bg/login-bg-15.jpg" style="background-image: url(<?=base_url()?>assets/img/login-bg/login-bg-15.jpg)"></a></li>
        <li><a href="javascript:;" data-click="change-bg" data-img="<?=base_url()?>assets/img/login-bg/login-bg-14.jpg" style="background-image: url(<?=base_url()?>assets/img/login-bg/login-bg-14.jpg)"></a></li>
        <li><a href="javascript:;" data-click="change-bg" data-img="<?=base_url()?>assets/img/login-bg/login-bg-13.jpg" style="background-image: url(<?=base_url()?>assets/img/login-bg/login-bg-13.jpg)"></a></li>
        <li><a href="javascript:;" data-click="change-bg" data-img="<?=base_url()?>assets/img/login-bg/login-bg-12.jpg" style="background-image: url(<?=base_url()?>assets/img/login-bg/login-bg-12.jpg)"></a></li>
    </ul> -->
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
