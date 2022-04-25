@extends('layouts.admin')
@section('content')
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h4 class="text-themecolor mb-0">Edit User</h4>
		</div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <ol class="breadcrumb mb-0 p-0 bg-transparent fa-pull-right">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"> Edit User </li>
			</ol>
		</div>
	</div>
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
		
		<div class="col-12">
			<div class="card">
				<div class="border-bottom title-part-padding">
					<h4 class="card-title mb-0">Edit User </h4>
				</div>
				<div class="card-body min_height">
					<form name="category_edit1" id="category_edit1" method="post" action="javascript:void(0)" enctype="multipart/form-data">
						@csrf
					    <div class="row">
							<!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
							<input type="hidden" name="user_id" id="user_id" value="{{ $users->id }}">

							<div class="mb-3 col-md-4">
								<label for="Name" class="control-label" >First Name:</label>
								<input type="text" id="fname" value="{{$users->fname}}" name="fname" class="form-control" required>
							</div>
							<div class="mb-3 col-md-4">
								<label for="Name" class="control-label" >Last Name:</label>
								<input type="text" id="lname" value="{{$users->lname}}" name="lname" class="form-control" required>
							</div>

							<div class="mb-3 col-md-4">
								<label for="Email" class="control-label">Email:</label>
								<input type="email" id="email" name="email" value="{{$users->email}}" class="form-control" required>
								{{-- allready exit error --}}
								<label id="email_error" class="error"></label>
							</div>
							<div class="mb-3 col-md-4">
								<label for="username" class="control-label">Mobile Number:</label>
								<input type="phone" id="phone" name="phone" value="{{$users->phone}}" class="form-control" required>
							{{-- allready exit error --}}
							<label id="name_error" class="error"></label>
							</div>
						
						</div>
						<!-- <a type="button" href="{{ url('/user_reviews') }}"class="btn btn-dark fa-pull-left mt-3">Back</a>
						<input type="submit" id="submit" value="Save" class="btn btn-success btn_submit fa-pull-right mt-3"> -->
						<a type="button" href="{{ route('user_list') }}" class="btn btn-dark fa-pull-left mt-3">Back</a>
						<input type="submit" id="submit" value="Submit" class="btn btn-success btn_submit fa-pull-right mt-3">
					</form>
				</div>
			</div>
		</div>
		
	</div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

<script>
	$("#category_edit1").validate({
	rules: {
		email: {required: true,},
		},
	messages: {
		email: {required: "Please enter email",},
	},
		submitHandler: function(form) {
		   var formData= new FormData(jQuery('#category_edit1')[0]);
		   host_url = "/development/meyfintech/";
		jQuery.ajax({
				url:host_url+"update_data",
				type: "post",
				cache: false,
				data: formData,
				processData: false,
				contentType: false,
				
				success:function(data) { 
				var obj = JSON.parse(data);
				if(obj.status==true){
					jQuery('.result').html("<div class='alert alert-success alert-dismissible text-white border-0 fade show' role='alert'><button type='button' class='btn-close btn-close-white' data-bs-dismiss='alert' aria-label='Close'></button><strong>Success - </strong> "+obj.message+"</div>");
					setTimeout(function(){
						jQuery('.result').html('');
						window.location = host_url+"user_list";
					}, 2000);
				}else{
					if(obj.status==false){
						jQuery('.result').html("<div class='alert alert-success alert-dismissible text-white border-0 fade show' role='alert'><button type='button' class='btn-close btn-close-white' data-bs-dismiss='alert' aria-label='Close'></button><strong>Success - </strong> "+obj.message+"</div>");
					}
					
				}
				}
			});
		}
	});
</script>
@stop


