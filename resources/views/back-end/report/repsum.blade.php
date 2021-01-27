<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        tr{
            border:1px solid black;
        }
    </style>
</head>
<body>
<div>
                          <div>
                          <h4 style="margin-left:250px;">Result Of Month:
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
                                      <span style="color: red">{{$nowyear}} </span>
                                    </h4>
                              <table border="1" style="border-collapse: collapse; text-align:center;
            margin: auto;" >
                                  <thead >
                                      <tr>
                                         <th>Name</th>
                                         <th>Emp ID</th>
                                         <th>Designation</th>
                                         <th>Department</th>
                                        @if($nowmonth=="09" ||$nowmonth=="04"||$nowmonth=="06"||$nowmonth=="11")

                                            @for($i=1;$i<=30;$i++)
                                                 {{$i}}
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
                                                 {{$i}}
                                            @endfor
                                        @else
                                            @for($i=1;$i<=31;$i++)
                                                 {{$i}}
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
                                      
                                          <td>
                                                  <h4>{{$user->name}}</h4>
                                                  </span>
                                              </td>
                                              @if(Auth::user()->hasRole(['Super Admin', 'Admin','Employee']))
                                              <td>{{$user->emp_id}}</td>
                                              <td>{{$user->designation}}</td>
                                              <td>{{$user->department}}</td>
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
                                                    A
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
</body>
</html>