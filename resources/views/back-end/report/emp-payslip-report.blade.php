   
@extends('back-end.master')
@section('title')
EMS Salary Report
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
                                          <form method="POST" action="#" enctype='multipart/form-data'>
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
                                        
                                        {{-- <li><a href="javascript:void(0);" onclick="btnToggleFunction()" class="btn-default" style="padding: 0px 6px;font-size: 12px;" class="btn btn-info"><i data-toggle="tooltip" data-placement="top" title="Filter" style="color:#f58c1f" class="fas fa-filter"></i></a></li> --}}
                       
                                       

                                    </ul>

                                </div>


                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>
                                            {{-- <th></th> --}}
                                            <th>Employee Id</th>
                                            <th>Name</th>
                                            
                                            <th>Total Basic</th>
                                            <th>Total Salary</th>
                                        
                                          
                                        </tr>
                                    </thead>
                                    <tbody>

@foreach($obj_payslip as $payslip)


                                        <tr>
        {{-- <td></td> --}}
                                        <td>{{$payslip->employee_id}}</td>
                                        <td><a href="{{route('payslip-report-this-emp',['email'=>$payslip->employee_email,'name'=>$payslip->employee_name])}}">{{$payslip->employee_name}}</a></td>
                                    
                                        <td> {{($payslip->basic_salary)}} </td>                                        

                                        <td>
                                            {{($payslip->basic_salary+$payslip->house_rent_allowance+$payslip->bonus
                                            +$payslip->conveyance+$payslip->other_allowance) -($payslip->TDS+$payslip->provident_fund
                                            +$payslip->c_bank_loan +$payslip->other_deductions)}}
                                        </td>
                           
                                        </tr>
                             
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