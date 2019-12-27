<link href="<?=base_url()?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="<?=base_url()?>assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
<style>
	.compose_footer{
		padding: 10px 0px;
		margin-top: 5px;
		border-bottom: 2px solid #c9ccce;
		border-top: 2px solid #c9ccce;
	}
	div.tagsinput span.tag {
		border: 1px solid #c5c5c5;
		-moz-border-radius: 2px;
		-webkit-border-radius: 2px;
		display: block;
		float: left;
		padding: 0px 5px 0px 2px;
		text-decoration: none;
		background: #ffffff;
		color: #000000;
		margin-right: 5px;
		margin-bottom: 5px;
		font-family: helvetica;
		font-size: 13px;
	}
	#tags_1_tagsinput{
		width: auto;
		min-height: 35px !important;
		height: 35px !important;
		border: none;
		border-bottom: 1px solid #d8d8d8;
		border-radius: 0px;
		padding: 2px 0px 6px 8px;
	}
	div.tagsinput span.tag a {
		font-weight: 700;
		color: #82ad2b;
		text-decoration: none;
		font-size: 12px;
	}
	div.tagsinput span.tag {
		border: 1px solid #c5c5c5;
		-moz-border-radius: 2px;
		-webkit-border-radius: 2px;
		display: block;
		float: left;
		padding: 0px 5px 0px 2px;
		text-decoration: none;
		background: #ffffff;
		color: #000000;
		margin-right: 5px;
		margin-bottom: 5px;
		font-family: helvetica;
		font-size: 12px;
		padding: 2px 8px;
	}
</style>
<!-- begin #content -->
<div id="content" class="content content-full-width inbox">
	<!-- begin vertical-box -->
	<div class="vertical-box with-grid">
		<!-- begin vertical-box-column -->
		<div class="vertical-box-column bg-white">
			<!-- begin vertical-box -->
			<div class="vertical-box">
				<!-- begin wrapper -->
			   <?php $mail = $maildetails[0]; ?>
				<div class="wrapper bg-silver">
					<span class="btn-group m-r-5">
						<h4>Reply : <?=$mail->subject?> </h4>
					</span>
					<span class="pull-right">
						<a href="<?=base_url('user/mail/inbox')?>" class="btn btn-white btn-sm"><i class="fa fa-times f-s-14 m-r-3 m-r-xs-0 t-plus-1"></i> <span class="hidden-xs">Back to inbox</span></a>
					</span>
				</div>
				<!-- end wrapper -->

				<!-- begin vertical-box-row -->
				<div class="vertical-box-row bg-white">
					<!-- begin vertical-box-cell -->
					<div class="vertical-box-cell">
						<!-- begin vertical-box-inner-cell -->
						<div class="vertical-box-inner-cell">
							<!-- begin scrollbar -->
							<div data-scrollbar="true" data-height="100%" class="p-15">
								<!-- begin email form -->
								<form action="<?=base_url('user/mail/savereplymaildata')?>" method="POST" enctype="multipart/form-data" name="email_to_form">


									<input type="hidden" value="<?=$mail_id?>" name="mail_regid">
									<input type="hidden" value="<?=$mid?>" name="primary_mid">
									<input type="hidden" value="<?=$branch_id?>" name="branch_id">
									<input type="hidden" value="<?=$school_id?>" name="school_id">
									<input type="hidden" value="<?=$reply_by?>" name="reply_by">
									<input type="hidden" value="<?=$reply_idnum?>" name="reply_idnum">

									
									<!-- begin email to -->
									<div class="email-to form-group">
										<!--<span class="float-right-link">
												<a href="#" data-click="add-cc" data-name="Cc" class="m-r-5">Cc</a>
												<a href="#" data-click="add-cc" data-name="Bcc">Bcc</a>
											</span>-->
										<?php

											if(isset($userdata->reg_id)){
												$current_id = 	$userdata->reg_id;
												$mail_id	=	$userdata->mailid;
											}else{
												$mail_id	=	$userdata->mail_id;
												$current_id	=	$userdata->id_num;
											}

											if($mail->sender_id == $current_id){
												$replyids = $mail->send_to;
											}else{
												$replyids = $mail->send_from;
											}
										?>
										<input type="hidden" value="<?=$mail_id?>" name="sender_mail">
										<input type="text" id="tags_1" required="required" class="form-control" value="<?=$replyids?>" name="mail_to">
									</div>

									<!--<input class="form-control" id="tags_1" name="mail_to[]">-->
									<!-- end email to -->

									<div data-id="extra-cc"></div>

									<!-- begin email subject -->
									<div class="email-subject">
										<input type="text" class="form-control form-control-lg" placeholder="Subject" name="mail_subject" />
									</div>
									<!-- end email subject -->
									<!-- begin email content -->
									<div class="email-content p-t-15">
										<textarea class="textarea form-control" id="ckeditor" placeholder="Enter text ..." name="mailcontent" rows="20"></textarea>
									</div>
									<script>
										// Replace the <textarea id="editor1"> with a CKEditor
										// instance, using default configuration.
										//customConfig: '';
										//CKEDITOR.replace( 'notice_content' );
										CKEDITOR.replace( 'mailcontent', {
											customConfig: 'custom/mailbox.js',
											width: '100%',
											height: 250
										});
									</script>
									<!-- end email content -->
									<!-- begin wrapper -->
									<div class="col-md-12 compose_footer">
											<span class="btn-group m-r-5">
												<input type="file" class="dropify" name="upload_attachments[]" multiple accept=".jpg,.jpeg,.png,.zip,.doc,.docx,.xlsx,.rar" data-max-file-size="25M">
											</span>
										<!--<span class="dropdown">
                                            <a href="javascript:;" class="btn btn-white btn-sm" data-toggle="dropdown"><i class="fa fa-ellipsis-h f-s-14 t-plus-1"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-left">
                                                <li><a href="javascript:;">Save draft</a></li>
                                                <li><a href="javascript:;">Show From</a></li>
                                                <li><a href="javascript:;">Check names</a></li>
                                                <li><a href="javascript:;">Switch to plain text</a></li>
                                                <li><a href="javascript:;">Check for accessibility issues</a></li>
                                            </ul>
                                        </span>-->
										<span class="pull-right">
											<!--<button type="submit" name="draft_box" class="btn btn-white p-l-40 p-r-40 m-r-5">Discard</button>-->
											<button type="submit" class="btn btn-primary p-l-40 p-r-40"><i class="far fa-envelope"></i> Reply Mail</button>
										</span>
									</div>
									<!-- end wrapper -->
								</form>
								<!-- end email form -->
							</div>
							<!-- end scrollbar -->
						</div>
						<!-- end vertical-box-inner-cell -->
					</div>
					<!-- end vertical-box-cell -->
				</div>
				<!-- end vertical-box-row -->

			</div>
			<!-- end vertical-box -->
		</div>
		<!-- end vertical-box-column -->
	</div>
	<!-- end vertical-box -->
</div>
<!-- end #content -->
<script src="<?=base_url()?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>
<script src="<?=base_url()?>assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
<script src="<?=base_url()?>assets/js/demo/form-plugins.demo.min.js"></script>
<script>
	$(document).ready(function() {
		App.init();
		EmailCompose.init();
		FormPlugins.init();
		/*$("#email-to").tagit("assignedTags");
		$("#email-to").tagit({
			beforeTagAdded: function(event, ui) {
				// do something special
				console.log(ui.tag);
			},
			beforeTagRemoved: function(event, ui) {
				// do something special
				console.log(ui.tag);
			}
		});
		$("#email-to").data("ui-tagit").tagInput.addClass("to_maildata");*/
	});
</script>
<script>
	function onAddTag(tag) {
		alert("Added a tag: " + tag);
	}
	function onRemoveTag(tag) {
		alert("Removed a tag: " + tag);
	}

	function onChangeTag(input,tag) {
		alert("Changed a tag: " + tag);
	}

	$(function() {

		$('#tags_1').tagsInput({
			// 'autocomplete_url': url_to_autocomplete_api,
			// 'autocomplete': { option: value, option: value},
			'height':'35px',
			'width':'auto',
			//'interactive':true,
			'defaultText':'Reply To',
			// 'onAddTag':callback_function,
			// 'onRemoveTag':callback_function,
			// 'onChange' : callback_function,
			// 'delimiter': [',',';'],   // Or a string with a single delimiter. Ex: ';'
			// 'removeWithBackspace' : true,
			// 'minChars' : 0,
			// 'maxChars' : 0, // if not provided there is no limit
			'placeholderColor' : '#666666'
		});
		$('#tags_2').tagsInput({
			width: 'auto',
			onChange: function(elem, elem_tags)
			{
				var languages = ['php','ruby','javascript'];
				$('.tag', elem_tags).each(function()
				{
					if($(this).text().search(new RegExp('\\b(' + languages.join('|') + ')\\b')) >= 0)
						$(this).css('background-color', 'yellow');
				});
			}
		});
		$('#tags_3').tagsInput({
			width: 'auto',

			//autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
			autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
		});


// Uncomment this line to see the callback functions in action
//			$('input.tags').tagsInput({onAddTag:onAddTag,onRemoveTag:onRemoveTag,onChange: onChangeTag});

// Uncomment this line to see an input with no interface for adding new tags.
//			$('input.tags').tagsInput({interactive:false});
	});
</script>
