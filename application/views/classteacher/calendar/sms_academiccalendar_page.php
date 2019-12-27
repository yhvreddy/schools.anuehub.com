<link href="<?=base_url()?>assets/plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" media='print' />
<link href="<?=base_url()?>assets/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" />
<style>
    .fc-button{
        background: black !important;
        color: white !important;
    }
</style>
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active">Academic Calendar</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Academic Calendar <small></small></h1>
    <!-- end page-header -->
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Academic Calendar</h4>
                </div>
                <div class="panel-body">

					<?php
						$calenerdata = array();
						$tablesdata = array_merge($events,$notices,$admissions,$employees);
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

							if(isset($tablesdata[$key]->notice_publish)){
								$starting = date('Y-m-d',strtotime($tablesdata[$key]->notice_publish)).' 00:00:00';
								$ending = date('Y-m-d',strtotime($tablesdata[$key]->notice_publish)).' 00:00:00';
								$titlename = $tablesdata[$key]->notice_title;
								$type = 'notice';
								$snum =	 $tablesdata[$key]->sno;
								$color = '#F50000';
								$contant = '';
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
						//$decode = json_decode(json_encode($events),true);
						//$calenerdataevents = array_merge($decode,$calenerdata);
						//echo "<pre>"; print_r($calenerdata);  echo "</pre>";
					?>
                    <div id="calendar"></div>
                </div>

            </div>
        </div>
        <!--<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Upcomming Events</h4>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
    <!-- End PAge Content -->
</div>
<!-- End Container fluid  -->
<script src="<?=base_url()?>assets/plugins/fullcalendar/lib/moment.min.js"></script>
<script src="<?=base_url()?>assets/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="<?=base_url()?>assets/js/demo/calendar.demo.min.js"></script>
<script>
    $(document).ready(function () {
        //Calendar.init();
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'listMonth,month,agendaWeek,agendaDay'
            },
			defaultView: 'listMonth',
            defaultDate: Date('Y-m'),
            navLinks: true, // can click day/week names to navigate views
			selectable: true,
            selectHelper: true,
            select: function(start, end) {
                $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd').modal({backdrop: 'static', keyboard: false});
                $('#ModalAdd').modal('show');
            },

		<?php foreach($calenerdata as $key => $event){ if($calenerdata[$key]['type'] == 'event'){ ?>
			eventRender: function(event, element) {
				element.bind('dblclick', function() {
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #eventdescription').val(event.eventdescription);
					$('#ModalEdit #title').val(event.title);
					$('#ModalEdit #color').val(event.color);
					$('#ModalEdit').modal({backdrop: 'static', keyboard: false});
					$('#ModalEdit').modal('show');
				});
			},

			eventDrop: function(event, delta, revertFunc) {
				edit(event);
			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
				edit(event);
			},
			editable: false,
		<?php } } ?>
        eventLimit: true, // allow "more" link when too many events
        events: [
            <?php foreach($calenerdata as $key => $event){

            $start = explode(" ", $calenerdata[$key]['start']);
            $end = explode(" ", $calenerdata[$key]['end']);
            if($start[1] == '00:00:00'){
                $start = $start[0];
            }else{
                $start = $calenerdata[$key]['start'];
            }
            if($end[1] == '00:00:00'){
                $end = $end[0];
            }else{
                $end = $calenerdata[$key]['end'];
            }
            ?>
				{
					id: "<?php echo $calenerdata[$key]['sno']; ?>",
					title: "<?php echo $calenerdata[$key]['title']; ?>",
					<?php if($calenerdata[$key]['type'] == 'event' || $calenerdata[$key]['type'] == 'notice'){ ?>
					start: '<?php echo $start; ?>',
					<?php }else{ ?>
					start: '<?php echo $calenerdata[$key]['repertdate']; ?>',
					<?php } ?>
					end: '<?php echo $end; ?>',
					color: "<?php echo $calenerdata[$key]['color']; ?>",
					eventdescription:"<?=$calenerdata[$key]['contant']?>",
				},
				<?php } ?>
            ]
        });
    });
</script>
