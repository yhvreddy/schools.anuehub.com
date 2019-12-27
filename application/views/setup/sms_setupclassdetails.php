<!-- begin #content -->
<div id="content" class="content">
    <?php $data = $this->session->userdata; ?>
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Settngs</a></li>
        <li class="breadcrumb-item active">Setup Classes</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Setup class<small></small></h1>
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

            //syllabus list all
			$syllabus =	$this->Model_dashboard->selectdata('sms_scl_types',array('status'=>1));
			$defaultclass =	$this->Model_dashboard->selectdata('sms_defaultclasses',array('status'=>1));
        ?>

		<div class="col-md-4">
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					</div>
					<h4 class="panel-title">Enable & Disable Syllabus</h4>
				</div>
				<div class="panel-body">
					<form method="post" class="col-12" action="<?=base_url('setup/enableanddisablesyllabus')?>" id="enabledisablesyllabus">
						<h5>Enable & Disable school syllabus</h5>
						<div class="row">
							<?php //print_r($syllabus); ?>
							<input type="hidden" value="<?= $data['school']->reg_id ?>" name="regid">
							<input type="hidden" value="<?= $data['school']->branch_id ?>" name="branchid">
							<input type="hidden" value="<?= $data['school']->school_id ?>" name="schoolid">
							<?php foreach ($syllabus as $values){ ?>
								<div class="col-md-4 pull-left">
									<div class="checkbox checkbox-css m-b-20">
										<input type="checkbox" <?php if(in_array($values->id, $scltypes)){ echo 'checked'; } ?> value="<?= $values->id; ?>" id="syllubus_<?= $values->id ?>" name="syllubus_class[]" class="custom-control-input">
										<label for="syllubus_<?= $values->id ?>"><?= $values->type; ?></label>
									</div>
								</div>
							<?php  } ?>
							<div class="col-md-12 mb-2">
								<center><input type="submit" class="btn btn-success" value="Save syllabus"></center>
							</div>
						</div>
					</form>

					<div class="col-md-12">
						<h5 class="pt-1 clearfix">Running Syllabus.</h5>
						<div class="row">
							<?php //print_r($scltypes); ?>
							<?php foreach ($syllabus as $values){ if(in_array($values->id, $scltypes)){ ?>
								<div class="col-md-4">
									<label class="label text-success font-20" style="font-size: 14px;padding: 0px;"> <i class="fas fa-angle-right"></i> <?= $values->type; ?></label>
								</div>
							<?php } } ?>
						</div>
					</div>
					
				</div>
			</div>
		</div>

        <div class="col-md-8">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Add / Edit Classes</h4>
                </div>
                <div class="panel-body">
                    <form method="post" action="<?= base_url() ?>setup/saveclassdetailslist" id="saveclasslists">
                        <div class="col-12 p-l-0">
							<?php if(count($chkdata) != 0){
								//echo "<pre>"; print_r($chkdata); echo "</pre>";
								foreach ($scltypes as $key => $enabledsyllabus){
									?>
									<h4><?= 'SET CLASS FOR '.$syllabus[$key]->type ?> Syllabus</h4>
									<label>Select Classes : <span class="text-danger">*</span></label>
									<?php
									if(isset($chkdata[$key]->class_type) &&  $scltypes[$key] == $chkdata[$key]->class_type){
										$savedclass = unserialize($chkdata[$key]->class);
										?>
										<input type="hidden" value="<?= $data['school']->reg_id ?>" name="regid">
										<input type="hidden" value="<?= $data['school']->branch_id ?>" name="branchid">
										<input type="hidden" value="<?= $data['school']->school_id ?>" name="schoolid">
										<input type="hidden" value="<?= $syllabus[$key]->type ?>" name="schoolname[]">
										<div class="row">
											<?php foreach ($defaultclass as $class){ ?>
												<div class="col-md-2 pull-left">
													<div class="checkbox checkbox-css m-b-20">
														<input type="checkbox" <?php if(in_array($class->class,$savedclass)){ echo 'checked'; } ?> value="<?= $class->class; ?>" id="<?= $syllabus[$key]->type.$class->class; ?>" name="<?= $syllabus[$key]->type ?>_class[]" class="custom-control-input">
														<label for="<?= $syllabus[$key]->type.$class->class; ?>"><?= $class->class; ?></label>
													</div>
												</div>
											<?php } ?>
										</div>
										<?php
									}else{
										?>
										<input type="hidden" value="<?= $data['school']->reg_id ?>" name="regid">
										<input type="hidden" value="<?= $data['school']->branch_id ?>" name="branchid">
										<input type="hidden" value="<?= $data['school']->school_id ?>" name="schoolid">
										<input type="hidden" value="<?= $syllabus[$key]->type ?>" name="schoolname[]">
										<div class="row">
											<?php foreach ($defaultclass as $class){ ?>
												<div class="col-md-2 pull-left">
													<div class="checkbox checkbox-css m-b-20">
														<input type="checkbox" value="<?= $class->class; ?>" id="<?= $syllabus[$key]->type.$class->class; ?>" name="<?= $syllabus[$key]->type ?>_class[]" class="custom-control-input">
														<label for="<?= $syllabus[$key]->type.$class->class; ?>"><?= $class->class; ?></label>
													</div>
												</div>
											<?php } ?>
										</div>
										<?php
									}
								?>

							<?php } }else{  } ?>
                            <div class="col-md-12 pt-3">
                                <center><input type="submit" class="btn btn-success" value="Save Classes"></center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- end row -->
</div>
<!-- end #content -->
<script>
    $(document).ready(function () {
        //save classes list
        $("#saveclasslist").submit(function (ee) {
            ee.preventDefault();
            $("#loader").show();
            $.ajax({
                url: '<?= base_url() ?>setup/saveclassdetailslist',
                method: 'POST',
                dataType: 'json',
                data: new FormData(this),
                processData: false,
                contentType: false,
            })
            .done(function (dataresponce) {
                $("#loader").hide();
                console.log(dataresponce);
                if (dataresponce.key == 0) {
                    swal({
                        title: "Sorry",
                        text: dataresponce.message,
                        type: "warning",
                    },function () {
                        //$("#sectionslist").load('subsetups/sms_sections_setup.php' + '#listofsections');
                        $("#saveclasslist").trigger('reset');
                        $("#saveclasslist").hide();
                        $("#sectionslist").show();
                    });
                    //swal("Sorry", dataresponce.message , "warning");
                } else if (dataresponce.key == 1) {
                    swal({
                        title: "success",
                        text: dataresponce.message,
                        type: "success",
                    }, function () {
                        // $("#saveclasslist").trigger('reset');
                        // $("#saveclasslist").hide();
                        // $("#sectionslist").show();
                        window.location.href = '<?= base_url('setup/sections') ?>';
                        //window.location.href = '<?= base_url('setup/sections') ?>';
                        //$("#listofsections").load();
                        //$("#listofsections").load('subsetups/sms_sections_setup.php' + '#listofsections');
                    });
                }
            })
            .fail(function (req, status, err) {
                //console.log("error : " + errordata);
                console.log('Something went wrong', status, err);
                $("#loader").hide();
            })

        });
    })
</script>
