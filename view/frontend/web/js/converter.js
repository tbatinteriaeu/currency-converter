define('js/theme', [
    'jquery',
    'domReady!'
], function ($) {
    'use strict';
    $.fn.converter = function() {

        var processed = false;

        //do ajax request on submit
        this.on('submit', function(e){

            //parse form fields to json
            var json = {};
            jQuery.each(jQuery($(this)).serializeArray(), function() {
                json[this.name] = this.value || '';
            });

            var form = $('#converter');
            //make ajax request
            $.ajax({
                url: form.attr('action'),
                data: json,
                dataType: 'json',
                beforeSend: function() {
                    form.find('.submit').attr('disabled', 'disabled');
                },
                method : 'POST'
            })
                .done(function( data ) {

                    if (data.success) {
                        //set received value for converted currency
                        $('#exchange-value').val(data.result).focus();

                    }

                }).always(function(){form.find('.submit').removeAttr('disabled')});

            return false;
        });

        this.find('#base-value').on('blur', function(){
            $('#exchange-value').val('...');
        });
        return this;

    };

    // binding:
    $(document).ready(function(){
        $( "#converter" ).converter();
    })
});