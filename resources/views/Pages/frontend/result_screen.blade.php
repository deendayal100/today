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
        </div>
        <div class="nav_bg nav_toggle"></div>
    </div>
    <div class="down_body_area_long">
        <div class="down_body_long_box">
            <div class="top_icon_area">
               @if($game_status == 1)
               <img src="{{ asset('assets/frontend/images/icons/trophy.png') }}" width="80" alt="img" />
                <h5>You Win!</h5>
                @else
                <img src="{{ asset('assets/frontend/images/icons/lose-money.png') }}" width="80" alt="img" />
                <h5>You Lose!</h5>
                @endif
            </div>
            <div class="cost_title">
                <h2>${{$game_amnt}}</h2>
            </div>
            <div class="table_area_scrool_main">
                <div class="table_area_scrool custome_scrollbar_1">
                    <div class="table_area">
                        <table class="table_main" border="0" cellspacing="0" cellpadding="0" align="center"
                            style="width: 100%;">
                            <thead>
                                <tr>
                                    <td>Player</td>
                                    <td>Winner Y/N</td>
                                    <td>Correct Y/N</td>
                                    <td>Time (secs)</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($resultData))
                                @foreach($resultData as $result)
                                <tr>
                                    <td>{{$result->name}}</td>
                                    @if($result->game_status == 1)
                                    <td>Y</td>
                                    @else
                                    <td>N</td>
                                    @endif
                                    @if($result->answer == 'correct')
                                    <td>Y</td>
                                    @else
                                    <td>N</td>
                                    @endif
                                    <td>{{$result->play_time}}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="play_btns_area">
                <button type="button" class="play_btn">
                    Play Again <img src="{{ asset('assets/frontend/images/icons/reload.png') }}" width="14" alt="img" />
                </button>
                <div class="yes_no_btn">
                   <a href="{{url('/select-group')}}"> <button type="button" class="yes_btn">
                        Yes
                    </button> </a>
                   <a href="{{url('/player-account')}}"> <button type="button" class="no_btn">
                        No
                    </button></a>
                </div>
            </div>
            <!-- <div class="play_bonus_btn_area">
                <button type="button" class="play_bonus_btn">
                    Bonus Pot stands at $X
                </button>
            </div>
            <div class="progress_area">
                <h5>Progress to Bonus Pot drawing</h5>
                <div class="question_progress_main">
                    <div class="question_progress_bar" style="width: 60%;"></div>
                </div>
            </div> -->
        </div>
    </div>
</div>
@stop