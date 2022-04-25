@extends('Pages.frontend.web')
@section('content')
<style>
    .error {
        color: #FF0000;
        margin: 0;
        font-size: 15px;
        font-weight: normal;
        display: block;
    }
    .swal2-popup {
        font-size: 0.50rem;
    }
    .para_1 {
        font-size: 15px;
    }
    .forgetpassbtn{
        max-width: 80px;
        height: 35px;
    }
</style>
<div class="witget_body bg_1 text-center">
    <div class="top_area">
    <div class="top_arrow">
        <a href="#" onclick="history.back()">
        <img src="{{ asset('assets/frontend/images/icons/arrow-left.png') }}" width="14" alt="img"/>
        </a>
    </div>
    <h4 class="top_title">Sign in</h4>
    </div>
    <div class="witget_logo_area">
    <div class="logo_area">
        <img src="{{ asset('assets/frontend/images/logo.png') }}" width="139" alt="img"/>
    </div>
    <div class="title_1">
        <h4>It Ain't Luck</h4>
    </div>
    </div>
    <div class="SignIn_area">
    <div class="SignIn_box form_area">
        <form id="player_signin">
        <div class="form_row">
            <div class="input_box">
            <div class="input_icon_left">
                <img src="{{ asset('assets/frontend/images/icons/user.png') }}" width="22" alt="icon"/>
            </div>
            <input type="text" name="name" id="player_name_signin" class="input-item" placeholder="Alias" autocomplete="off" />
            </div>
        </div>
        <div class="form_row">
            <div class="input_box">
            <div class="input_icon_left">
                <img src="{{ asset('assets/frontend/images/icons/lock.png') }}" width="22" alt="icon"/>
            </div>
            <input type="password" name="password" id="player_password_signin" class="input-item" placeholder="Password" autocomplete="off"/>
            <div class="input_icon_right toggle-password">
                <img id="my_image" src="{{ asset('assets/frontend/images/icons/eye-close.png') }}" width="22" alt="icon"/>
                
            </div>
            </div>
        </div>
        <div class="form_row text-center">
            <a href="{{route('frontend-forget-password')}}" class="f_password">Forgot password?</a>
        </div>
        <div class="form_row text-center pt_20">
            <a href="javascript:void(0)" class="player-signin"><button type="submit" class="btn yellow_btn">
            Sign in <img src="{{ asset('assets/frontend/images/icons/arrow-right.png') }}" width="22" alt="img"/>
            </button></a>
        </div>
        </form>
        <div class="new_SignIn">
        <p class="para_1">
            Don’t have an account? <a href="{{route('signup')}}" class="yellow_txt">Sign up</a>
        </p>
        </div>
    </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="{{ asset('assets/admin/dist/js/session.js') }}"></script>
<script>

    $("body").on('click', '.toggle-password', function() {
        var input = $("#player_password_signin");
        var eye = "{{ asset('assets/frontend/images/icons/eye.png') }}";
        var eyeClose = "{{ asset('assets/frontend/images/icons/eye-close.png') }}";
        if (input.attr("type") === "password") {
            input.attr("type", "text");
            $("#my_image").attr("src",eye);
        } else {
            input.attr("type", "password");
            $("#my_image").attr("src",eyeClose);
        }
    });

    $(function(){
        $('.player-signin').on('click', function(){
            $("#player_signin").validate({
                rules: {
                    name: {required: true,},
                    password:{required:true},
                },
                messages: {
                    name: {required: "Please enter name",},
                    password: {required: "Please enter password",},
                },
                submitHandler: function () {
                    var token = $("meta[name='csrf-token']").attr("content");
                    var name = $("#player_name_signin").val();
                    var password = $("#player_password_signin").val();
                    $.ajax({
                        type: 'POST',
                        url:'player-signin',
                        data: {
                            '_token': token,alias:name,password:password
                        },
                        success: function(data,status) {
                            var obj = JSON.parse(data);
                            if(status == 'success'){
                                if(obj.status==true){
                                    if(obj.data==null){
                                        Swal.fire(
                                            obj.message
                                        ) 
                                    }else{
                                        window.location.href = "player-account";
                                    }
                                }else{
                                    Swal.fire(
                                        obj.messages
                                    )
                                }
                            }
                        }
                    }); 
                }
            });
        });
    });

</script>

@stop