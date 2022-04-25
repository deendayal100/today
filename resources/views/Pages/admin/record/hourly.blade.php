@extends('layouts.admin')
@section('content')

<style>
.btn_submit:disabled {
    background: #d66821;
    border-color: #d66821;
    opacity: 1;
}
</style>
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h4 class="text-themecolor mb-0">Record of Play</h4>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <ol class="breadcrumb mb-0 p-0 bg-transparent fa-pull-right">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Record of Play</li>
            </ol>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="border-bottom title-part-padding d-flex justify-content-between">
                        <h4 class="card-title mb-0">Record of Play</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="">
                                <!-- Alert Append Box -->
                                <div class="result"></div>
                                <!-- <button style="margin-bottom: 10px;" type="button" class="btn btn-primary"
                                    data-toggle="modal" data-target="#recordPlay">
                                    Filter
                                </button> -->
                            </div>
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:100px;">S.No.</th>
                                        <th style="width:800px;">Name</th>
                                        <th style="width:1500px;">No of Question Attemped</th>
                                        <th style="width:500px;">Correct</th>
                                        <th style="width:200px;">Won/Lost</th>
                                        <th style="width:200px;">Won/Lost Amount</th>
                                        <th style="width:300px;">Date</th>
                                        <!-- <Th style="width:800px;">Average Time</th>
											<th><div style="width:50px;">Action</div></th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($group_record))
                                    @foreach ($group_record as $player)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ $player->player_name }}</td>
                                        <td>{{ $player->tl_attemped }}</td>
                                        <td>{{$player->tl_correct}}</td>
                                        @if($player->game_status == 1)
                                        <td>Won</td>
                                        @else
                                        <td>Lost</td>
                                        @endif
                                        <td>{{$player->prize_amount}}</td>
                                         <td>{{date('d-m-Y', strtotime($player->created_at))}}</td>
                                        <!-- <td>
												<a href="{{url('/game-view')}}/{{$player->id}}" class="btn btn-success btn-sm list_view infoU"  data-id='"{{ $player->id }}"' data-bs-whatever="@mdo">
													<i class="mdi mdi-eye"></i>
												</a>
											</td> -->
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <div class="modal fade modal_report" id="recordPlay" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content" id="searchPlan" action="{{route('serach-game-record')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Filters</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="Error" style="color:green; text-align:center;"></p>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Category</label>
                            <select class="form-control form-select" name="game_record_cat">
                                <option value="">Select category</option>
                                @if(!empty($cat))
								@foreach($cat as $val)
								<option value="{{$val->category}}">{{$val->category}}</option>
								@endforeach
								@endif
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Question Asked</label>
                            <select class="form-control form-select" name="game_record_question">
							   <option value="">Select Question</option>
								@if(!empty($question_asked))
								@foreach($question_asked as $val2)
								<option value="{{$val2->ques_id}}">{{$val2->question}}</option>
								@endforeach
								@endif
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12" >
                            <label>Won/Loss</label>
                            <select class="form-control form-select" name="game_won_loss">
								<option value="0">All</option>
								<option value="1">Won</option>
								<option value="2">Lost</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Date</label>
                            <input type="date" class="form-control" name="game_date" id="game_date" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnGameRecordFilter">Submit</button>
                </div>
            </form>
        </div>
    </div>
	<script>
		
	</script>
@stop