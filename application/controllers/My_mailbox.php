<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class My_mailbox extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
		$this->load->model('Model_mailbox');
		$this->load->library("pagination");
		//per page limit
		$this->perPage = 10;
    }


    public function index(){
        $this->mailinbox();
    }


    public function mailinbox(){
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id = $data['school_id'] =   $details['school']->school_id;
		$branch_id = $data['branch_id'] =   $details['school']->branch_id;
		$data['userdata'] = $userdata = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Inbox eMails..!";
		$data['user_sno']  = $user_sno	=	$userdata->sno;
		$data['user_id']   = $user_id	=	$details['regid'];
		$data['user_type'] = $user_type	=	$details['type'];
		if(isset($userdata->reg_id)){
			$send_from = $userdata->local_mail_id;
		}else{
			$send_from = $userdata->local_mail_id;
		}
		//$mailsents	=	$this->Model_dashboard->customquery("SELECT * FROM `sms_mail_box` INNER JOIN  `sms_mail_reports` ON sms_mail_reports.id = sms_mail_box.mail_ids AND sms_mail_reports.mail_id = sms_mail_box.mail_id WHERE sms_mail_box.school_id = '$school_id' AND sms_mail_box.branch_id = '$branch_id' AND sms_mail_box.sent_to = '$send_from' AND sms_mail_box.inbox_status = 1 ORDER BY sms_mail_box.id DESC");

		//pagination config
		$config = array();
		$config["base_url"] = base_url('user/mail/inbox/');
		$config["total_rows"] = $this->Model_mailbox->get_Inboxcount();
		$config["per_page"] = $this->perPage;
		$config["uri_segment"] = 4;
		//styling
		$config_links['next_tag_open'] = '<a class="btn btn-white btn-sm"><i class="fa fa-chevron-left f-s-14 t-plus-1"></i>';
		$config_links['next_tag_close'] = '</a>';
		$config_links['prev_tag_open'] = '<a class="btn btn-white btn-sm"><i class="fa fa-chevron-right f-s-14 t-plus-1"></i>';
		$config_links['prev_tag_close'] = '</a>';

		//initialize pagination library
		$this->pagination->initialize($config);
		/*$data['links'] = $this->pagination->create_links();
		var_dump($data['links']);
		exit; */
		//define offset
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$data['mailsents'] = $this->Model_mailbox->get_inboxdata($page,$this->perPage);
        $this->loadMailview('mailbox/inbox_page',$data);
    }


    public function mailInboxDataList(){
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id = $data['school_id'] =   $details['school']->school_id;
		$branch_id = $data['branch_id'] =   $details['school']->branch_id;
		$data['userdata'] = $userdata = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Inbox eMails..!";
		$data['user_sno']  = $user_sno	=	$userdata->sno;
		$data['user_id']   = $user_id	=	$details['regid'];
		$data['user_type'] = $user_type	=	$details['type'];
		if(isset($userdata->reg_id)){
			$sender_id = $userdata->reg_id;
			$send_from = $userdata->local_mail_id;
		}else{
			$sender_id = $userdata->id_num;
			$send_from = $userdata->local_mail_id;
		}
		$mailsents	=	$this->Model_dashboard->customquery("SELECT * FROM `sms_mail_box` INNER JOIN  `sms_mail_reports` ON sms_mail_reports.id = sms_mail_box.mail_ids AND sms_mail_reports.mail_id = sms_mail_box.mail_id WHERE sms_mail_box.school_id = '$school_id' AND sms_mail_box.branch_id = '$branch_id' AND sms_mail_box.sent_to = '$send_from' AND sms_mail_box.inbox_status = 1");
    	?>

		<!-- begin vertical-box-cell -->
		<div class="vertical-box-cell">
			<!-- begin vertical-box-inner-cell -->
			<div class="vertical-box-inner-cell">
				<!-- begin scrollbar -->
				<div data-scrollbar="true" data-height="100%">
					<!-- begin list-email -->

					<ul class="list-group list-group-lg no-radius list-email">
						<?php $i = 1; foreach ($mailsents as $mailsent){
							$extractdata = explode(' + ',$mailsent->information);
							$id   = $extractdata[0];
							$type = $extractdata[1];

							if($type == 'admin' || $type == 'superadmin'){
								$userdata = $this->Model_dashboard->selectdata('sms_regusers',array('sno'=>$id,'reg_id'=>$mailsent->sender_id),'sno');
								$person = $userdata[0];
								$from = 'admin';
								$name = $person->fname;
							}else if($type == 'student'){
								$userdata = $this->Model_dashboard->selectdata('sms_admissions',array('branch_id'=>$branch_id,'school_id'=>$school_id,'sno'=>$id),'sno');
								$person = $userdata[0];
								$from = 'student';
								$name = $person->firstname;
							}else if($type != 'student' || $type != 'admin' || $type != 'superadmin'){
								$userdata = $this->Model_dashboard->selectdata('sms_employee',array('branch_id'=>$branch_id,'school_id'=>$school_id,'sno'=>$id),'sno');
								$person = $userdata[0];
								$from = 'staff';
								$name = $person->firstname;
							}


							if(isset($person->profile_pic)){ $profile_image = $person->profile_pic; }else if(isset($person->student_image)){ $profile_image = $person->student_image; }elseif(isset($person->employee_pic)){ $profile_image = $person->employee_pic; }

							if(isset($person->fname)){ $fname = $person->fname;$lname = $person->lname; }else{ $fname = $person->firstname;$lname = $person->lastname; }

							?>
							<li class="list-group-item">

								<div class="checkbox checkbox-css email-checkbox ml-1">
									<input type="checkbox" class="SelectInboxMails" id="SelectInboxMails_<?=$mailsent->id?>" value="<?=$mailsent->id?>" name="SelectInboxMails"/>
									<label for="SelectInboxMails_<?=$mailsent->id?>"></label>
								</div>

								<a href="javascript:;" class="email-user bg-grey mr-4">
									<script>
										$(document).ready(function(){
											var PfirstName = '<?=$fname?>';
											var PlastName = '<?=$lname?>';
											var intials = PfirstName.charAt(0) + PlastName.charAt(0);
											var PprofileImage = $('#Inbox_sendersName<?=$mailsent->id?>').text(intials);
										});
									</script>
									<?php if(!empty($profile_image)){ ?>
										<img src="<?=base_url($profile_image)?>" class="fab text-white">
									<?php }else{ ?>
										<span id="Inbox_sendersName<?=$mailsent->id?>" style="" class="Inbox_sendersName text-uppercase"></span>
									<?php } ?>
								</a>

								<div class="email-info">
									<a href="<?=base_url('user/mail/details/'.$mailsent->id.'/'.$mailsent->branch_id.'/'.$mailsent->school_id.'/sent-mail?id='.$mailsent->mail_id)?>">
										<span class="email-time">
											<?php
											$datetime = $this->Model_integrate->daysago(date('Y-m-d H:i:s',strtotime($mailsent->send_date)));
											echo $datetime;
											?>
										</span>
											<span class="email-sender" style="margin-top: 2px;">
											<span class="pull-left"><?=$name?></span>
											<span class="pull-right importanticon" style="display:none">
												<label class="label label-default" style="font-size: xx-small;"> <i class="fa fa-flag"></i> Important</label>
											</span>
										</span>

											<span class="email-desc" style="top: 2px;"><?=$mailsent->subject?></span>

											<span class="email-checkbox pull-right" style="cursor: unset">
											<?php if(!empty($mailsent->attachments)){ ?>
												<i class="fas fa-paperclip"></i>
											<?php } ?>
										</span>
									</a>
								</div>
							</li>
						<?php } ?>
					</ul>

					<!-- end list-email -->
					<script>
						$(document).ready(function () {
							//delete mails
							$("#deleteinboxmails").click(function () {
								var checkedInboxvalues = [];
								var checkinboxdata = $('.SelectInboxMails:checked');
								if(checkinboxdata.length > 0){

									$(checkinboxdata).each(function(){
										if($(this).is(':checked')){
											$(this).closest('li').addClass('RemoveInboxrow');
										}else{
											$(this).closest('li').removeClass('RemoveInboxrow');
										}
									});
									$(checkinboxdata).each(function(){
										checkedInboxvalues.push($(this).val());
									});
									$.ajax({
										url:"<?=base_url('user/mail/trash/inboxmails'); ?>",
										method:"POST",
										data:{delete_inboxdata:checkedInboxvalues,request_type:'delete'},
										dataType:'json',
										success:function(inboxresponcedata)
										{
											console.log(inboxresponcedata);
											if(inboxresponcedata.key_code == 1){
												$("#SelectAllInboxMails").prop('checked', false);
												$('.RemoveInboxrow').fadeOut(800);
											}else{
												alert(inboxresponcedata.message);
											}
											//
										}
									})
								}else{
									checkedInboxvalues = [];
									alert('Select atleast one mail..!');
								}
							});

							$("#ImportantInboxMails").click(function () {
								var checkedInboxvalues = [];
								var checkinboxdata = $('.SelectInboxMails:checked');
								if(checkinboxdata.length > 0){
									$(checkinboxdata).each(function(){
										if($(this).is(':checked')){
											$(this).closest('li').addClass('ImportantInboxrow');
										}else{
											$(this).closest('li').removeClass('ImportantInboxrow');
										}
									});
									$(checkinboxdata).each(function(){
										checkedInboxvalues.push($(this).val());
									});
									$.ajax({
										url:"<?= base_url('user/mail/important/inboxmails'); ?>",
										method:"POST",
										data:{delete_inboxdata:checkedInboxvalues,request_type:'important'},
										dataType:'json',
										success:function(inboxresponcedata)
										{
											console.log(inboxresponcedata);
											if(inboxresponcedata.key_code == 1){
												$("#SelectAllInboxMails").prop('checked', false);
												$('.ImportantInboxrow').fadeOut(800);
											}else{
												alert(inboxresponcedata.message);
											}
											//
										}
									})
								}else{
									checkedInboxvalues = [];
									alert('Select atleast one mail..!');
								}
							});
						})
					</script>
				</div>
				<!-- end scrollbar -->
			</div>
			<!-- end vertical-box-inner-cell -->
		</div>
		<!-- end vertical-box-cell -->
		<?php
	}


	public function sentmails(){
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id = $data['school_id'] =   $details['school']->school_id;
		$branch_id = $data['branch_id'] =   $details['school']->branch_id;
		$data['userdata'] = $userdata = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Sent eMails..!";
		if(isset($userdata->reg_id)){
			$sender_id = $userdata->reg_id;
			$send_from = $userdata->local_mail_id;
		}else{
			$sender_id = $userdata->id_num;
			$send_from = $userdata->local_mail_id;
		}
		$data['mailsents']	=	$this->Model_dashboard->selectdata('sms_mail_reports',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1,'sender_id'=>$sender_id,'send_from'=>$send_from),'send_date');
		$this->loadMailview('mailbox/sentmails_page',$data);
	}


    public function composemail(){
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id = $data['school_id'] =   $details['school']->school_id;
		$branch_id = $data['branch_id'] =   $details['school']->branch_id;
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Email - Compose new mail..";
		$this->loadMailview('mailbox/newmail_page',$data);
	}


	public function savecomposemaildata(){
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
    	extract($_REQUEST);
    	$schooldata = $details['school'];
		$userdata 	= $this->Model_integrate->userdata();
		$schoolid 	= $schooldata->school_id;
		$branchid 	= $schooldata->branch_id;

		$academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
		$batch = $academicyear[0]->academic_year; //adminssion accadmic batch
		$enquiry = $this->Model_dashboard->selectdata('sms_mail_reports',array('school_id'=>$schoolid,'branch_id'=>$branchid));
		$countlist = count($enquiry) + 1;
		$schoolname  = $schooldata->schoolname;
		$letters =  random_string('alpha', 1);
		$alfnums =  random_string('alnum', 1);
		$mail_rid = strtoupper($letters).' '.strtoupper($alfnums);
		$mailbox_id  = $this->manualgenerate_id($schoolname,date('y').'MB',$mail_rid,$countlist);

		if(isset($userdata->reg_id)){
			$sender_id		=	$userdata->reg_id;
			$sender_mail	=	$userdata->local_mail_id;
			$information	=	$userdata->sno.' + '.$userdata->usermode;
		}else{
			$sender_id		=	$userdata->id_num;
			$sender_mail	=	$userdata->local_mail_id;
			if(isset($userdata->emoloyeeposition)){
				$usertype	=	$userdata->emoloyeeposition;
			}else{
				$usertype	=	$userdata->usermode;
			}
			$information	=	$userdata->sno.' + '.$usertype;
		}


    	$send_to	= $mail_to;
		$send_mails = explode(',',$mail_to);

		//atachments
		$attachfilespath = 'uploads/mailbox_files/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $mailbox_id.'/';
		$this->createdir($attachfilespath,$attachfilespath);
		if($_FILES['upload_attachments']['name'][0] != ''){
			$noticefiles = $this->multiuploadfiles($attachfilespath,'upload_attachments','*',FALSE,'','');
			$attachfiles = $noticefiles['uploaddata'];
		}else{ $attachfiles = ''; }

    	$savemaildata = array(
    		'branch_id'	=>	$branchid,
			'school_id'	=>	$schoolid,
			'mail_id'	=>	$mailbox_id,
			'send_from'	=>	$sender_mail,
			'send_to'	=>	$send_to,
			'subject'	=>	$mail_subject,
			'content'	=>	$mailcontent,
			'attachments'=>	$attachfiles,
			'mail_type'	=>	'mail',
			'sender_id'	=>	$sender_id,
			'send_date'	=>	date('Y-m-d H:i:s'),
			'status'	=>	1,
			'information'=> $information
		);

		$mailboxsend = $this->Model_dashboard->insertdata('sms_mail_reports',$savemaildata);
		if($mailboxsend != 0){
			foreach ($send_mails as $sendmaildata){
				$savemailsdata = array(
					'branch_id'	=>	$branchid,
					'school_id'	=>	$schoolid,
					'mail_ids'	=>	$mailboxsend,
					'mail_id'	=>	$mailbox_id,
					'sent_from'	=>	$sender_mail,
					'sent_to'	=>	$sendmaildata,
					'updated'	=>	date('Y-m-d H:i:s'),
					'status'	=>	1,
				);
				$this->Model_dashboard->insertdata('sms_mail_box',$savemailsdata);
			}
			$this->successalert('Successfully send mail..','You have sent mail '.$mail_subject.' success..!');
			redirect(base_url('user/mail/sent'));
		}else{
			$this->successalert('Failed to send mail..!','Failed to sent '.$mail_subject);
			redirect(base_url('user/mail/composemail'));
		}
	}


	public function savereplymaildata(){
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		extract($_REQUEST);
		$schooldata = $details['school'];
		$userdata 	= $this->Model_integrate->userdata();
		$schoolid 	= $schooldata->school_id;
		$branchid 	= $schooldata->branch_id;

		$academicyear = $this->Model_integrate->academicyear($schooldata->school_academic_form_to);
		$batch = $academicyear[0]->academic_year; //adminssion accadmic batch
		$enquiry = $this->Model_dashboard->selectdata('sms_mail_reports',array('school_id'=>$schoolid,'branch_id'=>$branchid));
		$countlist = count($enquiry) + 1;
		$schoolname  = $schooldata->schoolname;
		$letters =  random_string('alpha', 1);
		$alfnums =  random_string('alnum', 1);
		$mail_rid = strtoupper($letters).' '.strtoupper($alfnums);
		$mailbox_id  = $this->manualgenerate_id($schoolname,date('y').'MB',$mail_rid,$countlist);

		if(isset($userdata->reg_id)){
			$sender_id		=	$userdata->reg_id;
			$sender_mail	=	$userdata->mailid;
			$information	=	$userdata->sno.' + '.$userdata->usermode;
		}else{
			$sender_id		=	$userdata->id_num;
			$sender_mail	=	$userdata->mail_id;
			if(isset($userdata->emoloyeeposition)){
				$usertype	=	$userdata->emoloyeeposition;
			}else{
				$usertype	=	$userdata->usermode;
			}
			$information	=	$userdata->sno.' + '.$usertype;
		}


		$send_to	= $mail_to;
		//atachments
		$attachfilespath = 'uploads/mailbox_files/'.date('Y').'/'. $schooldata->branch_id . '/' . $schooldata->school_id . '/' . $mailbox_id.'/';
		$this->createdir($attachfilespath,$attachfilespath);
		if($_FILES['upload_attachments']['name'][0] != ''){
			$noticefiles = $this->multiuploadfiles($attachfilespath,'upload_attachments','*',FALSE,'','');
			$attachfiles = $noticefiles['uploaddata'];
		}else{ $attachfiles = ''; }

		$savemaildata = array(
			'branch_id'	=>	$branchid,
			'school_id'	=>	$schoolid,
			'mail_id'	=>	$mailbox_id,
			'send_from'	=>	$sender_mail,
			'send_to'	=>	$send_to,
			'subject'	=>	$mail_subject,
			'content'	=>	$mailcontent,
			'attachments'=>	$attachfiles,
			'mail_type'	=>	'mail_reply',
			'sender_id'	=>	$sender_id,
			'send_date'	=>	date('Y-m-d H:i:s'),
			'status'	=>	1,
			'information'=> $information,
			'reply_id'	=>	$mail_regid,
			'reply_num'	=>	$primary_mid
		);

		$mailboxsend = $this->Model_dashboard->insertdata('sms_mail_reports',$savemaildata);
		if($mailboxsend != 0){
			$this->successalert('Successfully send mail..','You have sent mail '.$mail_subject.' success..!');
			redirect(base_url('user/mail/sent'));
		}else{
			$this->successalert('Failed to send mail..!','Failed to sent '.$mail_subject);
			redirect(base_url('user/mail/composemail'));
		}
	}


	public function mailDetails(){
    	extract($_REQUEST);
    	$mail_id 	=	$id;
    	$mid		=	$this->uri->segment(4);
		$branch_id	=	$this->uri->segment(5);
		$school_id	=	$this->uri->segment(6);
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$data['school_id'] =   $details['school']->school_id;
		$data['branch_id'] =   $details['school']->branch_id;
		$data['userdata'] = $userdata = $this->Model_integrate->userdata();
		if((isset($id) && !empty($id)) && (isset($mid) && !empty($mid)) && (isset($branch_id) && !empty($branch_id)) && (isset($school_id) && !empty($school_id)) && (isset($inbox_id) && !empty($inbox_id))) {
			$data['maildetails'] = $maildetails = $this->Model_dashboard->selectdata('sms_mail_reports', array('school_id' => $school_id, 'branch_id' => $branch_id,'id'=>$mid,'mail_id'=>$mail_id));
			$wheredata = 	array('branch_id'=>$branch_id,'school_id'=>$school_id,'sent_to'=>$userdata->local_mail_id,'mail_ids'=>$mid,'mail_id'=>$mail_id,'id'=>$inbox_id);
			$setdata	=	array('mail_read'=>1,'updated'=>date('Y-m-d H:i:s'));
			$this->Model_dashboard->updatedata($setdata,$wheredata,'sms_mail_box');
			$data['PageTitle'] = "eMail : ".$maildetails[0]->subject;
			$this->loadMailview('mailbox/maildetails_page', $data);
		}else{
			$data['maildetails'] = $this->Model_dashboard->selectdata('sms_mail_reports', array('school_id' => $school_id, 'branch_id' => $branch_id,'id'=>$mid,'mail_id'=>$mail_id));
			$data['PageTitle'] = "eMail : ".$maildetails[0]->subject;
			$this->loadMailview('mailbox/maildetails_page', $data);
		}
	}


	public function mailReplymail(){
		extract($_REQUEST);
		$mail_id	=	$data['mail_id'] 	=	$id;
		$mid		=	$data['mid']		=	$this->uri->segment(4);
		$branch_id	=	$data['branch_id']	=	$this->uri->segment(5);
		$school_id	=	$data['school_id']	=	$this->uri->segment(6);
		$reply_by	=	$data['reply_by']	=	$this->uri->segment(7);
		$reply_idnum=	$data['reply_idnum']=	$this->uri->segment(8);

		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$data['userdata'] = $userdata = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Email - Reply..";
		if((isset($id) && !empty($id)) && (isset($mid) && !empty($mid)) && (isset($branch_id) && !empty($branch_id)) && (isset($school_id) && !empty($school_id)) && (isset($reply_by) && !empty($reply_by)) && (isset($reply_idnum) && !empty($reply_idnum))){
			$data['maildetails'] = $this->Model_dashboard->selectdata('sms_mail_reports', array('school_id' => $school_id, 'branch_id' => $branch_id,'id'=>$mid,'mail_id'=>$mail_id));
			$this->loadMailview('mailbox/replaymail_page', $data);
		}
	}


	public function trashInboxMails(){
    	extract($_REQUEST);
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id  =   $details['school']->school_id;
		$branch_id  =   $details['school']->branch_id;
		$userdata   =   $this->Model_integrate->userdata();
		$data['user_id']   = $user_id	=	$details['regid'];
		$data['user_type'] = $user_type	=	$details['type'];
    	//get mail data
		foreach ($delete_inboxdata as $value) {
			$wheredata = 	array('branch_id'=>$branch_id,'school_id'=>$school_id,'id'=>$value);
			$setdata	=	array('important_status'=>0,'inbox_status'=>0,'trash_status'=>1,'updated'=>date('Y-m-d H:i:s'));
			@$updatedata .=	$this->Model_dashboard->updatedata($setdata,$wheredata,'sms_mail_box');
		}

		if($updatedata != 0){
			$data = array('key_code' => 1,'message'=>'Successfully deleted mails..!');
		}else{
			$data = array('key_code' => 0,'message'=>'Failed to delete mails..!');
		}
		echo json_encode($data);
	}


	public function trashmailsList(){
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id = $data['school_id'] =   $details['school']->school_id;
		$branch_id = $data['branch_id'] =   $details['school']->branch_id;
		$data['userdata'] = $userdata = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Email - Inbox..";
		$data['user_sno']  = $user_sno	=	$userdata->sno;
		$data['user_id']   = $user_id	=	$details['regid'];
		$data['user_type'] = $user_type	=	$details['type'];
		if(isset($userdata->reg_id)){
			$sender_id = $userdata->reg_id;
			$send_from = $userdata->local_mail_id;
		}else{
			$sender_id = $userdata->id_num;
			$send_from = $userdata->local_mail_id;
		}
		$data['mailsents']= $mailsents	=	$this->Model_dashboard->customquery("SELECT * FROM `sms_mail_box` INNER JOIN  `sms_mail_reports` ON sms_mail_reports.id = sms_mail_box.mail_ids AND sms_mail_reports.mail_id = sms_mail_box.mail_id WHERE sms_mail_box.school_id = '$school_id' AND sms_mail_box.branch_id = '$branch_id' AND sms_mail_box.sent_to = '$send_from' AND sms_mail_box.trash_status = 1 AND sms_mail_box.inbox_status = 0");
        $this->loadMailview('mailbox/trashmails_page',$data);
	}


	public function Perment_DeleteSentmails(){
		extract($_REQUEST);
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id  =   $details['school']->school_id;
		$branch_id  =   $details['school']->branch_id;
		$userdata   =   $this->Model_integrate->userdata();
		$data['user_id']   = $user_id	=	$details['regid'];
		$data['user_type'] = $user_type	=	$details['type'];
		//get mail data
		foreach ($delete_inboxdata as $value) {
			$wheredata = 	array('branch_id'=>$branch_id,'school_id'=>$school_id,'id'=>$value);
			$setdata	=	array('status'=>0,'updated'=>date('Y-m-d H:i:s'));
			@$updatedata .=	$this->Model_dashboard->updatedata($setdata,$wheredata,'sms_mail_reports');
		}

		if($updatedata != 0){
			$data = array('key_code' => 1,'message'=>'Successfully deleted permanently..!');
		}else{
			$data = array('key_code' => 0,'message'=>'Failed to delete permanent..!');
		}
		echo json_encode($data);
	}


	public function PermentTrashMails_Delete(){
    	extract($_REQUEST);
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id  =   $details['school']->school_id;
		$branch_id  =   $details['school']->branch_id;
		$userdata   =   $this->Model_integrate->userdata();
		$data['user_id']   = $user_id	=	$details['regid'];
		$data['user_type'] = $user_type	=	$details['type'];
		//get mail data
		foreach ($delete_inboxdata as $value) {
			$wheredata = 	array('branch_id'=>$branch_id,'school_id'=>$school_id,'id'=>$value);
			$setdata	=	array('important_status'=>0,'inbox_status'=>0,'trash_status'=>0,'status'=>0,'updated'=>date('Y-m-d H:i:s'));
			@$updatedata .=	$this->Model_dashboard->updatedata($setdata,$wheredata,'sms_mail_box');
		}

		if($updatedata != 0){
			$data = array('key_code' => 1,'message'=>'Successfully deleted permanently..!');
		}else{
			$data = array('key_code' => 0,'message'=>'Failed to delete permanent..!');
		}
		echo json_encode($data);
	}

	
	public function RestoreTrashMails_Delete(){
		extract($_REQUEST);
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id  =   $details['school']->school_id;
		$branch_id  =   $details['school']->branch_id;
		$userdata   =   $this->Model_integrate->userdata();
		$data['user_id']   = $user_id	=	$details['regid'];
		$data['user_type'] = $user_type	=	$details['type'];
		//get mail data
		foreach ($delete_inboxdata as $value) {
			$wheredata = 	array('branch_id'=>$branch_id,'school_id'=>$school_id,'id'=>$value);
			$setdata	=	array('important_status'=>0,'inbox_status'=>1,'trash_status'=>0,'status'=>1,'updated'=>date('Y-m-d H:i:s'));
			@$updatedata .=	$this->Model_dashboard->updatedata($setdata,$wheredata,'sms_mail_box');
		}

		if($updatedata != 0){
			$data = array('key_code' => 1,'message'=>'Successfully restore mails..!');
		}else{
			$data = array('key_code' => 0,'message'=>'Failed to restore mails..!');
		}
		echo json_encode($data);
	}


	public function importantmailsList(){
		extract($_REQUEST);
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id  =   $details['school']->school_id;
		$branch_id  =   $details['school']->branch_id;
		$userdata   =   $this->Model_integrate->userdata();
		$data['user_id']   = $user_id	=	$details['regid'];
		$data['user_type'] = $user_type	=	$details['type'];
		//get mail data
		foreach ($delete_inboxdata as $value) {
			$wheredata = 	array('branch_id'=>$branch_id,'school_id'=>$school_id,'id'=>$value);
			$setdata	=	array('important_status'=>1,'inbox_status'=>0,'trash_status'=>0,'updated'=>date('Y-m-d H:i:s'));
			@$updatedata 	.=	$this->Model_dashboard->updatedata($setdata,$wheredata,'sms_mail_box');
		}

		if($updatedata != 0){
			$data = array('key_code' => 1,'message'=>'Successfully moved mails..!');
		}else{
			$data = array('key_code' => 0,'message'=>'Failed to move mails..!');
		}
		echo json_encode($data);
	}


	public function importantMails(){
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id = $data['school_id'] =   $details['school']->school_id;
		$branch_id = $data['branch_id'] =   $details['school']->branch_id;
		$data['userdata'] = $userdata = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Important eMails..!";
		$data['user_sno']  = $user_sno	=	$userdata->sno;
		$data['user_id']   = $user_id	=	$details['regid'];
		$data['user_type'] = $user_type	=	$details['type'];
		if(isset($userdata->reg_id)){
			$send_from = $userdata->local_mail_id;
		}else{
			$send_from = $userdata->local_mail_id;
		}
		$data['mailsents']= $mailsents	=	$this->Model_dashboard->customquery("SELECT * FROM `sms_mail_box` INNER JOIN  `sms_mail_reports` ON sms_mail_reports.id = sms_mail_box.mail_ids AND sms_mail_reports.mail_id = sms_mail_box.mail_id WHERE sms_mail_box.school_id = '$school_id' AND sms_mail_box.branch_id = '$branch_id' AND sms_mail_box.sent_to = '$send_from' AND sms_mail_box.trash_status = 0 AND sms_mail_box.inbox_status = 0 AND sms_mail_box.important_status = 1");
		$this->loadMailview('mailbox/Importantmails_page',$data);
	}




	//notifications
	public function mailNotificationscountlist(){
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id  = $data['school_id'] =   $details['school']->school_id;
		$branch_id  = $data['branch_id'] =   $details['school']->branch_id;
		$userdata   = $this->Model_integrate->userdata();
		if(isset($userdata->reg_id)){
			$sender_id = $userdata->reg_id;
			$send_from = $userdata->local_mail_id;
		}else{
			$sender_id = $userdata->id_num;
			$send_from = $userdata->local_mail_id;
		}
		$mailslist	=	$this->Model_dashboard->customquery("SELECT * FROM `sms_mail_box` INNER JOIN  `sms_mail_reports` ON sms_mail_reports.id = sms_mail_box.mail_ids AND sms_mail_reports.mail_id = sms_mail_box.mail_id WHERE sms_mail_box.school_id = '$school_id' AND sms_mail_box.branch_id = '$branch_id' AND sms_mail_box.sent_to = '$send_from' AND sms_mail_box.mail_read = 0 AND sms_mail_box.inbox_status = 1 ORDER BY sms_mail_box.id DESC LIMIT 5");
		if(count($mailslist) != 0) { ?>
			<i class="fa fa-bell"></i>
			<span class="label"><?= count($mailslist); ?></span>
		<?php }else{ ?>
			<i class="fa fa-bell"></i>
			<span class="label">0</span>
		<?php }
	}

	public function mailNotificationslist(){
		$details    =   $this->session->userdata;   // all session data will send to setdetails..
		$school_id  = $data['school_id'] =   $details['school']->school_id;
		$branch_id  = $data['branch_id'] =   $details['school']->branch_id;
		$userdata   = $this->Model_integrate->userdata();
		if(isset($userdata->reg_id)){
			$sender_id = $userdata->reg_id;
			$send_from = $userdata->local_mail_id;
		}else{
			$sender_id = $userdata->id_num;
			$send_from = $userdata->local_mail_id;
		}
		$mailslist	=	$this->Model_dashboard->customquery("SELECT * FROM `sms_mail_box` INNER JOIN  `sms_mail_reports` ON sms_mail_reports.id = sms_mail_box.mail_ids AND sms_mail_reports.mail_id = sms_mail_box.mail_id WHERE sms_mail_box.school_id = '$school_id' AND sms_mail_box.branch_id = '$branch_id' AND sms_mail_box.sent_to = '$send_from' AND sms_mail_box.mail_read = 0 AND sms_mail_box.inbox_status = 1 ORDER BY sms_mail_box.id DESC LIMIT 5");
		if(count($mailslist) != 0) { ?>
			<link href="<?=base_url()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
			<script src="<?=base_url()?>assets/plugins/gritter/js/jquery.gritter.js"></script>
			<li class="dropdown-header">NOTIFICATIONS (<?= count($mailslist); ?>)</li>
			<?php foreach ($mailslist as $value){ ?>
				<li class="media">
					<a href="<?=base_url('user/mail/details/'.$value->mail_ids.'/'.$value->branch_id.'/'.$value->school_id.'/sent-mail?id='.$value->mail_id.'&inbox_id='.$value->id)?>">
						<div class="media-left">
							<i class="fa fa-envelope media-object bg-silver-darker"></i>
							<!--<i class="fab fa-google text-warning media-object-icon f-s-14"></i>-->
						</div>
						<div class="media-body">
							<p class="media-heading text-justify"><?=$value->subject?></p>
							<p class="media-messaging"></p>
							<div class="text-muted f-s-11">
								<?php
									$datetime = $this->Model_integrate->daysago(date('Y-m-d H:i:s',strtotime($value->send_date)));
									echo $datetime;
								?>
							</div>
						</div>
					</a>
				</li>
				<script>
					/*$.gritter.add({
						image: 'https://upload.wikimedia.org/wikipedia/commons/5/52/Mail_iOS.svg',
						title: '<?//=$value->subject?>',
						text: 'mail @ <?//=$datetime?>',
						sticky:false,
						time:'',
						//fade_in_speed: 100,
						//fade_out_speed: 100,
						class_name:"my-sticky-class",
					}); */
				</script>
			<?php } ?>
			<li class="dropdown-footer text-center pb-2 pr-5 pl-5">
				<a href="<?=base_url('user/mail/inbox')?>" class="text-success font-weight-bold">view inbox</a>
			</li>
		<?php }else{ ?>
			<li class="dropdown-header">NOTIFICATIONS (<?= count($mailslist); ?>)</li>
			<li class="dropdown-footer text-center pb-3 pr-5 pl-5">
				<a href="<?=base_url('user/mail/inbox')?>" class="text-warning font-weight-bold">Notifications Found..!</a>
			</li>
		<?php }
	}
}
