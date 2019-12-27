<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] 									= 	'Login'; //dashboard
$route['404_override'] 											= 	'My404error';
$route['translate_uri_dashes'] 									= 	FALSE;

$route['demos/mailtemplates']									=	'Dashboard/mailtemplatedemo';
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~register and login urls~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
$route['user/loginAccess']                                      =   'Login/loginAccessAccount';
$route['registeraccount']                                       =   'Login/registerAccount';
$route['saveregisteraccount']                                   =   'Login/newRegisterAccount';
$route['register/conformaccount']                               =   'Login/conformaccount';
$route['register/conformmanualregister']                        =   'Login/conformmanualregister';
$route['changecredentials']                                     =   'Login/ChangePassword';
$route['setup/savechangepassword']                              =   'Login/saveChangePassword';
$route['setup/createpinnumber']                                 =   'Login/saveChangePinNumber';
$route['logout']                                                =   'Login/logout';
$route['logout/access']                                         =   'Login/logoutaccesspage';

$route['users/forgetpassword']									=	'Forget_password/forgetpassword';
$route['users/save/forgetpassword/request']						=	'Forget_password/savepasswordrequest';
$route['users/changepassword/:num/:any/:any/:num/:any']			=	'Forget_password/Changepassword';
$route['users/savenewchangepassword']							=	'Forget_password/saveChangePassword';


$route['users/forgetpin']										=	'Forget_password/Forgetpin';
$route['users/save/forgetpin/request']							=	'Forget_password/savePinRequest';
$route['users/changepin/:num/:any/:any/:num/:any']				=	'Forget_password/ChangePin';
$route['users/savenewchangepin']								=	'Forget_password/saveChangePin';
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~Setup Details~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
$route['setup/setschooldetails']                                =   'setup/setschooldetails';
$route['setup/academicdetails']                                 =   'setup/academicdetails';
$route['setup/saveschoolacademicdetails']                       =   'setup/saveschoolacademicdetails';
$route['sessionlocked'] 										= 	'Defaultmethods/lockscreen';
$route['unlockscreen'] 											= 	'Defaultmethods/lockscreentounlock';
$route['setup/classes']                                         =   'setup/classdetails';
$route['setup/sections']                                        =   'setup/classSections';
$route['setup/subjects']                                        =   'setup/subjectsdetails';
$route['setup/feedetails']                                      =   'setup/feedetails';
$route['setup/enableanddisablesyllabus']						=	'setup/enableandDisable';
$route['setup/divideclasssections']								=	'setup/DivideClassSections';
$route['setup/sections/delete/:num/:any/:any']					=	'setup/DeletesectiononList';
$route['setup/classDefaultsubjects']							=	'setup/classDefaultsubjects';
$route['setup/savedefaultsubjects']								=	'setup/saveDefaultsubjects';
$route['setup/subjects/delete/:num/:any/:any']					=	'setup/DeleteDefaultSubjects';
$route['setup/subjects/assignlistsubjectsajax']					=	'setup/AssignListSubjectsAjax';
$route['setup/savedefaultassignsubjects']						=	'setup/SaveAssignDefaultSubjects';
$route['setup/assignsubjects/delete/:num/:any/:any']			=	'setup/DeleteAssignSubjects';
$route['setup/feedetails/feedetailsfieldsajaxs'] 				=	'setup/feedetailsfieldsajaxs';
$route['setup/feedetails/delete/:num/:any/:any']				=	'setup/FeeRecordsDelete';
$route['setup/feedetails/:num/updataFeeRecordData']				=	'setup/updataFeeRecordData';

$route['dashboard/class/sectionslist']							=	'Defaultmethods/SectionsList';

//Main Notification Alert
$route['all/notification/datalist']						=	'Defaultmethods/NotificationsDataList';
$route['all/notification/datacountlist']				=	'Defaultmethods/NotificationsDatacountList';


//dashboard for all
$route['dashboard']                                             =   'dashboard';
$route['student/dashboard']                                     =   'dashboard';
$route['parents/dashboard']                                     =   'dashboard'; // feature opp *
$route['classteacher/dashboard']                                =   'dashboard';
$route['teacher/dashboard'] 	                                =   'dashboard';
$route['accountant/dashboard'] 	                                =   'dashboard';

//search option
$route['dashboard/data/search']									=	'Sms_searchdata/SearchResult';
$route['dashboard/data/searchResult']							=	'Sms_searchdata/SearchResult';

//profile
$route['dashboard/profile'] 									= 	'Sms_profile/profilepage';
$route['dashboard/profile/updateprofiledata/:num']              =   'Sms_profile/updateProfileData';
$route['dashboard/profile/updatepassword/:num']                 =   'Sms_profile/updatePassword';
$route['dashboard/profile/updateschooldetails/:num']            =   'Sms_profile/updateSchooldetails';

//branchs
$route['dashboard/branch/newbranch'] 							= 	'Sms_branchs';
$route['dashboard/branch/newbranch/saveregister'] 				= 	'Sms_branchs/SaveBranchDetails';
$route['dashboard/branch/saveeditbranchdetails'] 				= 	'Sms_branchs/saveeditbranchdetails';
$route['dashboard/branch/branchlist'] 							= 	'Sms_branchs/branchlist';
$route['dashboard/branch/branchdetails/(:num)/:any'] 			= 	'Sms_branchs/branchdetailsview';
$route['dashboard/branch/editbranchdetails/(:num)/:any/:any'] 	= 	'Sms_branchs/branchdetailsedit';
$route['dashboard/branch/accountonoff/(:num)/:any/:any']		=	'Sms_branchs/accountonoff';
$route['dashboard/branch/deleteaccount/(:num)/:any/:any']       =	'Sms_branchs/DeleteBranchDataList';
$route['dashboard/branch/restoredata/:num/:any/:any']			=	'Sms_branchs/RestoreBranchData';
$route['dashboard/branch/deleterecent/:num/:any/:any']			=	'Sms_branchs/DeleteRecentBranch';

//setupfrontoffice - enote, visiters, enquery details,...
$route['dashboard/enote'] 										= 	'Sms_enote/enote';
$route['dashboard/enote/savenewenote'] 							= 	'Sms_enote/savenewenote';
$route['dashboard/enote/:any'] 									= 	'Sms_enote/enote';
$route['dashboard/setupfrontoffice']                            =   'Sms_front_office/setupfrontoffice';
$route['dashboard/setupfrontoffice/visiters/add']               =   'Sms_front_office/visiterSetup';
$route['dashboard/setupfrontoffice/edit/:any']                  =   'Sms_front_office/visiterEditSetup';
$route['dashboard/frontoffice/visiters']                        =   'Sms_front_office/visiters';
$route['dashboard/frontoffice/visiters/save']                   =   'Sms_front_office/visitersDataSave';
$route['dashboard/frontoffice/visiters/edit/:num']              =   'Sms_front_office/visitersDataEdit';
$route['dashboard/frontoffice/visiters/delete/:num']            =   'Sms_front_office/visiterDataDelete';
$route['dashboard/frontoffice/visiters/timeout/:num/:num']      =   'Sms_front_office/visitertimeout';

//Sms_enquiry
$route['dashboard/enquiry/newenquiry'] 							= 	'Sms_enquiry/enquiry';
$route['dashboard/enquiry/enquirylist'] 						= 	'Sms_enquiry/enquirylist';
$route['dashboard/enquiry/save'] 								= 	'Sms_enquiry/SaveEnquiryDetails';
$route['dashboard/enquiry/delete/:num/:any/:any'] 				= 	'Sms_enquiry/deletedata';
$route['dashboard/enquiry/edit/:num/:any/:any'] 				= 	'Sms_enquiry/editdata';
$route['dashboard/enquiry/saveupdates'] 						= 	'Sms_enquiry/saveupdates';
$route['dashboard/enquiry/details/:num/:any/:any']				=	'Sms_enquiry/enquiryDetails';

//admissions
$route['dashboard/admissions/newadmissions'] 					= 	'Sms_admission';
$route['dashboard/admissions/admissionslist'] 					= 	'Sms_admission/admissionlist';
$route['dashboard/admissions/saveadmissions'] 					= 	'Sms_admission/saveadmissions';
$route['dashboard/enquiry/admission/:num/:any/:any']			=	'Sms_admission/admissionbyenquiry';
$route['dashboard/admission/delete/:num/:any/:any']				= 	'Sms_admission/deletedata';
$route['dashboard/admission/edit/:num/:any/:any']				=	'Sms_admission/editadmission';
$route['dashboard/admission/saveeditadmission']					=	'Sms_admission/saveeditadmissions';
$route['dashboard/admission/details/:num/:any/:any']			=	'Sms_admission/admissionsdetails';
$route['dashboard/admission/details/:num/:any/:any/:any']		=	'Sms_admission/admissionsdetails';


//employee's
$route['dashboard/employee/newemployee'] 						= 	'Sms_employee/employee';
$route['dashboard/employee/employeelist'] 						= 	'Sms_employee/employeelist';
$route['dashboard/employee/saveemployeedata'] 					= 	'Sms_employee/employeesavedata';
$route['dashboard/employee/edit/:num/:any/:any']				=	'Sms_employee/editemployee';
$route['dashboard/employee/saveeditemployeedata']               =   'Sms_employee/saveEditemployeedata';
$route['dashboard/employee/delete/:num/:any/:any']				= 	'Sms_employee/deletedata';
$route['dashboard/employee/details/:num/:any/:any']				=	'Sms_employee/employeedetails';
$route['dashboard/employee/details/:num/:any/:any/:any']		=	'Sms_employee/employeedetails';
$route['dashboard/employee/syllabus/getclass']					=	'Defaultmethods/GetClassForSyllabus';
$route['dashboard/employee/syllabus/Assignclass']				=	'Defaultmethods/AssignClassForSyllabus';
$route['dashboard/employee/syllabus/SaveAssignclass']			=	'Sms_employee/SaveAssignClass';
$route['dashboard/employee/syllabus/getSubjects']				=	'Defaultmethods/GetClassSubjectsForSyllabus';
$route['dashboard/employee/classteacherstatus']					=	'Sms_employee/classteacherexitsatus';

$route['dashboard/employee/syllabus/getselSubjects']				=	'Defaultmethods/GetClassSubjectsSelSyllabus';

//Timings
$route['dashboard/timings']                                     =   'Sms_timings/timings';
$route['dashboard/timings/set_timings']                         =   'Sms_timings/SetNewtimings';
$route['dashboard/timings/ajax/timingsfields']                  =   'Sms_timings/timingsFields';
$route['dashboard/timings/savetimingsdata']                     =   'Sms_timings/SavetimingsFields';
$route['dashboard/timings/classsubjectstimingslist']			=	'Sms_timings/ClassSubjectsTimingsList';
$route['dashboard/timings/ExistingDataDetails']					=	'Sms_timings/ExistingDataDetails';
$route['dashboard/timings/examinationsubjectstimingslist']      =	'Sms_timings/ExaminationTimingslist';
$route['dashboard/timings/classtiming/delete/:num/:any/:any/:any/:any']   = 'Sms_timings/DeleteAllclassTimetable';
$route['dashboard/timings/classtimings/delete/:num/:num/:any/:any/:any/:any']   = 'Sms_timings/DeleteclassTimetable';
$route['dashboard/timings/bus/delete/:num/:any/:any/:any'] 		= 'Sms_timings/DeleteBusTimingsData';

//examination Timings
$route['dashboard/timings/exam/timingslist']					=	'Sms_timings/ExaminationTimingslistDetails';
$route['dashboard/timings/exam/deleteexamtimings/:num/:any/:any'] =	 'Sms_timings/DeleteExamTimetable';
$route['dashboard/timings/exam/deleteslabs/:num/:any/:any/:any']  =  'Sms_timings/DeleteExaminationSlabsData';
$route['dashboard/exams/resultsupload']							=	'Sms_ExamsData/ResultsUpload';
$route['dashboard/exams/studentslistTouplaod']					=	'Sms_ExamsData/StudentsListToUpload';
$route['dashboard/upload/results/:num/:num/:any/:any/:any']		=	'Sms_ExamsData/UploadStudentMarks';
$route['dashboard/upload/results/uplaodData']					=	'Sms_ExamsData/UplaodResultData';
$route['dashboard/exams/uploaded/resultslist'] 					=	'Sms_ExamsData/UploadedResultsList';
$route['dashboard/exam/deleteresultlist/:num/:any/:any']		=	'Sms_ExamsData/DeleteExamResultData';

//attendence
$route['dashboard/attendence/newadd']                           =   'Sms_attendence/addnewAttendence';
$route['dashboard/attendence/ajax/stdattendancesave']           =   'Sms_attendence/stdattendanceSave';
$route['dashboard/attendence/ajax/empattendancesave']           =   'Sms_attendence/empattendanceSave';
$route['dashboard/attendence/ajax/attendancedatafetch']         =   'Sms_attendence/attendanceDatafetch';
$route['dashboard/attendence/attendencelist']                   =   'Sms_attendence/attendenceList';
$route['dashboard/attendence/ajax/attendancedatalistfetch']     =   'Sms_attendence/attendanceDatalistfetch';

//useraccounts
$route['dashboard/useraccounts']                                =   'Sms_useraccounts';
$route['dashboard/useraccounts/fieldssetajax']                  =   'Sms_useraccounts/fieldssetajax'; //ajax
$route['dashboard/useraccounts/smsuseraccountdataajax']         =   'Sms_useraccounts/smsuseraccountdataajax'; //ajax
$route['dashboard/useraccounts/usernamecheck']                  =   'Sms_useraccounts/usernamecheck';          //ajax
$route['dashboard/useraccounts/useraccountoffon']               =   'Sms_useraccounts/useraccountoffon';
$route['dashboard/useraccounts/savedata']                       =   'Sms_useraccounts/saveuseraccountdata';
$route['dashboard/useraccounts/newaccount']                     =   'Sms_useraccounts/newaccount';

//notice
$route['dashboard/notice/addnotice']                            =   'Sms_notice/addNotice';
$route['dashboard/notice/savenotice']                           =   'Sms_notice/savenotice';
$route['dashboard/notice/deletenotice/:any']                    =   'Sms_notice/deletenotice';
$route['dashboard/notice/edit/:any/:any']                       =   'Sms_notice/editNotice';
$route['dashboard/notice/saveeditnotice']                       =   'Sms_notice/saveEditNotice';
$route['dashboard/notice/:any']                                 =   'Sms_notice/Noticedetails';
$route['dashboard/notice/noticelist']                           =   'Sms_notice/noticeList';

//reports
$route['dashboard/reports/addreport']							=	'Sms_reports/AdminAddReports';
$route['dashboard/reports/addrepresentslist']					=	'Sms_reports/addRepresentsList';
$route['dashboard/reports/reportslist']							=	'Sms_reports/AdminReportsList';

//daily homeworks reports
$route['dashboard/reports/newdailyhomeworks']					=	'Sms_reports/addNewHomeworkReport';
$route['dashboard/reports/dairySubjectsList']					=	'Sms_reports/dairySubjectsList';
$route['dashboard/reports/saveHomeworkDetails']					=	'Sms_reports/saveHomeworkDetails';
$route['dashboard/reports/publishHwreport/:num/:num/:any']		=	'Sms_reports/publishUnpublishHwReport';
$route['dashboard/reports/UnpublishHwreport/:num/:num/:any']	=	'Sms_reports/publishUnpublishHwReport';
$route['dashboard/reports/homeworkslist']						=	'Sms_reports/homeworkReportsList';
$route['dashboard/reports/homework/:num/delete']                =	'Sms_reports/deleteHomeworkReport';
$route['dashboard/reports/saveEditHomeworkDetails']					=	'Sms_reports/saveEditHomeworkDetails';

//acdamic calender
$route['dashboard/academiccalendar']							=	'Sms_academiccalendar/academiccalendar';
$route['dashboard/academiccalendar/calendaraddEvent']           =   'Sms_academiccalendar/calendaraddEvent';
$route['dashboard/academiccalendar/calendareditEvent']          =   'Sms_academiccalendar/calendareditEvent';
$route['dashboard/academiccalendar/changeEventdates']           =   'Sms_academiccalendar/changeEventdates';

//fee payments
$route['dashboard/feepayments/feepayment']                      =   'Sms_feepayments/feepayment';
$route['dashboard/feepayments/ajax/addmissionlist']             =   'Sms_feepayments/admissionDetailsList';
$route['dashboard/feepayments/makefeepayment']                  =   'Sms_feepayments/makeFeepayment';
$route['dashboard/feepayments/savemakepayments']                =   'Sms_feepayments/savemakePayments';
$route['dashboard/feepayments/feepaymentlist']                  =   'Sms_feepayments/feePaymentList';
$route['dashboard/feepayments/feepaymentdetails/:any/:any/:any']=   'Sms_feepayments/feepaymentDetails';
$route['dashboard/feepayments/feestatements']                   =   'Sms_feepayments/feeStatements';
$route['dashboard/feepayments/onlinepayment/:any/:any/:any']	=	'PaymentPayuMoney/check';
$route['dashboard/feepayments/onlinepayment/status']			=	'StatusPayuMoney';

//Expenses
$route['dashboard/expenses']                                    =   'Sms_expenses/expenses';
$route['dashboard/expenses/edit/:num/:any']                     =   'Sms_expenses/expensesEdit';
$route['dashboard/expenses/expenseEditSavedata']                =   'Sms_expenses/expenseEditSavedata';
$route['dashboard/expenses/delete/:num/:any']                   =   'Sms_expenses/expensesDelete';
$route['dashboard/expenses/expenseSavedata']                    =   'Sms_expenses/expenseSavedata';
$route['dashboard/expenses/download/:num/:any']				    =	'Sms_expenses/expenseUploadfile';
$route['dashboard/expenses/expensesarch']                       =   'Sms_expenses/expensesarch';
$route['dashboard/expenses/setup']                              =   'Sms_expenses/expenseSetup';
$route['dashboard/expenses/saveSetup']                          =   'Sms_expenses/expenseSaveSetup';

//salary list
$route['dashboard/salary/salarypayment']                        =  'Sms_salarypayments/salarypayments';
$route['dashboard/salary/salarypaymentlist']                    =  'Sms_salarypayments/salarypaymentlist';

$route['dashboard/salary/ajax/employeelist']               =   'Sms_salarypayments/employeeDetailsList';
$route['dashboard/salary/makesalarypayment']               =   'Sms_salarypayments/makesalarypayment';
$route['dashboard/salary/savemakepayments']                =   'Sms_salarypayments/savemakePayments';
$route['dashboard/salary/salarypaymentdetails/:any/:any/:any']=   'Sms_salarypayments/salarypaymentDetails';
$route['dashboard/salary/feestatements']                   =   'Sms_salarypayments/feeStatements';

//import and export
$route['dashboard/data/exportdata']                        =   'Sms_importexport/exportData';
$route['dashboard/data/sendrequest']                       =   'Sms_importexport/RequestSendData';
$route['dashboard/data/downloadadmissions']                =   'Sms_importexport/createXLS';
$route['dashboard/data/downloadenquirydata']               =   'Sms_importexport/enquiryexportxls';
$route['dashboard/data/downloadfeepaymentdata/:any']       =   'Sms_importexport/feepaymentsexportxls';
$route['dashboard/data/downloadsalarypaymentdata/:any']    =   'Sms_importexport/salarypaymentsexportxls';

//mailbox
$route['user/mail/inbox']									=	'My_mailbox/mailinbox';
$route['user/mail/inbox/:any']								=	'My_mailbox/mailinbox';
$route['user/mail/composemail'] 							=	'My_mailbox/composemail';
$route['user/mail/savecomposemail'] 						=	'My_mailbox/savecomposemaildata';
$route['user/mail/important']								=	'My_mailbox/importantMails';
$route['user/mail/sent']									=	'My_mailbox/sentmails';
$route['user/mail/draft']									=	'My_mailbox/mailinbox';
$route['user/mail/trash']									=	'My_mailbox/trashmailsList';
$route['user/mail/details/:num/:any/:any/:any']				=	'My_mailbox/mailDetails';
$route['user/mail/reply/:num/:any/:any/:num/:any']			=	'My_mailbox/mailReplymail';
$route['user/mail/savereplymaildata']						=	'My_mailbox/savereplymaildata';

$route['user/mail/trash/inboxmails']						=	'My_mailbox/trashInboxMails';
$route['user/mail/important/inboxmails']					=	'My_mailbox/importantmailsList';
$route['user/mail/trash/permentdeletemails']				=	'My_mailbox/PermentTrashMails_Delete';
$route['user/mail/trash/restoredeletemails']				=	'My_mailbox/RestoreTrashMails_Delete';
$route['user/mail/trash/permentdeletesentmails']			=	'My_mailbox/Perment_DeleteSentmails';



$route['user/mail/notifications']							=	'My_mailbox/mailNotificationslist';
$route['user/mail/notificationscountlist']					=	'My_mailbox/mailNotificationscountlist';
$route['user/mail/inboxajaxdata']							=	'My_mailbox/mailInboxDataList';


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Classteacher & teacher Login ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$route['classteacher/studentslist']							=	'Sms_classteacher_teacher/StudentsList';
$route['classteacher/studentslist/details/:num/:any/:any']	=	'Sms_classteacher_teacher/StudentDetails';
$route['classteacher/studentslist/details/:num/:any/:any/:any']  =	'Sms_classteacher_teacher/StudentDetails';
$route['classteacher/CheckAssignSecRollNo']				=	'Sms_classteacher_teacher/CheckAssignSecRollNo';
$route['classteacher/studentslist/AssignSecRollNo']		=	'Sms_classteacher_teacher/AssignSecRollNo';
$route['classteacher/employeelist']						=	'Sms_classteacher_teacher/EmployeesList';
$route['classteacher/academiccalendar']					=	'Sms_classteacher_teacher/AcademicCalendar';
$route['classteacher/notices']							=	'Sms_classteacher_teacher/NoticesList';
$route['classteacher/employee/details/:num/:any/:any']			=	'Sms_classteacher_teacher/employeedetails';
$route['classteacher/employee/details/:num/:any/:any/:any']		=	'Sms_classteacher_teacher/employeedetails';
$route['classteacher/notice/:any']                       =   'Sms_classteacher_teacher/Noticedetails';
$route['classteacher/notices']                           =   'Sms_classteacher_teacher/NoticesList';
$route['classteacher/timingslist']                       =   'Sms_classteacher_teacher/timings';
$route['classteacher/academiccalendar']					 =	 'Sms_classteacher_teacher/academiccalendar';
$route['classteacher/attendence/newadd']                       =   'Sms_classteacher_teacher/addnewAttendence';
$route['classteacher/attendence/ajax/stdattendancesave']       =   'Sms_classteacher_teacher/stdattendanceSave';
$route['classteacher/attendence/ajax/empattendancesave']       =   'Sms_classteacher_teacher/empattendanceSave';
$route['classteacher/attendence/ajax/attendancedatafetch']     =   'Sms_classteacher_teacher/attendanceDatafetch';
$route['classteacher/attendence/attendencelist']               =   'Sms_classteacher_teacher/attendenceList';
$route['classteacher/attendence/ajax/attendancedatalistfetch'] =   'Sms_classteacher_teacher/attendanceDatalistfetch';
$route['classteacher/timings/exam/timingslist']		=	'Sms_classteacher_teacher/ExaminationTimingslistDetails';
$route['classteacher/exams/resultsupload']					='Sms_classteacher_teacher/ResultsUpload';
$route['classteacher/exams/studentslistTouplaod']			='Sms_classteacher_teacher/StudentsListToUpload';
$route['classteacher/upload/results/:num/:num/:any/:any/:any']='Sms_classteacher_teacher/UploadStudentMarks';
$route['classteacher/upload/results/uplaodData']			='Sms_classteacher_teacher/UplaodResultData';
$route['classteacher/exams/uploaded/resultslist'] 			='Sms_classteacher_teacher/UploadedResultsList';
$route['classteacher/exam/deleteresultlist/:num/:any/:any']	='Sms_classteacher_teacher/DeleteExamResultData';
$route['classteacher/profile']								=	'Sms_classteacher_teacher/userprofileDetails';
$route['classteacher/profile/updateprofiledata/:num']       =   'Sms_classteacher_teacher/updateProfileData';
$route['classteacher/profile/updatepassword/:num']          =   'Sms_classteacher_teacher/updatePassword';
$route['classteacher/profile/updateschooldetails/:num']     =   'Sms_classteacher_teacher/updateSchooldetails';


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Teacher Login Links ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$route['teacher/studentslist']							=	'Sms_teacher/StudentsList';
$route['teacher/studentslist/details/:num/:any/:any']	=	'Sms_teacher/StudentDetails';
$route['teacher/studentslist/details/:num/:any/:any/:any']  =	'Sms_teacher/StudentDetails';
$route['teacher/CheckAssignSecRollNo']				=	'Sms_teacher/CheckAssignSecRollNo';
$route['teacher/studentslist/AssignSecRollNo']		=	'Sms_teacher/AssignSecRollNo';
$route['teacher/employeelist']						=	'Sms_teacher/EmployeesList';
$route['teacher/academiccalendar']					=	'Sms_teacher/AcademicCalendar';
$route['teacher/notices']							=	'Sms_teacher/NoticesList';
$route['teacher/employee/details/:num/:any/:any']			=	'Sms_teacher/employeedetails';
$route['teacher/employee/details/:num/:any/:any/:any']		=	'Sms_teacher/employeedetails';
$route['teacher/notice/:any']                       =   'Sms_teacher/Noticedetails';
$route['teacher/notices']                           =   'Sms_teacher/NoticesList';
$route['teacher/timingslist']                       =   'Sms_teacher/timings';
$route['teacher/academiccalendar']					 =	 'Sms_teacher/academiccalendar';
$route['teacher/attendence/newadd']                       =   'Sms_teacher/addnewAttendence';
$route['teacher/attendence/ajax/stdattendancesave']       =   'Sms_teacher/stdattendanceSave';
$route['teacher/attendence/ajax/empattendancesave']       =   'Sms_teacher/empattendanceSave';
$route['teacher/attendence/ajax/attendancedatafetch']     =   'Sms_teacher/attendanceDatafetch';
$route['teacher/attendence/attendencelist']               =   'Sms_teacher/attendenceList';
$route['teacher/attendence/ajax/attendancedatalistfetch'] =   'Sms_teacher/attendanceDatalistfetch';
$route['teacher/timings/exam/timingslist']		        =	'Sms_teacher/ExaminationTimingslistDetails';
$route['teacher/exams/resultsupload']					=   'Sms_teacher/ResultsUpload';
$route['teacher/exams/studentslistTouplaod']			=   'Sms_teacher/StudentsListToUpload';
$route['teacher/exams/studentslistTouplaodmarksdata']	=   'Sms_teacher/StudentsListToUploadMarksData';
$route['teacher/upload/results/:num/:num/:any/:any/:any']= 'Sms_teacher/UploadStudentMarks';
$route['teacher/upload/results/uplaodData']			     =   'Sms_teacher/UplaodResultData';
$route['teacher/exams/uploaded/resultslist'] 			=   'Sms_teacher/UploadedResultsList';
$route['teacher/exam/deleteresultlist/:num/:any/:any']	=   'Sms_teacher/DeleteExamResultData';
$route['teacher/profile']								=	'Sms_teacher/userprofileDetails';
$route['teacher/profile/updateprofiledata/:num']       =   'Sms_teacher/updateProfileData';
$route['teacher/profile/updatepassword/:num']          =   'Sms_teacher/updatePassword';
$route['teacher/profile/updateschooldetails/:num']     =   'Sms_teacher/updateSchooldetails';
$route['teacher/class/sectionslist']				   =   'Defaultmethods/SectionsList';
$route['teacher/exams/upload/studentsmarkslist']       =   'Sms_teacher/UploadedMarksList';

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~Student Session~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
$route['student/dashboard/mydetails']					=	'Sms_students/MyInformationDetails';
$route['student/dashboard/notification']				=	'Sms_students/NoticesList';
$route['student/dashboard/notification/:any']			=	'Sms_students/Noticedetails';
$route['student/dashboard/academiccalendar']			=	'Sms_students/AcademicCalendar';
$route['student/dashboard/examtimings']					=	'Sms_students/ExaminationTimingslistDetails';
$route['student/dashboard/exams/results']				=	'Sms_students/UploadedMarksList';
$route['student/dashboard/timingslist']					=	'Sms_students/timings';
$route['student/dashboard/attendencereports']			=	'Sms_students/attendenceReports';
$route['student/profile']								=	'Sms_students/userprofileDetails';
$route['student/profile/updateprofiledata/:num']       	=   'Sms_students/updateProfileData';
$route['student/profile/updatepassword/:num']          	=   'Sms_students/updatePassword';
$route['student/dashboard/dairyworks']                  =   'Sms_students/dairyWorks';

