<?php $url = $this->uri->uri_string(); $two = $this->uri->segment(2); ?>
<div class="vertical-box-column width-200 bg-silver hidden-xs">
	<!-- begin vertical-box -->
	<div class="vertical-box">
		<!-- begin wrapper -->
		<div class="wrapper bg-silver text-center">
			<a href="<?=base_url('user/mail/composemail')?>" class="btn btn-inverse p-l-40 p-r-40 btn-sm">
				Compose
			</a>
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
						<!-- begin wrapper -->
						<div class="wrapper p-0">
							<div class="nav-title"><b>FOLDERS</b></div>

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
	</div>
	<!-- end vertical-box -->
</div>

<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
	<!-- begin sidebar scrollbar -->
	<div data-scrollbar="true" data-height="100%">

		<!-- begin sidebar nav -->
		<ul class="nav nav-inbox">
			<li class="nav-header"><b>Mailbox</b></li>
			<li <?php if($url == 'user/mail/composemail'){?>class="active"<?php } ?>><a href="<?=base_url('user/mail/composemail')?>"><i class="fa fa-envelope-open fa-fw m-r-5"></i> Compose Mail</a></li>
			<li <?php if($url == 'user/mail/inbox'){?>class="active"<?php } ?>><a href="<?=base_url('user/mail/inbox')?>"><i class="fa fa-inbox fa-fw m-r-5"></i> Inbox <span class="hide badge pull-right">52</span></a></li>
			<li <?php if($url == 'user/mail/important'){?>class="active"<?php } ?>><a href="<?=base_url('user/mail/important')?>"><i class="fa fa-flag fa-fw m-r-5"></i> Important</a></li>
			<li <?php if($url == 'user/mail/sent'){?>class="active"<?php } ?>><a href="<?=base_url('user/mail/sent')?>"><i class="fa fa-envelope fa-fw m-r-5"></i> Sent</a></li>
			<!--<li><a href="<?php //echo base_url('user/mail/draft'); ?>"><i class="fa fa-pencil-alt fa-fw m-r-5"></i> Drafts</a></li>-->
			<li <?php if($url == 'user/mail/trash'){?>class="active"<?php } ?>><a href="<?=base_url('user/mail/trash')?>"><i class="fa fa-trash fa-fw m-r-5"></i> Trash</a></li>
		</ul>

		<!--<ul class="nav nav-inbox">
			<li class="nav-header"><b>LABEL</b></li>
			<li><a href="javascript:;"><i class="fa fa-fw f-s-10 m-r-5 fa-circle text-white"></i> Admin</a></li>
			<li><a href="javascript:;"><i class="fa fa-fw f-s-10 m-r-5 fa-circle text-primary"></i> Designer & Employer</a></li>
			<li><a href="javascript:;"><i class="fa fa-fw f-s-10 m-r-5 fa-circle text-success"></i> Staff</a></li>
			<li><a href="javascript:;"><i class="fa fa-fw f-s-10 m-r-5 fa-circle text-warning"></i> Sponsorer</a></li>
			<li><a href="javascript:;"><i class="fa fa-fw f-s-10 m-r-5 fa-circle text-danger"></i> Client</a></li>
		</ul>-->
		<!-- end sidebar nav -->
	</div>
	<!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->
