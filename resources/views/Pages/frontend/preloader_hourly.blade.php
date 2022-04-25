@extends('Pages.frontend.web')
@section('content')
<div class="witget_body bg_1 d-flex it-center text-center">
    <div class="witget_content">
    <div class="logo_area">
        <img src="{{ asset('assets/frontend/images/logo.png') }}" width="242" alt="img"/>
    </div>
    <div class="title_1">
        <h3>Please Wait for Result....</h3>
        <p class="timer_txt">15 Seconds Remaining</p>
    </div>
    </div>
    <div class="loading_area">
    <img src="{{ asset('assets/frontend/images/loading.png') }}" width="23" alt="loading"/>
    </div>
</div>
<script>

    var timeleft = 15;
    var downloadTimer = setInterval(function(){
        if(timeleft < 0){
            clearInterval(downloadTimer);
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                type: 'POST',
                url:'hourly-result-page',
                data: {
                    '_token': token,
                },
                success: function(data,status) {
                    if(data.status==200){
                        window.location.href = "hourly-result";
                    }              
                }
            });
        } else {
            $('.timer_txt').text(timeleft+" Seconds remaining");
        }
        timeleft -= 1;
    }, 1000);
    // setTimeout(function(){
    //     var token = $("meta[name='csrf-token']").attr("content");
    //     $.ajax({
    //         type: 'POST',
    //         url:'hourly-result-page',
    //         data: {
    //             '_token': token,
    //         },
    //         success: function(data,status) {
    //             console.log(data);
    //             if(data.status==200){
    //                 window.location.href = "hourly-result";
    //             }              
    //         }
    //     });
		
	// }, 15000);
</script>
<script src="{{ asset('assets/admin/dist/js/session.js') }}"></script>
@stop