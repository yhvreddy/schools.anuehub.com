<!-- Container fluid  -->
<?php $schooldata = $this->session->userdata['school']; ?>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Salary</a></li>
        <li class="breadcrumb-item active">Salary Payment</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Salary Payment's<small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="<?=base_url('dashboard/salary/salarypaymentlist')?>" class="pull-right btn btn-success btn-xs"><i class="fa fa-list"></i> Salary List</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Salary Payment's</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 col-sm-12">
                                <form class="row" id="SearchEmployeePayment" action="#" method="post">
                                    <div class="col-md-10 col-lg-10 col-sm-10">
                                        <div class="form-group">
                                            <label>Enter Employee id </label>
                                            <input type="text" required class="form-control text-capitalize" placeholder="Enter Employee id" name="Admissionid" id="Admissionid">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-sm-2">
                                        <button class="btn btn-success mt-4" id="AdmissionidData" type="submit" name="submitAdmissionData"> <i class="fa fa-search"></i> </button>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="col-md-9 col-lg-9 col-sm-12">
                                <form method="post" action="#" id="searchpaymentlist">
                                    <div class="col-md-12 col-lg-12 col-sm-12 form-group">
                                        <div class="row justify-content-center align-items-center">

                                            <div class="col-xs-12 col-sm-6 col-md-4">
                                                <label>Employee Type <span class="text-red">*</span></label>
                                                <div class="form-group">
                                                    <select class="form-control select2" id="employeetype" name="emptype" required>
                                                        <option value="" selected>Employee type</option>
                                                        <?php foreach ($employee as $employees) { ?>
                                                            <option value="<?= $employees->shortname ?>"><?= $employees->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4 staff">
                                                <label>Staff Type</label>
                                                <div class="form-group">
                                                    <select class="form-control select2" id="sct" name="emppti" style="width: 100%">
                                                        <option value="">Select Staff type</option>
                                                        <?php foreach ($staff as $staffs) { ?>
                                                            <option value="<?= $staffs->shortname ?>"><?= $staffs->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!--<div class="col-xs-12 col-sm-6 col-md-5 empclass">
                                                <div class="row">
                                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                        <label for="sclsyllabuslist">School Syllabus</label>
                                                        <select type="text" name="StdSyllubas" id="sclsyllubaslist" class="form-control select2" style="width: 100%">
                                                            <option value="">Syllabus Type</option>
                                                            <?php //foreach ($syllabus as $key => $value) { ?>
                                                                <option value="<?//= $key ?>"><?//= $value ?></option>
                                                            <?php //} ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                        <label for="SyllabusClasses">Select Class</label>
                                                        <select type="text" name="empclass" id="SyllabusClasses" class="form-control select2" disabled="" style="width: 100%">
                                                            <option value="">Class</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>-->

                                            <div class="col-xs-12 col-sm-6 col-md-4 workers">
                                                <label>Workers Type</label>
                                                <div class="form-group">
                                                    <select class="form-control show-tick select2" name="emppoti" style="width: 100%">
                                                        <option value="">Select worker type</option>
                                                        <?php foreach ($worker as $workers) { ?>
                                                            <option value="<?= $workers->shortname ?>"><?= $workers->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-6 col-md-4 assistant">
                                                <label>Office assistant Type </label>
                                                <div class="form-group">
                                                    <select class="form-control show-tick select2" name="empoffic" style="width: 100%">
                                                        <option value="">Select assistant type</option>
                                                        <?php foreach ($office as $offices) { ?>
                                                            <option value="<?= $offices->shortname ?>"><?= $offices->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-1 col-lg-1 col-sm-1">
                                                <button class="btn btn-success mt-2" id="searchpaymentlistData" type="submit" name="submitlistdata"> <i class="fa fa-search"></i> </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 table-responsive" id="attlistofuser">
                        <div class="" style="margin:40px 0px">
                            <center>
                                <h4>Please select following options</h4>
                                <img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>">
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
<script>
    $(document).ready(function(){
        var selemployeetype = $("#employeetype").val();
        if($('#employeetype').attr("value")==""){
            $('.staff').hide();
            $('.workers').hide();
            $('.assistant').hide();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }
        if($('#employeetype').attr("value")=="staff"){
            $('.staff').show();
            $('.workers').hide();
            $('.assistant').hide();
        }
        if($('#employeetype').attr("value")=="worker"){
            $('.staff').hide();
            $('.workers').show();
            $('.assistant').hide();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }
        if($('#employeetype').attr("value")=="office"){
            $('.staff').hide();
            $('.workers').hide();
            $('.assistant').show();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }

        var sct = $("#sct").val();
        if($('#sct').attr("value")==""){
            $('.empclass').hide();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }
        if($('#sct').attr("value")=="teacher"){
            $('.empclass').hide();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }
        if($('#sct').attr("value")=="classteacher"){
            $('.empclass').show();
        }
        if($('#sct').attr("value")=="tutor"){
            $('.empclass').hide();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }

        $("#employeetype").change(function(){
            $( "#employeetype option:selected").each(function(){
                if($(this).attr("value")==""){
                    $('.staff').hide();
                    $('.workers').hide();
                    $('.assistant').hide();
                    $('.empsubjects').hide();
                    $('.empclass').hide();
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
                if($(this).attr("value")=="staff"){
                    $('.staff').show();
                    $('.workers').hide();
                    $('.assistant').hide();
                    $('.empsubjects').show();

                }
                if($(this).attr("value")=="worker"){
                    $('.staff').hide();
                    $('.workers').show();
                    $('.assistant').hide();
                    $('.empsubjects').hide();
                    $('.empclass').hide();
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
                if($(this).attr("value")=="office"){
                    $('.staff').hide();
                    $('.workers').hide();
                    $('.assistant').show();
                    $('.empsubjects').hide();
                    $('.empclass').hide();
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
            })
        }).change();
    });

    $(document).ready(function(){
        $("#sct").change(function(){
            $( "#sct option:selected").each(function(){
                if($(this).attr("value")==""){
                    $('.empclass').hide();
                    $("#sctclass").val("");
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
                if($(this).attr("value")=="teacher"){
                    $('.empclass').hide();
                    $("#sctclass").val("");
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
                if($(this).attr("value")=="classteacher"){
                    $('.empclass').show();
                    $("#sctclass").val("");
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
                if($(this).attr("value")=="tutor"){
                    $('.empclass').hide();
                    $("#sctclass").val("");
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
            })
        }).change();

        $("#Environmentid").keyup(function(event) {
            var environmentid = $(this).val();
            if(environmentid.length != ''){

                $.ajax({
                    url: "<?=base_url('defaultmethods/envernmentalid')?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {environmentid: environmentid},
                })
                    .done(function(dataresponce) {
                        console.log(dataresponce);
                        if(dataresponce.code == 1){
                            $("#Environmentid").css('color', 'red');
                            $("#Environmentid").focus();
                            //$("#Environmentiderror").text(dataresponce.message).css('color','red');
                        }else{
                            $("#Environmentid").css('color', 'green');
                            //$("#fname").focus();
                        }
                    })
                    .fail(function(req, status, err) {
                        console.log('Something went wrong', status, err);
                    })

            }else{
                $("#Environmentiderror").text('Enter valid Environmentid').css('color','red');
                $("#Environmentid").focus();
            }
        });

    });

    $('#stdclass').hide();
    
    $(document).ready(function () {
        var image = '<?=base_url("assets/images/pleaseselect _leftindcate.png")?>';
        var selectdata = "<div class='' style='margin:40px 0px'><center><h4>Please select following options</h4><img class='img-responsive' src='"+image+"'></center></div>";

        //admission type
        $('#SearchEmployeePayment').submit(function (e) {
            e.preventDefault();
            //$('#sclsyllubaslist').prop('selectedIndex',0);
            //$('#SyllabusClasses').prop('selectedIndex',0);
            var admissionid = $('#Admissionid').val();
            if(admissionid != ''){
                $.ajax({
                    url:"<?=base_url('dashboard/salary/ajax/employeelist')?>",
                    data:{admissionid:admissionid,submition:'singledata'},
                    type:"POST",
                    success:function(successdata){
                        $("#loader").hide();
                        $("#attlistofuser").html(successdata);
                        $("#Admissionid").val('');
                    }
                });
            }else{
                alert('Please Enter Employee Id..!');
                $("#Admissionid").val('');
            }
        })



        $('#sclsyllubaslist,#SyllabusClasses').change(function () {
            $('#attlistofuser').html(selectdata);
            $('#Admissionid').val('');
        });

        $('#searchpaymentlist').submit(function (e) {
            e.preventDefault();
            $("#loader").show();
            var formdata = $('#searchpaymentlist').serialize();
            //if(syllabusclass != '' && syllubastype != ''){
                //alert(attendencetype + syllubastype + syllabusclass);
            $.ajax({
                url:"<?=base_url('dashboard/salary/ajax/employeelist')?>",
                data:formdata,
                type:"POST",
                success:function(successdata){
                    $("#loader").hide();
                    $("#attlistofuser").html(successdata);
                }
            });

        })
    });
</script>