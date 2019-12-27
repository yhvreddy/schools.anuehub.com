<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_salarypayments extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }
    
    //enote for superadmin or admin only to save guide for like prof
    public function index($externaldata = NULL){
        $this->salarypayments();
    }
    
    //Add Attendence for admin and superadmin   salarys
    public function salarypayments(){
        $data['schooldata'] = $schooldata = $this->session->userdata['school'];
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "Salary Payment's..!";
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
        $data['employee']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'employee','status'=>1));
        $data['staff']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'staff','status'=>1));
        $data['worker']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'worker','status'=>1));
        $data['office']   = $this->Model_dashboard->selectdata('sms_formdata',array('type'=>'office','status'=>1));
        $this->loadViews('admin/salarys/salarypayment_collect',$data);
    }

    public function employeeDetailsList(){
        extract($_REQUEST);
        //$this->print_r($_REQUEST);
        $schooldata = $this->session->userdata['school'];
         //exit;
        if(isset($admissionid) && $admissionid != '') {

            $students = $this->Model_dashboard->selectdata('sms_employee', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'status' => 1, 'id_num' => $admissionid));

        }else {

            if ($emptype == 'worker') {
                $emp = $emppoti;
            } else if ($emptype == 'staff') {
                $emp = $emppti;
            } else if ($emptype == 'office') {
                $emp = $empoffice;
            }

            $students = $this->Model_dashboard->selectdata('sms_employee', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'status' => 1, 'employeetype' => $emptype, 'emoloyeeposition' => $emp));
        }
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
                        <th>T Salary</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Paid Date</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                            foreach($students as $student){
                                $emp = $student->id_num;
                                $salary = $this->Model_dashboard->customquery("SELECT * FROM `sms_empsalarylist` WHERE id_num = '$emp' AND school_id = '$schooldata->school_id' AND branch_id = '$schooldata->branch_id' AND status = 1 ORDER BY sno DESC LIMIT 1");
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
                                        <?php if(!empty($student->employee_pic)){ ?>
                                            <img src="<?=base_url($student->employee_pic)?>" class="profileImage">
                                        <?php }else{ ?>
                                            <div id="profileImage<?=$student->sno;?>" class="profileImage text-uppercase"></div>
                                        <?php } ?>
                                    </td>
                                    <td><?=$student->id_num; ?></td>
                                    <td><?=substr($student->lastname,0,1).'.'.$student->firstname; ?></td>
                                    <td><?=$student->mail_id; ?></td>
                                    <td><?=$student->mobile; ?></td>
                                    <td class="text-center"><?=$student->salary.' / M';?></td>
                                    <?php if(count($salary) != 0){ ?>
                                        <td><?=@$salary[0]->paidsalary?></td>
                                        <td><?php if(@$salary[0]->balancesalary == 0){ echo "<small class='text-green'> Paid ".date('M',strtotime($salary[0]->paiddate))." </small>"; }else{ echo @$salary[0]->balancesalary; }?></td>
                                    <?php }else{ ?>
                                        <td><?=@$salary[0]->paidsalary?></td>
                                        <td><?=@$salary[0]->balancesalary;?></td>
                                    <?php } ?>
                                    <td>
                                        <a href="<?=base_url('dashboard/salary/makesalarypayment?emp='.$student->id_num.'&schoolid='.$student->school_id.'&branchid='.$student->branch_id)?>" class="btn btn-xs btn-success">Pay salary</a>
                                    </td>
                                </tr>
                        <?php  $i++;  } ?>
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

    public function makesalarypayment(){
        extract($_REQUEST);
        //$students = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'batch'=>$batch,'class'=>$stdclass,'class_type'=>$stdsyllubas));
        if((isset($emp) && $emp != '') && (isset($schoolid) && $schoolid != '') && (isset($branchid) && $branchid != '')){
            $data['schooldata'] = $schooldata = $this->session->userdata['school'];
            $data['userdata'] = $this->Model_integrate->userdata();
            $data['PageTitle'] = "Collect Fee Payment's..!";
            $data['studentdata'] = $this->Model_dashboard->customquery("SELECT * FROM `sms_employee` WHERE id_num = '$emp' AND school_id = '$schooldata->school_id' AND branch_id = '$schooldata->branch_id'");
            $data['syllabus']   = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
            $data['salarydata'] = $this->Model_dashboard->customquery("SELECT * FROM `sms_empsalarylist` WHERE id_num = '$emp' AND school_id = '$schooldata->school_id' AND branch_id = '$schooldata->branch_id' AND status = 1 ORDER BY sno DESC LIMIT 1");
            //getting school data in session
            $this->loadViews('admin/salarys/salarypayment',$data);
        }else{
            $this->feepayment();
        }
    }

    public function savemakePayments(){
        extract($_REQUEST);
        //echo json_encode($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        if((isset($schoolid) && $schoolid != '') && (isset($branchid) && $branchid != '') && (isset($id_num) && $id_num != '')){

            $feeid = $this->Model_dashboard->selectdata('sms_empsalarylist',array('school_id' =>$schoolid,'branch_id' =>$branchid,'status'=>1),'sno');
            $fid = $this->Model_dashboard->selectdata('sms_empsalarylist',array('school_id' =>$schoolid,'branch_id' =>$branchid),'sno');
            $feeidcount = count($fid);
            $scl = $this->session->userdata['school']->schoolname; //regesrer main branch school name
            $sclid  = $this->Model_integrate->initials($scl); // getting mainbarnch school name starting letters
            $feeidcount = $feeidcount+1;
            $feeslipid = $sclid."ESY".date('y')."D".date('d')."I0".$feeidcount; //feeslip id generated
            $feedata = $this->Model_dashboard->customquery("SELECT * FROM `sms_empsalarylist` WHERE branch_id ='$branchid' AND school_id = '$schoolid' AND id_num = '$id_num' AND status = 1 ORDER BY sno DESC LIMIT 1");

            $students = $this->Model_dashboard->customquery("SELECT * FROM `sms_employee` WHERE id_num = '$id_num' AND school_id = '$schooldata->school_id' AND branch_id = '$schooldata->branch_id'");
            $employee = $students[0];
            $empposition     =   $employee->emoloyeeposition;
            $empid           =   $employee->sno;
            $totalsalary     =   $employee->salary;
            if(count($feedata) == 0){
                
                $payingdate   = date('Y-m-d',strtotime($paydate));
                //if($totalsalary >= $payamount){
                $payingamount = $payamount;
                $balance = $totalsalary - $payingamount;
                $insertdata = array(
                    'school_id'         => $schoolid,
                    'branch_id'         => $branchid,
                    'id_num'            => $id_num,
                    'employee_type'     => $empposition,
                    'employee_id'       => $empid,
                    'salary_payslip_id' => $feeslipid,
                    'totalsalary_month' => $totalsalary,
                    'paidsalary'        => $payingamount,
                    'balancesalary'     => $balance,
                    'lastmonthpaid'     => $payingamount,
                    'payingsalary'      => $payingamount,
                    'paiddate'          => $payingdate,
                    'payment_type'      => $payment_type,
                    'updated'           => date('Y-m-d H:i:s')
                );
                if($payment_type == 'offline') {
                    $insert = $this->Model_dashboard->insertdata('sms_empsalarylist', $insertdata);
                    if ($insert != 0) {
                        $json = array("status" => 1, "message" => "Successfully paid salary.", "testmessage" => $insertdata);
                    } else {
                        $json = array("status" => 0, "message" => "Not Successfully Paid salary.", 'testmessage' => $insertdata);
                    }
                }else if($payment_type == 'online'){
                    $insertdata['studentname']  =   $employee->firstname.'-'.$employee->lastname;
                    $insertdata['mobile']       =   $employee->mobile;
                    $insertdata['mail_id']      =   $employee->mail_id;
                    $insertdata['address']      =   $employee->sno;
                    $this->session->set_userdata('feedata',$insertdata);
                    $json = array("status" => 1, "message" => "Online payments coming soon.", 'testmessage' => $insertdata);
                }
//                }else{
//                    $json = array("status"=>0,"message" => "please check you have entered high amount above the total fee..!");
//                }
            }else{
                $payingdate   = date('Y-m-d',strtotime($paydate));
                //if($balanceamount >= $payamount){

                $totalsalamount = $totalsalary + $balanceamount;

                $payingsal = $payamount;
                $balance   = $totalsalamount - $payamount;
                $totalpaid = $lastpayamount + $payamount;

                $insertdata = array(
                    'school_id'         => $schoolid,
                    'branch_id'         => $branchid,
                    'id_num'            => $id_num,
                    'employee_type'     => $empposition,
                    'employee_id'       => $empid,
                    'salary_payslip_id' => $feeslipid,
                    'totalsalary_month' => $totalsalary,
                    'paidsalary'        => $totalpaid,
                    'balancesalary'     => $balance,
                    'lastmonthpaid'     => $payamount,
                    'payingsalary'      => $payamount,
                    'paiddate'          => $payingdate,
                    'payment_type'      => $payment_type,
                    'updated'           => date('Y-m-d H:i:s')
                );
                $json = array("status"=>0,"message" => "Repayment session will coming soon..",'testmessage'=>$_REQUEST,'inserting'=>$insertdata);

                if($payment_type == 'offline') {
                    $insert = $this->Model_dashboard->insertdata('sms_empsalarylist', $insertdata);
                    if ($insert != 0) {
                        $json = array("status" => 1, "message" => "Successfully paid.", "testmessage" => $insertdata);
                    } else {
                        $json = array("status" => 0, "message" => "Not Successfully Paid.", 'testmessage' => $insertdata);
                    }
                }else if($payment_type == 'online'){
                    /*$insertdata['studentname']  =   $student->firstname.'-'.$student->lastname;
                    $insertdata['mobile']       =   $student->mobile;
                    $insertdata['mail_id']      =   $student->mail_id;
                    $insertdata['address']      =   $student->sno;
                    $this->session->set_userdata('feedata',$insertdata);*/
                    $json = array("status" => 0, "message" => "Online payments coming soon.", 'testmessage' => $insertdata);
                }

                /*}else{
                    $json = array("status"=>0,"message" => "please check you have entered high amount above the total fee..!");
                }*/
            }
        }else{
            $json = array("status"=>0,"message" => "Invalid Request..! Please check it once..");
        }
        //header('content-type: application/json');
        echo json_encode($json);
    }

    public function salarypaymentlist(){
        $data['schooldata'] = $schooldata = $this->session->userdata['school'];
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "Fee Payment's List..!";
        //getting school data in session
        $data['syllabus']   = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
        $data['employees'] = $this->Model_dashboard->selectdata('sms_employee',array('branch_id'=>$schooldata->branch_id,'school_id'=>$schooldata->school_id,'status'=>1),'updated,sno');
        $this->loadViews('admin/salarys/salarypayment_list',$data);
    }

    public function salarypaymentDetails(){
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
            $data['employeedetails'] = $this->Model_dashboard->selectdata('sms_employee',array('branch_id'=>$schooldata->branch_id,'school_id'=>$schooldata->school_id,'status'=>1,'sno'=>$id,'id_num'=>$id_num),'updated,sno');
            $data['salarydetails'] = $this->Model_dashboard->selectdata('sms_empsalarylist',array('branch_id'=>$schooldata->branch_id,'school_id'=>$schooldata->school_id,'status'=>1,'id_num'=>$id_num),'updated,sno');
            $this->loadViews('admin/salarys/salarypayment_detailslist',$data);
        }else{
            $this->salarypaymentlist();
        }

    }
}
