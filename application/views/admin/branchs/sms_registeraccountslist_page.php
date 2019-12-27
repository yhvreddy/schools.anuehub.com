<!-- Container fluid  -->
<?php error_reporting(0); ?>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Branchs</a></li>
        <li class="breadcrumb-item active">Branch's List</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Branch's List <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Registered Branch's List</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <?php //print_r($reg);
                            if(count($reg) != 0){ ?>
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
										<tr class="text-center">
											<th>#</th>
											<th>Registered id</th>
											<th>Registered Name</th>
											<th>Mobile</th>
											<th>Mail id</th>
											<th>Branch</th>
											<th>Status</th>
											<th></th>
										</tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; foreach ($reg as $regdata){
											$branchdata = $this->Model_dashboard->selectdata('sms_regusers',array('gbsid'=>$regdata->upper_reg_id),'updated');
											$branch	=	$branchdata[0];

											$schooldata = $schoolinfo = $this->Model_dashboard->selectdata('sms_schoolinfo',array('reg_id'=>$regdata->reg_id,'scltype'=>'GSB'),'updated');
											$school	=	$schooldata[0];

											$regusers = $this->Model_dashboard->selectdata('sms_regusers',array('reg_id'=>$regdata->reg_id,'gbsid'=>$regdata->upper_reg_id));
                                    	?>

                                        <tr <?php if($regusers[0]->status == 0 && $regdata->status == 0 && $school->status == 0){ ?> style="color: red;font-weight: 600;" <?php } ?>>
                                            <td><?= $i; ?></td>
                                            <td><a href="<?=base_url().'dashboard/branch/branchdetails/'.$regusers[0]->sno.'/'.$regusers[0]->reg_id.'/'?>"><?=$regdata->reg_id?></a> </td>
                                            <td><?=ucwords(substr($regdata->lname,0,1).'.'.$regdata->fname)?></td>
                                            <td><?=$regdata->mobile?></td>
                                            <td><?=$regdata->mailid?></td>
											<td><?=ucwords($regdata->branch_name)?></td>
											<td align="center">
												<?php
													if($regdata->cstatus == 0 && $regdata->status == 1){
														echo "<span class='text-warning'>Not Activate</span>";
													}else if($regdata->cstatus == 1 && $regdata->status == 1 ){
														if(count($schooldata) != 0){
															if($school->status == 1) {
																echo "<span class='text-success'>Active</span>";
															}else{
																echo "<span class='text-success'>Deactivated</span>";
															}
														}else{
															echo "<span class='text-success' title='school Details Pending' data-toggle='tooltip'>Pending</span>";
														}
													}else if($regdata->cstatus == 1 && $regdata->status == 0 ){
														if($regusers[0]->status == 0 && $regdata->status == 0 && $school->status == 0){
															echo "<span class='text-warning text-uppercase'>Temp Disabled</span>";
														}else {
															echo "<span class='text-warning'>Deactivated</span>";
														}
													}
												?>
											</td>
                                            <td align="center">
                                                <?php

                                                    if(count($regusers) != 0 && count($schoolinfo) != 0){ ?>
                                                        <!--<a href="javascript:void(0);" style="font-size: 18px"><i class="mdi mdi-file"></i></a>-->

                                                        <?php if($regusers['0']->accmode != 0){ ?>
                                                            <a href="<?=base_url().'dashboard/branch/accountonoff/'.$regusers[0]->sno.'/'.$regusers[0]->reg_id.'/'.'off'?>" class="text-danger"><i class="fa fa-power-off text-danger fa-dx" onclick="return confirm('Are you want to deactivate account..!');"></i></a>
                                                        <?php }else{ ?>
                                                            <a href="<?=base_url().'dashboard/branch/accountonoff/'.$regusers[0]->sno.'/'.$regusers[0]->reg_id.'/'.'on'?>" class="text-success"><i class="fa fa-power-off text-success fa-dx" onclick="return confirm('Are you want to activate account..!');"></i></a>
                                                        <?php } ?>
														&nbsp;&nbsp;

														<?php if ($regusers[0]->status == 0 && $regdata->status == 0 && $school->status == 0){ ?>

															<a href="<?=base_url('dashboard/branch/restoredata/'.$regusers[0]->sno.'/'.$regusers[0]->reg_id.'/restore')?>" onclick="return confirm('Do want to restore <?=$regdata->branch_name?> branch data..?')" class="pt-1">
																<i class="fa fa-refresh fa-dx"></i>
															</a>

														<?php }else{ ?>
															<a href="javascript:void(0);" class="pt-1"><i class="fa fa-trash-o fa-dx" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#DeleteBranch_<?=$regusers[0]->sno?>"></i>
															</a>
														<?php  } ?>

                                                    <?php }else{ ?>

                                                        <!--<a href="<?php //echo base_url().'dashboard/branch/editbranchdetails/'.$regdata->sno.'/'.$regdata->reg_id.'/Edit'?>" onclick="return confirm('You want to edit <?php //echo $regdata->branch_name ?> data..?')"><i class="fa fa-edit fa-dx"></i></a>-->
                                                        &nbsp;&nbsp;
                                                        <a href="<?=base_url('dashboard/branch/deleterecent/'.$regdata->sno.'/'.$regdata->reg_id.'/delete')?>" onclick="return confirm('You want to delete <?=$regdata->branch_name?> branch..?')" class="text-danger"><i class="fa fa-trash-o fa-dx"></i></a>
                                                        
                                                    <?php }
                                                ?>
                                            </td>
                                        </tr>

										<!--Delete Branch with confirmation dialog-->
										<div id="DeleteBranch_<?=$regusers[0]->sno?>" class="modal fade" role="dialog">
											<div class="modal-dialog" style="top:25%">

												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title">Confirmation : <span style="font-size: small">You want to delete <?=$regdata->branch_name?> branch..?</span></h4>
														<button type="button" class="close" data-dismiss="modal">&times;</button>
													</div>
													<div class="modal-body">
														<span style="font-size:14px">You want to delete <?=$regdata->branch_name?> branch..?</span>
														<form method="post" action="<?=base_url('dashboard/branch/deleteaccount/'.$regusers[0]->sno.'/'.$regusers[0]->reg_id.'/delete')?>" id="DeleteBranchData_<?=$regusers[0]->sno?>">
															<input type="hidden" name="branch_name" value="<?=$regdata->branch_name?>">
															<div class="col-md-12 text-danger text-center" id="Errordata_<?=$regusers[0]->sno?>" style="font-size: 16px"></div>
															<div class="col-md-12 mt-2">
																<div class="custom-control custom-radio">
																	<input type="radio" class="custom-control-input" id="temp_<?=$regusers[0]->sno?>" value="temp" name="delete">
																	<label class="custom-control-label" for="temp_<?=$regusers[0]->sno?>" style="padding-top: 3px;">Delete For Temporary.</label><br>
																	<label for="temp_<?=$regusers[0]->sno?>" class="text-warning" style="padding-top: 3px; 10px"> <small>Once delete again you can restore all branch data</small>.</label>
																</div>
																<div class="custom-control custom-radio">
																	<input type="radio" class="custom-control-input" id="permanent_<?=$regusers[0]->sno?>" value="permanent" name="delete">
																	<label class="custom-control-label" for="permanent_<?=$regusers[0]->sno?>" style="padding-top: 3px;">Delete For Permanently.</label><br>
																	<label for="permanent_<?=$regusers[0]->sno?>" class="text-warning" style="padding-top: 3px; 10px"><small>Once delete you can lost all branch data & you can't restore.</small></label>
																</div>
															</div>
															<div class="mt-2">
																<button type="button" class="btn btn-warning btn-sm pull-left" id="DeleteData_<?=$regusers[0]->sno?>">Delete Branch</button>
																<button type="button" class="btn btn-danger btn-sm pull-right" data-dismiss="modal">Cancel</button>
															</div>
														</form>
														<script type="text/javascript">
															$(document).ready(function(){
																$("#DeleteData_<?=$regusers[0]->sno?>").click(function (event) {
																	event.preventDefault();
																	if($("input[name='delete']").is(":checked")){
																		$('#Errordata_<?=$regusers[0]->sno?>').text("");
																		$("#DeleteBranchData_<?=$regusers[0]->sno?>").submit();
																	}else{
																		$('#Errordata_<?=$regusers[0]->sno?>').text("please select option to delete branch..!");
																	}
																});
															});
														</script>
													</div>
												</div>

											</div>
										</div>

                                    <?php $i++; } ?>
                                    </tbody>
                                </table>
                            <?php }else{ ?>
                                <?= $this->Model_dashboard->norecords(); ?>
                            <?php } ?>
						<p>
							<span class="text-warning">Note : </span> You can't able to edit branch once you created. It will updated by branch admin..!
						</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
