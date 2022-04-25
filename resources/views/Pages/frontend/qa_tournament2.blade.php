@extends('Pages.frontend.web')
@section('content')
<div class="witget_body bg_1 text-center">
    <div class="top_area">
        <div class="top_arrow top_toggle">
            <a class="nav_toggle">
                <img src="{{ asset('assets/frontend/images/icons/menu_icon.png') }}" width="22" alt="img" />
            </a>
        </div>
        <h4 class="top_title">Category Name</h4>
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
                <p class="timer_txt">00:26</p>
            </div>
            @if(!empty($data_array))
            @php $i=0; @endphp
            @foreach($data_array as $val)
            
            <div class="question_area">
                <div class="question_txt">
                    <p class="p_question_txt">
                        {{$val->questionarr->question}}          
                    </p>
                </div>
                
                <div class="question_option">
                @php 
                    $keys = array_keys((array)$val->answerarr);shuffle($keys);
                    $s_array = array_merge(array_flip($keys), (array)$val->answerarr); @endphp 
                 @foreach($s_array as $k => $val2)
                 @php $j = $i.$k; @endphp 
                 <button type="button" onclick= "myFunction('{{$j}}')" data-value="{{$val->questionarr->id}}" class="qa_btn {{$i}}{{$k}}">{{$val2}}</button>
                @endforeach
                </div>
                <div class="question_progress">
                    <h5>Question Progress</h5>
                    <div class="question_progress_main">
                        <div class="question_progress_bar" id="question_progress_bar" style="width: 0%;"></div>
                    </div>
                </div>
                <div class="qa_submit">
                    <button type="button" class="btn yellow_btn mb-0">
                        Next Question
                    </button>
                </div>
            </div>
           @php  $i++; @endphp
            @endforeach
            @endif
        </div>
    </div>
</div>
<script>
var slideIndex = 0;
//showSlides();
var slides,timer;
function showSlides() {
    var i;
    slides = document.getElementsByClassName("question_area");
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex> slides.length) {slideIndex = 1} 
    slides[slideIndex-1].style.display = "block";
    //put the timeout in the timer variable
    timer = setTimeout(showSlides, 10000); // Change image every 8 seconds
}

    // var timeleft = 0;
    // var questionArr = [];
    // fetch_question();
    // function fetch_question(){
    //     var token = $("meta[name='csrf-token']").attr("content");
    //     $.ajax({
    //         type: 'POST',
    //         url:'tournament-question',
    //         data: {
    //             '_token': token
    //         },
    //         success: function(data,status) {
    //             console.log(data);
    //             var questionArr = data.data;
    //             showQuestions(questionArr);
    //         }
    //     });
    // }

    // function showQuestions(dataArr) {

    //     timeleft = dataArr.length;
    //     var downloadTimer = setInterval(function(){
    //         if(timeleft <= 0){
    //             clearInterval(downloadTimer);
    //             // window.location.href = "question-screen";
    //             console.log('finish');
    //         } else {
    //             var obj = dataArr[timeleft-1].answerarr;
    //             var ques_id = dataArr[timeleft-1].questionarr.id;
    //             var result1 = $.parseJSON(JSON.stringify(shuffleObject(obj)));
    //             var button_output ='';
    //             $.each(result1, function(k, v) {
    //                 button_output += '<button type="button" onclick= "myFunction(\'' +k+ '\')"  class="qa_btn' + ' ' +k +'" data-value="'+ques_id+'">'+v+'</button>';                      
    //             });
    //             $('.p_question_txt').text(dataArr[timeleft-1].questionarr.question);
    //             $('.question_option').html(button_output);               
    //             var pp = (110 - timeleft*10)+'%';
    //             document.getElementById("question_progress_bar").style.width = pp;
    //         }
    //         timeleft -= 1;
    //     }, 10000); 
               
        
    // }

    // function shuffleObject(obj){
    //     let newObj = {};
    //     var keys = Object.keys(obj);
    //     keys.sort(function(a,b){return Math.random()- 0.5;});
    //     keys.forEach(function(k) {
    //         newObj[k] = obj[k];
    //     });
    //     return newObj;
    // } 
    
    // $('.qa_submit').click(function(){
        
    // });

    function myFunction(k) {
        console.log(k);
       // var answer_time = (new Date - new Date($.session.get("start_time")))/1000;
        if(k == 'correct'){
            var element = document.querySelector(".qa_btn")
            element.classList.add("qa_btn_selected");
            var quesId = element.getAttribute('data-value');
            var ques_ans = 'correct';
        }else{
            var element = document.querySelector(".qa_btn")
            element.classList.add("qa_btn_wrong");
            var quesId = element.getAttribute('data-value');
            var ques_ans = 'wrong';
        }
        // var token = $("meta[name='csrf-token']").attr("content");
        // $.ajax({
        //     type: 'POST',
        //     url:'player-answer',
        //     data: {
        //         '_token': token,question_id:quesId,play_time:answer_time,game_type:'group',ques_ans:ques_ans
        //     },
        //     success: function(data,status) {
        //         window.location.href = "result-preloader";          
        //     }
        // });      
    }   

</script>
@stop