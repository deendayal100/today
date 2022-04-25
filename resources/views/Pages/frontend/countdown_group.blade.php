@extends('Pages.frontend.web')
@section('content')
<div class="witget_body bg_1 text-center">
    <div class="top_area">
        <div class="top_arrow top_toggle">
            <a class="nav_toggle">
                <img src="{{ asset('assets/frontend/images/icons/menu_icon.png') }}" width="22" alt="img" />
            </a>
        </div>
        <h4 class="top_title"></h4>
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
    <div class="individual_title_1">

    </div>
    <div class="countdown_area">
        <div class="countdown_area_box">
            <div class="timer_area" style="display: none;">
                <img src="{{ asset('assets/frontend/images/icons/timer.png') }}" width="80" alt="img" />
                <p class="timer_txt">0:0 Seconds</p>
            </div>
            <div class="countdown_txt pt-60">
                <h5 class="timer_ready" style="display: none;">GET READY!</h5>
                <p class="warning_msg">
                    Waiting for other players to join the game
                </p>
            </div>
            <div class="countdown_btn_area remove_player">
                <a href="#"><button type="button" class="countdown_btn">
                        Cancel
                </button></a>
            </div>
        </div>
    </div>
</div>
<script>
    $(".remove_player").click(function()
    {
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'POST',
            url:'remove-from-group',
            data: {
                '_token': token
            },
            success: function(data,status) {
                if(data.status==true){
                    window.location.href = "select-group";
                }               
            }
        });
    });

    group_check();
    function group_check(){
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'POST',
            url:'group-complete-check',
            data: {
                '_token': token
            },
            success: function(data,status) {
                if(data.status==true){
                    var timer = null;
                    $('.timer_area').css("display", "block");
                    $('.timer_ready').css("display", "block");
                    $('.warning_msg').text("Game is starting.");
                    // var counter = 0;
                    // var start = new Date;
                    // var timer = setInterval(function() {
                    //     counter++;
                    //     $('.timer_txt').text(counter+":0 Seconds");
                    //     if (counter == 5) {
                    //         clearInterval(timer);
                    //         window.location.href = "question-screen";
                    //     }
                    // }, 1000);
                    var timeleft = 5;
                    var downloadTimer = setInterval(function(){
                        if(timeleft < 0){
                            clearInterval(downloadTimer);
                            window.location.href = "question-screen";
                        } else {
                            $('.timer_txt').text(timeleft+" Seconds remaining");
                        }
                        timeleft -= 1;
                    }, 1000);
                }else{
                    group_check();
                }              
            }
        });
    }
   
</script>
@stop