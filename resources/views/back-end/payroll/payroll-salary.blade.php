   
@extends('back-end.master')
@section('title')
EMS Salary
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Employee Salary</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Payroll</li>
                            <li class="breadcrumb-item active">Employee Salary</li>
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
                                    <ul class="header-dropdown">
                                        {{-- <li><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#addcontact">Add New</a></li> --}}
                                    </ul>
                                    @endif
                                </div>


                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Employee ID</th>
                                            <th>Phone</th>
                                            <th>Join Date</th>
                                            
                                            <th>Basic Salary</th>
                                            <th>Payslip</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

@foreach($employeeList as $employee)
@if($employee->hasRole(['Admin', 'Employee']))


                                        <tr>
                                            <td class="width45">

                                                    @if($employee->profile_photo)
                                                    <a href="{{route('payslip-report-this-emp',['email'=>$employee->employee_email,'name'=>$employee->name])}}">
                                                    <img src="{{asset($employee->profile_photo)}}" class="rounded-circle width35" alt="">
                                                    </a>
                                                    @else
                                                    <a href="{{route('payslip-report-this-emp',['email'=>$employee->employee_email,'name'=>$employee->name])}}">
                                                    <img src="{{asset('images/nobody_m.original.jpg')}}" class="rounded-circle width35" alt="">
                                                    
                                                    </a>
                                                    @endif

                                                {{-- <img src="../assets/images/xs/avatar2.jpg" class="rounded-circle width35" alt=""> --}}
                                            </td>
                                            <td><a href="{{route('payslip-report-this-emp',['email'=>$employee->email,'name'=>$employee->name])}}
                                                ">
                                                <h6 class="mb-0">{{$employee->name}}</h6>
                                            <span>{{$employee->email }}</span></a>
                                            </td>
                                        <td><span>{{$employee->emp_id}}</span></td>
                                        <td><span>{{ $employee->phone_no}}</span></td>
                                            <td>
                                                    @if($employee->join_date)
                                                    {{Carbon\Carbon::parse($employee->join_date)->toFormattedDateString()}}
    
                                                    @endif
                                                </td>
                                           
                                            <td>{{$employee->basic_salary}}</td>
                                            <td>
                                                @if($employee->last_payslip_send)
                                                    @if(Carbon\Carbon::parse($employee->last_payslip_send)->format('m-Y')==Carbon\Carbon::now()->format('m-Y'))
                                                    Send    
                                                    {{-- {{Carbon\Carbon::parse($employee->last_payslip_send)->format('m-Y')}} --}}
                                                    @else 
                                                        Not Send
                                                    @endif
                                                @else 
                                                    Not Send
                                                @endif
                                            <td>

                                                @if(Auth::user()->hasRole(['Super Admin', 'Admin']))

                                                @if($employee->last_payslip_send)
                                                @if(Carbon\Carbon::parse($employee->last_payslip_send)->format('m-Y')==Carbon\Carbon::now()->format('m-Y'))
                                                <span  class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Already send salary slip"><i class="fa fa-envelope-o"></i> Slip
                                                    </span>
                                                @else 
                                                <span data-toggle="modal" data-target="#sendPayslip-{{$employee->id}}">
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Send salary slip"><i class="fa fa-envelope-o"></i> Slip</a>
                                                    </span>
                                                @endif
                                                @else
                                                <span data-toggle="modal" data-target="#sendPayslip-{{$employee->id}}">
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Send salary slip"><i class="fa fa-envelope-o"></i> Slip</a>
                                                    </span>
                                            @endif



                                            @endif
                                            @if(Auth::user()->hasRole(['Super Admin']))    
                                            <span data-toggle="modal" data-target="#editEmpSalary-{{$employee->id}}">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="
                                                @if($employee->basic_salary)
                                                Update Salary
                                                @elseif(empty($employee->basic_salary)) Add Salary
                                                @endif
                                                "><i class="fa fa-edit"></i></a>
                                            </span>
                                            @endif

                                                <a href="{{ route('view-increment-history',['id'=>$employee->id,'name'=>$employee->name]) }}" class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="View Increment History"><i class="fas fa-chart-line"></i></i></a>
                                                {{-- <button type="button" class="btn btn-sm btn-outline-danger js-sweetalert" title="Delete" data-type="confirm"><i class="fa fa-trash-o"></i></button> --}}
                                            </td>
                                        </tr>
                                        {{-- {{ route('send-payslip-to-employee',['id'=>$employee->id,'name'=>$employee->name]) }} --}}


<!-- sendPayslip -->
<div class="modal animated fadeIn" id="sendPayslip-{{$employee->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title">Send Payslip to {{$employee->name}}</h6>
                </div>
                <form method="POST" action="{{ route('send-payslip-to-employee') }}" enctype='multipart/form-data'>
                <div class="modal-body">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">                                    
                                    <select required class="form-control show-tick" name="emp_performance">
                                            <option value="">Select Performance Rating</option>
                                            
                                                <option value="1">Below Average</option>
                                                <option value="2">Average</option>
                                                <option value="3">Good</option>
                                                <option value="4">Very Good</option>
                                                <option value="5">Excellent</option>
                                            
                                    </select>
                            <input type="hidden" class="form-control" name="employee_id" value="{{ $employee->id }}" placeholder="Password *">
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
        
        
    





                                    <!-- Edit EMP -->
                                    <div class="modal animated zoomIn" id="editEmpSalary-{{$employee->id}}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog  modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="title" >@if($employee->basic_salary)
                                                                Update Salary
                                                                @elseif(empty($employee->basic_salary)) Add Salary
                                                                @endif</h6>
                                                    </div>
                                                    <form method="POST" action="{{ route('update-salary-info') }}" enctype='multipart/form-data'>
                                                        <div class="modal-body">
                                                            <div class="row clearfix">
    
                                                                @csrf

                                                                <div class="col-6">
                                                                    <div class="form-group">                                    
                                                                    <input type="number" class="form-control" required value="{{ $employee->basic_salary }}"data-toggle="tooltip" data-placement="top" name="basic_salary" placeholder="Basic Salary"title="Basic Salary">
                                                                        <input type="hidden" class="form-control" name="emp_id" value="{{$employee->id}}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">                                   
                                                                        <input type="number" class="form-control" value="{{ $employee->house_rent_allowance }}" data-toggle="tooltip" data-placement="top" name="house_rent_allowance" placeholder="House Rent Allowance" title="House Rent Allowance">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">                                    
                                                                        <input type="number" class="form-control" value="{{ $employee->bonus }}" data-toggle="tooltip" data-placement="top" name="bonus" placeholder="Bonus"title="Bonus">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">                                    
                                                                        <input type="number" class="form-control" value="{{ $employee->conveyance }}" data-toggle="tooltip" data-placement="top" name="conveyance" placeholder="Conveyance" title="Conveyance">
                                                                    </div>
                                                                </div>


                                                            <div class="col-md-4">

                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">                                    
                                                                        <input type="number" class="form-control" value="{{ $employee->other_allowance }}" data-toggle="tooltip" data-placement="top" name="other_allowance" placeholder="Other Allowance" title="Other Allowance">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
    
                                                                </div>
                                                                <div class="col-md-12">
                                                                        <hr/>
                                                                    </div>
   


                    <div class="col-6">
                            <div class="form-group">                                    
                                <input type="number" class="form-control" value="{{ $employee->TDS }}" data-toggle="tooltip" data-placement="top" name="TDS" placeholder="Tax Deducted at Source (T.D.S.) Salary" title="Tax Deducted at Source (T.D.S.) Salary">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">                                   
                                <input type="number" class="form-control" value="{{ $employee->provident_fund }}" data-toggle="tooltip" data-placement="top" name="provident_fund" placeholder="Provident Fund" title="Provident Fund">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">                                    
                                <input type="number" class="form-control" value="{{ $employee->c_bank_loan }}" data-toggle="tooltip" data-placement="top" name="c_bank_loan" placeholder="C/Bank Loan" title="C/Bank Loan">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">                                    
                                <input type="number" class="form-control" value="{{ $employee->other_deductions }}" data-toggle="tooltip" data-placement="top" name="other_deductions" placeholder="Other Deductions" title="Other Deductions">
                            </div>
                        </div>
    
                                                                <div class="col-12 ">
                                                                    <div class="form-group float-right">                                    
                                                                        <input type="submit" name="btn" value="@if($employee->basic_salary)
                                                                        Update Salary
                                                                        @elseif(empty($employee->basic_salary)) Add Salary
                                                                        @endif" class="btn btn-primary">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
              <!--   <div class="modal-footer">
    
              </div> -->
          </div>
      </div>
    </div>
    
    





      @endif                                 
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