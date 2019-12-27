<!-- Container fluid  -->
<?php $schooldata = $this->session->userdata['school']; ?>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Fee Payments</a></li>
        <li class="breadcrumb-item active">Collect Payment</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Collect Fee Payment's<small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="<?=base_url('dashboard/feepayments/feepaymentlist')?>" class="pull-right btn btn-success btn-xs"><i class="fa fa-list"></i> Fee List</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Collect Fee Payment's</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <form class="row" id="SearchStudentPayment" action="#" method="post">
                                    <div class="col-md-8 col-lg-8 col-sm-8">
                                        <div class="form-group">
                                            <label>Enter Admission id </label>
                                            <input type="text" required class="form-control text-capitalize" placeholder="Enter Admission id" name="Admissionid" id="Admissionid">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-4">
                                        <input class="btn btn-success mt-4" id="AdmissionidData" type="submit" name="submitAdmissionData" value="Search Data">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8 col-lg-8">
                                <form class="row" method="post" action="#" id="searchpaymentlist">
                                    <div class="col-md-10 col-lg-10 col-sm-10 form-group">
                                        <div class="row">
                                            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <label for="sclsyllabuslist">Student Syllabus</label>
                                                <select type="text" name="StdSyllubas" id="sclsyllubaslist" class="form-control select2" style="padding:0px">
                                                    <option value="">Select Syllabus Type</option>
                                                    <?php foreach ($syllabus as $key => $value) { ?>
                                                        <option value="<?= $key ?>"><?= $value ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <label for="SyllabusClasses">Student Class</label>
                                                <select type="text" name="StdClass" id="SyllabusClasses" class="form-control select2" disabled="" style="padding:0px 10px">
                                                    <option value="">Select Class</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-sm-2 pull-right">
                                        <input class="btn btn-success mt-4" id="searchpaymentlistData" type="submit" name="submitlistdata" value="Search Data">
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
    $('#stdclass').hide();
    $(document).ready(function () {

        var image = '<?=base_url("assets/images/pleaseselect _leftindcate.png")?>';
        var selectdata = "<div class='' style='margin:40px 0px'><center><h4>Please select following options</h4><img class='img-responsive' src='"+image+"'></center></div>";

        //admission type
        $('#SearchStudentPayment').submit(function (e) {
            e.preventDefault();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
            var admissionid = $('#Admissionid').val();
            if(admissionid != ''){
                $.ajax({
                    url:"<?=base_url('dashboard/feepayments/ajax/addmissionlist')?>",
                    data:{admissionid:admissionid},
                    type:"POST",
                    success:function(successdata){
                        $("#loader").hide();
                        $("#attlistofuser").html(successdata);
                    }
                });
            }else{
                alert('Please Enter Admission Id..!');
            }
        })



        $('#sclsyllubaslist,#SyllabusClasses').change(function () {
            $('#attlistofuser').html(selectdata);
            $('#Admissionid').val('');
        });

        $('#searchpaymentlist').submit(function (e) {
            e.preventDefault();
            $("#loader").show();
            var syllubastype =  $("#sclsyllubaslist").val();
            var syllabusclass=  $('#SyllabusClasses').val();
            if(syllabusclass != '' && syllubastype != ''){
                //alert(attendencetype + syllubastype + syllabusclass);
                $.ajax({
                    url:"<?=base_url('dashboard/feepayments/ajax/addmissionlist')?>",
                    data:{stdclass:syllabusclass,stdsyllubas:syllubastype},
                    type:"POST",
                    success:function(successdata){
                        $("#loader").hide();
                        $("#attlistofuser").html(successdata);
                    }
                });
            }else{
                alert('Please Select Syllabus and Class');
                $("#loader").hide();
            }

        })
    })
</script>