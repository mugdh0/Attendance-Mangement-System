<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\AccountHead;
use App\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AccountHeadController extends Controller
{
	public function addNewAccHead(Request $request){

		$this->validate($request, [
			'head_name' => 'required|max:30|min:2',
		]);
		$user_name = Auth::User()->name;
		$obj_accHead=new AccountHead();

		$obj_accHead->head_name=$request->head_name;
		$obj_accHead->head_description=$request->head_description;
		$obj_accHead->created_by=$user_name;
		$obj_accHead->status=$request->status;
		$obj_accHead->save();

		activityLog('Add new account head');
		return redirect()->back()->with('message','Info Added Successfully');
		
	}
	public function editAccHead(Request $request){

		$this->validate($request, [
			'head_name' => 'required|max:30|min:2',
		]);
		$user_name = Auth::User()->name;
		$obj_accHead=AccountHead::find($request->acc_head_id);

		$obj_accHead->head_name=$request->head_name;
		$obj_accHead->head_description=$request->head_description;
		$obj_accHead->created_by=$user_name;
		$obj_accHead->status=$request->status;
		$obj_accHead->save();
		activityLog('Edit account head');

		return redirect()->back()->with('message','Info Update Successfully');
	}
	public function deleteAccHead($id){
		AccountHead::find($id)->delete();


		activityLog('Delete account head');

		return redirect()->back()->with('message','Info Delete Successfully');
	}
	public function activeAccHead($id){
		$obj_accHead=AccountHead::find($id);
		$obj_accHead->status='Active';
		$obj_accHead->save();



		activityLog('Active account head');

		return redirect()->back()->with('message','Accout Head Active Successfully');
	}
	public function inactiveAccHead($id){
		$obj_accHead=AccountHead::find($id);
		$obj_accHead->status='Inactive';
		$obj_accHead->save();

		activityLog('Inactive account head');
	

		return redirect()->back()->with('message','Accout Head Inactive Successfully');
	}





}
