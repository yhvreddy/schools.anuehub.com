<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_useraccounts extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }

    public function index(){
        $this->useraccountlist();
    }

    //useraccounts list
    public function useraccountlist(){
        $data['PageTitle'] = "User Account List";
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['schoolid'] = $schoolid = $schooldata->school_id;
        $data['branchid'] = $branchid = $schooldata->branch_id;
        $data['scltype']  = $schooldata->scltype;
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($schoolid,$branchid);
        $data['useraccountdata']   =   $this->Model_dashboard->selectdata('sms_users',array('school_id'=>$schoolid,'branch_id'=>$branchid),'updated');
        $this->loadViews('admin/useraccounts/sms_useraccountslist_page',$data);
    }

    //fields ajax
    public function fieldssetajax(){
        extract($_REQUEST);
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['schoolid'] = $schoolid = $schooldata->school_id;
        $data['branchid'] = $branchid = $schooldata->branch_id;
        $data['scltype']  = $schooldata->scltype;
        $registerid =   '';
        $employee   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'employee','status'=>1));
        $staff      = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'staff','status'=>1));
        $worker     = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'worker','status'=>1));
        $office     = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'office','status'=>1));
        if($accountmode == 'student'){
            $syllabus = $this->Model_dashboard->syllabustypes($schoolid,$branchid);
            ?>
            <div class="row justify-content-center align-items-center">
                <div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <label for="sclsyllabuslist">Student Syllabus</label>
                    <select type="text" name="StdSyllubas" id="ajaxsclsyllubaslist" required="" class="form-control" style="padding:0px">
                        <option value="">Select Syllabus Type</option>
                        <?php foreach ($syllabus as $key => $value) { ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <label for="SyllabusClasses">Student Class</label>
                    <select type="text" name="StdClass" id="SyllabusClasses" required="" class="form-control" style="padding:0px 10px">
                        <option value="">Select Class</option>
                    </select>
                </div>

                <div class="form-group col-md-5">
                    <label>Select Student Name <span class="text-red">*</span></label>
                    <select class="form-control" name="stdstudent" disabled="" id="stdstudent" required>
                        <option value="">Select class First</option>
                    </select>
                </div>


            <!--<div class="form-group col-md-12">
                <label> <input type="checkbox" value="checked" name="autocredentials" id="autocredentials"><span style="position: absolute;padding-top:2px;left: 30px;top: -2px;">Create username and Password automatically.</span></label>
            </div>-->


                <div id="usercredentials" class="col-md-8">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Enter username <span class="text-red">*</span></label>
                            <input type="text" placeholder="Enter username" class="form-control" name="username" id="username" required="" autocomplete="off">
                            <span id="usernotice"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Enter Password <span class="text-red">*</span></label>
                            <input type="password" placeholder="Enter password" class="form-control" name="password" id="password" required="" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12" id="studentbtn" style="display:none">
                    <input type="submit" value="Create account" name="useraccount" class="btn btn-success pull-right">
                </div>
            </div>
        <?php }else if($accountmode == 'employee'){ ?>
            <div class="row justify-content-center align-items-center">
                <div class="col-md-4">
                    <label>Employee Type <span class="text-red">*</span></label>
                    <div class="form-group">
                        <select class="form-control" id="employeetype" name="emptype" required>
                            <option value="" selected>Select Employee type</option>
                            <?php foreach ($employee as $employees){ ?>
                                <option value="<?=$employees->shortname?>"><?=$employees->name?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="staff col-md-4">
                    <label>Staff Type <span class="text-red">*</span></label>
                    <div class="form-group">
                        <select class="form-control" id="sct" name="emppti">
                            <option value="">Select Staff type</option>
                            <?php foreach ($staff as $employees){ ?>
                                <option value="<?=$employees->shortname?>"><?=$employees->name?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!--<div class="empclass">
                    <b>Select Class</b>
                    <div class="form-group">
                    <select class="form-control show-tick" id="sct" name="empclass" required>
                        <?php //classlist($schoolid,$branchid); ?>
                    </select>
                    </div>
                </div>-->

                <div class="workers col-md-4">
                    <label>Workers Type <span class="text-red">*</span></label>
                    <div class="form-group">
                        <select class="form-control show-tick" id="emppoti" name="emppoti">
                            <option value="">Select worker type</option>
                            <?php foreach ($worker as $employees){ ?>
                                <option value="<?=$employees->shortname?>"><?=$employees->name?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="assistant col-md-4">
                    <label>Office assistant Type <span class="text-red">*</span></label>
                    <div class="form-group">
                        <select class="form-control show-tick" id="empoffic" name="empoffic">
                            <option value="">Office Assistant type</option>
                            <?php foreach ($office as $employees){ ?>
                                <option value="<?=$employees->shortname?>"><?=$employees->name?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label>Select Employee Name <span class="text-red">*</span></label>
                    <select class="form-control" name="employeename" id="employeelist" required>
                        <option value="">Select Employee Mode</option>
                    </select>
                </div>

                <!--<div class="form-group col-md-12">
                    <label> <input type="checkbox" value="checked" name="autocredentials" id="autocredentials"><span style="position: absolute;padding-top: 2px;;left: 30px;top:-4px">Create username and Password automatically.</span></label>
                </div>-->

                <div id="usercredentials" class="col-md-8">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Enter username <span class="text-red">*</span></label>
                            <input type="text" placeholder="Enter username" class="form-control" name="username" id="empusername" autocomplete="off" required>
                            <span id="empnote"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Enter Password <span class="text-red">*</span></label>
                            <input type="password" autocomplete="off" placeholder="Enter password" class="form-control" name="password" id="password" required>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12" id="employeebtn" style="display:none">
                    <input type="submit" value="Create account" name="employeeaccount" class="btn btn-success pull-right">
                </div>
            </div>
        <?php }else{ ?>
            <center>
                <h5><strong>Pleace Select Above Opption</strong></h5>
            </center>
            <img src="<?=base_url('assets/img/pleaseselect.png')?>" class="img-responsive">
        <?php } ?>
        <script>
            $(document).ready(function (){

                $("#ajaxsclsyllubaslist").change(function() {
                    var scltypeslist = $(this).val();
                    //alert(scltypeslist);
                    if(scltypeslist == ""){
                        swal("Please select syllabus type..!");
                        $("#SyllabusClasses").prop('disabled', 'disabled');
                    }else{
                        $("#loader").show();
                        var branchid        = "<?= $branchid ?>";
                        var schoolid        = "<?= $schoolid ?>";
                        var scltypeslist    = $("#ajaxsclsyllubaslist").val();
                        $.ajax({
                            url:"<?= base_url('Defaultmethods/syllubasbyclasses');?>",
                            dataType:'json',
                            method:'POST',
                            data: {schoolid:schoolid,branchid:branchid,syllabustype:scltypeslist},
                        })
                        .done(function (dataresponce) {
                            //console.log(dataresponce);
                            $("#loader").hide();
                            $("#SyllabusClasses").removeAttr('disabled');
                            $("#SyllabusClasses").children('option:not(:first)').remove();
                            var list = "";
                            for($l = 0; dataresponce.length > $l; $l++){
                                list += "<option value='"+ dataresponce[$l] +"'>"+ dataresponce[$l] +"</option>";
                            }
                            $("#SyllabusClasses").append(list);
                        })
                        .fail(function (req, status, err) {
                            console.log('Something went wrong',req, status, err);
                            $("#loader").hide();
                        })
                    }
                });

                $("#SyllabusClasses").change(function(event) {
                    var classname = $(this).val();
                    if(classname.length != 0){
                        $("#stdstudent").removeAttr('disabled');
                    }else{
                        $("#stdstudent").prop('disabled', 'TRUE');
                    }

                });

                $('#autocredentials').click(function(){
                    if($(this).is(":checked")){
                        $('#usercredentials').hide();
                        var checkedvalue = $('#autocredentials').val();
                        $('#username').val('');
                        $('#password').val('');
                        //alert(checkedvalue);
                    }else{
                        $('#usercredentials').show();
                    }
                });

                $("#SyllabusClasses").on('change',function(){
                    var accountclassid = $(this).val();
                    var ajaxsclsyllubaslist = $('#ajaxsclsyllubaslist').val();
                    if(accountclassid == "" && ajaxsclsyllubaslist == ""){
                        $("#SyllabusClasses,#ajaxsclsyllubaslist").focus();
                        return false;
                    }else{
                        $.ajax({
                            url:"<?=base_url('dashboard/useraccounts/smsuseraccountdataajax')?>",
                            data:{accountclassid:accountclassid,sclsyllubas:ajaxsclsyllubaslist},
                            type:'POST',
                            success:function(successinfo){
                                console.log(successinfo);
                                $("#stdstudent").html(successinfo);
                            }
                        })
                    }
                });

                $("#employeetype").on('change',function(){
                    $("#sct,#emppoti,#empoffic").val('');
                });

                $("#sct,#emppoti,#empoffic").on('change',function(){
                    var myseldata = $(this).val();
                    var employeetype = $("#employeetype").val();
                    //alert(employeetype + ' - ' + myseldata);
                    if(myseldata == "" || employeetype == ""){
                        return false;
                        $("#accountclassid").focus();
                    }else{
                        $.ajax({
                            url:"<?=base_url('dashboard/useraccounts/smsuseraccountdataajax')?>",
                            data:{myseldata:myseldata,employeetype:employeetype},
                            type:'post',
                            success:function(successinfo){
                                //console.log(successinfo);
                                $("#employeelist").html(successinfo);
                            }
                        })
                    }
                });

                $("#stdstudent,#employeelist").on('change',function(){
                    var stdstudentdata = $(this).val();
                    if(stdstudentdata == ''){
                        $("#username").prop('disabled',true);
                        $("#password").prop('disabled',true);
                    }else{
                        $("#username").prop('disabled',false);
                        $("#password").prop('disabled',false);
                    }
                });

            });

            $(document).ready(function(){
                var selemployeetype = $("#employeetype").val();
                if($('#employeetype').attr("value")==""){
                    $('.staff').hide();
                    $('.workers').hide();
                    $('.assistant').hide();
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
                }
                if($('#employeetype').attr("value")=="office"){
                    $('.staff').hide();
                    $('.workers').hide();
                    $('.assistant').show();
                }

                var sct = $("#sct").val();
                if($('#sct').attr("value")==""){
                    $('.empclass').hide();
                }
                if($('#sct').attr("value")=="teacher"){
                    $('.empclass').hide();
                }
                if($('#sct').attr("value")=="classteacher"){
                    $('.empclass').show();
                }
                if($('#sct').attr("value")=="tutor"){
                    $('.empclass').hide();
                }

                $("#employeetype").change(function(){
                    $( "#employeetype option:selected").each(function(){
                        if($(this).attr("value")==""){
                            $('.staff').hide();
                            $('.workers').hide();
                            $('.assistant').hide();
                        }
                        if($(this).attr("value")=="staff"){
                            $('.staff').show();
                            $('.workers').hide();
                            $('.assistant').hide();
                        }
                        if($(this).attr("value")=="worker"){
                            $('.staff').hide();
                            $('.workers').show();
                            $('.assistant').hide();
                        }
                        if($(this).attr("value")=="office"){
                            $('.staff').hide();
                            $('.workers').hide();
                            $('.assistant').show();
                        }
                    })
                }).change();
            });

            $(document).ready(function(){
                $("#sct").change(function(){
                    $( "#sct option:selected").each(function(){
                        if($(this).attr("value")==""){
                            $('.empclass').hide();
                        }
                        if($(this).attr("value")=="teacher"){
                            $('.empclass').hide();
                        }
                        if($(this).attr("value")=="classteacher"){
                            $('.empclass').show();
                        }
                        if($(this).attr("value")=="tutor"){
                            $('.empclass').hide();
                        }
                    })
                }).change();
            });

            $(document).ready(function () {
                $("#username,#empusername").keyup(function(){
                    var vdata = $(this).val();
                    var cktype = "checkname";
                    var accountmode = $('#accountmode').val();
                    //console.log(vdata + cktype + accountmode);
                    if(accountmode != 'null' || accountmode != '') {
                        if(accountmode == 'student'){
                            var stdclassid = $("#accountclassid").val();
                            var stdstudent = $("#stdstudent").val();
                            if(stdclassid == '' || stdstudent == ''){
                                alert("please select student class and student name..!");
                            }else{
                                $.ajax({
                                    method: "POST",
                                    data: {username: vdata, cktype: cktype},
                                    url: "<?=base_url('dashboard/useraccounts/usernamecheck')?>",
                                    success: function (responce) {
                                        //alert(responce);
                                        console.log(responce);
                                        if(responce.key == 1){
                                            $("#username,#usernotice").css("color","green");
                                            $("#username").css("border-bottom","2px solid green");
                                            $("#studentbtn").show();
                                            $('#usernotice').text(responce.msg).css('padding','5px 8px');
                                        }else{
                                            $("#username,#usernotice").css("color","red").focus();
                                            $("#username").css("border-bottom","2px solid red");
                                            $("#studentbtn").hide();
                                            $('#usernotice').text(responce.msg).css('padding','5px 8px');
                                        }
                                    },
                                    error: function (err) {
                                        console.log(err);
                                    }
                                });
                            }
                        }else{
                            var employeetype = $("#employeetype").val();
                            if(employeetype == 'staff'){
                                var subtype = $("#sct").val();           //staff
                            }else if(employeetype == 'worker'){
                                var subtype   = $("#emppoti").val();       //worker
                            }else if(employeetype == 'office'){
                                var subtype = $("#empoffic").val();      // officeassistent
                            }
                            var employeelist = $("#employeelist").val();

                            if(employeelist =='' || subtype == '' || employeelist == ''){
                                alert("please select employee type , employee name and other related data..!");
                            }else{
                                $.ajax({
                                    method: "Post",
                                    data: {username: vdata, cktype: cktype},
                                    url: "<?=base_url('dashboard/useraccounts/usernamecheck')?>",
                                    success: function (responce) {
                                        //alert(responce);
                                        console.log(responce);
                                        if(responce.key == 1){
                                            $("#empusername,#empnote").css("color","green");
                                            $("#empusername").css("border-bottom","2px solid green");
                                            $("#employeebtn").show();
                                            $("#empnote").text(responce.msg).css('padding','5px 8px');
                                        }else{
                                            $("#empusername,#empnote").css("color","red").focus();
                                            $("#empusername").css("border-bottom","2px solid red");
                                            $("#employeebtn").hide();
                                            $("#empnote").text(responce.msg).css('padding','5px 8px');
                                        }
                                    },
                                    error: function (err) {
                                        console.log(err);
                                    }
                                });
                            }
                        }
                    }else{
                        alert('please select above fields..!');
                    }
                });
            });
        </script>
        <?php
    }

    //check user names for accounts
    public function usernamecheck(){
        extract($_REQUEST);
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['schoolid'] = $schoolid = $schooldata->school_id;
        $data['branchid'] = $branchid = $schooldata->branch_id;
        $data['scltype']  = $schooldata->scltype;
        $academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
        $batch = $academicyear[0]->academic_year; //adminssion accadmic batch

        if(isset($cktype) && $cktype == 'checkname' && !empty($username)){
            $usernam = trim($username);
            if($usernam == ""){
                $json = array("key" => 0,"msg" => "username should not empty");
            }else{
				$regnames = $this->Model_dashboard->selectdata('sms_regusers',array('username'=>$usernam));
				if(count($regnames) == 0) {
					$usernames = $this->Model_dashboard->selectdata('sms_users', array('username' => $usernam));
					if (count($usernames) != 0) {
						$json = array("key" => 0, "msg" => "# " . $usernam . " already used");
					} else {
						$json = array("key" => 1, "msg" => "* " . $usernam . " is available.");
					}
				}else{
					$json = array("key" => 0, "msg" => "# " . $usernam . " already used");
				}
            }
			header('content-type: application/json');
			echo json_encode($json);
        }
    }

    //all user list names  ajax
    public function smsuseraccountdataajax(){
        extract($_REQUEST);
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['schoolid'] = $schoolid = $schooldata->school_id;
        $data['branchid'] = $branchid = $schooldata->branch_id;
        $data['scltype']  = $schooldata->scltype;
        $academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
        $batch = $academicyear[0]->academic_year; //adminssion accadmic batch
        //student names
        if(!empty($accountclassid) && !empty($sclsyllubas)){
            $accountclassid =   $accountclassid;
            $sclsyllubas    =   $sclsyllubas;
            $students = $this->Model_dashboard->selectdata('sms_admissions',array('school_id' =>$schoolid,'branch_id'=>$branchid,'class_type'=>$sclsyllubas,'class'=>$accountclassid,'status'=>1,'batch'=>$batch));
            if(count($students) <= 0){
                echo "<option value=''>Sorry No students found</option>";
            }else{
                echo "<option value=''>Select Student </option>";
                foreach ($students as $student){
                    $id = $student->id_num;
                    $useraccounts = $this->Model_dashboard->selectdata('sms_users',array('school_id' =>$schoolid,'branch_id'=>$branchid,'id_num'=>$id));
                    if(count($useraccounts) == 0){
                        ?>
                        <option value="<?=$student->id_num;?>"><?php echo $student->firstname.' -> '.$student->id_num; ?></option>
                        <?php
                    }
                }
            }
        }
        //employees data
        if(isset($myseldata) && isset($employeetype)){
            $employeetype = $employeetype;
            $myseldata = $myseldata;
            $employees = $this->Model_dashboard->selectdata('sms_employee',array('school_id' =>$schoolid,'branch_id'=>$branchid,'employeetype'=>$employeetype,'emoloyeeposition'=>$myseldata,'status'=>1));
            if(count($employees) <= 0){
                echo "<option value=''>Sorry No Employees found</option>";
            }else{
                echo "<option value=''>Select Employee </option>";
                foreach($employees as $employee){
                    $id = $employee->id_num;
                    $useraccounts = $this->Model_dashboard->selectdata('sms_users',array('school_id' =>$schoolid,'branch_id'=>$branchid,'id_num'=>$id));
                    if(count($useraccounts) == 0){
                        ?>
                        <option value="<?=$employee->id_num?>"><?=$employee->firstname.' -> '.$employee->id_num; ?></option>
                        <?php
                    }
                }
            }
        }
    }

    //save user account data
    public function saveuseraccountdata(){
        extract($_REQUEST);
        //exit;
        if(isset($useraccount) && !empty($useraccount)){
            $stdclass = $StdClass;
            if($stdclass == "" || $accountmode =='' || $stdstudent == "" || $schoolid == "" || $branchid == ""){
            	$this->failedalert('Please dont submit empty data..!','please fill all required data to create account..!');
                redirect(base_url('dashboard/useraccounts'));
            }else{
                $users = $this->Model_dashboard->selectdata('sms_users',array('school_id' =>$schoolid,'branch_id'=>$branchid,'id_num'=>$stdstudent));
                if(count($users) == 0){
                    $student = $this->Model_dashboard->selectdata('sms_admissions',array('school_id' =>$schoolid,'branch_id'=>$branchid,'id_num'=>$stdstudent,'class'=>$stdclass));
                    $student = $student[0];
                    $fname = $student->firstname;
                    $lname = $student->lastname;
                    if(!empty($student->local_mail_id)){
                    	$useremail =	strtolower($student->local_mail_id);
					}else{
                    	$useremail =    $student->mail_id;
					}
                    $usertype = $accountmode;
                    $pinnum = '1234';

                    $userdata = array(
                        'school_id' =>  $schoolid ,
                        'branch_id' =>  $branchid,
                        'id_num'    =>  $stdstudent,
                        'username'  =>  $username,
                        'password'  =>  md5($password),
                        'usertype'  =>  $usertype,
                        'ipaddress' =>  $this->input->ip_address(),
                        'pinnum'    =>  $pinnum,
                        'mail_id'	=>	$useremail,
                        'updated'   =>  date('Y-m-d H:i:s')
                    );

                    $newaccount = $this->Model_dashboard->insertdata('sms_users',$userdata);
                    if($newaccount != 0){
                    	$this->successalert('User account as successfully created..!',ucwords($fname.'.'.$lname).' account as created successfully. login to change password and pin at first login.');
                        redirect(base_url('dashboard/useraccounts'));
                    }else{
                    	$this->failedalert('Sorry Failed to create user account..!','account not created reqired data is missing.please check once.');
                        redirect(base_url('dashboard/useraccounts'));
                    }
                }else{
					$this->failedalert('Failed to create user account..!','Account as already exits or terminated.please check once and reactive.');
                    redirect(base_url('dashboard/useraccounts'));
                }
            }
        }
        //user-emp accounts
        if(isset($employeeaccount) && !empty($employeeaccount)){

            $employeeid = $employeename;
            $emptype = $emptype;
            $usertype = "";
            if($emptype == ''){
                return false;
            }else if($emptype == 'staff'){
                $user = $_POST['emppti'];
                if($user == ""){
                    return false;
                }else{
                    $usertype = $user;
                }
            }else if($emptype == 'worker'){
                $user = $_POST['emppoti'];
                if($user == ""){
                    return false;
                }else{
                    $usertype = $user;
                }
            }else if($emptype == 'office'){
                $user = $_POST['empoffic'];
                if($user == ""){
                    return false;
                }else{
                    $usertype = $user;
                }
            }


            if($employeeid == "" || $emptype == "" || $usertype == "" || $branchid == "" || $schoolid == ""){
				$this->failedalert('Please dont submit empty data..!','please fill all required data to create account..!');
                redirect(base_url('dashboard/useraccounts'));
            }else{
                $users = $this->Model_dashboard->selectdata('sms_users',array('school_id' =>$schoolid,'branch_id'=>$branchid,'id_num'=>$employeeid));
                if(count($users) == 0){
                    $employee = $this->Model_dashboard->selectdata('sms_employee',array('school_id' =>$schoolid,'branch_id'=>$branchid,'id_num'=>$employeeid,'employeetype'=>$emptype,'emoloyeeposition'=>$usertype));
                    $employee = $employee[0];
                    $fname = $employee->firstname;
                    $lname = $employee->lastname;
					if(!empty($employee->local_mail_id)){
						$useremail =	strtolower($employee->local_mail_id);
					}else{
						$useremail =    $employee->mail_id;
					}
                    $username = $_POST['username'];
                    $pwd = $_POST['password'];
                    $password = md5($_POST['password']);
                    $pinnum = '1234';

                    $userdata = array(
                        'school_id' =>  $schoolid ,
                        'branch_id' =>  $branchid,
                        'id_num'    =>  $employeeid,
                        'username'  =>  $username,
                        'password'  =>  $password,
                        'usertype'  =>  $usertype,
						'mail_id'	=>	$useremail,
                        'ipaddress' =>  $this->input->ip_address(),
                        'pinnum'    =>  $pinnum,
                        'updated'   =>  date('Y-m-d H:i:s')
                    );

                    $newaccount = $this->Model_dashboard->insertdata('sms_users',$userdata);
					if($newaccount != 0){
						$this->successalert('User account as successfully created..!',ucwords($fname.'.'.$lname).' account as created successfully. login to change password and pin at first login.');
						redirect(base_url('dashboard/useraccounts'));
					}else{
						$this->failedalert('Sorry Failed to create user account..!','account not created reqired data is missing.please check once.');
						redirect(base_url('dashboard/useraccounts'));
					}
				}else{
					$this->failedalert('Failed to create user account..!','Account as already exits or terminated.please check once and reactive.');
					redirect(base_url('dashboard/useraccounts'));
				}
            }
        }
    }

    //user account off/on
    public function useraccountoffon(){
        extract($_REQUEST);
        if(isset($userid) && !empty($userid)){
            $users = $this->Model_dashboard->selectdata('sms_users',array('sno'=>$userid));
            $status = $users[0]->status;
            if($status == '1'){
                //echo "Yes";
                $upquery = $this->Model_dashboard->updatedata(array('status'=>0,'updated'=>date('Y-m-d H:i:s')),array('sno'=>$userid),'sms_users');
                if($upquery != 0){
                    $json = array("key" => 1,"msg" => "You have successfully deactivated - ".$users[0]->id_num);
                }else{
                    $json = array("key" => 0,"msg" => "You have not successfully deactivated".' -'.$users[0]->id_num);
                }

            }else{
                //echo "No";
                $upquery = $this->Model_dashboard->updatedata(array('status'=>1,'updated'=>date('Y-m-d H:i:s')),array('sno'=>$userid),'sms_users');
                if($upquery != 0){
                    $json = array("key" => 1,"msg" => "You have successfully activated - ".$users[0]->id_num);
                }else{
                    $json = array("key" => 0,"msg" => "You have not successfully activated - ".$users[0]->id_num);
                }
            }
        }else{
            $json = array("key" => 0,"msg" => "Invalid request".$users[0]->id_num);
        }

        header('content-type: application/json');
        echo json_encode($json);
    }

    public function newaccount(){
        $data['PageTitle'] = "New User Account";
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['schoolid'] = $schoolid = $schooldata->school_id;
        $data['branchid'] = $branchid = $schooldata->branch_id;
        $data['scltype']  = $schooldata->scltype;
        //print_r($schooldata);
        $data['employee']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'employee','status'=>1));
        $data['staff']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'staff','status'=>1));
        $data['worker']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'worker','status'=>1));
        $data['office']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'office','status'=>1));
        //sending syllabus data to views and getting class data by ajax
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($schoolid,$branchid);
        $data['branchlist'] = $this->Model_dashboard->selectdata('sms_schoolinfo',array('scltype'=>'GSB','branch_id'=>$branchid));
        $data['schooldata'] = $schooldata;
        $this->loadViews('admin/useraccounts/sms_useraccount_page',$data);
    }
}
