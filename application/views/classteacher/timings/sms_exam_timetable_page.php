<!-- Container fluid  -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item">Examination's</li>
		<li class="breadcrumb-item active">Exam TimeTable List</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Examination Timetable <small>.</small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
		<div class="col-md-4 col-sm-12 col-xs-12">
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Examination Details List</h4>
				</div>
				<div class="panel-body">

					<?php
						$slabslist = $this->Model_dashboard->selectorderby('sms_examination_slabs_list',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'updated');
						if(count($slabslist) != 0){ ?>
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
									<th>#</th>
									<th>Exam Id</th>
									<th>Examination Name</th>
									</thead>
									<tbody>
									<?php $i = 1; foreach ($slabslist as $value){ ?>
										<tr>
											<td><?=$i++?></td>
											<td><?=$value->exam_id?></td>
											<td><?=$value->slab_name?></td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						<?php }else{
							$this->Model_dashboard->norecords();
						}
					?>

				</div>
			</div>

		</div>

        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Examination Timetable</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <?php if(count($timingslist) != 0){ ?>
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
									<th>#</th>
									<th>Exam Id</th>
									<th>Slab</th>
									<th>Syllabus</th>
									<th>class</th>
									<th>Section</th>
									<th>Timetable</th>
									<th></th>
                                </thead>
                                <tbody>
                                <?php $i = 1; foreach($timingslist as $timings){
									$syllubasname = $this->Model_dashboard->syllabusname(array('id'=>$timings->syllabus_type));
                                	?>
									<tr class="text-uppercase text-info">
										<td><?=$i++?></td>
										<td><?=$timings->examination_id?></td>
										<?php
											$slab = $this->Model_dashboard->selectdata('sms_examination_slabs_list',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'sno'=>$timings->exam_slab),'updated');
										?>
										<td><?=$slab[0]->slab_name?></td>
										<td><?=$syllubasname[0]->type?></td>
										<td><?=$timings->class?></td>
										<td><?php if($timings->section == 'all'){ echo 'All Sec'; }else{ echo $timings->section.' Section'; } ?></td>
										<td>
											<?php if(count(unserialize($timings->exam_timings)) != 0){ ?>
												<a href="javascript:(0);" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#<?=$timings->examination_id.'_'.$timings->class.'_'.$timings->section?>"> TimeTable</a>
											<?php }else{ ?>
												Not Found
											<?php } ?>
										</td>
										<td align="center">
											<a href="javascript:(0);" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#<?=$timings->examination_id.'_'.$timings->class.'_'.$timings->section?>"><i class="fa fa-file fa-dx"></i></a>&nbsp;&nbsp;
										</td>
									</tr>
								<?php } ?>
                                </tbody>
                            </table>
							<?php $i = 1; foreach($timingslist as $timings){
								$syllubasname = $this->Model_dashboard->syllabusname(array('id'=>$timings->syllabus_type));
								$slab = $this->Model_dashboard->selectdata('sms_examination_slabs_list',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'sno'=>$timings->exam_slab),'updated');
								?>
							<div class="modal" id="<?=$timings->examination_id.'_'.$timings->class.'_'.$timings->section?>">
								<div class="modal-dialog modal-md" style="margin-top: 80px">
									<div class="modal-content">

										<!-- Modal Header -->
										<div class="modal-header">
											<h4 class="modal-title">Examination Timetable : <?=$syllubasname[0]->type.' - '.$timings->class.' Class ('.$timings->section.')';?></h4>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>

										<!-- Modal body -->
										<div class="modal-body">
											<?php
												$examtimingslist = unserialize($timings->exam_timings);

												$subjects 	= 	array();
												$dates		=	array();
												$examtime   =	array();
												$totalmarks	=	'';
												foreach ($examtimingslist as $key => $examtimings){
													$subjects[] =	$examtimings['subject'];
													$dates[]	=	$examtimings['date'];
													$examtime[]	=	date('h:i a',strtotime($examtimings['from'])).' To '.date('h:i a',strtotime($examtimings['to']));
													//$totalmarks += $examtimings['marks'];
												}

											?>
											<h5><?=$slab[0]->slab_name?> Examination Timings</h5>
											<table class="table table-bordered table-striped">
												<thead>
													<th class="text-success">Subjects </th>
													<th class="text-success">Dates </th>
													<th class="text-success">Timings </th>
												</thead>
												<tbody>

													<?php foreach($subjects as $key => $subject){ ?>
														<tr>
															<td><?=$subject?></td>
															<td><?=date('d-m-Y',strtotime($dates[$key]))?></td>
															<td class='text-uppercase'><?=$examtime[$key]?></td>
														</tr>
													<?php } ?>

												</tbody>
											</table>
										</div>
									</div>
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
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
