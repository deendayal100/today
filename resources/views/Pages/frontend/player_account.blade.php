@extends('Pages.frontend.web')
@section('content')

<!-- <style>
img#img_preview {
    border-radius: 50%;
    width: 79px;
    height: 79px;
    object-fit: cover;
    border: 1px solid #f4f4f4;
}
</style> -->

<div class="nav_area"></div>
<div class="witget_body bg_1 text-center">
    <div class="top_area">
        <div class="top_arrow top_toggle">
            <a class="nav_toggle">
                <img src="{{ asset('assets/frontend/images/icons/menu_icon.png') }}" width="22" alt="img" />
            </a>
        </div>
        <h4 class="top_title">Account</h4>
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
    <div class="player_account_area">
        <div class="player_account_top">
            @if(!empty($player_info))
             @if(Session::has('profile_image') && Session::get('profile_image') != null)
            <div class="name_image" style="background: none;"><img src="{{$player_info->image}}" alt="img"
                    id="img_preview" /></div>
                @else <div class="name_image">M</div> @endif
            <div class="player_name">
                <h5>{{$player_info->name}}</h5>
            </div>
            <div class="player_amount">
                <h5>$1245</h5>
            </div>
            @else
            <div class="name_image">M</div>
            <div class="player_name">
                <h5>PLAYER NAME</h5>
            </div>
            <div class="player_amount">
                <h5>$1245</h5>
            </div>
            @endif
        </div>
        <div class="player_account_links">
            <a href="{{route('player-profile')}}"><button type="button" class="account_links">
                    <img class="account_links_left_icon"
                        src="{{ asset('assets/frontend/images/icons/user-icon-2.png') }}" width="14" alt="img">
                    Player Profile
                    <img class="account_links_right_icon"
                        src="{{ asset('assets/frontend/images/icons/arrow-right-2.png') }}" width="8" alt="img">
                </button></a>
            <a href="{{route('player-fund-management')}}"><button type="button" class="account_links">
                    <img class="account_links_left_icon"
                        src="{{ asset('assets/frontend/images/icons/user-icon-3.png') }}" width="19" alt="img">
                    Player Fund Management
                    <img class="account_links_right_icon"
                        src="{{ asset('assets/frontend/images/icons/arrow-right-2.png') }}" width="8" alt="img">
                </button></a>
            <a href="{{route('player-game-history')}}"><button type="button" class="account_links">
                    <img class="account_links_left_icon" src="{{ asset('assets/frontend/images/icons/stats.png') }}"
                        width="14" alt="img">
                    Player Game History
                    <img class="account_links_right_icon"
                        src="{{ asset('assets/frontend/images/icons/arrow-right-2.png') }}" width="8" alt="img">
                </button></a>
        </div>
        <div class="social_area">
            <h5>Share</h5>
            <ul>
                <li>
                    <a href="#">
                        <img src="{{ asset('assets/frontend/images/icons/facebook.png') }}" width="30" alt="FB" />
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="{{ asset('assets/frontend/images/icons/twetter.png') }}" width="30" alt="TW" />
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="{{ asset('assets/frontend/images/icons/youtube.png') }}" width="30" alt="YT" />
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="{{ asset('assets/frontend/images/icons/insta.png') }}" width="30" alt="IG" />
                    </a>
                </li>
            </ul>
        </div>
        <div class="player_account_btn_area">
            <a href="{{route('select-group')}}"><button type="button" class="group_btn">PLAY IN GROUP</button></a>
            <a href="{{route('tournament-ante')}}"><button type="button" class="tournament_btn">PLAY IN THE HOURLY
                    TOURNAMENT</button></a>
        </div>
    </div>
</div>
@stop