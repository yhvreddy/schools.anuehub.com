<!-- Container fluid  -->
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="javascript:;">Branchs</a></li>
		<li class="breadcrumb-item active">Branch Details</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Branch Details<small></small></h1>
	<!-- end page-header -->
	<!-- Start Page Content -->
	<div class="row justify-content-center align-items-center">
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

			<div class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Branch Details</h4>
				</div>
				<div class="panel-body">

					<?php if(count($regusers) != 0){ ?>
						<?php
						$regusers = $regusers['0'];
						$schoolinfo = $schoolinfo['0'];
						?>
						<div class="row">
							<h4 class="col-12 text-success">Register user Details</h4>
							<div class="col-md-12">
								<div class="row" style="margin: 0px 10px;">
									<div class="col-md-3 form-group">
										<label class="font-weight-bold text-info">Register id : </label>
										<span><?= $regusers->reg_id?></span>
									</div>
									<div class="col-md-3 form-group">
										<div class="row">
											<div class="col-4">
												<label class="font-weight-bold text-info">Type : </label>
												<span><?= $regusers->scl_mode?></span>
											</div>
											<?php if($regusers->gbsid != ''){ ?>
												<div class="col-8">
													<label class="font-weight-bold text-info">Branch Of  : </label>
													<span><?= $regusers->gbsid?></span>
												</div>
											<?php } ?>
										</div>
									</div>
									<div class="col-md-3 form-group">
										<label class="font-weight-bold text-info">First Name : </label>
										<span><?= $regusers->fname?></span>
									</div>
									<div class="col-md-3 form-group">
										<label class="font-weight-bold text-info">Last Name : </label>
										<span><?= $regusers->lname?></span>
									</div>
									<div class="col-md-3 form-group">
										<label class="font-weight-bold text-info">Reg Mail : </label>
										<span><?= $regusers->mailid?></span>
									</div>
									<div class="col-md-3 form-group">
										<label class="font-weight-bold text-info">Reg Mobile : </label>
										<span><?= $regusers->mobile?></span>
									</div>
									<div class="col-md-3 form-group">
										<label class="font-weight-bold text-info">Country : </label>
										<span><?php $country = $this->Model_dashboard->selectdata('sms_countries',array('id'=>$regusers->country_id)); echo $country['0']->name; ?></span>
									</div>
									<div class="col-md-3 form-group">
										<label class="font-weight-bold text-info">State : </label>
										<span><?php $state = $this->Model_dashboard->selectdata('sms_states',array('id'=>$regusers->state_id)); echo $state['0']->name; ?></span>
									</div>
									<div class="col-md-3 form-group">
										<label class="font-weight-bold text-info">City or Dist : </label>
										<span><?php $citydist = $this->Model_dashboard->selectdata('sms_cities',array('id'=>$regusers->city_id)); echo $citydist['0']->name; ?></span>
									</div>
									<div class="col-md-4 form-group">
										<label class="font-weight-bold text-info">Address : </label>
										<span><?= $regusers->address?></span>
									</div>
									<div class="col-md-3 form-group">
										<label class="font-weight-bold text-info">Pincode : </label>
										<span><?= $regusers->pincode?></span>
									</div>
									<div class="col-md-3 form-group">
										<label class="font-weight-bold text-info">Aadhaar No : </label>
										<span><?= $regusers->aadhaar?></span>
									</div>
								</div>
							</div>
						</div>
						<?php if(empty($schoolinfo) or $schoolinfo == ""){ ?>
							<div class="row">
								<h3 class="col-12 text-center">No Data Found (or) School Details Are Not Entered.</h3>
							</div>
						<?php }else{ ?>
							<div class="row"><h4 class="col-12 text-success">School Details</h4></div>
							<div class="row" style="margin: 0px 10px;">
								<div class="col-md-3 form-group">
									<label class="font-weight-bold text-info">Register id : </label>
									<span><?= $schoolinfo->reg_id?></span>
								</div>
								<div class="col-md-3 form-group">
									<label class="font-weight-bold text-info">School id : </label>
									<span><?= $schoolinfo->school_id?></span>
								</div>
								<?php if($schoolinfo->scltype == 'GSB'){ ?>
								<div class="col-md-3 form-group">
									<label class="font-weight-bold text-info">Branch id : </label>
									<span><?= $schoolinfo->branch_id?></span>
								</div>
								<?php } ?>

								<div class="col-md-3 form-group">
									<label class="font-weight-bold text-info">Type : </label>
									<span><?= $schoolinfo->scltype?></span>
								</div>
								<div class="col-md-3 form-group">
									<label class="font-weight-bold text-info">School : </label>
									<span><?= $schoolinfo->schoolname?></span>
								</div>
								<?php if($schoolinfo->scltype == 'GSB'){ ?>
									<div class="col-md-3 form-group">
										<label class="font-weight-bold text-info">Branch : </label>
										<span><?= $schoolinfo->branchname?></span>
									</div>
								<?php }  ?>
								<div class="col-md-4 form-group">
									<label class="font-weight-bold text-info">Mail Id : </label>
									<span><?= $schoolinfo->school_mail?></span>
								</div>
								<div class="col-md-3 form-group">
									<label class="font-weight-bold text-info">Mobile : </label>
									<span><?= $schoolinfo->school_mobile?></span>
								</div>
								<div class="col-md-3 form-group">
									<label class="font-weight-bold text-info">Alter Number : </label>
									<span><?= $schoolinfo->school_phone?></span>
								</div>
								<div class="col-md-3 form-group">
									<label class="font-weight-bold text-info">Country : </label>
									<span><?php $country = $this->Model_dashboard->selectdata('sms_countries',array('id'=>$schoolinfo->country_id)); echo $country['0']->name; ?></span>
								</div>
								<div class="col-md-3 form-group">
									<label class="font-weight-bold text-info">State : </label>
									<span><?php $state = $this->Model_dashboard->selectdata('sms_states',array('id'=>$schoolinfo->state_id)); echo $state['0']->name; ?></span>
								</div>
								<div class="col-md-3 form-group">
									<label class="font-weight-bold text-info">City or Dist : </label>
									<span><?php $citydist = $this->Model_dashboard->selectdata('sms_cities',array('id'=>$schoolinfo->city_id)); echo $citydist['0']->name; ?></span>
								</div>
								<div class="col-md-6 form-group">
									<label class="font-weight-bold text-info">Address : </label>
									<span><?= $schoolinfo->school_address?></span>
								</div>
								<div class="col-md-3 form-group">
									<label class="font-weight-bold text-info">Pincode : </label>
									<span><?= $schoolinfo->school_pincode?></span>
								</div>
								<div class="col-md-3 form-group">
									<label class="font-weight-bold text-info">Govt Reg id : </label>
									<span><?= $schoolinfo->school_tinnumber?></span>
								</div>
							</div>
						<?php } ?>
					<?php }else{ ?>
						<?= $this->Model_dashboard->norecords(); ?>
					<?php } ?>

				</div>
			</div>

		</div>

	</div>
	<!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
