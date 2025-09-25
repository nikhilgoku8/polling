
<script src="{{ asset('admin/assets/js/custom.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('admin/assets/js/bootstrap.min.js') }}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ asset('admin/assets/js/metisMenu.min.js') }}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{ asset('admin/assets/js/sb-admin-2.js') }}"></script>

<!-- Select Search JavaScript -->
<script src="{{ asset('admin/assets/plugins/selects_search/select2.min.js') }}"></script>
<script>
$(document).ready(function(){
    
    //$(".selSearch").select2();
    $("select").select2();
    $(".custom_select").select2({
        tags:true
    });

    // Read selected option
    // $('#but_read').click(function(){
    //     var username = $('#selUser option:selected').text();
    //     var userid = $('#selUser').val();
   
    //     $('#result').html("id : " + userid + ", name : " + username);
    // });
});
</script>

<script src="{{ asset('admin/assets/plugins/chart/d3.v4.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/chart/jquery.bar.chart.min.js') }}"></script>

<!--Textarea Toolbar-->
<script type="text/javascript" src="{{ asset('admin/assets/js/tinymce/tinymce.min.js') }}"></script>
<script>
tinymce.init({
    selector: "textarea.toolbar",
    menubar:false,
    statusbar: false,
    theme: "modern",
    height: 200,
    plugins: [

         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   content_css: "css/content.css",
   toolbar: "insertfile undo redo | styleselect | bold italic | bullist numlist | link image code | forecolor backcolor", 
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ],
        setup: function (editor) {
            editor.on('init', function () {
                $(editor.getElement()).addClass('mce-initialized'); // mark as initialized
            });
        }
 });

</script>

<!--Start calender -->
<script src="{{ asset('admin/assets/js/bootstrap-datetimepicker.js') }}"></script>
<script type="text/javascript">  
    $('.datepicker').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        format: 'yyyy-mm-dd'
    });

    $('.future_datepicker').datetimepicker({
        startDate: new Date(),
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        format: 'yyyy-mm-dd'
    });

    $('.past_datepicker').datetimepicker({
        endDate: new Date(), // Restricts selection to past dates
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        format: 'yyyy-mm-dd'
    });

    var start_date = new Date();
    start_date.setDate(start_date.getDate() + 3);
    $('.appointment_datepicker').datetimepicker({
        //startDate: start_date,
        startDate:new Date(),
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        format: 'yyyy-mm-dd',
        daysOfWeekDisabled: [0]
    });
  
</script>
<!-- End calender -->

<!-- Custom Js -->
<script type="text/javascript">
    function patientsFilters(){
        document.getElementById("filter_box").classList.toggle("show");
    }
</script>