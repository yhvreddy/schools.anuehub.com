<!-- Container fluid  -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Front Office</a></li>
        <li class="breadcrumb-item active">eNote</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">eNote <small>.</small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:void(0);" class="pull-right btn btn-success btn-xs" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#NeweNote"><i class="fa fa-plus"></i> New eNote</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">eNote list</h4>
                </div>
                <div class="panel-body">

                    <!-- eNote Model start-->
                    <div id="NeweNote" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content" style="top:20px">
                                <div class="modal-header">
                                    <h4 class="modal-title">New eNote</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method="post" class="floating-labels" action="<?=base_url('dashboard/enote/savenewenote')?>">
                                                <div class="row mt-3">
                                                    <div class="form-group col-md-3">
                                                        <label for="eNoteDate">Select Date</label>
                                                        <input type="text" required id="eNoteDate" class="text-black form-control mydatepicker text-black" placeholder="Pick Date"  name="eNoteDate">
                                                    </div>

                                                    <div class="form-group col-md-5">
                                                        <label for="eNoteStudentName">Enter Student Name</label>
                                                        <input class="form-control text-black" type="text" id="eNoteStudentName" name="eNoteStudentName" placeholder="Student Name" required>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="eNoteParentName">Parent or Gardien Name</label>
                                                        <input class="form-control text-black" type="text" name="eNoteParentName" id="eNoteParentName" placeholder="Parent or Gardien Name" required>
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="sclsyllabuslist">Student Syllabus</label>
                                                        <select type="text" name="eNoteSyllubas" name="eNoteSyllubas" id="sclsyllubaslist" class="form-control text-black" style="padding:0px">
                                                            <option value="">Select Syllabus</option>
                                                            <?php foreach ($syllabus as $key => $value) { ?>
                                                                <option value="<?= $key ?>"><?= $value ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="SyllabusClasses">Student Class</label>
                                                        <select type="text" name="eNoteClasses" id="SyllabusClasses" class="form-control text-black" disabled="" style="padding:0px 10px">
                                                            <option value="">Select Class</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-5">
                                                        <label for="eNoteEmail">Enter eMail id</label>
                                                        <input class="form-control text-black" type="email" id="eNoteEmail" name="eNoteEmail" placeholder="Enter email" required>
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="eNoteMobile">Enter Mobile Number</label>
                                                        <input class="form-control text-black" type="tel" maxlength="10" name="eNoteMobile" placeholder="Enter Mobile Number" id="eNoteMobile" required>
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <label for="eNoteMobile">eNote Content</label>
                                                        <textarea class="text-black" style="width:100%" id="NeweNote" rows="15" type="text" placeholder="Type eNote content.." name="eNoteContent" required></textarea>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <input type="reset" class="btn btn-warning pull-left" value="Reset eNote" name="CleareNote">
                                                        <input type="submit" class="btn btn-success pull-right" value="Save eNote" name="saveNote">
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
                    <script>
                        CKEDITOR.replace( 'eNoteContent', {
                            customConfig: 'custom/paper.js'
                        });
                    </script>

                    <div class="col-md-12">
                        <?php if(count($eNotelist) != 0){ ?>
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Sno</th>
                                    <th>eNote Date</th>
                                    <th>Student Name</th>
                                    <th>Father / Gardien</th>
                                    <th>Class</th>
                                    <th>mobile</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <?php $i=1; foreach ($eNotelist as $value) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= date('d-m-Y',strtotime($value->enotedate)) ?></td>
                                        <td><?= $value->studentname ?></td>
                                        <td><?= $value->parentname ?></td>
                                        <td><?= $value->class ?></td>
                                        <td><?= $value->mobile ?></td>
                                        <td class="text-center">
											<a href="javascript:void(0);" data-toggle="modal" data-target="#editenote_<?= $value->id ?>" data-backdrop="static" data-keyboard="false" class=""><i class="fa fa-edit fa-dx"></i></a> &nbsp;&nbsp;
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#viewenote_<?= $value->id ?>" data-backdrop="static" data-keyboard="false" class=""><i class="fa fa-file-o fa-dx"></i></a> &nbsp;&nbsp;
											<a href="javascript:void(0);" data-toggle="modal" data-target="#viewenote_<?= $value->id ?>" data-backdrop="static" data-keyboard="false" class=""><i class="fa fa-trash-o fa-dx"></i></a>
											&nbsp;
                                        </td>
                                        <!-- Modal view eNote-->
                                        <div id="viewenote_<?= $value->id ?>" class="modal fade" role="dialog">
                                            <div class="modal-dialog modal-lg" style="top:80px">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><?= 'eNote - '.$value->enotedate.' : '.$value->studentname ?></h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="<?=base_url()?>dashboard/enote/resend">
                                                            <div class="row">
                                                                <div class="col-md-3 m-b-5">
                                                                    <b>Date : </b>
                                                                    <?= date('d-m-Y',strtotime($value->enotedate)) ?>
                                                                </div>
                                                                <div class="col-md-5 m-b-5">
                                                                    <b>Student Name : </b>
                                                                    <?= $value->studentname ?>
                                                                </div>
                                                                <div class="col-md-4 m-b-5">
                                                                    <b>Parent Name : </b>
                                                                    <?= $value->parentname ?>
                                                                </div>
                                                                <div class="col-md-3 m-b-5">
                                                                    <b>Class : </b>
                                                                    <?= $value->class ?>
                                                                </div>

                                                                <div class="col-md-5 m-b-5">
                                                                    <b>Email : </b>
                                                                    <?= $value->email ?>
                                                                </div>
                                                                <div class="col-md-4 m-b-5">
                                                                    <b>Mobile : </b>
                                                                    <?= $value->mobile ?>
                                                                </div>
                                                                <div class="col-md-12 m-b-5">
                                                                    <b>eNote  : </b>
                                                                    <div class="col-md-12"><?= $value->enote ?></div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <?php //print_r($value); ?>
                                                                <input type="hidden" name="regeNote" value="<?= $value->id; ?>">
                                                                <div class="col-md-12">
                                                                    <h4><i class="mdi mdi-email font-20"></i> Send eNote </h4>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-6">
                                                                            <label>School Mail id</label>
                                                                            <input type="email" placeholder="Enter School email" name="schoolmail" required="required" class="form-control" style="width:100%" value="<?=$schooldata->school_mail?>" />
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label>Parent Mailid</label>
                                                                            <input class="form-control" type="email" placeholder="Enter Parent email" name="parentmail" value="<?=$value->email;?>" required style="width:100%">
                                                                        </div>
                                                                        <div class="col-md-12" style="margin:10px 0px 0px 0px">
                                                                            <input type="submit" class="btn btn-success pull-right" value="resend mail" name="resendmail">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- End eNote view -->
                                        
                                        <!-- edit eNote Model start-->
                                        <div id="editenote_<?= $value->id; ?>" class="modal fade" role="dialog">
                                            <div class="modal-dialog modal-lg">

                                                <!-- Modal content-->
                                                <div class="modal-content" style="top:20px">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit eNote : <?= $value->studentname; ?></h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <form method="post" class="floating-labels" action="<?=base_url('dashboard/enote/editenote/')?>">
                                                                    <div class="row mt-3">
                                                                        <div class="form-group col-md-3">
                                                                            <label for="eNoteDate">Select Date</label>
                                                                            <input type="text" required id="eNoteDate" class="text-black form-control mydatepicker text-black" placeholder="Pick Date" value="<?= date('m/d/Y',strtotime($value->enotedate)) ?>"  name="eNoteDate">
                                                                        </div>

                                                                        <div class="form-group col-md-5">
                                                                            <label for="eNoteStudentName">Enter Student Name</label>
                                                                            <input class="form-control text-black" type="text" id="eNoteStudentName" name="eNoteStudentName" placeholder="Student Name" required value="<?= $value->studentname ?>">
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label for="eNoteParentName">Parent or Gardien Name</label>
                                                                            <input class="form-control text-black" type="text" name="eNoteParentName" id="eNoteParentName" placeholder="Parent or Gardien Name" required value="<?= $value->parentname ?>">
                                                                        </div>

                                                                        <div class="form-group col-md-3">
                                                                            <label for="sclsyllabuslist">Student Syllabus</label>
                                                                            <select type="text" name="eNoteSyllubas" name="eNoteSyllubas" id="sclsyllubaslist" class="form-control text-black" style="padding:0px">
                                                                                <option value="">Select Syllabus</option>
                                                                                <?php foreach ($syllabus as $key => $value) { ?>
                                                                                    <option value="<?= $key ?>"><?= $value ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label for="SyllabusClasses">Student Class</label>
                                                                            <select type="text" name="eNoteClasses" id="SyllabusClasses" class="form-control text-black" disabled="" style="padding:0px 10px">
                                                                                <option value="">Select Class</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group col-md-5">
                                                                            <label for="eNoteEmail">Enter eMail id</label>
                                                                            <input class="form-control text-black" type="email" id="eNoteEmail" name="eNoteEmail" placeholder="Enter email" required>
                                                                        </div>

                                                                        <div class="form-group col-md-4">
                                                                            <label for="eNoteMobile">Enter Mobile Number</label>
                                                                            <input class="form-control text-black" type="tel" maxlength="10" name="eNoteMobile" placeholder="Enter Mobile Number" id="eNoteMobile" required>
                                                                        </div>

                                                                        <div class="form-group col-md-12">
                                                                            <label for="eNoteMobile">eNote Content</label>
                                                                            <textarea class="text-black" style="width:100%" id="NeweNote" rows="15" type="text" placeholder="Type eNote content.." name="editNoteContent" required></textarea>
                                                                        </div>
                                                                        
                                                                        <script>
                                                                            CKEDITOR.replace( 'editNoteContent', {
                                                                                customConfig: 'custom/paper.js'
                                                                            });
                                                                        </script>
                                                                        
                                                                        <div class="col-md-12">
                                                                            <input type="submit" class="btn btn-success pull-right" value="Update eNote" name="updateNote">
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- edit eNote Model end-->
                                    </tr>
                                <?php $i++; } ?>
                                <tbody>

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
