<!-- Container fluid  -->
<style>
    .select2{
        width: 100% !important;
    }
</style>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">import & export</a></li>
        <li class="breadcrumb-item active">Export</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Export Data <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Export Data</h4>
                </div>
                <div class="panel-body">
                    
                    <form class="row justify-content-center align-items-center" method="post" id="exportdatabackup">
                        
                        <div class="form-group col-xs-12 col-sm-6  col-md-3">
                            <label for="export_type">Select export type <span class="text-danger">*</span></label>
                            <select class="form-control" name="export_type" id="export_type" required>
                                <option value="">Select Export type</option>
                                <option value="1">Admission List</option>
                                <option value="2">Enquery List</option>
                                <option value="3">Fee payments List</option>
                                <option value="4">Salary payments List</option>
                                <option value="5">Employees List</option>
                                <option value="6">Attendence Report</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-xs-12 col-sm-6  col-md-3" id="all_session">
                            <label>Select Export sort by <span class="text-danger">*</span></label>
                            <select class="form-control" name="sorted_type" id="export_sort_session" required>
                                <option value="">Select Export sort by</option>
                                <option value="A0">All Data</option>
                                <option value="A1">Customized Data</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-xs-12 col-sm-6  col-md-2" id="dmy_session">
                            <label>Select Export by</label>
                            <select class="form-control" name="export_datetype" id="export_datetype">
                                <option value="">Select Export by</option>
                                <option value="00">All Data</option>
                                <option value="01">By Date</option>
                                <option value="02">By Month</option>
                                <option value="03">By year</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-xs-12 col-sm-6  col-md-2" id="gender_session">
                            <label for="selected_gender">Select Gender <span class="text-danger">*</span></label>
                            <select class="form-control" name="selected_gender" id="selected_gender">
                                <option value="">Select Gender</option>
                                <option value="all">All</option>
                                <?php foreach ($gender as $genders) { ?>
                                    <option value="<?= $genders->shortname ?>"><?= $genders->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group col-xs-12 col-sm-6 col-md-4" id="syllabus_session">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="sclsyllabuslist">Select Syllabus</label>
                                    <select name="StdSyllubas" id="sclsyllubaslist" class="form-control">
                                        <option value="">Syllabus Type</option>
                                        <?php foreach ($syllabus as $key => $value) { ?>
                                            <option value="<?= $key ?>"><?= $value ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="SyllabusClasses">Select Class</label>
                                    <select name="StdClass" id="SyllabusClasses" class="form-control" disabled="">
                                        <option value="">Select Class</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-6 col-md-3" id="employee_session">
                            <label>Employee Type <span class="text-red">*</span></label>
                            <div class="form-group">
                            <select class="form-control" id="employeetype" name="emptype">
                                <option value="">Select Employee type</option>
                                <?php foreach ($employee as $employees) { ?>
                                    <option value="<?= $employees->shortname ?>"><?= $employees->name ?></option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3 staff" id="staff_session">
                            <label>Staff Type</label>
                            <div class="form-group">
                            <select class="form-control" id="sct" name="emppti">
                                <option value="">Select Staff type</option>
                                <?php foreach ($staff as $staffs) { ?>
                                    <option value="<?= $staffs->shortname ?>"><?= $staffs->name ?></option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3 workers" id="workers_session">
                            <label>Workers Type</label>
                            <div class="form-group">
                            <select class="form-control show-tick" name="emppoti">
                                <option value="">Select worker type</option>
                                <?php foreach ($worker as $workers) { ?>
                                    <option value="<?= $workers->shortname ?>"><?= $workers->name ?></option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-3 assistant" id="office_session">
                            <label>Office assistant Type </label>
                            <div class="form-group">
                            <select class="form-control show-tick" name="empoffic">
                                <option value="">Select assistant type</option>
                                <?php foreach ($office as $offices) { ?>
                                    <option value="<?= $offices->shortname ?>"><?= $offices->name ?></option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>
                        
                        <div class="form-group col-xs-12 col-sm-6 col-md-4" id="date_session">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="from_date">Select From Data</label>
                                    <input type="text" class="form-control mydatepicker" placeholder="Pick From date" name="from_date" id="from_date">
                                </div>
                                <div class="col-md-6">
                                    <label for="to_date">Select To Data</label>
                                    <input type="text" class="form-control mydatepicker" placeholder="Pick To date" name="to_date" id="to_date">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group col-xs-12 col-sm-6 col-md-4" id="month_session">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="from_month">Select From Month</label>
                                    <input type="text" class="form-control mypicker" name="from_month" id="from_month" placeholder="Pick From Month">
                                </div>
                                <div class="col-md-6">
                                    <label for="to_month">Select To Month</label>
                                    <input type="text" class="form-control mypicker" name="to_month" id="to_month" placeholder="Pick To Month">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group col-xs-12 col-sm-6 col-md-4" id="year_session">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="from_year">Select From Year</label>
                                    <input type="text" class="form-control yearpicker" name="from_year" id="from_year" placeholder="Pick From Year">
                                </div>
                                <div class="col-md-6">
                                    <label for="to_year">Select To Year</label>
                                    <input type="text" class="form-control yearpicker" name="to_year" id="to_year" placeholder="Pick To Year">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" name="getdata" value="Get Data" class="btn btn-success mt-4">
                        </div>
                    </form> 
                    
                    <div class="row">
                        <div class="col-md-12" id="exportingData">
                            <div class="" style="margin:40px 0px">
                                <center>
                                    <h4>Please select following options</h4>
                                    <img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>">
                                </center>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid --> 
<script type="text/javascript">
    $(document).ready(function($) {
        
        function hideallsessions(){         
            $("#office_session,#workers_session,#staff_session,#employee_session,#gender_session,#syllabus_session,#year_session,#month_session,#date_session,#dmy_session,#all_session").hide();
        }
        
        function emptyalldata(){                     
            $("#selected_gender,#export_sort_session,#export_datetype,#sclsyllubaslist,#SyllabusClasses,#selected_gender,#from_month,#to_month,#from_year,#to_year,#from_date,#to_date").val("");    
        }
        
        hideallsessions();
        //emptyalldata();
        
        //step - 1
        $("#export_type").change(function(){
            var export_type =   $(this).val();
            
            if(export_type.length == ''){
                hideallsessions(); 
                emptyalldata();
            }else{
                //$('#export_sort_session').select2('val', ' ');
                emptyalldata();
                hideallsessions();
                if(export_type == 1){
                    $('#all_session').show();
                    console.log("admissions session.");
                }else if(export_type == 2){
                    console.log("enquery session.");
                    $('#all_session').show();
                }else if(export_type == 3){
                    console.log("fee list session.");
                    $('#all_session').show();
                }else if(export_type == 4){
                    console.log("salary list session.");
                    $('#all_session').show();
                }else if(export_type == 5){
                    console.log("Employee list session.");
                    $('#all_session').show();
                }else if(export_type == 6){
                    console.log("Attendence list session.");
                    $('#all_session').show();
                }
            }
        });
        
        //step - 2
        $("#export_sort_session").change(function(){
            var export_type =   $('#export_type').val();
            var export_sort =   $(this).val();
            
            if(export_type != '' && export_sort != ''){
                console.log('short by : ' + export_sort + ' - Export type : ' + export_type);
                if(export_sort == 'A0' && export_type == 1){
                    console.log("export all admissions list of current batch.");
                    //$('#syllabus_session,#gender_session,#date_session').hide();
                    $('#selected_gender,#sclsyllubaslist,#SyllabusClasses,#from_date,#to_date').val('');
                }else if(export_sort == 'A1' && export_type == 1){
                    //class and date and gender show
                    //$('#selected_gender,#sclsyllubaslist,#SyllabusClasses,#from_date,#to_date').val('');
                    $('#syllabus_session,#gender_session,#date_session').show();
                }else if(export_sort == 'A0' && export_type == 2){
                    console.log("export all enquery list of current batch.");
                    //$('#selected_gender,#sclsyllubaslist,#SyllabusClasses,#from_date,#to_date').val('');
                    $('#syllabus_session,#gender_session,#date_session').hide();
                }else if(export_sort == 'A1' && export_type == 2){
                    //class and date and gender show
                    //$('#selected_gender,#sclsyllubaslist,#SyllabusClasses,#from_date,#to_date').val('');
                    $('#syllabus_session,#gender_session,#date_session').show();
                }else if(export_sort == 'A0' && export_type == 3){
                    console.log("export all fee list of current batch.");
                    $('#date_session').hide();
                    $('#dmy_session').hide();
                }else if(export_sort == 'A1' && export_type == 3){
                    //date and gender show
                    $('#dmy_session').show();

                }else if(export_sort == 'A0' && export_type == 4){
                    console.log("export all salary list of current batch.");
                    $('#dmy_session').hide();
                }else if(export_sort == 'A1' && export_type == 4){
                    //date and gender show
                    $('#dmy_session').show();
                }else if((export_sort == 'A0' && export_type == 5) || (export_sort == 'A1' && export_type == 5)){
                    console.log("export all Employee list of current batch.");
                    $('#employee_session').show();
                }else if((export_sort == 'A0' && export_type == 6) || (export_sort == 'A1' && export_type == 6)){
                    console.log("export attendence list of current batch.");
                    $('#dmy_session').show();
                }
            }else{
                alert("please select export type and export sort by..!");
            }
            
        })
        
        //step - 3
        $("#export_datetype").change(function(){
            var datetype    =   $(this).val();
            console.log('dates by : ' + datetype);
            //$('#selected_gender').prop('selectedIndex',0);
            //$("#selected_gender").val("");
            
            if(datetype == ''){
                $('#year_session,#month_session,#date_session,#gender_session').hide();
                //$('#from_date,#to_date,#from_month,#to_month,#from_year,#to_year').val('');
            }else{
				$('#from_date,#to_date,#from_month,#to_month,#from_year,#to_year').val('');
                if(datetype == 00){

                    console.log('All fee details of current batch');
                    $('#date_session,#month_session,#year_session,#gender_session').hide();
                    //$('#gender_session').show().removeClass( "form-group col-md-2" ).addClass( "form-group col-md-3");
                    //$('#from_date,#to_date,#from_month,#to_month,#from_year,#to_year').val(' ');

                }else if(datetype == 01){
                    $('#month_session,#year_session').hide();
                    $('#date_session').show();
                    //$('#from_month,#to_month,#from_year,#to_year').val(' ');
                    $('#gender_session').removeClass( "form-group col-md-2" ).addClass( "form-group col-md-3");

                }else if(datetype == 02){
                    $('#date_session,#year_session').hide();
                    $('#month_session').show();
                    //$('#from_date,#to_date,#from_year,#to_year').val(' ');
                    $('#gender_session').removeClass( "form-group col-md-2" ).addClass( "form-group col-md-3");

                }else if(datetype == 03){
                    $('#date_session,#month_session').hide();
                    $('#year_session').show();
                    //$('#from_date,#to_date,#from_month,#to_month').val(' ');
                    $('#gender_session').removeClass( "form-group col-md-2" ).addClass( "form-group col-md-3");
                }else{
                    $('#year_session,#month_session,#date_session,#gender_session').hide();
                }   
            }
        });
        
        
        //submit
        $('#exportdatabackup').submit(function(e){
            e.preventDefault();
            var formdata = $(this).serialize();
            $('#loader').show();
            console.log(formdata);
            $.ajax({
                type: "POST",
                url: "<?=base_url('dashboard/data/sendrequest')?>",// where you wanna post
                data: formdata,
                /*processData: false,
                contentType: false,
                dataType: "JSON",*/
                error: function(jqXHR, textStatus, errorMessage) {
                    console.log(errorMessage); // Optional
                    $('#loader').hide();
                },
                success: function(data) {
                    $('#loader').hide();
                    $("#exportingData").html(data)
                    //console.log(data);
                } 
            })
        })
        
        
    });
    
    $(document).ready(function(){
        var selemployeetype = $("#employeetype").val();
        if($('#employeetype').attr("value")==""){
            $('.staff').hide();
            $('.workers').hide();
            $('.assistant').hide();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }
        if($('#employeetype').attr("value")=="staff"){
            $('.staff').show();
            $('.workers').hide();
            $('.assistant').hide();
        }
        if($('#employeetype').attr("value")=="worker"){
            $('.staff').hide();
            $('.workers').show();
            $('.assistant').hide();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }
        if($('#employeetype').attr("value")=="office"){
            $('.staff').hide();
            $('.workers').hide();
            $('.assistant').show();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }
        
        var sct = $("#sct").val();
        if($('#sct').attr("value")==""){
            $('.empclass').hide();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }
        if($('#sct').attr("value")=="teacher"){
            $('.empclass').hide();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }
        if($('#sct').attr("value")=="classteacher"){
            $('.empclass').show();
        }
        if($('#sct').attr("value")=="tutor"){
            $('.empclass').hide();
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }
        
        $("#employeetype").change(function(){
            $( "#employeetype option:selected").each(function(){
                if($(this).attr("value")==""){
                    $('.staff').hide();
                    $('.workers').hide();
                    $('.assistant').hide();
                    $('.empsubjects').hide();
                    $('.empclass').hide();
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
                if($(this).attr("value")=="staff"){
                    $('.staff').show();
                    $('.workers').hide();
                    $('.assistant').hide();
                    $('.empsubjects').show();
                    
                }
                if($(this).attr("value")=="worker"){
                    $('.staff').hide();
                    $('.workers').show();
                    $('.assistant').hide();
                    $('.empsubjects').hide();
                    $('.empclass').hide();
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
                if($(this).attr("value")=="office"){
                    $('.staff').hide();
                    $('.workers').hide();
                    $('.assistant').show();
                    $('.empsubjects').hide();
                    $('.empclass').hide();
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
            })
        }).change();
    });
</script>
