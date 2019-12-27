$(function() {
	//new branch file script code
	$("#registerAccount").hide();
     $("#Regcheckbox").click(function(event) {
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
     

      $("#RegFname").on('keyup',function () {
         var fname   =   $(this).val();
         if(fname === '' ){
             $("#RegFnameerror").text('Enter your first name').css('color', 'red');
         }else if(!regex.test(fname)){
             $("#RegFnameerror").text('First name should be charters only..!').css('color', 'red');
         }else if(fname != ''){
             $("#RegFnameerror").text('');
         }
      });

      $("#RegLname").on('keyup',function () {
         var lname   =   $(this).val();
         if(lname === '' ){
             $("#RegLnameerror").text('Enter your last name..!').css('color', 'red');
         }else if(!regex.test(lname)){
             $("#RegLnameerror").text('Last name should be charters only..!').css('color', 'red');
         }else if(lname != ''){
             $("#RegLnameerror").text('');
         }
      });

     $("#Regemail").on('keyup',function () {
         var mailid   =   $(this).val();
         if(mailid === '' ){
             $("#Regmailerror").text('Enter your email id..!').css('color', 'red');
         }else if(!regezem.test(mailid)){
             $("#Regmailerrors").text('Enter valid email id..!').css('color', 'red');
         }else if(mailid != ''){
             $("#Regmailerror").text('');
         }
     });

     $("#RegMobile").on('keyup',function () {
         var mobile   =   $(this).val();
         //alert(mobile.length);
         if(mobile === '' ){
             $("#Regmobileerror").text('Enter mobile number..!').css('color', 'red');
         }else if(!regexnum.test(mobile)){
             $("#Regmobileerror").text('Enter valid mobile number..!').css('color', 'red');
         }else if(mobile.length < 10){
             $("#Regmobileerror").text('Enter 10 digits Mobile Number..!').css('color', 'red');
         }else if(mobile != '' && mobile.length >= 10){
             $("#Regmobileerror").text('');
         }
     });

     $("#RegPincode").on('keyup',function () {
         var pincode   =   $(this).val();
         if(pincode === '' ){
             $("#Regpincodeerror").text('Enter pincode number..!').css('color', 'red');
         }else if(!regexnum.test(pincode)){
             $("#Regpincodeerror").text('Enter valid pincode..!').css('color', 'red');
         }else if(pincode != ''){
             $("#Regpincodeerror").text('');
         }
     });

     $("#RegAddress").on('keyup',function () {
         var address   =   $(this).val();
         if(address == '' ){
             $("#RegAddresserror").text('Enter Address..!').css('color', 'red');
         }else if(address != ''){
             $("#RegAddresserror").text('');
         }
     });

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

})
