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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> Compose</h2>
                        <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">App</li>
                            <li class="breadcrumb-item"><a href="{{route('app-inbox')}}">Inbox</a></li>
                            <li class="breadcrumb-item active">Compose</li>
                        </ul>
                    </div>            

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form method="POST" action="{{ route('send-message') }}" enctype='multipart/form-data'>
                                @csrf
                                <div class="form-group">
                                <input type="email" required value="{{$message->msg_receiver}}" name="msg_receiver" class="form-control" placeholder="To">
                                </div>
                                <div class="form-group">
                                    <input type="text" required value="{{$message->subject}}" name="subject" class="form-control" placeholder="Subject">
                                </div>
                                <div class="form-group">
                                    <input type="email" required name="cc" value="{{$message->cc}}" class="form-control" placeholder="CC">
                                </div>
                           
                            {{-- <hr> --}}
                            <div >
                            <textarea class="summernote" required name="msg">{!! $message->msg !!}</textarea>
                            </div>
                            <div class="m-t-30">
                                <input type="submit" class="btn btn-success" name="btnSendMsg" value='Send Message'>
                                <input type="submit" class="btn btn-secondary" name="btnDraft" value='Draft'>
                            <a href="{{route('app-inbox')}}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection