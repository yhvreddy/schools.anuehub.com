<!-- Container fluid  -->
<div class="container-fluid">
    <?php
        $regusers = $regusers['0'];
        //print_r($regusers);
    ?>
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 col-lg-5 col-sm-4 col-xs-12 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?= $regusers->reg_id ?> Edit Register Details</h3>
        </div>
        <div class="col-md-7 col-lg-7 col-sm-8 col-xs-12 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Branchs</a></li>
                    <li class="breadcrumb-item active">Edit Register Details</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- Start Page Content -->
    <div class="row justify-content-center align-items-center">
        <div class="col-md-10 col-lg-10 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><?= $regusers->reg_id ?> Edit Register Details</h4>
                            <div class="col-md-12">
                                <form class="floating-labels" id="SetSchooldetails">
                                    <input type="hidden" name="SchoolType" id="SchoolType" value="GSB">   
                                    <input type="hidden" name="Registerid" value="<?= $regusers->reg_id ?>">         
                                    <input type="hidden" name="Regid" value="<?= $regusers->sno ?>">
                                    <div class="row mt-5 mb-3">
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control form-control-line" name="RegFname" id="RegFname" required value="<?= $regusers->fname ?>">
                                            <span class="bar"></span>
                                            <label for="RegFname">Enter First Name <span class="text-danger">*</span></label>
                                            <small id="RegFnameerror"></small>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control form-control-line" name="RegLname" id="RegLname" required value="<?= $regusers->lname; ?>">
                                            <span class="bar"></span>
                                            <label id="RegLname">Enter Last Name <span class="text-danger">*</span></label>
                                            <small id="RegLnameerror"></small>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="tel" maxlength="10" class="form-control form-control-line" id="RegMobile" name="RegMobile" required value="<?= $regusers->mobile ?>">
                                            <span class="bar"></span>
                                            <label for="RegMobile">Enter Mobile Number <span class="text-danger">*</span></label>
                                            <small id="Regmobileerror"></small>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="email" class="form-control form-control-line" name="Regemail" id="Regemail" required value="<?= $regusers->mailid ?>">
                                            <span class="bar"></span>
                                            <label for="Regemail">Email Id <span class="text-danger">*</span></label>
                                            <small id="Regmailerror"></small>
                                        </div>           

                                        <div class="col-md-4 form-group">
                                            <select name="CountryName" id="CountryName" class="form-control p-0" required>
                                                <option value=""></option>
                                                <?php foreach ($countries as $country){ 
                                                        if($country->id == $regusers->country_id){
                                                    ?>
                                                    <option selected value="<?= $country->id ?>"><?= $country->name ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $country->id ?>"><?= $country->name ?></option>
                                                <?php } } ?>
                                            </select>
                                            <span class="bar"></span>
                                            <label for="CountryName">Select country.. <span class="text-danger">*</span></label>
                                            <small id="selectcountryerror"></small>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <select name="StateName" id="StateName" class="form-control p-0" required>
                                                <option value=""></option>
                                                <?php
                                                    $states = $this->Model_dashboard->selectdata('sms_states',array('country_id'=>$regusers->country_id));
                                                    foreach($states as $state){ 
                                                    if($state->id == $regusers->state_id){
                                                    ?>
                                                    <option selected="" value="<?= $state->id ?>"><?= $state->name ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $state->id ?>"><?= $state->name ?></option>
                                                <?php } }?>
                                            </select>
                                            <span class="bar"></span>
                                            <label for="StateName">Select State Name <span class="text-danger">*</span></label>
                                            <small id="selectstateerror"></small>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <select name="CityName" id="CityName" class="form-control p-0" required>
                                                <option value=""></option>
                                                <?php
                                                    $cities = $this->Model_dashboard->selectdata('sms_cities',array('state_id'=>$regusers->state_id));
                                                    foreach($cities as $city){ 
                                                    if($city->id == $regusers->city_id){
                                                    ?>
                                                    <option selected="" value="<?= $city->id ?>"><?= $city->name ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?= $city->id ?>"><?= $city->name ?></option>
                                                <?php } }?>
                                            </select>
                                            <span class="bar"></span>
                                            <label for="CityName">Select City / Dist Name <span class="text-danger">*</span></label>
                                            <small id="selectcityerror"></small>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <input type="text" class="form-control form-control-line" name="RegAddress" id="RegAddress" required value="<?= $regusers->address ?>">
                                            <span class="bar"></span>
                                            <label for="RegAddress">Enter Address <span class="text-danger">*</span></label>
                                            <small id="RegAddresserror"></small>
                                        </div>
                                        <!-- <div class="form-group col-md-4">
                                            <input type="text" class="form-control form-control-line" name="Regcity" required id="Regcity">
                                            <span class="bar"></span>
                                            <label for="Regcity">Enter City / town <span class="text-danger">*</span></label>
                                            <small id="Regcityerror"></small>
                                        </div> -->
                                        <div class="col-md-4 form-group">
                                            <input type="text" id="SclbranchName" required name="SclbranchName" class="form-control" value="<?=$regusers->branch_name?>">
                                            <span class="bar"></span>
                                            <label for="SclbranchName">Branch Name <span class="text-danger">*</span></label>
                                            <small id="Sclbranchnameerror"></small>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="tel" maxlength="6" class="form-control form-control-line" id="RegPincode" name="RegPincode" required value="<?=$regusers->pincode?>">
                                            <span class="bar"></span>
                                            <label for="RegPincode">Enter pincode <span class="text-danger">*</span></label>
                                            <small id="Regpincodeerror"></small>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" id="AadhaarCard" maxlength="14" class="form-control form-control-line text-center" name="RegAadhaar" required value="<?=$regusers->aadhaar?>">
                                            <span class="bar"></span>
                                            <label for="RegAadhaar">Enter Aadhaar Number <span class="text-danger">*</span></label>
                                            <small id="AadhaarCarderror"></small>
                                        </div>
                                        
                                        <div class="col-md-12 form-group">
                                            
                                            <label class="pull-left">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-success">
                                                        <input id="Regcheckbox" type="checkbox" name="Regcheckbox">
                                                        <label for="Regcheckbox"> I Accept Terms and conductions <a href="#">Click More.</a> </label>
                                                    </div>
                                                </div>
                                            </label>

                                            <a href="javascript:void(0);" id="registerAccount" class="btn btn-success pull-right mt-2" data-toggle="modal" data-target="#4digpin-registerAccount" data-backdrop="static" data-keyboard="false">Update Details</a>

                                            <!-- sample modal content -->
                                            <div id="4digpin-registerAccount" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content" style="top:100px">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Enter your 4 digits pin..</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php 
                                                                $this->Model_dashboard->fourDigitspin(); 
                                                            ?>
                                                            <input type="button" id="registernewAccount" class="btn btn-success pull-right mt-2" value="Update Register Details" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal -->
                                            
                                        </div>
                                        <!-- <div class="col-md-12">
                                            <input type="submit" name="NewRegister" value="Register Account" id="NewRegister" class="pull-right btn btn-success">
                                        </div> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-info">Guide Lines</h4>
                            <div class="col-md-12">
                                <div class="row">
                                    <p class="col-md-12"># Enter new branch admin details in given fields.</p>
                                    <p class="col-md-12"># Red Mark are ( <span class="text-danger">*</span> ) Required fields..</p>
                                </div>
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
    $(document).ready(function($) {
       /* regexp checkdata */
         var name = /^[A-Za-z\s]*$/;
         var regex = new RegExp(name);
         var number =  /^[0-9]+$/;
         var regexnum = new RegExp(number);
         var email = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
         var regezem = new RegExp(email);
         var aadhaarcard = /^(?:\\d{4})|\d{4}-\d{4}$/;
         var regaad = new RegExp(aadhaarcard);
        $("#registernewAccount").click(function(event) {
             event.preventDefault();
             var scltype =   $("#SchoolType").val();
             var fname   =   $("#RegFname").val();
             var lastname=   $("#RegLname").val();
             var mailid  =   $("#Regemail").val();
             var mobile  =   $("#RegMobile").val();
             var address =   $("#RegAddress").val();
             //var city    =   $("#city").val();
             var country =   $("#CountryName").val();
             var stateid =   $("#StateName").val();
             var citydist=   $("#CityName").val();
             var pincode =   $("#RegPincode").val();
             var aadhaar =   $("#AadhaarCard").val();

             if((scltype !='' && fname !='' && lastname !='' && mobile !='' && mailid != '' && address != '' && citydist != '' && country != '' && stateid != '' && aadhaar != '') && (regezem.test(mailid)) && (regex.test(fname)) && (regex.test(lastname)) && (regexnum.test(mobile)) &&  (regexnum.test(pincode)) && (regaad.test(aadhaar))){
                 var fromdata = $("#SetSchooldetails").serialize();
                 $("#resmessage").text('');
                 $("#loader").show();
                 $.ajax({
                     url: '<?=base_url();?>dashboard/branch/saveeditbranchdetails',
                     type: 'POST',
                     dataType: 'json',
                     data:fromdata,
                 })
                 .done(function(dataresponce) {
                     $("#loader").hide();
                     console.log(dataresponce);

                     if(dataresponce.key == 0){
                         swal({
                             title:"Sorry",
                             text: dataresponce.message,
                             type:"warning",
                         });
                         $(this).trigger('reset');
                         //swal("Sorry", dataresponce.message , "warning");
                     }else if(dataresponce.key == 1){
                        $("#4digpin-registerAccount").modal('hide');
                         swal({
                             title:"success",
                             text: dataresponce.message,
                             type:"success",
                         },function () {
                            $(this).trigger('reset');
                            window.location.href = "<?=base_url();?>dashboard/branch/branchlist";
                         });
                     }else{
                        swal(dataresponce.message);
                     }

                 })
                 .fail(function(errordata) {
                     console.log(errordata);
                     $("#loader").hide();
                     swal("oops"+errordata+"error");
                 })              
             }else{
                 $("#resmessage").text('Please fill all following fields..!').css('color', 'red');;
             } 
         }); 
    });
</script>