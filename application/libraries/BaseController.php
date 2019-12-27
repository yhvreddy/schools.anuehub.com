<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
//error_reporting(0);
class BaseController extends CI_Controller {
	
	protected $id 			= '';
	protected $regid 		= '';
	protected $global 		= array ();
	protected $type 		= '';
	protected $isLoggedIn 	= '';
	
	/**
	 * Takes mixed data and optionally a status code, then creates the response
	 *
	 * @access public
	 * @param array|NULL $data
	 * Data to output to the user
	 * running the script; otherwise, exit
	**/

	public function response($data = NULL) {
		$this->output->set_status_header ( 200 )->set_content_type ( 'application/json', 'utf-8' )->set_output ( json_encode ( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) )->_display ();
		exit ();
	}

	//This function used to check the user is logged in or not
	function isLoggedIn() {
		$isLoggedIn = $this->session->userdata('isLoggedIn');
		if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
			redirect(base_url());
		}else{
	      	$this->id 			= $this->session->userdata('id');
	      	$this->regid 		= $this->session->userdata('regid');
	      	$this->type 		= $this->session->userdata('type');
	      	$this->isLoggedIn 	= $this->session->userdata('isLoggedIn');

			$this->global['id'] 		= $this->id;
			$this->global['regid'] 		= $this->regid;
			$this->global['type'] 		= $this->type;
			$this->global['isLoggedIn'] = $this->isLoggedIn;
		}
	}

	//This function is used to logged out user from system
	function logout() {
		$this->session->sess_destroy ();
		redirect(base_url());
	}

    function successalert($message=NULL,$text=NULL){
        $this->session->set_flashdata('success',$message);
        $this->session->set_flashdata('image',base_url().'assets/images/success.png');
        $this->session->set_flashdata('text', $text);
    }
    
    function failedalert($message=NULL,$text=NULL){
        $this->session->set_flashdata('error',$message);
        $this->session->set_flashdata('image',base_url().'assets/images/failed.png');
        $this->session->set_flashdata('text', $text);
    }

	function otheralert($message=NULL,$text=NULL,$image=NULL){
		$this->session->set_flashdata('error',$message);
		$this->session->set_flashdata('image',base_url().$image);
		$this->session->set_flashdata('text', $text);
	}

	function manualgenerate_id($school,$year,$fullname,$countlist,$others=NULL){
		$school		=	$this->Model_integrate->initials($school);
		$fullname 	= 	$this->Model_integrate->initials($fullname);
		$fullname 	=	substr($fullname,0,2);
		return $school.$year.$fullname.$others.'00'.$countlist;
	}

	//auto load view (header and footer)
  	function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){
		$this->load->view('header', $headerInfo);
		$this->load->view($viewName, $pageInfo);
		$this->load->view('footer', $footerInfo);
  	}

  	//mail view
	function loadMailview($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){
		$this->load->view('header_mail', $headerInfo);
		$this->load->view($viewName, $pageInfo);
		$this->load->view('footer_mail', $footerInfo);
	}
	
	//manual load views 
	public function manualview($header,$body,$footer,$data = NULL){
		$this->load->view($header,$data);
		$this->load->view($body,$data);
		$this->load->view($footer,$data);
	}

	public function previous_page()
	{
		$refer = $this->agent->referrer();
		if(isset($refer) && !empty($refer)) {
			return $refer;
		}else {
			return '';
		}
	}

	//print pre
	public function print_r($data){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
  	}

	//lock account
    public function lockscreen(){
        $this->load->view('sms_lockscreen');
    }

	public function selectoptionstogetdetails(){ ?>
		<div class="" style="margin:40px 0px">
			<center>
				<img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>" style="">
				<h4>Please select following options...</h4>
			</center>
		</div>
	<?php }


    public function generate_mails($username,$domain,$length=''){
		if($length == ''){
			$length  = 1;
		}
		// array of possible top-level domains
		$tlds = array("edu","info");

		// string of possible characters
		$char = "0123456789abcdefghijklmnopqrstuvwxyz";
		// main loop - this gives 1000 addresses
		for ($j = 0; $j < $length; $j++) {

			// choose random lengths for the username ($ulen) and the domain ($dlen)
			$ulen = $username;
			$dlen = $domain;

			// reset the address
			$a = "";

			// get $ulen random entries from the list of possible characters
			// these make up the username (to the left of the @)
			/*for ($i = 1; $i <= $ulen; $i++) {
                $a .= substr($char, mt_rand(0, strlen($char)), 1);
            }*/
			$a .= $ulen;

			// wouldn't work so well without this
			$a .= "@";

			// now get $dlen entries from the list of possible characters
			// this is the domain name (to the right of the @, excluding the tld)
			/*for ($i = 1; $i <= $dlen; $i++) {
                $a .= substr($char, mt_rand(0, strlen($char)), 1);
            }*/

			$a .= $dlen;

			// need a dot to separate the domain from the tld
			$a .= ".";

			// finally, pick a random top-level domain and stick it on the end
			$a .= $tlds[mt_rand(0, (sizeof($tlds) - 1))];

			// done - echo the address inside a link
			return $a;
		}

	}

    //mail function
    public function sendemail($viewpage = "",$viewdetails = NULL,$fromid=NULL,$toid = NULL,$title=NULL,$attachments = NULL,$fromname = NULL,$toname = NULL){
        $config = Array(
            //'protocol' => 'sendmail',
            //'smtp_host' => 'your domain SMTP host',
            //'smtp_port' => 25,
            //'smtp_user' => 'SMTP Username',
            //'smtp_pass' => 'SMTP Password',
            //'smtp_timeout' => '4',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );

        $subject = $title;
        // Also, for getting full html you may use the following internal method:
        //$body = $this->email->full_html($subject, $message);

        $body = $this->load->view($viewpage,$viewdetails,TRUE);

		$attachmentsource = '';
        if($attachments != ''){
        	foreach ($attachments as $key => $attachment){
				$attachmentsource .= $attachment.',';
			}
		}else{
			$attachmentsource = '';
		}

		$attachmentsource = rtrim($attachmentsource, ',');

        $result = $this->email
            ->from($fromid,$fromname)
            //->reply_to('yoursecondemail@somedomain.com')    // Optional, an account where a human being reads.
            ->to($toid,$toname)
            ->subject($subject)
            ->message($body)
            //->AddAttachment($attachmentsource)
            ->attach($attachmentsource)
            ->send();

        if($result == 'true'){
            return 1;
        }else{
            return 0;
        }
        //echo json_encode($responce);
        //echo '<br />';
        //echo $this->email->print_debugger();
        //exit;
    }
  
	//ipaddress
    public function getipaddress(){
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

	//creating Directory
	public function createdir($checkpath,$createpath){
		if(!is_dir($checkpath)){
            if(mkdir($createpath, 0777, true)){
                return TRUE;
            }else{
                  return FALSE;
            }
		}else{
              return TRUE;
		}
	}

  	//Single file uploading
   	public function uploadfiles($uploadpath=NULL,$uploadfile=NULL,$formats=NULL,$renaming=NULL,$width=NULL,$height=NULL){

        $upload_config = array(
            'upload_path'   =>  $uploadpath,
            'allowed_types' =>  $formats,
            'encrypt_name'  =>  $renaming,
        );
        $this->load->library('upload', $upload_config);
        $this->upload->initialize($upload_config);
        
        if(!$this->upload->do_upload($uploadfile)) {
            $report = $this->upload->display_errors();
            $uploaddata = array('status'=>0,'upload'=>'failed','uploaddata'=>$report);
            return $uploaddata;
        }else{
            if($width != '' && $height != ''){
                $upload_config['image_library'] = 'gd2';
                $upload_config['source_image'] = $uploadpath.$fileData["file_name"];
                $upload_config['create_thumb'] = FALSE;
                $upload_config['maintain_ratio'] = FALSE;
                $upload_config['quality'] = '500%';
                $upload_config['width'] = $width;
                $upload_config['height'] = $height;
                $this->load->library('image_lib', $upload_config);
                $this->image_lib->resize();
            }
            $fileData = $this->upload->data();
            $uploaddata = array('status'=>1,'upload'=>'success','uploaddata'=>$fileData);
            return $uploaddata;
        }
   	}

	//multipul files uplaoding
	public function multiuploadfiles($uploadpath=NULL,$uploadfile=NULL,$formats=NULL,$renaming=NULL,$width=NULL,$height=NULL){
		//$this->print_r($uploadpath);
		// If file upload form submitted
		$uploadfiles = '';
		$filesCount = count(array_filter($_FILES[$uploadfile]['name']));
		if($filesCount > 0){
			for($i = 0; $i < $filesCount; $i++){
				$_FILES['file']['name']     = $_FILES[$uploadfile]['name'][$i];
				$_FILES['file']['type']     = $_FILES[$uploadfile]['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES[$uploadfile]['tmp_name'][$i];
				$_FILES['file']['error']    = $_FILES[$uploadfile]['error'][$i];
				$_FILES['file']['size']     = $_FILES[$uploadfile]['size'][$i];

				// File upload configuration
				$upload_config = array(
					'upload_path'   =>  $uploadpath,
					'allowed_types' =>  $formats,
					'encrypt_name'  =>  $renaming,
				);

				// Load and initialize upload library
				$this->load->library('upload',$upload_config);
				$this->upload->initialize($upload_config);

				// Upload file to server
				if($this->upload->do_upload('file')){
					$fileData = $this->upload->data();
					if($width != '' && $height != ''){
						$upload_config['image_library'] = 'gd2';
						$upload_config['source_image'] = $uploadpath.$fileData["file_name"];
						$upload_config['create_thumb'] = FALSE;
						$upload_config['maintain_ratio'] = FALSE;
						$upload_config['quality'] = '500%';
						$upload_config['width'] = $width;
						$upload_config['height'] = $height;
						$this->load->library('image_lib', $upload_config);
						$this->image_lib->resize();
					}
					$uploadfiles.= $uploadpath.$fileData['file_name'].',';
					$status = 1;
					$report = array();
					$upload = 'Success';
				}else{
					echo "====";
					$uploadfiles = '';
					$report = $this->upload->display_errors();
					$status = 0;
					$upload = 'Failed';
				}
			}

			$uploaddata = array('status'=>$status,'upload'=>$upload,'report'=>$report,'uploaddata'=>rtrim($uploadfiles,','));
			return $uploaddata;
		}else{
			$uploaddata = array('status'=>0,'upload'=>'Failed','uploaddata'=>'Uploading Files Empty');
			return $uploaddata;
		}
	}

	//Qr-Code gen
    public function qrcodegen($branchid,$schoolid,$regid,$acedmicyear,$savepath){
        extract($_REQUEST);
        $data['img_url']="";
        if($branchid != '' && $schoolid != '' && $regid !='' && $savepath != '')
        {
            $this->load->library('ciqrcode');
            $qr_image= $regid.'_'.rand().'.png';
            $params['data'] = $branchid.'&&'.$schoolid.'&&'.$regid.'&&'.$acedmicyear;
            $params['level'] = 'H';
            $params['size'] = 8;
            $params['savename'] =FCPATH.$savepath.$qr_image;
            if($this->ciqrcode->generate($params))
            {
                $data['img_url'] = $qr_image;
                $qr_image = array('code'=>1,'message'=>'success','image'=>$qr_image,'path'=>$savepath.$qr_image);
            }else{
                $qr_image = array('code'=>0,'message'=>'Not Genrate Qrcode');
            }
            return $qr_image;
        }
    }


	function getmac_ipaddress(){
		shell_exec("ipconfig/all");
		// Turn on output buffering
		ob_start();
		//Get the ipconfig details using system commond
		system('ipconfig /all');

		// Capture the output into a variable
		$mycom=ob_get_contents();
		// Clean (erase) the output buffer
		ob_clean();

		$findme = "Physical";
		//Search the "Physical" | Find the position of Physical text
		$pmac = strpos($mycom, $findme);

		// Get Physical Address
		$mac=substr($mycom,($pmac+36),17);
		//Display Mac Address
		
		return array('ip' => $this->input->ip_address(), 'mac' => $mac);

	}

    //devices
	public function detectDevice(){
		$userAgent = $_SERVER["HTTP_USER_AGENT"];
		$devicesTypes = array(
			"computer" => array("msie 10", "msie 9", "msie 8", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
			"tablet"   => array("tablet", "android", "ipad", "tablet.*firefox"),
			"mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini"),
			"bot"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis")
		);
		foreach($devicesTypes as $deviceType => $devices) {
			foreach($devices as $device) {
				if(preg_match("/" . $device . "/i", $userAgent)) {
					$deviceName = $deviceType;
				}
			}
		}
		return ucfirst($deviceName);
	}

	public function systemInfo()
	{
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$os_platform    = "Unknown OS Platform";
		$os_array       = array(
			'/windows phone 8/i'    =>  'Windows Phone 8',
			'/windows phone os 7/i' =>  'Windows Phone 7',
			'/windows nt 10/i'      =>  'Windows 10',
			'/windows nt 6.3/i'     =>  'Windows 8.1',
			'/windows nt 6.2/i'     =>  'Windows 8',
			'/windows nt 6.1/i'     =>  'Windows 7',
			'/windows nt 6.0/i'     =>  'Windows Vista',
			'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
			'/windows nt 5.1/i'     =>  'Windows XP',
			'/windows xp/i'         =>  'Windows XP',
			'/windows nt 5.0/i'     =>  'Windows 2000',
			'/windows me/i'         =>  'Windows ME',
			'/win98/i'              =>  'Windows 98',
			'/win95/i'              =>  'Windows 95',
			'/win16/i'              =>  'Windows 3.11',
			'/macintosh|mac os x/i' =>  'Mac OS X',
			'/mac_powerpc/i'        =>  'Mac OS 9',
			'/linux/i'              =>  'Linux',
			'/ubuntu/i'             =>  'Ubuntu',
			'/iphone/i'             =>  'iPhone',
			'/ipod/i'               =>  'iPod',
			'/ipad/i'               =>  'iPad',
			'/android/i'            =>  'Android',
			'/blackberry/i'         =>  'BlackBerry',
			'/webos/i'              =>  'Mobile'
		);
		$found = false;
		//$addr = new RemoteAddress;
		$device = '';
		foreach ($os_array as $regex => $value)
		{
			if($found)
				break;
			else if (preg_match($regex, $user_agent))
			{
				$os_platform    =   $value;
				$device = !preg_match('/(windows|mac|linux|ubuntu)/i',$os_platform)
					?'MOBILE':(preg_match('/phone/i', $os_platform)?'MOBILE':'SYSTEM');
			}
		}
		$device = !$device? 'system ': $device;
		return array('os'=>$os_platform,'device'=>$device);
	}

	public function browser()
	{
		error_reporting(0);
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$browser        =   "Unknown Browser";
		$browser_array  = array('/msie/i'       =>  'Internet Explorer',
			'/firefox/i'    =>  'Firefox',
			'/safari/i'     =>  'Safari',
			'/chrome/i'     =>  'Chrome',
			'/opera/i'      =>  'Opera',
			'/netscape/i'   =>  'Netscape',
			'/maxthon/i'    =>  'Maxthon',
			'/konqueror/i'  =>  'Konqueror',
			'/mobile/i'     =>  'Handheld Browser');

		foreach ($browser_array as $regex => $value)
		{
			if($found)
				break;
			else if (preg_match($regex, $user_agent,$result))
			{
				$browser    =   $value;
			}
		}
		return $browser;
	}

	
}
