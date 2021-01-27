
@extends('back-end.master')
@section('title')
EMS Setting
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-bars"></i></a> App Setting</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/')}}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Setting</li>

                        </ul>
                    </div>

                </div>
                <a href="javascript:void(0);" class="btn-link" onclick="window.history.back()"> <i class="fa fa-arrow-left"></i> </a>&nbsp;
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">

                            <div class="header">

                                    <h2>Settings</h2>
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


                                    <ul class="header-dropdown">
                                        {{-- <li><a href="javascript:void(0);" class="btn btn-info" data-toggle="modal" data-target="#addcontact">Add New</a></li> --}}
                                    </ul>

                                </div>



                                <div class="body">
                                        <div class="col-md-12">
                                        
                                            <form action="{{route('app-setting-info')}}" method="POST" enctype='multipart/form-data'>@csrf
                                            <div class="row clearfix">&nbsp;
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                        <div class="col-md-2"> <span>Company Name</span> </div>
                                                            <div class="col-md-9"><input type="text" required name="company_name" class="form-control" placeholder="Company Name"data-toggle="tooltip"
                                                                data-placement="top" title="Company Name" value="{{ $obj_setting->company_name }}"></div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <div class="row">
                                                            <div class="col-md-2"> <span>Address</span> </div>
                                                                <div class="col-md-9">
                                                                    <input type="text" name="address" class="form-control" placeholder="Address"data-toggle="tooltip"
                                                                    data-placement="top" title="Address" value="{{ $obj_setting->address }}">
                                                                <input type="hidden" name="setting_id" value="{{ $obj_setting->id }}" class="form-control" >
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <div class="row">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;<div class="col-md-2"> <span>Weekly Holidays</span> </div>
                                                                <div class="col-md-9">
                                                                <b style="color:red;">[{{ $obj_setting->weekly_holidays }}]</b>
                                                                &nbsp;
                                                                <div onclick="btnToggleFunction()" class="panel-header btn btn-default">
                                                                    <a><h6 class="text-left"><i class="fa fa-retweet" ></i> Change</h6></a>
                                                                </div>

                                                                <div id="IdForTaggle" style="display: none" class="panel-body ">
                                                                <div class="form-check form-check-inline">
                                                                    
                                                                    <input name="check_list[]" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Friday">
                                                                    <label class="form-check-label" for="inlineCheckbox1" >Friday</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input name="check_list[]"  class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Saturday">
                                                                    <label class="form-check-label" for="inlineCheckbox2">Saturday</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input name="check_list[]"  class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Sunday">
                                                                    <label class="form-check-label" for="inlineCheckbox1">Sunday</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input name="check_list[]"  class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Monday">
                                                                    <label class="form-check-label" for="inlineCheckbox2">Monday</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input name="check_list[]"  class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Tuesday">
                                                                    <label class="form-check-label" for="inlineCheckbox1">Tuesday</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input name="check_list[]"  class="form-check-input" type="checkbox" id="inlineCheckbox2" value="Wednesday">
                                                                    <label class="form-check-label" for="inlineCheckbox2">Wednesday</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input name="check_list[]"  class="form-check-input" type="checkbox" id="inlineCheckbox1" value="Thursday">
                                                                    <label class="form-check-label" for="inlineCheckbox1">Thursday</label>
                                                                </div>
                                                                <input type="hidden" name="setting_id" value="{{ $obj_setting->id }}" class="form-control" >
                                                                </div>
                                                                
                                                                <div>
                                                                
                                                                
                                                            </div>

                                                        </div>
                                                    </div> -->
                                                    <!-- <br>
                                                <div class="col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-2"> <span>Office hour:</span> </div>
                                                                <div class="col-md-4">
                                                                <?php 
                                                                $time= explode(":", $obj_setting->start_at);
                                                                if($time[0]>12){
                                                                    $time[0]=$time[0]-12;
                                                                    $sn= $time[0].":".$time[1]. " PM";
                                                                }else{
                                                                    $sn= $time[0].":".$time[1]. " AM";
                                                                }
                                                                
                                                                ?>
                                                                Start At: <b style="color:red;">[{{ $sn }}]</b>
                                                                <input type="time" onchange="onTimeChange()" value="onTimeChange()" id="timeInput"  name="start_at" class="form-control" placeholder="Start at" data-toggle="tooltip"
                                                                    data-placement="top" >
                                                                    
                                                                </div>
                                                                <div class="col-md-4">
                                                                <?php 
                                                                $time2= explode(":", $obj_setting->end_at);
                                                                if($time2[0]>12){
                                                                    $time2[0]=$time2[0]-12;
                                                                    $en= $time2[0].":".$time2[1]. " PM";
                                                                }else{
                                                                    $en= $time2[0].":".$time2[1]. " AM";
                                                                }
                                                                
                                                                ?>
                                                                End At: <b style="color:red;">[{{ $en }}]</b>
                                                                <input type="time" onchange="onTimeChange()" value="onTimeChange()" name="end_at" class="form-control" placeholder="end at" data-toggle="tooltip"
                                                                    data-placement="top" >
                                                                </div>
                                                                  
                                                            </div>

                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-2"> <span>Late Time Count(min)</span> </div>
                                                                <div class="col-md-4">
                                                                    <input type="number" name="late_count" class="form-control" placeholder="time(min)" data-toggle="tooltip"
                                                                    data-placement="top" title="late count" value="{{ $obj_setting->late_count }}">
                                                                <input type="hidden" name="setting_id" value="{{ $obj_setting->id }}" class="form-control" >
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-2"> <span>Late count for attendence deduction</span> </div>
                                                                <div class="col-md-4">
                                                                    <input type="number" name="deduct_count" class="form-control" placeholder="num" data-toggle="tooltip"
                                                                    data-placement="top" title="attendence deduct count" value="{{ $obj_setting->deduct_count }}">
                                                                <input type="hidden" name="setting_id" value="{{ $obj_setting->id }}" class="form-control" >
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-2"> <span>Logo</span> </div>
                                                                    <div class="col-md-9">
                                                                        <input type="file" name="logo" class="form-control-file" accept="image/*" id="exampleInputFile" aria-describedby="fileHelp">
                                                                        <small id="fileHelp" class="form-text text-muted">Image should be less then 2mb.</small></div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="submit" name="btn" class="btn btn-info">
                                                                            </div>
                                                                        </div>

                                                                </div>
                                                            </div>

                                            </div>
                                            </form>


                                        

                                        </div>
{{--
                                        &nbsp;
                                        <div class="col-md-12">
                                        <div onclick="btnToggleFunction2()" class="panel-header btn btn-default btn-block">
                                             <a><h6 class="text-left"><i class="fas fa-list" ></i> &nbsp;Note For Payslip</h6></a>
                                        </div>
                                        </div> --}}


                                </div>







                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    var fhr = 12;
var fmi = 0;
var ampm = 0;
var showpicker = 0;
var elid = 'none';
var picker_type=0;

function showpickers(a,b){
	if(showpicker){
		$('.tpicker').hide();
		showpicker=0;
	}else{
		elid = a;
		picker_type = b;
		var x = $("#"+elid).offset();
		$('.tpicker').show();
		var kk = $("#"+elid).outerHeight();
		$('.tpicker').offset({ top: x.top+kk, left: x.left});
		showpicker=1;
	}
}

function showdate(){
	$('.pk1').show();
	$('.pk2').hide();
}
function showtime(){
	$('.pk1').hide();
	$('.pk2').show();
}
function updatetime(){
	var gg="AM";
	if(ampm)gg = "PM";
	if(picker_type==24){
		var thr = fhr;var tmin = fmi;
		if(ampm){
			if(fhr<12)thr = fhr+12;
		}else{
			if(fhr==12)thr = 0;
		}
		$('#'+elid).val(("0" + thr).slice(-2)+":"+("0" + tmin).slice(-2));
	}else{
		$('#'+elid).val(("0" + fhr).slice(-2)+":"+("0" + fmi).slice(-2)+" "+gg);
	}
	$('.hrhere').html(("0" + fhr).slice(-2));
	$('.minhere').html(("0" + fmi).slice(-2));
	$('.medchange').html(gg);
}

$(function(){

	var pickerhtml = '<div class="tpicker"><div class="pk1"><div class="row"><div class="hr"><i class="fa fa-angle-up hrup"></i><a class="hrhere">12</a><i class="fa fa-angle-down hrdown"></i></div><div class="dot2">:</div><div class="hr">	<i class="fa fa-angle-up minup"></i><a class="minhere">00</a><i class="fa fa-angle-down mindown"></i></div><div class="dot"><button type="button" class="btn btn-primary medchange" onclick="showpickers("timepkr",12)" >AM</button></div></div></div><div class="pk2 mintt"><table class="table table-bordered mintable"><tr><td>00</td><td>05</td><td>10</td><td>15</td></tr><tr><td>20</td><td>25</td><td>30</td><td>35</td></tr><tr><td>40</td><td>45</td><td>50</td><td>55</td></tr></table></div><div class="pk2 hrtt"><table class="table table-bordered hrtable"><tr><td>01</td><td>02</td><td>03</td><td>04</td></tr><tr><td>05</td><td>06</td><td>07</td><td>08</td></tr><tr><td>09</td><td>10</td><td>11</td><td>12</td></tr></table></div></div>';

	$('.timepicker').html(pickerhtml);

	$('.hrup').click(function(){
		if(fhr<12){fhr++;updatetime();}else{fhr=1;updatetime();}
	});
	$('.hrdown').click(function(){
		if(fhr>1){fhr--;updatetime();}else{fhr=12;updatetime();}
	});
	$('.minup').click(function(){
		if(fmi<59){fmi++;updatetime();}else{fmi=0;updatetime();}
	});
	$('.mindown').click(function(){
		if(fmi>0){fmi--;updatetime();}else{fmi=59;updatetime();}
	});
	$('.medchange').click(function(){
		if(ampm){ampm=0;updatetime();}else{ampm=1;updatetime();}
	});
	$('.hrhere').click(function(){
		$('.hrtt').show();
		$('.pk1').hide();
		$('.mintt').hide();
	});
	$('.minhere').click(function(){
		$('.hrtt').hide();
		$('.pk1').hide();
		$('.mintt').show();
	});
	$('.hrtable td').click(function(){
		var vaa = $(this).html();
		$('.hrtt').hide();
		$('.pk1').show();
		$('.mintt').hide();
		fhr = parseInt(vaa);updatetime();
	});
	$('.mintable td').click(function(){
		var vaa = $(this).html();
		$('.hrtt').hide();
		$('.pk1').show();
		$('.mintt').hide();
		fmi = parseInt(vaa);updatetime();
	});
});
</script>

@endsection
