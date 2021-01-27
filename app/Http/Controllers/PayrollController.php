<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\LeaveCount;
use App\InOutSetting;
use App\Holiday;
use App\Salary;
use App\Payslip;
use App\Expense;
use App\Leave;
use App\SalaryHistory;
use Carbon\Carbon;
use App\Department;
use App\EmpLeave;
use PDF;
use App\AppSettings;
use Illuminate\Support\Facades\Auth;
class PayrollController extends Controller
{
    public function payrollPayslip(){
        $user_id=Auth::user()->id;
        $emp=User::find($user_id);
        $obj_dept=Department::all();
        $obj_role=User::select('role')->distinct()->get();


    if(Auth::user()->hasRole('Super Admin')){

        $obj_payslip=Payslip::select('*')->orderBy('created_at', 'DESC')->get();

    }else{
        $obj_payslip=Payslip::select('*')->where('employee_id',$emp->emp_id)->orderBy('created_at', 'DESC')->get();

    }

    	return view('back-end.payroll.payroll-payslip-list',[
            'obj_payslip'=>$obj_payslip,
            'obj_dept'=>$obj_dept,
            'obj_role'=>$obj_role,
        ]);

    }
    public function payrollSalary(){

        $employeeList = User::leftJoin('salaries', 'salaries.employee_id', '=', 'users.id')
        ->select('users.*', 'salaries.employee_id', 'salaries.basic_salary', 'salaries.house_rent_allowance',
        'salaries.bonus', 'salaries.conveyance', 'salaries.other_allowance',
        'salaries.TDS', 'salaries.provident_fund', 'salaries.c_bank_loan',
        'salaries.provident_fund', 'salaries.other_deductions')
        ->orderBy('users.created_at', 'DESC')
        ->get();
    	return view('back-end.payroll.payroll-salary',[
            'employeeList'=>$employeeList,
        ]);

    }
public function updatePayrollSalary(Request $request){
    $this->validate($request, [
        'basic_salary' => 'required|max:9|min:2',

    ]);

    $obj_user=User::find($request->emp_id);

    // return $obj_user;

    $obj_salary_check=salary::where('employee_id',$request->emp_id)->first();
    if($obj_salary_check){
    $obj_salary=salary::where('employee_id',$request->emp_id)->first();
    $obj_salary->employee_id=$obj_user->id;
    $obj_salary->basic_salary=$request->basic_salary;
    $obj_salary->house_rent_allowance=$request->house_rent_allowance;
    $obj_salary->bonus=$request->bonus;
    $obj_salary->conveyance=$request->conveyance;
    $obj_salary->other_allowance=$request->other_allowance;
    $obj_salary->TDS=$request->TDS;
    $obj_salary->provident_fund=$request->provident_fund;
    $obj_salary->c_bank_loan=$request->c_bank_loan;
    $obj_salary->other_deductions=$request->other_deductions;
    $obj_salary->save();

    $salary_history=SalaryHistory::where('employee_id',$request->emp_id)
                            ->orderBy('created_at', 'DESC')->first();
if($salary_history){

if($salary_history->current_basic_sallary!=$request->basic_salary){
    $obj_salary_history=new SalaryHistory();
    $obj_salary_history->employee_id=$request->emp_id;
    $obj_salary_history->current_basic_sallary=$request->basic_salary;
    $obj_salary_history->previous_basic_sallary=$salary_history->current_basic_sallary;
    $obj_salary_history->save();
}
}else{
    $obj_salary_history=new SalaryHistory();
    $obj_salary_history->employee_id=$request->emp_id;
    $obj_salary_history->current_basic_sallary=$request->basic_salary;
    $obj_salary_history->previous_basic_sallary=0;
    $obj_salary_history->save();

}


}else{
    $obj_salary=new salary();
    $obj_salary->employee_id=$obj_user->id;
    $obj_salary->basic_salary=$request->basic_salary;
    $obj_salary->house_rent_allowance=$request->house_rent_allowance;
    $obj_salary->bonus=$request->bonus;
    $obj_salary->conveyance=$request->conveyance;
    $obj_salary->other_allowance=$request->other_allowance;
    $obj_salary->TDS=$request->TDS;
    $obj_salary->provident_fund=$request->provident_fund;
    $obj_salary->c_bank_loan=$request->c_bank_loan;
    $obj_salary->other_deductions=$request->other_deductions;
    $obj_salary->save();

}
activityLog('Update Employee Salary.');

if(Auth::user()->hasRole('Super Admin')){
    ActivityLogEmp($obj_user->id,'Super Admin','Update Salary..');
    }elseif(Auth::user()->hasRole('Admin')){
        ActivityLogEmp($obj_user->id,'Admin','Update Salary.');
    }else{
        ActivityLogEmp($obj_user->id,'Me','Update Salary.');
    }

return redirect()->back()->with('message','Info Save Successfully.');
}

public function sendPayslip(Request $request){
    $this->validate($request, [

        'emp_performance' => 'required|not_in:Select Performance Rating',
    ]);
    $id=$request->employee_id;
    $obj_salary=salary::where('employee_id',$id)->first();
    $obj_user=User::find($id);
    $dt = Carbon::now();


    $obj_old_payslip=Payslip::where('employee_id',$obj_user->emp_id)->orderBy('created_at', 'DESC')->first();

if($obj_salary){


    if($obj_old_payslip){
        // return $obj_old_payslip->created_at->format('m Y');
        if($dt->format('F Y') == $obj_old_payslip->created_at->format('F Y')){

            return redirect()->back()->with('warning','Payslip already send on this month.');

        } else{
            $obj_payslip=new Payslip();
            $obj_payslip->notification_status='Unseen';
            $obj_payslip->confirmation_status='Not Confirm';
            $obj_payslip->employee_name=$obj_user->name;
            $obj_payslip->employee_id=$obj_user->emp_id;
            $obj_payslip->employee_email=$obj_user->email;
            $obj_payslip->employee_role=$obj_user->role;
            $obj_payslip->employee_dept=$obj_user->dept_name;
            $obj_payslip->emp_image=$obj_user->profile_photo;
            $obj_payslip->basic_salary=$obj_salary->basic_salary;
            $obj_payslip->house_rent_allowance=$obj_salary->house_rent_allowance;
            $obj_payslip->bonus=$obj_salary->bonus;
            $obj_payslip->conveyance=$obj_salary->conveyance;
            $obj_payslip->other_allowance=$obj_salary->other_allowance;
            $obj_payslip->TDS=$obj_salary->TDS;
            $obj_payslip->provident_fund=$obj_salary->provident_fund;
            $obj_payslip->c_bank_loan=$obj_salary->c_bank_loan;
            $obj_payslip->other_deductions=$obj_salary->other_deductions;
            $obj_payslip->emp_performance=$request->emp_performance;
            $obj_payslip->save();


        $obj_user->last_payslip_send=$dt;
        $obj_user->save();

        }
    }
    else{
        $obj_payslip=new Payslip();
        $obj_payslip->notification_status='Unseen';
        $obj_payslip->confirmation_status='Not Confirm';
        $obj_payslip->employee_name=$obj_user->name;
        $obj_payslip->employee_id=$obj_user->emp_id;
        $obj_payslip->employee_email=$obj_user->email;
        $obj_payslip->employee_role=$obj_user->role;
        $obj_payslip->employee_dept=$obj_user->dept_name;
        $obj_payslip->emp_image=$obj_user->profile_photo;
        $obj_payslip->basic_salary=$obj_salary->basic_salary;
        $obj_payslip->house_rent_allowance=$obj_salary->house_rent_allowance;
        $obj_payslip->bonus=$obj_salary->bonus;
        $obj_payslip->conveyance=$obj_salary->conveyance;
        $obj_payslip->other_allowance=$obj_salary->other_allowance;
        $obj_payslip->TDS=$obj_salary->TDS;
        $obj_payslip->provident_fund=$obj_salary->provident_fund;
        $obj_payslip->c_bank_loan=$obj_salary->c_bank_loan;
        $obj_payslip->other_deductions=$obj_salary->other_deductions;
        $obj_payslip->emp_performance=$request->emp_performance;
        $obj_payslip->save();


        $obj_user->last_payslip_send=$dt;
        $obj_user->save();

    }






    activityLog('Send payslip to employee.');

    return redirect()->back()->with('message','Payslip Successfully Send');

}else{
    return redirect()->back()->with('warning','Please insert salary for this employee');
}
}

public function confirmPayslip(Request $request){
    $obj_payslip=Payslip::find($request->payslip_id);
    $obj_payslip->confirmation_status='Confirm';
    $obj_payslip->emp_comment=$request->emp_comment;
    $obj_payslip->save();
    activityLog('Confirm payslip.');

    if(Auth::user()->hasRole('Super Admin')){
        ActivityLogEmp($user->id,'Super Admin','Confirm payslip');
        }elseif(Auth::user()->hasRole('Admin')){
            ActivityLogEmp($user->id,'Admin','Confirm payslip');
        }else{
            ActivityLogEmp($user->id,'Me','Confirm payslip');
        }


    return redirect()->back()->with('message','Payslip Successfully Confirm');

}

public function viewPayslipDetails($email,$name,$id){

    $user_id=Auth::user()->id;
    $emp=User::find($user_id);

    if(Auth::user()->hasRole('Super Admin')){
    $prev = Payslip::where('id', '>', $id)
    ->orderBy('id')->first();
// return $next;
    $next = Payslip::where('id', '<', $id)
    ->orderBy('id', 'desc')->first();
}else{
    $prev = Payslip::where('id', '>', $id)->where('employee_email',$emp->email)
    ->orderBy('id')->first();
    // where(function ($query) {
    //     $query->where('msg_receiver',Auth::user()->email)
    //           ->orWhere('cc',Auth::user()->email);
// return $prev;
    $next = Payslip::where('id', '<', $id)->where('employee_email',$emp->email)
    ->orderBy('id', 'desc')->first();
}


    $obj_payslip=Payslip::where('id',$id)->first();

    $obj_setting=AppSettings::first();


    $total_earning=$obj_payslip->basic_salary+$obj_payslip->house_rent_allowance+$obj_payslip->bonus
                   +$obj_payslip->conveyance+$obj_payslip->other_allowance;

    $total_deductions=$obj_payslip->TDS+$obj_payslip->provident_fund+$obj_payslip->c_bank_loan
                     +$obj_payslip->other_deductions;

    if(Auth::user()->hasRole('Super Admin')){

     }else{
    $obj_payslip->notification_status='Seen';
    $obj_payslip->save();
}

    return view('back-end.payroll.payroll-payslip',[
        'obj_payslip'=>$obj_payslip,
        'total_deductions'=>$total_deductions,
        'total_earning'=>$total_earning,
        'next'=>$next,
        'prev'=>$prev,
        'obj_setting'=>$obj_setting,
    ]);

}
public function filterPayslipByAdmin(Request $request){
// return $request;

$user_id=Auth::user()->id;
$emp=User::find($user_id);

$obj_dept=Department::all();
$obj_role=User::select('role')->distinct()->get();



if($request->dept=='null' && $request->role=='null' && $request->year=='null'&& $request->month=='null'){
    return redirect()->back()->with('warning','Please search in a right away');

}elseif($request->dept=='null' && $request->role=='null' && $request->year=='null'&& $request->month!='null'){
    $obj_payslip=Payslip::select('*')
    ->whereMonth('created_at', $request->month)
    ->orderBy('created_at', 'DESC')->get();
        // return 0001;

}elseif($request->dept=='null' && $request->role=='null' && $request->year!='null'&& $request->month=='null'){
    $obj_payslip=Payslip::select('*')
    ->whereYear('created_at', $request->year)
    ->orderBy('created_at', 'DESC')->get();
    // return 0010;
}elseif($request->dept=='null' && $request->role=='null' && $request->year!='null'&& $request->month!='null'){
    $obj_payslip=Payslip::select('*')
    ->whereYear('created_at', $request->year)
    ->whereMonth('created_at', $request->month)
    ->orderBy('created_at', 'DESC')->get();
    // return 0011;
}elseif($request->dept=='null' && $request->role!='null' && $request->year=='null'&& $request->month=='null'){
    $obj_payslip=Payslip::select('*')
    ->where('employee_role', $request->role)
    ->orderBy('created_at', 'DESC')->get();
    // return 0100;
}elseif($request->dept=='null' && $request->role!='null' && $request->year=='null'&& $request->month!='null'){
    $obj_payslip=Payslip::select('*')
    ->where('employee_role', $request->role)
    ->whereMonth('created_at', $request->month)
    ->orderBy('created_at', 'DESC')->get();
    // return 0101;
}elseif($request->dept=='null' && $request->role!='null' && $request->year!='null'&& $request->month=='null'){
    $obj_payslip=Payslip::select('*')
    ->where('employee_role', $request->role)
    ->whereYear('created_at', $request->year)
    ->orderBy('created_at', 'DESC')->get();
    // return 0110;
}elseif($request->dept=='null' && $request->role!='null' && $request->year!='null'&& $request->month!='null'){
    $obj_payslip=Payslip::select('*')
    ->where('employee_role', $request->role)
    ->whereYear('created_at', $request->year)
    ->whereMonth('created_at', $request->month)
    ->orderBy('created_at', 'DESC')->get();
    // return 0111;
}elseif($request->dept!='null' && $request->role=='null' && $request->year=='null'&& $request->month=='null'){
    $obj_payslip=Payslip::select('*')
    ->where('employee_dept', $request->dept)
    ->orderBy('created_at', 'DESC')->get();
    // return 1000;
}elseif($request->dept!='null' && $request->role=='null' && $request->year=='null'&& $request->month!='null'){
    $obj_payslip=Payslip::select('*')
    ->where('employee_dept', $request->dept)
    ->whereMonth('created_at', $request->month)
    ->orderBy('created_at', 'DESC')->get();
    // return 1001;
}elseif($request->dept!='null' && $request->role=='null' && $request->year!='null'&& $request->month=='null'){
    $obj_payslip=Payslip::select('*')
    ->where('employee_dept', $request->dept)
    ->whereYear('created_at', $request->year)
    ->orderBy('created_at', 'DESC')->get();
    // return 1010;
}elseif($request->dept!='null' && $request->role=='null' && $request->year!='null'&& $request->month!='null'){
    $obj_payslip=Payslip::select('*')
    ->where('employee_dept', $request->dept)
    ->whereYear('created_at', $request->year)
    ->whereMonth('created_at', $request->month)
    ->orderBy('created_at', 'DESC')->get();
    // return 1011;
}elseif($request->dept!='null' && $request->role!='null' && $request->year=='null'&& $request->month=='null'){
    $obj_payslip=Payslip::select('*')
    ->where('employee_dept', $request->dept)
    ->where('employee_role', $request->role)
    ->orderBy('created_at', 'DESC')->get();
    // return 1100;
}elseif($request->dept!='null' && $request->role!='null' && $request->year=='null'&& $request->month!='null'){
    $obj_payslip=Payslip::select('*')
    ->where('employee_dept', $request->dept)
    ->where('employee_role', $request->role)
    ->whereMonth('created_at', $request->month)
    ->orderBy('created_at', 'DESC')->get();
    // return 1101;
}elseif($request->dept!='null' && $request->role!='null' && $request->year!='null'&& $request->month=='null'){
    $obj_payslip=Payslip::select('*')
    ->where('employee_dept', $request->dept)
    ->where('employee_role', $request->role)
    ->whereYear('created_at', $request->year)
    ->orderBy('created_at', 'DESC')->get();
    // return 1110;
}elseif($request->dept!='null' && $request->role!='null' && $request->year!='null'&& $request->month!='null'){
    $obj_payslip=Payslip::select('*')
    ->where('employee_dept', $request->dept)
    ->where('employee_role', $request->role)
    ->whereYear('created_at', $request->year)
    ->whereMonth('created_at', $request->month)
    ->orderBy('created_at', 'DESC')->get();
    // return 1111;


}


return view('back-end.payroll.payroll-payslip-list',[
    'obj_payslip'=>$obj_payslip,
    'obj_dept'=>$obj_dept,
    'obj_role'=>$obj_role,
]);

}
public function filterPayslipByEmployee(Request $request){
    $user_id=Auth::user()->id;
    $emp=User::find($user_id);
    $obj_dept=Department::all();
    $obj_role=User::select('role')->distinct()->get();


    if($request->year=='null'&& $request->month=='null'){
        return redirect()->back()->with('warning','Please search in a right away');

    }elseif($request->year=='null'&& $request->month!='null'){
        $obj_payslip=Payslip::select('*')
        ->whereMonth('created_at', $request->month)
        ->where('employee_id',$emp->emp_id)
        ->orderBy('created_at', 'DESC')->get();

    }elseif($request->year!='null'&& $request->month=='null'){
        $obj_payslip=Payslip::select('*')
        ->whereYear('created_at', $request->year)
        ->where('employee_id',$emp->emp_id)
        ->orderBy('created_at', 'DESC')->get();

    }elseif($request->year!='null'&& $request->month!='null'){
        $obj_payslip=Payslip::select('*')
        ->whereYear('created_at', $request->year)
        ->whereMonth('created_at', $request->month)
        ->where('employee_id',$emp->emp_id)
        ->orderBy('created_at', 'DESC')->get();
}

    return view('back-end.payroll.payroll-payslip-list',[
        'obj_payslip'=>$obj_payslip,
        'obj_dept'=>$obj_dept,
        'obj_role'=>$obj_role,
    ]);
}
public function viewIncrementHistory($id, $name){
    $salary_histories=SalaryHistory::join('users','salary_histories.employee_id', '=', 'users.id')
    ->where('salary_histories.employee_id',$id)
    ->select('salary_histories.*','users.name')
    ->orderBy('salary_histories.created_at', 'DESC')->get();

    return view('back-end.accounts.salary-increment-history',[
        'salary_histories'=>$salary_histories,
    ]);
}

public function updatePayslipBySuperAdmin(Request $request){
// return $request;
    $this->validate($request, [
        'basic_salary' => 'required|max:9|min:2',
        'emp_performance' => 'required|not_in:Select Performance Rating',

    ]);

    $user_name = Auth::User()->name;

    $obj_payslip=Payslip::find($request->payslip_id);
    // $obj_payslip->notification_status='Unseen';
    // $obj_payslip->confirmation_status='Not Confirm';
    // $obj_payslip->employee_name=$obj_user->name;
    // $obj_payslip->employee_id=$obj_user->emp_id;
    // $obj_payslip->employee_email=$obj_user->email;
    // $obj_payslip->employee_role=$obj_user->role;
    // $obj_payslip->employee_dept=$obj_user->dept_name;
    // $obj_payslip->emp_image=$obj_user->profile_photo;
    $obj_payslip->basic_salary=$request->basic_salary;
    $obj_payslip->house_rent_allowance=$request->house_rent_allowance;
    $obj_payslip->bonus=$request->bonus;
    $obj_payslip->conveyance=$request->conveyance;
    $obj_payslip->other_allowance=$request->other_allowance;
    $obj_payslip->TDS=$request->TDS;
    $obj_payslip->provident_fund=$request->provident_fund;
    $obj_payslip->c_bank_loan=$request->c_bank_loan;
    $obj_payslip->other_deductions=$request->other_deductions;
    $obj_payslip->emp_performance=$request->emp_performance;
    $obj_payslip->save();
    activityLog('Update payslip by superadmin.');

return redirect()->back()->with('message','Payslip update successfully');




}
public function performanceByMonth($id,$name){
    $obj_payslips=Payslip::where('employee_id',$id)->orderBy('created_at','DESC')->get();

// return $obj_payslips;
    return view('back-end.report.performance-by-month',[
		'obj_payslips'=>$obj_payslips,

	]);
}

public function updatePerformanceBySuperAdmin(Request $request){

    $obj_payslip=Payslip::find($request->payslip_id);
    $obj_payslip->emp_performance=$request->emp_performance;
    $obj_payslip->save();
    activityLog('Update employee performance by superadmin.');
    return redirect()->back()->with('message','Permormance Chenged');

}

public function payrollPayment(){
    $user_id=Auth::user()->id;
    $emp=User::find($user_id);


    $obj_payslip=Payslip::select('*')->orderBy('payment_status', 'DESC')->get();
    $obj_empName=Payslip::select('employee_name')->distinct('employee_name')->get();

    return view('back-end.payroll.payroll-payment',[
        'obj_payslip'=>$obj_payslip,
        'obj_empName'=>$obj_empName,

    ]);

}

public function payPayment($id,$name){


$obj_payslip=Payslip::find($id);

$obj_payslip->payment_status="Paid";
$obj_payslip->pay_date=Carbon::now();
$obj_payslip->save();


    $total_earning=$obj_payslip->basic_salary+$obj_payslip->house_rent_allowance+$obj_payslip->bonus
        +$obj_payslip->conveyance+$obj_payslip->other_allowance;

    $total_deductions=$obj_payslip->TDS+$obj_payslip->provident_fund+$obj_payslip->c_bank_loan
        +$obj_payslip->other_deductions;

    $totalSend=$total_earning-$total_deductions;
    $user_name = Auth::User()->name;

    $obj_expense=new Expense();
    $obj_expense->accHead='Salary';
    $obj_expense->amount=$totalSend;
    $obj_expense->created_by=$user_name;
    $obj_expense->save();

    activityLog('Paid Employee Salary.');
    return redirect()->back()->with('message','Salary successfully paid');

}

public function paymentByEmp($email,$name){

    $obj_payslip=Payslip::where('employee_email',$email)->get();

    $user_id=Auth::user()->id;
    $emp=User::find($user_id);
    $obj_dept=Department::all();

    $obj_role=User::select('role')->distinct()->get();


    return view('back-end.payroll.payroll-payment-list-by-emp',[
        'obj_payslip'=>$obj_payslip,
        'obj_dept'=>$obj_dept,
        'obj_role'=>$obj_role,
    ]);

}
public function printPayslipDetails($email,$name,$id){

    $user_id=Auth::user()->id;
    $emp=User::find($user_id);



    $obj_payslip=Payslip::where('id',$id)->first();


    $total_earning=$obj_payslip->basic_salary+$obj_payslip->house_rent_allowance+$obj_payslip->bonus
                   +$obj_payslip->conveyance+$obj_payslip->other_allowance;

    $total_deductions=$obj_payslip->TDS+$obj_payslip->provident_fund+$obj_payslip->c_bank_loan
                     +$obj_payslip->other_deductions;

    if(Auth::user()->hasRole('Super Admin')){

     }else{
    $obj_payslip->notification_status='Seen';
    $obj_payslip->save();
    }
    $obj_setting=AppSettings::first();

$pdf = PDF::loadView('back-end.pdf.payslip', [
        'obj_payslip'=>$obj_payslip,
        'total_deductions'=>$total_deductions,
        'total_earning'=>$total_earning,
        'obj_setting'=>$obj_setting,

    ]);
// return $pdf->download('payslip.pdf');
return $pdf->stream();

    // return view('back-end.payroll.print-payslip',[
    //     'obj_payslip'=>$obj_payslip,
    //     'total_deductions'=>$total_deductions,
    //     'total_earning'=>$total_earning,

    // ]);


}



public function preview_monthly_report($name,$uid,$month){

    $emp=User::find($uid);


    return view('back-end.pdf.monthlyReportpreview',[
    'emp'=>$emp,'month'=>$month,
    ]);

}
public function printleavepreview($id,$name,$uid){

    $emp=User::find($uid);
    $leave=Leave::where('emp_db_id',$uid)->get();
    $leave_count=0;
    foreach($leave as $lv){
        if($lv->status == "Accepted"){
            $leave_count=$leave_count + $lv->leave_for;
        }
    }
    
    $last_leave=Leave::where(['emp_db_id'=>$uid,'status'=>'Accepted'])->orderBy('created_at', 'DESC')->first();

    $empLeaveAmount=EmpLeave::select('*')->first()->paid_leave_amount;

    //return $empLeaveAmount;
    return view('back-end.pdf.leavepreview',[
    'emp'=>$emp,'leave'=>$leave,'leave_count'=>$leave_count,'last_leave'=>$last_leave, 'empLeaveAmount'=>$empLeaveAmount,'id'=>$id,'name'=>$name,'uid'=>$uid,
    ]);
    

}
public function fullleavereport( ){

    $userList = User::orderBy('created_at','DESC')->get();
		$lvrp = LeaveCount::join('users', 'leave_counts.emp_id','=','users.emp_id')
		->select('leave_counts.*','users.name','users.emp_id')
		->orderBy('created_at','DESC')->get();
        
        $emp_leave = EmpLeave::find(1);

		return view('back-end.report.emp-full-leave-report-preview',[
			'lvrp'=>$lvrp,'userList'=>$userList,'emp_leave'=>$emp_leave->paid_leave_amount,
		]);
    

}

public function fullleavereportprint(){

    $userList = User::orderBy('created_at','DESC')->get();
		$lvrp = LeaveCount::join('users', 'leave_counts.emp_id','=','users.emp_id')
		->select('leave_counts.*','users.name','users.emp_id')
		->orderBy('created_at','DESC')->get();
        $emp_leave = EmpLeave::find(1);
    $mpdf = new \Mpdf\Mpdf([
                'margin_left' =>15,
				'margin_top' =>15,
				'margin_right' =>15,
				'margin_bottom' =>15,
        'default_font_size' => 9,
    ]);

    $html = \View::make('back-end.pdf.fullleaveprint')->with([
        'lvrp'=>$lvrp,'userList'=>$userList,'emp_leave'=>$emp_leave->paid_leave_amount,
        ]);
    $html= $html->render();
    $mpdf->SetHeader('Update Diagonostic,Rangpur|Leave Report|{PAGENO}');
    $mpdf->WriteHTML($html);
    $mpdf->Output('leavesfull.pdf','I');

    // return [
    //     'emp'=>$emp,'leave'=>$leave,'leave_count'=>$leave_count,'last_leave'=>$last_leave,'empLeaveAmount'=>$empLeaveAmount,'id'=>$id,'name'=>$name,'uid'=>$uid,
    // ];

}
public function leavepdf($id,$name,$uid){

    $emp=User::find($uid);
    $leave=Leave::where('emp_db_id',$uid)->get();
    $leave_count=0;
    foreach($leave as $lv){
        if($lv->status == "Accepted"){
            $leave_count=$leave_count + $lv->leave_for;
        }
    }
    
    $last_leave=Leave::where(['emp_db_id'=>$uid,'status'=>'Accepted'])->orderBy('created_at', 'DESC')->first();

    $empLeaveAmount=EmpLeave::select('*')->first()->paid_leave_amount;

    //return $empLeaveAmount;
   
    $mpdf = new \Mpdf\Mpdf([
                'margin_left' =>22,
				'margin_top' =>10,
				'margin_right' =>15,
				'margin_bottom' =>15,
        'default_font_size' => 12,
	    'default_font' => 'nikosh'
    ]);

    $html = \View::make('back-end.pdf.leaveapp')->with([
        'emp'=>$emp,'leave'=>$leave,'leave_count'=>$leave_count,'last_leave'=>$last_leave,'empLeaveAmount'=>$empLeaveAmount,'id'=>$id,'name'=>$name,'uid'=>$uid,
        ]);
    $html= $html->render();
    $mpdf->WriteHTML($html);
    $mpdf->Output('leaves.pdf','I');

    // return [
    //     'emp'=>$emp,'leave'=>$leave,'leave_count'=>$leave_count,'last_leave'=>$last_leave,'empLeaveAmount'=>$empLeaveAmount,'id'=>$id,'name'=>$name,'uid'=>$uid,
    // ];

}
public function print_emp(){

    $userList = User::orderby('designation','asc')->get();
    $roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();

    $inout_time = InOutSetting::all();
    $holidays = Holiday::all();
   
    $mpdf = new \Mpdf\Mpdf([
                'margin_left' =>15,
				'margin_top' =>15,
				'margin_right' =>15,
				'margin_bottom' =>15,
        'default_font_size' => 9,
    ]);

    $html = \View::make('back-end.report.emp-print')->with([
        'userList'=>$userList,
			// 'obj_dept'=>$obj_dept,
			
			'roleList'=>$roleList,
			'inout_time'=>$inout_time,
			'holidays'=>$holidays,
        
        ]);
    $html= $html->render();
    $mpdf->SetHeader('Update Diagonostic,Rangpur|Employee list|{PAGENO}');
    $mpdf->WriteHTML($html);
    $mpdf->Output('empreport.pdf','I');

    // return [
    //     'emp'=>$emp,'leave'=>$leave,'leave_count'=>$leave_count,'last_leave'=>$last_leave,'empLeaveAmount'=>$empLeaveAmount,'id'=>$id,'name'=>$name,'uid'=>$uid,
    // ];

}
}
