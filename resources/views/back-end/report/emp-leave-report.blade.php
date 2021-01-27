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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Report Expense</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Report</li>
                            <li class="breadcrumb-item active">Report Employee Leave</li>
                        </ul>
                    </div>            

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
               <div class="col-lg-12">
                    <div class="card">                        
                        <div class="body">
                        <a style="float:right;" href="emp.leave-report-preview" class="btn btn-sm btn-outline-danger " title="Print" data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fas fa-print">Print leave Report</i></a>
                        <br><br>
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom">
                                    <thead>
                                        <tr>
                                           
                                            <th>Employee Name</th>
                                            <th>Id</th>
                                            <th>Total Leave Taken</th>
                                            <th>Leave Remain</th>
                                            <th>Previous Leave</th>
                                            <th>Leave Status</th>
                                            {{-- <th>Avarage Performance</th> --}}
                                      
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($userList as $user)
                                        <tr>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->emp_id}}</td>
                                            @if(count($lvrp)>0)

                                            @foreach($lvrp as $lv)
                                                    @if($user->emp_id == $lv->emp_id)
                                                    <td>{{$lv->leave_taken}}</td>
                                                <td>{{$lv->leave_remain}}</td>
                                                
                                                <?php 
                                                $c=0;
                                                if($lv->last_leave == "REJECTED"){
                                                    $c=1;
                                                }else{
                                                    
                                                    $date = explode(",",$lv->last_leave);
                                                }
                                                ?>

                                                <td>
                                                            @if($c==1)

                                                            @else
                                                                @foreach($date as $dt)
                                                                    {{$dt}} [{{\Carbon\Carbon::parse($dt)->format('l')}}]<br>
                                                                @endforeach
                                                            @endif
                                                            
                                                </td>
                                                <td>
                                                <?php
                                                if($c==1){
                                                    $st= "";
                                                }else{
                                                    $d = \Carbon\Carbon::now();
                                                    $nowdate = explode(" ",$d);
                                                    $nw = \Carbon\Carbon::parse($nowdate[0])->format('d-m-Y');

                                                    $st = "Active";
                                                    foreach($date as $dt){
                                                    if((new \Carbon\Carbon($nw))->equalTo(new \Carbon\Carbon($dt))){
                                                        $st= "On Leave";
                                                    }else{
                                                        
                                                    }
                                                }
                                                }
                                                    
                                                ?>
                                                {{$st}}
                                                </td>
                                                @else
                                                <td>0</td>
                                                <td>{{$emp_leave}}</td>
                                                <td>0</td>
                                                <td>Active</td>
                                                
                                                @endif
                                                @endforeach
                                            @else
                                                
                                                <td>0</td>
                                                <td>{{$emp_leave}}</td>
                                                <td>0</td>
                                                <td>Active</td>
                                                
                                            @endif
                                        
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