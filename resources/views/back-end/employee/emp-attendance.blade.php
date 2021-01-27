@extends('back-end.master')
@section('title')
EMS employee Attendance
@endsection
@section('statusEMP')
active
@endsection
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Attendance Report</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Employee</li>
                            <li class="breadcrumb-item active">Attendance Report</li>
                        </ul>
                    </div>

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                      <div class="header">

                          <h2>Attendance Report</h2>

                          @if(Auth::user()->hasRole(['Super Admin', 'Admin','Employee']))

                          <ul class="header-dropdown">
                          
                            <form class="form-group" action="emp.attendance" method="post">
                              @csrf
                               
                              <li title="pick month">
                                <select name="month" class="form-control">
                                  <?php
                                      $month = !empty( $_GET['month'] ) ? $_GET['month'] : 0;
                                      for ($i = 0; $i <= 12; ++$i) {
                                          $time = strtotime(sprintf('+%d months', $i));
                                          $label = date('F ', $time);
                                          $value = date('m', $time);

                                          $selected = ( $value==$month ) ? ' selected=true' : '';

                                          printf('<option value="%s"%s>%s</option>', $value, $selected, $label );
                                      }
                                  ?>
                              </select>
                              </li>
                              <li>
                                <select name="year" class="form-control">
                <?php

                    $year = !empty( $_GET['year'] ) ? $_GET['year'] : 0;

                    for ($i = 0; $i <= 10; ++$i)  {
                        $time = strtotime(sprintf('-%d years', $i));
                        $value = date('Y', $time);
                        $label = date('Y ', $time);

                        $selected = ( $value==$year ) ? ' selected=true' : '';

                        printf('<option value="%s"%s>%s</option>', $value, $selected, $label);
                    }
                ?>
            </select>
                              </li>
                              <li>
                                <button type="submit" name="button" class="btn btn-success">Submit</button>
                              </li>
                              
                            </form>
                        
                          </ul>
                          @endif 

                      </div>
                      <!-- end head -->
                      <div class="body">
                          
                          <h5>Showing Result Of Month:
                                      @if($nowmonth=='01')
                                      <span style="color: red">January </span>
                                      @elseif($nowmonth=='02')
                                      <span style="color: red">February </span>
                                      @elseif($nowmonth=='03')
                                      <span style="color: red">March </span>
                                      @elseif($nowmonth=='04')
                                      <span style="color: red">April </span>
                                      @elseif($nowmonth=='05')
                                      <span style="color: red">May </span>
                                      @elseif($nowmonth=='06')
                                      <span style="color: red">June </span>
                                      @elseif($nowmonth=='07')
                                      <span style="color: red">July </span>
                                      @elseif($nowmonth=='08')
                                      <span style="color: red">August </span>
                                      @elseif($nowmonth=='09')
                                      <span style="color: red">September </span>
                                      @elseif($nowmonth=='10')
                                      <span style="color: red">October </span>
                                      @elseif($nowmonth=='11')
                                      <span style="color: red">November </span>
                                      @elseif($nowmonth=='12')
                                      <span style="color: red">December </span>
                                      @endif
                                      <span style="color: red;margin-right:35%">{{$nowyear}} </span>
                                      <a style="" href="{{ route('generatereport',['month'=>$nowmonth,'year'=>$nowyear]) }}" class="btn btn-sm btn-outline-danger " title="print" data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fas fa-print"> Print Full Report</i></a>
                                      <a style="" href="{{ route('generatesummary',['month'=>$nowmonth,'year'=>$nowyear]) }}" class="btn btn-sm btn-outline-success " title="print" data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fas fa-print"> Print Report Summary</i></a>
                                    </h5> <br>
                                    <div class="table-responsive">
                              <table border="1" class="table table-hover c_list">
                                  <thead class="thead-dark">
                                      <tr>
                                          <th>
                                              <label class="fancy-checkbox">
                                                 <!--    <input class="select-all" type="checkbox" name="checkbox"> -->
                                                 <span></span>
                                             </label>
                                         </th>
                                         <th>Name</th>
                                         <th>Emp ID</th>
                                        
                                        @if($nowmonth=="09" ||$nowmonth=="04"||$nowmonth=="06"||$nowmonth=="11")

                                            @for($i=1;$i<=30;$i++)
                                                <th> {{$i}}</th>
                                            @endfor

                                        @elseif($nowmonth=="02")
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
                                                <th> {{$i}}</th>
                                            @endfor
                                        @else
                                            @for($i=1;$i<=31;$i++)
                                                <th> {{$i}}</th>
                                            @endfor
                                        @endif
                                        
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
                                      <td class="width45">
                                                   <!--  <label class="fancy-checkbox">
                                                      <input class="checkbox-tick" type="checkbox" name="checkbox">
                                                      <span></span>
                                                  </label> -->
                                                  @if($user->profile_photo)
                                                  <a href="#">
                                                  <img src="{{asset($user->profile_photo)}}" class="rounded-circle avatar" alt="">
                                                  </a>
                                                  @else
                                                  <a href="#"> <!-- {{ route('empAttendancesrcs',['id'=>$user->id,'name'=>$user->name]) }} SAME 3 -->
                                                  <img src="{{asset('images/nobody_m.original.jpg')}}" class="rounded-circle avatar" alt="">
                                                  </a>
                                                  @endif
                                              </td>
                                          <td><a href="#">
                                                  <h6 class="mb-0">{{$user->name}}</h6>
                                                  <span>{{$user->email}}</span></a>
                                              </td>
                                              @if(Auth::user()->hasRole(['Super Admin', 'Admin','Employee']))
                                              <td><span>{{$user->emp_id}}</span></td>
                                                
                                        @if($nowmonth=="09" ||$nowmonth=="04"||$nowmonth=="06"||$nowmonth=="11")
                                        <?php $a30=0;?>
                                            @for($i=1;$i<=30;$i++)
                                            <?php
                                                $stat30=null;
                                                
                                             ?>

                                            <td>
                                            
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
                                                    A
                                                    <?php $a30=$a30+1;?>
                                                
                                                @endif
                                            </td>
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
                                            <td>
                                            
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
                                                    A
                                                    <?php $a2=$a2+1;?>
                                                
                                                @endif
                                            </td>
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
                                                <td>
                                                    @foreach($attendance as $att)
                                                        <?php $mon= explode("-", $att->date); 
                                                            
                                                        ?>
                                                        @if($att->emp_id == $user->emp_id && $mon[0] == $i && $mon[1] == $nowmonth && $mon[2] == $nowyear)
                                                            {{$att->status}}
                                                            <?php 
                                                                $stat=1;
                                                            ?>
                                                        @else
                                                        @endif

                                                    @endforeach
                                                @if($stat == null)
                                                    A
                                                    <?php $a=$a+1;?>
                                                
                                                @endif
                                                    
                                                </td>
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
  </div>

                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
