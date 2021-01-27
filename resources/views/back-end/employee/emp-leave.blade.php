@extends('back-end.master')
@section('title')
EMS employee Leave
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Manage Leave</h2>
                        <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Employee</li>
                            <li class="breadcrumb-item active">Manage Leave</li>
                        </ul>
                    </div>

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>Leave List</h2>&nbsp;

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
                        @if(Session::get('danger'))
                        <div class="alert alert-danger" id="message">
                            <h6 class=" text-center text-danger"> {{ Session::get('danger') }}</h6>
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


                        <!-- <div id="IdForTaggle" style="display: none;">
                                <br/>&nbsp;
                              <form method="POST" action="{{ route('filter-leave-request') }}" enctype='multipart/form-data'>
                                @csrf
                            <div class="row" >
                                <div class="col-md-2">

                                        <select class="form-control show-tick" data-toggle="tooltip"
                                         name="leave_type" title="Leave Type">

                                        <option value="">Select Leave Type</option>
                                        <option>Casual Leave</option>
                                        <option>Medical Leave</option>
                                        <option>Maternity Leave</option>
                                        <option>Others</option>

                                    </select>
                                </div>

                                <div class="col-md-2">
                                        <select class="form-control show-tick" name="emp_name"data-toggle="tooltip"
                                        title="Employee Name" data-placement="top">
                                        <option value="">Select Name</option>
                                        @foreach($userList as $u)
                                          @if($u->role == "Super Admin")

                                          @else
                                          <option>{{$u->name}} </option>

                                          @endif
                                        @endforeach

                                    </select>

                                </div>
                                <div class="col-md-2">
                                        <select class="form-control show-tick" name="status" title="Status"data-toggle="tooltip"
                                        data-placement="top">
                                        <option value="">Select Status</option>
                                        <option>Waiting</option>
                                        <option>Accepted(paid)</option>
                                        <option>Accepted(unpaid)</option>
                                        <option>Rejected</option>

                                    </select>
                                </div>
                                <div class="col-md-2">
                                        <input type="text" data-provide="datepicker" class="form-control" name="start_date" placeholder="Start Date" title="Start Date" data-toggle="tooltip"
                                        data-placement="top">
                                </div>

                                    <div class="center">
                                            <p>To</p>
                                        </div>
                                <div class="col-md-2">
                                        <input type="text" data-provide="datepicker" class="form-control" name="end_date" placeholder="End Date" title="End Date" data-toggle="tooltip"
                                        data-placement="top">
                                </div>



                                <div class="col-md-1">
                                    <input type="submit" class="btn btn-success" name="btn" value="OK">
                                </div>
                            </div>
                        </form>
                        </div> -->





                        <div id="IdForTaggle2" style="display: none;">
                                <br/>&nbsp;
                              <form method="POST" action="{{ route('filter-leave-request-emp') }}" enctype='multipart/form-data'>
                                @csrf
                            <div class="row" >
                                <div class="col-md-2">

                                        <select class="form-control show-tick" data-toggle="tooltip"
                                        data-placement="top" name="leave_type" title="Leave Type">

                                        <option value="">Select Leave Type</option>
                                        <option>Casual Leave</option>
                                        <option>Medical Leave</option>
                                        <option>Maternity Leave</option>
                                        <option>Others</option>

                                    </select>
                                        {{-- <input type="text"  class="form-control" placeholder="Role" title="Role"> --}}
                                </div>

                                <div class="col-md-2">
                                        <select class="form-control show-tick" name="status" title="Status"data-toggle="tooltip"
                                        data-placement="top">
                                        <option value="">Select Status</option>
                                        <option>Waiting</option>
                                        <option>Accepted</option>
                                        <option>Rejected</option>

                                    </select>
                                </div>
                                <div class="col-md-2">
                                        <input type="text" data-provide="datepicker" class="form-control" name="start_date" placeholder="Start Date" title="Start Date" data-toggle="tooltip"
                                        data-placement="top">
                                </div>

                                    <div class="center">
                                            <p>To</p>
                                        </div>
                                <div class="col-md-2">
                                        <input type="text" data-provide="datepicker" class="form-control" name="end_date" placeholder="End Date" title="End Date" data-toggle="tooltip"
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
                                <li><a href="javascript:void(0);" class="btn-default" data-toggle="modal" data-target="#update_paid_leave"><i title="Update Paid Leave" data-toggle="tooltip"
                                    data-placement="top" class="fas fa-sync-alt" style="color:#f58c1f"></i></a></li>
                                    <li><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#Leave_Request"><i data-toggle="tooltip" data-placement="top" title="Add Leave" style="color:#f58c1f" class="fas fa-plus"></i></a></li>
                                    <!-- <li><a href="javascript:void(0);" onclick="btnToggleFunction()" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" class="btn btn-info"><i data-toggle="tooltip" data-placement="top" title="Filter" style="color:#f58c1f" class="fas fa-filter"></i></a></li> -->

                                @endif
                                @if(Auth::user()->hasRole(['Employee']))
                                 <li><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#Leave_Request">Add Leave</a></li>
                                <li><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#Leave_Request"><i data-toggle="tooltip" data-placement="top" title="Add Leave Request" style="color:#f58c1f" class="fas fa-plus"></i></a></li>
                                <li><a href="javascript:void(0);" onclick="btnToggleFunction2()" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" class="btn btn-info"><i data-toggle="tooltip" data-placement="top" title="Filter" style="color:#f58c1f" class="fas fa-filter"></i></a></li>

                                @endif
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0 c_list">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Employee ID</th>
                                            <th>Leave Type</th>
                                            <th>Date</th>
                                            <th>Reason</th>
                                            <th>Day count</th>
                                            <th>Status</th>
                                            @if(Auth::user()->hasRole(['Super Admin','Admin']))
                                                <th>Action</th>

                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>

@foreach($allLeave as $leaveRequest)

                                        <tr>
                                            <td class="width45">

                                                @if($leaveRequest->profile_photo)

                                                <img src="{{asset($leaveRequest->profile_photo)}}" class="rounded-circle avatar" alt="">
                                                @else
                                                <img src="{{asset('images/nobody_m.original.jpg')}}" class="rounded-circle avatar" alt="">
                                                @endif

                                            </td>
                                            <td>

                                                <h6 class="mb-0">{{ $leaveRequest->name }}</h6>
                                            </td>
                                            <td><span>{{ $leaveRequest->emp_id }}</span></td>
                                            <td><span>{{ $leaveRequest->leave_type }}</span></td>

                                            
                                            <?php 
                                                if($leaveRequest->leave_dates == 0){
                                                    $date = "N/A";
                                                }else{
                                                    $date = explode(",",$leaveRequest->leave_dates);
                                                }
                                            ?>
                                            <td>
                                            @if($date == 0)
                                                N/A
                                            @else
                                                @foreach($date as $dt)
                                                        {{$dt}} [{{\Carbon\Carbon::parse($dt)->format('l')}}]<br>
                                                    @endforeach
                                                @endif
                                            </td>

                                            <td>{{ $leaveRequest->reason }}</td>
                                            <td>{{ $leaveRequest->leave_for }}</td>


                                            <td><span class="

                                        @if($leaveRequest->status=='Accepted' )  badge badge-success
                                        @elseif($leaveRequest->status=='Waiting')  badge badge-warning
                                        @elseif($leaveRequest->status=='Rejected')  badge badge-danger
                                        @endif"


                                        >{{ $leaveRequest->status }}</span></td>


                                            @if(Auth::user()->hasRole(['Super Admin','Admin']))
                                            <td>

                                            @if($leaveRequest->status=='Accepted' ) 
                                            <span data-toggle="modal" data-target="#editLeavef-{{$leaveRequest->id}}">
                                                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                              </span>
                                              <a href="{{ route('reject-leave-request',['id'=>$leaveRequest->id,'name'=>$leaveRequest->name])}}" class="btn btn-sm btn-outline-danger " title="Declined" data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fa fa-ban"></i></a>
                                        
                                        @elseif($leaveRequest->status=='Waiting')
                                        <span data-toggle="modal" data-target="#editLeave-{{$leaveRequest->id}}">
                                                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="Approve"><i class="fa fa-check"></i></a>
                                              </span>
                                              <a href="{{ route('print-leave-preview',['id'=>$leaveRequest->id,'name'=>$leaveRequest->name,'uid'=>$leaveRequest->emp_id])}}" class="btn btn-sm btn-outline-info " title="Print" data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fas fa-print"></i></a>
                                            
                                        @elseif($leaveRequest->status=='Rejected')  
                                        <span data-toggle="modal" data-target="#editLeave-{{$leaveRequest->id}}">
                                                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="Approve"><i class="fa fa-check"></i></a>
                                              </span>

                                        @endif

                <!-- <span data-toggle="modal" data-target="#ApprovedReq-{{$leaveRequest->id}}">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-success" title="Approved" data-toggle="tooltip" data-placement="top"><i  class="fa fa-check"></i></a>
                </span> -->

                                                
                                                
                                            </td>

                                            @endif
                                        </tr>
<div class="modal animated fadeIn" id="editLeavef-{{$leaveRequest->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title">Edit leave</h6>
            </div>

                <div class="modal-body">
                  <form method="POST" action="{{ route('update-emp-leave-request2') }}">
                     @csrf
                 <div class="modal-body">
                     <div class="row clearfix">
                         <div class="col-md-12">
                           <select required class="form-control mb-3 show-tick" name="leave_to">
                           <option>{{$leaveRequest->id}} {{$leaveRequest->emp_id}} ({{$leaveRequest->name}})</option>


                       </select>
                            
                             <select required class="form-control mb-3 show-tick" name="leave_type" >
                                 <option value="">Select Leave Type</option>
                                 <option>Casual Leave</option>
                                 <option>Medical Leave</option>
                                 <option>Maternity Leave</option>
                                 <option>Others</option>
                             </select>
                         </div>
                         <div class="col-md-12">
                         <div class="form-group">
                            <input type="text" class="datepicker_recurring_start form-control" value ="{{$leaveRequest->leave_dates}}"  name="leave_dates" placeholder="select leaves *">
                      

                            </div>
                         </div>
                         <div class="col-md-12">
                             <div class="form-group">
                                 <textarea rows="6" name="reason" class="form-control no-resize" placeholder="Leave Reason *">{{ $leaveRequest->reason }}</textarea>
                             </div>
                         </div>
                         <div class="col-12 ">
                                     <div class="form-group float-right">
                                     <button type="submit" name="btn" class="btn btn-primary">Update</button>
                                         <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                     </div>
                         </div>
                     </div>
                 </div>
                 </form>
                </div>

<!--             <div class="modal-footer">
                <button type="button" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
            </div> -->
        </div>
    </div>
</div>
<div class="modal animated fadeIn" id="editLeave-{{$leaveRequest->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title">Edit leave</h6>
            </div>

                <div class="modal-body">
                  <form method="POST" action="{{ route('update-emp-leave-request') }}">
                     @csrf
                 <div class="modal-body">
                     <div class="row clearfix">
                         <div class="col-md-12">
                           <select required class="form-control mb-3 show-tick" name="leave_to">
                           <option>{{$leaveRequest->id}} {{$leaveRequest->emp_id}} ({{$leaveRequest->name}})</option>


                       </select>

                             <select required class="form-control mb-3 show-tick" name="leave_type" >
                                 <option value="">Select Leave Type</option>
                                 <option>Casual Leave</option>
                                 <option>Medical Leave</option>
                                 <option>Maternity Leave</option>
                                 <option>Others</option>
                             </select>
                         </div>
                         <div class="col-md-12">
                         <div class="form-group">
                            <input type="text" class="datepicker_recurring_start form-control" value ="{{$leaveRequest->leave_dates}}"  name="leave_dates" placeholder="select leaves *">
                      

                            </div>
                         </div>
                         <div class="col-md-12">
                             <div class="form-group">
                                 <textarea rows="6" name="reason" class="form-control no-resize" placeholder="Leave Reason *">{{ $leaveRequest->reason }}</textarea>
                             </div>
                         </div>
                         <div class="col-12 ">
                                     <div class="form-group float-right">
                                     <button type="submit" name="btn" class="btn btn-primary">Update</button>
                                         <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                     </div>
                         </div>
                     </div>
                 </div>
                 </form>
                </div>

<!--             <div class="modal-footer">
                <button type="button" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
            </div> -->
        </div>
    </div>
</div>

<!-- Approve -->
<!-- <div class="modal animated fadeIn" id="ApprovedReq-{{$leaveRequest->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title">Approve leave</h6>
            </div>

                <div class="modal-body">
                    <div class="row clearfix">
<div class="col-md-2"></div>

                        <div class="col-md-4">
<a href="{{ route('accept-leave-request-with-paid',['id'=>$leaveRequest->id,'name'=>$leaveRequest->name])}}" class="btn btn-sm btn-outline-warning"data-toggle="tooltip" data-placement="top" title="Approved But paid"><i class="fa fa-check"></i>Paid</a>
                        </div>
                        <div class="col-md-4">
<a href="{{ route('accept-leave-request-with-unpaid',['id'=>$leaveRequest->id,'name'=>$leaveRequest->name])}}" class="btn btn-sm btn-outline-success"data-toggle="tooltip" data-placement="top" title="Approved But Unpaid"><i class="fa fa-check">Unpaid</i></a>
                        </div>
<div class="col-md-2"></div>
                        <div class="col-12 ">
                            <div class="form-group float-right">

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
            </div> 
        </div>
    </div>
</div> -->









@endforeach
                                    </tbody>
                                </table>
                            </div>


                            <p> </p>
                            @if(Auth::user()->hasRole('Employee'))
                                <p> </p>
                            @endif

                        <br/>&nbsp;
                         <div class="row rounded" style="background-color:#daedf2;">
                                &nbsp;
                            <div class="col-md-8 offset-4 ">
                            <h6>Total Paid Leave: &nbsp;&nbsp;{{$totalPaidLeave->paid_leave_amount}} days</h6>

                            </div>&nbsp;
                        </div>






                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Default Size -->
<div class="modal animated lightSpeedIn" id="Leave_Request" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel">Generate Leave</h6>
            </div>
             <form method="POST" action="{{ route('generate-emp-leave') }}">
                @csrf
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-12">
                      <select required class="form-control mb-3 show-tick" name="leave_to">
                      <option value="">Select User</option>
                      @foreach($userList as $u)
                        @if($u->role == "Super Admin")

                        @else
                        <option>{{$u->emp_id}} ( {{$u->name}} )</option>

                        @endif
                      @endforeach

                  </select>

                        
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group warning">
                            <b>Properties will be Added:</b>
                            <p style="color:red; margin-left:20px;" >*total leave <br>
                            *taken leave <br>
                            *remain leave <br>
                            *last taken leave</p>
                        </div>
                    </div>
                    <div class="col-12 ">
                                <div class="form-group float-right">
                                    <button type="submit" name="btn" class="btn btn-primary">Generate</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                </div>
                    </div>
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








<!-- AcceptReq -->
<div class="modal animated fadeIn" id="update_paid_leave" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title">Change Paid Leave Amount</h6>
                </div>
                <form method="POST" action="{{ route('emp_update_paid_leave') }}" enctype='multipart/form-data'>
                <div class="modal-body">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                            <input type="number" class="form-control" name="paid_leave_amount" placeholder="Amount of paid leave *">

                            </div>
                        </div>



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





@endsection
