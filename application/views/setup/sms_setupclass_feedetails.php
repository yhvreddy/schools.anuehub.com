<!-- begin #content -->
<div id="content" class="content">
    <?php $data = $this->session->userdata; ?>
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Settngs</a></li>
        <li class="breadcrumb-item active">Setup Fee Details</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Setup Fee Details<small></small></h1>
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
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
						<a href="javascript:;" data-toggle="modal" data-target="#FeeCurriculumsheet" data-backdrop="static" data-keyboard="false" class="btn btn-xs btn-success btn-default"><i class="fa fa-plus"></i> Fee Curriculum For Class</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Add / Edit Fee Setup Details</h4>
                </div>
                <div class="panel-body">
					<?php $feestructure =  $this->Model_default->selectdata('sms_class_fee_structure', array('school_id'=>$data['school']->school_id,'branch_id'=>$data['school']->branch_id),'updated DESC');
					if(count($feestructure) != 0){ ?>
						<div class="table-responsive">
							<table class="table-striped table table-bordered">
								<thead>
									<th>#</th>
									<th>Syllabus</th>
									<th align="center">Class</th>
									<th align="center">School Fee</th>
									<th align="center">Bus Fee</th>
									<th align="center">Hostel Fee</th>
									<th>Other Details</th>
									<th></th>
								</thead>
								<tbody>
									<?php $i =1; foreach ($feestructure as $key => $value){
											$sms_scl_types = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$value->scl_types,'status'=>1));
											?>
											<tr>
												<td><?=$i++;?></td>
												<td><?=$sms_scl_types[0]->type?></td>
												<td align="center"><?= $feeclass = $value->class?></td>
												<td align="center"><?=$value->schoolfee.''?></td>
												<td align="center"><?=$value->busfee?></td>
												<td align="center"><?=$value->hostelfee?></td>
												<td>
													<?php
														$otherfeedetails = unserialize($value->otherfee);
														foreach ($otherfeedetails as $key => $values){
															echo "<span class='text-success'>".$key."</span>".' : '.$values.'rs/- ';
														}
													?>
												</td>
												<td align="center">
													<span data-toggle="tooltip" title="Edit details"><a href="#" class="font-20" data-toggle="modal" data-target="#EditFeeCurriculumsheet<?=$value->sno?>" data-backdrop="static" data-keyboard="false"><i class="fa fa-edit fa-dx"></i></a></span>&nbsp;&nbsp;

													<span data-toggle="tooltip" title="Delete Record"><a href="<?=base_url('setup/feedetails/delete/'.$value->sno.'/'.$value->branch_id.'/'.$value->school_id).'?type=delete'?>" class="font-20" onclick="return confirm('You Want To Delete <?=$feeclass?> Fee Curriculum Record..?')"><i class="fa fa-trash-o fa-dx"></i></a></span>
												</td>
											</tr>

											<div id="EditFeeCurriculumsheet<?=$value->sno?>" class="modal fade" role="dialog">
												<div class="modal-dialog modal-lg">
													<!-- Modal content-->
													<div class="modal-content" style="margin-top: 80px;">
														<div class="modal-header">
															<h4 class="modal-title">Edit <?= $sms_scl_types[0]->type.' '.$value->class?> Class Fee Curriculum Details</h4>
															<button type="button" class="close" data-dismiss="modal">&times;</button>
														</div>
														<div class="modal-body">
															<form method="post" action="<?=base_url('setup/feedetails/'.$value->sno.'/updataFeeRecordData')?>" id="schoolfeedetailslist_edit<?=$value->sno?>" class="form-material">
																<div class="row" id="listofsections_edit<?=$value->sno?>">
																	<?php
																	$chkdata = $this->Model_dashboard->selectdata('sms_class',array('school_id'=>$value->school_id,'branch_id'=>$value->branch_id));
																	?>
																	<div class="col-md-12">
																		<div class="row">
																			<input type="hidden" value="<?= $value->branch_id ?>" id="subbranchid_edit<?=$value->sno?>" name="branchid">
																			<input type="hidden" value="<?= $value->school_id ?>" id="subschoolid_edit<?=$value->sno?>" name="schoolid">
																			<input type="hidden" value="<?= $value->sno ?>" id="subsno_edit<?=$value->sno?>" name="sno_id">

																			<div class="col-md-12">
																				<div class="row align-content-center justify-content-center">
																					<div class="form-group col-md-4">
																						<label>Select Syllabus type</label>
																						<select class="form-control" style="padding: 5px" required="" name="scltypeslist" id="scltypeslist_edit<?=$value->sno?>" disabled>
																							<option value="">Select syllabus type</option>
																							<?php
																							$i = 0;
																							foreach ($schoolstypes as $valued) {
																								@$scltype = $scltypes[$i];
																								//print_r($scltype);
																								if(in_array($valued->id, $scltypes)){ ?>
																									<option <?php if($valued->id == $value->scl_types){ echo 'selected'; } ?> value="<?= $valued->id ?>"><?= $valued->type ?></option>
																								<?php } $i++; } ?>
																						</select>
																						<small id="scltypeslisterror"></small>
																					</div>
																					<div class="form-group col-md-4" id="classoptionsbox_edit<?=$value->sno?>">
																						<label>Select Class</label>
																						<select class="form-control" disabled name="classlistname" required="" id="classlisting_edit<?=$value->sno?>" style="padding: 5px">
																							<option value="<?=$value->class?>" selected><?=$value->class?></option>
																							<option value="">Select Class</option>
																						</select>
																					</div>
																				</div>
																			</div>
																			<div class="col-md-12" id="FeefieldsDetailsbox_edit<?=$value->sno?>">
																				<div class="row" id="noofsubjectsmainbox_edit<?=$value->sno?>">
																					<h4 class="text-center col-md-12">Set Fee details</h4>
																					<div class="col-md-12">
																						<div class="row">
																							<div class=" col-12 mt-2">
																								<div class="row">
																									<div class="col-md-4 col-sm-12 col-12">
																										<label>School Fee</label>
																										<input type="number" min="0" name="schoolfee" required="" id="schoolfee_edit<?=$value->sno?>" placeholder="Enter school fee" class="form-control" value="<?=$value->schoolfee?>">
																										<span class="bar"></span>
																									</div>
																									<div class="col-md-4 col-sm-12 col-12">
																										<label>Bus Fee</label>
																										<input type="number" min="0" name="vehiclefee" required="" id="vehiclefee_edit<?=$value->sno?>" placeholder="Enter vehicle fee" class="form-control" value="<?=$value->busfee?>">
																										<span class="bar"></span>
																									</div>
																									<div class="col-md-4 col-sm-12 col-12">
																										<label>Hostel Fee</label>
																										<input type="number" min="0" name="hostelfee" required="" placeholder="Enter Hostel fee" id="hostelfee_edit<?=$value->sno?>" class="form-control" value="<?=$value->hostelfee?>">
																										<span class="bar"></span>
																									</div>
																								</div>
																							</div>
																							<div class="col-md-12 mt-1 mb-1">
																								<div class="ml-1">
																									<div class="checkbox checkbox-css m-b-20">
																										<input type="checkbox" value="no" <?php if(!empty($value->otherfee)){ echo 'checked'; } ?> id="otheramountlist_edit<?=$value->sno?>" name="otheramountlist_edit<?=$value->sno?>"
																											   class="custom-control-input">
																										<label for="otheramountlist_edit<?=$value->sno?>">Set Other Fee Expenses Details</label>
																									</div>
																								</div>
																								<div class="row mt-3">
																									<div class="col-md-12" id="otheramountlistbox_edit<?=$value->sno?>">
																										<div class="row justify-content-center align-items-center">

																											<div class="col-md-8" id="appendfeefieldsList_edit<?=$value->sno?>">
																												<?php if(!empty($value->otherfee)){
																													$otherfeelist = unserialize($value->otherfee);
																													$i = 1;
																													foreach ($otherfeelist as $key => $valuedata){ ?>
																													<div class="row">
																														<div class="col-md-5 form-group">
																															<input type="text" name="servicename_<?=$value->sno?>[]" placeholder="Enter Name" class="form-control" value="<?=$key?>">
																														</div>
																														<div class="col-md-5 form-group">
																															<input type="number" min="0" name="serviceamount_<?=$value->sno?>[]" placeholder="Enter Amount" class="form-control" value="<?=$valuedata?>">
																														</div>
																														<div class="col-md-2">
																															<?php if($i === 1){ ?>
																																<a href="javascript:void(0);" id="AddNewfield_edit<?=$value->sno?>" class="btn btn-success btn-sm">Add New</a>
																															<?php }else{ ?>
																															<a href="javascript:void(0);" id="AddNewfield_edit<?=$value->sno?>" class="btn btn-danger btn-sm RemoveField_edit<?=$value->sno?>">Remove</a>
																															<?php } ?>
																														</div>
																													</div>
																												<?php $i++; } }else{ ?>
																													<div class="row">
																														<div class="col-md-5 form-group">
																															<input type="text" name="servicename[]" placeholder="Enter Name"
																																   class="form-control">
																														</div>
																														<div class="col-md-5 form-group">
																															<input type="number" min="0" name="serviceamount[]" placeholder="Enter Amount"
																																   class="form-control">
																														</div>
																														<div class="col-md-2">
																															<a href="javascript:void(0);" id="AddNewfield_edit<?=$value->sno?>"
																															   class="btn btn-success btn-sm">Add New</a>
																														</div>
																													</div>
																												<?php } ?>
																												<div class="row">
																													<div class="col-md-12" id="appendfeefields_edit<?=$value->sno?>"></div>
																												</div>
																											</div>
																										</div>
																									</div>
																								</div>
																							</div>

																							<div class="col-md-12 mt-3" id="savefeebtn">
																								<center><input type="submit" class="btn btn-success" value="Save Fee Details" name="savefeelist"></center>
																							</div>
																							<script>
																								$(document).ready(function () {
																									if ($('#otheramountlist_edit<?=$value->sno?>').is(":checked")) {
																										$("#otheramountlist_edit<?=$value->sno?>").val('yes');
																									}else{
																										$("#otheramountlist_edit<?=$value->sno?>").val('no');
																									}
																									$('#otheramountlistbox_edit<?=$value->sno?>').show();
																									$("#otheramountlist_edit<?=$value->sno?>").click(function (e) {
																										if ($('#otheramountlist_edit<?=$value->sno?>').is(":checked")) {
																											$("#otheramountlist_edit<?=$value->sno?>").val('yes');
																											$("#otheramountlistbox_edit<?=$value->sno?>").show();
																										} else {
																											$("#otheramountlist_edit<?=$value->sno?>").val('no');
																											$("#otheramountlistbox_edit<?=$value->sno?>").hide();
																											$("#appendfeefields_edit<?=$value->sno?>").empty();
																											$("input[name='servicename[]']").val('');
																											$("input[name='serviceamount[]']").val('');
																										}
																									});

																									$("#AddNewfield_edit<?=$value->sno?>").click(function (e) {
																										var Editfields = '<div class="row"><div class="col-md-5 form-group"><input type="text" name="servicename_<?=$value->sno?>[]" placeholder="Enter Name" class="form-control"></div><div class="col-md-5 form-group"><input type="tel" name="serviceamount_<?=$value->sno?>[]" placeholder="Enter Amount" class="form-control"></div><div class="col-md-2"><a href="javascript:void(0);" id="AddNewfield_edit<?=$value->sno?>" class="btn btn-danger btn-sm RemoveField">Remove</a></div></div>'
																										$("#appendfeefields_edit<?=$value->sno?>").append(Editfields);
																									});

																									$("#appendfeefields_edit<?=$value->sno?>").on('click', '.RemoveField_edit<?=$value->sno?>', function (e) {
																										e.preventDefault();
																										$(this).parent().parent().remove();
																									})
																									$("#appendfeefieldsList_edit<?=$value->sno?>").on('click', '.RemoveField_edit<?=$value->sno?>', function (e) {
																										e.preventDefault();
																										$(this).parent().parent().remove();
																									})
																								});
																							</script>

																						</div>


																					</div>

																				</div>
																			</div>
																		</div>

																	</div>
																</div>

															</form>

														</div>
													</div>

												</div>
											</div>

											<?php
										}
									?>
								</tbody>
							</table>
						</div>
					<?php }else{ ?>
						<?=$this->Model_dashboard->norecords();?>
					<?php } ?>
                </div>
            </div>
        </div>
		<!-- Add New Curriculum Record -->
		<div id="FeeCurriculumsheet" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<!-- Modal content-->
				<div class="modal-content" style="margin-top: 80px;">
					<div class="modal-header">
						<h4 class="modal-title">Add Fee Curriculum Details</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<form method="post" action="<?=base_url('Setup/feelistbyclass')?>" id="schoolfeedetailslist_trash" class="form-material">
							<div class="row" id="listofsections">
								<?php
								$chkdata = $this->Model_dashboard->selectdata('sms_class',array('school_id'=>$data['school']->school_id,'branch_id'=>$data['school']->branch_id));
								?>
								<div class="col-md-12">
									<div class="row">
										<input type="hidden" value="<?= $data['school']->reg_id ?>" id="subregid" name="regid">
										<input type="hidden" value="<?= $data['school']->branch_id ?>" id="subbranchid" name="branchid">
										<input type="hidden" value="<?= $data['school']->school_id ?>" id="subschoolid" name="schoolid">

										<div class="col-md-12">
											<div class="row align-content-center justify-content-center">
												<div class="form-group col-md-4">
													<label>Select Syllabus type</label>
													<select class="form-control" style="padding: 5px" required="" name="scltypeslist" id="scltypeslist">
														<option value="">Select syllabus type</option>
														<?php
														$i = 0;
														foreach ($schoolstypes as $value) {
															@$scltype = $scltypes[$i];
															//print_r($scltype);
															if(in_array($value->id, $scltypes)){ ?>
																<option value="<?= $value->id ?>"><?= $value->type ?></option>
															<?php } $i++; } ?>
													</select>
													<small id="scltypeslisterror"></small>
												</div>
												<div class="form-group col-md-4" id="classoptionsbox">
													<label>Select Class</label>
													<select class="form-control" name="classlistname" required="" id="classlisting" style="padding: 5px">
														<option value="">Select Class</option>
													</select>
												</div>
											</div>
										</div>
										<script>
											$(document).ready(function(){
												$("#classlisting").change(function(){
													//console.log($(this).val());
													var subjectassignclass 	= 	$(this).val();
													var syllabuslisttype	=	$("#scltypeslist").val();
													if(subjectassignclass != '' && syllabuslisttype != '') {
														$.ajax({
															type: "POST",
															url: "<?=base_url('setup/feedetails/feedetailsfieldsajaxs')?>",// where you wanna post
															data: {Classname: subjectassignclass,syllabuslist:syllabuslisttype},
															/*processData: false,
                                                            contentType: false,*/
															error: function (jqXHR, textStatus, errorMessage) {
																console.log(errorMessage); // Optional
															},
															success: function (data) {
																$('#FeefieldsDetailsbox').html(data);
															}
														});
													}else{
														alert('Please select Syllabus type and Class..!');
													}
												})
											})
										</script>
										<div class="col-md-12" id="FeefieldsDetailsbox">
											<center>
												<h4>Please select following option</h4>
												<img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>">
											</center>
										</div>
									</div>

								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
    </div>
    <!-- end row -->
</div>
<!-- end #content -->
<script>
    $(document).ready(function(){

        $("#Addsubjects,#noofsubjectsmainbox,#otheramountlistbox").hide();

        $("#otheramountlist").click(function(e) {
            if($('#otheramountlist').is(":checked")){
                $("#otheramountlist").val('yes');
                $("#otheramountlistbox").show();
            }else{
                $("#otheramountlist").val('no');
                $("#otheramountlistbox").hide();
                $("#appendfeefields").empty();
                $("input[name='servicename[]']").val('');
                $("input[name='serviceamount[]']").val('');
            }
        });

        $("#AddNewfield").click(function(e) {
            var Newfields = '<div class="row"><div class="col-md-5 form-group"><input type="text" name="servicename[]" placeholder="Enter Name" class="form-control"></div><div class="col-md-5 form-group"><input type="tel" name="serviceamount[]" placeholder="Enter Amount" class="form-control"></div><div class="col-md-2"><a href="javascript:void(0);" id="AddNewfield" class="btn btn-danger btn-sm RemoveField">Remove</a></div></div>'
            $("#appendfeefields").append(Newfields);
        });

        $("#appendfeefields").on('click','.RemoveField',function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
        })

        $("#scltypeslist").change(function() {
            var scltypeslist = $(this).val();
            //alert(scltypeslist);
            if(scltypeslist == ""){
                $("#scltypeslisterror").text("Please select school Syllabus type..").css('color','red');
                $("#scltypeslist").focus();
            }else{
                $("#loader").show();
                $("#scltypeslisterror").text("");
                var subbranchid = $("#subbranchid").val();
                var subschoolid = $("#subschoolid").val();
                var subregid = $("#subregid").val();
                var scltypeslist = $("#scltypeslist").val();
                $.ajax({
                    url:"<?= base_url() ?>setup/subjectsperclasses",
                    dataType:'json',
                    method:'POST',
                    data: {schoolid:subschoolid,branchid:subbranchid,sclsyllubas:scltypeslist,regid:subregid},
                })
                    .done(function (dataresponce) {
                        $("#loader").hide();
                        $("#classoptionsbox").show();
                        $("#classlisting").children('option:not(:first)').remove();
                        console.log(dataresponce);
                        var list = "";

                        for($l = 0; dataresponce.length > $l; $l++){
                            list += "<option value='"+ dataresponce[$l] +"'>"+ dataresponce[$l] +"</option>";
                        }
                        $("#classlisting").append(list);
                    })
                    .fail(function (req, status, err) {
                        console.log('Something went wrong', status, err);
                        $("#loader").hide();
                    })
            }
        });

        $("#classlisting").change(function () {
            var classlisting = $(this).val();
            var sclstype = $("#scltypeslist").val();
            if(classlisting == ""){
                swal("please select class to add subjects..!");
            }else{
                $("#loader").hide();
                $("#noofsubjectsmainbox").show();
            }
        })

        $("#addlistofsubjects").click(function(event) {
            /* Act on the event */
            var scltypesmode = $("#scltypeslist").val();
            var classlisting = $("#classlisting").val();
            var subjectboxs = $("#noofsubjectboxs").val();
            if(scltypesmode != "" || classlisting != "" || subjectboxs != ""){
                $("#Addsubjects").show();
                var boxes = "";
                for(var i=1;subjectboxs >= i;i++){
                    //swal("ok done..!");
                    //console.log(i);
                    boxes += '<div class="col-md-4"><div class="row"><div class="col-md-10 form-group"><input type="text" name="subjectname[]" class="form-control subjectname" placeholder="Enter subject name"></div><div class="col-md-1"><a href="javascript:void(0);" class="btn btn-sm btn-danger RemoveInput" id="removeinput">X</a></div></div></div>';
                }
                $("#Addsubjects").append(boxes);
                $("#savesubjectsbtn").show();
            }else{
                $("#savesubjectsbtn").hide();
                swal("Class , syllabus and no.of subjects type should not be empty..!");
            }
        })

        $("#schoolfeedetailslist").submit(function(e) {
            e.preventDefault();
            $("#loader").show();
            //alert("ok..." + subjectnamecount);
            var feelistdata = $("#schoolfeedetailslist").serialize();
            //console.log(subjectdata);
            $.ajax({
                url: '<?=base_url('Setup/feelistbyclass')?>',
                type: 'POST',
                dataType: 'json',
                data: feelistdata,
            })
                .done(function(dataresponce) {
                    $("#loader").hide();
                    console.log(dataresponce);
                    if (dataresponce.code == 0) {
                        swal({
                            title: "Sorry",
                            text: dataresponce.message,
                            type: "warning",
                        },function () {
                            //$("#sectionslist").load('subsetups/sms_sections_setup.php' + '#listofsections');
                            $("#schoolfeedetailslist").trigger('reset');
                            $("#appendfeefields").empty();
                            $("#otheramountlistbox").hide();
                        });
                        //swal("Sorry", dataresponce.message , "warning");
                    } else if (dataresponce.code == 1) {
                        swal({
                            title: "success",
                            text: dataresponce.message,
                            type: "success",
                        }, function () {
                            $("#schoolfeedetailslist").trigger('reset');
                            $("#appendfeefields").empty();
                            $("#otheramountlistbox").hide();
                            $('#otheramountlist').trigger('click');
                            $("#otheramountlist").removeAttr('checked');
                            $("#otheramountlist").prop("checked", false);
                            $("#otheramountlist").val('no');
                            $("#otheramountlistbox").hide();
                            $("#appendfeefields").empty();
                            $("input[name='servicename[]']").val('');
                            $("input[name='serviceamount[]']").val('');

                            if(dataresponce.total == dataresponce.current){
                                window.location.href = '<?= base_url() ?>dashboard/welcomepage';

                            }
                        });
                    }
                })
                .fail(function (req, status, err) {
                    console.log('Something went wrong', status, err);
                    $("#loader").hide();
                })
        });

    });
</script>
