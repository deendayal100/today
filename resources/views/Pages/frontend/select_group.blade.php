@extends('Pages.frontend.web')
@section('content')
<div class="witget_body bg_1 text-center">
    <div class="top_area">
        <div class="top_arrow top_toggle">
            <a class="nav_toggle">
                <img src="{{ asset('assets/frontend/images/icons/menu_icon.png') }}" width="22" alt="img" />
            </a>
        </div>
        <h4 class="top_title">Select Group</h4>
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
    <div class="down_body_area">
        <div class="down_body_box">
            <div class="amount_area">
                <div class="top_text_1">
                    <p>
                        Select your group by name amount and number of players
                    </p>
                </div>
                <div class="amount_area_row">
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
                            <!-- <div class="select_amount">
                        <label class="amount_item">
                            <input type="radio" name="radio" data-value="" value="" />
                            <span class="checkmark"> $10</span>
                        </label>
                        <label class="amount_item">
                            <input type="radio" checked="checked" name="radio" data-value="" value="">
                            <span class="checkmark"> $25</span>
                        </label>
                        <label class="amount_item">
                            <input type="radio" name="radio" data-value="" value="">
                            <span class="checkmark"> $50</span>
                        </label>
                    </div> -->
                </div>
                <div class="amount_area_hr"></div>
                <div class="amount_area_row">
                    <div class="down_body_title">
                        <h3>NUMBER OF PLAYERS</h3>
                    </div>
                    <div class="select_amount">
                        @if(!empty($number_player))
                        @foreach($number_player as $val1)
                        <label class="amount_item">
                            <input type="radio" class="player_no_select" @if ($val1->id == 1) checked="checked" @endif name="player_no_select" id="player_no_select" data-value="{{$val1->id}}"
                                value="{{$val1->player_number}}">
                            <span class="checkmark">{{$val1->player_number}}</span>
                        </label>
                        @endforeach
                        @endif
                                <!-- <label class="amount_item">
                            <input type="radio" checked="checked" name="radio-2" data-value="" value="">
                            <span class="checkmark">5</span>
                        </label>
                        <label class="amount_item">
                            <input type="radio" name="radio-2" data-value="" value="">
                            <span class="checkmark">10</span>
                        </label> -->
                    </div>
                </div>
                <div class="current_group">
                    <button type="button">
                        20 currently active in that Group
                    </button>
                </div>
            </div>
            <div class="down_btn_area">
                <a href="javascript:void(0)"><button type="button" class="btn yellow_btn group_submit">
                        Go Play <img src="{{ asset('assets/frontend/images/icons/arrow-right-round.svg') }}" width="23"
                            alt="img" />
                    </button></a>
                <a href="{{route('player-account')}}"><button type="button" class="btn red_btn mb-0">
                        Cancel
                    </button></a>
            </div>
        </div>
    </div>
</div>

<script>
    $(".ante_amount_select").click(function()
    {
        var checked = $(this).attr('checked');
        var name = $(this).attr('name');
        if (checked == 'checked')
        {
            $(this).removeAttr('checked');
            $(this).attr('checked', false);
        }
        else
        {
            $("input[name="+name+"]:radio").attr('checked', false);
            $(this).attr('checked', 'checked');
        }
        active_player();
    });

    $(".player_no_select").click(function()
    {
        var checked = $(this).attr('checked');
        var name = $(this).attr('name');
        if (checked == 'checked')
        {
            $(this).removeAttr('checked');
            $(this).attr('checked', false);
        }
        else
        {
            $("input[name="+name+"]:radio").attr('checked', false);
            $(this).attr('checked', 'checked');
        }
        active_player();
    });
    
    active_player();
    function active_player(){
        var token = $("meta[name='csrf-token']").attr("content");
        var anteAmountId = $('input[name=ante_amount_select]:checked').attr("data-value");
        var playerNoId = $('input[name=player_no_select]:checked').attr("data-value");
        $.ajax({
            type: 'POST',
            url:'active-players',
            data: {
                '_token': token,anteAmountId:anteAmountId,playerNoId:playerNoId
            },
            success: function(data,status) {
                var obj = JSON.parse(data);
                if(status == 'success'){
                    if(obj.status==true){
                        if(obj.active_players==0){
                            $(".current_group").html('<button type="button">'+obj.active_players+'&nbsp;'+'currently active in that Group</button>');
                        }else{
                            $(".current_group").html('<button type="button">'+obj.active_players+'&nbsp;'+'currently active in that Group</button>');
                        }
                    }
                }
            }
        });
    }

    $(".group_submit").click(function()
    {
        var token = $("meta[name='csrf-token']").attr("content");
        var anteAmountId = $('input[name=ante_amount_select]:checked').attr("data-value");
        var playerNoId = $('input[name=player_no_select]:checked').attr("data-value");
        $.ajax({
            type: 'POST',
            url:'countdown-group',
            data: {
                '_token': token,anteAmountId:anteAmountId,playerNoId:playerNoId
            },
            success: function(data,status) {
                console.log(data);
                if(data.status==200){
                    window.location.href = "group-countdown";
                }
               
            }
        });
    });

    
</script>
@stop