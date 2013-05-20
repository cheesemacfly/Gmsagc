// Autocomplete for press and materials
$('#ngpp_gmsagcbundle_orderstype_press').typeahead({
    source: function (query, process) {
        $.get(Routing.generate('ngpp_gmsagc_press_list', { name: query }), function (data) {
            process(data);
        });
    }
});
$('#ngpp_gmsagcbundle_orderstype_material').typeahead({
    source: function (query, process) {
        $.get(Routing.generate('ngpp_gmsagc_materials_list', { name: query }), function (data) {
            process(data);
        });
    }
});