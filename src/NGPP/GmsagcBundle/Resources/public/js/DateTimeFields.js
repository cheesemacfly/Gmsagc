//Manage date type input on older browsers
if (!Modernizr.inputtypes.date) {
    $("input[type='date']").datepicker({ dateFormat: 'yy-mm-dd' });
}
//Manage time type input on older browsers
if (!Modernizr.inputtypes.time) {
    $("input[type='time']").timepicker({
        'timeFormat': 'H:i',
	'minTime': '0',
	'maxTime': '8:00'
    });
}