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
        <div class="col-8">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Dairy List</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
						<?php //print_r($homeworks); ?>
						<table class="table table-striped table-bordered" id="myTable">
							<thead align="center">
								<th>#</th>
								<th>Syllabus</th>
								<th>class - Sec</th>
                                <th>Date</th>
								<th>Homework</th>
								<th></th>
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
										<td align="center"><a href="javascript:;" data-toggle="modal" data-target="#DairyHomeworkreport_<?=$homework->id?>"> Click Details </a></td>
										<td align="center">
											
                                            <a href="javascript:;" data-toggle="modal" data-target="#DairyHomeworkreport_<?=$homework->id?>"><i class="fa fa-file fa-dx"></i></a> &nbsp;
                                            
                                            <a href="<?=base_url('dashboard/reports/homework/'.$homework->id.'/delete')?>" onClick="return confirm('Are want to delete Homework..?')"><i class="fa fa-trash-o fa-dx"></i></a>&nbsp;
                                            
                                            <?php if(date('Y-m-d') == date('Y-m-d',strtotime($homework->hw_date))){
                                                    if($homework->publish != 0){ ?>
												        <a href="<?=base_url('dashboard/reports/UnpublishHwreport/'.$homework->id.'/0/unpublish')?>" onclick="return confirm('are you sure to unpublish this homework report..!')"><i class="fa fa-power-off fa-dx text-red"></i></a>
											<?php }else{ ?>
												<a href="<?=base_url('dashboard/reports/publishHwreport/'.$homework->id.'/1/publish')?>" onclick="return confirm('are you sure to publish this homework report..!')"><i class="fa fa-power-off fa-dx text-success"></i></a>
											<?php } 
                                            } ?>
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
                    	list += "<option value='all'>All sections</option>";
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
            
            if(syllabusclass != '' && sectionname != '' && syllabusname != ''){
                var request = $.ajax({
                    url: "<?=base_url('dashboard/reports/dairySubjectsList')?>",
                    type: "POST",
                    data: {classname : syllabusclass,syllabustype : syllabusname,requesttype:'subjectslist',school_id:"<?=$school_id?>",branch_id:"<?=$branch_id?>",Section:sectionname},
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
                alert('Please select Syllabus, Class, Section..!');
            }
        });
    })
</script>
