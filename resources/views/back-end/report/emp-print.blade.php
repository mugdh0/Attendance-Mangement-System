<div class="body">
<div style="align:center;">
</div>
                        <div class="table-responsive">
                            <table border=1 align=center style="border-collapse: collapse; text-align:center;" class="table table-hover js-basic-example dataTable table-custom table-striped m-b-0 c_list">
                                <thead class="thead-dark">
                                    <tr>
                                        
                                       <th>Name</th>
                                       @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                       <th>Emp ID</th>
                                       <th>Department</th>
                                       <th>Designation</th>
                                       <th>In Time</th>
                                       <th>Out Time</th>
                                       <th>Holidays</th>
                                       
                                       
                                       @endif
                                   </tr>
                               </thead>
                               <tbody>
                                @foreach($userList as $user)
                                <tr>
                                    
                                        <td>
                                                <h4 class="mb-0">{{$user->name}}</h4>
                                            </td>
                                            @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                            <td><span>{{$user->emp_id}}</span></td>
                                            <td>{{$user->department}}</td>
                                            @endif
                                            <td>{{$user->designation}}</td>

                                                <td><?php $tt = 0;?>
                                                @foreach($inout_time as $iotime)
                                                    @if($iotime->user_id == $user->emp_id)
                                                        
                                                        <?php 
                                                                $time= explode(":", $iotime->in_time);
                                                                if($time[0]>12){
                                                                    $time[0]=$time[0]-12;
                                                                    $sn= $time[0].":".$time[1]. " PM";
                                                                }else{
                                                                    $sn= $time[0].":".$time[1]. " AM";
                                                                }
                                                                $tt=1;
                                                                ?>
                                                {{$sn}}
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                @foreach($inout_time as $iotime)
                                                    @if($iotime->user_id == $user->emp_id)
                                                        <?php 
                                                                $time2= explode(":", $iotime->out_time);
                                                                if($time2[0]>12){
                                                                    $time2[0]=$time2[0]-12;
                                                                    $en= $time2[0].":".$time2[1]. " PM";
                                                                }else{
                                                                    $en= $time2[0].":".$time2[1]. " AM";
                                                                }
                                                                $tt=1;
                                                                ?>
                                            {{$en}}
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                <?php $hh = 0;?>
                                                    @foreach($holidays as $holiday)
                                                        @if($holiday->emp_id ==$user->emp_id)
                                                        <?php 
                                                            $hol = explode(",",$holiday->date);
                                                            $hh=1;
                                                            ?>
                                                            
                                                            @foreach($hol as $hl)
                                                            {{ $hl }} [{{\Carbon\Carbon::parse($hl)->format('l')}}]<br>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </td>
                                    </tr>

@endforeach


</tbody>
</table>
</div>
</div>