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
 
/* img#img_preview {
    border-radius: 50%;
    width: 116px;
    height: 116px;
    object-fit: cover;
    border: 1px solid #f4f4f4;
}  */

.swal2-popup {
        font-size: 0.50rem;
    }
    .para_1 {
        font-size: 15px;
    }

.input_color_white {
    opacity: 1.0;
}

.form-control::placeholder {
    color: $main;
    opacity: 0.7;
}

.form-control::-ms-input-placeholder {
    color: $main;
    opacity: 0.7;
}
</style>

<div class="witget_body bg_1 text-center">
    <div class="top_area">
        <div class="top_arrow top_toggle">
            <a class="nav_toggle">
                <img src="{{ asset('assets/frontend/images/icons/menu_icon.png') }}" width="22" alt="img" />
            </a>
        </div>
        <h4 class="top_title">Profile</h4>
        <div class="top_amount">
            <div class="top_amount_box">
                <img src="{{ asset('assets/frontend/images/icons/m.png') }}" alt="img" />
                <span class="amount_txt">
                    $1245
                </span>
            </div>
        </div>
    </div>
    @include('Pages.frontend.includes.navbar')
    <form id="player_profile_form">
        <div class="Signup_area">
            <div class="Signup_box form_area pb-20">
                <div class="user_face">
                    @if(!empty($player_info))
                    @if(!isset($player_info->image) && $player_info->image != null)
                    <img src="{{$player_info->image}}" alt="img" id="img_preview" />
                    @else
                    <img src="{{ asset('assets/frontend/images/user-face.png') }}" alt="img"  id="img_preview"/>
                    @endif
                    @endif
                    <div class="click_photo">
                        <div class="upload-image">
                            <img src="{{ asset('assets/frontend/images/icons/camera.png') }}" alt="img" />
                            <input type="file" accept="image/*" name="profile_image" class="input-item player_profile_image"
                                id="player_profile_image" />
                        </div>
                    </div>
                </div>
                <div class="form_row">
                    <div class="input_box">
                        <div class="input_icon_left">
                            <img src="{{ asset('assets/frontend/images/icons/user.png') }}" width="22" alt="icon" />
                        </div>
                        @if(!empty($player_info))
                        <input type="text" name="name" class="input-item input_color_white" placeholder="Player Name"
                            value="{{$player_info->name}}" />
                        @else
                        <input type="text" name="name" class="input-item" placeholder="Player Name" value="" />
                        @endif
                    </div>
                </div>
                <div class="form_row">
                    <div class="input_box">
                        <div class="input_icon_left">
                            <img src="{{ asset('assets/frontend/images/icons/@.png') }}" width="16" alt="icon" />
                        </div>
                        @if(!empty($player_info))
                        <input type="text" name="alias" class="input-item input_color_white" placeholder="Alias"
                            value="{{$player_info->alias}}" />
                        @else
                        <input type="text" name="alias" class="input-item" placeholder="Alias" value="" />
                        @endif
                    </div>
                </div>
                <div class="form_row">
                    <div class="input_box">
                        <div class="input_icon_left">
                            <img src="{{ asset('assets/frontend/images/icons/envelop.png') }}" width="18" alt="icon" />
                        </div>
                        @if(!empty($player_info))
                        <input type="email" name="email" class="input-item input_color_white" placeholder="Email"
                            value="{{$player_info->email}}" />
                        @else
                        <input type="email" name="email" class="input-item" placeholder="Email" value="" />
                        @endif
                    </div>
                </div>
                <div class="form_row">
                    <div class="form_sub_title">
                        <h4>Update Password</h4>
                    </div>
                </div>
                <div class="form_row">
                    <div class="input_box">
                        <div class="input_icon_left">
                            <img src="{{ asset('assets/frontend/images/icons/lock.png') }}" width="22" alt="icon" />
                        </div>
                        <input type="password" name="password" class="input-item input_color_white"
                            placeholder="Password" />
                    </div>
                </div>
                <div class="form_row">
                    <div class="input_box">
                        <div class="input_icon_left">
                            <img src="{{ asset('assets/frontend/images/icons/lock.png') }}" width="22" alt="icon" />
                        </div>
                        <input type="password" name="new_password" class="input-item input_color_white"
                            placeholder="New Password" />
                    </div>
                </div>
                <div class="form_row text-center">
                    <a href="javascript:void(0)" class="player-profile-update"><button type="submit" class="update_btn">
                            Update
                        </button></a>
                </div>
    </form>
</div>
</div>
</div>

<script>
$("#camera_icon_click").click(function() {
    $("#image_div").css("display", "block")
});

$("#player_profile_image").change(function() {
    var imgUrl = URL.createObjectURL(event.target.files[0]);
    console.log(imgUrl);
    $("#img_preview").attr("src", imgUrl);
});

$(document).on('submit', '#player_profile_form', function(event) {
    event.preventDefault();
    var formData = new FormData(this);
    formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
    jQuery.ajax({
        url: "player-profile-update",
        type: "post",
        cache: false,
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, staus) {
            var obj = JSON.parse(data);
            // console.log(obj);
            // if(status == 'success'){
            if (obj.status == true) {
                Swal.fire(
                    'Success',
                    obj.message,
                    'success'
                )
                setTimeout(function() {
                    window.location.href = "homepage";
                }, 2000);
            } else {
                Swal.fire(
                    'Warning',
                    obj.message,
                    'warning'
                )
            }
            // }

        }
    });
});
</script>
@stop