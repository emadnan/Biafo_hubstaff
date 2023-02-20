<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Comply Techs</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ asset('frontend/plugins/fontawesome-free/css/all.min.css') }}">
    {{-- <--Theme style --> --}}
    <link rel="stylesheet" href="{{ asset('frontend/dist/css/adminlte.min.css') }}">
    <script src="{{asset('frontend/js/jquery-3.6.0.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
        integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous">
    </script>
    <script src="{{asset('frontend/flowy/flowy.min.js')}}"></script>
    <script src="{{asset('frontend/drawflow/dist/drawflow.min.js')}}"></script>
    <script src="{{asset('frontend/flowchart/jquery.flowchart.min.js')}}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> --}}

    <script src="{{asset('frontend/js/bootstrap5.bundle.min.js')}}"></script>
    <script src="{{asset('frontend/tinymce/js/tinymce/tinymce.min.js')}}"></script>
    <!-- <script src="https://cdn.tiny.cloud/1/azrxhs911ypi3jnpspgwo66x1bdomjoo2tlzzphzlv58kjuo/tinymce/6/plugins.min.js" referrerpolicy="origin"></script> -->

    <script src="{{asset('frontend/ckeditor/ckeditor.js')}}"></script>
    <!-- <script src="{{asset('frontend/pdf_editor/dist/pspdfkit.js')}}"></script> -->
    <script src="{{asset('frontend/plugins/chart.js/Chart.bundle.js')}}"></script>
    <script src="{{asset('frontend/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('frontend/plugins/chart.js/Chart.js')}}"></script>
    <script src="{{asset('frontend/plugins/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('frontend/plugins/chart.js/dashboard3.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/plugins/jquery-ui/jquery-ui.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/js/jquery.multiselect.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/js/additional-methods.min.js')}}"></script>
    <script type="text/javascript">
    jQuery.validator.setDefaults({
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    // // override jquery validate plugin defaults
    // $.validator.setDefaults({
    //     highlight: function(element) {
    //         $(element).closest('.form-group').addClass('has-error');
    //     },
    //     unhighlight: function(element) {
    //         $(element).closest('.form-group').removeClass('has-error');
    //     },
    //     errorElement: 'span',
    //     errorClass: 'text-danger',
    //     errorPlacement: function(error, element) {
    //         if(element.parent('.input-group').length) {
    //             error.insertAfter(element.parent());
    //         } else {
    //             error.insertAfter(element);
    //         }
    //     }
    // });



    </script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('frontend\css\bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend\css\custom.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend\css\fontawesome\css\all.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend\css\jquery.multiselect.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend\plugins\jquery-ui\jquery-ui.css')}}" rel="stylesheet">
    <link href="{{ asset('frontend\plugins\jquery-ui\jquery-ui.structure.css')}}" rel="stylesheet">
    <link href="{{asset('frontend\flowy\flowy.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend\drawflow\dist\drawflow.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend\flowchart\jquery.flowchart.min.css')}}" rel="stylesheet">
    <style>
    .loader {
        /* border: 12px solid #f3f3f3; */
        border-radius: 50%;
        border-top: 5px solid DodgerBlue;
        width: 70px;
        height: 70px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }

    .center-loader {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
    }
   
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div id="loader" class="loader center-loader">
    <!-- <img src="{{asset('frontend\img\loading.gif')}}"> -->
    </div>
    <script>
        document.onreadystatechange = function() {
            if (document.readyState !== "complete") {
                document.querySelector(
                  "body").style.visibility = "hidden";
                document.querySelector(
                  "#loader").style.visibility = "visible";
            } else {
                document.querySelector(
                  "#loader").style.display = "none";
                document.querySelector(
                  "body").style.visibility = "visible";
            }
        };
    </script>
    <div class="wrapper">

        @include('layouts.header')
        @include('layouts.sidebar')
        @include('toastr')

        @yield('content')
        @include('layouts.footer')
        
    </div>





</body>
@yield('scripts')
<script>
    var old_notification_count=0;
  load_unseen_notification = function (){
  $.ajax({
    url:"{{ route('realtime') }}",
    method:"GET",
    dataType:"json",
    success:function(data)
    {
      $('#notifications').html(data.notification);
      //alert(data.notification);
      if(data.unseen_notification > old_notification_count)
      {
        old_notification_count=data.unseen_notification;
        $('.count').html(data.unseen_notification);
        //alert(data.unseen_notification);
      }
    }
  });
}
// load_unseen_notification();
setInterval(load_unseen_notification,5000);
$(document).on('click', '.nav-link', function(){
 $('.count').html('');
 load_unseen_notification();
});
</script>
</html>