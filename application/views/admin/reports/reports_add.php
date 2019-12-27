<!-- Container fluid  -->
<?php $schooldata = $this->session->userdata['school']; ?>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Reports</a></li>
        <li class="breadcrumb-item active">New Report</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">New Report<small></small></h1>
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
                    <h4 class="panel-title">New Report</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <form method="post" enctype="multipart/form-data" action="<?=base_url('#')?>">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="row">

										<div class="col-md-12">
											<label>Send Report To</label>
											<div class="row">
												<?php $source = $this->Model_dashboard->selectdata('sms_formdata',array('status'=>1),'id');
												//echo count($source);
												foreach ($source as $sourcename){ if($sourcename->type == 'staff' || $sourcename->type == 'worker' || $sourcename->type == 'office' || $sourcename->type == 'student'){?>
													<div class="col-md-2 form-group">
														<div class="radio radio-css">
															<input type="radio" id="cssCheckbox1<?=$sourcename->id?>" name="reportSendTo" value="<?=$sourcename->shortname?>" />
															<label for="cssCheckbox1<?=$sourcename->id?>"><?=$sourcename->name?></label>
														</div>
													</div>
												<?php } } ?>
											</div>
                                            <script type="text/javascript">
                                                $(document).ready(function() {
                                                    $("input[name='reportSendTo']").change(function(event) {
                                                        if($(this).val() != ''){
                                                            //alert($(this).val());
                                                            //ajax calls to get data
                                                            var reportingto = $(this).val();
                                                            $.ajax({
                                                                url: "<?=base_url('dashboard/reports/addrepresentslist')?>",
                                                                type: 'POST',
                                                                dataType: 'json',
                                                                data: {report_to: reportingto},
                                                            })
                                                            .done(function(responcedata) {
                                                                if(responcedata.length != 0){
                                                                    $('#sendToReportsList').empty();
                                                                    $("#sendToReportsList").removeAttr('disabled');
                                                                    $("#sendToReportsList").append("<option value='all'>Select all</option>");
                                                                    for(var sl = 0;responcedata.length >= sl;sl++){
                                                                        $("#sendToReportsList").append("<option value='"+ responcedata[sl].id_num +"'>"+ responcedata[sl].firstname +'.'+ responcedata[sl].lastname +"</option>");
                                                                    }
                                                                }else{
                                                                    $('#sendToReportsList').empty();
                                                                    $("#sendToReportsList").attr('disabled', 'disabled');
                                                                    alert('No records found..!');
                                                                }
                                                            })
                                                            .fail(function(faildata) {
                                                                console.log(faildata);
                                                            });
                                                        }
                                                    });
                                                });
                                            </script>
											<div class="row">
												<div class="col-md-12">
													<label>Select Send report to </label>
													<select class="form-control select2" id="sendToReportsList" multiple name="sendToReportsList[]" disabled="" required="required">
													</select>
												</div>
											</div>
										</div>

                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <label>Enter Report Title</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Title of the Report" name="reportTitle" required>
                                            </div>
                                        </div>

									   <div class="col-md-12">
												<label>Upload Attach Files</label>
												<div class="form-group">
													<input type="file" multiple class="form-control dropify" accept="*" name="attachFilesUploads[]">
												</div>
											</div>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label>Type Notice Discription</label>
                                    <div class="form-group">
                                        <textarea id="ckeditor" class="form-control" placeholder="Type Discription..!" name="noticecontent"></textarea>
                                    </div>
                                    <script>
                                        // Replace the <textarea id="editor1"> with a CKEditor
                                        // instance, using default configuration.
                                        //customConfig: '';
                                        //CKEDITOR.replace( 'notice_content' );
                                        CKEDITOR.replace( 'noticecontent', {
                                            customConfig: 'custom/paper.js'
                                        });
                                    </script>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success pull-right" name="newnotice">
                                        SEND NOTICE
                                    </button>
                                </div>
                            </div>
                        </form>
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
        })
    })
</script>
