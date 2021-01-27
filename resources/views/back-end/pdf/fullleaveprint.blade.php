
                        <div class="table-responsive">
                                <table border=1 align=center style="border-collapse: collapse; text-align:center;">
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
                        