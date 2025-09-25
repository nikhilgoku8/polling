@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Edit User</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('users.index') }}">Users</a></li>
                    </ul>    
                </div>
                
                <div class="right_section">
                    <div class="blue_filled_btn">
                        <a href="{{ url()->previous() }}">Back</a>
                    </div>
                </div>
            </div>                    
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">

            <div class="my_panel form_box">
                <form id="data_form" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="dataID" value="{{ $result->id }}">
                <div class="page-header my_style less_margin">
                    <div class="left_section">
                        <div class="title_text">
                            <div class="title">Edit Details</div>
                            <div class="sub_title">Please fillup the form </div>
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
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>First Name*</label>
                                <div class="error form_error" id="form-error-fname"></div>
                                <input type="text" name="fname" placeholder="First Name" value="{{ $result->fname }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Middle Name</label>
                                <div class="error form_error" id="form-error-mname"></div>
                                <input type="text" name="mname" placeholder="Middle Name" value="{{ $result->fname }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Last Name*</label>
                                <div class="error form_error" id="form-error-lname"></div>
                                <input type="text" name="lname" placeholder="Last Name" value="{{ $result->lname }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Email*</label>
                                <div class="error form_error" id="form-error-email"></div>
                                <input type="text" name="email" placeholder="Email" value="{{ $result->email }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Gender*</label>
                                <div class="error form_error" id="form-error-gender"></div>
                                <select>
                                    <option value="">Select Gender</option>
                                    <option value="male" @selected($result->email == 'male')>Male</option>
                                    <option value="female" @selected($result->email == 'female')>Female</option>
                                </select>
                                <input type="text" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Password</label>
                                <div class="error form_error" id="form-error-password"></div>
                                <input type="text" name="password" placeholder="Password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input_box">
                                <label>Confirm Password</label>
                                <div class="error form_error" id="form-error-confirm_password"></div>
                                <input type="text" name="confirm_password" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>

                    <div class="input_boxes">
                        <div class="col-sm-4">
                            <div class="input_box">
                                <input type="submit" name="submit" value="Save" class="btn btn-primary">
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
                </form>
            </div>

    </div>
    <!-- /.row -->

<script type="text/javascript">
$(document).ready(function() {

    $("#data_form").on('submit',(function(e){
        e.preventDefault();
        $(".form_error").html("");
        $(".form_error").removeClass("alert alert-danger");

        var formData = new FormData(this);
        formData.append('_method', 'PUT'); // <-- This is important!

        $.ajax({
            type: "POST",
            url: "{{ route('users.update', $result->id) }}",
            data:  formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="{{ route('users.index') }}";
            },
            error: function(data){
                if (data.status === 422) {
                    let errors = data.responseJSON.errors;
                    $.each(errors, function (key, message) {
                        $('#form-error-' + key).html(message).addClass('alert alert-danger');
                    });
                } else if (data.status === 401) {
                    alert("Please log in.");
                    // window.location.href = "/login";
                } else if (data.status === 403) {
                    alert("You don’t have permission.");
                } else if (data.status === 404) {
                    alert("The resource was not found.");
                } else if (data.status === 500) {
                    alert("Something went wrong on the server.");
                    console.log(data.console_message);
                } else {
                    alert("Unexpected error: " + data.status);
                    console.log(data);
                }
            }
        });

    }));

});
</script>
            
@endsection    