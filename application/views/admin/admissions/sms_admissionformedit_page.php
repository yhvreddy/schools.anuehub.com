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
        <li class="breadcrumb-item active">Edit Admissions</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Edit Admission Details<small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Edit Admission Details</h4>
                </div>
                <div class="panel-body">
                    <form method="post" class="floating-labels" action="<?=base_url('dashboard/admission/saveeditadmission')?>" enctype="multipart/form-data">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-capitalize">
                            <?php $enquiry = $enquirydata['0']; $enquiry->feeamount = unserialize($enquiry->feeamount); $classlist = unserialize($classes['0']->class);  //echo "<pre>"; print_r($enquiry); echo "</pre>"; ?>
                            <div class="panel panel-default">
                                <div class="panel-heading"><h5 class="text-success">Student Details</h5></div>
                                <div class="panel-body">
                                    <input type="hidden" name="enquiryid" value="<?=$enquiry->id_num;?>">
                                    <input type="hidden" name="admission_sno_id" value="<?=$enquiry->sno;?>">
                                    <div class="row">
                                        <?php if($scltype == 'GB'){ ?>
                                            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                               <div class="form-group">
                                                   <label for="sclbranch">Select Branch: <span class="text-danger"> * </span></label>
                                                   <select class="form-control" name="" disabled="" id="sclbranch">
                                                        <option selected value="<?= $schoolid; ?>">This Branch</option>
                                                        <?php foreach($branchlist as $branchs){ ?>
                                                            <option value="<?=$branchs->school_id?>"><?=$branchs->branchname.' - '.$branchs->school_id; ?></option>
                                                        <?php } ?>
                                                   </select>
                                               </div>
                                            </div>
											<input type='hidden' value="<?= $schoolid; ?>" name="schoolid">
                                        <?php }else{ ?>
                                            <input type='hidden' value="<?= $schoolid; ?>" name="schoolid">
                                        <?php } ?>
                                        <input type='hidden' value="<?= $branchid; ?>" name="branchid">

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="Environmentid">Enter Environment ID <span class="text-danger">*</span></label>
                                                <input type="text" readonly="" class="form-control" maxlength="12" name="environmentid" id="Environmentid" required="" value="<?= $enquiry->em_id; ?>">
                                                <small id="Environmentiderror"></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="fname">Enter First Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter FirstName" value="<?=$enquiry->firstname;?>" name="stdfname" id="fname" required="">
                                            </div>
                                        </div>


                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label for="Lname">Enter Last Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="Enter LastName" value="<?=$enquiry->lastname;?>" name="stdlname" id="Lname" required="">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label for="ParentsName">Father or Mother Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="stdfmname" value="<?=$enquiry->fathername;?>" placeholder="Enter Father or Mother Name" id="ParentsName" required="">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="stdgender">Select Gender <span class="text-danger">*</span></label>
                                                <select class="form-control" name="stdgender" id="stdgender" required="" style="padding: 0px;">
                                                    <option value="">Select Gender</option>
                                                    <?php foreach ($gender as $genders) { if($genders->shortname == $enquiry->gender){ ?>
                                                        <option value="<?= $genders->shortname ?>" selected=''><?= $genders->name ?></option>
                                                    <?php }else{ ?>
                                                        <option value="<?= $genders->shortname ?>"><?= $genders->name ?></option>
                                                    <?php }} ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <label for="sclsyllabuslist">Student Syllabus</label>
                                            <select type="text" name="StdSyllubas" id="sclsyllubaslist" class="form-control" style="padding:0px">
                                                <option value="">Select Syllabus</option>
                                                <?php foreach ($syllabus as $key => $value) { if($key == $enquiry->class_type){ ?>
                                                    <option value="<?= $key ?>" selected=""><?= $value ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $key ?>"><?= $value ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <label for="SyllabusClasses">Student Class</label>
                                            <select type="text" name="StdClass" id="SyllabusClasses" class="form-control" style="padding:0px 10px">
                                                <option value="">Select Class</option>
                                                <?php foreach ($classlist as $classvalue) {
                                                    if($enquiry->class == $classvalue){ ?>
                                                        <option value="<?= $classvalue ?>" selected=""><?= $classvalue ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $classvalue ?>"><?= $classvalue ?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="mdate">Date OF Birth <span class="text-red">*</span></label>
                                                <input type="text" class="form-control mydatepicker" value="<?= $enquiry->dob ?>" name="DOB" id="mdate" placeholder="pick DateofBirth" required="">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="Nationality">Nationality</label>
                                                <input type="text" value="<?= $enquiry->nationality ?>" class="form-control" placeholder="Enter Nationality" name="Nationality" id="Nationality">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="Religion">Religion</label>
                                                <input type="text" value="<?= $enquiry->religion ?>" class="form-control" name="Religion" id="Religion" placeholder="Enter Religion">
                                            </div>
                                        </div>


                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="Mobileno">Mobile Number<span class="text-red">*</span></label>
                                                <input type="tel" class="form-control" name="mobile" id="Mobileno" placeholder="Enter Student Mobile Number" required="" maxlength="10" value="<?= $enquiry->mobile ?>">
                                            </div>
                                        </div>


                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="phnno">Alter Mobile</label>
                                                <input type="tel" class="form-control" value="<?= $enquiry->altermobile ?>" placeholder="Enter Alter Mobile Number" name="altermobile" id="phnno" maxlength="16">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="emid">Enter eMail Id <span class="text-red">*</span></label>
                                                <input type="text" value="<?= $enquiry->mail_id ?>" class="form-control" name="emailid" placeholder="Enter Mail id" id="emid" required="">
                                            </div>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label for="CountryName">Select country.. <span class="text-danger">*</span></label>
                                            <select name="CountryName" id="CountryName" class="form-control p-0" required>
                                                <option value="">Select Country Name</option>
                                                <?php foreach ($countries as $country){
                                                    if($country->id == $enquiry->country_id){
                                                ?>
                                                    <option selected value="<?= $country->id ?>"><?= $country->name ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $country->id ?>"><?= $country->name ?></option>
                                                <?php } } ?>
                                            </select>
                                            <small id="selectcountryerror"></small>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="StateName">Select State Name <span class="text-danger">*</span></label>
                                            <select name="StateIdName" id="StateName" class="form-control p-0" required>
                                                <option value="">Select State Name</option>
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
                                            <small id="selectstateerror"></small>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label for="CityName">Select City / Dist Name <span class="text-danger">*</span></label>
                                            <select name="CityIdName" id="CityName" class="form-control p-0" required>
                                                <option value="">Select City / Dist Name</option>
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
                                            <small id="selectcityerror"></small>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                            <label for="padd">Enter Address <span class="text-red">*</span></label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="<?= $enquiry->address ?>" placeholder="Enter Address" name="address" id="padd" required="">
                                            </div>
                                        </div>

                                        <!-- <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <label>Town/City <span class="text-red">*</span></label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Enter town/city" name="cityname" id="tadd" required="">
                                            </div>
                                        </div> -->

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <label>Pincode <span class="text-red">*</span></label>
                                            <div class="form-group">
                                                <input type="tel" class="form-control" value="<?= $enquiry->pincode ?>" placeholder="Enter Pincode" name="pincode" id="pcode" required="" maxlength="">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="stdservice">Select Service <span class="text-red">*</span></label>
                                                <select class="form-control" name="stdservice" id="stdservice" required="" style="padding: 0px">
                                                    <option value="">Select Service</option>
                                                    <?php foreach ($services as $service) { if($service->shortname == $enquiry->service){ ?>
                                                        <option selected="" value="<?= $service->shortname ?>"><?= $service->name ?></option>
                                                    <?php }else{ ?>
                                                        <option value="<?= $service->shortname ?>"><?= $service->name ?></option>
                                                    <?php } } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                                            <div class="form-group">
                                                <label for="stdservice">Select Blood group <span class="text-red">*</span></label>
                                                <select class="form-control" name="stdbloodgroup" id="stdbloodgroup" required="" style="padding: 0px">
                                                    <option value="">Select Blood group</option>
                                                    <?php foreach ($bloodgroups as $bloodgroup) { ?>
                                                        <option <?php if($enquiry->blood_group == $bloodgroup->shortname){ echo 'selected'; } ?> value="<?= $bloodgroup->shortname; ?>"><?= $bloodgroup->shortname; ?></option>
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
                                        <input type="hidden" value="<?=$enquiry->student_image?>" name="uploadedstudent_image">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                            <div class="form-group">
                                                <label id="mole">Moles <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" value="<?= $enquiry->moles; ?>" placeholder="Enter Student Identity moles" name="moles" id="mole" required="">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading"><h5 class="text-capitalize text-success">Parents <small>or</small> Gaurdian Details</h5></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label for="pgname">Parents <small>or</small> Gaurdian <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" value="<?= $enquiry->pname ?>" placeholder="Enter Parent Name" name="parentsname" id="pgname" required="">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label id="occ">Occupation <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" value="<?= $enquiry->pdegination ?>" placeholder="Enter Occupation" name="occupation" id="occ" required="">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label id="mno">Mobile No <span class="text-red">*</span></label>
                                                <input type="tel" class="form-control" value="<?= $enquiry->pphone ?>" name="parentsmobile" placeholder="Enter Mobile Number" id="mno" required="" maxlength="10">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <div class="form-group">
                                                <label for="emid">Email-Id <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" value="<?= $enquiry->pmailid ?>" placeholder="Enter Email id" name="parentsmailid" id="emid" required="">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                            <label for="simage">Upload parent / Gaurdian Image</label>
                                            <div class="form-group">
                                                <input type="file" class="form-control dropify" name="stdparentimage" id="stdparentimage" accept=".jpg,.png">
                                            </div>
                                        </div>
                                        <input type="hidden" value="<?=$enquiry->pimage?>" name="uploadedparent_image">
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">
                                            <div class="form-group">
                                                <label for="addr">Enter Address</label>
                                                <input type="text" class="form-control" value="<?= $enquiry->paddress ?>" name="parentsaddress" placeholder="Enter Address" id="addr">
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
                                                <input type="tel" class="form-control" value="<?= $enquiry->ppincode ?>" name="parentspincode" id="pcode" maxlength="" placeholder="Enter Pincode">
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
                                                    <div class="form-group">
                                                        <input type="number" id="schoolfee" class="form-control" placeholder="School Fee" name="feeamount[]" value="<?= $enquiry->feeamount['school'] ?>" required="" readonly="">
                                                        <span class="bar"></span>
                                                        <label for="schoolfee">School Fee <span class="text-red">*</span></label>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="feetype[]" value="school">

                                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                    <div class="form-group">
                                                        <input type="number" class="form-control" placeholder="Hostel / Daily Service" name="feeamount[]" value="<?= $enquiry->feeamount['service'] ?>" id="ServiceFee" readonly="">
                                                        <span class="bar"></span>
                                                        <label for="ServiceFee">Hostel / Daily Service</label>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="feetype[]" value="service">

                                                <?php foreach ($enquiry->feeamount as $key => $value) { if($key != 'school' && $key != 'service'){ ?>
                                                        <div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
                                                            <div class="form-group">
                                                                <input type="number" id="schoolfee" class="form-control" placeholder="School Fee" name="feeamount[]" value="<?= $enquiry->feeamount[$key] ?>" required="" readonly="">
                                                                <span class="bar"></span>
                                                                <label for="schoolfee"><?= $key ?>  <span class="text-red">*</span></label>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="feetype[]" value="<?= $key ?>">
                                                <?php } } ?>

                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-3 col-md-2 col-lg-2">
                                            <div class="form-group">
                                                <input type="number" value="<?= $enquiry->totalfee ?>" class="form-control" placeholder="Total Fee" name="totalfee" id="totalfee" readonly="">
                                                <span class="bar"></span>
                                                <label for="totalfee">Total Fee Amount<span class="text-red">*</span></label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-success pull-right" value="Update Admission" id="updateadmission" name="updateadmission">
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
                                    feeotherlist += '<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2 otherAmountBOxs"><label for="'+ index +'">'+ index +'</label><div class="form-group"><input type="number" class="form-control" placeholder="'+ index +'" value="'+ el +'" name="feeamount[]" id="'+ index +'" readonly=""></div><input type="hidden" name="feetype[]" value="'+ index +'"></div>';
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
