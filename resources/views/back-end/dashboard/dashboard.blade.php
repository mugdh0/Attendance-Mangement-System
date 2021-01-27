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
                        <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>

                </div>

            </div>


            {{-- <div class="row clearfix">
                    <div class="col-lg-12 col-md-12">

                    </div>
                </div> --}}


            <div class="row clearfix">
                <div class="col-lg-3 col-md-6">
                    <div class="card top_counter">
                        <div class="body">
                            <div class="icon"><a href="{{url('/employee.all')}}"><i class="fa fa-users"></i> </a></div>
                                <div class="content">
                                    <div class="text">Total Employee</div>
                                    <h5 class="number">{{$total_user}}</h5>
                                </div>
                        </div>
                    </div>
                    <div class="card top_counter" style="margin-top:-16px;">
                        <div class="body">
                            <div class="icon"><a href="emp.leave-report"> <i class="fa fa-user"></i> </a> </div>
                                <div class="content">
                                    <div class="text">Employees In Leave</div>
                                    <h5 class="number">{{$have_leave_today}} </h5>
                                </div>
                        </div>
                    </div>
                    <div class="card top_counter" style="margin-top:-16px;">
                        <div class="body">
                            <div class="icon"> @if(Auth::user()->hasRole(['Super Admin', 'Admin',]))<a href="{{ url('emp.app-users') }}">@else <a href="#"> @endif  <i class="fa fa-user"></i> </a> </div>
                                <div class="content">
                                    <div class="text">Total User</div>
                                    <h5 class="number">{{$total_userS}} </h5>
                                </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 col-md-6">
                    <!-- <div class="card text-center">
                        <div class="body">
                            <h5>Salary By Deptartment</h5>

                             <div id="pie_chart" style="width:100%; height:303px;"></div>
                            <canvas id="oilChart" width="600" height="330"></canvas>

                        </div>

                    </div> -->
                    <?php $present = ($p/$total_user)*100;
                            $absent = 100-$present;
                    ?>
                    <div class="card">
                      <div class="header">

                      </div>
                        <div class="body text-center">
                          <div class="container">
                                          <div class="row">
                                              <div class="col-xs-6" style="padding-left:80px;">
                                                <h6>Present</h6>
                                                <input type="text" class="knob2" data-linecap="round" value="{{$present}}" data-width="125" data-height="125" data-thickness="0.15" data-fgColor="#49a9e5" readonly>

                                              </div>
                                              <hr>
                                              <div class="col-xs-6" style="padding-right:80px;">
                                                <h6>Absent</h6>
                                                <input type="text" class="knob2" data-linecap="round" value="{{$absent}}" data-width="125" data-height="125" data-thickness="0.15" data-fgColor="#b880e1" readonly>

                                              </div>
                                          </div>
                            </div>
                          </div>
                          <div class="header" style="float:right; color:blue;">
                              <h2>Today</h2>
                          </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-6">
                        <div class="card top_counter">
                            <div class="body">
                            <div class="icon"><a href="#"> <i class="fas fa-clock"></i> </a> </div>
                                <div class="content">
                                    <div class="text">Todays Late</div>
                                    <h5 class="number">{{$lc}}</h5>
                                </div>

                              </div>
                          </div>
                          <div class="card top_counter" style="margin-top:-16px;">
                              <div class="body">

                            <div class="icon"><a href="#"><i class="fas fa-calendar-times"></i> </a></div>
                                <div class="content">
                                    <div class="text">Todays Absent</div>
                                    <h5 class="number"><?php echo $total_user-$p; ?></h5>
                                </div>
                              </div>
                          </div>
                          <div class="card top_counter" style="margin-top:-16px;">
                              <div class="body">

                                <div class="icon"><a href="#"><i class="fas fa-calendar-check"></i> </a></div>
                                    <div class="content">
                                        <div class="text">Todays Present</div>
                                        <h5 class="number">{{$p}}</h5>
                                    </div>
                            </div>
                        </div>
                        <!-- <div class="card top_counter">
                            <div class="body">
                                <div class="icon"><a href="{{url('/emp.account-report.yearly')}}"><i class="fas fa-coins"></i> </a></div>
                                <div class="content">
                                        <div class="text">Expense Previous Year</div>
                                        <h5 class="number">{{$totalExpensesPreYear}}</h5>

                                </div>
                                <hr>
                                <div class="icon"><a href="{{url('/emp.account-report.yearly')}}"><i class="fas fa-coins"></i> </a></div>
                                <div class="content">
                                        <div class="text">Income Previous Year</div>
                                        <h5 class="number">{{$totalIncomesPreYear}}</h5>
                                </div>
                            </div>
                        </div> -->
                    </div>

            </div>

            <!-- <div class="row clearfix">
                    <div class="col-lg-6 col-md-6">
                            <div class="card">
                                    <div class="header">
                                        <h2>Accounts Report</h2>

                                    </div>
                                    <div class="body">

                                        <canvas id="accReportChart" height="" width=""></canvas>
                                    </div>
                                </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                            <div class="card">
                                    <div class="header">
                                        <h2>Profit Report</h2>

                                    </div>
                                    <div class="body">

                                        <canvas id="profitChart" height="" width=""></canvas>
                                    </div>
                                </div>
                    </div>

            </div> -->

            <div class="row">
                    <div class="col-lg-8 col-md-12">

                            <div class="card" style="height: 28rem;">
                                    <div class="header">
                                        <h2>Employee Attendance (Current Month)</h2>
                                    </div>
                                    <div class="body" style="margin-top:-10px;">
                                        <div class="table-responsive" style="overflow-y:hidden; max-height:320px;">
                                        <table border="1" class="table table-hover" >
                                  <thead class="thead-dark">
                                      <tr>
                                          
                                         <th>Name</th>
                                         <th>Emp ID</th>
                                        
                                        <th>Working Days</th>
                                        
                                         <th>Absent</th>
                                         <th>Late</th>
                                         <th>Get Paid For(days)</th>
                                         <!-- <th>Action</th> -->

                                     </tr>
                                 </thead>
                                 <tbody>
                                 
                                  
                                  @foreach($userList as $user)
                                  
                                  <tr>
                                      
                                          <td>
                                                  <h6 class="mb-0">{{$user->name}}</h6>
                                              </td>
                                              @if(Auth::user()->hasRole(['Super Admin', 'Admin','Employee']))
                                              <td><span>{{$user->emp_id}}</span></td>
                                                
                                        @if($nowmonth=="09" ||$nowmonth=="04"||$nowmonth=="06"||$nowmonth=="11")
                                        <?php $a30=0;?>
                                            @for($i=1;$i<=30;$i++)
                                            <?php
                                                $stat30=null;
                                                
                                             ?>

                                            
                                            
                                            @foreach($attendance as $att)
                                                <?php $mon= explode("-", $att->date); 
                                                    
                                                ?>
                                                @if($att->emp_id == $user->emp_id && $mon[0] == $i && $mon[1] == $nowmonth && $mon[2] == $nowyear)
                                                    {{$att->status}}

                                                    <?php 
                                                                $stat30=1;
                                                            ?>
                                                @else
                                                    
                                                @endif   
                                            @endforeach
                                            @if($stat30 == null)
                                                    
                                                    <?php $a30=$a30+1;?>
                                                
                                                @endif
                                            
                                            @endfor
                                            <?php $present = 0; 
                                                            $absent = 0;
                                                            $late = 0;
                                                            ?>
                                                     @foreach($attendance as $att)
                                                        <?php $mon= explode("-", $att->date); 
                                                            
                                                        ?>
                                                        @if($att->emp_id == $user->emp_id && $mon[1] == $nowmonth && $mon[2] == $nowyear)
                                                            <?php
                                                            
                                                            $absent = $absent + $att->absent;
                                                            $late = $late + $att->late;
                                                             ?>
                                                        @endif   
                                                    @endforeach
                                                    
                                            <td>30</td>
                                            
                                            
                                            <td>{{$a30}}</td>
                                            <td>{{$late}}</td>
                                            <?php 
                                                    $diduct30 = intdiv($late,$deduct_count) + $a30;
                                                    
                                                ?>
                                            <td><?php $paid_for = 30-$diduct30;?>
                                            {{$paid_for}}</td>
                                            
                                        
                                          
                                              <!-- <td><a href="{{ route('empAttendancesrcs',['id'=>$user->id,'name'=>$user->name]) }}" class="btn btn-sm btn-outline-info " title="View" data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fa fa-eye"></i></a></td> -->

                                        @elseif($nowmonth=="02")
                                        


                                        <?php $a2=0;?>
                                        <?php

if ($nowyear % 400 == 0){
 $c="YES";
}
   
if ($nowyear % 4 == 0){
 $c="YES";
}

else if ($nowyear % 100 == 0){
 $c="NO";
}

else{
 $c=  "NO";
}


if($c == "YES"){
 $lep = 29;
}else{
 $lep = 28;
}
?>                                       
                                            @for($i=1;$i<=$lep;$i++)
                                            <?php
                                                $stat2=null;
                                                
                                             ?>
                                            
                                            
                                            @foreach($attendance as $att)
                                                <?php $mon= explode("-", $att->date); 
                                                    
                                                ?>
                                                @if($att->emp_id == $user->emp_id && $mon[0] == $i && $mon[1] == $nowmonth && $mon[2] == $nowyear)
                                                    {{$att->status}}
                                                    <?php 
                                                                $stat2=1;
                                                            ?>
                                                @endif   
                                            @endforeach
                                            @if($stat2 == null)
                                                    
                                                    <?php $a2=$a2+1;?>
                                                
                                                @endif
                                            
                                            @endfor
                                            <?php $present = 0; 
                                                            $absent = 0;
                                                            $late = 0;
                                                            ?>
                                                     @foreach($attendance as $att)
                                                        <?php $mon= explode("-", $att->date); 
                                                            
                                                        ?>
                                                        @if($att->emp_id == $user->emp_id && $mon[1] == $nowmonth && $mon[2] == $nowyear)
                                                            <?php
                                                            
                                                            $absent = $absent + $att->absent;
                                                            $late = $late + $att->late;
                                                             ?>
                                                        @endif   
                                                    @endforeach
                                                    
                                            <td>{{$lep}}</td>
                                            
                                            
                                            <td>{{$a2}}</td>
                                            <td>{{$late}}</td>
                                            <?php 
                                            $diduct2 = intdiv($late,$deduct_count) + $a2;
                                            ?>
                                            <td><?php $paid_for = $lep-$diduct2;?>
                                            {{$paid_for}}</td>
                                            
                                        
                                          
                                              <!-- <td><a href="{{ route('empAttendancesrcs',['id'=>$user->id,'name'=>$user->name]) }}" class="btn btn-sm btn-outline-info " title="View" data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fa fa-eye"></i></a></td> -->

                                        @else
                                        <?php $a=0;?>
                                             @for($i=1;$i<=31;$i++)
                                             <?php
                                                $stat=null;
                                                
                                             ?>
                                                
                                                    @foreach($attendance as $att)
                                                        <?php $mon= explode("-", $att->date); 
                                                            
                                                        ?>
                                                        @if($att->emp_id == $user->emp_id && $mon[0] == $i && $mon[1] == $nowmonth && $mon[2] == $nowyear)
                                                            
                                                            <?php 
                                                                $stat=1;
                                                            ?>
                                                        @else
                                                        @endif

                                                    @endforeach
                                                @if($stat == null)
                                                    
                                                    <?php $a=$a+1;?>
                                                
                                                @endif
                                                    
                                                
                                            @endfor
                                                        <?php 
                                                            $absent = 0;
                                                            $late = 0;
                                                            ?>
                                                     @foreach($attendance as $att)
                                                        <?php $mon= explode("-", $att->date); 
                                                            
                                                        ?>
                                                        @if($att->emp_id == $user->emp_id && $mon[1] == $nowmonth && $mon[2] == $nowyear)
                                                            <?php
                                                            $absent = $absent + $att->absent;
                                                            $late = $late + $att->late;
                                                        
                                                             ?>
                                                        @endif   
                                                    @endforeach

                                                    
                                            <td>31</td>
                                            
                                            
                                            <td>{{$a}}</td>
                                            <td>{{$late}}</td>
                                                <?php 
                                                    $diduct = intdiv($late,$deduct_count) + $a;
                                                    
                                                ?>
                                            
                                            <td>
                                            <?php $paid_for = 31-$diduct;?>
                                            {{$paid_for}}
                                            </td>
                                            
                                        
                                          
                                              <!-- <td><a href="{{ route('empAttendancesrcs',['id'=>$user->id,'name'=>$user->name]) }}" class="btn btn-sm btn-outline-info " title="View" data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fa fa-eye"></i></a></td> -->

                                        @endif
                                            

                                            @endif
                                      </tr>

    
  @endforeach

  </tbody>
  </table>
                                        </div>
                                        <br>
                                        <a style="float:right" href="/emp.attendance">See More...</a>
                                        <br>
                                        
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
    </div>

</div>
<script type="text/javascript" src="{{asset('assets/loader.js')}}"></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js" charset="utf-8"></script>



<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato"/>




<script>
    var ctx = document.getElementById("accReportChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Total Incomes", "Total Expense"],
            datasets: [{
                label: 'Accounts Report',
                data: ["<?php echo $totalIncomes; ?>","<?php echo $totalExpenses; ?>"],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>



<script>
    var url = "{{url('/profitChart')}}";
    var New = new Array();
    var Amount = new Array();

    $(document).ready(function(){
        $.get(url, function(response){
            response.forEach(function(data){
                New.push(data.month);
                Amount.push(data.amount);
            });
            var abc = document.getElementById("profitChart").getContext('2d');
            var BChart = new Chart(abc, {
                type: 'bar',
                data: {

                    labels:New,
                    datasets: [{
                        label: 'Profit',
                        data: Amount,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],

                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }

                        }]
                    }
                }
            });
        });
    });
</script>





@endsection
