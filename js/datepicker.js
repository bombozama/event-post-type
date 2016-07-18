(function( $ ) {
    'use strict';
    $(window).load(function() {
        $(".regular-text.datepicker").datepicker({
            altFormat: "yy/mm/dd",
            dateFormat: "dd/mm/yy",
            changeYear: true,
            changeMonth: true
        });
        $(".regular-text.datepicker").each(function(){
           $(this).datepicker("option", "altField", $(this).attr("data-value-input"));
        });
    });
})(jQuery);