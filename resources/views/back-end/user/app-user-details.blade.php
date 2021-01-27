
@extends('back-end.master')
@section('title')
EMS User Details
@endsection
@section('appUser')
active
@endsection
@section('content')


<div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">





                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Employee Details</h2>
                        <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Employee</li>
                            <li class="breadcrumb-item active">{{ $user->name }}</li>
                        </ul>
                    </div>

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">

                            <h2>Employee Details</h2>


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
                                <div class="row">


<div class="col-md-12 text-center">

<div class="container" id=profileCon>
        @if($user->profile_photo)
        <a href="#">
            <img class="imgProfile"  src="{{ asset($user->profile_photo) }}" class="img-thumbnail">
        </a>
        @else
        <a href="#">
        <img class="imgProfile"  src="{{asset('images/nobody_m.original.jpg')}}" class="img-thumbnail">
        </a>
        @endif
      </div>



      <br/>&nbsp;



    </div>


</div>
<div class="col-md-12">
<div class="row">
                                        <div class="col-md-6">
                                           <table class="table" width="100%">
                                               <tr class="">
                                                   <th style="width: 50%" class="" scope="col">Name</th>
                                                   <td style="width: 50%" data-title="Name">{{ $user->name }}</td>

                                               </tr>
                                               <tr class="">
                                                   <th scope="col">Email</th>
                                                   <td data-title="Email">{{ $user->email }} &nbsp; &nbsp; &nbsp;
                                                    {{-- <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a> 
                                                    @if(Auth::user()->hasRole(['Super Admin']))
                                                    <a type="button" class="btn btn-default" style="padding: 0px 6px;font-size: 12px;" href="javascript:void(0);" data-toggle="modal" data-target="#userEmailChange-{{$user->id}}" style="color: blue">
                                                        <span style="color: #357705" data-toggle="tooltip" data-placement="top" title="Change email Address"><i class="fa fa-edit"></i> </span>
                                                    </a>
                                                    @endif--}}
                                                </td>
                                               </tr>
                                               @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                               <tr class="">
                                                   <th scope="col">Phone No</th>

                                                   <td data-title="Email">{{ $user->phone_no }}</td>

                                               </tr>
                                               <tr class="">
                                                   <th scope="col">Employee ID</th>

                                                   <td data-title="EMployee Id">{{ $user->emp_id }} &nbsp; &nbsp; &nbsp;
                                                   {{--@if(Auth::user()->hasRole(['Super Admin']))
                                                    <a type="button" class="btn btn-default" style="padding: 0px 6px;font-size: 12px;" href="javascript:void(0);" data-toggle="modal" data-target="#userIdChange-{{$user->id}}" style="color: blue">
                                                        <span style="color: #357705" data-toggle="tooltip" data-placement="top" title="Change Employee Id"><i class="fa fa-edit"></i> </span>
                                                    </a>
                                                    @endif --}}
                                                </td>

                                               </tr>
                                               <tr class="">
                                                    <th scope="col">Join Date</th>

                                                    <td data-title="Join Date">{{ $user->join_date }}
                                                    </td>

                                                </tr>
                                                @endif
                                                <tr class="">
                                                        <th scope="col">Role</th>
                                                        <td data-title="Role">{{ $user->role }}</td>
                                                    </tr>

                                           </table>
                                       </div>
                                        <div class="col-md-6 float-right">
                                                <table class="table" width="100%">
                                                        <!-- <tr class="">
                                                                <th scope="col">Department</th>
                                                                <td data-title="Join Date">{{ $user->dept_name }}</td>
                                                        </tr> -->
                                                <tr class="">
                                                        <th scope="col">Gender</th>
                                                        <td data-title="Gender">{{ $user->gender }}</td>
                                            </tr>


                                                @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                                <tr class="">
                                                        <th scope="col">Date of birth</th>

                                                        <td data-title="Join Date">{{ $user->date_of_birth }}</td>

                                                    </tr>
                                                <!-- <tr class="">
                                                        <th scope="col">Job Status</th>
                                                        <td data-title="Job Status">{{ $user->job_status }}</td>
                                            </tr> -->
                                           <!-- <tr class="">
                                               <th scope="col">User Type</th>
                                               <td data-title="Role">
                                                   {{$user->roles->first()->name}}

                                               </td>
                                           </tr> -->
                                           @endif
                                           <tr class="">
                                                <th scope="col">Blood Group</th>

                                                <td data-title="Join Date">{{ $user->blood_group }}</td>

                                            </tr>

                                       </table>
                                       </div>
                                       </div>
                                       </div>
                @if(Auth::user()->hasRole(['Super Admin','Admin']))

                &nbsp;

                <div class="col-md-12">
                    <div onclick="btnToggleFunction2()" class="panel-header btn btn-default btn-block">
                            <a><h6 class="text-left"><i class="fas fa-list" ></i> &nbsp;Referance</h6></a>
                        </div>
                        <div id="IdForTaggle2" style="display: none" class="panel-body ">


                                        <table class="table" width="100%">
                                            <tr class="">
                                                <th style="width: 50%" class="" scope="col">Referance Name</th>
                                                <td style="width: 50%" data-title="Referance Name">{{ $user->referance_name }}</td>

                                            </tr>
                                            <tr class="">
                                                <th scope="col">Referance Phone</th>
                                                <td data-title="Referance phone">{{ $user->referance_phn }}</td>
                                            </tr>
                                            <tr class="">
                                                <th scope="col">Relation with</th>
                                                <td data-title="Relation with Referanvce">{{ $user->referance_rel }}</td>
                                            </tr>


                                        </table>



                        </div>
               </div>
                <br>
               <div class="col-md-12">
                    <div onclick="btnToggleFunction()" class="panel-header btn btn-default btn-block">
                            <a><h6 class="text-left"><i class="fas fa-list" ></i> &nbsp;Bank Details</h6></a>
                        </div>
                        <div id="IdForTaggle" style="display: none" class="panel-body ">


                                        <table class="table" width="100%">
                                            <tr class="">
                                                <th style="width: 50%" class="" scope="col">Bank Name</th>
                                                <td style="width: 50%" data-title="Bank Name">{{ $user->bank_name }}</td>

                                            </tr>
                                            <tr class="">
                                                <th scope="col">Branch</th>
                                                <td data-title="Branch">{{ $user->branch }}</td>
                                            </tr>
                                            <tr class="">
                                                <th scope="col">Bank A/C No</th>
                                                <td data-title="Bank A/C No">{{ $user->bank_ac }}</td>
                                            </tr>


                                        </table>



                        </div>
               </div>
               <br>
               <div class="col-md-12">
                    <div onclick="btnToggleFunction3()" class="panel-header btn btn-default btn-block">
                            <a><h6 class="text-left"><i class="fas fa-list" ></i> &nbsp;Time & Holiday Details</h6></a>
                        </div>
                        <div id="IdForTaggle3" style="display: none" class="panel-body ">


                                        <table class="table">
                                            <tr >
                                                <th class="" scope="col">In Time</th>
                                                <th class="" scope="col">Out Time</th>
                                                
                                            </tr>
                                            
                                            <tr >
                                            
                                            <?php 
                                                                $time= explode(":", $iotime->in_time);
                                                                if($time[0]>12){
                                                                    $time[0]=$time[0]-12;
                                                                    $sn= $time[0].":".$time[1]. " PM";
                                                                }else{
                                                                    $sn= $time[0].":".$time[1]. " AM";
                                                                }
                                                                
                                                                ?>
                                            <td>{{$sn}}</td>
                                            <?php 
                                                                $time2= explode(":", $iotime->out_time);
                                                                if($time2[0]>12){
                                                                    $time2[0]=$time2[0]-12;
                                                                    $en= $time2[0].":".$time2[1]. " PM";
                                                                }else{
                                                                    $en= $time2[0].":".$time2[1]. " AM";
                                                                }
                                                                
                                                                ?>
                                            <td>{{$en}}</td>
                                            </tr>
                                            <tr class="">
                                                <th scope="col">Holiday</th>
                                                <?php 
                                                if($holiday == null ){
                                                    $c=0;
                                                }else{
                                                    $c=1;
                                                    $hol = explode(",",$holiday->date);
                                                }
                                                
                                                ?>
                                                <td>
                                                @if($c == 0)
                                                    N/A
                                                @else
                                                    @foreach($hol as $hl)
                                                    {{ $hl }} [{{\Carbon\Carbon::parse($hl)->format('l')}}]<br>
                                                    @endforeach
                                                @endif
                                                
                                                </td>
                                            </tr>


                                        </table>



                        </div>
               </div>



@endif




               @if(Auth::user()->hasRole(['Super Admin']))

               <!-- &nbsp;
                                       <div class="col-md-12">
                                            <div onclick="btnToggleFunction()" class="panel-header btn btn-default btn-block">
                                                    <a><h6 class="text-left"><i class="fas fa-list" ></i> &nbsp;Salary Info</h6></a>
                                            </div>
                                                <div id="IdForTaggle" style="display: none" class="panel-body row ">
                                                        <div class="col-md-12">
                                                                <span class="pull-right" data-toggle="modal" data-target="#editEmpSalary">
                                                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="
                                                                        @if(!empty($salary_info->basic_salary))
                                                                        Update Salary
                                                                        @elseif(empty($salary_info->basic_salary)) Add Salary
                                                                        @endif
                                                                        "><i class="fas fa-pencil-alt"></i></a>
                                                                </span>
                                                        </div>

                                                        @if($salary_info)

                                                        <div class="col-md-6">
                                                                <table class="table" width="100%">
                                                                    <tr class="">
                                                                        <th style="width: 50%" class="" scope="col">Basic Salary</th>
                                                                        <td style="width: 50%" data-title="Name">{{ $salary_info->basic_salary }}</td>

                                                                    </tr>
                                                                    <tr class="">
                                                                        <th scope="col">House Rent Allowance</th>
                                                                        <td data-title="Email">{{ $salary_info->house_rent_allowance }}</td>
                                                                    </tr>
                                                                    <tr class="">
                                                                        <th scope="col">bonus</th>
                                                                        <td data-title="Email">{{ $salary_info->Bonus }}</td>
                                                                    </tr>
                                                                    <tr class="">
                                                                        <th scope="col">Conveyance</th>
                                                                        <td data-title="EMployee Id">{{ $salary_info->conveyance }}</td>
                                                                    </tr>
                                                                    <tr class="">
                                                                         <th scope="col">Other Allowance</th>
                                                                         <td data-title="Join Date">{{ $salary_info->other_allowance }}</td>
                                                                     </tr>

                                                                </table>
                                                            </div>
                                                             <div class="col-md-6 float-right">
                                                                     <table class="table" width="100%">
                                                                             <tr class="">
                                                                                     <th scope="col">TDS</th>
                                                                                     <td data-title="Join Date">{{ $salary_info->TDS }}</td>
                                                                             </tr>
                                                                     <tr class="">
                                                                             <th scope="col">Provident fund</th>
                                                                             <td data-title="Gender">{{ $salary_info->provident_fund }}</td>
                                                                 </tr>
                                                                 <tr class="">
                                                                         <th scope="col">Job Status</th>
                                                                         <td data-title="Job Status">{{ $salary_info->c_bank_loan }}</td>
                                                             </tr>
                                                                 <tr class="">
                                                                         <th scope="col">Role</th>
                                                                         <td data-title="Role">{{ $salary_info->other_deductions }}</td>
                                                                     </tr>

                                                                {{-- <tr class="">
                                                                    <th scope="col">
                                                                        <a class="btn btn-block btn-info" href="#">Change Password</a>
                                                                    </th>
                                                                    <td data-title="">

                                                                        <a class="btn btn-block btn-info" href="#">Edit Profile</a>
                                                                    </td>
                                                                </tr> --}}
                                                            </table>
                                                            </div>
                                                            @else
                                                            <div class="col-md-12 text-center"><br/><h3>No Data Found</h3></div>
                                                            @endif


                                                </div>
                                       </div> -->

@endif


                                       </div>




                        </div>

                    </div>
                </div>
            </div>

      </div>
            </div>





<!-- userEmailAddressChange -->
<div class="modal animated fadeIn" id="userIdChange-{{$user->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title">Change {{$user->name}}'s Employee Id</h6>
            </div>
            <form method="POST" action="{{ route('change-emp-id') }}" enctype='multipart/form-data'>
            <div class="modal-body">
                @csrf
                <div class="row clearfix">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                        <input type="text" required class="form-control" name="emp_id" placeholder="Employee Id *">
                        <input type="hidden" class="form-control" name="user_id" value="{{ $user->id }}" placeholder="Password *">
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

        </div>
    </form>
    </div>
    </div>




<!-- userEmailAddressChange -->
<div class="modal animated fadeIn" id="userEmailChange-{{$user->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title">Change {{$user->name}}'s Email</h6>
            </div>
            <form method="POST" action="{{ route('change-user-email') }}" enctype='multipart/form-data'>
            <div class="modal-body">
                @csrf
                <div class="row clearfix">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                        <input type="email" required class="form-control" name="email" placeholder="Email *">
                        <input type="hidden" class="form-control" name="user_id" value="{{ $user->id }}" placeholder="Password *">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <input type="email" required class="form-control" name="confirm_email"  placeholder="Confirm Email *">
                        </div>
                    </div>


                        <div class="col-12 ">
                                <div class="form-group float-right">
                                    <input type="submit" name="btn" value="Update Email" class="btn btn-primary">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                                </div>
                        </div>

                </div>
            </div>

        </div>
    </form>
    </div>
    </div>





                                    <!-- Edit EMP -->
                                    <div class="modal animated zoomIn" id="editEmpSalary" tabindex="-1" role="dialog">
                                            <div class="modal-dialog  modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="title" >@if(!empty($salary_info->basic_salary))
                                                                Update Salary
                                                                @elseif(empty($salary_info->basic_salary)) Add Salary
                                                                @endif</h6>
                                                    </div>
                                                    <form method="POST" action="{{ route('update-salary-info') }}" enctype='multipart/form-data'>
                                                        <div class="modal-body">
                                                            <div class="row clearfix">

                                                                @csrf

                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                    <input type="number" class="form-control" required @if(!empty($salary_info->basic_salary)) value="{{ $salary_info->basic_salary }}" @endif data-toggle="tooltip" data-placement="top" name="basic_salary" placeholder="Basic Salary"title="Basic Salary">
                                                                        <input type="hidden" class="form-control" name="emp_id" value="{{$user->id}}" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <input type="number" class="form-control" @if(!empty($salary_info->house_rent_allowance)) value="{{ $salary_info->house_rent_allowance }}" @endif data-toggle="tooltip" data-placement="top" name="house_rent_allowance" placeholder="House Rent Allowance" title="House Rent Allowance">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <input type="number" class="form-control" @if(!empty($salary_info->bonus)) value="{{ $salary_info->bonus }}" @endif data-toggle="tooltip" data-placement="top" name="bonus" placeholder="Bonus"title="Bonus">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <input type="number" class="form-control" @if(!empty($salary_info->conveyance)) value="{{ $salary_info->conveyance }}" @endif data-toggle="tooltip" data-placement="top" name="conveyance" placeholder="Conveyance" title="Conveyance">
                                                                    </div>
                                                                </div>


                                                            <div class="col-md-4">

                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <input type="number" class="form-control" @if(!empty($salary_info->other_allowance)) value="{{ $salary_info->other_allowance }}" @endif data-toggle="tooltip" data-placement="top" name="other_allowance" placeholder="Other Allowance" title="Other Allowance">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">

                                                                </div>
                                                                <div class="col-md-12">
                                                                        <hr/>
                                                                    </div>



                    <div class="col-6">
                            <div class="form-group">
                                <input type="number" class="form-control" @if(!empty($salary_info->TDS)) value="{{ $salary_info->TDS }}" @endif data-toggle="tooltip" data-placement="top" name="TDS" placeholder="Tax Deducted at Source (T.D.S.) Salary" title="Tax Deducted at Source (T.D.S.) Salary">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="number" class="form-control" @if(!empty($salary_info->provident_fund)) value="{{ $salary_info->provident_fund }}" @endif data-toggle="tooltip" data-placement="top" name="provident_fund" placeholder="Provident Fund" title="Provident Fund">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="number" class="form-control" @if(!empty($salary_info->c_bank_loan)) value="{{ $salary_info->c_bank_loan }}" @endif data-toggle="tooltip" data-placement="top" name="c_bank_loan" placeholder="C/Bank Loan" title="C/Bank Loan">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="number" class="form-control" @if(!empty($salary_info->other_deductions)) value="{{ $salary_info->other_deductions }}" @endif data-toggle="tooltip" data-placement="top" name="other_deductions" placeholder="Other Deductions" title="Other Deductions">
                            </div>
                        </div>

                                                                <div class="col-12 ">
                                                                    <div class="form-group float-right">
                                                                        <input type="submit" name="btn" value="
                                                                        @if(!empty($salary_info->basic_salary))
                                                                Update Salary
                                                                @elseif(empty($salary_info->basic_salary)) Add Salary
                                                                @endif

                                                                        " class="btn btn-primary">
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
