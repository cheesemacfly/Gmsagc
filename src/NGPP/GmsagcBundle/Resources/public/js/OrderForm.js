//Manage date type input on older browsers
if (!Modernizr.inputtypes.date) {
    $("input[type='date']").datepicker({ dateFormat: 'yy-mm-dd' });
}

//Autocomplete for press and materials
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

//Manage relations
// Get the div that holds the collection of relations
var collectionRelationsHolder = $('div#ngpp_gmsagcbundle_orderstype_relations');
// setup an "add a relation" link
var $addRelationLink = $('<a href="#" class="btn add_tag_link">Add a relation</a>');
var $newRelationLinkDiv = $('<div></div>').append($addRelationLink);

jQuery(document).ready(function() {
    // add a delete link to all of the existing tag form div elements
    $('div[id^="ngpp_gmsagcbundle_orderstype_relations_"]').each(function() {
        addRelationFormDeleteLink($(this));
    });
    // add the "add a relation" anchor the relation div
    collectionRelationsHolder.append($newRelationLinkDiv);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionRelationsHolder.data('index', collectionRelationsHolder.find(':input').length);

    $addRelationLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new relation form (see next code block)
        addRelationForm(collectionRelationsHolder, $newRelationLinkDiv);
    });
});
function addRelationForm(collectionRelationsHolder, $newLinkDiv) {
    // Get the data-prototype explained earlier
    var prototype = collectionRelationsHolder.data('prototype');

    // get the new index
    var index = collectionRelationsHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__label__/g, 'Relation nb ' + (index + 1))
            .replace(/__name__/g, index);

    // increase the index with one for the next item
    collectionRelationsHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a relation" link li
    var $newFormDiv = $('<div></div>').append(newForm);
    $newLinkDiv.before($newFormDiv);
    // add a delete link to the new form
    addRelationFormDeleteLink($newFormDiv);
}
function addRelationFormDeleteLink($relationFormDiv) {
    var $removeFormA = $('<a href="#" class="btn">Delete this relation</a>');
    $relationFormDiv.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the div for the relation form
        $relationFormDiv.remove();
    });
}