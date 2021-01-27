<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Income;
use App\Expense;
use App\AccountHead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\ActivityLog;

class AccountsController extends Controller
{
    public function accHead(){
        $obj_accHead=AccountHead::all();
    	return view('back-end.accounts.account-head',[
            'obj_accHead'=>$obj_accHead,
        ]);
    }
    public function accExpenses(){
        $obj_accHead=AccountHead::where('status','Active')->get();
        $obj_expenses=Expense::select('*')->orderBy('created_at', 'desc')->get();
        // return $obj_expenses;
    	return view('back-end.accounts.account-expenses',[
            'obj_accHead'=>$obj_accHead,
            'obj_expenses'=>$obj_expenses,
        ]);
    }
    public function accIncome(){
        $obj_accHead=AccountHead::where('status','Active')->get();
    	$obj_income=Income::all();
    	return view('back-end.accounts.account-income',[
            'obj_income'=>$obj_income,
            'obj_accHead'=>$obj_accHead,
    	]);

    }
    public function AddNewAccIncome(Request $request){
    $user_name = Auth::User()->name;

    $this->validate($request, [
        'accHead' => 'required|max:30|min:2',
        'amount' => 'required|min:2|numeric',
    ]);

    	
	$obj_income=new Income();
	$obj_income->accHead=$request->accHead;
	$obj_income->amount=$request->amount;
	$obj_income->created_by=$user_name;
	$obj_income->save();

   
    activityLog('Add New Income');

	return redirect()->back()->with('message','Info Added Successfully.');

    }

    public function deleteIncome($id){
        Income::find($id)->delete();
        
        activityLog('Delete Income form List');

		return redirect()->back()->with('message','Info Delete Successfully.');
    }

    public function editIncome(request $request){
    	// return $request;
    $this->validate($request, [
        'accHead' => 'required|max:30|min:2',
        'amount' => 'required|min:2|numeric',
    ]);
    $user_name = Auth::User()->name;

    $obj_income=Income::find($request->income_id);
	$obj_income->accHead=$request->accHead;
	$obj_income->amount=$request->amount;
	$obj_income->created_by=$user_name;
    $obj_income->save();
    
    activityLog('Edit Income form List');

	return redirect()->back()->with('message','Info Edit Successfully.');

    }

    public function filterIncomeByDate(Request $request){
        
        $sDate=Carbon::parse($request->start_date)->format('Y-m-d');
        $eDate=Carbon::parse($request->end_date)->format('Y-m-d');
        
        $obj_accHead=AccountHead::where('status','Active')->get();
      
    if($request->accHead!=null && $request->start_date!=null && $request->end_date==null){

            $obj_income=Income::where('created_at', 'like', '%'.$sDate.'%')
            ->where('accHead',$request->accHead)
            ->orderBy('created_at', 'DESC')->get();


    }elseif($request->accHead != null && $request->start_date==null && $request->end_date==null){
            $obj_income=Income::where('accHead',$request->accHead)
                        ->orderBy('created_at', 'DESC')->get();
    }elseif($request->accHead==null && $request->start_date!=null && $request->end_date!=null){
        $obj_income=Income::whereBetween('created_at', [$sDate, $eDate])
        ->orderBy('created_at', 'DESC')->get();
    }elseif($request->accHead!=null && $request->start_date!=null && $request->end_date!=null){
        $obj_income=Income::whereBetween('created_at', [$sDate, $eDate])
        ->where('accHead',$request->accHead)
        ->orderBy('created_at', 'DESC')->get();
    }else{
        return redirect()->back()->with('warning','Did not match any documents.');
    }



    	return view('back-end.accounts.account-income',[
    		'obj_income'=>$obj_income,
    		'obj_accHead'=>$obj_accHead,
    	]);
    }
public function filterAccHead(Request $request){
    $sDate=Carbon::parse($request->created_date)->format('Y-m-d');
    $obj_accHead=AccountHead::where('created_at', 'like', '%'.$sDate.'%')->get();


    return view('back-end.accounts.account-head',[
        'obj_accHead'=>$obj_accHead,
    ]);
}

}
