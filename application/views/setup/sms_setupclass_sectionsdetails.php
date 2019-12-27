<!-- begin #content -->
<div id="content" class="content">
    <?php $data = $this->session->userdata; ?>
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Settngs</a></li>
        <li class="breadcrumb-item active">Setup Sections</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Setup Sections<small></small></h1>
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
		<div class="col-md-4">
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					</div>
					<h4 class="panel-title">Add / Edit Sections</h4>
				</div>
				<div class="panel-body">
					<h5>Add / Update Divide Sections</h5>
					<form class="row" method="post" action="<?=base_url('setup/savesectionslist')?>">
						<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label for="sclsyllabuslist">School Enabled Syllabus</label>
							<select type="text" name="StdSyllubas" id="sclsyllubaslistData" class="form-control select2" style="padding:0px">
								<option value="">Select Syllabus Type</option>
								<?php foreach ($syllabus as $key => $value) { ?>
									<option value="<?= $key ?>"><?= $value ?></option>
								<?php } ?>
							</select>
						</div>

						<!--<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<label for="SyllabusClasses">School Syllabus Class</label>
							<select type="text" name="StdClass" id="SyllabusClasses" class="form-control select2" disabled="" style="padding:0px 10px">
								<option value="">Select Class</option>
							</select>
						</div>-->

						<div class="form-group col-md-12 col-sm-12 col-xs-12" id="SectionsDivideClass">

							<center>
								<h4>Please select following options</h4>
								<img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>">
							</center>

						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function(){
				$("#sclsyllubaslistData").change(function(){
					//console.log($(this).val());
					var syllabustype = $(this).val();
					$.ajax({
						type: "POST",
						url: "<?=base_url('setup/divideclasssections')?>",// where you wanna post
						data: {syllabus: syllabustype},
						/*processData: false,
						contentType: false,*/
						error: function (jqXHR, textStatus, errorMessage) {
							console.log(errorMessage); // Optional
						},
						success: function (data) {
							$('#SectionsDivideClass').html(data);
						}
					});
				})
			})
		</script>
        <div class="col-md-8">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Sections List</h4>
                </div>
                <div class="panel-body">
					<?php $sectionslist = $this->Model_dashboard->selectdata('sms_section',array('school_id'=>$data['school']->school_id,'branch_id'=>$data['school']->branch_id));
						if(count($sectionslist) != 0){
							  //print_r($sections);
							?>
							<table class="table table-bordered table-striped" id="myTable">
								<thead>
									<th>#</th>
									<th width="15%">Syllabus</th>
									<th width="15%">Class</th>
									<th width="55%">Section's</th>
									<th width="15%" style="display: none"></th>
									<th></th>
								</thead>
								<tbody>
									<?php $i = 1; foreach ($sections as $section) {
										$sms_scl_types = $this->Model_dashboard->selectdata('sms_scl_types',array('id'=>$section->class_type,'status'=>1));
										?>
										<tr>
											<td><?=$i?></td>
											<td align="center"><?=$sms_scl_types[0]->type?></td>
											<td align="center"><?=$section->class?> class</td>
											<td>
												<?php
													$classesections = unserialize($section->section);
													$sections = str_replace('"','',implode(', ',$classesections));
													echo count($classesections).' sections : ';
													foreach ($classesections as $list){
														?>
															<span class="label label-info"><?=str_replace('"','',$list)?></span>
														<?php
													}
												?>
											</td>
											<td align="center">
												<span data-toggle="tooltip" title="Delete section"><a href="<?=base_url('setup/sections/delete/'.$section->sno.'/'.$section->branch_id.'/'.$section->school_id.'?action=delete')?>" onclick="return confirm('You want to delete all <?=$section->class?> class sections : <?=$sections?>')"><i class="fa fa-trash-o fa-dx"></i></a></span>&nbsp;&nbsp;
											</td>
										</tr>
									<?php $i++; } ?>
								</tbody>
							</table>
							<?php
						}else{
							$this->Model_dashboard->norecords();
						}
					?>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>
<!-- end #content -->
<script>
    //sections list
    $("#sectionslist").submit(function (ee) {
        ee.preventDefault();
        $("#loader").show();
        $.ajax({
            url: '<?= base_url() ?>setup/savesectionslist',
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

                    });
                    //swal("Sorry", dataresponce.message , "warning");
                } else if (dataresponce.key == 1) {
                    swal({
                        title: "success",
                        text: dataresponce.message,
                        type: "success",
                    }, function () {
                        window.location.href = '<?= base_url('setup/sections') ?>';
                        // $("#saveclasslist").trigger('reset');
                        // $("#saveclasslist").hide();
                        // $("#sectionslist").hide();
                        // $("#sectionslist").trigger('reset');
                        //$(".actions").show();
                        //$("#classesandsectionsfinsh").show();
                        //$("#sectionslist").load('subsetups/sms_sections_setup.php' + '#listofsections');
                    });
                }
            })
            .fail(function (req, status, err) {
                //console.log("error : " + errordata);
                console.log('Something went wrong', status, err);
                $("#loader").hide();
            })

    });
</script>
