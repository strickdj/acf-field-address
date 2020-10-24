require('../scss/render_field_options.scss')

jQuery(document).ready(function ($) {
  let acf = window.acf

  // todo init
  $('.acfAddressWidget').acfAddressWidget()
  if (typeof acf.add_action !== 'undefined') {
    acf.add_action('append', function () {
      $('.acfAddressWidget').acfAddressWidget()
    })
  }
})
