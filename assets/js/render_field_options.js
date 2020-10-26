require('../scss/render_field_options.scss')

jQuery(document).ready(function ($) {
  let acf = window.acf

  if (typeof acf.addAction !== 'undefined') {
    acf.addAction('new_field/type=addyopts', function (field) {
      console.log('field', field)
      field.$el.find('.acfAddressWidget').acfAddressWidget({ field })
    })
  }
})
