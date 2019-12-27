<!-- Container fluid  -->
<?php $schooldata = $this->session->userdata['school']; ?>
<style>
    table.table-bordered.dataTable tbody td {
        line-height: 28px;
    }
</style>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Fee Payments</a></li>
        <li class="breadcrumb-item active">Payment Details</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Fee Payment Details<small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="<?=base_url('dashboard/salary/salarypaymentlist')?>" class="pull-right btn btn-success btn-xs"><i class="fa fa-list"></i> Salary Payment list</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Salary Payment details</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <?php $stdinfo = $employeedetails[0]; //print_r($stdinfo); ?>
                        <h4>EMPLOYEE DETAILS</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <label class="col-md-3">Reg id :</label>
                                    <span class="col-md-9"><?php echo $stdinfo->id_num; ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <label class="col-md-3">F Name :</label>
                                    <span class="col-md-9"><?php echo $stdinfo->firstname; ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <label class="col-md-3">L Name :</label>
                                    <span class="col-md-9"><?php echo $stdinfo->lastname; ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <label class="col-md-3">Position :</label>
                                    <span class="col-md-9"><?php echo $stdinfo->emoloyeeposition; ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <label class="col-md-3">Gender :</label>
                                    <span class="col-md-9"><?php 	if($stdinfo->gender == "M"){ echo "Male"; }else{ echo "Female"; } ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <label class="col-md-3">DOB :</label>
                                    <span class="col-md-9"><?php echo $stdinfo->dob; ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <label class="col-md-3">Mobile :</label>
                                    <span class="col-md-9"><?php echo $stdinfo->mobile; ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <label class="col-md-3">Phone :</label>
                                    <span class="col-md-9"><?php echo $stdinfo->phone; ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <label class="col-md-3">Mail :</label>
                                    <span class="col-md-9"><?php echo $stdinfo->mail_id; ?></span>
                                </div>
                            </div>
                        </div>
                        <h4>SALARY DETAILS</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="margin-bottom:0px" id="feelistdetails">
                                <thead class="text-uppercase">
                                <tr>
                                    <!--<th>
                                      <input type="checkbox" id="remember_me" class="filled-in">
                                      <label for="remember_me" style="padding: 5px;margin:-5px 0px -5px 0px;"></label>
                                    </th>-->
                                    <th>Sno</th>
                                    <th>Payslip Id</th>
                                    <th>TotalSalary <small>Per/m</small></th>
                                    <th>Paid Salary</th>
                                    <th>Balance Salary</th>
                                    <th>Last Paid</th>
                                    <th>Paid By</th>
                                    <th>Paid Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;
                                    $lastpaidamount =   '';$balanceamount = '';$paidamount = '';$totalsalaryamount='';
                                    $studentfee = $this->Model_dashboard->customquery("SELECT * FROM `sms_empsalarylist` WHERE id_num = '$stdinfo->id_num' AND branch_id = '$stdinfo->branch_id' AND school_id = '$stdinfo->school_id' AND status = '1' ORDER BY sno DESC ");
                                    foreach($studentfee as $stdfee){ ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $stdfee->salary_payslip_id?></td>
                                            <td align="center"><?php echo $stdfee->totalsalary_month.' /-'; ?></td>
                                            <td align="center"><?php echo $stdfee->paidsalary.' /-'; ?></td>
                                            <td align="center"><?php if($stdfee->balancesalary != 0){ echo $stdfee->balancesalary.' /-'; }else{ echo 'Total Paid'; } ?></td>
                                            <td align="center"><?php echo $stdfee->lastmonthpaid.' /-'; ?></td>
                                            <td class="text-capitalize"><?=$stdfee->payment_type?></td>
                                            <td><?php echo $stdfee->paiddate; ?></td>
                                        </tr>
                                    <?php
                                        @$lastpaidamount += $stdfee->lastmonthpaid;
                                        @$balanceamount += $stdfee->balancesalary;
                                        @$paidamount += $stdfee->paidsalary;
                                        @$totalsalaryamount += $stdfee->totalsalary_month;
                                        $i++;
                                    }
                                ?>
                                    <tr class="bg-black" style="background: black">
                                        <td colspan="2"></td>
                                        <td class="text-white" colspan="2"><?='Total Salary : <b>'.$totalsalaryamount.' /- </b>';?></td>
                                        <td class="text-white"><?='Total Balance : <b>'.$balanceamount.' /-</b>';?></td>
                                        <td class="text-white"><?='Total Last Paid : <b>'.$lastpaidamount.' /-</b>';?></td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <script>
                        $('#feelistdetails').DataTable({
                            'paging'      : false,
                            'lengthChange': false,
                            'searching'   : false,
                            'ordering'    : false,
                            'info'        : false,
                            'autoWidth'   : false,
                            'bSort' : false
                        });
                    </script>
                    <div class="row justify-content-center align-items-center mt-4">
                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->