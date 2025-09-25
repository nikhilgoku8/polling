@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Users</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('users.index') }}">Users</a></li>
                    </ul>    
                </div>
                
                <div class="right_section">
                    <div class="purple_filled_btn">
                        <a href="{{ route('users.edit', $result->id) }}">Edit</a>
                    </div>
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
                                <div class="title">View User</div>
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
                            <div class="clr"></div>
                        </div>

                    </div>
                </form>
            </div>

    </div>
    <!-- /.row -->

<script type="text/javascript">
$(document).ready(function() {
    $("input").prop('disabled', true);
    $("select").prop('disabled', true);
    $(".delete_icon").css({'display':'none'});
    $(".edit_details").css({'display':'none'});
});
</script>
@endsection    