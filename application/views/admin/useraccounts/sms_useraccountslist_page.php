<!-- Container fluid  -->
<style>
    table.table-bordered.dataTable tbody td {
        line-height: 28px;
    }
    .switcher label {
        height: 18px !important;
    }
</style>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item active">User Accounts</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">User Account's <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:void(0);" class="pull-right btn btn-success btn-xs" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#Newuseraccount"><i class="fa fa-plus"></i> New User Account</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">User Account's list</h4>
                </div>
                <div class="panel-body">
                    <!-- eNote Model start-->
                    <div id="Newuseraccount" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content" style="top:50px">
                                <div class="modal-header">
                                    <h4 class="modal-title">New User Account</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method="post" action="<?=base_url('dashboard/useraccounts/savedata')?>">
                                                <input type="hidden" name="schoolid" value="<?=$schoolid?>">
                                                <input type="hidden" name="branchid" value="<?=$branchid?>">
                                                <div class="row">
                                                    <div class="form-group col-md-4">
                                                        <label>Select account mode</label>
                                                        <select class="form-control" name="accountmode" id="accountmode">
                                                            <option value="">Select Mode Type</option>
                                                            <option value="student">Student Account</option>
                                                            <option value="employee">Employee Account</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div id="contentbox">
                                                    <div class="row justify-content-center align-items-center">
                                                        <div id="col-md-6">
                                                            <center>
                                                                <h5><strong>Pleace Select Above Opption</strong></h5>
                                                                <img src="<?=base_url('assets/img/pleaseselect.png')?>" class="img-responsive">
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- eNote Model end-->

                    <div class="col-md-12">
                        <?php if(count($useraccountdata) != 0){ ?>
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>Reg id</th>
                                    <th>Name</th>
                                    <th>Mail Id</th>
									<th>Mobile</th>
                                    <th>User Id</th>
                                    <th>User type</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($useraccountdata as $useraccount) {
                                        $userdata = $this->Model_dashboard->sedetails($branchid,$schoolid,$useraccount->id_num);
                                        ?>
                                        <tr>
                                            <td><?=$i?></td>
                                            <script>
                                                $(document).ready(function(){
                                                    var firstName = '<?=$userdata->firstname?>';
                                                    var lastName = '<?=$userdata->lastname?>';
                                                    var intials = firstName.charAt(0) + lastName.charAt(0);
                                                    var profileImage = $('#profileImage<?=$userdata->sno?>').text(intials);
                                                });
                                            </script>
                                            <td align="center">
                                                <div id="profileImage<?=$userdata->sno;?>" class="profileImage text-uppercase"></div>
                                            </td>

											<?php
												if($useraccount->usertype == 'student'){
													$detailslink  = 'dashboard/admission/details/'.$userdata->sno.'/'.$userdata->branch_id.'/'.$userdata->school_id.'/student';
												}else{
													$detailslink  = 'dashboard/employee/details/'.$userdata->sno.'/'.$userdata->branch_id.'/'.$userdata->school_id.'/employee';
												}
											?>

                                            <td><a href="<?=base_url($detailslink)?>" target="_blank"> <?=$useraccount->id_num?> </a></td>
                                            <td><?=$userdata->firstname?></td>
                                            <td><?=$userdata->mail_id?></td>
											<td><?=$userdata->mobile?></td>
                                            <td><?=$useraccount->username?></td>
                                            <td><?=$useraccount->usertype?></td>
                                            <td>
                                                <?php if($useraccount->status == 1){ ?>
                                                    <div class="switcher">
                                                        <input type="checkbox" id="switcher_checkbox_1<?=$useraccount->sno;?>" checked="" value="<?=$useraccount->sno;?>" data-status="Off">
                                                        <label for="switcher_checkbox_1<?=$useraccount->sno;?>"></label>
                                                    </div>
                                                <?php }else{ ?>
                                                    <div class="switcher">
                                                        <input type="checkbox" id="switcher_checkbox_1<?=$useraccount->sno;?>" value="<?=$useraccount->sno;?>" data-status="On">
                                                        <label for="switcher_checkbox_1<?=$useraccount->sno;?>"></label>
                                                    </div>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <script>
                                            $(document).ready(function(){
                                                $('#switcher_checkbox_1<?=$useraccount->sno;?>').click(function(){
                                                    var idnum = $(this).val();
                                                    var datastatus = $(this).data("status");
                                                    //alert(datastatus);
                                                    if(confirm('Are you Want to switch '+ datastatus +' account..!')){
                                                        $.ajax({
                                                            url:"<?=base_url('dashboard/useraccounts/useraccountoffon')?>",
                                                            type:'POST',
                                                            dataType:'JSON',
                                                            data:{userid:idnum},
                                                            success:function(resp){
                                                                console.log(resp.msg);
                                                                if(resp.key == 0){
                                                                    alert(resp.msg);
                                                                }else if(resp.key == 1){
                                                                    alert(resp.msg);
                                                                }
                                                            }
                                                        });
                                                    }
                                                });
                                            });
                                        </script>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        <?php }else{ ?>
                            <?= $this->Model_integrate->norecords(); ?>
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
        $("#accountmode").on('change',function(){
            var accountmode = $(this).val();
            if(accountmode == ""){
                return false;
                $("#accountmode").focus();
                $("#contentbox").hide();
            }else{
                $("#contentbox").show();
                //alert(accountmode);
                $.ajax({
                    url:"<?=base_url('dashboard/useraccounts/fieldssetajax')?>",
                    data:{accountmode:accountmode},
                    type:'post',
                    success:function(successdata){
                        //console.log(successdata);
                        $("#contentbox").html(successdata);
                    }
                })
            }
        })

    })
</script>
