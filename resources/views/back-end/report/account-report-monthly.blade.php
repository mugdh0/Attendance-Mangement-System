@extends('back-end.master')
@section('title')
EMS Report
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a>Accounts Report</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Report</li>
                            <li class="breadcrumb-item active">Accounts Report</li>
                        </ul>
                    </div>            

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">   
                           


                            <div class="header">
                            
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
                                        
                                        <li><a href="{{ route('account-report-monthly') }}" data-toggle="tooltip" data-placement="top" title="Monthly Account Report" class="btn btn-primary btn-sm rounded">M</a></li>
                               
                                        <li><a href="{{ route('account-report-yearly') }}" data-toggle="tooltip" data-placement="top" title="Yearly Account Report" class="btn btn-secondary btn-sm rounded">Y</a></li>
                                       
                                    </ul>
                                </div>



                        <div class="body">

                               <br/> &nbsp;
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom">
                                        <thead>
                                                <tr>
                                                 
                                                    <th>Month</th>
                                                    <th>Income</th>
                                                    <th>Expense</th>
                                                    <th>Profit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($report as $key=>$value)
                                            
                                                <tr>
                                                    <td>
                                                            <span data-toggle="modal" data-target="#details-{{$key}}">
                                                                <a href="javascript:void(0);" class="" data-toggle="tooltip" data-placement="top" title="Details">{{$key}}</a>
                                                            </span>  
                                                        
                                                        {{-- {{ Carbon\Carbon::createFromFormat('Y-m', $key)->format('Y-m') }} --}}
                                                        </td>
                                                    <td>{{ $value[0]->income}}</td>
                                                    <td>{{ $value[1]->expense}}</td>
                                                    <td
                                                    class="
                                                    @if($value[0]->income - $value[1]->expense>0) text-success
                                                    @else text-danger
                                                     @endif"
                                                    >{{$value[0]->income - $value[1]->expense}}</td>
                                                </tr>




<!-- Details -->
<div class="modal animated fadeIn" id="details-{{$key}}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h6 class="title">Details on {{ Carbon\Carbon::createFromFormat('Y-m', $key)->format('F Y') }}</h6>
                </div>
                
                <div class="modal-body">
                 
                    <div class="row clearfix">
                            
                                  <div class="col-md-12">



                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Date</strong>
                                        </div>
                                        <div class="col-md-3">
                                                <strong>Account Head</strong>
                                            </div>
                                        <div class="col-md-3">
                                            <strong>Type</strong>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Amount</strong>
                                        </div> 
                                    </div><br/>
                                @foreach($res1 as $key=>$value1)
                               
                                    @foreach($value1 as $data)
                                    @if($value[0]->month===$data->month)
                                    <div class="row">
                                            <div class="col-md-3">
                                                <span>{{ Carbon\Carbon::createFromFormat('Y-m-d', $data->day)->format('jS F Y') }}</span>
                                            </div><hr/>
                                            <div class="col-md-3">
                                            <span>{{$data->accHead}}</span>
                                                </div><hr/>
                                            <div class="col-md-3">
                                                @if($data->expanse_id)<span  class="badge badge-pill badge-danger">Expanse </span>
                                                @else <span  class="badge badge-pill badge-success"> Income </span>
                                                @endif
                                               
                                            </div><hr/>
                                            <div class="col-md-3">
                                                <span>{{$data->amount}}</span>
                                            </div> <hr/>
                                        </div>
                                        @endif
                                    @endforeach
                                    
                                    @endforeach


                                  </div>
    
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                              Close
                            </button>
                          </div>

                </div>
    
            </div>
        
        </div>
        </div>
        
        
    





                                            @endforeach
                                            </tbody>
                                </table>
                            </div>

                        </br>&nbsp;
                        <div class="row rounded" style="background-color:#daedf2;">
                                &nbsp;
                            <div class="col-md-8 offset-4 ">
                            <h6>Income: &nbsp;&nbsp;{{ $totalIncomes}}</h6>
                            <h6>Expense: {{$totalExpenses}}</h6>
                            <h6 style="inline-block;">Profit:&nbsp;&nbsp;&nbsp;&nbsp; <span class=" 
                                @if($totalIncomes-$totalExpenses>0) text-success
                                @else text-danger
                                 @endif
                                 "> {{$totalIncomes-$totalExpenses}}
                               
                                </span></h6>
                            </div>&nbsp;
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection