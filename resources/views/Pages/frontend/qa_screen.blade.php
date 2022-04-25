@extends('Pages.frontend.web')
@section('content')
<div class="witget_body bg_1 text-center">
    <div class="top_area">
    <div class="top_arrow top_toggle">
        <a class="nav_toggle">
        <img src="{{ asset('assets/frontend/images/icons/menu_icon.png') }}" width="22" alt="img"/>
        </a>
    </div>
    <h4 class="top_title">Q&A Tournament</h4>
    <div class="top_amount">
        <div class="top_amount_box">
        <img src="{{ asset('assets/frontend/images/icons/m.png') }}" alt="img"/>
        <span class="amount_txt">
            $1245
        </span>
        </div>
    </div>
    </div>
    @include('Pages.frontend.includes.navbar')
    <div class="down_body_area">
    <div class="down_body_box">
        <div class="timer_area">
        <img src="{{ asset('assets/frontend/images/icons/timer.png') }}" width="80" alt="img"/>
        <p class="timer_txt"></p>
        </div>
        <div class="question_area">
        <div class="question_txt">
            <p class="p_question_txt">10 Seconds remaining</p>
        </div>
        <div class="question_option">
            
        </div>
        </div>
    </div>
    </div>
</div>
<script>
    fetch_question();
    function fetch_question(){
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'POST',
            url:'get-question',
            data: {
                '_token': token
            },
            success: function(data,status) {
                if(data.status==true){
                    var timer = null;
                    var start = new Date;
                    $.session.set("start_time", start);
                    // var timer = setInterval(function() {
                    //     $('.timer_txt').text((new Date - start) / 1000 + " Seconds");
                    // }, 1000);
                    var timeleft = 10;
                    var downloadTimer = setInterval(function(){
                        if(timeleft < 0){
                            clearInterval(downloadTimer);
                           // window.location.href = "question-screen";
                           var token = $("meta[name='csrf-token']").attr("content");
                           var quesId = $('.qa_btn').attr('data-value');
                           $.ajax({
                                type: 'POST',
                                url:'auto-answer',
                                data: {
                                    '_token': token,question_id:quesId,play_time:0,game_type:'group',ques_ans:'noanswer'
                                },
                                success: function(data,status) {
                                    //console.log(data);
                                    window.location.href = "result-preloader";    
                                }
                            });
                        } else {
                            $('.timer_txt').text(timeleft+" Seconds remaining");
                        }
                        timeleft -= 1;
                    }, 1000);
                    var obj = data.data.answer_array;
                    var ques_id = data.data.question_id;
                    var result1 = $.parseJSON(JSON.stringify(shuffleObject(obj)));
                    var button_output ='';
                    $.each(result1, function(k, v) {
                        button_output += '<button type="button" onclick= "myFunction(\'' +k+ '\')"  class="qa_btn' + ' ' +k +'" data-value="'+ques_id+'">'+v+'</button>';                      
                    });
                    $('.p_question_txt').text(data.data.question);
                    $('.question_option').html(button_output);
                }            
            }
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

    function myFunction(k) {
        var answer_time = (new Date - new Date($.session.get("start_time")))/1000;
        if(k == 'correct'){
            var element = document.querySelector(".qa_btn" + '.' + k)
            element.classList.add("qa_btn_selected");
            var quesId = element.getAttribute('data-value');
            var ques_ans = 'correct';
        }else{
            var element = document.querySelector(".qa_btn" + '.' + k)
            element.classList.add("qa_btn_wrong");
            var quesId = element.getAttribute('data-value');
            var ques_ans = 'wrong';
        }
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'POST',
            url:'player-answer',
            data: {
                '_token': token,question_id:quesId,play_time:answer_time,game_type:'group',ques_ans:ques_ans
            },
            success: function(data,status) {
                //console.log(data);
                window.location.href = "result-preloader";          
            }
        });      
    }
</script>
<script src="{{ asset('assets/admin/dist/js/session.js') }}"></script>
@stop
