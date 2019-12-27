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
        <li class="breadcrumb-item active">Uploaded Marks List</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Uploaded Marks List<small>.</small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Uploaded Marks List</h4>
                </div>
                <div class="panel-body">
					<div class="table-responsive">
						<?php  if(count($uploadedmarks) != 0){ ?>
							<table id="myTable" class="table table-bordered table-striped">
								<thead class="text-center bg-info">
									<th class="text-white">#</th>
									<th class="text-white"></th>
									<th class="text-white">Student Name</th>
									<th class="text-white">Exam</th>
									<th class="text-white">Syllabus</th>
									<th class="text-white">Uploaded Marks</th>
									<th class="text-white">Status</th>
									<th>Uploaded</th>
									<th class="text-white"></th>
								</thead>
								<tbody>
								<?php $i = 1; foreach($uploadedmarks as $timings){

									$studentslist = $this->Model_default->selectdata('sms_admissions', array('school_id' => $timings->school_id, 'branch_id' => $timings->branch_id, 'sno' => $timings->sno_id, 'id_num' => $timings->id_num));
                                    
									$syllubasname = $this->Model_dashboard->syllabusname(array('id'=>$studentslist[0]->class_type));
									?>
									<tr class="">
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
										<td><span title="<?=$studentslist[0]->id_num?>" data-toggle="tooltip"><?=substr($studentslist[0]->lastname,0,1).'.'.$studentslist[0]->firstname?></span></td>
										<?php
										$slab = $this->Model_dashboard->selectdata('sms_examination_slabs_list',array('school_id'=>$timings->school_id,'branch_id'=>$timings->branch_id,'sno'=>$timings->exam_slab),'updated');
										?>
										<td><?=$slab[0]->slab_name?></td>
										<td class="text-center"><?=$syllubasname[0]->type.' - '.$timings->syllabus_class.' - '.$studentslist[0]->section.' - '.$studentslist[0]->rollno?></td>
										<td class="text-center">
                                            <?php if(!empty($timings->uploaded_marks)){ ?>
                                                <a href="javascript:;"><span class="text-success">Marks Details</span></a>
                                            <?php }else{ ?>
                                                <a href="javascript:;"><span>No Upload Found</span></a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                        	<?php
                                        		if($timings->c_status == 1 && $timings->a_status == 1){
                                        			if($timings->c_status == 1){
                                        				echo '<span class="text-warning" title="By Classteacher" data-toggle="tooltip">pending...</span>';
                                        			}else{
                                        				echo '<span class="text-warning" title="By Admin" data-toggle="tooltip">pending</span>';
                                        			}
                                        		}else{
                                        			if($timings->c_status == 0){
                                        				echo '<span class="text-success" title="By Classteacher" data-toggle="tooltip">approved</span>';
                                        			}else if($timings->a_status == 0){
                                        				echo '<span class="text-success">admin approved</span>';
                                        			}else if($timings->a_status == 0 && $timings->c_status == 0){
                                        				echo '<span class="text-success">Approved</span>';
                                        			}
                                        		}
                                        	?>
                                        </td>
                                        <td><?=date('d-m-Y',strtotime($timings->created))?></td>
                                        <td align="center">

                                        	<?php if($timings->c_status == 1) { ?>
                                        		<span title="Edit Marks" data-toggle="tooltip"><a href="#"><i class="fa fa-edit fa-dx"></i></a></span>&nbsp;&nbsp;	
                                        	<?php }else{ ?>
                                        		<span title="Send request" data-toggle="tooltip"><a href="#"><i class="fa fa-random fa-dx"></i></a></span>&nbsp;&nbsp;
                                        	<?php } ?>

                                        	<span title="View Marks" data-toggle="tooltip"><a href="#"><i class="fa fa-file fa-dx"></i></a></span>&nbsp;&nbsp;

                                        	<?php if($timings->c_status == 1) { ?>
                                        		<span title="Delete Marks" data-toggle="tooltip"><a href="#"><i class="fa fa-trash fa-dx"></i></a></span>	
                                        	<?php } ?>
                                            
                                        </td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
							
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
