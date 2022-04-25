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
            <div class="question_area">
                <div class="question_txt">
                    <p class="p_question_txt">
                    </p>
                </div>
                <div class="question_option">
                   
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
        </div>
    </div>
</div>
<script>
    var timeleft = 0;
    var dataArr = [];
    fetch_question();
    function fetch_question(){
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'POST',
            url:'tournament-question',
            data: {
                '_token': token
            },
            success: function(data,status) {
                console.log(data);
                var questionArr = data.data;
                showQuestions(questionArr);
            }
        });
    }

    function showQuestions(dataArr) {
        timeleft = dataArr.length;
        var downloadTimer = setInterval(function(){
            if(timeleft <= 0){
                clearInterval(downloadTimer);
                // window.location.href = "question-screen";
                console.log('finish');
            } else {
                var obj = dataArr[timeleft-1].answerarr;
                var ques_id = dataArr[timeleft-1].questionarr.id;
                var result1 = $.parseJSON(JSON.stringify(shuffleObject(obj)));
                var button_output ='';
                $.each(result1, function(k, v) {
                    button_output += '<button type="button" onclick= "myFunction(\'' +k+ '\')"  class="qa_btn' + ' ' +k +'" data-value="'+ques_id+'">'+v+'</button>';                      
                });
                $('.p_question_txt').text(dataArr[timeleft-1].questionarr.question);
                $('.question_option').html(button_output);               
                var pp = (110 - timeleft*10)+'%';
                document.getElementById("question_progress_bar").style.width = pp;
            }
            timeleft -= 1;
        }, 10000); 
               
        
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
    
    $('.qa_submit').click(function(){
        timeleft = timeleft+1;
        
    });

   

</script>
@stop