<!-- Container fluid  -->
<?php $schooldata = $this->session->userdata['school']; ?>
<style>
    .dropify-wrapper{
        height: 35px !important;
        font-size:15px !important;
    }
    .dropify-message{
        padding-bottom: 8px;
    }
    .dropify-wrapper .dropify-message span.file-icon {
        font-size: 20px;
        display: initial;
    }
    .dropify-message p{
        margin: 0px !important;
        font-size: 6px;
        line-height: 1px;
    }
    .dropify-font:before{

    }
</style>
<?php $expense = $expensedata[0]; ?>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Expenses</a></li>
        <li class="breadcrumb-item active">Expenses</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Expenses <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title"> Expenses</h4>
                </div>
                <div class="panel-body">
                    <form class="col-md-12" action="<?=base_url('dashboard/expenses/expenseEditSavedata')?>" id="saveexpensesData" name="saveexpenses" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="sno" value="<?=$expense->sno?>">
                            <input type="hidden" name="id_num" value="<?=$expense->id_num?>">
                            <div class="form-group col-md-2">
                                <label>Select Expenses Head <small class="text-danger">*</small></label>
                                <select autofocus="" id="exp_head_id" name="exp_head_id" class="form-control select2" autocomplete="off" required>
                                    <option value="">Select Expenses Head</option>
                                    <?php $i = 1; foreach ($expenseshead as $exp){ ?>
                                        <option <?php if($expense->exp_type == $exp->sno){ ?> selected <?php } ?> value="<?=$exp->sno?>"><?=$exp->name?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Expenses Name <small class="text-danger">*</small></label>
                                <input id="expensesName" name="exp_name" placeholder="Expenses Name" type="text" class="form-control" value="<?=$expense->exp_name?>">
                                <span class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Invoice Number <small class="text-danger">*</small></label>
                                <input id="invoice_no" required name="invoice_no" placeholder="Invoice id" type="text" class="form-control" value="<?=$expense->exp_id?>">
                                <span class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Date <small class="text-danger">*</small></label>
                                <input id="expensesDate" name="exp_date" placeholder="Date" type="text" class="form-control mydatepicker" value="<?=date('m/d/Y',strtotime($expense->exp_date));?>" readonly="readonly" autocomplete="off">
                                <span class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Amount <small class="text-danger">*</small></label>
                                <input id="expensesAmount" name="exp_amount" required placeholder="Expenses Amount" type="text" class="form-control" value="<?=$expense->exp_amount?>">
                                <span class="text-danger"></span>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="exampleInputEmail1">Attach Document</label>
                                <input id="documents" name="exp_documents" placeholder="" type="file" class="dropify form-control" accept=".jpg,.png,.JPEG,.pdf">
                                <input type="hidden" name="uploaded_image" value="<?=$expense->exp_upload?>">

                            </div>

                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea class="form-control" id="exp_description" name="description" placeholder="Description" rows="3"><?=$expense->exp_description?></textarea>
                                <span class="text-danger"></span>
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="radio radio-css radio-inline">
                                            <input type="radio" id="inlineCssRadio1_<?='offline'?>" name="payment_status" <?php if($expense->exp_status == 'pending'){ echo 'checked'; } ?> value="pending" />
                                            <label for="inlineCssRadio1_<?='offline'?>">Pending </label>
                                        </div>
                                        <div class="radio radio-css radio-inline">
                                            <input type="radio" id="inlineCssRadio1_<?='online'?>" name="payment_status" <?php if($expense->exp_status == 'complete'){ echo 'checked'; } ?> value="complete" />
                                            <label for="inlineCssRadio1_<?='online'?>">Complete </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" id="saveexpensesDatabtn" class="btn btn-success pull-right">Save Expenses</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Expenses List</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered table-striped" id="myTable">
                            <thead>
                                <th>Sno</th>
                                <th>Expenses Id</th>
                                <th>Expenses Head</th>
                                <th>Expenses Name</th>
                                <th>Invoice Id</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach ($expenses as $expens){ ?>
                                    <tr>
                                        <td><?=$i++?></td>
                                        <td><?=$expens->id_num?></td>
                                        <?php
                                        $exp = $this->Model_dashboard->selectdata('sms_setupdata',array('school_id'=>$schooldata->school_id,'branch_id'=>$schooldata->branch_id,'sno'=>$expens->exp_type,'status'=>1));
                                        ?>
                                        <td><?=$exp[0]->name?></td>
                                        <td><?=$expens->exp_name?></td>
                                        <td><?=$expens->exp_id?></td>
                                        <td><?=$expens->exp_amount?></td>
                                        <td><?=date('d-m-Y',strtotime($expens->exp_date))?></td>
                                        <td align="right">
                                            <?php if($expens->exp_upload != ''){
                                                $encode = urlencode($expens->exp_upload);
                                                ?>
                                                <a href="<?=base_url('dashboard/expenses/download/'.$expens->sno.'/'.$expens->id_num.'?file='.$encode)?>"><i class="fa fa-download fa-dx"></i> </a>&nbsp;&nbsp;
                                            <?php } ?>
                                            <a href="<?=base_url('dashboard/expenses/edit/'.$expens->sno.'/'.$expens->id_num)?>" onclick="return confirm('Are you want to edit expenses <?= $expens->exp_name ?>..?')"><i class="fa fa-edit fa-dx"></i> </a>&nbsp;&nbsp;
                                            <a href="<?=base_url('dashboard/expenses/delete/'.$expens->sno.'/'.$expens->id_num)?>" onclick="return confirm('Are you want to Delete expenses <?= $expens->exp_name ?>..?')"><i class="fa fa-trash-o fa-dx"></i> </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<script>
    $(document).ready(function () {
        $('#saveexpensesDatabtn').on('click',function (e) {
            e.preventDefault();
            var tselected = $('input[type="radio"]:checked').length;
            var expenseshead  = $('#exp_head_id').val();
            var expensesName  = $('#expensesName').val();
            var invoice_no    = $('#invoice_no').val();
            var expensesDate  = $('#expensesDate').val();
            var expensesAmount = $('#expensesAmount').val();

            if(expensesAmount != '' && expensesDate != '' && expenseshead != '' && expensesName != '' && invoice_no != '') {
                if(tselected <= 0) {
                    alert('Please select Expenses Status..!');
                }else {
                    $('#saveexpensesData').submit();
                }
            }else{
                alert('please fill requred data..!');
            }

        })
    })
</script>