<!-- Container fluid  -->
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
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Expenses</a></li>
        <li class="breadcrumb-item active">Setup Expenses</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Setup <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-4">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Setup Expenses</h4>
                </div>
                <div class="panel-body">
                    <form class="row" method="post" action="<?=base_url('dashboard/expenses/saveSetup')?>">
                        <div class="form-group col-md-12">
                            <label>Expenses Head</label>
                            <input type="text" name="headname" class="form-control" placeholder="Enter Expenses Name.." required>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Expenses Description</label>
                            <textarea name="headname_content" class="form-control" placeholder="Enter Expenses Description.."></textarea>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-success pull-right" name="expensesheadname" value="Save Expenses Head">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-8">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="<?=base_url('dashboard/admissions/admissionslist')?>" class="pull-right btn btn-success btn-xs"><i class="fa fa-plus"></i> Add Expenses</a>
                    </div>
                    <h4 class="panel-title">Setup Expenses List</h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-bordered table-striped" id="myTable">
                            <thead>
                                <th>Sno</th>
                                <th>Expenses Head</th>
                                <th>Description</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php $i = 1; foreach ($expenseshead as $expense){ ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=$expense->name?></td>
                                        <td><?=$expense->content?></td>
                                        <td></td>
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