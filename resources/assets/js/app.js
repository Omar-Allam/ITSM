window.jQuery = require('jquery');
require('bootstrap-sass');
require('select2');

(function($) {
    $(function(){
        $('select').select2({width: '100%'});
    });
}(window.jQuery));

