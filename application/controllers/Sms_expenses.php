<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_expenses extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }
    
    //enote for superadmin or admin only to save guide for like prof
    public function index($externaldata = NULL){
        $this->expenses();
    }

    public function expenses(){
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "Expenses..!";
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $data['expenseshead'] = $this->Model_dashboard->selectdata('sms_setupdata',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1));
        $data['expenses'] = $this->Model_dashboard->selectdata('sms_expenses',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'updated');
        $this->loadViews('admin/expenses/sms_expenses_page',$data);
    }

    public function expenseSavedata(){
        extract($_REQUEST);
        //$this->print_r($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $check = $this->Model_dashboard->selectdata('sms_expenses',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id));
        $id = count($check) + 1;
        $reg = 'EXP00'.$id;

        if(isset($_FILES['exp_documents']['name']) && $_FILES['exp_documents']['name'] != ''){
            //create directory
            $directory = $this->createdir('./uploads/files/expenses/'.$schooldata->branch_id.'/'.$schooldata->school_id.'/'.$reg,'./uploads/files/expenses/'.$schooldata->branch_id.'/'.$schooldata->school_id.'/'.$reg.'');

            $uploadimage = $this->uploadfiles('./uploads/files/expenses/' . $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $reg, 'exp_documents', '*', TRUE, '', '');
            $expupload = 'uploads/files/expenses/' . $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $reg . '/' . $uploadimage['uploaddata']['file_name'];

        }else{ $expupload = ''; }

        $insertdata = array(
            'school_id'     =>  $schooldata->school_id,
            'branch_id'     =>  $schooldata->branch_id,
            'exp_name'      =>  ucwords($exp_name),
            'exp_id'        =>  $invoice_no,
            'id_num'        =>  $reg,
            'exp_type'      =>  $exp_head_id,
            'exp_upload'    =>  $expupload,
            'exp_amount'    =>  $exp_amount,
            'exp_date'      =>  date('Y-m-d',strtotime($exp_date)),
            'exp_status'    =>  $payment_status,
            'exp_description'=> $description,
            'updated'       =>  date('Y-m-d H:i:s')
        );
        $insert = $this->Model_dashboard->insertdata('sms_expenses',$insertdata);
        if($insert != 0){
            $this->session->set_flashdata('success', 'Successfully Save Expenses..!');
            redirect(base_url('dashboard/expenses'));
        }else{
            $this->session->set_flashdata('error', 'Failed To Save Expenses..!');
            redirect(base_url('dashboard/expenses'));
        }
    
    }

    public function expensesEdit(){
        $sno = $this->uri->segment(4);
        $id_num = $this->uri->segment(5);
        if((isset($sno) && $sno != '') && (isset($id_num) && $id_num != '')) {
            $data['userdata'] = $this->Model_integrate->userdata();
            $data['PageTitle'] = "Expenses..!";
            //getting school data in session
            $schooldata = $this->session->userdata['school'];
            $data['expenseshead'] = $this->Model_dashboard->selectdata('sms_setupdata', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'status' => 1));
            $data['expenses'] = $this->Model_dashboard->selectdata('sms_expenses', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'status' => 1),'updated');
            $data['expensedata'] = $this->Model_dashboard->selectdata('sms_expenses', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id,'status' => 1,'sno'=>$sno,'id_num'=>$id_num),'updated');
            $this->loadViews('admin/expenses/sms_expenses_edit_page', $data);
        }else{
            $this->expenses();
        }
    }

    public function expenseEditSavedata(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        //$this->print_r($_REQUEST);
        //exit;
        if($id_num != '' && $sno != ''){
            $check = $this->Model_dashboard->selectdata('sms_expenses',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id));


            if(isset($_FILES['exp_documents']['name']) && $_FILES['exp_documents']['name'] != ''){
                //create directory
                $directory = $this->createdir('./uploads/files/expenses/'.$schooldata->branch_id.'/'.$schooldata->school_id.'/'.$id_num,'./uploads/files/expenses/'.$schooldata->branch_id.'/'.$schooldata->school_id.'/'.$id_num.'');

                $uploadimage = $this->uploadfiles('./uploads/files/expenses/' . $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num, 'exp_documents', '*', TRUE, '', '');
                $expupload = 'uploads/files/expenses/' . $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $id_num . '/' . $uploadimage['uploaddata']['file_name'];

            }else{ $expupload = $uploaded_image; }

            $conduction = array(
                'sno'   =>  $sno,
                'id_num'=>  $id_num,
                'school_id'     =>  $schooldata->school_id,
                'branch_id'     =>  $schooldata->branch_id,
            );

            $insertdata = array(
                'exp_name'      =>  ucwords($exp_name),
                'exp_id'        =>  $invoice_no,
                'exp_type'      =>  $exp_head_id,
                'exp_upload'    =>  $expupload,
                'exp_amount'    =>  $exp_amount,
                'exp_date'      =>  date('Y-m-d',strtotime($exp_date)),
                'exp_status'    =>  $payment_status,
                'exp_description'=> $description,
                'updated'       =>  date('Y-m-d H:i:s')
            );

            $insert = $this->Model_dashboard->updatedata($insertdata,$conduction,'sms_expenses');
            if($insert != 0){
                $this->session->set_flashdata('success', 'Successfully Update Expenses..!');
                redirect(base_url('dashboard/expenses'));
            }else{
                $this->session->set_flashdata('error', 'Failed To Update Expenses..!');
                redirect(base_url('dashboard/expenses'));
            }
        }else{
            //invalid reqest
            $this->session->set_flashdata('error', 'Invalied Expenses Update Request..!');
            redirect(base_url('dashboard/expenses'));
        }
    }

    public function expensesDelete(){
        $schooldata = $this->session->userdata['school'];
        $sno = $this->uri->segment(4);
        $id_num = $this->uri->segment(5);
        if((isset($sno) && $sno != '') && (isset($id_num) && $id_num != '')) {
            $conduction = array(
                'sno'   =>  $sno,
                'id_num'=>  $id_num,
                'school_id'     =>  $schooldata->school_id,
                'branch_id'     =>  $schooldata->branch_id,
            );

            $insertdata = array(
                'status'      =>  0,
                'updated'       =>  date('Y-m-d H:i:s')
            );

            $insert = $this->Model_dashboard->updatedata($insertdata,$conduction,'sms_expenses');
            if($insert != 0){
                $this->session->set_flashdata('success', 'Successfully Delete Expenses..!');
                redirect(base_url('dashboard/expenses'));
            }else{
                $this->session->set_flashdata('error', 'Failed To Delete Expenses..!');
                redirect(base_url('dashboard/expenses'));
            }
        }else{
            $this->session->set_flashdata('error', 'Invalied Expenses Delete Request..!');
            redirect(base_url('dashboard/expenses'));
        }
    }

    public function expenseUploadfile(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $sno  = $this->uri->segment(4);
        $id_num = $this->uri->segment(5);
        $expenses = $this->Model_dashboard->selectdata('sms_expenses', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id,'status' => 1,'sno'=>$sno,'id_num'=>$id_num));
        $filepath = urldecode($file); // Decode URL-encoded string
        if((count($expenses) != 0) && file_exists($filepath)) {
            // Process download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
            exit;
        }else{

        }
    }

    public function expenseSetup(){
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "Set Expenses..!";
        //getting school data in session
        $schooldata = $this->session->userdata['school'];
        $data['expenseshead'] = $this->Model_dashboard->selectdata('sms_setupdata',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1));
        $this->loadViews('admin/expenses/sms_expenses_setup_page',$data);
    }

    public function expenseSaveSetup(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        $check = $this->Model_dashboard->selectdata('sms_setupdata',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'name'=>ucwords($headname)));
        if(count($check) != 0){
            //already exits
            $this->session->set_flashdata('error', 'Already Exits Expenses Head..!');
            redirect(base_url('dashboard/expenses/setup'));
        }else{
            $insertdata = array(
                'school_id' =>  $schooldata->school_id,
                'branch_id' =>  $schooldata->branch_id,
                'name'      =>  ucwords($headname),
                'content'   =>  $headname_content
            );
            $insert = $this->Model_dashboard->insertdata('sms_setupdata',$insertdata);
            if($insert != 0){
                $this->session->set_flashdata('success', 'Successfully Save Expenses Head..!');
                redirect(base_url('dashboard/expenses/setup'));
            }else{
                $this->session->set_flashdata('error', 'Failed To Save Expenses Head..!');
                redirect(base_url('dashboard/expenses/setup'));
            }
        }
    }
}
