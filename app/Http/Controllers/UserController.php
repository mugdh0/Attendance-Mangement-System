<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Holiday;
use App\InOutSetting;
use App\AttendanceCalculation;
use App\Department;
use DB;
use Carbon\Carbon;
use File;
use Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Salary;
use App\SalaryHistory;

use Carbon\CarbonPeriod;

class UserController extends Controller
{
    public function appUser(){

        //$obj_dept=Department::all();
        $roles = Role::all();
        $roleList = User::select('role')->where('role','!=',null)->distinct('role')->get();
        $userList = User::select('*')->where('role','!=',null)->orderBy('created_at', 'desc')->get();
        $userLists = User::select('*')->where('role','=',null)->orderBy('created_at', 'desc')->get();
        return view('back-end.user.app-user',[
        'userList'=>$userList,
        //'obj_dept'=>$obj_dept,
        'roles'=>$roles,
        'roleList'=>$roleList,
        'userLists'=>$userLists,
        ]);
    
    }
    public function appUserAddP(Request $request){

        $this->validate($request, [
           
            
            // 'password' => 'required|string|min:5|confirmed',
            // 'emp_id' => 'unique:users|required',
            'password' => 'min:5|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:5',
            'role' => 'required',
        ]);
        $user = explode(" ",$request->attendence_of);
        // return $user[0];
         $u = User::where('emp_id',$user[0])->first();
        
         $u->password = Hash::make($request->password);
         
          $u->role = $request->role;
          $u->active = 1;
          $u->save();
      return redirect()->back()->with('message','New User Added Successfully.');
        // return $request;
    }
    public function appUserAdd(Request $request){

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'fathers_name' => 'required|string|max:255',
            'mothers_name' => 'required|string|max:255',
            'present_add' => 'required|string|max:255',
            'parmanent_add' => 'required|string|max:255',
            'phone_no' => 'required|string|max:255',
            'emergency_phone_no' => 'required|string|max:255',
            
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:5|confirmed',
            'emp_id' => 'unique:users|required',
            //'password' => 'min:5|required_with:confirm_password|same:confirm_password',
            //'confirm_password' => 'min:5',

            'gender' => 'required|not_in:Select Gender',
            // 'role' => 'required',
            //'user_type' => 'required|not_in:null',
            //'job_status' => 'required|not_in:Select Job Status',
            
				'in_time' => 'required',
                'out_time' => 'required',
        'dateH' => 'required',
        ]);


        $join_date=Carbon::parse($request->join_date);
        $date_of_birth=Carbon::parse($request->date_of_birth);

        // return $date_of_birth;

        $user = new User();
        $user->name = $request->name;
        $user->fathers_name = $request->fathers_name;
        $user->mothers_name = $request->mothers_name;
        $user->present_add = $request->present_add;
        $user->parmanent_add = $request->parmanent_add;
        $user->email = $request->email;
        $user->date_of_birth = $date_of_birth;
        $user->religion = $request->religion;
        $user->phone_no = $request->phone_no;
        $user->emergency_phone_no = $request->emergency_phone_no;
        //$user->password = Hash::make($request->password);
        
        $user->emp_id = $request->emp_id;
        $user->join_date = $join_date;

        $user->bank_name = $request->bank_name;
        $user->branch = $request->branch;
        $user->bank_ac = $request->bank_ac;


        $user->gender = $request->gender;
        $user->blood_group = $request->blood_group;
        // $user->job_status = $request->job_status;
        $user->created_by = Auth::user()->name;

        // $user->twitter_link = $request->twitter_link;
        // $user->linkedin_link = $request->linkedin_id;
        // $user->git_link = $request->git_link;
        // $user->facebook_link = $request->facebook_link;

        $user->referance_name = $request->referance_name;
        $user->referance_phn = $request->referance_phn;
        $user->referance_rel = $request->referance_rel;
        $user->designation = $request->designation;
        $user->department = $request->department;

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
      //     'role' => $request->user_type,
      //     'name' => $users_name), function ($message) use ($users_name, $users_email) {
      //     $message->from('ex4useonly@gmail.com', 'BrotherhoodInfotech');
      //     $message->to($users_email, $users_name)->subject('Welcome To Brotherhood Infotech');
      //});

      $user->save();

      $inoutset = new InOutSetting();
      $inoutset->user_id = $request->emp_id;
      $inoutset->in_time = $request->in_time;
      $inoutset->out_time = $request->out_time;

      $inoutset->save();

      $holi = new Holiday();
      $holi->emp_id = $request->emp_id;
      $holi->date = $request->dateH;
    
        $holi->save();

      $holis = Holiday::where(['emp_id'=>$request->emp_id,'date'=>$request->dateH])->first();
        
      $datef = explode(",",$request->dateH);

				foreach($datef as $dt){
					$atten = new AttendanceCalculation();
					$atten->user_id = $request->emp_id;
					$atten->date = Carbon::parse($dt)->format('d-m-Y');
                    $atten->status= "H";
                    $atten->holiday_token= $holis->id;
                    $atten->save();
                }

    //   if ($request->user_type == 'Super Admin') {
    //   $user->attachRole(Role::where('name', 'Super Admin')->first());
    // } elseif ($request->user_type == 'Admin') {
    //     $user->attachRole(Role::where('name', 'Admin')->first());
    // } elseif ($request->user_type == 'Employee') {
    //     $user->attachRole(Role::where('name', 'Employee')->first());
    // }
    
    activityLog('Add new user.');

    
	// $now = Carbon::now()->toDateTimeString();

    // $date = explode(" ",$now);
    
	// $period = CarbonPeriod::create($date[0], '2021-12-31');

	// foreach ($period as $date) {
    //     echo $date->format('d-m-Y');
    //     $att = new AttendanceCalculation();
    //     $att->user_id = $request->emp_id;
    //     $att->date = $date->format('d-m-Y');
    //     $att->save();
	// }
    $user->attachRole(Role::where('name', 'Employee')->first());
      return redirect()->back()->with('message','New User Added Successfully.');
        // return $request;
    }

    public function viewUserDetails($id,$name){
        $user=User::find($id);
        $salary_info=Salary::where('employee_id',$user->emp_id)->first();

        // return $salary_info;
        $holiday=Holiday::where('emp_id',$user->emp_id)->first();

        $iotime= InOutSetting::where('user_id',$user->emp_id)->first();
        
    return view('back-end.user.app-user-details',[
        'user'=>$user,
        'holiday'=>$holiday,
        'iotime'=>$iotime,
        'salary_info'=>$salary_info,
    ]);
    }

    public function appUserDelete($id,$name){

        $user = User::find($id);
        $user->role = null;
        $user->active = 0;
        $user->password = null;
        $user->save();

     return redirect()->back()->with('message','User Delete Successfully');
    
}
    public function appUserUpdate(Request $request){
        if(Auth::user()->hasRole(['Super Admin','Admin'])){  
            $this->validate($request, [
                'name' => 'required|string|max:255',
                // 'gender' => 'required|not_in:Select Gender',
                // 'role' => 'required',
                // 'user_type' => 'required|not_in:Select User Type',
                // 'job_status' => 'required|not_in:Select Job Status',
                'in_time' => 'required',
                    'out_time' => 'required',
            'dateH' => 'required',
            ]);
        }else{
            $this->validate($request, [
                'name' => 'required|string|max:255',
                // 'gender' => 'required|not_in:Select Gender',
                // 'role' => 'required',
                // 'user_type' => 'required|not_in:Select User Type',
                // 'job_status' => 'required|not_in:Select Job Status',
            //     'in_time' => 'required',
            //         'out_time' => 'required',
            // 'dateH' => 'required',
            ]);
        }
       

        
        $join_date=Carbon::parse($request->join_date);
        $date_of_birth=Carbon::parse($request->date_of_birth);

        $user =User::find($request->user_id);
        
        $user->name = $request->name;
        $user->fathers_name = $request->fathers_name;
        $user->mothers_name = $request->mothers_name;
        $user->present_add = $request->present_add;
        $user->parmanent_add = $request->parmanent_add;
        $user->email = $request->email;
        $user->date_of_birth = $date_of_birth;
        $user->religion = $request->religion;
        $user->phone_no = $request->phone_no;
        $user->emergency_phone_no = $request->emergency_phone_no;
        //$user->password = Hash::make($request->password);
        
       
        $user->join_date = $join_date;

        $user->bank_name = $request->bank_name;
        $user->branch = $request->branch;
        $user->bank_ac = $request->bank_ac;


        $user->gender = $request->gender;
        $user->blood_group = $request->blood_group;
        // $user->job_status = $request->job_status;
        $user->created_by = Auth::user()->name;

        // $user->twitter_link = $request->twitter_link;
        // $user->linkedin_link = $request->linkedin_id;
        // $user->git_link = $request->git_link;
        // $user->facebook_link = $request->facebook_link;

        $user->referance_name = $request->referance_name;
        $user->referance_phn = $request->referance_phn;
        $user->referance_rel = $request->referance_rel;
        $user->designation = $request->designation;
        $user->department = $request->department;
        $user->updated_by = Auth::user()->name;

        // $user->bank_name = $request->bank_name;
        // $user->branch = $request->branch;
        // $user->bank_ac = $request->bank_ac;

        // $user->twitter_link = $request->twitter_link;
        // $user->linkedin_link = $request->linkedin_id;
        // $user->git_link = $request->git_link;
        // $user->facebook_link = $request->facebook_link;


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

      $users_name = $request->name;
      $users_email = $user->email;

      // Mail::send('back-end.mail.welcomeMsgForNewEmployee', array(
      //     'role' => $request->user_type,
      //     'name' => $users_name), function ($message) use ($users_name, $users_email) {
      //     $message->from('ex4useonly@gmail.com', 'BrotherhoodInfotech');
      //     $message->to($users_email, $users_name)->subject('Update Info');
      //});

    $user->save();
    if(Auth::user()->hasRole(['Super Admin','Admin'])){    
      $inoutset = InOutSetting::find($request->iotime);
      $inoutset->user_id = $request->iotimeui;
      $inoutset->in_time = $request->in_time;
      $inoutset->out_time = $request->out_time;
        $inoutset->save();
    
    if($request->hid == null){
        $holi = new Holiday();
        $holi->emp_id = $request->hidui;
        $holi->date = $request->dateH;
        $holi->save();

        $holis = Holiday::where(['emp_id'=>$request->hidui,'date'=>$request->dateH])->first();
        
        // return $holis;
        $datef = explode(",",$request->dateH);
  
                  foreach($datef as $dt){
                      $atten = new AttendanceCalculation();
                      $atten->user_id = $request->hidui;
                      $atten->date = Carbon::parse($dt)->format('d-m-Y');
                      $atten->status= "H";
                      $atten->holiday_token= $holis->id;
                      $atten->save();
                  }
    }else{
        AttendanceCalculation::where('holiday_token',$request->hid)->delete();
        $holi = Holiday::find($request->hid);
        $holi->emp_id = $request->hidui;
        $holi->date = $request->dateH;
        $holi->save();

        $datef = explode(",",$request->dateH);
      
				foreach($datef as $dt){
                    $atten = new AttendanceCalculation();
                    $atten->user_id = $request->hidui;
                    $atten->date = Carbon::parse($dt)->format('d-m-Y');
                    $atten->status = "H";
                    $atten->holiday_token = $request->hid;
                    $atten->save();
                }
    }
    }
//       if(Auth::user()->hasRole('Super Admin')){
//       $this->validate($request, [
//         'user_type' => 'required|not_in:Select User Type',

//     ]);
// if($request->user_type != "null"){
//       if ($request->user_type == 'Super Admin') {
//         return redirect()->back()->with('warning','You Can not Added user as super Admin. other info Successfully updated.');
//     } else {
//         $user->deferAndAttachNewRole(Role::where('name', $request->user_type)->first());

//     }
// }

    // }


    activityLog('Update User Info');
    if(Auth::user()->hasRole('Super Admin')){
        ActivityLogEmp($user->id,'Super Admin','profile update.');
        }elseif(Auth::user()->hasRole('Admin')){
            ActivityLogEmp($user->id,'Admin','profile update.');
        }else{
            ActivityLogEmp($user->id,'Me','profile update.');
        }
    return redirect()->back()->with('message','User Info Updated Successfully.');

}

public function appUserActive(Request $request){

    $this->validate($request, [
        'password' => 'min:5|required_with:confirm_password|same:confirm_password',
        'confirm_password' => 'min:5',
    ]);
    

    
    $user = User::where('id',$request->id)->first();

    //return $request->email;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->active=1;
    $user->role=$request->role;
    $user->save();
    activityLog('Employee Active By superadmin.');
    ActivityLogEmp($user->id,'Super Admin','Employee Active By superadmin.');
    // activityLog('Change Password by superadmin.');
    // if(Auth::user()->hasRole('Super Admin')){
    //     ActivityLogEmp($user->id,'Super Admin','Password Change.');
    //     }elseif(Auth::user()->hasRole('Admin')){
    //         ActivityLogEmp($user->id,'Admin','Password Change.');
    //     }else{
    //         ActivityLogEmp($user->id,'Me','Password Change.');
        // }

    return redirect()->back()->with('message','User Activated Succesfully');
}
public function appUserChangePassword(Request $request){

    $this->validate($request, [
        'password' => 'min:5|required_with:confirm_password|same:confirm_password',
        'confirm_password' => 'min:5',
    ]);

    $user = User::find($request->id);
    $user->password = Hash::make($request->password);
    $user->save();

    activityLog('Change Password by superadmin.');
    if(Auth::user()->hasRole('Super Admin')){
        ActivityLogEmp($user->id,'Super Admin','Password Change.');
        }elseif(Auth::user()->hasRole('Admin')){
            ActivityLogEmp($user->id,'Admin','Password Change.');
        }else{
            ActivityLogEmp($user->id,'Me','Password Change.');
        }

    return redirect()->back()->with('message','Password Change Succesfully');
}

    public function appUserChangePasswordOwn(Request $request){
        $this->validate($request, [
            'password' => 'min:5|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:5',
            'old_password' => 'min:5',
        ]);
        $current_password = Auth::User()->password;
        if(Hash::check($request->old_password, $current_password)){

        $user =User::find($request->user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        activityLog('Change password by user.');
        if(Auth::user()->hasRole('Super Admin')){
            ActivityLogEmp($user->id,'Super Admin','Password Change.');
            }elseif(Auth::user()->hasRole('Admin')){
                ActivityLogEmp($user->id,'Admin','Password Change.');
            }else{
                ActivityLogEmp($user->id,'Me','Password Change.');
            }

        }else{
            return redirect()->back()->with('warning','Please enter correct current password');
        }
        return redirect()->back()->with('message','Password Change Succesfully');
    }

    public function appUserChangeEmailBySAdmin(Request $request){

        $this->validate($request, [
            'email' => 'unique:users|min:5|required_with:confirm_email|same:confirm_email',
            'confirm_email' => 'min:5',
        ]);

        $user =User::find($request->user_id);
        $user->email = $request->email;
        $user->save();

        activityLog('Change email by superadmin.');
        if(Auth::user()->hasRole('Super Admin'))
        {
                ActivityLogEmp($user->id,'Super Admin','Email Change.');
        }elseif(Auth::user()->hasRole('Admin')){
                ActivityLogEmp($user->id,'Admin','Email Change.');
        }else{
                ActivityLogEmp($user->id,'Me','Email Change.');
            }

        return redirect()->back()->with('message','Email Address Change Succesfully');

    }
    public function appUserChangeEmpIdlBySAdmin(Request $request){

        $this->validate($request, [
            'emp_id' => 'unique:users|required',

        ]);

        $user =User::find($request->user_id);
        $user->emp_id = $request->emp_id;
        $user->save();

        activityLog('Employee Id by superadmin.');

        if(Auth::user()->hasRole('Super Admin')){
        ActivityLogEmp($user->id,'Super Admin','Employee Id Change.');
        }elseif(Auth::user()->hasRole('Admin')){
            ActivityLogEmp($user->id,'Admin','Employee Id Change.');
        }else{
            ActivityLogEmp($user->id,'Me','Employee Id Change.');
        }

        return redirect()->back()->with('message','Employee Id Change Succesfully');

    }

public function appUserInactiveBySAdmin($id,$name){
    $user =User::find($id);
    $user->active=0;
    $user->save();

    activityLog('Employee inactive By superadmin.');
    ActivityLogEmp($user->id,'Super Admin','Employee inactive By superadmin.');

    return redirect()->back()->with('message','User Inactive Successfully');
}
public function appUserActiveBySAdmin($id,$name){

    $user =User::find($id);
    $user->active=1;
    $user->save();

    activityLog('Employee Active By superadmin.');
    ActivityLogEmp($user->id,'Super Admin','Employee Active By superadmin.');

    return redirect()->back()->with('message','User Active Successfully');
}

}
