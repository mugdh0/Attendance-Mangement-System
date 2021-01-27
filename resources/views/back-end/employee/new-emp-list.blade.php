
@extends('back-end.master')
@section('title')
New Employee List
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

                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                        <ul class="header-dropdown">
                            <li><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#addcontact">Add New</a></li>
                        </ul>
                        @endif
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example dataTable table-custom table-striped m-b-0 c_list">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>
                                            <label class="fancy-checkbox">
                                               <!--    <input class="select-all" type="checkbox" name="checkbox"> -->
                                               <span></span>
                                           </label>
                                       </th>
                                       <th>Name</th>
                                       @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                       <th>Emp ID</th>
                                       <th>Phone</th>
                                       <th>Join Date</th>
                                       @endif
                                       <th>Role</th>
                                       <!-- <th>Department</th> -->
                                       @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                       <th>Action</th>
                                       @endif
                                   </tr>
                               </thead>
                               <tbody>
                                @foreach($userList as $user)
                                <tr>
                                    <td class="width45">
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
                                        <td><a href="{{ route('view-user-details',['id'=>$user->id,'name'=>$user->name]) }}">
                                                <h6 class="mb-0">{{$user->name}}</h6>
                                                <span>{{$user->email}}</span></a>
                                            </td>
                                            @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                            <td><span>{{$user->emp_id}}</span></td>
                                            <td><span>{{$user->phone_no}}</span></td>
                                            <td>

                                                @if($user->join_date)
                                                {{Carbon\Carbon::parse($user->join_date)->format('Y-m-d')}}

                                                @endif
                                            </td>
                                            @endif
                                            <td>{{$user->role}}</td>
                                            <td>{{$user->dept_name}}</td>
                                        @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                            <td>
                                              <span data-toggle="modal" data-target="#editEmp-{{$user->id}}">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                            </span>
                                            @if(Auth::user()->hasRole(['Super Admin']))
                                                <a href="{{ route('delete-emp',['id'=>$user->id,'name'=>$user->name]) }}" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-type="confirm"><i class="fa fa-trash-o"></i></a>
                                            @endif
                                        </td>

                                        @endif
                                    </tr>









                                    <!-- Edit EMP -->
                                    <div class="modal animated zoomIn" id="editEmp-{{$user->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="title" >Edit Contact</h6>
                                                </div>
                                                <form method="POST" action="{{ route('edit-emp-info') }}" enctype='multipart/form-data'>
                                                    <div class="modal-body">
                                                            @csrf
                                                            <div class="row clearfix">
                                                                <div class="col-md-4 col-sm-12">
                                                                    <div class="form-group">
                                                                    <input type="text" required class="form-control" value="{{$user->name}}" data-toggle="tooltip" data-placement="top" name="name" placeholder="Name *" title="Name *">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-12">
                                                                    <div class="form-group">
                                                                        <input type="email" required class="form-control" value="{{$user->email}}" data-toggle="tooltip" data-placement="top" readonly placeholder="Email ID *" title="Email ID *">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-12">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" value="{{$user->phone_no}}" data-toggle="tooltip" data-placement="top" name="phone_no" placeholder="Phone No *"title="Phone No *" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-12">
                                                                    <div class="form-group">
                                                                            <input type="text" required class="form-control" value="@if($user->join_date){{Carbon\Carbon::parse($user->join_date)->format('Y-m-d')}}@endif " name="join_date" placeholder="Join Date" title="Join Date" data-toggle="tooltip"
                                                                            data-placement="top">
                                                                        </div>
                                                                </div>


                                                                <div class="col-md-4 col-sm-12">
                                                                        <div class="form-group">
                                                                            <input type="text" required value="{{$user->role}}" data-toggle="tooltip" data-placement="top" name="role" class="form-control" placeholder="Role" title="Role">
                                                                        </div>
                                                                    </div>

                                                                <!-- <div class="col-md-4 col-sm-12">
                                                                    <div class="form-group">
                                                                        <select class="form-control show-tick" data-toggle="tooltip" data-placement="top" name="dept_name" title="Dept Name">
                                                                            <option value="" required>Select Department Type</option>
                                                                            @foreach($obj_dept as $dept)
                                                                                <option value="{{$dept->dept_name}}" {{ $dept->dept_name==$user->dept_name ? 'Selected' : ''}} >{{ $dept->dept_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div> -->
                                                                <div class="col-md-4 col-sm-12">
                                                                        <div class="form-group">
                                                                        <input type="text" value="{{ $user->date_of_birth }}" data-provide="datepicker" name="date_of_birth" class="form-control" placeholder="Date of birth">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12">
                                                                            <div class="form-group">
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
                                                                        <input type="text" required class="form-control"value="{{$user->emp_id}}" data-toggle="tooltip" data-placement="top" readonly placeholder="Employee ID *" title="Employee ID">
                                                                        <input type="hidden" value="{{$user->id}}" name="user_id" >
                                                                    </div>
                                                                </div>

                                                                    <div class="col-md-4 col-sm-12">
                                                                            <select class="form-control mb-3 show-tick" data-toggle="tooltip" data-placement="top" name="job_status" title="Job Status">
                                                                                <option value="" required>Select Job Status</option>

                                                                                <option {{ $user->job_status=='Provision Period' ? 'Selected' : ''}}  value="Provision Period" >Provision Period</option>
                                                                                <option value="Permanent" {{ $user->job_status=='Permanent' ? 'Selected' : ''}} >Permanent</option>

                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4 col-sm-12">
                                                                                <select class="form-control mb-3 show-tick" data-toggle="tooltip" data-placement="top" name="gender" title="Gender">
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
                                                                        <input type="text" class="form-control" value="{{$user->facebook_link}}" data-toggle="tooltip" data-placement="top" name="facebook_link" placeholder="Facebook" title="Facebook">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" value="{{$user->twitter_link}}" data-toggle="tooltip" data-placement="top" name="twitter_link" placeholder="Twitter"  title="Twitter">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" value="{{$user->linkedin_link}}" data-toggle="tooltip" data-placement="top" name="linkedin_id" placeholder="Linkedin" title="Linkedin">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" value="{{$user->git_link}}" data-toggle="tooltip" data-placement="top" name="git_link" placeholder="Git" title="Git">
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
                                                        {{-- <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary">Add</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                                        </div> --}}
                                                    </div>
                                                </form>
          <!--   <div class="modal-footer">

          </div> -->
      </div>
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
<div class="modal animated zoomIn" id="addcontact" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel">Add Contact</h6>
            </div>
            <form method="POST" action="{{ route('add-new-emp') }}" enctype='multipart/form-data'>
                <div class="modal-body">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" required placeholder="Name *">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" required placeholder="Email ID *">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="phone_no" placeholder="Phone No *">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                        <input type="text" data-provide="datepicker" required class="form-control" id="join_date" name="join_date" placeholder="Join Date" title="Join Date" data-toggle="tooltip"
                                        data-placement="top">
                                    </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <input type="password" class="form-control" required name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <input type="password" class="form-control" required name="confirm_password" placeholder="Confirm Password">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <input type="text" name="role" required class="form-control" placeholder="Role">
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <input type="text" data-provide="datepicker" name="bate_of_birth" class="form-control" placeholder="Date of birth">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                    <select class="form-control show-tick" required name="blood_group">
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

                            <!-- <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <select class="form-control show-tick" required name="dept_name">
                                        <option value="">Select Department Type</option>
                                        @foreach($obj_dept as $dept)
                                            <option>{{ $dept->dept_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="emp_id" placeholder="Employee ID *">
                                </div>
                            </div>

                                <div class="col-md-4 col-sm-12">
                                        <select class="form-control mb-3 show-tick" required name="job_status">
                                            <option value="">Select Job Status</option>

                                            <option value="Provision Period" >Provision Period</option>
                                            <option value="Permanent">Permanent</option>

                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                            <select class="form-control mb-3 show-tick" required name="gender">
                                                <option value="">Select Gender</option>

                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>

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
                                        <input type="text" class="form-control" name="facebook_link" placeholder="Facebook">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="twitter_link" placeholder="Twitter">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="linkedin_id" placeholder="Linkedin">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="git_link" placeholder="Git">
                                    </div>
                                </div>


                                <div class="col-12 ">
                                        <div class="form-group float-right">
                                            <input type="submit" name="btn" value="Add" class="btn btn-primary">
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
          <!--   <div class="modal-footer">

          </div> -->
      </div>
  </div>
</div>



@endsection
