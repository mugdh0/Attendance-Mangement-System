<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', function(){
    return view('logono4');
});
//----Admin
Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'role:Super Admin|Admin|Employee'], function () {



//chart
	Route::get('/profitChart', 'ChartController@profitChart');



	//MyProfileController
	Route::get('my-profile', 'MyProfileController@myProfile')->name('my-profile');
	Route::post('update-my-profile', 'MyProfileController@updateMyProfile')->name('update-my-profile');


	//message
	Route::get('/app-inbox', 'MessageController@appInbox')->name('app-inbox');
	Route::get('/app-inbox/message-details/{id}', 'MessageController@msgDetails')->name('msg-details');
	Route::get('/app-compose', 'MessageController@appCompose')->name('app-compose');
	Route::post('/send-message', 'MessageController@sendMessage')->name('send-message');
	Route::get('app-inbox/send', 'MessageController@viewSendMessages')->name('view-send-messages');
	Route::get('delete-message/{id}', 'MessageController@deleteMessages')->name('delete-message');
	Route::get('messages/trashed', 'MessageController@trashedMsg')->name('trashed-msg');
	Route::get('delete-messages/trashed/{id}', 'MessageController@trashedMsgPermanentDelete')->name('delete-trashed-message');
	Route::get('draft-messages', 'MessageController@draftMessages')->name('draft-messages');
	Route::get('draft-msg/details/{id}', 'MessageController@draftMessagesDetails')->name('draft-msg-details');
	Route::get('restore/trashed-message/{id}', 'MessageController@restoreTrashedMessage')->name('restore-trashed-message');
	Route::get('add/favourite-message/{id}', 'MessageController@addMessageToFavourite')->name('msg-add-favourite');
	Route::get('favourite-messages', 'MessageController@favouriteMessages')->name('starred-msg-list');

	Route::post('search-mail', 'MessageController@searchMail')->name('search-mail');



	// Route::get('myproducts', 'ProductController@index');
	Route::delete('myproducts/{id}', 'MessageController@destroy');

	Route::delete('myMailsDeleteAll', 'MessageController@deleteAll');
	Route::delete('draftMailsDeleteAll', 'MessageController@deleteAllDraft');
	Route::delete('trashMailsDeleteAll', 'MessageController@deleteAllTrashedMail');
	Route::delete('trash-Mails/restore', 'MessageController@restoreAllTrashedMail');
	Route::post('read-all/message', 'MessageController@readAllMessage');
	Route::post('message/unread-all/', 'MessageController@unreadAllMessage');




	//EmployeesController
		
	Route::get('emp.generatereport/{month}/{year}', 'EmployeesController@generatereport')->name('generatereport');
	Route::get('emp.generatesummary/{month}/{year}', 'EmployeesController@generatesummary')->name('generatesummary');
  Route::post('emp.import', 'EmployeesController@import')->name('import');
  Route::post('emp.importemp', 'EmployeesController@importemp')->name('importemp');
  
  Route::get('users/export/', 'EmployeesController@export');

  Route::post('emp.importInOut', 'EmployeesController@importInOut')->name('importInOut');

  Route::post('emp.attendanceShort', 'EmployeesController@addAttendence')->name('addAttendence');
  Route::post('emp.attendanceShortupdate', 'EmployeesController@updateAttendence')->name('updateAttendence');
  Route::get('emp.attendanceShort/{id}', 'EmployeesController@deleteAttendence')->name('deleteAttendence');

  Route::get('emp.attendance', 'EmployeesController@empAttendance')->name('emp-attendance');
  Route::post('emp.attendance', 'EmployeesController@empAttendanceSrc')->name('emp-attendance');
  Route::get('emp.attendanceShort', 'EmployeesController@empAttendanceShort')->name('emp-attendance-short');
  Route::post('emp.attendanceShortSrc', 'EmployeesController@dailyempAttendance')->name('dailyempAttendance');

  Route::get('emp.attendanceShortSrc', 'EmployeesController@empAttendanceShort')->name('dailyempAttendance');

  Route::post('emp.update/paid_leave', 'EmployeesController@updatePaidLeave')->name('emp_update_paid_leave');

	Route::get('emp.empAttendancesrcs/{id}/{name}', 'EmployeesController@viewAttendenceDetails')->name('empAttendancesrcs');
  Route::post('emp.empAttendancesrcs/{id}/{name}', 'EmployeesController@viewAttendenceDetailsSP')->name('empAttendancesrcs');
  //Route::post('emp.empAttendancesrcs/{id}/{name}', 'EmployeesController@viewAttendenceDetailsSP')->name('emp.empAttendancesrcs');
	//Route::post('emp.empAttendancesrc', 'EmployeesController@empAttendancesrc')->name('emp-empAttendancesrc');
  // Route::post('emp.attendance', 'EmployeesController@empAttendancesrc')->name('emp-attendance');

	Route::get('employee.all', 'EmployeesController@empAll')->name('emp-all');
	Route::get('emp.leave', 'EmployeesController@empLeave')->name('emp-leave');
	Route::get('emp.departments', 'EmployeesController@empDepartments')->name('emp-departments');
	Route::post('emp.add-new-emp', 'EmployeesController@addNewEmp')->name('add-new-emp');
	Route::post('emp.edit-emp-info', 'EmployeesController@editEmpInfo')->name('edit-emp-info');
	Route::get('emp.delete-emp/{id}/{name}', 'EmployeesController@deleteEmp')->name('delete-emp');

	Route::post('emp.leave-request', 'EmployeesController@leaveRequest')->name('send-emp-leave-request');
	  Route::post('emp.leave-request', 'EmployeesController@storeleaveRequest')->name('store-emp-leave-request');
	  Route::post('emp.generate-leave', 'EmployeesController@generateLeave')->name('generate-emp-leave');
	  Route::post('emp.leave-update', 'EmployeesController@updateleaveRequest')->name('update-emp-leave-request');
	  Route::post('emp.leave-updateT', 'EmployeesController@updateleaveRequestT')->name('update-emp-leave-request2');

	Route::get('emp.accept-leave-request.paid/{id}/{name}', 'EmployeesController@acceptLeaveRequestWithPaid')->name('accept-leave-request-with-paid');

	Route::get('emp.accept-leave-request.unpaid/{id}/{name}', 'EmployeesController@acceptLeaveRequestWithUnpaid')->name('accept-leave-request-with-unpaid');
	Route::get('emp.reject-leave-request/{id}/{name}', 'EmployeesController@rejectLeaveRequest')->name('reject-leave-request');
	
	

	Route::get('emp.leave-report-preview', 'PayrollController@fullleavereport')->name('fullleavereport');
	Route::get('emp.leave-full-print', 'PayrollController@fullleavereportprint')->name('leave-full-print');
	

	Route::get('emp.app-new-user-list', 'EmployeesController@newEmployeeList');

	//UserController
	Route::get('emp.app-users', 'UserController@appUser')->name('app-users');
	Route::get('emp.view-user-details/{id}/{name}', 'UserController@viewUserDetails')->name('view-user-details');
	Route::post('emp.add-new-user', 'UserController@appUserAdd')->name('add-new-user');
	Route::post('emp.add-new-user-p', 'UserController@appUserAddP')->name('add-new-user-p');
	Route::post('emp.update-user-info', 'UserController@appUserUpdate')->name('update-user-info');
	Route::get('emp.delete.app-user/{id}/{name}', 'UserController@appUserDelete')->name('delete-user');
	Route::post('emp.app-user.change-password', 'UserController@appUserChangePassword')->name('change-user-password');
	Route::post('emp.app-user.active', 'UserController@appUserActive')->name('appUserActive');
	Route::post('emp.my-profile.change-password', 'UserController@appUserChangePasswordOwn')->name('change-my-profile-password');
	Route::post('emp.user-profile/change-email', 'UserController@appUserChangeEmailBySAdmin')->name('change-user-email');
	Route::post('emp.user-profile/change-emp_id', 'UserController@appUserChangeEmpIdlBySAdmin')->name('change-emp-id');
	Route::get('emp.user-inactive/{id}/{name}', 'UserController@appUserInactiveBySAdmin')->name('inactive-user');
	Route::get('emp.user-active/{id}/{name}', 'UserController@appUserActiveBySAdmin')->name('active-user');


	//DepartmentController

	Route::post('emp.add-new-department','DepartmentController@addNewDepartment')->name('add-new-dept');
	Route::get('emp.delete-dept/{id}/{name}', 'DepartmentController@deleteDept')->name('delete-dept');
	Route::post('emp.edit-dept', 'DepartmentController@editDept')->name('edit-dept-info');


	//HolidayController
	Route::get('emp.app-holidays', 'HolidayController@index')->name('app-holidays');
	Route::post('emp.add-new-holiday', 'HolidayController@addNewHoliday')->name('add-new-holiday');
	Route::get('emp.delete-holiday/{id}', 'HolidayController@deleteHoliday')->name('delete-holiday');
	Route::post('emp.update-holidays', 'HolidayController@updateHoliday')->name('update-holidays');


	//AccountsController

	Route::get('emp.account-head', 'AccountsController@accHead')->name('acc-head');
	Route::get('emp.account-expenses', 'AccountsController@accExpenses')->name('acc-expenses');
	Route::get('emp.account-income', 'AccountsController@accIncome')->name('acc-income');
	Route::post('emp.add.account-income','AccountsController@AddNewAccIncome')->name('add-new-income');
	Route::get('emp.delete-income/{id}', 'AccountsController@deleteIncome')->name('delete-income');
	Route::post('emp.edit.accout-info', 'AccountsController@editIncome')->name('edit-income');
	Route::post('emp.filter-income-by-date', 'AccountsController@filterIncomeByDate')->name('filter-income-by-date');
	Route::post('emp.filter/acc-head', 'AccountsController@filterAccHead')->name('filter-acc-head');


//filterController
	Route::get('app-emp/search/latetoday','FilterController@late');
	Route::get('app-emp/search/leavetoday','FilterController@leave');
	Route::get('app-emp/search/presenttoday','FilterController@present');


	Route::get('app-emp/search/active-emp','FilterController@activeEmp');
	Route::get('app-emp/search/inactive-emp','FilterController@inactiveEmp');
	Route::get('app-emp/search/provision-period','FilterController@provisionPeriod');
	Route::get('app-emp/search/permanent-emp','FilterController@permanentEmp');
	Route::post('app-emp/filter/','FilterController@filterEmployee')->name('filter-employee');
	Route::post('emp.attendanceShorts','EmployeesController@filterEmployeedate')->name('filter-employee-date');
	

	Route::get('app-user/search/active-user','FilterController@activeUser');
	Route::get('app-user/search/inactive-user','FilterController@inactiveUser');
	Route::get('app-user/search/provision-period','FilterController@userProvisionPeriod');
	Route::get('app-user/search/permanent-user','FilterController@permanentUser');
	Route::post('app-user/filter/','FilterController@filterUser')->name('filter-user');

	Route::post('app.filter/leave-request','FilterController@filterLeaveRequest')->name('filter-leave-request');
	Route::post('emp.filter/leave-request','FilterController@filterLeaveRequestEMP')->name('filter-leave-request-emp');

	Route::post('emp.filter/payslip-payment','FilterController@filterPayslipPayment')->name('filter-payslip-form-payment');
	Route::post('app.filter/activity-log','FilterController@filterActivityLogS')->name('filter-activity-log-superadmin');


//ExpenseController
	Route::post('emp.add.new-expense', 'ExpensesController@addNewExpenses')->name('add-new-expense');
	Route::get('emp.delete-expenses/{id}', 'ExpensesController@deleteExpense')->name('delete-expenses');
	Route::post('emp.edit.expense-info', 'ExpensesController@editExpens')->name('edit-expenses');
	Route::post('emp.filter-expense-by-date', 'ExpensesController@filterExpenseByDate')->name('filter-expense-by-date');


//AccountHeadController
	Route::post('emp.add.new-acc-head', 'AccountHeadController@addNewAccHead')->name('add-new-acc-head');
	Route::post('emp.edit.acc-head', 'AccountHeadController@editAccHead')->name('edit-acc-head');
	Route::get('emp.delete.acc-head/{id}/{name}', 'AccountHeadController@deleteAccHead')->name('delete-acc-head');
	Route::get('emp.active.acc-head/{id}/{name}', 'AccountHeadController@activeAccHead')->name('active-acc-head');
	Route::get('emp.inactive.acc-head/{id}/{name}', 'AccountHeadController@inactiveAccHead')->name('inactive-acc-head');



	// PayrollController
	Route::get('emp.performance/month/{id}/{name}', 'PayrollController@performanceByMonth')->name('view-emp-performance-by-month');
	Route::get('emp.payroll-payslip', 'PayrollController@payrollPayslip')->name('payroll-payslip');
	Route::post('emp.send-payslip', 'PayrollController@sendPayslip')->name('send-payslip-to-employee');
	Route::get('emp.payroll-salary', 'PayrollController@payrollSalary')->name('payroll-salary');
	Route::post('emp.update-payroll-salary', 'PayrollController@updatePayrollSalary')->name('update-salary-info');
	Route::get('emp.view.increment-history/{id}/{name}', 'PayrollController@viewIncrementHistory')->name('view-increment-history');

	Route::get('emp.view-payslip./emp.payroll-paymentdetails/{email}/{name}/{id}', 'PayrollController@viewPayslipDetails')->name('view-payslip-details');
	Route::post('emp.confirm-payslip', 'PayrollController@confirmPayslip')->name('confirm-payslip');
	Route::post('emp.update-payslip/super-admin', 'PayrollController@updatePayslipBySuperAdmin')->name('update-payslip-info-by-super-admin');
	Route::post('emp.update-performance/super-admin', 'PayrollController@updatePerformanceBySuperAdmin')->name('change-performance');

	Route::post('emp.filter-payslip-by-superadmin', 'PayrollController@filterPayslipByAdmin')->name('filter-payslip-by-superadmin');
	Route::post('emp.filter-payslip-by-employee', 'PayrollController@filterPayslipByEmployee')->name('filter-payslip-by-employee');

	Route::get('emp.payroll-payment', 'PayrollController@payrollPayment')->name('payroll-payment');
	Route::get('emp.Payment-payslip/{id}/{name}', 'PayrollController@payPayment')->name('Payment-payslip-to-emp');
	Route::get('emp.payslip-by-emp/{email}/{name}', 'PayrollController@paymentByEmp')->name('payslip-by-emp');


	Route::get('emp.print-payslip/{email}/{name}/{id}', 'PayrollController@printPayslipDetails')->name('print-payslip');

  Route::get('emp.print-leave/{name}/{uid}', 'PayrollController@printleave')->name('print-leave');
  Route::get('emp.print_emp', 'PayrollController@print_emp')->name('print_emp');
  Route::get('emp.print-report/{name}/{uid}/{month}', 'PayrollController@printreport')->name('print-report');
  Route::get('emp.print-leave-preview/{id}/{name}/{uid}', 'PayrollController@printleavepreview')->name('print-leave-preview');

  Route::get('emp.print-emp-preview', 'EmployeesController@printempview')->name('print-emp-preview');

  Route::get('emp.leavepdf/{id}/{name}/{uid}', 'PayrollController@leavepdf')->name('leavepdf');

Route::get('emp.preview_monthly_report/{name}/{uid}/{month}', 'PayrollController@preview_monthly_report')->name('preview_monthly_report');
	//ReportController
	Route::get('emp.account-report.monthly', 'ReportController@reportAccountMonthly')->name('account-report-monthly');
	Route::get('emp.account-report.yearly', 'ReportController@reportAccountYearly')->name('account-report-yearly');

	Route::get('emp.employee-performance-report', 'ReportController@reportEmployeePerformance')->name('employee-performance-report');
	Route::get('emp.leave-report', 'ReportController@empLeavereport')->name('employee-leave-report');
	Route::get('emp.view-user/leave-list/{id}/{name}', 'ReportController@empLeavereportList')->name('view-user-leave-list');
	Route::get('emp.employee-salary/report/for/{email}/{name}', 'ReportController@empSalaryreportListFor')->name('payslip-report-this-emp');
	Route::get('emp.employee-salary/report', 'ReportController@empSalaryreportList')->name('employee-salary-report');




	Route::get('/', 'BackEndController@index')->name('/');
	});

	//emp-middleware
    Route::group(['middleware' => 'role:Employee|Admin'], function () {

    //emp deshboard
	Route::get('emp.dashboard', 'BackEndController@empDashboard')->name('emp-dashboard');

	Route::get('emp/activity-log', 'BackEndController@activityLogEmp')->name('activity-log-emp');

	});





    Route::group(['middleware' => 'role:Super Admin'], function () {
    //deshboard


	Route::post('update/paid_leave', 'BackEndController@updatePaidLeave')->name('update_paid_leave');

	Route::get('activity-log', 'BackEndController@activityLog')->name('activity-log');
	Route::get('app-settings', 'BackEndController@appSettings')->name('app-settings');
	Route::post('save.app-settings', 'BackEndController@saveAppSettingsInfo')->name('app-setting-info');
	
	Route::get('att-timing-settings', 'EmployeesController@AttTimingSettings')->name('att-timing-settings');
	Route::post('att-timing-settings', 'EmployeesController@saveAttTimingSettings')->name('att-timing-settings');
	Route::get('del-att-timing-settings/{id}', 'EmployeesController@deleteAttendencetimeing')->name('deleteAttendencetimeing');
	Route::post('update-att-timing-settings', 'EmployeesController@updateAttTimingSettings')->name('update-att-timing-settings');
	
	});


});
Auth::routes();
