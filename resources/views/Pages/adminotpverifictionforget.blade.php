<!DOCTYPE html>
<html lang="en">
<head>
  <title>OTP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>

	<style>
		.body{
			font-family: 'Poppins', sans-serif;
		}
		.margin_top_align{
			margin-top: 10rem;
		}
		.otp_screen h3{
			font-size: 34px;
		}
		.otp_screen p{
			font-size: 20px;
			margin: 15px 0px;
		}
		
		.otp_screen .verify_otp input{
			width: 80px;
		    height: 66px;
		    border-radius: 5px;
		    border: 1px solid #c5c5c5;
		    text-align: center;
		    margin-top: 15px;

		}
		.otp_screen button {
			padding: 8px 46px;
			border: 1px solid #d66821;
			color: #fff;
			background: #d66821;
			border-radius: 8px;
			font-size: 20px;
			margin-top: 46px;
			margin-bottom: 15px;
		}
	</style>

<div class="container margin_top_align">
 	<div class="text-center">
 		<div class="otp_screen">
	 		<h3>Please Enter OTP</h3>
	 		<p>We have sent you one time password to your Email Address</p>
	 		<span id="timer">Your OTP Exprie :2:00</span>
          <span style="color:red" class=".result"></span>
           @if (\Session::has('message'))
                    <div class="alert alert-success">
                        <ul>
                            <li style=" list-style: none;">{!! \Session::get('message') !!}</li>
                        </ul>
                    </div>
                @endif
	 		<div class="verify_otp">
	 			<form method="POST" class="digit-group" data-group-name="digits" id="adminverify_otp" data-autosubmit="false" autocomplete="off">
                 <input type="hidden" name="id" value="{{$user_data->id}}">
                 <input type="hidden" name="email" value="{{$user_data->email}}">
                 @csrf
                 <input type="text" id="digit-1" name="digit1" data-next="digit-2"  />
					<input type="text" id="digit-2" name="digit2" data-next="digit-3" data-previous="digit-1"  />
					<input type="text" id="digit-3" name="digit3" data-next="digit-4" data-previous="digit-2"  />
					<input type="text" id="digit-4" name="digit4" data-next="digit-5" data-previous="digit-3"  />
                    <input type="text" id="digit-5" name="digit5" data-next="digit-6" data-previous="digit-4"   / >
                    <input type="text" id="digit-6" name="digit6" data-next="digit-7" data-previous="digit-5"  />
                   <br> <span class="result" style="color:red"></span>
                    <br>
                    <button type="submit">Verify</button>
                    <br>
                     <a href="{{$resend_otp}}" disabled class="f-16 fm secondary-100 " disabled = "true" id="resendotp">Resend OTP</a>
                          <span id="lblrecendotp" >Resend OTP</span>
                </form>

            </div>

	 	</div>
 	</div>
</div>

</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script>

	

$('.digit-group').find('input').each(function() {
	$(this).attr('maxlength', 1);
	$(this).on('keyup', function(e) {
		var parent = $($(this).parent());
		
		if(e.keyCode === 8 || e.keyCode === 37) {
			var prev = parent.find('input#' + $(this).data('previous'));
			
			if(prev.length) {
				$(prev).select();
			}
		} else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
			var next = parent.find('input#' + $(this).data('next'));
			
			if(next.length) {
				$(next).select();
			} else {
				// if(parent.data('autosubmit')) {
				// 	parent.submit();
				// }
			}
		}
	});
});	
</script>
<script>
	let timerOn = true;

function timer(remaining) {
  var m = Math.floor(remaining / 60);
  var s = remaining % 60;
  
  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;
  document.getElementById('timer').innerHTML = "Time left  "+ m + ':' + s;
  remaining -= 1;
  
  if(remaining >= 0 && timerOn) {
    setTimeout(function() {
        timer(remaining);
    }, 1000);
    return;
  }
  else
  {
   $("#lblrecendotp").hide();
     $('#resendotp').show();
  }

  if(!timerOn) {
    // Do validate stuff here
    return;
  }
  
  // Do timeout stuff here
  // alert('Timeout for otp');
}
timer(60);
</script>
<script>
   $(function(){
   	  $("#lblrecendotp").css({"color":'#d66821','cursor':"no-drop"});
      $("#resendotp").hide();
      
   host_url ="/development/wemarkthespot";
   $("#adminverify_otp").validate({
      rules: {
         // digit1: {
         //    required: true,
         // },
         // digit2: {
         //    required: true,
         // },
         // digit3: {
         //    required: true,
         // },
         // digit4: {
         //    required: true,
         // },
         // digit5: {
         //    required: true,
         // },

         // digit6: {
         //    required: true,
         // },
      },
      
      messages: {
         // digit1: {required: "Please enter otp",},
         // digit2: {required: "Please enter otp",},
         // digit3: {required: "Please enter otp",},
         // digit4: {required: "Please enter otp",},
         // digit5: {required: "Please enter otp",},
         // digit6: {required: "Please enter otp",},

      },
      submitHandler: function(form) {
         var formData= new FormData(jQuery('#adminverify_otp')[0]);
      formData.append("_token",$('meta[name="csrf-token"]').attr('content'));
         // u ="development/wemarkthespot/";
        
      jQuery.ajax({
            url: "{{route('adminverify_otp')}}",
            type: "post",
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            
            success:function(data) { 
            var obj = JSON.parse(data);
            
            if(obj.status==true){
            //console.log(host_url+'adminforgetpasswordview'+obj.url);
               $(".result").text(obj.message);
               setTimeout(function(){
                  // $("#b_trainer").modal('show');
                  window.location.href =obj.url;
               }, 1000);
            }
            else{
               if(obj.status==false){
                  $(".result").text(obj.message);
                  jQuery('.result').css("display", "block");
               }
               
            }
            }
         });
      }
   }); 
});
</script>
