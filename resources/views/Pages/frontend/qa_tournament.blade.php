@extends('Pages.frontend.web')
@section('content')
<div class="witget_body bg_1 text-center">
    <div class="top_area">
        <div class="top_arrow top_toggle">
            <a class="nav_toggle">
                <img src="{{ asset('assets/frontend/images/icons/menu_icon.png') }}" width="22" alt="img" />
            </a>
        </div>
        @if(!empty($data_array))
        <h4 class="top_title">{{$data_array->category}}</h4>
        @else
        <h4 class="top_title">Category Name</h4>
        @endif
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
            <div class="timer_area">
                <img src="{{ asset('assets/frontend/images/icons/timer.png') }}" width="80" alt="img" />
                <!-- <p class="timer_txt">10 Seconds remaining</p> -->
                <p class="timer_txt">
                @if(!empty($data_array)) 
                    @php
                    $td = strtotime(date('h:i A'))-strtotime($data_array->end_time);
                    
                    if($td < 0){
                        $timediff = abs($td);
                        $minutes = $td/60;
                        $sec = $td%60;
                        echo   abs($minutes).":00 Minutes Remaining";
                    }else{
                        $timediff = 0;
                        $minutes = 00;
                        $sec = 00;
                        echo   abs($minutes).":00 Minutes Remaining";
                    }
                    @endphp
                @endif
                </p>
            </div>
            @if(!empty($data_array))
            <div class="question_area">
                <div class="question_txt">
                    <p class="p_question_txt">
                        {{$data_array->question}}          
                    </p>
                </div>
                <div class="question_option">
                @php 
                    $keys = array_keys((array)$data_array->ansArr);shuffle($keys);
                    $s_array = array_merge(array_flip($keys), (array)$data_array->ansArr); @endphp 
                 @foreach($s_array as $k => $val2)
                 <button type="button" data-index="{{$k}}" data-value="{{$data_array->id}}" class="qa_btn">{{$val2}}</button>
                @endforeach
                </div>
                <!-- <div class="question_progress">
                    <h5>Question Progress</h5>
                    <div class="question_progress_main">
                        <div class="question_progress_bar" id="question_progress_bar" style="width: 0%;"></div>
                    </div>
                </div> -->
                <div class="qa_submit">
                    <!-- <button type="button" onclick="plusSlides(1)" class="btn yellow_btn mb-0">
                        Next Question
                    </button> -->
                    <a href="{{url('qa-tournament')}}"><button type="button"  class="btn yellow_btn mb-0">
                        Next Question
                    </button></a>
                    <a href="{{route('player-account')}}"><button type="button"  class="btn red_btn mb-0 mt-3">
                        Cancel
                    </button></a>
                </div>
            </div>
           
            @endif
        </div>
    </div>
</div>
<script src="{{ asset('assets/admin/dist/js/session.js') }}"></script>
<script>
    // var slideIndex = 0;
    // showSlides();
    // var slides,timer,downloadTimer;
    // function showSlides() {
    //     var start = new Date;
    //     $.session.set("start_time", start);
    //     $('.timer_txt').text(10+" Seconds remaining");
    //     clearInterval(downloadTimer);
    //     var timeleft =9;
    //     var i;
    //     slides = document.getElementsByClassName("question_area");
    //     for (i = 0; i < slides.length; i++) {
    //     slides[i].style.display = "none";  
    //     }
    //     slideIndex++;
    //     if (slideIndex> slides.length) {slideIndex = 1} 
    //     slides[slideIndex-1].style.display = "block";
    //     timer = setTimeout(showSlides, 10000);
    //    if(slideIndex == 10){
    //        clearTimeout(timer);
    //    }
    //    clearInterval(downloadTimer);
    //       downloadTimer = setInterval(function(){
    //         if(timeleft <= 0){
    //             clearInterval(downloadTimer);
    //         } else {
    //             $('.timer_txt').text(timeleft+" Seconds remaining");
    //         }
    //         timeleft -= 1;
    //     }, 1000); 
    // }

    // function plusSlides(position) {
    //     var start = new Date;
    //     $.session.set("start_time", start);
    //     $('.timer_txt').text(10+" Seconds remaining");
    //     clearInterval(downloadTimer);
    //     clearTimeout(timer);
    //     var timeleft =9;
    //     slideIndex +=position;
    //     if (slideIndex > slides.length) {slideIndex = 10}
    //     for (i = 0; i < slides.length; i++) {
    //         slides[i].style.display = "none";  
    //     }
    //     slides[slideIndex-1].style.display = "block";
    //     timer = setTimeout(showSlides, 10000);
    //    if(slideIndex == 10){
    //        clearTimeout(timer);
    //    }
    //     downloadTimer = setInterval(function(){
    //         if(timeleft <= 0){
    //             clearInterval(downloadTimer);
    //         } else {
    //             $('.timer_txt').text(timeleft+" Seconds remaining");
    //         }
    //         timeleft -= 1;
    //     }, 1000);        
    // }

    const nodeList = document.querySelectorAll(".qa_btn");
    for (let i = 0; i < nodeList.length; i++) {
        nodeList[i].addEventListener('click', function(event) {
            // event.preventDefault();
            var answer_time = (new Date - new Date($.session.get("start_time")))/1000;
            var k = nodeList[i].getAttribute('data-index');
            if(k == 'correct'){
                for(let j = 0; j < nodeList.length; j++){
                    nodeList[j].disabled = true;
                }
                nodeList[i].classList.add("qa_btn_selected");
                var quesId = nodeList[i].getAttribute('data-value');
                var ques_ans = 'correct';
                
            }else{
                for(let j = 0; j < nodeList.length; j++){
                    nodeList[j].disabled = true;
                }
                nodeList[i].classList.add("qa_btn_wrong");
                var quesId = nodeList[i].getAttribute('data-value');
                var ques_ans = 'wrong';
                
            }
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                type: 'POST',
                url:'player-hourly-answer',
                data: {
                    '_token': token,question_id:quesId,play_time:answer_time,game_type:'hourly',ques_ans:ques_ans
                },
                success: function(data,status) {
                    window.location.href = "qa-tournament";
                    // var obj = data.data.ansArr;
                    // var ques_id = data.data.id;
                    // var result1 = $.parseJSON(JSON.stringify(shuffleObject(obj)));
                    // var button_output ='';
                    // $.each(result1, function(k, v) {
                    //     button_output += '<button type="button" data-index="'+k+'" data-value="'+ques_id+'" class="qa_btn" >'+v+'</button>';                      
                    // });
                    // $('.p_question_txt').text(data.data.question);
                    // $('.question_option').html(button_output);             
                }
            });             
        });
    } 
    
    function shuffleObject(obj){
        let newObj = {};
        var keys = Object.keys(obj);
        keys.sort(function(a,b){return Math.random()- 0.5;});
        keys.forEach(function(k) {
            newObj[k] = obj[k];
        });
        return newObj;
    }

    window.onload = function () {
        var timeleft = 1;
        var downloadTimer = setInterval(function(){
            if(timeleft < 0){
                clearInterval(downloadTimer);
                window.location.href = "hourly-result-preloader";
            } else {
                minutes = parseInt(timeleft / 60, 10);
                seconds = parseInt(timeleft % 60, 10);
                if(seconds == 0){
                    seconds ="00";
                }
                $('.timer_txt').text(minutes + ":" + seconds + " Minutes Remaining");
            }
            timeleft -= 1;
        }, 1000);
    };

</script>

@stop