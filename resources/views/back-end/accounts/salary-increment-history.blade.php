   
@extends('back-end.master')
@section('title')
EMS Salary Increment History
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
                    <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom m-b-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Current_basic Sallary</th>
                                            <th>Previous Basic Sallary</th>
                                            <th>Increment At</th>
                     
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($salary_histories as $salary_history)
                                            <tr>
                                                <td><span class="mb-0">{{$salary_history->name}}</span></td>
                                                <td><span>{{$salary_history->current_basic_sallary}}</span></td>
                                                <td><span>{{ $salary_history->previous_basic_sallary}}</span></td>
                                                <td> {{Carbon\Carbon::parse($salary_history->created_at)->toFormattedDateString()}} </td>
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