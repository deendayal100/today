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
    <title>Forget Password</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="public/assets/admin/images/favicon.png">
    <!-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/> -->
    <!-- Custom CSS -->
    <link href="{{ asset('public/assets/admin/dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/admin/dist/css/custom.css') }}" rel="stylesheet">
    <script src="{{ asset('public/assets/admin/libs/jquery/dist/jquery.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
                        <h3 class="box-title mb-3 text-center">Reset New Password</h3>
                    </div>
                    <span id="error_message" style="color:red"></span>
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
                            <form method="POST" class="form-horizontal mt-3 form-material" id="adminconfirmpassword" action="{{ route('login.custom') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{$id}}"/>
                                <div class="form-group mb-4 icons-set" style="overflow: inherit;">
                                    <div class="input-group align-items-center">
                                        <span class="icon-right fa input_icon fa-eye-slash icons" id="hidden1" data-name="password"></span>
                                        <input type="password" placeholder="Password" id="password" class="form-control special_characters_type" name="password" required>

                                        
                                        @if ($errors->has('password'))
                                        <span class="alert alert-danger">{{ $errors->first('password') }}</span>
                                        @endif   
                                    <div class="password_hints" id="password_hints">
                                       <h4>Password must meet the following requirements:</h4>
                                       <ul>
                                          <li id="letter" class="invalid letter">At least <strong>one special character</strong></li>
                                          <li id="capital" class="invalid capital">At least <strong>one capital letter</strong></li>
                                          <li id="small" class="invalid small">At least <strong>one small letter</strong></li>
                                          <li id="number" class="invalid number">At least <strong>one number</strong></li>
                                          <li id="length" class="invalid length">Be at least <strong>6 characters</strong></li>
                                       </ul>
                                    </div> 
                                    </div>
                                </div>
                                <div class="form-group mb-4  icons-set" style="overflow: inherit;">
                                    <div class="input-group align-items-center icons-set">
                                        <span class="icon-right fa input_icon fa-eye-slash icons " id="hidden2" data-name="cpassword"></span>
                                 <input type="password" placeholder="Confirm Password" id="cpassword" class="form-control" name="cpassword" required>

                                        
                                        @if ($errors->has('cpassword'))
                                        <span class="alert alert-danger">{{ $errors->first('cpassword') }}</span>
                                        @endif    
                                    </div>
                                </div>

                            
                                <div class="form-group text-center mt-4 mb-3">
                                    <div class="col-xs-12">
                                    <a href="{{ url('/dashboard') }}">
                                        <button class="btn btn-info d-block w-100 waves-effect waves-light" type="submit">Save</button>
                                    </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="recoverform">
                    <div class="logo">
                        <h3 class="font-weight-medium mb-3">Recover Password</h3>
                        <span class="text-muted">Enter your Email and instructions will be sent to you!</span>
                    </div>
                    <div class="row mt-3 form-material">
                        <!-- Form -->
                        <form class="col-12" action="{{ url('/dashboard') }}">
                            <!-- email -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="email" required="" placeholder="Username">
                                </div>
                            </div>
                            <!-- pwd -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button class="btn d-block w-100 btn-info text-uppercase" type="submit" name="action">Reset</button>
                                </div>
                            </div>
							<div class="form-group mb-0 mt-4">
								<div class="col-sm-12 justify-content-center d-flex">
									<p><a href="{{ url('/login') }}" class="text-info font-weight-medium ms-1">Sign In</a></p>
								</div>
							</div>
                        </form>
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
    <!-- -------------------------------------------------------------- -->
    <!-- This page plugin js -->
    <!-- -------------------------------------------------------------- -->
    <style>

   .password_hints {
      position: absolute;
      top: 60px;
      bottom: -115px\9;
      right: 55px;
      width: 220px;
      padding: 15px;
      background: #fefefe;
      font-size: .875em;
      border-radius: 5px;
      box-shadow: 0 1px 3px #ccc;
      border: 1px solid #ddd;
      z-index: 9;
   }
   .position-relative {
       position:relative; 
   }
   .password_hints ul {
      list-style:none;
      margin:0;
      padding:0;
   }
   .password_hints ul li {
      margin: 0;
      padding: 0;
      list-style: none;
      font-size: 13px;
      line-height: 25px;
   }
   .password_hints::before {
      content: "\25B2";
      position:absolute;
      top:-12px;
      left:45%;
      font-size:14px;
      line-height:14px;
      color:#ddd;
      text-shadow:none;
      display:block;
   }
   .invalid {
      background-image:url(../images/invalid.png) no-repeat 0 50%;
      color:#ec3f41;
   }
   .valid {
      background-image:url(../images/valid.png) no-repeat 0 50%;
      color:#3a7d34;
   }


   .password_hints h4 {
      font-size: 13px;
   }
   .password_hints {
      display:none;
   }
   #password-error {
        display: block;
        width: 100%;
    }
    #cpassword-error {
        display: block;
        width: 100%;
    }
    .icons {
        position: absolute;
        right: 0;
        bottom: 8px;
		z-index: 999;
		cursor: pointer;
    }
    .icons-set{
        position: relative;
    }
	label#password-error , label#cpassword-error{
    position: absolute;
    top: 36px;
}

   </style>
   <script>
   jQuery(document).ready(function() {
       c1 = 0;
       c2 = 0;
       c3 = 0;
       c4 = 0;
       c5 = 0;
      jQuery('.special_characters_type').keyup(function() {
         
      

         var pswd = jQuery(this).val();
         if ( pswd.length < 8 ) {
      
         console.log("1->"+$("#checksubmit").attr("data-val"));
             c1= 0;
          if( c2=='1' && c3=='1' && c4=='1' && c5=='1')
               {
               console.log("2->"+$("#checksubmit").attr("data-val"));
               $("#checksubmit").attr("data-val",1);
                     $("#UserPassword").attr("data-val",1);
            }
               else
               {
                  console.log("3->" +"pswd.length===>"+ pswd.length +$("#checksubmit").attr("data-val"));
                  $("#checksubmit").attr("data-val",0);
                  $("#UserPassword").attr("data-val",0);
               
               }
            jQuery('.length').removeClass('valid').addClass('invalid');
         } else {
                c1 = 1;

                if(c1=='1' && c2=='1' && c3=='1' && c4=='1' && c5=='1')
                  {
                  console.log("4 if->" +"pswd.length===>"+ pswd.length +$("#checksubmit").attr("data-val"));
                  $("#checksubmit").attr("data-val",1);
                  console.log("3->"+$("#checksubmit").attr("data-val"));
                                 //$("#checksubmit").attr("data-val",1);
                     $("#UserPassword").attr("data-val",1);
                  }
               else
               {
                     console.log("5->" +"pswd.length===>"+ pswd.length +$("#checksubmit").attr("data-val"));
                  
               console.log("5->"+$("#checksubmit").attr("data-val"));
                              $("#checksubmit").attr("data-val",0);
                  $("#UserPassword").attr("data-val",0);
               
               }
                console.log("c1=dd=>"+c1);
            jQuery('.length').removeClass('invalid').addClass('valid');
         }
         //validate letter
         if ( pswd.match(/[?,=,.,*,!,#,$,%,&,?,@, ,"]/) ) {
             c2 = 1;
              if(c1=='1' && c2=='1' && c3=='1' && c4=='1' && c5=='1')
                  {
                  console.log("6->"+$("#checksubmit").attr("data-val"));
                                 $("#checksubmit").attr("data-val",1);
                     $("#UserPassword").attr("data-val",1);
                  }
               else
               {
               console.log("7->"+$("#checksubmit").attr("data-val"));
                              $("#checksubmit").attr("data-val",0);

                  $("#UserPassword").attr("data-val",0);
               
               }

                            console.log("c2==>"+c2);
            jQuery('.letter').removeClass('invalid').addClass('valid');
         } else {
            c2= 0;
          if(c1=='1' && c2=='1' && c3=='1' && c4=='1' && c5=='1')
               {
               console.log("8->"+$("#checksubmit").attr("data-val"));
                              $("#checksubmit").attr("data-val",1);
                     $("#UserPassword").attr("data-val",1);
            }
               else
               {
               console.log("9->"+$("#checksubmit").attr("data-val"));
                              $("#checksubmit").attr("data-val",0);
                  $("#UserPassword").attr("data-val",0);
               
               }
            jQuery('.letter').removeClass('valid').addClass('invalid');
         }

         //validate capital letter
         if ( pswd.match(/[A-Z]/) ) {
            c3 =1;
             if(c1=='1' && c2=='1' && c3=='1' && c4=='1' && c5=='1')
                  {
                  console.log("10->"+$("#checksubmit").attr("data-val"));
                                 $("#checksubmit").attr("data-val",1);
                     $("#UserPassword").attr("data-val",1);
                  }
               else
               {
               console.log("11->"+$("#checksubmit").attr("data-val"));
                              $("#checksubmit").attr("data-val",0);
                  $("#UserPassword").attr("data-val",0);
               
               }

                            console.log("c3==>"+c3);
            jQuery('.capital').removeClass('invalid').addClass('valid');
         } else {
             c3= 0;
          if(c1=='1' && c2=='1' && c3=='1' && c4=='1' && c5=='1')
               {
               console.log("12->"+$("#checksubmit").attr("data-val"));
                              $("#checksubmit").attr("data-val",1);
                     $("#UserPassword").attr("data-val",1);
            }
               else
               {
               console.log("13->"+$("#checksubmit").attr("data-val"));
                              $("#checksubmit").attr("data-val",0);
                  $("#UserPassword").attr("data-val",0);
               
               }
            jQuery('.capital').removeClass('valid').addClass('invalid');
         }

         //validate capital letter
         if ( pswd.match(/[a-z]/) ) {
          c4 = 1;
          if(c1=='1' && c2=='1' && c3=='1' && c4=='1' && c5=='1')
                  {
                  console.log("14->"+$("#checksubmit").attr("data-val"));
                                 $("#checksubmit").attr("data-val",1);
                     $("#UserPassword").attr("data-val",1);
                  }
                 else
                   {
                   console.log("15->"+$("#checksubmit").attr("data-val"));
                                 $("#checksubmit").attr("data-val",0);
                   $("#UserPassword").attr("data-val",0);
               
                  }

                     console.log("c4==>"+c4);
            jQuery('.small').removeClass('invalid').addClass('valid');
         } else {
            c4= 0;
          if(c1=='1' && c2=='1' && c3=='1' && c4=='1' && c5=='1')
               {
               console.log("17->"+$("#checksubmit").attr("data-val"));
                              $("#checksubmit").attr("data-val",1);
                     $("#UserPassword").attr("data-val",1);
            }
               else
               {
               console.log("18->"+$("#checksubmit").attr("data-val"));
                              $("#checksubmit").attr("data-val",0);
                  $("#UserPassword").attr("data-val",0);
               
               }
            jQuery('.small').removeClass('valid').addClass('invalid');

         }

         //validate number
         if ( pswd.match(/\d/) ) {
         c5= 1;
          if(c1=='1' && c2=='1' && c3=='1' && c4=='1' && c5=='1')
               {
               console.log("20->"+$("#checksubmit").attr("data-val"));
                              $("#checksubmit").attr("data-val",1);
                     $("#UserPassword").attr("data-val",1);
            }
               else
               {
               console.log("21->"+$("#checksubmit").attr("data-val"));
                              $("#checksubmit").attr("data-val",0);
                  $("#UserPassword").attr("data-val",0);
               
               }

                         console.log("c5==>"+c5);
            jQuery('.number').removeClass('invalid').addClass('valid');
         } else {
         c5= 0;
          if(c1=='1' && c2=='1' && c3=='1' && c4=='1' && c5=='1')
               {
               console.log("22->"+$("#checksubmit").attr("data-val"));
                  $("#checksubmit").attr("data-val",1);
                     $("#UserPassword").attr("data-val",1);
            }
               else
               {
               console.log("23->"+$("#checksubmit").attr("data-val"));
                  $("#checksubmit").attr("data-val",0);
                  $("#UserPassword").attr("data-val",0);
               
               }
            jQuery('.number').removeClass('valid').addClass('invalid');
         }
         
      }).focus(function() {
         jQuery('#password_hints').show();
      }).blur(function() {
         jQuery('#password_hints').hide();
      });
   



   });
   

   </script>
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
        $("#hidden1").on("click",function(){
           type=$("#password").attr("type");
            if(type=='password')
           {

               $("input[name='"+$(this).data("name")+"']").attr("type",'text');
               $("#hidden1").removeClass('fa-eye-slash');
               $("#hidden1").addClass('fa-eye');

           }
           else
           {
               $("input[name='"+$(this).data("name")+"']").attr("type",'password');
                $("#hidden1").addClass('fa-eye-slash');
               $("#hidden1").removeClass('fa-eye');
           }
        });
        $("#hidden2").on("click",function(){
           type=$("#cpassword").attr("type");
            if(type=='password')
           {

               $("input[name='"+$(this).data("name")+"']").attr("type",'text');
               $("#hidden2").removeClass('fa-eye-slash');
               $("#hidden2").addClass('fa-eye');

           }
           else
           {
               $("input[name='"+$(this).data("name")+"']").attr("type",'password');
                $("#hidden2").addClass('fa-eye-slash');
               $("#hidden2").removeClass('fa-eye');
           }
        });
    </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script>
   $(function(){
     patten ="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$";
        jQuery.validator.addMethod("passwordcheck", function(value, element, param) {
    return value.match(patten);
},'Please enter valid password');
   $("#adminconfirmpassword").validate({
      rules: {
        password: {
            required: true,
            minlength:6,
             passwordcheck:true,
            maxlength:50
         },
         cpassword: {
            required: true,
            minlength:6,
            maxlength:50,
            equalTo: "#password"

         },
        
      },
      
      messages: {
        password: {required: "Please enter password",},
        cpassword:{required:"Please enter confirm password.", equalTo:"Password and confirm password must be same."},
        

      },
      submitHandler: function(form) {
         var formData= new FormData(jQuery('#adminconfirmpassword')[0]);
      formData.append("_token",$('meta[name="csrf-token"]').attr('content'));
        
      jQuery.ajax({
            url: "{{route('verify_adminforgetpassword')}}",
            type: "post",
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            
            success:function(data) { 
            var obj = JSON.parse(data);
        
            if(obj.status==true){
               //  $("#staticBackdrop").modal('show');
               // $("#msgotp").text(obj.message);
                  $("#error_message").text(obj.message);
                  setTimeout(function(){ 
                     window.location.href="{{route('login')}}";

                   }, 2000);
             //   $("#btnok").attr("href",obj.url);
            }
            else{
               if(obj.status==false){
                  $("#error_message").text(obj.message);
               //      $("#staticBackdrop").modal('show');
               //  $("#msgotp").text(obj.message);
               //  $("#btnok").attr("href","#");
               }
             
            }
            }
         });
      }
   }); 
});
</script>
</body>

</html>


