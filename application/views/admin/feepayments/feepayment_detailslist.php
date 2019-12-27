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
                        <a href="<?=base_url('dashboard/feepayments/feepaymentlist')?>" class="pull-right btn btn-success btn-xs"><i class="fa fa-list"></i> Fee Payment list</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Fee Payment details</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <?php $stdinfo = $adminssiondetails[0]; ?>
                        <h4>STUDENT DETAILS</h4>
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
                                    <label class="col-md-3">Class :</label>
                                    <span class="col-md-9"><?php echo $stdinfo->class; ?></span>
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
                                    <span class="col-md-9"><?php echo $stdinfo->altermobile; ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <label class="col-md-3">Mail :</label>
                                    <span class="col-md-9"><?php echo $stdinfo->mail_id; ?></span>
                                </div>
                            </div>
                        </div>
                        <h4>FEE DETAILS</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row">
                                    <label class="col-md-5">Service :</label>
                                    <span class="col-md-7 text-capitalize"><?php echo $stdinfo->service; ?></span>
                                </div>
                            </div>
                            <?php $fee = unserialize($stdinfo->feeamount);
                                foreach ($fee as $key => $feelist){ ?>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <label class="col-md-5"><?php if($key == 'service'){ echo 'Hostel / Bus'; }else{ echo $key; } ?> :</label>
                                            <span class="col-md-7"><?php echo $feelist.'/-'; ?></span>
                                        </div>
                                    </div>
                            <?php } ?>
                            <div class="col-md-3">
                                <div class="row">
                                    <label class="col-md-5">Totalfee :</label>
                                    <span class="col-md-7"><?php echo $stdinfo->totalfee.'/-'; ?></span>
                                </div>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="margin-bottom:0px" id="feelistdetails">
                                <thead class="text-uppercase">
                                <tr>
                                    <!--<th>
                                      <input type="checkbox" id="remember_me" class="filled-in">
                                      <label for="remember_me" style="padding: 5px;margin:-5px 0px -5px 0px;"></label>
                                    </th>-->
                                    <th>Sno</th>
                                    <th>feeslip Id</th>
                                    <th>Totalfee</th>
                                    <th>Paid Date</th>
                                    <th>Paid Fee</th>
                                    <th>Balance</th>
                                    <th>Last Paid</th>
                                    <th>Paid By</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;
                                    $studentfee = $this->Model_dashboard->customquery("SELECT * FROM `sms_feelist` WHERE id_num = '$stdinfo->id_num' AND branch_id = '$stdinfo->branch_id' AND school_id = '$stdinfo->school_id' AND status = '1' ORDER BY sno DESC ");
                                    foreach($studentfee as $stdfee){ ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $stdfee->feelistid?></td>
                                        <td><?php echo $stdfee->totalfee; ?></td>
                                        <td><?php echo $stdfee->paiddate; ?></td>
                                        <td><?php echo $stdfee->paidfee; ?></td>
                                        <td><?php if($stdfee->balancefee != 0){ echo $stdfee->balancefee; }else{ echo 'Total Paid'; } ?></td>
                                        <td><?php echo $stdfee->lastpaidfee; ?></td>
                                        <td class="text-capitalize"><?=$stdfee->payment_type?></td>
                                    </tr>
                                    <?php $i++;
                                }
                                ?>
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