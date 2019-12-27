<!-- begin #content -->
<script>
	$(document).ready(function(){
		$("#deleteinboxmails,#ImportantInboxMails").hide();
		// add multiple select / deselect functionality
		$("#SelectAllInboxMails").click(function () {

			if($(this).prop("checked")) {
				$("#Clickallinfo").hide();
				$(".SelectInboxMails").prop("checked", true);
				$("#deleteinboxmails,#ImportantInboxMails").show();
			} else {
				$("#Clickallinfo").show();
				$(".SelectInboxMails").prop("checked", false);
				$("#deleteinboxmails,#ImportantInboxMails").hide();
			}

		});

		var checkedInboxmails = $(".SelectInboxMails:checked").length;
		if(checkedInboxmails == 0){
			$(".SelectInboxMails").prop("checked", false);
			$("#SelectAllInboxMails").prop('checked', false);
			$("#deleteinboxmails,#ImportantInboxMails").hide();
			$("#Clickallinfo").show();
		}

		$(".SelectInboxMails").click(function(){

			if($(this).is(':checked')){
				$(this).closest('li').addClass('RemoveInboxrow');
				$(this).closest('li').addClass('ImportantInboxrow');
			}else{
				$(this).closest('li').removeClass('RemoveInboxrow');
				$(this).closest('li').removeClass('ImportantInboxrow');
			}

			if($(".SelectInboxMails").length == $(".SelectInboxMails:checked").length){
				//$("#SelectAllInboxMails").attr("checked", "checked");
				$("#SelectAllInboxMails").prop('checked', true);
				$("#deleteinboxmails,#ImportantInboxMails").show();
				$("#Clickallinfo").hide();
			}else{
				$("#Clickallinfo").hide();
				$("#SelectAllInboxMails").prop('checked', false);
				$("#deleteinboxmails,#ImportantInboxMails").show();
			}

			if($(".SelectInboxMails:checked").length == 0){
				$(".SelectInboxMails").prop("checked", false);
				$("#SelectAllInboxMails").prop('checked', false);
				$("#deleteinboxmails,#ImportantInboxMails").hide();
				$("#Clickallinfo").show();
			}

		});
	});
</script>
<div id="content" class="content content-full-width inbox">

	<!-- begin vertical-box -->
	<div class="vertical-box with-grid">
		<!-- begin vertical-box-column -->
		<div class="vertical-box-column bg-white">
			<!-- begin vertical-box -->
			<div class="vertical-box">
				<?php //echo "<pre>"; print_r($mailsents); echo "</pre>";?>
				<?php if(count($mailsents) > 0){ ?>
					<!-- begin wrapper -->
					<div class="wrapper bg-silver-lighter">
						<!-- begin btn-toolbar -->
						<?php //print_r($userdata); ?>
						<div class="btn-toolbar">
							<div class="btn-group mr-3" style="margin-left: 10px !important;">
								<div class="checkbox checkbox-css">
									<input type="checkbox" id="SelectAllInboxMails" />
									<label for="SelectAllInboxMails"></label>
								</div>
							</div>
							<div class="btn-group mr-3" id="Clickallinfo">
								<label class="text-black-darker" style="margin-top: 6px !important;margin-bottom: 0px;"><i class="fa fa-hand-point-left fa-dx"></i> Click to select all</label>
							</div>
							<!-- begin btn-group -->
							<!--<div class="btn-group dropdown m-r-5">
								<button class="btn btn-white btn-sm" data-toggle="dropdown">
									View All <span class="caret m-l-3"></span>
								</button>
								<ul class="dropdown-menu text-left text-sm">
									<li class="active"><a href="javascript:;"><i class="fa fa-circle f-s-10 fa-fw m-r-5"></i> All</a></li>
									<li><a href="javascript:;"><i class="fa fa-circle f-s-10 fa-fw m-r-5"></i> Read</a></li>
									<li><a href="javascript:;"><i class="fa fa-circle f-s-10 fa-fw m-r-5"></i> Unread</a></li>
								</ul>
							</div>-->
							<!-- end btn-group -->
							<!-- begin btn-group -->
							<!--<div class="btn-group m-r-5">
								<button class="btn btn-sm btn-white"><i class="fa fa-redo f-s-14 t-plus-1"></i></button>
							</div>-->
							<!-- end btn-group -->
							<!-- begin btn-group -->
							<div class="btn-group">
								<button class="btn btn-sm btn-white" id="deleteinboxmails" data-email-action="delete"><i class="fa t-plus-1 fa-trash f-s-14 m-r-3"></i> <span class="hidden-xs">Delete</span></button>
								<button class="btn btn-sm btn-white" id="ImportantInboxMails" data-email-action="important"><i class="fa t-plus-1 fa-flag f-s-14 m-r-3"></i> <span class="hidden-xs">Move to Inbox</span></button>
							</div>
							<!-- end btn-group -->
							<!-- begin btn-group -->
							<div class="btn-group ml-auto">
								<label class="mb-0" style="font-size: 18px;"><i class="fa fa-envelope-open"></i> Important Mails</label>
							</div>
							<!-- end btn-group -->
						</div>
						<!-- end btn-toolbar -->
					</div>
					<!-- end wrapper -->
					<!-- begin vertical-box-row -->
					<div class="vertical-box-row">
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
													<a href="<?=base_url('user/mail/details/'.$mailsent->mail_ids.'/'.$mailsent->branch_id.'/'.$mailsent->school_id.'/sent-mail?id='.$mailsent->mail_id.'&inbox_id='.$mailsent->id)?>">
														<span class="email-time">
															<?php
																$datetime = $this->Model_integrate->daysago(date('Y-m-d H:i:s',strtotime($mailsent->send_date)));
																echo $datetime;
															?>
														</span>
														<span class="email-sender" style="margin-top: 2px;">
															<span class="pull-left"><?=$name?></span>
															<span class="pull-right importanticon">
																<label class="label label-success" style="font-size: xx-small;"> <i class="fa fa-flag"></i> Important</label>
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
																$("#Clickallinfo").show();
																$("#deleteinboxmails,#ImportantInboxMails").hide();
																$('.RemoveInboxrow').fadeOut(800);
															}else{
																$("#Clickallinfo").show();
																$("#deleteinboxmails,#ImportantInboxMails").hide();
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
														url:"<?= base_url('user/mail/trash/restoredeletemails'); ?>",
														method:"POST",
														data:{delete_inboxdata:checkedInboxvalues,request_type:'important'},
														dataType:'json',
														success:function(inboxresponcedata)
														{
															console.log(inboxresponcedata);
															if(inboxresponcedata.key_code == 1){
																$("#SelectAllInboxMails").prop('checked', false);
																$("#Clickallinfo").show();
																$("#deleteinboxmails,#ImportantInboxMails").hide();
																$('.ImportantInboxrow').fadeOut(800);
															}else{
																$("#Clickallinfo").show();
																$("#deleteinboxmails,#ImportantInboxMails").hide();
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
					</div>
					<!-- end vertical-box-row -->
					<!-- begin wrapper -->
					<div class="wrapper bg-silver-lighter clearfix">
						<div class="btn-group pull-right">
							<button class="btn btn-white btn-sm">
								<i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
							</button>
							<button class="btn btn-white btn-sm">
								<i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
							</button>
						</div>
						<div class="m-t-5 text-inverse f-w-600">1,232 messages</div>
					</div>
					<!-- end wrapper -->
				<?php }else{ ?>
					<div class="col-md-12 mt-5">
						<?= $this->Model_dashboard->norecords(); ?>
					</div>
				<?php } ?>
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
		InboxV2.init();
	});
</script>
