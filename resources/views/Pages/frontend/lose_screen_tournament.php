@extends('Pages.frontend.web')
@section('content')
<div class="witget_body bg_1 text-center">
    <div class="top_area">
    <div class="top_arrow top_toggle">
        <a class="nav_toggle">
        <img src="{{ asset('assets/frontend/images/icons/menu_icon.png') }}" width="22" alt="img"/>
        </a>
    </div>
    <h4 class="top_title"></h4>
    <div class="top_amount">
        <div class="top_amount_box">
        <img src="{{ asset('assets/frontend/images/icons/m.png') }}" alt="img"/>
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
            <img src="{{ asset('assets/frontend/images/user-face.png') }}" alt="img"/>
        </div>
        <div class="nav_user_info">
            <h5>Player Name</h5>
            <h4>$1245</h4>
        </div>
        </div>
        <div class="nav_list_area">
        <ul>
            <li>
            <a href="#"><span class="nav_list_icon"><img src="{{ asset('assets/frontend/images/icons/user.png') }}" width="22" alt="icon"/></span> Player Profile</a>
            </li>
            <li>
            <a href="#"><span class="nav_list_icon"><img src="{{ asset('assets/frontend/images/icons/user-icon-3.png') }}" width="19" alt="icon"/></span> Player Fund Management</a>
            </li>
            <li>
            <a href="#"><span class="nav_list_icon"><img src="{{ asset('assets/frontend/mages/icons/stats.png') }}i" width="14" alt="icon"/></span> Player Game History</a>
            </li>
            <li>
            <a href="#"><span class="nav_list_icon"><img src="{{ asset('assets/frontend/images/icons/i.png') }}" width="18" alt="icon"/></span> Terms and Policy</a>
            </li>
            <li>
            <a href="#"><span class="nav_list_icon"><img src="{{ asset('assets/frontend/images/icons/log-out.png') }}" width="14" alt="icon"/></span> Log Out</a>
            </li>
        </ul>
        </div>
    </div>
    <div class="nav_bg nav_toggle"></div>
    </div>
    <div class="down_body_area_long">
    <div class="down_body_long_box">
        <div class="top_icon_area">
        <img src="{{ asset('assets/frontend/images/icons/lose-money.png') }}" width="80" alt="img"/>
        <h5>You Lose!</h5>
        </div>
        <div class="cost_title">
        <h2>$350</h2>
        </div>
        <div class="table_area_scrool_main">
        <div class="table_area_scrool custome_scrollbar_1">
            <div class="table_area">
            <table class="table_main" border="0" cellspacing="0" cellpadding="0" align="center" style="width: 100%;">

                <thead>
                <tr>
                    <td>Player</td>
                    <td>Winner Y/N</td>
                    <td>Correct Y/N</td>
                    <td>Time (secs)</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Star Kiler</td>
                    <td>Y</td>
                    <td>Y</td>
                    <td>2.541</td>
                </tr>
                <tr>
                    <td>Yummy</td>
                    <td>Y</td>
                    <td>Y</td>
                    <td>2.541</td>
                </tr>
                <tr>
                    <td>Me</td>
                    <td>Y</td>
                    <td>Y</td>
                    <td>2.541</td>
                </tr>
                <tr>
                    <td>Bill</td>
                    <td>Y</td>
                    <td>Y</td>
                    <td>2.541</td>
                </tr>
                <tr>
                    <td>Star Kiler</td>
                    <td>Y</td>
                    <td>Y</td>
                    <td>2.541</td>
                </tr>
                <tr>
                    <td>Yummy</td>
                    <td>Y</td>
                    <td>Y</td>
                    <td>2.541</td>
                </tr>
                <tr>
                    <td>Me</td>
                    <td>Y</td>
                    <td>Y</td>
                    <td>2.541</td>
                </tr>
                <tr>
                    <td>Bill</td>
                    <td>Y</td>
                    <td>Y</td>
                    <td>2.541</td>
                </tr>
                </tbody>
            
            </table>
            </div>
        </div>
        </div>
        <div class="play_btns_area">
        <button type="button" class="play_btn">
            Play Again <img src="{{ asset('assets/frontend/images/icons/reload.png') }}" width="14" alt="img"/>
        </button>
        <div class="yes_no_btn">
            <button type="button" class="yes_btn">
            Yes
            </button>
            <button type="button" class="no_btn">
            No
            </button>
        </div>
        </div>
        <div class="play_bonus_btn_area">
        <button type="button" class="play_bonus_btn">
            Bonus Pot stands at $X
        </button>
        </div>
    </div>
    </div>
</div>
@stop