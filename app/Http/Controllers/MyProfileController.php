<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Salary;
use App\Department;
use DB;
use Carbon\Carbon;
use File;
use Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class MyProfileController extends Controller
{
    public function myProfile(){
        $id=Auth::user()->id;
        $user=User::find($id);
        $salary_info=Salary::where('employee_id',$id)->first();
        //  return $salary_info;
        $obj_dept=Department::all();
        $roles = Role::all();


        return view('back-end.my-profile.my-profile',[
            'user'=>$user,
            'salary_info'=>$salary_info,
            'obj_dept'=>$obj_dept,
            'roles'=>$roles,
        ]);
    }
    public function updateMyProfile(Request $request){

        // return $request;
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'gender' => 'required|not_in:Select Gender',

        ]);

        $date_of_birth=Carbon::parse($request->date_of_birth);

        $user =User::find($request->user_id);
        $user->name = $request->name;

        $user->phone_no = $request->phone_no;
        $user->date_of_birth = $date_of_birth;
        $user->blood_group = $request->blood_group;
        $user->gender = $request->gender;

        if(Auth::user()->roles->first()->name=='Super Admin'){
            $this->validate($request, [
                'email' => 'required|string|email|max:255',
            ]);
        $user->role = $request->role;
        if($request->dept_name!="Select Department Type"){
            $user->dept_name = $request->dept_name;
        }
        $user->email = $request->email;
        $user->emp_id = $request->emp_id;
    }
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
      // });

      $user->save();
      activityLog('Update own profile.');
      ActivityLogEmp($user->id,'Me','Profile update.');

    return redirect()->back()->with('message','User Info Updated Successfully.');
    }
}
