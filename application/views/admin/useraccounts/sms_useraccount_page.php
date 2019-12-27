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
    <h1 class="page-header">Enquery <small>Student Enquery details.</small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:void(0);" class="pull-right btn btn-success btn-xs" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#NeweNote"><i class="fa fa-plus"></i> New enquery</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Enquery list</h4>
                </div>
                <div class="panel-body">
                    <!-- eNote Model start-->
                    <div id="NeweNote" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content" style="top:50px">
                                <div class="modal-header">
                                    <h4 class="modal-title">New Enquery</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method="post" class="floating-labels" action="<?=base_url('dashboard/enquiry/save')?>">
                                                <div class="row mt-3">
                                                    <input type="hidden" value="" name="schoolid">
                                                    <input type="hidden" value="" name="branchid">
                                                    
                                                    <div class="form-group col-md-4">
                                                        <label for="StdfName">Enter First Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" placeholder="Enter First Name" name="StdfName" required id="StdfName">
                                                        <span class="bar"></span>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="StdlName">Enter Last Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="StdlName" name="StdlName" placeholder="Enter Last Name" required>
                                                        <span class="bar"></span>
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label for="stdgender">Select Gender <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="stdgender" id="stdgender" required="" style="padding: 0px;">
                                                            <option value="">Select Gender</option>
                                                            <?php foreach ($gender as $genders) { ?>
                                                                <option value="<?= $genders->shortname ?>"><?= $genders->name ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span class="bar"></span>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="StdlName">Father or Guardian Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="StdGName" name="StdGName" placeholder="Father or Guardian Name" required>
                                                        <span class="bar"></span>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="sclsyllabuslist">Student Syllabus</label>
                                                        <select type="text" name="StdSyllubas" id="sclsyllubaslist" class="form-control" style="padding:0px">
                                                            <option value="">Select Syllabus Type</option>
                                                            <?php foreach ($syllabus as $key => $value) { ?>
                                                                <option value="<?= $key ?>"><?= $value ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span class="bar"></span>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="SyllabusClasses">Student Class</label>
                                                        <select type="text" name="StdClass" id="SyllabusClasses" class="form-control" disabled="" style="padding:0px 10px">
                                                            <option value="">Select Syllubas First</option>
                                                        </select>
                                                        <span class="bar"></span>
                                                    </div>

                                                    <div class="col-md-4 form-group">
                                                        <label for="mdate">Date OF Birth <span class="text-red">*</span></label>
                                                        <input type="text" placeholder="Pick Date of Birth" class="form-control mydatepicker" name="dob" id="mdate" required="">
                                                        <span class="bar"></span>
                                                    </div>

                                                    <div class="form-group col-md-5">
                                                        <label for="StdEmail">Enter Mail-id <span class="text-danger">*</span></label>
                                                        <input class="form-control" placeholder="Enter mail id" type="email" name="StdEmail" required id="StdEmail">
                                                        <span class="bar"></span>
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="StdMobile">Mobile <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="tel" maxlength="10" name="StdMobile" placeholder="Enter Mobile Number" required>
                                                        <span class="bar"></span>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label for="CountryName">Select country.. <span class="text-danger">*</span></label>
                                                        <select name="CountryName" id="CountryName" class="form-control p-0" required>
                                                            <option value="">Select Country Name</option>
                                                            <?php foreach ($countries as $country){ ?>
                                                                <option value="<?= $country->id ?>"><?= $country->name ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span class="bar"></span>
                                                        <small id="selectcountryerror"></small>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label for="StateName">Select State Name <span class="text-danger">*</span></label>
                                                        <select name="StateName" id="StateName" class="form-control p-0" required disabled="">
                                                            <option value="">Select Country First</option>
                                                        </select>
                                                        <span class="bar"></span>
                                                        <small id="selectstateerror"></small>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label for="CityName">Select City / Dist Name <span class="text-danger">*</span></label>
                                                        <select name="CityName" id="CityName" class="form-control p-0" required disabled="">
                                                            <option value="">Select State First</option>
                                                        </select>
                                                        <span class="bar"></span>
                                                        <small id="selectcityerror"></small>
                                                    </div>
                                                    <div class="form-group col-md-5">
                                                        <label for="StdAddress">Address <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" id="StdAddress" name="StdAddress" placeholder="Enter Address" required>
                                                        <span class="bar"></span>
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="StdPincode">Enter Pincode <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="tel" maxlength="6" name="StdPincode" placeholder="Enter Pincode" id="StdPincode" required>
                                                        <span class="bar"></span>
                                                    </div>

<!--                                                    <div class="form-group col-md-4">-->
<!--                                                        <label for="AadhaarCard">Enter Aadhaar Number</label>-->
<!--                                                        <input type="tel" id="AadhaarCard" maxlength="14" class="form-control form-control-line" name="RegAadhaar" placeholder="Enter Aadhaar Number">-->
<!--                                                        <span class="bar"></span>-->
<!--                                                    </div>-->

                                                    <div class="col-md-12">
                                                        <input type="submit" class="btn btn-success pull-right" value="Save Enquiery" name="SaveEnquiery">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- eNote Model end-->

                    <div class="col-md-12">
                        <?php if(count($enquirydata) != 0){ ?>
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Sno</th>
                                    <th>Reg id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Class</th>
                                    <th>Mobile</th>
                                    <th>Date of Birth</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($enquirydata as $enquiry) { ?>
                                        <tr>
                                            <td><?=$i;?></td>
                                            <td><a href="javascript:void(0);"><?=$enquiry->id_num?></a></td>
                                            <td><?=$enquiry->firstname?></td>
                                            <td><?=$enquiry->lastname?></td>
                                            <td><?=$enquiry->class?></td>
                                            <td><?=$enquiry->mobile?></td>
                                            <td><?=$enquiry->dob?></td>
                                            <td align="center">
                                                <?php
                                                    $add = $this->Model_default->selectdata('sms_admissions',array('branch_id'=>$branchid,'school_id'=>$schoolid,'enq_id'=>$enquiry->id_num));
                                                    if(count($add) == 0){
                                                ?>
                                                    <a href="<?=base_url().'dashboard/enquiry/admission/'.$enquiry->sno.'/'.$enquiry->school_id.'/'.$enquiry->branch_id.''?>" onclick="return confirm('Are you want to add Admission..!')"><i class="fa fa-user-plus fa-dx"></i></a>
                                                &nbsp;&nbsp;
                                                <?php } ?>
<!--                                                <a href="javascript:void(0);"><i class="fa fa-file-o fa-dx"></i></a>&nbsp;&nbsp;-->

                                                <a href="<?=base_url().'dashboard/enquiry/edit/'.$enquiry->sno.'/'.$enquiry->school_id.'/'.$enquiry->branch_id.''?>"><i class="fa fa-pencil-square-o fa-dx"></i></a>&nbsp;&nbsp;
                                                
                                                <a href="<?=base_url().'dashboard/enquiry/delete/'.$enquiry->sno.'/'.$enquiry->school_id.'/'.$enquiry->branch_id.''?>" onclick="return confirm('Are want to delete <?=$enquiry->id_num?> enquiry Details')"><i class="fa fa-trash-o fa-dx"></i></a>
                                            </td>
                                        </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        <?php }else{ ?>
                            <?= $this->Model_integrate->norecords(); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->