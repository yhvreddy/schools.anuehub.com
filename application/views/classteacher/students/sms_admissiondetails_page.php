<!-- Container fluid  -->
<?php $schooldata = $this->session->userdata['school']; ?>
<style>
	table.table-bordered.dataTable tbody td {
		line-height: 28px;
	}
</style>
<div id="content" class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item active">Student Details</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Student Details<small></small></h1>
	<!-- end page-header -->
	<!-- Start Page Content -->
	<div class="row">
		<div class="col-12">
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<a href="<?=base_url('classteacher/studentslist')?>" class="pull-right btn btn-success btn-xs"><i class="fa fa-list"></i> Students list</a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					</div>
					<h4 class="panel-title">Student details</h4>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<?php $stdinfo = $admissiondetails[0]; ?>
						<h4 class="text-capitalize text-success">STUDENT DETAILS</h4>
						<div class="row">
							<div class="<?php if($stdinfo->student_image == ''){ ?> col-md-12 <?php }else{ ?> col-md-10 <?php } ?>">
								<div class="row">
									<div class="col-md-4">
										<span><label class="font-bold">Reg id :</label> <?php echo $stdinfo->id_num; ?></span>
									</div>
									<div class="col-md-4">
										<span><label class="font-bold">First Name : </label> <?php echo $stdinfo->firstname; ?></span>
									</div>
									<div class="col-md-4">
										<span><label class="font-bold">Last Name :</label> <?php echo $stdinfo->lastname; ?></span>
									</div>
									<div class="col-md-4">
										<span><label class="font-bold">Class :</label> <?php echo $stdinfo->class; ?></span>
									</div>
									<div class="col-md-4">
										<span><label class="font-bold">Gender :</label> <?php 	if($stdinfo->gender == "M"){ echo "Male"; }else{ echo "Female"; } ?></span>
									</div>
									<div class="col-md-4">
										<span><label class="font-bold">DOB :</label><?php echo $stdinfo->dob; ?></span>
									</div>
									<div class="col-md-4">
										<span><label class="font-bold">Mobile :</label> <?php echo $stdinfo->mobile; ?></span>
									</div>
									<div class="col-md-4">
										<span><label class="font-bold">Phone :</label> <?php echo $stdinfo->altermobile; ?></span>
									</div>
									<div class="col-md-4">
										<span><label class="font-bold">Mail :</label> <?php echo $stdinfo->mail_id; ?></span>
									</div>
									<div class="col-md-4">
										<span><label class="font-bold">School Mail :</label> <?php echo strtolower($stdinfo->local_mail_id); ?></span>
									</div>
									<div class="col-md-4">
										<span class="text-capitalize"><label class="font-bold">Nationality :</label> <?php echo $stdinfo->nationality; ?></span>
									</div>

									<div class="col-md-4">
										<span class="text-capitalize"><label class="font-bold">Religion :</label> <?php echo $stdinfo->religion; ?></span>
									</div>

									<div class="col-md-4">
										<span><label class="font-bold">Country :</label>
										<?php $contaryname = $this->Model_default->countryName(array('id'=>$stdinfo->country_id));
										if(!empty($stdinfo->country_id)) { echo $contaryname->name; }
										?></span>
									</div>

									<div class="col-md-4">
										<span> <label class="font-bold">State :</label>
										<?php $statename = $this->Model_default->stateName(array('id'=>$stdinfo->state_id));
										if(!empty($stdinfo->state_id)) { echo $statename->name; }
										?></span>
									</div>

									<div class="col-md-4">
										<span> <label class="font-bold">City :</label>
										<?php $cityname = $this->Model_default->cityName(array('id'=>$stdinfo->city_id));
										if(!empty($stdinfo->city_id)) { echo $cityname->name; }
										?></span>
									</div>
									<div class="col-md-4">
										<div class="row">
											<span class="col-md-12 text-capitalize"><label class="font-bold">Address :</label> <?php echo $stdinfo->address; ?></span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="row">
											<span class="col-md-12 text-capitalize"><label class="font-bold">Pincode :</label> <?php echo $stdinfo->pincode; ?></span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="row">
											<span class="col-md-12 text-capitalize"><label class="font-bold">Service :</label> <?php echo $stdinfo->service; ?></span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="row">
											<span class="col-md-12 text-capitalize"><label class="font-bold">Blood Group :</label> <?php echo $stdinfo->blood_group; ?></span>
										</div>
									</div>
									<div class="col-md-8">
										<div class="row">
											<span class="col-md-12 text-capitalize"><label class="font-bold">Mole's :</label> <?php echo $stdinfo->moles; ?></span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="row">
											<span class="col-md-12 text-capitalize"><label class="font-bold">Academic Batch : </label> <?php echo $stdinfo->batch; ?></span>
										</div>
									</div>

								</div>
							</div>


							<?php if($stdinfo->student_image != ''){ ?>
								<div class="col-md-2">
									<img src="<?=base_url($stdinfo->student_image)?>" class="img-responsive" style="width: 100%;height: 175px;">
								</div>
							<?php } ?>
						</div>

							<h4 class="text-uppercase text-success">Parents <small>or</small> Gaurdian Details</h4>
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4">
										<span class="text-capitalize"><label class="font-bold">Name :</label> <?php echo $stdinfo->pname; ?></span>
									</div>
									<div class="col-md-4">
										<span class="text-capitalize"><label class="font-bold">Degination :</label> <?php echo $stdinfo->pdegination; ?></span>
									</div>
									<div class="col-md-4">
										<span class="text-capitalize"><label class="font-bold">Mobile :</label> <?php echo $stdinfo->pphone; ?></span>
									</div>
									<div class="col-md-4">
										<div class="row">
											<span class="col-md-12 text-capitalize"><label class="font-bold">Mail Id :</label> <?php echo $stdinfo->pmailid; ?></span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<span class="col-md-12 text-capitalize"><label class="font-bold">Address :</label> <?php echo $stdinfo->paddress; ?></span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="row">
											<span class="col-md-12 text-capitalize"><label class="font-bold">Pincode :</label> <?php echo $stdinfo->ppincode; ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row justify-content-center align-items-center">
							<div class="col-md-2 mb-5">
								<?php if($stdinfo->qr_code != ''){ ?>
									<img src="<?=base_url($stdinfo->qr_code)?>" class="img-responsive" style="width: 100%">
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
