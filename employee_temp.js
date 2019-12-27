var selemployeetype = $("#employeetype").val();
        if($('#employeetype').attr("value")==""){
            $('.staff').hide();
            $('.workers').hide();
            $('.assistant').hide();
            $('#ClassSubjectsToDeal').hide();
            $("input[name='syllabus_name']").prop('checked', false);
            $("#SyllabusClassList").html("");
            $("#SyllabusClassSubjectsList").html("");
            $('#EmpAddressbox').addClass('col-md-6');
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }
        if($('#employeetype').attr("value")=="staff"){
            $('.staff').show();
            $('.workers').hide();
            $('.assistant').hide();
            $('#ClassSubjectsToDeal').show();
            $("input[name='syllabus_name']").prop('checked', false);
            $("#SyllabusClassList").html("");
            $("#SyllabusClassSubjectsList").html("");
            $('#EmpAddressbox').addClass('col-md-3');
        }
        if($('#employeetype').attr("value")=="worker"){
            $('.staff').hide();
            $('.workers').show();
            $('.assistant').hide();
            $("input[name='syllabus_name']").prop('checked', false);
            $("#SyllabusClassList").html("");
            $("#SyllabusClassSubjectsList").html("");
            $('#EmpAddressbox').addClass('col-md-3');
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }
        if($('#employeetype').attr("value")=="office"){
            $('.staff').hide();
            $('.workers').hide();
            $('.assistant').show();
            $("input[name='syllabus_name']").prop('checked', false);
            $("#SyllabusClassList").html("");
            $("#SyllabusClassSubjectsList").html("");
            $('#EmpAddressbox').addClass('col-md-3');
            $('#sclsyllubaslist').prop('selectedIndex',0);
            $('#SyllabusClasses').prop('selectedIndex',0);
        }
        
        $("#sct").on('change',function(){
            var sct = $("#sct").val();
            if(sct == ""){
                $("input[name='syllabus_name']").prop('checked', false);
                $("#SyllabusClassList").html("");
                $("#SyllabusClassSubjectsList").html("");
                $('.empclass').hide();
                $("#ClassSubjectsToDeal").hide();
                $('#EmpAddressbox').addClass('col-md-3');
                $('#sclsyllubaslist').prop('selectedIndex',0);
                $('#SyllabusClasses').prop('selectedIndex',0);
            }
            if(sct == "teacher"){
                $("input[name='syllabus_name']").prop('checked', false);
                $("#SyllabusClassList").html("");
                $("#ClassSubjectsToDeal").show();
                $("#SyllabusClassSubjectsList").html("");
                $('.empclass').hide();
                $('#EmpAddressbox').addClass('col-md-3');
                $('#sclsyllubaslist').prop('selectedIndex',0);
                $('#SyllabusClasses').prop('selectedIndex',0);
            }
            if(sct == "classteacher"){
                $("input[name='syllabus_name']").prop('checked', false);
                $("#SyllabusClassList").html("");
                $("#ClassSubjectsToDeal").show();
                $("#SyllabusClassSubjectsList").html("");
                $('.empclass').show();
                $('#EmpAddressbox').addClass('col-md-3');
            }
            if(sct == "tutor"){
                $("input[name='syllabus_name']").prop('checked', false);
                $("#SyllabusClassList").html("");
                $("#SyllabusClassSubjectsList").html("");
                $('.empclass').hide();
                $("#ClassSubjectsToDeal").show();
                $('#EmpAddressbox').addClass('col-md-3');
                $('#sclsyllubaslist').prop('selectedIndex',0);
                $('#SyllabusClasses').prop('selectedIndex',0);
            }
        });
        
        $("#employeetype").change(function(){
        	//$("#tags_1").val('');
            $("input[name='syllabus_name']").prop('checked', false);
            $("#SyllabusClassList").html("");
            $("#SyllabusClassSubjectsList").html("");
            $('#EmpAddressbox').addClass('col-md-3');
            $("#ClassSubjectsToDeal").hide();
            $('#sct').select2({ placeholder: "Please select staff type", allowClear: true });
            $( "#employeetype option:selected").each(function(){
                $('#sclsyllubaslist').prop('selectedIndex',0);
                $('#SyllabusClasses').prop('selectedIndex',0);
                $('#sct').prop('selectedIndex',0);
                if($(this).attr("value")==""){
                    $('.staff').hide();
                    $('.workers').hide();
                    $('.assistant').hide();
                    $('#ClassSubjectsToDeal').hide();
                    $('.empclass').hide();
                    $("input[name='syllabus_name']").prop('checked', false);
                    $("#SyllabusClassList").html("");
                    $("#SyllabusClassSubjectsList").html("");
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
                if($(this).attr("value")=="staff"){
                    $('.staff').show();
                    $('.workers').hide();
                    $('.assistant').hide();
                    $('#ClassSubjectsToDeal').hide();
                    $("input[name='syllabus_name']").prop('checked', false);
                    $("#SyllabusClassList").html("");
                    $("#SyllabusClassSubjectsList").html("");
                    $('#sct').select2({ placeholder: "Please select staff type", allowClear: true });
                }
                if($(this).attr("value")=="worker"){
                    $('.staff').hide();
                    $('.workers').show();
                    $('.assistant').hide();
                    $('#ClassSubjectsToDeal').hide();
                    $('.empclass').hide();
                    $("input[name='syllabus_name']").prop('checked', false);
                    $("#SyllabusClassList").html("");
                    $("#SyllabusClassSubjectsList").html("");
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                    $('#sct').select2({ placeholder: "Please select staff type", allowClear: true });
                    
                }
                if($(this).attr("value")=="office"){
                    $('.staff').hide();
                    $('.workers').hide();
                    $('.assistant').show();
                    $('#ClassSubjectsToDeal').hide();
                    $('.empclass').hide();
                    $("input[name='syllabus_name']").prop('checked', false);
                    $("#SyllabusClassList").html("");
                    $("#SyllabusClassSubjectsList").html("");
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                    $('#sct').select2({ placeholder: "Please select staff type", allowClear: true });
                }
            })
        });
        
        
            $(document).ready(function(){
        $("#sct").change(function(){
			$("#tags_1").val('');
            $( "#sct option:selected").each(function(){
                if($(this).attr("value")==""){
                    $('.empclass').hide();
                    $("#sctclass").val("");
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
                if($(this).attr("value")=="teacher"){
                    $('.empclass').hide();
                    $("#sctclass").val("");
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
                if($(this).attr("value")=="classteacher"){
                    $('.empclass').show();
                    $("#sctclass").val("");
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
                if($(this).attr("value")=="tutor"){
                    $('.empclass').hide();
                    $("#sctclass").val("");
                    $('#sclsyllubaslist').prop('selectedIndex',0);
                    $('#SyllabusClasses').prop('selectedIndex',0);
                }
            })
        }).change();
    
        $("#Environmentid").keyup(function(event) {
            var environmentid = $(this).val();
            if(environmentid.length != ''){

                $.ajax({
                    url: "<?=base_url('defaultmethods/envernmentalid')?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {environmentid: environmentid},
                })
                .done(function(dataresponce) {
                    console.log(dataresponce);
                    if(dataresponce.code == 1){
                        $("#Environmentid").css('color', 'red');
                        $("#Environmentid").focus();
                        //$("#Environmentiderror").text(dataresponce.message).css('color','red');
                    }else{
                        $("#Environmentid").css('color', 'green');
                        //$("#fname").focus();
                    }
                })
                .fail(function(req, status, err) {
                    console.log('Something went wrong', status, err);
                })
                
            }else{
                $("#Environmentiderror").text('Enter valid Environmentid').css('color','red');
                $("#Environmentid").focus();
            }
        });

    });