<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Holiday;
use Carbon\Carbon;
use App\AttendanceCalculation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HolidayController extends Controller
{
    public function index(){
	
		$userList = User::orderBy('created_at', 'desc')->get();
	
			$holidays= Holiday::select('*')
			->orderBy('created_at', 'ASC')->get();

			$holidays=Holiday::join('users', 'holidays.emp_id', '=', 'users.emp_id')
	 ->select('holidays.*','users.name','users.emp_id','users.profile_photo')->orderBy('holidays.created_at', 'desc')->get();
    	// dd($holidays);
    	return view('back-end.holiday.holiday',[
    		'holidays'=> $holidays, 'userList'=>$userList,
    	]);
    }

    public function addNewHoliday(Request $request){

	//return $request;
      $this->validate($request, [
        'holiday_of' => 'required',
        'date' => 'required',
    ]);
	
	$id = explode(" ",$request->holiday_of);
	
	$have_holiday = Holiday::where('emp_id',$id[0])->get();
	$req_date = explode(",",$request->date);

	foreach($have_holiday as $hh){
		$hd = explode(",",$hh->date);
		foreach($hd as $h){
			foreach($req_date as $rq){
			if((new Carbon($h))->equalTo(new Carbon($rq))){
				return redirect()->back()->with('danger','holidays date Already added');
	
				}else{
				
				}
			}
		}
	}
		
		$holiday = new Holiday();
		$holiday->emp_id = $id[0];
		$holiday->date = $request->date;
		
		$holiday->save();
		
		$holiday_token = Holiday::where(['emp_id'=>$id[0],'date'=>$request->date])->first();
				$date = explode(",",$request->date);

				foreach($date as $dt){
					$atten = new AttendanceCalculation();
					$atten->user_id = $id[0];
					$atten->date = Carbon::parse($dt)->format('d-m-Y');
					$atten->status= "H";
					$atten->holiday_token = $holiday_token->id;
					$atten->save();

			}

			return redirect()->back()->with('message','holidays added Successfully');
	

	

	// $obj_holiday=new Holiday();
	// $obj_holiday->date=$request->date;

	

	// $obj_holiday->save();
	

	}

	public function deleteHoliday($id){
	
	$dele = Holiday::find($id);

	$date = explode(",",$dele->date);
	
	 foreach($date as $dt){
		AttendanceCalculation::where(['user_id'=>$dele->emp_id, 'date'=>$dt])->delete();
	} 
	
	 Holiday::find($id)->delete();



	activityLog('Delete Holiday.');
	
	return redirect()->back()->with('message','Holiday Delete Successfully');
	}

	
	public function updateHoliday(Request $request){
		$this->validate($request, [
			'holiday_of' => 'required',
			'date' => 'required',
		]);
		

		$id= explode(" ", $request->holiday_of);

		AttendanceCalculation::where('holiday_token',$id[0])->delete();
		$holiday = holiday::where('id', $id[0])->first();
		$holiday->date= $request->date;
		$holiday->save();

		$datef = explode(",",$request->date);
      
				foreach($datef as $dt){
                    $atten = new AttendanceCalculation();
                    $atten->user_id = $id[1];
                    $atten->date = Carbon::parse($dt)->format('d-m-Y');
                    $atten->status = "H";
                    $atten->holiday_token = $id[0];
                    $atten->save();
                }

		return redirect()->back()->with('message','holidays Successfully updated..');
		
	}

}
