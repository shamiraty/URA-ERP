<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
    <!-- Add this inside the <head> section of your HTML -->

    <!--this is of AJAX crud--->
<meta name="csrf-token" content="{{ csrf_token() }}">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{ asset('assets/images/uralogo.png') }}" type="image/png" />

  <link rel="stylesheet" href="{{ asset('asset/assets/css/remixicon.css') }}">
  <!-- BootStrap css -->
  <link rel="stylesheet" href="{{ asset('asset/assets/css/lib/bootstrap.min.css') }}">
  <!-- Apex Chart css -->
  <link rel="stylesheet" href="{{ asset('asset/assets/css/lib/apexcharts.css') }}">
  <!-- Data Table css -->
  <link rel="stylesheet" href="{{ asset('asset/assets/css/lib/dataTables.min.css') }}">
  <!-- Text Editor css -->
  <link rel="stylesheet" href="{{ asset('asset/assets/css/lib/editor-katex.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/assets/css/lib/editor.atom-one-dark.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/assets/css/lib/editor.quill.snow.css') }}">
  <!-- Date picker css -->
  <link rel="stylesheet" href="{{ asset('asset/assets/css/lib/flatpickr.min.css') }}">
  <!-- Calendar css -->
  <link rel="stylesheet" href="{{ asset('asset/assets/css/lib/full-calendar.css') }}">
  <!-- Vector Map css -->
  <link rel="stylesheet" href="{{ asset('asset/assets/css/lib/jquery-jvectormap-2.0.5.css') }}">
  <!-- Popup css -->
  <link rel="stylesheet" href="{{ asset('asset/assets/css/lib/magnific-popup.css') }}">
  <!-- Slick Slider css -->
  <link rel="stylesheet" href="{{ asset('asset/assets/css/lib/slick.css') }}">
  <!-- prism css -->
  <link rel="stylesheet" href="{{ asset('asset/assets/css/lib/prism.css') }}">
  <!-- file upload css -->
  <link rel="stylesheet" href="{{ asset('asset/assets/css/lib/file-upload.css') }}">

  <link rel="stylesheet" href="{{ asset('asset/assets/css/lib/audioplayer.css') }}">
  <!-- main css -->
  <link rel="stylesheet" href="{{ asset('asset/assets/css/style.css') }}">
  

 <!--ends  added CSS-->
 @stack('styles')
	<title>URASACCOS CRM</title>
</head>
<!--added style-->
@include('body.sidebar')</div>
<main class="dashboard-main">
    @include('body.header')
    <div class="dashboard-main-body">

                @yield('content')
    </div>
    <footer class="d-footer">
        <div class="row align-items-center justify-content-between">
          <div class="col-auto">
            <p class="mb-0">© 2024 URA SACCOS LTD. All Rights Reserved.</p>
          </div>
          <div class="col-auto">
            <p class="mb-0">Made by <span class="text-primary-600">URASACCOS ICT</span></p>
          </div>
        </div>
      </footer>
</main>

 <!-- jQuery library js -->
 <script src="{{ asset('asset/assets/js/lib/jquery-3.7.1.min.js') }}"></script>
 <!-- Bootstrap js -->
 <script src="{{ asset('asset/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
 <!-- Apex Chart js -->
 <script src="{{ asset('asset/assets/js/lib/apexcharts.min.js') }}"></script>
 <!-- Data Table js -->
 <script src="{{ asset('asset/assets/js/lib/dataTables.min.js') }}"></script>
 <!-- Iconify Font js -->
 <script src="{{ asset('asset/assets/js/lib/iconify-icon.min.js') }}"></script>
 <!-- jQuery UI js -->
 <script src="{{ asset('asset/assets/js/lib/jquery-ui.min.js') }}"></script>
 <!-- Vector Map js -->
 <script src="{{ asset('asset/assets/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>
 <script src="{{ asset('asset/assets/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script>
 <!-- Popup js -->
 <script src="{{ asset('asset/assets/js/lib/magnifc-popup.min.js') }}"></script>
 <!-- Slick Slider js -->
 <script src="{{ asset('asset/assets/js/lib/slick.min.js') }}"></script>
 <!-- prism js -->
 <script src="{{ asset('asset/assets/js/lib/prism.js') }}"></script>
 <!-- file upload js -->
 <script src="{{ asset('asset/assets/js/lib/file-upload.js') }}"></script>
 <!-- audioplayer -->
 <script src="{{ asset('asset/assets/js/lib/audioplayer.js') }}"></script>

 <!-- main js -->
 <script src="{{ asset('asset/assets/js/app.js') }}"></script>
 <script>
    let table = new DataTable('#dataTable');
  </script>

<!--ends added javascript-->
<!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('asset/assets/js/homeTwoChart.js') }}"></script>

<script>
    // =============================== Wizard Step Js Start ================================
    $(document).ready(function() {
        // click on next button
        $('.form-wizard-next-btn').on("click", function() {
            var parentFieldset = $(this).parents('.wizard-fieldset');
            var currentActiveStep = $(this).parents('.form-wizard').find('.form-wizard-list .active');
            var next = $(this);
            var nextWizardStep = true;
            parentFieldset.find('.wizard-required').each(function(){
                var thisValue = $(this).val();

                if( thisValue == "") {
                    $(this).siblings(".wizard-form-error").show();
                    nextWizardStep = false;
                }
                else {
                    $(this).siblings(".wizard-form-error").hide();
                }
            });
            if( nextWizardStep) {
                next.parents('.wizard-fieldset').removeClass("show","400");
                currentActiveStep.removeClass('active').addClass('activated').next().addClass('active',"400");
                next.parents('.wizard-fieldset').next('.wizard-fieldset').addClass("show","400");
                $(document).find('.wizard-fieldset').each(function(){
                    if($(this).hasClass('show')){
                        var formAtrr = $(this).attr('data-tab-content');
                        $(document).find('.form-wizard-list .form-wizard-step-item').each(function(){
                            if($(this).attr('data-attr') == formAtrr){
                                $(this).addClass('active');
                                var innerWidth = $(this).innerWidth();
                                var position = $(this).position();
                                $(document).find('.form-wizard-step-move').css({"left": position.left, "width": innerWidth});
                            }else{
                                $(this).removeClass('active');
                            }
                        });
                    }
                });
            }
        });
        //click on previous button
        $('.form-wizard-previous-btn').on("click",function() {
            var counter = parseInt($(".wizard-counter").text());;
            var prev =$(this);
            var currentActiveStep = $(this).parents('.form-wizard').find('.form-wizard-list .active');
            prev.parents('.wizard-fieldset').removeClass("show","400");
            prev.parents('.wizard-fieldset').prev('.wizard-fieldset').addClass("show","400");
            currentActiveStep.removeClass('active').prev().removeClass('activated').addClass('active',"400");
            $(document).find('.wizard-fieldset').each(function(){
                if($(this).hasClass('show')){
                    var formAtrr = $(this).attr('data-tab-content');
                    $(document).find('.form-wizard-list .form-wizard-step-item').each(function(){
                        if($(this).attr('data-attr') == formAtrr){
                            $(this).addClass('active');
                            var innerWidth = $(this).innerWidth();
                            var position = $(this).position();
                            $(document).find('.form-wizard-step-move').css({"left": position.left, "width": innerWidth});
                        }else{
                            $(this).removeClass('active');
                        }
                    });
                }
            });
        });
        //click on form submit button
        $(document).on("click",".form-wizard .form-wizard-submit" , function(){
            var parentFieldset = $(this).parents('.wizard-fieldset');
            var currentActiveStep = $(this).parents('.form-wizard').find('.form-wizard-list .active');
            parentFieldset.find('.wizard-required').each(function() {
                var thisValue = $(this).val();
                if( thisValue == "" ) {
                    $(this).siblings(".wizard-form-error").show();
                }
                else {
                    $(this).siblings(".wizard-form-error").hide();
                }
            });
        });
        // focus on input field check empty or not
        $(".form-control").on('focus', function(){
            var tmpThis = $(this).val();
            if(tmpThis == '' ) {
                $(this).parent().addClass("focus-input");
            }
            else if(tmpThis !='' ){
                $(this).parent().addClass("focus-input");
            }
        }).on('blur', function(){
            var tmpThis = $(this).val();
            if(tmpThis == '' ) {
                $(this).parent().removeClass("focus-input");
                $(this).siblings(".wizard-form-error").show();
            }
            else if(tmpThis !='' ){
                $(this).parent().addClass("focus-input");
                $(this).siblings(".wizard-form-error").hide();
            }
        });
    });
    // =============================== Wizard Step Js End ================================
</script>

        <script>

         @if(Session::has('message'))

         var type = "{{ Session::get('alert-type','info') }}"

         switch(type){

            case 'info':

            toastr.info(" {{ Session::get('message') }} ");

            break;



            case 'success':

            toastr.success(" {{ Session::get('message') }} ");

            break;



            case 'warning':

            toastr.warning(" {{ Session::get('message') }} ");

            break;



            case 'error':

            toastr.error(" {{ Session::get('message') }} ");

            break;

         }

         @endif

        </script>



<script>



</body>
</html>
