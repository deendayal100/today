@extends('Pages.frontend.web')
@section('content')
<div class="witget_body bg_1 text-center">
    <div class="top_area">
        <div class="top_arrow top_toggle">
            <a class="nav_toggle">
                <img src="{{ asset('assets/frontend/images/icons/menu_icon.png') }}" width="22" alt="img" />
            </a>
        </div>
        <h4 class="top_title">Player Fund Management</h4>
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
                <img src="{{ asset('assets/frontend/images/icons/money.png') }}" width="80" alt="img" />
            </div>
            <div class="top_amount_area">
                <h5>Total Amount</h5>
                <h2>$1245.25</h2>
            </div>
            <div class="hr_2"></div>
            <div class="money_withdrawl_area">
                <h3>
                    How much you want to
                    <br />
                    withdrawal amount
                </h3>
                <form>
                    <input type="text" class="input-item-2" placeholder="Enter Amount" />
                    <button type="button" class="withdrawl_btn">
                        Withdrawal Amount <img src="{{ asset('assets/frontend/images/icons/arrow-right-round.svg') }}"
                            width="22" alt="img">
                    </button>
                </form>
            </div>
            <div class="money_deposit_area">
                <h3>Deposit Money</h3>
                <ul>
                    <li>
                        <a href="#"><img src="{{ asset('assets/frontend/images/paypal.svg') }}" width="130"
                                alt="img" /></a>
                    </li>
                    <li>
                        <a href="#"><img src="{{ asset('assets/frontend/images/creadit-card.svg') }}" width="130"
                                alt="img" /></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@stop