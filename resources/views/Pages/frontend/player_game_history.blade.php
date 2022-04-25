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
    <div class="down_body_area_long">
        <div class="down_body_long_box">

            <div class="top_user_area">
            @if(Session::has('profile_image') && Session::get('profile_image') != null)
                <img src="{{Session::get('profile_image')}}" width="80" alt="img" id="img_preview"/>
                @else <img src="{{ asset('assets/frontend/images/user-face-2.png') }}" width="80" alt="img" id="img_preview"/> @endif
            </div>

            <div class="table_area_row">
                <div class="items_title_area">
               
                 <img class="items_title_img" src="{{ asset('assets/frontend/images/icons/game-controlar.png') }}"
                        width="36" alt="img" /> 
                    <h5>Gameplay</h5>
                    <p>Results</p>
                </div>
                <div class="table_area_box">
                    <table class="table_main_2" border="0" cellspacing="0" cellpadding="0" align="center"
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
                        @if(!empty($group_res))
                        @foreach($group_res as $result)
                        <tr>
                            <td>{{$result->player_name}}</td>
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
            <div class="table_area_row">
                <div class="items_title_area">
                    <img class="items_title_img" src="{{ asset('assets/frontend/images/icons/users.png') }}" width="36"
                        alt="img" />
                    <h5>TOURNAMENT</h5>
                    <p>Results</p>
                </div>
                <div class="table_area_box">
                    <table class="table_main_2" border="0" cellspacing="0" cellpadding="0" align="center"
                        style="width: 100%;">

                        <thead>
                            <tr>
                            <td>Player</td>
                            <td>Winner Y/N</td>
                            <td>Total Attempted Questions</td>
                            <td>Total Correct</td>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!empty($h_game_detail))
                        @foreach($h_game_detail as $val_result)
                            <tr>
                                <td>{{$val_result->player_name}}</td>
                                @if($val_result->game_status == 1)
                                <td>Y</td>
                                @else
                                <td>N</td>
                                @endif   
                                <td>{{$val_result->tl_attemped}}</td>
                                <td>{{$val_result->tl_correct}}</td>
                            </tr>
                        @endforeach    
                        @endif
                        </tbody>

                    </table>
                </div>
            </div>
            <!-- <div class="table_area_row">
                <div class="items_title_area">
                    <img class="items_title_img" src="{{ asset('assets/frontend/images/icons/users.png') }}" width="36"
                        alt="img" />
                    <h5 class="pt-5">CATEGORY DETAILS</h5>
                </div>
                <div class="table_area_scrool_main">
                    <div class="table_area_scrool custome_scrollbar_1">
                        <div class="table_area">
                            <table class="table_main table_main_3" border="0" cellspacing="0" cellpadding="0"
                                align="center" style="width: 100%;">

                                <thead>
                                    <tr>
                                        <td>Category</td>
                                        <td>Correct Y/N</td>
                                        <td>Win/Lost</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>History</td>
                                        <td>20%</td>
                                        <td>35%</td>
                                    </tr>
                                    <tr>
                                        <td>Sports</td>
                                        <td>10%</td>
                                        <td>10%</td>
                                    </tr>
                                    <tr>
                                        <td>Music</td>
                                        <td>15%</td>
                                        <td>15%</td>
                                    </tr>
                                    <tr>
                                        <td>History</td>
                                        <td>20%</td>
                                        <td>35%</td>
                                    </tr>
                                    <tr>
                                        <td>Sports</td>
                                        <td>10%</td>
                                        <td>10%</td>
                                    </tr>
                                    <tr>
                                        <td>Music</td>
                                        <td>15%</td>
                                        <td>15%</td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="play_btns_area">
                <a href="{{route('player-account')}}"><button type="button" class="play_btn">
                    Return to Player Account
                </button></a>
            </div>
        </div>
    </div>
</div>
@stop