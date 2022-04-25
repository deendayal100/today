@extends('Pages.frontend.web')
@section('content')
<div class="witget_body bg_1 text-center">
    <div class="witget_content">
        <div class="logo_area">
        <img src="{{ asset('assets/frontend/images/logo.png') }}" width="139" alt="img"/>
        </div>
        <div class="title_1">
        <h4>It Ain't Luck</h4>
        </div>
    </div>
    <div class="home_btns_area">
        <div class="home_btns">
        <a href="{{route('signin')}}"><button type="button" class="btn yellow_btn">
            Sign in <img src="{{ asset('assets/frontend/images/icons/arrow-right.png') }}" width="22" alt="img"/>
        </button></a>
        <a href="{{route('signup')}}"><button type="button" class="btn blue_btn">
            Sign up <img src="{{ asset('assets/frontend/images/icons/add.png') }}" width="22" alt="img"/>
        </button></a>
        <button type="button" class="btn red_btn">
            Demo <img src="{{ asset('assets/frontend/images/icons/video.png') }}" width="22" alt="img"/>
        </button>
        </div>
    </div>
</div>
@stop
