<!-- Container fluid  -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item">Examination's</li>
        <li class="breadcrumb-item active">Upload Results</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Upload Results <small>.</small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Upload Results</h4>
                </div>
                <div class="panel-body">

					<div class="col-md-12 col-sm-12 col-xs-12">
                        <form method="post" action="<?=base_url('teacher/exams/studentslistTouplaodmarksdata')?>" id="UploadExamResultsData">
                            <input type="hidden" value="exam_timetable" name="exam_type" id="exam_timetable">
                            <?php if(count($slabslist) != 0){ ?>
                                <h5 class="text-info">Select Options To Upload Examination Results</h5>
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
                                <div class="col-md-12 text-center mb-1" id="TempResultTest"></div>
                                <div class="row justify-content-center align-items-center" id="ExaminationTimingsList">
                                    <div class="col-md-8" >
                                        <center>
                                            <h4>Please select following options..!</h4>
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
                                            $("#TempResultTest").html('');
                                            if(classname != '' && syllabusname != ''){
                                                var request = $.ajax({
                                                    url: "<?=base_url('teacher/class/sectionslist')?>",
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
                                            var classsections				=	$("#ExaminationClassesSections").val();
                                            var selectedexamslab			=	$("#ExamSelectedSlab").val();
                                            var subject_classtimings_for	=	$('#SyllabusClasses').val();
                                            var syllabus_to_getdata			=	$("#sclsyllubaslist").val();
                                            $("#TempResultTest").html('');
                                            if(subject_classtimings_for != '' && syllabus_to_getdata != ''){
                                                console.log(syllabus_to_getdata + ' - ' + subject_classtimings_for);
                                                var request = $.ajax({
                                                    url: "<?=base_url('teacher/exams/studentslistTouplaod')?>",
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
                                        });
                                    
                                
                                        $('#UploadExamResultsData').submit(function(e){
                                            e.preventDefault();
                                            var uploadingdata = $("#UploadExamResultsData").serialize();
                                            $.ajax({
                                                url : '<?=base_url('teacher/exams/studentslistTouplaodmarksdata')?>',
                                                type: 'POST',
                                                data: uploadingdata,
                                                success:function(responcedata){
                                                    $('#TempResultTest').html(responcedata);
                                                    //setInterval(function(){  
                                                        $('#ExaminationTimingsList').html('');
                                                        $('#ExaminationTimingsList').append('<div class="col-md-8"><center><h4>Please select following options..!</h4><img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>" style=""></center></div>');
                                                    //}, 5000);
                                                }
                                            });
                                        });
                                    });
                                </script>
                            <?php }else{
                                $this->Model_dashboard->norecords();
                            }
                            ?>
                        </form>
					</div>
				
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
