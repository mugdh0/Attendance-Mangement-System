     <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-btn">
                <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
            </div>

            <div class="navbar-brand">
            <a href="{{ route('/') }}"><img src="{{asset($obj_setting->logo)}}" style="height:30px;width: 30px;" alt="Lucid Logo" class="img-responsive logo"></a>

          </div>

            <div class="navbar-right">
                {{-- <form id="navbar-search" class="navbar-form search-form">
                    <input value="" class="form-control" placeholder="Search here..." type="text">
                    <button type="button" class="btn btn-default"><i class="icon-magnifier"></i></button>
                </form>                --}}

                <div id="navbar-menu">
                    <ul class="nav navbar-nav">
<!--                         <li><a href="app-events.html" class="icon-menu d-none d-sm-block d-md-none d-lg-block"><i class="icon-calendar"></i></a></li> -->
<!--                         <li><a href="app-chat.html" class="icon-menu d-none d-sm-block"><i class="icon-bubbles"></i></a></li> -->
                        {{-- <li><a href="{{route('app-inbox')}}" class="icon-menu d-none d-sm-block"><i class="icon-envelope">
                            </i><span class="@if($noOfMsgReceived>0) notification-dot @endif"></span></a></li>
                         <li class="dropdown"> --}}
                            <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                            {{-- <i class="icon-envelope"></i>
                                <i class="icon-bell"></i> --}}
                                <span class="@if($noOfMsgReceived>0) notification-dot @endif"></span>
                            </a>
                            <ul class="dropdown-menu notifications animated shake">
                                <li class="header"><strong>You have {{$noOfMsgReceived}} new Messages</strong></li>

@foreach($unseenEmail as $mail)
                                <li>
                                    <a href="{{route('msg-details',['id'=>$mail->id])}}">
                                        <div class="media">
                                            <div class="media-left">
                                                <i class="icon-info text-warning"></i>
                                            </div>
                                            <div class="media-body">
                                            <p class="text">{{ $mail->subject }}</p>
                                                <span class="timestamp">{{ Carbon\Carbon::parse($mail->created_at)->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                @endforeach

                                <li class="footer"><a href="{{route('app-inbox')}}" class="more">See all</a></li>
                            </ul>
                        </li>




                        {{-- <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown"><i class="icon-equalizer"></i></a>
                            <ul class="dropdown-menu user-menu menu-icon animated bounceIn">
                                <li class="menu-heading">ACCOUNT SETTINGS</li>
                                <li><a href="javascript:void(0);"><i class="icon-note"></i> <span>Basic</span></a></li>
                                <li><a href="javascript:void(0);"><i class="icon-equalizer"></i> <span>Preferences</span></a></li>
                                <li><a href="javascript:void(0);"><i class="icon-lock"></i> <span>Privacy</span></a></li>
                                <li><a href="javascript:void(0);"><i class="icon-bell"></i> <span>Notifications</span></a></li>
                                <li class="menu-heading">BILLING</li>
                                <li><a href="javascript:void(0);"><i class="icon-credit-card"></i> <span>Payments</span></a></li>
                                <li><a href="javascript:void(0);"><i class="icon-printer"></i> <span>Invoices</span></a></li>
                                <li><a href="javascript:void(0);"><i class="icon-refresh"></i> <span>Renewals</span></a></li>
                            </ul>
                        </li>  --}}
                        <li><a href="{{ route('logout') }}" class="icon-menu" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i class="icon-login">
                        </i></a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
