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
                    <div class="purple_hollow_btn">
                        <a href="{{ route('users.create'); }}">Add New</a>
                    </div>
                    <div class="orange_hollow_btn">
                        <a id="filter_option">Filter</a>
                    </div>
                </div>
            </div>                    
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    @include('admin.users.filter')

    <div class="row">
        <div class="fourth_row">
            
            <div class="my_panel">
                
                @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger">{{Session::get('error')}}</div>
                @endif


                <div class="upper_sec">
                    <div class="left_section">
                        <div class="title">Users Data</div>
                        <div class="sub_title"> </div>
                    </div>
                    <div class="right_section">
                        <div class="orange_filled_btn">
                            <a id="delete_records">Delete</a>
                        </div>
                    </div>
                </div>
                <div class="details_table">
                    <table>
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th class="action">ACTION</th>
                            </tr>
                            @if(!empty($result))
                                @foreach ($result as $row)
                                    <tr>
                                        <td>{{ $row->fname .' '. $row->mname .' '. $row->lname }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td>{{ ucwords($row->gender) }}</td>
                                        <td>{{ $row->created_at }}</td>
                                        <td>{{ $row->updated_at }}</td>
                                        <td class="action">
                                            <a href="{{ route('users.edit', $row->id) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <span class="checkbox">
                                                <input name="dataID" class="styled" type="checkbox" value="{{ $row->id }}">
                                                <label for="checkbox1"></label>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                @if(method_exists($result, 'links'))
                <div class="table_pagination">
                    {{ $result->links('pagination.numbers') }}
                    <div class="clr"></div>
                </div>
                @endif
            </div>

        </div>
        <!-- fourth_row end -->
    </div>
    <!-- /.row -->    

<script type="text/javascript">
$(document).ready(function() {

  $("#delete_records").on('click',(function(e){
    e.preventDefault();

    var dataID = [];
    $.each($("input[name='dataID']:checked"), function(){
        dataID.push($(this).val());
    });

    if(dataID.length == 0){
        alert('No records are selected');
    }else{
        if (confirm('Are you sure you want to delete these records?')) {
            $.ajax({
                type: "POST",
                url: "{{ route('users.bulk-delete') }}",
                data: {"_token":"{{ csrf_token() }}", "dataID":dataID},
                dataType: 'json',
                success: function(response) {
                    window.location.reload(true);
                }
            });
        }
    }  

  }));

});
</script>

@endsection