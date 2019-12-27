<!-- Container fluid  -->
<?php
    $schooldata = $this->session->userdata['school'];
    $notice     = $noticelist[0];
?>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Notice Board</a></li>
        <li class="breadcrumb-item active">Edit Notice</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Edit Notice<small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="<?=base_url('dashboard/notice/noticelist')?>" class="pull-right btn btn-success btn-xs"><i class="fa fa-list"></i> Notice List</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">New Notice</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <form method="post" enctype="multipart/form-data" action="<?=base_url('dashboard/notice/saveeditnotice')?>">
                            <input type="hidden" value="<?=$notice->sno?>" name="sno">
                            <input type="hidden" value="<?=$notice->id_num?>" name="id_num">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label>Notice Date</label>
                                                    <input type="text" name="noticedate" value="<?= date('d/m/Y',strtotime($notice->notice_date)) ?>" class="mydatepicker form-control" placeholder="Pick Notice date" required readonly>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label>Pick Publish Date</label>
                                                    <input type="text" name="noticepublishdate" value="<?= date('d/m/Y',strtotime($notice->notice_publish)) ?>" required class="mydatepicker form-control" placeholder="Pick Publish date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <label>Enter Notice Title</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Title of the Notice" name="noticetitle" value="<?=$notice->notice_title?>" required>
                                            </div>
                                        </div>
                                        <!--<div class="itm_upload">
                                            <div class="demo-radio-button col-md-12">
                                                <input name="srctype" type="radio" id="radio_5" class="with-gap" value="none" checked>
                                                <label for="radio_5">None</label>
                                                <input name="srctype" type="radio" class="with-gap" value="srcfile" id="radio_3">
                                                <label for="radio_3">Upload Image</label>
                                                <input name="srctype" type="radio" id="radio_4" value="urllink" class="with-gap">
                                                <label for="radio_4">Image Url</label>
                                            </div>

                                            <div class="col-md-12" id="upload" style="display: none">
                                                <div class="form-group">
                                                    <input type="file" class="form-control" placeholder="Upload notice image..!" name="noticeupload">
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="url" style="display: none">
                                                <div class="form-group">
                                                    <input type="url" class="form-control" placeholder="Upload notice image..!" name="noticelink">
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Upload Image Files</label>
                                                    <div class="form-group">
                                                        <input type="file" class="form-control" accept=".png,.jpg,.JPEG" name="noticeupload">
														<input type="hidden" value="<?=$notice->notice_img?>" name="UplaodedNoticeImage">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Upload Other Files</label>
                                                    <div class="form-group">
                                                        <input type="file" multiple class="form-control" accept="*" name="noticeOtheruploads[]">
<!--														<a href="javascript:;">Click to Uploaded files</a>-->
														<input type="hidden" value="<?=$notice->notice_files?>" name="UplaodedNoticeOtherFiles">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Notice To</label>
                                            <div class="row">
                                            <?php $source = $this->Model_dashboard->selectdata('sms_formdata',array('status'=>1),'id');
                                            //echo count($source);
                                                $inserted = explode(',',$notice->notice_to);
                                                foreach ($source as $sourcename){ if($sourcename->type == 'staff' || $sourcename->type == 'worker' || $sourcename->type == 'office' || $sourcename->type == 'student'){ ?>
                                                    <div class="col-md-6 form-group">
                                                        <div class="checkbox checkbox-css">
                                                            <input type="checkbox" id="cssCheckbox1<?=$sourcename->id?>" name="noticeto[]" value="<?=$sourcename->shortname?>" <?php if(in_array($sourcename->shortname,$inserted)){ echo 'checked'; } ?> />
                                                            <label for="cssCheckbox1<?=$sourcename->id?>"><?=$sourcename->name?></label>
                                                        </div>
                                                    </div>
                                            <?php } } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label>Type Notice Discription</label>
                                    <div class="form-group">
                                        <textarea id="ckeditor" class="form-control" placeholder="Type Discription..!" name="noticecontent"><?=$notice->notice_content?></textarea>
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
                                        UPDATE NOTICE
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
