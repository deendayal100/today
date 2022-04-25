<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="robots" content="noindex,nofollow">
    <title>Forgot Password</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="public/assets/admin/images/favicon.png">
    <!-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/> -->
    <!-- Custom CSS -->
    <link href="{{ asset('public/assets/admin/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/admin/dist/css/custom.css') }}" rel="stylesheet">
    <script src="{{ asset('public/assets/admin/libs/jquery/dist/jquery.min.js') }}"></script>
</head>

<body>
    <div class="main-wrapper">
        
        <!-- -------------------------------------------------------------- -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- -------------------------------------------------------------- -->
        <div class="preloader">
			<div class="spinner-border text-muted"></div>
		</div>
        <!-- -------------------------------------------------------------- -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- -------------------------------------------------------------- -->
        <!-- -------------------------------------------------------------- -->
        <!-- Login box.scss -->
        <!-- -------------------------------------------------------------- -->
        <!-- <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(public/assets/admin/images/background/login-register.jpg) no-repeat center center; background-size: cover;"> -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" >
			
		    <div class="auth-box p-4 bg-white rounded">
			    <div class="logo_box_login mb-4 text-center">
					<a class="navbar-brand" href="javascript:void(0);">
						<!-- Logo icon -->
						<b class="logo-icon">
							<!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
							<!-- Dark Logo icon -->
							<img src="{{asset('assets/images/logo.svg')}}"  alt="homepage" class="dark-logo"/>
						</b>
                        
						<!--End Logo icon -->
						<!-- Logo text -->
						<span class="logo-text">
							<!-- dark Logo text -->
							<!-- <img src="public/assets/admin/images/logo-text.png" alt="homepage" class="dark-logo" /> -->
						</span>
					</a>
				</div>
                <div id="loginform">
                    <div class="logo">
                        <h3 class="box-title mb-3 text-center">Forgot Password</h3>
                    </div>
                    <span class="error" id="msg_error"></span>
                    <!-- Form -->
                    @if (\Session::has('msg'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('msg') !!}</li>
                        </ul>
                    </div>
                @endif
                    <div class="row">
                        <div class="col-12">
                            <form method="POST" class="form-horizontal mt-3 form-material" id="forgotadminpasswordform" action="{{ route('login.custom') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <div class="">
                                        <input type="text" placeholder="Email" id="email" class="form-control" name="email" required
                                        autofocus>
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                

                            
                                <div class="form-group text-center mt-4 mb-3">
                                    <div class="col-xs-12">
                                    <a href="{{ url('/dashboard') }}">
                                        <button class="btn btn-info d-block w-100 waves-effect waves-light" type="submit">Get OTP</button>
                                    </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
        <!-- -------------------------------------------------------------- -->
        <!-- Login box.scss -->
        <!-- -------------------------------------------------------------- -->
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- All Required js -->
    <!-- -------------------------------------------------------------- -->
 
    <script src="{{ asset('public/assets/admin/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    
    <script src="{{ asset('public/assets/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <!-- -------------------------------------------------------------- -->
    <!-- This page plugin js -->
    <!-- -------------------------------------------------------------- -->
    
    <script>
        $(".preloader").fadeOut();
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    </script>

<script>
 jQuery.validator.addMethod("emailExt", function(value, element, param) {
    return value.match(/^[a-zA-Z0-9_\.%\+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,}$/);
},'Please enter valid email');

         $("#forgotadminpasswordform").validate({
        rules: {
            email: {required: true,email: true,maxlength:50,emailExt: true,},  
        },

        messages: {
        email: {required: "Please enter valid Email",email: "Please enter valid Email",},   

        },
   submitHandler: function(form) {
      var formData= new FormData(jQuery('#forgotadminpasswordform')[0]);
     
      // u = host_url+"manage_business_signin";
      formData.append("_token",$('meta[name="csrf-token"]').attr('content'));
   jQuery.ajax({
         url: "{{route('forgotadminpasswordformcheck')}}",
         type: "POST",
         cache: false,
         data: formData,
         processData: false,
         contentType: false,
         
         success:function(data) { 
         var obj = JSON.parse(data);
        
         if(obj.status==true){
              $("#msg_error").css({ "color": "green"}); 
            //  $('#staticBackdrop').modal('show');
                $("#msg_error").text(obj.message);
                
                //$("#otpbtn").attr("href",obj.url);
            
               setTimeout(function(){ window.location.href= obj.url; }, 2000);
                

         }
         else{
               //alert(obj.status);
             if(obj.status==false){
               if(obj.status==false)
               {
                    //alert(obj.message);
                    $("#msg_error").text(obj.message);
                    
                    $("#msg_error").css({ "color": "red"}); 
                }
               else
               {
                  jQuery('#msg_error').css("display", "none");
               }
            }
            else{
               jQuery('#email_error').html('');
            }
         }
         }
      });
   }
});


      </script>

</body>

</html>


