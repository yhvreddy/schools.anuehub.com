<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
<!-- end scroll to top btn -->
</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="<?=base_url()?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
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
<script src="<?=base_url()?>assets/plugins/dropify-master/dist/js/dropify.min.js"></script>
<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?=base_url()?>assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-wysihtml5/dist/bootstrap3-wysihtml5.all.min.js"></script>
<script src="<?=base_url()?>assets/js/demo/email-compose.demo.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-tagsinput/1.3.6/jquery.tagsinput.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script>
	$(document).ready(function() {
		// Basic
		$('.dropify').dropify({
			messages: {
				'default': 'Add attachment',
				'replace': 'Drag and drop or click to replace',
				'remove':  'Remove',
				'error':   'Ooops, something wrong happended.'
			},
			tpl: {
				message:         '<div class="dropify-message"><span class="fas fa-paperclip" /> <p class="default_message">{{ default }}</p></div>'
			}
		});

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
</script>
</body>
</html>
