<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';
class Sms_timings extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->isLoggedIn();
        $this->load->model('Model_default');
        $this->load->model('Model_integrate');
        $this->load->model('Model_dashboard');
    }

    //enote for superadmin or admin only to save guide for like prof
    public function index(){
        $this->timings();
    }

    //timings for admin and superadmin
    public function timings(){
        $data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "Timings..!";
        //getting school data in session
        $schooldata = $data['schooldata'] = $this->session->userdata['school'];
        //sending syllabus data to views and getting class data by ajax
        $data['syllabus'] = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
        $data['timingslist'] = $this->Model_dashboard->selectdata('sms_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'updated');
        $data['timings'] = $this->Model_dashboard->selectorderby('sms_formdata',array('type'=>'timings','status'=>1),'id');
        $data['schooldata'] = $schooldata;
        $this->loadViews('admin/timings/sms_timings_page',$data);

    }

    //New Timings set
	public function SetNewtimings(){
        extract($_REQUEST);
        if(isset($sutype) && $sutype != ''){
            $data['sutype'] =   $sutype;
        }else{
            $data['sutype'] =   '';
        }
		$data['userdata'] = $this->Model_integrate->userdata();
		$data['PageTitle'] = "Set or Update Timings..!";
		//getting school data in session
		$schooldata = $this->session->userdata['school'];
		//sending syllabus data to views and getting class data by ajax
		$data['syllabus'] = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
		$data['timingslist'] = $this->Model_dashboard->selectdata('sms_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'sno');
		$data['timings'] = $this->Model_dashboard->selectorderby('sms_formdata',array('type'=>'timings','status'=>1),'id');
		$data['schooldata'] = $schooldata;
		$this->loadViews('admin/timings/sms_New_timings_page',$data);
	}

    //ajax fields
	public function timingsFields(){
		  $timingtype = '';
		  extract($_REQUEST);
		  //$this->print_r($_REQUEST);
		  $schooldata = $this->session->userdata['school'];
		  $schoolid =	$schooldata->school_id;
		  $branchid =	$schooldata->branch_id;
		  $schooladdress  = $schooldata->school_address;
			//$timings = $this->Model_dashboard->selectorderby('sms_formdata',array('type'=>'timings','status'=>1),'id');
		if($timingtype == 'school'){ ?>

			<div class="col-md-12 mt-3">
				<h4 class="text-center text-success">Set School Timings</h4>
				<?php
				$school = $this->Model_dashboard->selectdata('sms_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'timingsfor'=>'school'),'sno');
				if(count($school) != 0){ ?>

					<h6 class="text-center text-red">School Timings are already set. If you want Update Timings..</h6>
					<div class="row justify-content-center align-items-center">
						<div class="col-xs-12 col-md-3">
							<div class="form-group">
								<label>From Time</label>
								<input type="text" name="fromtime" class="form-control text-uppercase" placeholder="Enter from time" value="<?=date('h:i a',strtotime($school[0]->fromtime))?>" required>
							</div>
						</div>
						<div class="col-xs-12 col-md-3">
							<div class="form-group">
								<label>To Time</label>
								<input type="text" name="totime" class="form-control text-uppercase" placeholder="Enter tos time" value="<?=date('h:i a',strtotime($school[0]->totime))?>" required>
							</div>
						</div>
					</div>

				<?php }else{ ?>

					<div class="row justify-content-center align-items-center">
						<div class="col-xs-12 col-md-4">
							<div class="form-group">
								<label>From Time</label>
								<input type="text" name="fromtime" class="form-control mytimepicker" placeholder="Enter from time" required>
							</div>
						</div>
						<div class="col-xs-12 col-md-4">
							<div class="form-group">
								<label>To Time</label>
								<input type="text" name="totime" class="form-control mytimepicker" placeholder="Enter tos time" required>
							</div>
						</div>
					</div>

				<?php } ?>
				<div class="row justify-content-center align-items-center">
					<input type="submit" name="saveschooltimings" value="Save School Timings" class="btn btn-success">
				</div>
			</div>

		<?php }else if($timingtype == 'class'){ ?>

			<div class="col-md-12 mt-3">
				<h4 class="text-center text-success">Set Class Timings</h4>
				<div class="row justify-content-center align-items-center">
					<?php $syllabus = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id); ?>

					<div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<label for="sclsyllabuslist">Student Syllabus</label>
						<select type="text" name="StdSyllubas" id="sclsyllubaslist" class="form-control" style="padding:5px !important;">
							<option value="">Select Syllabus Type</option>
							<?php foreach ($syllabus as $key => $value) { ?>
								<option value="<?= $key ?>"><?= $value ?></option>
							<?php } ?>
						</select>
					</div>

					<div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<label for="SyllabusClasses">Student Class</label>
						<select type="text" name="StdClass" id="SyllabusClasses" class="form-control" style="padding:0px 10px">
							<option value="">Select Class</option>
						</select>
					</div>

					<div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
						<label for="SyllabusClasses">Student Class Sections</label>
						<select type="text" name="StdClassSection" id="SyllabusClassesSections" class="form-control" style="padding:0px 10px">
							<option value="">Select Class Section</option>
						</select>
					</div>

				</div>
				<div class="row justify-content-center align-items-center">
					<div class="col-md-12" id="SubjectPeriodsTimingsList">
						<center>
							<h4>Please select following options To Set Class Timings...</h4>
							<img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>" style="">
						</center>
					</div>
				</div>
				<script>
					$(document).ready(function () {

						$('#SyllabusClasses').change(function () {
							$("#loader").show();
							var classname 	 = $(this).val();
							var syllabusname = $("#sclsyllubaslist").val();
							if(classname != '' && syllabusname != ''){
								var request = $.ajax({
									url: "<?=base_url('dashboard/class/sectionslist')?>",
									type: "POST",
									data: {classname : classname,syllabustype : syllabusname,requesttype:'class_sections',schoolid:"<?=$schoolid?>",branchid:"<?=$branchid?>"},
									dataType: "json"
								});

								request.done(function(dataresponce) {
									console.log(dataresponce);
									$("#loader").hide();
									$("#SyllabusClassesSections").children('option:not(:first)').remove();
									var list = "";
									for($l = 0; dataresponce.length > $l; $l++){
										list += "<option value='"+ dataresponce[$l] +"'>"+ dataresponce[$l] + " Section "+"</option>";
									}
									$("#SyllabusClassesSections").append(list);
								});

								request.fail(function(jqXHR, textStatus) {
									$("#loader").hide();
									alert( "Request failed: " + textStatus );
								});
							}else{
								$("#loader").hide();
								alert('Please select syllabus and class..!');
							}
						});

						$("#SyllabusClassesSections").change(function () {
							var classsections				=	$(this).val();
							var subject_classtimings_for	=	$('#SyllabusClasses').val();
							var syllabus_to_getdata			=	$("#sclsyllubaslist").val();
							if(subject_classtimings_for != '' && syllabus_to_getdata != ''){
								console.log(syllabus_to_getdata + ' - ' + subject_classtimings_for);
								var request = $.ajax({
									url: "<?=base_url('dashboard/timings/classsubjectstimingslist')?>",
									type: "POST",
									data: {classname : subject_classtimings_for,syllabustype : syllabus_to_getdata,requesttype:'classperiods',classsection:classsections},
									//dataType: "json"
								});

								request.done(function(datareserved) {
									$("#SubjectPeriodsTimingsList").html(datareserved);
								});

								request.fail(function(jqXHR, textStatus) {
									$("#SubjectPeriodsTimingsList").html( "Request failed: " + textStatus );
								});
							}else{
								alert('Please select syllabus and class..!');
							}
						})
					})
				</script>
			</div>


		<?php }else if($timingtype == 'bus'){ ?>

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

			<div class="col-md-12 mt-3">
				<h4 class="text-center text-success">Set Bus Timings</h4>
				<div class="row">

					<div class="col-md-6">
						<h5 class="text-success">Enter Bus Details : </h5>

						<div class="row">

							<div class="col-md-6 form-group">
								<label>Origin Location</label>
								<input type="text" name="From_location" value="<?=$schooladdress?>" class="form-control controls" placeholder="Enter an origin location" required id="origin-input">
							</div>
							<div class="col-md-6 form-group">
								<label>Destination Location</label>
								<input type="text" name="To_location" class="form-control controls" placeholder="Enter a destination location" required id="destination-input">
							</div>

							<div style="display: none">
								<div id="mode-selector" class="controls">
									<input type="radio" name="type" id="changemode-walking" checked="checked">
									<label for="changemode-walking">Walking</label>

									<input type="radio" name="type" id="changemode-transit">
									<label for="changemode-transit">Transit</label>

									<input type="radio" name="type" id="changemode-driving">
									<label for="changemode-driving">Driving</label>
								</div>
							</div>


							<div class="col-md-12">
								<div class="row align-content-center justify-content-center">
									<div class="col-md-6 form-group">
										<label>Bus Registration Number</label>
										<input type="text" required name="Bus_Number" class="form-control text-uppercase" placeholder="Bus Number Ex : AP07BR2602">
									</div>
								</div>
							</div>

							<div class="col-md-12 mb-3">
								<div class="row align-content-center justify-content-center">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="EnableGPSDevice" name="enable_device" value="">
										<label class="custom-control-label" style="padding: 3px;" for="EnableGPSDevice">Do You Enable GPS Device To Track Live Location..?</label>
									</div>
								</div>
							</div>

							<div class="col-md-12" id="EnableGPSDevice_Box">
								<div class="row align-content-center justify-content-center">
									<div class="col-md-6 form-group">
										<label>Enter GPS Device id : </label>
										<input type="text" id="GPS_device_id" name="Enter_gps_device_id" class="form-control" placeholder="Enter GPS Device id">
									</div>
								</div>
							</div>

							<script>
								$(document).ready(function () {
									$('#EnableGPSDevice').val('device_no');
									$('#EnableGPSDevice_Box').hide();
									$("#EnableGPSDevice").click(function () {
										if($(this).is(':checked') === true){
											$('#EnableGPSDevice').val('device_yes');
											$('#EnableGPSDevice_Box').show();
											$('#GPS_device_id').attr('required','required');
										}else{
											$('#EnableGPSDevice_Box').hide();
											$('#EnableGPSDevice').val('device_no');
											$('#GPS_device_id').removeAttr('required');
										}
									})
								})
							</script>
							<div class="col-md-12">
								<div class="row align-content-center justify-content-center">
									<div class="col-md-6">
										<div class="row">
											<h6 class="text-success col-12 text-center">Morning Timings</h6>
											<div class="col-xs-12 col-md-6 form-group">
												<label>From Time</label>
												<input type="text" name="mng_from_time" class="form-control mytimepicker" id="From_Time" placeholder="From Time">
											</div>
											<div class="col-xs-12 col-md-6 form-group">
												<label>To Time</label>
												<input type="text" name="mng_to_time" class="form-control mytimepicker" id="To_Time"  placeholder="To Time">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<h6 class="text-success col-12 text-center">Evening Timings</h6>
											<div class="col-xs-12 col-md-6 form-group">
												<label>From Time</label>
												<input type="text" name="evn_from_time" class="form-control mytimepicker" id="From_Time" placeholder="From Time">
											</div>
											<div class="col-xs-12 col-md-6 form-group">
												<label>To Time</label>
												<input type="text" name="evn_to_time" class="form-control mytimepicker" id="To_Time"  placeholder="To Time">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="row align-content-center justify-content-center">
									<input type="submit" name="busdetails" value="Save Bus Details" class="btn btn-success">
								</div>
							</div>
						</div>

					</div>




					<div class="col-md-6">
						<div id="map"></div>
					</div>
				</div>
			</div>

			<script>
				// This example requires the Places library. Include the libraries=places
				// parameter when you first load the API. For example:
				// <script
				// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

				/*function initMap() {
					var map = new google.maps.Map(document.getElementById('map'), {
						mapTypeControl: false,
						center: {lat: -33.8688, lng: 151.2195},
						zoom: 13
					});

					new AutocompleteDirectionsHandler(map);
				} */

				/**
				 * @constructor
				 */
				function AutocompleteDirectionsHandler(map) {
					this.map = map;
					this.originPlaceId = null;
					this.destinationPlaceId = null;
					this.travelMode = 'WALKING';
					this.directionsService = new google.maps.DirectionsService;
					this.directionsDisplay = new google.maps.DirectionsRenderer;
					this.directionsDisplay.setMap(map);

					var originInput = document.getElementById('origin-input');
					var destinationInput = document.getElementById('destination-input');
					var modeSelector = document.getElementById('mode-selector');

					var originAutocomplete = new google.maps.places.Autocomplete(originInput);
					// Specify just the place data fields that you need.
					originAutocomplete.setFields(['place_id']);

					var destinationAutocomplete =
						new google.maps.places.Autocomplete(destinationInput);
					// Specify just the place data fields that you need.
					destinationAutocomplete.setFields(['place_id']);

					this.setupClickListener('changemode-walking', 'WALKING');
					this.setupClickListener('changemode-transit', 'TRANSIT');
					this.setupClickListener('changemode-driving', 'DRIVING');

					this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
					this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');

					this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(originInput);
					this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(
						destinationInput);
					this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(modeSelector);
				}

				// Sets a listener on a radio button to change the filter type on Places
				// Autocomplete.
				AutocompleteDirectionsHandler.prototype.setupClickListener = function(
					id, mode) {
					var radioButton = document.getElementById(id);
					var me = this;

					radioButton.addEventListener('click', function() {
						me.travelMode = mode;
						me.route();
					});
				};

				AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(
					autocomplete, mode) {
					var me = this;
					autocomplete.bindTo('bounds', this.map);

					autocomplete.addListener('place_changed', function() {
						var place = autocomplete.getPlace();

						if (!place.place_id) {
							window.alert('Please select an option from the dropdown list.');
							return;
						}
						if (mode === 'ORIG') {
							me.originPlaceId = place.place_id;
						} else {
							me.destinationPlaceId = place.place_id;
						}
						me.route();
					});
				};

				AutocompleteDirectionsHandler.prototype.route = function() {
					if (!this.originPlaceId || !this.destinationPlaceId) {
						return;
					}
					var me = this;

					this.directionsService.route(
						{
							origin: {'placeId': this.originPlaceId},
							destination: {'placeId': this.destinationPlaceId},
							travelMode: this.travelMode
						},
						function(response, status) {
							if (status === 'OK') {
								me.directionsDisplay.setDirections(response);
							} else {
								window.alert('Directions request failed due to ' + status);
							}
						});
				};
			</script>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBy0rhiHQbQ_FYNmzwNa47yzzDYrVMTnaE&libraries=places&callback=initMap" async defer></script>

		<?php }else if($timingtype == 'exam'){ ?>

			<div class="col-md-12 mt-3">
				<h4 class="text-center text-success">Set Exam Timings</h4>
				<div class="row">

					<div class="col-md-4">
						<div class="row">
							<h5 class="text-success">Create Examination Slab's</h5>
							<div class="col-md-12">
								 <div class="row">
									 <input type="hidden" value="" name="exam_type_slabs" id="exam_type_slabs">
									 <div class="col-md-12 form-group">
										 <div class="row">
											 <div class="col-md-6">
												 <label for="CreateExaminationSlab">Enter Slab Name ( <small>Ex: First UnitTest,Second UnitTest,...</small> )</label>
												 <input type="text" class="form-control" placeholder="Enter Slab Name. Ex: First UnitTest,Second UnitTest,.." id="CreateExaminationSlab" name="slab_name">
											 </div>
											 <div class="col-md-6">
												 <label for="ExaminationsPerDay">Enter No.of Exams per Day ( <small>Ex: 1 or 2</small> )</label>
												 <input type="tel" min="1" name="slab_examsperday" max="2" maxlength="1" class="form-control" placeholder="Enter No.of Exams Per Day Ex: 1 or 2" id="ExaminationsPerDay">
											 </div>
										 </div>
										 <div class="row align-content-center justify-content-center" id="ExamTimingsSetBox"></div>
										 <div class="col-md-12 mt-3" id="SubmitSlabButton">
											 <center><input type="submit" class="btn btn-success" value="Save Slab Details"></center>
										 </div>
										 <script>
											 $(document).ready(function () {
												 $("#SubmitSlabButton").hide();
												 $("#exam_type_slabs").val('');
												 $("#exam_type_slabs").removeAttr('name');
												 $("#ExaminationsPerDay").on('keyup',function () {
													 var ExaminationsPerDay = $(this).val();
													 if(ExaminationsPerDay != '' || ExaminationsPerDay != 0) {
														 var numtext = '';
														 var AppendTimingsData = '<div class="col-md-12 mt-2"><h6 class="text-success"> '+ numtext +' Exam Timings</h6><div class="col-md-12"><div class="row"><div class="col-6"><label for="ExamFromTime_'+ExaminationsPerDay+'">From Time</label><input type="text" name="FromTime[]" class="form-control mytimepickers" placeholder="Pick From Time" required></div><div class="col-6"><label for="ExamToTime_'+ExaminationsPerDay+'">To Time</label><input type="text" class="form-control mytimepickers" required name="ToTime[]" placeholder="Pick To Time"></div></div></div></div>';

														 var i;
														 for(i = 0;i < ExaminationsPerDay; i++){
															if(ExaminationsPerDay <= 2) {
																$("#ExamTimingsSetBox").append(AppendTimingsData);
															}
														 }

														 $("#exam_type_slabs").attr('name','exam_type_slabs');
														 $("#exam_type_slabs").val('slabs');
														 $("#SubmitSlabButton").show();
													 }else{
														 alert('Please Enter No.of Exams Per Day..!');
														 $('#ExamTimingsSetBox').html('');
														 $("#exam_type_slabs").removeAttr('name');
														 $("#exam_type_slabs").val('');
														 $("#SubmitSlabButton").hide();
													 }
												 });

												 var slabname 	= 	$("#CreateExaminationSlab").val();
												 var slabdays	=	$("#ExaminationsPerDay").val();
												 if(slabname != '' && slabdays != ''){
													 $("#exam_type_slabs").attr('name','exam_type_slabs');
													 $("#exam_type_slabs").val('slabs');
												 }else{
													 $("#exam_type_slabs").removeAttr('name');
													 $("#exam_type_slabs").val('');
												 }

											 })
										 </script>
									 </div>
								 </div>
							</div>
						</div>

						<div class="row mt-3">
							<h5 class="text-success">Recent Created Slab's List</h5>
							<?php
							$slabslist = $this->Model_dashboard->selectorderby('sms_examination_slabs_list',array('school_id'=>$schoolid,'branch_id'=>$branchid,'status'=>1),'updated');
							if(count($slabslist) != 0){ ?>
								<div class="table-responsive">
									<table class="table table-bordered table-striped">
										<thead>
											<th>#</th>
											<th>Slab Id</th>
											<th>Slab Name</th>
										</thead>
										<tbody>
											<?php $i = 1; foreach ($slabslist as $value){ ?>
												<tr>
													<td><?=$i++;?></td>
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
						<div class="row mt-3">
							<p>
								<span class="text-warning">Note : </span>
							</p>
						</div>
					</div>

					<div class="col-md-8">
						<input type="hidden" value="exam_timetable" name="exam_type" id="exam_timetable">
						<?php if(count($slabslist) != 0){ ?>
							<h5 class="text-info">Created Examination TimeTable</h5>
							<div class="row">
								<div class="form-group col-xs-12 col-sm-6 col-md-3">
									<label>Select Exam Slab</label>
									<select class="form-control" name="Exam_selected_slab" required="required" id="ExamSelectedSlab">
										<option value="">Please select slab</option>
										<?php $is = 0; foreach ($slabslist as $value){ ?>
											<option <?php if($is == 0){ echo 'selected'; } ?> value="<?=$value->sno?>"><?=$value->slab_name?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-9">
									<?php $syllabus = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id); ?>

									<div class="row">
										<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
											<label for="sclsyllabuslist">Student Syllabus</label>
											<select type="text" name="StdSyllubas" id="sclsyllubaslist" class="form-control" style="padding:5px !important;">
												<option value="">Select Syllabus Type</option>
												<?php foreach ($syllabus as $key => $value) { ?>
													<option value="<?= $key ?>"><?= $value ?></option>
												<?php } ?>
											</select>
										</div>

										<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
											<label for="SyllabusClasses">Student Class</label>
											<select type="text" name="StdClass" id="SyllabusClasses" class="form-control" style="padding:0px 10px">
												<option value="">Select Class</option>
											</select>
										</div>

										<div class="form-group col-xs-12 col-sm-6 col-md-4 col-lg-4">
											<label for="SyllabusClasses">Student Class Sections</label>
											<select type="text" name="StdClassSection" id="ExaminationClassesSections" class="form-control" style="padding:0px 10px">
												<option value="">Select Class Section</option>
											</select>
										</div>
									</div>

								</div>
							</div>
							<div class="col-12">
								<div class="row justify-content-center align-items-center" id="ExaminationTimingsList">
									<div class="col-md-8" >
										<center>
											<h4>Please select following options..!</h4>
											<img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>" style="">
										</center>
									</div>
								</div>
							</div>
							<script>
								$(document).ready(function () {

									$('#SyllabusClasses').change(function () {
										$("#loader").show();
										var classname 	 = $(this).val();
										var syllabusname = $("#sclsyllubaslist").val();
										if(classname != '' && syllabusname != ''){
											var request = $.ajax({
												url: "<?=base_url('dashboard/class/sectionslist')?>",
												type: "POST",
												data: {classname : classname,syllabustype : syllabusname,requesttype:'class_sections',schoolid:"<?=$schoolid?>",branchid:"<?=$branchid?>"},
												dataType: "json"
											});

											request.done(function(dataresponce) {
												console.log(dataresponce);
												$("#loader").hide();
												$("#ExaminationClassesSections").children('option:not(:first)').remove();
												var list = "";
												list += "<option value='all' >All Sections</option>";
												for($l = 0; dataresponce.length > $l; $l++){
													list += "<option value='"+ dataresponce[$l] +"'>"+ dataresponce[$l] + " Section "+"</option>";
												}
												$("#ExaminationClassesSections").append(list);
											});

											request.fail(function(jqXHR, textStatus) {
												$("#loader").hide();
												alert( "Request failed: " + textStatus );
											});
										}else{
											$("#loader").hide();
											alert('Please select syllabus and class..!');
										}
									});

									$("#ExaminationClassesSections").change(function () {
										var classsections				=	$(this).val();
										var selectedexamslab			=	$("#ExamSelectedSlab").val();
										var subject_classtimings_for	=	$('#SyllabusClasses').val();
										var syllabus_to_getdata			=	$("#sclsyllubaslist").val();
										if(subject_classtimings_for != '' && syllabus_to_getdata != ''){
											console.log(syllabus_to_getdata + ' - ' + subject_classtimings_for);
											var request = $.ajax({
												url: "<?=base_url('dashboard/timings/examinationsubjectstimingslist')?>",
												type: "POST",
												data: {classname : subject_classtimings_for,syllabustype : syllabus_to_getdata,requesttype:'examtimetable',classsection:classsections,examslab_id:selectedexamslab},
												//dataType: "json"
											});

											request.done(function(datareserved) {
												$("#ExaminationTimingsList").html(datareserved);
											});

											request.fail(function(jqXHR, textStatus) {
												$("#ExaminationTimingsList").html( "Request failed: " + textStatus );
											});
										}else{
											alert('Please select syllabus and class..!');
										}
									})

								})
							</script>
							<div class="row">
								<div class="mt-3">
									<p>
										<span class="text-warning">Note : </span>
									</p>
								</div>
							</div>
						<?php }else{
								$this->Model_dashboard->norecords();
							}
						?>
					</div>

				</div>
			</div>

		<?php }/*else if($timingtype == 'other'){ ?>

			<div class="col-md-12 mt-3">
				<h4 class="text-center text-success">Set Other Timings</h4>
			</div>

		<?php }*/else{ ?>

			<div class="" style="margin:40px 0px">
				<center>
					<img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>" style="width: 160px;">
					<h4>Please select following options...</h4>
				</center>
			</div>

		<?php } ?>
			<script>
				$('.mytimepicker').timepicker();
				$('.mytimepicker').val('');
				$(document).ready(function(e) {
					$("#sclsyllubaslist").change(function() {
						var scltypeslist = $(this).val();
						//alert(scltypeslist);
						if(scltypeslist == ""){
							swal("Please select syllabus type..!");
							$("#SyllabusClasses").prop('disabled', 'disabled');
						}else{
							$("#loader").show();
							var branchid        = "<?= $schooldata->branch_id ?>";
							var schoolid        = "<?= $schooldata->school_id ?>";
							var scltypeslist    = $('#sclsyllubaslist').val();
							$.ajax({
								url:"<?= base_url('Defaultmethods/syllubasbyclasses');?>",
								dataType:'json',
								method:'POST',
								data: {schoolid:schoolid,branchid:branchid,syllabustype:scltypeslist},
							})
							.done(function (dataresponce) {
								//console.log(dataresponce);
								$("#loader").hide();
								$("#SyllabusClasses").removeAttr('disabled');
								$("#SyllabusClasses").children('option:not(:first)').remove();
								var list = "";
								for($l = 0; dataresponce.length > $l; $l++){
									list += "<option value='"+ dataresponce[$l] +"'>"+ dataresponce[$l] +"</option>";
								}
								$("#SyllabusClasses").append(list);
							})
							.fail(function (req, status, err) {
								console.log('Something went wrong', status, err);
								$("#loader").hide();
							})
						}
					});
				});
			</script>
		<?php
    }

    //Examnination Timings
	public function ExaminationTimingslist(){
		extract($_REQUEST);
		$schooldata = $this->session->userdata['school'];
		//$this->print_r($_REQUEST);

		$subjectslist = $this->Model_dashboard->selectdata('sms_subjects',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'class'=>$classname,'scl_types'=>$syllabustype),'sno');
		$scl_types = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$syllabustype));


		if(isset($classsection) && $classsection != 'all') {
			//echo "Sections A,B,...";
			$examtimings = $this->Model_default->selectdata('sms_examtimings', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'class' => $classname, 'syllabus_type' => $syllabustype, 'section' => $classsection, 'exam_slab' => $examslab_id));
		}else if($classsection == 'all' && isset($classsection)){
			//echo "All";
			$examtimings = $this->Model_default->selectdata('sms_examtimings', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'class' => $classname, 'syllabus_type' => $syllabustype, 'exam_slab' => $examslab_id));
		}else{
			//echo 'null';
			$examtimings = array();
		}

		if(count($examtimings) != 0){  //$this->print_r($examtimings);
			$subjectslists = $subjectslist[0];
			$subjects = unserialize($subjectslists->subject);
			?>
			<h5 class="col-md-12 text-center text-success">Update Examination TimeTable...!</h5>
			<link href="<?= base_url() ?>assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
			<link href="<?= base_url() ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
			<link href="<?= base_url() ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />
			<link rel="stylesheet" href="https://seantheme.com/color-admin-v4.3/admin/assets/plugins/bootstrap-datepicker/css/less/datepicker3.less" type="text/css">
			<script src="<?= base_url() ?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
			<script src="<?= base_url() ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

			<div class="row justify-content-center align-content-center mb-3">
				<h5 class="col-md-12 mt-3">Pick Subjects To Set Examination Timings.</h5>
				<script>
					$(document).ready(function () {
						$("#exam_timetable").val('');
						$("#exam_timetable").removeAttr('name');
					})
				</script>
				<?php
					$examtimings = $examtimings[0];
					$savedtimings	=	unserialize($examtimings->exam_timings);
					$savedsubjects	=	array();
					$filterselectedsubjects	=	array() ;
				    $filterothersubjects	=	array();


					foreach ($savedtimings as $key => $savedtiming){
						//$this->print_r($savedtiming);

						$savedsubjects[] =	$savedtiming['subject'];
						if(in_array($savedtiming['subject'],$subjects)){
							$filterselectedsubjects[]	=	array('Subject' => $savedtiming['subject'],'Date'=>$savedtiming['date'], 'FromTime' => $savedtiming['from'], 'ToTime' => $savedtiming['to'],'Marks'=>$savedtiming['marks']);
						}else{
							$filterothersubjects[]		=	array('Subject' => $savedtiming['subject'],'Date'=>$savedtiming['date'], 'FromTime' => $savedtiming['from'], 'ToTime' => $savedtiming['to'],'Marks'=>$savedtiming['marks']);
						}

					}
					//$this->print_r($filterothersubjects);
				?>
				<div class="col-md-12">
					<div class="row ml-2 mr-2">
						<?php foreach ($subjects as $key => $subject) { ?>
							<div class="checkbox checkbox-css col-md-2">
								<input type="checkbox" id="Selectedotheramountlist_<?= $subject ?>" value="<?= $subject ?>" <?php if(in_array($subject,$savedsubjects)){ echo 'checked'; } ?> name="subjectnames[]"/>
								<label for="Selectedotheramountlist_<?= $subject ?>"><?= $subject ?></label>
							</div>
							<script>
								$(document).ready(function () {

									//existing data
									var checkedlistdata = $('input[name="subjectnames[]"]:checked').length;
									if (checkedlistdata != 0) {
										$("#exam_timetable").val('exam_timetable');
										$("#exam_timetable").attr('name','exam_type');
										$("#Selectedotheramountlist").attr('checked','checked');
										$('#SelectedortherSubjectsAddons,#SelectedSaveButtonClass').show();
									}else{
										$("#exam_timetable").val('');
										$("#exam_timetable").removeAttr('name');
										$("#Selectedotheramountlist").removeAttr('checked');
										$('#SelectedortherSubjectsAddons,#SelectedSaveButtonClass').hide();
									}
									if ($('#Selectedotheramountlist_<?=$subject?>').is(":checked")) {
										$("#SelectedId_<?=$subject?>").show();
										$('#SelectedDate_<?= $subject ?>,#SelectedFrom_<?= $subject ?>,#SelectedTo_<?= $subject ?>,#SelectedMarks_<?= $subject ?>').attr('required', 'required');
									}else {
										$("#SelectedId_<?=$subject?>").hide();
										$('#SelectedDate_<?= $subject ?>,#SelectedFrom_<?= $subject ?>,#SelectedTo_<?= $subject ?>,#SelectedMarks_<?= $subject ?>').removeAttr('required');
										$('#SelectedTo_<?= $subject ?>,#SelectedDate_<?= $subject ?>,#SelectedFrom_<?= $subject ?>,#SelectedMarks_<?= $subject ?>').val('');
									}

									//new data
									$("#Selectedotheramountlist_<?=$subject?>").click(function (e) {
										var checkedlist = $('input[name="subjectnames[]"]:checked').length;
										if (checkedlist != 0) {
											$('#SelectedortherSubjectsAddons,#SelectedSaveButtonClass').show();
										} else {
											$('#SelectedortherSubjectsAddons,#SelectedSaveButtonClass').hide();
										}
										if ($('#Selectedotheramountlist_<?=$subject?>').is(":checked")) {
											$("#SelectedId_<?=$subject?>").show();
											$('#SelectedDate_<?= $subject ?>,#SelectedFrom_<?= $subject ?>,#SelectedTo_<?= $subject ?>,#SelectedMarks_<?= $subject ?>').attr('required', 'required');
										}else {
											$("#SelectedId_<?=$subject?>").hide();
											$('#SelectedDate_<?= $subject ?>,#SelectedFrom_<?= $subject ?>,#SelectedTo_<?= $subject ?>,#SelectedMarks_<?= $subject ?>').removeAttr('required');
											$('#SelectedTo_<?= $subject ?>,#SelectedDate_<?= $subject ?>,#SelectedFrom_<?= $subject ?>,#SelectedMarks_<?= $subject ?>').val('');
										}
									});

									$('.mydatepicker').datepicker({
										autoclose: true,
									});
								})
							</script>
						<?php } ?>
					</div>
				</div>
			</div>

			<div class="col-md-12 hidden-xs hidden-sm mb-2">
				<div class="row">
					<div class="col-md-2 text-left text-warning">Subject Name</div>
					<div class="col-md-3 text-center text-warning">Exam Date</div>
					<div class="col-md-3 text-center text-warning">Time From</div>
					<div class="col-md-2 text-left text-warning">Time To</div>
					<div class="col-md-2 text-left text-warning">Per Marks</div>
				</div>
			</div>

			<div>
				<?php foreach ($subjects as $key => $subject) {

					//$this->print_r($filterselectedsubjects[$key]['Date']);

					if(@in_array($filterselectedsubjects[$key]['Subject'],$subjects) && $subject == $filterselectedsubjects[$key]['Subject']){
						$saveddate = $filterselectedsubjects[$key]['Date'];
						$savedFromTime	=	date('h:i a', strtotime($filterselectedsubjects[$key]["FromTime"]));
						$savedToTime	=	date('h:i a', strtotime($filterselectedsubjects[$key]["ToTime"]));
						$savedMarksdata	=	$filterselectedsubjects[$key]["Marks"];
					}else{
						$saveddate = '';
						$savedFromTime = '';
						$savedToTime = '';
						$savedMarksdata = '';
					}



					?>
					<div class="row justify-content-center align-content-center" id="SelectedId_<?= $subject ?>">
						<div class="col-md-2 pt-2 pl-0">
							<label class="text-uppercase text-success"><?= $subject ?></label>
						</div>
						<div class="form-group col-md-3">
							<input class="form-control mydatepicker" placeholder="Pick Exam Date" name="examinationdates[]" value="<?=$saveddate?>" type="text" id="SelectedDate_<?= $subject ?>">
						</div>
						<div class="col-xs-12 col-md-2">
							<div class="form-group">
								<input type="text" name="from_time[]" class="form-control" id="SelectedFrom_<?= $subject ?>" placeholder="<?= $subject ?>">
							</div>
						</div>
						<div class="col-xs-12 col-md-2">
							<div class="form-group">
								<input type="text" name="to_time[]" class="form-control" id="SelectedTo_<?= $subject ?>" placeholder="<?= $subject ?>">
							</div>
						</div>
						<div class="col-md-2 form-group">
							<input type="tel" class="form-control" value="<?=$savedMarksdata?>" name="total_marks[]" placeholder="Marks of Subject" id="SelectedMarks_<?= $subject ?>">
						</div>
					</div>

						<script>
							$(document).ready(function () {
								$('#SelectedFrom_<?= $subject ?>').timepicker({defaultTime: '<?=$savedFromTime?>'});
								$('#SelectedTo_<?= $subject ?>').timepicker({defaultTime: '<?=$savedToTime?>'});
								//$('#SelectedId_<?//=$subject?>').hide();
							})
						</script>
				<?php } ?>
			</div>

			<div class="row justify-content-center align-content-center" id="SelectedortherSubjectsAddons">
				<div class="col-md-12 mb-3">
					<div class="checkbox checkbox-css">
						<input type="checkbox" id="Selectedotheramountlist" name="otherdata"/>
						<label for="Selectedotheramountlist">Check To Add More Examination Timings (
							<small>Drawing,...</small>
							)- <?= $classname ?> Class..</label>
					</div>
				</div>
			</div>

			<div class="row justify-content-center align-content-center mt-3">
				<div class="col-md-12" id="Selectedotheramountlistbox">
					<div class="row justify-content-center align-items-center">
						<div class="col-md-12" id="Othersappendfeefields">
							<?php if(count($filterothersubjects) != 0){ foreach ($filterothersubjects as $key => $filterothersubject){ ?>
								<div class="row">
									<div class="col-md-2 form-group">
										<input type="text" name="subjectnames[]" placeholder="Subject Name" class="form-control fetch_results" id="SelectedOtherSubject_<?=$filterothersubject['Subject']?>" value="<?=$filterothersubject['Subject']?>">
									</div>
									<div class="form-group col-md-3">
										<input class="form-control mydatepicker fetch_results" placeholder="Pick Exam Date" name="examinationdates[]" value="<?=$filterothersubject['Date']?>" type="text">
									</div>
									<div class="col-md-2 form-group">
										<input type="text" name="from_time[]" placeholder="From Time" class="form-control fetch_results" id="SelectedOtherFrom_<?= str_replace(' ', '_', $filterothersubject['Subject']) ?>">
									</div>
									<div class="col-md-2 form-group">
										<input type="text" name="to_time[]" placeholder="To Time" class="form-control fetch_results" id="SelectedOtherTo_<?= str_replace(' ', '_', $filterothersubject['Subject']) ?>">
									</div>
									<div class="col-md-2 form-group">
										<input type="tel" class="form-control fetch_results" name="total_marks[]" placeholder="Marks of Subject" value="<?=$filterothersubject['Marks']?>">
									</div>
									<div class="col-md-1">
										<?php if($key == 0){ ?>
											<a href="javascript:void(0);" id="SelectedAddNewfield"
										   class="btn btn-success btn-sm"> + </a>
										<?php }else{ ?>
											<a href="javascript:void(0);" id="OtherAddNewfield"
											   class="btn btn-danger btn-sm RemoveField">Remove</a>
										<?php } ?>
									</div>
								</div>
								<script>
									$(document).ready(function () {
										$('#SelectedOtherFrom_<?= str_replace(' ', '_', $filterothersubject['Subject']) ?>').timepicker({defaultTime: '<?=date('h:i a', strtotime($filterothersubject["FromTime"]))?>'});
										$('#SelectedOtherTo_<?= str_replace(' ', '_', $filterothersubject['Subject']) ?>').timepicker({defaultTime: '<?=date('h:i a', strtotime($filterothersubject["ToTime"]))?>'});
										if($('#Selectedotheramountlist').is(":checked")) {
											$("#Selectedotheramountlist").attr('value','yes');
										}else{
											$('.fetch_results').find('input:tel').val('');
											$('.fetch_results').find('input:text').val('');
											$("#Selectedotheramountlist").attr('value','no');
										}

										$("#Selectedotheramountlist").change(function () {
											if($('#Selectedotheramountlist').is(":checked")) {
												$("#Selectedotheramountlist").attr('value','yes');
											}else{
												$(".fetch_results").val('');
												$('.fetch_results').find('input:text').val('');
												$('.fetch_results').find('input:tel').val('');
												$("#Selectedotheramountlist").attr('value','no');
											}
										})

									})
								</script>
							<?php } }else{ ?>
								<script>
									$(document).ready(function () {
										$("#Selectedotheramountlist").removeAttr('checked');
										$("#Selectedotheramountlistbox").hide();
									})
								</script>
								<div class="row">
									<div class="col-md-2 form-group">
										<input type="text" name="subjectnames[]" placeholder="Subject Name" class="form-control">
									</div>
									<div class="form-group col-md-3">
										<input class="form-control mydatepicker" placeholder="Pick Exam Date" name="examinationdates[]" type="text">
									</div>
									<div class="col-md-2 form-group">
										<input type="text" name="from_time[]" placeholder="From Time" class="form-control mytimepicker">
									</div>
									<div class="col-md-2 form-group">
										<input type="text" name="to_time[]" placeholder="To Time" class="form-control mytimepicker">
									</div>
									<div class="col-md-2 form-group">
										<input type="tel" class="form-control" name="total_marks[]" placeholder="Marks of Subject">
									</div>
									<div class="col-md-1">
										<a href="javascript:void(0);" id="SelectedAddNewfield"
										   class="btn btn-success btn-sm"> + </a>
									</div>
								</div>
							<?php } ?>
							<div class="row">
								<div class="col-md-12" id="Selectedappendfeefields"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>
				$(document).ready(function () {
					//$('#Selectedotheramountlistbox,#SelectedortherSubjectsAddons,#SelectedSaveButtonClass').hide();
					$("#Selectedotheramountlist").click(function (e) {
						if ($('#Selectedotheramountlist').is(":checked")) {
							$("#Selectedotheramountlist").val('yes');
							$("#Selectedotheramountlistbox").show();
						} else {
							$("#Selectedotheramountlist").val('no');
							$("#Selectedotheramountlistbox").hide();
							$("#Selectedappendfeefields").empty();
							$("input[name='servicename[]']").val('');
							$("input[name='serviceamount[]']").val('');
						}
					});

					$("#SelectedAddNewfield").click(function (e) {
						var Newfields = '<div class="row"><div class="col-md-2 form-group"><input type="text" name="subjectnames[]" placeholder="Subject Name" class="form-control"></div><div class="form-group col-md-3"><input class="form-control mydatepicker" placeholder="Pick Exam Date" name="examinationdates[]" type="text" required="required"></div><div class="col-md-2 form-group"><input type="text" name="from_time[]" placeholder="From Time" class="form-control mytimepickers"></div><div class="col-md-2 form-group"><input type="text" name="to_time[]" placeholder="To Time" class="form-control mytimepickers"></div><div class="col-md-2 form-group"><input type="tel" class="form-control" name="total_marks[]" placeholder="Marks of Subject"></div><div class="col-md-1"><a href="javascript:void(0);" id="SelectedAddNewfield" class="btn btn-danger btn-sm RemoveField"> - </a></div></div>';

						$("#Selectedappendfeefields").append(Newfields);
					});

					$("#Selectedappendfeefields").on('click', '.RemoveField', function (e) {
						e.preventDefault();
						$(this).parent().parent().remove();
					})

					$("#Othersappendfeefields").on('click', '.RemoveField', function (e) {
						e.preventDefault();
						$(this).parent().parent().remove();
					})
				});
			</script>
			<div class="col-12">
				<div class="row justify-content-center align-items-center" id="SelectedSaveButtonClass">
					<input type="submit" name="saveclasstimings" value="Update Exam Timings" class="btn btn-success">
				</div>
			</div>
			<script>
				$(document).ready(function () {
					$('.mytimepicker,.timepicker,.mytimepickeredit').timepicker();
					$(".mytimepicker").val('');
				})
			</script>

		<?php }else {

			if (count($subjectslist) != 0) {
				$subjectslists = $subjectslist[0];
				$subjects = unserialize($subjectslists->subject);
				?>
				<h5 class="col-md-12 text-center text-success">Set New Examination TimeTable...!</h5>
				<link href="<?= base_url() ?>assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet"/>
				<link href="<?= base_url() ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
				<link href="<?= base_url() ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />
				<link rel="stylesheet" href="https://seantheme.com/color-admin-v4.3/admin/assets/plugins/bootstrap-datepicker/css/less/datepicker3.less" type="text/css">
				<script src="<?= base_url() ?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
				<script src="<?= base_url() ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
				<div class="row justify-content-center align-content-center mb-3">
					<h5 class="col-md-12 mt-3">Pick Subjects To Set Examination Timings.</h5>
					<div class="col-md-12">
						<div class="row ml-2 mr-2">
							<?php foreach ($subjects as $key => $subject) { ?>
								<div class="checkbox checkbox-css col-md-2">
									<input type="checkbox" id="otheramountlist_<?= $subject ?>" value="<?= $subject ?>"
										   name="subjectnames[]"/>
									<label for="otheramountlist_<?= $subject ?>"><?= $subject ?></label>
								</div>
								<script>
									$(document).ready(function () {

										$("#exam_timetable").val('');
										$("#exam_timetable").removeAttr('name');

										$("#otheramountlist_<?=$subject?>").click(function (e) {
											var checkedlist = $('input[name="subjectnames[]"]:checked').length;
											if (checkedlist != 0) {
												$("#exam_timetable").val('exam_timetable');
												$("#exam_timetable").attr('name','exam_type');
												$('#ortherSubjectsAddons,#SaveButtonClass').show();
											}else{
												$('#ortherSubjectsAddons,#SaveButtonClass').hide();
												$("#exam_timetable").val('');
												$("#exam_timetable").removeAttr('name');
											}

											if ($('#otheramountlist_<?=$subject?>').is(":checked")) {
												$("#Id_<?=$subject?>").show();
												$('#Date_<?= $subject ?>,#From_<?= $subject ?>,#To_<?= $subject ?>,#Marks_<?= $subject ?>').attr('required', 'required');
											}else {
												$("#Id_<?=$subject?>").hide();
												$('#Date_<?= $subject ?>,#From_<?= $subject ?>,#To_<?= $subject ?>,#Marks_<?= $subject ?>').removeAttr('required');
												$('#To_<?= $subject ?>,#Date_<?= $subject ?>,#From_<?= $subject ?>,#Marks_<?= $subject ?>').val('');
											}

											$('#From_<?= $subject ?>').val('');
											$('#To_<?= $subject ?>').val('');
										});

										$('.mydatepicker').datepicker({
											autoclose: true,
										});
									})
								</script>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-md-12 hidden-xs hidden-sm mb-2">
					<div class="row">
						<div class="col-md-2 text-left text-warning">Subject Name</div>
						<div class="col-md-3 text-center text-warning">Exam Date</div>
						<div class="col-md-3 text-center text-warning">Time From</div>
						<div class="col-md-2 text-left text-warning">Time To</div>
						<div class="col-md-2 text-left text-warning">Per Marks</div>
					</div>
				</div>
				<div>
					<?php foreach ($subjects as $key => $subject) { ?>

						<div class="row justify-content-center align-content-center" id="Id_<?= $subject ?>">
							<div class="col-md-2 pt-2 pl-0">
								<label class="text-uppercase text-success"><?= $subject ?></label>
							</div>
							<div class="form-group col-md-3">
								<input class="form-control mydatepicker" placeholder="Pick Exam Date" name="examinationdates[]" id="Date_<?= $subject ?>" type="text">
							</div>
							<div class="col-xs-12 col-md-2">
								<div class="form-group">
									<input type="text" name="from_time[]" class="form-control mytimepicker" id="From_<?= $subject ?>" placeholder="<?= $subject ?>">
								</div>
							</div>
							<div class="col-xs-12 col-md-2">
								<div class="form-group">
									<input type="text" name="to_time[]" class="form-control mytimepicker" id="To_<?= $subject ?>" placeholder="<?= $subject ?>">
								</div>
							</div>
							<div class="col-md-2 form-group">
								<input type="tel" class="form-control" name="total_marks[]" placeholder="Marks of Subject" id="Marks_<?= $subject ?>">
							</div>
						</div>
						<script>
							$(document).ready(function () {
								$('#Id_<?=$subject?>').hide();
							})
						</script>
						<?php
					} ?>
				</div>
				<div class="row justify-content-center align-content-center" id="ortherSubjectsAddons">
					<div class="col-md-12 mb-3">
						<div class="checkbox checkbox-css">
							<input type="checkbox" id="otheramountlist"/>
							<label for="otheramountlist">Check To Add More Examination Timings (
								<small>Games,Drawing,...</small>
								)- <?= $classname ?> Class..</label>
						</div>
					</div>
				</div>

				<div class="row justify-content-center align-content-center mt-3">
					<div class="col-md-12" id="otheramountlistbox">
						<div class="row justify-content-center align-items-center">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-2 form-group">
										<input type="text" name="subjectnames[]" placeholder="Subject Name" class="form-control">
									</div>
									<div class="form-group col-md-3">
										<input class="form-control mydatepicker" placeholder="Pick Exam Date" name="examinationdates[]" type="text">
									</div>
									<div class="col-md-2 form-group">
										<input type="text" name="from_time[]" placeholder="From Time" class="form-control mytimepicker">
									</div>
									<div class="col-md-2 form-group">
										<input type="text" name="to_time[]" placeholder="To Time" class="form-control mytimepicker">
									</div>
									<div class="col-md-2 form-group">
										<input type="tel" class="form-control" name="total_marks[]" placeholder="Marks of Subject">
									</div>
									<div class="col-md-1">
										<a href="javascript:void(0);" id="AddNewfield"
										   class="btn btn-success btn-sm"> + </a>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12" id="appendfeefields"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script>
					$(document).ready(function () {
						$('#otheramountlistbox,#ortherSubjectsAddons,#SaveButtonClass').hide();
						$("#otheramountlist").click(function (e) {
							if ($('#otheramountlist').is(":checked")) {
								$("#otheramountlist").val('yes');
								$("#otheramountlistbox").show();
							} else {
								$("#otheramountlist").val('no');
								$("#otheramountlistbox").hide();
								$("#appendfeefields").empty();
								$("input[name='servicename[]']").val('');
								$("input[name='serviceamount[]']").val('');
							}
						});

						$("#AddNewfield").click(function (e) {
							var Newfields = '<div class="row"><div class="col-md-2 form-group"><input type="text" name="subjectnames[]" placeholder="Subject Name" class="form-control"></div><div class="form-group col-md-3"><input class="form-control mydatepicker" placeholder="Pick Exam Date" name="examinationdates[]" type="text" required="required"></div><div class="col-md-2 form-group"><input type="text" name="from_time[]" placeholder="From Time" class="form-control mytimepickers"></div><div class="col-md-2 form-group"><input type="text" name="to_time[]" placeholder="To Time" class="form-control mytimepickers"></div><div class="col-md-2 form-group"><input type="tel" class="form-control" name="total_marks[]" placeholder="Marks of Subject"></div><div class="col-md-1"><a href="javascript:void(0);" id="AddNewfield" class="btn btn-danger btn-sm RemoveField"> - </a></div></div>';

							$("#appendfeefields").append(Newfields);
						});

						$("#appendfeefields").on('click', '.RemoveField', function (e) {
							e.preventDefault();
							$(this).parent().parent().remove();
						})
					});
				</script>
				<div class="col-12">
					<div class="row justify-content-center align-items-center" id="SaveButtonClass">
						<input type="submit" name="saveclasstimings" value="Save Exam Timings" class="btn btn-success">
					</div>
				</div>
				<script>
					$(document).ready(function () {
						$('.mytimepicker,.timepicker,.mytimepickeredit').timepicker();
						$(".mytimepicker").val('');
					})
				</script>
			<?php } else { ?>
				<div class="row justify-content-center align-content-center">
					<div class="col-md-10 pt-5 pb-5">
						<h3 class="text-center"><?= 'No Subjects Are Assign TO ' . $scl_types[0]->type . ' ' . $classname ?>
							Class...</h3>
						<h4 class="text-center">Please Check In Subjects List [ Settings > Subjects ] AND Assign
							Subjects To <?= $classname ?> Class...</h4>
					</div>
				</div>
			<?php }

		}
	}

    //Get subjects to set periods for class
	public function ClassSubjectsTimingsList(){
    	extract($_REQUEST);
		$schooldata = $this->session->userdata['school'];
    	$subjectslist = $this->Model_dashboard->selectdata('sms_subjects',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'class'=>$classname,'scl_types'=>$syllabustype),'sno');
		$scl_types = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$syllabustype));

		$classtimings = $this->Model_default->selectdata('sms_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'class'=>$classname,'syllabus_type'=>$syllabustype,'section'=>$classsection));

		if(count($classtimings) != 0){
			$classtiming = $classtimings[0];
			$subjectslists = $subjectslist[0];
			$subjects = unserialize($subjectslists->subject);
			//subjects & timings
			$selectedsubjects = array();
			$selectedtimings = array();
			$selectedOthertimings = array();
			foreach($classtimings as $key => $classtiming){
				   $selectedsubjects[] = $classtiming->titlesubject;
				if(!in_array($classtiming->titlesubject,$subjects)){
					$selectedOthertimings[]	= array('Subject'=>$classtiming->titlesubject,'FromTime'=>$classtiming->fromtime,'ToTime'=>$classtiming->totime);
				}else{
					$selectedtimings[]	= array('Subject'=>$classtiming->titlesubject,'FromTime'=>$classtiming->fromtime,'ToTime'=>$classtiming->totime);
				}
			}


			$filterselectedclass = array();
			foreach($selectedsubjects as $key => $filtersubject) {
				if(!in_array($filtersubject,$subjects)){
					$filterselectedclass[] = $filtersubject;
				}
			}
			//$this->print_r($selectedOthertimings);
			?>
			<link href="<?= base_url() ?>assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"
				  rel="stylesheet"/>
			<script
				src="<?= base_url() ?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>

			<div class="row justify-content-center align-content-center mb-3">
				<h5 class="col-md-12">Pick Day To Assign Classes</h5>
				<div class="col-md-12"></div>
				<?php $formdata = $this->Model_dashboard->selectdata('sms_formdata', array('type' => 'days'));
				foreach ($formdata as $days) { ?>
					<div class="radio radio-css radio-inline">
						<input type="radio" id="<?= $days->name . '_' . $days->id ?>" value="<?= $days->id ?>"
							   name="dayname" <?php if($classtiming->day_class == $days->id){ echo 'checked'; } ?>/>
						<label for="<?= $days->name . '_' . $days->id ?>" class="pr-3"><?= $days->name ?></label>
					</div>
					<script>
						$(document).ready(function () {
							var subject_classtimings_for 	= 	'<?=$classname?>';
							var syllabus_to_getdata			=   '<?=$syllabustype?>';
							var classsections				=	'<?=$classsection?>';
							var checkeddayvalue	=	$("#<?= $days->name . '_' . $days->id ?>").val();
							if($("#<?= $days->name . '_' . $days->id ?>").is(":checked")) {
								var request = $.ajax({
									url: "<?=base_url('dashboard/timings/ExistingDataDetails')?>",
									type: "POST",
									data: {classname : subject_classtimings_for,syllabustype : syllabus_to_getdata,dayclass:checkeddayvalue,classsection:classsections},
									//dataType: "json"
								});

								request.done(function(datareserved) {
									$("#AppendAllExistingDataDetails").html(datareserved);
								});

								request.fail(function(jqXHR, textStatus) {
									$("#AppendAllExistingDataDetails").html( "Request failed: " + textStatus );
								});
							}

							$("#<?= $days->name . '_' . $days->id ?>").click(function (e) {

								var checkeddayvalue	=	$("#<?= $days->name . '_' . $days->id ?>").val();
								if($("#<?= $days->name . '_' . $days->id ?>").is(":checked")) {
									var request = $.ajax({
										url: "<?=base_url('dashboard/timings/ExistingDataDetails')?>",
										type: "POST",
										data: {classname : subject_classtimings_for,syllabustype : syllabus_to_getdata,dayclass:checkeddayvalue,classsection:classsections},
										//dataType: "json"
									});

									request.done(function(datareserved) {
										$("#AppendAllExistingDataDetails").html(datareserved);
									});

									request.fail(function(jqXHR, textStatus) {
										$("#AppendAllExistingDataDetails").html( "Request failed: " + textStatus );
									});
								}else {
									alert ("Please Check Day To Set TimeTable..!");
								}

							});
						})
					</script>
				<?php } ?>
			</div>
			<div class="row">
				<div class="col-md-12" id="AppendAllExistingDataDetails"></div>
			</div>

		<?php }else {

			if (count($subjectslist) != 0) {
				$subjectslists = $subjectslist[0];
				$subjects = unserialize($subjectslists->subject);
				?>
				<h5 class="col-md-12 text-center text-success">Set New Class TimeTable...!</h5>
				<link href="<?= base_url() ?>assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"
					  rel="stylesheet"/>
				<script
					src="<?= base_url() ?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
				<div class="row justify-content-center align-content-center mb-3">
					<h5 class="col-md-12">Pick Day To Assign Classes</h5>
					<div class="col-md-12"></div>
					<?php $formdata = $this->Model_dashboard->selectdata('sms_formdata', array('type' => 'days'));
					foreach ($formdata as $days) { ?>
						<div class="radio radio-css radio-inline">
							<input type="radio" id="<?= $days->name . '_' . $days->id ?>" value="<?= $days->id ?>" name="dayname"/>
							<label for="<?= $days->name . '_' . $days->id ?>"><?= $days->name ?></label>
						</div>
					<?php } ?>
				</div>

				<div class="row justify-content-center align-content-center mb-3">
					<h5 class="col-md-12 mt-3">Pick Subjects To Assign Class Timings.</h5>
					<div class="col-md-12"></div>
					<?php foreach ($subjects as $key => $subject) { ?>
						<div class="checkbox checkbox-css col-md-2">
							<input type="checkbox" id="otheramountlist_<?= $subject ?>" value="<?= $subject ?>"
								   name="subjectnames[]"/>
							<label for="otheramountlist_<?= $subject ?>"><?= $subject ?></label>
						</div>
						<script>
							$(document).ready(function () {
								$("#otheramountlist_<?=$subject?>").click(function (e) {
									var checkedlist = $('input[name="subjectnames[]"]:checked').length;
									if (checkedlist != 0) {
										$('#ortherSubjectsAddons,#SaveButtonClass').show();
									} else {
										$('#ortherSubjectsAddons,#SaveButtonClass').hide();
									}
									if ($('#otheramountlist_<?=$subject?>').is(":checked")) {
										$("#Id_<?=$subject?>").show();
										$('#From_<?= $subject ?>').attr('required', 'required');
										$('#To_<?= $subject ?>').attr('required', 'required');
									} else {
										$("#Id_<?=$subject?>").hide();
										$('#From_<?= $subject ?>').removeAttr('required');
										$('#To_<?= $subject ?>').removeAttr('required');
									}
									$('#From_<?= $subject ?>').val('');
									$('#To_<?= $subject ?>').val('');
								});
							})
						</script>
					<?php } ?>
				</div>
				<?php foreach ($subjects as $key => $subject) { ?>
					<div class="row justify-content-center align-content-center" id="Id_<?= $subject ?>">
						<div class="col-md-2 pt-2">
							<label class="text-uppercase text-success"><?= $subject ?> Timings</label>
						</div>
						<div class="col-xs-12 col-md-2">
							<div class="form-group">
								<input type="text" name="from_time[]" class="form-control mytimepicker"
									   id="From_<?= $subject ?>" placeholder="<?= $subject ?> Sub From Time">
							</div>
						</div>
						<div class="col-xs-12 col-md-2">
							<div class="form-group">
								<input type="text" name="to_time[]" class="form-control mytimepicker"
									   id="To_<?= $subject ?>" placeholder="<?= $subject ?> Sub To Time">
							</div>
						</div>
					</div>
					<script>
						$(document).ready(function () {
							$('#Id_<?=$subject?>').hide();
						})
					</script>
					<?php
				} ?>
				<div class="row justify-content-center align-content-center" id="ortherSubjectsAddons">
					<div class="col-md-6 mb-3">
						<div class="checkbox checkbox-css">
							<input type="checkbox" id="otheramountlist"/>
							<label for="otheramountlist">Check To Add More Class (
								<small>Games,Drawing,...</small>
								)- <?= $classname ?> Class..</label>
						</div>
					</div>
				</div>
				<div class="row justify-content-center align-content-center mt-3">
					<div class="col-md-12" id="otheramountlistbox">
						<div class="row justify-content-center align-items-center">
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-3 form-group">
										<input type="text" name="subjectnames[]" placeholder="Enter Class Name"
											   class="form-control">
									</div>
									<div class="col-md-3 form-group">
										<input type="text" name="from_time[]" placeholder="From Time"
											   class="form-control mytimepicker">
									</div>
									<div class="col-md-3 form-group">
										<input type="text" name="to_time[]" placeholder="To Time"
											   class="form-control mytimepicker">
									</div>
									<div class="col-md-2">
										<a href="javascript:void(0);" id="AddNewfield"
										   class="btn btn-success btn-sm">Add New</a>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12" id="appendfeefields"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script>
					$(document).ready(function () {
						$('#otheramountlistbox,#ortherSubjectsAddons,#SaveButtonClass').hide();
						$("#otheramountlist").click(function (e) {
							if ($('#otheramountlist').is(":checked")) {
								$("#otheramountlist").val('yes');
								$("#otheramountlistbox").show();
							} else {
								$("#otheramountlist").val('no');
								$("#otheramountlistbox").hide();
								$("#appendfeefields").empty();
								$("input[name='servicename[]']").val('');
								$("input[name='serviceamount[]']").val('');
							}
						});

						$("#AddNewfield").click(function (e) {
							var Newfields = '<div class="row"><div class="col-md-3 form-group"><input type="text" name="subjectnames[]" placeholder="Enter Class Name" class="form-control"></div><div class="col-md-3 form-group"><input type="text" name="from_time[]" placeholder="From Time" class="form-control mytimepickers"></div><div class="col-md-3 form-group"><input type="text" name="to_time[]" placeholder="To Time" class="form-control mytimepickers"></div><div class="col-md-2"><a href="javascript:void(0);" id="AddNewfield" class="btn btn-danger btn-sm RemoveField">Remove</a></div></div>';

							$("#appendfeefields").append(Newfields);
						});

						$("#appendfeefields").on('click', '.RemoveField', function (e) {
							e.preventDefault();
							$(this).parent().parent().remove();
						})
					});
				</script>
				<div class="row justify-content-center align-items-center" id="SaveButtonClass">
					<input type="submit" name="saveclasstimings" value="Save Class Timings" class="btn btn-success">
				</div>
				<script>
					$(document).ready(function () {
						$('.mytimepicker,.timepicker,.mytimepickeredit').timepicker();
						$(".mytimepicker").val('');
					})
				</script>
				<?php
			} else { ?>
				<div class="row justify-content-center align-content-center">
					<div class="col-md-10 pt-5 pb-5">
						<h3 class="text-center"><?= 'No Subjects Are Assign TO ' . $scl_types[0]->type . ' ' . $classname ?>
							Class...</h3>
						<h4 class="text-center">Please Check In Subjects List [ Settings > Subjects ] AND Assign
							Subjects To <?= $classname ?> Class...</h4>
					</div>
				</div>
			<?php }

		}

	}

	//Existing Data Details
	public function ExistingDataDetails(){
    	extract($_REQUEST);
		$schooldata = $this->session->userdata['school'];
		$subjectslist = $this->Model_dashboard->selectdata('sms_subjects',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'class'=>$classname,'scl_types'=>$syllabustype),'sno');
		$scl_types = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$syllabustype));

		$classtimings = $this->Model_default->selectdata('sms_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'class'=>$classname,'syllabus_type'=>$syllabustype,'section'=>$classsection,'day_class'=>$dayclass));
		if(count($classtimings) != 0) {
			$classtiming = $classtimings[0];
			$subjectslists = $subjectslist[0];
			$subjects = unserialize($subjectslists->subject);
			//subjects & timings
			$selectedsubjects = array();
			$selectedtimings = array();
			$selectedOthertimings = array();
			foreach ($classtimings as $key => $classtiming) {
				$selectedsubjects[] = $classtiming->titlesubject;
				if (!in_array($classtiming->titlesubject, $subjects)) {
					$selectedOthertimings[] = array('Subject' => $classtiming->titlesubject, 'FromTime' => $classtiming->fromtime, 'ToTime' => $classtiming->totime);
				} else {
					$selectedtimings[] = array('Subject' => $classtiming->titlesubject, 'FromTime' => $classtiming->fromtime, 'ToTime' => $classtiming->totime);
				}
			}


			$filterselectedclass = array();
			foreach ($selectedsubjects as $key => $filtersubject) {
				if (!in_array($filtersubject, $subjects)) {
					$filterselectedclass[] = $filtersubject;
				}
			}
			?>
			<div class="row justify-content-center align-content-center mb-3">
				<h5 class="col-md-12 mt-4 text-center text-danger">Already Set Class TimeTable. If Want To Update
					It...!</h5>
				<h5 class="col-md-12 mt-3">Pick Subjects To Assign Class Timings.</h5>
				<div class="col-md-12"></div>
				<?php foreach ($subjects as $key => $subject) { ?>
					<div class="checkbox checkbox-css col-md-2">
						<?php if (in_array($subject, $selectedsubjects)) { ?>
							<input type="checkbox" id="Selectedotheramountlist_<?= $subject ?>" value="<?= $subject ?>" name="subjectnames[]" checked/>
						<?php } else { ?>
							<input type="checkbox" id="Selectedotheramountlist_<?= $subject ?>" value="<?= $subject ?>" name="subjectnames[]"/>
						<?php } ?>

						<label for="Selectedotheramountlist_<?= $subject ?>"><?= $subject ?></label>
					</div>
					<script>
						$(document).ready(function () {

							//selected subjects
							var checkedlist = $('input[name="subjectnames[]"]:checked').length;
							if (checkedlist != 0) {
								$('#SelectedortherSubjectsAddons,#SelectedSaveButtonClass').show();
								$('#Selectedotheramountlist').attr('checked', 'checked');
							} else {
								$('#Selectedotheramountlist').removeAttr('checked');
								$('#SelectedortherSubjectsAddons,#SelectedSaveButtonClass').hide();
							}
							if ($('#Selectedotheramountlist_<?=$subject?>').is(":checked")) {
								$("#SelectedId_<?=$subject?>").show();
								$('#SelectedFrom_<?= $subject ?>').attr('required', 'required');
								$('#SelectedTo_<?= $subject ?>').attr('required', 'required');
							} else {
								$("#SelectedId_<?=$subject?>").hide();
								$('#SelectedFrom_<?= $subject ?>').removeAttr('required');
								$('#SelectedTo_<?= $subject ?>').removeAttr('required');
							}

							//Link New ckeck
							$("#Selectedotheramountlist_<?=$subject?>").click(function (e) {
								var Selectedcheckedlist = $('input[name="subjectnames[]"]:checked').length;
								if (Selectedcheckedlist != 0) {
									$('#SelectedortherSubjectsAddons,#SelectedSaveButtonClass').show();
								} else {
									$('#SelectedortherSubjectsAddons,#SelectedSaveButtonClass').hide();
								}

								if ($('#Selectedotheramountlist_<?=$subject?>').is(":checked")) {
									$("#SelectedId_<?=$subject?>").show();
									$('#SelectedFrom_<?= $subject ?>').attr('required', 'required');
									$('#SelectedTo_<?= $subject ?>').attr('required', 'required');
								} else {
									$("#SelectedId_<?=$subject?>").hide();
									$('#SelectedFrom_<?= $subject ?>').removeAttr('required');
									$('#SelectedTo_<?= $subject ?>').removeAttr('required');
								}
								$('#SelectedFrom_<?= $subject ?>').val('');
								$('#SelectedTo_<?= $subject ?>').val('');
							});
						})
					</script>
				<?php } ?>
			</div>

			<?php print_r($subjects); foreach ($subjects as $key => $subject) {
                    if (in_array($subject, $selectedsubjects)) { ?>
                    <div class="row justify-content-center align-content-center" id="SelectedId_<?= $subject ?>">
                        <div class="col-md-2 pt-2">
                            <label class="text-uppercase text-success"><?= $subject ?> Timings</label>
                        </div>
                        <div class="col-xs-12 col-md-2">
                            <div class="form-group">
                                <input type="text" name="from_time[]" class="form-control mytimepicker" id="SelectedFrom_<?= $subject ?>" placeholder="<?= $subject ?> Sub From Time">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-2">
                            <div class="form-group">
                                <input type="text" name="to_time[]" class="form-control mytimepicker" id="SelectedTo_<?= $subject ?>" placeholder="<?= $subject ?> Sub To Time">
                            </div>
                        </div>
                        </div>
                    <script>
                        $(document).ready(function () {

                            $('#SelectedFrom_<?= $subject ?>').timepicker({defaultTime: '<?=date('h:i a', strtotime($selectedtimings[$key]["FromTime"]))?>'});
                            $('#SelectedTo_<?= $subject ?>').timepicker({defaultTime: '<?=date('h:i a', strtotime($selectedtimings[$key]["ToTime"]))?>'});

                            //$('#SelectedId_<?//=$subject?>').hide();
                        })
                    </script>
				<?php }else{ ?>
                    <div class="row justify-content-center align-content-center" id="SelectedId_<?= $subject ?>">
					<div class="col-md-2 pt-2">
						<label class="text-uppercase text-success"><?= $subject ?> Timings</label>
					</div>
					<div class="col-xs-12 col-md-2">
						<div class="form-group">
							<input type="text" name="from_time[]" class="form-control mytimepicker" id="SelectedFrom_<?= $subject ?>" placeholder="<?= $subject ?> Sub From Time">
						</div>
					</div>
					<div class="col-xs-12 col-md-2">
						<div class="form-group">
							<input type="text" name="to_time[]" class="form-control mytimepicker" id="SelectedTo_<?= $subject ?>" placeholder="<?= $subject ?> Sub To Time">
						</div>
					</div>
				</div>
                <?php }} ?>

			<div class="row justify-content-center align-content-center" id="SelectedortherSubjectsAddons">
				<div class="col-md-6 mb-3">
					<div class="checkbox checkbox-css">
						<input type="checkbox" id="Selectedotheramountlist"/>
						<label for="Selectedotheramountlist">Check To Add More Class (
							<small>Games,Drawing,...</small>
							)- <?= $classname ?> Class..</label>
					</div>
				</div>
			</div>

			<div class="row justify-content-center align-content-center mt-3">
				<div class="col-md-12" id="Selectedotheramountlistbox">
					<div class="row justify-content-center align-items-center">
						<div class="col-md-8">
							<div id="OtherSelectedappendfeefields">
								<?php foreach ($selectedOthertimings as $key => $selectedOthertiming) { ?>
									<div class="row">
										<div class="col-md-3 form-group">
											<input type="text" name="subjectnames[]" placeholder="Enter Class Name"
												   readonly class="form-control"
												   value="<?= $selectedOthertiming['Subject'] ?>">
										</div>
										<div class="col-md-3 form-group">
											<input type="text" name="from_time[]" placeholder="From Time"
												   class="form-control"
												   id="SelectedOtherFrom_<?= str_replace(' ', '_', $selectedOthertiming['Subject']) ?>">
										</div>
										<div class="col-md-3 form-group">
											<input type="text" name="to_time[]" placeholder="To Time"
												   id="SelectedOtherTo_<?= str_replace(' ', '_', $selectedOthertiming['Subject']) ?>"
												   class="form-control">
										</div>
										<div class="col-md-2">
											<?php if ($key === 0) { ?>
												<a href="javascript:void(0);" id="OtherAddNewfield"
												   class="btn btn-success btn-sm">Add New</a>
											<?php } else { ?>
												<a href="javascript:void(0);" id="OtherAddNewfield"
												   class="btn btn-danger btn-sm RemoveField">Remove</a>
											<?php } ?>
										</div>
									</div>
									<script>
										$(document).ready(function () {
											$('#SelectedOtherFrom_<?= str_replace(' ', '_', $selectedOthertiming['Subject']) ?>').timepicker({defaultTime: '<?=date('h:i a', strtotime($selectedOthertiming["FromTime"]))?>'});
											$('#SelectedOtherTo_<?= str_replace(' ', '_', $selectedOthertiming['Subject']) ?>').timepicker({defaultTime: '<?=date('h:i a', strtotime($selectedOthertiming["ToTime"]))?>'});
										})
									</script>
								<?php } ?>
							</div>
							<div class="row">
								<div class="col-md-12" id="Othersappendfeefields"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>
				$(document).ready(function () {
					$('#Selectedotheramountlistbox,#SelectedortherSubjectsAddons').hide();
					if ($('#Selectedotheramountlist').is(":checked")) {
						$("#Selectedotheramountlist").val('yes');
						$("#Selectedotheramountlistbox").show();
					} else {
						$("#Selectedotheramountlist").val('no');
						$("#Selectedotheramountlistbox").hide();
						$("#Selectedappendfeefields").empty();
						$("input[name='servicenames[]']").val('');
						$("input[name='serviceamount[]']").val('');
					}
					$("#Selectedotheramountlist").click(function (e) {
						if ($('#Selectedotheramountlist').is(":checked")) {
							$("#Selectedotheramountlist").val('yes');
							$("#Selectedotheramountlistbox").show();
						} else {
							$("#Selectedotheramountlist").val('no');
							$("#Selectedotheramountlistbox").hide();
							$("#Selectedappendfeefields").empty();
							$("input[name='servicenames[]']").val('');
							$("input[name='serviceamount[]']").val('');
						}
					});

					$("#OtherAddNewfield").click(function (e) {
						var Newfields = '<div class="row"><div class="col-md-3 form-group"><input type="text" name="subjectnames[]" placeholder="Enter Class Name" class="form-control"></div><div class="col-md-3 form-group"><input type="text" name="from_time[]" placeholder="From Time" class="form-control mytimepickers"></div><div class="col-md-3 form-group"><input type="text" name="to_time[]" placeholder="To Time" class="form-control mytimepickers"></div><div class="col-md-2"><a href="javascript:void(0);" id="OtherAddNewfield" class="btn btn-danger btn-sm RemoveField">Remove</a></div></div>';

						$("#Othersappendfeefields").append(Newfields);
					});

					$("#OtherSelectedappendfeefields").on('click', '.RemoveField', function (e) {
						e.preventDefault();
						$(this).parent().parent().remove();
					});

					$("#Othersappendfeefields").on('click', '.RemoveField', function (e) {
						e.preventDefault();
						$(this).parent().parent().remove();
					})
				});
			</script>
            <script>
				$(document).ready(function () {
                    //$(".mytimepicker").val('');
					$('.mytimepicker,.timepicker,.mytimepickeredit').timepicker();
				})
			</script>
			<div class="row justify-content-center align-items-center" id="SelectedSaveButtonClass">
				<input type="submit" name="saveclasstimings" value="Update Class Timings" class="btn btn-success">
			</div>

		<?php }else{

			$subjectslists = $subjectslist[0];
			$subjects = unserialize($subjectslists->subject);
			//subjects & timings
			$selectedsubjects = array();
			$selectedtimings = array();
			$selectedOthertimings = array();
			foreach ($classtimings as $key => $classtiming) {
				$selectedsubjects[] = $classtiming->titlesubject;
				if (!in_array($classtiming->titlesubject, $subjects)) {
					$selectedOthertimings[] = array('Subject' => $classtiming->titlesubject, 'FromTime' => $classtiming->fromtime, 'ToTime' => $classtiming->totime);
				} else {
					$selectedtimings[] = array('Subject' => $classtiming->titlesubject, 'FromTime' => $classtiming->fromtime, 'ToTime' => $classtiming->totime);
				}
			}


			$filterselectedclass = array();
			foreach ($selectedsubjects as $key => $filtersubject) {
				if (!in_array($filtersubject, $subjects)) {
					$filterselectedclass[] = $filtersubject;
				}
			}

			?>
			<h5 class="col-md-12 text-center text-success mt-3">Set New Class TimeTable...!</h5>
			<div class="row justify-content-center align-content-center mb-3">
				<h5 class="col-md-12 mt-3">Pick Subjects To Assign Class Timings.</h5>
				<div class="col-md-12"></div>
				<?php foreach ($subjects as $key => $subject) { ?>
					<div class="checkbox checkbox-css col-md-2">
						<input type="checkbox" id="otheramountlist_<?= $subject ?>" value="<?= $subject ?>"
							   name="subjectnames[]"/>
						<label for="otheramountlist_<?= $subject ?>"><?= $subject ?></label>
					</div>
					<script>
						$(document).ready(function () {
							$("#otheramountlist_<?=$subject?>").click(function (e) {
								var checkedlist = $('input[name="subjectnames[]"]:checked').length;
								if (checkedlist != 0) {
									$('#ortherSubjectsAddons,#SaveButtonClass').show();
								} else {
									$('#ortherSubjectsAddons,#SaveButtonClass').hide();
								}
								if ($('#otheramountlist_<?=$subject?>').is(":checked")) {
									$("#Id_<?=$subject?>").show();
									$('#From_<?= $subject ?>').attr('required', 'required');
									$('#To_<?= $subject ?>').attr('required', 'required');
								} else {
									$("#Id_<?=$subject?>").hide();
									$('#From_<?= $subject ?>').removeAttr('required');
									$('#To_<?= $subject ?>').removeAttr('required');
								}
								$('#From_<?= $subject ?>').val('');
								$('#To_<?= $subject ?>').val('');
							});
						})
					</script>
				<?php } ?>
			</div>
			<?php foreach ($subjects as $key => $subject) { ?>
				<div class="row justify-content-center align-content-center" id="Id_<?= $subject ?>">
					<div class="col-md-2 pt-2">
						<label class="text-uppercase text-success"><?= $subject ?> Timings</label>
					</div>
					<div class="col-xs-12 col-md-2">
						<div class="form-group">
							<input type="text" name="from_time[]" class="form-control mytimepicker"
								   id="From_<?= $subject ?>" placeholder="<?= $subject ?> Sub From Time">
						</div>
					</div>
					<div class="col-xs-12 col-md-2">
						<div class="form-group">
							<input type="text" name="to_time[]" class="form-control mytimepicker"
								   id="To_<?= $subject ?>" placeholder="<?= $subject ?> Sub To Time">
						</div>
					</div>
				</div>
				<script>
					$(document).ready(function () {
						$('#Id_<?=$subject?>').hide();
					})
				</script>
				<?php
			} ?>
			<div class="row justify-content-center align-content-center" id="ortherSubjectsAddons">
				<div class="col-md-6 mb-3">
					<div class="checkbox checkbox-css">
						<input type="checkbox" id="otheramountlist"/>
						<label for="otheramountlist">Check To Add More Class (
							<small>Games,Drawing,...</small>
							)- <?= $classname ?> Class..</label>
					</div>
				</div>
			</div>
			<div class="row justify-content-center align-content-center mt-3">
				<div class="col-md-12" id="otheramountlistbox">
					<div class="row justify-content-center align-items-center">
						<div class="col-md-8">
							<div class="row">
								<div class="col-md-3 form-group">
									<input type="text" name="subjectnames[]" placeholder="Enter Class Name"
										   class="form-control">
								</div>
								<div class="col-md-3 form-group">
									<input type="text" name="from_time[]" placeholder="From Time"
										   class="form-control mytimepicker">
								</div>
								<div class="col-md-3 form-group">
									<input type="text" name="to_time[]" placeholder="To Time"
										   class="form-control mytimepicker">
								</div>
								<div class="col-md-2">
									<a href="javascript:void(0);" id="AddNewfield"
									   class="btn btn-success btn-sm">Add New</a>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12" id="appendfeefields"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>
				$(document).ready(function () {
					$('#otheramountlistbox,#ortherSubjectsAddons,#SaveButtonClass').hide();
					$("#otheramountlist").click(function (e) {
						if ($('#otheramountlist').is(":checked")) {
							$("#otheramountlist").val('yes');
							$("#otheramountlistbox").show();
						} else {
							$("#otheramountlist").val('no');
							$("#otheramountlistbox").hide();
							$("#appendfeefields").empty();
							$("input[name='servicename[]']").val('');
							$("input[name='serviceamount[]']").val('');
						}
					});

					$("#AddNewfield").click(function (e) {
						var Newfields = '<div class="row"><div class="col-md-3 form-group"><input type="text" name="subjectnames[]" placeholder="Enter Class Name" class="form-control"></div><div class="col-md-3 form-group"><input type="text" name="from_time[]" placeholder="From Time" class="form-control mytimepickers"></div><div class="col-md-3 form-group"><input type="text" name="to_time[]" placeholder="To Time" class="form-control mytimepickers"></div><div class="col-md-2"><a href="javascript:void(0);" id="AddNewfield" class="btn btn-danger btn-sm RemoveField">Remove</a></div></div>';

						$("#appendfeefields").append(Newfields);
					});

					$("#appendfeefields").on('click', '.RemoveField', function (e) {
						e.preventDefault();
						$(this).parent().parent().remove();
					})
				});
			</script>
			<div class="row justify-content-center align-items-center" id="SaveButtonClass">
				<input type="submit" name="saveclasstimings" value="Save Class Timings" class="btn btn-success">
			</div>
			<script>
				$(document).ready(function () {
					$('.mytimepicker,.timepicker,.mytimepickeredit').timepicker();
					$(".mytimepicker").val('');
				})
			</script>
		<?php }
	}

    //save timings
    public function SavetimingsFields(){
        extract($_REQUEST);
        $schooldata = $this->session->userdata['school'];
        //$this->print_r($_REQUEST);
		//exit;
        //school timings..
        if(isset($timing_type) && $timing_type == 'school'){
			    //$this->print_r($_REQUEST);
        	$school = $this->Model_dashboard->selectdata('sms_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1,'timingsfor'=>$timing_type),'sno');
            if(count($school) != 0){

            	//update timings
				$updateTimings = $this->Model_dashboard->updatedata(array('fromtime'=>date('H:i',strtotime($fromtime)),'totime'=>date('H:i',strtotime($totime)),'updated'=>date('Y-m-d H:i:s')),array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'timingsfor'=>$timing_type),'sms_timings');

				if($updateTimings != 0){
					$this->successalert('School Timings Are Successfully Updated..!','School timings are Updated @'.date('h:i: a',strtotime($fromtime)).' - '.date('h:i: a',strtotime($totime)).'..!');
					redirect(base_url('dashboard/timings'));
				}else{
					$this->failedalert('School Timings Are Failed To Update..!','School Timings Are Failed To Update @'.date('h:i: a',strtotime($school[0]->fromtime)).' - '.date('h:i: a',strtotime($school[0]->totime)).'..!');
					redirect(base_url('dashboard/timings'));
				}

            }else{
                $insert = $this->Model_dashboard->insertdata('sms_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'timingsfor'=>$timing_type,'fromtime'=>date('H:i',strtotime($fromtime)),'totime'=>date('H:i',strtotime($totime)),'updated'=>date('Y-m-d H:i:s')));
                if($insert != 0){
                    $this->session->set_flashdata('error', 'Successfull Saved School Timings..!');
                    $this->session->set_flashdata('text', 'School timings are saved @'.date('h:i: a',strtotime($fromtime)).' - '.date('h:i: a',strtotime($totime)).'..!');
                    redirect(base_url('dashboard/timings'));
                }
            }

            //end school timings
        }else if(isset($timing_type) && $timing_type == 'class'){

        	//class timings
			$insertdata 	= 	'';
			$syllabustype	=	$StdSyllubas;
			$syllabusclass	=	$StdClass;
			$class_section	=	$StdClassSection;
			$day_id			=	$dayname;
			$school_id		=	$schooldata->school_id;
			$branch_id		=	$schooldata->branch_id;
			//$this->print_r($_REQUEST);

            $subjectnames   =   array_merge(array_filter($subjectnames));
            $from_time      =   array_merge(array_filter($from_time));
            $to_time        =   array_merge(array_filter($to_time));

            /*$this->print_r($subjectnames);
            $this->print_r($from_time);
            $this->print_r($to_time);*/

            /*foreach($subjectnames as $key => $subject){
                $insertdata = array('school_id' => $school_id, 'branch_id' => $branch_id, 'timingsfor' => $timing_type, 'class' => $syllabusclass, 'section' => $class_section, 'titlesubject' => $subject, 'syllabus_type' => $syllabustype, 'day_class' => $day_id, 'fromtime' => date('h:i a', strtotime($from_time[$key])), 'totime' => date('h:i a', strtotime($to_time[$key])), 'updated' => date('Y-m-d H:i:s'));
                $this->print_r($insertdata);
            }
            exit;*/


			$classtimings = $this->Model_default->selectdata('sms_timings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'class'=>$syllabusclass,'syllabus_type'=>$syllabustype,'section'=>$class_section,'day_class'=>$day_id));

			if(count($classtimings) != 0) {
				//update timings

				$deleterelateddata = array('branch_id'=>$schooldata->branch_id,'school_id'=>$schooldata->school_id,'syllabus_type'=>$syllabustype,'class'=>$syllabusclass,'timingsfor'=>'class','day_class'=>$day_id);
				$delete_existing_data	=	$this->Model_default->deleterecord('sms_timings',$deleterelateddata);

				if($delete_existing_data != 0){

                    foreach($subjectnames as $key => $subject){
                        $insertdata = array('school_id' => $school_id, 'branch_id' => $branch_id, 'timingsfor' => $timing_type, 'class' => $syllabusclass, 'section' => $class_section, 'titlesubject' => $subject, 'syllabus_type' => $syllabustype, 'day_class' => $day_id, 'fromtime' => date('H:i', strtotime($from_time[$key])), 'totime' => date('H:i', strtotime($to_time[$key])), 'updated' => date('Y-m-d H:i:s'));
                        //$this->print_r($insertdata);
                        $insertupdatedata .= $this->Model_dashboard->insertdata('sms_timings', $insertdata);
                    }

					if ($insertupdatedata != 0){
						$this->successalert('Class Timetable successfully Updated..!', $syllabusclass . ' - ' . $class_section . ' Timetable successfully Updated..!');
						redirect(base_url('dashboard/timings'));
					}else{
						$this->successalert('Class Timetable Failed To Update..!', $syllabusclass . ' - ' . $class_section . ' Timetable Failed To Update..!');
						redirect(base_url('dashboard/timings'));
					}

				}else{
					$this->successalert('Timetable Failed To Update..!', $syllabusclass . ' - ' . $class_section . ' Timetable Failed To Update or Invalid Request..!');
					redirect(base_url('dashboard/timings'));
				}

			}else{
				//New Class sections

                foreach($subjectnames as $key => $subject){
                    $insertdata = array('school_id' => $school_id, 'branch_id' => $branch_id, 'timingsfor' => $timing_type, 'class' => $syllabusclass, 'section' => $class_section, 'titlesubject' => $subject, 'syllabus_type' => $syllabustype, 'day_class' => $day_id, 'fromtime' => date('H:i', strtotime($from_time[$key])), 'totime' => date('H:i', strtotime($to_time[$key])), 'updated' => date('Y-m-d H:i:s'));
                    //$this->print_r($insertdata);
                    $insert .= $this->Model_dashboard->insertdata('sms_timings', $insertdata);
                }

				if ($insert != 0) {
					$this->successalert('Class Timetable successfully Saved..!', $syllabusclass . ' - ' . $class_section . ' Timetable successfully saved..!');
					redirect(base_url('dashboard/timings'));
				} else {
					$this->successalert('Class Timetable Failed To Save..!', $syllabusclass . ' - ' . $class_section . ' Timetable Failed To save..!');
					redirect(base_url('dashboard/timings'));
				}

			}

			//end class timings
		}else if(isset($timing_type) && $timing_type == 'exam'){

        	//exam timings
        	if(isset($exam_type_slabs) && $exam_type_slabs == 'slabs' && $slab_name != '' && $slab_examsperday != ''){

        		//save or update slabs data
				//$this->print_r($_REQUEST);
				$examtimings = array();
				foreach($FromTime as $key => $value){
					$examtimings[$key] = date('H:i',strtotime($FromTime[$key])).' - '.date('H:i',strtotime($ToTime[$key]));
				}

				$slabslists = $this->Model_dashboard->selectdata('sms_examination_slabs_list',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id));
				$countlist = count($slabslists) + 1;

				$schoolname = $schooldata->schoolname;;
				$letters 	=  random_string('alpha', 1);
				$alfnums 	=  random_string('alnum', 1);
				$studentname= strtoupper($letters).' '.strtoupper($alfnums);
				$exam_id    = $this->manualgenerate_id($schoolname,date('y'),$studentname,$countlist);

				$insertdata = array('exam_id'=>$exam_id,'branch_id'=>$schooldata->branch_id,'school_id'=>$schooldata->school_id,'slab_name'=>$slab_name,'exam_per_day'=>$slab_examsperday,'exam_timings'=>serialize($examtimings),'updated'=>date('Y-m-d H:i:s'));
				$insertslabsdata = $this->Model_dashboard->insertdata('sms_examination_slabs_list',$insertdata);
				if($insertslabsdata != 0){
					$this->successalert('Successfully Saved Exam Slab..!',$slab_name.' Slab Successfully saved..!');
					redirect(base_url('dashboard/timings/set_timings'));
				}else{
					$this->failedalert('Failed To Saved Exam Slab..!',$slab_name.' Slab Failed To Save. Try again..!');
					redirect(base_url('dashboard/timings/set_timings'));
				}

			}else if(isset($exam_type) && $exam_type == 'exam_timetable' && $StdClass != '' && $StdSyllubas != '' && $StdClassSection != ''){

        		if($StdClassSection == 'all') {
					$examtimetabledata = $this->Model_dashboard->selectdata('sms_examtimings', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'syllabus_type' => $StdSyllubas, 'class' => $StdClass, 'exam_slab' => $Exam_selected_slab));
				}else{
					$examtimetabledata = $this->Model_dashboard->selectdata('sms_examtimings', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'syllabus_type' => $StdSyllubas, 'class' => $StdClass, 'exam_slab' => $Exam_selected_slab,'section'=>$StdClassSection));
				}

				if(count($examtimetabledata) != 0){

					$subjectnames = array_merge(array_filter($subjectnames));
					$examinationdates = array_merge(array_filter($examinationdates));
					$from_time = array_merge(array_filter($from_time));
					$to_time = array_merge(array_filter($to_time));
					$total_marks = array_merge(array_filter($total_marks));
					$totalmarks = '';

					if($StdClassSection == 'all') {
						$deleterelateddata = array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'syllabus_type' => $StdSyllubas, 'class' => $StdClass, 'exam_slab' => $Exam_selected_slab);
					}else{
						$deleterelateddata = array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'syllabus_type' => $StdSyllubas, 'class' => $StdClass, 'exam_slab' => $Exam_selected_slab,'section'=>$StdClassSection);
					}

					$delete_existing_data	=	$this->Model_default->deleterecord('sms_examtimings',$deleterelateddata);

					 if($delete_existing_data != 0) {

						 foreach ($examinationdates as $key => $examinationdate) {
							 $timingsdetails[$key] = array('subject' => $subjectnames[$key], 'date' => $examinationdate,'from'=>date('H:i',strtotime($from_time[$key])), 'to'=>date('H:i',strtotime($to_time[$key])),'marks' => $total_marks[$key]);
							 @$totalmarks += $total_marks[$key];
						 }

						 $slabslists = $this->Model_dashboard->selectdata('sms_examtimings', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id));
						 $countlist = count($slabslists) + 1;

						 $schoolname = $schooldata->schoolname;;
						 $letters = random_string('alpha', 1);
						 $alfnums = random_string('alnum', 1);
						 $studentname = strtoupper($letters) . ' ' . strtoupper($alfnums);
						 $examination_id = $this->manualgenerate_id($schoolname, date('y'), $studentname, $countlist);

						 $inserttimetabledata = array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'examination_id' => $examination_id, 'syllabus_type' => $StdSyllubas, 'class' => $StdClass, 'section' => $StdClassSection, 'exam_slab' => $Exam_selected_slab, 'exam_timings' => serialize($timingsdetails), 'total_marks' => $totalmarks, 'updated' => date('Y-m-d H:i:s'));

						 $insertslabsdata = $this->Model_dashboard->insertdata('sms_examtimings', $inserttimetabledata);
						 if($insertslabsdata != 0) {
							 $this->successalert('Successfully Updated Exam TimeTable..!', $StdClass.' - '.$StdClassSection.' Sections TimeTable Successfully saved..!');
							 redirect(base_url('dashboard/timings/exam/timingslist'));
						 }else{
							 $this->failedalert('Failed To Updated Exam TimeTable..!', $StdClass.' - '.$StdClassSection. ' Sections TimeTable Failed To Save. Try again..!');
							 redirect(base_url('dashboard/timings/set_timings'));
						 }

					 }else{
						 $this->failedalert('Failed To Updated Exam TimeTable..!', $StdClass.' - '.$StdClassSection. ' Sections TimeTable Failed To Update.Invalid Request.Try again..!');
						 redirect(base_url('dashboard/timings/set_timings'));
					 }

				}else{
					$timingsdetails = array();

					$subjectnames = array_merge(array_filter($subjectnames));
					$examinationdates = array_merge(array_filter($examinationdates));
					$from_time = array_merge(array_filter($from_time));
					$to_time = array_merge(array_filter($to_time));
					$total_marks = array_merge(array_filter($total_marks));


					$totalmarks = '';

					foreach ($examinationdates as $key => $examinationdate) {
						$timingsdetails[$key] = array('subject' => $subjectnames[$key],'date' => $examinationdate,'from'=>date('H:i',strtotime($from_time[$key])),'to'=> date('H:i',strtotime($to_time[$key])),'marks' =>$total_marks[$key]);
						@$totalmarks += $total_marks[$key];
					}

					$slabslists = $this->Model_dashboard->selectdata('sms_examtimings', array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id));
					$countlist = count($slabslists) + 1;

					$schoolname = $schooldata->schoolname;;
					$letters = random_string('alpha', 1);
					$alfnums = random_string('alnum', 1);
					$studentname = strtoupper($letters) . ' ' . strtoupper($alfnums);
					$examination_id = $this->manualgenerate_id($schoolname, date('y'), $studentname, $countlist);

					$inserttimetabledata = array('school_id' => $schooldata->school_id, 'branch_id' => $schooldata->branch_id, 'examination_id' => $examination_id, 'syllabus_type' => $StdSyllubas, 'class' => $StdClass, 'section' => $StdClassSection, 'exam_slab' => $Exam_selected_slab, 'exam_timings' => serialize($timingsdetails), 'total_marks' => $totalmarks, 'updated' => date('Y-m-d H:i:s'));

					$insertslabsdata = $this->Model_dashboard->insertdata('sms_examtimings', $inserttimetabledata);
					if ($insertslabsdata != 0) {
						$this->successalert('Successfully Saved Exam TimeTable..!', $slab_name . ' TimeTable Successfully saved..!');
						redirect(base_url('dashboard/timings/exam/timingslist'));
					} else {
						$this->failedalert('Failed To Saved Exam TimeTable..!', $slab_name . ' TimeTable Failed To Save. Try again..!');
						redirect(base_url('dashboard/timings/set_timings'));
					}
				}

			}else if(isset($exam_type) && $exam_type == 'exam_timetable' && $StdClass != '' && $StdSyllubas != '' && $StdClassSection != '' && isset($exam_type_slabs) && $exam_type_slabs == 'slabs' && $slab_name != '' && $slab_examsperday != ''){

				$this->failedalert('Failed To Saved Exam TimeTable..!', '*Unable To Create both Slab and Exam Timetable at a time.Please create one b one..!');
				redirect(base_url('dashboard/timings/set_timings'));

			}

		}else if(isset($timing_type) && $timing_type == 'bus'){
        	$this->print_r($_REQUEST);
			exit;
        	$schooldata = $this->session->userdata['school'];
			$schoolname  = $schooldata->schoolname;
			$school_id = $schooldata->school_id;
			$branch_id = $schooldata->branch_id;

			$buslist = $this->Model_dashboard->selectdata('sms_bus_timings',array('school_id'=>$schoolid,'branch_id'=>$branchid));
			$countlist = count($buslist) + 1;


			$randnumber  = $this->Model_integrate->generateRandom(0,99);
			$letters =  random_string('alpha', 1);
			$alfnums =  random_string('alnum', 1);
			$studentname = strtoupper($letters).' '.strtoupper($alfnums);
			$busreg_id   = $this->manualgenerate_id($schoolname,date('y'),$studentname,$countlist);



        	$conduction	=	array('branch_id'=>$branch_id,'school_id'=>$school_id,'bus_number'=>$Bus_Number);
        	$bustimings = $this->Model_dashboard->selectdata('sms_bus_timings',$conduction,'sno');
        	if(count($bustimings) != 0){
        		//update
				if($enable_device == 'device_yes'){
					$Enter_gps_device_id = $Enter_gps_device_id;
				}else{ $Enter_gps_device_id =''; }
				$mng_from_time 	= 	date('H:i',strtotime($mng_from_time));
				$mng_to_time	=	date('H:i',strtotime($mng_to_time));
				$evn_from_time	=	date('H:i',strtotime($evn_from_time));
				$evn_to_time	=	date('H:i',strtotime($evn_to_time));

				$mng_timings	=	array('from'=>$mng_from_time,'to'=>$mng_to_time);
				$evn_timings	=	array('from'=>$evn_from_time,'to'=>$evn_to_time);

				$updateconduction = array('school_id'=>$school_id, 'branch_id'=>$branch_id,'sno'=>$sno_id,'bus_id'=>$busreg_id);
				$updatedata = array('school_id'=>$school_id, 'branch_id'=>$branch_id, 'from_location'=>$From_location, 'to_location'=>$To_location, 'bus_number'=>$Bus_Number, 'gps'=>$enable_device, 'gps_id'=>$Enter_gps_device_id, 'morning_timings'=>serialize($mng_timings), 'evening_timings'=>serialize($evn_timings), 'updated'=>date('Y-m-d H:i:s'));

				$insert = $this->Model_dashboard->updatedata($updateconduction,$updatedata,'sms_bus_timings');
				if($insert != 0){
					$this->successalert('Successfully Updated Bus timings',$Bus_Number.' Bus Timings as successfully Updated..!');
					redirect(base_url('dashboard/timings'));
				}else{
					$this->failedalert('Failed To Update Bus timings',$Bus_Number.' Bus Timings as Failed To Update..!');
					redirect(base_url('dashboard/timings/set_timings'));
				}
			}else {
        		if($enable_device == 'device_yes'){
					$Enter_gps_device_id = $Enter_gps_device_id;
				}else{ $Enter_gps_device_id =''; }
        		$mng_from_time 	= 	date('H:i',strtotime($mng_from_time));
        		$mng_to_time	=	date('H:i',strtotime($mng_to_time));
        		$evn_from_time	=	date('H:i',strtotime($evn_from_time));
				$evn_to_time	=	date('H:i',strtotime($evn_to_time));

				$mng_timings	=	array('from'=>$mng_from_time,'to'=>$mng_to_time);
				$evn_timings	=	array('from'=>$evn_from_time,'to'=>$evn_to_time);

				$insertdata = array('school_id'=>$school_id, 'branch_id'=>$branch_id, 'from_location'=>$From_location, 'to_location'=>$To_location, 'updated'=>date('Y-m-d H:i:s'), 'bus_number'=>$Bus_Number, 'gps'=>$enable_device, 'gps_id'=>$Enter_gps_device_id, 'morning_timings'=>serialize($mng_timings), 'evening_timings'=>serialize($evn_timings),'bus_id'=>$busreg_id);

				$insert = $this->Model_dashboard->insertdata('sms_bus_timings',$insertdata);
				if($insert != 0){
					$this->successalert('Successfully Saved Bus timings',$Bus_Number.' Bus Timings as successfully saved..!');
					redirect(base_url('dashboard/timings'));
				}else{
					$this->failedalert('Failed To Save Bus timings',$Bus_Number.' Bus Timings as Failed To save..!');
					redirect(base_url('dashboard/timings/set_timings'));
				}

			}
		}

    }

    //Examination Timings list Details
	public function ExaminationTimingslistDetails(){
		$data['userdata'] = $this->Model_integrate->userdata();
        $data['PageTitle'] = "Examination Timetable..!";
        //getting school data in session
        $schooldata = $data['schooldata'] = $this->session->userdata['school'];
        //sending syllabus data to views and getting class data by ajax
        $data['syllabus'] = $this->Model_dashboard->syllabustypes($schooldata->school_id,$schooldata->branch_id);
        $data['timingslist'] = $this->Model_dashboard->selectdata('sms_examtimings',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'status'=>1),'updated');
        $data['timings'] = $this->Model_dashboard->selectorderby('sms_formdata',array('type'=>'timings','status'=>1),'id');
        $data['schooldata'] = $schooldata;
        $this->loadViews('admin/timings/sms_exam_timetable_page',$data);
	}

	//delete Delete Exam Timetable
	public function DeleteExamTimetable(){
    	$sessiondata = $this->session->userdata();
    	$schooldata	 = $sessiondata['school'];

    	$insert_id	=	$this->uri->segment(5);
		$branch_id	=	$this->uri->segment(6);
		$school_id	=	$this->uri->segment(7);
		if((isset($insert_id) && $insert_id!='') && (isset($branch_id) && $branch_id!='') && (isset($school_id) && $school_id!='')){

			$deleterelateddata = array('branch_id'=>$branch_id,'school_id'=>$school_id,'sno'=>$insert_id);
			$delete_existing_data	=	$this->Model_default->deleterecord('sms_examtimings',$deleterelateddata);
			if($delete_existing_data != 0){
				$this->successalert('Successfully  delete Exam Timetable..!','You have Successfully Delete Exam Timetable..!');
				redirect(base_url('dashboard/timings/exam/timingslist'));
			}else{
				$this->failedalert('Failed to delete Exam Timetable..!','Sorry you have Failed to delete exam timetable or Invalid Request.');
				redirect(base_url('dashboard/timings/exam/timingslist'));
			}
		}else{
			$this->failedalert('Unable to delete Exam Timetable..!','Sorry you have unable to delete exam timetable.Invalid Request or Opps Error.');
			redirect(base_url('dashboard/timings/exam/timingslist'));
		}
	}

    //delete Examination Slabs Data
    public function DeleteExaminationSlabsData(){
		$sessiondata = $this->session->userdata();
		$schooldata	 = $sessiondata['school'];

		$insert_id  = $this->uri->segment(5);
		$branch_id  = $this->uri->segment(6);
		$school_id  = $this->uri->segment(7);
		$examrg_id  = $this->uri->segment(8);

		if((isset($insert_id) && $insert_id != '') && (isset($branch_id) && $branch_id != '') && (isset($school_id) && $school_id != '') && (isset($examrg_id) && $examrg_id != '')){
		  $deleterelateddata = array('branch_id'=>$branch_id,'school_id'=>$school_id,'sno'=>$insert_id,'exam_id'=>$examrg_id);
				$delete_existing_data	=	$this->Model_default->deleterecord('sms_examination_slabs_list',$deleterelateddata);
				if($delete_existing_data != 0){
			$relateddata  =  array('branch_id'=>$branch_id,'school_id'=>$school_id,'exam_slab'=>$insert_id);
			$relateddata  =  $this->Model_default->deleterecord('sms_examtimings',$relateddata);
					$this->successalert('Successfully delete Exam Slab & Data..!','You have Successfully Delete Exam Slab & Data..!');
					redirect(base_url('dashboard/timings/exam/timingslist'));
				}else{
					$this->failedalert('Failed to delete Exam Slab & Data..!','Sorry you have Failed to delete exam Slab & Data or Invalid Request.');
					redirect(base_url('dashboard/timings/exam/timingslist'));
				}
		}else{
		  $this->failedalert('Unable to delete Exam Slab & Data..!','Sorry you have unable to delete Exam Slab & Data.Invalid Request or Opps Error.');
				redirect(base_url('dashboard/timings/exam/timingslist'));
		}

  	}

  	//Delete All class Timetable
  	public function DeleteAllclassTimetable(){
    $sessiondata = $this->session->userdata();
    $schooldata	 = $sessiondata['school'];

    $syllabus_id  = $this->uri->segment(5);
    $class  = $this->uri->segment(6);
    $section  = $this->uri->segment(7);
    $branch_id  = $this->uri->segment(8);
    $school_id  = $this->uri->segment(9);

    if((isset($syllabus_id) && $syllabus_id != '') && (isset($class) && $class != '') && (isset($section) && $section != '') && (isset($branch_id) && $branch_id != '') && (isset($school_id) && $school_id != '')){
      $deleterelateddata = array('branch_id'=>$branch_id,'school_id'=>$school_id,'syllabus_type'=>$syllabus_id,'class'=>$class,'section'=>$section);
			$delete_existing_data	=	$this->Model_default->deleterecord('sms_timings',$deleterelateddata);
			if($delete_existing_data != 0){
				$this->successalert('Successfully delete class Timetable..!','You have Successfully Delete class Timetable..!');
				redirect(base_url('dashboard/timings'));
			}else{
				$this->failedalert('Failed to delete class Timetable..!','Sorry you have Failed to delete class Timetable or Invalid Request.');
				redirect(base_url('dashboard/timings'));
			}
    }else{
      $this->failedalert('Unable to delete class Timetable..!','Sorry you have unable to delete class TimeTable.Invalid Request or Opps Error.');
			redirect(base_url('dashboard/timings'));
    }

  }

  	//Delete class Timetable by day
  	public function DeleteclassTimetable(){
    $sessiondata = $this->session->userdata();
    $schooldata	 = $sessiondata['school'];
    $day_timetable  = $this->uri->segment(5);
    $syllabus_id  = $this->uri->segment(6);
    $class  = $this->uri->segment(7);
    $section  = $this->uri->segment(8);
    $branch_id  = $this->uri->segment(9);
    $school_id  = $this->uri->segment(10);

    if((isset($syllabus_id) && $syllabus_id != '') && (isset($day_timetable) && $day_timetable != '') && (isset($class) && $class != '') && (isset($section) && $section != '') && (isset($branch_id) && $branch_id != '') && (isset($school_id) && $school_id != '')){
      $deleterelateddata = array('branch_id'=>$branch_id,'school_id'=>$school_id,'day_class'=>$day_timetable,'syllabus_type'=>$syllabus_id,'class'=>$class,'section'=>$section);
			$delete_existing_data	=	$this->Model_default->deleterecord('sms_timings',$deleterelateddata);
			if($delete_existing_data != 0){
				$this->successalert('Successfully delete class Timetable..!','You have Successfully Delete class Timetable..!');
				redirect(base_url('dashboard/timings'));
			}else{
				$this->failedalert('Failed to delete class Timetable..!','Sorry you have Failed to delete class Timetable or Invalid Request.');
				redirect(base_url('dashboard/timings'));
			}
    }else{
      $this->failedalert('Unable to delete class Timetable..!','Sorry you have unable to delete class TimeTable.Invalid Request or Opps Error.');
			redirect(base_url('dashboard/timings'));
    }
  }

  	//Delete BusTimings Data
	public function DeleteBusTimingsData(){
    	extract($_REQUEST);
    	$sno_id	=	$this->uri->segment(5);
		$branch_id	=	$this->uri->segment(6);
		$school_id	=	$this->uri->segment(7);
		$bus_id	=	$this->uri->segment(8);


		if((isset($sno_id) && $sno_id != '') && (isset($branch_id) && $branch_id != '') && (isset($school_id) && $school_id != '') && (isset($bus_id) && $bus_id != '')){

			$conduction = array('sno'=>$sno_id,'bus_id'=>$bus_id,'school_id'=>$school_id,'branch_id'=>$branch_id);
			$updatedata = array('status'=>0,'updated'=>date('Y-m-d H:i:s'));

			$delete_existing_data	=	$this->Model_default->updatedata('sms_bus_timings',$updatedata,$conduction);
			if($delete_existing_data != 0){
				$this->successalert('Successfully delete bus details..!','You have Successfully Delete '.$bus_id.' bus details..!');
				redirect(base_url('dashboard/timings'));
			}else{
				$this->failedalert('Failed to delete bus details..!','Sorry you have Failed to delete '.$bus_id.' bus details or Invalid Request.');
				redirect(base_url('dashboard/timings'));
			}
		}else{
			$this->failedalert('Unable to delete bus details..!','Sorry you have unable to delete '.$bus_id.' bus details.Invalid Request or Opps Error.');
			redirect(base_url('dashboard/timings'));
		}

	}

}
