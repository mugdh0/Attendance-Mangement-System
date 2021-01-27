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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a>In Out Time Settings</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Employee</li>
                            <li class="breadcrumb-item active">In Out Settings</li>
                        </ul>
                    </div>

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                      <div class="header">

                          <h2> In Out Time Settings </h2>


                          @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                          <ul class="header-dropdown">
                            <li><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#add_attendence"><i data-toggle="tooltip" data-placement="top" title="Add New" style="color:#f58c1f" class="fas fa-plus"></i></a></li>
                            <!--<li><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#import"><i data-toggle="tooltip" data-placement="top" title="import" style="color:#f58c1f" class="fas fa-file-download"></i></a></li>
                             <li><a href="users/export/" class=" btn-default" style="padding: 0px 6px;font-size: 12px;"><i data-toggle="tooltip" data-placement="top" title="export" style="color:#f58c1f" class="fas fa-file-upload"></i></a></li>
                             -->
                      
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
                                         <th>In Time</th>
                                         <th>Out Time</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>

                                   @if(count($in_outSettings)>0)
                                  @foreach($in_outSettings as $user)
                                  <tr>
                                            <td class="width45">
  <!--                                             <label class="fancy-checkbox">
                                                      <input class="checkbox-tick" type="checkbox" name="checkbox">
                                                      <span></span>
                                                  </label> -->
                                                  @if($user->profile_photo)
                                                  <a href="{{ route('empAttendancesrcs',['id'=>$user->id,'name'=>$user->name]) }}">
                                                  <img src="{{asset($user->profile_photo)}}" class="rounded-circle avatar" alt="">
                                                  </a>
                                                  @else
                                                  <a href="{{ route('empAttendancesrcs',['id'=>$user->id,'name'=>$user->name]) }}">
                                                  <img src="{{asset('images/nobody_m.original.jpg')}}" class="rounded-circle avatar" alt="">
                                                  </a>
                                                  @endif
                                              </td>
                                          <td><a href="{{ route('empAttendancesrcs',['id'=>$user->emp_id,'name'=>$user->name]) }}">
                                                  <h6 class="mb-0">{{$user->name}}</h6>
                                                  <span>{{$user->email}}</span></a>
                                              </td>
                                              @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                              <td><span>{{$user->emp_id}}</span></td>

                                              @endif

                                              <?php 
                                                                $time= explode(":", $user->in_time);
                                                                if($time[0]>12){
                                                                    $time[0]=$time[0]-12;
                                                                    $sn= $time[0].":".$time[1]. " PM";
                                                                }else{
                                                                    $sn= $time[0].":".$time[1]. " AM";
                                                                }
                                                                
                                                                ?>
                                            <td>{{$sn}}</td>
                                            <?php 
                                                                $time2= explode(":", $user->out_time);
                                                                if($time2[0]>12){
                                                                    $time2[0]=$time2[0]-12;
                                                                    $en= $time2[0].":".$time2[1]. " PM";
                                                                }else{
                                                                    $en= $time2[0].":".$time2[1]. " AM";
                                                                }
                                                                
                                                                ?>
                                            <td>{{$en}}</td>
                                            <td><span data-toggle="modal" data-target="#edit_attendence-{{$user->id}}">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                            </span>
                                              {{--<a href="{{ route('deleteAttendencetimeing',['id'=>$user->id]) }}" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-type="confirm"><i class="fa fa-trash-o"></i></a>--}}
                                              </td>
                                      </tr>

<div class="modal animated lightSpeedIn" id="edit_attendence-{{$user->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title" id="defaultModalLabel">Add Attendance</h6>
                </div>
                 <form method="POST" action="{{ route('update-att-timing-settings') }}">
                    @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-12">
                          <select required class="form-control mb-3 show-tick" name="attendence_of">
                            <option>{{$user->id}} {{$user->emp_id}} ( {{$user->name}} )</option>

                      </select>

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



    <div class="modal animated lightSpeedIn" id="add_attendence" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title" id="defaultModalLabel">Add Attendance</h6>
                </div>
                 <form method="POST" action="{{ route('att-timing-settings') }}">
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
    <div class="modal animated lightSpeedIn" id="import" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title" id="defaultModalLabel">import In Out Time</h6>
                </div>
                <div class="col-md-12">
                  <form class="form-group" action="{{ route('importInOut') }}" enctype="multipart/form-data" method="post">
                    @csrf
                  <input type="file" name="file" accept=".xlsx">
                </div>

                <div class="col-12 ">
                            <div class="form-group float-right">
                                <button type="submit" name="import" value="import" class="btn btn-primary">import</button>
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

@endsection
