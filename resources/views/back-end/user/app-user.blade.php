
@extends('back-end.master')
@section('title')
EMS User
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
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a>Users</h2>
                    <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ul>
                </div>

            </div>
            <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                            <h2>User List</h2>
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

                            <div id="IdForTaggle" style="display: none;">
                                    <br/>&nbsp;
                                  <form method="POST" action="{{ route('filter-user') }}" enctype='multipart/form-data'>
                                    @csrf
                                <div class="row" >
                                    <div class="col-md-2">

                                            <select class="form-control show-tick" data-toggle="tooltip"
                                            data-placement="top" name="role">
                                            <option value="">Select User Role</option>
                                            @foreach($roleList as $role)
                                                @if($role->role !='Super Admin')
                                                    <option value="{{$role->role}}">{{ $role->role }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                            {{-- <input type="text"  class="form-control" placeholder="Role" title="Role"> --}}
                                    </div>

                                    <div class="col-md-2">
                                        <select class="form-control show-tick" name="user_type"data-toggle="tooltip"
                                        data-placement="top" title="User Type">
                                            <option value="">Select User Type</option>
                                            @foreach($roles as $role)
                                                @if($role->name !='Super Admin')
                                                    <option value="{{$role->name}}">{{ $role->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                            <input type="text" data-provide="datepicker" class="form-control" name="Sjoin_date" placeholder="Join Date" title="Join Date" data-toggle="tooltip"
                                            data-placement="top">
                                    </div>
                                    <div class="center">
                                            <p>To</p>
                                        </div>
                                <div class="col-md-2">
                                        <input type="text" data-provide="datepicker" class="form-control" name="Ejoin_date" placeholder="Join Date" title="Join Date" data-toggle="tooltip"
                                        data-placement="top">
                                </div>



                                <div class="col-md-1">
                                    <input type="submit" class="btn btn-success" name="btn" value="OK">
                                </div>
                                </div>
                            </form>
                            </div>




                        <ul class="header-dropdown">
                                @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                {{-- <li data-toggle="tooltip" data-placement="top" title="Filter User">
                                        <select class="form-control mb-3 show-tick" onchange="window.location = $(':selected', this).attr('href')" name="job_status">
                                                <option href="{{url('emp.app-users')}}">Filter By</option>
                                                <option href="{{url('app-user/search/active-user')}}" >Active User</option>
                                                <option href="{{url('app-user/search/inactive-user')}}" >Inactive User</option>
                                                <option href="{{url('app-user/search/provision-period')}}" >Provision Period User</option>
                                                <option href="{{url('app-user/search/permanent-user')}}">Permanent User</option>

                                        </select>

                                </li>
                             <li><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#add_user">Add User</a></li> 
                            <li><a href="javascript:void(0);" onclick="btnToggleFunction()" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" class="btn btn-info"><i data-toggle="tooltip" data-placement="top" title="Filter" style="color:#f58c1f" class="fas fa-filter"></i></a></li>
                            --}}
                            <li><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#add_user"><i data-toggle="tooltip" data-placement="top" title="Add New" style="color:#f58c1f" class="fas fa-plus"></i></a></li>
                            
                            @endif
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Join Date</th>
                                        <th>Role</th>
                                        <th>Created By</th>
                                        @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($userList as $user)


                                    <tr>
                                        <td class="width45">
                                                @if($user->profile_photo)
                                                <a href="{{ route('view-user-details',['id'=>$user->id,'name'=>$user->name]) }}">
                                                <img src="{{asset($user->profile_photo)}}" class="rounded-circle width35" alt="">
                                                </a>
                                                @else
                                                <a href="{{ route('view-user-details',['id'=>$user->id,'name'=>$user->name]) }}">
                                                <img src="{{asset('images/nobody_m.original.jpg')}}" class="rounded-circle width35" alt="">
                                                </a>
                                                @endif
                                        {{-- <img src="{{ asset($user->profile_photo)}}" class="rounded-circle width35" alt=""> --}}
                                        </td>
                                        <td>
                                                <a href="{{ route('view-user-details',['id'=>$user->id,'name'=>$user->name]) }}">
                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                        <span>{{ $user->email }}</span>
                                                </a>
                                        </td>
                                        <td><span

                                        @if($user->hasRole('Super Admin'))
                                            class="badge badge-pill badge-danger"
                                        @elseif($user->hasRole('Admin'))
                                        class="badge badge-pill badge-info"

                                        @elseif($user->hasRole('Employee'))
                                        class="badge badge-pill badge-success"

                                        @endif>

                                        {{$user->roles->first()->name}}

                                        </span></td>


                                        <td>
                                             @if($user->join_date)
                                                {{Carbon\Carbon::parse($user->join_date)->toFormattedDateString()}}

                                                @endif</td>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->created_by }}</td>
                                        @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                        <td>
                                                @if($user->roles->first()->name != 'Super Admin')
                                                @if($user->active == 0 && $user->password == null)
                                                    <span data-toggle="modal" data-target="#active-{{$user->id}}">
                                                        <a href="javascript:void(0);" class="btn btn-sm " data-toggle="tooltip" data-placement="top" title="Active"><i style="color:darkgrey" class="fas fa-toggle-on fa-2x"></i></a>
                                                    </span>
                                                @elseif($user->active == 0 && $user->password != null)
                                                <a href="{{ route('active-user',['id'=>$user->id,'name'=>$user->name]) }}" class="btn btn-sm" data-toggle="tooltip" data-placement="top" title="active"><i style="color:darkgrey" class="fas fa-toggle-on fa-2x fa-rotate-180"></i></a>
                                                @else
                                                    <a href="{{ route('inactive-user',['id'=>$user->id,'name'=>$user->name]) }}" class="btn btn-sm" data-toggle="tooltip" data-placement="top" title="Inactive"><i style="color:green" class="fas fa-toggle-on fa-2x fa-rotate-180"></i></a>
                                                @endif

                                            <!-- <span data-toggle="modal" data-target="#editUser-{{$user->id}}">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-success" title="Edit" data-toggle="tooltip" data-placement="top"><i class="fa fa-edit"></i></a>
                                            </span> -->
                                            @endif
                                            @if(Auth::user()->hasRole('Super Admin'))
                                            @if($user->roles->first()->name != 'Super Admin')
                                            <a href="{{ route('delete-user',['id'=>$user->id,'name'=>$user->name]) }}" class="btn btn-sm btn-outline-danger" title="Delete" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></a>
                                            @endif
                                            @if($user->active == 0)
                                            <span data-toggle="modal" data-target="">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" disabled title="Change Password" data-toggle="tooltip" data-placement="top"><i class="fa fa-key" aria-hidden="true"></i></a>
                                            </span>
                                            @elseif($user->active == 1)
                                            <span data-toggle="modal" data-target="#change_pass-{{$user->id}}">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning" title="Change Password" data-toggle="tooltip" data-placement="top"><i class="fa fa-key" aria-hidden="true"></i></a>
                                            </span>
                                            @endif
                                            
                                            @endif
                                        </td>
                                        @endif
                                    </tr>

<div class="modal animated fadeIn" id="change_pass-{{$user->id}}" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="title" id="defaultModalLabel">change User password</h6>
        </div>
        <form method="POST" action="{{ route('change-user-password') }}" enctype='multipart/form-data'>
        <div class="modal-body">
            @csrf
            <div class="row clearfix">
                    <div class="col-12">
                    <h6>changing {{$user->name}}'s password</h6>
                    </div><br>
                    <br><input type="hidden" class="form-control" name="id" value="{{$user->id}}">
                        <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                        <input required type="password" class="form-control" id="passwo" name="password" placeholder="Password *">
                        <input type="hidden" class="form-control" name="user_id" placeholder="Password *">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <input type="password" oninput="check(this)" required class="form-control" name="confirm_password"  placeholder="Confirm Password *">
                        </div>
                    </div>
                    <script language='javascript' type='text/javascript'>
                        function check(input) {
                            if (input.value != document.getElementById('password').value) {
                                input.setCustomValidity('Password Must be Matching.');
                            } else {
                                // input is valid -- reset the error message
                                input.setCustomValidity('');
                            }
                        }
                    </script>
                
                <div class="col-12">

                    <hr>
            </div>


                    <div class="col-12 ">
                            <div class="form-group float-right">
                                <button type="submit" name="btn" value="Add" class="btn btn-primary">Change </button> 
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                            </div>
                    </div>

            </div>
        </div>
        {{-- <div class="modal-footer">
            <button type="button" class="btn btn-primary">Add</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
        </div> --}}
    </div>
</form>
</div>
</div>

    <div class="modal animated fadeIn" id="active-{{$user->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title">Active User</h6>
                </div>
                <form method="POST" action="{{ route('appUserActive') }}" enctype='multipart/form-data'>
                <div class="modal-body">
                    @csrf
                    <div class="row clearfix">
                            <!-- <div class="col-sm-12">
                                <div class="form-group">
                                <input type="text" class="form-control" data-toggle="tooltip"
                                        data-placement="top" name="email" title="email" placeholder="add email *">
                                </div>
                            </div> -->
                            <div class="col-12">
                            <select class="form-control show-tick" required name="role" data-toggle="tooltip"
                                                data-placement="top" title="Role">
                                                        <option value="">Select Role</option>

                                                            <option value="Admin">Admin</option> 
                                                            <option value="Employee">Employee</option> 

                                                    </select>
                            </div>
                        <br><input type="hidden" class="form-control" name="id" value="{{$user->id}}">
                        <br>
                        <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                        <input required type="password" class="form-control" id="passwo" name="password" placeholder="Password *">
                        <input type="hidden" class="form-control" name="user_id" placeholder="Password *">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <input type="password" oninput="check(this)" required class="form-control" name="confirm_password"  placeholder="Confirm Password *">
                        </div>
                    </div>
                    <script language='javascript' type='text/javascript'>
                        function check(input) {
                            if (input.value != document.getElementById('password').value) {
                                input.setCustomValidity('Password Must be Matching.');
                            } else {
                                // input is valid -- reset the error message
                                input.setCustomValidity('');
                            }
                        }
                    </script>

                        <div class="col-12 ">
                                <div class="form-group float-right">
                                    <button type="submit" name="btn"  class="btn btn-primary">Active User</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                </div>
                        </div>

                    </div>
                </div> 
        </form>
        </div>
        </div>
<!-- userPasswordChange -->
<div class="modal animated fadeIn" id="userPasswordChang-{{$user->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title">Change {{$user->name}}'s Password</h6>
            </div>
            <form method="POST" action="{{ route('change-user-password') }}" enctype='multipart/form-data'>
            <div class="modal-body">
                @csrf
                <div class="row clearfix">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                        <input required type="password" class="form-control" id="passwo" name="password" placeholder="Password *">
                        <input type="hidden" class="form-control" name="user_id" value="{{ $user->id }}" placeholder="Password *">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <input type="password" oninput="check(this)" required class="form-control" name="confirm_password"  placeholder="Confirm Password *">
                        </div>
                    </div>
                    <script language='javascript' type='text/javascript'>
                        function check(input) {
                            if (input.value != document.getElementById('password').value) {
                                input.setCustomValidity('Password Must be Matching.');
                            } else {
                                // input is valid -- reset the error message
                                input.setCustomValidity('');
                            }
                        }
                    </script>

                        <div class="col-12 ">
                                <div class="form-group float-right">
                                    <input type="submit" name="btn" value="Update Password" class="btn btn-primary">
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
    <div class="modal animated fadeIn" id="editUser-{{$user->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title">Edit User</h6>
                </div>
                <form method="POST" action="{{ route('update-user-info') }}" enctype='multipart/form-data'>
                <div class="modal-body">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                            <input type="text" class="form-control" value="{{$user->name}}"data-toggle="tooltip"
                                    data-placement="top" name="name" title="Name" placeholder="Name *">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="email" class="form-control" value="{{$user->email}}"data-toggle="tooltip"
                                    data-placement="top" readonly title="Email" placeholder="Email ID *">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{$user->phone_no}}" data-toggle="tooltip"
                                    data-placement="top" name="phone_no" placeholder="Phone No *" title="Phone No">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                    <input type="text" class="form-control" value="@if($user->join_date){{Carbon\Carbon::parse($user->join_date)->format('m/d/Y')}}@endif" data-provide="datepicker" name="join_date" placeholder="Join Date" title="Join Date" data-toggle="tooltip"
                                    data-placement="top">
                                </div>
                        </div>


                        <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <input type="text" value="{{$user->role}}"data-toggle="tooltip"
                                    data-placement="top" name="role" class="form-control" placeholder="Role" title="Role">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                    <input type="text" value="@if($user->date_of_birth){{Carbon\Carbon::parse($user->date_of_birth)->format('m/d/Y')}}@endif " data-provide="datepicker" name="date_of_birth" data-toggle="tooltip"
                                    data-placement="top" title="Date Of birth" class="form-control" placeholder="Date of birth">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                                <select class="form-control show-tick" required name="blood_group" data-toggle="tooltip"
                                                data-placement="top" title="Blood Group">
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
                                <input type="text" class="form-control"value="{{$user->emp_id}}"data-toggle="tooltip"
                                    data-placement="top" readonly placeholder="Employee ID *" title="Employee ID">
                                <input type="hidden" value="{{$user->id}}" name="user_id" >
                            </div>
                        </div>

                        @if(Auth::user()->hasRole('Super Admin'))
                        <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <select required class="form-control show-tick" name="user_type"data-toggle="tooltip"
                                    data-placement="top" title="User Type">
                                        <option value="">Select User Type</option>
                                        @foreach($roles as $role)
                                            @if($role->name !='Super Admin')
                                                <option @if($user->roles->first()->name==$role->name) selected @endif value="{{$role->name}}">{{ $role->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-4 col-sm-12">
                                    <select class="form-control mb-3 show-tick" name="job_status"data-toggle="tooltip"
                                    data-placement="top" title="Job Status">
                                        <option>Select Job Status</option>

                                        <option {{ $user->job_status=='Provision Period' ? 'Selected' : ''}}  value="Provision Period" >Provision Period</option>
                                        <option value="Permanent" {{ $user->job_status=='Permanent' ? 'Selected' : ''}} >Permanent</option>

                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                        <select class="form-control mb-3 show-tick" name="gender" data-toggle="tooltip"
                                    data-placement="top" title="Gender">
                                            <option>Select Gender</option>

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
<!--
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" name="bank_name" class="form-control" placeholder="Bank Name"data-toggle="tooltip"
                                    data-placement="top" title="Bank Name" value="{{$user->bank_name}}">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" name="branch" class="form-control" placeholder="Branch"data-toggle="tooltip"
                                    data-placement="top" title="Branch" value="{{$user->branch}}">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" name="bank_ac" class="form-control" placeholder="Bank A/C No"data-toggle="tooltip"
                                    data-placement="top" title="Bank A/C No" value="{{$user->bank_ac}}">
                            </div>
                        </div> -->
                        <div class="col-12">

                            <hr>
                    </div>

                        <!-- <div class="col-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="{{$user->facebook_link}}" name="facebook_link"data-toggle="tooltip"
                                    data-placement="top" placeholder="Facebook" title="Facebook">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="{{$user->twitter_link}}" name="twitter_link"data-toggle="tooltip"
                                    data-placement="top" placeholder="Twitter" title="Twitter">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="{{$user->linkedin_link}}" name="linkedin_id"data-toggle="tooltip"
                                    data-placement="top" placeholder="Linkedin"title="Linkedin">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="{{$user->git_link}}" name="git_link"data-toggle="tooltip"
                                    data-placement="top" placeholder="Git" title="Git">
                                </div>
                            </div> -->

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










                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Default Size -->
<div class="modal animated fadeIn" id="add_user" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h6 class="title" id="defaultModalLabel">Add User</h6>
        </div>
        <form method="POST" action="{{ route('add-new-user-p') }}" enctype='multipart/form-data'>
        <div class="modal-body">
            @csrf
            <div class="row clearfix">
            
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                    <select class="form-control mb-3 show-tick" name="attendence_of" onchange="myFunction(event)">
                          <option value="">Select User</option>
                          @foreach($userLists as $u)
                            @if($u->role == "Super Admin")

                            @else
                            <option>{{$u->emp_id}} ( {{$u->name}} )
                                
                            </option>
                            
                            @endif
                          @endforeach
                        
                      </select>    
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <select class="form-control show-tick" name="role" >
                                <option value="" required>Select User role</option>
                                @foreach($roles as $role)
                                    @if($role->name !='Super Admin' && $role->name !='Admin')
                                        <option>{{ $role->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br><input type="hidden" class="form-control" name="id" value="{{$user->id}}">
                        <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                        <input required type="password" class="form-control" id="passwo" name="password" placeholder="Password *">
                        <input type="hidden" class="form-control" name="user_id" placeholder="Password *">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <input type="password" oninput="check(this)" required class="form-control" name="confirm_password"  placeholder="Confirm Password *">
                        </div>
                    </div>
                    <script language='javascript' type='text/javascript'>
                        function check(input) {
                            if (input.value != document.getElementById('password').value) {
                                input.setCustomValidity('Password Must be Matching.');
                            } else {
                                // input is valid -- reset the error message
                                input.setCustomValidity('');
                            }
                        }
                    </script>
                
                <div class="col-12">

                    <hr>
            </div>


                    <div class="col-12 ">
                            <div class="form-group float-right">
                                <button type="submit" name="btn" value="Add" class="btn btn-primary">Add </button> 
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                            </div>
                    </div>

            </div>
        </div>
        {{-- <div class="modal-footer">
            <button type="button" class="btn btn-primary">Add</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
        </div> --}}
    </div>
</form>
</div>
</div>



@endsection
