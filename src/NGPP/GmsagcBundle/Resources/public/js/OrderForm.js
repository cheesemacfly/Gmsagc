// Autocomplete for press and materials
$('#ngpp_gmsagcbundle_orderstype_press').typeahead({
    source: function (query, process) {
        $.get(Routing.generate('ngpp_gmsagc_ajax_press_list', { name: query }), function (data) {
            process(data);
        });
    }
});

$('#ngpp_gmsagcbundle_orderstype_material').typeahead({
    source: function (query, process) {
        $.get(Routing.generate('ngpp_gmsagc_ajax_materials_list', { name: query }), function (data) {
            process(data);
        });
    }
});

$('#ngpp_gmsagcbundle_orderstype_action').change(function() {
    $.ajax({
        type: 'POST',
        url: Routing.generate('ngpp_gmsagc_ajax_orders_save'),
        data: $('#ordersForm').serialize(),
        dateType: 'html'
    }).done(function(data){
        //Replace mold form/field with the one from the response
        $('#ngpp_gmsagcbundle_orderstype_mold').replaceWith($(data).find('#ngpp_gmsagcbundle_orderstype_mold'));
    });
});