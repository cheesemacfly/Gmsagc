// Autocomplete for press and materials
$('#ngpp_gmsagcbundle_orderstype_press').typeahead({
    name: 'ngpp_gmsagcbundle_orderstype_press_list',
    prefetch: { 
        url: Routing.generate('ngpp_gmsagc_ajax_press_list'),
        ttl: 3600 
    }
});
$('#ngpp_gmsagcbundle_orderstype_material').typeahead({
    name: 'ngpp_gmsagcbundle_orderstype_materials_list',
    prefetch: { 
        url: Routing.generate('ngpp_gmsagc_ajax_materials_list'), 
        ttl: 3600 
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