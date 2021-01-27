
@extends('back-end.master')
@section('title')
Employee List
@endsection
@section('statusEMP')
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

                        <h2>Employee List</h2>


                        @if(Session::get('message'))
                        <div class="alert alert-success" id="message">
                            <h6 class=" text-center text-success"> {{ Session::get('message') }}</h6>
                        </div>
                        @endif

                        @if(Session::get('warning'))
                        <div class="alert alert-warning" id="warning">
                            <h6 class=" text-center text-warning"> {{ Session::get('warning') }}</h6>
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
                              <form method="POST" action="{{ route('filter-employee') }}" enctype='multipart/form-data'>
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

                        @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                        <ul class="header-dropdown">
                            {{-- <li data-toggle="tooltip" data-placement="top" title="Filter Emp">
                                    <select class="form-control mb-3 show-tick" onchange="window.location = $(':selected', this).attr('href')" name="job_status">
                                            <option href="{{url('employee.all')}}">Filter By</option>

                                            <option href="{{url('app-emp/search/active-emp')}}" >Active Employee</option>
                                            <option href="{{url('app-emp/search/inactive-emp')}}" >Inactive Employee</option>
                                            <option href="{{url('app-emp/search/provision-period')}}" >Provision Period</option>
                                            <option href="{{url('app-emp/search/permanent-emp')}}">Permanent</option>

                                    </select>

                            </li>

                            --}}
                        
                            <!-- <li><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#import"><i data-toggle="tooltip" data-placement="top" title="import employee" style="color:#f58c1f" class="fas fa-file-download"></i></a></li>  -->
                            <li><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#add_user"><i data-toggle="tooltip" data-placement="top" title="Add New" style="color:#f58c1f" class="fas fa-plus"></i>Add Employee</a></li>
                            <li><a href="{{route('print-emp-preview')}}" class=" btn-default" style="padding: 0px 6px;font-size: 12px;"><i data-toggle="tooltip" data-placement="top" title="Add New" style="color:#f58c1f" class="fas fa-print"></i> Print</a></li>
                            
                            <!-- <li><a href="javascript:void(0);" onclick="btnToggleFunction()" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" class="btn btn-info"><i data-toggle="tooltip" data-placement="top" title="Filter" style="color:#f58c1f" class="fas fa-filter"></i></a></li> -->
                        </ul>
                        @endif
                        @if(Auth::user()->hasRole('Employee'))
                        <ul class="header-dropdown">
                        <li><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#add_user"><i data-toggle="tooltip" data-placement="top" title="Add New" style="color:#f58c1f" class="fas fa-plus"></i>Add Employee</a></li>
                        </ul>
                        @endif
                    </div>

                    <div class="body">
                        <div class="table-responsive">
                            <table style="table-layout: fixed; text-align:center;" class="table table-hover js-basic-example dataTable table-custom table-striped m-b-0 c_list">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>
                                            <label class="fancy-checkbox">
                                               <!--    <input class="select-all" type="checkbox" name="checkbox"> -->
                                               <span></span>
                                           </label>
                                       </th>
                                       <th>Name</th>
                                       
                                       <th>Emp ID</th>
                                       <th>Department</th>
                                       <th>Designation</th>
                                       <th>In Time</th>
                                       <th>Out Time</th>
                                       <th style="white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;">Holidays</th>
                                       
                                       <th>Action</th>
                                       
                                   </tr>
                               </thead>
                               <tbody>
                                @foreach($userList as $user)
                                <tr>
                                    <td class="">
<!--                                             <label class="fancy-checkbox">
                                                    <input class="checkbox-tick" type="checkbox" name="checkbox">
                                                    <span></span>
                                                </label> -->
                                                @if($user->profile_photo)
                                                <a href="{{ route('view-user-details',['id'=>$user->id,'name'=>$user->name]) }}">
                                                <img src="{{asset($user->profile_photo)}}" class="rounded-circle avatar" alt="">
                                                </a>
                                                @else
                                                <a href="{{ route('view-user-details',['id'=>$user->id,'name'=>$user->name]) }}">
                                                <img src="{{asset('images/nobody_m.original.jpg')}}" class="rounded-circle avatar" alt="">
                                                </a>
                                                @endif
                                            </td>
                                        <td style="text-align:left;"><a href="{{ route('view-user-details',['id'=>$user->id,'name'=>$user->name]) }}">
                                                <h6 class="mb-0">{{$user->name}}</h6>
                                                <span>{{$user->email}}</span></a>
                                            </td>
                                            
                                            <td style="text-align:right;"><span>{{$user->emp_id}}</span></td>
                                            <td>{{$user->department}}</td>
                                            
                                            <td>{{$user->designation}}</td>

                                                <td><?php $tt = 0;?>
                                                @foreach($inout_time as $iotime)
                                                    @if($iotime->user_id == $user->emp_id)
                                                        
                                                        <?php 
                                                                $time= explode(":", $iotime->in_time);
                                                                if($time[0]>12){
                                                                    $time[0]=$time[0]-12;
                                                                    $sn= $time[0].":".$time[1]. " PM";
                                                                }else{
                                                                    $sn= $time[0].":".$time[1]. " AM";
                                                                }
                                                                $tt=1;
                                                                ?>
                                                {{$sn}}
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                @foreach($inout_time as $iotime)
                                                    @if($iotime->user_id == $user->emp_id)
                                                        <?php 
                                                                $time2= explode(":", $iotime->out_time);
                                                                if($time2[0]>12){
                                                                    $time2[0]=$time2[0]-12;
                                                                    $en= $time2[0].":".$time2[1]. " PM";
                                                                }else{
                                                                    $en= $time2[0].":".$time2[1]. " AM";
                                                                }
                                                                $tt=1;
                                                                ?>
                                            {{$en}}
                                                    @endif
                                                    @endforeach
                                                </td>

                                                <td style="white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;">
                                               
                                                    @foreach($holidays as $holiday)
                                                        @if($holiday->emp_id ==$user->emp_id)
                                                        <?php 
                                                            $hol = explode(",",$holiday->date);
                                                            
                                                            ?><span data-toggle="modal" data-target="#view-{{$holiday->id}}">
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning" data-toggle="tooltip" data-placement="top" title="view All"><i class="fa fa-eye"></i></a>
                                                        </span>
                                                            
                                                            @foreach($hol as $hl)
                                                            {{ $hl }} [{{\Carbon\Carbon::parse($hl)->format('l')}}]
                                                            @endforeach
                                                        
                                                                
                                                        @endif
                                                        <div class="modal fade" id="view-{{$holiday->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Holidays</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div style="margin-left:25%" class="modal-body">
      <?php 
                                                $hol = explode(",",$holiday->date);
                                                ?>
                                                 @foreach($hol as $hl)
                                                {{ $hl }} [{{\Carbon\Carbon::parse($hl)->format('l')}}]<br>

                                                @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
                                                    @endforeach
                                                </td>

                                        @if(Auth::user()->hasRole(['Super Admin', 'Admin','Employee']))
                                            <td>
                                                @if($user->roles->first()->name != 'Super Admin')
                                                
                                                
                                              <span data-toggle="modal" data-target="#editEmp-{{$user->id}}">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                            </span>
                                            
                                            @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                            <a href="{{ route('delete-emp',['id'=>$user->id,'name'=>$user->name]) }}" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-type="confirm"><i class="fa fa-trash-o"></i></a>

                                            @endif 
                                                
                                            @endif
                                            <!-- @if(Auth::user()->hasRole(['Super Admin']))
                                                <a href="{{ route('delete-emp',['id'=>$user->id,'name'=>$user->name]) }}" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-type="confirm"><i class="fa fa-trash-o"></i></a>
                                            @endif -->
                                            
                                        </td>

                                        @endif
                                    
                                    </tr>


<!-- edit user -->
<div class="modal animated fadeIn" id="editEmp-{{$user->id}}" tabindex="-1" role="dialog">
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
                            <input type="text" class="form-control" value="{{$user->fathers_name}}"data-toggle="tooltip"
                                    data-placement="top" name="fathers_name" title="Fathers Name" placeholder="Fathers Name *">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                            <input type="text" class="form-control" value="{{$user->mothers_name}}"data-toggle="tooltip"
                                    data-placement="top" name="mothers_name" title="Mothers Name" placeholder="Fathers Name *">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                            <input type="text" class="form-control" value="{{$user->present_add}}"data-toggle="tooltip"
                                    data-placement="top" name="present_add" title="Present Address" placeholder="Present Address *">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                            <input type="text" class="form-control" value="{{$user->parmanent_add}}"data-toggle="tooltip"
                                    data-placement="top" name="parmanent_add" title="Parmanent Address" placeholder="Parmanent Address *">
                            </div>
                        </div>
                        @if(Auth::user()->hasRole('Super Admin'))
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="email" class="form-control" value="{{$user->email}}" data-toggle="tooltip"
                                    data-placement="top" name="email" title="Email" placeholder="Email ID *">
                            </div>
                        </div>
                        @endif

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                            <input type="text" class="form-control"  data-provide="datepicker"  value="@if($user->join_date){{Carbon\Carbon::parse($user->join_date)->format('m-d-Y')}}@endif " name="join_date" placeholder="Join Date" title="Join Date" data-toggle="tooltip"
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
                                    <input type="text"  value="@if($user->date_of_birth){{Carbon\Carbon::parse($user->date_of_birth)->format('d-m-Y')}}@endif "  data-provide="datepicker" name="date_of_birth" data-toggle="tooltip"
                                    data-placement="top" title="Date Of birth" class="form-control" placeholder="Date of birth">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{$user->religion}}"data-toggle="tooltip"
                                    data-placement="top" name="religion" placeholder="Religion *" title="Religion">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{$user->phone_no}}"data-toggle="tooltip"
                                    data-placement="top" name="phone_no" placeholder="Phone No *" title="Phone No">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" value="{{$user->emergency_phone_no}}"data-toggle="tooltip"
                                    data-placement="top" name="emergency_phone_no" placeholder="Emergency Phone No *" title="Emergency Phone No">
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
                                        <select class="form-control mb-3 show-tick" name="gender"data-toggle="tooltip"
                                    data-placement="top" title="Gender">
                                            <option>Select Gender</option>

                                            <option value="Male" {{ $user->gender=='Male' ? 'Selected' : ''}}>Male</option>
                                            <option value="Female" {{ $user->gender=='Female' ? 'Selected' : ''}}>Female</option>

                                        </select>
                                    </div>
                      
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="number" class="form-control" value="{{$user->emp_id}}" data-toggle="tooltip"
                                    data-placement="top" readonly placeholder="Employee ID (Only Number)" title="Employee ID (Only Number)">
                                <input type="hidden" value="{{$user->id}}" name="user_id" >
                            </div>
                        </div>

                        <!-- @if(Auth::user()->hasRole('Super Admin'))
                        <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <select required class="form-control show-tick" name="user_type"data-toggle="tooltip"
                                    data-placement="top" title="User Type">
                                        <option value="">Select User Type</option>
                                        @foreach($roles as $role)
                                            @if($role->name !='Super Admin')
                                                <option @if($user->roles->first()->name==$role->name) selected @endif value="{{$role->name}}" value="{{$role->name}}">{{ $role->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

@endif -->

                            
                                
                        <div class="col-12">
                                <div class="form-group">
                                    <input type="file" name="profile_photo" class="form-control-file" accept="image/*" id="exampleInputFile" aria-describedby="fileHelp">
                                    <small id="fileHelp" class="form-text text-muted">Image should be less then 2mb.</small>
                                </div>
                                <hr>
                        </div>
                        
                    <div class="col-12">
                                <h5>Reference:</h5>
                                <div class="form-group">
                                <input type="text" class="form-control" name="referance_name" placeholder="Referance Name*" data-toggle="tooltip"
                                data-placement="top" title="Referance Name" value="{{$user->referance_name}}" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="referance_phn" placeholder="Referance Phone Number*" data-toggle="tooltip"
                                data-placement="top" title="Referance Phone Number" value="{{$user->referance_phn}}" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="referance_rel" placeholder="Relation with Referance*" data-toggle="tooltip"
                                data-placement="top" title="Relation with Referance*" value="{{$user->referance_rel}}" required>
                            </div>
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

                            <div class="col-12">
                            <h5>Office Info:</h5>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                    <input type="text" data-provide="datepicker" class="form-control" id="join_date" required name="join_date" placeholder="Join Date" title="Join Date" data-toggle="tooltip"
                                    data-placement="top" value="{{$user->join_date}}">
                                </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" required class="form-control" name="designation" placeholder="Designation *" data-toggle="tooltip"
                                data-placement="top" title="designation" value="{{$user->designation}}">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" required class="form-control" name="department" placeholder="Department *" data-toggle="tooltip"
                                data-placement="top" title="Department" value="{{$user->department}}">
                            </div>
                        </div>
                         <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" name="bank_name" class="form-control" placeholder="Bank Name" data-toggle="tooltip"
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
                        </div>

                        <hr>
                        @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                        @foreach($inout_time as $iotime)
                            @if($iotime->user_id == $user->emp_id)
                                @if($iotime->in_time !=null || $iotime->out_time !=null)
                            <div class="col-md-4 col-sm-12">
                            <div class="form-group"> In Time
                      <input type="time" onchange="onTimeChange()" value="{{$iotime->in_time}}" id="timeInput"  name="in_time" class="form-control" placeholder="time in" data-toggle="tooltip"
                         data-placement="top">
                         <input type="hidden" value="{{$iotime->id}}" name="iotime">
                         <input type="hidden" value="{{$iotime->user_id}}" name="iotimeui">
                      </div>
                      </div>
                      <div class="col-md-4 col-sm-12">
                      <div class="form-group"> Out time
                      <input type="time" onchange="onTimeChange()" value="{{$iotime->out_time}}" id="timeInput"  name="out_time" class="form-control" placeholder="time out" data-toggle="tooltip"
                         data-placement="top" >
                      </div>
                      </div>
                      @else
                      <div class="col-md-4 col-sm-12">
                            <div class="form-group"> In Time
                      <input type="time" onchange="onTimeChange()"  id="timeInput"  name="in_time" class="form-control" placeholder="time in" data-toggle="tooltip"
                         data-placement="top">
                         <input type="hidden" value="{{$iotime->id}}" name="iotime">
                         <input type="hidden" value="{{$iotime->user_id}}" name="iotimeui">
                      </div>
                      </div>
                      <div class="col-md-4 col-sm-12">
                      <div class="form-group"> Out time
                      <input type="time" onchange="onTimeChange()"  id="timeInput"  name="out_time" class="form-control" placeholder="time out" data-toggle="tooltip"
                         data-placement="top" >
                      </div>
                      </div>   
                      @endif
                      
                        @endif
                      @endforeach
                        
                      @if(count($holidays)>0)
                      @foreach($holidays as $holiday)
                            @if($holiday->emp_id == $user->emp_id)
                            <div class="col-12 ">
                        <div class="form-group">
                        Holidays
                            <input type="text" data-provide="datepicker" value="{{$holiday->date}}" id="date2" name="dateH" class="form-control" placeholder="select Holidays *" >
                            <input type="hidden" name="hid" value="{{$holiday->id}}">
                            <input type="hidden" name="hidui" value="{{$holiday->emp_id}}">
                        </div>
                        </div>
                        
                            @endif          
                        @endforeach

                        @else
                        <div class="col-12 ">
                        <div class="form-group">
                        Holidays
                            <input type="text" name="dateH" class="datepicker_recurring_start form-control" placeholder="select Holidays *" >
                            <input type="hidden" name="hid" >
                            <input type="hidden" name="hidui" value="{{$user->emp_id}}" >
                        </div>
                        </div>

                      @endif
                      
                    
                      
                      @endif
                      <hr>
                      <br>
                            <div class="col-12 ">
                                    <div class="form-group float-right">
                                    <button type="submit" name="btn" class="btn btn-primary">Update</button>
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




<!-- Default Size -->
<div class="modal animated fadeIn" id="add_user" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title" id="defaultModalLabel">Add User</h6>
                </div>
                <form method="POST" action="{{ route('add-new-user') }}" enctype='multipart/form-data'>
                <div class="modal-body">
                    @csrf
                    <div class="row clearfix">
                    
                    <div class="col-12">
                    <h5>Personal Info:</h5>
                    </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" required placeholder="Name *" data-toggle="tooltip"
                                data-placement="top" title="Name">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="fathers_name" required placeholder="Fathers Name *" data-toggle="tooltip"
                                data-placement="top" title="Fathers Name">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="mothers_name" required placeholder="Mothers Name *" data-toggle="tooltip"
                                data-placement="top" title="Mothers Name">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="present_add" required placeholder="Presents Address *" data-toggle="tooltip"
                                data-placement="top" title="Presents Address">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="parmanent_add" required placeholder="Parmanent Address *" data-toggle="tooltip"
                                data-placement="top" title="Parmanent Address">
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" required placeholder="Email Addess *" data-toggle="tooltip"
                                data-placement="top" title="Email Addess">
                            </div>
                        </div>
                        
                        
                        <!--
                            <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="password" class="form-control" required name="password" data-toggle="tooltip"
                                data-placement="top" title="Password" id="pass" placeholder="Password">
                            </div>
                        </div>
                         <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="password" oninput="checkP(this)" class="form-control" required name="confirm_password" data-toggle="tooltip"
                                data-placement="top" title="Confirm Password" placeholder="Confirm Password">
                            </div>
                        </div>
                        <script language='javascript' type='text/javascript'>
                            function checkP(input) {
                                if (input.value != document.getElementById('pass').value) {
                                    input.setCustomValidity('Password Must be Matching.');
                                } else {
                                    // input is valid -- reset the error message
                                    input.setCustomValidity('');
                                }
                            }
                        </script> 
                        <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <input type="text" name="role" class="form-control" placeholder="Role" data-toggle="tooltip"
                                    data-placement="top" title="Role">
                                </div>
                            </div>
                            -->
                            
                            <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" data-provide="datepicker" name="date_of_birth" class="form-control" placeholder="Date of birth" data-toggle="tooltip"
                                        data-placement="top" title="Date Of Birth">
                                    </div>
                                </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="religion" required placeholder="Religion *" data-toggle="tooltip"
                                    data-placement="top" title="Religion">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="phone_no" placeholder="Phone No *" data-toggle="tooltip"
                                data-placement="top" title="Phone NO">
                            </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="emergency_phone_no" placeholder="Emergency Phone No (in cause)*" data-toggle="tooltip"
                                data-placement="top" title="Emergency Phone No">
                            </div>
                            </div>

                                <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                                <select class="form-control show-tick" required name="blood_group" data-toggle="tooltip"
                                                data-placement="top" title="Blood Group">
                                                        <option value="">Select Blood Group</option>

                                                            <option>A+</option>
                                                            <option>A-</option>
                                                            <option>AB+</option>
                                                            <option>AB-</option>
                                                            <option>B+</option>
                                                            <option>B-</option>
                                                            <option>O+</option>
                                                            <option>O-</option>

                                                    </select>
                                        </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                                <select class="form-control show-tick" required name="gender" data-toggle="tooltip"
                                                data-placement="top" title="Gender">
                                                        <option value="">Select Gender</option>

                                                            <option>Female</option>
                                                            <option>Male</option>
                                                            <option>Other</option>

                                                    </select>
                                        </div>
                                </div>
                                <div class="col-12">
                                <div class="form-group">
                                    <input type="file" name="profile_photo" class="form-control-file" accept="image/*" id="exampleInputFile" aria-describedby="fileHelp">
                                    <small id="fileHelp" class="form-text text-muted">Image should be less then 2mb.</small>
                                </div>
                                <hr>
                        </div>

                        
                        <!-- <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <select class="form-control show-tick" name="user_type">
                                        <option value="" required>Select User Type</option>
                                        @foreach($roles as $role)
                                            @if($role->name !='Super Admin')
                                                <option>{{ $role->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                    <select required class="form-control mb-3 show-tick" name="job_status" data-toggle="tooltip"
                                    data-placement="top" title="Job Status">
                                        <option value="">Select Job Status</option>

                                        <option value="Provision Period" >Provision Period</option>
                                        <option value="Permanent">Permanent</option>

                                    </select>
                                </div> -->
                                <!-- <div class="col-md-4 col-sm-12">
                                        <select required class="form-control mb-3 show-tick" name="gender" data-toggle="tooltip"
                                        data-placement="top" title="Gender">
                                            <option value="">Select Gender</option>

                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>

                                        </select>
                                    </div> -->
                        <div class="col-12">
                                <h5>Reference:</h5>
                                <div class="form-group">
                                <input type="text" class="form-control" name="referance_name" placeholder="Referance Name*" data-toggle="tooltip"
                                data-placement="top" title="Referance Name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="referance_phn" placeholder="Referance Phone Number*" data-toggle="tooltip"
                                data-placement="top" title="Referance Phone Number" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="referance_rel" placeholder="Relation with Referance*" data-toggle="tooltip"
                                data-placement="top" title="Relation with Referance*" required>
                            </div>
                                <hr>
                        </div>

                        <div class="col-12">
                            <h5>Office Uses:</h5>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                    <input type="text" data-provide="datepicker" class="form-control" id="join_date" required name="join_date" placeholder="Join Date" title="Join Date" data-toggle="tooltip"
                                    data-placement="top">
                                </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="number" required class="form-control" name="emp_id" placeholder="Employee ID (Only Number) *" data-toggle="tooltip"
                                data-placement="top" title="Employee Id (Only Number)" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" required class="form-control" name="designation" placeholder="Designation *" data-toggle="tooltip"
                                data-placement="top" title="designation">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" required class="form-control" name="department" placeholder="Department *" data-toggle="tooltip"
                                data-placement="top" title="Department">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" name="bank_name" class="form-control" placeholder="Bank Name"data-toggle="tooltip"
                                    data-placement="top" title="Bank Name" >
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" name="branch" class="form-control" placeholder="Branch"data-toggle="tooltip"
                                    data-placement="top" title="Branch">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <input type="text" name="bank_ac" class="form-control" placeholder="Bank A/C No"data-toggle="tooltip"
                                    data-placement="top" title="Bank A/C No" >
                            </div>
                        </div>
                        <div class="col-12">

                            <hr>
                    </div>

                        <!-- <div class="col-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="facebook_link" placeholder="Facebook"data-toggle="tooltip"
                                    data-placement="top" title="Facebook">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="twitter_link" placeholder="Twitter"data-toggle="tooltip"
                                    data-placement="top" title="Twitter">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="linkedin_id" placeholder="Linkedin"data-toggle="tooltip"
                                    data-placement="top" title="Linkedin">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="git_link" placeholder="Git"data-toggle="tooltip"
                                    data-placement="top" title="Git">
                                </div>
                            </div> -->
                            <hr>
                            <div class="col-md-4 col-sm-12">
                            <div class="form-group"> In Time
                      <input type="time" onchange="onTimeChange()" value="onTimeChange()" id="timeInput"  name="in_time" class="form-control" placeholder="time in" data-toggle="tooltip"
                         data-placement="top" >
                      </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                      <div class="form-group"> Out time
                      <input type="time" onchange="onTimeChange()" value="onTimeChange()" id="timeInput"  name="out_time" class="form-control" placeholder="time out" data-toggle="tooltip"
                         data-placement="top" >
                      </div>
                      </div>
                      <div class="col-12">
                      <div class="form-group">
                      
                          <input type="text" class="datepicker_recurring_start form-control" id="date" name="dateH" placeholder="select Holidays *">
                      
                      </div>
                            </div>
                      <hr>
                      

                            <div class="col-12 ">
                                    <div class="form-group float-right">
                                        <button type="submit" name="btn" class="btn btn-primary">Add</button>
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

        {{-- <script>
                $('#searchEmp').change(function() {
                    window.location = $(':selected', this).attr('href')
                });

            </script> --}}
<div class="modal animated lightSpeedIn" id="import" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title" id="defaultModalLabel">import employee</h6>
                </div>
                <div class="col-md-12">
                  <form class="form-group" action="{{ route('importemp') }}" enctype="multipart/form-data" method="post">
                    @csrf
                  <input type="file" name="file" accept=".xls">
                </div>

                <div class="col-12 ">
                            <div class="form-group float-right">
                                <button type="submit" name="import" value="import" class="btn btn-primary">import</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                            </div>
                </div>
                </form>
          <!--       <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                </div> -->
            </div>
        </div>
    </div>
@endsection
