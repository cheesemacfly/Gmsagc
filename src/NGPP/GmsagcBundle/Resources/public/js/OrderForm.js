if (!Modernizr.inputtypes.date) {
    $("input[type='date']").datepicker({ dateFormat: 'yy-mm-dd' });
}

jQuery(document).ready(function() {
    $('#ngpp_gmsagcbundle_orderstype_press').typeahead({
        local: ["aaaaaaaaaaaaa","ert","ert5","ert57","ertt","Press test","wret","wwwwwwww"]
    });
});