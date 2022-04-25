@extends('Pages.frontend.web')
@section('content')
<div class="witget_body bg_1 text-center">
    <div class="top_area">
        <div class="top_arrow top_toggle">
            <a class="nav_toggle">
                <img src="{{ asset('assets/frontend/images/icons/menu_icon.png') }}" width="22" alt="img" />
            </a>
        </div>
        <h4 class="top_title">Tournament Ante</h4>
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
    <div class="down_body_area">
        <div class="down_body_box">
            <div class="amount_area">
                <div class="down_body_title">
                    <h3>ANTE AMOUNT</h3>
                </div>
                <div class="select_amount">
                @if(!empty($ante_amount))
                @foreach($ante_amount as $val)
                <label class="amount_item">
                    <input type="radio" class="ante_amount_select" id="ante_amount_select" @if ($val->id == 1) checked="checked" @endif name="ante_amount_select" data-value="{{$val->id}}"
                        value="{{$val->ante_amount}}">
                    <span class="checkmark"> ${{$val->ante_amount}}</span>
                </label>
                @endforeach
                @endif
                </div>
            </div>
            <div class="down_btn_area">
                <a href="javascript:void(0)"><button type="button" class="btn yellow_btn play_submit">
                        Go Play <img src="{{ asset('assets/frontend/images/icons/arrow-right-round.svg') }}" width="23"
                            alt="img" />
                    </button></a>
                <a href="{{route('player-account')}}"><button type="button" class="btn red_btn">
                        Cancel
                    </button></a>
            </div>

        </div>
    </div>
</div>

<script>
    $(".play_submit").click(function()
    {
        var token = $("meta[name='csrf-token']").attr("content");
        var anteAmountId = $('input[name=ante_amount_select]:checked').attr("data-value");
        $.ajax({
            type: 'POST',
            url:'group-hourly',
            data: {
                '_token': token,anteAmountId:anteAmountId
            },
            success: function(data,status) {
                console.log(data);
                if(data.status==200 || data.status==202){
                    window.location.href = "countdown-tournament";
                }
            }
        });
    });
</script>
@stop