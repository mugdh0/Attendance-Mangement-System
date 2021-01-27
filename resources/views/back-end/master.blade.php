<!doctype html>
<html lang="en">


<!-- Mirrored from thememakker.com/templates/lucid/hr/html/light/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 05 Dec 2018 08:41:38 GMT -->
<head>
<title>@yield('title')</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Lucid Bootstrap 4.1.1 Admin Template">
<meta name="author" content="WrapTheme, design by: ThemeMakker.com">

<link rel="stylesheet" href="{{ asset('assets2/fontawesome-free-5.6.1-web/css/all.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous"> --}}



<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 <link rel="stylesheet" href="assets/timepicker.css">
  <script type="text/javascript" src="assets/timepicker.js"></script>

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/dist/summernote.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}"/>

<link rel="stylesheet" href="{{ asset('assets/vendor/chartist/css/chartist.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/toastr/toastr.min.css') }}">

<!-- MAIN CSS -->
<link rel="stylesheet" href="{{ asset('assets2/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets2/css/custom.css') }}">
<link rel="stylesheet" href="{{ asset('assets2/css/inbox.css') }}">
<link rel="stylesheet" href="{{ asset('assets2/css/color_skins.css') }}">

<link rel="stylesheet" href="{{ asset('assets/bootstrap-datetimepicker.min.css') }}">

</head>
<body class="theme-orange">

    <div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30">
            {{-- <img src="https://thememakker.com/templates/lucid/hr/html/assets/images/logo-icon.svg" width="48" height="48" alt="Lucid"> --}}
        </div>
        <p><b>Please wait...</b></p>
    </div>
</div>
<div id="wrapper">
@include('back-end.include.header')


<script type="text/javascript" src="assets/timepicker.js"></script>
<div id="left-sidebar" class="sidebar">
    @include('back-end.include.sidebar')
</div>

<!-- #toast-container .toast .toast-message -->


     <main>
            @yield('content')
        </main>
    </div>


<script src="{{asset('assets/bootstrap-datetimepicker.min.js')}}"></script>

<script src="{{asset('assets2/bundles/libscripts.bundle.js')}}"></script>
<script src="{{asset('assets2/bundles/vendorscripts.bundle.js')}}"></script>

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/vendor/sweetalert/sweetalert.min.js')}}"></script> <!-- SweetAlert Plugin Js -->


<!-- <script src="{{asset('assets/vendor/toastr/toastr.js')}}"></script> -->
<script src="{{asset('assets2/bundles/chartist.bundle.js')}}"></script>
<script src="{{asset('assets2/bundles/knob.bundle.js')}}"></script> <!-- Jquery Knob-->

<script src="{{asset('assets2/bundles/mainscripts.bundle.js')}}"></script>
<script src="{{asset('assets2/js/index.js')}}"></script>
<script src="{{asset('assets/vendor/summernote/dist/summernote.js')}}"></script>
<script src="{{'assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js'}}"></script>

<script src="{{asset('assets2/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets2/js/pages/ui/dialogs.js')}}"></script>


<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/js/mdb.min.js"></script>

    <script>
        function btnToggleFunction() {
            $('#IdForTaggle').slideToggle(1000);
        }
        function btnToggleFunction2() {
            $('#IdForTaggle2').slideToggle(1000);
        }
        function btnToggleFunction1() {
            $('#IdForTaggle1').slideToggle(1000);
        }
        function btnToggleFunction3() {
            $('#IdForTaggle3').slideToggle(1000);
        }

        setTimeout(function(){
        $('#message').fadeOut('slow');
        },3000);

    </script>



<script>
    $(document).ready(function(){
        $(".mail-detail-expand").click(function(){
            $("#mail-detail-open").toggle();
        });
        $(".mail-back").click(function(){
            $("#mail-detail-open").toggle();
        });
    });
</script>
<script>





$('#datepicker').datepicker("option", "onSelect", function(){alert('hi')});
                            </script>

<script>
                                var inputEle = document.getElementById('timeInput');
                                function onTimeChange() {
                                var timeSplit = inputEle.value.split(':'),
                                    hours,
                                    minutes,
                                    meridian;
                                hours = timeSplit[0];
                                minutes = timeSplit[1];
                                if (hours > 12) {
                                    meridian = 'PM';
                                    hours -= 12;
                                } else if (hours < 12) {
                                    meridian = 'AM';
                                    if (hours == 0) {
                                    hours = 12;
                                    }
                                } else {
                                    meridian = 'PM';
                                }
                                document.getElementById("time").value= hours + ':' + minutes + ' ' + meridian;
                                }
                      </script>
<!-- <script src="{{ asset('assets/date-time-picker.min.js')}}"></script>
<script>
$('.myDatePicker').dateTimePicker();
$('.myDatePicker1').dateTimePicker({});
$('.myDatePicker2').dateTimePicker();
$('.myDatePicker3').dateTimePicker();
$('.myDatePicker4').dateTimePicker();
$('.myDatePicker5').dateTimePicker(); -->
<script>
$('#date').datepicker({
    multidate: true,
	format: 'dd-mm-yyyy'
});

$('#date2').datepicker({
    multidate: true,
	format: 'dd-mm-yyyy'
});
$('#dtt').datepicker({
    multidate: true,
	format: 'dd-mm-yyyy'
});
$('#date3').datepicker({
    multidate: true,
	format: 'dd-mm-yyyy'
});
$('body').on('focus',".datepicker_recurring_start", function(){
    $(this).datepicker({
        multidate: true,
	    format: 'dd-mm-yyyy'
    });
});
</script>





</body>


</html>
