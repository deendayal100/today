@extends('Pages.frontend.web')
@section('content')

<style>
.upload-image .input-item {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}
img#img_preview {
    border-radius: 50%;
    width: 116px;
    height: 116px;
    object-fit: cover;
    border: 1px solid #f4f4f4;
}
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
</style>

<div class="witget_body bg_1 text-center">
    <div class="top_area">
    <div class="top_arrow">
        <a href="#" onclick="history.back()">
        <img src="{{ asset('assets/frontend/images/icons/arrow-left.png') }}" width="14" alt="img"/>
        </a>
    </div>
    <h4 class="top_title">Sign up</h4>
    </div>
    <form id="player_signup_form">
    <div class="Signup_area">
    <div class="Signup_box form_area">
        <div class="user_face">
            <img src="{{ asset('assets/frontend/images/user-face.png') }}" alt="img" id="img_preview"/>
            <div class="click_photo" id="camera_icon_click">
                <div class="upload-image">
                <img src="{{ asset('assets/frontend/images/icons/camera.png') }}" alt="img" />
                <input type="file"  accept="image/*" name="profile_image" class="input-item" id="player_profile_image" />
                </div>
            </div>
        </div>
        <form >
            
            <div class="form_row">
                <div class="input_box">
                <div class="input_icon_left">
                    <img src="{{ asset('assets/frontend/images/icons/user.png') }}" width="22" alt="icon"/>
                </div>
                <input type="text" name="name" class="input-item" id="player_name_add" placeholder="Player Name" autocomplete="off"/>
                </div>
            </div>
            <div class="form_row">
                <div class="input_box">
                <div class="input_icon_left">
                    <img src="{{ asset('assets/frontend/images/icons/@.png') }}" width="16" alt="icon"/>
                </div>
                <!-- <input type="text" name="username" id="player_username_add" class="input-item" placeholder="Alias"/> -->
                <input type="text" name="alias" id="player_username_add" class="input-item" placeholder="Alias" autocomplete="off"/>
                </div>
            </div>
            <div class="form_row">
                <div class="input_box">
                <div class="input_icon_left">
                    <img src="{{ asset('assets/frontend/images/icons/envelop.png') }}" width="18" alt="icon"/>
                </div>
                <input type="email" name="email" id="player_email_add" class="input-item" placeholder="Email" autocomplete="off"/>
                </div>
            </div>
            <div class="form_row">
                <div class="input_box">
                <div class="input_icon_left">
                    <img src="{{ asset('assets/frontend/images/icons/lock.png') }}" width="22" alt="icon"/>
                </div>
                <input type="password" name="password" id="player_password_add" class="input-item " placeholder="Password"/>
                <div class="input_icon_right toggle-password">
                    <img id="my_image" src="{{ asset('assets/frontend/images/icons/eye-close.png') }}" width="22" alt="icon" autocomplete="off"/>
                </div>
                </div>
            </div>
            <div class="form_row text-center pt_10">
                <a href="javascript:void(0)" class="player_signup"><button type="submit" class="btn blue_btn">
                Sign up <img src="{{ asset('assets/frontend/images/icons/add.png') }}" width="22" alt="img"/>
                </button></a>
            </div>
        </form>
        <div class="validationError"></div>
        <div class="new_SignIn">
            <p class="para_1">
                Already have an account? <a href="{{route('signin')}}" class="yellow_txt">Sign in</a>
            </p>
        </div>
    </div>
    </div>
</div>


<script>

    $("body").on('click', '.toggle-password', function() {
        var input = $("#player_password_add");
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

    $("#camera_icon_click").click( function() {
        $("#image_div").css("display","block")
    });

    $("#player_profile_image").change(function () {
        var imgUrl = URL.createObjectURL(event.target.files[0]);
        $("#img_preview").attr("src",imgUrl);
    });

    $(document).on('submit', '#player_signup_form', function(event){
        event.preventDefault();
        var formData = new FormData(this);
        formData.append("_token",$('meta[name="csrf-token"]').attr('content'));
        jQuery.ajax({
            url:  "player-signup",
            type: "post",
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            success:function(data,staus) {
                var obj = JSON.parse(data);
                if(obj.status==200){
                    Swal.fire(
                        obj.message
                    )
                    setTimeout(function(){
                        window.location.href = "homepage";
                    },2000);                            
                }else{
                    Swal.fire(
                        obj.message
                    )
                }
            }
        });
    });
</script>
@stop