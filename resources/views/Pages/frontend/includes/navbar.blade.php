<div class="nav_area">
    <div class="nav_area_box">
        <div class="player_account_top">
            @if(Session::has('player_id'))
            @if(Session::has('profile_image') && Session::get('profile_image') != null)
            <div class="name_image" style="background: none;"><img src="{{Session::get('profile_image')}}" alt="img"
                    id="img_preview1" /></div>
            @else <div class="name_image">M</div>  @endif
            <div class="player_name">
                <h5>{{Session::get('player_name')}}</h5>
            </div>
            <div class="player_amount">
                <h5>${{Session::get('wallet_amnt')}}</h5>
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
        <div class="nav_list_area">
            <ul>
                <li>
                    <a href="{{route('player-profile')}}"><span class="nav_list_icon"><img
                                src="{{ asset('assets/frontend/images/icons/user.png') }}" width="22"
                                alt="icon" /></span> Player Profile</a>
                </li>
                <li>
                    <a href="{{route('player-fund-management')}}"><span class="nav_list_icon"><img
                                src="{{ asset('assets/frontend/images/icons/user-icon-3.png') }}" width="19"
                                alt="icon" /></span> Player Fund Management</a>
                </li>
                <li>
                    <a href="{{route('player-game-history')}}"><span class="nav_list_icon"><img
                                src="{{ asset('assets/frontend/images/icons/stats.png') }}" width="14"
                                alt="icon" /></span> Player Game History</a>
                </li>
                <li>
                    <a href="#"><span class="nav_list_icon"><img src="{{ asset('assets/frontend/images/icons/i.png') }}"
                                width="18" alt="icon" /></span> Terms and Policy</a>
                </li>
                <li>
                    <a href="{{route('player-logout')}}"><span class="nav_list_icon"><img
                                src="{{ asset('assets/frontend/images/icons/log-out.png') }}" width="14"
                                alt="icon" /></span> Log Out</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="nav_bg nav_toggle"></div>
</div>