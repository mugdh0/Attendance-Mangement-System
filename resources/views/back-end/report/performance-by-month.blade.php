@extends('back-end.master')
@section('title')
Employee Performance Report
@endsection
@section('statusReport')
active
@endsection
@section('content')

 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Report Expense</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Report</li>
                            <li class="breadcrumb-item active">Report Expense</li>
                        </ul>
                    </div>            

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">                        
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom">
                                    <thead>
                                        <tr>
                                           
                                            <th>#</th>
                                            <th>Employee Name</th>
                                            <th>Month</th>
                                            <th>Employee Role</th>
                                            <th>Performance</th>
                                            <th>Action</th>
                                      
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($obj_payslips as $payslip)
                                        <tr>
                                            <td></td>
                                                
                                        <td>
                                  
                                                @if($payslip->emp_image)
                                                <img src="{{ $payslip->emp_image }}" class="rounded-circle width35" alt="">
                                                @else
                                                <img src="{{asset('images/nobody_m.original.jpg')}}" class="rounded-circle width35" alt="">
                                                @endif

                                            {{ $payslip->employee_name}}
                                            
                                    </td>
                                    <td>
                                            {{Carbon\Carbon::parse($payslip->created_at)->format('F Y')}}</td>
                                        <td>{{$payslip->employee_role}}</td>
                                        <td ><span
                                            @if(round($payslip->emp_performance) < 3)
                                            class="badge badge-warning"
                                            @elseif(round($payslip->emp_performance) == 3)
                                            class="badge badge-info"
                                            @elseif(round($payslip->emp_performance) >3)
                                            class="badge badge-success"
                                            @endif
                                            >
                                                @if(round($payslip->emp_performance) == 1)
                                                Below Avarage({{round($payslip->emp_performance)}}/5)
                                                @elseif(round($payslip->emp_performance) == 2)
                                                Avarage({{round($payslip->emp_performance)}}/5)
                                                @elseif(round($payslip->emp_performance) == 3)
                                                Good({{round($payslip->emp_performance)}}/5)
                                                @elseif(round($payslip->emp_performance) == 4)
                                                Very Good({{round($payslip->emp_performance)}}/5)
                                                @elseif(round($payslip->emp_performance) == 5)
                                                Excellent({{round($payslip->emp_performance)}}/5)
                                              @else
                                              Not Define
                                                @endif
                                                    
                                        </span>
                                        </td>
                                        <td>

                                                <span data-toggle="modal" data-target="#cngP-{{$payslip->id}}">
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Change Performance"><i class="fa fa-edit"></i></a>
                                                    </span>

    <!-- sendPayslip -->
    <div class="modal animated fadeIn" id="cngP-{{$payslip->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="title">Change Performance</h6>
                    </div>
                    <form method="POST" action="{{ route('change-performance') }}" enctype='multipart/form-data'>
                    <div class="modal-body">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">                                    
                                        <select required class="form-control show-tick" name="emp_performance">
                                                <option value="">Select Performance Rating</option>
                                                
                                                    <option {{ $payslip->emp_performance=='1' ? 'Selected' : ''}} value="1">Below Average</option>
                                                    <option {{ $payslip->emp_performance=='2' ? 'Selected' : ''}} value="2">Average</option>
                                                    <option {{ $payslip->emp_performance=='3' ? 'Selected' : ''}} value="3">Good</option>
                                                    <option {{ $payslip->emp_performance=='4' ? 'Selected' : ''}} value="4">Very Good</option>
                                                    <option {{ $payslip->emp_performance=='5' ? 'Selected' : ''}} value="5">Excellent</option>
                                                
                                        </select>
                                <input type="hidden" class="form-control" name="payslip_id" value="{{ $payslip->id }}" >
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