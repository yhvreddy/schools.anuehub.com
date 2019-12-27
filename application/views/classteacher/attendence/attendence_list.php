<!-- Container fluid  -->
<?php $schooldata = $this->session->userdata['school']; ?>
<style>
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Attendance</a></li>
        <li class="breadcrumb-item active">Attendance List</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Attendance List<small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="<?=base_url('classteacher/attendence/newadd')?>" class="pull-right btn btn-success btn-xs"><i class="fa fa-plus"></i> New Attendance</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Attendance List</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <form class="row" method="post" action="#" id="myattendence">
                            <div class="col-md-2 col-lg-2 col-sm-6 form-group">
                                 <label>Pick Month / Year</label>
                                 <input type="text" class="form-control mypicker" required name="attendencedate" id="AttendenceDate" value="<?=date('Y-m');?>" placeholder="Pick Attendence Date">
                            </div>
                            <div class="form-group col-md-3 col-lg-3 col-sm-6">
                                <label>Select Attendence type</label>
                                <select required class="form-control" id="attendenceType">
                                    <option value="">Select Attendence type</option>
                                    <option value="std">Student Attendence</option>
                                    <option value="emp">Employee Attendence</option>
                                </select>
                            </div>
                            <div class="col-md-5 form-group" id="stdclass">
                                <div class="row">
                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="sclsyllabuslist">Student Syllabus</label>
                                        <select type="text" name="StdSyllubas" id="sclsyllubaslist" class="form-control" style="padding:0px">
                                            <option value="">Select Syllabus Type</option>
                                            <?php foreach ($syllabus as $key => $value) { ?>
                                                <option value="<?= $key ?>"><?= $value ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="SyllabusClasses">Student Class</label>
                                        <select type="text" name="StdClass" id="SyllabusClasses" class="form-control" disabled="" style="padding:0px 10px">
                                            <option value="">Select Class</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 pull-right">
                                <input class="btn btn-success mt-4" id="getAttendenceData" type="submit" name="submitdata" value="Get Attendence List">
                            </div>
                        </form>
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
    $('#stdclass').hide();
    $(document).ready(function () {
        $('#attendenceType').on('change',function () {
            var attendencetype = $('#attendenceType').val();
            var sclsyllubaslist = $('#sclsyllubaslist').val();
            var SyllabusClasses = $('#SyllabusClasses').val();
            if(attendencetype == 'std'){
                $('#stdclass').show();
                if(sclsyllubaslist != '' || SyllabusClasses != '') {
                    $('#attlistofuser').text('');
                }else{
                    $('#attlistofuser').show();
                }
            }else if(attendencetype == 'emp'){
                if(sclsyllubaslist != '' || SyllabusClasses != '') {
                    $('#attlistofuser').text('');
                }else{
                    $('#attlistofuser').show();
                }
                $('#stdclass').hide();
                $('#sclsyllubaslist').prop('selectedIndex',0);
                $('#SyllabusClasses').prop('selectedIndex',0);
            }
        })

        $('#myattendence').submit(function (e) {
            e.preventDefault();
            $("#loader").show();
            var attendencedate  =   $('#AttendenceDate').val();
            var attendencetype  =   $('#attendenceType').val();
            if(attendencetype == 'std'){
                var syllubastype =  $("#sclsyllubaslist").val();
                var syllabusclass=  $('#SyllabusClasses').val();
                if(syllabusclass != '' && syllubastype != ''){
                    //alert(attendencetype + syllubastype + syllabusclass);
                    $.ajax({
                        url:"<?=base_url('dashboard/attendence/ajax/attendancedatalistfetch')?>",
                        data:{attendancetype:attendencetype,selecteddate:attendencedate,stdclass:syllabusclass,stdsyllubas:syllubastype},
                        type:"POST",
                        success:function(stdsuccess){
                            $("#loader").hide();
                            $("#attlistofuser").html(stdsuccess);
                        }
                    })
                }else{
                    alert('Please Select Syllabus and Student Class');
                    $("#loader").hide();
                }
            }else if(attendencetype == 'emp'){
                $.ajax({
                    url:"<?=base_url('dashboard/attendence/ajax/attendancedatalistfetch')?>",
                    data:{atttype:attendencetype,seldate:attendencedate,attmode:"employees"},
                    type:"POST",
                    success:function(empsuccess){
                        $("#loader").hide();
                        $("#attlistofuser").html(empsuccess);
                    }
                })
            }else{
                alert('Invalid Request..!');
                $("#loader").hide();
            }
        })
    })
</script>
