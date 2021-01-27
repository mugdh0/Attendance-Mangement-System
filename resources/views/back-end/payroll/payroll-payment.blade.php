   
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Payment</h2>
                        <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Payroll</li>
                            <li class="breadcrumb-item">Payslip</li>
                            <li class="breadcrumb-item active">Payment</li>
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
 

                                    
                                    <div id="IdForTaggle" style="display: none;">
                                            <br/>&nbsp;
                                          <form method="POST" action="{{ route('filter-payslip-form-payment') }}" enctype='multipart/form-data'>
                                            @csrf
                                        <div class="row" >
                                          
                                            <div class="col-md-3">
                                                    <select class="form-control mb-3 show-tick" name="employee_name">
                                
                                                            <option value="">Select Name</option>
                                                            @foreach($obj_empName as $empName)
                                                            <option value="{{$empName->employee_name}}">{{$empName->employee_name}}</option>
                                                            @endforeach
                                            </select>
                                            </div>
                                            <div class="col-md-3" >
                                                    <input type="text" name="pay_for" data-provide="datepicker" class="form-control" placeholder="Pay For">
                                                    {{-- <input type="text"  data-date-format="MM-yyyy" data-provide="datepicker"  name="pay_for" class="form-control" placeholder="Pay For"> --}}
                                          
                                                </div>
                                          


                                            <div class="col-md-3">
                                                    <select class="form-control mb-3 show-tick" name="payment_status">
                                
                                                            <option value="">Select Payment Status</option>
                                                           
                                                            <option value="Paid">Paid</option>
                                                            <option value="Unpaid">Unpaid</option>
                                                        
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
                                        <li><a href="javascript:void(0);" onclick="btnToggleFunction()" class="btn-default" style="padding: 0px 6px;font-size: 12px;" class="btn btn-info"><i data-toggle="tooltip" data-placement="top" title="Filter" style="color:#f58c1f" class="fas fa-filter"></i></a></li>
                       
                                        {{-- <li><a href="javascript:void(0);" onclick="btnToggleFunction()" class="btn btn-info">Filter</a></li> --}}

                                    </ul>

                                </div>


                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            {{-- <th>Year</th>
                                            <th>Month</th> --}}
                                            <th>Name</th>
                                            <th>Id</th>
                                            <th>Salary</th>
                                    
                                            <th>Pay For</th> 
                                            <th>Payment Date</th> 
                                            <th>Payment Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

@foreach($obj_payslip as $payslip)


                                        <tr>
        <td></td>
                                            {{-- <td> 
                                            <span>{{$payslip->created_at->year}}</span>
                                            </td>
                                        <td><span> {{Carbon\Carbon::parse($payslip->created_at)->format('F') }}
                                            
                                        </span></td> --}}
                                        
                                            
                                    <td><a href="{{route('payslip-by-emp',['email'=>$payslip->employee_email,'name'=>$payslip->employee_name])}}">{{$payslip->employee_name}}</a></td>
                                            <td>{{$payslip->employee_id}}</td>
                                            <td>
                    {{($payslip->basic_salary+$payslip->house_rent_allowance+$payslip->bonus
                   +$payslip->conveyance+$payslip->other_allowance) -($payslip->TDS+$payslip->provident_fund+$payslip->c_bank_loan
                     +$payslip->other_deductions)}}

                                                {{-- {{$payslip->basic_salary}} --}}
                                            
                                            </td>

                                            <td><span> {{Carbon\Carbon::parse($payslip->created_at)->format('F Y') }}
                                            <td>{{$payslip->pay_date}}</td>
                                            <td>{{$payslip->payment_status}}</td>
                                            <td>
                        
                                                <a href="{{ route('view-payslip-details',['email'=>$payslip->employee_email,'name'=>$payslip->employee_name,'id'=>$payslip->id])}}" class="btn btn-sm btn-outline-info" title="View"  data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fa fa-eye"></i></a>
                                                
                                                <a 
                                                @if($payslip->payment_status=="Unpaid")
                                                 href="{{ route('Payment-payslip-to-emp',['id'=>$payslip->id,'name'=>$payslip->employee_name])}}" class="btn btn-sm btn-outline-primary"title="Pay
                                                 @else
                                                 href="javascript:void(0);" class="btn btn-sm btn-outline-secondary"title="Already Paid
                                                 @endif
                                                 "data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fas fa-check-double"></i></i></a>
                                               
                                               
                                            </td>
                                        </tr>

                                        {{-- {{ route('confirm-payslip',['id'=>$payslip->id,'name'=>$payslip->employee_name])}} --}}



    <!-- confirmation -->
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