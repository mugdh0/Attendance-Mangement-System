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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Employee Performance</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Report</li>
                            <li class="breadcrumb-item active">Employee Performance</li>
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
                                           
                                            <th>Employee Name</th>
                                            <th>Employee Role</th>
                                            <th>Avarage Performance</th>
                                      
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($obj_payslip as $payslip)
                                        <tr>
                                        <td>
                                            <a href="{{ route('view-emp-performance-by-month',['id'=>$payslip->employee_id,'name'=>$payslip->employee_name]) }}">
                                                @if($payslip->emp_image)
                                                <img src="{{ $payslip->emp_image }}" class="rounded-circle width35" alt="">
                                                @else
                                                <img src="{{asset('images/nobody_m.original.jpg')}}" class="rounded-circle width35" alt="">
                                                @endif

                                            {{ $payslip->employee_name}}
                                            </a>
                                    </td>
                                        <td>{{$payslip->employee_role}}</td>
                                        <td ><span
                                            @if(round($payslip->avg_performance) < 3)
                                            class="badge badge-warning"
                                            @elseif(round($payslip->avg_performance) == 3)
                                            class="badge badge-info"
                                            @elseif(round($payslip->avg_performance) >3)
                                            class="badge badge-success"
                                            @endif
                                            >
                                                @if(round($payslip->avg_performance) == 1)
                                                Below Avarage({{round($payslip->avg_performance)}}/5)
                                                @elseif(round($payslip->avg_performance) == 2)
                                                Avarage({{round($payslip->avg_performance)}}/5)
                                                @elseif(round($payslip->avg_performance) == 3)
                                                Good({{round($payslip->avg_performance)}}/5)
                                                @elseif(round($payslip->avg_performance) == 4)
                                                Very Good({{round($payslip->avg_performance)}}/5)
                                                @elseif(round($payslip->avg_performance) == 5)
                                                Excellent({{round($payslip->avg_performance)}}/5)
                                              @else
                                              Not Define
                                                @endif
                                                    
                                        </span>
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