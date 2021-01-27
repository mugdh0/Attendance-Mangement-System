   
@extends('back-end.master')
@section('title')
EMS payroll
@endsection
@section('statusPayroll')
active
@endsection
@section('content')
 <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Payslip</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Payroll</li>
                            <li class="breadcrumb-item active">Payslip</li>
                        </ul>
                    </div>            
 
                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">

                <div class="col-lg-12 col-md-12">


                        @if(Session::get('warning'))
                        <div class="alert alert-warning" id="warning">
                            <h6 class=" text-center text-warning"> {{ Session::get('warning') }}</h6>
                        </div>
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



                    <div class="card invoice1">  
                        
                        
                            <div class="header">
         
                                    <ul class="header-dropdown">
                                            {{-- <li><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#addNewIncome">Add New</a></li> --}}
                                            
                                            @if(!empty($next))
                                        <li>
                                            <a data-toggle="tooltip" data-placement="bottom" title="Back To Previous Slip" href="{{url('/emp.view-payslip.details/'.$next->employee_email.'/'.$next->employee_name.'/'. $next->id)}}"><i class="fas fa-less-than"></i><h5></h5></a>
                                        </li>
                                        @endif
                            
                                        @if(isset($prev))
                                        <li>
                                            <a data-toggle="tooltip" data-placement="bottom" title="Go To Next Slip" href="{{url('/emp.view-payslip.details/'.$prev->employee_email.'/'.$prev->employee_name.'/'. $prev->id)}}"><i class="fas fa-greater-than"></i><h5></h5></a>
                                        </li>
                                        @endif
                                    </ul>
                            </div>

  



                        <div class="body">
                            <div class="invoice-top clearfix">
                                <div class="logo">
                                <img src="{{asset($obj_setting->logo)}}" alt="user" class="img-fluid">
                                </div>
                                <div class="info">
                                <h6>{{$obj_setting->company_name}}</h6>
                                <p>{{$obj_setting->address}}</p>
                                </div>
                                <div class="title">
                                <h4>Invoice #{{ $obj_payslip->id}}</h4>
                                <p>Salary Month: {{Carbon\Carbon::parse($obj_payslip->created_at)->toFormattedDateString()}}
                                   </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-5">
                            <div class="invoice-mid clearfix">      
                                <div class="clientlogo">
                                        @if($obj_payslip->emp_image)
                                        <img src="{{asset($obj_payslip->emp_image)}}" alt="user" class="rounded-circle img-fluid">
                                        @else
                                        <img src="{{asset('images/nobody_m.original.jpg')}}" alt="user" class="rounded-circle img-fluid">
                                        @endif
                                    {{-- <img src="{{ asset('assets/images/sm/avatar2.jpg')}}" alt="user" class="rounded-circle img-fluid"> --}}
                                </div>
                                <div class="info">
                                    <h6>{{ $obj_payslip->employee_name }}</h6>
                                <p>{{$obj_payslip->employee_role}}<br>Employee ID: {{ $obj_payslip->employee_id }}</p>
                               @if($obj_payslip->emp_performance)
                                <p>Performance: 
                                    @if($obj_payslip->emp_performance == 1)
                                    Below Avarage
                                    @elseif($obj_payslip->emp_performance == 2)
                                    Avarage
                                    @elseif($obj_payslip->emp_performance == 3)
                                    Good
                                    @elseif($obj_payslip->emp_performance == 4)
                                    Very Good
                                    @elseif($obj_payslip->emp_performance == 5)
                                    Excellent
                                  
                                    @endif
                                </p>
                                @endif
                                </div>
                            </div>
                           
                        </div>

                        <div class="col-md-2 text-center">
                            <br/>&nbsp;
                            @if($obj_payslip->payment_status=="Paid")
                        <h1 style="z-index:10;border-style: double;border-width: 7px;text-transform: uppercase;
                          -ms-transform: rotate(30deg); /* IE 9 */
                        -webkit-transform: rotate(-30deg); /* Safari 3-8 */
                        transform: rotate(-30deg);
                        color:blue;border-radius: 8px;"><span class="text-danger"> {{$obj_payslip->payment_status}}</span></h1>
                            @endif
                    </div>

                        <div class="col-md-5">
                                @if(Auth::user()->hasRole('Super Admin'))
                                <span class="pull-right" data-toggle="modal" data-target="#editEmpSalary">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="Edit Salary"><i class="fa fa-edit"> Edit Payslip</i></a>
                                </span>

@endif















                                    <!-- Edit EMP -->
                                    <div class="modal animated zoomIn" id="editEmpSalary" tabindex="-1" role="dialog">
                                            <div class="modal-dialog  modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="title" >Update Payslip</h6>
                                                    </div>
                                                    <form method="post" action="{{ route('update-payslip-info-by-super-admin') }}" enctype='multipart/form-data'>
                                                        <div class="modal-body">
                                                            <div class="row clearfix">
    
                                                                @csrf

                                                                <div class="col-6">
                                                                    <div class="form-group">                                    
                                                                    <input type="number" class="form-control" required data-toggle="tooltip" data-placement="top" value="{{ $obj_payslip->basic_salary }}" name="basic_salary" placeholder="Basic Salary" title="Basic Salary">
                                                                        <input type="hidden" name="payslip_id" value="{{$obj_payslip->id}}">
                                                                     
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">                                   
                                                                        <input type="number" class="form-control" data-toggle="tooltip" data-placement="top" value="{{ $obj_payslip->house_rent_allowance }}" name="house_rent_allowance" placeholder="House Rent Allowance"title="House Rent Allowance">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">                                    
                                                                        <input type="number" class="form-control" data-toggle="tooltip" data-placement="top" value="{{ $obj_payslip->bonus }}" name="bonus" placeholder="Bonus"title="Bonus">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">                                    
                                                                        <input type="number" class="form-control" data-toggle="tooltip" data-placement="top" value="{{ $obj_payslip->conveyance }}" name="conveyance" placeholder="Conveyance" title="Conveyance">
                                                                    </div>
                                                                </div>


                                                            <div class="col-md-4">

                                                            </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">                                    
                                                                        <input type="number" class="form-control" data-toggle="tooltip" data-placement="top" value="{{ $obj_payslip->other_allowance }}" name="other_allowance" placeholder="Other Allowance" title="Other Allowance">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
    
                                                                </div>
                                                                <div class="col-md-12">
                                                                        <hr/>
                                                                    </div>
   


                    <div class="col-6">
                            <div class="form-group">                                    
                                <input type="number" class="form-control" value="{{ $obj_payslip->TDS }}" data-toggle="tooltip" data-placement="top" name="TDS" placeholder="Tax Deducted at Source (T.D.S.) Salary" title="Tax Deducted at Source (T.D.S.) Salary">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">                                   
                                <input type="number" class="form-control" value="{{ $obj_payslip->provident_fund }}" data-toggle="tooltip" data-placement="top" name="provident_fund" placeholder="Provident Fund" title="Provident Fund">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">                                    
                                <input type="number" class="form-control" value="{{ $obj_payslip->c_bank_loan }}" name="c_bank_loan" data-toggle="tooltip" data-placement="top" placeholder="C/Bank Loan" title="C/Bank Loan">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">                                    
                                <input type="number" class="form-control" value="{{ $obj_payslip->other_deductions }}" name="other_deductions" placeholder="Other Deductions" title="Other Deductions" data-toggle="tooltip" data-placement="top">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">                                    
                                    <select required class="form-control show-tick" name="emp_performance">
                                            <option value="">Select Performance Rating</option>
                                            
                                                <option value="1" @if($obj_payslip->emp_performance == 1) selected @endif>Below Average</option>
                                                <option value="2" @if($obj_payslip->emp_performance == 2) selected @endif>Average</option>
                                                <option value="3" @if($obj_payslip->emp_performance == 3) selected @endif>Good</option>
                                                <option value="4" @if($obj_payslip->emp_performance == 4) selected @endif>Very Good</option>
                                                <option value="5" @if($obj_payslip->emp_performance == 5) selected @endif>Excellent</option>
                                            
                                    </select>
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
              <!--   <div class="modal-footer">
    
              </div> -->
          </div>
      </div>
    </div>
    
    













                            </div>
                        </div>
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="thead-success">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Earnings</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Basic Salary</td>
                                                    <td>Tk {{ $obj_payslip->basic_salary }}</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>House Rent Allowance (H.R.A.)</td>
                                                    <td>Tk @if($obj_payslip->house_rent_allowance){{ $obj_payslip->house_rent_allowance }}@else 0 @endif</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Bonus</td>
                                                    <td>Tk @if($obj_payslip->bonus){{ $obj_payslip->bonus }}@else 0 @endif</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Conveyance</td>
                                                    <td>Tk @if($obj_payslip->conveyance){{ $obj_payslip->conveyance }}@else 0 @endif</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Other Allowance</td>
                                                    <td>Tk @if($obj_payslip->other_allowance){{ $obj_payslip->other_allowance }}@else 0 @endif</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><strong>Total Earnings</strong></td>
                                                    <td><strong>Tk {{ $total_earning}}</strong></td>
                                                </tr>
                                            </tbody>                                            
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="thead-danger">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Deductions</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Tax Deducted at Source (T.D.S.)</td>
                                                    <td>Tk @if($obj_payslip->TDS){{ $obj_payslip->TDS }}@else 0 @endif</td>
                                                </tr>
                                                {{-- <tr>
                                                    <td>2</td>
                                                    <td>ESI</td>
                                                    <td>$0</td>
                                                </tr> --}}
                                                <tr>
                                                    <td>3</td>
                                                    <td>Provident Fund</td>
                                                    <td>Tk @if($obj_payslip->provident_fund){{ $obj_payslip->provident_fund }}@else 0 @endif</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>C/Bank Loan</td>
                                                    <td>Tk @if($obj_payslip->c_bank_loan){{ $obj_payslip->c_bank_loan }}@else 0 @endif</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Other Deductions</td>
                                                    <td>Tk @if($obj_payslip->other_deductions){{ $obj_payslip->other_deductions }} @else 0 @endif</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><strong>Total Deductions</strong></td>
                                                    <td><strong>Tk {{ $total_deductions }}</strong></td>
                                                </tr>
                                            </tbody>                                            
                                        </table>
                                    </div>
                                </div>
                            </div>                            
                            <hr>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <h5>Note</h5>
                                    <p>{{$obj_setting->payslip_note}}</p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <p class="m-b-0"><b>Total Earnings:</b> Tk {{ $total_earning}}</p>
                                    <p class="m-b-0"><b>Total Deductions:</b> Tk {{ $total_deductions }}</p>
                                    <h5 class="m-b-0 m-t-10">Net Salary Tk {{ $total_earning-$total_deductions}}</h5>
                                </div>                                    
                                <div class="hidden-print col-md-12 text-right">
                                    <hr>
                                <a href="{{route('print-payslip',['email'=>$obj_payslip->employee_email,'name'=>$obj_payslip->employee_name,'id'=>$obj_payslip->id])}}" class="btn btn-outline-secondary"><i class="icon-printer"></i></a>
                                    {{-- <button class="btn btn-primary">Submit</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection