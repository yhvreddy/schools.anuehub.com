<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
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
    <!-- <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet"> -->
    <link href="<?= base_url() ?>assets/css/sweetalert.min.css" rel="stylesheet">
    <!-- ================== END BASE CSS STYLE ================== -->
    <!-- ================== BEGIN BASE JS ================== -->
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/intl-tel-input-master/build/css/intlTelInput.css">
    <script src="<?=base_url()?>assets/plugins/pace/pace.min.js"></script>
    
    <!-- ================== END BASE JS ================== -->
    <script src="<?=base_url()?>assets/plugins/jquery/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/angular.min.js"></script>
    <script src="<?= base_url() ?>assets/js/sweetalert.min.js"></script>
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
        
        .intl-tel-input{
            width:100%;
        }
    </style>
</head>
<body class="pace-top">
    <div class="loader" id="loader" style="display:none">
        <center>
            <img src="<?= base_url() ?>assets/images/loader.gif">
        </center>
    </div>
    <?php
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
        <div class="login-cover-image" style="background-image: url(<?=base_url()?>assets/img/login-bg/login-bg-13.jpg)" data-id="login-cover-image"></div>
        <div class="login-cover-bg"></div>
    </div>
    
    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login login-v2" style="width:80%;margin: 80px auto 0 auto;top:0;left:0" data-pageload-addclass="animated fadeIn">
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
            <div class="login-content" style="width: 100%">
                <form  method="post" id="SetSchooldetails" action="<?= base_url('saveregisteraccount') ?>">
                        <div class="col-md-12 text-center" id="resmessage"></div>
                        <div class="row mt-4">
                            <div class="col-md-4 form-group">
                                <label for="SchoolType">Select School Type</label>
                                <select name="SchoolType" id="SchoolType" class="form-control p-0" required>
                                    <option value="">Select School Type</option>
                                    <?php foreach ($scltypes as $type){ ?>
                                        <option value="<?= $type->shortname ?>"><?= $type->name ?></option>
                                    <?php } ?>
                                </select>
                                <small id="selectschoolerror"></small>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="Fname">Enter First Name</label>
                                <input type="text" name="Fname" class="form-control" required id="Fname" placeholder="Enter First Name">
                                <small id="fnameerror"></small>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="Lname">Enter Last Name</label>
                                <input type="text" name="Lname" class="form-control" required id="Lname" placeholder="Enter Last Name">
                                <small id="lnameerror"></small>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="Mobile">Enter Mobile Number</label>
                                <input type="tel" minlength="10" style="width:100%;" placeholder="Enter Mobile Number" required name="Mobile" class="form-control" id="Mobiles">
                                <small id="mobileerror"></small>
                                <input id="full_phone" type="hidden" name="phone_number">
                                <input id="calling_code" type="hidden" name="calling_code">
                                <span id="valid-msg" class="hide">✓ Valid</span>
                                <span id="error-msg" class="hide"></span>
                            </div>
                            <div class="col-md-5 form-group">
                                <label for="Mailid">Enter Mail id</label>
                                <input type="email" required placeholder="Enter Mail id" name="Mailid" class="form-control" id="Mailid">
                                <small id="emailerror"></small>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="CountryName">Select country Name <span class="text-danger">*</span></label>
                                <select name="CountryName" id="CountryName" class="form-control p-0" required>
                                    <option value="">Select country Name</option>
                                    <?php foreach ($countries as $country){ ?>
                                        <option value="<?= $country->id ?>"><?= $country->name ?></option>
                                    <?php } ?>
                                    <!-- <option value='other'> Other country </option> -->
                                </select>
                                <small id="selectcountryerror"></small>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="StateName">Select State Name <span class="text-danger">*</span></label>
                                <select name="StateName" id="StateName" class="form-control p-0" required>
                                    <option value="">Select State Name</option>
                                </select>
                                <small id="selectstateerror"></small>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="CityName">Select City / Dist Name <span class="text-danger">*</span></label>
                                <select name="CityName" id="CityName" class="form-control p-0" required>
                                    <option value="">Select City / Dist Name</option>
                                </select>
                                <small id="selectcityerror"></small>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="Address">Enter Address</label>
                                <input type="text" required name="Address" class="form-control" id="address" placeholder="Enter Address">
                                <small id="addresserror"></small>
                            </div>
                            <!-- <div class="col-md-5 form-group">
                                <input type="text" required name="city" class="form-control" id="city">
                                <span class="bar"></span>
                                <label for="city">Enter city or town</label>
                                <small id="cityerror"></small>
                            </div> -->
                            <div class="col-md-3 form-group">
                                <label for="pincode">Enter Pincode / Zip Code</label>
                                <input type="text" maxlength="" required name="pincode" placeholder="Enter Pincode / Zip Code" class="form-control" id="pincode">
                                <small id="pincodeerror"></small>
                            </div>

                            <!-- <div class="col-md-4 form-group">
                                <label for="AadhaarCard">Enter Aadhaar Number</label>                                
                                <input type="text" maxlength="14" required name="Aadhaar" placeholder="Enter Aadhaar Number" id="AadhaarCard" class="form-control">
                                <small id="AadhaarCarderror"></small>
                            </div> -->
                        </div>
                        
                        <div class="row mt-3 mb-3">
                            <div class="col-md-12 form-group">
                                
                                <label class="pull-left">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-css m-b-20">
                                            <input type="checkbox" id="remember_checkbox" name="remember" class="custom-control-input">
                                            <label for="remember_checkbox"> I Accept Terms and conductions <a href="#">Click More.</a> </label>
                                        </div>
                                    </div>
                                </label>

                                <input type="submit" id="registerAccount" class="btn btn-success pull-right mt-2" value="Register Account" />

                            </div>
                        </div>
                    </form>
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
    <script src="<?=base_url()?>assets/plugins/intl-tel-input-master/build/js/intlTelInput.js"></script>

    <script>
        $(document).ready(function() {
            App.init();
            LoginV2.init();
        });
    </script>
    
    <script>
        var input = document.querySelector("#Mobile");
        var errorMsg = document.querySelector("#error-msg");
        var validMsg = document.querySelector("#valid-msg");
        
        var telInput = window.intlTelInput(input, {
            // allowDropdown: false,
            // autoHideDialCode: false,
            // autoPlaceholder: "off",
            // dropdownContainer: document.body,
            // excludeCountries: ["us"],
            // formatOnDisplay: false,
            geoIpLookup: function(callback) {
              $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
              });
            },
            // hiddenInput: "full_number",
            initialCountry: "auto",
            // localizedCountries: { 'de': 'Deutschland' },
            // nationalMode: false,
            // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
            // placeholderNumberType: "MOBILE",
            preferredCountries: ['In', 'US'],
            separateDialCode: true,
            hiddenInput: "full_phone",
            utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js'
            //"<?=base_url('assets/plugins/intl-tel-input-master/build/js/utils.js')?>",
        });

        // Error messages based on the code returned from getValidationError
        var errorMap = [ "Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        var reset = function() {
            input.classList.remove("error");
            errorMsg.innerHTML = "";
            errorMsg.classList.add("hide");
            validMsg.classList.add("hide");
        };

        // Validate on blur event
        input.addEventListener('blur', function() {
            reset();
            if(input.value.trim()){
                if(telInput.isValidNumber()){
                    validMsg.classList.remove("hide");
                    /* get code here*/
                    //alert(input);
                }else{
                    input.classList.add("error");
                    var errorCode = telInput.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("hide");
                }
            }
        });       
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".selected-dial-code").on('change',function(){
            alert("++++");
        });
        $("#registerAccount").hide();
        $("#remember_checkbox").click(function(event) {
            /* Act on the event */
            if($(this).is(':checked')){
                $("#registerAccount").show();
            }else{
                $("#registerAccount").hide();
            }
        });

        /* regexp checkdata */
        var name = /^[A-Za-z\s]*$/;
        var regex = new RegExp(name);
        var number =  /^[0-9]+$/;
        var regexnum = new RegExp(number);
        var email = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var regezem = new RegExp(email);
        var aadhaarcard = /^(?:\\d{4})|\d{4}-\d{4}$/;
        var regaad = new RegExp(aadhaarcard);
        
        $("#SchoolType").change(function(event) {
            if($(this).val() == ''){
                $(this).focus();
                $("#selectschoolerror").text("Please select school type").css('color', 'red');
            }else{
                $("#selectschoolerror").text("");
            }
        });

        $("#Fname").on('keyup',function () {
            var fname   =   $(this).val();
            if(fname === '' ){
                $("#fnameerror").text('Enter your first name').css('color', 'red');
            }else if(!regex.test(fname)){
                $("#fnameerror").text('First name should be charters only..!').css('color', 'red');
            }else if(fname != ''){
                $("#fnameerror").text('');
            }
        });

        $("#Lname").on('keyup',function () {
            var lname   =   $(this).val();
            if(lname === '' ){
                $("#lnameerror").text('Enter your last name..!').css('color', 'red');
            }else if(!regex.test(lname)){
                $("#lnameerror").text('Last name should be charters only..!').css('color', 'red');
            }else if(lname != ''){
                $("#lnameerror").text('');
            }
        });

        $("#Mailid").on('keyup',function () {
            var mailid   =   $(this).val();
            if(mailid === '' ){
                $("#emailerror").text('Enter your email id..!').css('color', 'red');
            }else if(!regezem.test(mailid)){
                $("#emailerror").text('Enter valid email id..!').css('color', 'red');
            }else if(mailid != ''){
                $("#emailerror").text('');
            }
        });

        $("#Mobile").on('keyup',function () {
            var mobile   =   $(this).val();
            //alert(mobile.length);
            if(mobile === '' ){
                $("#mobileerror").text('Enter mobile number..!').css('color', 'red');
            }else if(!regexnum.test(mobile)){
                $("#mobileerror").text('Enter valid mobile number..!').css('color', 'red');
            }else if(mobile.length < 10){
                $("#mobileerror").text('Enter 10 digits Mobile Number..!').css('color', 'red');
            }else if(mobile != '' && mobile.length >= 10){
                $("#mobileerror").text('');
            }
        });

        $("#pincode").on('keyup',function () {
            var pincode   =   $(this).val();
            if(pincode === '' ){
                $("#pincodeerror").text('Enter pincode number..!').css('color', 'red');
            }else if(!regexnum.test(pincode)){
                $("#pincodeerror").text('Enter valid pincode..!').css('color', 'red');
            }else if(pincode != ''){
                $("#pincodeerror").text('');
            }
        });

        $("#address").on('keyup',function () {
            var address   =   $(this).val();
            if(address == '' ){
                $("#addresserror").text('Enter Address..!').css('color', 'red');
            }else if(address != ''){
                $("#addresserror").text('');
            }
        });

        // $("#city").on('keyup',function () {
        //     var city   =   $(this).val();
        //     if(city == '' ){
        //         $("#cityerror").text('Enter City or town name..!').css('color', 'red');
        //     }else if(city != ''){
        //         $("#cityerror").text('');
        //     }
        // });

        $("#CountryName").change(function(event) {
            if($(this).val() == ''){
                $(this).focus();
                $("#selectcountryerror").text("Please select country name").css('color', 'red');
            }else{
                $("#selectcountryerror").text("");
            }
        });

        $("#StateName").change(function(event) {
            if($(this).val() == ''){
                $(this).focus();
                $("#selectstateerror").text("Please select State Name").css('color', 'red');
            }else{
                $("#selectstateerror").text("");
            }
        });

        $("#CityName").change(function(event) {
            if($(this).val() == ''){
                $(this).focus();
                $("#selectcityerror").text("Select city / dist name").css('color', 'red');
            }else{
                $("#selectcityerror").text("");
            }
        });

        $("#AadhaarCard").on('keyup',function () {
            var aadhaar   =   $(this).val();
            if(aadhaar === '' ){
                $("#AadhaarCarderror").text('Enter Aadhaar number..!').css('color', 'red');
            }else if(!regaad.test(aadhaar)){
                $("#AadhaarCarderror").text('Enter valid aadhaar..!').css('color', 'red');
            }else if(aadhaar != ''){
                $("#AadhaarCarderror").text('');
            }
        });


        $("#registerAccount").click(function(event) {
            event.preventDefault();
            var scltype =   $("#SchoolType").val();
            var fname   =   $("#Fname").val();
            var lastname=   $("#Lname").val();
            var mailid  =   $("#Mailid").val();
            var mobile  =   $("#Mobile").val();
            //var countytel   =   $("#calling_code").val($("#Mobile").intlTelInput("getSelectedCountryData").dialCode);
            var address =   $("#address").val();
            //var city    =   $("#city").val();
            var country =   $("#CountryName").val();
            var stateid =   $("#StateName").val();
            var citydist=   $("#CityName").val();
            var pincode =   $("#pincode").val();
            
           // alert('school type :' +scltype + 'FirstName :' + fname + 'LastName :' + lastname + 'Mail :' + mailid + 'Mobile :' + mobile + 'Address :' + address + 'County :' + country + 'state :' + stateid + 'City :' + citydist + 'Pincode :' + pincode + 'Aadhaar :' + aadhaar);
            if((scltype !='' && fname !='' && lastname !='' && mobile !='' && mailid != '' && address != '' && citydist != '' && country != '' && stateid != '') && (regezem.test(mailid)) && (regex.test(fname)) && (regex.test(lastname)) && (regexnum.test(mobile)) &&  (regexnum.test(pincode))){
                var fromdata = $("#SetSchooldetails").serialize();
                console.log(fromdata);
                $("#resmessage").text('');
                $("#loader").show();
                $.ajax({
                    url: "<?= base_url('saveregisteraccount') ?>",
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
                        swal({
                            title:"success",
                            text: dataresponce.message,
                            type:"success",
                        },function () {
                            window.location.href = '<?= base_url(); ?>';                
                        });
                    }
                })
                .fail(function(errordata) {
                    console.log(errordata);
                    $("#loader").hide();
                    swal("oops", errordata , "error");
                })              
            }else{
                $("#resmessage").text('Please fill all following fields..!').css('color', 'red');;
            } 
        });

        $('#AadhaarCard').keyup(function() {
            var foo = $(this).val().split("-").join(""); // remove hyphens
            if (foo.length > 0) {
                foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
            }
            $(this).val(foo);
        });
        
    })

    $(document).ready(function(){
        //country to state
        $("#CountryName").change(function(){
            var CountryName = $(this).val();
            //alert(CountryName);
            if(CountryName == ""){
                $("#selectcountryerror").text("please select country name").css('color', 'red');
                $("#StateName").prop('disabled','true');
                $("#CountryName").focus();
            }else{
                $("#selectcountryerror").text("");
                $.ajax({
                    url: '<?= base_url() ?>defaultmethods/stateslist',
                    type: 'POST',
                    dataType: 'json',
                    data: {Countryid: CountryName},
                })
                .done(function(responcedata) {
                    console.log(responcedata);
                    $('#StateName').empty();
                    $("#StateName").removeAttr('disabled');
                    $("#StateName").append("<option value=''>Select State Name</option>");
                    for(var sl = 0;responcedata.length >= sl;sl++){
                        $("#StateName").append("<option value='"+ responcedata[sl].id +"'>"+ responcedata[sl].name +"</option>");
                    }
                    //$("#StateName").append("<option value='other'> Other State </option>");
                })
                .fail(function(req, status, err) {
                    console.log('Something went wrong', status, err);
                    $("#loader").hide();
                }) 
                
            }
        })
        //state to city or dist
        $("#StateName").change(function(){
            var StateName = $(this).val();
            if(StateName == ""){
                $("#selectstateerror").text("please select state name").css('color', 'red');
                $("#CityName").prop('disabled','true');
                $("#StateName").focus();
            }else{
                $("#selectstateerror").text("");
                $.ajax({
                    url: '<?= base_url() ?>defaultmethods/citieslist',
                    type: 'POST',
                    dataType: 'json',
                    data: {Stateid: StateName},
                })
                .done(function(responcedata) {
                    //console.log(responcedata);
                    $('#CityName').empty();
                    $("#CityName").removeAttr('disabled');
                    $("#CityName").append("<option value=''>Select City Name</option>");
                    for(var sl = 0;responcedata.length >= sl;sl++){
                        $("#CityName").append("<option value='"+ responcedata[sl].id +"'>"+ responcedata[sl].name +"</option>");
                    }
                    //$("#CityName").append("<option value='other'> Other City / Dist </option>");
                    
                })
                .fail(function(req, status, err) {
                    //console.log("error : " + errordata);
                    console.log('Something went wrong', status, err);
                    $("#loader").hide();
                }) 
                
            }
        })
    })
</script>
</body>
</html>
