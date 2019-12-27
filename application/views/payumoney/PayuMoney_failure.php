<style type="text/css">
	.image{
		width: 100px;
    height: 100px;
    margin: 20px auto;
	}
	.mycard{
		margin: 60px 0px;
	}
	.badge-danger{
		background: red;
	}
</style>
<?php $schooldata = $this->session->userdata['school']; ?>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Fee Payments</a></li>
        <li class="breadcrumb-item active"> Payment Status</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Payment Status<small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-body">
      			<div class="col-md-12 text-center mycard">
                    <?php //print_r($feelistdata); ?>
                        <img src="<?=base_url('assets/img/payment_failed.png')?>" class="image img-responsive">
                        <h4 class="panel-header">Your Transaction <label for="failure" class="label label-danger">Failed</label></h4>
                        <?php
                    echo "<p>Your order status is ". $status ."..</br>";
                    echo "Your transaction id for this transaction is ".$txnid.". <br>Contact our customer support.</p>";
                    ?>
                    <div class="row align-items-center justify-content-center">
                        <a href="<?=base_url('dashboard/feepayments/feepaymentlist')?>" class="pull-right btn btn-success"><i class="fa fa-arrow-alt-circle-left"></i> Check Fee List</a>&nbsp;&nbsp;
                        <a href="<?=base_url('dashboard/feepayments/makefeepayment?std='.$feelistdata['id_num'].'&schoolid='.$feelistdata['school_id'].'&branchid='.$feelistdata['branch_id'].'')?>" class="btn btn-info"><i class="fa fa-recycle"></i> Retry Payment</a>
                    </div>
<!--                    <h6 style="margin:10px 0px 0px 0px">Please Try after 5min's..</h6>-->
      			</div>

                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->