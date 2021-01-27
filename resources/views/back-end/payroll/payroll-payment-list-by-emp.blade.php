   
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Payslip Payment</h2>
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
            
 



<ul class="header-dropdown">

    {{-- <li><a href="javascript:void(0);" onclick="btnToggleFunction2()" class="btn btn-info">Filter</a></li> --}}
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
                                            <th>Confirmation Status</th>
                                          
                                            <th>Payment Status</th> 
                                            <th>Pay For</th> 
                                            <th>Payment Date</th> 
                                            
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
                                            <td>{{$payslip->confirmation_status}}</td>
                                            
                                          
                                            <td>{{$payslip->payment_status}}</td>
                                            <td><span> {{Carbon\Carbon::parse($payslip->created_at)->format('F Y') }}
                                            <td>{{$payslip->pay_date}}</td>
                             
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