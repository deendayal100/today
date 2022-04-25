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
										<th style="width:100px;">S.No.</th>
										<th style="width:800px;">Name</th>
										<th style="width:500px;">Amount</th>
										<th style="width:200px;">Payment Method</th>
										<th style="width:200px;">Payment Status</th>
										<Th style="width:800px;">Date</th>
										<th style="width:200px;">Trasaction Id</th>
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
										<td>{{ $fund->transaction_id }}</td>
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

@stop