   
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
                                    {{-- <h3 class="label">Labels <a href="#" class="float-right m-r-10" title="Add New Labels"><i class="icon-plus"></i></a></h3>
                                    <ul class="nav">
                                        <li class="active">
                                            <a href="javascript:void(0);"><i class="fa fa-circle text-danger"></i>Web Design<span class="badge badge-primary float-right">5</span></a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);"><i class="fa fa-circle text-info"></i>Recharge</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);"><i class="fa fa-circle text-dark"></i>Paypal</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);"><i class="fa fa-circle text-primary"></i>Family</a>
                                        </li>
                                    </ul> --}}
                                </div>
                            </div>
                            <div class="mail-right">
                                <div class="header d-flex align-center">
                                    <h2>Drafted Email List</h2>
                                    {{-- <form class="ml-auto">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search Mail" aria-label="Search Mail" aria-describedby="search-mail">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="search-mail"><i class="icon-magnifier"></i></span>
                                            </div>
                                        </div>
                                    </form> --}}
                                </div>
                                <div class="mail-action clearfix">
                                    <div class="pull-left">
                                        <div class="fancy-checkbox d-inline-block">
                                            <label>
                                                <input class="select-all" type="checkbox" name="checkbox" id="master">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="btn-group">
                                            <a href="javascript:void(0);" onClick="history.go(0)" class="btn btn-default btn-sm hidden-sm"><i class="fa fa-refresh"></i> Refresh</a>
                                            {{-- <a href="javascript:void(0);" class="btn btn-default btn-sm hidden-sm"><i class="fa fa-archive"></i> Archive</a> --}}
                                            <a href="javascript:void(0);" class="btn btn-default btn-sm delete_all" data-url="{{ url('draftMailsDeleteAll') }}"><i class="fa fa-trash"></i> Trash</a>
                                        </div>
{{--                                   
                                        <div class="btn-group">
                                            <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0);">Mark as read</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Mark as unread</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Spam</a>
                                                <div role="separator" class="dropdown-divider"></div>
                                                <a class="dropdown-item delete_all" data-url="{{ url('draftMailsDeleteAll') }}" href="javascript:void(0);">Delete</a>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="pull-right ml-auto">
                                        <div class="pagination-email d-flex">
                                            {{-- <p>1-50/295</p> --}}
                                            <div class="btn-group m-l-20">
                                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-angle-left"></i></button>
                                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-angle-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mail-list">
                                    <ul class="list-unstyled">
@foreach($messages as $message)
                                        <li class="clearfix">
                                            <div class="mail-detail-left">
                                                <label class="fancy-checkbox">
                                                    <input type="checkbox" name="checkbox" data-id="{{$message->id}}" class="checkbox-tick">
                                                    <span></span>
                                                </label>
                                                <a href="javascript:void(0);" class="mail-star active"><i class="fa fa-star"></i></a>
                                            </div>
                                            <div class="mail-detail-right">
                                            <h6 class="sub"><a href="{{route('draft-msg-details',['id'=>$message->id])}}" class="mail-detail-expand">{{$message->subject}}</a> </h6>
                                            <p class="dep"><span class=""></span>{!! $message->msg !!}</p>
                                            <span class="time">{{ Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</span>
                                            </div>
                                            <div class="hover-action">
                                                <a class="btn btn-warning mr-2" href="javascript:void(0);"><i class="fa fa-archive"></i></a>
                                            <a class="btn btn-danger text-white" href="{{route('delete-message',['id'=>$message->id])}}" title="Delete" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></a>
                                            </div>
                                        </li>
@endforeach
                                    
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>


    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


<script type="text/javascript">
    $(document).ready(function () {


        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".checkbox-tick").prop('checked', true);  
         } else {  
            $(".checkbox-tick").prop('checked',false);  
         }  
        });


        $('.delete_all').on('click', function(e) {


            var allVals = [];  
            $(".checkbox-tick:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  


            if(allVals.length <=0)  
            {  
                alert("Please select row.");  
            }  else {  


                var check = confirm("Are you sure you want to delete this row?");  
                if(check == true){  


                    var join_selected_values = allVals.join(","); 


                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['success']) {
                                $(".checkbox-tick:checked").each(function() {  
                                    $(this).parents("tr").remove();
                                });
                                alert(data['success']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });


                  $.each(allVals, function( index, value ) {
                      $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }  
            }  
        });


        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });


        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();


            $.ajax({
                url: ele.href,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });


            return false;
        });
    });
</script>



@endsection