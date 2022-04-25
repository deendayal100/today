@extends('Pages.frontend.web')
@section('content')

<style>
    .padding-btn-now{
        padding-bottom: 0px!important;
        padding-top: 6px!important;
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
</style>

<div class="witget_body bg_1 text-center">
    <div class="top_area">
    <div class="top_arrow">
        <a href="#" onclick="history.back()">
        <img src="{{ asset('assets/frontend/images/icons/arrow-left.png') }}" width="14" alt="img"/>
        </a>
    </div>
    <h4 class="top_title">Reset Password</h4>
    </div>
    <form id="reset_password_form">
    <div class="Signup_area">
    <div class="Signup_box form_area">
        <div class="form_row">
            <div class="input_box">
            <div class="input_icon_left">
                <img src="{{ asset('assets/frontend/images/icons/envelop.png') }}" width="18" alt="icon"/>
            </div>
            <input type="email" name="email" id="player_email" class="input-item" placeholder="Email" autocomplete="off"/>
            </div>
        </div>
        <div class="form_row text-center padding-btn-now ">
            <a href="javascript:void(0)" class="forget-pass-player"><button type="submit" class="btn yellow_btn">
             Send  <!-- <img src="{{ asset('assets/frontend/images/icons/arrow-right.png') }}" width="22" alt="img"/> -->
            </button></a>
        </div>
        <div class="form_row text-center ">
            <a href="javascript:void(0)" class="resend-link"><button type="submit" class="btn blue_btn">
             Resend <!-- <img src="{{ asset('assets/frontend/images/icons/arrow-right.png') }}" width="22" alt="img"/> -->
            </button></a>
        </div>
    </form>
    </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
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
@stop
