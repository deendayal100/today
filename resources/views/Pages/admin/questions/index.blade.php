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
            <h4 class="text-themecolor mb-0">Questions</h4>
		</div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <ol class="breadcrumb mb-0 p-0 bg-transparent fa-pull-right">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Questions</li>
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
					    <h4 class="card-title mb-0">Questions</h4> 
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<div class="">
                                <!-- Alert Append Box -->
                                <div class="result"></div>
								<button style="margin-bottom: 10px;"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#questionModal">
  								  Add
							    </button>								
                            </div>
							<table id="zero_config" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th style="width:100px;">S.No.</th>
										<th style="width:200px;">Category</th>
										<th style="width:100px;">Difficulty</th>
										<th style="width:400px;">Questions</th>
										<th style="width:150px;">Wrong Answer 1</th>
										<th style="width:150px;">Wrong Answer 2</th>
										<th style="width:150px;">Wrong Answer 3</th>
										<th style="width:150px;">Correct</th>
									</tr>
								</thead>
								<tbody>
								@if(!empty($question))
								@foreach ($question as $val)
									<tr>
										<td>{{$loop->iteration}}</td>
										<td >{{$val->category}}</td>
										<td >{{$val->difficulty}}</td>
										<td >{{$val->question}}</td>
										<td >{{$val->wrong_answer1}}</td>
										<td >{{$val->wrong_answer2}}</td>
										<td >{{$val->wrong_answer3}}</td>
										<td >{{$val->correct}}</td>
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

	<!-- ============================================================== -->
    <!-- csv upload modal start -->
    <!-- ============================================================== -->
	<div class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Question Upload</h5>
			</div>
			<form class=""  method="post" action="javascript:void(0)" id="upload_questions">
				<div class="modal-body">
					<div class="questionError"></div>
					@csrf
					<div class="mb-3">
						<label for="formFile" class="form-label">Upload Question</label>
						<input class="form-control" type="file" id="question_csv" name="question_csv">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Upload</button>
				</div>
			</form>
			</div>
		</div>
	</div>
	<!-- ============================================================== -->
    <!-- csv upload modal end -->
    <!-- ============================================================== -->
	
<script>
	$("#upload_questions").validate({
	rules: {
		question_csv: {required: true,}
	},
	messages: {
		question_csv: {required: "Please upload CSV File.",}
	},
	submitHandler: function(form) {
		var formData= new FormData(jQuery('#upload_questions')[0]);
		formData.append("_token",$('meta[name="csrf-token"]').attr('content'));
		host_url ="development/game_project/";
		jQuery.ajax({
			url:  "upload-questions",
			type: "post",
			cache: false,
			data: formData,
			processData: false,
			contentType: false,
			success:function(data) {
				var obj = JSON.parse(data);
				if(obj.status==true){
					jQuery('.questionError').html("<div class='alert alert-success alert-dismissible text-white border-0 fade show' role='alert'><button type='button' class='btn-close btn-close-white' data-bs-dismiss='alert' aria-label='Close'></button><strong>Success - </strong> "+obj.message+"</div>");
					setTimeout(function(){
						window.location.href = "player-questions";
					},2000);
				}
				else{
					if(obj.status==false){
						jQuery('.questionError').html("<div class='alert alert-warning alert-dismissible text-white border-0 fade show' role='alert'><button type='button' class='btn-close btn-close-white' data-bs-dismiss='alert' aria-label='Close'></button><strong>Error! - </strong> "+obj.message['question_csv']+"</div>");						
					}
				}
			}
		});
	}
	});
</script>
@stop