<!-- Container fluid  -->
<?php
    $schooldata = $this->session->userdata['school'];
    $notice = $noticelist[0];
?>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Notice Board</a></li>
        <li class="breadcrumb-item active">Notice Details</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">New Notice<small></small></h1>
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
                    <h4 class="panel-title">Notice Details</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <?php //print_r($notice); ?>
                        <div class="wrapper">
                            <h3 class="m-t-0 m-b-15 f-w-500"><?=$notice->notice_title?></h3>
                            <ul class="media-list underline m-b-15 p-b-15">
                                <li class="media media-sm clearfix">
                                    <?php
                                        $regid  = $this->Model_integrate->initials($notice->notice_title); //
                                        $uname  = strtoupper(substr($regid, 0, 2));
                                    ?>
                                    <a href="javascript:;" class="pull-left">
                                        <?php if(!empty($notice->notice_img)){ ?>
                                            <img src="<?=base_url($notice->notice_img)?>"class="media-object rounded-corner">
                                        <?php }else{ ?>
                                            <div class="profileImage text-uppercase"><?=$uname?></div>
                                        <?php } ?>
                                    </a>
                                    <div class="media-body">
                                        <div class="email-from text-inverse f-s-14 f-w-600 m-b-3">
                                            Notice To :
                                            <?php $noticeto = unserialize($notice->notice_to);
                                                foreach ($noticeto as $tags){ ?>
                                                <span class="btn btn-xs btn-success"><?=$tags?></span>
                                            <?php } ?>
                                        </div>
                                        <div class="m-b-3"><i class="fa fa-clock fa-fw"></i> Publish Date : <?=date('F j, Y',strtotime($notice->notice_publish))?></div>

                                    </div>
                                </li>
                            </ul>

                            <div class="f-s-12 text-inverse p-t-10">
                                <?= $notice->notice_content ?>
                            </div>
                            <?php if(!empty($notice->notice_files)){ $data = explode(',',$notice->notice_files); ?>
                                <ul class="attached-document clearfix">
									<?php
										foreach ($data as $key => $attachment){

											$names = explode('/'.$notice->id_num.'/',$attachment);
											$name = $names[1];

											$array = explode(".", $attachment);
											$extension = end($array);
											$this->Model_integrate->attachedfiles($attachment,$extension,$name);

										}
									?>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
