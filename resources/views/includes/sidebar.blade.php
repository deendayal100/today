<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile position-relative" style="background: url({{ asset('assets/admin/images/background/user-info.jpg') }}) no-repeat;">
            <!-- User profile image -->
            <div class="profile-img">

                @if(Session::has('image'))
                    <img src="{{\App\Models\User::where('id',Session::get('id'))->pluck('image')[0]}}" alt="user" class="w-100" />
                @else
                    <img src="{{ asset('assets/admin/images/users/profile.png') }}" alt="user" class="w-100" />
                @endif
            </div>

            <!-- User profile text-->
            <div class="profile-text pt-1 dropdown">
                <a href="#" class="dropdown-toggle u-dropdown w-100 text-white d-block position-relative" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">{{\App\Models\User::where('id',Session::get('id'))->pluck('name')[0]}}</a>
                <div class="dropdown-menu animated flipInY" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="{{ url('/my_profile') }}"><i data-feather="user" class="feather-sm text-info me-1 ms-1"></i> My Profile</a>
                    <div class="dropdown-divider"></div>
                    <a style="display:none" class="dropdown-item" href="{{ route('signout') }}"><i data-feather="log-out" class="feather-sm text-danger me-1 ms-1"></i> Logout</a>
                    <div class="dropdown-divider"></div>
                    <div class="pl-4 p-2"><a href="{{ route('signout') }}" class="btn d-block w-100 btn-info rounded-pill">Logout</a></div>
                </div>
            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @if (Request::segment(1)=='dashboard') active @endif" href="{{ url('/dashboard') }}"  aria-expanded="false">
                        <i class="mdi mdi-gauge"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item" style="">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @if (Request::segment(1)=='Funds-view') active  @elseif (Request::segment(1)=='funds_list')  aclass   @endif"  href="{{ url('/player_list') }}" aria-expanded="false">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">Players Management </span>
                    </a>
                </li>
                <!-- <li class="sidebar-item" style="">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @if (Request::segment(1)=='Funds-view') active  @elseif (Request::segment(1)=='funds_list')  aclass   @endif" target="Blank" href="{{ url('/funds_list') }}" aria-expanded="false">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">Funds Management </span>
                    </a>
                </li> -->

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">Funds Management</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ url('/funds_deposit_list') }}" class="sidebar-link">
                            <i class="mdi mdi-checkbox-blank-circle"></i>
                                <span class="hide-menu">Deposit</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('/funds_widrawl_list') }}" class="sidebar-link">
                            <i class="mdi mdi-checkbox-blank-circle"></i>
                                <span class="hide-menu">Withdrawal</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- <li class="sidebar-item" style="">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @if (Request::segment(1)=='user-view') active  @elseif (Request::segment(1)=='user_list')  aclass   @endif" href="{{ url('/player-game-list') }}" aria-expanded="false">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">Record of Play</span>
                    </a>
                </li> -->

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">Record of Play</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ url('/group-list') }}" class="sidebar-link">
                            <i class="mdi mdi-checkbox-blank-circle"></i>
                                <span class="hide-menu">Group Play</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('/tournament-list') }}" class="sidebar-link">
                            <i class="mdi mdi-checkbox-blank-circle"></i>
                                <span class="hide-menu">Hourly Tournament</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item" style="">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @if (Request::segment(1)=='user-view') active  @elseif (Request::segment(1)=='user_list')  aclass   @endif" href="{{ url('/player-stastics') }}" aria-expanded="false">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">Statistics</span>
                    </a>
                </li>
                <li class="sidebar-item" style="">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link @if (Request::segment(1)=='user-view') active  @elseif (Request::segment(1)=='user_list')  aclass   @endif" href="{{ url('/player-questions') }}" aria-expanded="false">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">Question Upload</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">Group Play Management</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ url('/group-ante-amount') }}" class="sidebar-link">
                            <i class="mdi mdi-checkbox-blank-circle"></i>
                                <span class="hide-menu">Ante Amount</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ url('/group-player-no') }}" class="sidebar-link">
                            <i class="mdi mdi-checkbox-blank-circle"></i>
                                <span class="hide-menu">No. of Players</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="mdi mdi-account"></i>
                        <span class="hide-menu">Hourly Tournament Management</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ url('/hourly-ante-amount') }}" class="sidebar-link">
                            <i class="mdi mdi-checkbox-blank-circle"></i>
                                <span class="hide-menu">Ante Amount</span>
                            </a>
                        </li>
                    </ul>
                </li>                      
                <!-- ========================================================================== -->
               
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <div class="sidebar-footer">
        <!-- item--><!--
        <a href="" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Settings"><i class="ti-settings"></i></a>
        <a href="" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Email"><i class="mdi mdi-gmail"></i></a>-->
        <a href="{{ url('/signout') }}" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Logout"><i class="mdi mdi-power"></i></a>
    </div>
    <!-- End Bottom points-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<!-- ============================================================== -->

<style>
.sidebar-nav ul .sidebar-item .sidebar-link.active {
    color: #607d8b !important;
    opacity: 1;
    font-weight: normal;
}
.sidebar-nav ul .sidebar-item .sidebar-link.active.aclass {
    color: #000 !important;
    font-weight: 500 !important;
}
</style>