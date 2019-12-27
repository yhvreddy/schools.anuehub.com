<?php
	$url = $this->uri->uri_string();
	$two = $this->uri->segment(2);
	if(isset($customlink) && !empty($customlink)){
		$customlink = $customlink;
	}else {
		$customlink = '';
	}
?>
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <!--<ul class="nav">
             <li class="nav-profile">
                <a href="javascript:;" data-toggle="nav-profile">
                    <div class="image">
                        <img src="../assets/img/user/user-13.jpg" alt="" />
                    </div>
                    <div class="info">
                        <b class="caret pull-right"></b>
                        Sean Ngu
                        <small>Front end developer</small>
                    </div>
                </a>
            </li>
            <li>
                <ul class="nav nav-profile">
                    <li><a href="javascript:;"><i class="fa fa-cog"></i> Settings</a></li>
                    <li><a href="javascript:;"><i class="fa fa-pencil-alt"></i> Send Feedback</a></li>
                    <li><a href="javascript:;"><i class="fa fa-question-circle"></i> Helps</a></li>
                </ul>
            </li>
        </ul> -->
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        <ul class="nav">

            <?php $sessiondata = $this->session->userdata; ?>
				<li class="nav-header text-uppercase">Navigation <span class="pull-right">[ <?=ucwords($sessiondata['type'])?> ]</span></li>
			<?php
                if($sessiondata['type'] == 'student'){ ?>


					<li <?php if($url == 'student/dashboard'){ ?> class="active" <?php } ?>><a href="<?=base_url('student/dashboard')?>"><i class="fa fa-th-large"></i><span>Dashboard</span></a></li>

                    <li <?php if($url == 'student/dashboard/mydetails'){ ?> class="active" <?php } ?>><a href="<?=base_url('student/dashboard/mydetails')?>"><i class="fa fa-user"></i><span>My Details</span></a></li>
            
                    <li <?php if($url == 'student/dashboard/dairyworks'){ ?> class="active" <?php } ?>><a href="<?=base_url('student/dashboard/dairyworks')?>"><i class="fa fa-user"></i><span>Dairy</span></a></li>

                    <li><a href="<?=base_url('user/mail/inbox')?>" target="_blank"><i class="fa fa-envelope"></i> <span>Mail box </span></a></li>

                    <li <?php if($url == 'student/dashboard/notification'){ ?> class="active" <?php } ?>><a href="<?=base_url('student/dashboard/notification')?>"><i class="fa fa-wpforms"></i> <span>Notice </span></a></li>

                    <li <?php if($url == 'student/dashboard/timingslist'){ ?> class="active" <?php } ?>><a href="<?=base_url('student/dashboard/timingslist')?>"><i class="fa fa-times-circle"></i> <span>Timings List </span></a></li>

                    <li <?php if($url == 'student/dashboard/academiccalendar'){ ?> class="active" <?php } ?> ><a href="<?=base_url('student/dashboard/academiccalendar')?>"><i class="fa fa-calendar"></i> <span>Academic Calender </span></a></li>
            
                    <li <?php if($url == 'student/dashboard/attendencereports'){ ?> class="active" <?php } ?>><a href="<?=base_url('student/dashboard/attendencereports')?>"><i class="fa fa-bolt"></i> <span>Attendence</span></a></li>
            
                    <li class="has-sub <?php if($url == 'student/dashboard/examtimings' || $url == 'student/dashboard/exams/results'){ ?> active <?php } ?>">
                        <a href="javascript:;">
                            <b class="caret"></b>
                            <i class="fa fa-file"></i>
                            <span>Examination's</span>
                        </a>
                        <ul class="sub-menu">
                            <li <?php if($url == 'student/dashboard/examtimings'){ ?> class="active" <?php } ?>><a href="<?=base_url('student/dashboard/examtimings')?>">Exam Timetable</a></li>
                            
                            <li <?php if($url == 'student/dashboard/exams/results'){ ?> class="active" <?php } ?>><a href="<?=base_url('student/dashboard/exams/results')?>">Results List</a></li>
                        </ul>
                    </li>
                    
                    <li><a href="<?=base_url('student/profile')?>"><i class="fa fa-user"></i> <span>profile</span></a></li>


                <?php }else if($sessiondata['type'] == 'classteacher'){  ?>


					<li <?php if($url == 'classteacher/dashboard'){?>class="active"<?php } ?>><a href="<?=base_url('classteacher/dashboard');?>"><i class="fa fa-th-large"></i><span>Dashboard</span></a></li>
					<li <?php if($url == 'classteacher/studentslist'){?>class="active"<?php } ?>><a href="<?=base_url('classteacher/studentslist')?>"><i class="fa fa-users"></i> <span>Students List </span></a></li>
					<li <?php if($url == 'classteacher/employeelist'){?>class="active"<?php } ?>><a href="<?=base_url('classteacher/employeelist')?>"><i class="fa fa-users"></i> <span>Staff List </span></a></li>
					<li><a href="<?=base_url('user/mail/inbox')?>" target="_blank"><i class="fa fa-envelope"></i> <span>Mail box </span></a></li>
					<li <?php if($url == 'classteacher/notices'){ ?> class="active" <?php } ?>><a href="<?=base_url('classteacher/notices')?>"><i class="fa fa-wpforms"></i> <span>Notice </span></a></li>
					<li <?php if($url == 'classteacher/timingslist'){ ?> class="active" <?php } ?>><a href="<?=base_url('classteacher/timingslist')?>"><i class="fa fa-times-circle"></i> <span>Timings List </span></a></li>
					<li <?php if($url == 'classteacher/academiccalendar'){ ?> class="active" <?php } ?> ><a href="<?=base_url('classteacher/academiccalendar')?>"><i class="fa fa-calendar"></i> <span>Academic Calender </span></a></li>
					<li class="has-sub <?php if($url == 'classteacher/attendence/newadd' || $url == 'classteacher/attendence/attendencelist'){?>active<?php } ?>">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-bolt"></i>
							<span>Attendence</span>
						</a>
						<ul class="sub-menu">
							<li <?php if($url == 'classteacher/attendence/newadd'){ ?> class="active" <?php } ?>><a href="<?=base_url('classteacher/attendence/newadd')?>">New Attendance</a></li>
							<li <?php if($url == 'classteacher/attendence/attendencelist'){ ?> class="active" <?php } ?>><a href="<?=base_url('classteacher/attendence/attendencelist')?>">Attendence List</a></li>
						</ul>
					</li>
					<li class="has-sub <?php if($url == 'classteacher/timings/exam/timingslist' || $url == 'classteacher/exams/resultsupload' || $url == 'classteacher/exams/uploaded/resultslist'){?>active<?php } ?>">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-users"></i>
							<span>Examination's</span>
						</a>
						<ul class="sub-menu">
							<li <?php if($url == 'classteacher/timings/exam/timingslist'){ ?> class="active" <?php } ?>><a href="<?=base_url('classteacher/timings/exam/timingslist')?>">Exam Timetable</a></li>
							<li <?php if($url == 'classteacher/exams/resultsupload'){ ?> class="active" <?php } ?>><a href="<?=base_url('classteacher/exams/resultsupload')?>">Results Upload</a></li>
							<li <?php if($url == 'classteacher/exams/uploaded/resultslist'){ ?> class="active" <?php } ?>><a href="<?=base_url('classteacher/exams/uploaded/resultslist')?>">Results List</a></li>
						</ul>
					</li>
					<li><a href="<?=base_url('classteacher/profile')?>"><i class="fa fa-user"></i> <span>profile</span></a></li>


				<?php }else if($sessiondata['type'] == 'teacher'){ ?>
            
					<li <?php if($url == 'teacher/dashboard'){?>class="active"<?php } ?>><a href="<?=base_url('teacher/dashboard')?>"><i class="fa fa-th-large"></i><span>Dashboard</span></a></li>
					<li <?php if($url == 'teacher/studentslist'){?>class="active"<?php } ?>><a href="<?=base_url('teacher/studentslist')?>"><i class="fa fa-users"></i> <span>Students List </span></a></li>
					<li <?php if($url == 'teacher/employeelist'){?>class="active"<?php } ?> style="display:none"><a href="<?=base_url('teacher/employeelist')?>"><i class="fa fa-users"></i> <span>Staff List </span></a></li>
					<li><a href="<?=base_url('user/mail/inbox')?>" target="_blank"><i class="fa fa-envelope"></i> <span>Mail box </span></a></li>
					<li <?php if($url == 'teacher/notices'){ ?> class="active" <?php } ?>><a href="<?=base_url('teacher/notices')?>"><i class="fa fa-wpforms"></i> <span>Notice </span></a></li>
					<li <?php if($url == 'teacher/timingslist'){ ?> class="active" <?php } ?>><a href="<?=base_url('teacher/timingslist')?>"><i class="fa fa-times-circle"></i> <span>Timings List </span></a></li>
					<li <?php if($url == 'teacher/academiccalendar'){ ?> class="active" <?php } ?> ><a href="<?=base_url('teacher/academiccalendar')?>"><i class="fa fa-calendar"></i> <span>Academic Calender </span></a></li>
            
                    <li <?php if($url == 'teacher/attendence/attendencelist'){ ?> class="active" <?php } ?>><a href="<?=base_url('teacher/attendence/attendencelist')?>"><i class="fa fa-bolt"></i> <span>Attendence</span></a></li>
            
					<li class="has-sub <?php if($url == 'teacher/timings/exam/timingslist' || $url == 'teacher/exams/resultsupload' || $url == 'teacher/exams/upload/studentsmarkslist' || $url == 'teacher/exams/uploaded/resultslist'){ ?> active <?php } ?>">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-users"></i>
							<span>Examination's</span>
						</a>
						<ul class="sub-menu">
							<li <?php if($url == 'teacher/timings/exam/timingslist'){ ?> class="active" <?php } ?>><a href="<?=base_url('teacher/timings/exam/timingslist')?>">Exam Timetable</a></li>
							
                            <li <?php if($url == 'teacher/exams/resultsupload'){ ?> class="active" <?php } ?>><a href="<?=base_url('teacher/exams/resultsupload')?>">Upload Marks</a></li>
                            
                            <li <?php if($url == 'teacher/exams/upload/studentsmarkslist'){ ?> class="active" <?php } ?>><a href="<?=base_url('teacher/exams/upload/studentsmarkslist')?>">Uploaded Marks</a></li>
                            
							<li <?php if($url == 'teacher/exams/uploaded/resultslist'){ ?> class="active" <?php } ?>><a href="<?=base_url('teacher/exams/uploaded/resultslist')?>">Results List</a></li>
						</ul>
					</li>
					<li><a href="<?=base_url('teacher/profile')?>"><i class="fa fa-user"></i> <span>profile</span></a></li>
                    
				<?php }else if($sessiondata['type'] == 'admin' || $sessiondata['type'] == 'superadmin'){ ?>

                    <li <?php if($url == 'dashboard'){?>class="active"<?php } ?>><a href="<?=base_url('dashboard')?>"><i class="fa fa-th-large"></i><span>Dashboard</span></a></li>

                    <li class="has-sub <?php if($url == 'dashboard/frontoffice/visiters' || $url == 'dashboard/enote' || $url == 'dashboard/enquiry/newenquiry' || $url == 'dashboard/setupfrontoffice'){?>active<?php } ?>">
                        <a href="javascript:;">
                            <b class="caret"></b>
                            <i class="fa fa-university"></i>
                            <span>Front Office <!-- <span class="label label-theme m-l-5"></span> --></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="<?php if($url == 'dashboard/frontoffice/visiters'){?>active<?php } ?>"><a href="<?=base_url('dashboard/frontoffice/visiters')?>">Visiters</a></li>
                            <li class="<?php if($url == 'dashboard/enote'){?>active<?php } ?>"><a href="<?=base_url('dashboard/enote')?>">eNote</a></li>
                            <li class="<?php if($url == 'dashboard/enquiry/newenquiry'){?>active<?php } ?>"><a href="<?=base_url('dashboard/enquiry/newenquiry')?>">Admission Enquiry</a></li>
                            <li class="<?php if($url == 'dashboard/setupfrontoffice'){?>active<?php } ?>"><a href="<?=base_url('dashboard/setupfrontoffice')?>">Setup Front Office</a></li>
                        </ul>
                    </li>

                    <li class="has-sub">
                        <a href="javascript:;">
                            <b class="caret"></b>
							<i class="fas fa-school"></i>
                            <span>Branchs <!-- <span class="label label-theme m-l-5"></span> --></span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="<?=base_url('dashboard/branch/newbranch')?>">New Branch</a></li>
                            <li><a href="<?=base_url('dashboard/branch/branchlist')?>">Branch List</a></li>
                        </ul>
                    </li>
                    
                    <li class="has-sub">
                        <a href="javascript:;">
                            <b class="caret"></b>
                            <i class="fa fa-users"></i>
                            <span>Admissions</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="<?=base_url('dashboard/admissions/newadmissions')?>">New Admission</a></li>
                            <li><a href="<?=base_url('dashboard/admissions/admissionslist')?>">Admission List</a></li>
                        </ul>
                    </li>

                    <li class="has-sub">
                        <a href="javascript:;">
                            <b class="caret"></b>
                            <i class="fa fa-user-md"></i>
                            <span>Employee</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="<?=base_url('dashboard/employee/newemployee')?>">New Employee</a></li>
                            <li><a href="<?=base_url('dashboard/employee/employeelist')?>">Employee List</a></li>
                        </ul>
                    </li>

                    <li><a href="<?=base_url('dashboard/useraccounts')?>"><i class="fa fa-user-plus"></i><span>User Accounts</span></a></li>

                    <li class="has-sub">
                        <a href="javascript:;">
                            <b class="caret"></b>
							<i class="fas fa-columns"></i>
                            <span>Notice Board</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="<?=base_url('dashboard/notice/addnotice')?>">New Notice</a></li>
                            <li><a href="<?=base_url('dashboard/notice/noticelist')?>">Notice List</a></li>
                        </ul>
                    </li>

					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-files-o"></i>
							<span>Daily Reports <!-- <span class="label label-theme m-l-5"></span> --></span>
						</a>
						<ul class="sub-menu">
							<li class=""><a href="<?=base_url('dashboard/reports/addreport')?>">Send Reports</a></li>
							<li class=""><a href="<?=base_url('dashboard/reports/reportslist')?>">Reports List</a></li>
						</ul>
					</li>

					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-files-o"></i>
							<span>Homework Reports<!-- <span class="label label-theme m-l-5"></span> --></span>
						</a>
						<ul class="sub-menu">
                            <li class=""><a href="<?=base_url('dashboard/reports/newdailyhomeworks')?>">Homework Dairy</a></li>
                            <li class=""><a href="<?=base_url('dashboard/reports/homeworkslist')?>">Homeworks List</a></li>
						</ul>
					</li>
			
					<li><a href="<?=base_url('user/mail/inbox')?>" target="_blank"><i class="fa fa-envelope"></i> <span>Mail box </span></a></li>

					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fas fa-user-clock"></i>
							<span>Timings</span>
						</a>
						<ul class="sub-menu">
							<li><a href="<?=base_url('dashboard/timings/set_timings')?>">Set Timings</a></li>
							<li><a href="<?=base_url('dashboard/timings')?>">Timings List</a></li>
						</ul>
					</li>

                    <li><a href="<?=base_url('dashboard/academiccalendar')?>"><i class="fa fa-calendar"></i><span>Calendar</span></a></li>

                    <li class="has-sub">
                        <a href="javascript:;">
                            <b class="caret"></b>
                            <i class="fa fa-bolt"></i>
                            <span>Attendence</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="<?=base_url('dashboard/attendence/newadd')?>">New Attendance</a></li>
                            <li><a href="<?=base_url('dashboard/attendence/attendencelist')?>">Attendence List</a></li>
                        </ul>
                    </li>

					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fas fa-file-invoice"></i>
							<span>Examination's</span>
						</a>
						<ul class="sub-menu">
							<li><a href="<?=base_url('dashboard/timings/exam/timingslist')?>">Exam Timetable</a></li>
							<li><a href="<?=base_url('dashboard/exams/resultsupload')?>">Results Upload</a></li>
							<li><a href="<?=base_url('dashboard/exams/uploaded/resultslist')?>">Results List</a></li>
						</ul>
					</li>

                    <li class="has-sub">
                        <a href="javascript:;">
                            <b class="caret"></b>
							<i class="fas fa-chart-line"></i>
                            <span>Fee Payment's</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="<?=base_url('dashboard/feepayments/feepayment')?>">Collect Fee</a></li>
                            <li><a href="<?=base_url('dashboard/feepayments/feepaymentlist')?>">Fee Payment List</a></li>
                            <!--<li><a href="<?//=base_url('dashboard/feepayments/feestatements')?>">Fee Statement's</a></li>-->
                        </ul>
                    </li>

                    <li class="has-sub">
                        <a href="javascript:;">
                            <b class="caret"></b>
							<i class="fas fa-chart-area"></i>
                            <span>Salary Payment's</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="<?=base_url('dashboard/salary/salarypayment')?>">Salary Payment</a></li>
                            <li><a href="<?=base_url('dashboard/salary/salarypaymentlist')?>">Salary List</a></li>
                            <!--<li><a href="<?//=base_url('dashboard/feepayments/feestatements')?>">Fee Statement's</a></li>-->
                        </ul>
                    </li>

                    <li class="has-sub">
                        <a href="javascript:;">
                            <b class="caret"></b>
							<i class="fas fa-chart-pie"></i>
                            <span>Expenses</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="<?=base_url('dashboard/expenses')?>">Add Expense</a></li>
                            <!--<li><a href="<?//=base_url('dashboard/expenses/expensesarch')?>">Search Expense</a></li>-->
                            <li><a href="<?=base_url('dashboard/expenses/setup')?>">Expense Setup</a></li>
                            <!--<li><a href="<?//=base_url('dashboard/feepayments/feestatements')?>">Fee Statement's</a></li>-->
                        </ul>
                    </li>

                    <li class="nav-header">SETTINGS,BACKUP'S &amp; OTHERS</li>

                    <li class="has-sub">
                        <a href="javascript:;">
                            <b class="caret"></b>
                            <i class="fa fa-cogs"></i>
                            <span>Settings</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="<?=base_url('setup/classes')?>">Classes</a></li>
                            <li><a href="<?=base_url('setup/sections')?>">Sections</a> </li>
                            <li><a href="<?=base_url('setup/subjects')?>">Subjects</a></li>
                            <li><a href="<?=base_url('setup/feedetails')?>">SetFee Payments</a></li>
                        </ul>
                    </li>

                    <li class="has-sub">
                        <a href="javascript:;">
                            <b class="caret"></b>
                            <i class="fa fa-cloud"></i>
                            <span>Import & Export</span>
                        </a>
                        <ul class="sub-menu">
                            <!--<li><a href="#">Import Data</a></li>-->
                            <li><a href="<?=base_url('dashboard/data/exportdata')?>">Export Data</a></li>
                        </ul>
                    </li>

                    <li><a href="<?=base_url('dashboard/profile')?>"><i class="fa fa-user"></i><span>Profile</span></a></li>

                <?php } ?>
            <!-- <li class="has-sub">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fa fa-table"></i>
                    <span>Tables</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="table_basic.html">Basic Tables</a></li>
                    <li class="has-sub">
                        <a href="javascript:;"><b class="caret pull-right"></b> Managed Tables</a>
                        <ul class="sub-menu">
                            <li><a href="table_manage.html">Default</a></li>
                            <li><a href="table_manage_autofill.html">Autofill</a></li>
                            <li><a href="table_manage_buttons.html">Buttons</a></li>
                            <li><a href="table_manage_colreorder.html">ColReorder</a></li>
                            <li><a href="table_manage_fixed_columns.html">Fixed Column</a></li>
                            <li><a href="table_manage_fixed_header.html">Fixed Header</a></li>
                            <li><a href="table_manage_keytable.html">KeyTable</a></li>
                            <li><a href="table_manage_responsive.html">Responsive</a></li>
                            <li><a href="table_manage_rowreorder.html">RowReorder</a></li>
                            <li><a href="table_manage_scroller.html">Scroller</a></li>
                            <li><a href="table_manage_select.html">Select</a></li>
                            <li><a href="table_manage_combine.html">Extension Combination</a></li>
                        </ul>
                    </li>
                </ul>
            </li> -->
            
            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
