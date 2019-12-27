<!-- begin #content -->
<div id="content" class="content">
	<?php $data = $this->session->userdata; ?>
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
		<li class="breadcrumb-item"><a href="javascript:;">Settngs</a></li>
		<li class="breadcrumb-item active">Setup Subjects</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Setup Sections<small></small></h1>
	<!-- end page-header -->
	<!-- begin row -->
	<div class="row">
		<!-- set class to school -->
		<?php
		//school class data
		$chkdata = $this->Model_dashboard->selectdata('sms_class',array('school_id'=>$data['school']->school_id,'branch_id'=>$data['school']->branch_id));
		$countonclass = count($chkdata);
		//school information
		$regschooltypes = $this->Model_dashboard->selectdata('sms_schoolinfo',array('reg_id' => $data['school']->reg_id,'school_id'=>$data['school']->school_id,'branch_id'=>$data['school']->branch_id));
		$scltypes = explode(',', $regschooltypes['0']->scl_types);
		//print_r($scltypes);
		$countonscl = count($scltypes);
		//sections count
		$ckecksection = $this->Model_dashboard->selectdata('sms_section', array('school_id'=>$data['school']->school_id,'branch_id'=>$data['school']->branch_id));
		$countsection   =   count($ckecksection);
		?>
		<div class="col-md-4">
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					</div>
					<h4 class="panel-title">Add / Edit Defaults Subjects</h4>
				</div>
				<div class="panel-body">
					<h5>Add / Update Divide Sections</h5>
					<form class="row" method="post" action="<?=base_url('setup/savedefaultsubjects')?>">
						<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label for="sclsyllabuslist">Select School Syllabus</label>
							<select type="text" name="StdSyllubas" id="sclsyllubaslistData" class="form-control select2" style="padding:0px">
								<option value="">Select Syllabus Type</option>
								<?php foreach ($syllabus as $key => $value) { ?>
									<option value="<?= $key ?>"><?= $value ?></option>
								<?php } ?>
							</select>
						</div>

						<!--<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<label for="SyllabusClasses">School Syllabus Class</label>
							<select type="text" name="StdClass" id="SyllabusClasses" class="form-control select2" disabled="" style="padding:0px 10px">
								<option value="">Select Class</option>
							</select>
						</div>-->

						<div class="form-group col-md-12 col-sm-12 col-xs-12" id="SectionsDivideClass">

							<center>
								<h4>Please select following option</h4>
								<img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>">
							</center>

						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function(){
				$("#sclsyllubaslistData").change(function(){
					//console.log($(this).val());
					var syllabustype = $(this).val();
					$.ajax({
						type: "POST",
						url: "<?=base_url('setup/classDefaultsubjects')?>",// where you wanna post
						data: {syllabus: syllabustype},
						/*processData: false,
						contentType: false,*/
						error: function (jqXHR, textStatus, errorMessage) {
							console.log(errorMessage); // Optional
						},
						success: function (data) {
							$('#SectionsDivideClass').html(data);
						}
					});
				})
			})
		</script>
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-inverse">
						<div class="panel-heading">
							<div class="panel-heading-btn">
								<a href="javascript:;" data-toggle="modal" data-target="#AssignSubjectsClass" data-backdrop="static" data-keyboard="false" class="btn btn-xs btn-success btn-default"><i class="fa fa-plus"></i> Assign Class Subjects</a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
							</div>
							<h4 class="panel-title">Subjects List</h4>
						</div>
						<div class="panel-body">
							<?php
							if(count($defualtsubjects) != 0){
								//print_r($sections);
								?>
								<table class="table table-bordered table-striped" id="myTable">
									<thead>
									<th>#</th>
									<th width="15%">Syllabus</th>
									<th width="65%">Default Subjects</th>
									<th width="15%" style="display: none"></th>
									<th></th>
									</thead>
									<tbody>
									<?php $i = 1; foreach ($defualtsubjects as $section) {
										$sms_scl_types = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$section->syllabus_type,'status'=>1));
										?>
										<tr>
											<td><?=$i?></td>
											<td align="center"><?=$sms_scl_types[0]->type?></td>
											<td class="pl-2">
												<?php
												$classesections = unserialize($section->subjects);
												$sections = str_replace('"','',implode(', ',$classesections));
												foreach ($classesections as $list){
													?>
													<span class="label label-info" style="line-height: 2.5;"><?=str_replace('"','',$list)?></span>
													<?php
												}
												?>
											</td>
											<td align="center">
												<span data-toggle="tooltip" title="Delete Subjects"><a href="<?=base_url('setup/subjects/delete/'.$section->sno.'/'.$section->branch_id.'/'.$section->school_id.'?action=delete')?>" onclick="return confirm('You want to delete all default subjects : <?=$sections?>')"><i class="fa fa-trash-o fa-dx"></i></a></span>&nbsp;&nbsp;
											</td>
										</tr>
										<?php $i++; } ?>
									</tbody>
								</table>
								<?php
							}else{
								$this->Model_dashboard->norecords();
							}
							?>
						</div>
					</div>
				</div>
				<?php if(count($assignsubjectslist) != 0){ ?>
					<div class="col-md-12">
						<div class="panel panel-inverse">
							<div class="panel-heading">
								<div class="panel-heading-btn">
									<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
									<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
								</div>
								<h4 class="panel-title">Assign Subjects List</h4>
							</div>
							<div class="panel-body">
								<?php
								if(count($assignsubjectslist) != 0){
									//print_r($sections);
									?>
									<table class="table table-bordered table-striped" id="myTable2">
										<thead>
											<th>#</th>
											<th width="15%">Syllabus</th>
											<th>Class</th>
											<th>Subjects List</th>
											<th></th>
										</thead>
										<tbody>
										<?php $i = 1; foreach ($assignsubjectslist as $assignsubject) {
											$sms_scl_types = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$assignsubject->scl_types,'status'=>1));
											?>
											<tr>
												<td><?=$i?></td>
												<td align="center"><?=$sms_scl_types[0]->type?></td>
												<th><?=$assignsubject->class?></th>
												<td class="pl-2">
													<?php
													$assignedsubjects = unserialize($assignsubject->subject);
													foreach ($assignedsubjects as $list){
														?>
														<span class="label label-info" style="line-height: 2.5;"><?=str_replace('"','',$list)?></span>
														<?php
													}
													?>
												</td>
												<td align="center">
													<span data-toggle="tooltip" title="Delete Subjects"><a href="<?=base_url('setup/assignsubjects/delete/'.$section->sno.'/'.$section->branch_id.'/'.$section->school_id.'?action=delete')?>" onclick="return confirm('You want to delete all Assign <?=$assignsubject->class?> subjects : <?=$sections?>')"><i class="fa fa-trash-o fa-dx"></i></a></span>&nbsp;&nbsp;&nbsp;
													<span data-toggle="tooltip" title="Edit Subjects"><a href="#"><i class="fa fa-edit fa-dx"></i></a></span>
												</td>
											</tr>
											<?php $i++; } ?>
										</tbody>
									</table>
									<?php
								}else{
									$this->Model_dashboard->norecords();
								}
								?>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- end row -->


	<div id="AssignSubjectsClass" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content" style="margin-top: 80px;">
				<div class="modal-header">
					<h4 class="modal-title">Assign Subjects to Classes</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form method="post" action="<?=base_url('setup/savedefaultassignsubjects')?>">
						<div class="row justify-content-center align-content-center">

							<div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label for="sclsyllabuslist">School Syllabus Type</label>
								<select type="text" name="StdSyllubas" id="sclsyllubaslist" class="form-control" style="padding:5px" required="required">
									<option value="">Select Syllabus Type</option>
									<?php foreach ($syllabus as $key => $value) { ?>
										<option value="<?= $key ?>"><?= $value ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
								<label for="SyllabusClasses">Subject Assigning Class</label>
								<select type="text" name="SubjectAssignClasses" id="SyllabusClasses" class="form-control" disabled="" style="padding:0px 10px" required="required">
									<option value="">Select Class</option>
								</select>
							</div>

							<div class="col-md-10" id="Assignsubjectslist">
									<center>
										<h4>Please select following option</h4>
										<img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>">
									</center>
								</div>

						</div>
					</form>
					<script>
						$(document).ready(function(){
							$("#SyllabusClasses").change(function(){
								//console.log($(this).val());
								var subjectassignclass 	= 	$(this).val();
								var syllabuslisttype	=	$("#sclsyllubaslist").val();
								if(subjectassignclass != '' && syllabuslisttype != '') {
									$.ajax({
										type: "POST",
										url: "<?=base_url('setup/subjects/assignlistsubjectsajax')?>",// where you wanna post
										data: {Classname: subjectassignclass,syllabuslist:syllabuslisttype},
										/*processData: false,
                                        contentType: false,*/
										error: function (jqXHR, textStatus, errorMessage) {
											console.log(errorMessage); // Optional
										},
										success: function (data) {
											$('#Assignsubjectslist').html(data);
										}
									});
								}else{
									alert('Please select Syllabus type and Class..!');
								}
							})
						})
					</script>
				</div>
			</div>

		</div>
	</div>


</div>
<!-- end #content -->
<script>
	//sections list
	$("#sectionslist").submit(function (ee) {
		ee.preventDefault();
		$("#loader").show();
		$.ajax({
			url: '<?= base_url() ?>setup/savesectionslist',
			method: 'POST',
			dataType: 'json',
			data: new FormData(this),
			processData: false,
			contentType: false,
		})
			.done(function (dataresponce) {
				$("#loader").hide();
				console.log(dataresponce);
				if (dataresponce.key == 0) {
					swal({
						title: "Sorry",
						text: dataresponce.message,
						type: "warning",
					},function () {

					});
					//swal("Sorry", dataresponce.message , "warning");
				} else if (dataresponce.key == 1) {
					swal({
						title: "success",
						text: dataresponce.message,
						type: "success",
					}, function () {
						window.location.href = '<?= base_url('setup/sections') ?>';
						// $("#saveclasslist").trigger('reset');
						// $("#saveclasslist").hide();
						// $("#sectionslist").hide();
						// $("#sectionslist").trigger('reset');
						//$(".actions").show();
						//$("#classesandsectionsfinsh").show();
						//$("#sectionslist").load('subsetups/sms_sections_setup.php' + '#listofsections');
					});
				}
			})
			.fail(function (req, status, err) {
				//console.log("error : " + errordata);
				console.log('Something went wrong', status, err);
				$("#loader").hide();
			})

	});
</script>
