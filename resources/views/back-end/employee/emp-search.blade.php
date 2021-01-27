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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Attendance List</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Employee</li>
                            <li class="breadcrumb-item active">Attendance Report</li>
                        </ul>
                    </div>

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                      <div class="header">

                          <p><b> Employee Name: <span style="color: blue">{{$name}}</span>
                          <br>EmpId: {{$id}}</b>
                        </p>

                          @if(Auth::user()->hasRole(['Super Admin', 'Admin']))

                          <ul class="header-dropdown">

                            <form class="form-group" action="" method="post">
                              @csrf
                              <li>
                                <span data-toggle="modal" data-target="#show">
                                  <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary" data-toggle="tooltip" data-placement="top" title="Elaboration's"><i class="fa fa-eye"></i></a>
                              </span>
                              </li>
                              <li><a href="{{ route('preview_monthly_report',['name'=>$name,'uid'=>$id, 'month'=>$data[0]->month, ])}}" class="btn btn-sm btn-outline-info " title="print" data-toggle="tooltip" data-placement="top" data-type="confirm"><i class="fas fa-print"></i></a></li>

                              <li title="pick month">
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
                              </li>
                              <li>
                                <button style="margin-top:-3px;" type="submit" name="button" class="btn btn-success">Submit</button>
                              </li>

                            </form>

                          </ul>
                          @endif
                      </div>
                      <!-- end head -->
                        <div class="body">
                            <div class="table-responsive">
                                    @if($data!=null)
                                    <h5>Showing Result Of Month:
                                      @if($data[0]->month=='01')
                                      <span style="color: red">January </span>
                                      @elseif($data[0]->month=='02')
                                      <span style="color: red">February </span>
                                      @elseif($data[0]->month=='03')
                                      <span style="color: red">March </span>
                                      @elseif($data[0]->month=='04')
                                      <span style="color: red">April </span>
                                      @elseif($data[0]->month=='05')
                                      <span style="color: red">May </span>
                                      @elseif($data[0]->month=='06')
                                      <span style="color: red">June </span>
                                      @elseif($data[0]->month=='07')
                                      <span style="color: red">July </span>
                                      @elseif($data[0]->month=='08')
                                      <span style="color: red">August </span>
                                      @elseif($data[0]->month=='09')
                                      <span style="color: red">September </span>
                                      @elseif($data[0]->month=='10')
                                      <span style="color: red">October </span>
                                      @elseif($data[0]->month=='11')
                                      <span style="color: red">November </span>
                                      @elseif($data[0]->month=='12')
                                      <span style="color: red">December </span>
                                      @endif
                                      <span style="color: red">{{$data[0]->year}} </span>
                                    </h5>

                                    <!-- results -->

                                    @if($month=="09" ||$month=="04"||$month=="06"||$month=="11")

                                    <br>
                                    <table class="table table-hover m-b-0">
                                      <thead class="thead thead-light">

                                        <th colspan="13" style="text-align:center"> Days</th>
                                        <th colspan="2" style="text-align:center"> Summary Days</th>
                                        <th style="text-align:center">Remarks</th>

                                      </thead>
                                      <tbody>
                                        <tr>

                                        <td>P</td>
                                        <td>A</td>
                                        <td>L</td>

                                        <td>2L</td>
                                        <td>SL</td>
                                        <td>AL</td>
                                        <td>CL</td>
                                        <td>H</td>
                                        <td>OL</td>
                                        <td>GH</td>
                                        <td>T</td>
                                        <td>LWP</td>
                                        <td>NA</td>

                                        <td>Salary Deduction</td>
                                        <td>Total Late</td>
                                        </tr>
                                        <tr>
                                          <td>20</td>
                                          <td>2</td>
                                          <td>2</td>

                                          <td>1</td>
                                          <td>1</td>
                                          <td>1</td>
                                          <td>1</td>
                                          <td>5</td>
                                          <td>0</td>
                                          <td>2</td>
                                          <td>0</td>
                                          <td>0</td>
                                          <td>0</td>

                                          <td>100</td>
                                          <td>2</td>
                                        </tr>
                                      </tbody>

                                    </table>

                                    </div>

                                    </div>
                                    <div class="body">
                                        <div class="table-responsive">
                                    <br><br>
                                    <table class="table table-hover m-b-0">
                                      <thead class="thead-dark">

                                        <th>date</th>
                                        @for($i=1;$i<=30;$i++)
                                          <th>{{$i}}</th>
                                        @endfor
                                      </thead>
                                      <tbody>
                                          <td>status</td>
                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>P/L</td>
                                          <td>L/P</td>
                                          <td>L/L</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>L/L</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P/L</td>
                                          <td>L/P</td>
                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>L/P</td>
                                          <td>L/P</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P/L</td>
                                          <td>P/L</td>
                                          <td>P/P</td>
                                      </tbody>

                                    </table>
                                  </div>
                                    </div>
                                    <div class="body">
                                        <div class="table-responsive">
                                    <br><br>
                                    <table class="table table-hover m-b-0">
                                      <thead class="thead-dark">

                                        <th>date</th>
                                        @for($i=1;$i<=30;$i++)
                                          <th>{{$i}}</th>
                                        @endfor
                                      </thead>
                                      <tbody>
                                          <td>status</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>L</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>L</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P</td>
                                          <td>L</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>L</td>
                                          <td>L</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P</td>
                                          <td>P</td>
                                          <td>P</td>
                                      </tbody>

                                    </table>
                                  </div>
                                  </div>


                                    @else
                                    <div class="body">
                                    <div class="table-responsive">
                                    <br><br>
                                    <table class="table table-hover m-b-0">
                                      <thead class="thead thead-light">

                                        <th colspan="13" style="text-align:center"> Days</th>
                                        <th colspan="2" style="text-align:center"> Summary Days</th>
                                        <th style="text-align:center">Remarks</th>

                                      </thead>
                                      <tbody>
                                        <tr>

                                        <td>P</td>
                                        <td>A</td>
                                        <td>L</td>

                                        <td>2L</td>
                                        <td>SL</td>
                                        <td>AL</td>
                                        <td>CL</td>
                                        <td>H</td>
                                        <td>OL</td>
                                        <td>GH</td>
                                        <td>T</td>
                                        <td>LWP</td>
                                        <td>NA</td>

                                        <td>Salary Deduction</td>
                                        <td>Total Late</td>
                                        </tr>
                                        <tr>
                                          <td>20</td>
                                          <td>2</td>
                                          <td>2</td>

                                          <td>1</td>
                                          <td>1</td>
                                          <td>1</td>
                                          <td>1</td>
                                          <td>5</td>
                                          <td>0</td>
                                          <td>2</td>
                                          <td>0</td>
                                          <td>0</td>
                                          <td>0</td>

                                          <td>100</td>
                                          <td>2</td>
                                        </tr>
                                      </tbody>

                                    </table>

                                    </div>

                                  </div>

                                  <br><br>
                                  <div class="body">
                                  <div class="table-responsive">
                                    <table class="table table-hover m-b-0">
                                      <thead class="thead-dark">
                                        <th>date</th>
                                        @for($i=1;$i<=31;$i++)

                                          <th>{{$i}}</th>
                                        @endfor
                                      </thead>
                                      <tbody>
                                          <td>Status</td>
                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>P/L</td>
                                          <td>L/P</td>
                                          <td>L/L</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>L/L</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P/L</td>
                                          <td>L/P</td>
                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>P/P</td>
                                          <td>L/P</td>
                                          <td>L/P</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P/L</td>
                                          <td>P/L</td>
                                          <td>P/L</td>
                                      </tbody>

                                    </table>
                                  </div>

                                    </div>

                                    <br><br>
                                    <div class="body">
                                    <div class="table-responsive">
                                    <table class="table table-hover m-b-0">
                                      <thead class="thead-dark">

                                        <th>date</th>
                                        @for($i=1;$i<=31;$i++)
                                          <th>{{$i}}</th>
                                        @endfor
                                      </thead>
                                      <tbody>
                                          <td>status</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>L</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>L</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P</td>
                                          <td>L</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P</td>
                                          <td>P</td>
                                          <td>P</td>
                                          <td>L</td>
                                          <td>L</td>
                                          <td>H</td>
                                          <td>H</td>

                                          <td>P</td>
                                          <td>P</td>
                                          <td>P</td>
                                      </tbody>

                                    </table>
                                  </div>

                                    </div>

</div>
</div>

                                    @endif

                                    @else
                                    <tbody>
                                      <tr>
                                        <td>no data found for this month</td>
                                      </tr>
                                    </tbody>
                                    @endif






                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal animated fadeIn" id="show" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title">Elaboration</h6>
                </div>

                    <div class="modal-body">

                     <div class="modal-body">
                         <div class="row clearfix">
                             <div class="col-md-10">
                               <table class="table table-hover m-b-0">
                                 <tr>
                                   <th>sign</th>
                                   <th>meaning</th>
                                 </tr>
                                 <tr>
                                   <td>A</td>
                                   <td>Absent</td>
                                 </tr>
                                 <tr>
                                   <td>2L</td>
                                   <td>Late in & Early out</td>
                                 </tr>
                                 <tr>
                                   <td>SL/AL/CL/OL</td>
                                   <td>Sick Leave/Annual Leave/Casual Leave/Others Leave</td>
                                 </tr>
                                 <tr>
                                   <td>P</td>
                                   <td>Present</td>
                                 </tr>
                                 <tr>
                                   <td>H</td>
                                   <td>Holiday</td>
                                 </tr>
                                 <tr>
                                   <td>GH</td>
                                   <td>Gov. Holiday</td>
                                 </tr>
                                 <tr>
                                   <td>T</td>
                                   <td>Tour</td>
                                 </tr>
                               </table>

                             </div>

                             <div class="col-md-10">
                               <table class="table table-hover m-b-0">
                                 <tr>
                                   <th>sign</th>
                                   <th>meaning</th>
                                 </tr>
                                 <tr>
                                   <td>P/P</td>
                                   <td>No problem</td>
                                 </tr>
                                 <tr>
                                   <td>L/L</td>
                                   <td>2 late(late in and early out)</td>
                                 </tr>
                                 <tr>
                                   <td>P/L</td>
                                   <td>1 late(early out)</td>
                                 </tr>
                                 <tr>
                                   <td>L/P</td>
                                   <td>1 late(late in)</td>
                                 </tr>
                                 <tr>
                                   <td>ML</td>
                                   <td>Manula Attendance Late</td>
                                 </tr>
                                 <tr>
                                   <td>LWP</td>
                                   <td>Leave without pay</td>
                                 </tr>

                               </table>

                             </div>

                             <div class="col-12 ">
                                         <div class="form-group float-right">

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


@endsection
