<!DOCTYPE html>
<html lang="en">
<head>
	<base href="{{ URL::to('/') }}/">
	@include('admin.layout.head_script')
</head>

<body>

    <div id="wrapper">

        <div id="page-wrapper" style="margin:0">
            

            @yield('content')


            <div class="row">
                <div class="last_row">
                    
                    <div class="left_section">
                        All Rights Reserved @ <b>Kartavya Healtheon Private limited</b>.
                    </div>
                    <div class="right_section">
                        <!-- <div class="text">D’zine and Developed by <br> <b>Codzera Technologies Private Limited.</b> </div>
                        <div class="codzera_logo">
                            <img src="admin/assets/images/codzera-logo.png">
                        </div> -->
                    </div>

                </div>
                <!-- last_row end -->
            </div>
            <!-- /.row -->


        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    @include('admin.layout.footer_script')

</body>

</html>
