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
            <h4 class="text-themecolor mb-0">Players</h4>
		</div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <ol class="breadcrumb mb-0 p-0 bg-transparent fa-pull-right">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Players</li>
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
					    <h4 class="card-title mb-0">Players List</h4> 
						<a style="display:none" href="{{ route('add_player') }}" class="btn btn-info btn-sm">
							Add Player
						</a>               
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<div class="">
                                <!-- Alert Append Box -->
                                <div class="result"></div>
								<button style="margin-bottom: 10px;"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#playerModal">
  								  Add Player
							    </button>
                            </div>
							<table id="zero_config" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th style=""><input type="checkbox" id="user_master"></th>
										<th style="width:100px;">S.No.</th>
										<th style="width:100px;">Id.</th>
										<th style="width:800px;">Name</th>
										<th style="width:500px;">Email</th>
										<th style="width:200px;">Phone</th>
										<Th style="width:800px;">Status</th>
										<th style="width:60px;">Action</th>
									</tr>
								</thead>
								<tbody>
								@if(!empty($users))	
								@foreach ($users as $user)
									<tr>
									<td style=""><input type="checkbox" class="sub_chk" data-id="{{$user->id}}"></td>
										<td>{{$loop->iteration}}</td>
										<td>{{ $user->unique_id }}</td>
										<td >{{ $user->name }}</td>
										<td>{{ $user->email }}</td>
										<td>{{ $user->phone }}</td>
										<td>
										<span class="status">
													<label class="switch">
														@if($user->status==1)
															<input data-id="{{$user->id}}" class="  switch-input" onchange="useractivedeactive({{$user->id}},'0');" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $user->status ? 'checked' : '' }}>
															<span class="switch-label" data-on="Active" data-off="Inactive"></span> 
															<span class="switch-handle"></span> 
														@else
															<input data-id="{{$user->id}}" class="  switch-input" onchange="useractivedeactive({{$user->id}},'1');" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Deactive" data-off="InActive">
															<span class="switch-label" data-on="Active" data-off="Inactive"></span> 
															<span class="switch-handle"></span> 
														@endif
													</label>
												</span>
										</td>
										<td>
											<div class="table_action">
												
												<a style="display: " href="javascript:void(0)" class="btn btn-info btn-sm player_edit" id="{{$user->id}}" data-toggle="modal" data-target="#editPlayer">
													<i class="mdi mdi-lead-pencil"></i>
												</a> 

												<!-- <a href="{{ route('player_delete',$user->id) }}" class="btn btn-danger btn-sm  " onclick="return confirm('Are you sure delete this user？')">
													<i class="mdi mdi-delete"></i>
												</a> -->
												
											</div>
											  
										</td>
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


	<!-- model open  Add Player-->
<div class="modal fade" id="playerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Player</h5>
				<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
			</div>
			<form class="" action="javascript:void(0)" id="player_signup"  method="post" enctype="multipart/form-data">
				<div class="modal-body">
				<div class="playerError"></div>
						
						<div class="form-group form-group-transparent">
							<label class="f-16 fr white">Name</label>
							<div class="">
								<input type="text" class="form-control" required="true" name="name" placeholder="Enter Full Name">
							</div>
							
						</div>
						<div class="form-group form-group-transparent">
							<label class="f-16 fr white">Name</label>
							<div class="">
								<input type="text" class="form-control" required="true" name="alias" placeholder="Enter Alias">
							</div>
							
						</div>
						<div class="form-group form-group-transparent">
							<label class="f-16 fr white">Email</label>
							<div class="">
								<input type="email" class="form-control" required="true" name="email" placeholder="Enter Email Address">
							</div>
						</div>
						<div class="form-group form-group-transparent">
							<label class="f-16 fr white">Phone</label>
							<div class=" input-group-inline">
							<input type="hidden" id="country_code"  name="country_code"/>
							<input type="text" class="form-control" required="true" id="phone" name="phone" placeholder="Enter Phone">
							</div>
						</div>
						<div class="form-group form-group-transparent">
							<label class="f-16 fr white">Password</label>
							<div class="input-group-inline">
							<input type="text" class="form-control" required="true" id="password" name="password" placeholder="Enter Password">
							</div>
						</div>
						<div class="form-group form-group-transparent">
							<label class="f-16 fr white">Confirm Password</label>
							<div class="input-group-inline">
							<input type="text" class="form-control" required="true" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password">
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
					<input type="submit" class="btn btn-primary"  value="Submit">
				</div>
			</form>	
		</div>
  </div>
</div>
<!-- model end  Add Player-->
<!--Edit Player Modal open-->
	<div class="modal fade" id="editPlayer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Player</h5>
				<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
			</div>
			<form class="" action="javascript:void(0)" id="player_edit_form"  method="post" enctype="multipart/form-data">
				<div class="modal-body">
				<div class="editPlayerError"></div>
						
						<div class="form-group form-group-transparent">
							<label class="f-16 fr white">Name</label>
							<div class="">
								<input type="text" id="player_name_edit" class="form-control" required="true" name="name" placeholder="Enter Full Name">
							</div>
						</div>
						<div class="form-group form-group-transparent">
							<label class="f-16 fr white">Email</label>
							<div class="">
								<input type="email" id="player_email_edit" class="form-control" required="true" name="email" placeholder="Enter Email Address">
							</div>
						</div>
						<div class="form-group form-group-transparent">
							<label class="f-16 fr white">Phone</label>
							<div class="">
							<input type="text" class="form-control" required="true" id="player_phone_edit" name="phone" placeholder="Enter Phone">
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="player_id"  name="player_id" value=""/>
					<button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
					<input type="submit" class="btn btn-primary"  value="Submit">
					<!-- <button type="submit" class="btn btn-primary">Submit</button> -->
				</div>
			</form>	
		</div>
  </div>
</div>

<script>
	$("#player_signup").validate({
		rules: {
			name: {required: true,},
			email: {required: true,email: true,},
			password:{required:true},
			phone:{ 
			required:true,
			minlength:10,
			maxlength:10},
		},
		messages: {
			name: {required: "Please enter name",},email: {required: "Please enter valid email",email: "Please enter valid email",},   
			phone: {required: "Please enter Mobile Number",},
			password: {required: "Please enter password",},
		},
		submitHandler: function(form) {
		   var formData= new FormData(jQuery('#player_signup')[0]);
		   //formData.append("_token",$('meta[name="csrf-token"]').attr('content'));
		   formData.append("_token",$('meta[name="csrf-token"]').attr('content'));
		   host_url ="development/game_project/";
		jQuery.ajax({
				url:  "add_player",
				type: "post",
				cache: false,
				data: formData,
				processData: false,
				contentType: false,
				success:function(data) {
				var obj = JSON.parse(data);
				if(obj.status==true){
					jQuery('.playerError').html("<div class='alert alert-success alert-dismissible text-white border-0 fade show' role='alert'><button type='button' class='btn-close btn-close-white' data-bs-dismiss='alert' aria-label='Close'></button><strong>Success - </strong> "+obj.message+"</div>");
					setTimeout(function(){
						 window.location.href = "player_list";
					},2000);
				}
				else{
					if(obj.status==false && obj.data==0){
						jQuery('.playerError').html("<div class='alert alert-warning alert-dismissible text-white border-0 fade show' role='alert'><button type='button' class='btn-close btn-close-white' data-bs-dismiss='alert' aria-label='Close'></button><strong>Error! - </strong> "+obj.message+"</div>");
						
					}
					else if(obj.status==false && obj.data==1){
						jQuery('.playerError').html("<div class='alert alert-warning alert-dismissible text-white border-0 fade show' role='alert'><button type='button' class='btn-close btn-close-white' data-bs-dismiss='alert' aria-label='Close'></button><strong>Error! - </strong> "+obj.message+"</div>");
						
					}
					else if(obj.statusmobile_number==false){
						jQuery('#mobile_number_error').html(obj.message);
						jQuery('#mobile_number_error').css("display", "block");
					}
					else if(obj.statusemail==false){
						jQuery('#email_error').html('');
						jQuery('#email_error').html(obj.message);
						jQuery('#email_error').css("display", "block");
					}
					else{
						jQuery('#mobile_number_error').html('');
						jQuery('#email_error').html('');
					}
				}
				}
			});
		}
	});
</script>
<script>
	$('.player_edit').on('click', function () {
		host_url = "/development/game_project/";
		var token = $("meta[name='csrf-token']").attr("content");
        var player_id = $(this).attr('id');
        $.ajax({
			type: 'POST',
            url: host_url+'detail_player',
            data: {
                player_id:player_id,'_token': token
            },
            dataType : 'json',
			success: function(data,status) {
				if(status == 'success'){
					$('#player_name_edit').val(data[0]['name']);
					$('#player_email_edit').val(data[0]['email']);
					$('#player_phone_edit').val(data[0]['phone']);
					$('#player_id').val(data[0]['id']);
				}
			}
        });
    });
</script>
<script type="text/javascript">
	function useractivedeactive($id,$status){
		host_url = "/development/game_project/";
		var status =$status; //$(this).prop('checked') == true ? 1 : 0; 
		var token = $("meta[name='csrf-token']").attr("content");
		var user_id =$id;
		$.ajax({
			type: "POST",
			dataType: "json",
			url: 'player/change/status',
			data: {'_token': token,'status': status, 'user_id': user_id},
			success: function(data){
			setTimeout(function(){
				jQuery('.result').html('');
				window.location.href ="player_list";
			}, 1000);
			}
		});
		
	}
</script>
<script>
	$("#player_edit_form").validate({
		rules: {
			name: {required: true,},
			email: {required: true,email: true,},
			password:{required:true},
			phone:{ 
			required:true,
			minlength:10,
			maxlength:10},
			},
		
		messages: {
			name: {required: "Please enter name",},email: {required: "Please enter valid email",email: "Please enter valid email",},   
			phone: {required: "Please enter Mobile Number",},
			password: {required: "Please enter password",},
		},
		submitHandler: function(form) {
		   var formData= new FormData(jQuery('#player_edit_form')[0]);
		   formData.append("_token",$('meta[name="csrf-token"]').attr('content'));
		   host_url ="development/game_project/";
		jQuery.ajax({
				url:  "edit_player",
				type: "post",
				cache: false,
				data: formData,
				processData: false,
				contentType: false,
				success:function(data) {
				var obj = JSON.parse(data);
				if(obj.status==true){
					jQuery('.editPlayerError').html("<div class='alert alert-success alert-dismissible text-white border-0 fade show' role='alert'><button type='button' class='btn-close btn-close-white' data-bs-dismiss='alert' aria-label='Close'></button><strong>Success - </strong> "+obj.message+"</div>");
					setTimeout(function(){
						 window.location.href = "player_list";
					},2000);
				}
				else{
					if(obj.status==false && obj.data==0){
						jQuery('.editPlayerError').html("<div class='alert alert-warning alert-dismissible text-white border-0 fade show' role='alert'><button type='button' class='btn-close btn-close-white' data-bs-dismiss='alert' aria-label='Close'></button><strong>Error! - </strong> "+obj.message+"</div>");
						
					}
					else if(obj.status==false && obj.data==1){
						jQuery('.editPlayerError').html("<div class='alert alert-warning alert-dismissible text-white border-0 fade show' role='alert'><button type='button' class='btn-close btn-close-white' data-bs-dismiss='alert' aria-label='Close'></button><strong>Error! - </strong> "+obj.message+"</div>");
						
					}
				}
				}
			});
		}
	});
</script>

@stop