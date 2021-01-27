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
                            <li class="breadcrumb-item active">Attendance</li>
                        </ul>
                    </div>

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>
            
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                      <div class="header">

                          <!-- <h2> Today </h2> -->
                          <div id="IdForTaggle" style="display: none;">
                                <br/>&nbsp;
                              <form method="POST" action="{{ route('filter-employee-date') }}" enctype='multipart/form-data'>
                                @csrf
                            <div class="row" >
                                
                            <div class="col-md-2">

                                        
                            <select class="form-control mb-3 show-tick" name="attendence_of">
                          <option value="">Select User</option>
                          @foreach($userList as $u)
                            @if($u->role == "Super Admin")

                            @else
                            <option>{{$u->emp_id}} ( {{$u->name}} )</option>

                            @endif
                          @endforeach

                      </select>

                                </div>
                                <div class="col-md-2">
                                        <input type="text" data-provide="datepicker" class="form-control" name="form" placeholder="form Date" title="form Date" data-toggle="tooltip"
                                        data-placement="top">
                                </div>

                                    <div class="center">
                                            <p>To</p>
                                        </div>
                                <div class="col-md-2">
                                        <input type="text" data-provide="datepicker" class="form-control" name="to" placeholder="to Date" title="to Date" data-toggle="tooltip"
                                        data-placement="top">
                                </div>



                                <div class="col-md-1">
                                    <input type="submit" class="btn btn-success" name="btn" value="OK">
                                </div>
                            </div>
                        </form>
                        </div>
                          <form class="form-group" action="{{route('dailyempAttendance')}}" method="post">
                              @csrf
                              

                          @if(Auth::user()->hasRole(['Super Admin', 'Admin','Employee']))
                          <ul class="header-dropdown">
                            
                              <!-- <li title="pick month">
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
                              </li> -->
                              <li><input id="datepicker" required type="text" name="srcdate" data-date-autoclose="true" class="form-control" placeholder="select date *" >

                              <li>
                                <button type="submit" name="button" class="btn btn-default" ><i title="search" style="color:#f58c1f; border-color: #e7e7e7;" class="fa fa-search"></i></a></button>
                              </li>
                              
                            </form></li>
                            @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                          
                            <li style="margin-left:60px;"><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#add_attendence"><i data-toggle="tooltip" data-placement="top" title="Add New" style="color:#f58c1f" class="fas fa-plus"></i>Add</a></li>
                            @endif
                            <li><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#import"><i data-toggle="tooltip" data-placement="top" title="import" style="color:#f58c1f" class="fas fa-file-download"></i> Import</a></li>
                            <!-- <li><a href="javascript:void(0);" onclick="btnToggleFunction()" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" class="btn btn-info"><i data-toggle="tooltip" data-placement="top" title="Filter" style="color:#f58c1f" class="fas fa-filter"></i></a></li> -->
                            <!-- <li><a href="users/export/" class=" btn-default" style="padding: 0px 6px;font-size: 12px;"><i data-toggle="tooltip" data-placement="top" title="export" style="color:#f58c1f" class="fas fa-file-upload"></i></a></li>
                             -->
                            <!-- <li data-toggle="tooltip" data-placement="top" title="Filter Emp">
                                    <select class="form-control mb-3 show-tick" onchange="window.location = $(':selected', this).attr('href')" name="job_status">
                                            <option href="{{ route('emp-attendance-short')}}">Filter By</option>

                                            <option href="{{url('app-emp/search/latetoday')}}" >Late</option>
                                            <option href="{{url('app-emp/search/presenttoday')}}" >Present</option>
                                            

                                    </select>

                            </li> -->
                            
                          </ul>
                          
                       
                        @endif

                      </div>
                      @if(Session::get('message'))
                      <div class="alert alert-success" id="message">
                          <h6 class=" text-center text-success"> {{ Session::get('message') }}</h6>
                      </div>
                      @endif

                      @if(Session::get('warning'))
                      <div class="alert alert-warning" id="warning">
                          <h6 class=" text-center text-warning"> {{ Session::get('warning') }}</h6>
                      </div>
                      @endif
                      @if(Session::get('danger'))
                      <div class="alert alert-danger" id="danger">
                          <h6 class=" text-center text-danger"> {{ Session::get('danger') }}</h6>
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
                      <!-- end head -->
                      <div class="body">
                          <div class="table-responsive">
                              <table class="table table-hover js-basic-example dataTable table-custom table-striped m-b-0 c_list">
                                  <thead class="thead-dark">
                                      <tr>

                                          <th>
                                              <label class="fancy-checkbox">
                                                 <!--    <input class="select-all" type="checkbox" name="checkbox"> -->

                                             </label>
                                         </th>
                                         <th>Name</th>
                                         <th>Emp ID</th>
                                         <th>Date</th>
                                         <th>In Time</th>
                                         <th>Out Time</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>

                                   @if(count($attendence_today)>0)
                                  @foreach($attendence_today as $user)
                                  <?php 
                                        $date = explode("-",$user->date);
                                        
                                  ?>
                                  @if($date[0]==$nowdate && $date[1]==$nowmonth && $date[2]==$nowyear)
                                  <tr>
                                            <td class="width45">
  <!--                                             <label class="fancy-checkbox">
                                                      <input class="checkbox-tick" type="checkbox" name="checkbox">
                                                      <span></span>
                                                  </label> -->
                                                  @if($user->profile_photo)
                                                  
                                                  <img src="{{asset($user->profile_photo)}}" class="rounded-circle avatar" alt="">
                                                  
                                                  @else
                                                  
                                                  <img src="{{asset('images/nobody_m.original.jpg')}}" class="rounded-circle avatar" alt="">
                                                  
                                                  @endif
                                              </td>
                                          <td>
                                                  <h6 class="mb-0">{{$user->name}}</h6>
                                                  
                                              </td>
                                              
                                              <td><span>{{$user->emp_id}}</span></td>

                                              

                                            <td>{{$user->date}}</td>
                                            <?php 
                                                                if($user->time_in == null){
                                                                    $sn=$user->status;
                                                                }else{
                                                                    $time= explode(":", $user->time_in);
                                                                if($time[0]>12){
                                                                    $time[0]=$time[0]-12;
                                                                    $sn= $time[0].":".$time[1]. " PM";
                                                                }else{
                                                                    $sn= $time[0].":".$time[1]. " AM";
                                                                }
                                                                }
                                                                
                                                                
                                                                ?>
                                            <td>{{$sn}}</td>
                                            <?php               
                                            if($user->time_out == null){

                                                $en = $user->status;
                                            }else{
                                                                $time2= explode(":", $user->time_out);
                                                                if($time2[0]>12){
                                                                    $time2[0]=$time2[0]-12;
                                                                    $en= $time2[0].":".$time2[1]. " PM";
                                                                }else{
                                                                    $en= $time2[0].":".$time2[1]. " AM";
                                                                }
                                            }
                                                                
                                                                ?>
                                            <td>{{$en}}</td>
                                            @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                          
                                            <td><span data-toggle="modal" data-target="#edit_attendence-{{$user->id}}">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                            </span>
                                              <a href="{{ route('deleteAttendence',['id'=>$user->id]) }}" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-type="confirm"><i class="fa fa-trash-o"></i></a>
                                              </td>

                                              @endif
                                      </tr>
                                      @endif

        <div class="modal animated fadeIn" id="edit_attendence-{{$user->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title" id="defaultModalLabel">edit Attendance</h6>
                </div>
                 <form method="POST" action="{{ route('updateAttendence') }}">
                    @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-12">
                          <select required class="form-control mb-3 show-tick" name="attendence_of">
                          
                            <option>{{$user->id}} {{$user->emp_id}} ( {{$user->name}} )</option>


                      </select>

                      <div class="form-group">
                          <input required type="text" data-provide="datepicker" name="date" data-date-autoclose="true" class="form-control" placeholder="Date *" value="{{$user->date}}">
                      
                      </div>
                      
                      <div class="form-group"> In Time
                      <input type="time" onchange="onTimeChange()" value="{{$user->time_in}}" id="timeInput"  name="in_time" class="form-control" placeholder="time in" data-toggle="tooltip"
                         data-placement="top" >
                      </div>
                      <div class="form-group"> Out time
                      <input type="time" onchange="onTimeChange()" value="{{$user->time_out}}" id="timeInput"  name="out_time" class="form-control" placeholder="time out" data-toggle="tooltip"
                         data-placement="top" >
                      </div>

                        </div>

                        <div class="col-12 ">
                                    <div class="form-group float-right">
                                        <button type="submit" name="btn"  class="btn btn-primary">add</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                    </div>
                        </div>
                    </div>
                </div>
                </form>
          <!--       <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                </div> -->
            </div>
        </div>
    </div>
  @endforeach
  @else
  @endif

  </tbody>
  </table>
  </div>
  </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal animated fadeIn" id="add_attendence" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title" id="defaultModalLabel">Add Attendance</h6>
                </div>
                 <form method="POST" action="{{ route('addAttendence') }}">
                    @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-12">
                          <select required class="form-control mb-3 show-tick" name="attendence_of">
                          <option value="">Select User</option>
                          @foreach($userList as $u)
                            @if($u->role == "Super Admin")

                            @else
                            <option>{{$u->emp_id}} ( {{$u->name}} )</option>

                            @endif
                          @endforeach

                      </select>

                      <div class="form-group">
                          <input required type="text" data-provide="datepicker" name="date" data-date-autoclose="true" class="form-control" placeholder="Date *">
                      
                      </div>
                      
                      <div class="form-group"> In Time
                      <input type="time" onchange="onTimeChange()" value="onTimeChange()" id="timeInput"  name="in_time" class="form-control" placeholder="time in" data-toggle="tooltip"
                         data-placement="top" >
                      </div>
                      <div class="form-group"> Out time
                      <input type="time" onchange="onTimeChange()" value="onTimeChange()" id="timeInput"  name="out_time" class="form-control" placeholder="time out" data-toggle="tooltip"
                         data-placement="top" >
                      </div>

                        </div>

                        <div class="col-12 ">
                                    <div class="form-group float-right">
                                        <button type="submit" name="btn"  class="btn btn-primary">add</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                    </div>
                        </div>
                    </div>
                </div>
                </form>
          <!--       <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                </div> -->
            </div>
        </div>
    </div>
    <div class="modal animated fadeIn" id="import" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title" id="defaultModalLabel">Upload Attendance</h6>
                </div>
                <div class="col-md-12">
                  <form class="form-group" action="{{ route('import') }}" enctype="multipart/form-data" method="post">
                    @csrf
                  <input type="file" name="file" accept=".xls">
                </div>

                <div class="col-12 ">
                            <div class="form-group float-right">
                                <button type="submit" name="import" value="import" class="btn btn-primary">Upload</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                            </div>
                </div>
                </form>
          <!--       <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                </div> -->
            </div>
        </div>
    </div>

<!-- edit attendance -->

@endsection
