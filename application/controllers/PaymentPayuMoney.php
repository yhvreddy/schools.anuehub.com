<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class PaymentPayuMoney extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }

	public function check()
    {
        $this->data['schooldata'] = $schooldata = $this->session->userdata['school'];
        $this->data['userdata'] = $userdata = $this->Model_integrate->userdata();
        $this->data['PageTitle'] = "Fee Payment Confirm..!";
        $feedata = $this->session->userdata['feedata'];
        $amount =  $feedata['payingfee'];
        $product_info = 'online fee payment';
        $customer_name = str_replace('-','.',$feedata['studentname']);
        $customer_emial = $feedata['mail_id'];
        $customer_mobile = $feedata['mobile'];
        $customer_address = $feedata['address'];
//        $this->print_r($feedata);
//        exit;
        //payumoney details
        $MERCHANT_KEY = "eukJS7lL"; //change  merchant with yours
        $SALT = "xoG8xMvShi";  //change salt with yours

        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        //optional udf values
        $udf1 = '';
        $udf2 = '';
        $udf3 = '';
        $udf4 = '';
        $udf5 = '';

        $hashstring = $MERCHANT_KEY . '|' . $txnid . '|' . $amount . '|' . $product_info . '|' . $customer_name . '|' . $customer_emial . '|' . $udf1 . '|' . $udf2 . '|' . $udf3 . '|' . $udf4 . '|' . $udf5 . '||||||' . $SALT;
        $hash = strtolower(hash('sha512', $hashstring));

        $success = base_url().'dashboard/feepayments/onlinepayment/status';
        $fail    = base_url().'dashboard/feepayments/onlinepayment/status';
        $cancel  = base_url().'dashboard/feepayments/onlinepayment/status';

        $this->data['cartlist']     =  $feedata;
        $this->data['listtitle']    =  'check out list';
        $this->data['pageTitle']    = 'Check out Details';

        $this->data['data'] = array(
            'mkey' => $MERCHANT_KEY,
            'tid' => $txnid,
            'hash' => $hash,
            'amount' => $amount,
            'name' => $customer_name,
            'productinfo' => $product_info,
            'mailid' => $customer_emial,
            'phoneno' => $customer_mobile,
            'address' => $customer_address,
            'action' => "https://sandboxsecure.payu.in", //for live change action  https://secure.payu.in
            'sucess' => $success,
            'failure' => $fail,
            'cancel' => $cancel
        );
        $this->session->set_userdata('feedata',$feedata);
        //exit;
        //$this->load->view('PayuMoney_confirmation_1', $data);
        $this->loadViews('payumoney/PayuMoney_confirmation',$this->data,$this->data);
    }

	public function help()
	{
		$this->load->view('help');
	}
}
