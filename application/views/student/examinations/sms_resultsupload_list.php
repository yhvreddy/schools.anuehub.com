<!-- Container fluid  -->
<style>
	table.table-bordered.dataTable tbody td {
		line-height: 28px;
	}
</style>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item">Examination's</li>
        <li class="breadcrumb-item active">Results List</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Results List<small>.</small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Uploaded Results List</h4>
                </div>
                <div class="panel-body">
					<div class="table-responsive">
						<?php if(count($resultslist) != 0){ ?>
							<table id="myTable" class="table table-bordered table-striped">
								<thead class="text-center bg-info">
									<th class="text-white">#</th>
									<th class="text-white"></th>
									<th class="text-white">Exam Id</th>
									<th class="text-white">Admission Id</th>
									<th class="text-white">Student Name</th>
									<th class="text-white">Slab Name</th>
									<th class="text-white">Syllabus</th>
									<th class="text-white">Marks List</th>
									<th class="text-white">Total</th>
									<th class="text-white">%</th>
									<th class="text-white"></th>
								</thead>
								<tbody>
								<?php $i = 1; foreach($resultslist as $timings){

									$studentslist = $this->Model_default->selectdata('sms_admissions', array('school_id' => $timings->school_id, 'branch_id' => $timings->branch_id, 'sno' => $timings->student_id, 'id_num' => $timings->admission_id));

									$syllubasname = $this->Model_dashboard->syllabusname(array('id'=>$studentslist[0]->class_type));
									?>
									<tr class="text-uppercase">
										<td><?=$i++?></td>
										<script>
											$(document).ready(function(){
												var firstName = '<?=$studentslist[0]->firstname?>';
												var lastName = '<?=$studentslist[0]->lastname?>';
												var intials = firstName.charAt(0) + lastName.charAt(0);
												var profileImage = $('#profileImage<?=$studentslist[0]->sno?>').text(intials);
											});
										</script>
										<td align="center">
											<?php if(!empty($studentslist[0]->student_image)){ ?>
												<img src="<?=base_url($studentslist[0]->student_image)?>" class="profileImage">
											<?php }else{ ?>
												<div id="profileImage<?=$studentslist[0]->sno;?>" class="profileImage text-uppercase"></div>
											<?php } ?>
										</td>
										<td><?=$timings->exam_id?></td>
										<td><a href="javascript:(0);" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#ResultsDetails_<?=$timings->sno?>"><?=$studentslist[0]->id_num?></a></td>
										<td><?=substr($studentslist[0]->lastname,0,1).'.'.$studentslist[0]->firstname?></td>
										<?php
										$slab = $this->Model_dashboard->selectdata('sms_examination_slabs_list',array('school_id'=>$timings->school_id,'branch_id'=>$timings->branch_id,'sno'=>$timings->slab_id),'updated');
										?>
										<td><?=$slab[0]->slab_name?></td>
										<td><?=$syllubasname[0]->type.' - '.$timings->class?></td>
										<td>
											<?php if(count(unserialize($timings->markslist)) != 0){ ?>
												<a href="javascript:(0);" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#ResultsDetails_<?=$timings->sno?>"> Marks Details</a>
											<?php }else{ ?>
												Not Found
											<?php } ?>
										</td>
										<td><?=$timings->gainedmarks.' / '.$timings->totalmarks?></td>
										<td><?=round($timings->gainedmarks/$timings->totalmarks*100, 2)?></td>
										<td align="center">
											<?php $popup = base_url('dashboard/upload/results/'.$timings->student_id.'/'.$timings->examination_id.'/'.$timings->branch_id.'/'.$timings->school_id.'/'.$timings->admission_id.'?exam='.$timings->exam_id.'&classreq='.$timings->class.'&uploaded_id='.$timings->sno.'&request=update'); ?>
											<a href="#" onclick='window.open("<?=$popup?>", "mywindow", "scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=800,height=500,left=100,top=100");' data-backdrop="static" data-keyboard="false" class="font-20"><i class="fa fa-edit fa-dx"></i></a>&nbsp;&nbsp;
										</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
							<?php $i = 1; foreach($resultslist as $timings){
								$studentslist = $this->Model_default->selectdata('sms_admissions', array('school_id' => $timings->school_id, 'branch_id' => $timings->branch_id, 'sno' => $timings->student_id, 'id_num' => $timings->admission_id));

								$syllubasname = $this->Model_dashboard->syllabusname(array('id'=>$studentslist[0]->class_type));

								$slab = $this->Model_dashboard->selectdata('sms_examination_slabs_list',array('school_id'=>$timings->school_id,'branch_id'=>$timings->branch_id,'sno'=>$timings->slab_id),'updated');
								?>
								<div class="modal" id="ResultsDetails_<?=$timings->sno?>">
									<div class="modal-dialog modal-md" style="margin-top: 80px">
										<div class="modal-content">

											<!-- Modal Header -->
											<div class="modal-header">
												<h4 class="modal-title"><?=$slab[0]->slab_name;?> Result Details  : <?=ucwords(substr($studentslist[0]->lastname,0,1).'.'.$studentslist[0]->firstname)?></h4>
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>

											<!-- Modal body -->
											<div class="modal-body">
												<h5><?=$slab[0]->slab_name;?> Result : </h5>
												<?php
													$resultsdatalist	=	unserialize($timings->markslist);
													$mainmarkslist 	= 	array();
													$etcmarks		=	array();
													$maintotalmarks	=	'';$etctotalmarks	=	'';

													$countotalsub	=	count($resultsdatalist);
												    $totalmarksper	=	$timings->totalmarks;

													foreach ($resultsdatalist as $key => $resultvalue){
														if($resultvalue['type'] == 'main') {
															$mainmarkslist[] = array('subject' => $resultvalue['subject'], 'marks' => $resultvalue['marks']);
															@$maintotalmarks +=  $resultvalue['marks'];
														}else if($resultvalue['type'] == 'etc'){
															$etcmarks[] = array('subject' => $resultvalue['subject'], 'marks' => $resultvalue['marks']);
															@$etctotalmarks +=  $resultvalue['marks'];
														}
													}

													@$grandtotal	= $maintotalmarks + $etctotalmarks;

													if(count($mainmarkslist) != 0){ ?>

														<h6>Main Subjects</h6>

														<table id="" class="table-bordered table table-striped">
															<thead>
																<th>#</th>
																<th>Subject Name</th>
																<th>Marks</th>
															</thead>
															<tbody>
																<?php $r = 1; foreach ($mainmarkslist as $value){ ?>
																	<tr>
																		<td><?=$r++;?></td>
																		<td><?=$value['subject']?></td>
																		<td><?=$value['marks']?></td>
																	</tr>
																<?php } ?>
															</tbody>
														</table>
													<?php }

													if(count($etcmarks) != 0){ ?>

														<h6>Etc Marks</h6>

														<table id="" class="table-bordered table table-striped">
															<tbody>
																<?php $r = 1; foreach ($etcmarks as $value){ ?>
																	<tr>
																		<td><?=$r++;?></td>
																		<td><?=$value['subject']?></td>
																		<td><?=$value['marks']?></td>
																	</tr>
																<?php } ?>
															</tbody>
														</table>
													<?php }

													if(count($etcmarks) != 0 || count($mainmarkslist) != 0){ ?>
														<table id="" class="table-bordered table table-striped">
															<tbody>

																<tr>
																	<td>
																		<label style="margin-bottom: 0px;padding-top: 3px;" class="text-primary"><?php if(count($etcmarks) != 0){ echo 'Etc : '.$etctotalmarks; } ?></label>
																	</td>
																	<td>
																		<label style="margin-bottom: 0px;padding-top: 3px;" class="text-pink-darker"><?php if(count($mainmarkslist) != 0){ echo 'Main  : '.$maintotalmarks; } ?> </label>
																	</td>
																	<td>
																		<label style="margin-bottom: 0px;padding-top: 3px;" class="text-success"><?php echo 'Total : '.$grandtotal; ?></label>

																		<label style="margin-bottom: 0px;padding-top: 3px;" class="pull-right text-info"><?php echo 'Percentage : '.round($grandtotal/$totalmarksper*100,2).'%'; ?></label>
																	</td>
																</tr>

															</tbody>
														</table>
													<?php }
												?>
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
