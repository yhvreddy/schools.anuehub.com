<!-- Container fluid  -->
<div class="container-fluid">
    <!-- Bread crumb and right sidebar toggle -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?= $this->uri->segment(5); ?> Branch Details</h3>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Branchs</a></li>
                    <li class="breadcrumb-item active">Branch Details</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Registered Branch Details : <?= $this->uri->segment(5); ?></h4>
                    <div class="col-md-12">
                        <?php //print_r($reg);
                            if(count($regusers) != 0){ ?>
                                <?php 
                                    $regusers = $regusers['0']; 
                                    $schoolinfo = $schoolinfo['0'];
                                    //print_r($schoolinfo);
                                ?>
                                    <div class="row">
                                        <h4 class="col-12 text-success">Register user Details</h4>
                                        <div class="col-md-3 form-group">
                                            <label class="font-weight-bold text-info">Register id : </label>
                                            <span><?= $regusers->reg_id?></span>
                                        </div>
                                        <div class="col-md-5 form-group">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label class="font-weight-bold text-info">Type : </label>
                                                    <span><?= $regusers->scl_mode?></span>
                                                </div>
                                                <?php if($regusers->gbsid != ''){ ?>
                                                    <div class="col-8">
                                                        <label class="font-weight-bold text-info">Branch Of  : </label>
                                                        <span><?= $regusers->gbsid?></span>  
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">First Names : </label>
                                            <span><?= $regusers->fname?></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">Last Name : </label>
                                            <span><?= $regusers->lname?></span>
                                        </div>
                                        <div class="col-md-5 form-group">
                                            <label class="font-weight-bold text-info">Reg Mail : </label>
                                            <span><?= $regusers->mailid?></span>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label class="font-weight-bold text-info">Reg Mobile : </label>
                                            <span><?= $regusers->mobile?></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">Country : </label>
                                            <span><?php $country = $this->Model_dashboard->selectdata('sms_countries',array('id'=>$regusers->country_id)); echo $country['0']->name; ?></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">State : </label>
                                            <span><?php $state = $this->Model_dashboard->selectdata('sms_states',array('id'=>$regusers->state_id)); echo $state['0']->name; ?></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">City or Dist : </label>
                                            <span><?php $citydist = $this->Model_dashboard->selectdata('sms_cities',array('id'=>$regusers->city_id)); echo $citydist['0']->name; ?></span>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <label class="font-weight-bold text-info">Address : </label>
                                            <span><?= $regusers->address?></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">Pincode : </label>
                                            <span><?= $regusers->pincode?></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">Aadhaar No : </label>
                                            <span><?= $regusers->aadhaar?></span>
                                        </div>
                                    </div>
                                <?php if(empty($schoolinfo) or $schoolinfo == ""){ ?>
                                    <div class="row">
                                        <h3 class="col-12 text-center">No Data Found (or) School Details Are Not Entered.</h3>
                                    </div>
                                <?php }else{ ?>
                                    <div class="row">
                                        <h4 class="col-12 text-warning">School Details</h4>
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">Register id : </label>
                                            <span><?= $schoolinfo->reg_id?></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">School id : </label>
                                            <span><?= $schoolinfo->school_id?></span>
                                        </div>
                                        <?php if($schoolinfo->scltype == 'GSB'){ ?>
                                            <div class="col-md-4 form-group">
                                                <label class="font-weight-bold text-info">Branch id : </label>
                                                <span><?= $schoolinfo->branch_id?></span>
                                            </div>
                                        <?php } ?>
                                            
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">Type : </label>
                                            <span><?= $schoolinfo->scltype?></span>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <label class="font-weight-bold text-info">School name : </label>
                                            <span><?= $schoolinfo->schoolname?></span>
                                        </div>
                                        <?php if($schoolinfo->scltype == 'GSB'){ ?>
                                            <div class="col-md-4 form-group">
                                                <label class="font-weight-bold text-info">Branch : </label>
                                                <span><?= $schoolinfo->branchname?></span>
                                            </div>
                                        <?php }  ?>
                                        <div class="col-md-5 form-group">
                                            <label class="font-weight-bold text-info">Mail Id : </label>
                                            <span><?= $schoolinfo->school_mail?></span>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label class="font-weight-bold text-info">Mobile : </label>
                                            <span><?= $schoolinfo->school_mobile?></span>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label class="font-weight-bold text-info">Alter Number : </label>
                                            <span><?= $schoolinfo->school_phone?></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">Country : </label>
                                            <span><?php $country = $this->Model_dashboard->selectdata('sms_countries',array('id'=>$schoolinfo->country_id)); echo $country['0']->name; ?></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">State : </label>
                                            <span><?php $state = $this->Model_dashboard->selectdata('sms_states',array('id'=>$schoolinfo->state_id)); echo $state['0']->name; ?></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">City or Dist : </label>
                                            <span><?php $citydist = $this->Model_dashboard->selectdata('sms_cities',array('id'=>$schoolinfo->city_id)); echo $citydist['0']->name; ?></span>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <label class="font-weight-bold text-info">Address : </label>
                                            <span><?= $schoolinfo->school_address?></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">Pincode : </label>
                                            <span><?= $schoolinfo->school_pincode?></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="font-weight-bold text-info">School Reg id : </label>
                                            <span><?= $schoolinfo->school_tinnumber?></span>
                                        </div>
                                    </div>
                                <?php } ?>
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