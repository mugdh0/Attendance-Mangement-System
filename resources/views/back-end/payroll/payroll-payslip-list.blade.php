   
@extends('back-end.master')
@section('title')
EMS payroll
@endsection
@section('statusPayroll')
active
@endsection
@section('content')
 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Payslip</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Payroll</li>
                            <li class="breadcrumb-item active">Payslip</li>
                        </ul>
                    </div>            

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">


                            <div class="header">

                                    {{-- <h2>Employee List</h2> --}}
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
            
                                    @if(Auth::user()->hasRole('Super Admin'))

                                    
                                    <div id="IdForTaggle" style="display: none;">
                                        <br/>&nbsp;
                                          <form method="POST" action="{{ route('filter-payslip-by-superadmin') }}" enctype='multipart/form-data'>
                                            @csrf
                                        <div class="row" >
                                          
                                            <div class="col-md-3">
                                                    <select class="form-control mb-3 show-tick" name="dept">
                                
                                                            <option value="null">Select Department</option>
                                                            @foreach($obj_dept as $dept)
                                                            <option value="{{$dept->dept_name}}">{{$dept->dept_name}}</option>
                                                        @endforeach
                                                        </select>
                                            </div>
                                            <div class="col-md-3">
                                                    <select class="form-control mb-3 show-tick" name="role">
                                
                                                            <option value="null">Select Role</option>
                                                        @foreach($obj_role as $role)
                                                        @if($role->role!=null)
                                                            <option>{{$role->role}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                            </div>
                                            <div class="col-md-2">
                                                    <select class="form-control mb-3 show-tick" name="year">
                                
                                                            <option value="null">Select Year</option>
                                                        @for($i=2010;$i<=Carbon\Carbon::now()->format('Y');$i++ )
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                            </div>
                                            <div class="col-md-2">
                                                    <select class="form-control mb-3 show-tick" name="month">
                                
                                                            <option value="null">Select Month</option>
                                                        
                                                            <option value="1">January</option>
                                                            <option value="2">February</option>
                                                            <option value="3">March</option>
                                                            <option value="4">April</option>
                                                            <option value="5">May</option>
                                                            <option value="6">June</option>
                                                            <option value="7">July</option>
                                                            <option value="8">August</option>
                                                            <option value="9">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">Deember</option>
                                                        
                                                    </select>
                                            </div>
            
                                            <div class="col-md-2">
                                                <input type="submit" class="btn btn-success" name="btn" value="Search">
                                            </div>
                                        </div>
                                    </form>
                                    </div>
            
                                    <ul class="header-dropdown">
                                        {{-- <li><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#addNewIncome">Add New</a></li> --}}
            
                                        {{-- <li><a href="javascript:void(0);" onclick="btnToggleFunction()" class="btn btn-info">Filter</a></li> --}}
                                        <li><a href="javascript:void(0);" onclick="btnToggleFunction()" class="btn-default" style="padding: 0px 6px;font-size: 12px;" class="btn btn-info"><i data-toggle="tooltip" data-placement="top" title="Filter" style="color:#f58c1f" class="fas fa-filter"></i></a></li>
                       

                                    </ul>


@else




<div id="IdForTaggle2" style="display: none;">
        <br/>&nbsp;
      <form method="POST" action="{{ route('filter-payslip-by-employee') }}" enctype='multipart/form-data'>
        @csrf
    <div class="row" >
        <div class="col-md-2">

        </div>
        <div class="col-md-3">
                <select class="form-control mb-3 show-tick" name="year">
                                
                        <option value="null">Select Year</option>
                    @for($i=2010;$i<=Carbon\Carbon::now()->format('Y');$i++ )
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
        </div>
        <div class="col-md-3">
                <select class="form-control mb-3 show-tick" name="month">
                                
                        <option value="null">Select Month</option>
                    
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">Deember</option>
                    
                </select>
        </div>

        <div class="col-md-2">
            <input type="submit" class="btn btn-success" name="btn" value="Search">
        </div>
    </div>
</form>
</div>

<ul class="header-dropdown">
    {{-- <li><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#addNewIncome">Add New</a></li> --}}
    <li><a href="javascript:void(0);" onclick="btnToggleFunction2()" class="btn-default" style="padding: 0px 6px;font-size: 12px;" class="btn btn-info"><i data-toggle="tooltip" data-placement="top" title="Filter" style="color:#f58c1f" class="fas fa-filter"></i></a></li>
    {{-- <li><a href="javascript:void(0);" onclick="btnToggleFunction2()" class="btn btn-info">Filter</a></li> --}}
</ul>

    @endif
                                </div>


                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Year</th>
                                            <th>Month</th>
                                            <th>Name</th>
                                            <th>Basic Salary</th>
                                            <th>Payment</th>
                                            <th>Confirmation Status</th>
                                            <th>Confirmation Message</th>
                                            <th>Notification Status</th>
                                      
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

@foreach($obj_payslip as $payslip)


                                        <tr>
<td></td>
                                            <td> 
                                            <span>{{$payslip->created_at->year}}</span>
                                            </td>
                                        <td><span> {{Carbon\Carbon::parse($payslip->created_at)->format('F') }}
                                            {{-- {{$payslip->created_at->month}} --}}
                                        </span></td>
                                        
                                            
                                            <td>{{$payslip->employee_name}}</td>
                                            
                                            <td>{{$payslip->basic_salary}}</td>
                                            <td>{{$payslip->payment_status}}</td>
                                            <td>{{$payslip->confirmation_status}}</td>
                                            <td>{{$payslip->emp_comment}}</td>
                                            <td>{{$payslip->notification_status}}</td>
                                            <td>

                                                <a href="{{ route('view-payslip-details',['email'=>$payslip->employee_email,'name'=>$payslip->employee_name,'id'=>$payslip->id])}}" class="btn btn-sm btn-outline-info" title="View"  data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fa fa-eye"></i></a>
                                                {{-- <button type="button" class="btn btn-sm btn-outline-danger" title="Not Confirm" data-type="confirm"><i class="fa fa-ban"></i></button> --}}
                                                @if(Auth::user()->hasRole(['Employee', 'Admin']))
                                                @if($payslip->confirmation_status=='Not Confirm' && $payslip->payment_status == "Paid")
                                               
                                                <span data-toggle="modal" data-target="#confirmation-msg-{{$payslip->id}}">
                                                    <a href="javascript:void(0);"class="btn btn-sm btn-outline-success" title="Confirm"  data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fa fa-check"></i></a>
                                                <span>
                                                @else
                                                <a href="javascript:void(0);"class="btn btn-sm btn-outline-secondary" title="Confirm"  data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fa fa-check"></i></a>
                                                @endif
                                                @endif
                                            </td>
                                        </tr>

                                        {{-- {{ route('confirm-payslip',['id'=>$payslip->id,'name'=>$payslip->employee_name])}} --}}



<!-- userPasswordChange -->
<div class="modal animated fadeIn" id="confirmation-msg-{{$payslip->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title">Confirmation Message</h6>
            </div>
            <form method="POST" action="{{ route('confirm-payslip') }}" enctype='multipart/form-data'>
            <div class="modal-body">
                @csrf
                <div class="row clearfix">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group"> 
                                <textarea rows="4" name="emp_comment" class="form-control no-resize" placeholder="Comment *"></textarea>                                   
                        
                        <input type="hidden" class="form-control" name="payslip_id" value="{{ $payslip->id }}" placeholder="Password *">
                        </div>
                    </div>
            
                        <div class="col-12 ">
                                <div class="form-group float-right">                                    
                                    <input type="submit" name="btn" value="Send" class="btn btn-primary">
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
    


@endsection