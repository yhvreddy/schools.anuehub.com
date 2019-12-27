<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
<?php
$schooldata = $this->session->userdata['school'];
$schoolid = $schooldata->school_id;
$branchid = $schooldata->branch_id;
$registerid = $schooldata->reg_id;
?>
<!-- begin theme-panel -->

<!-- end theme-panel -->
<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
<!-- end scroll to top btn -->
</div>
<!-- end page container -->
<!-- ================== BEGIN BASE JS ================== -->
<script src="<?=base_url()?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
<!--[if lt IE 9]>
<script src="<?=base_url()?>assets/crossbrowserjs/html5shiv.js"></script>
<script src="<?=base_url()?>assets/crossbrowserjs/respond.min.js"></script>
<script src="<?=base_url()?>assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="<?=base_url()?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?=base_url()?>assets/plugins/js-cookie/js.cookie.js"></script>
<script src="<?=base_url()?>assets/js/theme/default.min.js"></script>
<script src="<?=base_url()?>assets/js/apps.min.js"></script>
<!-- ================== END BASE JS ================== -->
<script src="<?=base_url()?>assets/plugins/parsley/dist/parsley.js"></script>
<script src="<?=base_url()?>assets/plugins/highlight/highlight.common.js"></script>
<script src="<?=base_url()?>assets/js/demo/render.highlight.js"></script>
<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?=base_url()?>assets/plugins/d3/d3.min.js"></script>
<script src="<?=base_url()?>assets/plugins/nvd3/build/nv.d3.js"></script>
<script src="<?=base_url()?>assets/plugins/jquery-jvectormap/jquery-jvectormap.min.js"></script>
<script src="<?=base_url()?>assets/plugins/jquery-jvectormap/jquery-jvectormap-world-merc-en.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js"></script>
<script src="<?=base_url()?>assets/js/demo/dashboard-v2.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script src="<?=base_url()?>assets/plugins/dropify-master/dist/js/dropify.min.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?=base_url()?>assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?=base_url()?>assets/plugins/masked-input/masked-input.min.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="<?=base_url()?>assets/plugins/password-indicator/js/password-indicator.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>
<script src="<?=base_url()?>assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?=base_url()?>assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-show-password/bootstrap-show-password.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
<script src="<?=base_url()?>assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js"></script>
<script src="<?=base_url()?>assets/plugins/clipboard/clipboard.min.js"></script>
<script src="<?=base_url()?>assets/js/demo/form-plugins.demo.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url()?>assets/js/demo/table-manage-default.demo.min.js"></script>
<script src="<?=base_url()?>assets/plugins/superbox/js/jquery.superbox.min.js"></script>
<script src="<?=base_url()?>assets/plugins/lity/dist/lity.min.js"></script>
<script src="<?=base_url()?>assets/js/demo/profile.demo.min.js"></script>
<script src="<?=base_url()?>assets/plugins/intl-tel-input-master/build/js/intlTelInput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.js"></script>
<script>
	$(document).ready(function () {
		$(function () {
			setNavigation();
		});

		function setNavigation() {
			var path = window.location.pathname;
			path = path.replace(/\/$/, "");
			path = decodeURIComponent(path);

			$(".nav a").each(function () {
				var href = $(this).attr('href');
				if (path.substring(0, href.length) === href) {
					$(this).closest('li').addClass('active');
				}
			});
		}
	})
</script>
<script>
    $(document).ready(function() {
        //$('.textarea_editor').wysihtml5();
        $('.default-select2,.select2').select2();
        $('.mydatepicker').datepicker({
            autoclose: true,
        });
        $('.mypicker,.yearmonthpicker').datepicker({
            format: "yyyy-mm",
            startView: 1,
            minViewMode: 1,
            maxViewMode: 2,
            autoclose: true,
            toggleActive: true
        })
        $('.yearpicker').datepicker({
            format: "yyyy",
            startView: 1,
            minViewMode: 2,
            maxViewMode: 3,
            autoclose: true,
            toggleActive: true
        })
    });
    $(document).ready(function() {
        App.init();
        DashboardV2.init();
        Highlight.init();
		FormPlugins.init();
        TableManageDefault.init();
        $('[data-toggle="tooltip"]').tooltip();
        $(".select2").select2();
        $('.mytimepicker,.timepicker,.mytimepickeredit').timepicker();
        $(".mytimepicker").val('');
    });
	$('body').on('focus',".mytimepickers",function () {
		$(this).val('');
		$(this).timepicker();
	});
	
	$('body').on('focus',".mydatepicker",function () {
		$(this).val('');
		$('.mydatepicker').datepicker({
			autoclose: true,
		});
	});
</script>
<script>
	$(document).ready(function(){
		$('#myTable,#myTable2,.MyTableDataList').DataTable({
			paging      : true,
			lengthChange: true,
			searching   : true,
			ordering    : true,
			info        : true,
			autoWidth   : true,
			bSort 	  : false,
			language: {
				processing: true,
			},
			columnDefs  : [
				{ orderable: false, 'targets': 0 }
			],
			order: [],
		});
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
<script type="text/javascript">

	function onAddTag(tag) {
		alert("Added a tag: " + tag);
	}
	function onRemoveTag(tag) {
		alert("Removed a tag: " + tag);
	}

	function onChangeTag(input,tag) {
		alert("Changed a tag: " + tag);
	}

	$(function() {

		$('#tags_1').tagsInput({
			// 'autocomplete_url': url_to_autocomplete_api,
			// 'autocomplete': { option: value, option: value},
			'height':'35px',
			'width':'auto',
			//'interactive':true,
			'defaultText':'subject',
			// 'onAddTag':callback_function,
			// 'onRemoveTag':callback_function,
			// 'onChange' : callback_function,
			// 'delimiter': [',',';'],   // Or a string with a single delimiter. Ex: ';'
			// 'removeWithBackspace' : true,
			// 'minChars' : 0,
			// 'maxChars' : 0, // if not provided there is no limit
			'placeholderColor' : '#666666'
		});
		$('#tags_2').tagsInput({
			width: 'auto',
			onChange: function(elem, elem_tags)
			{
				var languages = ['php','ruby','javascript'];
				$('.tag', elem_tags).each(function()
				{
					if($(this).text().search(new RegExp('\\b(' + languages.join('|') + ')\\b')) >= 0)
						$(this).css('background-color', 'yellow');
				});
			}
		});
		$('#tags_3').tagsInput({
			width: 'auto',
			//autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
			autocomplete_url:'test/fake_json_endpoint.html' // jquery ui autocomplete requires a json endpoint
		});


        // Uncomment this line to see the callback functions in action
        //			$('input.tags').tagsInput({onAddTag:onAddTag,onRemoveTag:onRemoveTag,onChange: onChangeTag});

        // Uncomment this line to see an input with no interface for adding new tags.
        //			$('input.tags').tagsInput({interactive:false});
	});

</script>

<script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove':  'Remove',
                'error':   'Ooops, something wrong happended.'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('#AadhaarCard').keyup(function() {
            var foo = $(this).val().split("-").join(""); // remove hyphens
            if (foo.length > 0) {
                foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
            }
            $(this).val(foo);
        });
    });

    $(document).ready(function() {
        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });
        // Order by the grouping
        $('#example tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });
    });

    $(document).ready(function(){
        //country to state
        $("#CountryName").change(function(){
            var CountryName = $(this).val();
            if(CountryName == ""){
                $("#selectcountryerror").text("please select country name").css('color', 'red');
                $("#StateName").prop('disabled','true');
                $("#CountryName").focus();
            }else{
                $("#selectcountryerror").text("");
                $.ajax({
                    url: '<?= base_url() ?>dashboard/stateslist',
                    type: 'POST',
                    dataType: 'json',
                    data: {Countryid: CountryName},
                })
                    .done(function(responcedata) {
                        //console.log(responcedata);
                        $('#StateName').empty();
                        $("#StateName").removeAttr('disabled');
                        $("#StateName").append("<option value=''> Select state name</option>");
                        for(var sl = 0;responcedata.length >= sl;sl++){
                            $("#StateName").append("<option value='"+ responcedata[sl].id +"'>"+ responcedata[sl].name +"</option>");
                        }

                    })
                    .fail(function(req, status, err) {
                        //console.log("error : " + errordata);
                        console.log('Something went wrong', status, err);
                        $("#loader").hide();
                    })

            }
        })
        //state to city or dist
        $("#StateName").change(function(){
            var StateName = $(this).val();
            if(StateName == ""){
                $("#selectstateerror").text("please select state name").css('color', 'red');
                $("#CityName").prop('disabled','true');
                $("#StateName").focus();
            }else{
                $("#selectstateerror").text("");
                $.ajax({
                    url: '<?= base_url() ?>dashboard/citieslist',
                    type: 'POST',
                    dataType: 'json',
                    data: {Stateid: StateName},
                })
                    .done(function(responcedata) {
                        //console.log(responcedata);
                        $('#CityName').empty();
                        $("#CityName").removeAttr('disabled');
                        $("#CityName").append("<option value=''>Select city or dist name</option>");
                        for(var sl = 0;responcedata.length >= sl;sl++){
                            $("#CityName").append("<option value='"+ responcedata[sl].id +"'>"+ responcedata[sl].name +"</option>");
                        }

                    })
                    .fail(function(req, status, err) {
                        //console.log("error : " + errordata);
                        console.log('Something went wrong', status, err);
                        $("#loader").hide();
                    })

            }
        })
        
        //country to state
        $("#CountryName1").change(function(){
            var CountryName = $(this).val();
            if(CountryName == ""){
                $("#selectcountryerror").text("please select country name").css('color', 'red');
                $("#StateName1").prop('disabled','true');
                $("#CountryName1").focus();
            }else{
                $("#selectcountryerror").text("");
                $.ajax({
                    url: '<?= base_url() ?>dashboard/stateslist',
                    type: 'POST',
                    dataType: 'json',
                    data: {Countryid: CountryName},
                })
                    .done(function(responcedata) {
                        //console.log(responcedata);
                        $('#StateName1').empty();
                        $("#StateName1").removeAttr('disabled');
                        $("#StateName1").append("<option value=''> </option>");
                        for(var sl = 0;responcedata.length >= sl;sl++){
                            $("#StateName1").append("<option value='"+ responcedata[sl].id +"'>"+ responcedata[sl].name +"</option>");
                        }

                    })
                    .fail(function(req, status, err) {
                        //console.log("error : " + errordata);
                        console.log('Something went wrong', status, err);
                        $("#loader").hide();
                    })

            }
        })
        //state to city or dist
        $("#StateName1").change(function(){
            var StateName = $(this).val();
            if(StateName == ""){
                $("#selectstateerror").text("please select state name").css('color', 'red');
                $("#CityName1").prop('disabled','true');
                $("#StateName1").focus();
            }else{
                $("#selectstateerror").text("");
                $.ajax({
                    url: '<?= base_url() ?>dashboard/citieslist',
                    type: 'POST',
                    dataType: 'json',
                    data: {Stateid: StateName},
                })
                    .done(function(responcedata) {
                        //console.log(responcedata);
                        $('#CityName1').empty();
                        $("#CityName1").removeAttr('disabled');
                        $("#CityName1").append("<option value=''> </option>");
                        for(var sl = 0;responcedata.length >= sl;sl++){
                            $("#CityName1").append("<option value='"+ responcedata[sl].id +"'>"+ responcedata[sl].name +"</option>");
                        }

                    })
                    .fail(function(req, status, err) {
                        //console.log("error : " + errordata);
                        console.log('Something went wrong', status, err);
                        $("#loader").hide();
                    })

            }
        })
    })
</script>

<script type="text/javascript">
    $(document).ready(function() {
		/*var scltypeslist = $('#sclsyllubaslist').val();
		if(scltypeslist != ''){
			$("#loader").show();
			var branchid        = "<?//= $branchid ?>";
			var schoolid        = "<?//= $schoolid ?>";
			var regisrterid     = "<?//= $registerid ?>";
			var scltypeslist    = $("#sclsyllubaslist").val();
			$.ajax({
				url:"<?php //echo base_url('Defaultmethods/syllubasbyclasses');?>",
				dataType:'json',
				method:'POST',
				data: {schoolid:schoolid,branchid:branchid,syllabustype:scltypeslist,regid:regisrterid},
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
		}*/
        $("#sclsyllubaslist").change(function() {
            var scltypeslist = $(this).val();
            //alert(scltypeslist);
            if(scltypeslist == ""){
                swal("Please select syllabus type..!");
                $("#SyllabusClasses").prop('disabled', 'disabled');
            }else{
                $("#loader").show();
                var branchid        = "<?= $branchid ?>";
                var schoolid        = "<?= $schoolid ?>";
                var regisrterid     = "<?= $registerid ?>";
                var scltypeslist    = $("#sclsyllubaslist").val();
                $.ajax({
                    url:"<?= base_url('Defaultmethods/syllubasbyclasses');?>",
                    dataType:'json',
                    method:'POST',
                    data: {schoolid:schoolid,branchid:branchid,syllabustype:scltypeslist,regid:regisrterid},
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

<script type="text/javascript">
    var logoutlock = 500*6000;
    var IDLE_TIMEOUT = logoutlock; //seconds
    var _localStorageKey = 'global_countdown_last_reset_timestamp';
    var _idleSecondsTimer = null;
    var _lastResetTimeStamp = (new Date()).getTime();
    var _localStorage = null;

    AttachEvent(document, 'click', ResetTime);
    AttachEvent(document, 'mousemove', ResetTime);
    AttachEvent(document, 'keypress', ResetTime);
    AttachEvent(window, 'load', ResetTime);

    try {
        _localStorage = window.localStorage;
    }
    catch (ex) {
    }

    _idleSecondsTimer = window.setInterval(CheckIdleTime, 1000);

    function GetLastResetTimeStamp() {
        var lastResetTimeStamp = 0;
        if (_localStorage) {
            lastResetTimeStamp = parseInt(_localStorage[_localStorageKey], 10);
            if (isNaN(lastResetTimeStamp) || lastResetTimeStamp < 0)
                lastResetTimeStamp = (new Date()).getTime();
        } else {
            lastResetTimeStamp = _lastResetTimeStamp;
        }

        return lastResetTimeStamp;
    }

    function SetLastResetTimeStamp(timeStamp) {
        if (_localStorage) {
            _localStorage[_localStorageKey] = timeStamp;
        } else {
            _lastResetTimeStamp = timeStamp;
        }
    }

    function ResetTime() {
        SetLastResetTimeStamp((new Date()).getTime());
    }

    function AttachEvent(element, eventName, eventHandler) {
        if (element.addEventListener) {
            element.addEventListener(eventName, eventHandler, false);
            return true;
        } else if (element.attachEvent) {
            element.attachEvent('on' + eventName, eventHandler);
            return true;
        } else {
            //nothing to do, browser too old or non standard anyway
            return false;
        }
    }

    function WriteProgress(msg) {
        var oPanel = document.getElementById("SecondsUntilExpire");
        if (oPanel){
            oPanel.innerHTML = msg;
        }else if (console){
            //console.log(msg);
        }
    }

    function CheckIdleTime() {
        var currentTimeStamp = (new Date()).getTime();
        var lastResetTimeStamp = GetLastResetTimeStamp();
        var secondsDiff = Math.floor((currentTimeStamp - lastResetTimeStamp) / 1000);
        if (secondsDiff <= 0) {
            ResetTime();
            secondsDiff = 0;
        }
        WriteProgress((IDLE_TIMEOUT - secondsDiff) + "");
        if (secondsDiff >= IDLE_TIMEOUT) {
            window.clearInterval(_idleSecondsTimer);
            ResetTime();
            //alert("Time expired!");
            document.location.href = "<?=base_url('sessionlocked');?>";
        }
    }
</script>
</body>

</html>
