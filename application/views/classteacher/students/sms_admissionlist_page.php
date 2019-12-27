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
        <li class="breadcrumb-item"><a href="javascript:;">Admissions</a></li>
        <li class="breadcrumb-item active">Student List</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Student List <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Students list</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <?php if(count($adminssions) != 0){ ?>
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th></th>
                                        <th>Admission Id</th>
                                        <th>First Name</th>
                                        <th>Gender</th>
                                        <th>DOB</th>
                                        <th>Syllabus</th>
                                        <th>class</th>
										<th>Sec / Rollno</th>
                                        <th>Mobile</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($adminssions as $adminssion) { ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <script>
                                                $(document).ready(function(){
                                                    var firstName = '<?=$adminssion->firstname?>';
                                                    var lastName = '<?=$adminssion->lastname?>';
                                                    var intials = firstName.charAt(0) + lastName.charAt(0);
                                                    var profileImage = $('#profileImage<?=$adminssion->sno?>').text(intials);
                                                });
                                            </script>
                                            <td align="center">
                                                <?php if(!empty($adminssion->student_image)){ ?>
                                                    <img src="<?=base_url($adminssion->student_image)?>" class="profileImage">
                                                <?php }else{ ?>
                                                    <div id="profileImage<?=$adminssion->sno;?>" class="profileImage text-uppercase"></div>
                                                <?php } ?>
                                            </td>
                                            <td><?=$adminssion->id_num?></td>
                                            <td><?=ucwords(substr($adminssion->lastname,0,1).'.'.$adminssion->firstname)?></td>
                                            <td><?php if($adminssion->gender == 'FM'){ echo 'Female'; }else{ echo 'Male'; } ?></td>
                                            <td><?php echo date('Y-m-d',strtotime($adminssion->dob));?></td>
                                            <td><?php $syllabusname = $this->Model_dashboard->syllabusname(array('id'=>$adminssion->class_type)); echo $syllabusname['0']->type; ?></td>
                                            <td><?=$adminssion->class?></td>
											<?php if($adminssion->rollno != '' && $adminssion->section != ''){ ?>
												<td align="center"><span class="text-success" style="font-weight: 600"><?=$adminssion->section?></span> &nbsp;&nbsp; - &nbsp;&nbsp; <span class="text-red-darker" style="font-weight: 600"><?=$adminssion->rollno?></span></td>
											<?php }else{ ?>
												<td align="center">
													<a href="javascript:;" data-backdrop="static" data-keyboard="false" class="text-warning text-decoration-none" data-toggle="modal" data-target="#AssignSecRollno_<?=$adminssion->sno?>">Assign RollNo</a>
												</td>
											<?php } ?>

                                            <td><?=$adminssion->mobile?></td>
                                            <td align="center">

												<span data-toggle="tooltip" title="assign sec / rollno"><a href="javascript:;" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#AssignSecRollno_<?=$adminssion->sno?>"><i class="fa fa-ticket fa-dx"></i></a></span>&nbsp;&nbsp;


												<div class="modal" id="AssignSecRollno_<?=$adminssion->sno?>">
													<div class="modal-dialog" style="top:140px">
														<div class="modal-content">

															<!-- Modal Header -->
															<div class="modal-header">
																<h4 class="modal-title">Assign Section & Rollno : <?=ucwords($adminssion->firstname)?></h4>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>

															<!-- Modal body -->
															<div class="modal-body">
																<form method="post" id="AssignRollSec_<?=$adminssion->sno?>" action="<?=base_url('classteacher/studentslist/AssignSecRollNo')?>">
																	<input type="hidden" name="sno" value="<?=$adminssion->sno?>">
																	<input type="hidden" name="id_num" value="<?=$adminssion->id_num?>">
																	<input type="hidden" name="branch_id" value="<?=$adminssion->branch_id?>">
																	<input type="hidden" name="school_id" value="<?=$adminssion->school_id?>">
																	<input type="hidden" name="class_type" value="<?=$adminssion->class_type?>">
																	<input type="hidden" name="class_name" value="<?=$adminssion->class?>">

																	<div class="row">
																		<?php
																			$sections = $this->Model_dashboard->selectdata('sms_section',array('branch_id'=>$adminssion->branch_id,'school_id' =>$adminssion->school_id,'class_type' => $adminssion-> class_type, 'class' => $adminssion->class,'status'=>1),'updated');
																			$sections	=	unserialize($sections[0]->section);
																		?>
																		<div class="col-md-4 col-xs-12 col-sm-12 form-group">
																			<select name="Std_section" class="form-control" style="width: inherit;" required id="StudentSection_<?=$adminssion->sno?>">
																				<option value="">Select Section</option>
																				<?php foreach ($sections as $section){ ?>
																					<option <?php if ($adminssion->section == str_replace('"','',$section)){ echo "selected"; } ?> value="<?=str_replace('"','',$section)?>"><?=str_replace('"','',$section);?>  - Section</option>
																				<?php } ?>
																			</select>
																		</div>
																		<div class="col-md-4 col-xs-12 col-sm-12 form-group">
																			<input type="text" required id="Std_RollNo_<?=$adminssion->sno?>" value="<?=$adminssion->rollno?>" class="form-control" placeholder="Enter Rollno" style="width: inherit;" name="Std_RollNo">
																		</div>

																		<div class="col-md-4 col-xs-12 col-sm-12">
																			<input type="submit" class="btn btn-success" name="AssignRollSec" value="Assign RollNo & Sec">
																		</div>
																		<div class="col-sm-12 mt-2 text-center" id="alertmsg_<?=$adminssion->sno?>"></div>
																	</div>
																	<script>
																		$(document).ready(function () {
																			$("#AssignRollSec_<?=$adminssion->sno?>").submit(function (event) {
																				event.preventDefault();
																				$('#loader').show();
																				var fromdata = $('#AssignRollSec_<?=$adminssion->sno?>').serialize();
																				var selectsection = $('#StudentSection_<?=$adminssion->sno?>').val();
																				var assignrollno =	$("#Std_RollNo_<?=$adminssion->sno?>").val();
																				if(selectsection != '' && assignrollno != ''){
																					//console.log(selectsection + ' - ' + assignrollno);
																					$.ajax({
																						url : "<?=base_url('classteacher/CheckAssignSecRollNo')?>",
																						type : 'POST',
																						data : fromdata,
																						dataType : 'json',
																						success : function (responcedata) {
																							$('#loader').hide();
																							//console.log(responcedata);
																							if(responcedata.code_id == 1){
																								$("#alertmsg_<?=$adminssion->sno?>").html("<span class='text-warning'>"+responcedata.message+"</span>");
																							}else if(responcedata.code_id == 0){
																								$("#alertmsg_<?=$adminssion->sno?>").html("<span class='text-success'>"+responcedata.message+"</span>");
																								$('#loader').show();
																								$.ajax({
																									url : "<?=base_url('classteacher/studentslist/AssignSecRollNo')?>",
																									type : 'POST',
																									data : fromdata,
																									dataType : 'json',
																									success : function (assignresponcedata) {
																										$('#loader').hide();
																										console.log(assignresponcedata);
																										if(assignresponcedata.code_id == 0){
																											swal({
																												title: "Sorry..!",
																												text: assignresponcedata.message,
																												icon: "warning",
																												buttons: true,
																												dangerMode: true,
																											})
																												.then((willDelete) => {
																													if (willDelete) {

																													}else {
																														function pageRedirect() {
																															window.location.href = "<?=base_url('classteacher/studentslist')?>";
																														}
																														setTimeout(pageRedirect(), 1000);
																													}
																												});
																											//window.close();
																										}else if(assignresponcedata.code_id == 1){
																											swal({
																												title: "Success..!",
																												text: assignresponcedata.message,
																												icon: "success",
																												button : 'Close',
																												//dangerMode: true,
																											})
																											.then((willDelete) => {
																												$("#loader").show();
																												function pageRedirect() {
																													window.location.href = "<?=base_url('classteacher/studentslist')?>";
																												}
																												setTimeout(pageRedirect(), 3000);
																											});
																										}
																									},
																									error : function (assignerrordata) {
																										$('#loader').hide();
																										console.log(assignerrordata);
																									}
																								})
																							}
																						},
																						error : function (errordata) {
																							$('#loader').hide();
																							console.log(errordata);
																						}
																					})
																				}else{
																					$('#loader').hide();
																					alert('Section and Rollno Should not be empty..!');
																				}
																			});
																		})
																	</script>
																</form>
															</div>
														</div>
													</div>
												</div>

                                                <span data-toggle="tooltip" title="View details"><a href="<?=base_url('classteacher/studentslist/details/'.$adminssion->sno.'/'.$adminssion->branch_id.'/'.$adminssion->school_id)?>" class="font-20"><i class="fa fa-file fa-dx"></i></a></span>&nbsp;
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
