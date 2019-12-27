<style>
	/* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
	#map {
		height: 100%;
	}
	.controls {
		margin-top: 10px;
		border: 1px solid transparent;
		border-radius: 2px 0 0 2px;
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		height: 32px;
		outline: none;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
	}

	#origin-input,
	#destination-input {
		background-color: #fff;
		font-family: Roboto;
		font-size: 15px;
		font-weight: 300;
		/* margin-left: 12px; */
		/* padding: 0 11px 0 13px; */
		text-overflow: ellipsis;
		width: 100%;
	}

	#origin-input:focus,
	#destination-input:focus {
		border-color: #4d90fe;
	}

	#mode-selector {
		color: #fff;
		background-color: #4d90fe;
		margin-left: 12px;
		padding: 5px 11px 0px 11px;
	}

	#mode-selector label {
		font-family: Roboto;
		font-size: 13px;
		font-weight: 300;
	}
</style>
<!-- Container fluid  -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item">Timings</li>
        <li class="breadcrumb-item active">Timings List</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Timings List<small>.</small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="<?=base_url('dashboard/timings/set_timings?sutype=school')?>" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Add / Update School Timings</a>
                            </div>
                            <h4 class="panel-title">School Timings</h4>
                        </div>
                        <div class="panel-body">
                            <?php
                                $schooltimings = $this->Model_dashboard->selectdata('sms_timings',array('school_id'=>$schooldata->school_id, 'branch_id'=>$schooldata->branch_id, 'timingsfor'=>'school', 'status'=>1), 'updated');
                            ?>
                            <div class="table-responsive">
                                <?php if(count($schooltimings) != 0){ ?>
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                        <tr class="text-uppercase">
                                            <th>#</th>
                                            <th>Time Mode</th>
                                            <th>From Time</th>
                                            <th>To Time</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1; foreach($schooltimings as $userdata){ ?>
                                            <tr class="text-uppercase text-info">
                                                <td><?=$i?></td>
                                                <td><?php echo $userdata->timingsfor; ?> Timings</td>
                                                <td><?php echo date('h:i a', strtotime($userdata->fromtime)); ?></td>
                                                <td><?php echo date('h:i a', strtotime($userdata->totime)); ?></td>
                                                <td>
                                                    <center>
                                                        <a href="<?=base_url('dashboard/timings/set_timings?sutype=school')?>" class="text-green" onClick="return confirm('Are you want to edit School Timings..!');"><i class="fa fa-edit fa-dx text-success"></i></a>
                                                    </center>
                                                </td>
                                            </tr>
                                            <?php $i++ ; } ?>
                                        </tbody>
                                    </table>
                                    <p>
                      								<span class="text-warning font-weight-bold">Note : </span> You can't delete school timings once you created. but you can edit school timings at any time.
                      							</p>
                                <?php }else{ ?>
                                     <?= $this->Model_dashboard->norecords(); ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="<?=base_url('dashboard/timings/set_timings?sutype=bus')?>" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Add Bus Timings</a>
                            </div>
                            <h4 class="panel-title">Bus Details & Timings.</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <?php
                                    $bustimings = $this->Model_dashboard->selectdata('sms_bus_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'updated');
                                    if(count($bustimings) != 0){ ?>
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                        <tr class="text-uppercase">
                                            <th>#</th>
                                            <th>Bus Id</th>
                                            <th>GPS</th>
                                            <th>Timings</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1; foreach($bustimings as $userdata){ ?>

											<tr class="text-uppercase text-info">
												<td><?=$i?></td>
												<td><?php echo strtoupper($userdata->bus_number); ?></td>
												<td class="text-center">
													<?php
														if($userdata->gps == 'device_yes'){
															echo $userdata->gps_id;
														}else{ echo 'No GPS'; }
													?>
												</td>
												<td>
													<?php
														$m_timings = unserialize($userdata->morning_timings);
														$m_timings = implode(' - ',$m_timings);
														echo $m_timings;
													?>
												</td>
												<td>
													<center>
														<a href="javascript:;" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#busTimings_<?=$userdata->sno?>" class="text-success"><i class="fa fa-file fa-dx"></i></a> &nbsp;&nbsp;
														<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#EditbusTimings_<?=$userdata->sno?>" class="text-success"><i class="fa fa-edit fa-dx"></i></a> &nbsp;&nbsp;
														<a href="<?=base_url('dashboard/timings/bus/delete/'.$userdata->sno.'/'.$userdata->branch_id.'/'.$userdata->school_id.'/'.$userdata->bus_id)?>" class="text-danger" onClick="return confirm('Are you want to delete <?=$userdata->bus_number?> Details..?');"><i class="fa fa-trash-o fa-dx"></i></a>
													</center>
												</td>
											</tr>
                                            <div class="modal" id="busTimings_<?=$userdata->sno?>">
                                                <div class="modal-dialog modal-lg" style="top:80px">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Bus Details : <?=strtoupper($userdata->bus_number);?></h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-4">
																		<label>Bus Number : <span class="text-success"><?php echo strtoupper($userdata->bus_number); ?></span></label>
                                                                    </div>
																	<div class="col-md-4">
																		<label>
																			GPS : <span class="text-success"><?php
																				if($userdata->gps == 'device_yes'){
																					echo $userdata->gps_id;
																				}else{ echo 'No GPS'; }
																				?></span>
																		</label>
																	</div>
																	<div class="col-md-4">
																		<label>
																			From : <span class="text-success">
																			<?=$userdata->from_location?>
																		</span>
																		</label>
																	</div>
																	<div class="col-md-4">
																		<label>
																			To : <span class="text-success">
																			<?=$userdata->to_location?>
																		</span>
																		</label>
																	</div>
																	<div class="col-md-4">
																		<label>Morning : <span class="text-success">
																			<?php
																			$m_timings = unserialize($userdata->morning_timings);
																			$m_timings = implode(' - ',$m_timings);
																			echo $m_timings;
																			?>
																		</span></label>
																	</div>
																	<div class="col-md-4">
																		<label>Evening : <span class="text-success">
																			<?php
																			$e_timings = unserialize($userdata->evening_timings);
																			$e_timings = implode(' - ',$e_timings);
																			echo $e_timings;
																			?>
																		</span></label>
																	</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

											<div class="modal" id="EditbusTimings_<?=$userdata->sno?>">
												<div class="modal-dialog modal-lg" style="top:20px">
													<div class="modal-content">

														<!-- Modal Header -->
														<div class="modal-header">
															<h4 class="modal-title">Edit Bus Details : <?=strtoupper($userdata->bus_number);?></h4>
															<button type="button" class="close" data-dismiss="modal">&times;</button>
														</div>

														<!-- Modal body -->
														<div class="modal-body">
															<div class="col-md-12">
																<h4 class="text-center text-success">Update Bus Timings</h4>
																<div class="row justify-content-center align-content-center">

																	<div class="col-md-8">
																		<h5 class="text-success">Enter Bus Details : </h5>
																		<form method="post" action="<?=base_url('dashboard/timings/savetimingsdata')?>" class="row">
																			<input type="hidden" value="<?=$userdata->sno?>" name="sno_id">
																			<input type="hidden" value="<?=$userdata->branch_id?>" name="branch_id">
																			<input type="hidden" value="<?=$userdata->school_id?>" name="school_id">
																			<input type="hidden" value="<?=$userdata->bus_id?>" name="bus_id">
																			<input type="hidden" value="bus" name="timing_type">
																			<div class="col-md-12">
																				<div class="row">
																					<div class="col-md-6 form-group">
																						<label>Origin Location</label>
																						<input type="text" name="From_location" value="<?=$userdata->from_location?>" class="form-control controls" placeholder="Enter an origin location" required id="origin-input_<?=$userdata->sno?>">
																					</div>
																					<div class="col-md-6 form-group">
																						<label>Destination Location</label>
																						<input type="text" name="To_location" class="form-control controls" placeholder="Enter a destination location" required  value="<?=$userdata->to_location?>"
																							   id="destination-input_<?=$userdata->sno?>">
																					</div>
																				</div>
																			</div>

																			<div style="display: none">
																				<div id="mode-selector" class="controls">
																					<input type="radio" name="type" id="changemode-walking_<?=$userdata->sno?>" checked="checked">
																					<label for="changemode-walking">Walking</label>

																					<input type="radio" name="type" id="changemode-transit_<?=$userdata->sno?>">
																					<label for="changemode-transit">Transit</label>

																					<input type="radio" name="type" id="changemode-driving_<?=$userdata->sno?>">
																					<label for="changemode-driving">Driving</label>
																				</div>
																			</div>


																			<div class="col-md-12">
																				<div class="row align-content-center justify-content-center">
																					<div class="col-md-6 form-group">
																						<label>Bus Registration Number</label>
																						<input type="text" required name="Bus_Number" class="form-control text-uppercase" placeholder="Bus Number Ex : AP07BR2602" value="<?=$userdata->bus_number?>" id="Bus_Number_<?=$userdata->sno?>">
																					</div>
																				</div>
																			</div>

																			<div class="col-md-12 mb-3">
																				<div class="row align-content-center justify-content-center">
																					<div class="custom-control custom-checkbox">
																						<input type="checkbox" class="custom-control-input"  <?php if($userdata->gps == 'device_yes'){ echo 'checked'; } ?>
                                                                                         id="EnableGPSDevice_<?=$userdata->sno?>" name="enable_device" value="">
																						<label class="custom-control-label" style="padding: 3px;" for="EnableGPSDevice_<?=$userdata->sno?>">Do You Enable GPS Device To Track Live Location..?</label>
																					</div>
																				</div>
																			</div>

																			<div class="col-md-12" id="EnableGPSDevice_Box_<?=$userdata->sno?>">
																				<div class="row align-content-center justify-content-center">
																					<div class="col-md-6 form-group">
																						<label>Enter GPS Device id : </label>
																						<input type="text" id="GPS_device_id_<?=$userdata->sno?>" name="Enter_gps_device_id" class="form-control" placeholder="Enter GPS Device id" value="<?=$userdata->gps_id?>">
																					</div>
																				</div>
																			</div>

																			<script>
																				$(document).ready(function () {
																					$('#EnableGPSDevice_<?=$userdata->sno?>').val('device_no');
																					$('#EnableGPSDevice_Box_<?=$userdata->sno?>').hide();
																					if($("#EnableGPSDevice_<?=$userdata->sno?>").is(':checked') === true){
																						$('#EnableGPSDevice_<?=$userdata->sno?>').val('device_yes');
																						$('#EnableGPSDevice_Box_<?=$userdata->sno?>').show();
																						$('#GPS_device_id_<?=$userdata->sno?>').attr('required','required');
																						$('GPS_device_id_<?=$userdata->sno?>').val();
																					}else{
																						$('#EnableGPSDevice_Box_<?=$userdata->sno?>').hide();
																						$('#EnableGPSDevice_<?=$userdata->sno?>').val('device_no');
																						$('#GPS_device_id_<?=$userdata->sno?>').removeAttr('required');
																						$('GPS_device_id_<?=$userdata->sno?>').val('');
																					}
																					$("#EnableGPSDevice_<?=$userdata->sno?>").click(function () {
																						if($(this).is(':checked') === true){
																							$('#EnableGPSDevice_<?=$userdata->sno?>').val('device_yes');
																							$('#EnableGPSDevice_Box_<?=$userdata->sno?>').show();
																							$('#GPS_device_id_<?=$userdata->sno?>').attr('required','required');
																							$('GPS_device_id_<?=$userdata->sno?>').val();
																						}else{
																							$('#EnableGPSDevice_Box_<?=$userdata->sno?>').hide();
																							$('#EnableGPSDevice_<?=$userdata->sno?>').val('device_no');
																							$('#GPS_device_id_<?=$userdata->sno?>').removeAttr('required');
																							$('GPS_device_id_<?=$userdata->sno?>').val('');
																						}
																					})
																				})
																			</script>
																			<div class="col-md-12">
																				<div class="row align-content-center justify-content-center">
																					<?php
																						//m-from time
																						if(!empty($userdata->morning_timings)){
																							$mng_timings = unserialize($userdata->morning_timings);
																							$mng_from_time	= date('h:i a',strtotime($mng_timings['from']));
																							$mng_to_time	= date('h:i a',strtotime($mng_timings['to']));
																							?>
																							<script>
																								$(document).ready(function () {
																									$('#M_From_Time_<?=$userdata->sno?>').timepicker({defaultTime: '<?=$mng_from_time?>'});
																									$('#M_To_Time_<?=$userdata->sno?>').timepicker({defaultTime: '<?=$mng_to_time?>'});
																								})
																							</script>
																						<?php }else{
																							$mng_from_time 	= 	'';
																							$mng_to_time	=	'';
																						}
																						//m-from time
																						if(!empty($userdata->evening_timings)){
																							$evg_timings = unserialize($userdata->evening_timings);
																							$evg_from_time	= date('h:i a',strtotime($evg_timings['from']));
																							$evg_to_time	= date('h:i a',strtotime($evg_timings['to']));
																						?>
																						<script>
																							$(document).ready(function () {
																								$('#E_From_Time_<?=$userdata->sno?>').timepicker({defaultTime: '<?=$evg_from_time?>'});
																								$('#E_To_Time_<?=$userdata->sno?>').timepicker({defaultTime: '<?=$evg_to_time?>'});
																							})
																						</script>
																					<?php }else{
																						$evg_from_time	=	'';
																						$evg_to_time	=	'';
																					} ?>
																					<div class="col-md-6">
																						<div class="row">
																							<h6 class="text-success col-12 text-center">Morning Timings</h6>
																							<div class="col-xs-12 col-md-6 form-group">
																								<label>From Time</label>
																								<input type="text" name="mng_from_time" value="<?=$mng_from_time?>" class="form-control mytimepicker" id="M_From_Time_<?=$userdata->sno?>" placeholder="From Time">
																							</div>
																							<div class="col-xs-12 col-md-6 form-group">
																								<label>To Time</label>
																								<input type="text" name="mng_to_time" value="<?=$mng_to_time?>" class="form-control mytimepicker" id="M_To_Time_<?=$userdata->sno?>"  placeholder="To Time">
																							</div>
																						</div>
																					</div>
																					<div class="col-md-6">
																						<div class="row">
																							<h6 class="text-success col-12 text-center">Evening Timings</h6>
																							<div class="col-xs-12 col-md-6 form-group">
																								<label>From Time</label>
																								<input type="text" name="evn_from_time" value="<?=$evg_from_time?>" class="form-control mytimepicker" id="E_From_Time_<?=$userdata->sno?>" placeholder="From Time">
																							</div>
																							<div class="col-xs-12 col-md-6 form-group">
																								<label>To Time</label>
																								<input type="text" name="evn_to_time" value="<?=$evg_to_time?>" class="form-control mytimepicker" id="E_To_Time_<?=$userdata->sno?>"  placeholder="To Time">
																							</div>
																						</div>
																					</div>

																				</div>
																			</div>
																			<div class="col-md-12">
																				<div class="row align-content-center justify-content-center">
																					<input type="submit" name="busdetails" value="Update Bus Details" class="btn btn-success">
																				</div>
																			</div>
																		</form>
																	</div>

																	<div class="col-md-12">
																		<div id="map"></div>
																	</div>
																</div>
															</div>
														</div>

													</div>
												</div>
											</div>
                                        <?php  $i++ ;} ?>
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
        </div>

        <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="<?=base_url('dashboard/timings/set_timings?sutype=class')?>" class="btn btn-xs btn-success"><i class="fa fa-plus"></i> Add / Update Class Timings</a>
                    </div>
                    <h4 class="panel-title">Class Timings List</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <?php
                            $classtimings = $this->Model_dashboard->customquery("SELECT * FROM sms_timings GROUP BY section,class HAVING branch_id = '".$schooldata->branch_id."' AND school_id = '".$schooldata->school_id."' AND timingsfor = 'class' ORDER BY section,class, COUNT(sno) ASC");
                            //print_r($classtimings);
                            if(count($classtimings) != 0){ ?>
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                <tr class="text-uppercase">
                                    <th>#</th>
                                    <th>Syllabus</th>
                                    <th>Section</th>
                                    <th>Day</th>
                                    <th>Timetable</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1; foreach($classtimings as $userdata){
                                    $syllubasname = $this->Model_dashboard->syllabusname(array('id'=>$userdata->syllabus_type));
                                    $dayclass = $this->Model_dashboard->selectdata('sms_formdata',array('id'=>$userdata->day_class));
                                    ?>
                                    <tr class="text-uppercase text-green">
                                        <td><?=$i++?></td>
                                        <td><?= $syllubasname[0]->type.' - '.$userdata->class; ?></td>
                                        <td align="center"><?php echo $userdata->section.' - Sec'; ?></td>
                                        <td><?php echo $dayclass[0]->name.',..'; ?></td>
                                        <td align="center"><a href="javascript:(0)" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#<?=$syllubasname[0]->type.'_'.$userdata->class.'_'.$userdata->section.'_'.$dayclass[0]->name?>"><?=$userdata->titlesubject.',...'; ?></a></td>
                                        <td>
                                            <center>
                                                <a href="<?=base_url('dashboard/timings/classtiming/delete/'.$userdata->syllabus_type.'/'.$userdata->class.'/'.$userdata->section.'/'.$userdata->branch_id.'/'.$userdata->school_id)?>" onclick="return confirm('Are you want to delete <?= $syllubasname[0]->type.' - '.$userdata->class.' Class - '.$userdata->section; ?> Section Timetable..?')"  class="text-green" onClick="return confirm('Are you want to delete Timetable..?');"><i class="fa fa-trash-o fa-dx text-danger"></i></a>
                                            </center>
                                        </td>
                                    </tr>

                                <?php } ?>
                                </tbody>
                            </table>
                            <?php foreach($classtimings as $userdata){
                                $syllubasname = $this->Model_dashboard->syllabusname(array('id'=>$userdata->syllabus_type));
                                $dayclass = $this->Model_dashboard->selectdata('sms_formdata',array('id'=>$userdata->day_class));
                            ?>
                                <!-- Timetable Details -->
                								<div class="modal" id="<?=$syllubasname[0]->type.'_'.$userdata->class.'_'.$userdata->section.'_'.$dayclass[0]->name?>">
                								  <div class="modal-dialog modal-lg" style="margin-top: 80px">
                									<div class="modal-content">

                									  <!-- Modal Header -->
                									  <div class="modal-header">
                										<h4 class="modal-title"><?=$syllubasname[0]->type.' - '.$userdata->class.' ('.$userdata->section.')';?></h4>
                										<button type="button" class="close" data-dismiss="modal">&times;</button>
                									  </div>

                									  <!-- Modal body -->
                									  <div class="modal-body">
                										<?php
                											$dayslist = $this->Model_dashboard->selectorderby('sms_formdata',array('type'=>'days','status'=>1), 'id ASC');

                											$timetable   =  $this->Model_dashboard->selectorderby('sms_timings',array('school_id'=>$schooldata->school_id, 'branch_id'=>$schooldata->branch_id, 'timingsfor'=>'class', 'class'=>$userdata->class, 'section'=>$userdata->section,'syllabus_type'=>$userdata->syllabus_type,'status'=>1), 'TIME_FORMAT(fromtime, "%H:%i") ASC');
                											$days = array();

                											//seperite data
                											$subjects   =   array();
                											$from_time  =   array();
                											$to_time    =   array();
                											$timingslist=   array();
                											$day        =   array();
                											foreach($timetable as $key => $timings){
                											   $subjects[]    =   array("$timings->day_class"=>$timings->titlesubject);
                											   $from_time[]   =   $timings->fromtime;
                											   $to_time[]     =   $timings->totime;
                											   if(!in_array($timings->day_class,$day)){
                												   $day[]   =   $timings->day_class;
                											   }
                											}

                											foreach($dayslist as $daysname){
                												$days[$daysname->id]    =   $daysname->name;
                											}

                											/*echo "<pre>";
                											print_r($dayslist);
                											print_r($subjects);
                											print_r($from_time);
                											print_r($to_time);
                											echo "</pre>";*/
                											foreach($day as $key => $value){
                										?>
                                      <div style="width: fit-content;float: right;">
                                        <a href="<?=base_url('dashboard/timings/classtimings/delete/'.$value.'/'.$userdata->syllabus_type.'/'.$userdata->class.'/'.$userdata->section.'/'.$userdata->branch_id.'/'.$userdata->school_id)?>" class="pull-right" onclick="return confirm('Are you want to delete <?=$days[$value]?> Timings from <?= $syllubasname[0]->type.' - '.$userdata->class.' Class - '.$userdata->section; ?> Section Timetable..?')">
                                          <i class="fa fa-trash-o fa-dx"></i>
                                        </a>
                                      </div>
                										  <table class="table table-bordered table-striped">
                											  <thead>
                												  <th>Day</th>
                												  <?php foreach($timetable as $key => $timings){
                														if($timings->day_class == $value){
                															echo "<th>".$timings->titlesubject."</th>";
                														}
                												   } ?>
                											  </thead>
                											  <tbody>

                												<tr>
                												  <td class="text-success"><?=$days[$value]?></td>
                												  <?php foreach($timetable as $key => $timings){
                														if($timings->day_class == $value){ ?>
                													<th class='text-uppercase text-center p-5'>
                														<?=date('h:i',strtotime($timings->fromtime))?>
                														<small><?=date('a',strtotime($timings->fromtime))?></small>
                														<br>
                														<?=date('h:i',strtotime($timings->totime))?>
                														<small><?=date('a',strtotime($timings->totime))?></small>
                													</th>
                														<?php }
                												   } ?>
                												</tr>

                											  </tbody>
                										  </table>
                										  <?php } ?>
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
<script>
    $(document).ready(function(){
        //sections
        /* class section */
        function classselection(classname,selsection){
            if(classname == "" || selsection == ""){
                return false;
                $(this).focus();
            }else{
                $.ajax({
                    url:"smstimingajax.php",
                    type:"post",
                    data:{classname:classname,selsection:selsection},
                    success:function(successdata){
                        console.log(successdata);
                        $("#sectionlist").html(successdata);
                    }
                })
            }
        }
        var classname = $('#classname').val();
        var selsection = $("#selsection").val();
        classselection(classname,selsection);

        $("#classname").change(function(){
            var classname = $(this).val();
            classselection(classname,selsection);
        })
        //subjects
        function selectsubject(classname,selsection,selsubject){
            console.log(classname + selsection + selsubject);
            if(classname == "" || selsection == "" || selsubject == ""){
                return false;
                $(this).focus();
            }else{
                $.ajax({
                    url:"smstimingajax.php",
                    type:"post",
                    data:{classsubjects:classname,mysection:selsection,subjectid:selsubject},
                    success:function(successsubject){
                        console.log(successsubject);
                        $("#subjectlist").html(successsubject);
                    }
                })
            }
        }
        var selsubject = $("#selsubject").val(); //not req
        selectsubject(classname,selsection,selsubject);

        $("#sectionlist").change(function(){
            var classname = $('#classname').val();
            var selsection = $(this).val();
            selectsubject(classname,selsection,selsubject);
        })

        //disable function
        function disablefunction(sectionlist){
            if(sectionlist == ''){
                $("#subjectlist").prop('disabled',true);
            }else{
                $("#subjectlist").prop('disabled',false);
            }
        }
        var sectionlist = $("#selsection").val();
        disablefunction(sectionlist)

        $("#sectionlist").on('change',function(){
            var sectionlist = $(this).val();
            $("#subjectlist").val("");
            disablefunction(sectionlist)
        });

        /*$("#fromtime,#totime").blur(function(){
            var fromtime = $('#fromtime').val();
            var totime = $('#totime').val();
            if(fromtime == "" || totime == ""){
                $(this).focusin();
                return false;
            }else{
                $("#submittimetable").show();
            }
        })*/
    })

    $(document).ready(function(){

        $('#useraccountinfo').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'bSort' : false
        });

        setTimeout(function(){
            $(".alert").fadeTo(1000, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 1500);

    });

    $(document).ready(function(){
        //function to hide
        //$("#timings").hide().val("");
        function settingtimings(settimings){
            if(settimings == "null"){
                $(this).focus();
                $("#timings").hide().val("");
                $("#otherbox").hide().val("");
                $("#classtimings").hide().val("");
                $("#contentbox").hide().val("");
                $("#busnumber").hide().val("");
                return false;
            }else if(settimings == "other"){
                $("#otherbox").show().val("");
                $("#timings").show().val("");
                $("#classtimings").hide().val("");
                $("#contentbox").hide().val("");
                $("#busnumber").hide().val("");
            }else if(settimings == "school"){
                $("#otherbox").hide().val("");
                $("#timings").show().val("");
                $("#classtimings").hide().val("");
                $("#contentbox").hide().val("");
                $("#busnumber").hide().val("");
            }else if(settimings == "class"){
                $("#otherbox").hide().val("");
                $("#timings").hide().val("");
                $("#classtimings").show().val("");
                $("#contentbox").hide().val("");
                $("#busnumber").hide().val("");
            }else if(settimings == "dailyservice"){
                $("#otherbox").show().val("");
                $("#timings").show().val("");
                $("#classtimings").hide().val("");
                $("#contentbox").hide().val("");
                $("#busnumber").show().val("");
            }
        }
        var settimings = $("#settimings").val();
        settingtimings(settimings);
        $("#settimings").change(function(){
            var settimings = $(this).val();
            $("#subjectlist,#classname,#sectionlist").val("");
            settingtimings(settimings);
        })

        //subject time set
        function timeseting(subjectlist){
            if(subjectlist == ""){
                return false;
                $(this).focusin();
            }else if(subjectlist == "addnewsubject"){
                $("#otherbox").show();
                $("#timings").show();
            }else{
                $("#timings").show();
                $("#otherbox").hide().val("");
            }
        }

        var subjectlist = $("#selsubject").val();
        timeseting(subjectlist);

        $("#subjectlist").change(function(){
            var subjectlist = $(this).val();
            timeseting(subjectlist);
        })


        //subject teacher

        $("#subjectlist").on('change',function(){
            var subjectlist = $(this).val();
            var classname = $("#classname").val();
            if(classname == ''){
                $("#classname").focus();
            }else{
                $.ajax({
                    url:"smstimingajax.php",
                    type:"POST",
                    data:{clssubject:subjectlist,clsname:classname},
                    success:function(sucesdata){
                        console.log(sucesdata);
                        $("#stafflist").html(sucesdata);
                    }
                });
            }
        });
    });
</script>
