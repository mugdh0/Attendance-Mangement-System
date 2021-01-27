<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use App\Payslip;
use App\Leave;
use App\LeaveCount;
use App\Income;
use App\Expense;
use Carbon\Carbon;
use App\Department;
use Illuminate\Support\Facades\Auth;
use App\LeaveRequest;
use App\EmpLeave;

class ReportController extends Controller
{
	public function reportAccountMonthly(){
		$expenses = Expense::select(
            DB::raw('sum(amount) as expense'),
            DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month")
        )
            ->groupBy('month')
			->get();
		$incomes = Income::select(
				DB::raw('sum(amount) as income'),
				DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month")
			)
				->groupBy('month')
				->get();
				
				$totalIncomes = Income::select('amount')->sum('amount');
				$totalExpenses = Expense::select('amount')->sum('amount');
				



//details in month
				$expenses1 = Expense::select(
					DB::raw('accHead'),
					DB::raw('id as expanse_id'),
					DB::raw('amount'),
				
					DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month"),
					DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as day"),
					DB::raw("created_at")
				)
					->get();
					
					$income1 = Income::select(
						DB::raw('accHead'),
						DB::raw('id as income_id'),
						DB::raw('amount'),
					
						DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month"),
						DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as day"),
						DB::raw("created_at")
					)
						->get();

						$balanceSheet = collect($income1)->merge($expenses1);
						$merged = $balanceSheet->sortBy('created_at');


					$res1 = $merged
					->groupBy(function ($merged) {
						 return $merged->month;
						//  return Carbon::create($merged->created_at)->format('F Y');
					});
				
// 		foreach($res1 as $key=>$value){
// 			foreach($value as $data){
// 				if($data->expanse_id){
// 				return $data;
// 				}else{
// 					return $data;
// 				}
// 			}
// 					// return $value;
// 				}
				

// return $res1;











			$balanceSheet = collect($incomes)->merge($expenses);
			$merged = $balanceSheet->sortBy('created_at');
	


			$res = $merged
				->groupBy(function ($merged) {
					 return $merged->month;
					//  return Carbon::create($merged->created_at)->format('F Y');
				});
				// return $res;
				// foreach($res as $key=>$value){
				// 	return $value[0]->incomes;
				// }
				

		return view('back-end.report.account-report-monthly',[
			'totalIncomes'=>$totalIncomes,
			'totalExpenses'=>$totalExpenses,
			'report'=>$res,
			'res1'=>$res1,
		]);
	}

	public function reportAccountYearly(){
		$expenses = Expense::select(
            DB::raw('sum(amount) as expense'),
            DB::raw("DATE_FORMAT(created_at,'%Y') as year")
        )
            ->groupBy('year')
			->get();
		$incomes = Income::select(
				DB::raw('sum(amount) as income'),
				DB::raw("DATE_FORMAT(created_at,'%Y') as year")
			)
				->groupBy('year')
				->get();
				
				$totalIncomes = Income::select('amount')->sum('amount');
				$totalExpenses = Expense::select('amount')->sum('amount');

			$balanceSheet = collect($incomes)->merge($expenses);
			$merged = $balanceSheet->sortBy('created_at');
	


			$res = $merged
				->groupBy(function ($merged) {
					 return $merged->year;
					//  return Carbon::create($merged->created_at)->format('F Y');
				});
				// return $res;
				// foreach($res as $key=>$value){
				// 	return $value[0]->income;
				// }
				

		return view('back-end.report.account-report-yearly',[
			'report'=>$res,
			'totalIncomes'=>$totalIncomes,
			'totalExpenses'=>$totalExpenses,
		]);
	}

	public function reportEmployeePerformance(){


		$obj_payslip=Payslip::groupBy( 'employee_id','employee_name','employee_role','emp_image' )
		->select( 'employee_name','employee_id','employee_role','emp_image', DB::raw( 'AVG( emp_performance ) as avg_performance' ) )
		->get();

// return $obj_payslip;
		return view('back-end.report.employee-performance',[
			'obj_payslip'=>$obj_payslip,
		]);
	}
	public function empLeavereport(){
		// $empLeaveReport=LeaveRequest::join('users', 'leave_requests.emp_db_id', '=', 'users.id')
		// ->select(DB::raw("SUM(day) as TotalDay"),'leave_requests.emp_db_id',
		// 'users.name', 'users.profile_photo')
		// ->where('leave_requests.status','Accepted(paid)')
		// ->groupBy('leave_requests.emp_db_id',
		// 'users.name', 'users.profile_photo')
		// ->get();
		// // return $empLeaveReport;
		// $totalPaidLeave=EmpLeave::select('*')->first();
		// return view('back-end.report.emp-leave-report',[
		// 	'empLeaveReport'=>$empLeaveReport,
		// 	'totalPaidLeave'=>$totalPaidLeave,
		// ]);

		$userList = User::orderBy('created_at','DESC')->get();
		$lvrp = LeaveCount::join('users', 'leave_counts.emp_id','=','users.emp_id')
		->select('leave_counts.*','users.name','users.emp_id')
		->orderBy('created_at','DESC')->get();
		
		$emp_leave = EmpLeave::find(1);

		return view('back-end.report.emp-leave-report',[
			'lvrp'=>$lvrp,'userList'=>$userList,'emp_leave'=>$emp_leave->paid_leave_amount,
		]);
		// return $userList;
	}

public function empLeavereportList($id,$name){

	$empLeaveReport=LeaveRequest::join('users', 'leave_requests.emp_db_id', '=', 'users.id')
	->select('leave_requests.*', 'users.name', 'users.profile_photo')
	->where('leave_requests.emp_db_id',$id) 
	->get();
	// return $empLeaveReport;
	$allPaidLeave=LeaveRequest::where('status','Accepted(paid)')
	->where('emp_db_id',Auth::user()->id)
	->get();
	// return $allPaidLeave;
	$leavdays=0;
	
	foreach($allPaidLeave as $paidLeave){

	$leavdays=$leavdays+ $paidLeave->day;
	}



	// return $leavdays;

	$totalPaidLeave=EmpLeave::select('*')->first();

	return view('back-end.report.emp-leave-list',[
		'allLeaveRequest'=>$empLeaveReport,
		'totalPaidLeave'=>$totalPaidLeave,
		'allPaidLeave'=>$leavdays,
	]);


}
public function empSalaryreportList(){
    $user_id=Auth::user()->id;
    $emp=User::find($user_id);


	$obj_payslip=Payslip::select('employee_name','employee_id','employee_email',
		DB::raw('sum(basic_salary) as basic_salary'),
		DB::raw('sum(house_rent_allowance) as house_rent_allowance'),
		DB::raw('sum(bonus) as bonus'),
		DB::raw('sum(conveyance) as conveyance'),
		DB::raw('sum(other_allowance) as other_allowance'),
		DB::raw('sum(TDS) as TDS'),
		DB::raw('sum(provident_fund) as provident_fund'),
		DB::raw('sum(c_bank_loan) as c_bank_loan'),
		DB::raw('sum(other_deductions) as other_deductions') 

	)->groupby('employee_name','employee_id','employee_email')->get();
	$obj_empName=Payslip::select('employee_name')->distinct('employee_name')->get();
	
	// return $obj_payslip; 
    
	return view('back-end.report.emp-payslip-report',[
        'obj_payslip'=>$obj_payslip,
        'obj_empName'=>$obj_empName,
    
    ]);

}

public function empSalaryreportListFor($email,$name){



    $obj_payslip=Payslip::select('*')->where('employee_email',$email)->orderBy('payment_status', 'DESC')->get();
    $obj_empName=Payslip::select('employee_name')->distinct('employee_name')->get();
    
	return view('back-end.report.emp-payslip-report-For',[
        'obj_payslip'=>$obj_payslip,
        'obj_empName'=>$obj_empName,
        'name__'=>$name,
    
    ]);

}


}
