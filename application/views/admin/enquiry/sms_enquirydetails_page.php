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
		<li class="breadcrumb-item"><a href="javascript:;">Enquiry</a></li>
		<li class="breadcrumb-item active">Enquiry Details</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Enquiry Details<small></small></h1>
	<!-- end page-header -->
	<!-- Start Page Content -->
	<div class="row">
		<?php $stdinfo = $enquirydetails[0]; ?>
		<div class="col-12">
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<a href="<?=base_url('dashboard/enquiry/newenquiry')?>" class="pull-right btn btn-success btn-xs"><i class="fa fa-list"></i> Enquiry list</a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					</div>
					<h4 class="panel-title">Enquiry details</h4>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<h4>STUDENT DETAILS</h4>
						<div class="row">
							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">Reg id :</label>
									<span class="col-md-9"><?php echo $stdinfo->id_num; ?></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">F Name :</label>
									<span class="col-md-9"><?php echo ucwords($stdinfo->firstname); ?></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">L Name :</label>
									<span class="col-md-9"><?php echo ucwords($stdinfo->lastname); ?></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="row">
									<label class="col-md-4">Father Name :</label>
									<span class="col-md-8"><?php echo ucwords($stdinfo->fathername); ?></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">Gender :</label>
									<span class="col-md-9"><?php if($stdinfo->gender == 'M'){ echo 'Male'; }else{ echo 'FeMale'; } ?></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">Class :</label>
									<span class="col-md-9"><?php echo $stdinfo->class; ?></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">Gender :</label>
									<span class="col-md-9"><?php 	if($stdinfo->gender == "M"){ echo "Male"; }else{ echo "Female"; } ?></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">DOB :</label>
									<span class="col-md-9"><?php if(!empty($stdinfo->dob)){ echo date('d-m-Y',strtotime($stdinfo->dob)); }else{ echo '---'; } ?></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">Mobile :</label>
									<span class="col-md-9"><?php echo $stdinfo->mobile; ?></span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">Phone :</label>
									<span class="col-md-9"><?php echo $stdinfo->altermobile; ?></span>
								</div>
							</div>

							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">Mail :</label>
									<span class="col-md-9"><?php echo $stdinfo->mail_id; ?></span>
								</div>
							</div>

							<div class="col-md-4">
								<div class="row">
									<label class="col-md-4">Nationality :</label>
									<span class="col-md-8 text-capitalize"><?php echo $stdinfo->nationality; ?></span>
								</div>
							</div>

							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">Religion :</label>
									<span class="col-md-9 text-capitalize"><?php echo $stdinfo->religion; ?></span>
								</div>
							</div>

							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">Country :</label>
									<span class="col-md-9">
										<?php $contaryname = $this->Model_default->countryName(array('id'=>$stdinfo->country_id));
											if(!empty($stdinfo->country_id)) { echo $contaryname->name; }
										?>
									</span>
								</div>
							</div>

							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">State :</label>
									<span class="col-md-9">
										<?php $statename = $this->Model_default->stateName(array('id'=>$stdinfo->state_id));
										if(!empty($stdinfo->state_id)) { echo $statename->name; }
										?>
									</span>
								</div>
							</div>

							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">City :</label>
									<span class="col-md-9">
										<?php $cityname = $this->Model_default->cityName(array('id'=>$stdinfo->city_id));
										if(!empty($stdinfo->city_id)) { echo $cityname->name; }
										?>
									</span>
								</div>
							</div>

							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">Address :</label>
									<span class="col-md-9 text-capitalize"><?php echo $stdinfo->address; ?></span>
								</div>
							</div>

							<div class="col-md-4">
								<div class="row">
									<label class="col-md-3">Pincode :</label>
									<span class="col-md-9 text-capitalize"><?php echo $stdinfo->pincode; ?></span>
								</div>
							</div>

						</div>
						<div class="row justify-content-center align-items-center">
							<?php
							$add = $this->Model_default->selectdata('sms_admissions',array('branch_id'=>$stdinfo->branch_id,'school_id'=>$stdinfo->school_id,'enq_id'=>$stdinfo->id_num));
							if(count($add) == 0){
							?>
								<a href="<?=base_url('dashboard/enquiry/admission/'.$stdinfo->sno.'/'.$stdinfo->school_id.'/'.$stdinfo->branch_id)?>" class="btn btn-success btn-sm mt-5" onclick="return confirm('Do you want to add Admission of <?=ucwords($stdinfo->firstname).'.'.ucwords($stdinfo->lastname)?>..!')">Add Admission</a>
							<?php } ?>
						</div>
					</div>

					<div class="row justify-content-center align-items-center mt-4">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
