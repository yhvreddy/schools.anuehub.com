<!-- begin #content -->
<div id="content" class="content content-full-width inbox">
	<!-- begin vertical-box -->
	<div class="vertical-box with-grid">
		<!-- begin vertical-box-column -->
		<div class="vertical-box-column bg-white">
			<?php $maildetails = $maildetails[0]; //echo "<pre>"; print_r($maildetails); echo "</pre>";?>
			<!-- begin vertical-box -->
			<div class="vertical-box">
				<!-- begin wrapper -->
				<div class="wrapper bg-silver-lighter clearfix">
					<div class="pull-left">
						<div class="btn-group m-r-5">
							   <h4>Mail Details</h4>
						</div>
						<div class="btn-group m-r-5 hide">
							<a href="javascript:;" class="btn btn-white btn-sm"><i class="fa fa-trash f-s-14 m-r-3 m-r-xs-0 t-plus-1"></i> <span class="hidden-xs">Delete</span></a>
							<a href="javascript:;" class="btn btn-white btn-sm"><i class="fa fa-archive f-s-14 m-r-3 m-r-xs-0 t-plus-1"></i> <span class="hidden-xs">Archive</span></a>
						</div>
					</div>
					<?php 
						if(isset($userdata->id_num)){
							$replay_by = $userdata->id_num;
						}else if(isset($userdata->reg_id)){
							$replay_by = $userdata->reg_id;
						}
					?>
					<div class="pull-right">
						<div class="btn-group">
							<!--<a href="email_inbox.html" class="btn btn-white btn-sm disabled"><i class="fa fa-arrow-up f-s-14 t-plus-1"></i></a>
							<a href="email_inbox.html" class="btn btn-white btn-sm"><i class="fa fa-arrow-down f-s-14 t-plus-1"></i></a>-->
							<a href="<?=base_url('user/mail/reply/'.$maildetails->id.'/'.$maildetails->branch_id.'/'.$maildetails->school_id.'/'.$userdata->sno.'/'.$replay_by.'?id='.$maildetails->mail_id)?>" class="btn btn-white btn-sm"><i class="fa fa-reply f-s-14 m-r-3 m-r-xs-0 t-plus-1"></i> <span class="hidden-xs">Reply</span></a>

							<a href="<?=base_url('user/mail/inbox')?>" class="btn btn-white btn-sm"><i class="fas fa-envelope-open f-s-14 t-plus-1"></i> <span class="hidden-xs">Back to Inbox</span></a>
						</div>
						<div class="btn-group m-l-5">
							
						</div>
					</div>
				</div>
				<!-- end wrapper -->
				<!-- begin vertical-box-row -->
				<div class="vertical-box-row">
					<?php
						$extractdata = explode(' + ',$maildetails->information);
						$id   = $extractdata[0];
						$type = $extractdata[1];
						if($type == 'admin' || $type == 'superadmin'){
							$userdata = $this->Model_dashboard->selectdata('sms_regusers',array('sno'=>$id,'reg_id'=>$maildetails->sender_id),'sno');
							$person = $userdata[0];
							$from = 'admin';
							$name = $person->fname;
						}else if($type == 'student'){
							$userdata = $this->Model_dashboard->selectdata('sms_admissions',array('branch_id'=>$maildetails->branch_id,'school_id'=>$maildetails->school_id,'sno'=>$id),'sno');
							$person = $userdata[0];
							$from = 'student';
							$name = $person->firstname;
						}else if($type != 'student' || $type != 'admin' || $type != 'superadmin'){
							$userdata = $this->Model_dashboard->selectdata('sms_employee',array('branch_id'=>$maildetails->branch_id,'school_id'=>$maildetails->school_id,'sno'=>$id),'sno');
							$person = $userdata[0];
							$from = 'staff';
							$name = $person->firstname;
						}


						if(isset($person->profile_pic)){ $profile_image = $person->profile_pic; }else if(isset($person->student_image)){ $profile_image = $person->student_image; }elseif(isset($person->employee_pic)){ $profile_image = $person->employee_pic; }

						if(isset($person->fname)){ $fname = $person->fname;$lname = $person->lname; }else{ $fname = $person->firstname;$lname = $person->lastname; }
					?>
					<!-- begin vertical-box-cell -->
					<div class="vertical-box-cell">
						<!-- begin vertical-box-inner-cell -->
						<div class="vertical-box-inner-cell">
							<!-- begin scrollbar -->
							<div data-scrollbar="true" data-height="100%">
								<!-- begin wrapper -->
								<div class="wrapper">
									<h3 class="m-t-0 m-b-15 f-w-500"><?=$maildetails->subject?></h3>
									<ul class="media-list underline m-b-15 p-b-15">
										<li class="media media-sm clearfix">
											<a href="javascript:;" class="pull-left">
												<script>
													$(document).ready(function(){
														var PfirstName = '<?=$fname?>';
														var PlastName = '<?=$lname?>';
														var intials = PfirstName.charAt(0) + PlastName.charAt(0);
														var PprofileImage = $('#profileDetailsview<?=$maildetails->id?>').text(intials);
													});
												</script>
												<?php if(!empty($profile_image)){ ?>
													<img src="<?=base_url($profile_image)?>" class="media-object rounded-corner">
												<?php }else{ ?>
													<span id="profileDetailsview<?=$maildetails->id?>" class="profileDetailsview text-uppercase" style="background: #e5e5e5;padding: 20px 18px;font-size: 24px;border-radius: 25px;"></span>
												<?php } ?>
											</a>
											<div class="media-body">
												<div class="email-from text-inverse f-s-14 f-w-600 m-b-3">
													from <?=$maildetails->send_from?>
												</div>
												<div class="m-b-3"><i class="fa fa-clock fa-fw"></i>
													<?php
														$date = date('d-m-Y',strtotime($maildetails->send_date));
														if(date('d-m-Y') === $date){
															echo 'Today';
														}else{
															echo $date;
														}
													?>, <?= date('H:i a',strtotime($maildetails->send_date)) ?></div>
												<div class="email-to">
													To: <?php
														$mailslist = explode(',',$maildetails->send_to);
														foreach ($mailslist as $mails){
															echo "<label class='label label-info pb-1' style='padding: 2px 5px 2px 5px;'>".$mails."</label> ";
														}
													?>
												</div>
											</div>
										</li>
									</ul>

									<div class="text-inverse mb-5 text-justify">
										<?=$maildetails->content?>
									</div>

									<?php if(!empty($maildetails->attachments)){ $data = explode(',',$maildetails->attachments); ?>
										<ul class="attached-document clearfix">
											<?php
											foreach ($data as $key => $attachment){

												$names = explode('/'.$maildetails->mail_id.'/',$attachment);
												$name = $names[1];
												$array = explode(".", $attachment);
												$extension = end($array);
												$this->Model_integrate->attachedfiles($attachment,$extension,$name);

											}
											?>
										</ul>
									<?php } ?>
									
								</div>
								<!-- end wrapper -->
							</div>
							<!-- end scrollbar -->
						</div>
						<!-- end vertical-box-inner-cell -->
					</div>
					<!-- end vertical-box-cell -->
				</div>
				<!-- end vertical-box-row -->
				<!-- begin wrapper -->
				<!--<div class="wrapper bg-silver-lighter text-right clearfix">
					<div class="btn-group">
						<a href="email_inbox.html" class="btn btn-white btn-sm disabled"><i class="fa fa-arrow-up"></i></a>
						<a href="email_inbox.html" class="btn btn-white btn-sm"><i class="fa fa-arrow-down"></i></a>
					</div>
				</div>-->
				<!-- end wrapper -->
			</div>
			<!-- end vertical-box -->
		</div>
		<!-- end vertical-box-column -->
	</div>
	<!-- end vertical-box -->
</div>
<!-- end #content -->
<script>
	$(document).ready(function() {
		App.init();
	});
</script>
