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
<div class="theme-panel theme-panel-lg">
    <a href="javascript:;" data-click="theme-panel-expand"  class="theme-collapse-btn"><i class="fa fa-cog"></i></a>
    <div class="theme-panel-content">

        <div class="panel panel-default panel-with-tabs" data-sortable-id="ui-unlimited-tabs-2">
            <!-- begin panel-heading -->
            <div class="panel-heading p-0">
<!--                <div class="panel-heading-btn m-r-10 m-t-10">-->
<!--                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-inverse" data-click="panel-expand"><i class="fa fa-expand"></i></a>-->
<!--                </div>-->
                <!-- begin nav-tabs -->
                <div class="tab-overflow">
                    <ul class="nav nav-tabs">
                        <li class="nav-item prev-button"><a href="javascript:;" data-click="prev-tab" class="text-inverse nav-link"><i class="fa fa-arrow-left"></i></a></li>
                        <li class="nav-item"><a href="#nav-tab2-1" data-toggle="tab" class="nav-link active">Online</a></li>
                        <li class="nav-item"><a href="#nav-tab2-2" data-toggle="tab" class="nav-link">Employees</a></li>
                        <li class="nav-item"><a href="#nav-tab2-3" data-toggle="tab" class="nav-link">Students</a></li>
                        <li class="nav-item"><a href="#nav-tab2-4" data-toggle="tab" class="nav-link">Notifications</a></li>
                        <li class="nav-item"><a href="#nav-tab2-5" data-toggle="tab" class="nav-link">Settings</a></li>
                        <li class="nav-item next-button"><a href="javascript:;" data-click="next-tab" class="text-inverse nav-link"><i class="fa fa-arrow-right"></i></a></li>
                    </ul>
                </div>
                <!-- end nav-tabs -->
            </div>
            <!-- end panel-heading -->
            <!-- begin tab-content -->
            <div class="tab-content">
                <!-- begin tab-pane -->
                <div class="tab-pane fade" id="nav-tab2-1" class="active">
                    <h3 class="m-t-10">Nav Tab 1</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Integer ac dui eu felis hendrerit lobortis. Phasellus elementum, nibh eget adipiscing porttitor,
                        est diam sagittis orci, a ornare nisi quam elementum tortor.
                        Proin interdum ante porta est convallis dapibus dictum in nibh.
                        Aenean quis massa congue metus mollis fermentum eget et tellus.
                        Aenean tincidunt, mauris ut dignissim lacinia, nisi urna consectetur sapien,
                        nec eleifend orci eros id lectus.
                    </p>
                    <p>
                        Aenean eget odio eu justo mollis consectetur non quis enim.
                        Vivamus interdum quam tortor, et sollicitudin quam pulvinar sit amet.
                        Donec facilisis auctor lorem, quis mollis metus dapibus nec. Donec interdum tellus vel mauris vehicula,
                        at ultrices ex gravida. Maecenas at elit tincidunt, vulputate augue vitae, vulputate neque.
                        Aenean vel quam ligula. Etiam faucibus aliquam odio eget condimentum.
                        Cras lobortis, orci nec eleifend ultrices, orci elit pellentesque ex, eu sodales felis urna nec erat.
                        Fusce lacus est, congue quis nisi quis, sodales volutpat lorem.
                    </p>
                </div>
                <!-- end tab-pane -->
                <!-- begin tab-pane -->
                <div class="tab-pane fade" id="nav-tab2-2">
                    <h3 class="m-t-10">Nav Tab 2</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Integer ac dui eu felis hendrerit lobortis. Phasellus elementum, nibh eget adipiscing porttitor,
                        est diam sagittis orci, a ornare nisi quam elementum tortor.
                        Proin interdum ante porta est convallis dapibus dictum in nibh.
                        Aenean quis massa congue metus mollis fermentum eget et tellus.
                        Aenean tincidunt, mauris ut dignissim lacinia, nisi urna consectetur sapien,
                        nec eleifend orci eros id lectus.
                    </p>
                    <p>
                        Aenean eget odio eu justo mollis consectetur non quis enim.
                        Vivamus interdum quam tortor, et sollicitudin quam pulvinar sit amet.
                        Donec facilisis auctor lorem, quis mollis metus dapibus nec. Donec interdum tellus vel mauris vehicula,
                        at ultrices ex gravida. Maecenas at elit tincidunt, vulputate augue vitae, vulputate neque.
                        Aenean vel quam ligula. Etiam faucibus aliquam odio eget condimentum.
                        Cras lobortis, orci nec eleifend ultrices, orci elit pellentesque ex, eu sodales felis urna nec erat.
                        Fusce lacus est, congue quis nisi quis, sodales volutpat lorem.
                    </p>
                </div>
                <!-- end tab-pane -->
                <!-- begin tab-pane -->
                <div class="tab-pane fade" id="nav-tab2-3">
                    <h3 class="m-t-10">Nav Tab 3</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Integer ac dui eu felis hendrerit lobortis. Phasellus elementum, nibh eget adipiscing porttitor,
                        est diam sagittis orci, a ornare nisi quam elementum tortor.
                        Proin interdum ante porta est convallis dapibus dictum in nibh.
                        Aenean quis massa congue metus mollis fermentum eget et tellus.
                        Aenean tincidunt, mauris ut dignissim lacinia, nisi urna consectetur sapien,
                        nec eleifend orci eros id lectus.
                    </p>
                    <p>
                        Aenean eget odio eu justo mollis consectetur non quis enim.
                        Vivamus interdum quam tortor, et sollicitudin quam pulvinar sit amet.
                        Donec facilisis auctor lorem, quis mollis metus dapibus nec. Donec interdum tellus vel mauris vehicula,
                        at ultrices ex gravida. Maecenas at elit tincidunt, vulputate augue vitae, vulputate neque.
                        Aenean vel quam ligula. Etiam faucibus aliquam odio eget condimentum.
                        Cras lobortis, orci nec eleifend ultrices, orci elit pellentesque ex, eu sodales felis urna nec erat.
                        Fusce lacus est, congue quis nisi quis, sodales volutpat lorem.
                    </p>
                </div>
                <!-- end tab-pane -->
                <!-- begin tab-pane -->
                <div class="tab-pane fade" id="nav-tab2-4">
                    <h3 class="m-t-10">Nav Tab 4</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Integer ac dui eu felis hendrerit lobortis. Phasellus elementum, nibh eget adipiscing porttitor,
                        est diam sagittis orci, a ornare nisi quam elementum tortor.
                        Proin interdum ante porta est convallis dapibus dictum in nibh.
                        Aenean quis massa congue metus mollis fermentum eget et tellus.
                        Aenean tincidunt, mauris ut dignissim lacinia, nisi urna consectetur sapien,
                        nec eleifend orci eros id lectus.
                    </p>
                    <p>
                        Aenean eget odio eu justo mollis consectetur non quis enim.
                        Vivamus interdum quam tortor, et sollicitudin quam pulvinar sit amet.
                        Donec facilisis auctor lorem, quis mollis metus dapibus nec. Donec interdum tellus vel mauris vehicula,
                        at ultrices ex gravida. Maecenas at elit tincidunt, vulputate augue vitae, vulputate neque.
                        Aenean vel quam ligula. Etiam faucibus aliquam odio eget condimentum.
                        Cras lobortis, orci nec eleifend ultrices, orci elit pellentesque ex, eu sodales felis urna nec erat.
                        Fusce lacus est, congue quis nisi quis, sodales volutpat lorem.
                    </p>
                </div>
                <!-- end tab-pane -->
                <!-- begin tab-pane -->
                <div class="tab-pane fade" id="nav-tab2-5">
                    <h5 class="m-t-0">Color Theme</h5>
                    <ul class="theme-list clearfix">
                        <li><a href="javascript:;" class="bg-red" data-theme="red" data-theme-file="../assets/css/default/theme/red.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Red">&nbsp;</a></li>
                        <li><a href="javascript:;" class="bg-pink" data-theme="pink" data-theme-file="../assets/css/default/theme/pink.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Pink">&nbsp;</a></li>
                        <li><a href="javascript:;" class="bg-orange" data-theme="orange" data-theme-file="../assets/css/default/theme/orange.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Orange">&nbsp;</a></li>
                        <li><a href="javascript:;" class="bg-yellow" data-theme="yellow" data-theme-file="../assets/css/default/theme/yellow.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Yellow">&nbsp;</a></li>
                        <li><a href="javascript:;" class="bg-lime" data-theme="lime" data-theme-file="../assets/css/default/theme/lime.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Lime">&nbsp;</a></li>
                        <li><a href="javascript:;" class="bg-green" data-theme="green" data-theme-file="../assets/css/default/theme/green.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Green">&nbsp;</a></li>
                        <li><a href="javascript:;" class="bg-teal" data-theme="default" data-theme-file="../assets/css/default/theme/default.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Default">&nbsp;</a></li>
                        <li><a href="javascript:;" class="bg-aqua" data-theme="aqua" data-theme-file="../assets/css/default/theme/aqua.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Aqua">&nbsp;</a></li>
                        <li><a href="javascript:;" class="bg-blue" data-theme="blue" data-theme-file="../assets/css/default/theme/blue.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Blue">&nbsp;</a></li>
                        <li><a href="javascript:;" class="bg-purple" data-theme="purple" data-theme-file="../assets/css/default/theme/purple.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Purple">&nbsp;</a></li>
                        <li><a href="javascript:;" class="bg-indigo" data-theme="indigo" data-theme-file="../assets/css/default/theme/indigo.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Indigo">&nbsp;</a></li>
                        <li><a href="javascript:;" class="bg-black" data-theme="black" data-theme-file="../assets/css/default/theme/black.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Black">&nbsp;</a></li>
                    </ul>
                    <div class="divider"></div>
                    <div class="row m-t-10">
                        <div class="col-md-6 control-label text-inverse f-w-600">Header Styling</div>
                        <div class="col-md-6">
                            <select name="header-styling" class="form-control form-control-sm">
                                <option value="1">default</option>
                                <option value="2">inverse</option>
                            </select>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-md-6 control-label text-inverse f-w-600">Header</div>
                        <div class="col-md-6">
                            <select name="header-fixed" class="form-control form-control-sm">
                                <option value="1">fixed</option>
                                <option value="2">default</option>
                            </select>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-md-6 control-label text-inverse f-w-600">Sidebar Styling</div>
                        <div class="col-md-6">
                            <select name="sidebar-styling" class="form-control form-control-sm">
                                <option value="1">default</option>
                                <option value="2">grid</option>
                            </select>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-md-6 control-label text-inverse f-w-600">Sidebar</div>
                        <div class="col-md-6">
                            <select name="sidebar-fixed" class="form-control form-control-sm">
                                <option value="1">fixed</option>
                                <option value="2">default</option>
                            </select>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-md-6 control-label text-inverse f-w-600">Sidebar Gradient</div>
                        <div class="col-md-6">
                            <select name="content-gradient" class="form-control form-control-sm">
                                <option value="1">disabled</option>
                                <option value="2">enabled</option>
                            </select>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-md-6 control-label text-inverse f-w-600">Content Styling</div>
                        <div class="col-md-6">
                            <select name="content-styling" class="form-control form-control-sm">
                                <option value="1">default</option>
                                <option value="2">black</option>
                            </select>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-md-6 control-label text-inverse f-w-600">Direction</div>
                        <div class="col-md-6">
                            <select name="direction" class="form-control form-control-sm">
                                <option value="1">LTR</option>
                                <option value="2">RTL</option>
                            </select>
                        </div>
                    </div>
                    <div class="divider"></div>
                </div>
                <!-- end tab-pane -->
            </div>
            <!-- end tab-content -->
        </div>
    </div>
</div>
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
<script>
    var input = document.querySelector("#Mobileno");
    var errorMsg = document.querySelector("#error-msg");
    var validMsg = document.querySelector("#valid-msg");

    var telInput = window.intlTelInput(input, {
        // allowDropdown: false,
        // autoHideDialCode: false,
        // autoPlaceholder: "off",
        // dropdownContainer: document.body,
        // excludeCountries: ["us"],
        // formatOnDisplay: false,
        geoIpLookup: function(callback) {
            $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        // hiddenInput: "full_number",
        initialCountry: "auto",
        // localizedCountries: { 'de': 'Deutschland' },
        // nationalMode: false,
        // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        // placeholderNumberType: "MOBILE",
        preferredCountries: ['In', 'US'],
        separateDialCode: true,
        hiddenInput: "full_phone",
        utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js'
        //"<?=base_url('assets/plugins/intl-tel-input-master/build/js/utils.js')?>",
    });

    // Error messages based on the code returned from getValidationError
    var errorMap = [ "Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

    var reset = function() {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    };

    // Validate on blur event
    input.addEventListener('blur', function() {
        reset();
        if(input.value.trim()){
            if(telInput.isValidNumber()){
                validMsg.classList.remove("hide");
                /* get code here*/
                //alert(input);
            }else{
                input.classList.add("error");
                var errorCode = telInput.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
            }
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('.textarea_editor').wysihtml5();
        $('.timepicker').timepicker();
        $('.default-select2').select2();
        $('.mydatepicker').datepicker({
            autoclose: true,
        });
        $('.mypicker').datepicker({
            format: "mm/yyyy",
            startView: 1,
            minViewMode: 1,
            maxViewMode: 2,
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
        $('.mytimepicker,.mytimepickeredit').timepicker();
        $(".mytimepicker").val('');
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
        $('#myTable').DataTable();
        $('#example23,#example2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                /* 'copy',*/ 'csv', 'excel', 'pdf', 'print'
            ]
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
                    $("#StateName").append("<option value=''> </option>");
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
                    $("#CityName").append("<option value=''> </option>");
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
    })
</script>
<script type="text/javascript">
    $(document).ready(function($) {
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
                    console.log(dataresponce);
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
