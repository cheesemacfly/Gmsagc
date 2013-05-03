//Manage date type input on older browsers
if (!Modernizr.inputtypes.date) {
    $("input[type='date']").datepicker({ dateFormat: 'yy-mm-dd' });
}