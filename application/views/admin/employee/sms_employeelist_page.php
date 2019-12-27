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
        <li class="breadcrumb-item"><a href="javascript:;">Employee</a></li>
        <li class="breadcrumb-item active">Employee's List</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Employee's List <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Employee list</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 table-responsive">
                        <?php if(count($employees) != 0){ ?>
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>Register Id</th>
                                    <th>First name</th>
									<th>Last name</th>
                                    <th>Reg email </th>
                                    <th>Mobile</th>
                                    <th>Position</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach ($employees as $employee) { ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <script>
                                            $(document).ready(function(){
                                                var firstName = '<?=$employee->firstname?>';
                                                var lastName = '<?=$employee->lastname?>';
                                                var intials = firstName.charAt(0) + lastName.charAt(0);
                                                var profileImage = $('#profileImage<?=$employee->sno?>').text(intials);
                                            });
                                        </script>
                                        <td align="center">
                                            <?php if(!empty($employee->employee_pic)){ ?>
                                                <img src="<?=base_url($employee->employee_pic)?>" class="profileImage">
                                            <?php }else{ ?>
                                                <div id="profileImage<?=$employee->sno;?>" class="profileImage text-uppercase"></div>
                                            <?php } ?>
                                        </td>
                                        <td><a href="<?=base_url('dashboard/employee/details/'.$employee->sno.'/'.$employee->branch_id.'/'.$employee->school_id)?>"> <?=$employee->id_num?></a></td>
                                        <td><?=$employee->firstname?></td>
										<td><?=$employee->lastname?></td>
                                        <td><?=$employee->mail_id?></td>
                                        <td><?=$employee->mobile?></td>
                                        <td>
											<?php if($employee->emoloyeeposition == 'classteacher' || $employee->emoloyeeposition == 'teacher'){ ?>
											   	<?php if(!empty($employee->assign_class_syllabus) && !empty($employee->assign_classes_list)){ ?>
													<span data-toggle="tooltip" title="Assign classes.">
														<a href="javascript:;" data-backdrop="static" data-keyboard="false" data-toggle="modal" class="text-warning" style="text-decoration: none" data-target="#AssignPosition_<?=$employee->sno?>">
															<?=ucwords($employee->emoloyeeposition)?>
														</a>
													</span>
												<?php  }else{ ?>
													<span data-toggle="tooltip" title="Assign class to teach.">
														<a href="javascript:;" class="text-success" style="text-decoration: none" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#AssignPosition_<?=$employee->sno?>"><?=ucwords($employee->emoloyeeposition)?></a>
													</span>
												<?php } ?>
												<div class="modal" id="AssignPosition_<?=$employee->sno?>">
													<div class="modal-dialog" style="top:100px">
														<div class="modal-content">

															<!-- Modal Header -->
															<div class="modal-header">
																<h4 class="modal-title"><?=ucwords($employee->firstname)?> : Assign Classes to teach..</h4>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>

															<!-- Modal body -->
															<div class="modal-body">
																<form method="post" action="<?=base_url('dashboard/employee/syllabus/SaveAssignclass')?>">
																	<div class="col-md-12">
																		<input type="hidden" name="sno" value="<?=$employee->sno?>">
																		<input type="hidden" name="id_num" value="<?=$employee->id_num?>">
																		<input type="hidden" name="branch_id" value="<?=$employee->branch_id?>">
																		<input type="hidden" name="school_id" value="<?=$employee->school_id?>">
																		<div class="row">
																			<?php foreach ($syllabus as $key => $value) { ?>
																				<div class="custom-control custom-radio col-md-2">
																					<input type="radio" class="custom-control-input" id="customCheck_<?= $employee->sno.'_'.$key ?>" value="<?= $key ?>" name="syllabus_name" <?php if($employee->assign_class_syllabus == $key){ echo 'checked'; } ?>>
																					<label class="custom-control-label" for="customCheck_<?= $employee->sno.'_'.$key ?>"> <?= $value ?></label>
																				</div>
																				<script>
																					var temp_selected_syllabus 	= [];
																					temp_selected_syllabus.push("<?=$employee->assign_class_syllabus?>");
																					//console.log(temp_selected_syllabus);
																					$(document).ready(function(){
																						$("#customCheck_<?= $employee->sno.'_'.$key ?>").change(function(){
																							$("#SyllabusClassList").html("");
																							$("#SyllabusClassSubjectsList").html("");
																							var selectedsyllabus =   $(this).val();
																							var school_id        =   '<?=$schoolid?>';
																							var branch_id        =   '<?=$branchid?>';
																							if(selectedsyllabus != '' && school_id != '' && branch_id != ''){
																								temp_selected_syllabus = [];
																								temp_selected_syllabus.push(selectedsyllabus);
																								//console.log(temp_selected_syllabus);
																								//console.log(selectedsyllabus);
																								$.ajax("<?=base_url('dashboard/employee/syllabus/Assignclass')?>?syllabus="+selectedsyllabus+"&school_id="+school_id+"&branch_id="+branch_id,{  success: function (gdata) {
																										$('#SyllabusClassList_<?= $employee->sno ?>').html("");
																										$('#SyllabusClassList_<?= $employee->sno ?>').html(gdata);
																									} }
																								);
																							}else{
																								alert("please select syllabus..!");
																							}
																						})
																					})
																				</script>
																			<?php } ?>
																		</div>
																	</div>
																	<div class="col-md-12" id="SyllabusClassList_<?= $employee->sno ?>">
																		<?php if(!empty($employee->assign_class_syllabus) && !empty($employee->assign_classes_list)){
																			$classlist = explode(',',$employee->assign_classes_list);
																			$classdata = $this->Model_integrate->classeslist($schoolid,$branchid,$employee->assign_class_syllabus);
																			?>
																			<label class="col-md-12">Select class to Assign.</label>
																			<div class="col-md-12">
																				<div class="col-md-12">
																					<div class="row">
																						<?php if(count($classdata) != 0){ ?>
																							<?php foreach($classdata as $key => $value){ ?>
																							<div class="custom-control custom-checkbox col-md-2">
																								<input type="checkbox" <?php if(in_array($value, $classlist)){ echo 'checked'; } ?> class="custom-control-input" id="customCheck_<?= $employee->sno.'_'.$value ?>" value="<?= $value ?>" name="assigning_syllabus_class[]" <?php if(isset($employee->deal_syllabus_class) && !empty($employee->deal_syllabus_class) && in_array($value,$classlist)){ echo "checked"; } ?> >
																								<label class="custom-control-label" for="customCheck_<?= $employee->sno.'_'.$value ?>"> <?= $value ?></label>
																							</div>
																						<?php } ?>
																						<?php }else{ ?>
																							<div class="col-md-12">
																								<h5 class="pt-1 pb-1 text-center">No Class Found. Add Class <a href="<?=base_url('setup/classes')?>">Click here</a></h5>
																							</div>
																						<?php } ?>
																					</div>
																				</div>
																			</div>
																		<?php } ?>
																	</div>
																	<div class="col-md-12 mt-3">
																		<div class="row align-content-center justify-content-center">
																			<input type="submit" class="btn btn-success" value="Assign Classes">
																		</div>
																	</div>
																</form>
															</div>
														</div>
													</div>
												</div>
											<?php }else{ ?>
												<?=ucwords($employee->emoloyeeposition);?>
											<?php } ?></td>
                                        <td align="center">
                                            <span data-toggle="tooltip" title="View details"><a href="<?=base_url('dashboard/employee/details/'.$employee->sno.'/'.$employee->branch_id.'/'.$employee->school_id)?>" data-toggle='tooltip' title="View" class="font-20"><i class="fa fa-file fa-dx"></i></a></span>&nbsp;&nbsp;

											<span data-toggle="tooltip" title="Edit details"><a href="<?=base_url('dashboard/employee/edit/'.$employee->sno.'/'.$employee->school_id.'/'.$employee->branch_id.'/')?>" onclick="return confirm('You Want to Edit Employee Details - <?=$employee->id_num.' - '.$employee->firstname.'.'.$employee->lastname?>')" data-toggle='tooltip' title="Edit"><i class="fa fa-edit fa-dx"></i></a></span>&nbsp;&nbsp;

											<span data-toggle="tooltip" title="Delete details"><a href="<?=base_url('dashboard/employee/delete/'.$employee->sno.'/'.$employee->school_id.'/'.$employee->branch_id.'/')?>" data-toggle='tooltip' title="delete" onclick="return confirm('You Want to Delete Employee - <?=$employee->id_num.' - '.$employee->firstname.'.'.$employee->lastname?>')"><i class="fa fa-trash-o fa-dx"></i></a></span>
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
