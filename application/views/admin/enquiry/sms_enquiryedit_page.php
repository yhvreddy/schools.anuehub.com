<!-- Container fluid  -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Front Office</a></li>
        <li class="breadcrumb-item active">Enquery</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Edit Enquery <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="<?=base_url('dashboard/enquiry/newenquiry')?>" class="pull-right btn btn-success btn-xs"><i class="fa fa-list"></i> Enquery List</a>
                    </div>
                    <h4 class="panel-title">Update Enquiry</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="row">
                            <?php 
                                $data = $enquirydata['0']; 
                                $classlist = unserialize($classes['0']->class); 
                                //print_r($data); 
                            ?>
                            <div class="col-md-12">
                                <form method="post" class="floating-labels" action="<?=base_url('dashboard/enquiry/saveupdates/')?>">
                                    <div class="row mt-3">
                                        <input type="hidden" value="<?=$data->school_id?>" name="schoolid">
                                        <input type="hidden" value="<?=$data->branch_id?>" name="branchid">
                                        <input type="hidden" name="id" value="<?=$data->sno?>">
                                        
                                        <div class="form-group col-md-4">
                                            <label for="StdfName">Enter First Name <span class="text-danger">*</span></label>
                                            <input class="form-control" value="<?=$data->firstname?>" type="text" name="StdfName" required id="StdfName">
                                            <span class="bar"></span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="StdlName">Enter Last Name <span class="text-danger">*</span></label>
                                            <input class="form-control" value="<?=$data->lastname?>" type="text" id="StdlName" name="StdlName" required>
                                            <span class="bar"></span>
                                        </div>

                                        <div class="col-md-2 form-group">
                                            <label for="stdgender">Select Gender <span class="text-danger">*</span></label>
                                            <select class="form-control" name="stdgender" id="stdgender" required="" style="padding: 0px;">
                                                <?php foreach ($gender as $genders) { 
                                                    if($data->gender == $genders->shortname){ ?>
                                                    <option selected="" value="<?= $genders->shortname ?>"><?= $genders->name ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $genders->shortname ?>"><?= $genders->name ?></option>
                                                <?php } }?>
                                            </select>
                                            <span class="bar"></span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="StdlName">Farther or Guardian Name <span class="text-danger">*</span></label>
                                            <input class="form-control" value="<?=$data->fathername?>" type="text" id="StdGName" name="StdGName" required>
                                            <span class="bar"></span>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="sclsyllabuslist">Student Syllabus</label>
                                            <select type="text" name="StdSyllubas" id="sclsyllubaslist" class="form-control" style="padding:0px">
                                                <option value=""></option>
                                                <?php foreach ($syllabus as $key => $value) { if($key == $data->class_type){ ?>
                                                    <option value="<?= $key ?>" selected=""><?= $value ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $key ?>"><?= $value ?></option>
                                                <?php } } ?>
                                            </select>
                                            <span class="bar"></span>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="SyllabusClasses">Student Class</label>
                                            <select type="text" name="StdClass" id="SyllabusClasses" class="form-control" disabled="" style="padding:0px 10px">
                                                <option value=""></option>
                                                <?php foreach ($classlist as $classvalue) {
                                                    if($data->class == $classvalue){ ?>
                                                        <option value="<?= $classvalue ?>" selected=""><?= $classvalue ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $classvalue ?>"><?= $classvalue ?></option>
                                                <?php } } ?>
                                            </select>
                                            <span class="bar"></span>
                                        </div>

                                        <div class="col-md-2 form-group">
                                            <label for="mdate">Date OF Birth <span class="text-red">*</span></label>
                                            <input type="text" value="<?=$data->dob?>" class="form-control mydatepicker" name="dob" id="mdate" required="">
                                            <span class="bar"></span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="StdMobile">Mobile <span class="text-danger">*</span></label>
                                            <input class="form-control" value="<?=$data->mail_id?>" type="email" name="StdEmail" required id="StdEmail">
                                            <span class="bar"></span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="StdMobile">Mobile <span class="text-danger">*</span></label>
                                            <input class="form-control" value="<?=$data->mobile?>" type="tel" maxlength="10" name="StdMobile" required>
                                            <span class="bar"></span>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label for="CountryName">Select country.. <span class="text-danger">*</span></label>
                                            <select name="CountryName" id="CountryName" class="form-control p-0" required>
                                                <option value=""></option>
                                                <?php foreach ($countries as $country){ 
                                                    if($country->id == $data->country_id){
                                                    ?>
                                                    <option selected="" value="<?= $country->id ?>"><?= $country->name ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $country->id ?>"><?= $country->name ?></option>
                                                <?php } }?>
                                            </select>
                                            <span class="bar"></span>
                                            <small id="selectcountryerror"></small>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <?php $states = $this->Model_dashboard->selectdata('sms_states',array('status'=>1,'country_id'=>$data->country_id)); ?>
                                            <label for="StateName">Select State Name <span class="text-danger">*</span></label>
                                            <select name="StateName" id="StateName" class="form-control p-0" required="">
                                                <option value=""></option>
                                                <?php foreach ($states as $state) { if($state->id == $data->state_id){ ?>
                                                    <option value="<?=$state->id;?>" selected=""><?=$state->name;?></option>    
                                                <?php }else{ ?>
                                                    <option value="<?=$state->id;?>"><?=$state->name;?></option>
                                                <?php } } ?>
                                            </select>
                                            <span class="bar"></span>
                                            <small id="selectstateerror"></small>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <?php $cities = $this->Model_dashboard->selectdata('sms_cities',array('status'=>1,'state_id'=>$data->state_id)); ?>
                                            <label for="CityName">Select City / Dist Name <span class="text-danger">*</span></label>
                                            <select name="CityName" id="CityName" class="form-control p-0" required="">
                                                <option value=""></option>
                                                <?php foreach ($cities as $city) { if($city->id == $data->city_id){ ?>
                                                    <option value="<?=$city->id;?>" selected=""><?=$city->name;?></option>    
                                                <?php }else{ ?>
                                                    <option value="<?=$city->id;?>"><?=$city->name;?></option>
                                                <?php } } ?>
                                            </select>
                                            <span class="bar"></span>
                                            <small id="selectcityerror"></small>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="StdPincode">Enter Pincode <span class="text-danger">*</span></label>
                                            <input class="form-control" value="<?=$data->address?>" type="text" id="StdAddress" name="StdAddress" required>
                                            <span class="bar"></span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="StdPincode">Enter Pincode <span class="text-danger">*</span></label>
                                            <input class="form-control" value="<?=$data->pincode?>" type="tel" maxlength="6" name="StdPincode" id="StdPincode" required>
                                            <span class="bar"></span>
                                        </div>

<!--                                        <div class="form-group col-md-4">-->
<!--                                            <label for="AadhaarCard">Enter Aadhaar Number</label>-->
<!--                                            <input type="tel" id="AadhaarCard" value="--><?php $data->aadhaar; ?><!--" maxlength="14" class="form-control form-control-line" name="RegAadhaar">-->
<!--                                            <span class="bar"></span>-->
<!--                                        </div>-->

                                        <div class="col-md-12">
                                            <input type="submit" class="btn btn-success pull-right" value="Update Enquiry Details" name="SaveEnquiery">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
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
