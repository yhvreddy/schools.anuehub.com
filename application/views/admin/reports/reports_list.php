<!-- Container fluid  -->
<?php $schooldata = $this->session->userdata['school']; ?>
<style>
    table.table-bordered.dataTable tbody td {
        line-height: 28px;
    }
</style>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Notice Board</a></li>
        <li class="breadcrumb-item active">Notice List</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Notice List<small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="<?=base_url('dashboard/notice/addnotice')?>" class="pull-right btn btn-success btn-xs"><i class="fa fa-plus"></i> New Notice</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Notice List</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <?php if (count($noticelist) != 0){ ?>
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>Notice Id</th>
                                    <th width="40%">Notice Title</th>
                                    <th>Notice Date</th>
                                    <th>Publish Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($noticelist as $notice) {
                                    if((date('d-m-Y',strtotime($notice->notice_publish)) <= date('d-m-Y')) || $notice->publish_status == 2){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <?php
                                            $regid  = $this->Model_integrate->initials($notice->notice_title); //
                                            $uname  = strtoupper(substr($regid, 0, 2));
                                        ?>
                                        <td align="center">
                                            <?php if(!empty($notice->notice_img)){ ?>
                                                <img src="<?=base_url($notice->notice_img)?>" class="profileImage">
                                            <?php }else{ ?>
                                                <div class="profileImage text-uppercase"><?=$uname?></div>
                                            <?php } ?>
                                        </td>
                                        <td><a href="<?=base_url('dashboard/notice/'.$notice->sno)?>/?id=<?=$notice->id_num?>" target="_blank"> <?=$notice->id_num?> </a></td>
                                        <td><?=$notice->notice_title?></td>
                                        <td><?=date('d-m-Y',strtotime($notice->notice_date))?></td>
                                        <td><?=date('d-m-Y',strtotime($notice->notice_publish))?></td>
                                        <td align="center">
                                            <a href="<?=base_url('dashboard/notice/'.$notice->sno)?>/?id=<?=$notice->id_num?>" target="_blank" class="font-20"><i class="fa fa-file fa-dx"></i></a>&nbsp;&nbsp;

                                            <a href="<?=base_url('dashboard/notice/edit/'.$notice->sno.'/'.$notice->id_num)?>" onclick="return confirm('You Want To Edit Notice : <?=$notice->notice_title?>');" class="font-20"><i class="fa fa-edit fa-dx"></i></a>&nbsp;&nbsp;

                                            <a href="<?=base_url('dashboard/notice/deletenotice/'.$notice->sno)?>" onclick="return confirm('You want to delete Notice : <?=$notice->notice_title?>');" class="font-20"><i class="fa fa-trash-o fa-dx"></i></a>
                                        </td>
                                    </tr>
                                <?php } } ?>
                                </tbody>
                            </table>
                        <?php }else{ ?>
                            <?= $this->Model_dashboard->norecords(); ?>
                        <?php } ?>
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
