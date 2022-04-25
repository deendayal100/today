@extends('layouts.admin')
@section('content')

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h4 class="text-themecolor mb-0">User Details</h4>
		</div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <ol class="breadcrumb mb-0 p-0 bg-transparent fa-pull-right">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">User Details</li>
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
					<h4 class="card-title mb-0">User Details</h4>
				</div>
				<div class="card-body min_height">
					<form name="user_add" id="user_add" method="post" action="javascript:void(0)" enctype="multipart/form-data">
						@csrf
					    <div class="row">
							<div class="">
								<!-- Alert Append Box -->
							<div class="result"></div>
							</div>
							<div class="mb-3 col-md-4">
								<label for="Name" class="control-label" >First Name:</label>
								<input type="text" id="name" value="{{$user->fname}}" readonly="true" name="name" class="form-control">
							</div>
							<div class="mb-3 col-md-4">
								<label for="Name" class="control-label" >Last Name:</label>
								<input type="text" id="name" value="{{$user->lname}}" readonly="true" name="name" class="form-control">
							</div>

							<div class="mb-3 col-md-4">
								<label for="Email" class="control-label">Email:</label>
								<input type="email" id="email" name="email" value="{{$user->email}}" readonly="true" class="form-control">
								{{-- allready exit error --}}
								<label id="email_error" class="error"></label>
							</div>
						
							<div class="mb-3 col-md-4" style="display: block;">
								<label for="username" class="control-label">Phone Number:</label>
								<input type="text" id="mobile_number" name="phone" value="{{$user->phone}}" readonly="true"  class="form-control">
								{{-- allready exit error --}}
								<label id="name_error" class="error"></label>
							</div>
                        
							<div class="mb-3 col-md-4">
								<label for="password" class="control-label">Joined:</label>
								<input type="text" id="language" name="language"  readonly="true" value="{{$user->created_at}}"    class="form-control">
							</div>

							<div class="mb-3 col-md-4" style="display: block;">
								<label for="password" class="control-label">Average Rating:</label>
								<input type="text" id="reason" name="reason"  readonly="true" value="{{$user->reason}}" class="form-control">
							</div>

							<div class="mb-3 col-md-4"style="display: block;">
								<label for="password" class="control-label">Profile Image:</label>
								@if(!empty($user->image))
								    <img src="{{($user->image)}}" height="150" width="100" class="form-control" />
								@else
								    <input type="text" id="image" name="image"  readonly="true" value="Image not found" class="form-control">
								@endif
							</div>

							<div class="mb-3 col-md-4">
								<label for="status" class="control-label">Status:</label>
								<?php
									if(isset($user->status)){
										if(($user->status == 0)){
											echo '<p style="color:red"><b>De-Active</b></p>';
										}else if($user->status == 1){
											echo '<p style="color:green"><b>Active</b></p>';
										}else if($user->status == 2){
											echo '<p style="color:green"><b>Active</b></p>';
										} 
									}
								?>
							</div>
							
						</div>
						<a type="button" href="{{route('user_list')}}" class="btn btn-dark fa-pull-left mt-3">Back</a>
						<!-- <input type="submit" id="submit" value="Add" class="btn btn-success btn_submit fa-pull-right mt-3"> -->
					</form>
				</div>
			</div>
		</div>
		
	</div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

@stop


