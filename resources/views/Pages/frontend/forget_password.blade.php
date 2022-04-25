<!DOCTYPE html>
<html lang="en">
<head>
  <title>Reset Password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<style>
	.forget-padding{
		padding-top: 70px;
	}
	.forget-pswd{
		margin: 0 auto;
	}
	.forget-btn {
	    padding: 8px 42px;
	    border-radius: 6px;
	    background-color: #00798d;
	    border: 1px solid #00798d;
	}
	.forget-btn:hover{
		  color: #fff;
	    background-color: #00798d;
	    border-color: #00798d;
	}
</style>
<body>
	<div class="forget-padding">
		<div class="container">
			<div class="col-md-4 forget-pswd">
				<h2>Forget Password</h2>
				<form action="javascript:void(0)">
				  <div class="mb-4 mt-4">
				    <label for="email" class="form-label">New Password</label>
				    <input type="password" class="form-control" placeholder="New Password" name="email">
				  </div>
				  <div class="mb-4">
				    <label for="pwd" class="form-label">Confirm Password</label>
				    <input type="password" class="form-control" placeholder="Confirm Password" name="pswd">
				  </div>
				  <button type="submit" class="btn btn-primary forget-btn">Reset Password</button>
				</form>
			</div>	
		</div>
	</div>
	<script>
     $(function(){
        $('.forget-pass-player').on('click', function(){
            $("#reset_password_form").validate({
                rules: {
                    email: {required: true,},
                },
                messages: {
                    email: {required: "Please enter email",},
                },
                submitHandler: function () {
                    var token = $("meta[name='csrf-token']").attr("content");
                    var email = $("#player_email").val();
                    $.ajax({
                        type: 'POST',
                        url:'reset-password',
                        data: {
                            '_token': token,email:email
                        },
                        success: function(data) {
                            if(data.status==200){
                                Swal.fire(data.message) 
                                    //window.location.href = "player-account";
                            }else if(data.status == 201){
                                Swal.fire(data.message)
                            }else{
                                Swal.fire( data.message) 
                            }
                        }
                    }); 
                }
            });
        });
    });
</script>
	</script>
</body>
</html>