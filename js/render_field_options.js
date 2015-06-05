jQuery(document).ready(function ($) {

    // If our widgets are initially on the page we need to initialize them
    // todo init
    $('.acfAddressWidget').acfAddressWidget();


    // Acf allows us to add an action to whenever it adds something to the dom
    // In this case we want to initialize our sortable ui when it loads our field markup
    if (typeof acf.add_action !== 'undefined') {
        acf.add_action('append', function ($el) {

            $('.acfAddressWidget').acfAddressWidget();

        });
    }

});
