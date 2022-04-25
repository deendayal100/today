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
            <h4 class="text-themecolor mb-0">Player History</h4>
		</div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <ol class="breadcrumb mb-0 p-0 bg-transparent fa-pull-right">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Player History</li>
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
					    <h4 class="card-title mb-0">Player History</h4> 
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<div class="">
                                <!-- Alert Append Box -->
                                <div class="result"></div>
                            </div>
							<table id="zero_config" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th style="width:100px;">S.No.</th>
										<th style="width:800px;">Category</th>
										<th style="width:500px;">Amount</th>
										<th style="width:200px;">Result</th>
										<th style="width:200px;">Time</th>
									</tr>
								</thead>
								<tbody>
								@if(!empty($history))
								@foreach ($history as $val)
									<tr>
										<td>{{$loop->iteration}}</td>
										@if(!empty($val->category))
										<td >{{$val->category['category']}}</td>
										@else{<td ></td>}
										@endif
										@if(!empty($val->fund))
										<td>{{$val->fund['amount']}}</td>
										@else{<td ></td>}
										@endif
										@if($val->game_status == 1 )	
										<td>Win</td>
										@elseif($val->game_status == 2)
										<td>Loss</td>
										@endif
										<td>{{$val->play_time}}</td>
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

@stop