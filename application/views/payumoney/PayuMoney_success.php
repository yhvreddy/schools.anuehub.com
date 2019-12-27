<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
	.image{
		width: 100px;
    height: 100px;
    margin: 20px auto;
	}
	.mycard{
		margin: 60px 0px;
	}
</style>
<?php $schooldata = $this->session->userdata['school']; ?>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Fee Payments</a></li>
        <li class="breadcrumb-item active">Payment Status</li>
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
      				<img src="<?=base_url('assets/img/payment_success.png')?>" class="image img-responsive">
      				<h4 class="panel-header text-center">Your Transaction <label for="Success" class="label label-success">Success</label></h4>
      			
      				<?php 
                    echo "<p>Thank You. Your order status is ". $status .".</br>";
                    echo "Your Transaction ID for this transaction is ".$txnid."</br>";
                    echo "We have received a payment of Rs. <b>" . $amount . ". </b> Order Books as sent to mail.</p>";
                    ?>
                    <h6>Thank you..</h6>
                    <div class="row align-items-center justify-content-center">
                        <a href="<?=base_url('dashboard/feepayments/feepaymentlist')?>" class="pull-right btn btn-success"><i class="fa fa-arrow-circle-o-right"></i> Back to Fee List</a>
                    </div>
      			</div>

                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->