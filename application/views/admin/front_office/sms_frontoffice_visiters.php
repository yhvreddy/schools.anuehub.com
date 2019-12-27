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
        <li class="breadcrumb-item"><a href="javascript:;">Front Office</a></li>
        <li class="breadcrumb-item active">Visiter's</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Visiters <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="row">

                <div class="col-md-12">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                <a href="javascript:;" data-toggle="modal" data-target="#Newvisiters" data-backdrop="static" data-keyboard="false" class="pull-right btn btn-success btn-xs"><i class="fa fa-list"></i> New Visiter</a>
                            </div>
                            <h4 class="panel-title">Visiters List</h4>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12 table-responsive">
                                <?php if(count($visitersdata) != 0){ //print_r($visitersdata); ?>
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>SNo</th>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Perpose</th>
                                            <th>No Persons</th>
                                            <th>In time</th>
                                            <th>Out time</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=1; foreach ($visitersdata as $visiter) { ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <script>
                                                    $(document).ready(function(){
                                                        var firstName = '<?=$visiter->name?>';
                                                        var intials = firstName.charAt(0);
                                                        var profileImage = $('#profileImage<?=$visiter->sno?>').text(intials);
                                                    });
                                                </script>
                                                <td align="center">

                                                        <div id="profileImage<?=$visiter->sno;?>" class="profileImage text-uppercase"></div>
                                                </td>
                                                <td><?=$visiter->name?></td>
                                                <td><?=$visiter->mobile?></td>
                                                <?php
                                                $purpose = $this->Model_dashboard->selectdata('sms_frontoffice_types',array('school_id'=>$schooldata->school_id,'sno'=>$visiter->purpose,'branch_id'=>$schooldata->branch_id,'type'=>'visiters'))
                                                ?>
                                                <td><?=$purpose[0]->name?></td>
                                                <td><?=$visiter->nopersons?></td>
                                                <td><?php echo date('h:i a',strtotime($visiter->intime))?></td>
                                                <td><?php if(!empty($visiter->outtime)){ echo date('h:i a',strtotime($visiter->outtime)); }else{ echo '---'; }?></td>
                                                <td align="center">
                                                    <?php if($visiter->inout == 1){ ?>
                                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#outvisiters<?=$visiter->sno?>" data-backdrop="static" data-keyboard="false" class="font-20"><i class="fa fa-times fa-dx"></i></a>&nbsp;&nbsp;

                                                        <a href="javascript:;" data-toggle="modal" data-target="#Editvisiters<?=$visiter->sno?>" data-backdrop="static" data-keyboard="false" class="font-20"><i class="fa fa-edit fa-dx"></i></a>&nbsp;&nbsp;
                                                    <?php } ?>
													<?php if($visiter->inout == 1){ ?>
														<a href="javascript:;" onclick="return alert('You can not able to delete visiters data : <?=$visiter->name?>');" class="font-20 text-warning"><i class="fa fa-trash-o fa-dx"></i></a>
													<?php }else if($visiter->inout == 0){ ?>
														<a href="<?=base_url('dashboard/frontoffice/visiters/delete/'.$visiter->sno)?>" onclick="return confirm('You want to delete visiter data: <?=$visiter->name?>');" class="font-20 text-danger"><i class="fa fa-trash-o fa-dx"></i></a>
													<?php } ?>

                                                </td>
                                            </tr>
                                            <!-- Modal Edit-->
                                            <div id="Editvisiters<?=$visiter->sno?>" class="modal fade" role="dialog">
                                                <div class="modal-dialog modal-lg">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit : <?=$visiter->name?></h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <form method="post" action="<?=base_url('dashboard/frontoffice/visiters/edit/'.$visiter->sno)?>">
                                                                    <div class="form-group col-md-3">
                                                                        <label>Enter Visiter Name</label>
                                                                        <input type="text" placeholder="Enter Vister Name" required name="visitername" class="form-control" value="<?=$visiter->name?>">
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label>Select Perpose</label>
                                                                        <select class="form-control text-black" name="perposetype" required>
                                                                            <option value="">Select visiting Perpose</option>
                                                                            <?php foreach($visiters as $visit){ ?>
                                                                                <option <?php if($visiter->purpose == $visit->sno){ echo 'selected'; } ?> value="<?= $visit->sno ?>"><?= $visit->name ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label>Enter Vister Mobile</label>
                                                                        <input type="tel" name="mobile" id="Mobile" maxlength="" placeholder="Enter Visiter Mobile" required value="<?=$visiter->mobile?>" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label>Enter Referral Id</label>
                                                                        <input type="text" class="form-control" placeholder="Enter Referral id" name="referralid" value="<?=$visiter->referral_id?>">
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label>Enter Number of Persons</label>
                                                                        <input type="tel" class="form-control" placeholder="Enter Number of persons" name="numofpersons" value="<?=$visiter->nopersons?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label>Date</label>
                                                                        <input type="text" readonly="readonly" class="form-control mydatepicker" placeholder="pick Date" name="visitingdate" required value="<?=date('m/d/Y',strtotime($visiter->visiting_data))?>">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group row">
                                                                            <div class="col-md-6">
                                                                                <label>In time</label>
                                                                                <input placeholder="In Time" type="text" class="form-control mytimepickeredit" value="<?=date('h:i a',strtotime($visiter->intime))?>" name="intme" required>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label>Out time</label>
                                                                                <input type="text" class="form-control mytimepickeredit" name="outtme" value="<?=date('h:i a',strtotime($visiter->outtime))?>" placeholder="Out Time" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-12">
                                                                        <label>Note</label>
                                                                        <textarea placeholder="Type Note..." name="note" class="form-control"><?=$visiter->note?></textarea>
                                                                    </div>
                                                                    <div class="form-group col-md-12">
                                                                        <input type="submit" value="Save Visiter Data" name="submitperpose" class="btn btn-success pull-right">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div id="outvisiters<?=$visiter->sno?>" class="modal fade" role="dialog">
                                                <div class="modal-dialog modal-lg">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Time Out : <?=$visiter->name?></h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <form method="post" action="<?=base_url('dashboard/frontoffice/visiters/timeout/'.$visiter->sno.'/0')?>">
                                                                    <div class="form-group col-md-3">
                                                                        <label>Enter Visiter Name</label>
                                                                        <input type="text" placeholder="Enter Vister Name" required name="visitername" class="form-control" value="<?=$visiter->name?>">
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label>Select Perpose</label>
                                                                        <select class="form-control text-black" name="perposetype" required>
                                                                            <option value="">Select visiting Perpose</option>
                                                                            <?php foreach($visiters as $visit){ ?>
                                                                                <option <?php if($visiter->purpose == $visit->sno){ echo 'selected'; } ?> value="<?= $visit->sno ?>"><?= $visit->name ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label>Enter Vister Mobile</label>
                                                                        <input type="tel" name="mobile" id="Mobile" maxlength="" placeholder="Enter Visiter Mobile" required value="<?=$visiter->mobile?>" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label>Enter Referral Id</label>
                                                                        <input type="text" class="form-control" placeholder="Enter Referral id" name="referralid" value="<?=$visiter->referral_id?>">
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label>Enter Number of Persons</label>
                                                                        <input type="tel" class="form-control" placeholder="Enter Number of persons" name="numofpersons" value="<?=$visiter->nopersons?>" required>
                                                                    </div>
                                                                    <div class="form-group col-md-3">
                                                                        <label>Date</label>
                                                                        <input type="text" readonly="readonly" class="form-control mydatepicker" placeholder="pick Date" name="visitingdate" required value="<?=date('m/d/Y',strtotime($visiter->visiting_data))?>">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group row">
                                                                            <div class="col-md-6">
                                                                                <label>In time</label>
                                                                                <input placeholder="In Time" type="text" class="form-control mytimepickeredit" value="<?=date('h:i a',strtotime($visiter->intime))?>" name="intme" required>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label>Out time</label>
                                                                                <input type="text" class="form-control mytimepicker" name="outtme" value="<?php if(!empty($visiter->outtime)){ echo date('h:i a',strtotime($visiter->outtime)); }?>" placeholder="Out Time" required="required">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-12">
                                                                        <label>Note</label>
                                                                        <textarea placeholder="Type Note..." name="note" class="form-control"><?=$visiter->note?></textarea>
                                                                    </div>
                                                                    <div class="form-group col-md-12">
                                                                        <input type="submit" value="Logout Visiter" name="logoutvisiter" class="btn btn-success pull-right">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

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

                <div id="Newvisiters" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New Visiter</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <form method="post" class="row" action="<?=base_url('dashboard/frontoffice/visiters/save')?>">
                                            <div class="form-group col-md-4">
                                                <label>Enter Visiter Name</label>
                                                <input type="text" placeholder="Enter Vister Name" required name="visitername" class="form-control">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Select Perpose</label>
                                                <select class="form-control text-black" name="perposetype" required>
                                                    <option value="">Select visiting Perpose</option>
                                                    <?php foreach($visiters as $visiter){ ?>
                                                        <option value="<?= $visiter->sno ?>"><?= $visiter->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Enter Vister Mobile</label>
                                                <input type="tel" name="mobile" id="Mobileno" maxlength="" placeholder="Enter Visiter Mobile" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Enter Referral Id</label>
                                                <input type="text" class="form-control" placeholder="Enter Referral id" name="referralid">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>No.of Persons</label>
                                                <input type="tel" class="form-control" placeholder="No.of persons" name="numofpersons" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Date</label>
                                                <input type="text" readonly="readonly" class="form-control mydatepicker" placeholder="pick Date" name="visitingdate" required value="<?=date('m/d/Y')?>">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label>In time</label>
                                                        <input placeholder="In Time" type="text" class="form-control mytimepicker" name="intme" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Out time</label>
                                                        <input type="text" class="form-control mytimepicker" name="outtme" placeholder="Out Time">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Note</label>
                                                <textarea placeholder="Type Note..." name="note" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <input type="submit" value="Save Visiter Data" name="submitperpose" class="btn btn-success pull-right">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
