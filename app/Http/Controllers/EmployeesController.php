<?php

namespace App\Http\Controllers;
use \Mpdf\Mpdf;
use Illuminate\Http\Request;
use App\User;
use App\Role; 
use App\importUser;
use App\Attendance;
use App\AttendanceCalculation;
use App\LeaveRequest;

use App\Department;
use App\Holiday;
use App\Leave;
use App\LeaveCount;
use App\Att;
use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use File;
use Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\EmpLeave;
use App\ActivityLog;

use App\Imports\InOutImport;
use App\Imports\UsersImport; 
use App\Imports\empImport;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

use App\AppSettings;
use App\InOutSetting;

class EmployeesController extends Controller
{
	public function filterEmployeedate(Request $request){
		
		$from = Carbon::parse($request->form)->format('d-m-Y');
		$to = Carbon::parse($request->to)->format('d-m-Y');
		
		
	// 	$obj_setting=AppSettings::first();
	// $nowmonth = $request->month;
	// $nowyear = $request->year;
	// // return $nowmonth;
	$userList = User::orderBy('created_at', 'desc')->get();
	
	$attendance = AttendanceCalculation::whereBetween('date', [$from, $to])->get();
	
	$src = 1;

	// $attendance=AttendanceCalculation::join('users', 'attendance_calculations.user_id', '=', 'users.emp_id')
	//  ->select('attendance_calculations.*','users.name','users.emp_id','users.profile_photo')->orderBy('attendance_calculations.date', 'desc')->get();

	 return view('back-end.employee.emp-attendanceShortfilter',[
 		'attendance'=>$attendance, 'userList'=>$userList, 'src'=>$src, 
	 	]);
	 }

	
	
	public function generatereport($month,$year){
		$obj_setting=AppSettings::first();
		$nowmonth = $month;
		$nowyear = $year;
		$userList = User::orderBy('created_at', 'desc')->get();

		$attendance=AttendanceCalculation::join('users', 'attendance_calculations.user_id', '=', 'users.emp_id')
		 ->select('attendance_calculations.*','users.name','users.emp_id','users.profile_photo')->orderBy('attendance_calculations.date', 'desc')->get();


			$mpdf = new \Mpdf\Mpdf([
				'margin_left' =>15,
				'margin_top' =>15,
				'margin_right' =>15,
				'margin_bottom' =>15,
				'default_font_size' => 9,
			]);

			$html = \View::make('back-end.report.rep')->with([
				'attendance'=>$attendance, 'userList'=>$userList, 'nowmonth' => $nowmonth, 'nowyear' => $nowyear, 'deduct_count'=>$obj_setting->deduct_count,
			]);
			$html= $html->render();
			$mpdf->SetHeader('Update Diagonostic,Rangpur|Atttendence Report(details)|{PAGENO}');

			$long_html = strlen($html);
			$long_int  = intval($long_html/1000);
			
			if($long_int > 0)
			{
				for($i = 0; $i<$long_int; $i++)
				{
					$temp_html = substr($html, ($i*1000),999);
					$mpdf->WriteHTML($temp_html);
				}
				//Last block
				$temp_html = substr($html, ($i*1000),($long_html-($i*1000)));
				$mpdf->WriteHTML($temp_html);
			}
			else
			{
				$mpdf->WriteHTML($html);
			}

			//$mpdf->WriteHTML($html);
			$mpdf->Output('att.pdf','I');

	}
	public function generatesummary($month,$year){
		$obj_setting=AppSettings::first();
		$nowmonth = $month;
		$nowyear = $year;
		$userList = User::orderBy('created_at', 'desc')->get();

		$attendance=AttendanceCalculation::join('users', 'attendance_calculations.user_id', '=', 'users.emp_id')
		 ->select('attendance_calculations.*','users.name','users.emp_id','users.profile_photo')->orderBy('attendance_calculations.date', 'desc')->get();


			$mpdf = new \Mpdf\Mpdf([
				'margin_left' =>15,
				'margin_top' =>15,
				'margin_right' =>15,
				'margin_bottom' =>15,
				'default_font_size' => 9,
			]);

			$html = \View::make('back-end.report.repsum')->with([
				'attendance'=>$attendance, 'userList'=>$userList, 'nowmonth' => $nowmonth, 'nowyear' => $nowyear, 'deduct_count'=>$obj_setting->deduct_count,
			]);
			$html= $html->render();
			$mpdf->SetHeader('Update Diagonostic,Rangpur|Atttendence Report(summary)|{PAGENO}');
			
			$long_html = strlen($html);
			$long_int  = intval($long_html/1000);
			
			if($long_int > 0)
			{
				for($i = 0; $i<$long_int; $i++)
				{
					$temp_html = substr($html, ($i*1000),999);
					$mpdf->WriteHTML($temp_html);
				}
				//Last block
				$temp_html = substr($html, ($i*1000),($long_html-($i*1000)));
				$mpdf->WriteHTML($temp_html);
			}
			else
			{
				$mpdf->WriteHTML($html);
			}

			$mpdf->Output('att.pdf','I');

	}

	public function AttTimingSettings(){
		$userList = User::orderBy('created_at', 'desc')->get();

		$in_outSettings=InOutSetting::join('users', 'in_out_settings.user_id', '=', 'users.emp_id')
		->select('in_out_settings.*','users.name','users.emp_id','users.profile_photo')->orderBy('in_out_settings.created_at', 'desc')->get();

		return view('back-end.employee.emp-attInOutSetting',[
				'in_outSettings'=>$in_outSettings, 'userList'=>$userList,
			]);
	}
	
	public function saveAttTimingSettings(Request $request){
		$this->validate($request, [
				'attendence_of' => 'required',
				'in_time' => 'required',
				'out_time' => 'required',
		]);
			
		//eturn $request->attendence_of;
		$emp_id = explode(" ", $request->attendence_of);
		
		$users = InOutSetting::where('user_id',$emp_id[0])->get();
		if(count($users)>0){
			return redirect()->back()->with('danger', 'Attendance Already added');
		}else{
			$inoutset = new InOutSetting();
		$inoutset->user_id = $emp_id[0];
		$inoutset->in_time = $request->in_time;
		$inoutset->out_time = $request->out_time;

		$inoutset->save();
	
		return redirect()->back()->with('message', 'In Out Time Info Successfully added');
		
		}
		
	}

	public function updateAttTimingSettings(Request $request){
		$this->validate($request, [
				'attendence_of' => 'required',
				'in_time' => 'required',
				'out_time' => 'required',
		]);
	
		$id= explode(" ", $request->attendence_of);
		$users = InOutSetting::where('id',$id)->first();
		$users->in_time = $request->in_time;
		$users->out_time = $request->out_time;
		$users->save();
	
		return redirect()->back()->with('message', 'In Out Time Info Successfully added');
			
		
		
	}
public function printempview(){
		$userList = User::orderby('designation','asc')->get();
        $roles = Role::all();


		$roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();

		$inout_time = InOutSetting::all();
		$holidays = Holiday::all();
// return $roleList;

		return view('back-end.report.emp-print-preview',[
            'userList'=>$userList,
			// 'obj_dept'=>$obj_dept,
			'roles'=>$roles,
			'roleList'=>$roleList,
			'inout_time'=>$inout_time,
			'holidays'=>$holidays,
		]);
}

	public function empAll(){
		// $userList = User::join('in_out_settings','users.emp_id','=','in_out_settings.user_id')
		// 			->join('holidays','users.emp_id','=','holidays.emp_id')
		// 			->select('users.*','in_out_settings.*','holidays.*')
		// 			->orderBy('users.department','asc')->get();
        //  return $userList;
		//$obj_dept=Department::all();
		$userList = User::orderby('designation','asc')->get();
        $roles = Role::all();


		$roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();

		$inout_time = InOutSetting::all();
		$holidays = Holiday::all();
// return $roleList;

		return view('back-end.employee.emp-all',[
            'userList'=>$userList,
			// 'obj_dept'=>$obj_dept,
			'roles'=>$roles,
			'roleList'=>$roleList,
			'inout_time'=>$inout_time,
			'holidays'=>$holidays,
		]);
	}
	public function newEmployeeList(){
		$userList = User::where('job_status','Provision Period')->orderBy('created_at', 'desc')->get();
        // return $userList;
        //$obj_dept=Department::all();
		return view('back-end.employee.new-emp-list',[
            'userList'=>$userList,
			'obj_dept'=>$obj_dept,
		]);
	}
	public function empLeave(){
		if(Auth::user()->hasRole(['Super Admin','Admin'])){
			$allLeave=Leave::join('users', 'leaves.emp_db_id', '=', 'users.emp_id')
			->select('leaves.*','users.name','users.emp_id','users.profile_photo')->orderBy('created_at', 'desc')->get();

$userList = User::orderBy('created_at', 'desc')->get();
$totalPaidLeave=EmpLeave::select('*')->first();
			return view('back-end.employee.emp-leave',[
					'allLeave'=>$allLeave, 'userList'=>$userList, 'totalPaidLeave'=>$totalPaidLeave,
			]);
		}
	}

	// public function empLeave(){
	//
  //       if(Auth::user()->hasRole('Super Admin')){
	//
  //           $allLeaveRequest=LeaveRequest::join('users', 'leave_requests.emp_db_id', '=', 'users.id')
  //           ->select('leave_requests.*','users.name','users.emp_id','users.profile_photo')->orderBy('created_at', 'desc')->get();
  //       // return $allLeaveRequest;
	//
	//
  //       }else{
  //           $allLeaveRequest=LeaveRequest::join('users', 'leave_requests.emp_db_id', '=', 'users.id')
  //           ->where('leave_requests.emp_db_id',Auth::user()->id)
  //           ->select('leave_requests.*','users.name','users.emp_id','users.profile_photo')->orderBy('created_at', 'desc')->get();
	//
	//
  //       }
  //       $allPaidLeave=LeaveRequest::where('status','Accepted(paid)')
  //       ->where('emp_db_id',Auth::user()->id)
  //       ->get();
  //       $leavdays=0;
	//
  //       foreach($allPaidLeave as $paidLeave){
  //           $d1=Carbon::parse($paidLeave->start_date)->diffInDays($paidLeave->end_date);
	//
  //       $leavdays=$leavdays+ $d1+1;
  //       }
	//
	//
	//
  //       // return $leavdays;
  //       $leaveUser=LeaveRequest::join('users', 'leave_requests.emp_db_id', '=', 'users.id')
  //       ->select('users.name')->where('users.name','!=',null)->distinct('users.name')->get();
  //       $totalPaidLeave=EmpLeave::select('*')->first();
	//
	// 			$userList = User::orderBy('created_at', 'desc')->get();
	//
	//
  //   }

    public function empAttendance(){

		$obj_setting=AppSettings::first();
		$nowmonth = Carbon::now()->month;
		$nowyear = Carbon::now()->year;
		$userList = User::orderBy('created_at', 'desc')->get();

		$attendance=AttendanceCalculation::join('users', 'attendance_calculations.user_id', '=', 'users.emp_id')
		 ->select('attendance_calculations.*','users.name','users.emp_id','users.profile_photo')->orderBy('attendance_calculations.date', 'desc')->get();

		return view('back-end.employee.emp-attendance',[
				'attendance'=>$attendance, 'userList'=>$userList, 'nowmonth' => $nowmonth, 'nowyear' => $nowyear, 'deduct_count'=>$obj_setting->deduct_count,
			]);
		
  }
  public function empAttendanceSrc(Request $request){
	$obj_setting=AppSettings::first();
	$nowmonth = $request->month;
	$nowyear = $request->year;
	// return $nowmonth;
	$userList = User::orderBy('created_at', 'desc')->get();

	$attendance=AttendanceCalculation::join('users', 'attendance_calculations.user_id', '=', 'users.emp_id')
	 ->select('attendance_calculations.*','users.name','users.emp_id','users.profile_photo')->orderBy('attendance_calculations.date', 'desc')->get();

	return view('back-end.employee.emp-attendance',[
			'attendance'=>$attendance, 'userList'=>$userList, 'nowmonth' => $nowmonth, 'nowyear' => $nowyear, 'deduct_count'=>$obj_setting->deduct_count,
		]);
}
public function dailyempAttendance(Request $request){
	// return $request->srcdate;
	// m/d/y

	$date = explode("/",$request->srcdate);

	$dt = Carbon::parse($request->srcdate)->format('d-m-Y');
	$obj_setting=AppSettings::first();
	
	$nowdate = $date[1];
	$nowmonth = $date[0];
	$nowyear = $date[2];
	// return $nowmonth;
	$userList = User::orderBy('created_at', 'desc')->get();

	$attendance=AttendanceCalculation::join('users', 'attendance_calculations.user_id', '=', 'users.emp_id')
	 ->select('attendance_calculations.*','users.name','users.emp_id')->where(['date'=>$dt,'leave_token'=>0,'holiday_token'=>0])->orderBy('attendance_calculations.date', 'desc')->get();

	return view('back-end.employee.emp-attendanceShort',[
			'attendence_today'=>$attendance, 'userList'=>$userList, 'nowmonth' => $nowmonth, 'nowyear' => $nowyear, 'nowdate'=>$nowdate,
		]);
	
}
	public function empAttendanceShort(){
		
		$userList = User::orderBy('created_at', 'desc')->get();

		$time = Carbon::now()->toDateTimeString();
		$date = explode(" ",$time);
		$dt = Carbon::parse($date[0])->format('d-m-Y');

		$d = explode("-",$dt);
		// return $dt;
		
		
		$attendence_today=AttendanceCalculation::join('users', 'attendance_calculations.user_id', '=', 'users.emp_id')
		->select('attendance_calculations.*','users.name','users.emp_id','users.profile_photo')->where(['date'=>$dt,'leave_token'=>0,'holiday_token'=>0])->orderBy('attendance_calculations.date', 'desc')->get();

		return view('back-end.employee.emp-attendanceShort',[
				'attendence_today'=>$attendence_today, 'userList'=>$userList, 'nowdate'=>$d[0], 'nowmonth'=>$d[1],'nowyear'=>$d[2],
			]);
}

public function updateAttendence(Request $request){
	$this->validate($request, [
			'attendence_of' => 'required',
			'date' => 'required',
			'in_time' => 'required',
			'out_time' => 'required',
	]);

	
	$date=Carbon::parse($request->date)->format('d-m-Y');

	$id = explode(" ", $request->attendence_of);

	$att = AttendanceCalculation::find($id[0]);
	$att->date = $date;
	//return $att;
	
				$att_in_time = Carbon::parse($request->in_time)->format('H:i:s');
				$att_out_time = Carbon::parse($request->out_time)->format('H:i:s');

				$att->time_in = $att_in_time;
				$att->time_out = $att_out_time;

				$att_officehour = InOutSetting::where('user_id',$att->user_id)->first();
				$sid="1";
			 	$offichour = AppSettings::find($sid);

			 	$off_in_time = Carbon::parse($att_officehour->in_time)->addMinutes($offichour->late_count)->format('H:i:s'); 
				$off_out_time = Carbon::parse($att_officehour->out_time)->format('H:i:s');
				
					if ((new Carbon($att_in_time))->greaterThan(new Carbon($off_in_time))){
						$att->status = "L/"; //late
						$att->late = $att->late +1;
					}else{
						$att->status = "P/"; //notlate
						$att->present = 1;
					}

					if ((new Carbon($att_out_time))->lessThan(new Carbon($off_out_time))){
						$att->status = $att->status."L"; //late
						$att->late = $att->late +1;
					}else{
						$att->status = $att->status."P"; //notlate
						$att->present = 1;
					}
				$att->save();
	
				


// 	if($c>$d){
//     $attendence->status = "L/";
// }else{
// 	$attendence->status = "P/";
// }

// if($e<$f){
// 	$attendence->status = $attendence->status."L";
// }else{
// $attendence->status = $attendence->status."P";
// }

	return redirect()->back()->with('message', 'Attendance Info Successfully updaed');

}

public function addAttendence(Request $request){
	$this->validate($request, [
			'attendence_of' => 'required',
			'date' => 'required',
			'in_time' => 'required',
			'out_time' => 'required',
	]);
	$date=Carbon::parse($request->date)->format('d-m-Y');

	$emp_id= explode(" ", $request->attendence_of);

	$have_att = AttendanceCalculation::where(['user_id'=>$emp_id[0],'date'=>$date])->get();

	if(count($have_att)>0){
		return redirect()->back()->with('danger', 'Attendance date Allready added');
	}else{

	$att = new AttendanceCalculation();
	$att->user_id = $emp_id[0];
	$att->date = $date;
	
				$att_in_time = Carbon::parse($request->in_time)->format('H:i:s');
				$att_out_time = Carbon::parse($request->out_time)->format('H:i:s');

				$att->time_in = $att_in_time;
				$att->time_out = $att_out_time;

				$att_officehour = InOutSetting::where('user_id',$att->user_id)->first();
				$sid="1";
			 	$offichour = AppSettings::find($sid);

			 	$off_in_time = Carbon::parse($att_officehour->in_time)->addMinutes($offichour->late_count)->format('H:i:s'); 
				$off_out_time = Carbon::parse($att_officehour->out_time)->format('H:i:s');
				
				$att->late=0;
				$att->present=0;
					if ((new Carbon($att_in_time))->greaterThan(new Carbon($off_in_time))){
						$att->status = "L/"; //late
						$att->late = $att->late +1;
					}else{
						$att->status = "P/"; //notlate
						$att->present = 1;
					}

					if ((new Carbon($att_out_time))->lessThan(new Carbon($off_out_time))){
						$att->status = $att->status."L"; //late
						$att->late = $att->late +1;
					}else{
						$att->status = $att->status."P"; //notlate
						$att->present = 1;
					}

	 $att->save();

	return redirect()->back()->with('message', 'Attendance Info Successfully added');

	}

}

public function deleteAttendence($id){
	AttendanceCalculation::find($id)->delete();
    return redirect()->back()->with('message', 'Attendance Info Successfully Deleted');

}
public function deleteAttendencetimeing($id){
	InOutSetting::find($id)->delete();
    return redirect()->back()->with('message', 'Attendance Info Successfully Deleted');

}

public function importInOut(Request $request){
	if($request->hasFile('file')){
		Excel::import(new InOutImport, request()->file('file'));

		return redirect()->back()->with('message','xlxs sheet uploaded Successfully.');

	}else{
				$userList = User::orderBy('created_at', 'desc')->get();

		$in_outSettings=InOutSetting::join('users', 'in_out_settings.user_id', '=', 'users.emp_id')
		->select('in_out_settings.*','users.name','users.emp_id','users.profile_photo')->orderBy('in_out_settings.created_at', 'desc')->get();

		return view('back-end.employee.emp-attInOutSetting',[
				'in_outSettings'=>$in_outSettings, 'userList'=>$userList,
			]);
	}
}


public function importemp(Request $request ){
// 	if($request->hasFile('file')){
// 		Excel::import(new empImport, request()->file('file'));
// 		$importEmp = importUser::all();
		
// 		foreach($importEmp as $ie){
// 			$a = User::where('emp_id',$ie->emp_id)->get();
// 			if(count($a)>0){
// 				importUser::truncate();
// 				return redirect()->back()->with('message','Employee Already Addded');
// 			}else{
// 				$adduser = new User();
// 				$adduser->emp_id = $ie->emp_id;
// 				$adduser->save();

// 				$adduser->attachRole(Role::where('name', 'Employee')->first());

// 				$now = Carbon::now()->toDateTimeString();
// 				$date = explode(" ",$now);
    
// 				$period = CarbonPeriod::create($date[0], '2021-6-31');

// 				foreach ($period as $date) {
// 					echo $date->format('d-m-Y');
// 					$att = new AttendanceCalculation();
// 					$att->user_id = $ie->emp_id;
// 					$att->date = $date->format('d-m-Y');
// 					$att->save();
// 				}	
// 			}
// 		}
// 		return redirect()->back()->with('message','Employee Added Successfully.');

// 	}else{
// 	$userList = User::orderBy('created_at', 'desc')->get();
// 	// return $userList;
// 	//$obj_dept=Department::all();
// 	$roles = Role::all();


// 	$roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();

// // return $roleList;

// 	return view('back-end.employee.emp-all',[
// 		'userList'=>$userList,
// 		// 'obj_dept'=>$obj_dept,
// 		'roles'=>$roles,
// 		'roleList'=>$roleList,
// 	]);
	
	//}

}
public function import(Request $request){
	if($request->hasFile('file')){
	Excel::import(new UsersImport, request()->file('file'));

	
	$attIn = Attendance::where('status','Check-In')->get();
	 foreach($attIn as $in){
		$time = explode(" ",$in->time);
		$d = Carbon::parse($time[0])->format('d-m-Y');
		$t = Carbon::parse($time[1])->format('H:i:s');

 	$have = AttendanceCalculation::where(['user_id'=>$in->user_id,'date'=>$d])->get();
	
	 if(count($have)>0){
	
	 }else{
			$atten = new AttendanceCalculation();
			$atten->user_id = $in->user_id;
			$atten->date = $d;
			$atten->time_in = $t;
			$atten->save(); 		
	 	}
	 }
	 $attOut = Attendance::where('status','Check-Out')->get();
	 foreach($attOut as $out){
		$tt = explode(" ", $out->time);
		$do = Carbon::parse($tt[0])->format('d-m-Y');
		$to = Carbon::parse($tt[1])->format('H:i:s');
	
	 	$attn = AttendanceCalculation::where(['user_id' => $out->user_id, 'date' => $do])->first();
		$attn->time_out = $to;
		$attn->save();
	  }
	 
	
		$attendance = AttendanceCalculation::all();
		foreach($attendance as $att){
			
				if($att->time_in == null){
					$ofh = InOutSetting::where('user_id',$att->user_id)->first();
					$att_in_time = Carbon::parse($ofh->in_time)->addMinutes(121)->format('H:i:s'); 
					//$att->time_in = $att_in_time;
					
				}else{
					$att_in_time = Carbon::parse($att->time_in)->format('H:i:s');
				}
				if($att->time_out == null){
					$ofhc = InOutSetting::where('user_id',$att->user_id)->first();
					$att_out_time = Carbon::parse($ofhc->out_time)->subMinutes(121)->format('H:i:s');
					//$att->time_out = $att_out_time;
				}else{
					$att_out_time = Carbon::parse($att->time_out)->format('H:i:s');
				}
				
				

				$att_officehour = InOutSetting::where('user_id',$att->user_id)->first();
				if($att_officehour==null){
					return redirect()->back()->with('danger','Attendence xl not Upload!!! Please fillup All Employee Attendance In and Out Time');
				}else{
					$sid="1";
					$offichour = AppSettings::find($sid);

					$off_in_time = Carbon::parse($att_officehour->in_time)->addMinutes($offichour->late_count)->format('H:i:s'); 
					$off_out_time = Carbon::parse($att_officehour->out_time)->format('H:i:s');
					
					$att->late=0;
					$att->present=0;

					if($att->status == null){
							if ((new Carbon($att_in_time))->greaterThan(new Carbon($off_in_time))){
								$att->status = "L/"; //late
								$att->late = $att->late +1;
								
							}else{
								$att->status = "P/"; //notlate
								$att->present = 1;
							}

							if ((new Carbon($att_out_time))->lessThan(new Carbon($off_out_time))){
								$att->status = $att->status."L"; //late
								$att->late = $att->late +1;
								
							}else{
								$att->status = $att->status."P"; //notlate
								$att->present = 1;
							}
							$att->save();
							
						}
				}
				
			 }
			 Attendance::truncate();
			 return redirect()->back()->with('message','xlxs sheet uploaded Successfully.');
			 
		 
	//2nd stage.....
		// $user = User::all();
		
		// foreach($user as $us){
		// 	$attendence = Attendance::where('user_id',$us->emp_id)->get();
		// 	if(count($attendence)>0){
		// 		foreach($attendence as $att){
		// 			$time = explode(" ",$att->time);
		// 			if($att->status == "Check-In"){
						

		// 			}
		// 		}
		// 	}else{
		// 		$holiday = Holiday::where('emp_id',$us->emp_id)->get();
		// 		if(count($holiday)>0){
		// 			$holi = explode(",",$holiday->date);
		// 			foreach($holi as $hl){
		// 				$atten = new AttendanceCalculation();
		// 				$atten->user_id = $att->user_id;
		// 				$atten->date = Carbon::parse($hl)->format('d-m-Y');
		// 				$atten->status = "H";
		// 				$atten->save();
		// 			}

		// 		}else{
		// 				$leave = Leave::where(['emp_db_id' => $us->emp_id,'status'=>'Accepted'])->get();
		// 				if(count($leave)>0){
		// 					$le=explode(",",$levave->leave_dates);
		// 					foreach($le as $l){
		// 						$atten = new AttendanceCalculation();
		// 						$atten->user_id = $us->emp_id;
		// 						$atten->date = Carbon::parse($l)->format('d-m-Y');
		// 						$atten->status = "CL";
		// 						$atten->save();
		// 					}
		// 				}else{
		// 					//absent--> notpunched
		// 				}
		// 		}
				
		// 	}
		// }
		//1st stage.........
			// foreach($attendence as $att){
				
			// 	$atten = new AttendanceCalculation();
			// 	$atten->user_id = $att->user_id;
			// 	$atten->date = $att->date;
			
			// 	$ti = Carbon::parse($att->time_in)->format('H:i'); 
			// 	$atten->time_in = $ti;

			// 	$to = Carbon::parse($att->time_out)->format('H:i'); 
			// 	$atten->time_out = $to;
				
			// 	$sid="1";
			// 	$offichour = AppSettings::find($sid);

			// 	$in_time = Carbon::parse($offichour->start_at)->addMinutes($offichour->late_count)->format('H:i'); 
			// 	$out_time = Carbon::parse($offichour->end_at)->format('H:i'); 


			// 	if ((new Carbon($ti))->greaterThan(new Carbon($in_time))){
			// 		$atten->status = "L/"; //late
			// 		$atten->late = $atten->late +1;
			// 	}else{
			// 		$atten->status = "P/"; //notlate
			// 		$atten->present = $atten->present+1;
			// 	}

			// 	if ((new Carbon($to))->lessThan(new Carbon($out_time))){
			// 		$atten->status = $atten->status."L"; //late
			// 		$atten->late = $atten->late +1;
			// 	}else{
			// 		$atten->status = $atten->status."P"; //notlate
			// 		$atten->present = $atten->present+1;
			// 	}

			// 	$holiday = Holiday::where('emp_id',$att->user_id)->first();
			// 	$holi = explode(",",$holiday->date);
				
				
			// 	foreach($holi as $hl){
			// 		if(Carbon::parse($att->date)->equalTo($hl)){
			// 			$atten->status = "H";
			// 		}else{
			// 			//not holiday
			// 		}
			// 	}

			// 	$leave = Leave::where(['emp_db_id' => $att->user_id,'status'=>'Accepted'])->get();
			// 	foreach($leave as $lev){
			// 		$le=explode(",",$lev->leave_dates);
			// 		foreach($le as $l){
			// 			if(Carbon::parse($att->date)->equalTo($l)){
			// 				$atten->status = "Cl";
			// 			}else{
			// 				//not CL
			// 			}
			// 		}
			// 	}
				
				
			// 	$atten->save();
			// }
		
		//}
		

	}else{
				$userList = User::orderBy('created_at', 'desc')->get();

		$attendence_today=AttendanceCalculation::join('users', 'attendance_calculations.user_id', '=', 'users.emp_id')
		->select('attendance_calculations.*','users.name','users.emp_id','users.profile_photo')->orderBy('attendance_calculations.date', 'desc')->get();

		return view('back-end.employee.emp-attendanceShort',[
				'attendence_today'=>$attendence_today, 'userList'=>$userList,
			]);
		// return "no";
		// return redirect()->back()->with('warning','xlxs sheet could not uploaded..please try again');
	}
}
public function export()
{
		return Excel::download(new UsersExport, 'Attendance.xlsx');
}
	public function viewAttendenceDetails($id,$name){
		//holiday
		// $holidays= Holiday::select('*')->where('status','Active')
    //         ->orderBy('date', 'ASC')->get();

		//leave
		// $holidays= Holiday::select('*')->where('status','Active')
		        // ->orderBy('date', 'ASC')->get();
		//database e jabo chek kore anbo ekhane then jabo view korte
		$now = Carbon::now();

			// echo $now->year;
			// echo $now->month;
			// echo $now->weekOfYear;
		$data = DB::table('atts')

		              ->where('month', $now->month)
		       				->where('year', $now->year)
		    					->get();

					if(count($data)>0){
					return view('back-end.employee.emp-search',[
					'data'=>$data,'name'=>$name,'id'=>$id, 'month'=>$now->month,
						]);
						}else{
							return view('back-end.employee.emp-search',[
							'data'=>null,'name'=>$name,'id'=>$id, 'month'=>$now->month,
								]);
						}
}


public function viewAttendenceDetailsSP($id,$name,Request $request){
	//holiday
	// $holidays= Holiday::select('*')->where('status','Active')
	//         ->orderBy('date', 'ASC')->get();

	//leave

	//database e jabo chek kore anbo ekhane then jabo view korte

		// echo $now->year;
		// echo $now->month;
		// echo $now->weekOfYear;


	$data = DB::table('atts')
								->where('month', $request->month)
								->where('year', $request->year)
								->get();

				if(count($data)>0){
				return view('back-end.employee.emp-search',[
				'data'=>$data,'name'=>$name,'id'=>$id, 'month'=>$request->month,
					]);
					}else{
						return view('back-end.employee.emp-search',[
						'data'=>null,'name'=>$name,'id'=>$id,
							]);
					}
	// echo $id;
	// echo $name;
	// echo $request->month;
	// echo $request->year;
}
// 	public function empAttendancesrc(Request $request){
// 		$userList = User::orderBy('created_at', 'desc')->get();
// 		// $data = DB::table('attendences')
//     //               ->where('month', $request->month)
//     //               ->where('year', $request->year)
//     //               ->get();
// 		// if(count($data)>0){
// 		// 	return view('back-end.employee.emp-search',[
//     //     'data'=>$data, 'month'=>$request->month,
//     //   ]);
// 		// }else{
// 		// 	return view('back-end.employee.emp-attendance');
// 		// }
//
// }
  public function empDepartments(){
    $obj_dept=Department::all();

      return view('back-end.employee.emp-departments',[
        'obj_dept'=>$obj_dept,
      ]);
  }



  public function addNewEmp(Request $request){
		// return $request;
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'emp_id' => 'unique:users|required',
            'password' => 'min:5|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:5',
            'gender' => 'required|not_in:Select Gender',
            'role' => 'required',

            'blood_group' => 'required|not_in:Select Blood Group',
            'job_status' => 'required|not_in:Select Job Status',
        ]);

        // return $request;
        $join_date=Carbon::parse($request->join_date);
        $date_of_birth=Carbon::parse($request->date_of_birth);


      $user = new User();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = Hash::make($request->password);
      $user->phone_no = $request->phone_no;
      $user->emp_id = $request->emp_id;
      $user->join_date = $join_date;
      $user->role = $request->role;
      // $user->dept_name = $request->dept_name;
      $user->gender = $request->gender;
      $user->date_of_birth = $date_of_birth;
      $user->blood_group = $request->blood_group;
      $user->job_status = $request->job_status;
      $user->created_by = Auth::user()->name;
      $user->facebook_link = $request->facebook_link;
      $user->twitter_link = $request->twitter_link;
      $user->linkedin_link = $request->linkedin_id;
      $user->git_link = $request->git_link;
      $user->facebook_link = $request->facebook_link;

      if ($request->file('profile_photo')) {
        $this->validate($request, [
            'profile_photo' => 'required|mimes:jpg,JPG,JPEG,jpeg,png|max:2058',
        ]);

        $userImage = $request->file('profile_photo');
        $fileType = $userImage->getClientOriginalExtension();
        $imageName = date('YmdHis') . "ProfilePic" . rand(5, 10) . '.' . $fileType;
        $directory = 'images/';
        $imageUrl = $directory . $imageName;
        Image::make($userImage)->fit(800, 800)->save($imageUrl);

        $user->profile_photo = $imageUrl;
    }

    $users_name = $request->name;
    $users_email = $request->email;

    // Mail::send('back-end.mail.welcomeMsgForNewEmployee', array(
    //     'role' => 'Employee',
    //     'name' => $users_name), function ($message) use ($users_name, $users_email) {
    //     $message->from('ex4useonly@gmail.com', 'BrotherhoodInfotech');
    //     $message->to($users_email, $users_name)->subject('Welcome To Brotherhood Infotech');
    //});

	$user->save();

    $user->attachRole(Role::where('name', 'Employee')->first());

    return redirect()->back()->with('message','New Employee Added Successfully.');
}

public function deleteEmp($id, $name){
	$emp=User::find($id);

    if (File::exists($emp->profile_photo)) {
        unlink($emp->profile_photo);
    }
    $emp->delete();
    return redirect()->back()->with('message', 'Employee Info Successfully Deleted');

}
public function editEmpInfo(Request $request){

    // return $request;

   $this->validate($request, [
    'name' => 'required|max:30|min:2',
        'gender' => 'required|not_in:Select Gender',
        'role' => 'required',
        'job_status' => 'required|not_in:Select Job Status',
]);

$join_date=Carbon::parse($request->join_date);
$date_of_birth=Carbon::parse($request->date_of_birth);

   $user=User::find($request->user_id);
// return $emp;

   $user->name = $request->name;


$user->phone_no = $request->phone_no;
$user->emp_id = $request->emp_id;
$user->join_date = $join_date;
$user->role = $request->role;
// $user->dept_name = $request->dept_name;
$user->gender = $request->gender;
$user->date_of_birth = $date_of_birth;
$user->blood_group = $request->blood_group;
$user->job_status = $request->job_status;
$user->twitter_link = $request->twitter_link;
$user->linkedin_link = $request->linkedin_id;
$user->git_link = $request->git_link;
$user->facebook_link = $request->facebook_link;
$user->updated_by = Auth::user()->name;

if ($request->file('profile_photo')) {
    $this->validate($request, [
        'profile_photo' => 'required|mimes:jpg,JPG,JPEG,jpeg,png|max:2058',
    ]);

    $userImage = $request->file('profile_photo');
    $fileType = $userImage->getClientOriginalExtension();
    $imageName = date('YmdHis') . "ProfilePic" . rand(5, 10) . '.' . $fileType;
    $directory = 'images/';
    $imageUrl = $directory . $imageName;
    Image::make($userImage)->fit(800, 800)->save($imageUrl);


    if (File::exists($user->profile_photo)) {
        unlink($user->profile_photo);
    }


    $user->profile_photo = $imageUrl;
}

            // Mail::send('admin.users.welcomeMsg', array(
            //     'role' => 'Admin',
            //     'name' => $users_name), function ($message) use ($users_name, $users_email) {
            //     $message->from('ex4useonly@gmail.com', 'BrotherhoodInfotech');
            //     $message->to($users_email, $users_name)->subject('Welcome To Brotherhood Infotech');
            // });

$user->save();

activityLog('Edit Employee Info');
if(Auth::user()->hasRole('Super Admin')){
    ActivityLogEmp($user->id,'Super Admin','Update Profile');
    }elseif(Auth::user()->hasRole('Admin')){
        ActivityLogEmp($user->id,'Admin','Update Profile');
    }else{
        ActivityLogEmp($user->id,'Me','Update Profile');
    }

return redirect()->back()->with('message','Successfully Updated This profile.');

}
// public function leaveRequest(Request $request){
//         // return $request;
//     $this->validate($request,[
//         'start_date'=>'required',
//         'start_date'=>'required',
//         'end_date'=>'required',
//         'reason'=>'required',
//     ]);
//
//     $user_id = Auth::User()->id;
//     $day=Carbon::parse($request->start_date)->diffInDays($request->end_date)+1;
//
//     // return $day;
//     $pandingLeaveRequest=LeaveRequest::where('emp_db_id',$user_id)
//     ->where('status','Waiting')->count();
//     // return $pandingLeaveRequest;
//
//     if($pandingLeaveRequest<=0){
//     $leave_req=new LeaveRequest();
//     $leave_req->leave_type=$request->leave_type;
//     $leave_req->emp_db_id=$user_id;
//     $leave_req->start_date=Carbon::parse($request->start_date)->format('Y-m-d');
//     $leave_req->end_date=Carbon::parse($request->end_date)->format('Y-m-d');
//     $leave_req->reason=$request->reason;up
//     $leave_req->status=$request->status;
//     $leave_req->save();
//
//     activityLog('Send leave request info');
// }else{
//     return redirect()->back()->with('warning','Your request is already panding.');
// }
//    if(Auth::user()->hasRole('Admin')){
//             ActivityLogEmp($user_id,'Admin','Send Leave Request.');
//         }else{
//             ActivityLogEmp($user_id,'Me','Send Leave Request.');
//         }1
//
//     return redirect()->back()->with('message','Request Successfully Send.');
//
// }

public function generateLeave(Request $request){
	$this->validate($request,[
		'leave_to'=>'required',
]);
	$emp_id= explode(" ", $request->leave_to);

	$leave=Leave::where('emp_db_id',$emp_id[0])->get();
    $leave_count=0;
    foreach($leave as $lv){
        if($lv->status == "Accepted"){
            $leave_count=$leave_count + $lv->leave_for;
        }
	}
	$ca = EmpLeave::find(1);
	 
	if($leave_count >= $ca->paid_leave_amount){
		return redirect()->back()->with('danger','maximum leave amount reached');
	}else{
		$leave= new Leave();
		$leave->emp_db_id=$emp_id[0];
		$leave->leave_dates = 0;
		$leave->status="Waiting";
		$leave->save();
		return redirect()->back()->with('message','Leave Successfully generated.. **print by Clicking Print icon');
	}
	

}
public function storeleaveRequest(Request $request){
	$this->validate($request,[
			'leave_to'=>'required',
			'start_date'=>'required',
			'start_date'=>'required',
			'end_date'=>'required',
			'reason'=>'required',
	]);

	$emp_id= explode(" ", $request->leave_to);
	$day=Carbon::parse($request->start_date)->diffInDays($request->end_date)+1;
	$leave= new Leave();
	$leave->leave_type=$request->leave_type;
	$leave->emp_db_id=$emp_id[0];
	$leave->start_date=Carbon::parse($request->start_date)->format('m-m-Y');
	$leave->end_date=Carbon::parse($request->end_date)->format('d-m-Y');
	$leave->reason=$request->reason;
	$leave->leave_for=$day;
	$leave->status="Waiting";
	$leave->save();

return redirect()->back()->with('message','Leave Successfully added..');
}
public function updateleaveRequest(Request $request){
	$this->validate($request,[
			'leave_to'=>'required',
			'leave_dates'=>'required',
			'reason'=>'required',
	]);
	$c=0;
	$id= explode(" ", $request->leave_to);
	$have_leave = Leave::where(['emp_db_id'=>$id[1],'status'=>'Accepted'])->get();
	
	// return $have_leave;
	$req_dates = explode(",",$request->leave_dates);

	foreach($have_leave as $lv0){
		foreach($req_dates as $date){
			$l = explode(",",$lv0->leave_dates);
			foreach($l as $ld){
				if((new Carbon($date))->equalTo(new Carbon($ld))){
					return redirect()->back()->with('danger','Leave Date Already Added..');
				}else{
					$c=1;
				}
			}
		}
		 
	}
	

// return "ok";
	$leave = Leave::where('id', $id[0])->first();
	$dc = 0;
	$leave->leave_type=$request->leave_type;
	$leave->leave_dates= $request->leave_dates;
	$day= explode(",", $request->leave_dates);
	foreach($day as $d){
		$dc = $dc+1;
	}
	$leave->reason=$request->reason;
	$leave->leave_for=$dc;
	$leave->status="Accepted";
	$leave->save();

	$leaveCountHave = LeaveCount::where('emp_id',$id[1])->get();
	if(count($leaveCountHave)>0){
			$leaveCountHave[0]->leave_taken = $leaveCountHave[0]->leave_taken + $dc;
			$total_leave = EmpLeave::find(1);
			
			$leaveCountHave[0]->leave_remain = $total_leave->paid_leave_amount - $leaveCountHave[0]->leave_taken;
			$leaveCountHave[0]->last_leave = $request->leave_dates;

			$leaveCountHave[0]->save();
	}else{
			$leave_count = new LeaveCount();
			$leave_count->emp_id = $id[1];

			$leave_count->leave_taken = $leave_count->leave_taken + $dc;
			$total_leave = EmpLeave::find(1);
			
			$leave_count->leave_remain = $total_leave->paid_leave_amount - $leave_count->leave_taken;
			$leave_count->last_leave = $request->leave_dates;

			$leave_count->save();
	}

	foreach($day as $l){
		$atten = new AttendanceCalculation();
		$atten->user_id = $id[1];
		$atten->date = Carbon::parse($l)->format('d-m-Y');
		if($request->leave_type == "Casual Leave"){
			$atten->status = "CL";
		}elseif($request->leave_type == "Medical Leave"){
			$atten->status = "ML";
		}elseif($request->leave_type == "Maternity Leave"){
			$atten->status = "MatL";
		}else{
			$atten->status= "OL";
		}
		$atten->leave_token = $id[0];
		
		$atten->save();
	}
	
return redirect()->back()->with('message','Leave Successfully approved..');
}
public function updateleaveRequestT(Request $request){
	$this->validate($request,[
			'leave_to'=>'required',
			'leave_dates'=>'required',
			'reason'=>'required',
	]);
	
	$id= explode(" ", $request->leave_to);
	$leave = Leave::where('id', $id[0])->first();
	$dc = 0;
	$leave->leave_type=$request->leave_type;
	$leave->leave_dates= $request->leave_dates;
	$day= explode(",", $request->leave_dates);
	foreach($day as $d){
		$dc = $dc+1;
	}
	$leave->reason=$request->reason;
	$leave->leave_for=$dc;
	$leave->status="Accepted";
	$leave->save();

	$leaveCountHave = LeaveCount::where('emp_id',$id[1])->first();
	//return $leaveCountHave->last_leave;

	$last_leave_count = 0;
	$lld = explode(",",$leaveCountHave->last_leave);

	foreach($lld as $ld){
		$last_leave_count = $last_leave_count+1;
	}
			$leaveCountHave->leave_taken = $leaveCountHave->leave_taken + $dc - $last_leave_count;
			$total_leave = EmpLeave::find(1);
			
			$leaveCountHave->leave_remain = $total_leave->paid_leave_amount - $leaveCountHave->leave_taken;
			$leaveCountHave->last_leave = $request->leave_dates;

			$leaveCountHave->save();

	 AttendanceCalculation::where('leave_token',$id[0])->delete();

	 foreach($day as $l){
		$atten = new AttendanceCalculation();
		$atten->user_id = $id[1];
		$atten->date = Carbon::parse($l)->format('d-m-Y');
		if($request->leave_type == "Casual Leave"){
			$atten->status = "CL";
		}elseif($request->leave_type == "Medical Leave"){
			$atten->status = "ML";
		}elseif($request->leave_type == "Maternity Leave"){
			$atten->status = "MatL";
		}else{
			$atten->status= "OL";
		}
		$atten->leave_token = $id[0];
		
		$atten->save();
	}
	
	
return redirect()->back()->with('message','Leave Successfully approved..');

}

public function acceptLeaveRequestWithPaid($id,$name){
        // return $id;
    $leave_request=Leave::find($id);
    $leave_request->status='Accepted(paid)';
    $leave_request->save();

    activityLog('Approved leave request with paid.');

    return redirect()->back()->with('message','approved leave request with paid Successfully');

}

public function acceptLeaveRequestWithUnpaid($id,$name){
        // return $id;
    $leave_request=Leave::find($id);
    $leave_request->status='Accepted(unpaid)';
    $leave_request->save();
    activityLog('Approved leave request with unpaid.');
    return redirect()->back()->with('message','approved leave request with unpaid Successfully');

}

public function rejectLeaveRequest($id,$name){
        // return $id;
    $leave_request=Leave::find($id);
    $leave_request->status='Rejected';
     $leave_request->save();
	$lld = explode(",",$leave_request->leave_dates);
	foreach($lld as $ld){
		AttendanceCalculation::where(['user_id'=>$leave_request->emp_db_id,'date'=>$ld])->delete();
	}

	$lc=LeaveCount::where('emp_id',$leave_request->emp_db_id)->first();

	$leavedate = explode(",",$lc->last_leave);
	$lcc = count($leavedate);
	
	$lc->leave_taken = $lc->leave_taken-$lcc;
	$lc->leave_remain = $lc->leave_remain+$lcc;
	$lc->last_leave = "REJECTED";

	$lc->save();
    activityLog('Reject leave.');
    return redirect()->back()->with('message','Rejected leave Successfully');

}

public function updatePaidLeave(Request $request){
	$this->validate($request, [ 'accHead' => 'paid_leave_amount|max:4|min:1', ]);

	$empLeave=EmpLeave::select('*')->first();
	$empLeave->paid_leave_amount=$request->paid_leave_amount;
	$empLeave->save();

	activityLog('Upadate total paid leave.');
	return redirect()->back()->with('message','Total paid leave amount  is succressfully updated');
}



}
