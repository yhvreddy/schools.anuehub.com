<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_attendence extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }
    
    //enote for superadmin or admin only to save guide for like prof
    public function index($externaldata = NULL){
        $this->addnewAttendence();
    }
    
    //Add Attendence for admin and superadmin
    public function addnewAttendence(){
        $data['schooldata'] = $schooldata = $this->session->userdata['school'];
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "New Attendence..!";
        //getting school data in session
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
        $this->loadViews('admin/attendence/attendence_add',$data);
    }

    //ajax
    public function attendanceDatafetch(){
        extract($_REQUEST);
        //$this->print_r($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        //student data
        if((isset($attendancetype) && $attendancetype != '') && (isset($stdclass) && $stdclass != '') && (isset($selecteddate) && $selecteddate != '') && (isset($stdsyllubas) && $stdsyllubas != '')){

            $academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
            $batch = $academicyear[0]->academic_year;

            $students = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'batch'=>$batch,'class_type'=>$stdsyllubas,'class'=>$stdclass));

            if(count($students) == 0){ ?>
                <center>
                    <img src="<?=base_url()?>assets/images/norecordfound.png" style="width:450px;margin:40px 0px">
                </center>
            <?php }else{ ?>
                <style>
                    table.table-bordered.dataTable tbody td {
                        line-height: 28px;
                    }
                </style>
                <form method="post" action="#" id="StudentNewAttendence">
                    <div class="clearfix">
                        <h4 class="pull-left pt-2 text-info"><?=$stdclass.' Students List'?></h4>
                        <input type="button" value="Save Attendence" name="studentattendence" class="btn btn-success pull-right" id="studentattendence">
                    </div>
                    <input type="hidden" value="<?=$selecteddate;?>" id="seldate" name="seldate">
                    <input type="hidden" value="<?=$stdclass;?>" id="selclass" name="selclass">
                    <input type="hidden" value="<?=$stdsyllubas;?>" id="seldate" name="selsyllubas">
                    <input type="hidden" value="student" name="attendencetype">
                    <table id="attendancelist" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sno</th>
                                <th></th>
                                <th>Std Id</th>
                                <th>Student Name</th>
                                <th>Sec - Rollno</th>
                                <th>Mobile</th>
                                <th>Attendance</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        foreach($students as $student){
                            $attendnce = $this->Model_dashboard->selectdata('sms_attendence',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'id_num'=>$student->id_num,'att_date'=>date('Y-m-d',strtotime($selecteddate)),'att_type'=>'student'));
                            if(count($attendnce) == 0){
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <script>
                                    $(document).ready(function(){
                                        var firstName = '<?=$student->firstname?>';
                                        var lastName = '<?=$student->lastname?>';
                                        var intials = firstName.charAt(0) + lastName.charAt(0);
                                        var profileImage = $('#profileImage<?=$student->sno?>').text(intials);
                                    });
                                </script>
                                <td align="center">
                                    <?php if(!empty($student->student_image)){ ?>
                                        <img src="<?=base_url($student->student_image)?>" class="profileImage">
                                    <?php }else{ ?>
                                        <div id="profileImage<?=$student->sno;?>" class="profileImage text-uppercase"></div>
                                    <?php } ?>
                                </td>
                                <td><?php echo $student->id_num; ?></td>
                                <td><?php echo $student->firstname.'.'.$student->lastname; ?></td>
                                <td align="center"><?php echo $student->section.' &nbsp;&nbsp; <i class="fa fa-arrow-right"></i> &nbsp;&nbsp;'.$student->rollno; ?></td>
                                <td><?php echo $student->mobile; ?></td>
                                <td>
                                    <input type="hidden" value="<?php echo $student->sno; ?>" id="attdsno<?php echo $student->sno; ?>" name="student_sno[]">
                                    <input type="hidden" value="<?php echo $student->id_num; ?>" id="attregno<?php echo $student->sno; ?>" name="student_id[]">
                                    <div class="form-group form-group-sm">
                                        <?php $att = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'attendence','status'=>1));
                                            foreach ($att as $attendence){ ?>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" id="inlineCssRadio1<?=$attendence->shortname?><?php echo $student->sno; ?>" name="student_attendence_<?=$i - 1;?>" value="<?=$attendence->shortname?>" />
                                                <label for="inlineCssRadio1<?=$attendence->shortname?><?php echo $student->sno; ?>"><?=$attendence->name?></label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                            <?php	$i++ ;
                        }} ?>
                        </tbody>
                    </table>
                    <!--<div class="clearfix row justify-content-center align-items-center">
                        <input type="button" value="Save Attendence" name="studentattendence" class="btn btn-success pull-right" id="studentattendence">
                    </div>-->
                </form>
                <script>
                    $('#studentattendence').on('click',function () {
                        $("#loader").show();
                        var totalcount = '<?=count($students)?>';
                        var tselected = $('input[type="radio"]:checked').length;
                        if(totalcount == tselected){
                            var attendencedata = $("#StudentNewAttendence").serialize();
                            //console.log(attendencedata);
                            $.ajax({
                                url:"<?=base_url('dashboard/attendence/ajax/stdattendancesave')?>",
                                data:attendencedata,
                                type:"POST",
                                dataType: 'json',
                                success:function(stdsuccess){
                                    $("#loader").hide();
                                    console.log(stdsuccess.msg);
                                    if(stdsuccess.code == 1){
                                        $('#StudentNewAttendence').trigger("reset");
                                        $('#attlistofuser').text('');
                                        $.gritter.add({
                                            title:stdsuccess.msg,
                                            text:stdsuccess.text,
                                            sticky:false,
                                            time:'',
                                            //fade_in_speed: 100,
                                            //fade_out_speed: 100,
                                            class_name:"my-sticky-class"
                                        });
                                        return false;
                                    }else{
                                        $.gritter.add({
                                            title:stdsuccess.msg,
                                            text:stdsuccess.text,
                                            sticky:false,
                                            time:'',
                                            //fade_in_speed: 100,
                                            //fade_out_speed: 100,
                                            class_name:"my-sticky-class"
                                        });
                                        return false;
                                    }
                                }
                            })
                        }else{
                            if(tselected <= 0){
                                alert('Student Attendence do not Save as empty.');
                            }else{
                                if(confirm("Do you Want Make Attendence of "+tselected + " Student's")){
                                    var attendencedata = $("#StudentNewAttendence").serialize();
                                    //console.log(attendencedata);
                                    $.ajax({
                                        url:"<?=base_url('dashboard/attendence/ajax/stdattendancesave')?>",
                                        data:attendencedata,
                                        type:"POST",
                                        dataType: 'json',
                                        success:function(stdsuccess){
                                            $("#loader").hide();
                                            console.log(stdsuccess);
                                            if(stdsuccess.code == 1){
                                                $('#StudentNewAttendence').trigger("reset");
                                                $.gritter.add({
                                                    title:stdsuccess.msg,
                                                    text:stdsuccess.text,
                                                    sticky:false,
                                                    time:'',
                                                    //fade_in_speed: 100,
                                                    //fade_out_speed: 100,
                                                    class_name:"my-sticky-class"
                                                });
                                                return false;
                                                $('#attlistofuser').text('');
                                            }else{
                                                $.gritter.add({
                                                    title:stdsuccess.msg,
                                                    text:stdsuccess.text,
                                                    sticky:false,
                                                    time:'',
                                                    //fade_in_speed: 100,
                                                    //fade_out_speed: 100,
                                                    class_name:"my-sticky-class"
                                                });
                                                return false;
                                            }
                                        }
                                    })
                                }else{
                                    alert('Make it Later..!');
                                }
                            }
                            $("#loader").hide();
                        }
                    });
                    $('#attendancelist').DataTable({
                        'paging'      : false,
                        'lengthChange': false,
                        'searching'   : false,
                        'ordering'    : false,
                        'info'        : false,
                        'autoWidth'   : false,
                        'bSort' : false
                    });
                </script>
            <?php }
        }

        //employee data
        if((isset($atttype) && $atttype != '') && (isset($seldate) && $seldate != '') && (isset($attmode) && $attmode != '')){

            $academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
            $batch = $academicyear[0]->academic_year;

            $employees = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1));

            if(count($employees) == 0){ ?>
                <center>
                    <img src="<?=base_url()?>assets/images/norecordfound.png" style="width:450px;margin:40px 0px">
                </center>
            <?php }else if(count($employees) != 0){ ?>
                <style>
                    table.table-bordered.dataTable tbody td {
                        line-height: 28px;
                    }
                </style>
                <form method="post" action="#" id="EmployeeNewAttendence">
                    <div class="clearfix">
                        <h4 class="pull-left pt-2 text-info"><?="Employee's List"?></h4>
                        <input type="button" value="Save Attendence" name="employeeattendence" class="btn btn-success pull-right" id="employeeattendence">
                    </div>
                    <input type="hidden" value="<?php echo $seldate; ?>" id="seldate" name="seldate">
                    <input type="hidden" value="employee" name="attendencetype">
                    <table id="attendancelist" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Sno</th>
                            <th></th>
                            <th>Emp Id</th>
                            <th>Name</th>
                            <th>Emp Type</th>
                            <th>Mobile</th>
                            <th>Attendance</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i = 1;
                            foreach($employees as $empdata){
                                $attendnce = $this->Model_dashboard->selectdata('sms_attendence',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'id_num'=>$empdata->id_num,'att_date'=>date('Y-m-d',strtotime($seldate)),'att_type'=>'employee'));
                                if(count($attendnce) == 0){
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <script>
                                        $(document).ready(function(){
                                            var firstName = '<?=$empdata->firstname?>';
                                            var lastName = '<?=$empdata->lastname?>';
                                            var intials = firstName.charAt(0) + lastName.charAt(0);
                                            var profileImage = $('#profileImage<?=$empdata->sno?>').text(intials);
                                        });
                                    </script>
                                    <td align="center">
                                        <?php if(!empty($empdata->employee_pic)){ ?>
                                            <img src="<?=base_url($empdata->employee_pic)?>" class="profileImage">
                                        <?php }else{ ?>
                                            <div id="profileImage<?=$empdata->sno;?>" class="profileImage text-uppercase"></div>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $empdata->id_num; ?></td>
                                    <td><?php echo $empdata->firstname.'.'.$empdata->lastname; ?></td>
                                    <td align="center"><?php echo ucwords($empdata->emoloyeeposition); ?></td>
                                    <td><?php echo $empdata->mobile; ?></td>
                                    <td>
                                        <input type="hidden" value="<?php echo $empdata->sno; ?>" id="attdsno<?php echo $empdata->sno; ?>" name="employee_sno[]">
                                        <input type="hidden" value="<?php echo $empdata->id_num; ?>" id="attregno<?php echo $empdata->sno; ?>" name="employee_id[]">
                                        <div class="form-group form-group-sm">
                                            <?php $eatt = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'attendence','status'=>1));
                                                foreach ($eatt as $attendence){ ?>
                                                <div class="radio radio-css radio-inline">
                                                    <input type="radio" id="inlineCssRadio1<?=$attendence->shortname?><?php echo $empdata->sno; ?>" name="employeeattendence_<?=$i - 1;?>" value="<?=$attendence->shortname?>" />
                                                    <label for="inlineCssRadio1<?=$attendence->shortname?><?php echo $empdata->sno; ?>"><?=$attendence->name?></label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php	$i++ ;
                            } } ?>
                        </tbody>
                    </table>
                </form>
                <!--<div class="clearfix row justify-content-center align-items-center">
                    <input type="button" value="Save Attendence" name="employeeattendence" class="btn btn-success pull-right" id="employeeattendence">
                </div>-->
                <script>
                    $('#employeeattendence').on('click',function () {
                        $("#loader").show();
                        var totalcount = '<?=count($employees)?>';
                        var tselected = $('input[type="radio"]:checked').length;
                        if(totalcount == tselected){
                            var attendencedata = $("#EmployeeNewAttendence").serialize();
                            //console.log(attendencedata);
                            $.ajax({
                                url:"<?=base_url('dashboard/attendence/ajax/empattendancesave')?>",
                                data:attendencedata,
                                type:"POST",
                                dataType: 'json',
                                success:function(stdsuccess){
                                    $("#loader").hide();
                                    console.log(stdsuccess);
                                    if(stdsuccess.code == 1){
                                        $('#EmployeeNewAttendence').trigger("reset");
                                        $('#attlistofuser').text('');
                                        $.gritter.add({
                                            title:stdsuccess.msg,
                                            text:stdsuccess.text,
                                            sticky:false,
                                            time:'',
                                            //fade_in_speed: 100,
                                            //fade_out_speed: 100,
                                            class_name:"my-sticky-class"
                                        });
                                        return false;
                                    }else{
                                        $.gritter.add({
                                            title:stdsuccess.msg,
                                            text:stdsuccess.text,
                                            sticky:false,
                                            time:'',
                                            //fade_in_speed: 100,
                                            //fade_out_speed: 100,
                                            class_name:"my-sticky-class"
                                        });
                                        return false;
                                    }
                                }
                            })
                        }else{
                            if(tselected <= 0){
                                alert('Employee Attendence do not Save as empty.');
                            }else{
                                if(confirm("Do you Want Make Attendence of "+tselected + " Employee's")){
                                    //alert(tselected + "Employee's");
                                    $.ajax({
                                        url:"<?=base_url('dashboard/attendence/ajax/empattendancesave')?>",
                                        data:attendencedata,
                                        type:"POST",
                                        dataType: 'json',
                                        success:function(stdsuccess){
                                            $("#loader").hide();
                                            console.log(stdsuccess);
                                            if(stdsuccess.code == 1){
                                                $('#EmployeeNewAttendence').trigger("reset");
                                                $('#attlistofuser').text('');
                                                $.gritter.add({
                                                    title:stdsuccess.msg,
                                                    text:stdsuccess.text,
                                                    sticky:false,
                                                    time:'',
                                                    //fade_in_speed: 100,
                                                    //fade_out_speed: 100,
                                                    class_name:"my-sticky-class"
                                                });
                                                return false;
                                            }else{
                                                $.gritter.add({
                                                    title:stdsuccess.msg,
                                                    text:stdsuccess.text,
                                                    sticky:false,
                                                    time:'',
                                                    //fade_in_speed: 100,
                                                    //fade_out_speed: 100,
                                                    class_name:"my-sticky-class"
                                                });
                                                return false;
                                            }
                                        }
                                    })
                                }else{
                                    alert('Make it Later..!');
                                }
                            }
                            $("#loader").hide();
                        }
                    });
                    $('#attendancelist').DataTable({
                        'paging'      : false,
                        'lengthChange': false,
                        'searching'   : false,
                        'ordering'    : false,
                        'info'        : false,
                        'autoWidth'   : false,
                        'bSort' : false
                    });
                </script>
            <?php }
        }

    }

    //save attendence
    public function stdattendanceSave(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $student_sno = array_filter($student_sno);
        $student_id  = array_filter($student_id);
        $insert = '';
        $schooltimngs = $this->Model_dashboard->selectdata('sms_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1));

        /*if(count($schooltimngs) != 0){
            $schooltimngs = $schooltimngs[0];
            $attfrom = $schooltimngs->fromtime; //school start time
            $attfrom = date('h:i', strtotime($attfrom));

            $sclmto = new DateTime($attfrom);
            $sclmto->add(new DateInterval('PT1H'));
            $attend = $sclmto->format('h:i');

            $scllate = new DateTime($attend);
            $scllate->add(new DateInterval('PT15M'));
            $attlate = $scllate->format('h:i');

            $curtime = date("h:i"); // A = AM/PM


        }*/
        $AMPM = date('A');
        //set attendence value to array
        for($i=0;count($student_sno) > $i;$i++){
            $attendence[] = @${'student_attendence_' . $i};
        }
        //$this->print_r($students);
        foreach ($student_sno as $student => $value){
            $insertdata[$student] = array(
                'school_id' =>  $schooldata->school_id,
                'branch_id' =>  $schooldata->branch_id,
                'att_date'  =>  date('Y-m-d',strtotime($seldate)),
                'class'     =>  $selclass,
                'syllubas'  =>  $selsyllubas,
                'att_type'  =>  $attendencetype,
                'id_num'    =>  $student_id[$student],
                'att_mode'  =>  $attendence[$student],
                'id'        =>  $value,
                'att_timeon'=>  $AMPM,
                'updated'   =>  date('Y-m-d H:i:s')
            );
        }
        for($i=0;count($insertdata) > $i;$i++){
            $value = trim($attendence[$i]);
            if(empty($value)) {
                unset($insertdata[$value]);
            }else {
                //echo json_encode($insertdata[$i]);
                $insert = $this->Model_dashboard->insertdata('sms_attendence',$insertdata[$i]);
                if($insert != 0){
                    $countsuccessvalues[] = $insert;
                    $output = array('code'=>1,'msg'=>'successfully saved Attendence Data..!','text'=>'');
                }else{
                    $output = array('code'=>0,'msg'=>'Failed to saved Attendence Data..!','text'=>'');
                }
            }
        }
        echo json_encode($output);
//        echo count(@$countfailedvalues).' failed to insert,';
//        echo count(@$countsuccessvalues).' Success';
        //$this->print_r($insertdata);
    }

    public function empattendanceSave(){
        extract($_REQUEST);
//        $this->print_r($_REQUEST);
//        exit;
        $schooldata = $this->session->userdata['school'];
        $employee_sno = array_filter($employee_sno);
        $employee_id  = array_filter($employee_id);
        $insert = '';
        $schooltimngs = $this->Model_dashboard->selectdata('sms_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1));

        /*if(count($schooltimngs) != 0){
            $schooltimngs = $schooltimngs[0];
            $attfrom = $schooltimngs->fromtime; //school start time
            $attfrom = date('h:i', strtotime($attfrom));

            $sclmto = new DateTime($attfrom);
            $sclmto->add(new DateInterval('PT1H'));
            $attend = $sclmto->format('h:i');

            $scllate = new DateTime($attend);
            $scllate->add(new DateInterval('PT15M'));
            $attlate = $scllate->format('h:i');

            $curtime = date("h:i"); // A = AM/PM


        }*/
        $AMPM = date('A');
        //set attendence value to array
        for($i=0;count($employee_sno) > $i;$i++){
            $attendence[] = @${'employeeattendence_'. $i};
        }
        //$this->print_r($students);
        foreach ($employee_sno as $employee => $value){
            $insertdata[$employee] = array(
                'school_id' =>  $schooldata->school_id,
                'branch_id' =>  $schooldata->branch_id,
                'att_date'  =>  date('Y-m-d',strtotime($seldate)),
                'att_type'  =>  $attendencetype,
                'id_num'    =>  $employee_id[$employee],
                'att_mode'  =>  $attendence[$employee],
                'id'        =>  $value,
                'att_timeon'=>  $AMPM,
                'updated'   =>  date('Y-m-d H:i:s')
            );
        }
        for($i=0;count($insertdata) > $i;$i++){
            $value = trim($attendence[$i]);
            if(empty($value)) {
                unset($insertdata[$value]);
            }else {
                //echo json_encode($insertdata[$i]);
                $insert = $this->Model_dashboard->insertdata('sms_attendence',$insertdata[$i]);
                if($insert != 0){
                    $countsuccessvalues[] = $insert;
                    $output = array('code'=>1,'msg'=>'successfully saved Attendence Data..!','text'=>'');
                }else{
                    $output = array('code'=>0,'msg'=>'Failed to saved Attendence Data..!','text'=>'');
                }
            }
        }
        echo json_encode($output);
//        echo count(@$countfailedvalues).' failed to insert,';
//        echo count(@$countsuccessvalues).' Success';
        //$this->print_r($insertdata);
    }

    public function attendenceList(){
        $data['schooldata'] = $schooldata = $this->session->userdata['school'];
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "Attendence List..!";
        //getting school data in session
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
        $this->loadViews('admin/attendence/attendence_list',$data);
    }

    public function attendanceDatalistfetch(){
        extract($_REQUEST);
        //$this->print_r($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        //student data
        if((isset($attendancetype) && $attendancetype == 'std') && (isset($stdclass) && $stdclass != '') && (isset($selecteddate) && $selecteddate != '') && (isset($stdsyllubas) && $stdsyllubas != '')){

            $academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
            $batch = $academicyear[0]->academic_year;

            $students = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'batch'=>$batch,'class_type'=>$stdsyllubas,'class'=>$stdclass));
            //$attendence = $this->Model_dashboard->selectdata('sms_attendence',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'att_type'=>'student','class_type'=>$stdsyllubas,'class'=>$stdclass));

            if(count($students) == 0){ ?>
                <center>
                    <img src="<?=base_url()?>assets/images/norecordfound.png" style="width:450px;margin:40px 0px">
                </center>
            <?php }else{ ?>
                <style>
                    table.table-bordered.dataTable tbody td {
                        line-height: 28px;
                    }
                </style>
                
                <?php
                    $dft = date('Y-m',strtotime($selecteddate));
                    //displaying dates of month
                    $date = $dft;//date('Y-M');
                    $end = date('Y-m-',strtotime($selecteddate)).date('t', strtotime($date));
                    //get month and year form selected data
                    $selectedmonth = date('m',strtotime($selecteddate));
                    $selectedyear  = date('Y',strtotime($selecteddate));
                ?>
                <div id="StudentNewAttendence">
                    <div class="clearfix">
                        <h4 class="text-info text-center"><?=$stdclass.' Students Attendence List'?></h4>
                    </div>
                    <div class="clearfix">
                        <table class="table table-striped table-bordered table-responsive" id="attendancelist">
                            <thead>
                                <th></th>
                                <th width="">Student Id</th>
                                <?php while(strtotime($date) <= strtotime($end)) {
                                    $day_num = date('d', strtotime($date));
                                    $day_name = date('l', strtotime($date));
                                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date))); ?>
                                    <th style="font-size:12px"><?php echo $day_num ?><br/><?php //echo $day_name ?></th>
                                <?php } ?>
                            </thead>
                            <tbody>
                                <?php foreach($students as $student){ ?>

                                    <tr>
                                        <script>
                                            $(document).ready(function(){
                                                var firstName = '<?=$student->firstname?>';
                                                var lastName = '<?=$student->lastname?>';
                                                var intials = firstName.charAt(0) + lastName.charAt(0);
                                                var profileImage = $('#profileImage<?=$student->sno?>').text(intials);
                                            });
                                        </script>
                                        <td align="center">
                                            <?php if(!empty($student->student_image)){ ?>
                                                <img src="<?=base_url($student->student_image)?>" class="profileImage">
                                            <?php }else{ ?>
                                                <div id="profileImage<?=$student->sno;?>" class="profileImage text-uppercase"></div>
                                            <?php } ?>
                                        </td>
                                        <td><a href="javascript:;" data-toggle="tooltip" title="<?=$student->firstname.'.'.substr($student->lastname,0,1); ?>"><?=$student->id_num; ?></a></td>
                                        <?php for($i = 1;date('d',strtotime($end)) >= $i;$i++) {
                                            //$attdata['att_type'];
                                            $date = $dft.'-'.$i;
                                            $day_num = date('d', strtotime($date));
                                            $day_name = date('l', strtotime($date));
                                            $dateon =  date('Y-m-d', strtotime($date));
                                            $attendencedata = $this->Model_dashboard->customquery("SELECT * FROM `sms_attendence` WHERE school_id = '$schooldata->school_id' AND branch_id = '$schooldata->branch_id' AND id_num ='$student->id_num' AND att_date  like '%$dateon%' AND att_type = 'student' AND id = $student->sno");
                                            $cdate = date('d');

                                                if (count($attendencedata) != 0) {
                                                    $attdata = $attendencedata[0];
                                                    $old_date = $attdata->att_date;
                                                    $eee = date('Y-m-d', strtotime($old_date));
                                                    $ananyt = explode('-', $eee);
                                                    if ($day_num == $ananyt[2] && $day_num <= $cdate) {
                                                        if ($attdata->att_mode == 'P') {
                                                            $adata = "<label class='text-success'>P</label>";
                                                        } else if ($attdata->att_mode == 'A') {
                                                            $adata = "<label class='text-danger'>A</label>";
                                                        } else if ($attdata->att_mode == 'L') {
                                                            $adata = "<label class='text-warning'>L</label>";
                                                        } else if ($attdata->att_mode == 'HF') {
                                                            $adata = "<label class='text-info'>H</label>";
                                                        }
                                                    }
                                                } else {
                                                    if($day_num <= $cdate){
                                                        $adata = "<label class='text-danger'>A</label>";
                                                    }else{
                                                        $adata = '';
                                                    }
                                                }
                                            
                                        ?>
                                            <td style="font-size:12px"><?=$adata;?></td>
                                        <?php } ?>
                                    </tr>
                                <?php }  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <script>
                    $('#attendancelist').DataTable({
                        'paging'      : false,
                        'lengthChange': false,
                        'searching'   : true,
                        'ordering'    : false,
                        'info'        : true,
                        'autoWidth'   : true,
                        'bSort' : true,
                        //scrollY:        "300px",
                        //scrollX:        true,
                        fixedHeader: true,
                        scrollCollapse: true,
                        fixedColumns  :   {
                            leftColumns: 2
                        },
                        buttons: [
                            'copy', 'excel', 'pdf'
                        ]
                    });
                    $('[data-toggle="tooltip"]').tooltip();
                </script>
            <?php }
        }

        //employee data
        if((isset($atttype) && $atttype == 'emp') && (isset($seldate) && $seldate != '') && (isset($attmode) && $attmode != '')){

            $academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
            $batch = $academicyear[0]->academic_year;

            $employees = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1));
            $selecteddate   =   $seldate;
            if(count($employees) == 0){ ?>
                <center>
                    <img src="<?=base_url()?>assets/images/norecordfound.png" style="width:450px;margin:40px 0px">
                </center>
            <?php }else if(count($employees) != 0){ ?>
                <style>
                    table.table-bordered.dataTable tbody td {
                        line-height: 28px;
                    }
                </style>
                <?php
                $dft = date('Y-m',strtotime($selecteddate));
                //displaying dates of month
                $date = $dft;//date('Y-M');
                $end = date('Y-m-',strtotime($selecteddate)).date('t', strtotime($date));
                //get month and year form selected data
                $selectedmonth = date('m',strtotime($selecteddate));
                $selectedyear  = date('Y',strtotime($selecteddate));
                ?>
                <div id="EmployeeNewAttendence">
                    <div class="clearfix">
                        <h4 class="text-center pt-2 text-info"><?="Employee's Attendence List"?></h4>
                    </div>
                    <div class="clearfix">
                        <table class="table table-striped table-bordered table-responsive" id="attendancelist">
                            <thead>
                            <th></th>
                            <th width="">Employee Id</th>
                            <?php while(strtotime($date) <= strtotime($end)) {
                                $day_num = date('d', strtotime($date));
                                $day_name = date('l', strtotime($date));
                                $date = date("Y-m-d", strtotime("+1 day", strtotime($date))); ?>
                                <th style="font-size:12px"><?php echo $day_num ?><br/><?php //echo $day_name ?></th>
                            <?php } ?>
                            </thead>
                            <tbody>
                            <?php foreach($employees as $employee){ ?>

                                <tr>
                                    <script>
                                        $(document).ready(function(){
                                            var firstName = '<?=$employee->firstname?>';
                                            var lastName = '<?=$employee->lastname?>';
                                            var intials = firstName.charAt(0) + lastName.charAt(0);
                                            var profileImage = $('#profileImage<?=$employee->sno?>').text(intials);
                                        });
                                    </script>
                                    <td align="center">
                                        <?php if(!empty($employee->student_image)){ ?>
                                            <img src="<?=base_url($employee->student_image)?>" class="profileImage">
                                        <?php }else{ ?>
                                            <div id="profileImage<?=$employee->sno;?>" class="profileImage text-uppercase"></div>
                                        <?php } ?>
                                    </td>
                                    <td><a href="javascript:;" data-toggle="tooltip" title="<?=$employee->firstname.'.'.substr($employee->lastname,0,1); ?>"><?=$employee->id_num; ?></a></td>
                                    <?php for($i = 1;date('d',strtotime($end)) >= $i;$i++) {
                                        //$attdata['att_type'];
                                        $date = $dft.'-'.$i;
                                        $day_num = date('d', strtotime($date));
                                        $day_name = date('l', strtotime($date));
                                        $dateon =  date('Y-m-d', strtotime($date));
                                        $attendencedata = $this->Model_dashboard->customquery("SELECT * FROM `sms_attendence` WHERE school_id = '$schooldata->school_id' AND branch_id = '$schooldata->branch_id' AND id_num ='$employee->id_num' AND att_date  like '%$dateon%' AND att_type = 'employee' AND id = $employee->sno");
                                        $cdate = date('d');

                                        if (count($attendencedata) != 0) {
                                            $attdata = $attendencedata[0];
                                            $old_date = $attdata->att_date;
                                            $eee = date('Y-m-d', strtotime($old_date));
                                            $ananyt = explode('-', $eee);
                                            if($day_num == $ananyt[2] && $day_num <= $cdate) {
                                                if ($attdata->att_mode == 'P') {
                                                    $adata = "<label class='text-success'>P</label>";
                                                } else if ($attdata->att_mode == 'A') {
                                                    $adata = "<label class='text-danger'>A</label>";
                                                } else if ($attdata->att_mode == 'L') {
                                                    $adata = "<label class='text-warning'>L</label>";
                                                } else if ($attdata->att_mode == 'HF') {
                                                    $adata = "<label class='text-info'>H</label>";
                                                }
                                            }
                                        } else {
                                            if($day_num <= $cdate){
                                                $adata = "<label class='text-danger'>A</label>";
                                            }else{
                                                $adata = '';
                                            }
                                        }

                                        ?>
                                        <td style="font-size:12px"><?=$adata;?></td>
                                    <?php } ?>
                                </tr>
                            <?php }  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <script>
                    $('#attendancelist').DataTable({
                        'paging'      : false,
                        'lengthChange': false,
                        'searching'   : true,
                        'ordering'    : false,
                        'info'        : true,
                        'autoWidth'   : true,
                        'bSort' : true,
                        //scrollY:        "300px",
                        //scrollX:        true,
                        fixedHeader: true,
                        scrollCollapse: true,
                        fixedColumns  :   {
                            leftColumns: 2
                        },
                        buttons: [
                            'copy', 'excel', 'pdf'
                        ]
                    });
                    $('[data-toggle="tooltip"]').tooltip();
                </script>
            <?php }
        }
    }
}
