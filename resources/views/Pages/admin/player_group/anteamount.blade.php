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
            <h4 class="text-themecolor mb-0">Ante Amount</h4>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <ol class="breadcrumb mb-0 p-0 bg-transparent fa-pull-right">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Ante Amount</li>
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
            <form>
                <div class="card">
                    <div class="border-bottom title-part-padding d-flex justify-content-between">
                        <h4 class="card-title mb-0">Ante Amount</h4>
                    </div>
                   
                    <div class="card-body">
                        <div class="resultError"></div>
                        <div>
							@if($ante_amount != '' && $ante_amount != null)
								<div class="row g-3 align-items-center">
									<div class="col-6">
										<label for="exampleInputEmail1" class="form-label">Ante Amount First</label>
										<input type="text" class="form-control" id="anteInput1"
											aria-describedby="emailHelp" value="{{$ante_amount[0]}}"></div>
									</div>
								</div>
								<div class="row g-3 align-items-center">	
									<div class="col-6">
										<label for="exampleInputPassword2" class="form-label">Ante Amount Second</label>
										<input type="text" class="form-control" id="anteInput2" value="{{$ante_amount[1]}}">
									</div>
								</div>
								<div class="row g-3 align-items-center">	
									<div class="col-6">
										<label for="exampleInputPassword3" class="form-label">Ante Amount Third</label>
										<input type="text" class="form-control" id="anteInput3" value="{{$ante_amount[2]}}">
									</div>
								</div>
								<!-- <input type="hidden"  id="anteInput4" value=""/> -->
							@endif
                        </div>
                        <div class="card-footer ">
                            <button type="button" class="btn btn-primary ante_amnt_update">Update</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
<script>
	$('.ante_amnt_update').on('click', function () {
		var token = $("meta[name='csrf-token']").attr("content");
        var ante_amnt1 = $('#anteInput1').val();
		var ante_amnt2 = $('#anteInput2').val();
		var ante_amnt3 = $('#anteInput3').val();
		var id = $('#anteInput4').val();
        $.ajax({
			type: 'POST',
            url:'update-ante-amount',
            data: {
                id:id,'_token': token,ante_amount1:ante_amnt1,ante_amount2:ante_amnt2,ante_amount3:ante_amnt3
            },
            //dataType : 'json',
			success: function(data) {
				var obj = JSON.parse(data);
                if(obj.status==true){
					jQuery('.resultError').html("<div class='alert alert-success alert-dismissible text-white border-0 fade show' role='alert'><button type='button' class='btn-close btn-close-white' data-bs-dismiss='alert' aria-label='Close'></button><strong>Success - </strong> "+obj.message+"</div>");
					setTimeout(function(){
						 window.location.href = "group-ante-amount";
					},2000);
				}else{
                    jQuery('.resultError').html("<div class='alert alert-danger alert-dismissible text-white border-0 fade show' role='alert'><button type='button' class='btn-close btn-close-white' data-bs-dismiss='alert' aria-label='Close'></button><strong>Error - </strong> "+obj.message+"</div>");
					setTimeout(function(){
						 window.location.href = "group-ante-amount";
					},2000);
                }
			}
        });
    });
</script>
@stop