@extends('back-end.master')
@section('title')
EMS
@endsection
@section('statusDB')
active
@endsection
@section('content')


    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Dashboard</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>            

                </div>
            
            </div>

            <div class="row clearfix">
                <div class="col-lg-3 col-md-6">
                    <div class="card top_counter">
                        <div class="body">
                        <div class="icon"><a href="#"> <i class="fas fa-user-clock"></i></a> </div>
                            <div class="content">
                                <div class="text">Leave Remain</div>
                            <h5 class="number">{{$totalPaidLeave->paid_leave_amount-$leaveTaken}}</h5>
                            </div>
                            <hr>
                        <div class="icon"><a href="#"><i class="fa fa-users"></i> </a></div>
                            <div class="content">
                                <div class="text">Leave Taken</div>
                            <h5 class="number">{{$leaveTaken}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon"><a href="#"><i class="fas fa-mug-hot"></i> </a></div>
                            <div class="content">
                                <div class="text">Next Holiday</div>
                            <h5 class="number">
                                @if(!empty($UpcomingHoliday->date))
                                {{Carbon\Carbon::parse($UpcomingHoliday->date)->toFormattedDateString()}}
                                @else Not found
                            @endif
                            </h5>
                            </div>
                            <hr>
                            <div class="icon"><a href="#"><i class="fas fa-coins"></i> </a></div>
                            <div class="content">
                                <div class="text">Department</div>
                            <p class="h6">{{Auth::user()->dept_name}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  
                            <div class="card">
                                    {{-- <div class="header">
                                        
                                    </div> --}}
                                    <div class="body">
                                            <h6>Your Performance</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover m-b-0">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Avatar</th>
                                                        <th>Month</th>
                                                        <th>Basic Salary</th>
                                                        <th>Performance</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($obj_payslips as $payslip)
                                                    <tr>
                                                    <td>
                                                        @if($payslip->emp_image)
                                                        <img src="{{ $payslip->emp_image }}" class="rounded-circle width35" alt="">
                                                        @else
                                                        <img src="{{asset('images/nobody_m.original.jpg')}}" class="rounded-circle width35" alt="">
                                                        @endif
                                                    </td>
                                                    <td>{{Carbon\Carbon::parse($payslip->created_at)->toFormattedDateString()}}</td>
                                                    <td><span>{{ $payslip->basic_salary }}</span></td>
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
                                                        {{-- <td><span class="sparkbar">5,8,6,3,5,9,2</span></td> --}}
                                                    </tr>
                                                    @endforeach
                                                    
                                                </tbody>
                                            </table>
                                            <div><a href="#" class="pull-right"></a></div>
                                        </div>
                                    </div>
                                </div>
      
                                    
                </div>
                <div class="col-lg-3 col-md-6">
                        <div class="card top_counter">
                            <div class="body">
                            <div class="icon"><a href="#"> <i class="fas fa-coins"></i> </a> </div>
                                <div class="content">
                                    <div class="text">Total Paid</div>
                                    <h5 class="number">{{$totalSalary}}</h5>
                                    
                                </div>
                                <hr>
                            <div class="icon"><a href="#"><i class="fas fa-coins"></i> </a></div>
                                <div class="content">
                                    <div class="text">Total Basic Salary</div>
                                    <h5 class="number">{{$totalBasicSalaries}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card top_counter">
                            <div class="body">
                              
                                  <div class="icon"><a href="#"><i class="fas fa-coins"></i> </a></div>
                                  <div class="content">
                                        <div class="text">Job Status </div>
                                                <h5 class="number">{{ Auth::user()->job_status }}</h5>
                                        </div>
                                <hr>
                                <div class="icon"><a href="#"><i class="fas fa-coins"></i> </a></div>
                                <div class="content">
                                        <div class="text">Courrent Basic Salary</div>
                                <h5 class="number">@if(!empty($courrentBasicSarary->basic_salary)){{$courrentBasicSarary->basic_salary}}@endif</h5>
                
                                </div>
                            </div>
                        </div>
                    </div>
 
            </div>







            

            
            
        </div>

        @if(Auth::user()->hasRole(['Admin']))
        <div class="row">
                <div class="col-lg-8 col-md-12">

                        <div class="card">
                                <div class="header">
                                    <h2>Employee Performance</h2>
                                </div>
                                <div class="body">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-b-0">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Avatar</th>
                                                    <th>Name</th>
                                                    <th>Designation</th>
                                                    <th>Performance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($obj_payslip as $payslip)
                                                <tr>
                                                <td>
                                                    @if($payslip->emp_image)
                                                    <img src="{{ $payslip->emp_image }}" class="rounded-circle width35" alt="">
                                                    @else
                                                    <img src="{{asset('images/nobody_m.original.jpg')}}" class="rounded-circle width35" alt="">
                                                    @endif
                                                </td>
                                                <td>{{$payslip->employee_name}}</td>
                                                <td><span>{{ $payslip->employee_role }}</span></td>
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
                                                    {{-- <td><span class="sparkbar">5,8,6,3,5,9,2</span></td> --}}
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>




                </div>

        <div class="col-lg-4 col-md-5">
                <div class="card">
                    <div class="header">
                        <h2>Employee Structure</h2>
                    </div>
                    <div class="body text-center">
                        <h6>Male</h6>
                        <input type="text" class="knob2" data-linecap="round" value="{{$male_user}}" data-width="125" data-height="125" data-thickness="0.15" data-fgColor="#49a9e5" readonly>
                        <hr>
                        <h6>Female</h6>
                        <input type="text" class="knob2" data-linecap="round" value="{{$female_user}}" data-width="125" data-height="125" data-thickness="0.15" data-fgColor="#b880e1" readonly>
                    </div>
                </div>
            </div>

        </div>


    </div>
    @endif
    
</div>



@endsection