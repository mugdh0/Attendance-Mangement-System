@extends('back-end.master')
@section('title')
EMS Employee Department
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
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Departments List</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Employee</li>
                        <li class="breadcrumb-item active">Departments List</li>
                    </ul>
                </div>            

            </div>
            <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Employee List</h2>

                        @if(Auth::user()->hasRole('Super Admin'))
                        <ul class="header-dropdown">
                                <li><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#addDepartments"><i data-toggle="tooltip" data-placement="top" title="Add Department" style="color:#f58c1f" class="fas fa-plus"></i></a></li>
                            
                            {{-- <li><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#addDepartments">Add New</a></li> --}}
                        </ul>
                        @endif

                        @if(Session::get('message'))
                        <div class="alert alert-success" id="message">
                            <h6 class=" text-center text-success"> {{ Session::get('message') }}</h6>
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
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                                <thead>
                                    <tr>
                                            
                                        <th>#</th>
                                        
                                        <th>Department Name</th>
                                        <th>Department Head</th>
                                        <th>Total Employee</th>
                                        @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1 @endphp
                                    @foreach($obj_dept as $dept)
                 

                                @php
                                    $countEMP=\App\User::where('dept_name',$dept->dept_name)->count();
                                @endphp
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td><h6 class="mb-0">{{ $dept->dept_name }}</h6></td>
                                        <td>{{ $dept->dept_head }}</td>
                                        <td>{{ $countEMP }}</td>


                                        @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                        <td>
                                          <span data-toggle="modal" data-target="#editDept-{{$dept->id}}">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-success" title="Edit"><i class="fa fa-edit"></i></a>
                                        </span>

                                        <a href="{{ route('delete-dept',['id'=>$dept->id,'name'=>$dept->dept_name]) }}" class="btn btn-sm btn-outline-danger " title="Delete" data-type="confirm"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                  

                                    @endif


                                </tr>







<!-- Edit EMP -->
<div class="modal animated zoomIn" id="editDept-{{$dept->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" >Add Contact</h6>
            </div>
            <form method="POST" action="{{ route('edit-dept-info') }}" enctype='multipart/form-data'>
                <div class="modal-body">
                    <div class="row clearfix">

                        @csrf

                        <div class="col-md-6">
                            <div class="form-group">                                    
                                <input type="text" required class="form-control" value="{{ $dept->dept_name }}" name="dept_name" placeholder="Departments Name">
                                 <input type="hidden" value="{{ $dept->id }}" name="dept_id">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">                                    
                                <input type="text" name="dept_head" value="{{ $dept->dept_head }}" class="form-control" placeholder="Departments Head">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea rows="6" name="short_description" class="form-control no-resize" placeholder="Short Description">{{ $dept->short_description }}</textarea>
                            </div>
                        </div> 

                        <div class="col-12 ">
                            <div class="form-group float-right">                                    
                                <input type="submit" name="btn" value="Update" class="btn btn-primary">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                            </div>
                        </div>



                    </div>
                </div>
            </form>
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
<div class="modal animated bounceIn" id="addDepartments" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel">Add Departments</h6>
            </div>
            <form method="POST" action="{{ route('add-new-dept') }}">
                @csrf
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">                                    
                                <input type="text" class="form-control" name="dept_name" placeholder="Departments Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">                                    
                                <input type="text" name="dept_head" class="form-control" placeholder="Departments Head">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea rows="6" name="short_description" class="form-control no-resize" placeholder="Short Description"></textarea>
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
<!--             <div class="modal-footer">
                <button type="button" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
            </div> -->
        </div>
    </div>
</div>


@endsection