@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Pollings</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('pollings.index') }}">Pollings</a></li>
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
                            <div class="title">Edit Poll Event</div>
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
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Title</label>
                                <div class="error form_error" id="form-error-title"></div>
                                <input type="text" name="title" placeholder="Title" value="{{ $result->title }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Poll Type</label>
                                <div class="error form_error" id="form-error-poll_type"></div>
                                <select name="poll_type">
                                    <option value="">Select</option>
                                    <option value="free-for-all" @selected($result->poll_type == 'free-for-all')>Free for all</option>
                                    <option value="selected-candidates" @selected($result->poll_type == 'selected-candidates')>Selected Candidates</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Winner Type</label>
                                <div class="error form_error" id="form-error-winner_type"></div>
                                <select name="winner_type">
                                    <option value="">Select</option>
                                    <option value="single" @selected($result->winner_type == 'single')>Single</option>
                                    <option value="gender-based" @selected($result->winner_type == 'gender-based')>Gender Based</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Status</label>
                                <div class="error form_error" id="form-error-status"></div>
                                <select name="status">
                                    <option value="">Select</option>
                                    <option value="active" @selected($result->status == 'active')>Active</option>
                                    <option value="inactive" @selected($result->status == 'inactive')>Inactive</option>
                                </select>
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
    <!-- /.row -->

    @if($result->poll_type == 'selected-candidates')
    <div class="row">
        <div class="my_panel form_box">
            
            @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">{{Session::get('error')}}</div>
            @endif

            <form id="polling_candidates_form" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="polling_id" value="{{ $result->id }}">
                <div class="page-header my_style less_margin">
                    <div class="left_section">
                        <div class="title_text">
                            <div class="title">Edit Polling Candidates</div>
                            <!-- <div class="sub_title">Drag and drop then save to make the changes</div> -->
                        </div>
                    </div>
                    <div class="right_section">
                        <div class="purple_filled_btn">
                            <!-- <a class="save-order">Save</a> -->
                            <!-- <button type="button" class="btn btn-primary save-banners-order">Save Order</button> -->
                        </div>
                    </div>
                </div>

                <div class="inner_boxes">
                    <div class="input_boxes">
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Candidates</label>
                                <div class="error form_error" id="form-error-poll_candidates"></div>
                                <select name="poll_candidates[]" multiple>
                                    <option value="">Select Candidates</option>
                                    @php
                                        $candidates = $result->candidates->pluck('id')->toArray();
                                    @endphp
                                    @if($users->isNotEmpty())
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" @selected(in_array($user->id, $candidates))>{{ $user->fname .' '.$user->mname .' '.$user->lname }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="input_boxes">
                        <div class="col-sm-4">
                            <div class="input_box">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /.row -->
    @endif

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
            url: "{{ route('pollings.update', $result->id) }}",
            data:  formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="{{ route('pollings.index') }}";
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

    $("#polling_candidates_form").on('submit',(function(e){
        e.preventDefault();
        $(".form_error").html("");
        $(".form_error").removeClass("alert alert-danger");

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "{{ route('pollings.candidates_update', $result->id) }}",
            data:  formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                window.location.reload(true);
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