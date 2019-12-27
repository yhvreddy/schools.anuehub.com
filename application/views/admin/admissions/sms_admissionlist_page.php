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
        <li class="breadcrumb-item"><a href="javascript:;">Admissions</a></li>
        <li class="breadcrumb-item active">Admissions List</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Admission's List <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="<?=base_url('dashboard/admissions/newadmissions')?>" class="pull-right btn btn-success btn-xs" data-target="#NeweNote"><i class="fa fa-plus"></i> New Admission</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Admissions list</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <?php if(count($adminssions) != 0){ ?>
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th></th>
                                        <th>Admission Id</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Gender</th>
    <!--                                    <th>DOB</th>-->
    <!--                                    <th>Syllabus</th>-->
                                        <th>class</th>
                                        <th>Mobile</th>
                                        <th>School mail</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($adminssions as $adminssion) { ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <script>
                                                $(document).ready(function(){
                                                    var firstName = '<?=$adminssion->firstname?>';
                                                    var lastName = '<?=$adminssion->lastname?>';
                                                    var intials = firstName.charAt(0) + lastName.charAt(0);
                                                    var profileImage = $('#profileImage<?=$adminssion->sno?>').text(intials);
                                                });
                                            </script>
                                            <td align="center">
                                                <?php if(!empty($adminssion->student_image)){ ?>
                                                    <img src="<?=base_url($adminssion->student_image)?>" class="profileImage">
                                                <?php }else{ ?>
                                                    <div id="profileImage<?=$adminssion->sno;?>" class="profileImage text-uppercase"></div>
                                                <?php } ?>
                                            </td>
                                            <td><a href="<?=base_url('dashboard/admission/details/'.$adminssion->sno.'/'.$adminssion->branch_id.'/'.$adminssion->school_id)?>"> <?=$adminssion->id_num?> </a></td>
                                            <td><?=$adminssion->firstname?></td>
                                            <td><?=$adminssion->lastname?></td>
                                            <td><?php if($adminssion->gender == 'FM'){ echo 'Female'; }else{ echo 'Male'; } ?></td>
                                            <!--<td><?php //echo date('Y-m-d',strtotime($adminssion->dob));?></td>-->
                                            <!--<td><?php //$syllabusname = $this->Model_dashboard->syllabusname(array('id'=>$adminssion->class_type)); echo $syllabusname['0']->type; ?></td>-->
                                            <td><?=$adminssion->class?></td>
                                            <td><?=$adminssion->mobile?></td>
                                            <td><?=strtolower($adminssion->local_mail_id)?></td>
                                            <td align="center">
                                                <span data-toggle="tooltip" title="View details"><a href="<?=base_url('dashboard/admission/details/'.$adminssion->sno.'/'.$adminssion->branch_id.'/'.$adminssion->school_id)?>" class="font-20"><i class="fa fa-file fa-dx"></i></a></span>&nbsp;&nbsp;

												<span data-toggle="tooltip" title="Edit details"><a href="<?=base_url('dashboard/admission/edit/'.$adminssion->sno.'/'.$adminssion->school_id.'/'.$adminssion->branch_id.'/')?>" onclick="return confirm('You want to Edit '.$adminssion->id_num.' - '.$adminssion->firstname.' Admission.');" class="font-20"><i class="fa fa-edit fa-dx"></i></a></span>&nbsp;&nbsp;

												<span data-toggle="tooltip" title="Delete details"><a href="<?=base_url('dashboard/admission/delete/'.$adminssion->sno.'/'.$adminssion->school_id.'/'.$adminssion->branch_id.'/')?>" onclick="return confirm('You want to delete admission : <?=$adminssion->id_num?> - <?=$adminssion->firstname?>');" class="font-20"><i class="fa fa-trash-o fa-dx"></i></a></span>
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
