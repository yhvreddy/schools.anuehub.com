<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_feepayments extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }
    
    //enote for superadmin or admin only to save guide for like prof
    public function index($externaldata = NULL){
        $this->feepayment();
    }
    
    //Add Attendence for admin and superadmin
    public function feepayment(){
        $data['schooldata'] = $schooldata = $this->session->userdata['school'];
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "Collect Fee Payment's..!";
        //getting school data in session
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
        $this->loadViews('admin/feepayments/feepayment_collect',$data);
    }

    public function admissionDetailsList(){
        extract($_REQUEST);
        //$this->print_r($_REQUEST);
        $schooldata = $this->session->userdata['school'];

        if(isset($admissionid) && $admissionid != ''){

            $academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
            $batch = $academicyear[0]->academic_year;

            $students = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'batch'=>$batch,'id_num'=>$admissionid));

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
                <div id="StudentNewAttendence">
                    <div class="clearfix">
                        <h4 class="pull-left pt-2 text-info"><?= 'Student Details'?></h4>
                    </div>
                    <table id="attendancelist" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Sno</th>
                            <th></th>
                            <th>Std Id</th>
                            <th>Name</th>
                            <th>eMail</th>
                            <th>Mobile</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Payment</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                foreach($students as $student){
                                    $fee = $this->Model_default->selectorderby('sms_feelist',array('branch_id'=>$schooldata->branch_id,'school_id'=>$schooldata->school_id,'status'=>1,'id_num'=>$student->id_num),'sno DESC');
                                    if((@$fee[0]->totalfee != @$fee[0]->paidfee) || count($fee) == 0){
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
                                        <td><?=$student->id_num; ?></td>
                                        <td><?=substr($student->lastname,0,1).'.'.$student->firstname; ?></td>
                                        <td><?=$student->mail_id; ?></td>
                                        <td><?=$student->mobile; ?></td>
                                        <td class="text-center"><?=$student->totalfee;?></td>
                                        <td><?=@$fee[0]->paidfee?></td>
                                        <td><?=@$fee[0]->balancefee?></td>
                                        <td>
                                            <a href="<?=base_url('dashboard/feepayments/makefeepayment?std='.$student->id_num.'&schoolid='.$student->school_id.'&branchid='.$student->branch_id)?>" class="btn btn-xs btn-success">Make Payment</a>
                                        </td>
                                    </tr>
                            <?php $i++; } } ?>
                        </tbody>
                    </table>
                    <!--<div class="clearfix row justify-content-center align-items-center">
                        <input type="button" value="Save Attendence" name="studentattendence" class="btn btn-success pull-right" id="studentattendence">
                    </div>-->
                </div>
                <script>
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

        if((isset($stdclass) && $stdclass != '') && (isset($stdsyllubas) && $stdsyllubas != '')){
            $academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
            $batch = $academicyear[0]->academic_year;

            $students = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'batch'=>$batch,'class'=>$stdclass,'class_type'=>$stdsyllubas));

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
                <div id="StudentNewAttendence">
                    <div class="clearfix">
                        <h4 class="pull-left pt-2 text-info"><?= 'Student Details'?></h4>
                    </div>
                    <table id="attendancelist" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Sno</th>
                            <th></th>
                            <th>Std Id</th>
                            <th>Name</th>
                            <th>eMail</th>
                            <th>Mobile</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Payment</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        foreach($students as $student){
                            $fee = $this->Model_default->selectorderby('sms_feelist',array('branch_id'=>$student->branch_id,'school_id'=>$student->school_id,'status'=>1,'id_num'=>$student->id_num),'sno DESC');
                            //$this->print_r($fee);
                            if((@$fee[0]->totalfee != @$fee[0]->paidfee) || (count($fee) == 0)){
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
                                <td><?=$student->id_num; ?></td>
                                <td><?=substr($student->lastname,0,1).' . '.$student->firstname; ?></td>
                                <td><?=$student->mail_id; ?></td>
                                <td><?=$student->mobile; ?></td>
                                <td class="text-center"><?=$student->totalfee	?></td>
                                <td><?=@$fee[0]->paidfee?></td>
                                <td><?=@$fee[0]->balancefee?></td>
                                <td>
                                    <a href="<?=base_url('dashboard/feepayments/makefeepayment?std='.$student->id_num.'&schoolid='.$student->school_id.'&branchid='.$student->branch_id)?>" class="btn btn-xs btn-success">Make Payment</a>
                                </td>
                            </tr>
                            <?php   $i++; } } ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    $('#attendancelist').DataTable({
                        'paging'      : true,
                        'lengthChange': true,
                        'searching'   : true,
                        'ordering'    : false,
                        'info'        : true,
                        'autoWidth'   : true,
                        'bSort' : false
                    });
                </script>
            <?php }
        }
    }

    public function makeFeepayment(){
        extract($_REQUEST);
        //$students = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'batch'=>$batch,'class'=>$stdclass,'class_type'=>$stdsyllubas));
        if((isset($std) && $std != '') && (isset($schoolid) && $schoolid != '') && (isset($branchid) && $branchid != '')){
            $data['schooldata'] = $schooldata = $this->session->userdata['school'];
            $data['userdata'] = $this->Model_integrate->userdata();
            $data['PageTitle'] = "Collect Fee Payment's..!";
            $data['studentdata'] = $this->Model_dashboard->customquery("SELECT * FROM `sms_admissions` WHERE id_num = '$std' AND school_id = '$schooldata->school_id' AND branch_id = '$schooldata->branch_id'");
            $data['syllabus']   = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
            $data['feedata'] = $this->Model_dashboard->customquery("SELECT * FROM `sms_feelist` WHERE id_num = '$std' AND school_id = '$schooldata->school_id' AND branch_id = '$schooldata->branch_id' AND status = 1 ORDER BY sno DESC LIMIT 1");
            //getting school data in session
            $this->loadViews('admin/feepayments/feepayment',$data);
        }else{
            $this->feepayment();
        }
    }

    public function savemakePayments(){
        extract($_REQUEST);
        //echo json_encode($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        if((isset($schoolid) && $schoolid != '') && (isset($branchid) && $branchid != '') && (isset($id_num) && $id_num != '')){

            $feeid = $this->Model_dashboard->selectdata('sms_feelist',array('school_id' =>$schoolid,'branch_id' =>$branchid,'status'=>1),'sno');
            $fid = $this->Model_dashboard->selectdata('sms_feelist',array('school_id' =>$schoolid,'branch_id' =>$branchid),'sno');
            $feeidcount = count($fid);
            $scl = $this->session->userdata['school']->schoolname; //regesrer main branch school name
            $sclid  = $this->Model_integrate->initials($scl); // getting mainbarnch school name starting letters
            $feeidcount = $feeidcount+1;
            $feeslipid = $sclid."Y".date('y')."0".$feeidcount; //feeslip id generated



            $feedata = $this->Model_dashboard->customquery("SELECT * FROM `sms_feelist` WHERE branch_id ='$branchid' AND school_id = '$schoolid' AND id_num = '$id_num' AND status = 1 ORDER BY sno DESC LIMIT 1");

            $students = $this->Model_dashboard->customquery("SELECT * FROM `sms_admissions` WHERE id_num = '$id_num' AND school_id = '$schooldata->school_id' AND branch_id = '$schooldata->branch_id'");
            $student = $students[0];
            $stdclass     =   $student->class;
            $classtype    =   $student->class_type;
            $totalfee     = $student->totalfee;
            $feeamount    = unserialize($student->feeamount);
            if(count($feedata) == 0){
                //fee logic
                  //$this->print_r($student);
                $payingdate   = date('Y-m-d',strtotime($paydate));
                if($totalfee >= $payamount){
                    $payingfee = $payamount;
                    $balance = $totalfee - $payingfee;
                    $insertdata = array(
                        'school_id' => $schoolid,
                        'branch_id' => $branchid,
                        'id_num' => $id_num,
                        'class' => $stdclass,
                        'class_type' => $classtype,
                        'feelistid' => $feeslipid,
                        'totalfee' => $totalfee,
                        'paidfee' => $payingfee,
                        'balancefee' => $balance,
                        'lastpaidfee' => $payingfee,
                        'payingfee' => $payingfee,
                        'paiddate' => $payingdate,
                        'payment_type' => $payment_type
                    );
                    if($payment_type == 'offline') {
                        $insert = $this->Model_dashboard->insertdata('sms_feelist', $insertdata);
                        if ($insert != 0) {
                            $json = array("status" => 1, "message" => "Successfully paid.", "testmessage" => $insertdata);
                        } else {
                            $json = array("status" => 0, "message" => "Not Successfully Paid.", 'testmessage' => $insertdata);
                        }
                    }else if($payment_type == 'online'){
                        $insertdata['studentname']  =   $student->firstname.'-'.$student->lastname;
                        $insertdata['mobile']       =   $student->mobile;
                        $insertdata['mail_id']      =   $student->mail_id;
                        $insertdata['address']      =   $student->sno;
                        $this->session->set_userdata('feedata',$insertdata);
                        $json = array("status" => 1, "message" => "Online payments coming soon.", 'testmessage' => $insertdata);
                    }
                }else{
                    $json = array("status"=>0,"message" => "please check you have entered high amount above the total fee..!");
                }
            }else{
                $payingdate   = date('Y-m-d',strtotime($paydate));
                if($balanceamount >= $payamount){
                    $payingfee = $payamount;

                    //$totalpaid = $lastpayamount + $payingfee;
                    //$total = $stdtotalpayedfee + $payingfee;
                    //$balance = $totalfee - $totalpaid;

                    $totalpaid = $lastpayamount + $payingfee;
                    $total = $stdtotalpayedfee + $payingfee;
                    $balance = $totalfee - $total;

                    $insertdata = array(
                        'school_id' => $schoolid,
                        'branch_id' => $branchid,
                        'id_num'    => $id_num,
                        'class'     => $stdclass,
                        'class_type'=> $classtype,
                        'feelistid' => $feeslipid,
                        'totalfee'  => $totalfee,
                        'paidfee'   => $total,
                        'balancefee'=> $balance,
                        'lastpaidfee'=> $payingfee,
                        'payingfee' => $payingfee,
                        'paiddate' => $payingdate,
                        'payment_type' => $payment_type
                    );
                    $json = array("status"=>0,"message" => "Repayment session will coming soon..",'testmessage'=>$_REQUEST,'inserting'=>$insertdata);

                    if($payment_type == 'offline') {
                        $insert = $this->Model_dashboard->insertdata('sms_feelist', $insertdata);
                        if ($insert != 0) {
                            $json = array("status" => 1, "message" => "Successfully paid.", "testmessage" => $insertdata);
                        } else {
                            $json = array("status" => 0, "message" => "Not Successfully Paid.", 'testmessage' => $insertdata);
                        }
                    }else if($payment_type == 'online'){
                        $insertdata['studentname']  =   $student->firstname.'-'.$student->lastname;
                        $insertdata['mobile']       =   $student->mobile;
                        $insertdata['mail_id']      =   $student->mail_id;
                        $insertdata['address']      =   $student->sno;
                        $this->session->set_userdata('feedata',$insertdata);
                        $json = array("status" => 1, "message" => "Online payments coming soon.", 'testmessage' => $insertdata);
                    }
                }else{
                    $json = array("status"=>0,"message" => "please check you have entered high amount above the total fee..!");
                }
            }
        }else{
            $json = array("status"=>0,"message" => "Invalid Request..! Please check it once..");
        }
        //header('content-type: application/json');
        echo json_encode($json);
    }

    public function feePaymentList(){
        $data['schooldata'] = $schooldata = $this->session->userdata['school'];
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "Fee Payment's List..!";
        //getting school data in session
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
        $data['adminssions'] = $this->Model_dashboard->selectdata('sms_admissions',array('branch_id'=>$schooldata->branch_id,'school_id'=>$schooldata->school_id,'status'=>1),'updated,sno');
        $this->loadViews('admin/feepayments/feepayment_list',$data);
    }

    public function feepaymentDetails(){
        extract($_REQUEST);
        $schoolid   = $this->uri->segment(4);
        $branchid   = $this->uri->segment(5);
        $id_num     = $this->uri->segment(6);
        $data['schooldata'] = $schooldata = $this->session->userdata['school'];
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "Fee Payment's Details..!";
        //getting school data in session
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
        if((isset($id) && $id != '') && ($schoolid != '' && isset($schoolid)) && ($branchid != '' && isset($branchid))){
            $data['adminssiondetails'] = $this->Model_dashboard->selectdata('sms_admissions',array('branch_id'=>$schooldata->branch_id,'school_id'=>$schooldata->school_id,'status'=>1,'sno'=>$id,'id_num'=>$id_num),'updated,sno');
            $data['feedetails'] = $this->Model_dashboard->selectdata('sms_feelist',array('branch_id'=>$schooldata->branch_id,'school_id'=>$schooldata->school_id,'status'=>1,'id_num'=>$id_num),'updated,sno');
            $this->loadViews('admin/feepayments/feepayment_detailslist',$data);
        }else{
            $data['adminssions'] = $this->Model_dashboard->selectdata('sms_admissions',array('branch_id'=>$schooldata->branch_id,'school_id'=>$schooldata->school_id,'status'=>1),'updated,sno');
            $this->loadViews('admin/feepayments/feepayment_list',$data);
        }

    }
}
