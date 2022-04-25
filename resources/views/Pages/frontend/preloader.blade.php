@extends('Pages.frontend.web')
@section('content')
<div class="witget_body bg_1 d-flex it-center text-center">
    <div class="witget_content">
    <div class="logo_area">
        <img src="{{ asset('assets/frontend/images/logo.png') }}" width="242" alt="img"/>
    </div>
    <div class="title_1">
        <h3> Wait for Result</h3>
    </div>
    </div>
    <div class="loading_area">
    <img src="{{ asset('assets/frontend/images/loading.png') }}" width="23" alt="loading"/>
    </div>
</div>
<script>
    setTimeout(function(){
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            type: 'POST',
            url:'auto-answer',
            data: {
                '_token': token,
            },
            success: function(data,status) {
               // console.log(data);
                if(data.status==200){
                    window.location.href = "result-page";
                }              
            }
        });
		//window.location.href ="result-page";
	}, 15000);
</script>
<script src="{{ asset('assets/admin/dist/js/session.js') }}"></script>
@stop