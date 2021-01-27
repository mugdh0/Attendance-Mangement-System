<?php

namespace App\Http\Controllers;
use App\Expense;
use App\AccountHead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExpensesController extends Controller
{
    public function addNewExpenses(Request $request){
        $this->validate($request, [
            'accHead' => 'required|max:30|min:2',
            'amount' => 'required|min:2|numeric',
        ]);
        $user_name = Auth::User()->name;
        $obj_expense=new Expense();
        $obj_expense->accHead=$request->accHead;
        $obj_expense->amount=$request->amount;
        $obj_expense->created_by=$user_name;
        $obj_expense->save();

        activityLog('Add new expenses.');
        return redirect()->back()->with('message','Expense added successfully');
    }


    public function deleteExpense($id){
        Expense::find($id)->delete();
        activityLog('Delete expenses.');
		return redirect()->back()->with('message','Info Delete Successfully.');
    }

    public function editExpens(request $request){
    	// return $request;
    $this->validate($request, [
        'accHead' => 'required|max:30|min:2',
        'amount' => 'required|min:2|numeric',
    ]);
    $user_name = Auth::User()->name;

    $obj_expense=Expense::find($request->expenses_id);
	$obj_expense->accHead=$request->accHead;
	$obj_expense->amount=$request->amount;
	$obj_expense->created_by=$user_name;
    $obj_expense->save();

    activityLog('Edit expenses.');
	return redirect()->back()->with('message','Info Edit Successfully.');

    }

    public function filterExpenseByDate(Request $request){
        $sDate=Carbon::parse($request->start_date)->format('Y-m-d');
        $eDate=Carbon::parse($request->end_date)->format('Y-m-d');
        
    	// $obj_expense=Expense::whereBetween('created_at', [$sDate, $eDate])
    	// ->orderBy('created_at', 'DESC')->get();
        $obj_accHead=AccountHead::where('status','Active')->get();




        if($request->accHead!=null && $request->start_date!=null && $request->end_date==null){

            $obj_expense=Expense::where('created_at', 'like', '%'.$sDate.'%')
            ->where('accHead',$request->accHead)
        ->orderBy('created_at', 'DESC')->get();


    }elseif($request->accHead != null && $request->start_date==null && $request->end_date==null){
            $obj_expense=Expense::where('accHead',$request->accHead)
                        ->orderBy('created_at', 'DESC')->get();
    }elseif($request->accHead==null && $request->start_date!=null && $request->end_date!=null){
    	$obj_expense=Expense::whereBetween('created_at', [$sDate, $eDate])
    	->orderBy('created_at', 'DESC')->get();

    }elseif($request->accHead!=null && $request->start_date!=null && $request->end_date!=null){
        $obj_expense=Expense::whereBetween('created_at', [$sDate, $eDate])
        ->where('accHead',$request->accHead)
        ->orderBy('created_at', 'DESC')->get();
    }else{
        return redirect()->back()->with('warning','Did not match any documents.');
    }


    	return view('back-end.accounts.account-expenses',[
    		'obj_expenses'=>$obj_expense,
    		'obj_accHead'=>$obj_accHead,
    	]);
    }

}
