<!-- Container fluid  -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Front Office</a></li>
        <li class="breadcrumb-item active">Setup</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Front office Setup <small></small></h1>
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
                    <h4 class="panel-title">Front office Setup</h4>
                </div>
                <div class="panel-body">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <!-- begin nav-tabs -->
                        <ul class="nav nav-tabs">
                            <li class="nav-items">
                                <a href="#default-tab-1" data-toggle="tab" class="nav-link active show">
                                    <span class="d-sm-none">Visiter</span>
                                    <span class="d-sm-block d-none">Visiter Setup</span>
                                </a>
                            </li>
                            <!--<li class="nav-items">
                                <a href="#default-tab-2" data-toggle="tab" class="nav-link">
                                    <span class="d-sm-none">Tab 2</span>
                                    <span class="d-sm-block d-none">Default Tab 2</span>
                                </a>
                            </li>
                            <li class="nav-items">
                                <a href="#default-tab-3" data-toggle="tab" class="nav-link">
                                    <span class="d-sm-none">Tab 3</span>
                                    <span class="d-sm-block d-none">Default Tab 3</span>
                                </a>
                            </li>-->
                        </ul>
                        <!-- end nav-tabs -->
                        <!-- begin tab-content -->
                        <div class="tab-content">
                            <!-- begin tab-pane -->
                            <div class="tab-pane fade active show" id="default-tab-1">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="panel panel-inverse">
                                                <div class="panel-heading">
                                                    <div class="panel-heading-btn">
                                                    </div>
                                                    <h4 class="panel-title">Visiters Setup</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <form method="post" action="<?=base_url('dashboard/setupfrontoffice/visiters/add')?>">
                                                        <div class="form-group col-md-12">
                                                            <label>Enter Visiter Perpose</label>
                                                            <input type="text" placeholder="Enter Vister Perpose Type" required name="visiterperposetype" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label>Comment / Information</label>
                                                            <textarea placeholder="Type Information..." name="visiterperposenote" class="form-control"></textarea>
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <input type="submit" value="Save Data" name="submitperpose" class="btn btn-success pull-right">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-7">
                                            <div class="panel panel-inverse">
                                                <div class="panel-heading">
                                                    <div class="panel-heading-btn">
                                                    </div>
                                                    <h4 class="panel-title">Visiters Setup</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <?php if(count($visiters) != 0){ ?>
                                                        <table id="myTable" class="table table-bordered table-striped">
                                                            <thead>
                                                            <tr>
                                                                <th>SNo</th>
                                                                <th>name</th>
                                                                <th>note</th>
                                                                <th class="text-center"></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php $i=1; foreach ($visiters as $visiter) { ?>
                                                                <tr>
                                                                    <td><?=$i++;?></td>
                                                                    <td><?=$visiter->name?></td>
                                                                    <td><?=$visiter->note?></td>
                                                                    <td align="center">
                                                                        <a href="javascript:;" data-toggle="modal" data-target="#EditFrontofficevisiter<?=$visiter->sno?>" data-backdrop="static" data-keyboard="false" class="font-20"><i class="fa fa-edit fa-dx"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <!-- Modal -->
                                                                <div id="EditFrontofficevisiter<?=$visiter->sno?>" class="modal fade" role="dialog">
                                                                    <div class="modal-dialog modal-md">

                                                                        <!-- Modal content-->
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Edit : <?=$visiter->name?></h4>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <form method="post" action="<?=base_url('dashboard/setupfrontoffice/edit/'.$visiter->sno);?>">
                                                                                        <div class="form-group col-md-12">
                                                                                            <label>Enter Visiter Perpose</label>
                                                                                            <input type="text" placeholder="Enter Vister Perpose Type" required value="<?=$visiter->name?>" name="visiterperposetype" class="form-control">
                                                                                        </div>
                                                                                        <div class="form-group col-md-12">
                                                                                            <label>Comment / Information</label>
                                                                                            <textarea placeholder="Type Information..." name="visiterperposenote" class="form-control"><?=$visiter->note?></textarea>
                                                                                        </div>
                                                                                        <div class="form-group col-md-12">
                                                                                            <input type="submit" value="Edit Data" name="submitEditperpose" class="btn btn-success pull-right">
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
                                </div>
                            </div>
                            <!-- end tab-pane -->
                            <!-- begin tab-pane -->
                            <div class="tab-pane fade" id="default-tab-2">
                                <blockquote>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    <small>Someone famous in <cite title="Source Title">Source Title</cite></small>
                                </blockquote>
                                <h4>Lorem ipsum dolor sit amet</h4>
                                <p>
                                    Nullam ac sapien justo. Nam augue mauris, malesuada non magna sed, feugiat blandit ligula.
                                    In tristique tincidunt purus id iaculis. Pellentesque volutpat tortor a mauris convallis,
                                    sit amet scelerisque lectus adipiscing.
                                </p>
                            </div>
                            <!-- end tab-pane -->
                            <!-- begin tab-pane -->
                            <div class="tab-pane fade" id="default-tab-3">
                                <p>
								<span class="fa-stack fa-4x pull-left m-r-10">
									<i class="fa fa-square-o fa-stack-2x"></i>
									<i class="fab fa-twitter fa-stack-1x"></i>
								</span>
                                    Praesent tincidunt nulla ut elit vestibulum viverra. Sed placerat magna eget eros accumsan elementum.
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam quis lobortis neque.
                                    Maecenas justo odio, bibendum fringilla quam nec, commodo rutrum quam.
                                    Donec cursus erat in lacus congue sodales. Nunc bibendum id augue sit amet placerat.
                                    Quisque et quam id felis tempus volutpat at at diam. Vivamus ac diam turpis.Sed at lacinia augue.
                                    Nulla facilisi. Fusce at erat suscipit, dapibus elit quis, luctus nulla.
                                    Quisque adipiscing dui nec orci fermentum blandit.
                                    Sed at lacinia augue. Nulla facilisi. Fusce at erat suscipit, dapibus elit quis, luctus nulla.
                                    Quisque adipiscing dui nec orci fermentum blandit.
                                </p>
                            </div>
                            <!-- end tab-pane -->
                        </div>
                        <!-- end tab-content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->