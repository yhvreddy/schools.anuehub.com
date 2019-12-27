<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class StatusPayuMoney extends BaseController {

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
      }

	public function index() {
        extract($_REQUEST);
        $this->data['feedata'] = @$feedata = $this->session->userdata['feedata'];
        $this->data['schooldata'] = $schooldata = $this->session->userdata['school'];
        $this->data['userdata'] = $this->Model_integrate->userdata();
        $this->data['PageTitle'] = "Collect Fee Payment's..!";
        $status = $this->input->post('status');
        if (empty($status)) {
            redirect(base_url('dashboard/feepayments/feepayment'));
        }
        $firstname = $this->input->post('firstname');
        $amount = $this->input->post('amount');
        $txnid = $this->input->post('txnid');
        $posted_hash = $this->input->post('hash');
        $key = $this->input->post('key');
        $productinfo = $this->input->post('productinfo');
        $email = $this->input->post('email');
        $salt = "xoG8xMvShi"; //  Your salt
        $add = $this->input->post('additionalCharges');
        if(isset($add)){
            $additionalCharges = $this->input->post('additionalCharges');
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }else{
            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $this->data['status']   =   $status;
        $this->data['hash'] = hash("sha512", $retHashSeq);
        $this->data['amount'] = $amount;
        $this->data['txnid'] = $txnid;
        $this->data['posted_hash'] = $posted_hash;
        $this->data['status'] = $status;
        $userdata = $this->session->userdata;
//         echo "<pre>";
//         print_r($userdata);
//         echo "</pre>";
        
        if($status == 'success'){ 
            //insert data to table;
            $insertdata = array(
                'school_id' => $feedata['school_id'],
                'branch_id' => $feedata['branch_id'],
                'id_num'    => $feedata['id_num'],
                'class'     => $feedata['class'],
                'class_type'=> $feedata['class_type'],
                'feelistid' => $feedata['feelistid'],
                'totalfee'  => $feedata['totalfee'],
                'paidfee'   => $feedata['paidfee'],
                'balancefee'=> $feedata['balancefee'],
                'lastpaidfee'=> $feedata['lastpaidfee'],
                'payingfee' => $feedata['payingfee'],
                'paiddate'  => $feedata['paiddate'],
                'payment_type' => $feedata['payment_type'],
                'status'        =>  1,
                'transaction_id'=>  $payuMoneyId,
                'reference_id'  =>  $txnid,
                'bankcode'      =>  $bankcode,
                'bank_ref_num'  =>  $bank_ref_num,
                'name_on_card'  =>  $name_on_card,
                'cardnum'       =>  $cardnum,
                'paystatus'     =>  $status
            );
            $check = $this->Model_dashboard->selectorderby('sms_feelist',array('transaction_id'=>$payuMoneyId,'reference_id'=>$txnid),'sno DESC');
            if(count($check) == 0){
                $insert = $this->Model_dashboard->insertdata('sms_feelist',$insertdata);
                if($insert != 0){
                    //$this->session->unset_userdata('feedata');
                }
            }
            $this->loadViews('payumoney/PayuMoney_success',$this->data,$this->data);
        }else if($status == 'failure'){
            //insert data to table;
            if(isset($cardnum) && $cardnum != ''){
                $cardnum = $cardnum;
            }else{
                $cardnum = '';
            }

            if(isset($name_on_card) && $name_on_card != ''){
                $name_on_card = $name_on_card;
            }else{
                $name_on_card = '';
            }
            $insertdata = array(
                'school_id' => $feedata['school_id'],
                'branch_id' => $feedata['branch_id'],
                'id_num'    => $feedata['id_num'],
                'class'     => $feedata['class'],
                'class_type'=> $feedata['class_type'],
                'feelistid' => $feedata['feelistid'],
                'totalfee'  => $feedata['totalfee'],
                'paidfee'   => $feedata['paidfee'],
                'balancefee'=> $feedata['balancefee'],
                'lastpaidfee'=> $feedata['lastpaidfee'],
                'payingfee' => $feedata['payingfee'],
                'paiddate'  => $feedata['paiddate'],
                'payment_type' => $feedata['payment_type'],
                'status'        =>  0,
                'transaction_id'=>  $payuMoneyId,
                'reference_id'  =>  $txnid,
                'bankcode'      =>  $bankcode,
                'bank_ref_num'  =>  $bank_ref_num,
                'name_on_card'  =>  $name_on_card,
                'cardnum'       =>  $cardnum,
                'paystatus'     =>  $status
            );
            $check = $this->Model_dashboard->selectorderby('sms_feelist',array('transaction_id'=>$payuMoneyId,'reference_id'=>$txnid),'sno DESC');
            $this->data['feelistdata'] = $insertdata;
            if(count($check) == 0){
                $insert = $this->Model_dashboard->insertdata('sms_feelist',$insertdata);
                if($insert != 0){
                    //$this->session->unset_userdata('feedata');
                }
            }
            $this->loadViews('payumoney/PayuMoney_failure',$this->data,$this->data);
        }
    }    
}
