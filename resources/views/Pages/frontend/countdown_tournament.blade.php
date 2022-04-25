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
    <div class="nav_area">
        <div class="nav_area_box">
            <div class="nav_top_area">
                <div class="nav_user_pic">
                    <img src="{{ asset('assets/frontend/images/user-face.png') }}" alt="img" />
                </div>
                <div class="nav_user_info">
                    <h5>Player Name</h5>
                    <h4>$1245</h4>
                </div>
            </div>
            @include('Pages.frontend.includes.navbar')
            <div class="nav_bg nav_toggle"></div>
        </div>
        <div class="individual_title_1">
            <h4>
                Answer  Questions
                <br />
                As Fast As You Can
            </h4>
        </div>
        <div class="countdown_area">
            <div class="countdown_area_box">
                <div class="timer_area">
                    <img src="{{ asset('assets/frontend/images/icons/timer.png') }}" width="80" alt="img" />
                    <p class="timer_txt">5 Seconds remaining</p>
                </div>
                <div class="countdown_txt">
                    <h5>GET READY! </h5>
                    <p>
                        The set of questions differs for everybody. Winner will be notified at the end of each hour.
                        Play as
                        many times as you like for each Grand Prize!
                    </p>
                </div>
                <div class="countdown_btn_area">
                    <button type="button" class="countdown_btn">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
    countdownQuestion();
    function countdownQuestion() {
        var timeleft = 5;
        var downloadTimer = setInterval(function() {
            if (timeleft < 0) {
                clearInterval(downloadTimer);
                window.location.href = "qa-tournament";
            } else {
                $('.timer_txt').text(timeleft + " Seconds remaining");
            }
            timeleft -= 1;
        }, 1000);
    }
    </script>
    @stop