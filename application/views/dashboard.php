<!-- begin #content -->
<?php
    $sessiondata = $this->session->userdata;
    $currentdate = date('Y-m-d');
    error_reporting(0);
?>
<!-- ================== BEGIN PAGE CSS ================== -->
<link href="<?=base_url()?>assets/plugins/nvd3/build/nv.d3.css" rel="stylesheet" />
<!-- ================== END PAGE CSS ================== -->
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/bracking_alerts/breaking-news-ticker.css">
<script src="<?=base_url()?>assets/plugins/bracking_alerts/breaking-news-ticker.min.js"></script>
<style>
	.widget.widget-stats { padding: 10px; }
	.widget-stats .stats-number { font-size: 16px; margin-bottom: 8px; }
	.widget-stats .stats-progress { margin-bottom: 10px; }
</style>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Dashboard<small></small></h1>
    <!-- end page-header -->
    
    <?php if(($sessiondata['type'] === 'admin' && !empty($sessiondata['type'])) || ($sessiondata['type'] === 'superadmin' && !empty($sessiondata['type']))){ 
        $events   =  $this->Model_dashboard->selectdata('sms_events',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));
        $notices = $this->Model_dashboard->selectdata('sms_notice',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1),'sno');
        $admissions = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1),'sno');
        $employees = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1),'sno');
    ?>
        <!-- begin row -->
        <div class="row">
            <!-- begin col-3 -->
            <?php
                $visiters = $this->Model_dashboard->selectdata('sms_visiters_data',array('school_id'=>$school_id,'branch_id'=>$branch_id,'DATE(created)'=>$currentdate,'status'=>1));
                $totalvisiters = $this->Model_dashboard->selectdata('sms_visiters_data',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));
                @$persentvisiters = count($visiters) / count($totalvisiters) * 100;
                @$totalpercentage = count($totalvisiters) / count($totalvisiters) * 100;
            ?>
            <div class="col-lg-3 col-md-6">
                <div class="widget widget-stats bg-gradient-teal">
                    <div class="stats-icon stats-icon-lg" style="font-size: 65px;width: auto;"><i class="fa fa-user fa-fw"></i></div>
                    <div class="stats-content">
                        <div class="stats-title">TODAY'S / TOTAL VISITS</div>
                        <div class="stats-number"><?=count($visiters).' / '.count($totalvisiters);?></div>
                        <div class="stats-progress progress">
                            <div class="progress-bar" style="width: <?=$persentvisiters?>%;"></div>
                        </div>
                        <div class="stats-desc">Total Visiters List ( <?=count($totalvisiters)?> )</div>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <?php
                $enquiry = $this->Model_dashboard->selectdata('sms_enquiry',array('school_id'=>$school_id,'branch_id'=>$branch_id,'DATE(created)'=>$currentdate,'status'=>1));
                $totalenquiry = $this->Model_dashboard->selectdata('sms_enquiry',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));
                @$percentage_enquiry = count($enquiry) / count($totalenquiry) * 100;
            ?>
            <div class="col-lg-3 col-md-6">
                <div class="widget widget-stats bg-gradient-blue">
                    <div class="stats-icon stats-icon-lg" style="font-size: 65px;width: auto;"><i class="fa fa-users fa-fw"></i></div>
                    <div class="stats-content">
                        <div class="stats-title">TODAY'S / TOTAL ENQUIRY'S</div>
                        <div class="stats-number"><?=count($enquiry).' / '.count($totalenquiry)?></div>
                        <div class="stats-progress progress">
                            <div class="progress-bar" style="width:<?=$percentage_enquiry?>%;"></div>
                        </div>
                        <div class="stats-desc">Total Enquiry List (<?=count($totalenquiry)?>)</div>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <?php
                $admission = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$school_id,'branch_id'=>$branch_id,'DATE(created)'=>$currentdate,'status'=>1));
                $totaladmission = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));
                @$percentage_admission = count($admission) / count($totaladmission) * 100;
            ?>
            <div class="col-lg-3 col-md-6">
                <div class="widget widget-stats bg-gradient-purple">
                    <div class="stats-icon stats-icon-lg" style="font-size: 65px;width: auto;"><i class="fa fa-users fa-fw"></i></div>
                    <div class="stats-content">
                        <div class="stats-title">TODAY'S / TOTAL ADMISSION'S</div>
                        <div class="stats-number"><?= count($admission).' / '. count($totaladmission)?></div>
                        <div class="stats-progress progress">
                            <div class="progress-bar" style="width: <?=$percentage_admission?>%;"></div>
                        </div>
                        <div class="stats-desc">Total Admission List ( <?=count($totaladmission)?> )</div>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <?php
                $employee = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));
                $totalemployee = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));
                @$percentage_employee = count($employee) / count($totalemployee) * 100;
            ?>
            <div class="col-lg-3 col-md-6">
                <div class="widget widget-stats bg-gradient-black">
                    <div class="stats-icon stats-icon-lg" style="font-size: 65px;width: auto;"><i class="fa fa-users fa-fw"></i></div>
                    <div class="stats-content">
                        <div class="stats-title">TOTAL EMPLOYEE'S</div>
                        <div class="stats-number"><?=count($employee)?></div>
                        <div class="stats-progress progress">
                            <div class="progress-bar" style="width: <?=$percentage_employee?>%;"></div>
                        </div>
                        <div class="stats-desc">Total Employee's List (<?=count($totalemployee)?>)</div>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
        </div>
        <!-- end row -->
		<!-- begin row -->
		<div class="row">
            <?php
                //total fee list
                $totalfeelist = $this->Model_default->manualselect("SELECT * FROM `sms_admissions` WHERE school_id = '$school_id' AND branch_id = '$branch_id'");
                foreach ($totalfeelist as $value){
                    $totalfeeamount	+=	$value->totalfee;
                }
                //total day paid amount
                $totalpaidfeelist = $this->Model_default->manualselect("SELECT * FROM `sms_feelist` WHERE school_id = '$school_id' AND branch_id = '$branch_id' AND created like '%".date('Y-m-d')."%'");
                foreach ($totalpaidfeelist as $value){
                    $todayspaidfee += $value->paidfee;
                }
                //Total paid
                $totalfeepaidlist = $this->Model_default->manualselect("SELECT * FROM `sms_feelist` WHERE school_id = '$school_id' AND branch_id = '$branch_id'");
                foreach ($totalfeepaidlist as $value){
                    $totalpaidamount += $value->paidfee;
                }
            ?>
			<!-- begin col-8 -->
			<div class="col-lg-9">
				<!-- begin widget-chart -->
				<div class="widget widget-rounded m-b-30" data-id="widget">
					<!-- begin widget-header -->
					<div class="widget-header">
						<h4 class="widget-header-title">Complete Statistics Overview</h4>
					</div>
					<!-- end widget-header -->
					<!-- begin vertical-box -->
					<div class="vertical-box with-grid with-border-top">
						<!-- begin vertical-box-column -->
						<div class="vertical-box-column widget-chart-content">
							<div id="nv-stacked-area-chart" style="height: 108%"></div>
						</div>
						<!-- end vertical-box-column -->
						<!-- begin vertical-box-column -->
						<div class="vertical-box-column p-15" style="width: 30%;">
							<div class="widget-chart-info">
								<h4 class="widget-chart-info-title">Total Fee payments</h4>
								<p class="widget-chart-info-desc">Total fee payments paid by all students in this academic year.</p>
								<div class="widget-chart-info-progress">
									<b>Paid amount</b>
                                    <?php $totalpercentage	=	$totalpaidamount/$totalfeeamount*100; ?>
									<span class="pull-right"><?=round($totalpercentage,1)?>%</span>
								</div>
								<div class="progress progress-sm">
									<div class="progress-bar progress-bar-striped progress-bar-animated rounded-corner" style="width:<?=round($totalpercentage,1)?>%;"></div>
								</div>
							</div>
							<hr />
							<div class="widget-chart-info">
								<h4 class="widget-chart-info-title">Total salary paid.</h4>
								<p class="widget-chart-info-desc">Total salary paid on this month for employees.</p>
								<div class="widget-chart-info-progress">
									<b>Salary paid amount</b>
									<span class="pull-right">15%</span>
								</div>
								<div class="progress progress-sm m-b-15">
									<div class="progress-bar progress-bar-striped progress-bar-animated rounded-corner bg-orange" style="width: 15%"></div>
								</div>
								<div class="widget-chart-info-progress">
									<b>Expenses amount</b>
									<span class="pull-right">5%</span>
								</div>
								<div class="progress progress-sm m-b-15">
									<div class="progress-bar progress-bar-striped progress-bar-animated rounded-corner bg-green" style="width: 5%"></div>
								</div>
								<div class="widget-chart-info-progress">
									<b>Website Redesign</b>
									<span class="pull-right">95%</span>
								</div>
								<div class="progress progress-sm">
									<div class="progress-bar progress-bar-striped progress-bar-animated rounded-corner bg-success" style="width: 95%"></div>
								</div>
							</div>
						</div>
						<!-- end vertical-box-column -->
					</div>
					<!-- end vertical-box -->
				</div>
				<!-- end widget-chart -->
			</div>
			<!-- end col-8 -->
			<!-- begin col-4 -->
			<div class="col-lg-3">
				<div class="row row-space-10 m-b-20">
					<!-- begin col-4 -->
					<div class="col-lg-12">
						<div class="widget widget-stats bg-gradient-teal m-b-10">
							<div class="stats-icon stats-icon-lg" style="font-size: 65px;width: auto;"><i style="transform:rotate(90deg);webkit-transform:rotate(90deg);" class="fa fa-exchange fa-fw"></i></div>
							<div class="stats-content">
								<div class="stats-title text-uppercase">Total Fee Amount</div>
								<div class="stats-number"><?=number_format($totalfeeamount, 2)?></div>
								<div class="stats-progress progress">
									<div class="progress-bar" style="width: 100%;"></div>
								</div>
								<div class="stats-desc">Total Admission Fee (100%)</div>
							</div>
						</div>
					</div>
					<!-- end col-4 -->

					<!-- begin col-4 -->
					<div class="col-lg-12">
						<div class="widget widget-stats bg-gradient-purple m-b-10">
							<div class="stats-icon stats-icon-lg" style="font-size: 65px;width: auto;"><i class="fa fa-sort-amount-asc fa-fw"></i></div>
							<div class="stats-content">
								<?php
									$dueamount = $totalfeeamount - $totalpaidamount;
									$totalduepercent = $dueamount/$totalfeeamount*100;
								?>
								<div class="stats-title text-uppercase">Total Balance Due Amount</div>
								<div class="stats-number"><?=number_format($dueamount,2)?></div>
								<div class="stats-progress progress">
									<div class="progress-bar" style="width: <?=round($totalduepercent,1)?>% !important;"></div>
								</div>
								<div class="stats-desc">Total Due Amount (<?=round($totalduepercent,1)?>%)</div>
							</div>
						</div>
					</div>
					<!-- end col-4 -->

					<!-- begin col-4 -->
					<div class="col-lg-12">
						<div class="widget widget-stats bg-gradient-blue m-b-10">
							<div class="stats-icon stats-icon-lg" style="font-size: 65px;width: auto;"><i class="fa fa-dollar-sign fa-fw"></i></div>
							<div class="stats-content">
								<?php $todayspercentage	=	$todayspaidfee/$dueamount*100; ?>
								<div class="stats-title">TODAY'S PAYMENT</div>
								<div class="stats-number"><?=number_format($todayspaidfee,2)?></div>
								<div class="stats-progress progress">
									<div class="progress-bar" style="width: <?=round($todayspercentage,1)?>%;"></div>
								</div>
								<div class="stats-desc">Today's paid amount (<?=round($todayspercentage,1)?>%)</div>
							</div>
						</div>
					</div>
					<!-- end col-4 -->

					<!-- begin col-4 -->
					<div class="col-lg-12">
						<div class="widget widget-stats bg-gradient-black m-b-10">
							<div class="stats-icon stats-icon-lg" style="font-size: 65px;width: auto;"><i class="fa fa-sort-amount-desc fa-fw"></i></div>
							<div class="stats-content">
								<?php $totalpercentage	=	$totalpaidamount/$totalfeeamount*100; ?>
								<div class="stats-title text-uppercase">Total Paid Amount</div>
								<div class="stats-number"><?=number_format($totalpaidamount,2)?></div>
								<div class="stats-progress progress">
									<div class="progress-bar" style="width:<?=round($totalpercentage,1)?>%;"></div>
								</div>
								<div class="stats-desc">Total Paid Amount (<?=round($totalpercentage,1)?>%)</div>
							</div>
						</div>
					</div>
					<!-- end col-4 -->
				</div>
			</div>
			<!-- end col-4 -->
		</div>
		<!-- end row -->
		<?php
			$calenerdata = array();
			$tablesdata = array_merge($events,$admissions,$employees);
			foreach ($tablesdata as $key => $value){
				if(isset($tablesdata[$key]->start) && isset($tablesdata[$key]->end)){
					$starting = $tablesdata[$key]->start;
					$type = 'event';
					$titlename = $tablesdata[$key]->title;
					$ending = $tablesdata[$key]->end;
					$snum =	 $tablesdata[$key]->sno;
					$color = $tablesdata[$key]->color;
					$contant = $tablesdata[$key]->contant;
					$repertdata = '';
				}

				if(isset($tablesdata[$key]->dob)){
					$starting = date('Y-m-d',strtotime($tablesdata[$key]->dob)).' 00:00:00';
					$ending = date('Y-m-d',strtotime($tablesdata[$key]->dob)).' 00:00:00';
					$titlename = $tablesdata[$key]->firstname.'.'.$tablesdata[$key]->lastname;
					if(isset($tablesdata[$key]->usermode)){
						$type = $tablesdata[$key]->usermode;
						$color = '#9C13AC';
					}else if(isset($tablesdata[$key]->employeetype)){
						$type = $tablesdata[$key]->employeetype.' - '.$tablesdata[$key]->emoloyeeposition;
						$color = '#A4E600';
					}
					$snum =	 $tablesdata[$key]->sno;

					$contant = 'Happy Birthday '.$titlename;
					$repertdata = date('Y').'-'.date('m-d',strtotime($tablesdata[$key]->dob));
				}

				$calenerdata[] = array('start' => $starting,'end'=>$ending,'title'=>$titlename,'type'=>$type,'sno'=>$snum,'color'=>$color,'contant'=>$contant,'repertdate'=>$repertdata);
			}
		 	 $r = 1; $presentmonth = date('d-m-Y'); 
            foreach ($calenerdata as $key => $calenderdata){
                $start = explode(" ", $calenerdata[$key]['start']);
                $end = explode(" ", $calenerdata[$key]['end']);
                if($start[1] == '00:00:00'){
                    $start = $start[0];
                    $start_date		=	date('j',strtotime($start));
                    $start_month	=	date('n',strtotime($start));
                    $start_year		=	date('Y',strtotime($start));
                }else{
                    $start = $calenerdata[$key]['start'];
                    $start_date		=	date('j',strtotime($start));
                    $start_month	=	date('n',strtotime($start));
                    $start_year		=	date('Y',strtotime($start));
                }
                $types		=	$calenerdata[$key]['type'];
                $info		=	$calenerdata[$key]['contant'];
                $title		=	$calenerdata[$key]['title'];
                if($presentmonth === date('d-m-Y',strtotime($start))){
                    if(empty($info) && $info == ''){
                        $info = 'To Day : No Events Founds';
                    }
                    if(empty($title) && $title == ''){
                        $info = 'To Day : No Events Founds';
                    }
                    $todayevents[] =  array('start' => $start,'title'=>$title,'type'=>$type,'contant'=>$info);
                } ?>
		<?php } ?>
		<!-- begin row -->
		<div class="row">
			<!-- begin col-4 -->
			<?php
				$notifications = $this->Model_default->manualselect("SELECT * FROM `sms_notice` WHERE (school_id = '$school_id' AND branch_id = '$branch_id') AND status = '1' ORDER by sno DESC limit 5");
			?>
			<div class="col-lg-4">
				<!-- begin panel -->
				<div class="panel panel-inverse" data-sortable-id="index-2">
					<div class="panel-heading">
						<h4 class="panel-title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> &nbsp; Notification's </h4>
					</div>
					<div class="panel-body bg-silver p-0">
						<div class="widget-todolist" data-id="widget">
							<!-- begin widget-todolist-body -->
							<div class="widget-todolist-body mb-0">
								<?php if(count($notifications) != 0){ ?>
									<?php foreach ($notifications as $notification){ ?>
										<!-- begin widget-todolist-item -->
										<a href="<?=base_url('dashboard/notice/'.$notification->sno)?>/?id=<?=$notification->id_num?>" style="text-decoration: none">
											<div class="widget-list-item">
												<div class="widget-list-media">
												<?php if (!empty($notification->notice_img)){ ?>
													<img src="<?=base_url($notification->notice_img)?>" alt="" class="rounded" style="width: 100%">
												<?php }else{ ?>
													<img src="<?=base_url()?>assets/img/default_image.png" alt="" class="rounded" style="width: 100%">
												<?php } ?>
												</div>

												<div class="widget-list-content">
													<h4 class="widget-list-title"><?=$notification->notice_title?></h4>
												</div>
											</div>
										</a>
										<!-- end widget-todolist-item -->
									<?php } ?>
								<?php }else{ ?>
									<div class="">
										<?=$this->Model_dashboard->norecords();?>
									</div>
								<?php } ?>
							</div>
							<!-- end widget-todolist-body -->
						</div>
					</div>
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-4 -->
			<!-- begin col-4 -->
			<div class="col-lg-4">
				<!-- begin panel -->
				<div class="panel panel-inverse" data-sortable-id="index-3">
					<div class="panel-heading">
						<h4 class="panel-title"> <i class="fa fa-calendar"></i> &nbsp; Academic Calender</h4>
					</div>
					<div id="ScheduleAcademicCalendar" class="bootstrap-calendar"></div>
					<div class="list-group">
						           <?php //echo "<pre>"; print_r($todayevents); echo "</pre>"; ?>

								<div class="breaking-news-ticker" id="newsTicker11" style="border: solid 1px #f6f6f6;">
									<div class="bn-news">
										<ul>

											<?php foreach ($todayevents as $key => $todayevent){ ?>
												<?php if(!empty($todayevent['title'])){ ?>
													<li><a href="javascript:;" class="text-blue">Today Event : <?=$todayevent['title']?></a></li>
												<?php }else{ ?>
                                                    <li><a href="javascript:;" class="text-success">Today Event : No Events Found..</a></li>
                                                <?php } ?>

												<?php if(!empty($todayevent['info'])){ ?>
													<li><a href="javascript:;" class="text-success">Today Event : <?php echo $todayevent['info']; ?></a></li>
												<?php  }else{ ?>
                                                    <li><a href="javascript:;" class="text-success">Today Event : No Events Found..</a></li>
                                                <?php } ?>
											<?php } ?>
										</ul>
									</div>
									<div class="bn-controls">
										<button><span class="bn-arrow bn-prev"></span></button>
										<button><span class="bn-action"></span></button>
										<button><span class="bn-arrow bn-next"></span></button>
									</div>
								</div>
							<script>
								$(document).ready(function() {
									$('#newsTicker11').breakingNews({
										effect: 'slide-up'
									});
								})
							</script>

					</div>
					<div class="list-group">
						<a href="javascript:;" class="list-group-item">
							<span class="badge f-w-500 bg-gradient-blue" style="line-height: 1.5;    border-radius: 5px;">Academic Events </span>
							<span class="badge f-w-500 bg-gradient-teal" style="line-height: 1.5;    border-radius: 5px;">Birthday Events</span>
						</a>
					</div>
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-4 -->
			<!-- begin col-4 -->
			<div class="col-lg-4">
				<!-- begin panel -->
				<div class="panel panel-inverse" data-sortable-id="index-2">
					<div class="panel-heading">
						<h4 class="panel-title"><i class="fa fa-envelope-o" aria-hidden="true"></i> &nbsp; Mail Reports </h4>
					</div>
					<div class="panel-body bg-silver p-0">
						<div class="widget-todolist" data-id="widget" style="min-height: 310px;">
							<!-- begin widget-todolist-body -->
							<div class="widget-todolist-body mb-0">
								<?php if(count($mailsents) != 0){ ?>
									<?php foreach ($mailsents as $mailsent){
										$extractdata = explode(' + ',$mailsent->information);
										$id   = $extractdata[0];
										$type = $extractdata[1];
										$userdata = $this->Model_dashboard->selectdata('sms_regusers',array('sno'=>$id,'reg_id'=>$mailsent->sender_id),'sno');
										$person = $userdata[0];
										$from = 'admin';
										$fname = $person->fname;
										$lname = $person->lname;
										?>
										<!-- begin widget-todolist-item -->
										<a href="<?=base_url('user/mail/details/'.$mailsent->mail_ids.'/'.$mailsent->branch_id.'/'.$mailsent->school_id.'/sent-mail?id='.$mailsent->mail_id.'&inbox_id='.$mailsent->id)?>" style="text-decoration: none">
											<div class="widget-list-item">
												<div class="widget-list-media">


													<img src="<?=base_url()?>assets/img/email.png" class="fab text-white" style="width: 100%">


												</div>

												<div class="widget-list-content">
													<h4 class="widget-list-title"><?=$mailsent->subject?></h4>
												</div>
											</div>
										</a>
										<!-- end widget-todolist-item -->
									<?php } ?>
								<?php }else{ ?>
									<div class="mt-5">
										<?=$this->Model_dashboard->norecords();?>
									</div>
								<?php } ?>
							</div>
							<!-- end widget-todolist-body -->
						</div>
					</div>
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-4 -->
		</div>
		<!-- end row -->
    <?php } else if($sessiondata['type'] === 'classteacher' && !empty($sessiondata['type'])){

        $events   =  $this->Model_dashboard->selectdata('sms_events',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));

		$noticewhereconduction = "notice_to LIKE '%".$sessiondata['type']."%'";
		$conduction		 =	array('school_id'=>$school_id,'branch_id'=>$branch_id);
		$notifications =	$this->Model_dashboard->selectwithorconduction('sms_notice',$conduction,$noticewhereconduction,'sno',5);
    ?>
            <!-- begin row -->
        <div class="row">
            
            <!-- begin col-3 -->
            <?php
                $employees = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'employeetype'=>'staff','status'=>1),'sno');
    
                $employeedata = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'id_num'=>$sessiondata['regid'],'status'=>1),'sno');
                $employeedata   =   $employeedata[0];
    
                $totalemployee = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));
                @$percentage_employee = count($employees) / count($totalemployee) * 100;
    
                $admission = $this->Model_dashboard->selectdata('sms_admissions',array('school_id' => $school_id, 'branch_id' => $branch_id,'class_type' => $employeedata->employee_syllabus, 'class' => $employeedata->employeeclass,'status'=>1));//'class_type'=>$employeedata->employee_syllabus,
                $totaladmission = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));
                @$percentage_admission = count($admission) / count($totaladmission) * 100;
            ?>
            <div class="col-lg-3 col-md-6">
                <div class="widget widget-stats bg-gradient-purple">
                    <div class="stats-icon stats-icon-lg" style="font-size: 65px;width: auto;"><i class="fa fa-users fa-fw"></i></div>
                    <div class="stats-content">
                        <div class="stats-title text-uppercase"><?=$employeedata->employeeclass?> Students list </div>
                        <div class="stats-number"><?= count($admission)?> Students</div>
                        <div class="stats-progress progress">
                            <div class="progress-bar" style="width: <?=$percentage_admission?>%;"></div>
                        </div>
                        <div class="stats-desc">Total Admission List ( <?=round($percentage_admission,1)?>% )</div>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <?php //echo "<pre>"; print_r($employeedata); echo "</pre>"; ?>
            <div class="col-lg-3 col-md-6">
                <div class="widget widget-stats bg-gradient-black">
                    <div class="stats-icon stats-icon-lg" style="font-size: 65px;width: auto;"><i class="fa fa-users fa-fw"></i></div>
                    <div class="stats-content">
                        <div class="stats-title">EMPLOYEE'S</div>
                        <div class="stats-number"><?=count($employees)?> Members</div>
                        <div class="stats-progress progress">
                            <div class="progress-bar" style="width: <?=$percentage_employee?>%;"></div>
                        </div>
                        <div class="stats-desc">Total Staff List ( <?=round($percentage_employee,1)?>% )</div>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
        </div>
        <!-- end row -->
        <?php    $calenerdata = array();
			     $tablesdata = array_merge($events,$admissions,$employees);
			foreach ($tablesdata as $key => $value){
				if(isset($tablesdata[$key]->start) && isset($tablesdata[$key]->end)){
					$starting = $tablesdata[$key]->start;
					$type = 'event';
					$titlename = $tablesdata[$key]->title;
					$ending = $tablesdata[$key]->end;
					$snum =	 $tablesdata[$key]->sno;
					$color = $tablesdata[$key]->color;
					$contant = $tablesdata[$key]->contant;
					$repertdata = '';
				}

				/*if(isset($tablesdata[$key]->dob)){
					$starting = date('Y-m-d',strtotime($tablesdata[$key]->dob)).' 00:00:00';
					$ending = date('Y-m-d',strtotime($tablesdata[$key]->dob)).' 00:00:00';
					$titlename = $tablesdata[$key]->firstname.'.'.$tablesdata[$key]->lastname;
					if(isset($tablesdata[$key]->usermode)){
						$type = $tablesdata[$key]->usermode;
						$color = '#9C13AC';
					}else if(isset($tablesdata[$key]->employeetype)){
						$type = $tablesdata[$key]->employeetype.' - '.$tablesdata[$key]->emoloyeeposition;
						$color = '#A4E600';
					}
					$snum =	 $tablesdata[$key]->sno;

					$contant = 'Happy Birthday '.$titlename;
					$repertdata = date('Y').'-'.date('m-d',strtotime($tablesdata[$key]->dob));
				}*/

				$calenerdata[] = array('start' => $starting,'end'=>$ending,'title'=>$titlename,'type'=>$type,'sno'=>$snum,'color'=>$color,'contant'=>$contant,'repertdate'=>$repertdata);
			}
		 	 $r = 1; $presentmonth = date('d-m-Y'); 
            foreach ($calenerdata as $key => $calenderdata){
                $start = explode(" ", $calenerdata[$key]['start']);
                $end = explode(" ", $calenerdata[$key]['end']);
                if($start[1] == '00:00:00'){
                    $start = $start[0];
                    $start_date		=	date('j',strtotime($start));
                    $start_month	=	date('n',strtotime($start));
                    $start_year		=	date('Y',strtotime($start));
                }else{
                    $start = $calenerdata[$key]['start'];
                    $start_date		=	date('j',strtotime($start));
                    $start_month	=	date('n',strtotime($start));
                    $start_year		=	date('Y',strtotime($start));
                }
                $types		=	$calenerdata[$key]['type'];
                $info		=	$calenerdata[$key]['contant'];
                $title		=	$calenerdata[$key]['title'];
                if($presentmonth === date('d-m-Y',strtotime($start))){
                    if(empty($info) && $info == ''){
                        $info = 'To Day : No Events Founds';
                    }
                    if(empty($title) && $title == ''){
                        $info = 'To Day : No Events Founds';
                    }
                    $todayevents[] =  array('start' => $start,'title'=>$title,'type'=>$type,'contant'=>$info);
                } ?>
		<?php } ?>
		<!-- begin row -->
		<div class="row">
			<!-- begin col-4 -->
			<div class="col-lg-4">
				<!-- begin panel -->
				<div class="panel panel-inverse" data-sortable-id="index-2">
					<div class="panel-heading">
						<h4 class="panel-title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> &nbsp; Notification's </h4>
					</div>
					<div class="panel-body bg-silver p-0">
						<div class="widget-todolist" data-id="widget" style="min-height: 310px;">
							<!-- begin widget-todolist-body -->
							<div class="widget-todolist-body mb-0">
								<?php if(count($notifications) != 0){ ?>
									<?php foreach ($notifications as $notification){ ?>
										<!-- begin widget-todolist-item -->
										<a href="<?=base_url('dashboard/notice/'.$notification->sno)?>/?id=<?=$notification->id_num?>" style="text-decoration: none">
											<div class="widget-list-item">
												<div class="widget-list-media">
												<?php if (!empty($notification->notice_img)){ ?>
													<img src="<?=base_url($notification->notice_img)?>" alt="" class="rounded" style="width: 100%">
												<?php }else{ ?>
													<img src="<?=base_url()?>assets/img/default_image.png" alt="" class="rounded" style="width: 100%">
												<?php } ?>
												</div>

												<div class="widget-list-content">
													<h4 class="widget-list-title"><?=$notification->notice_title?></h4>
												</div>
											</div>
										</a>
										<!-- end widget-todolist-item -->
									<?php } ?>
								<?php }else{ ?>
									<div class="">
										<?=$this->Model_dashboard->norecords();?>
									</div>
								<?php } ?>
							</div>
							<!-- end widget-todolist-body -->
						</div>
					</div>
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-4 -->
			<!-- begin col-4 -->
			<div class="col-lg-4">
				<!-- begin panel -->
				<div class="panel panel-inverse" data-sortable-id="index-3">
					<div class="panel-heading">
						<h4 class="panel-title"> <i class="fa fa-calendar"></i> &nbsp; Academic Calender</h4>
					</div>
					<div id="ScheduleAcademicCalendar" class="bootstrap-calendar"></div>
					<div class="list-group">
						           <?php //echo "<pre>"; print_r($todayevents); echo "</pre>"; ?>

								<div class="breaking-news-ticker" id="newsTicker11" style="border: solid 1px #f6f6f6;">
									<div class="bn-news">
										<ul>

											<?php foreach ($todayevents as $key => $todayevent){ ?>
												<?php if(!empty($todayevent['title'])){ ?>
													<li><a href="javascript:;" class="text-blue">Today Event : <?=$todayevent['title']?></a></li>
												<?php }else{ ?>
                                                    <li><a href="javascript:;" class="text-success">Today Event : No Events Found..</a></li>
                                                <?php } ?>

												<?php if(!empty($todayevent['info'])){ ?>
													<li><a href="javascript:;" class="text-success">Today Event : <?php echo $todayevent['info']; ?></a></li>
												<?php  }else{ ?>
                                                    <li><a href="javascript:;" class="text-success">Today Event : No Events Found..</a></li>
                                                <?php } ?>
											<?php } ?>
										</ul>
									</div>
									<div class="bn-controls">
										<button><span class="bn-arrow bn-prev"></span></button>
										<button><span class="bn-action"></span></button>
										<button><span class="bn-arrow bn-next"></span></button>
									</div>
								</div>
							<script>
								$(document).ready(function() {
									$('#newsTicker11').breakingNews({
										effect: 'slide-up'
									});
								})
							</script>

					</div>
					<div class="list-group">
						<a href="javascript:;" class="list-group-item">
							<span class="badge f-w-500 bg-gradient-blue" style="line-height: 1.5;    border-radius: 5px;">Academic Events </span>
							<span class="badge f-w-500 bg-gradient-teal" style="line-height: 1.5;    border-radius: 5px;">Birthday Events</span>
						</a>
					</div>
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-4 -->
			<!-- begin col-4 -->
			<div class="col-lg-4">
				<!-- begin panel -->
				<div class="panel panel-inverse" data-sortable-id="index-2">
					<div class="panel-heading">
						<h4 class="panel-title"><i class="fa fa-envelope-o" aria-hidden="true"></i> &nbsp; Mail Reports </h4>
					</div>
					<div class="panel-body bg-silver p-0">
						<div class="widget-todolist" data-id="widget" style="min-height: 310px;">
							<!-- begin widget-todolist-body -->
							<div class="widget-todolist-body mb-0">
								<?php if(count($mailsents) != 0){ ?>
									<?php foreach ($mailsents as $mailsent){
										$extractdata = explode(' + ',$mailsent->information);
										$id   = $extractdata[0];
										$type = $extractdata[1];
										$userdata = $this->Model_dashboard->selectdata('sms_regusers',array('sno'=>$id,'reg_id'=>$mailsent->sender_id),'sno');
										$person = $userdata[0];
										$from = 'admin';
										$fname = $person->fname;
										$lname = $person->lname;
										?>
										<!-- begin widget-todolist-item -->
										<a href="<?=base_url('user/mail/details/'.$mailsent->mail_ids.'/'.$mailsent->branch_id.'/'.$mailsent->school_id.'/sent-mail?id='.$mailsent->mail_id.'&inbox_id='.$mailsent->id)?>" style="text-decoration: none">
											<div class="widget-list-item">
												<div class="widget-list-media">


													<img src="<?=base_url()?>assets/img/email.png" class="fab text-white" style="width: 100%">


												</div>

												<div class="widget-list-content">
													<h4 class="widget-list-title"><?=$mailsent->subject?></h4>
												</div>
											</div>
										</a>
										<!-- end widget-todolist-item -->
									<?php } ?>
								<?php }else{ ?>
									<div class="">
										<?=$this->Model_dashboard->norecords();?>
									</div>
								<?php } ?>
							</div>
							<!-- end widget-todolist-body -->
						</div>
					</div>
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-4 -->
		</div>
		<!-- end row -->
    
    <?php }else if($sessiondata['type'] === 'teacher' && !empty($sessiondata['type'])){

		$events   =  $this->Model_dashboard->selectdata('sms_events',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));
		
		$notifications = $this->Model_default->manualselect("SELECT * FROM `sms_notice` WHERE  school_id = '$school_id' AND branch_id = '$branch_id' AND (notice_to LIKE '%teacher%' AND notice_to NOT LIKE '%classteacher%') ORDER BY sno DESC LIMIT 5");

		?>
		<!-- begin row -->
		<div class="row">

			<!-- begin col-3 -->
			<?php
			$employees = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'employeetype'=>'staff','status'=>1),'sno');

			$employeedata = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'id_num'=>$sessiondata['regid'],'status'=>1),'sno');
			$employeedata   =   $employeedata[0];

			$totalemployee = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));
			@$percentage_employee = count($employees) / count($totalemployee) * 100;

			//$admission = $this->Model_dashboard->selectdata('sms_admissions',array('school_id' => $school_id, 'branch_id' => $branch_id,'class_type' => $userdata->assign_class_syllabus, 'class' => $employeedata->employeeclass,'status'=>1));

			$assignclass = explode(',',$userdata->assign_classes_list);
			$assignclasslist = '';
			foreach ($assignclass as $assignclassdata){
				@$assignclasslist .= 'class LIKE "%'.$assignclassdata.'%" OR ';
			}
			$assignclasslist = rtrim($assignclasslist,'OR ');

			$admission = $this->Model_default->manualselect("SELECT * FROM `sms_admissions` WHERE  school_id = '$school_id' AND branch_id = '$branch_id' AND (".$assignclasslist.") ORDER BY sno DESC");

			$totaladmission = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));
			@$percentage_admission = count($admission) / count($totaladmission) * 100;


			$classes = implode(', ',$assignclass);

			?>
			<div class="col-lg-3 col-md-6">
				<div class="widget widget-stats bg-gradient-purple">
					<div class="stats-icon stats-icon-lg" style="font-size: 65px;width: auto;"><i class="fa fa-users fa-fw"></i></div>
					<div class="stats-content">
						<div class="stats-title text-uppercase">Students list : <small class="text-white"><?=$classes?></small> </div>
						<div class="stats-number"><?= count($admission)?> Students </div>
						<div class="stats-progress progress">
							<div class="progress-bar" style="width: <?=$percentage_admission?>%;"></div>
						</div>
						<div class="stats-desc">Total Admission List ( <?=round($percentage_admission,1)?>% )</div>
					</div>
				</div>
			</div>
			<!-- end col-3 -->
			<!-- begin col-3 -->
			<?php //echo "<pre>"; print_r($employeedata); echo "</pre>"; ?>
			<div class="col-lg-3 col-md-6">
				<div class="widget widget-stats bg-gradient-black">
					<div class="stats-icon stats-icon-lg" style="font-size: 65px;width: auto;"><i class="fa fa-users fa-fw"></i></div>
					<div class="stats-content">
						<div class="stats-title">EMPLOYEE'S</div>
						<div class="stats-number"><?=count($employees)?> Members</div>
						<div class="stats-progress progress">
							<div class="progress-bar" style="width: <?=$percentage_employee?>%;"></div>
						</div>
						<div class="stats-desc">Total Staff List ( <?=round($percentage_employee,1)?>% )</div>
					</div>
				</div>
			</div>
			<!-- end col-3 -->
		</div>
		<!-- end row -->
		<?php    $calenerdata = array();
		$tablesdata = array_merge($events,$admissions,$employees);
		foreach ($tablesdata as $key => $value){
			if(isset($tablesdata[$key]->start) && isset($tablesdata[$key]->end)){
				$starting = $tablesdata[$key]->start;
				$type = 'event';
				$titlename = $tablesdata[$key]->title;
				$ending = $tablesdata[$key]->end;
				$snum =	 $tablesdata[$key]->sno;
				$color = $tablesdata[$key]->color;
				$contant = $tablesdata[$key]->contant;
				$repertdata = '';
			}

			/*if(isset($tablesdata[$key]->dob)){
                $starting = date('Y-m-d',strtotime($tablesdata[$key]->dob)).' 00:00:00';
                $ending = date('Y-m-d',strtotime($tablesdata[$key]->dob)).' 00:00:00';
                $titlename = $tablesdata[$key]->firstname.'.'.$tablesdata[$key]->lastname;
                if(isset($tablesdata[$key]->usermode)){
                    $type = $tablesdata[$key]->usermode;
                    $color = '#9C13AC';
                }else if(isset($tablesdata[$key]->employeetype)){
                    $type = $tablesdata[$key]->employeetype.' - '.$tablesdata[$key]->emoloyeeposition;
                    $color = '#A4E600';
                }
                $snum =	 $tablesdata[$key]->sno;

                $contant = 'Happy Birthday '.$titlename;
                $repertdata = date('Y').'-'.date('m-d',strtotime($tablesdata[$key]->dob));
            }*/

			$calenerdata[] = array('start' => $starting,'end'=>$ending,'title'=>$titlename,'type'=>$type,'sno'=>$snum,'color'=>$color,'contant'=>$contant,'repertdate'=>$repertdata);
		}
		$r = 1; $presentmonth = date('d-m-Y'); foreach ($calenerdata as $key => $calenderdata){
			$start = explode(" ", $calenerdata[$key]['start']);
			$end = explode(" ", $calenerdata[$key]['end']);
			if($start[1] == '00:00:00'){
				$start = $start[0];
				$start_date		=	date('j',strtotime($start));
				$start_month	=	date('n',strtotime($start));
				$start_year		=	date('Y',strtotime($start));
			}else{
				$start = $calenerdata[$key]['start'];
				$start_date		=	date('j',strtotime($start));
				$start_month	=	date('n',strtotime($start));
				$start_year		=	date('Y',strtotime($start));
			}
			$types		=	$calenerdata[$key]['type'];
			$info		=	$calenerdata[$key]['contant'];
			$title		=	$calenerdata[$key]['title'];
			if($presentmonth === date('d-m-Y',strtotime($start))){
				if(empty($info) && $info == ''){
					$info = 'To Day : No Events Founds';
				}
				if(empty($title) && $title == ''){
					$info = 'To Day : No Events Founds';
				}
				$todayevents[] =  array('start' => $start,'title'=>$title,'type'=>$type,'contant'=>$info);
			} ?>
		<?php } ?>
		<!-- begin row -->
		<div class="row">
			<!-- begin col-4 -->
			<div class="col-lg-4">
				<!-- begin panel -->
				<div class="panel panel-inverse" data-sortable-id="index-2">
					<div class="panel-heading">
						<h4 class="panel-title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> &nbsp; Notification's </h4>
					</div>
					<div class="panel-body bg-silver p-0">
						<div class="widget-todolist" data-id="widget" style="min-height: 310px;">
							<!-- begin widget-todolist-body -->
							<div class="widget-todolist-body mb-0">
								<?php if(count($notifications) != 0){ ?>
									<?php foreach ($notifications as $notification){ ?>
										<!-- begin widget-todolist-item -->
										<a href="<?=base_url('dashboard/notice/'.$notification->sno)?>/?id=<?=$notification->id_num?>" style="text-decoration: none">
											<div class="widget-list-item">
												<div class="widget-list-media">
													<?php if (!empty($notification->notice_img)){ ?>
														<img src="<?=base_url($notification->notice_img)?>" alt="" class="rounded" style="width: 100%">
													<?php }else{ ?>
														<img src="<?=base_url()?>assets/img/default_image.png" alt="" class="rounded" style="width: 100%">
													<?php } ?>
												</div>

												<div class="widget-list-content">
													<h4 class="widget-list-title"><?=$notification->notice_title?></h4>
												</div>
											</div>
										</a>
										<!-- end widget-todolist-item -->
									<?php } ?>
								<?php }else{ ?>
									<div class="">
										<?=$this->Model_dashboard->norecords();?>
									</div>
								<?php } ?>
							</div>
							<!-- end widget-todolist-body -->
						</div>
					</div>
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-4 -->
			<!-- begin col-4 -->
			<div class="col-lg-4">
				<!-- begin panel -->
				<div class="panel panel-inverse" data-sortable-id="index-3">
					<div class="panel-heading">
						<h4 class="panel-title"> <i class="fa fa-calendar"></i> &nbsp; Academic Calender</h4>
					</div>
					<div id="ScheduleAcademicCalendar" class="bootstrap-calendar"></div>
					<div class="list-group">
						<?php //echo "<pre>"; print_r($todayevents); echo "</pre>"; ?>

						<div class="breaking-news-ticker" id="newsTicker11" style="border: solid 1px #f6f6f6;">
							<div class="bn-news">
								<ul>

									<?php foreach ($todayevents as $key => $todayevent){ ?>
										<?php if(!empty($todayevent['title'])){ ?>
											<li><a href="javascript:;" class="text-blue">Today Event : <?=$todayevent['title']?></a></li>
										<?php }else{ ?>
											<li><a href="javascript:;" class="text-success">Today Event : No Events Found..</a></li>
										<?php } ?>

										<?php if(!empty($todayevent['info'])){ ?>
											<li><a href="javascript:;" class="text-success">Today Event : <?php echo $todayevent['info']; ?></a></li>
										<?php  }else{ ?>
											<li><a href="javascript:;" class="text-success">Today Event : No Events Found..</a></li>
										<?php } ?>
									<?php } ?>
								</ul>
							</div>
							<div class="bn-controls">
								<button><span class="bn-arrow bn-prev"></span></button>
								<button><span class="bn-action"></span></button>
								<button><span class="bn-arrow bn-next"></span></button>
							</div>
						</div>
						<script>
							$(document).ready(function() {
								$('#newsTicker11').breakingNews({
									effect: 'slide-up'
								});
							})
						</script>

					</div>
					<div class="list-group">
						<a href="javascript:;" class="list-group-item">
							<span class="badge f-w-500 bg-gradient-blue" style="line-height: 1.5;    border-radius: 5px;">Academic Events </span>
							<span class="badge f-w-500 bg-gradient-teal" style="line-height: 1.5;    border-radius: 5px;">Birthday Events</span>
						</a>
					</div>
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-4 -->
			<!-- begin col-4 -->
			<div class="col-lg-4">
				<!-- begin panel -->
				<div class="panel panel-inverse" data-sortable-id="index-2">
					<div class="panel-heading">
						<h4 class="panel-title"><i class="fa fa-envelope-o" aria-hidden="true"></i> &nbsp; Mail Reports </h4>
					</div>
					<div class="panel-body bg-silver p-0">
						<div class="widget-todolist" data-id="widget" style="min-height: 310px;">
							<!-- begin widget-todolist-body -->
							<div class="widget-todolist-body mb-0">
								<?php if(count($mailsents) != 0){ ?>
									<?php foreach ($mailsents as $mailsent){
										$extractdata = explode(' + ',$mailsent->information);
										$id   = $extractdata[0];
										$type = $extractdata[1];
										$userdata = $this->Model_dashboard->selectdata('sms_regusers',array('sno'=>$id,'reg_id'=>$mailsent->sender_id),'sno');
										$person = $userdata[0];
										$from = 'admin';
										$fname = $person->fname;
										$lname = $person->lname;
										?>
										<!-- begin widget-todolist-item -->
										<a href="<?=base_url('user/mail/details/'.$mailsent->mail_ids.'/'.$mailsent->branch_id.'/'.$mailsent->school_id.'/sent-mail?id='.$mailsent->mail_id.'&inbox_id='.$mailsent->id)?>" style="text-decoration: none">
											<div class="widget-list-item">
												<div class="widget-list-media">


													<img src="<?=base_url()?>assets/img/email.png" class="fab text-white" style="width: 100%">


												</div>

												<div class="widget-list-content">
													<h4 class="widget-list-title"><?=$mailsent->subject?></h4>
												</div>
											</div>
										</a>
										<!-- end widget-todolist-item -->
									<?php } ?>
								<?php }else{ ?>
									<div class="mt-4">
										<?=$this->Model_dashboard->norecords();?>
									</div>
								<?php } ?>
							</div>
							<!-- end widget-todolist-body -->
						</div>
					</div>
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-4 -->
		</div>
		<!-- end row -->
    
	<?php }else if($sessiondata['type'] === 'student' && !empty($sessiondata['type'])){

		$events   =  $this->Model_dashboard->selectdata('sms_events',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));

		$notifications = $this->Model_default->manualselect("SELECT * FROM `sms_notice` WHERE  school_id = '$school_id' AND branch_id = '$branch_id' AND notice_to LIKE '%student%' ORDER BY sno DESC LIMIT 5");
		
		?>
		<!-- begin row -->
		<div class="row">

			<!-- begin col-3 -->
			<?php
                $totalemployee = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));
                @$percentage_employee = count($employees) / count($totalemployee) * 100;

                $employees = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'employeetype'=>'staff','status'=>1),'sno');

                $employeedata = $this->Model_dashboard->selectdata('sms_employee',array('school_id'=>$school_id,'branch_id'=>$branch_id,'id_num'=>$sessiondata['regid'],'status'=>1),'sno');
                $employeedata   =   $employeedata[0];

                $admission = $this->Model_default->manualselect("SELECT * FROM `sms_admissions` WHERE  school_id = '$school_id' AND branch_id = '$branch_id' AND class_type = $userdata->class_type AND class = '$userdata->class' ORDER BY sno DESC");

                $totaladmission = $this->Model_dashboard->selectdata('sms_admissions',array('school_id'=>$school_id,'branch_id'=>$branch_id,'status'=>1));
                @$percentage_admission = count($admission) / count($totaladmission) * 100;


                $classes = $userdata->class;
                $section = $userdata->section;
                $syllabus = $userdata->class_type;
                //print_r($userdata);
			?>
			<div class="col-lg-3 col-md-6">
				<div class="widget widget-stats bg-gradient-purple">
					<div class="stats-icon stats-icon-lg" style="font-size: 65px;width: auto;"><i class="fa fa-users fa-fw"></i></div>
					<div class="stats-content">
						<div class="stats-title text-uppercase">Students list : <small class="text-white"><?=$classes?></small> </div>
						<div class="stats-number"><?= count($admission)?> Students </div>
						<div class="stats-progress progress">
							<div class="progress-bar" style="width: <?=$percentage_admission?>%;"></div>
						</div>
						<div class="stats-desc">Total Admission List ( <?=round($percentage_admission,1)?>% )</div>
					</div>
				</div>
			</div>
			<!-- end col-3 -->
			<!-- begin col-3 -->
				<div class="col-lg-3 col-md-6">
					<div class="widget widget-stats bg-gradient-black">
						<div class="stats-icon stats-icon-lg" style="font-size: 65px;width: auto;"><i class="fa fa-users fa-fw"></i></div>
						<div class="stats-content">
							<div class="stats-title">SUBJECTS TEACHERS</div>
							<div class="stats-number"><?=count($employees)?> Members</div>
							<div class="stats-progress progress">
								<div class="progress-bar" style="width: <?=$percentage_employee?>%;"></div>
							</div>
							<div class="stats-desc">Subject Teachers ( <?=round($percentage_employee,1)?>% )</div>
						</div>
					</div>
				</div>
			<!-- end col-3 -->
		</div>
		<!-- end row -->
		<?php    $calenerdata = array();
		$tablesdata = array_merge($events,$admissions,$employees);
		foreach ($tablesdata as $key => $value){
			if(isset($tablesdata[$key]->start) && isset($tablesdata[$key]->end)){
				$starting = $tablesdata[$key]->start;
				$type = 'event';
				$titlename = $tablesdata[$key]->title;
				$ending = $tablesdata[$key]->end;
				$snum =	 $tablesdata[$key]->sno;
				$color = $tablesdata[$key]->color;
				$contant = $tablesdata[$key]->contant;
				$repertdata = '';
			}

			/*if(isset($tablesdata[$key]->dob)){
                $starting = date('Y-m-d',strtotime($tablesdata[$key]->dob)).' 00:00:00';
                $ending = date('Y-m-d',strtotime($tablesdata[$key]->dob)).' 00:00:00';
                $titlename = $tablesdata[$key]->firstname.'.'.$tablesdata[$key]->lastname;
                if(isset($tablesdata[$key]->usermode)){
                    $type = $tablesdata[$key]->usermode;
                    $color = '#9C13AC';
                }else if(isset($tablesdata[$key]->employeetype)){
                    $type = $tablesdata[$key]->employeetype.' - '.$tablesdata[$key]->emoloyeeposition;
                    $color = '#A4E600';
                }
                $snum =	 $tablesdata[$key]->sno;

                $contant = 'Happy Birthday '.$titlename;
                $repertdata = date('Y').'-'.date('m-d',strtotime($tablesdata[$key]->dob));
            }*/

			$calenerdata[] = array('start' => $starting,'end'=>$ending,'title'=>$titlename,'type'=>$type,'sno'=>$snum,'color'=>$color,'contant'=>$contant,'repertdate'=>$repertdata);
		}
		$r = 1; $presentmonth = date('d-m-Y'); foreach ($calenerdata as $key => $calenderdata){
			$start = explode(" ", $calenerdata[$key]['start']);
			$end = explode(" ", $calenerdata[$key]['end']);
			if($start[1] == '00:00:00'){
				$start = $start[0];
				$start_date		=	date('j',strtotime($start));
				$start_month	=	date('n',strtotime($start));
				$start_year		=	date('Y',strtotime($start));
			}else{
				$start = $calenerdata[$key]['start'];
				$start_date		=	date('j',strtotime($start));
				$start_month	=	date('n',strtotime($start));
				$start_year		=	date('Y',strtotime($start));
			}
			$types		=	$calenerdata[$key]['type'];
			$info		=	$calenerdata[$key]['contant'];
			$title		=	$calenerdata[$key]['title'];
			if($presentmonth === date('d-m-Y',strtotime($start))){
				if(empty($info) && $info == ''){
					$info = 'To Day : No Events Founds';
				}
				if(empty($title) && $title == ''){
					$info = 'To Day : No Events Founds';
				}
				$todayevents[] =  array('start' => $start,'title'=>$title,'type'=>$type,'contant'=>$info);
			} ?>
		<?php } ?>
		<!-- begin row -->
		<div class="row">
			<!-- begin col-4 -->
			<div class="col-lg-4">
				<!-- begin panel -->
				<div class="panel panel-inverse" data-sortable-id="index-2">
					<div class="panel-heading">
						<h4 class="panel-title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> &nbsp; Notification's </h4>
					</div>
					<div class="panel-body bg-silver p-0">
						<div class="widget-todolist" data-id="widget" style="min-height: 310px;">
							<!-- begin widget-todolist-body -->
							<div class="widget-todolist-body mb-0">
								<?php if(count($notifications) != 0){ ?>
									<?php foreach ($notifications as $notification){ ?>
										<!-- begin widget-todolist-item -->
										<a href="<?=base_url('dashboard/notice/'.$notification->sno)?>/?id=<?=$notification->id_num?>" style="text-decoration: none">
											<div class="widget-list-item">
												<div class="widget-list-media">
													<?php if (!empty($notification->notice_img)){ ?>
														<img src="<?=base_url($notification->notice_img)?>" alt="" class="rounded" style="width: 100%">
													<?php }else{ ?>
														<img src="<?=base_url()?>assets/img/default_image.png" alt="" class="rounded" style="width: 100%">
													<?php } ?>
												</div>

												<div class="widget-list-content">
													<h4 class="widget-list-title"><?=$notification->notice_title?></h4>
												</div>
											</div>
										</a>
										<!-- end widget-todolist-item -->
									<?php } ?>
								<?php }else{ ?>
									<div class="">
										<?=$this->Model_dashboard->norecords();?>
									</div>
								<?php } ?>
							</div>
							<!-- end widget-todolist-body -->
						</div>
					</div>
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-4 -->
			<!-- begin col-4 -->
			<div class="col-lg-4">
				<!-- begin panel -->
				<div class="panel panel-inverse" data-sortable-id="index-3">
					<div class="panel-heading">
						<h4 class="panel-title"> <i class="fa fa-calendar"></i> &nbsp; Academic Calender</h4>
					</div>
					<div id="ScheduleAcademicCalendar" class="bootstrap-calendar"></div>
					<div class="list-group">
						<?php //echo "<pre>"; print_r($todayevents); echo "</pre>"; ?>

						<div class="breaking-news-ticker" id="newsTicker11" style="border: solid 1px #f6f6f6;">
							<div class="bn-news">
								<ul>

									<?php foreach ($todayevents as $key => $todayevent){ ?>
										<?php if(!empty($todayevent['title'])){ ?>
											<li><a href="javascript:;" class="text-blue">Today Event : <?=$todayevent['title']?></a></li>
										<?php }else{ ?>
											<li><a href="javascript:;" class="text-success">Today Event : No Events Found..</a></li>
										<?php } ?>

										<?php if(!empty($todayevent['info'])){ ?>
											<li><a href="javascript:;" class="text-success">Today Event : <?php echo $todayevent['info']; ?></a></li>
										<?php  }else{ ?>
											<li><a href="javascript:;" class="text-success">Today Event : No Events Found..</a></li>
										<?php } ?>
									<?php } ?>
								</ul>
							</div>
							<div class="bn-controls">
								<button><span class="bn-arrow bn-prev"></span></button>
								<button><span class="bn-action"></span></button>
								<button><span class="bn-arrow bn-next"></span></button>
							</div>
						</div>
						<script>
							$(document).ready(function() {
								$('#newsTicker11').breakingNews({
									effect: 'slide-up'
								});
							})
						</script>

					</div>
					<div class="list-group">
						<a href="javascript:;" class="list-group-item">
							<span class="badge f-w-500 bg-gradient-blue" style="line-height: 1.5;    border-radius: 5px;">Academic Events </span>
							<span class="badge f-w-500 bg-gradient-teal" style="line-height: 1.5;    border-radius: 5px;">Birthday Events</span>
						</a>
					</div>
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-4 -->
			<!-- begin col-4 -->
			<div class="col-lg-4">
				<!-- begin panel -->
				<div class="panel panel-inverse" data-sortable-id="index-2">
					<div class="panel-heading">
						<h4 class="panel-title"><i class="fa fa-envelope-o" aria-hidden="true"></i> &nbsp; Mail Reports </h4>
					</div>
					<div class="panel-body bg-silver p-0">
						<div class="widget-todolist" data-id="widget" style="min-height: 310px;">
							<!-- begin widget-todolist-body -->
							<div class="widget-todolist-body mb-0">
								<?php if(count($mailsents) != 0){ ?>
									<?php foreach ($mailsents as $mailsent){
										$extractdata = explode(' + ',$mailsent->information);
										$id   = $extractdata[0];
										$type = $extractdata[1];
										$userdata = $this->Model_dashboard->selectdata('sms_regusers',array('sno'=>$id,'reg_id'=>$mailsent->sender_id),'sno');
										$person = $userdata[0];
										$from = 'admin';
										$fname = $person->fname;
										$lname = $person->lname;
										?>
										<!-- begin widget-todolist-item -->
										<a href="<?=base_url('user/mail/details/'.$mailsent->mail_ids.'/'.$mailsent->branch_id.'/'.$mailsent->school_id.'/sent-mail?id='.$mailsent->mail_id.'&inbox_id='.$mailsent->id)?>" style="text-decoration: none">
											<div class="widget-list-item">
												<div class="widget-list-media">


													<img src="<?=base_url()?>assets/img/email.png" class="fab text-white" style="width: 100%">


												</div>

												<div class="widget-list-content">
													<h4 class="widget-list-title"><?=$mailsent->subject?></h4>
												</div>
											</div>
										</a>
										<!-- end widget-todolist-item -->
									<?php } ?>
								<?php }else{ ?>
									<div class="mt-4">
										<?=$this->Model_dashboard->norecords();?>
									</div>
								<?php } ?>
							</div>
							<!-- end widget-todolist-body -->
						</div>
					</div>
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-4 -->
		</div>
        <div class="row">
			<!-- begin col-4 -->
			<div class="col-lg-4">
				<!-- begin panel -->
                <?php
    
                    $dairyworks = $this->Model_default->manualselect("SELECT * FROM `sms_homework_reports` WHERE  school_id = '$school_id' AND branch_id = '$branch_id' AND syllabus = '$syllabus' AND class = '$classes' AND section = '$section' AND publish = 1 AND hw_date = '".date('Y-m-d')."' ORDER BY hw_date DESC");
                ?>
				<div class="panel panel-inverse" data-sortable-id="index-2">
					<div class="panel-heading">
						<h4 class="panel-title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> &nbsp; <?php if($dairyworks[0]->hw_date != ''){ echo date('d-m-Y',strtotime($dairyworks[0]->hw_date)); }else{ echo date('d-m-Y'); } ?> Dairy Work's </h4>
					</div>
					<div class="panel-body bg-silver p-0">
						<div class="widget-todolist" data-id="widget">
							<!-- begin widget-todolist-body -->
							<div class="widget-todolist-body mb-0 col-12">
								<?php if(count($dairyworks) != 0){ ?>
									
                                    <?php $dairywork = unserialize($dairyworks[0]->hw_details); //print_r($dairywork); ?>
                                    
                                    <?php for($i = 0; $i < count($dairywork); $i++){ 
                                            foreach ($dairywork[$i] as $key => $work){ ?>
                                                <div class="col-12 pt-2 pb-2" style="border-bottom: 1px solid #e8e8e8;">
                                                    <div class="row">
                                                        <div class="col-4 text-bold text-success"><?=strtoupper($key)?> <span class="pull-right"> : </span></div>
                                                        <div class="col-8 text-bold">
                                                            <?php if($work != ''){ echo ucwords($work); }else{ echo '*** No Work Assign ***'; }?>
                                                        </div>
                                                    </div>
                                                </div>
                                    <?php } } ?>
                                    
								<?php }else{ ?>
									<div class="">
										<?=$this->Model_dashboard->norecords();?>
									</div>
								<?php } ?>
							</div>
							<!-- end widget-todolist-body -->
						</div>
					</div>
				</div>
				<!-- end panel -->
			</div>
			<!-- end col-4 -->
			
		</div>
		<!-- end row -->
	<?php } ?>


</div>
<!-- end #content -->
<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="<?=base_url()?>assets/plugins/d3/d3.min.js"></script>
<script src="<?=base_url()?>assets/plugins/nvd3/build/nv.d3.js"></script>
<script src="<?=base_url()?>assets/plugins/clipboard/clipboard.min.js"></script>
<script src="<?=base_url()?>assets/plugins/highlight/highlight.common.js"></script>
<script src="<?=base_url()?>assets/js/school_statistics_sheet.js"></script>
<script src="<?=base_url()?>assets/js/demo/render.highlight.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script>
	$(document).ready(function() {
		Widget.init();

		var t = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
			e = ["S", "M", "T", "W", "T", "F", "S"],
			r = new Date,
			n = r.getMonth() + 1,
			o = r.getFullYear(),
			
			i = $("#ScheduleAcademicCalendar");
		$(i).calendar({
			months: t,
			days: e,
			events: [
				["<?=date('j'); ?>/<?=date('m')?>/" + o, "Today Date", "<?=base_url('dashboard/academiccalendar')?>", COLOR_BLACK],
				<?php foreach ($calenerdata as $key => $calenderevent){
					$start = explode(" ", $calenerdata[$key]['start']);
					$end = explode(" ", $calenerdata[$key]['end']);
					if($start[1] == '00:00:00'){
						$start = $start[0];
						$start_date		=	date('j',strtotime($start));
						$start_month	=	date('n',strtotime($start));
						$start_year		=	date('Y',strtotime($start));
					}else{
						$start = $calenerdata[$key]['start'];
						$start_date		=	date('j',strtotime($start));
						$start_month	=	date('n',strtotime($start));
						$start_year		=	date('Y',strtotime($start));
					}
					$types		=	$calenerdata[$key]['type'];
					$info		=	$calenerdata[$key]['contant'];
					$title		=	$calenerdata[$key]['title'];
					if($types == 'event'){ ?>
						["<?=$start_date; ?>/<?=$start_month?>/" + o, "<?=$title?>", "<?=base_url('dashboard/academiccalendar')?>", COLOR_BLUE],
					<?php }else{ ?>
						["<?=$start_date; ?>/<?=$start_month?>/" + o, "<?=$info?>", "<?=base_url('dashboard/academiccalendar')?>", COLOR_GREEN],
					<?php }  ?>
				<?php  } ?>
			],
			popover_options: {
				placement: "top",
				html: !0
			}
		}), $(i).find("td.event").each(function() {
			var t = $(this).css("background-color");
			$(this).removeAttr("style"), $(this).find("a").css("background-color", t)
		}), $(i).find(".icon-arrow-left, .icon-arrow-right").parent().on("click", function() {
			$(i).find("td.event").each(function() {
				var t = $(this).css("background-color");
				$(this).removeAttr("style"), $(this).find("a").css("background-color", t)
			})
		})
		


	});
</script>
