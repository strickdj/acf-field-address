require('../scss/render_field.scss')

jQuery(document).ready(function ($) {
  let $addressWidget = $('.acf-address-field')

  $addressWidget.each(function (index, element) {
    let $el = $(element),
      name = $el.data('name'),
      value = $el.data('value'),
      layout = $el.data('layout'),
      options = $el.data('options')

    value = $.extend({
      street1: null,
      street2: null,
      street3: null,
      city: null,
      state: null,
      zip: null,
      country: null
    }, value)

    $.each(layout, function (rowIndex, row) {
      let $ul = $('<ul/>')
      $.each(row, function (col, obj) {
        let $li = $('<li/>')
        let propName = name + '[' + obj.id + ']'
        $li.append($('<label/>')
          .prop('for', propName)
          .text(options[obj.id].label))

        $li.append($('<input type="text"/>')
            .prop('name', propName)
            .prop('value', value[obj.id])
            .prop('placeholder', options[obj.id].defaultValue)
        )
        $ul.append($li)
      })
      $el.append($ul)
    })
  })
})
