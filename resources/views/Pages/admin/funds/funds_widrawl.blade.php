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
            <h4 class="text-themecolor mb-0">Deposit Funds List</h4>
		</div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <ol class="breadcrumb mb-0 p-0 bg-transparent fa-pull-right">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Deposit Funds List</li>
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
					    <h4 class="card-title mb-0">Deposit Funds List</h4> 
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
									<th style=""><input type="checkbox" id="user_master"></th>
										<th style="width:100px;">Id.</th>
										<th style="width:800px;">Name</th>
										<th style="width:500px;">Amount</th>
										<th style="width:200px;">Payment Method</th>
										<th style="width:200px;">Payment Status</th>
										<Th style="width:800px;">Date</th>
										<th style="width:200px;">Widrawl Request Id</th>
										<th><div style="width:110px;"> Action</div></th>
									</tr>
								</thead>
								<tbody>
								@if(!empty($funds))
								@foreach ($funds as $fund)
									<tr>
									<td style=""><input type="checkbox" class="sub_chk" data-id="{{$fund->id}}"></td>
										<td>{{$loop->iteration}}</td>
										@if(!empty($fund->user))
										<td >{{ $fund->user['name'] }}</td>
										@else
										<td ></td>
										@endif
										<td>{{ $fund->amount }}</td>
										<td>{{ $fund->method }}</td>
										<td>{{ $fund->payment_status }}</td>
										<td>{{ $fund->transaction_date }}</td>
										<td>{{ $fund->widrawl_request_id }}</td>
										@if($fund->widrawl_request_status == 1)
										<td>Accepted</td>
										@elseif($fund->widrawl_request_status == 0)
										<td>Rejected</td>
										@else
										<td>
											<a style="display: " href="javascript:void(0)" class="btn btn-success btn-sm" onclick="widrawl_request_status({{$fund->id}},'1');">
												Accept
											</a>
											<a style="display: " href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="widrawl_request_status({{$fund->id}},'0');">
												Reject
											</a>
										</td>
										@endif	
									</tr>
									@endforeach
									@endif
									<meta name="csrf-token" content="{{ csrf_token() }}">
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
<script type="text/javascript">
	function widrawl_request_status($id,$status){
		host_url = "/development/game_project/";
		var status =$status;
		var token = $("meta[name='csrf-token']").attr("content");
		var fund_id =$id;
		$.ajax({
			type: "POST",
			dataType: "json",
			url:'funds-widrawl-request-status',
			data: {'_token': token,'status': status, 'fund_id': fund_id},
			success: function(data){
			setTimeout(function(){
				jQuery('.result').html('');
				window.location.href ="funds_widrawl_list";
			}, 1000);
			}
		});
	}
</script>
@stop