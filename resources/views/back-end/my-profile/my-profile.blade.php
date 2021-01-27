   
@extends('back-end.master')
@section('title')
EMS My Profile
@endsection
@section('appUser')
active
@endsection
@section('content')


<div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
    
    
    
    
    
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Employee List</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Employee</li>
                            <li class="breadcrumb-item active">Employee List</li>
                        </ul>
                    </div>            

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>
    
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
    
                            <h2>Employee Details</h2>
    
    
                            @if(Session::get('warning'))
                            <div class="alert alert-warning" id="warning">
                                <h6 class=" text-center text-warning"> {{ Session::get('warning') }}</h6>
                            </div>
                            @endif            
    
                            @if(Session::get('message'))
                            <div class="alert alert-success" id="message">
                                <h6 class=" text-center text-success"> {{ Session::get('message') }}</h6>
                            </div>
                            @endif
    
                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
    
    
                      
                        </div>
                        <div class="body">
                                <div class="row">


<div class="col-md-12 text-center">

<div class="container" id=profileCon>
        @if($user->profile_photo)
        <a href="#">
            <img class="imgProfile"  src="{{ asset($user->profile_photo) }}" class="img-thumbnail">
        </a>
        @else
        <a href="#">
        <img class="imgProfile"  src="{{asset('images/nobody_m.original.jpg')}}" class="img-thumbnail">
        </a>
        @endif
      {{-- <p class="title">{{ $user->name }}</p> --}}
        <div class="overlay"></div>
        <div class="button" id='button11'>
                <a href="{{$user->twitter_link}}" style="color:#1DA1F2;" target="_blank"><i class="fab fa-twitter-square fa-3x"></i></a>
                <a href="{{$user->facebook_link}}" style="color:#3C5A99;" target="_blank"><i class="fab fa-facebook-square fa-3x"></i></a>&nbsp;
                <a href="{{$user->linkedin_link}}" style="color:#006192;" target="_blank"><i class="fab fa-linkedin-square fa-3x"></i></a>&nbsp;
                <a href="{{$user->git_link}}" style="color:#657786;" target="_blank"><i class="fab fa-github-square fa-3x"></i></a>&nbsp;

        </div>
      </div>

      <br/>&nbsp;

      <div class="col-md-12" id=''>
            <span data-toggle="modal" data-target="#userPasswordChange">
                <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning" data-toggle="tooltip" data-placement="top" title="Change Password"><i class="fa fa-key" aria-hidden="true"></i></a>
            </span>
            <span data-toggle="modal" data-target="#editUser">
                <a href="javascript:void(0);" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="Edit Profile"><i class="fa fa-edit"></i></a>
            </span>
            {{-- <a class="btn btn-info" href="#">Edit Profile</a> --}}
            {{-- <a class="btn btn-info" href="#">Change Password</a>&nbsp; --}}

      </div>
      <br/>&nbsp;

</div>
<div class="col-md-12">
<div class="row">
                                        <div class="col-md-6">
                                           <table class="table" width="100%">
                                               <tr class="">
                                                   <th style="width: 50%" class="" scope="col">Name</th>
                                                   <td style="width: 50%" data-title="Name">{{ $user->name }}</td>
               
                                               </tr>
                                               <tr class="">
                                                   <th scope="col">Email</th>
                                                   <td data-title="Email">{{ $user->email }}</td>
                                               </tr>
                                               <tr class="">
                                                   <th scope="col">Phone No</th>
                                                   <td data-title="Email">{{ $user->phone_no }}</td>
                                               </tr>
                                               <tr class="">
                                                   <th scope="col">Employee ID</th>
                                                   <td data-title="EMployee Id">{{ $user->emp_id }}</td>
                                               </tr>
                                               <tr class="">
                                                    <th scope="col">Join Date</th>
                                                    <td data-title="Join Date">{{ $user->join_date }}</td>
                                                </tr>
                                                <tr class="">
                                                        <th scope="col">Date of birth</th>
                                                     
                                                        <td data-title="Join Date">{{ $user->date_of_birth }}</td>
                                                     
                                                    </tr>

                                           </table>
                                       </div>
                                        <div class="col-md-6 float-right">
                                                <table class="table" width="100%">
                                                        <tr class="">
                                                                <th scope="col">Department</th>
                                                                <td data-title="Join Date">{{ $user->dept_name }}</td>
                                                        </tr>
                                                <tr class="">
                                                        <th scope="col">Gender</th>
                                                        <td data-title="Gender">{{ $user->gender }}</td>
                                            </tr>
                                            <tr class="">
                                                    <th scope="col">Job Status</th>
                                                    <td data-title="Job Status">{{ $user->job_status }}</td>
                                        </tr>
                                            <tr class="">
                                                    <th scope="col">Role</th>
                                                    <td data-title="Role">{{ $user->role }}</td>
                                                </tr>
                                           <tr class="">
                                               <th scope="col">User Type</th>
                                               <td data-title="Role">
                                                    {{$user->roles->first()->name}}
                                               </td>
                                           </tr>
                                           <tr class="">
                                                <th scope="col">Blood Gropu</th>
                                             
                                                <td data-title="Join Date">{{ $user->blood_group }}</td>
                                             
                                            </tr>
                                           {{-- <tr class="">
                                               <th scope="col">
                                                   <a class="btn btn-block btn-info" href="#">Change Password</a>
                                               </th>
                                               <td data-title="">
           
                                                   <a class="btn btn-block btn-info" href="#">Edit Profile</a>
                                               </td>
                                           </tr> --}}
                                       </table>
                                       </div>
                                       </div>
                                       </div>

                                       &nbsp;
                                       <div class="col-md-12">
                                       {{-- <div onclick="btnToggleFunction2()" class="panel-header btn btn-default btn-block">
                                                <a><h6 class="text-left"><i class="fas fa-list" ></i> &nbsp;Bank Details</h6></a>
                                            </div>
                                            <div id="IdForTaggle2" style="display: none" class="panel-body ">
                                                    
                                                   
                                                            <table class="table" width="100%">
                                                                <tr class="">
                                                                    <th style="width: 50%" class="" scope="col">Bank Name</th>
                                                                    <td style="width: 50%" data-title="Bank Name">{{ $user->bank_name }}</td>
                                
                                                                </tr>
                                                                <tr class="">
                                                                    <th scope="col">Branch</th>
                                                                    <td data-title="Branch">{{ $user->branch }}</td>
                                                                </tr>
                                                                <tr class="">
                                                                    <th scope="col">Bank A/C No</th>
                                                                    <td data-title="Bank A/C No">{{ $user->bank_ac }}</td>
                                                                </tr>
                                            
                    
                                                            </table>
                                                      
                    
                    
                                            </div>
                                   </div>
                                   
                                   &nbsp;
                                       <div class="col-md-12">
                                            <div onclick="btnToggleFunction()" class="panel-header btn btn-default btn-block">
                                                    <a><h6 class="text-left"><i class="fas fa-list" ></i> &nbsp;Salary Info</h6></a>
                                                </div>
                                                <div id="IdForTaggle" style="display: none" class="panel-body row ">
                                                        @if($salary_info)
                                                        <div class="col-md-6">
                                                                <table class="table" width="100%">
                                                                    <tr class="">
                                                                        <th style="width: 50%" class="" scope="col">Basic Salary</th>
                                                                        <td style="width: 50%" data-title="Name">{{ $salary_info->basic_salary }}</td>
                                    
                                                                    </tr>
                                                                    <tr class="">
                                                                        <th scope="col">House Rent Allowance</th>
                                                                        <td data-title="Email">{{ $salary_info->house_rent_allowance }}</td>
                                                                    </tr>
                                                                    <tr class="">
                                                                        <th scope="col">bonus</th>
                                                                        <td data-title="Email">{{ $salary_info->Bonus }}</td>
                                                                    </tr>
                                                                    <tr class="">
                                                                        <th scope="col">Conveyance</th>
                                                                        <td data-title="EMployee Id">{{ $salary_info->conveyance }}</td>
                                                                    </tr>
                                                                    <tr class="">
                                                                         <th scope="col">Other Allowance</th>
                                                                         <td data-title="Join Date">{{ $salary_info->other_allowance }}</td>
                                                                     </tr>
                     
                                                                </table>
                                                            </div>
                                                             <div class="col-md-6 float-right">
                                                                     <table class="table" width="100%">
                                                                             <tr class="">
                                                                                     <th scope="col">TDS</th>
                                                                                     <td data-title="Join Date">{{ $salary_info->TDS }}</td>
                                                                             </tr>
                                                                     <tr class="">
                                                                             <th scope="col">Provident fund</th>
                                                                             <td data-title="Gender">{{ $salary_info->provident_fund }}</td>
                                                                 </tr>
                                                                 <tr class="">
                                                                         <th scope="col">Job Status</th>
                                                                         <td data-title="Job Status">{{ $salary_info->c_bank_loan }}</td>
                                                             </tr>
                                                                 <tr class="">
                                                                         <th scope="col">Role</th>
                                                                         <td data-title="Role">{{ $salary_info->other_deductions }}</td>
                                                                     </tr>
                                                        
                                                    
                                                            </table>
                                                            </div>

                                                            @else
                                                            <div class="col-md-12 text-center"><br/><h3>No Data Found</h3></div>
                                                            
                                                            @endif

                                                </div>
                                                
                                       </div>
                                       --}}



                                       </div>




                        </div>       

                    </div>
                </div>
            </div>

      </div>
            </div>





<!-- userPasswordChange -->
<div class="modal animated fadeIn" id="userPasswordChange" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title">Change Password</h6>
                </div>
                <form method="POST" action="{{ route('change-my-profile-password') }}" enctype='multipart/form-data'>
                <div class="modal-body">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">                                    
                            <input type="password" class="form-control" name="old_password" placeholder="Current Password *">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">                                    
                            <input type="password" class="form-control" name="password" placeholder="Password *">
                            <input type="hidden" class="form-control" name="user_id" value="{{ $user->id }}" placeholder="Password *">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">                                    
                                <input type="password" class="form-control" name="confirm_password"  placeholder="Confirm Password *">
                            </div>
                        </div>
    
        
                            <div class="col-12 ">
                                    <div class="form-group float-right">                                    
                                        <button type="submit" name="btn" class="btn btn-primary">Update Password</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                    </div>
                            </div>
        
                    </div>
                </div>
    
            </div>
        </form>
        </div>
        </div>
        
        




<!-- edit user -->
    <div class="modal animated fadeIn" id="editUser" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="title">Edit User</h6>
                    </div>
                    <form method="POST" action="{{ route('update-my-profile') }}" enctype='multipart/form-data'>
                    <div class="modal-body">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">                                    
                                <input type="text" class="form-control" required value="{{$user->name}}" title="Name"data-toggle="tooltip" data-placement="top" name="name" placeholder="Name *">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">                                    
                                    <input type="email" class="form-control" value="{{$user->email}}" @if(Auth::user()->roles->first()->name!='Super Admin')) readonly @else name="email" @endif placeholder="Email ID *"
                                    title="Email"data-toggle="tooltip" data-placement="top">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" value="{{$user->phone_no}}" name="phone_no"
                                    title="Phone No"data-toggle="tooltip" data-placement="top" placeholder="Phone No *">
                                </div>
                            </div>    

                            <div class="col-md-4 col-sm-12">
                                    <div class="form-group">                                    
                                    <input type="text" value="@if($user->date_of_birth){{Carbon\Carbon::parse($user->date_of_birth)->format('m/d/Y')}}@endif" data-provide="datepicker" name="date_of_birth" class="form-control"
                                    title="Date of birth"data-toggle="tooltip" data-placement="top" placeholder="Date of birth">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                        <div class="form-group" title="Blood Group"data-toggle="tooltip" data-placement="top">                                    
                                                <select class="form-control show-tick" required name="blood_group">
                                                        <option value="">Select Blood Group</option>
                                                        
                                                            <option {{ $user->blood_group=='A+' ? 'Selected' : ''}}>A+</option>
                                                            <option {{ $user->blood_group=='A-' ? 'Selected' : ''}}>A-</option>
                                                            <option {{ $user->blood_group=='AB+' ? 'Selected' : ''}}>AB+</option>
                                                            <option {{ $user->blood_group=='AB-' ? 'Selected' : ''}}>AB-</option>
                                                            <option {{ $user->blood_group=='B+' ? 'Selected' : ''}}>B+</option>
                                                            <option {{ $user->blood_group=='B-' ? 'Selected' : ''}}>B-</option>
                                                            <option {{ $user->blood_group=='O+' ? 'Selected' : ''}}>O+</option>
                                                            <option {{ $user->blood_group=='O-' ? 'Selected' : ''}}>O-</option>
                                                        
                                                    </select>
                                        </div>
                                </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">                                    
                                    <input type="text" title="Employee Id"data-toggle="tooltip" data-placement="top" class="form-control"value="{{$user->emp_id}}"@if(Auth::user()->roles->first()->name!='Super Admin')  readonly @else name="emp_id" @endif placeholder="Employee ID *">
                                    <input type="hidden" value="{{$user->id}}" name="user_id" >
                                </div>
                            </div>

                            @if(Auth::user()->roles->first()->name=='Super Admin')
                            <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <select class="form-control show-tick" name="dept_name" title="Department Name"data-toggle="tooltip" data-placement="top">
                                            <option>Select Department Type</option>
                                            @foreach($obj_dept as $dept)
                                                <option value="{{$dept->dept_name}}" {{ $dept->dept_name==$user->dept_name ? 'Selected' : ''}} >{{ $dept->dept_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                        <div class="form-group">                                    
                                            <input type="text" value="{{$user->role}}"data-toggle="tooltip"
                                            data-placement="top" name="role" class="form-control" placeholder="Role" title="Role">
                                        </div>
                                    </div>

                                    @endif
                     
                                    <div class="col-md-4 col-sm-12" title="Gender"data-toggle="tooltip" data-placement="top">
                                            <select class="form-control mb-3 show-tick" name="gender">
                                                <option value="" required>Select Gender</option>
                                               
                                                <option value="Male" {{ $user->gender=='Male' ? 'Selected' : ''}}>Male</option>
                                                <option value="Female" {{ $user->gender=='Female' ? 'Selected' : ''}}>Female</option>
                                                
                                            </select>
                                        </div>
                            <div class="col-12">
                                    <div class="form-group">                                            
                                        <input type="file" name="profile_photo" class="form-control-file" accept="image/*" id="exampleInputFile" aria-describedby="fileHelp">
                                        <small id="fileHelp" class="form-text text-muted">Image should be less then 2mb.</small>
                                    </div>
                                    <hr>
                            </div>
                            <div class="col-6">
                                    <div class="form-group">                                    
                                        <input type="text" class="form-control" title="Facebook Link"data-toggle="tooltip" data-placement="top" value="{{$user->facebook_link}}" name="facebook_link" placeholder="Facebook">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">                                   
                                        <input type="text" class="form-control" title="Twitter Link"data-toggle="tooltip" data-placement="top" value="{{$user->twitter_link}}" name="twitter_link" placeholder="Twitter">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">                                    
                                        <input type="text" class="form-control" title="Linkedin Link"data-toggle="tooltip" data-placement="top" value="{{$user->linkedin_link}}" name="linkedin_id" placeholder="Linkedin">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">                                    
                                        <input type="text" class="form-control" title="Git_ Lnk"data-toggle="tooltip" data-placement="top" value="{{$user->git_link}}" name="git_link" placeholder="Git">
                                    </div>
                                </div>
            
                                <div class="col-12 ">
                                        <div class="form-group float-right">                                    
                                            <input type="submit" name="btn" value="Update" class="btn btn-primary">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                        </div>
                                </div>
            
                        </div>
                    </div>
     
                </div>
            </form>
            </div>
            </div>
            
            
    








@endsection