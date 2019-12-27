<!-- Container fluid  -->
<?php $schooldata = $this->session->userdata['school']; ?>
<div id="content" class="content">
    
    <!-- Start Page Content -->
    <div class="row">
        <!--<div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-body m-5">-->
                    <div class="col-md-12">
                        <form action="<?php echo $data['action']; ?>/_payment" method="post" id="payuForm" name="payuForm">
                            <input type="hidden" name="key" value="<?php echo $data['mkey']; ?>" />
                            <input type="hidden" name="hash" value="<?php echo $data['hash']; ?>"/>
                            <input type="hidden" name="txnid" value="<?php echo $data['tid']; ?>" />
                            <input type="hidden" name="amount" value="<?php echo $data['amount']; ?>"  />
                            <input type="hidden" name="firstname" id="firstname" value="<?php echo $data['name']; ?>" />
                            <input type="hidden" name="email" id="email" value="<?php echo $data['mailid']; ?>" />
                            <input type="hidden" name="phone" value="<?php echo $data['phoneno']; ?>"  />
                            <input type="hidden" name="productinfo" value="<?php echo $data['productinfo']; ?>">
                            <input type="hidden" name="address1" value="<?php echo $data['address']; ?>" />
                            <input name="surl" value="<?php echo $data['sucess']; ?>" size="64" type="hidden" />
                            <input name="furl" value="<?php echo $data['failure']; ?>" size="64" type="hidden" />
                            <!--for test environment comment  service provider   -->
                            <input type="hidden" name="service_provider" value="payu_paisa" size="64" />
                            <input name="curl" value="<?php echo $data['cancel']; ?> " type="hidden" />
                        </form>
                    </div>
                <!--</div>
            </div>
        </div>-->
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
<script>
    $(document).ready(function () {
        $('#paymenymentloader').show();
        $('#payuForm').submit();
    })
</script>
