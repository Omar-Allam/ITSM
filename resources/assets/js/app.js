import swal from 'sweetalert2'
window.jQuery = window.$ = require('jquery');
window.swal = swal;
require('bootstrap-sass');
require('select2');

(function($) {
    $(function(){
        $('.select2').select2({width: '100%', allowClear: true});
    });
}(window.jQuery));

