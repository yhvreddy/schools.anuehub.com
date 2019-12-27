<!-- Container fluid  -->
<style>
	.main {
		width: 50%;
		margin: 50px auto;
	}

	/* Bootstrap 4 text input with search icon */

	.has-search .form-control {
		padding-left: 2.375rem;
	}

	.has-search .form-control-feedback {
		position: absolute;
		z-index: 2;
		display: block;
		width: 2.375rem;
		height: 2.375rem;
		line-height: 2.375rem;
		text-align: center;
		pointer-events: none;
		color: #aaa;
	}
</style>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item active">Search</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Search<small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row justify-content-center align-items-center">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">Search</h4>
                        </div>
                        <div class="panel-body">
							<?php if(count($searchdata) != 0 && isset($searchdata['search_name']) && $searchdata['search_name'] != ''){ ?>
								<h4 class="text-success mb-3">Search Result of :  <span class="text-warning"><?=$searchdata['search_name']?></span></h4>
								<?php
								$search_name	= rtrim($searchdata['search_name']);
								//search query

								$enquirys = $this->Model_default->manualselect("SELECT * FROM `sms_enquiry` WHERE school_id = '$school_id' AND branch_id = '$branch_id' AND (id_num LIKE '%$search_name%' OR mail_id LIKE '%$search_name%' OR mobile LIKE '%$search_name%' OR class LIKE '%$search_name%' OR altermobile LIKE '%$search_name%' OR firstname LIKE '%$search_name%') AND status = 1 ORDER BY updated DESC");

								$admissions = $this->Model_default->manualselect("SELECT * FROM `sms_admissions` WHERE school_id = '$school_id' AND branch_id = '$branch_id' AND (em_id LIKE '%$search_name%' OR id_num LIKE '%$search_name%' OR mail_id LIKE '%$search_name%' OR mobile LIKE '%$search_name%' OR class LIKE '%$search_name%' OR altermobile LIKE '%$search_name%' OR pmailid LIKE '%$search_name%' OR pphone LIKE '%$search_name%' OR firstname LIKE '%$search_name%') AND status = 1 ORDER BY updated DESC");

								$employees = $this->Model_default->manualselect("SELECT * FROM `sms_employee` WHERE school_id = '$school_id' AND branch_id = '$branch_id' AND (id_num LIKE '%$search_name%' OR mail_id LIKE '%$search_name%' OR mobile LIKE '%$search_name%' OR  phone LIKE '%$search_name%' OR firstname LIKE '%$search_name%') AND status = 1 ORDER BY updated DESC");

								if(count($enquirys) != 0 || count($admissions) != 0 || count($employees) != 0){ ?>

								<?php if(count($enquirys) != 0){ ?>
									<h5 class="col-md-12">Enquiry : <?=$search_name?></h5>
									<div class="col-md-12 table-responsive pl-5 pr-5 mb-3">
										<table class="table MyTableDataList table-bordered table-striped">
											<thead>
											<tr>
												<th>#</th>
												<th>Reg id</th>
												<th>First Name</th>
												<th>Last Name</th>
												<th>Gnd</th>
												<th>Class</th>
												<th>Mobile</th>
												<th class="text-center">Actions</th>
											</tr>
											</thead>
											<tbody>
											<?php $i=1; foreach ($enquirys as $enquiry) { ?>
												<tr>
													<td><?=$i;?></td>
													<td><a href="<?=base_url('dashboard/enquiry/details/'.$enquiry->sno.'/'.$enquiry->branch_id.'/'.$enquiry->school_id)?>"><?=$enquiry->id_num?></a></td>
													<td><?=$enquiry->firstname?></td>
													<td><?=$enquiry->lastname?></td>
													<td class="text-center"><?php if($enquiry->gender == 'M'){ echo 'M'; }else{ echo 'FM'; } ?></td>
													<td><?=$enquiry->class?></td>
													<td><?=$enquiry->mobile?></td>
													<td align="center">
														<?php
														$add = $this->Model_default->selectdata('sms_admissions',array('branch_id'=>$branch_id,'school_id'=>$school_id,'enq_id'=>$enquiry->id_num));
														if(count($add) == 0){
															?>
															<span data-toggle="tooltip" title="Add admission"><a href="<?=base_url().'dashboard/enquiry/admission/'.$enquiry->sno.'/'.$enquiry->school_id.'/'.$enquiry->branch_id.''?>" onclick="return confirm('Do you want to add Admission of <?=ucwords($enquiry->firstname).'.'.ucwords($enquiry->lastname)?>..!')"><i class="fa fa-user-plus fa-dx"></i></a></span>
															&nbsp;&nbsp;
														<?php } ?>
														<span data-toggle="tooltip" title="view details"><a href="<?=base_url('dashboard/enquiry/details/'.$enquiry->sno.'/'.$enquiry->branch_id.'/'.$enquiry->school_id)?>"><i class="fa fa-file-o fa-dx"></i></a></span>&nbsp;&nbsp;

														<?php if(count($add) == 0){ ?>

															<span data-toggle="tooltip" title="Edit details"><a href="<?=base_url().'dashboard/enquiry/edit/'.$enquiry->sno.'/'.$enquiry->school_id.'/'.$enquiry->branch_id.''?>"><i class="fa fa-pencil-square-o fa-dx"></i></a></span>&nbsp;&nbsp;

															<span data-toggle="tooltip" title="Delete details"><a href="<?=base_url().'dashboard/enquiry/delete/'.$enquiry->sno.'/'.$enquiry->school_id.'/'.$enquiry->branch_id.''?>" onclick="return confirm('Are want to delete <?=$enquiry->id_num?> enquiry Details')"><i class="fa fa-trash-o fa-dx"></i></a></span>
														<?php } ?>
													</td>
												</tr>
												<?php $i++; } ?>
											</tbody>
										</table>
									</div>
								<?php } ?>

								<?php if(count($admissions) != 0){ ?>
									<h5 class="col-md-12">Admissions : <?=$search_name?></h5>
									<div class="col-md-12 table-responsive pl-5 pr-5">
										<table class="table table-bordered MyTableDataList table-striped">
											<thead>
											<tr>
												<th>#</th>
												<th></th>
												<th>Admission Id</th>
												<th>First Name</th>
												<th>Last Name</th>
												<th>Gender</th>
												<th>class</th>
												<th>Mobile</th>
												<th class="text-center">Action</th>
											</tr>
											</thead>
											<tbody>
											<?php $i=1; foreach ($admissions as $adminssion) { ?>
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
													<td><a href="<?=base_url('dashboard/admission/details/'.$adminssion->sno.'/'.$adminssion->branch_id.'/'.$adminssion->school_id)?>"> <?=$adminssion->id_num?> </a></td>
													<td><?=$adminssion->firstname?></td>
													<td><?=$adminssion->lastname?></td>
													<td><?php if($adminssion->gender == 'FM'){ echo 'Female'; }else{ echo 'Male'; } ?></td>
													<!--<td><?php //echo date('Y-m-d',strtotime($adminssion->dob));?></td>-->
													<!--<td><?php //$syllabusname = $this->Model_dashboard->syllabusname(array('id'=>$adminssion->class_type)); echo $syllabusname['0']->type; ?></td>-->
													<td><?=$adminssion->class?></td>
													<td><?=$adminssion->mobile?></td>
													<td align="center">
														<span data-toggle="tooltip" title="View details"><a href="<?=base_url('dashboard/admission/details/'.$adminssion->sno.'/'.$adminssion->branch_id.'/'.$adminssion->school_id)?>" class="font-20"><i class="fa fa-file fa-dx"></i></a></span>&nbsp;&nbsp;

														<span data-toggle="tooltip" title="Edit details"><a href="<?=base_url('dashboard/admission/edit/'.$adminssion->sno.'/'.$adminssion->school_id.'/'.$adminssion->branch_id.'/')?>" onclick="return confirm('You want to Edit '.$adminssion->id_num.' - '.$adminssion->firstname.' Admission.');" class="font-20"><i class="fa fa-edit fa-dx"></i></a></span>&nbsp;&nbsp;

														<span data-toggle="tooltip" title="Delete details"><a href="<?=base_url('dashboard/admission/delete/'.$adminssion->sno.'/'.$adminssion->school_id.'/'.$adminssion->branch_id.'/')?>" onclick="return confirm('You want to delete admission : <?=$adminssion->id_num?> - <?=$adminssion->firstname?>');" class="font-20"><i class="fa fa-trash-o fa-dx"></i></a></span>
													</td>
												</tr>
											<?php } ?>
											</tbody>
										</table>
									</div>
								<?php } ?>

								<?php if(count($employees) != 0){ ?>
									<h5 class="col-md-12">Employee : <?=$search_name?></h5>
									<div class="col-md-12 table-responsive pl-5 pr-5 mb-3">
										<table class="MyTableDataList table table-bordered table-striped">
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
													<td><?=ucwords($employee->emoloyeeposition)?></td>
													<td align="center">
														<span data-toggle="tooltip" title="View details"><a href="<?=base_url('dashboard/employee/details/'.$employee->sno.'/'.$employee->branch_id.'/'.$employee->school_id)?>" data-toggle='tooltip' title="View" class="font-20"><i class="fa fa-file fa-dx"></i></a></span>&nbsp;&nbsp;

														<span data-toggle="tooltip" title="Edit details"><a href="<?=base_url('dashboard/employee/edit/'.$employee->sno.'/'.$employee->school_id.'/'.$employee->branch_id.'/')?>" onclick="return confirm('You Want to Edit Employee Details - <?=$employee->id_num.' - '.$employee->firstname.'.'.$employee->lastname?>')" data-toggle='tooltip' title="Edit"><i class="fa fa-edit fa-dx"></i></a></span>&nbsp;&nbsp;

														<span data-toggle="tooltip" title="Delete details"><a href="<?=base_url('dashboard/employee/delete/'.$employee->sno.'/'.$employee->school_id.'/'.$employee->branch_id.'/')?>" data-toggle='tooltip' title="delete" onclick="return confirm('You Want to Delete Employee - <?=$employee->id_num.' - '.$employee->firstname.'.'.$employee->lastname?>')"><i class="fa fa-trash-o fa-dx"></i></a></span>
													</td>
												</tr>
											<?php } ?>
											</tbody>
										</table>
									</div>
								<?php } ?>

								<?php if(count($admissions) != 0){ ?>
									<h5 class="col-md-12">Fee Reports : <?=$search_name?></h5>
									<div class="col-md-12 table-responsive pl-5 pr-5 mb-3">
										<table class="MyTableDataList table table-bordered table-striped">
											<thead>
												<tr>
													<th></th>
													<th>Reg id</th>
													<th>Name</th>
													<th>Class</th>
													<th>Total</th>
													<th>Paid</th>
													<th>Balance</th>
													<th>Lastpaid</th>
													<th>Paid Date</th>
													<th>Paid By</th>
												</tr>
											</thead>
											<tbody>
											<?php $i = 1;
											foreach($admissions as $fatch){

												$stdid = $fatch->id_num;
												$stdfee = $this->Model_dashboard->selectdata('sms_feelist', array('id_num' => $stdid,'branch_id' => $fatch->branch_id,'school_id' => $fatch->school_id,'status' => 1),'sno');
												if(count($stdfee) != 0){ ?>
													<tr>
														<!--<td>
                                                    <input type="checkbox" id="remember_<?php //echo $i; ?>" name="multiid[]" value="<?php //echo $fatch['sno']; ?>" class="filled-in case checkbox">
                                                    <input type="hidden" value="<?php //echo $fatch['id_num']; ?>" name="stdids[]">
                                                    <label for="remember_<?php //echo $i; ?>" class="case checkbox" style="padding: 5px;margin:0px 5px -5px 0px;"></label>
                                                </td>-->
														<script>
															$(document).ready(function(){
																var firstName = '<?=$fatch->firstname?>';
																var lastName = '<?=$fatch->lastname?>';
																var intials = firstName.charAt(0) + lastName.charAt(0);
																var profileImage = $('#profileImage<?=$fatch->sno?>').text(intials);
															});
														</script>
														<td align="center">
															<?php if(!empty($fatch->student_image)){ ?>
																<img src="<?=base_url($fatch->student_image)?>" class="profileImage">
															<?php }else{ ?>
																<div id="profileImage<?=$fatch->sno;?>" class="profileImage text-uppercase"></div>
															<?php } ?>
														</td>
														<td><a href="<?=base_url('dashboard/feepayments/feepaymentdetails/'.$fatch->school_id.'/'.$fatch->branch_id.'/'.$fatch->id_num.'?id='.$fatch->sno)?>"><?php echo $fatch->id_num; ?></a></td>
														<td><?php echo substr($fatch->lastname,0,1).' . '.$fatch->firstname; ?></td>
														<td><?php echo $fatch->class; ?></td>
														<td class=""><?php echo $fatch->totalfee.' /-'; ?></td>
														<td class="">
															<?php
															$sumfee = $this->Model_dashboard->customquery("SELECT SUM(lastpaidfee) as paidfee FROM `sms_feelist` WHERE id_num = '$stdid' AND branch_id = '$fatch->branch_id' AND school_id = '$fatch->school_id' ORDER BY sno DESC");
															$sumfee = $sumfee[0];
															echo $totalpaidfee = $sumfee->paidfee.' /-';
															?>
														</td>
														<td class=""><?php  $balance = $fatch->totalfee - $sumfee->paidfee; if($balance == 0){ echo 'Total Paid'; }else{ echo $balance.' /-';} ?></td>
														<td class="">
															<?php
															$stfee = $this->Model_dashboard->customquery("SELECT * FROM `sms_feelist` WHERE id_num = '$stdid' AND branch_id = '$fatch->branch_id' AND school_id = '$fatch->school_id' AND status = '1' ORDER BY sno DESC");
															$stfee = $stfee[0];
															echo $stfee->lastpaidfee.' /-';
															?>
														</td>
														<td><?php echo $stfee->paiddate; ?></td>
														<td class="text-capitalize"><?=$stfee->payment_type?></td>
													</tr>
													<?php $i++;
												}
											}
											?>
											</tbody>
										</table>
									</div>
								<?php } ?>

								<?php if(count($employees) != 0){ ?>
									<h5 class="col-md-12">Employee Salary's: <?=$search_name?></h5>
									<div class="col-md-12 table-responsive pl-5 pr-5 mb-3">
										<table class="table table-bordered table-striped MyTableDataList">
											<thead>
											<tr>
												<th></th>
												<th>Reg id</th>
												<th>Name</th>
												<th>emp position</th>
												<th>T Salary <small>per/m</small></th>
												<th>T Paid</th>
												<th>Paid Salary</th>
												<th>Balance</th>
												<th>Paid Date</th>
											</tr>
											</thead>
											<tbody>
											<?php $i = 1;
											foreach($employees as $fatch){

												$stdid = $fatch->id_num;
												$stdfee = $this->Model_dashboard->selectdata('sms_empsalarylist', array('id_num' => $stdid,'branch_id' => $fatch->branch_id,'school_id' => $fatch->school_id,'status' => 1),'sno');
												if(count($stdfee) != 0){ ?>
													<tr>
														<!--<td>
                                                    <input type="checkbox" id="remember_<?php //echo $i; ?>" name="multiid[]" value="<?php //echo $fatch['sno']; ?>" class="filled-in case checkbox">
                                                    <input type="hidden" value="<?php //echo $fatch['id_num']; ?>" name="stdids[]">
                                                    <label for="remember_<?php //echo $i; ?>" class="case checkbox" style="padding: 5px;margin:0px 5px -5px 0px;"></label>
                                                </td>-->
														<script>
															$(document).ready(function(){
																var firstName = '<?=$fatch->firstname?>';
																var lastName = '<?=$fatch->lastname?>';
																var intials = firstName.charAt(0) + lastName.charAt(0);
																var profileImage = $('#profileImage<?=$fatch->sno?>').text(intials);
															});
														</script>
														<td align="center">
															<?php if(!empty($fatch->employee_pic)){ ?>
																<img src="<?=base_url($fatch->employee_pic)?>" class="profileImage">
															<?php }else{ ?>
																<div id="profileImage<?=$fatch->sno;?>" class="profileImage text-uppercase"></div>
															<?php } ?>
														</td>
														<td><a href="<?=base_url('dashboard/salary/salarypaymentdetails/'.$fatch->school_id.'/'.$fatch->branch_id.'/'.$fatch->id_num.'?id='.$fatch->sno)?>"><?php echo $fatch->id_num; ?></a></td>
														<td><?php echo substr($fatch->lastname,0,1).' . '.$fatch->firstname; ?></td>
														<td class="text-capitalize"><?php echo $fatch->emoloyeeposition; ?></td>
														<td align="center"><?php echo $fatch->salary." /-"; ?></td>
														<?php
														$stfee = $this->Model_dashboard->customquery("SELECT * FROM `sms_empsalarylist` WHERE id_num = '$stdid' AND branch_id = '$fatch->branch_id' AND school_id = '$fatch->school_id' AND status = '1' ORDER BY sno DESC");
														$stfee = $stfee[0];
														?>
														<td align="center"><?=$stfee->paidsalary.' /-'?></td>
														<td align="center"><?=$stfee->lastmonthpaid.' /-'?></td>
														<td align="center"><?php if(@$stfee->balancesalary == 0){ echo "<small class='text-green'> Paid ".date('F',strtotime($stfee->paiddate))." </small>"; }else{ echo @$stfee->balancesalary.' /-'; }?></td>
														<td><?=date('d-m-Y',strtotime($stfee->paiddate))?></td>
													</tr>
													<?php $i++;
												}
											}
											?>
											</tbody>
										</table>
									</div>
								<?php } ?>

							<?php }else{ ?>
									<?= $this->Model_dashboard->norecords(); ?>
								<?php }  }else{ ?>
									<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
										<form method="post" action="<?=base_url('dashboard/data/searchResult?search=yes')?>">
											<div class="row justify-content-center align-content-center">
												<div class="col-lg-6 col-md-6 col-sm-11 col-xs-11">
													<div class="form-group has-search">
														<span class="fa fa-search form-control-feedback"></span>
														<input type="text" class="form-control" name="search_name" placeholder="Search with Register Id or Mail or Mobile" />
													</div>
												</div>
											</div>
										</form>
										<div class="" style="margin:40px 0px">
											<center>
												<img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>" style="">
												<h4>Search admissions, employees, Fee details, attendance, etc...</h4>
											</center>
										</div>
									</div>
							<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
<script type="text/javascript">
    $(document).ready(function() {
       /* regexp checkdata */
         var number =  /^[0-9]+$/;
         var regexnum = new RegExp(number);

        $("#SetSubBranchSchooldetails").submit(function(event) {
             event.preventDefault();

			var new_scltype 	=   $("#SchoolType").val();
			var new_firstname   =   $("#RegFname").val();
			var new_lastname 	=   $(".RegLname").val();
			var new_emailid  	=   $("#Regemail").val();
			var new_mobilenum  	=   $("#RegMobile").val();
			var new_address 	=   $("#RegAddress").val();
			//var city    =   $("#city").val();
			var new_country 	=   $("#CountryName").val();
			var new_stateid 	=   $("#StateName").val();
			var new_citydist	=   $("#CityName").val();
			var new_pincode 	=   $("#RegPincode").val();
			var new_aadhaar 	=   $("#AadhaarCard").val();
			var new_branch		=	$("#SclbranchName").val();
			
			var one		=	$("#Num_one").val();
			var two		= 	$("#Num_two").val();
			var three	=	$("#Num_three").val();
			var four	=	$("#Num_four").val();

			var databaind = 'fname = ' + new_firstname + ' lname = ' + new_lastname + ' mobile = ' + new_mobilenum + ' email = '+ new_emailid + ' address = '+ new_address + ' country = '+ new_country +' state = '+ new_stateid + ' city = '+ new_citydist +' pincode = ' + new_pincode + ' aadhaar = '+new_aadhaar + ' Branch = '+ new_branch;
			console.log(databaind);

			if(new_scltype !='' && new_firstname !='' && new_lastname !='' && new_mobilenum !='' && new_emailid != '' && new_address != '' && new_citydist != '' && new_country != '' && new_pincode != '' && new_stateid != '' && new_aadhaar != '' && new_branch != ''){

				if((regexnum.test(one) && one != '') && (regexnum.test(two) && two != '') && (regexnum.test(three) && three != '') && (regexnum.test(four) && four != '')) {
					$("#ErrorMessageSubmiting").text('');
					var fromdata = $("#SetSubBranchSchooldetails").serialize();
					$("#resmessage").text('');
					$("#loader").show();
					$.ajax({
						url: '<?=base_url();?>dashboard/branch/newbranch/saveregister',
						type: 'POST',
						dataType: 'json',
						data: fromdata,
					})
						.done(function (dataresponce) {
							$("#loader").hide();
							console.log(dataresponce);

							if (dataresponce.key == 0) {
								swal({
									title: "Sorry",
									text: dataresponce.message,
									type: "warning",
								});
								$(this).trigger('reset');
								//swal("Sorry", dataresponce.message , "warning");
							} else if (dataresponce.key == 1) {
								$("#4digpin-registerAccount").modal('hide');
								swal({
									title: "success",
									text: dataresponce.message,
									type: "success",
								}, function () {
									$(this).trigger('reset');
									window.location.href = "<?php echo base_url();?>dashboard/branch/branchlist";
								});
							} else {
								swal(dataresponce.message);
							}

						})
						.fail(function (errordata) {
							console.log(errordata);
							$("#loader").hide();
							swal("oops" + errordata + "error");
						});
				}else{
					$("#ErrorMessageSubmiting").text('');
					alert("Please enter valid pin..!");
					//$("#ErrorMessageFourDigitspin").text('Please enter valid pin..!').css('color', 'red');
				}

			}else{
				$('#FourdigpinRegisterAccount').modal('toggle');
				$("#Num_one,#Num_two,#Num_three,#Num_four").val('');
				$("#ErrorMessageSubmiting").text('Please fill all following required fields..!').css('color', 'red');
			}
		});
    });
</script>
