   
@extends('back-end.master')
@section('title')
EMS Inbox
@endsection

@section('content')


    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Inbox</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">App</li>
                            <li class="breadcrumb-item active">Inbox</li>
                        </ul>
                    </div>            

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="mobile-left">
                            <a class="btn btn-primary toggle-email-nav collapsed" data-toggle="collapse" href="#email-nav" role="button" aria-expanded="false" aria-controls="email-nav">
                                <span class="btn-label">
                                    <i class="la la-bars"></i>
                                </span>
                                Menu
                            </a>
                        </div>
                        <div class="mail-inbox">
                            <div class="mail-left collapse" id="email-nav">
                                <div class="mail-compose m-b-20">
                                    <a href="{{route('app-compose')}}" class="btn btn-danger btn-block">Compose</a>
                                </div>
                                <div class="mail-side">
                                    <ul class="nav">
                                        <li class="active"><a href="{{route('app-inbox')}}"><i class="icon-envelope"></i>Inbox<span class="badge badge-primary float-right">{{$totalUnseen}}</span></a></li>
                                            <li><a href="{{route('view-send-messages')}}"><i class="icon-cursor"></i>Sent</a></li>
                                        <li><a href="{{route('draft-messages')}}"><i class="icon-envelope-open"></i>Draft<span class="badge badge-info float-right">{{$totalDraft}}</span></a></li>
                                            {{-- <li><a href="javascript:void(0);"><i class="icon-action-redo"></i>Outbox</a></li> --}}
                                            <li><a href="{{route('starred-msg-list')}}"><i class="icon-star"></i>Starred<span class="badge badge-warning float-right">{{ $totalFavMessages }}</span></a></li>
                                        <li><a href="{{route('trashed-msg')}}"><i class="icon-trash"></i>Trash<span class="badge badge-danger float-right">{{$totalTrashed}}</span></a></li>
                                        </ul>
                         
                                </div>
                            </div>
                            <div class="mail-right">
                        
                             
                             
                                <div class="mail-detail-full animated jello" id="mail-detail-open" >
                                    <div class="mail-action clearfix">
                                        <div class="pull-left">
                                            <div class="d-inline-block">
                                            <a href="javascript:void(0);" onclick="history.back()" class="mail-back btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
                                            </div>
                                            <div class="btn-group">
                                                <a href="javascript:void(0);" onClick="history.go(0)" class="btn btn-default btn-sm hidden-sm">Refresh</a>
                                                <a href="javascript:void(0);" class="btn btn-default btn-sm hidden-sm">Archive</a>
                                                <a href="javascript:void(0);" class="btn btn-default btn-sm">Trash</a>
                                            </div>
                                            {{-- <div class="btn-group">
                                                <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tags</button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);">Tag 1</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">Tag 2</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">Tag 3</a>
                                                </div>
                                            </div> --}}
                                            {{-- <div class="btn-group">
                                                <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0);">Mark as read</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">Mark as unread</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">Spam</a>
                                                    <div role="separator" class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                </div>
                                            </div> --}}
                                        </div>
                                        {{-- <div class="pull-right ml-auto">
                                            <a href="javascript:void(0);" class="btn btn-default btn-sm"><i class="fa fa-mail-forward"></i></a>
                                        </div> --}}
                                    </div>
                                    <div class="detail-header">
                                        <div class="media">
                                            <div class="float-left">
                                                {{-- <div class="m-r-20"><img src="../assets/images/sm/avatar1.jpg" alt=""></div> --}}
                                            </div>
                                            <div class="media-body">
                                                <p class="mb-0"><strong class="text-muted m-r-5">From:</strong><a class="text-default" href="javascript:void(0);">{{$message->msg_sender}}</a> <span class="text-muted text-sm float-right">{{ Carbon\Carbon::parse($message->created_at)->format('jS F Y h:i:s A') }}</span></p>
                                                <p class="mb-0"><strong class="text-muted m-r-5">To:</strong>Me <small class="text-muted float-right"><i class="zmdi zmdi-attachment m-r-5"></i></small></p>
                                                <p class="mb-0"><strong class="text-muted m-r-5">CC:</strong><a class="text-default" href="javascript:void(0);">{{$message->cc}}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mail-cnt">
                                        {!! $message->msg !!}
                                      <hr>
                                        <strong>Click here to</strong>
                                        <a href="{{route('app-compose')}}">Reply</a> or
                                        <a href="{{route('app-compose')}}">Forward</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>


@endsection