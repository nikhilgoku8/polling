@extends('admin.layout.master')

@section('content')   
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Change Password</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ url('wm/dashboard'); }}">Home</a></li>
                        <li><a href="{{ url('wm/change-password'); }}">Change Password</a></li>
                    </ul>    
                </div>
            </div>                    
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="fourth_row">
            
            <div class="my_panel form_box">
                
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger">{{Session::get('error')}}</div>
                @endif


                <form id="data_form" action="" method="POST" enctype="multipart/form-data">
	                @csrf
	                <div class="page-header my_style less_margin">
	                    <div class="left_section">
	                        <div class="title_text">
	                            <div class="title">Please fillup the form</div>
	                            <!-- <div class="sub_title">Please fillup the form </div> -->
	                        </div>
	                    </div>
	                    <div class="right_section">
	                        <!-- <div class="purple_filled_btn">
	                            <a href="#">Save</a>
	                        </div> -->
	                    </div>
	                </div>

	                <div class="inner_boxes">
	                    <div class="input_boxes">
	                        <div class="col-sm-12">
	                            <div class="input_box">
	                                <label>Old Password</label>
	                                <div class="error form_error" id="form-error-old_password"></div>
	                                <input type="password" name="old_password" placeholder="Enter Old Password">
	                            </div>
	                        </div>
	                        <div class="col-sm-12">
	                            <div class="input_box">
	                                <label>New Password</label>
	                                <div class="error form_error" id="form-error-new_password"></div>
	                                <input type="password" name="new_password" placeholder="Enter New Password">
	                            </div>
	                        </div>
	                        <div class="clr"></div>
	                    </div>

	                    <div class="input_boxes">
	                        <div class="col-sm-4">
	                            <div class="input_box">
	                                <input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary">
	                            </div>
	                        </div>
	                        <div class="clr"></div>
	                    </div>

	                </div>
                </form>
                
            </div>

        </div>
        <!-- fourth_row end -->
    </div>
    <!-- /.row -->    

<script type="text/javascript">
$(document).ready(function() {
	$("#data_form").on('submit',(function(e){
    	e.preventDefault();
    	$(".form_error").html("");
    	$(".form_error").removeClass("alert alert-danger");

	    $.ajax({
	        type: "POST",
	        url: "{{ url('wm/changePasswordFunction') }}",
	        data:  new FormData(this),
	        dataType: 'json',
	        cache: false,
	        contentType: false,
	        processData: false,
	        success: function(result) {
	            window.location.reload(true);
	        },
	        error: function(data){
	            var responseData = data.responseJSON;
	            if(responseData.error_type=='form'){
	            	jQuery.each( responseData.errors, function( i, val ) {
				    	$("#form-error-"+i).html(val);
				    	$("#form-error-"+i).addClass('alert alert-danger');
					});
	            }
	        }
	    });

	}));
});
</script>

@endsection