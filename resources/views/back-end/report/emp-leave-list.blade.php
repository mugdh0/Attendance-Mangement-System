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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Leave Request</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Employee</li>
                            <li class="breadcrumb-item active">Leave Request</li>
                        </ul>
                    </div>            

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>Employee Leave List</h2>&nbsp;
           

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

                            <ul class="header-dropdown">
                                    @if(Auth::user()->hasRole('Super Admin'))
                                    <li><a href="javascript:void(0);" class="btn-default" data-toggle="modal" data-target="#update_paid_leave"><i title="Update Paid Leave" data-toggle="tooltip"
                                        data-placement="top" class="fas fa-sync-alt" style="color:#f58c1f"></i></a></li>

                                {{-- <li><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#update_paid_leave">Update Paid Leave</a></li> --}}
                                @endif
                                @if(Auth::user()->hasRole(['Employee', 'Admin']))
                                {{-- <li><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#Leave_Request">Add Leave</a></li> --}}
                                <li><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#Leave_Request"><i data-toggle="tooltip" data-placement="top" title="Add Leave Request" style="color:#f58c1f" class="fas fa-plus"></i></a></li>
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
                                            <th>Status</th>
                                            @if(Auth::user()->hasRole('Super Admin'))
                                                <th>Action</th>
                                           
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>

@foreach($allLeaveRequest as $leaveRequest)

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
                                            <td>{{ $leaveRequest->start_date }} to {{ $leaveRequest->end_date }}</td>
                                            <td>{{ $leaveRequest->reason }}</td>

                                            <td><span class="

                                        @if($leaveRequest->status=='Accepted(paid)' )  badge badge-success 
                                        @elseif($leaveRequest->status=='Accepted(unpaid)')  badge badge-info 
                                        @elseif($leaveRequest->status=='Waiting')  badge badge-warning 
                                        @elseif($leaveRequest->status=='Rejected')  badge badge-danger 
                                        @endif"


                                        >{{ $leaveRequest->status }}</span></td>


                                            @if(Auth::user()->hasRole('Super Admin'))
                                            <td>

                <span data-toggle="modal" data-target="#ApprovedReq-{{$leaveRequest->id}}">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-success" title="Approved" data-toggle="tooltip" data-placement="top"><i  class="fa fa-check"></i></a>
                </span>


                
                                                <a href="{{ route('reject-leave-request',['id'=>$leaveRequest->id,'name'=>$leaveRequest->name])}}" class="btn btn-sm btn-outline-danger " title="Declined" data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fa fa-ban"></i></a>
                                            </td>
     
                                            @endif
                                        </tr>






<!-- Approve -->
<div class="modal animated bounceIn" id="ApprovedReq-{{$leaveRequest->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title">Add Departments</h6>
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
  
<!--             <div class="modal-footer">
                <button type="button" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
            </div> -->
        </div>
    </div>
</div>










@endforeach
                                    </tbody>
                                </table>
                            </div>


                            <br/>&nbsp;
                            <div class="row rounded" style="background-color:#daedf2;">
                                    &nbsp;
                                <div class="col-md-8 offset-4 ">
                                <h6>Total Paid Leave: &nbsp;&nbsp;{{$totalPaidLeave->paid_leave_amount}} days</h6>
                                <h6>You have Remain: {{$totalPaidLeave->paid_leave_amount -$allPaidLeave}} days</h6>
                          
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
                <h6 class="title" id="defaultModalLabel">Add Leave Request</h6>
            </div>
             <form method="POST" action="{{ route('send-emp-leave-request') }}">
                @csrf
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <select required class="form-control mb-3 show-tick" name="leave_type">
                            <option value="">Select Leave Type</option>
                            <option>Casual Leave</option>
                            <option>Medical Leave</option>
                            <option>Maternity Leave</option>
                            <option>Others</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input required type="text" data-provide="datepicker" name="start_date" data-date-autoclose="true" class="form-control" placeholder="From *">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input required type="text" data-provide="datepicker" name="end_date" data-date-autoclose="true" class="form-control" placeholder="To *">
                            <input type="hidden" name="status" value="Waiting">

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea rows="6" name="reason" class="form-control no-resize" placeholder="Leave Reason *"></textarea>
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
            </form>
      <!--       <div class="modal-footer">
                <button type="button" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
            </div> -->
        </div>
    </div>
</div>








<!-- userPasswordChange -->
<div class="modal animated fadeIn" id="update_paid_leave" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title">Change Paid Leave Amount</h6>
                </div>
                <form method="POST" action="{{ route('update_paid_leave') }}" enctype='multipart/form-data'>
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
