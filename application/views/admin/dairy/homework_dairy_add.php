<!-- Container fluid  -->
<?php $schooldata = $this->session->userdata['school']; ?>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Reports</a></li>
        <li class="breadcrumb-item active">Homework Reports</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Homework Reports<small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Add / Edit Homework Report</h4>
                </div>
                <div class="panel-body">
                    <form method="post" action="<?=base_url('dashboard/reports/saveHomeworkDetails')?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label for="reportHomeworkDate">Date</label>
                                <input type="text" name="reportHomeworkDate" id="reportHomeworkDate" required="" class="mydatepicker form-control" placeholder="Pick date" value="<?=date('m/d/Y')?>">
                            </div>

                            <div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label for="sclsyllabuslist">Select Syllabus</label>
                                <select type="text" name="StdSyllubas" id="sclsyllubaslist" class="form-control" style="padding:5px !important;">
                                    <option value="">Select Syllabus</option>
                                    <?php foreach ($syllabus as $key => $value) { ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label for="SyllabusClasses">Select Class</label>
                                <select type="text" name="StdClass" id="SyllabusClasses" class="form-control" style="padding:0px 10px">
                                    <option value="">Select Class</option>
                                </select>
                            </div>

                            <div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                <label for="SyllabusClasses">Class Sections</label>
                                <select type="text" name="StdClassSection" id="DairyClassesSections" class="form-control" style="padding:0px 10px">
                                    <option value="">Class Section</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center" id="DairyHomeworkSubjectsList">
                            <div class="col-md-12 mt-5 mb-5">
                                <center>
                                    <h4>Please select following options..!</h4>
                                    <img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>" style="">
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Todays Dairy List</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
						<?php //print_r($homeworks); ?>
						<table class="table table-striped table-bordered" id="myTable">
							<thead>
								<td>#</td>
								<td>Syllabus</td>
								<td>Class - Sec</td>
								<td>Date</td>
								<td></td>
							</thead>
							<tbody>
								<?php $i = 1; foreach ($homeworks as $key => $homework){ ?>
									<tr>
										<td><?=$i++?></td>
										<td align="center">
											<?php
												$name = $this->Model_dashboard->syllabusname(array('id'=>$homework->syllabus));
												print_r($name[0]->type);
											?>
										</td>
										<td align="center"><?=$homework->class.' - '.$homework->section?></td>
										<td align="center"><?=date('d-m-Y',strtotime($homework->hw_date))?></td>
										<td align="center">
											<a href="javascript:;" data-toggle="modal" data-target="#DairyHomeworkreport_<?=$homework->id?>"> <i class="fa fa-eye fa-dx"></i> </a>&nbsp;
											<?php if($homework->publish != 0){ ?>
												<a href="<?=base_url('dashboard/reports/UnpublishHwreport/'.$homework->id.'/0/unpublish')?>" onclick="return confirm('are you sure to unpublish this homework report..!')"><i class="fa fa-power-off fa-dx text-red"></i></a>
											<?php }else{ ?>
												<a href="<?=base_url('dashboard/reports/publishHwreport/'.$homework->id.'/1/publish')?>" onclick="return confirm('are you sure to publish this homework report..!')"><i class="fa fa-power-off fa-dx text-success"></i></a>
											<?php } ?>
											&nbsp;
										</td>
									</tr>
									<!-- Modal -->
									<div class="modal fade" id="DairyHomeworkreport_<?=$homework->id?>" tabindex="-1" role="dialog" aria-labelledby="DairyHomeworkreport_<?=$homework->id?>"
										 aria-hidden="true">
										<div class="modal-dialog" role="document" style="margin-top: 80px">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel"><?=date('d-m-Y',strtotime($homework->hw_date))?> Homework Report</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
                                                    
                                                    <?php 
                                                        $hwdetails = unserialize($homework->hw_details);
                                                        //echo "<pre>"; print_r($hwdetails); echo "</pre>";
                                                    ?>
                                                        <div class="row">
                                                            <div class="col-md-4"><strong>Subject</strong></div>
                                                            <div class="col-md-8"><strong>HomeWork Details</strong></div>
                                                        </div>
                                                    
                                                    <?php 
                                                        for($i = 0; $i < count($hwdetails); $i++){
                                                            foreach($hwdetails[$i] as $key => $hwdetail){ ?>
                                                                <div class="row mt-2">
                                                                    <div class="col-md-4 text-success"><?=$key?> <span class="pull-right"> : </span></div>
                                                                    <div class="col-md-8"><?=$hwdetail?></div>
                                                                </div>
                                                    <?php   }
                                                        }
                                                    ?>
                                                    
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
							</tbody>
						</table>
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
        $("input[name='srctype']").click(function(){
            if($('#radio_3').is(':checked')){
                $('#upload').show();
                $('#url').hide();
            }else if($('#radio_4').is(':checked')){
                $('#url').show();
                $('#upload').hide();
            }else if($('#radio_5').is(':checked')){
                $('#url').hide();
                $('#upload').hide();
            }
        });

        $('#SyllabusClasses').change(function () {
            $("#loader").show();
            var classname    = $(this).val();
            var syllabusname = $("#sclsyllubaslist").val();
            if(classname != '' && syllabusname != ''){
                var request = $.ajax({
                    url: "<?=base_url('dashboard/class/sectionslist')?>",
                    type: "POST",
                    data: {classname : classname,syllabustype : syllabusname,requesttype:'class_sections',schoolid:"<?=$school_id?>",branchid:"<?=$branch_id?>"},
                    dataType: "json"
                });

                request.done(function(dataresponce) {
                    console.log(dataresponce);
                    $("#loader").hide();
                    $("#DairyClassesSections").children('option:not(:first)').remove();
                    var list = "";
                    	//list += "<option value='all'>All sections</option>";
                    for($l = 0; dataresponce.length > $l; $l++){
                        list += "<option value='"+ dataresponce[$l] +"'>"+ dataresponce[$l] + " Section "+"</option>";
                    }
                    $("#DairyClassesSections").append(list);
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

        $('#DairyClassesSections').change(function () {
            $("#loader").show();
            var sectionname     = $(this).val();
            var syllabusname    = $("#sclsyllubaslist").val();
            var syllabusclass   = $('#SyllabusClasses').val();
            var reportDate      = $('#reportHomeworkDate').val();
            if(syllabusclass != '' && sectionname != '' && syllabusname != '' && reportDate != ''){
                var request = $.ajax({
                    url: "<?=base_url('dashboard/reports/dairySubjectsList')?>",
                    type: "POST",
                    data: {classname : syllabusclass,syllabustype : syllabusname,requesttype:'subjectslist',school_id:"<?=$school_id?>",branch_id:"<?=$branch_id?>",Section:sectionname,reportdate:reportDate},
                    //dataType: "json"
                });

                request.done(function(dataresponce) {
                    //console.log(dataresponce);
                    $("#DairyHomeworkSubjectsList").html(dataresponce);
                    $("#loader").hide();
                });

                request.fail(function(jqXHR, textStatus) {
                    $("#loader").hide();
                    alert( "Request failed: " + textStatus );
                });
            }else{
                $("#loader").hide();
                alert('Please select Date, Syllabus, Class, Section..!');
            }
        });
    })
</script>
