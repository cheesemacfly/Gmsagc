// Get the div that holds the collection of addresses
var collectionAddressesHolder = $('div#ngpp_gmsagcbundle_contactstype_addresses');
// setup an "add an address" link
var $addAddressLink = $('<a href="#" class="btn btn-success btn-xs add_tag_link"><span class="glyphicon glyphicon-plus"></span> Ajouter une addresse</a>');
var $newAddressLinkDiv = $('<div></div>').append($addAddressLink);

$(document).ready(function() {
    // add a delete link to all of the existing tag form div elements
    $('div[id^="ngpp_gmsagcbundle_contactstype_addresses_"]').each(function() {
        addAddressFormDeleteLink($(this));
    });
    // add the "add an address" anchor the address div
    collectionAddressesHolder.append($newAddressLinkDiv);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionAddressesHolder.data('index', collectionAddressesHolder.find(':input').length);

    $addAddressLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new address form (see next code block)
        addAddressForm(collectionAddressesHolder, $newAddressLinkDiv);
    });
});
function addAddressForm(collectionAddressesHolder, $newLinkDiv) {
    // Get the data-prototype explained earlier
    var prototype = collectionAddressesHolder.data('prototype').replace(/__name__label__/g, '');

    // get the new index
    var index = collectionAddressesHolder.data('index');

    // increase the index with one for the next item
    collectionAddressesHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormDiv = $('<div></div>').append(prototype);
    $newLinkDiv.before($newFormDiv);
    // add a delete link to the new form
    addAddressFormDeleteLink($newFormDiv);
}
function addAddressFormDeleteLink($addressFormDiv) {
    var $removeFormA = $('<a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Supprimer cette addresse</a>');
    $addressFormDiv.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the div for the address form
        $addressFormDiv.remove();
    });
}