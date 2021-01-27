   
@extends('back-end.master')
@section('title')
EMS Payments
@endsection
@section('statusAcc')
active
@endsection
@section('content')

 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Payments</h2>
                        <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Accounts</li>
                            <li class="breadcrumb-item active">Payments</li>
                        </ul>
                    </div>            

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">


                    <div class="header">

                        <h2>Account Head</h2>


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
                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if(Auth::user()->hasRole('Super Admin'))


                       
                        <div id="IdForTaggle" style="display: none;">
                                <br/>&nbsp;
                              <form method="POST" action="{{ route('filter-acc-head') }}" enctype='multipart/form-data'>
                                @csrf
                            <div class="row" >
                                <div class="col-md-2">

                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" data-provide="datepicker" name="created_date" placeholder="Created Date" title="Created Date" data-toggle="tooltip" data-placement="top">
                                </div>
                             

                                <div class="col-md-2">
                                    <input type="submit" class="btn btn-success" name="btn" value="Search">
                                </div>
                            </div>
                        </form>
                        </div>


                        <ul class="header-dropdown">
                                <li><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#addAccountHead"><i data-toggle="tooltip" data-placement="top" title="Add Account Head" style="color:#f58c1f" class="fas fa-plus"></i></a></li>
                            
                            {{-- <li><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#addAccountHead"><i class="fas fa-plus text-white" data-toggle="tooltip" data-placement="top" title="Add New"></i></a></li> --}}
                            <li><a href="javascript:void(0);" onclick="btnToggleFunction()" class="btn-default" style="padding: 0px 6px;font-size: 12px;"><i data-toggle="tooltip" data-placement="top" title="Filter" style="color:#f58c1f" class="fas fa-filter"></i></a></li>
                        </ul>
                        @endif
                    </div>

                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Head Name</th>
                                            <th>Head Description</th>
                                            <th>Created By</th>
                                            <th>Status</th>
                                            <th>Created date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($obj_accHead as $accHead)
                                            <tr>
                                                <td>{{$accHead->id}}</td>
                                                <td>{{$accHead->head_name}}</td>
                                                <td>{{$accHead->head_description}}</td>
                                                <td>{{$accHead->created_by}}</td>
                                                <td>{{$accHead->status}}</td>
                                                <td>{{$accHead->created_at}}</td>
                                         <td>
@if($accHead->status==='Inactive')
    <a href="{{ route('active-acc-head',['id'=>$accHead->id,'name'=>$accHead->head_name]) }}" class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="Active"><i class="fa fa-arrow-up"></i></a>
@else
    <a href="{{ route('inactive-acc-head',['id'=>$accHead->id,'name'=>$accHead->head_name]) }}" class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="Inactive" ><i class="fa fa-arrow-down"></i></a>
@endif

                                              <span data-toggle="modal" data-target="#editAccHead-{{$accHead->id}}">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                            </span>

                                            <a href="{{ route('delete-acc-head',['id'=>$accHead->id,'name'=>$accHead->head_name]) }}" data-toggle="tooltip" data-placement="top" class="btn btn-sm btn-outline-danger" title="Delete" data-type="confirm"><i class="fa fa-trash-o"></i></a>



                                        </td>
                                            </tr>






<!-- edit head -->
<div class="modal animated zoomIn" id="editAccHead-{{ $accHead->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="">Edit Account Head</h6>
            </div>
            <form method="POST" action="{{ route('edit-acc-head') }}" enctype='multipart/form-data'>
                <div class="modal-body">
                    <div class="row clearfix">

                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">                                    
                                <input type="text" name="head_name" value="{{$accHead->head_name}}" class="form-control" placeholder="Head Name" required>
                                 <input type="hidden" name="acc_head_id" value="{{$accHead->id}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">                                    
                                <input type="text" name="head_description" value="{{$accHead->head_description}}" class="form-control" placeholder="Head Description">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="inline form-group">  
                                <span class="">Status &nbsp;</span>        
                                <input type="radio" value="Active" name="status" checked placeholder="Head Description"><span> Active</span>
                                  <input type="radio" value="Inactive" name="status" placeholder="Head Description"><span> Inactive</span>
                            </div>
                        </div>



                        <div class="col-12 ">
                            <div class="form-group float-right">                                    
                                <input type="submit" name="btn" value="Add" class="btn btn-primary">
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


<!-- Default Size -->
<div class="modal animated zoomIn" id="addAccountHead" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title" id="">Edit Account Head</h6>
                </div>
                <form method="POST" action="{{ route('add-new-acc-head') }}" enctype='multipart/form-data'>
                    <div class="modal-body">
                        <div class="row clearfix">
    
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group">                                    
                                    <input type="text" name="head_name"  class="form-control" placeholder="Head Name" required>
                                    
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">                                    
                                    <input type="text" name="head_description" class="form-control" placeholder="Head Description">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="inline form-group">  
                                    <span class="">Status &nbsp;</span>        
                                    <input type="radio" value="Active" name="status" checked placeholder="Head Description"><span> Active</span>
                                      <input type="radio" value="Inactive" name="status" placeholder="Head Description"><span> Inactive</span>
                                </div>
                            </div>
    
    
    
                            <div class="col-12 ">
                                <div class="form-group float-right">                                    
                                    <input type="submit" name="btn" value="Add" class="btn btn-primary">
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