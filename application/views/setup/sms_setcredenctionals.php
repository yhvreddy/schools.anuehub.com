<!DOCTYPE html>
<html lang="en">
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
    <script src="<?=base_url()?>assets/plugins/jquery/jquery-3.3.1.min.js"></script>
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?=base_url()?>assets/plugins/pace/pace.min.js"></script>
    <script src="<?= base_url() ?>assets/js/angular.min.js"></script>
    <link href="<?= base_url() ?>assets/css/sweetalert.min.css" rel="stylesheet">
    <script src="<?= base_url() ?>assets/js/sweetalert.min.js"></script>
    <!-- ================== END BASE JS ================== -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .customalert{
            width: max-content;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1111111111;
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
        #changepassword .short{
            font-weight:bold;
            color:#FF0000;
            font-size:12px;
        }
        #changepassword .weak{
            font-weight:bold;
            color:orange;
            font-size:12px;
        }
        #changepassword .good{
            font-weight:bold;
            color:#2D98F3;
            font-size:12px;
        }
        #changepassword .strong{
            font-weight:bold;
            color: limegreen;
            font-size:12px;
        }
        .red{color: red;}
    </style>
</head>

<body class="pace-top">
<div class="loader" id="loader" style="display:none">
    <center>
        <img src="<?= base_url() ?>assets/images/loader.gif">
    </center>
</div>
<?php
    extract($_REQUEST);
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
                <?php if(count($userdata) != ''){ //print_r($userdata['schooldata']->school_id); ?>
                    <?php if(isset($pin)){ ?>
                        <form class="margin-bottom-0" id="setpin" action="#" method="post">
                            <input type="hidden" name="id" value="<?=$userdata['id']?>">
                            <input type="hidden" name="reg_id" value="<?=$userdata['reg_id']?>">
                            <input type="hidden" name="sclmode" value="<?=$userdata['sclmode']?>">
                            <input type="hidden" name="type" value="<?=$userdata['type']?>">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <!-- <label for="SetPinNumber">Set 4-dig Pin Number</label> -->
                                    <input class="form-control" type="password" placeholder="Set 4-digits pin Number" required="" id="SetPinNumber" name="setpinnumber" maxlength="4">
                                    <small id="setpinerror"></small>
                                </div>
                            </div>
                            
                            <div class="form-group text-center m-t-20">
                                <div class="col-xs-12">
                                    <button class="btn btn-info btn-md btn-block text-uppercase waves-effect waves-light" type="submit">Set Pin</button>
                                </div>
                            </div>

                        </form>
                    <?php }else if(isset($password)){ ?>
                        <form class="margin-bottom-0" id="changepassword" action="javascript:;">
                            <input type="hidden" name="id" value="<?=$userdata['id']?>">
                            <input type="hidden" name="reg_id" value="<?=$userdata['reg_id']?>">
                            <input type="hidden" name="sclmode" value="<?=$userdata['sclmode']?>">
                            <input type="hidden" name="type" value="<?=$userdata['type']?>">
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <!-- <label for="OldPassword">Enter Old Password</label> -->
                                    <input class="form-control" type="password" required="" autofocus="" placeholder="Enter old Password" id="OldPassword" name="oldpassword">
                                    <small id="Oldpassworderror"></small>
                                </div>
                            </div>

                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <!-- <label for="NewPassword">Enter New Password</label> -->
                                    <input class="form-control" type="password" placeholder="Enter New Password" id="NewPassword" name="newpassword" required="">
                                    <small id="Newpassworderror"></small>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <!-- <label for="conformNewPassword">Enter Conform Password</label> -->
                                    <input class="form-control" type="password" placeholder="Re Enter New Password" id="conformNewPassword" name="conformpassword" required="">
                                    <small id="Conformpassworderror"></small>
                                </div>
                            </div>
                            <div class="form-group text-center m-t-20">
                                <div class="col-xs-12">
                                    <button class="btn btn-info btn-md btn-block text-uppercase waves-effect waves-light" type="submit">Change Password</button>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                <?php }else{ ?>
                    Invalid Request to change Password
                <?php } ?>    
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
    <!-- ================== END PAGE LEVEL JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
            LoginV2.init();
        });
    </script>
    <script type="text/javascript">
        //validation for change password and create pin
        $(document).ready(function(){ 
            //regular expressions
            var number =  /^[0-9]+$/;
            var regexpnum = new RegExp(number);
        
            //old password check
            $("#OldPassword").keyup(function() {
                /* Act on the event */
                var OldPassword = $(this).val();
                if(OldPassword == ""){
                    $("#OldPassword").focus();
                    $("#Oldpassworderror").text('Enter Old Password or Genrated Password.');
                    $("#Oldpassworderror").addClass('red');
                }else{
                    $("#Oldpassworderror").text('');
                    $("#Oldpassworderror").removeClass('red');
                }
            });
            //new password check
            $('#NewPassword').keyup(function(){
                if($(this).val() == ""){
                    $('#Newpassworderror').text("Enter New password..")
                    $('#Newpassworderror').removeClass();
                    $('#Newpassworderror').addClass('red');
                    $('#NewPassword').focus();
                }else{
                    $('#Newpassworderror').html(checkStrength($('#NewPassword').val()))
                }
            })  
            //conform passowrd check
            $("#conformNewPassword").keyup(function() {
                /* Act on the event */
                var newpassword = $("#NewPassword").val();
                var conformpass = $(this).val();
                //alert(newpassword);
                if(conformpass == ""){
                    $("#Conformpassworderror").text('Enter Conform Password..');
                    $("#Conformpassworderror").removeClass('strong');
                    $("#Conformpassworderror").addClass('red');
                }else if(newpassword != conformpass){
                    $("#Conformpassworderror").text('Password not matching...');
                    $("#Conformpassworderror").addClass('red');
                    $("#Conformpassworderror").removeClass('strong');
                }else if(newpassword == conformpass){
                    $("#Conformpassworderror").text('password is matched..');
                    $("#Conformpassworderror").removeClass('red');
                    $("#Conformpassworderror").addClass('strong');
                }
            });

            function checkStrength(password){
                var strength = 0;
                if (password.length < 6) { 
                    $('#Newpassworderror').removeClass()
                    $('#Newpassworderror').addClass('short')
                    $('#Newpassworderror').text('Password is two short..') 
                }
                
                if (password.length > 7) strength += 1
                
                //If password contains both lower and uppercase characters, increase strength value.
                if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  strength += 1
                
                //If it has numbers and characters, increase strength value.
                if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))  strength += 1 
                
                //If it has one special character, increase strength value.
                if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))  strength += 1
                
                //if it has two special characters, increase strength value.
                if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1

                //Calculated strength value, we can return messages
                
                
                
                //If value is less than 2
                
                if (strength < 2 )
                {
                    $('#Newpassworderror').removeClass()
                    $('#Newpassworderror').addClass('weak')
                    $('#Newpassworderror').text('Week password')           
                }
                else if (strength == 2 )
                {
                    $('#Newpassworderror').removeClass()
                    $('#Newpassworderror').addClass('good')
                    $('#Newpassworderror').text('Good password')       
                }
                else
                {
                    $('#Newpassworderror').removeClass()
                    $('#Newpassworderror').addClass('strong')
                    $('#Newpassworderror').text('strong password')
                }
            }

            //pin validate
            $("#SetPinNumber").keyup(function(event) {
                var pinnum = $(this).val();
                if(pinnum === '' ){
                    $("#setpinerror").text('create 4 digits pin number').css('color', 'red');
                }else if(!regexpnum.test(pinnum)){
                    $("#setpinerror").text('pin number should be number only.').css('color', 'red');
                }else if(pinnum.length < 4 && pinnum.length != 4){
                    $("#setpinerror").text('Enter valid 4 digits pin number.').css('color', 'red');
                }else if(pinnum != ''){
                    $("#setpinerror").text('');
                }
            });
        });

        //change password & create pin
        $(document).ready(function() {
            //submiting form to ajax with validation
            //change password..
            $("#changepassword").submit(function(event) {
                // loader for responce message.
                $("#loader").show();
                event.preventDefault();
                //getting values for all input fields
                var opwd = $("#OldPassword").val();
                var npwd = $("#NewPassword").val();
                var cpwd = $("#conformNewPassword").val();
                //checking input fields is empty or not
                if(opwd != "" && npwd != "" && cpwd != ""){  
                    // not empty -> send details to ajax and validate and change password..!
                    if(npwd == cpwd){
                        $.ajax({
                            url: "<?= base_url('setup/savechangepassword') ?>",
                            type: 'POST',
                            dataType: 'json',
                            data: {oldpassword:opwd,newpassword:npwd,conformpassword:cpwd},
                        })
                        .done(function(dataresponce) {
                            console.log(dataresponce);
                            $("#loader").hide();
                            if(dataresponce.key == 0){
                                swal({
                                    title:"Sorry",
                                    text: dataresponce.message,
                                    type:"warning",
                                });
                                $("#changepassword").trigger('reset');
                                //swal("Sorry", dataresponce.message , "warning");
                            }else if(dataresponce.key == 1){
                                swal({
                                    title:"success",
                                    text: dataresponce.message,
                                    type:"success",
                                },function () {
                                    window.location.href = dataresponce.url;                
                                });
                                $("#changepassword").trigger('reset');
                            }
                        })
                        .fail(function(errordata) {
                            console.log(errordata);
                            $("#loader").hide();
                            swal("Oop's error", errordata , "error");
                        })
                    }else{
                        $("#Conformpassworderror").text('Conform password should be same as new password..');
                        $("#Conformpassworderror").addClass('red');
                        $("#conformNewPassword").focus();
                    }
                                        
                }else{
                    //any field is empty -> check fields which is empty and display message to that filed
                    if(opwd == ""){
                        $("#OldPassword").focus();
                        $("#Oldpassworderror").text('Enter Old Password or Genrated Password.');
                        $("#Oldpassworderror").addClass('red'); 
                    }else if(npwd == ""){
                        $('#Newpassworderror').text("Enter New password..")
                        $('#Newpassworderror').addClass('red');
                        $('#NewPassword').focus();
                    }else if(cpwd == ""){
                        $("#Conformpassworderror").text('Enter Conform Password..');
                        $("#Conformpassworderror").addClass('red');
                        $("#conformNewPassword").focus();
                    }
                    $("#loader").hide();
                }
            });    

            //create 4digits pin number
            $("#setpin").submit(function(e){
                e.preventDefault();
                var pin = $("#SetPinNumber").val();
                $("#loader").show();
                if (pin != "" && pin.length == 4) {
                    $.ajax({
                        url: "<?= base_url('setup/createpinnumber') ?>",
                        type: 'POST',
                        dataType: 'json',
                        data: {setpinnumber:pin},
                    })
                    .done(function(dataresponce) {
                        console.log(dataresponce);
                        $("#loader").hide();
                        if(dataresponce.key == 0){
                            swal({
                                title:"Sorry",
                                text: dataresponce.message,
                                type:"warning",
                            });
                            $("#setpin").trigger('reset');
                        }else if(dataresponce.key == 1){
                            swal({
                                title:"success",
                                text: dataresponce.message,
                                type:"success",
                            },function () {
                                window.location.href = dataresponce.url;                
                            });
                            $("#setpin").trigger('reset');
                        }
                    })
                    .fail(function(req, status, err) {
                        console.log('Something went wrong', status, err);
                        $("#loader").hide();
                        swal("Oop's error", 'Something went wrong', status, err , "error");
                    })
                }else{
                    $("#setpinerror").text('4 digits pin number should not be empty..!');
                    $("#setpinerror").addClass('red');
                    $("#setpinerror").focus();
                }
            })
        });
    </script>
</body>

</html>
