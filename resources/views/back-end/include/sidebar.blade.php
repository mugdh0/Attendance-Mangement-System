        <div class="sidebar-scroll">
            <div class="user-account">
                @if(Auth::user()->profile_photo)
                <img src="{{asset(Auth::user()->profile_photo)}}" class="rounded-circle user-photo" alt="User Profile Picture">
                @else

                <img src="{{asset('images/nobody_m.original.jpg')}}" class="rounded-circle user-photo" alt="User Profile Picture">
                 @endif
                <div class="dropdown">
                    <span>Welcome,</span>
                    <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{ Auth::user()->name }}</strong></a>

                    <ul class="dropdown-menu dropdown-menu-right account animated flipInY">

                    <li><a href="{{route("my-profile")}}"><i class="icon-user"></i>My Profile</a></li>
                        <!-- <li><a href="{{route('app-inbox')}}"><i class="icon-envelope-open"></i>Messages</a></li> -->
                        @if(Auth::user()->hasRole(['Super Admin']))
                    <li><a href="{{route('app-settings')}}"><i class="icon-settings"></i>Settings</a></li>
                        @endif
                        <li class="divider"></li>
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i class="icon-power"></i>Logout</a></li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>

                </div>
            <p class="" style="padding-left:4.5em">
               {{Auth::user()->roles->first()->name}}

            </p><span>Update Diagnostic,</span>
            <span> Rangpur</span>
                <hr>
                {{-- <div class="row">
                    <div class="col-4">
                        <h6>{{Carbon\Carbon::now()->Format('Y') - Carbon\Carbon::parse($authUser->created_at)->Format('Y')}}+</h6>
                        <small>Experience</small>
                    </div>
                    <div class="col-4">
                    <h6>{{$total_user}}+</h6>
                        <small>Employees</small>
                    </div>
                    {{-- <div class="col-4">
                        <h6>80+</h6>
                        <small>Clients</small>
                    </div>
                </div> --}}
            </div>
            <!-- Nav tabs -->
<!--             <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#hr_menu">HR</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#setting"><i class="icon-settings"></i></a></li>
            </ul>
                 -->
            <!-- Tab panes -->
            <div class="tab-content p-l-0 p-r-0">
                <div class="tab-pane animated fadeIn active" id="hr_menu">
                    <nav class="sidebar-nav">
                        <ul class="main-menu metismenu">
                                @if(Auth::user()->hasRole(['Super Admin','Admin']))
                            <li class="@yield('statusDB')"><a href="{{route('/')}}"><i class="icon-speedometer"></i><span>Dashboard</span></a></li>
                            @else
                            <li class="@yield('statusDB')"><a href="{{route('emp-dashboard')}}"><i class="icon-speedometer"></i><span>EMP Dashboard</span></a></li>
                            @endif
                            <li class="@yield('statusHD')"><a href="{{ route('app-holidays')}}"><i class="icon-list"></i>Holidays</a></li>


                             <li><a href="{{ route('emp-attendance-short')}}"><i class="icon-calendar"></i>Attendance</a></li>
                            <!--<li><a href="app-activities.html"><i class="icon-badge"></i>Activities</a></li>
                            <li><a href="app-social.html"><i class="icon-globe"></i>HR Social</a></li> -->


                            <li class="@yield('statusEMP')">
                                <a href="#Employees" class="has-arrow"><i class="icon-users"></i><span>Employees</span></a>
                                <ul>
                                    <li><a href="{{ route('emp-all')}}">All Employees</a></li>
                                    @if(Auth::user()->hasRole(['Super Admin','Admin']))
                                    <li><a href="{{ route('emp-leave')}}">Manage leave</a></li>
                                    @endif
                                    {{--<li><a href="{{ route('emp-attendance')}}">Attendance</a></li>--}}
                                    <!-- <li><a href="{{ route('emp-departments')}}">Departments</a></li> -->
                                </ul>
                            </li>
                            {{--@if(Auth::user()->hasRole(['Super Admin']))
                            <li class="@yield('statusAcc')">
                                <a href="#Accounts" class="has-arrow"><i class="icon-briefcase"></i><span>Accounts</span></a>
                                <ul>
                                    <li><a href="{{ route('acc-head')}}">Account Head</a></li>
                                    <li><a href="{{ route('acc-expenses')}}">Expenses</a></li>
                                    <li><a href="{{ route('acc-income')}}">Income</a></li>
                                </ul>
                            </li>
                            @endif

                            <li class="@yield('statusPayroll')">
                                <a href="#Payroll" class="has-arrow"><i class="icon-credit-card"></i><span>Payroll</span></a>
                                <ul>
                                        @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                        <li><a href="{{ route('payroll-salary')}}">Employee Salary</a></li>
                                        <li><a href="{{ route('payroll-payment')}}">Payment</a></li>

                                        @endif
                                    <li><a href="{{ route('payroll-payslip')}}">Payslip</a></li>

                                </ul>
                            </li>--}}
                            @if(Auth::user()->hasRole(['Super Admin','Admin','Employee']))

                            <li class="@yield('statusReport')">
                                <a href="#Report" class="has-arrow"><i class="icon-bar-chart"></i><span>Report</span></a>
                                <ul>
                                  <li><a href="{{ route('emp-attendance') }}">Attendance Report</a></li>
                                        {{--<li><a href="{{ route('account-report-monthly') }}">Account Report</a></li>
                                         <li><a href="{{ route('account-report-yearly') }}">Account Report Yearly</a></li>
                                    <li><a href="{{ route('employee-performance-report') }}">Employee Performance</a></li>

                                    <li><a href="{{ route('employee-salary-report') }}">Employee Salary Report</a></li>--}}
                                    <li><a href="{{ route('employee-leave-report') }}">Employee Leave Report</a></li>
                                    {{-- <li><a href="{{ route('activity-log') }}">Activity log</a></li> --}}

                                </ul>
                            </li>
                            @endif

    <!-- @if(Auth::user()->hasRole(['Employee']))
                            <li class="@yield('statusReport')">
                                <a href="#Report" class="has-arrow"><i class="icon-bar-chart"></i><span>Report</span></a>
                                <ul>
                                    <li><a href="{{ route('activity-log-emp') }}">Activity log</a></li>
                                </ul>
                            </li>
    @endif -->

                            @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                           <li class="@yield('appUser')"><a href="{{ route('app-users')}}"><i class="icon-user"></i>Users</a></li>
                           <li>
                           <a href="#Settings" class="has-arrow"><i class="icon-settings"></i><span>Settings</span></a>
                           <ul>
                                <a href="{{route('app-settings')}}">General Settings</a>
                                <a href="{{route('att-timing-settings')}}">Attendance Timeing Setting</a>
                           </ul>   
                           </li>
                           @endif


<!--                              <li>
                                <a href="#Authentication" class="has-arrow"><i class="icon-lock"></i><span>Authentication</span></a>
                                <ul>
                                    <li><a href="page-login.html">Login</a></li>
                                    <li><a href="page-register.html">Register</a></li>
                                    <li><a href="page-lockscreen.html">Lockscreen</a></li>
                                    <li><a href="page-forgot-password.html">Forgot Password</a></li>
                                    <li><a href="page-404.html">Page 404</a></li>
                                    <li><a href="page-403.html">Page 403</a></li>
                                    <li><a href="page-500.html">Page 500</a></li>
                                    <li><a href="page-503.html">Page 503</a></li>
                                </ul>
                            </li> -->
                        </ul>
                    </nav>
                </div>


            </div>
        </div>
