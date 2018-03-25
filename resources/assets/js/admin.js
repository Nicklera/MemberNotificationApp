
try {
    window.$ = window.jQuery = require('jquery');;
    
    require('bootstrap-sass');
    require('jquery-ui');
    window.moment = require('moment');
    window.swal = require('sweetalert2');
    // Admin LTE & its plugins
    require('admin-lte')
    require('admin-lte/plugins/fullcalendar/fullcalendar.min.js');
    require('admin-lte/plugins/iCheck/icheck.min.js');
    require('admin-lte/plugins/datepicker/bootstrap-datepicker.js');
    require('bootstrap-slider');
    require('jstree');
    require( 'datatables.net-bs' )();
    require( 'datatables.net-buttons-bs' )();
    require( 'datatables.net-buttons/js/buttons.colVis.js' )();
    require( 'datatables.net-buttons/js/buttons.flash.js' )();
    require( 'datatables.net-buttons/js/buttons.html5.js' )();
    require( 'datatables.net-buttons/js/buttons.print.js' )();
} catch (e) {}

// CUSTOM JS
if (jQuery().datepicker) {
    $('.date-picker').datepicker({
        orientation: "left",
        autoclose: true,
        format: "yyyy-mm-dd"
    });
}
 $('[data-toggle="tooltip"]').tooltip();

  $('.delete').on('click', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        swal({
            title: 'Are you sure?',
            text: '',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancel'
        }).then(function () {
            window.location = href;
        })
    });

    if (jQuery().iCheck) {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    }