<!DOCTYPE html>
<?php error_reporting(0); ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/images/favicon.png">
    <title><?= $PageTitle ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/plugins/wizard/steps.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?= base_url() ?>assets/css/colors/blue.css" id="theme" rel="stylesheet">
    <link href="<?= base_url() ?>assets/plugins/icheck/skins/all.css" rel="stylesheet">
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/js/angular.min.js"></script>
    <link href="<?= base_url() ?>assets/css/sweetalert.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   <!--  <link rel="stylesheet" href="<?//= base_url() ?>assets/plugins/dropify/dist/css/dropify.min.css"> -->
    <style>
        .customalert{
            width: max-content;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1111111111;
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
        .footersection{
            bottom: 0px;
            position: absolute;
            right: 32%;
            left: 32%;
            padding: 20px 0px;
        }
    </style>
</head>

<body>
<?php $data = $this->session->userdata; ?>
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
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
    </svg>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper" >
    <div class="login-register" style="position:absolute;background-image:url(<?= base_url() ?>assets/images/background/background.jpg);background-size: 100% 100vh;padding: 8% 0% 0% 0%;">
        <div class="login-box card" style="width: 90%;opacity: 0.9;height:auto;">
            <div class="card-body">
                <?php if(isset($data)){ ?>
                    <div class="col-md-12">
                        <?php //echo "<pre>";print_r($data['school']);echo "</pre>"; ?>
                        <h3 class="text-center text-uppercase">Setup <?= strtoupper($data['school']->schoolname); ?> Details</h3>
                        <!--<h4 class="card-title">Step wizard for setup school details</h4>
                            <h6 class="card-subtitle">You can us the validation like what we did</h6>-->
                            <div class="">
                                <!-- set class to school -->
                                <?php
                                    //school class data
                                    $chkdata = $this->Model_dashboard->selectdata('sms_class',array('school_id'=>$data['school']->school_id,'branch_id'=>$data['school']->branch_id));
                                    $countonclass = count($chkdata);
                                    //school information
                                    $regschooltypes = $this->Model_dashboard->selectdata('sms_schoolinfo',array('reg_id' => $data['school']->reg_id,'school_id'=>$data['school']->school_id,'branch_id'=>$data['school']->branch_id));
                                    $scltypes = explode(',', $regschooltypes['0']->scl_types);
                                    //print_r($scltypes);
                                    $countonscl = count($scltypes);
                                    //sections count
                                    $ckecksection = $this->Model_dashboard->selectdata('sms_section', array('school_id'=>$data['school']->school_id,'branch_id'=>$data['school']->branch_id));
                                    $countsection   =   count($ckecksection);
                                ?>
                                <?php if(isset($classesections)){ ?>
                                    <!-- Step 1 -->
                                    <h3>Class & sections Details</h3>
                                    <section id="content-2" class="content mCustomScrollbar light" data-mcs-theme="minimal-dark">
                                        <?php //print_r($schoolstypes); ?>
                                        

                                        <form method="post" action="#" id="saveclasslist">
                                            <div class="row">
                                                <?php
                                                $i = 0;
                                                foreach ($schoolstypes as $value) {
                                                    @$scltype = $scltypes[$i];
                                                    //echo $value->id;    // 1,3
                                                    //print_r($scltype);
                                                    if(in_array($value->id, $scltypes)){ ?>
                                                        <div class="col-md-12 mb-3 mt-2">
                                                            <h4><?= 'SET CLASS FOR '.$value->type ?></h4>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group" style="margin:0px">
                                                                        <label>Select Classes : <span class="text-danger">*</span></label>
                                                                        <div class="c-inputs-stacked">
                                                                            <input type="hidden" value="<?= $data['school']->reg_id ?>" name="regid">
                                                                            <input type="hidden" value="<?= $data['school']->branch_id ?>" name="branchid">
                                                                            <input type="hidden" value="<?= $data['school']->school_id ?>" name="schoolid">
                                                                            <input type="hidden" value="<?= $value->type ?>" name="schoolname[]">
                                                                            <?php foreach ($classlist as $class) {
                                                                                if($class->class != 'other'){
                                                                                    ?>

                                                                                    <label class="inline custom-control custom-checkbox block">
                                                                                        <input type="checkbox" class="custom-control-input" value="<?= $class->class; ?>" id="<?= $value->type.$class->class; ?>" name="<?= $value->type ?>_class[]"> <span class="custom-control-indicator"></span> <span class="custom-control-description ml-0"><?= $class->class; ?></span> </label>
                                                                                    <script type="text/javascript">
                                                                                        $(document).ready(function() {
                                                                                            $("#<?= $value->type.$class->class; ?>").click(function() {
                                                                                                var <?= $value->type.$class->class; ?> = $(this).val();
                                                                                            if(<?= $value->type.$class->class; ?> == "other"){
                                                                                                    if($(this).is(':checked')) {
                                                                                                        //console.log("This other Section of : <?//= $value->type . $class->class; ?>");
                                                                                                        $("#otherpartsection<?= $value->type ?>").show();
                                                                                                    }else{
                                                                                                        $("#otherpartsection<?= $value->type ?>").hide();
                                                                                                    }
                                                                                                }
                                                                                            });
                                                                                        });
                                                                                    </script>
                                                                                    <script>
                                                                                        $(document).ready(function () {
                                                                                            //append code
                                                                                            //console.log("Welcome");
                                                                                            var <?= $value->type.$class->class; ?> = $("#<?= $value->type.$class->class; ?>").val();
                                                                                            $("#addclass<?= $value->type ?>").click(function () {
                                                                                                if(<?= $value->type.$class->class; ?> == "other"){
                                                                                                    if($("#<?= $value->type.$class->class; ?>").is(':checked')) {
                                                                                                        //$("#addotherclasses").text("It's fine");
                                                                                                        var txt_box;
                                                                                                        $('#addclass<?= $value->type ?>').click(function(){
                                                                                                            //$(this).remove();
                                                                                                            txt_box = '<div class="space col-md-3"><div class="row"><div class="col-md-12 form-group"><div class="form-line"><input type="text" name="<?= $value->type ?>_class[]" class="left txt form-control" placeholder="Enter Class Name"/> </div></div></div></div>';
                                                                                                            $("#addotherclasses<?= $value->type ?>").append(txt_box);
                                                                                                            //id++;
                                                                                                        });

                                                                                                        $('#removeclass<?= $value->type ?>').click(function(){
                                                                                                            //alert("=====");
                                                                                                            var parent=$("#addotherclasses<?= $value->type ?>").parent().prev().attr("id");
                                                                                                            var parent_im=$("#addotherclasses<?= $value->type ?>").parent().attr("id");
                                                                                                            $("#"+parent_im).slideUp('medium',function(){
                                                                                                                $("#"+parent_im).remove();
                                                                                                            });
                                                                                                        });
                                                                                                    }
                                                                                                }
                                                                                            });
                                                                                        })
                                                                                    </script>
                                                                                <?php } } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row" id="otherpartsection<?= $value->type ?>">
                                                                <div class="col-md-12 mb-2">
                                                                    <h4>Add Other Classes Name  <a class="btn btn-xs btn-success" id="addclass<?= $value->type ?>">Add New Class</a> <a class="btn btn-danger btn-xs" id="removeclass<?= $value->type ?>"> remove </a></h4>
                                                                    <div id="addotherclasses<?= $value->type ?>" class="row">
                                                                        <div class="space col-md-3">
                                                                            <div class="row">
                                                                                <div class="col-md-12 form-group">
                                                                                    <div class="form-line">
                                                                                        <input type="text" data_sclname="<?= $value->type ?>" name="<?= $value->type ?>_class[]" class='left txt form-control' placeholder="Enter Class Name"/>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            $(document).ready(function () {
                                                                $("#otherpartsection<?= $value->type ?>").hide();
                                                            })
                                                        </script>
                                                        <?php
                                                    }  ?>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                                <div class="col-md-12 pt-5">
                                                    <center><input type="submit" class="btn btn-success" value="Save Classes"></center>
                                                </div>
                                            </div>
                                        </form>

                                        <!-- set sections to school -->
                                        <form method="post" action="#" id="sectionslist" class="floating-labels">
                                             <div class="row" id="listofsections">
                                                 <?php include 'subsetups/sms_sections_setup.php'; ?>
                                             </div>
                                        </form>

                                        <div class="row" id="classesandsectionsfinsh">
                                            <div class="col-md-12 p-5" style="font-size: 30px;padding: 3.7rem !important;">
                                                <center>successfully saved classes and Section's<br>Save Subjects list.. Press Next to Start Subjects List.!</center>
                                                <center><a href="<?=base_url('setup/details?subjects')?>" class="btn btn-success">Next Setup Subjects</a></center>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function () {
                                                $("#sectionslist,#classesandsectionsfinsh,#classoptionsbox").hide();

                                                if(<?= $countonclass ?> == <?= $countonscl ?>){
                                                    $("#sectionslist").show();
                                                    $("#saveclasslist").hide();
                                                }else{
                                                    $("#sectionslist").hide();
                                                    $("#saveclasslist").show();
                                                }

                                                if(<?= $countsection ?> != 0){
                                                    $("#sectionslist").hide();
                                                    $("#saveclasslist").hide();
                                                    $("#classesandsectionsfinsh").show();
                                                    $(".actions").show();
                                                }

                                                //save classes list
                                                $("#saveclasslist").submit(function (ee) {
                                                    ee.preventDefault();
                                                    $("#loader").show();
                                                    $.ajax({
                                                        url: '<?= base_url() ?>setup/saveclassdetailslist',
                                                        method: 'POST',
                                                        dataType: 'json',
                                                        data: new FormData(this),
                                                        processData: false,
                                                        contentType: false,
                                                    })
                                                        .done(function (dataresponce) {
                                                            $("#loader").hide();
                                                            console.log(dataresponce);
                                                            if (dataresponce.key == 0) {
                                                                swal({
                                                                    title: "Sorry",
                                                                    text: dataresponce.message,
                                                                    type: "warning",
                                                                },function () {
                                                                    //$("#sectionslist").load('subsetups/sms_sections_setup.php' + '#listofsections');
                                                                    $("#saveclasslist").trigger('reset');
                                                                    $("#saveclasslist").hide();
                                                                    $("#sectionslist").show();
                                                                });
                                                                //swal("Sorry", dataresponce.message , "warning");
                                                            } else if (dataresponce.key == 1) {
                                                                swal({
                                                                    title: "success",
                                                                    text: dataresponce.message,
                                                                    type: "success",
                                                                }, function () {
                                                                    $("#saveclasslist").trigger('reset');
                                                                    $("#saveclasslist").hide();
                                                                    $("#sectionslist").show();
                                                                    window.location.href = '<?= base_url() ?>setup/details?classesections';
                                                                    //$("#listofsections").load();
                                                                    //$("#listofsections").load('subsetups/sms_sections_setup.php' + '#listofsections');
                                                                });
                                                            }
                                                        })
                                                        .fail(function (req, status, err) {
                                                            //console.log("error : " + errordata);
                                                            console.log('Something went wrong', status, err);
                                                            $("#loader").hide();
                                                        })

                                                });
                                                
                                                //sections list
                                                $("#sectionslist").submit(function (ee) {
                                                    ee.preventDefault();
                                                    $("#loader").show();
                                                    $.ajax({
                                                        url: '<?= base_url() ?>setup/savesectionslist',
                                                        method: 'POST',
                                                        dataType: 'json',
                                                        data: new FormData(this),
                                                        processData: false,
                                                        contentType: false,
                                                    })
                                                        .done(function (dataresponce) {
                                                            $("#loader").hide();
                                                            console.log(dataresponce);
                                                            if (dataresponce.key == 0) {
                                                                swal({
                                                                    title: "Sorry",
                                                                    text: dataresponce.message,
                                                                    type: "warning",
                                                                },function () {
                                                                    
                                                                });
                                                                //swal("Sorry", dataresponce.message , "warning");
                                                            } else if (dataresponce.key == 1) {
                                                                swal({
                                                                    title: "success",
                                                                    text: dataresponce.message,
                                                                    type: "success",
                                                                }, function () {
                                                                    $("#saveclasslist").trigger('reset');
                                                                    $("#saveclasslist").hide();
                                                                    $("#sectionslist").hide();
                                                                    $("#sectionslist").trigger('reset');
                                                                    $(".actions").show();
                                                                    $("#classesandsectionsfinsh").show();
                                                                    $("#sectionslist").load('subsetups/sms_sections_setup.php' + '#listofsections');
                                                                });
                                                            }
                                                        })
                                                        .fail(function (req, status, err) {
                                                            //console.log("error : " + errordata);
                                                            console.log('Something went wrong', status, err);
                                                            $("#loader").hide();
                                                        })

                                                });

                                            })
                                        </script>
                                    </section>
                                <?php }else if (isset($subjects)) { ?>
                                    <!-- Step 2 -->
                                    <h3>Subjects Details</h3>
                                    <section id="content-2" class="content mCustomScrollbar light" data-mcs-theme="minimal-dark">
                                        <!-- set subjects to class -->
                                        <form method="post" action="javascript:void(0);" id="subjectslist" class="form-material">
                                            <div class="row" id="listofsections">
                                                <?php
                                                $chkdata = $this->Model_dashboard->selectdata('sms_class',array('school_id'=>$data['school']->school_id,'branch_id'=>$data['school']->branch_id));
                                                ?>
                                                <div class="col-md-12">
                                                    <div class="row justify-content-center align-items-center">
                                                        <input type="hidden" value="<?= $data['school']->reg_id ?>" id="subregid" name="regid">
                                                        <input type="hidden" value="<?= $data['school']->branch_id ?>" id="subbranchid" name="branchid">
                                                        <input type="hidden" value="<?= $data['school']->school_id ?>" id="subschoolid" name="schoolid">
                                                        
                                                        <div class="form-group col-md-3">
                                                            <select class="form-control" name="scltypeslist" id="scltypeslist">
                                                                <option value="">Select syllabus type</option>
                                                                <?php
                                                                    $i = 0;
                                                                    foreach ($schoolstypes as $value) {
                                                                        @$scltype = $scltypes[$i];
                                                                        //print_r($scltype);
                                                                        if(in_array($value->id, $scltypes)){ ?>
                                                                            <option value="<?= $value->id ?>"><?= $value->type ?></option>    
                                                                    <?php } $i++; } ?>
                                                            </select>
                                                            <small id="scltypeslisterror"></small>
                                                        </div> 
                                                        <div class="col-md-3">
                                                            <div class="form-group" id="classoptionsbox">
                                                                <select class="form-control" name="classlistname" id="classlisting">
                                                                    <option value="">Select Class</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row" id="noofsubjectsmainbox">
                                                                <div class="col-md-4" style="    padding: 10px 0px 0px 0px;text-align: center;">
                                                                    <label>Number of Fields </label>
                                                                </div>
                                                                <div class="form-group col-md-5">
                                                                    <input type="number" min="1" class="form-control text-center" name="noofsubjectboxs" id="noofsubjectboxs">
                                                                </div>
                                                                <div class="col-md-3 form-group">
                                                                    <button type="button" name="addlistofsubjects" id="addlistofsubjects" class="btn btn-success btn">Add Fields</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row" id="Addsubjects"></div>
                                                        </div>
                                                        <div class="col-md-12 mt-2" id="savesubjectsbtn">
                                                            <center><input type="submit" class="btn btn-success" value="Save Subjects" name="savesubjectslist"></center>';
                                                        </div>
                                                    </div>
                                                </div>                                                
                                            </div> 
                                        </form>
                                        <script>
                                            $(document).ready(function(){

                                                $("#Addsubjects,#noofsubjectsmainbox,#savesubjectsbtn").hide();

                                                $("#scltypeslist").change(function() {
                                                    var scltypeslist = $(this).val();
                                                    //alert(scltypeslist);
                                                    if(scltypeslist == ""){
                                                        $("#scltypeslisterror").text("Please select school Syllabus type..").css('color','red');
                                                        $("#scltypeslist").focus();
                                                    }else{
                                                        $("#loader").show();
                                                        $("#scltypeslisterror").text("");
                                                        var subbranchid = $("#subbranchid").val();
                                                        var subschoolid = $("#subschoolid").val();
                                                        var subregid = $("#subregid").val();
                                                        var scltypeslist = $("#scltypeslist").val();
                                                        $.ajax({
                                                            url:"<?= base_url() ?>setup/subjectsperclasses",
                                                            dataType:'json',
                                                            method:'POST',
                                                            data: {schoolid:subschoolid,branchid:subbranchid,sclsyllubas:scltypeslist,regid:subregid},
                                                        })
                                                        .done(function (dataresponce) {
                                                            $("#loader").hide();
                                                            $("#classoptionsbox").show();
                                                            $("#classlisting").children('option:not(:first)').remove();
                                                            console.log(dataresponce);
                                                            var list = "";
                                                            
                                                            for($l = 0; dataresponce.length > $l; $l++){
                                                                list += "<option value='"+ dataresponce[$l] +"'>"+ dataresponce[$l] +"</option>";
                                                            }
                                                            $("#classlisting").append(list);
                                                        })
                                                        .fail(function (req, status, err) {
                                                            console.log('Something went wrong', status, err);
                                                            $("#loader").hide();
                                                        })
                                                    }
                                                });

                                                $("#classlisting").change(function () {
                                                    var classlisting = $(this).val();
                                                    var sclstype = $("#scltypeslist").val();
                                                    if(classlisting == ""){
                                                        swal("please select class to add subjects..!");
                                                    }else{
                                                        $("#loader").hide();
                                                        $("#noofsubjectsmainbox").show();
                                                    }
                                                })

                                                $("#addlistofsubjects").click(function(event) {
                                                    /* Act on the event */
                                                    var scltypesmode = $("#scltypeslist").val();
                                                    var classlisting = $("#classlisting").val();
                                                    var subjectboxs = $("#noofsubjectboxs").val();
                                                    if(scltypesmode != "" || classlisting != "" || subjectboxs != ""){
                                                        $("#Addsubjects").show();
                                                        var boxes = "";
                                                        for(var i=1;subjectboxs >= i;i++){
                                                            //swal("ok done..!");
                                                            //console.log(i);
                                                            boxes += '<div class="col-md-4"><div class="row"><div class="col-md-10 form-group"><input type="text" name="subjectname[]" class="form-control subjectname" placeholder="Enter subject name"></div><div class="col-md-1"><a href="javascript:void(0);" class="btn btn-sm btn-danger RemoveInput" id="removeinput">X</a></div></div></div>';
                                                        }
                                                        $("#Addsubjects").append(boxes);
                                                        $("#savesubjectsbtn").show();
                                                    }else{
                                                        $("#savesubjectsbtn").hide();
                                                        swal("Class , syllabus and no.of subjects type should not be empty..!");
                                                    }
                                                })

                                                $("#Addsubjects").on('click','.RemoveInput',function(e){
                                                    e.preventDefault();
                                                    $(this).parent().parent().parent().remove();
                                                })

                                                $("#subjectslist").submit(function(e) {
                                                    e.preventDefault();
                                                    $("#loader").show();
                                                    var subjectnamecount = $("input[name='subjectname[]']").length;
                                                    //alert("ok..." + subjectnamecount);
                                                    var subjectdata = $("#subjectslist").serialize();
                                                    //console.log(subjectdata);
                                                    $.ajax({
                                                        url: '<?=base_url('Setup/subjectlistbyclass')?>',
                                                        type: 'POST',
                                                        dataType: 'json',
                                                        data: subjectdata,
                                                    })
                                                    .done(function(dataresponce) {
                                                        $("#loader").hide();
                                                        console.log(dataresponce);
                                                        if (dataresponce.code == 0) {
                                                            swal({
                                                                title: "Sorry",
                                                                text: dataresponce.message,
                                                                type: "warning",
                                                            },function () {
                                                                //$("#sectionslist").load('subsetups/sms_sections_setup.php' + '#listofsections');
                                                                $("#subjectslist").trigger('reset');
                                                                $("#Addsubjects").empty();
                                                                $("#savesubjectsbtn").hide();
                                                                //$("#noofsubjectsmainbox").hide();
                                                                $("#noofsubjectboxs").val('');
                                                            });
                                                            //swal("Sorry", dataresponce.message , "warning");
                                                        } else if (dataresponce.code == 1) {
                                                            swal({
                                                                title: "success",
                                                                text: dataresponce.message,
                                                                type: "success",
                                                            }, function () {
                                                                $("#subjectslist").trigger('reset');
                                                                $("#Addsubjects").empty();
                                                                $("#savesubjectsbtn").hide();
                                                                $("#noofsubjectsmainbox").hide();
                                                                $("#noofsubjectboxs").val('');
                                                                if(dataresponce.total == dataresponce.current){
                                                                    window.location.href = '<?= base_url() ?>setup/details?feedetails';    
                                                                    
                                                                }
                                                            });
                                                        }
                                                    })
                                                    .fail(function (req, status, err) {
                                                        console.log('Something went wrong', status, err);
                                                        $("#loader").hide();
                                                    })
                                                });

                                            });
                                        </script>
                                    </section>    
                                <?php }else if(isset($feedetails)){ ?>
                                    <!-- Step 3 -->
                                    <h3>Fee structurs</h3>
                                    <section id="content-2" class="content mCustomScrollbar light" data-mcs-theme="minimal-dark">
                                        <!-- set subjects to class -->
                                        <form method="post" action="javascript:void(0);" id="schoolfeedetailslist" class="form-material">
                                            <div class="row" id="listofsections">
                                                <?php
                                                $chkdata = $this->Model_dashboard->selectdata('sms_class',array('school_id'=>$data['school']->school_id,'branch_id'=>$data['school']->branch_id));
                                                ?>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <input type="hidden" value="<?= $data['school']->reg_id ?>" id="subregid" name="regid">
                                                        <input type="hidden" value="<?= $data['school']->branch_id ?>" id="subbranchid" name="branchid">
                                                        <input type="hidden" value="<?= $data['school']->school_id ?>" id="subschoolid" name="schoolid">
                                                        
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <select class="form-control p-0" required="" name="scltypeslist" id="scltypeslist">
                                                                        <option value="">Select syllabus type</option>
                                                                        <?php
                                                                            $i = 0;
                                                                            foreach ($schoolstypes as $value) {
                                                                                @$scltype = $scltypes[$i];
                                                                                //print_r($scltype);
                                                                                if(in_array($value->id, $scltypes)){ ?>
                                                                                    <option value="<?= $value->id ?>"><?= $value->type ?></option>    
                                                                            <?php } $i++; } ?>
                                                                    </select>
                                                                    <small id="scltypeslisterror"></small>
                                                                </div> 
                                                                <div class="col-md-12">
                                                                    <div class="form-group" id="classoptionsbox">
                                                                        <select class="form-control p-0" name="classlistname" required="" id="classlisting">
                                                                            <option value="">Select Class</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                                
                                                        <div class="col-md-8">
                                                            <div class="row" id="noofsubjectsmainbox">
                                                                <h4 class="text-center col-md-12">Set Fee details</h4>
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class=" col-12 mt-2">
                                                                            <div class="row">
                                                                                <div class="col-md-4 col-sm-12 col-12">
                                                                                    <input type="tel" name="schoolfee" required="" id="schoolfee" placeholder="Enter school fee" class="form-control">
                                                                                    <span class="bar"></span>
                                                                                </div>
                                                                                <div class="col-md-4 col-sm-12 col-12">
                                                                                    <input type="tel" name="vehiclefee" required="" id="vehiclefee" placeholder="Enter vehicle fee" class="form-control">
                                                                                    <span class="bar"></span>
                                                                                </div>
                                                                                <div class="col-md-4 col-sm-12 col-12">
                                                                                    <input type="tel" name="hostelfee" required="" placeholder="Enter Hostel fee" id="hostelfee" class="form-control">
                                                                                    <span class="bar"></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 mt-4 mb-2">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <label class="inline custom-control custom-checkbox block">
                                                                                        <input type="checkbox" class="custom-control-input" value="no" id="otheramountlist" name="otheramountlist"> 
                                                                                        <span class="custom-control-indicator"></span> 
                                                                                        <span class="custom-control-description ml-0">Set Other Fee Expenses Details</span> 
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mt-3">
                                                                                <div class="col-md-12" id="otheramountlistbox">
                                                                                    <div class="row justify-content-center align-items-center">
                                                                                        <div class="col-md-8">
                                                                                            <div class="row">
                                                                                                <div class="col-md-5 form-group">
                                                                                                    <input type="text" name="servicename[]" placeholder="Enter Name" class="form-control">
                                                                                                </div>
                                                                                                <div class="col-md-5 form-group">
                                                                                                    <input type="tel" name="serviceamount[]" placeholder="Enter Amount" class="form-control">
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <a href="javascript:void(0);" id="AddNewfield" class="btn btn-success btn-sm">Add New</a>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <div class="col-md-12" id="appendfeefields"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-12 mt-3" id="savefeebtn">
                                                                            <center><input type="submit" class="btn btn-success" value="Save Fee Details" name="savefeelist"></center>';
                                                                        </div>
                                                                    

                                                                    </div>
                                                                    
                                                                        

                                                                </div>
                                                                
                                                            </div>
                                                                    
                                                        </div>
                                                    </div>
                                                            
                                                </div>                                                
                                            </div> 
                                        </form>
                                    </section>
                                    <script>
                                        $(document).ready(function(){

                                            $("#Addsubjects,#noofsubjectsmainbox,#otheramountlistbox").hide();

                                            $("#otheramountlist").click(function(e) {
                                                if($('#otheramountlist').is(":checked")){ 
                                                    $("#otheramountlist").val('yes');  
                                                    $("#otheramountlistbox").show();
                                                }else{
                                                    $("#otheramountlist").val('no');
                                                    $("#otheramountlistbox").hide();
                                                    $("#appendfeefields").empty();
                                                    $("input[name='servicename[]']").val('');
                                                    $("input[name='serviceamount[]']").val('');
                                                }
                                            });

                                            $("#AddNewfield").click(function(e) {
                                                var Newfields = '<div class="row"><div class="col-md-5 form-group"><input type="text" name="servicename[]" placeholder="Enter Name" class="form-control"></div><div class="col-md-5 form-group"><input type="tel" name="serviceamount[]" placeholder="Enter Amount" class="form-control"></div><div class="col-md-2"><a href="javascript:void(0);" id="AddNewfield" class="btn btn-danger btn-sm RemoveField">Remove</a></div></div>'
                                                $("#appendfeefields").append(Newfields);
                                            });

                                            $("#appendfeefields").on('click','.RemoveField',function(e){
                                                e.preventDefault();
                                                $(this).parent().parent().remove();
                                            })

                                            $("#scltypeslist").change(function() {
                                                var scltypeslist = $(this).val();
                                                //alert(scltypeslist);
                                                if(scltypeslist == ""){
                                                    $("#scltypeslisterror").text("Please select school Syllabus type..").css('color','red');
                                                    $("#scltypeslist").focus();
                                                }else{
                                                    $("#loader").show();
                                                    $("#scltypeslisterror").text("");
                                                    var subbranchid = $("#subbranchid").val();
                                                    var subschoolid = $("#subschoolid").val();
                                                    var subregid = $("#subregid").val();
                                                    var scltypeslist = $("#scltypeslist").val();
                                                    $.ajax({
                                                        url:"<?= base_url() ?>setup/subjectsperclasses",
                                                        dataType:'json',
                                                        method:'POST',
                                                        data: {schoolid:subschoolid,branchid:subbranchid,sclsyllubas:scltypeslist,regid:subregid},
                                                    })
                                                    .done(function (dataresponce) {
                                                        $("#loader").hide();
                                                        $("#classoptionsbox").show();
                                                        $("#classlisting").children('option:not(:first)').remove();
                                                        console.log(dataresponce);
                                                        var list = "";
                                                        
                                                        for($l = 0; dataresponce.length > $l; $l++){
                                                            list += "<option value='"+ dataresponce[$l] +"'>"+ dataresponce[$l] +"</option>";
                                                        }
                                                        $("#classlisting").append(list);
                                                    })
                                                    .fail(function (req, status, err) {
                                                        console.log('Something went wrong', status, err);
                                                        $("#loader").hide();
                                                    })
                                                }
                                            });

                                            $("#classlisting").change(function () {
                                                var classlisting = $(this).val();
                                                var sclstype = $("#scltypeslist").val();
                                                if(classlisting == ""){
                                                    swal("please select class to add subjects..!");
                                                }else{
                                                    $("#loader").hide();
                                                    $("#noofsubjectsmainbox").show();
                                                }
                                            })

                                            $("#addlistofsubjects").click(function(event) {
                                                /* Act on the event */
                                                var scltypesmode = $("#scltypeslist").val();
                                                var classlisting = $("#classlisting").val();
                                                var subjectboxs = $("#noofsubjectboxs").val();
                                                if(scltypesmode != "" || classlisting != "" || subjectboxs != ""){
                                                    $("#Addsubjects").show();
                                                    var boxes = "";
                                                    for(var i=1;subjectboxs >= i;i++){
                                                        //swal("ok done..!");
                                                        //console.log(i);
                                                        boxes += '<div class="col-md-4"><div class="row"><div class="col-md-10 form-group"><input type="text" name="subjectname[]" class="form-control subjectname" placeholder="Enter subject name"></div><div class="col-md-1"><a href="javascript:void(0);" class="btn btn-sm btn-danger RemoveInput" id="removeinput">X</a></div></div></div>';
                                                    }
                                                    $("#Addsubjects").append(boxes);
                                                    $("#savesubjectsbtn").show();
                                                }else{
                                                    $("#savesubjectsbtn").hide();
                                                    swal("Class , syllabus and no.of subjects type should not be empty..!");
                                                }
                                            })

                                            $("#schoolfeedetailslist").submit(function(e) {
                                                e.preventDefault();
                                                $("#loader").show();
                                                //alert("ok..." + subjectnamecount);
                                                var feelistdata = $("#schoolfeedetailslist").serialize();
                                                //console.log(subjectdata);
                                                $.ajax({
                                                    url: '<?=base_url('Setup/feelistbyclass')?>',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: feelistdata,
                                                })
                                                .done(function(dataresponce) {
                                                    $("#loader").hide();
                                                    console.log(dataresponce);
                                                    if (dataresponce.code == 0) {
                                                        swal({
                                                            title: "Sorry",
                                                            text: dataresponce.message,
                                                            type: "warning",
                                                        },function () {
                                                            //$("#sectionslist").load('subsetups/sms_sections_setup.php' + '#listofsections');
                                                            $("#schoolfeedetailslist").trigger('reset');
                                                            $("#appendfeefields").empty();
                                                            $("#otheramountlistbox").hide();
                                                        });
                                                        //swal("Sorry", dataresponce.message , "warning");
                                                    } else if (dataresponce.code == 1) {
                                                        swal({
                                                            title: "success",
                                                            text: dataresponce.message,
                                                            type: "success",
                                                        }, function () {
                                                            $("#schoolfeedetailslist").trigger('reset');
                                                            $("#appendfeefields").empty();
                                                            $("#otheramountlistbox").hide();
                                                            $('#otheramountlist').trigger('click');
                                                            $("#otheramountlist").removeAttr('checked');
                                                            $("#otheramountlist").prop("checked", false);
                                                            $("#otheramountlist").val('no');
                                                            $("#otheramountlistbox").hide();
                                                            $("#appendfeefields").empty();
                                                            $("input[name='servicename[]']").val('');
                                                            $("input[name='serviceamount[]']").val('');
                                                        
                                                            if(dataresponce.total == dataresponce.current){
                                                                window.location.href = '<?= base_url() ?>dashboard/welcomepage';    
                                                                
                                                            }
                                                        });
                                                    }
                                                })
                                                .fail(function (req, status, err) {
                                                    console.log('Something went wrong', status, err);
                                                    $("#loader").hide();
                                                })
                                            });

                                        });
                                    </script>
                                <?php }else if(isset($othersetup)){ ?>
                                        <!-- Step 4 -->
                                        <h6>Other Details</h6>
                                        <section id="content-2" class="content mCustomScrollbar light" data-mcs-theme="minimal-dark">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="behName1">Behaviour :</label>
                                                        <input type="text" class="form-control required" id="behName1">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="participants1">Confidance</label>
                                                        <input type="text" class="form-control required" id="participants1">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="participants1">Result</label>
                                                        <select class="custom-select form-control required" id="participants1" name="location">
                                                            <option value="">Select Result</option>
                                                            <option value="Selected">Selected</option>
                                                            <option value="Rejected">Rejected</option>
                                                            <option value="Call Second-time">Call Second-time</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="decisions1">Comments</label>
                                                        <textarea name="decisions" id="decisions1" rows="4" class="form-control"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Rate Interviwer :</label>
                                                        <div class="c-inputs-stacked">
                                                            <label class="inline custom-control custom-checkbox block">
                                                                <input type="checkbox" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description ml-0">1 star</span> </label>
                                                            <label class="inline custom-control custom-checkbox block">
                                                                <input type="checkbox" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description ml-0">2 star</span> </label>
                                                            <label class="inline custom-control custom-checkbox block">
                                                                <input type="checkbox" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description ml-0">3 star</span> </label>
                                                            <label class="inline custom-control custom-checkbox block">
                                                                <input type="checkbox" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description ml-0">4 star</span> </label>
                                                            <label class="inline custom-control custom-checkbox block">
                                                                <input type="checkbox" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description ml-0">5 star</span> </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                <?php } ?>
                            </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="text-center text-white mt-3 footersection">
            &copy; <?= date('Y'); ?> all rights reservied.Developed by <a href="#">anuTechnologies</a>
        </div>

    </div>

</section>
<!-- End Wrapper -->
<!-- Bootstrap tether Core JavaScript -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?= base_url() ?>assets/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?= base_url() ?>assets/js/waves.js"></script>
<!--Menu sidebar -->
<!-- <script src="<?//= base_url() ?>assets/js/sidebarmenu.js"></script> -->
<!--stickey kit -->
<!-- <script src="<?//= base_url() ?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="<?//= base_url() ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>-->
<!--Custom JavaScript -->
<script src="<?= base_url() ?>assets/js/custom.min.js"></script>
<!-- icheck -->
<!-- <script src="<?//= base_url() ?>assets/plugins/icheck/icheck.min.js"></script>
<script src="<?//= base_url() ?>assets/plugins/icheck/icheck.init.js"></script> -->
<script src="<?= base_url() ?>assets/js/sweetalert.min.js"></script>

<script src="<?= base_url() ?>assets/plugins/moment/min/moment.min.js"></script>
<!-- <script src="<?= base_url() ?>assets/plugins/wizard/jquery.steps.min.js"></script> -->
<!-- <script src="<?= base_url() ?>assets/plugins/wizard/jquery.validate.min.js"></script> -->
<!-- <script src="<?= base_url() ?>assets/plugins/wizard/steps.js"></script> -->
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="<?= base_url() ?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

<!-- Google CDN jQuery with fallback to local -->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?//= base_url() ?>assets/plugins/scrollbar_plugin/js/minified/jquery-1.11.0.min.js"><\/script>')</script> -->

<script>
    $(document).ready(function () {
        //$(".actions").hide();
    })
</script>
</body>

</html>