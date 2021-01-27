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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a>Activity Log</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Report</li>
                            <li class="breadcrumb-item active">Activity Log</li>
                        </ul>
                    </div>            

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">   
                        
                        





                            <div class="header">
                                    <h2>Activity Log</h2>
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
                                    <br/>&nbsp;
                                    <div id="IdForTaggle" style="display: none;">
                                          <form method="POST" action="{{ route('filter-activity-log-superadmin') }}" enctype='multipart/form-data'>
                                            @csrf
                                        <div class="row" >
                 
                                            <div class="col-md-5">
                                                    <input type="text" data-provide="datepicker" class="form-control" name="start_date" placeholder="Start Date" title="Start Date" data-toggle="tooltip"
                                                    data-placement="top">
                                            </div>
                                            <div class="center">
                                                    <p>To</p>
                                                </div>
                                        <div class="col-md-5">
                                                <input type="text" data-provide="datepicker" class="form-control" name="end_date" placeholder="End Date" title="End Date" data-toggle="tooltip"
                                                data-placement="top">
                                        </div>
                                     
                                      
        
                                        <div class="col-md-1">
                                            <input type="submit" class="btn btn-success" name="btn" value="OK">
                                        </div>
                                        </div>
                                    </form>
                                    </div>
        
        
        
                               
                                <ul class="header-dropdown">
                                        @if(Auth::user()->hasRole(['Super Admin']))
                       
                                    {{-- <li><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#add_user">Add User</a></li> --}}
                                   <li><a href="javascript:void(0);" onclick="btnToggleFunction()" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" class="btn btn-info"><i data-toggle="tooltip" data-placement="top" title="Filter" style="color:#f58c1f" class="fas fa-filter"></i></a></li>
                                    @endif
                                </ul>
                            </div>







                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom">
                                        <thead>
                                                <tr>
                                                 
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>message</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @php($i = 0)
                                            @foreach($logs as $log)
                                            
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                   
                                                    <td>{{ $log->name}}</td>
                                                    <td>{{ $log->email}}</td>
                                                    <td>{{$log->message}}</td>
                                                    <td>
                                                        {{Carbon\Carbon::parse($log->created_at)->toFormattedDateString()}}
                                                        
                                                    </td>
                                                    <td>
                                                            {{Carbon\Carbon::parse($log->created_at)->format('h:i:s A')}}
                                                        
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