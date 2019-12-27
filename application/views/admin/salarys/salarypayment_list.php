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
        <li class="breadcrumb-item"><a href="javascript:;">Salary Payments</a></li>
        <li class="breadcrumb-item active">Salary List</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Salary List<small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="<?=base_url('dashboard/salary/salarypayment')?>" class="pull-right btn btn-success btn-xs"><i class="fa fa-list"></i> Salary Payment</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Salary Payment List</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <?php if(count($employees) != 0){ ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="myTable">
                                    <thead>
                                    <tr>
                                        <!--<th>
                                          <input type="checkbox" id="remember_me" class="filled-in">
                                          <label for="remember_me" style="padding: 5px;margin:-5px 0px -5px 0px;"></label>
                                        </th>-->
                                        <th></th>
                                        <th>Reg id</th>
                                        <th>Name</th>
                                        <th>emp position</th>
                                        <th>T Salary <small>per/m</small></th>
                                        <th>T Paid</th>
                                        <th>Paid Salary</th>
                                        <th>Balance</th>
                                        <th>Paid Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach($employees as $fatch){

                                        $stdid = $fatch->id_num;
                                        $stdfee = $this->Model_dashboard->selectdata('sms_empsalarylist', array('id_num' => $stdid,'branch_id' => $fatch->branch_id,'school_id' => $fatch->school_id,'status' => 1),'sno');
                                        if(count($stdfee) != 0){ ?>
                                            <tr>
                                                <!--<td>
                                                    <input type="checkbox" id="remember_<?php //echo $i; ?>" name="multiid[]" value="<?php //echo $fatch['sno']; ?>" class="filled-in case checkbox">
                                                    <input type="hidden" value="<?php //echo $fatch['id_num']; ?>" name="stdids[]">
                                                    <label for="remember_<?php //echo $i; ?>" class="case checkbox" style="padding: 5px;margin:0px 5px -5px 0px;"></label>
                                                </td>-->
                                                <script>
                                                    $(document).ready(function(){
                                                        var firstName = '<?=$fatch->firstname?>';
                                                        var lastName = '<?=$fatch->lastname?>';
                                                        var intials = firstName.charAt(0) + lastName.charAt(0);
                                                        var profileImage = $('#profileImage<?=$fatch->sno?>').text(intials);
                                                    });
                                                </script>
                                                <td align="center">
                                                    <?php if(!empty($fatch->employee_pic)){ ?>
                                                        <img src="<?=base_url($fatch->employee_pic)?>" class="profileImage">
                                                    <?php }else{ ?>
                                                        <div id="profileImage<?=$fatch->sno;?>" class="profileImage text-uppercase"></div>
                                                    <?php } ?>
                                                </td>
                                                <td><a href="<?=base_url('dashboard/salary/salarypaymentdetails/'.$fatch->school_id.'/'.$fatch->branch_id.'/'.$fatch->id_num.'?id='.$fatch->sno)?>"><?php echo $fatch->id_num; ?></a></td>
                                                <td><?php echo substr($fatch->lastname,0,1).' . '.$fatch->firstname; ?></td>
                                                <td class="text-capitalize"><?php echo $fatch->emoloyeeposition; ?></td>
                                                <td align="center"><?php echo $fatch->salary." /-"; ?></td>
                                                <?php
                                                $stfee = $this->Model_dashboard->customquery("SELECT * FROM `sms_empsalarylist` WHERE id_num = '$stdid' AND branch_id = '$fatch->branch_id' AND school_id = '$fatch->school_id' AND status = '1' ORDER BY sno DESC");
                                                $stfee = $stfee[0];
                                                ?>
                                                <td align="center"><?=$stfee->paidsalary.' /-'?></td>
                                                <td align="center"><?=$stfee->lastmonthpaid.' /-'?></td>
                                                <td align="center"><?php if(@$stfee->balancesalary == 0){ echo "<small class='text-green'> Paid ".date('F',strtotime($stfee->paiddate))." </small>"; }else{ echo @$stfee->balancesalary.' /-'; }?></td>
                                                <td><?=date('d-m-Y',strtotime($stfee->paiddate))?></td>
                                            </tr>
                                            <?php $i++;
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <!--<input type="submit" class="btn btn-danger btn-xs pull-left" value="DELETE ALL" onClick="return confirm('Are you want to delete..?');" name="deleteall">-->
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
<script>
    $(document).ready(function () {
        $('#savemakepayment').on('submit',function (e) {
            e.preventDefault();
            var tselected = $('input[type="radio"]:checked').length;
            if(tselected <= 0) {
                alert('Please select payment type..!');
            }else{
                $('#loader').show();
                var stdtotalfee =   $('#stdtotalfee').val();
                var formdata = $('#savemakepayment').serialize();
                $.ajax({
                    url:"<?=base_url('dashboard/feepayments/savemakepayments')?>",
                    data:formdata,
                    type:"POST",
                    dataType: 'json',
                    success:function(success){
                        $("#loader").hide();
                        console.log(success);
                        if(success.status == 1){
                            if(success.testmessage.payment_type == 'offline') {
                                alert(success.message);
                            }else if(success.testmessage.payment_type == 'online'){
                                //alert('0000000');
                                $('#loader').show();
                                var count = 5;

                                setInterval(function(){
                                    count--;
                                    //document.getElementById('countDown').innerHTML = count;
                                    if(count == 0) {
                                        //window.location = "<?//=base_url()?>dashboard/feepayments/feepayment?id_num="+ success.testmessage.id_num +"&school_id=";
                                        alert('Ok Here redirect url');
                                    }
                                },1000);
                            }
                        }else if(success.status == 0){
                            alert(success.message);
                        }
                    }
                })
            }
        })
    })
</script>