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
        <li class="breadcrumb-item active">Fee Payment List</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Fee Payment List<small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="<?=base_url('dashboard/feepayments/feepayment')?>" class="pull-right btn btn-success btn-xs"><i class="fa fa-list"></i> New Fee Payment</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Fee Payment List</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <?php if(count($adminssions) != 0){ ?>
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
                                        <th>Class</th>
                                        <th>Total</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Lastpaid</th>
                                        <th>Paid Date</th>
                                        <th>Paid By</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach($adminssions as $fatch){

                                        $stdid = $fatch->id_num;
                                        $stdfee = $this->Model_dashboard->selectdata('sms_feelist', array('id_num' => $stdid,'branch_id' => $fatch->branch_id,'school_id' => $fatch->school_id,'status' => 1),'sno');
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
                                                    <?php if(!empty($fatch->student_image)){ ?>
                                                        <img src="<?=base_url($fatch->student_image)?>" class="profileImage">
                                                    <?php }else{ ?>
                                                        <div id="profileImage<?=$fatch->sno;?>" class="profileImage text-uppercase"></div>
                                                    <?php } ?>
                                                </td>
                                                <td><a href="<?=base_url('dashboard/feepayments/feepaymentdetails/'.$fatch->school_id.'/'.$fatch->branch_id.'/'.$fatch->id_num.'?id='.$fatch->sno)?>"><?php echo $fatch->id_num; ?></a></td>
                                                <td><?php echo substr($fatch->lastname,0,1).' . '.$fatch->firstname; ?></td>
                                                <td><?php echo $fatch->class; ?></td>
                                                <td class=""><?php echo $fatch->totalfee.' /-'; ?></td>
                                                <td class="">
                                                    <?php
                                                    $sumfee = $this->Model_dashboard->customquery("SELECT SUM(lastpaidfee) as paidfee FROM `sms_feelist` WHERE id_num = '$stdid' AND branch_id = '$fatch->branch_id' AND school_id = '$fatch->school_id' ORDER BY sno DESC");
                                                    $sumfee = $sumfee[0];
                                                    echo $totalpaidfee = $sumfee->paidfee.' /-';
                                                    ?>
                                                </td>
                                                <td class=""><?php  $balance = $fatch->totalfee - $sumfee->paidfee; if($balance == 0){ echo 'Total Paid'; }else{ echo $balance.' /-';} ?></td>
                                                <td class="">
                                                    <?php
                                                    $stfee = $this->Model_dashboard->customquery("SELECT * FROM `sms_feelist` WHERE id_num = '$stdid' AND branch_id = '$fatch->branch_id' AND school_id = '$fatch->school_id' AND status = '1' ORDER BY sno DESC");
                                                    $stfee = $stfee[0];
                                                    echo $stfee->lastpaidfee.' /-';
                                                    ?>
                                                </td>
                                                <td><?php echo $stfee->paiddate; ?></td>
                                                <td class="text-capitalize"><?=$stfee->payment_type?></td>
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