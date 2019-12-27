<!-- Container fluid  -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item">Timings</li>
        <li class="breadcrumb-item active">Set / Update Timings</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Set / Update Timings <small>.</small></h1>
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
                    <h4 class="panel-title">Set / Update Timings</h4>
                </div>
                <div class="panel-body">

					<div class="col-md-12">
						<form method="post" action="<?=base_url('dashboard/timings/savetimingsdata')?>" enctype="multipart/form-data">
							<div class="row justify-content-center align-items-center">
								<div class="form-group col-md-6">                                    
									<?php if(isset($sutype) && $sutype != ''){
                                            foreach ($timings as $timing){ 
                                                if($timing->shortname != 'other'){ ?>
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" id="inlineCssRadio1_<?=$timing->id?>" name="timing_type" value="<?=$timing->shortname?>" <?php if($timing->shortname == $sutype){ echo 'checked'; }else{ echo 'disabled'; } ?> />
                                                        <label for="inlineCssRadio1_<?=$timing->id?>"><?=$timing->name?></label>
                                                    </div>
									<?php      } 
                                            }
                                        }else{
                                            foreach ($timings as $timing){ 
                                                if($timing->shortname != 'other'){ ?>
                                                    <div class="radio radio-css radio-inline">
                                                        <input type="radio" id="inlineCssRadio1_<?=$timing->id?>" name="timing_type" value="<?=$timing->shortname?>" />
                                                        <label for="inlineCssRadio1_<?=$timing->id?>"><?=$timing->name?></label>
                                                    </div>
									<?php      } 
                                            } 
                                        } ?>
								</div>
								<script>
									$(document).ready(function(){
                                        var checkedtimingtype = $('input[type="radio"]:checked').val();
                                        if(checkedtimingtype != ''){
                                            $.ajax({
												url:"<?=base_url('dashboard/timings/ajax/timingsfields')?>",
												data:{timingtype:checkedtimingtype},
												type:"POST",
												success:function(successdata){
													$('#attlistofuser').html(successdata);
													$("#loader").hide();
												}
											})
                                        }
										$('input[type="radio"]').change(function () {
											var timingtype = $(this).val();
											$("#loader").show();
											$.ajax({
												url:"<?=base_url('dashboard/timings/ajax/timingsfields')?>",
												data:{timingtype:timingtype},
												type:"POST",
												success:function(successdata){
													$('#attlistofuser').html(successdata);
													$("#loader").hide();
												}
											})
										})
									})
								</script>
								<div class="col-md-12 table-responsive" id="attlistofuser">
									<div class="" style="margin:60px 0px">
										<center>
											<img class="img-responsive" src="<?=base_url('assets/images/pleaseselect _leftindcate.png')?>" style="width: 100% !important;">
											<h4>Please select following options...</h4>
										</center>
									</div>
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
