<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Charts;
use App\User;
use App\Payslip;
use App\Income;
use App\Expense;
use Carbon\Carbon;
use App\Department;
use Illuminate\Support\Facades\Auth;
use App\ActivityLog;

class ChartController extends Controller
{
    public function profitChart()
    {

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
				->groupBy('month')->orderBy('month','DESC')
				->take(12)->get();

			$balanceSheet = collect($incomes)->merge($expenses);
			$merged = $balanceSheet->sortBy('created_at');
	


			$res = $merged
				->groupBy(function ($merged) {
					 return $merged->month;
					//  return Carbon::create($merged->created_at)->format('F Y');
                });
                
				$data2 = [];
				foreach($res as $key=>$value){
					$data2[] = [
						'month' => Carbon::createFromFormat('Y-m',$key)->format('F Y'),
						'amount' => $value[0]->income-$value[1]->expense
					];
					
				}


        return response()->json($data2);
    }


}

