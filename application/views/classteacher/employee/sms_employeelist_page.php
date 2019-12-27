<!-- Container fluid  -->
<style>
    table.table-bordered.dataTable tbody td {
        line-height: 28px;
    }
</style>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
		<li class="breadcrumb-item active"><a href="javascript:;">Staff List</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Staff List <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Staff list</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 table-responsive">
                        <?php if(count($employees) != 0){ ?>
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>Register Id</th>
                                    <th>Staff Name</th>
                                    <th>Mail id </th>
                                    <th>Mobile</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach ($employees as $employee) { ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <script>
                                            $(document).ready(function(){
                                                var firstName = '<?=$employee->firstname?>';
                                                var lastName = '<?=$employee->lastname?>';
                                                var intials = firstName.charAt(0) + lastName.charAt(0);
                                                var profileImage = $('#profileImage<?=$employee->sno?>').text(intials);
                                            });
                                        </script>
                                        <td align="center">
                                            <?php if(!empty($employee->employee_pic)){ ?>
                                                <img src="<?=base_url($employee->employee_pic)?>" class="profileImage">
                                            <?php }else{ ?>
                                                <div id="profileImage<?=$employee->sno;?>" class="profileImage text-uppercase"></div>
                                            <?php } ?>
                                        </td>
                                        <td><a href="<?=base_url('classteacher/employee/details/'.$employee->sno.'/'.$employee->branch_id.'/'.$employee->school_id)?>"> <?=$employee->id_num?></a></td>
                                        <td><?=ucwords(substr($employee->lastname,0,1).'.'.$employee->firstname);?></td>
                                        <td><?php if(!empty($employee->local_mail_id)){ echo strtolower($employee->local_mail_id); }else{ echo strtolower($employee->mail_id); }?></td>
                                        <td><?=$employee->mobile?></td>
                                        <td align="center">
                                            <span data-toggle="tooltip" title="View details"><a href="<?=base_url('classteacher/employee/details/'.$employee->sno.'/'.$employee->branch_id.'/'.$employee->school_id)?>" data-toggle='tooltip' title="View" class="font-20"><i class="fa fa-file fa-dx"></i></a></span>&nbsp;&nbsp;
                                        </td>
                                    </tr>
                                <?php } ?>
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
