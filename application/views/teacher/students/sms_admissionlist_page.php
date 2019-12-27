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
        <li class="breadcrumb-item active">Student List</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Student List <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Students list</h4>
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
                                        <th>Gender</th>
                                        <th>DOB</th>
                                        <th>Syllabus</th>
                                        <th>class</th>
										<th>Sec / Rollno</th>
                                        <th>Mobile</th>
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
                                            <td><?=$adminssion->id_num?></td>
                                            <td><?=ucwords(substr($adminssion->lastname,0,1).'.'.$adminssion->firstname)?></td>
                                            <td><?php if($adminssion->gender == 'FM'){ echo 'Female'; }else{ echo 'Male'; } ?></td>
                                            <td><?php echo date('Y-m-d',strtotime($adminssion->dob));?></td>
                                            <td><?php $syllabusname = $this->Model_dashboard->syllabusname(array('id'=>$adminssion->class_type)); echo $syllabusname['0']->type; ?></td>
                                            <td><?=$adminssion->class?></td>
											<?php if($adminssion->rollno != '' && $adminssion->section != ''){ ?>
												<td align="center"><span class="text-success" style="font-weight: 600"><?=$adminssion->section?></span> &nbsp;&nbsp; - &nbsp;&nbsp; <span class="text-red-darker" style="font-weight: 600"><?=$adminssion->rollno?></span></td>
											<?php }else{ ?>
												<td align="center">
													<a href="javascript:;" data-backdrop="static" data-keyboard="false" class="text-warning text-decoration-none" data-toggle="modal" data-target="#AssignSecRollno_<?=$adminssion->sno?>">Assign RollNo</a>
												</td>
											<?php } ?>

                                            <td><?=$adminssion->mobile?></td>
                                            <td align="center">
                                                <span data-toggle="tooltip" title="View details"><a href="<?=base_url('teacher/studentslist/details/'.$adminssion->sno.'/'.$adminssion->branch_id.'/'.$adminssion->school_id)?>" class="font-20"><i class="fa fa-file fa-dx"></i></a></span>&nbsp;
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
