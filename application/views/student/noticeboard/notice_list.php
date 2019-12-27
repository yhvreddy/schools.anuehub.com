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
                    <h4 class="panel-title">Notice List</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <?php if (count($noticelist) != 0){ ?>
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Notice Title</th>
                                    <th>Notice Date</th>
                                    <th class="text-center"></th>
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
                                        <td><?=$notice->notice_title?></td>
                                        <td><?=date('d-m-Y',strtotime($notice->notice_date))?></td>
                                        <td align="center">
                                            <a href="<?=base_url('teacher/notice/'.$notice->sno.'?id='.$notice->id_num)?>" class="font-20"><i class="fa fa-file fa-dx"></i></a>&nbsp;&nbsp;
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
