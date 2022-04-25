@extends('Pages.frontend.web')
@section('content')
<!-- Trigger/Open The Modal -->
<button id="myBtn" class="modal_btn_1">Click Me</button>

<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
    <span class="close" style="display: none;">&times;</span>
    <div class="modal-body">
        <div class="moda1_1">
        <div class="winer_modal_content">
            <img src="{{ asset('assets/frontend/images/icons/badge.png') }}" width="80" alt="img"/>
            <p>
            You’re currently in First Place!
            <br/>
            Winner will be announced at XX:00 EST!
            </p>
        </div>
        </div>
    </div>
    </div>
</div>
@stop