<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use File;
use Image;
use App\AttendanceCalculation;
use App\Payslip;
use App\Income;
use App\Expense;
use Carbon\Carbon;
use App\Department;
use Illuminate\Support\Facades\Auth;
use App\Salary;
use App\EmpLeave;
use App\LeaveRequest;
use App\Leave;
use App\Holiday;
use App\ActivityLog;
use App\EmpActivityLog;
use App\AppSettings;

class BackEndController extends Controller
{
    public function index(){
        // $authUser = User::where('email', Auth::User()->email)->first();
         if(Auth::User()->hasRole('Super Admin')){
        // return 'o';}else{return 'ff';}
        $obj_settings=AppSettings::first();
		$nowmonth = Carbon::now()->month;
		$nowyear = Carbon::now()->year;
        $userList = DB::table('users')->orderBy('created_at', 'desc')->limit(5)->get();
        
    


		$attendance=AttendanceCalculation::join('users', 'attendance_calculations.user_id', '=', 'users.emp_id')
		 ->select('attendance_calculations.*','users.name','users.emp_id','users.profile_photo')->orderBy('attendance_calculations.date', 'desc')->get();

        $time = Carbon::now()->toDateTimeString();
		$date = explode(" ",$time);
		$dt = Carbon::parse($date[0])->format('d-m-Y');

        $lv = Leave::where('status','Accepted');
        $leave = 0;
        foreach($lv as $l){
            $dates = explode(",",$l->leave_dates);

            foreach($dates as $dts){
               if(Carbon::parse($dts)->format('d-m-Y')==$dt){
                $leave = $leave +1;
               }
            }
    
        }
        $lc=0;
        $late = AttendanceCalculation::where('date','$dt')->get();
        foreach($late as $l){
            if($l->late == 2 || $l->late == 2){
                $lc = $lc+1;
            }
        }
        $p=0;
        $pre = AttendanceCalculation::where('date','$dt')->get();
        foreach($pre as $pe){
            if($pe->status == "P/P" || $pe->status == "P/L" || $pe->status == "L/L" || $pe->status == "L/P"){
                $p = $p+1;
            }
        }
       
        $new_user=User::where('job_status','Provision Period')->count();
        $total_user=User::select('id')->count();
        $total_userS=User::select('id')->where('role','!=',null)->count();
        $female_user=User::where('gender','Female')->count();
        $male_user=User::where('gender','Male')->count();

        $female_userP=round((100*$female_user)/$total_user);
        $male_userP=round((100*$male_user)/$total_user);

        $totalIncomes = Income::select('amount')->sum('amount');
        $totalExpenses = Expense::select('amount')->sum('amount');

        $totalIncomesPreMonth = Income::select('amount')
        ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
        ->sum('amount');
        // return $totalIncomesPreMonth;
        $totalExpensesPreMonth = Expense::select('amount')
        ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
        ->sum('amount');

        $totalIncomesPreYear = Income::select('amount')
        ->whereYear('created_at', '=', Carbon::now()->subYear()->year)
        ->sum('amount');

        $totalExpensesPreYear = Expense::select('amount')
        ->whereYear('created_at', '=', Carbon::now()->subYear()->year)
        ->sum('amount');
        // return $totalExpensesPreYear;
        $totalSalary = Salary::select('basic_salary')->sum('basic_salary');
        $countSalaryNo = Salary::select('basic_salary')->count();
        if($countSalaryNo>0 && $totalSalary>0)
        $avgSalary=$totalSalary/$countSalaryNo;
        else{
            $avgSalary=0;
        }
// return $countSalaryNo;
		$obj_payslip=Payslip::groupBy( 'employee_id','employee_name','employee_role','emp_image' )
		->select( 'employee_name','employee_id','employee_role','emp_image', DB::raw( 'AVG( emp_performance ) as avg_performance' ) )
        ->inrandomorder()->take(5)->get();

        $now_date = Carbon::now()->format('d-m-Y');


        
        $have_leave_today = AttendanceCalculation::where(['date'=>$now_date,'time_in'=>'','time_out'=>''])->count();
        
        // $data=DB::table('users')
        // ->select(
        //  DB::raw('users.dept_name as dept'),
        //  DB::raw('sum(salaries.basic_salary) as salary'))
        //  ->join('salaries','salaries.employee_id', '=', 'users.id')
        // ->groupBy('dept')
        // ->get();
        // $salaryByDept = array(array());
        //
        // foreach($data as $key => $value)
        // {
        //  $salaryByDept[$key]= [$value->dept, $value->salary];
        // }
        $obj_setting=AppSettings::all();

    }else{
        return redirect()->route('emp-dashboard');
    }
        // $salaryByDept[] = ['dept', 'salary'];
        // foreach($data as $key => $value)
        // {
        //  $salaryByDept[++$key] = [$value->dept, $value->salary];
        // }
// return $salaryByDept;



        return view('back-end.dashboard.dashboard',[
            'new_user'=>$new_user,
            'total_user'=>$total_user,
            'female_user'=>$female_userP,
            'male_user'=>$male_userP,
            'obj_payslip'=>$obj_payslip,
            'totalIncomes'=>$totalIncomes,
			'totalExpenses'=>$totalExpenses,
			'totalIncomesPreMonth'=>$totalIncomesPreMonth,
			'totalExpensesPreMonth'=>$totalExpensesPreMonth,
			'totalExpensesPreYear'=>$totalExpensesPreYear,
			'totalIncomesPreYear'=>$totalIncomesPreYear,
			'totalSalary'=>$totalSalary,
            'avgSalary'=>$avgSalary,
            'obj_setting'=>$obj_setting,
            'leave'=>$leave,
            'lc' => $lc,
            'p' =>$p,
            'attendance'=>$attendance, 
            'userList'=>$userList, 
            'nowmonth' => $nowmonth, 
            'nowyear' => $nowyear, 
            'deduct_count'=>$obj_settings->deduct_count,
            'total_userS' => $total_userS,
			'have_leave_today'=>$have_leave_today,
        ]);
        
    }

public function empDashboard(){

    // .............................main empDashboard................
//     $emp_id=Auth::user()->id;
//     $emp_mail=Auth::user()->email;
//     $emp=User::find($emp_id);

//     $totalBasicSalaries=Payslip::where('employee_email',$emp_mail)->sum('basic_salary');
//     $obj_payslips=Payslip::where('employee_email',$emp_mail)->orderBy('created_at','DESC')->take(4)->get();
//     $courrentBasicSarary=Salary::select('basic_salary')->where('employee_id',$emp_id)->first();
// $total_earning=0;
// $total_deductions=0;
// foreach($obj_payslips as $obj_payslip){
//     $total_earning=$total_earning+ $obj_payslip->basic_salary+$obj_payslip->house_rent_allowance+$obj_payslip->bonus
//     +$obj_payslip->conveyance+$obj_payslip->other_allowance;

// $total_deductions=$total_deductions+$obj_payslip->TDS+$obj_payslip->provident_fund+$obj_payslip->c_bank_loan
//     +$obj_payslip->other_deductions;
// }
// $totalSalary=$total_earning-$total_deductions;

//         $allPaidLeave=LeaveRequest::where('status','Accepted(paid)')
//         ->where('emp_db_id',Auth::user()->id)
//         ->get();
//         $leaveTaken=0;

//         foreach($allPaidLeave as $paidLeave){
//             $d1=Carbon::parse($paidLeave->start_date)->diffInDays($paidLeave->end_date);

//         $leaveTaken=$leaveTaken+ $d1+1;
//         }
//         $totalPaidLeave=EmpLeave::select('*')->first();

//     $dt = Carbon::now();

//     $UpcomingHoliday= Holiday::select('*')->wheredate('date', '>=',$dt->toDateString() )
//     ->orderBy('date', 'ASC')->first();



//     // return $leaveTaken;
//     $female_user=User::where('gender','Female')->count();
//     $male_user=User::where('gender','Male')->count();
//     $total_user=User::select('id')->count();

//     $female_userP=round((100*$female_user)/$total_user);
//     $male_userP=round((100*$male_user)/$total_user);
//     $obj_payslip=Payslip::groupBy( 'employee_id','employee_name','employee_role','emp_image' )
//     ->select( 'employee_name','employee_id','employee_role','emp_image', DB::raw( 'AVG( emp_performance ) as avg_performance' ) )
//     ->take(5)->get();


// // return $daa;



//     return view('back-end.dashboard.emp-dashboard',[
//         'totalBasicSalaries'=>$totalBasicSalaries,
//         'totalSalary'=>$totalSalary,
//         'courrentBasicSarary'=>$courrentBasicSarary,
//         'obj_payslips'=>$obj_payslips,
//         'leaveTaken'=>$leaveTaken,
//         'UpcomingHoliday'=>$UpcomingHoliday,
//         'totalPaidLeave'=>$totalPaidLeave,

//         'female_user'=>$female_userP,
//         'male_user'=>$male_userP,
//         'obj_payslip'=>$obj_payslip,
//     ]);

//......................update emp dash...................
$obj_settings=AppSettings::first();
		$nowmonth = Carbon::now()->month;
		$nowyear = Carbon::now()->year;
		$userList = User::orderBy('created_at', 'desc')->get();

		$attendance=AttendanceCalculation::join('users', 'attendance_calculations.user_id', '=', 'users.emp_id')
		 ->select('attendance_calculations.*','users.name','users.emp_id','users.profile_photo')->orderBy('attendance_calculations.date', 'desc')->get();

        $time = Carbon::now()->toDateTimeString();
		$date = explode(" ",$time);
		$dt = Carbon::parse($date[0])->format('d-m-Y');

        $lv = Leave::where('status','Accepted');
        $leave = 0;
        foreach($lv as $l){
            $dates = explode(",",$l->leave_dates);

            foreach($dates as $dts){
               if(Carbon::parse($dts)->format('d-m-Y')==$dt){
                $leave = $leave +1;
               }
            }
    
        }
        $lc=0;
        $late = AttendanceCalculation::where('date','$dt')->get();
        foreach($late as $l){
            if($l->late == 2 || $l->late == 2){
                $lc = $lc+1;
            }
        }
        $p=0;
        $pre = AttendanceCalculation::where('date','$dt')->get();
        foreach($pre as $pe){
            if($pe->status == "P/P" || $pe->status == "P/L" || $pe->status == "L/L" || $pe->status == "L/P"){
                $p = $p+1;
            }
        }
       
        $new_user=User::where('job_status','Provision Period')->count();
        $total_user=User::select('id')->count();
        $total_userS=User::select('id')->where('role','!=',null)->count();
        $female_user=User::where('gender','Female')->count();
        $male_user=User::where('gender','Male')->count();

        $female_userP=round((100*$female_user)/$total_user);
        $male_userP=round((100*$male_user)/$total_user);

        $totalIncomes = Income::select('amount')->sum('amount');
        $totalExpenses = Expense::select('amount')->sum('amount');

        $totalIncomesPreMonth = Income::select('amount')
        ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
        ->sum('amount');
        // return $totalIncomesPreMonth;
        $totalExpensesPreMonth = Expense::select('amount')
        ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
        ->sum('amount');

        $totalIncomesPreYear = Income::select('amount')
        ->whereYear('created_at', '=', Carbon::now()->subYear()->year)
        ->sum('amount');

        $totalExpensesPreYear = Expense::select('amount')
        ->whereYear('created_at', '=', Carbon::now()->subYear()->year)
        ->sum('amount');
        // return $totalExpensesPreYear;
        $totalSalary = Salary::select('basic_salary')->sum('basic_salary');
        $countSalaryNo = Salary::select('basic_salary')->count();
        if($countSalaryNo>0 && $totalSalary>0)
        $avgSalary=$totalSalary/$countSalaryNo;
        else{
            $avgSalary=0;
        }
// return $countSalaryNo;
		$obj_payslip=Payslip::groupBy( 'employee_id','employee_name','employee_role','emp_image' )
		->select( 'employee_name','employee_id','employee_role','emp_image', DB::raw( 'AVG( emp_performance ) as avg_performance' ) )
        ->inrandomorder()->take(5)->get();

        $now_date = Carbon::now()->format('d-m-Y');


        
        $have_leave_today = AttendanceCalculation::where(['date'=>$now_date,'time_in'=>'','time_out'=>''])->count();
        
        // $data=DB::table('users')
        // ->select(
        //  DB::raw('users.dept_name as dept'),
        //  DB::raw('sum(salaries.basic_salary) as salary'))
        //  ->join('salaries','salaries.employee_id', '=', 'users.id')
        // ->groupBy('dept')
        // ->get();
        // $salaryByDept = array(array());
        //
        // foreach($data as $key => $value)
        // {
        //  $salaryByDept[$key]= [$value->dept, $value->salary];
        // }
        $obj_setting=AppSettings::all();

        return view('back-end.dashboard.dashboard',[
            'new_user'=>$new_user,
            'total_user'=>$total_user,
            'female_user'=>$female_userP,
            'male_user'=>$male_userP,
            'obj_payslip'=>$obj_payslip,
            'totalIncomes'=>$totalIncomes,
			'totalExpenses'=>$totalExpenses,
			'totalIncomesPreMonth'=>$totalIncomesPreMonth,
			'totalExpensesPreMonth'=>$totalExpensesPreMonth,
			'totalExpensesPreYear'=>$totalExpensesPreYear,
			'totalIncomesPreYear'=>$totalIncomesPreYear,
			'totalSalary'=>$totalSalary,
            'avgSalary'=>$avgSalary,
            'obj_setting'=>$obj_setting,
            'leave'=>$leave,
            'lc' => $lc,
            'p' =>$p,
            'attendance'=>$attendance, 
            'userList'=>$userList, 
            'nowmonth' => $nowmonth, 
            'nowyear' => $nowyear, 
            'deduct_count'=>$obj_settings->deduct_count,
            'total_userS' => $total_userS,
			'have_leave_today'=>$have_leave_today,
        ]);

}

public function updatePaidLeave(Request $request){
    $this->validate($request, [
        'accHead' => 'paid_leave_amount|max:4|min:1',
    ]);

    $empLeave=EmpLeave::select('*')->first();
    $empLeave->paid_leave_amount=$request->paid_leave_amount;
    $empLeave->save();

    activityLog('Upadate total paid leave.');
    return redirect()->back()->with('message','Total paid leave amount  is succressfully updated');

}

public function activityLog(){

    $logs=ActivityLog::select('*')->orderBy('created_at','DESC')->get();
    // return $logs;

    return view('back-end.report.activitylog',[
        'logs'=>$logs,
    ]);
}

public function activityLogEmp(){
    $userId=Auth::user()->id;
    $logs=EmpActivityLog::select('*')->where('user_id', $userId)->orderBy('created_at','DESC')->get();

    return view('back-end.report.activity-log-Emp',[
        'logs'=>$logs,
    ]);
}

public function appSettings(){
    $obj_setting=AppSettings::first();
    return view('back-end.settings.settings',[
        'obj_setting'=>$obj_setting
    ]);
}
public function saveAppSettingsInfo(Request $request){

    // return $request;

    $this->validate($request, [
        'company_name' => 'required',
        'address' => 'required'
        
]);
        
    $obj_setting=AppSettings::find($request->setting_id);
    $obj_setting->company_name=$request->company_name;
    $obj_setting->address=$request->address;
    $obj_setting->deduct_count=$request->deduct_count;
    
    if($request->start_at == null or $request->end_at == null){

    }else{
        $obj_setting->start_at=$request->start_at;
        $obj_setting->end_at=$request->end_at;
    }
    
    if($request->check_list!=[]){
        $holi=" ";
    foreach($request->check_list as $holiday){
        $holi = $holi.$holiday.",";
    }
    $obj_setting->weekly_holidays=$holi;
    }
    

    
    $obj_setting->late_count=$request->late_count;

    if ($request->file('logo')) {
        $this->validate($request, [
            'logo' => 'required|mimes:jpg,JPG,JPEG,jpeg,png|max:2058',
        ]);

        $logo = $request->file('logo');
        $fileType = $logo->getClientOriginalExtension();
        $imageName = date('YmdHis') . "logo" . rand(5, 10) . '.' . $fileType;
        $directory = 'images/';
        $imageUrl = $directory . $imageName;
        Image::make($logo)->fit(250, 250)->save($imageUrl);
        if (File::exists($obj_setting->logo)) {
          unlink($obj_setting->logo);
          }
        $obj_setting->logo = $imageUrl;
    }


    $obj_setting->save();
    activityLog('Upadate Setting.');
    return redirect()->back()->with('message','info save successfully');
}

}
