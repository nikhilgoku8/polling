<div class="filter_box {{ (request()->has('q') || request('fname') || request('lname') || request('email')) ? 'show' : '' }}" id="filter_box">
        <div class="row">
            <div class="my_panel">
                <div class="inner_box ">
                    <div class="upper_sec">
                        <div class="left_section">
                            <div class="title">
                                Filter Data
                                <div class="error form_error" id="form-error-custom_error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="filter_form">
                        <form id="filter_form" action="{{ route('users.index') }}" method="GET">
                        <!-- @@csrf -->
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>First Name</label>
                                <div class="error form_error" id="form-error-fname"></div>
                                <input type="text" name="fname" placeholder="First Name" value="{{ request('fname') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Last Name</label>
                                <div class="error form_error" id="form-error-lname"></div>
                                <input type="text" name="lname" placeholder="Last Name" value="{{ request('lname') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input_box">
                                <label>Email</label>
                                <div class="error form_error" id="form-error-email"></div>
                                <input type="text" name="email" placeholder="Email" value="{{ request('email') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <span class="input_box purple_filled_btn">
                                <button type="submit" name="submit">Search</button>
                            </span>
                            <span class="input_box blue_filled_btn">
                                <a href="{{ route('users.index') }}">Clear Filters</a>
                            </span>
                        </div>
                        </form>
                    </div>
                    <div class="clr"></div>
                </div>
                <!-- patients_filter_box end -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- patients_filter end -->