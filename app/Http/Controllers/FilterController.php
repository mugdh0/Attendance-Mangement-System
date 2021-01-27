<?php

namespace App\Http\Controllers;
use App\AttendanceCalculation;
use Illuminate\Http\Request;
use App\User;
use App\Attendance;
use App\Role;
use App\Leave;
use App\Department;
use DB;
use Carbon\Carbon;
use File;
use Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\EmpLeave;
use App\Payslip;
use App\ActivityLog;


class FilterController extends Controller
{
    public function late(){

        $userList = User::orderBy('created_at', 'desc')->get();
        $a = 1||2;
        $time = Carbon::now()->toDateTimeString();
		$date = explode(" ",$time);
        $dt = Carbon::parse($date[0])->format('d-m-Y');
        
		$attendence_today=AttendanceCalculation::join('users', 'attendance_calculations.user_id', '=', 'users.emp_id')
		->select('attendance_calculations.*','users.name','users.emp_id','users.profile_photo')->where(['attendance_calculations.date'=>$dt,'attendance_calculations.late'=>$a])->orderBy('attendance_calculations.date', 'desc')->get();

		return view('back-end.employee.emp-attendanceShort',[
				'attendence_today'=>$attendence_today, 'userList'=>$userList,
			]);

    }
    public function leave(){
        $time = Carbon::now()->toDateTimeString();
		$date = explode(" ",$time);
        $dt = Carbon::parse($date[0])->format('d-m-Y');

		$userList = User::orderBy('created_at', 'desc')->get();

		$attendence_today=AttendanceCalculation::join('users', 'attendance_calculations.user_id', '=', 'users.emp_id')
        ->select('attendance_calculations.*','users.name','users.emp_id','users.profile_photo')
        ->where('status','H')->orderBy('attendance_calculations.date', 'desc')->get();

        

		return view('back-end.employee.emp-attendanceShort',[
				'attendence_today'=>$attendence_today, 'userList'=>$userList,
			]);

    }
    public function present(){

		$userList = User::orderBy('created_at', 'desc')->get();

		$attendence_today=Attendance::join('users', 'attendances.user_id', '=', 'users.id')
		->select('attendances.*','users.name','users.emp_id','users.profile_photo')->where('attendances.status','present')->orderBy('attendances.date', 'desc')->get();

		return view('back-end.employee.emp-attendanceShort',[
				'attendence_today'=>$attendence_today, 'userList'=>$userList,
			]);

    }
    public function activeEmp(){

		$userList = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Employee')
                ->orwhere('name', '=', 'Admin');
        })->where('active',1)->orderBy('created_at', 'desc')->get();
        // return $userList;
        $obj_dept=Department::all();
        $roles = Role::all();
        $roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();
		return view('back-end.employee.emp-all',[
            'userList'=>$userList,
			'obj_dept'=>$obj_dept,
            'roles'=>$roles,
            'roleList'=>$roleList,
		]);

    }
    public function inactiveEmp(){
        $userList = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Employee')
                ->orwhere('name', '=', 'Admin');
        })->where('active',0)->orderBy('created_at', 'desc')->get();
        // return $userList;
        $obj_dept=Department::all();
        $roles = Role::all();
        $roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();
		return view('back-end.employee.emp-all',[
            'userList'=>$userList,
			'obj_dept'=>$obj_dept,
            'roles'=>$roles,
            'roleList'=>$roleList,
		]);


    }
    public function provisionPeriod(){

		$userList = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Employee')
                ->orwhere('name', '=', 'Admin');
        })->where('job_status','Provision Period')->orderBy('created_at', 'desc')->get();
        // return $userList;
        $obj_dept=Department::all();
        $roles = Role::all();
        $roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();
		return view('back-end.employee.emp-all',[
            'userList'=>$userList,
			'obj_dept'=>$obj_dept,
            'roles'=>$roles,
            'roleList'=>$roleList,
		]);

    }
    public function permanentEmp(){

        $userList = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Employee')
                ->orwhere('name', '=', 'Admin');
        })->where('job_status','Permanent')->orderBy('created_at', 'desc')->get();
        // return $userList;
        $obj_dept=Department::all();
        $roles = Role::all();
        $roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();
		return view('back-end.employee.emp-all',[
            'userList'=>$userList,
			'obj_dept'=>$obj_dept,
            'roles'=>$roles,
            'roleList'=>$roleList,
		]);
    }

    public function filterEmployee(Request $request){
        $obj_dept=Department::all();
        $roles = Role::all();

        $roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();

        $sDate=Carbon::parse($request->Sjoin_date)->format('Y-m-d');
        $eDate=Carbon::parse($request->Ejoin_date)->format('Y-m-d');

        if($request->role==null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role==null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 00001;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role==null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 00010;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })->where('join_date','like', '%'.$sDate.'%')->orderBy('created_at', 'desc')->get();
        }elseif($request->role==null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 00011;

            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })->whereBetween('join_date', [$sDate, $eDate])->orderBy('created_at', 'desc')->get();

        }elseif($request->role==null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            // return 00100;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })->where('dept_name', $request->dept_name)->orderBy('created_at', 'desc')->get();


        }elseif($request->role==null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 00101;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role==null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 00110;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('dept_name', $request->dept_name)
            ->where('join_date','like', '%'.$sDate.'%')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->role==null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 00111;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('dept_name', $request->dept_name)
            ->whereBetween('join_date', [$sDate, $eDate])
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            // return 01000;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 01001;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 01010;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.join_date','like', '%'.$sDate.'%')
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 01011;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->whereBetween('join_date', [$sDate, $eDate])
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            // return 01100;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.dept_name', $request->dept_name)
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 01101;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 01110;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.dept_name', $request->dept_name)
            ->where('users.join_date','like', '%'.$sDate.'%')
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 01111;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.dept_name', $request->dept_name)
            ->whereBetween('join_date', [$sDate, $eDate])
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            // return 10000;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('role', $request->role)
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 10001;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role!=null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 10010;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('role', $request->role)
            ->where('users.join_date','like', '%'.$sDate.'%')
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 10011;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('role', $request->role)
            ->whereBetween('join_date', [$sDate, $eDate])
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            // return 10100;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('role', $request->role)
            ->where('users.dept_name',$request->dept_name)
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->role!=null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 10101;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role!=null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 10110;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('role', $request->role)
            ->where('users.join_date','like', '%'.$sDate.'%')
            ->where('users.dept_name',$request->dept_name)
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 10111;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('role', $request->role)
            ->whereBetween('join_date', [$sDate, $eDate])
            ->where('users.dept_name',$request->dept_name)
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            // return 11000;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.role', $request->role)

            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 11001;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 11010;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.role', $request->role)
            ->where('users.join_date','like', '%'.$sDate.'%')
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 11011;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.role', $request->role)
            ->whereBetween('join_date', [$sDate, $eDate])
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            // return 11100;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.role', $request->role)
            ->where('users.dept_name',$request->dept_name)
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();

        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 11101;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 11110;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.role', $request->role)
            ->where('users.join_date','like', '%'.$sDate.'%')
            ->where('users.dept_name',$request->dept_name)
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 11111;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.role', $request->role)
            ->whereBetween('join_date', [$sDate, $eDate])
            ->where('users.dept_name',$request->dept_name)
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();

        }else{
            return redirect()->back()->with('warning','Please search in right away');
        }


		return view('back-end.employee.emp-all',[
            'userList'=>$userList,
			'obj_dept'=>$obj_dept,
			'roles'=>$roles,
			'roleList'=>$roleList,
		]);


    }












    public function activeUser(){

		$userList = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Employee')
                ->orwhere('name', '=', 'Admin');
        })->where('active',1)->orderBy('created_at', 'desc')->get();
        // return $userList;
        $obj_dept=Department::all();
        $roles = Role::all();
        $roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();

        return view('back-end.user.app-user',[
            'userList'=>$userList,
            'obj_dept'=>$obj_dept,
            'roles'=>$roles,
            'roleList'=>$roleList,

            ]);

    }
    public function inactiveUser(){
        $userList = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Employee')
                ->orwhere('name', '=', 'Admin');
        })->where('active',0)->orderBy('created_at', 'desc')->get();
        // return $userList;
        $obj_dept=Department::all();
        $roles = Role::all();
        $roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();
        return view('back-end.user.app-user',[
            'userList'=>$userList,
			'obj_dept'=>$obj_dept,
            'roles'=>$roles,
            'roleList'=>$roleList,
		]);


    }
    public function userProvisionPeriod(){

		$userList = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Employee')
                ->orwhere('name', '=', 'Admin');
        })->where('job_status','Provision Period')->orderBy('created_at', 'desc')->get();
        // return $userList;
        $obj_dept=Department::all();
        $roles = Role::all();
        $roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();
        return view('back-end.user.app-user',[
            'userList'=>$userList,
			'obj_dept'=>$obj_dept,
            'roles'=>$roles,
            'roleList'=>$roleList,
		]);

    }
    public function permanentUser(){

        $userList = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Employee')
                ->orwhere('name', '=', 'Admin');
        })->where('job_status','Permanent')->orderBy('created_at', 'desc')->get();
        // return $userList;
        $obj_dept=Department::all();
        $roles = Role::all();
        $roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();
        return view('back-end.user.app-user',[
            'userList'=>$userList,
			'obj_dept'=>$obj_dept,
            'roles'=>$roles,
            'roleList'=>$roleList,
		]);
    }
    public function filterUser(Request $request){
        $obj_dept=Department::all();
        $roles = Role::all();

        $roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();

        $sDate=Carbon::parse($request->Sjoin_date)->format('Y-m-d');
        $eDate=Carbon::parse($request->Ejoin_date)->format('Y-m-d');

        if($request->role==null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role==null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 00001;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role==null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 00010;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })->where('join_date','like', '%'.$sDate.'%')->orderBy('created_at', 'desc')->get();
        }elseif($request->role==null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 00011;

            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })->whereBetween('join_date', [$sDate, $eDate])->orderBy('created_at', 'desc')->get();

        }elseif($request->role==null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            // return 00100;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })->where('dept_name', $request->dept_name)->orderBy('created_at', 'desc')->get();


        }elseif($request->role==null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 00101;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role==null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 00110;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('dept_name', $request->dept_name)
            ->where('join_date','like', '%'.$sDate.'%')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->role==null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 00111;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('dept_name', $request->dept_name)
            ->whereBetween('join_date', [$sDate, $eDate])
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            // return 01000;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 01001;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 01010;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.join_date','like', '%'.$sDate.'%')
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 01011;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->whereBetween('join_date', [$sDate, $eDate])
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            // return 01100;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.dept_name', $request->dept_name)
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 01101;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 01110;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.dept_name', $request->dept_name)
            ->where('users.join_date','like', '%'.$sDate.'%')
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role==null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 01111;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.dept_name', $request->dept_name)
            ->whereBetween('join_date', [$sDate, $eDate])
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            // return 10000;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('role', $request->role)
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 10001;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role!=null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 10010;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('role', $request->role)
            ->where('users.join_date','like', '%'.$sDate.'%')
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type==null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 10011;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('role', $request->role)
            ->whereBetween('join_date', [$sDate, $eDate])
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            // return 10100;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('role', $request->role)
            ->where('users.dept_name',$request->dept_name)
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->role!=null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 10101;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role!=null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 10110;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('role', $request->role)
            ->where('users.join_date','like', '%'.$sDate.'%')
            ->where('users.dept_name',$request->dept_name)
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type==null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 10111;
            $userList = User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Employee')
                    ->orwhere('name', '=', 'Admin');
            })
            ->where('role', $request->role)
            ->whereBetween('join_date', [$sDate, $eDate])
            ->where('users.dept_name',$request->dept_name)
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            // return 11000;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.role', $request->role)

            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 11001;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 11010;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.role', $request->role)
            ->where('users.join_date','like', '%'.$sDate.'%')
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name==null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 11011;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.role', $request->role)
            ->whereBetween('join_date', [$sDate, $eDate])
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date==null){
            // return 11100;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.role', $request->role)
            ->where('users.dept_name',$request->dept_name)
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();

        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date==null && $request->Ejoin_date!=null){
            // return 11101;
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date==null){
            // return 11110;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.role', $request->role)
            ->where('users.join_date','like', '%'.$sDate.'%')
            ->where('users.dept_name',$request->dept_name)
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();
        }elseif($request->role!=null && $request->user_type!=null && $request->dept_name!=null && $request->Sjoin_date!=null && $request->Ejoin_date!=null){
            // return 11111;
            $userList = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name',$request->user_type)
            ->where('users.role', $request->role)
            ->whereBetween('join_date', [$sDate, $eDate])
            ->where('users.dept_name',$request->dept_name)
            ->select('users.*')
            ->orderBy('users.created_at', 'desc')->get();

        }else{
            return redirect()->back()->with('warning','Please search in right away');
        }


		return view('back-end.user.app-user',[
            'userList'=>$userList,
			'obj_dept'=>$obj_dept,
			'roles'=>$roles,
			'roleList'=>$roleList,
		]);


    }












    public function filterLeaveRequest(Request $request){
        // return $request;

        $sDate=Carbon::parse($request->start_date)->format('Y-m-d');
        $eDate=Carbon::parse($request->end_date)->format('Y-m-d');

        $allPaidLeave=Leave::where('status','Accepted(paid)')
        ->where('emp_db_id',Auth::user()->id)
        ->get();
        $leavdays=0;

        foreach($allPaidLeave as $paidLeave){
            $d1=Carbon::parse($paidLeave->start_date)->diffInDays($paidLeave->end_date);

        $leavdays=$leavdays+ $d1+1;
        }

        $totalPaidLeave=EmpLeave::select('*')->first();
        $leaveUser=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
        ->select('users.name')->where('users.name','!=',null)->distinct('users.name')->get();

        if($request->leave_type==null && $request->emp_name==null && $request->status==null && $request->start_date==null && $request->end_date==null){
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->leave_type==null && $request->emp_name==null && $request->status==null && $request->start_date==null && $request->end_date!=null){
            // return 00001;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('end_date','<=', $eDate)

            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();
            // return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->leave_type==null && $request->emp_name==null && $request->status==null && $request->start_date!=null && $request->end_date==null){
            // return 00010;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('start_date','>=', $sDate)
            // ->where([['start_date','<=',$sDate],['end_date','>=', $sDate]])
            // ->where(function ($query) use ($sDate) {
            //     $query ->where('start_date','>=', $sDate);
            //     $query ->andwhere('end_date','<=', $sDate);
            // })

            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type==null && $request->emp_name==null && $request->status==null && $request->start_date!=null && $request->end_date!=null){
            // return 00011;

            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where(function ($query) use ($sDate,$eDate) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('end_date', '<=', $eDate);
            })
            ->orwhere(function ($query) use ($sDate,$eDate) {
                $query ->where('start_date','<=', $sDate);
                $query ->where('end_date', '>=', $sDate);
            })
            ->orwhere(function ($query) use ($sDate,$eDate) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('start_date', '<=', $eDate);
            })

            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();



            // $allLeaveRequest=DB::Select("SELECT leaves.* ,users.name,users.emp_id,users.profile_photo FROM `leaves`
            // INNER JOIN users ON leaves.emp_db_id = users.id
            // WHERE (`start_date`>=$sDate &&`end_date`<=$eDate)||(`start_date`<=$sDate &&`end_date`>=$sDate) || (`start_date`>=$sDate &&`start_date`<=$eDate)
            // ORDER BY leaves.created_at DESC");

        }elseif($request->leave_type==null && $request->emp_name==null && $request->status!=null && $request->start_date==null && $request->end_date==null){
            // return 00100;

            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('status', $request->status)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type==null && $request->emp_name==null && $request->status!=null && $request->start_date==null && $request->end_date!=null){
            // return 00101;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('end_date','<=', $eDate)
            ->where('status', $request->status)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();
            // return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->leave_type==null && $request->emp_name==null && $request->status!=null && $request->start_date!=null && $request->end_date==null){
            // return 00110;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('status', $request->status)
            ->where('start_date','>=', $sDate)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type==null && $request->emp_name==null && $request->status!=null && $request->start_date!=null && $request->end_date!=null){
            // return 00111;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('end_date', '<=', $eDate);
                $query ->where('status', $request->status);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','<=', $sDate);
                $query ->where('end_date', '>=', $sDate);
                $query ->where('status', $request->status);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('start_date', '<=', $eDate);
                $query ->where('status', $request->status);
            })

            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type==null && $request->emp_name!=null && $request->status==null && $request->start_date==null && $request->end_date==null){
            // return 01000;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('users.name',$request->emp_name)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type==null && $request->emp_name!=null && $request->status==null && $request->start_date==null && $request->end_date!=null){
            // return 01001;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('end_date','<=', $eDate)
            ->where('users.name',$request->emp_name)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

            // return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->leave_type==null && $request->emp_name!=null && $request->status==null && $request->start_date!=null && $request->end_date==null){
            // return 01010;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('users.name',$request->emp_name)
            ->where('start_date','>=', $sDate)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type==null && $request->emp_name!=null && $request->status==null && $request->start_date!=null && $request->end_date!=null){
            // return 01011;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('end_date', '<=', $eDate);
                $query ->where('users.name',$request->emp_name);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','<=', $sDate);
                $query ->where('end_date', '>=', $sDate);
                $query ->where('users.name',$request->emp_name);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('start_date', '<=', $eDate);
                $query ->where('users.name',$request->emp_name);
            })

            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type==null && $request->emp_name!=null && $request->status!=null && $request->start_date==null && $request->end_date==null){
            // return 01100;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('users.name',$request->emp_name)
            ->where('status', $request->status)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type==null && $request->emp_name!=null && $request->status!=null && $request->start_date==null && $request->end_date!=null){
            // return 01101;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('end_date','<=', $eDate)
            ->where('users.name',$request->emp_name)
            ->where('status', $request->status)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();
            // return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->leave_type==null && $request->emp_name!=null && $request->status!=null && $request->start_date!=null && $request->end_date==null){
            // return 01110;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('users.name',$request->emp_name)
            ->where('status', $request->status)
            ->where('start_date','>=', $sDate)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->leave_type==null && $request->emp_name!=null && $request->status!=null && $request->start_date!=null && $request->end_date!=null){
            // return 01111;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('end_date', '<=', $eDate);
                $query ->where('users.name',$request->emp_name);
                $query ->where('status', $request->status);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','<=', $sDate);
                $query ->where('end_date', '>=', $sDate);
                $query ->where('users.name',$request->emp_name);
                $query ->where('status', $request->status);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('start_date', '<=', $eDate);
                $query ->where('users.name',$request->emp_name);
                $query ->where('status', $request->status);
            })

            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type!=null && $request->emp_name==null && $request->status==null && $request->start_date==null && $request->end_date==null){
            // return 10000;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('leave_type',$request->leave_type)

            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type!=null && $request->emp_name==null && $request->status==null && $request->start_date==null && $request->end_date!=null){
            // return 10001;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('end_date','<=', $eDate)
            ->where('leave_type',$request->leave_type)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

            // return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->leave_type!=null && $request->emp_name==null && $request->status==null && $request->start_date!=null && $request->end_date==null){
            // return 10010;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('leave_type',$request->leave_type)
            ->where('start_date','>=', $sDate)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type!=null && $request->emp_name==null && $request->status==null && $request->start_date!=null && $request->end_date!=null){
            // return 10011;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('end_date', '<=', $eDate);
                $query ->where('leave_type',$request->leave_type);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','<=', $sDate);
                $query ->where('end_date', '>=', $sDate);
                $query ->where('leave_type',$request->leave_type);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('start_date', '<=', $eDate);
                $query ->where('leave_type',$request->leave_type);
            })
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type!=null && $request->emp_name==null && $request->status!=null && $request->start_date==null && $request->end_date==null){
            // return 10100;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('leave_type',$request->leave_type)
            ->where('status', $request->status)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type!=null && $request->emp_name==null && $request->status!=null && $request->start_date==null && $request->end_date!=null){
            // return 10101;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('end_date','<=', $eDate)
            ->where('leave_type',$request->leave_type)
            ->where('status', $request->status)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

            // return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->leave_type!=null && $request->emp_name==null && $request->status!=null && $request->start_date!=null && $request->end_date==null){
            // return 10110;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('leave_type',$request->leave_type)
            ->where('status', $request->status)
            ->where('start_date','>=', $sDate)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->leave_type!=null && $request->emp_name==null && $request->status!=null && $request->start_date!=null && $request->end_date!=null){
            // return 10111;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('end_date', '<=', $eDate);
                $query ->where('leave_type',$request->leave_type);
                $query ->where('status', $request->status);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','<=', $sDate);
                $query ->where('end_date', '>=', $sDate);
                $query ->where('leave_type',$request->leave_type);
                $query ->where('status', $request->status);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('start_date', '<=', $eDate);
                $query ->where('leave_type',$request->leave_type);
                $query ->where('status', $request->status);
            })
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type!=null && $request->emp_name!=null && $request->status==null && $request->start_date==null && $request->end_date==null){
            // return 11000;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('leave_type',$request->leave_type)
            ->where('users.name', $request->emp_name)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type!=null && $request->emp_name!=null && $request->status==null && $request->start_date==null && $request->end_date!=null){
            // return 11001;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('end_date','<=', $eDate)
            ->where('leave_type',$request->leave_type)
            ->where('users.name', $request->emp_name)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();
            // return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->leave_type!=null && $request->emp_name!=null && $request->status==null && $request->start_date!=null && $request->end_date==null){
            // return 11010;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('leave_type',$request->leave_type)
            ->where('users.name', $request->emp_name)
            ->where('start_date','>=', $sDate)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type!=null && $request->emp_name!=null && $request->status==null && $request->start_date!=null && $request->end_date!=null){
            // return 11011;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('end_date', '<=', $eDate);
                $query ->where('leave_type',$request->leave_type);
                $query ->where('users.name', $request->emp_name);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','<=', $sDate);
                $query ->where('end_date', '>=', $sDate);
                $query ->where('leave_type',$request->leave_type);
                $query ->where('users.name', $request->emp_name);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('start_date', '<=', $eDate);
                $query ->where('leave_type',$request->leave_type);
                $query ->where('users.name', $request->emp_name);
            })
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type!=null && $request->emp_name!=null && $request->status!=null && $request->start_date==null && $request->end_date==null){
            // return 11100;

            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('leave_type',$request->leave_type)
            ->where('users.name', $request->emp_name)
            ->where('status', $request->status)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type!=null && $request->emp_name!=null && $request->status!=null && $request->start_date==null && $request->end_date!=null){
            // return 11101;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('end_date','<=', $eDate)
            ->where('leave_type',$request->leave_type)
            ->where('users.name', $request->emp_name)
            ->where('status', $request->status)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();
            // return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->leave_type!=null && $request->emp_name!=null && $request->status!=null && $request->start_date!=null && $request->end_date==null){
            // return 11110;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('leave_type',$request->leave_type)
            ->where('users.name', $request->emp_name)
            ->where('status', $request->status)
            ->where('start_date','>=', $sDate)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type!=null && $request->emp_name!=null && $request->status!=null && $request->start_date!=null && $request->end_date!=null){
            // return 11111;
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('end_date', '<=', $eDate);
                $query ->where('leave_type',$request->leave_type);
                $query ->where('users.name', $request->emp_name);
                $query ->where('status', $request->status);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','<=', $sDate);
                $query ->where('end_date', '>=', $sDate);
                $query ->where('leave_type',$request->leave_type);
                $query ->where('users.name', $request->emp_name);
                $query ->where('status', $request->status);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('start_date', '<=', $eDate);
                $query ->where('leave_type',$request->leave_type);
                $query ->where('users.name', $request->emp_name);
                $query ->where('status', $request->status);
            })
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }else{
            return redirect()->back()->with('warning','Please search in right away');
        }

        return view('back-end.employee.emp-leave',[
            'allLeaveRequest'=>$allLeaveRequest,
            'totalPaidLeave'=>$totalPaidLeave,
            'allPaidLeave'=>$leavdays,
            'leaveUser'=>$leaveUser,
        ]);
    }





    public function filterLeaveRequestEMP(Request $request){

        $user_id=Auth::user()->id;
        //  return $request;

        $sDate=Carbon::parse($request->start_date)->format('Y-m-d');
        $eDate=Carbon::parse($request->end_date)->format('Y-m-d');

        $allPaidLeave=Leave::where('status','Accepted(paid)')
        ->where('emp_db_id',Auth::user()->id)
        ->get();
        $leavdays=0;

        foreach($allPaidLeave as $paidLeave){
            $d1=Carbon::parse($paidLeave->start_date)->diffInDays($paidLeave->end_date);

        $leavdays=$leavdays+ $d1+1;
        }

        $totalPaidLeave=EmpLeave::select('*')->first();
        $leaveUser=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
        ->select('users.name')->where('users.name','!=',null)->distinct('users.name')->get();

        if($request->leave_type==null && $request->status==null && $request->start_date==null && $request->end_date==null){
            return redirect()->back()->with('warning','Please search in right away');
        }elseif($request->leave_type==null && $request->status==null && $request->start_date==null && $request->end_date!=null){
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('end_date','<=', $eDate)
         ->where('users.id',$user_id)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->leave_type==null && $request->status==null && $request->start_date!=null && $request->end_date==null){
            $allLeaveRequest=Leave::join('users', 'leave.emp_db_id', '=', 'users.id')
            ->where('start_date','>=', $sDate)
            ->where('users.id',$user_id)

            ->select('leave.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type==null && $request->status==null && $request->start_date!=null && $request->end_date!=null){

            $allLeaveRequest=Leave::join('users', 'leave.emp_db_id', '=', 'users.id')
            ->where(function ($query) use ($sDate,$eDate,$request,$user_id) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('end_date', '<=', $eDate);
                $query ->where('users.id',$user_id);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request,$user_id) {
                $query ->where('start_date','<=', $sDate);
                $query ->where('end_date', '>=', $sDate);
                $query ->where('users.id',$user_id);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request,$user_id) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('start_date', '<=', $eDate);
                $query ->where('users.id',$user_id);
            })

            ->select('leave.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type==null && $request->status!=null && $request->start_date==null && $request->end_date==null){

            $allLeaveRequest=Leave::join('users', 'leave.emp_db_id', '=', 'users.id')
            ->where('status', $request->status)
            ->where('users.id',$user_id)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type==null && $request->status!=null && $request->start_date==null && $request->end_date!=null){
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('status', $request->status)
            ->where('end_date','<=', $eDate)
            ->where('users.id',$user_id)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type==null && $request->status!=null && $request->start_date!=null && $request->end_date==null){
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('status', $request->status)
            ->where('start_date','>=', $sDate)
            ->where('users.id',$user_id)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->leave_type==null && $request->status!=null && $request->start_date!=null && $request->end_date!=null){
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where(function ($query) use ($sDate,$eDate,$request,$user_id) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('end_date', '<=', $eDate);
                $query ->where('users.id',$user_id);
                $query ->where('status', $request->status);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request,$user_id) {
                $query ->where('start_date','<=', $sDate);
                $query ->where('end_date', '>=', $sDate);
                $query ->where('users.id',$user_id);
                $query ->where('status', $request->status);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request,$user_id) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('start_date', '<=', $eDate);
                $query ->where('users.id',$user_id);
                $query ->where('status', $request->status);
            })


            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->leave_type!=null && $request->status==null && $request->start_date==null && $request->end_date==null){
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('leave_type',$request->leave_type)
            ->where('users.id',$user_id)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->leave_type!=null && $request->status==null && $request->start_date==null && $request->end_date!=null){
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('leave_type',$request->leave_type)
            ->where('users.id',$user_id)
            ->where('end_date','<=', $eDate)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->leave_type!=null && $request->status==null && $request->start_date!=null && $request->end_date==null){
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('leave_type',$request->leave_type)
            ->where('users.id',$user_id)
            ->where('start_date','>=', $sDate)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->leave_type!=null && $request->status==null && $request->start_date!=null && $request->end_date!=null){
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where(function ($query) use ($sDate,$eDate,$request,$user_id) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('end_date', '<=', $eDate);
                $query ->where('users.id',$user_id);
                $query ->where('leave_type',$request->leave_type);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request,$user_id) {
                $query ->where('start_date','<=', $sDate);
                $query ->where('end_date', '>=', $sDate);
                $query ->where('users.id',$user_id);
                $query ->where('leave_type',$request->leave_type);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request,$user_id) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('start_date', '<=', $eDate);
                $query ->where('users.id',$user_id);
                $query ->where('leave_type',$request->leave_type);
            })


            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();
        }elseif($request->leave_type!=null && $request->status!=null && $request->start_date==null && $request->end_date==null){

            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('leave_type',$request->leave_type)
            ->where('users.id',$user_id)
            ->where('status', $request->status)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type!=null && $request->status!=null && $request->start_date==null && $request->end_date!=null){

            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('leave_type',$request->leave_type)
            ->where('users.id',$user_id)
            ->where('end_date','<=', $eDate)
            ->where('status', $request->status)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type!=null && $request->status!=null && $request->start_date!=null && $request->end_date==null){
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where('leave_type',$request->leave_type)
            ->where('users.id',$user_id)
            ->where('start_date','>=', $sDate)
            ->where('status', $request->status)
            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }elseif($request->leave_type!=null && $request->status!=null && $request->start_date!=null && $request->end_date!=null){
            $allLeaveRequest=Leave::join('users', 'leaves.emp_db_id', '=', 'users.id')
            ->where(function ($query) use ($sDate,$eDate,$request,$user_id) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('end_date', '<=', $eDate);
                $query ->where('users.id',$user_id);
                $query ->where('leave_type',$request->leave_type);
                $query ->where('status', $request->status);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request,$user_id) {
                $query ->where('start_date','<=', $sDate);
                $query ->where('end_date', '>=', $sDate);
                $query ->where('users.id',$user_id);
                $query ->where('leave_type',$request->leave_type);
                $query ->where('status', $request->status);
            })
            ->orwhere(function ($query) use ($sDate,$eDate,$request,$user_id) {
                $query ->where('start_date','>=', $sDate);
                $query ->where('start_date', '<=', $eDate);
                $query ->where('users.id',$user_id);
                $query ->where('leave_type',$request->leave_type);
                $query ->where('status', $request->status);
            })
            ->where('users.id',$user_id)
            ->where('leave_type',$request->leave_type)

            ->select('leaves.*','users.name','users.emp_id','users.profile_photo')
            ->orderBy('created_at', 'desc')->get();

        }else{
            return redirect()->back()->with('warning','Please search in right away');
        }
        
        return view('back-end.employee.emp-leave',[
            'allLeaveRequest'=>$allLeaveRequest,
            'totalPaidLeave'=>$totalPaidLeave,
            'allPaidLeave'=>$leavdays,
            'leaveUser'=>$leaveUser,
        ]);
    }













public function filterPayslipPayment(Request $request){

    $user_id=Auth::user()->id;
    $emp=User::find($user_id);
    $payDate=Carbon::parse($request->pay_for)->format('Y-m');
    // return $payDate;
    // $obj_payslip=Payslip::select('*')->orderBy('pay_date', 'ASC')->get();
    $obj_empName=Payslip::select('employee_name')->distinct('employee_name')->get();

if($request->employee_name==null && $request->pay_for==null && $request->payment_status==null){
   return redirect()->back()->with('warning','please search in right away');
}elseif($request->employee_name==null && $request->pay_for==null && $request->payment_status!=null){
    $obj_payslip=Payslip::select('*')->where('payment_status',$request->payment_status)
    ->orderBy('pay_date', 'ASC')->get();

}elseif($request->employee_name==null && $request->pay_for!=null && $request->payment_status==null){
    $obj_payslip=Payslip::select('*')
    ->where('created_at','like', '%'.$payDate.'%')
    ->orderBy('pay_date', 'ASC')->get();

}elseif($request->employee_name==null && $request->pay_for!=null && $request->payment_status!=null){
    $obj_payslip=Payslip::select('*')
    ->where('created_at','like', '%'.$payDate.'%')
    ->where('payment_status',$request->payment_status)
    ->orderBy('pay_date', 'ASC')->get();

}elseif($request->employee_name!=null && $request->pay_for==null && $request->payment_status==null){
    $obj_payslip=Payslip::select('*')
    ->where('employee_name',$request->employee_name)
    ->orderBy('pay_date', 'ASC')->get();

}elseif($request->employee_name!=null && $request->pay_for==null && $request->payment_status!=null){
    $obj_payslip=Payslip::select('*')
    ->where('employee_name',$request->employee_name)
    ->where('payment_status',$request->payment_status)
    ->orderBy('pay_date', 'ASC')->get();

}elseif($request->employee_name!=null && $request->pay_for!=null && $request->payment_status==null){
    $obj_payslip=Payslip::select('*')
    ->where('employee_name',$request->employee_name)
    ->where('created_at','like', '%'.$payDate.'%')
    ->orderBy('pay_date', 'ASC')->get();

}elseif($request->employee_name!=null && $request->pay_for!=null && $request->payment_status!=null){
    $obj_payslip=Payslip::select('*')
    ->where('employee_name',$request->employee_name)
    ->where('created_at','like', '%'.$payDate.'%')
    ->where('payment_status',$request->payment_status)
    ->orderBy('pay_date', 'ASC')->get();

}else{
    return redirect()->back()->with('warning','Please search in right away');
}

    return view('back-end.payroll.payroll-payment',[
        'obj_payslip'=>$obj_payslip,
        'obj_empName'=>$obj_empName,

    ]);
}










public function filterActivityLogS(Request $request){

    $sDate=Carbon::parse($request->start_date)->format('Y-m-d');
    $eDate=Carbon::parse($request->end_date)->format('Y-m-d');
    // return $sDate;
    if($request->start_date !=null && $request->end_date != null){
        $logs=ActivityLog::select('*')
        ->whereBetween('created_at', [$sDate, $eDate])->orderBy('created_at', 'desc')->get();
    }elseif($request->start_date !=null && $request->end_date == null){
        $logs=ActivityLog::select('*')
        ->where('created_at','like', '%'.$sDate.'%')->orderBy('created_at', 'desc')->get();
    }else{
        return redirect()->back()->with('warning','Please search in right away');
    }

return view('back-end.report.activitylog',[
    'logs'=>$logs,
]);
}



}
