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
            <div class="timer_area">
                <img src="{{ asset('assets/frontend/images/icons/timer.png') }}" width="80" alt="img" />
                <p class="timer_txt">0:2</p>
            </div>
            <div class="countdown_txt pt-60">
                <h5>GET READY!</h5>
                <p>
                    Waiting for other players to join the game
                </p>
            </div>
            <div class="countdown_btn_area">
                <a href="#"><button type="button" class="countdown_btn">
                        Cancel
                    </button></a>
            </div>
        </div>
    </div>
</div>
@stop