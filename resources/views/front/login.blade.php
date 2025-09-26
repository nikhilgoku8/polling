@extends('front.layout.master')

@section('content')

<div class="login_page">
	<div class="container">
		<div class="inner_container">
			
			<div class="form_wrapper">
				<form id="login_form" action="" method="POST">
					@csrf
					<div class="col-sm-12">
						<div class="heading">Login</div>
					</div>
					<div class="col-sm-12">
						<div class="input_box">
							<label>
								<span>Email</span>
								<div class="form_error email-form_error">asd</div>
								<input type="text" name="email">
							</label>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="input_box">
							<div class="form_error password-form_error"></div>
							<label>
								<span>Password</span>
								<input type="text" name="password">
							</label>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="input_box">
							<button>Submit</button>
						</div>
					</div>
					<div class="clr"></div>
				</form>
			</div>

		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$("#login_form").on("submit", function(e) {
        e.preventDefault(); // stop normal form submission
        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('front.authenticateUser') }}",     // your server-side script
            type: "POST",          // method (POST/GET)
            data: formData, // form data
	        processData: false, // important for FormData
	        contentType: false, // important for FormData
            success: function(response) {
                $("#result").html(response); // show server response
            },
            error: function() {
                $("#result").html("Something went wrong!");
            }
        });
    });
});
</script>

@endsection