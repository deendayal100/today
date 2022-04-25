@extends('Pages.frontend.web')
@section('content')
<!-- Trigger/Open The Modal -->
<button id="myBtn" class="modal_btn_1">Click Me</button>

<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
    <div class="modal-body">
        <div class="moda1_2">
        <div class="modal-header">
            <span class="close"><img src="{{ asset('assets/frontend/images/icons/close.svg') }}" width="17" alt="img"/></span>
        </div>
        
        <div class="table_area_box">
            <table class="table_main_2" border="0" cellspacing="0" cellpadding="0" align="center" style="width: 100%;">

            <thead>
                <tr>
                <td>Player</td>
                <td>Winner Y/N</td>
                <td>Correct Y/N</td>
                <td>Time (secs)</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>Star Kiler</td>
                <td>Y</td>
                <td>Y</td>
                <td>2.541</td>
                </tr>
                <tr>
                <td>Yummy</td>
                <td>Y</td>
                <td>Y</td>
                <td>2.541</td>
                </tr>
                <tr>
                <td>Me</td>
                <td>Y</td>
                <td>Y</td>
                <td>2.541</td>
                </tr>
                <tr>
                <td>Bill</td>
                <td>Y</td>
                <td>Y</td>
                <td>2.541</td>
                </tr>
            </tbody>
        
            </table>
        </div>
        </div>
    </div>
    </div>
</div>
@stop