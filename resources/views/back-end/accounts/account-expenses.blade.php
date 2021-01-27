   
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Expenses</h2>
                        <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Accounts</li>
                            <li class="breadcrumb-item active">Expenses</li>
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
                                          <form method="POST" action="{{ route('filter-expense-by-date') }}" enctype='multipart/form-data'>
                                            @csrf
                                        <div class="row" >
                                            <div class="col-md-2">
            
                                            </div>
                                            <div class="col-md-2">
                                                    <select class="form-control mb-3 show-tick" name="accHead">
                            
                                                            <option value="">Select Account Head</option>
                                                            @foreach($obj_accHead as $accHead)
                                                            <option>{{$accHead->head_name}}</option>
                                                        @endforeach
                                                        </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" data-provide="datepicker" name="start_date" placeholder="Start Date" title="Start Date" data-toggle="tooltip" data-placement="top">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" data-provide="datepicker" name="end_date" title="End Date" placeholder="End Date" data-toggle="tooltip" data-placement="top">
                                            </div>
            
                                            <div class="col-md-2">
                                                <input type="submit" class="btn btn-success" name="btn" value="Search">
                                            </div>
                                        </div>
                                    </form>
                                    </div>

                                    <ul class="header-dropdown">
                                            <li><a href="javascript:void(0);" class=" btn-default" style="padding: 0px 6px;font-size: 12px;" data-toggle="modal" data-target="#addExpensesHead"><i data-toggle="tooltip" data-placement="top" title="Add New" style="color:#f58c1f" class="fas fa-plus"></i></a></li>
                            
                                        {{-- <li data-toggle="tooltip" data-placement="top" title="Add New"><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#addExpensesHead"><i class="fas fa-plus text-white"></i></a></li> --}}
                                        <li><a href="javascript:void(0);" onclick="btnToggleFunction()" style="padding: 0px 6px;font-size: 12px;" class="btn-default"><i data-toggle="tooltip" data-placement="top" title="Filter"style="color:#f58c1f" class=" fas fa-filter "></i></a></li>
                                    </ul>
                                    @endif
                                </div>


                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover js-basic-example dataTable table-custom">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Head Name</th>
                                            <th>Amount</th>
                                            <th>Created By</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        @foreach($obj_expenses as $expenses)
                                            <td></td>
                                            <td>{{$expenses->accHead}}</td>
                                            <td>{{$expenses->amount}}</td>
                                            <td>{{$expenses->created_by}}</td>
                                            <td>{{ Carbon\Carbon::parse($expenses->created_at)->toFormattedDateString() }}</td>
                                            <td>
                                                    <span data-toggle="modal" data-target="#editEXP-{{$expenses->id}}">
                                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-success"data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                                    </span>
        
                                                    <a href="{{route('delete-expenses',['id'=>$expenses->id])}}" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-type="confirm"><i class="fa fa-trash-o"></i></a>
                                                </td>
                                        </tr>





                                    <!-- Edit EMP -->
                                    <div class="modal animated zoomIn" id="editEXP-{{$expenses->id}}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="title" >Edit Expenses</h6>
                                                    </div>
                                                    <form method="POST" action="{{ route('edit-expenses') }}" enctype='multipart/form-data'>
                                                        <div class="modal-body">
                                                            <div class="row clearfix">
    
                                                                @csrf
    
                                                                <div class="col-md-6">
                                                                        <select required class="form-control mb-3 show-tick" name="accHead">
                                                                        
                                                                            <option value="">Select Account Head</option>
                                                                            @foreach($obj_accHead as $accHead)
                                                                            <option @if($expenses->accHead== $accHead->head_name)Selected @endif>{{$accHead->head_name}}</option>
                                                                        @endforeach
                                                                        </select>
                                                                    </div>
                              
                                                                <div class="col-md-6">
                                                                    <div class="form-group">                                    
                                                                        <input required type="text" name="amount" value="{{ $expenses->amount }}" class="form-control" placeholder="Amount">
                                                                        <input type="hidden" name="expenses_id" value="{{ $expenses->id }}">
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
<div class="modal animated zoomIn" id="addExpensesHead" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel">Add Income</h6>
            </div>
            <form method="POST" action="{{ route('add-new-expense') }}" enctype='multipart/form-data'>
                <div class="modal-body">
                    <div class="row clearfix">

                        @csrf
                        <div class="col-md-6">
                            <select required class="form-control mb-3 show-tick" name="accHead">
                            
                                <option value="">Select Account Head</option>
                                @foreach($obj_accHead as $accHead)
                                <option>{{$accHead->head_name}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">                                    
                                <input type="number" required name="amount" class="form-control" placeholder="Amount">
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

{{-- <script>
$('#datatable').DataTable({
    "order": [[ 2, "DESC" ]] // Order on init. # is the column, starting at 0
});
</script> --}}



@endsection