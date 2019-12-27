<!-- Container fluid  -->
<style>
    .dropify-wrapper{
        height: 35px !important;
        font-size:15px !important;
    }
    .dropify-message{
        padding-bottom: 8px;
    }
    .dropify-wrapper .dropify-message span.file-icon {
        font-size: 20px;
        display: initial;
    }
    .dropify-message p{
        margin: 0px !important;
        font-size: 6px;
        line-height: 1px;
    }
    .dropify-font:before{
        
    }
</style>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Admissions</a></li>
        <li class="breadcrumb-item active">New Admissions</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Admission <small></small></h1>
    <!-- end page-header -->

    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:void(0);" class="pull-right btn btn-success btn-xs"><i class="fa fa-list"></i> Admissions List</a>
                    </div>
                    <h4 class="panel-title">New Admission</h4>
                </div>
                <div class="panel-body">
                    <form method="post" class="floating-labels" enctype="multipart/form-data" action="<?=base_url('dashboard/admissions/saveadmissions')?>">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-capitalize">
                            <?php
								$enquiry = $enquirydata['0'];
								$classlist = unserialize($classes['0']->class);
								if(!empty($enquiry->dob)){ $dob = date('m/d/Y',strtotime($enquiry->dob)); }else{ $dob = ''; }
								//echo "<pre>"; print_r($enquiry); echo "</pre>"; ?>
                            <div class="panel panel-default">
                                <div class="panel-heading"><h5 class="text-success">Student Details</h5></div>
                                <div class="panel-body">
                                    <input type="hidden" name="enquiryid" value="<?=$enquiry->id_num;?>">
                                    <div class="row">
                                        <?php if($scltype == 'GB'){ ?>
                                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                               <div class="form-group">
                                                   <label for="sclbranch">Select Branch: <span class="text-danger"> * </span></label>
                                                   <select class="form-control" name="schoolid" id="sclbranch" disabled>
                                                        <option selected value="<?= $schoolid; ?>">This Branch</option>
                                                        <?php foreach($branchlist as $branchs){ ?>
                                                            <option value="<?=$branchs->school_id?>"><?=$branchs->branchname.' - '.$branchs->school_id; ?></option>
                                                        <?php } ?>
                                                   </select>
                                                   <span class="bar"></span>
                                               </div>
                                            </div>
                                        <?php }else{ ?>
                                            <input type='hidden' value="<?= $schoolid; ?>" name="schoolid">
                                        <?php } ?>
                                        <input type='hidden' value="<?= $branchid; ?>" name="branchid">

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="Environmentid">Enter Environment ID <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" maxlength="25" name="environmentid" placeholder="Enter Environment Id" id="Environmentid" value="<?=$environment_id?>" readonly required="" minlength="8">
                                                <span class="bar"></span>
                                                <small id="Environmentiderror"></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="fname">Enter First Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" value="<?=$enquiry->firstname;?>" name="stdfname" placeholder="Enter First Name" id="fname" required="">
                                                <span class="bar"></span>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label for="Lname">Enter Last Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" value="<?=$enquiry->lastname;?>" name="stdlname" placeholder="Enter Last Name" id="Lname" required="">
                                                <span class="bar"></span>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label for="ParentsName">Father or Mother Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="stdfmname" value="<?=$enquiry->fathername;?>" placeholder="Enter Father or Mother Name" id="ParentsName" required="">
                                                <span class="bar"></span>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="stdgender">Select Gender <span class="text-danger">*</span></label>
                                                <select class="form-control" name="stdgender" id="stdgender" required="" style="padding: 0px;">
                                                    <option value=""></option>
                                                    <?php foreach ($gender as $genders) { if($genders->shortname == $enquiry->gender){ ?>
                                                        <option value="<?= $genders->shortname ?>" selected=''><?= $genders->name ?></option>
                                                    <?php }else{ ?>
                                                        <option value="<?= $genders->shortname ?>"><?= $genders->name ?></option>
                                                    <?php }} ?>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>

                                        <div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <label for="sclsyllabuslist">Student Syllabus</label>
                                            <select type="text" name="StdSyllubas" id="sclsyllubaslist" class="form-control" required style="padding:0px">
                                                <option value=""></option>
                                                <?php foreach ($syllabus as $key => $value) { if($key == $enquiry->class_type){ ?>
                                                    <option value="<?= $key ?>" selected=""><?= $value ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $key ?>"><?= $value ?></option>
                                                <?php } } ?>
                                            </select>
                                            <span class="bar"></span>
                                        </div>

                                        <div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <label for="sclsyllabuslist">Student Syllabus</label>
                                            <select type="text" name="StdClass" id="SyllabusClasses" class="form-control" style="padding:0px 10px">
                                                <option value="">Select Class</option>
                                                <?php foreach ($classlist as $classvalue) {
                                                    if($enquiry->class == $classvalue){ ?>
                                                        <option value="<?= $classvalue ?>" selected=""><?= $classvalue ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $classvalue ?>"><?= $classvalue ?></option>
                                                <?php } } ?>
                                            </select>
                                            <span class="bar"></span>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="mdate">Date OF Birth <span class="text-red">*</span></label>
                                                <input type="text" class="form-control mydatepicker" value="<?= $dob; ?>" placeholder="Pick Date of Birth" name="DOB" id="mdate" required="">
                                                <span class="bar"></span>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="Nationality">Nationality</label>
                                                <input type="text" class="form-control" name="Nationality" id="Nationality" placeholder="Enter Nationality">
                                                <span class="bar"></span>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="Religion">Religion</label>
                                                <input type="text" class="form-control" placeholder="Enter Religion" name="Religion" id="Religion">
                                                <span class="bar"></span>
                                            </div>
                                        </div>


                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="Mobileno">Mobile Number<span class="text-red">*</span></label>
                                                <input type="tel" class="form-control" name="mobile" id="Mobileno" required="" maxlength="10" placeholder="Enter Mobile Number" value="<?= $enquiry->mobile ?>">
                                                <span class="bar"></span>
                                            </div>
                                        </div>


                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="phnno">Alter Mobile</label>
                                                <input type="tel" class="form-control" placeholder="Enter Alternate Number" name="altermobile" id="phone" maxlength="16">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="emid">Enter eMail Id <span class="text-red">*</span></label>
                                                <input type="text" value="<?= $enquiry->mail_id ?>" placeholder="Enter Mail Id" class="form-control" name="emailid" id="emid" required="">
                                                <span class="bar"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label for="CountryName">Select country.. <span class="text-danger">*</span></label>
                                            <select name="CountryName" id="CountryName" class="form-control p-0" required>
                                                <option value=""></option>
                                                <?php foreach ($countries as $country){
                                                    if($country->id == $enquiry->country_id){
                                                ?>
                                                    <option selected value="<?= $country->id ?>"><?= $country->name ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $country->id ?>"><?= $country->name ?></option>
                                                <?php } } ?>
                                            </select>
                                            <span class="bar"></span>
                                            <small id="selectcountryerror"></small>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label for="StateName">Select State Name <span class="text-danger">*</span></label>
                                            <select name="StateIdName" id="StateName" class="form-control p-0" required>
                                                <option value=""></option>
                                                <?php
                                                    $states = $this->Model_dashboard->selectdata('sms_states',array('country_id'=>$enquiry->country_id));
                                                    foreach($states as $state){
                                                    if($state->id == $enquiry->state_id){
                                                    ?>
                                                    <option selected="" value="<?= $state->id ?>"><?= $state->name ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $state->id ?>"><?= $state->name ?></option>
                                                <?php } }?>
                                            </select>
                                            <span class="bar"></span>
                                            <small id="selectstateerror"></small>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label for="CityName">Select City / Dist Name <span class="text-danger">*</span></label>
                                            <select name="CityIdName" id="CityName" class="form-control p-0" required>
                                                <option value=""></option>
                                                <?php
                                                    $cities = $this->Model_dashboard->selectdata('sms_cities',array('state_id'=>$enquiry->state_id));
                                                    foreach($cities as $city){
                                                    if($city->id == $enquiry->city_id){
                                                    ?>
                                                    <option selected="" value="<?= $city->id ?>"><?= $city->name ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $city->id ?>"><?= $city->name ?></option>
                                                <?php } }?>
                                            </select>
                                            <span class="bar"></span>
                                            <small id="selectcityerror"></small>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                            <label for="padd">Enter Address <span class="text-red">*</span></label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="<?= $enquiry->address ?>" name="address" placeholder="Enter Address" id="padd" required="">
                                                <span class="bar"></span>
                                            </div>
                                        </div>

                                        <!-- <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <label>Town/City <span class="text-red">*</span></label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Enter town/city" name="cityname" id="tadd" required="">
                                            </div>
                                        </div> -->

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <label for="pcode">Your Pincode <span class="text-red">*</span></label>
                                            <div class="form-group">
                                                <input type="tel" class="form-control" value="<?= $enquiry->pincode ?>" name="pincode" placeholder="Enter Pincode" id="pcode" required="" maxlength="6">
                                                <span class="bar"></span>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="stdservice">Select Service <span class="text-red">*</span></label>
                                                <select class="form-control" name="stdservice" id="stdservice" required="" style="padding: 0px">
                                                    <option value="">Select Service</option>
                                                    <?php foreach ($services as $service) { ?>
                                                        <option value="<?= $service->shortname ?>"><?= $service->name ?></option>
                                                    <?php } ?>
                                                </select>
                                                <span class="bar"></span>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                            <div class="form-group">
                                                <label for="stdservice">Select Blood group <span class="text-red">*</span></label>
                                                <select class="form-control" name="stdbloodgroup" id="stdbloodgroup" required="" style="padding: 0px">
                                                    <option value="">Select Blood group</option>
                                                    <?php foreach ($bloodgroups as $bloodgroup) { ?>
                                                        <option value="<?= $bloodgroup->shortname; ?>"><?= $bloodgroup->shortname; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <label for="simage">Upload Student Image</label>
                                            <div class="form-group">
                                                <input type="file" class="form-control dropify" name="stdimage" id="stdimage" accept=".jpg,.png">
                                            </div>
                                        </div>

        <!--                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">-->
        <!--                                    <div class="form-group">-->
        <!--                                        <label for="AadhaarCard">Aadhaar Card No  <span class="text-red">*</span></label>-->
        <!--                                        <input type="text" class="form-control" value="--><?php $enquiry->aadhaar; ?><!--" name="aadhaarcard" id="AadhaarCard" required="" maxlength="14">-->
        <!--                                        <span class="bar"></span>-->
        <!--                                    </div>-->
        <!--                                </div>-->

                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label id="mole">Moles <span class="text-red">*</span></label>
                                                <input type="text" placeholder="Enter Identification Moles" class="form-control" name="moles" id="mole" required="">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading"><h5 class="text-capitalize text-success">Parents <small>or</small> Gaurdian Info</h5></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label for="pgname">Parents <small>or</small> Gaurdian Name <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" name="parentsname" id="pgname" required="">
                                                <span class="bar"></span>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label id="occ">Occupation <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" name="occupation" id="occ" required="">
                                                <span class="bar"></span>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label id="mno">Mobile No <span class="text-red">*</span></label>
                                                <input type="tel" class="form-control" name="parentsmobile" id="mno" required="" maxlength="10">
                                                <span class="bar"></span>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label for="emid">Email-Id <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" name="parentsmailid" id="emid" required="">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <label for="simage">Upload parent / Gaurdian Image</label>
                                            <div class="form-group">
                                                <input type="file" class="form-control dropify" name="stdparentimage" id="stdparentimage" accept=".jpg,.png">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">
                                            <div class="form-group">
                                                <label for="addr">Address</label>
                                                <input type="text" class="form-control" name="parentsaddress" id="addr">
                                            </div>
                                        </div>

                                        <!-- <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <label>City / Town</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Your City" name="parentscity" id="city">
                                            </div>
                                        </div> -->

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">

                                            <div class="form-group">
                                                <label for="pcode">Pincode</label>
                                                <input type="tel" class="form-control" name="parentspincode" id="pcode" maxlength="6">
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading"><h5 class="text-success">Fee Details</h5></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-12 col-lg-12">
                                            <div class="row" id="FeeDetailsBox">
                                                <div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
                                                    <label for="schoolfee">School Fee <span class="text-red">*</span></label>
                                                    <div class="form-group">
                                                        <input type="number" id="schoolfee" class="form-control" placeholder="School Fee" name="feeamount[]" required="" readonly="">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="feetype[]" value="school">

                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                    <label for="dailyservice">Hostel / Daily Service</label>
                                                    <div class="form-group">
                                                        <input type="number" class="form-control" placeholder="Hostel / Daily Service" name="feeamount[]" id="ServiceFee" readonly="">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="feetype[]" value="service">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
                                            <label>Total Fee <span class="text-red">*</span></label>
                                            <div class="form-group">
                                                <input type="number" class="form-control" placeholder="Total Fee" name="totalfee" id="totalfee" readonly="">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-success pull-right" value="New Admission" id="newadmission" name="newadmission">
                                </div>
                            </div>

                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid --> 
<script type="text/javascript">
    $(document).ready(function($) {

        $("#SyllabusClasses").change(function(event) {
            var classname = $(this).val();
            if(classname.length != 0){
                $("#stdservice").removeAttr('disabled');    
            }else{
                $("#stdservice").prop('disabled', 'TRUE');
            } 
            
        });

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
                        $("#Environmentiderror").text(dataresponce.message).css('color','red');
                    }else{
                        $("#Environmentid").css('color', 'green');
                        $("#Environmentiderror").text('');
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

        $("#stdservice").change(function(event) {
            var classname = $("#SyllabusClasses").val();
            var syllabus = $("#sclsyllubaslist").val();
            var service = $(this).val();
            if(classname == ''){
                swal("select class");
            }else if(syllabus == ''){
                swal('Syllabus type');
            }else if(service == ''){
                swal('Select Service type');
            }else if(classname != '' && syllabus !=''){
                $("#loader").show();
                $.ajax({
                    url: "<?=base_url('defaultmethods/feedetailsofclass')?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {syllabus:syllabus,classname:classname,service:service},
                })
                .done(function(dataresponce) {
                    console.log(dataresponce);
                    $("#loader").hide();
                    if(dataresponce.code == 1){
                        $("#schoolfee").val(dataresponce.data.school);
                        $("#ServiceFee").val(dataresponce.data.servicefee);
                        var feeotherlist='';
                        var othertotal = 0;
                        $(".otherAmountBOxs").remove();
                        //if(dataresponce.data.other.length != ''){    
                            $.each(dataresponce.data.other,function(index, el) {
                                if(index.length != '' && el.length != ''){
                                    feeotherlist += '<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2 otherAmountBOxs"><label for="'+ index +'">'+ index +'</label><div class="form-group"><input type="number" class="form-control" placeholder="'+ index +'" value="'+ el +'" name="feeamount[]" id="'+ index +'"></div><input type="hidden" name="feetype[]" value="'+ index +'"></div>';
                                    othertotal += parseInt(el) || 0;
                                }
                            });
                        //}
                        var totalamount = parseInt(dataresponce.data.school) + parseInt(dataresponce.data.servicefee) + parseInt(othertotal);
                        $("#FeeDetailsBox").append(feeotherlist);
                        $("#totalfee").val(totalamount);
                    }else{

                    }
                })
                .fail(function(req, status, err) {
                    console.log('Something went wrong', status, err);
                    $("#loader").hide();
                })        
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        //class
        var classval = $("#sclsyllubaslist").val();
        if(classval != ''){
            $("#SyllabusClasses").removeAttr('disabled');
        }else{
            $("#SyllabusClasses").prop('disabled','true');
        }
    })    
</script>
