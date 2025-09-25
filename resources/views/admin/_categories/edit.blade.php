@extends('admin.layout.master')

@section('content')     

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header my_style">
                <div class="left_section">
                    <h1 class="">Categories</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{ route('dashboard') }}">Home</a></li>
                        <li><a href="{{ route('categories.index') }}">Categories</a></li>
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
                            <div class="title">Edit Category</div>
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
                        <div class="col-sm-12">
                            <div class="input_box">
                                <label>Sort Order</label>
                                <div class="error form_error" id="form-error-sort_order"></div>
                                <input type="number" name="sort_order" placeholder="Sort Order" value="{{ $result->sort_order }}">
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

    <div class="row">
        <div class="my_panel form_box">
            
            @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger">{{Session::get('error')}}</div>
            @endif

            <form id="sort_sub_categories" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="dataID" value="{{ $result->id }}">
            <div class="page-header my_style less_margin">
                <div class="left_section">
                    <div class="title_text">
                        <div class="title">Edit Sub Categories Sort Order</div>
                        <div class="sub_title">Drag and drop then save to make the changes</div>
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
                <div class="sorting_wrapper">
                    <ul id="sortable">
                    @if(!empty($result->subCategories))
                        @foreach($result->subCategories as $subCategory)
                            <li class="ui-state-default" data-id="{{ $subCategory->id }}">
                                <div class="title">{{ $subCategory->title }}</div>
                                <div class="sort_order">{{ $subCategory->sort_order }}</div>
                            </li>
                        @endforeach
                    @else
                        No Banners
                    @endif
                    </ul>
                </div>
                <div class="input_boxes"><div class="input_box"></div></div>
                <div class="input_boxes">
                    <div class="col-sm-4">
                        <div class="input_box">
                            <button type="button" class="btn btn-primary save-banners-order">Save Order</button>
                        </div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- /.row -->

<script>
  $(document).ready(function() {
    const $draggable = $('.ui-state-default');

    $draggable.on('mousedown', function() {
      $(this).addClass('grabbing');
    });

    $(document).on('mouseup', function() {
      $draggable.removeClass('grabbing');
    });
  });



</script>

<script>
$( function() {
    $( "#sortable" ).sortable({
        revert: true
    });

    // $( "#draggable" ).draggable({
    //   connectToSortable: "#sortable",
    //   helper: "clone",
    //   revert: "invalid"
    // });

    $( "ul, li" ).disableSelection();

    $('.save-banners-order').click(function() {
        let sortedIds = [];
        $('ul#sortable li').each(function(index) {
            sortedIds.push({
                id: $(this).data('id'),
                sort_order: index + 1 // +1 if you want it 1-based
            });
        });

        // console.log(sortedIds);

        $.ajax({
            // url: '/nwm/collections/{{ $result->id }}/sort-banners',
            url: "{{ route('categories.sortSubCategories', $result->id) }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sorted: sortedIds
            },
            success: function(response) {
                alert('Sort order saved successfully!');
                window.location.reload();
            },
            error: function(xhr) {
                alert('Something went wrong');
            }
        });
    });

});

</script>

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
            url: "{{ route('categories.update', $result->id) }}",
            data:  formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                location.href="{{ route('categories.index') }}";
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