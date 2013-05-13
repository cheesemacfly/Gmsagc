//Manage date type input on older browsers
if (!Modernizr.inputtypes.date) {
    $("input[type='date']").datepicker({ dateFormat: 'yy-mm-dd' });
}
//Manage time type input on older browsers
if (!Modernizr.inputtypes.time) {
    $("input[type='time']").timePicker({endTime: "08:00", step: 30});
}