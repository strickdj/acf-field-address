jQuery(document).ready(function($) {
  // todo init
  $('.acfAddressWidget').acfAddressWidget();
  if (typeof acf.add_action !== 'undefined') {
    acf.add_action('append', function($el) {
      $('.acfAddressWidget').acfAddressWidget();
    });
  }
});
