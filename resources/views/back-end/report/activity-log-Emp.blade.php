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
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom">
                                        <thead>
                                                <tr>
                                                 
                                                    <th>#</th>
                                                    <th>Change By</th>
                                                    <th>Message</th>
                                                    
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @php($i = 0))
                                            @foreach($logs as $log)
                                            
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                   
                                                    <td>{{ $log->change_by}}</td>
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