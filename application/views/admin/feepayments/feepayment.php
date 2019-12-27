<!-- Container fluid  -->
<?php $schooldata = $this->session->userdata['school']; ?>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Fee Payments</a></li>
        <li class="breadcrumb-item active">Collect Payment</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Collect Fee Payment's<small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="<?=base_url('dashboard/feepayments/feepaymentlist')?>" class="pull-right btn btn-success btn-xs"><i class="fa fa-list"></i> Fee List</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Collect Fee Payment's</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <?php
                            $student = $studentdata[0];
                            if(count($studentdata) != '' || $student != 0){
                        ?>
                            <form class="row" method="post" action="<?=base_url('dashboard/feepayments/savemakepayments')?>" id="savemakepayment">
                                <input type="hidden" value="<?=$student->school_id?>" name="schoolid">
                                <input type="hidden" value="<?=$student->branch_id?>" name="branchid">
                                <input type="hidden" value="<?=$student->id_num?>" name="id_num">
                                <div class="col-md-3 form-group">
                                    <label>Student Name</label>
                                    <input type="text" placeholder="Student name" name="stdname" id="stdname" class="form-control" value="<?=substr($student->lastname,0,1).' . '.$student->firstname?>" readonly>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Student Father/Mother Name</label>
                                    <input type="text" placeholder="Student Father/Mother name" name="stdfathername" value="<?=$student->fathername?>" id="stdfathername" class="form-control" readonly>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Student Mobile</label>
                                    <input type="text" placeholder="Student Mobile number" name="stdmobile" class="form-control" value="<?=$student->mobile?>" readonly id="stdmobile">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Student Mailid</label>
                                    <input type="text" placeholder="Student mail id" name="stdmailid" class="form-control" readonly value="<?=$student->mail_id?>" id="stdmailid">
                                </div>
                                <div class="row justify-content-center align-items-center text-center">
                                    <div class="col-md-2 form-group">
                                        <label>Total Fee</label>
                                        <input type="text" placeholder="Total Fee" name="stdtotalfee" class="form-control text-center" value="<?=$student->totalfee?>" readonly id="stdtotalfee">
                                    </div>
                                    <?php if(count($feedata) != 0){ $feedata = $feedata[0]; ?>
                                        <div class="col-md-2 form-group">
                                            <label>Total PayedFee</label>
                                            <input type="text" placeholder="Total PayedFee" name="stdtotalpayedfee" class="form-control text-center" value="<?=$feedata->paidfee?>" readonly id="stdtotalpayedfee">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Last payee amount</label>
                                            <input type="text" placeholder="Last payee amount" name="lastpayamount" class="form-control text-center" value="<?=$feedata->lastpaidfee?>" readonly id="lastpayamount">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Lastpay date</label>
                                            <input type="text" placeholder="Last pay date" name="lastpaydate" class="form-control text-center" value="<?=date('d/m/Y',strtotime($feedata->paiddate))?>" readonly id="lastpaydate">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Balance fee amount</label>
                                            <input type="text" placeholder="Balance fee amount" name="balanceamount" value="<?=$feedata->balancefee?>" class="form-control text-center" readonly id="balanceamount">
                                        </div>
                                    <?php }else{ ?>
                                        <div class="col-md-2 form-group">
                                            <label>Total PayedFee</label>
                                            <input type="text" placeholder="Total PayedFee" name="stdtotalpayedfee" class="form-control text-center" readonly id="stdtotalpayedfee">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Last payee amount</label>
                                            <input type="text" placeholder="Last payee amount" name="lastpayamount" class="form-control text-center" readonly id="lastpayamount">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Lastpay date</label>
                                            <input type="text" placeholder="Last pay date" name="lastpaydate" class="form-control text-center"  readonly id="lastpaydate">
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <label>Balance fee amount</label>
                                            <input type="text" placeholder="Balance fee amount" name="balanceamount" class="form-control text-center" readonly id="balanceamount">
                                        </div>
                                    <?php } ?>
                                    <div class="col-md-3 form-group">
                                        <label>pay date</label>
                                        <input type="text" placeholder="Select Pay Date" name="paydate"  class="form-control paydate mydatepicker text-center" id="datepicker" value="<?=date('m/d/Y')?>" required>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Enter pay amount</label>
                                        <input type="text" placeholder="Enter pay amount" id="payamount" name="payamount" class="form-control text-center" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row justify-content-center align-items-center">
                                        <h5 class="col-md-12 text-center">Select Payment Type</h5>
                                        <div class="radio radio-css radio-inline">
                                            <input type="radio" id="inlineCssRadio1_<?='offline'?>" name="payment_type" value="offline" />
                                            <label for="inlineCssRadio1_<?='offline'?>">Offline Payment</label>
                                        </div>
                                        <div class="radio radio-css radio-inline">
                                            <input type="radio" id="inlineCssRadio1_<?='online'?>" name="payment_type" value="online" />
                                            <label for="inlineCssRadio1_<?='online'?>">Online Payment</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row justify-content-center align-items-center">
                                        <input type="submit" value="PAYFEE AMOUNT" name="payfeeamount" class="btn btn-success pull-right mt-4 mb-4" id="payfeeamount">
                                    </div>
                                </div>
                            </form>
                        <?php }else{ ?>

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
                                setInterval(function(){
                                    alert(success.message);
                                    window.location = "<?=base_url()?>dashboard/feepayments/feepaymentlist";
                                },1000);
                            }else if(success.testmessage.payment_type == 'online'){
                                //alert('0000000');
                                $('#loader').show();
                                var count = 5;

                                setInterval(function(){
                                    count--;
                                    //document.getElementById('countDown').innerHTML = count;
                                    if(count == 0) {
                                        window.location = "<?=base_url()?>dashboard/feepayments/onlinepayment/"+ success.testmessage.id_num +"/"+ success.testmessage.school_id +"/"+success.testmessage.branch_id;
                                        //alert('Ok Here redirect url');
                                    }
                                },1000);
                            }
                        }else if(success.status == 0){
                            alert(success.message);
                            window.location = "<?=base_url()?>dashboard/feepayments/feepayment";
                        }
                    }
                })
            }
        })
    })
</script>