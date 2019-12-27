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
		<li class="breadcrumb-item"><a href="javascript:;">Staff List</a></li>
		<li class="breadcrumb-item active">Staff Details</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Staff Details<small></small></h1>
	<!-- end page-header -->
	<!-- Start Page Content -->
	<div class="row">
		<div class="col-12">
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Employee details</h4>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<?php $empinfo = $stdinfo = $employeedetails[0]; //print_r($stdinfo); ?>
						<h4 class="text-capitalize text-success">Employee Details</h4>
						<div class="row">
							<div class="<?php if($stdinfo->employee_pic == ''){ ?> col-md-12 <?php }else{ ?> col-md-10 <?php } ?>">
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
										<span><label class="font-bold">Father Name :</label> <?php echo $stdinfo->fathername; ?></span>
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
										<span><label class="font-bold">Phone :</label> <?php echo $stdinfo->phone; ?></span>
									</div>
									<div class="col-md-4">
										<span><label class="font-bold">School Local Mail :</label> <?php echo strtolower($stdinfo->local_mail_id); ?></span>
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
											<span class="col-md-12 text-capitalize"><label class="font-bold">Pincode : </label> <?php echo $stdinfo->pincode; ?></span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="row">
											<span class="col-md-12 text-capitalize"><label class="font-bold">Designation :</label> <?php echo $stdinfo->designation; ?></span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="row">
											<span class="col-md-12 text-capitalize"><label class="font-bold">Position :</label> <?php echo $stdinfo->emoloyeeposition; ?></span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="row">
											<span class="col-md-12 text-capitalize"><label class="font-bold"> Salary  :</label> <?php echo $stdinfo->salary; ?> <small>per/month</small></span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="row">
											<?php
												$syllabusname = $this->Model_default->selectdata('sms_scl_types', array('id' => $stdinfo->deal_syllabus), 'id DESC');
												if(count($syllabusname) != 0){
													$syllabusname = $syllabusname[0];
												}else{
													$syllabusname = '';
												}
											?>
											<span class="col-md-12 text-capitalize"><label class="font-bold"> Dealing class  :</label> <?php if(!empty($stdinfo->deal_syllabus_class)){ echo $syllabusname->type.' - '.$stdinfo->deal_syllabus_class; }else{ echo 'No assign class link to deal.'; } ?> </span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="row">
											<span class="col-md-12 text-capitalize"><label class="font-bold"> Dealing subjects  :</label> <?php if(!empty($stdinfo->dealsubjects)){ echo str_replace(',',', ',$stdinfo->dealsubjects); }else{ echo 'No assign subjects to deal.'; } ?> </span>
										</div>
									</div>
								</div>
							</div>


							<?php if($stdinfo->employee_pic != ''){ ?>
								<div class="col-md-2">
									<img src="<?=base_url($stdinfo->employee_pic)?>" class="img-responsive" style="width: 100%;height: 175px;">
								</div>
							<?php } ?>
						</div>
					</div>


					<div class="col-md-12">
						<div class="row justify-content-center align-items-center">
							<div class="col-md-2">
								<?php if($stdinfo->qr_code != ''){ ?>
									<img src="<?=base_url($stdinfo->qr_code)?>" class="img-responsive" style="width: 100%">
								<?php } ?>
							</div>
						</div>
					</div>
					<script>
						$('#feelistdetails').DataTable({
							'paging'      : false,
							'lengthChange': false,
							'searching'   : false,
							'ordering'    : false,
							'info'        : false,
							'autoWidth'   : false,
							'bSort' : false
						});
					</script>
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
