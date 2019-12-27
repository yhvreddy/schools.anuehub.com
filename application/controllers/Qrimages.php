<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Code written by TangleSkills

class Qrimages extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		  $this->load->helper('url');
    }
	
	public function index()
	{
		$data['img_url']="";
		if($this->input->post('action') && $this->input->post('action') == "generate_qrcode")
		{
			$this->load->library('ciqrcode');
			$qr_image=rand().'.png';
			$params['data'] = $this->input->post('qr_text');
			$params['level'] = 'H';
			$params['size'] = 8;
			$params['savename'] =FCPATH."uploads/qr_image/".$qr_image;
			if($this->ciqrcode->generate($params))
			{
				$data['img_url']=$qr_image;	
			}
		}
		$this->load->view('qrcode',$data);
	}
}
