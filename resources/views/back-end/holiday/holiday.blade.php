
@extends('back-end.master')
@section('title')
EMS Holiday
@endsection
@section('statusHD')
active
@endsection
@section('content')
<div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Holidays</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Holidays</li>
                        </ul>
                    </div>

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>Holidays List</h2>





						@if(Session::get('message'))
                        <div class="alert alert-success" id="message">
                            <h6 class=" text-center text-success"> {{ Session::get('message') }}</h6>
                        </div>
                        @endif

                        @if(Session::get('warning'))
                        <div class="alert alert-warning" id="message">
                            <h6 class=" text-center text-warning"> {{ Session::get('warning') }}</h6>
                        </div>
                        @endif

                        @if(Session::get('danger'))
                        <div class="alert alert-danger" id="message">
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

                        @if(Auth::user()->hasRole(['Super Admin', 'Admin','Employee']))
                        <ul class="header-dropdown">
                                <li><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#addholiday"><i data-toggle="tooltip" data-placement="top" title="Add Holiday" style="color:#f58c1f" class="fas fa-plus"></i></a></li>

                        </ul>
                        @endif

                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table style="table-layout: fixed;" class="table table-hover js-basic-example dataTable table-custom table-striped m-b-0 c_list">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Employee Id</th>
                                            <th>Employee name</th>
                                            <th style="white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;">                 
                                                
                                            Holidays</th>

                                            @if(Auth::user()->hasRole(['Super Admin', 'Admin'])) 
                                            
                                            <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                   <tbody>
                                   	
                                       
                                       @foreach($holidays as $holiday)
                                        <tr class="" >
                                            
                                            <!-- <td>{{ $holiday->status }}</td> -->
                                                
                                                <td>
                                                {{ $holiday->emp_id }}
                                                </td>
                                                <td>
                                                {{ $holiday->name }}
                                                </td>
                                                <?php 
                                                $hol = explode(",",$holiday->date);
                                                ?>
                                                 <td style="white-space: nowrap;
                                                    text-overflow: ellipsis;
                                                    overflow: hidden;">                   
                                                <span data-toggle="modal" data-target="#view-{{$holiday->id}}">
                                                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-warning" data-toggle="tooltip" data-placement="top" title="view All"><i class="fa fa-eye"></i></a>
                                              </span>
                                                @foreach($hol as $hl)
                                                {{ $hl }} [{{\Carbon\Carbon::parse($hl)->format('l')}}]

                                                @endforeach
                                                
                                                </td>
                                                @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                                <td>
                                                    <a href="{{ route('delete-holiday',['id'=>$holiday->id]) }}" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></a>
                                                    <span data-toggle="modal" data-target="#editholiday-{{$holiday->id}}">
                                                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                              </span>
                                               </td>
                                            @endif
                                        </tr><div class="modal fade" id="view-{{$holiday->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Holidays</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div style="margin-left:25%" class="modal-body">
      <?php 
                                                $hol = explode(",",$holiday->date);
                                                ?>
                                                 @foreach($hol as $hl)
                                                {{ $hl }} [{{\Carbon\Carbon::parse($hl)->format('l')}}]<br>

                                                @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
                                        <div class="modal animated fadeIn" id="editholiday-{{$holiday->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title">Edit Holidays</h6>
            </div>

                <div class="modal-body">
                  <form method="POST" action="{{ route('update-holidays') }}">
                     @csrf
                 <div class="modal-body">
                     <div class="row clearfix">
                         <div class="col-md-12">
                         <div class="form-group"></div>
                           <select required class="form-control mb-3 show-tick" name="holiday_of">
                           <option>{{$holiday->id}} {{$holiday->emp_id}} ({{$holiday->name}})</option>
                        </div>

                       </select>

                         <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="datepicker_recurring_start form-control" name="date"  placeholder="select Holidays *" value="{{$holiday->date}}" >
                      
                            </div>
                         </div>
                         <div class="col-12 ">
                                     <div class="form-group float-right">
                                         <button type="submit" name="btn" class="btn btn-primary">Update</button>
                                         <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                     </div>
                         </div>
                     </div>
                 </div>
                 </form>
                </div>

<!--             <div class="modal-footer">
                <button type="button" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
            </div> -->
        </div>
    </div>
</div>


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

</div>





<!-- Default Size -->
<div class="modal animated zoomIn" id="addholiday" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel">Add Holiday</h6>
            </div>
            <form method="POST" action="{{ route('add-new-holiday') }}" enctype='multipart/form-data'>
            @csrf
            <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-12">
                          <select required class="form-control mb-3 show-tick" name="holiday_of">
                          <option value="">Select User</option>
                          @foreach($userList as $u)
                            @if($u->role == "Super Admin")

                            @else
                            <option>{{$u->emp_id}} ( {{$u->name}} )</option>

                            @endif
                          @endforeach

                      </select>

                      <div class="form-group">
                          <input type="text" data-provide="datepicker" id="date" name="date" class="form-control" placeholder="select Holidays *">
                      
                      </div>
                      
                      
                        </div>

                        <div class="col-12 ">
                                    <div class="form-group float-right">
                                        <button type="submit" name="btn"  class="btn btn-primary">Add</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                    </div>
                        </div>
                    </div>
                </div>
                </form>
            
          <!--   <div class="modal-footer">

          </div> -->
      </div>
  </div>
</div>






@endsection
