(function ($) {

  //let defaults = require('./defaults.service')

  //defaults(window.jQuery)

  let widgetCount = 0

  // factory function for creating widget closures
  let makeLayout = function (options, $el) {

    // keeping track of multiple widgets
    widgetCount = widgetCount + 1

    // Widget Defaults
    let defaults = {
      layout: [
        [ { id: 'street1', label: 'Street 1' } ],
        [ { id: 'street2', label: 'Street 2' } ],
        [ { id: 'street3', label: 'Street 3' } ],
        [
          { id: 'city', label: 'City' },
          { id: 'state', label: 'State' },
          { id: 'zip', label: 'Postal Code' },
          { id: 'country', label: 'Country' }
        ],
        []
      ],
      rowClass: 'acf-address-' + widgetCount + '-row',
      sortableElement: 'li'
    }

    // merge defaults and passed arguments
    let settings = $.extend(defaults, options)

    let gridInfo = {
      $el: $el,
      layout: settings.layout,
      rowClass: settings.rowClass,
      sortableElement: settings.sortableElement,
      $inputElement: $('<input type="hidden">')
        .prop('name', 'acfAddressWidget[' + settings.fieldKey + '][address_layout]')
        .prop('value', JSON.stringify(settings.layout)),
      $detachedEls: {}
    }

    let setGridPositions = function () {

      let positions = []

      gridInfo.$el.find('.' + gridInfo.rowClass).each(function (rowIndex, row) {

        let r = []

        $(row).find(gridInfo.sortableElement).each(function (col, item) {

          let $item = $(item)

          r[col] = {
            id: $item.data().id,
            label: $item.data().label
          }

          // create a position object that holds the row and column values
          let position = {
            col: col,
            row: rowIndex
          }

          // set the data properties col and row to the corresponding values
          $item.data(position)

        })

        positions[rowIndex] = r

      })

      gridInfo.$inputElement.attr('value', JSON.stringify(positions))

    }

    let makeSortable = function ($el, options) {

      let settings = $.extend({
        stop: function () { // takes parameters event, ui
          setGridPositions()
        }
      }, options)

      return $el.sortable(settings).disableSelection()

    }


    let setSortableLabel = function (e) {
      let id = e.data.id,
        label = e.target.value

      if ($(e.target).data('col') === 'label') {
        gridInfo.$el.find('li').each(function (index, element) {
          $el = $(element)
          if ($el.data().id === id) {
            $el.data('label', label)
              .text(label)
          }
        })
      }
    }


    let toggleSortable = function (e) {

      let id = e.data.id,
        targetData = $(e.target).data(),
        $lastUl = gridInfo.$el.find('.' + gridInfo.rowClass).last()

      if (e.target.checked) {

        // check to see if its in the $detachedEls object
        if (gridInfo.$detachedEls.hasOwnProperty(id)) {
          // used the saved one
          $lastUl.append(gridInfo.$detachedEls[id])
        } else {
          // create the element from scratch
          $lastUl.append($('<li></li>')
            .data({
              id: targetData.id,
              label: targetData.label
            })
            .text(targetData.label))
        }

      } else {

        gridInfo.$el.find('li').each(function (index, element) {
          $el = $(element)
          if ($el.data().id === id) {
            gridInfo.$detachedEls[id] = $el
            $el.detach()
          }
        })

      }

      // update the layout input with changes
      setGridPositions()

    }

    let buildLayout = function () {

      gridInfo.$el.append(gridInfo.$inputElement)

      $(gridInfo.layout).each(function (row, items) {
        let $ul = $('<ul></ul>')
          .addClass(gridInfo.rowClass)
        gridInfo.$el.append($ul)

        makeSortable($ul, { connectWith: '.' + gridInfo.rowClass })

        $(items).each(function (col, obj) {
          $ul.append($('<li></li>')
            .data(obj)
            .text(obj.label)
            .attr('id', `${obj.id}-li-movable-${widgetCount}`))
        })

      })

    }

    buildLayout()

    // we need to return some functions
    return {
      onBlur: setSortableLabel,
      onCheck: toggleSortable
    }

  }

  let makeOptions = function (options, $el) {

    // Widget Defaults
    let defaults = {
      options: {
        street1: {
          id: 'street1',
          label: 'Street 1',
          defaultValue: '',
          enabled: true,
          cssClass: 'street1',
          separator: ''
        },
        street2: {
          id: 'street2',
          label: 'Street 2',
          defaultValue: '',
          enabled: true,
          cssClass: 'street2',
          separator: ''
        },
        street3: {
          id: 'street3',
          label: 'Street 3',
          defaultValue: '',
          enabled: true,
          cssClass: 'street3',
          separator: ''
        },
        city: { id: 'city', label: 'City', defaultValue: '', enabled: true, cssClass: 'city', separator: ',' },
        state: { id: 'state', label: 'State', defaultValue: '', enabled: true, cssClass: 'state', separator: '' },
        zip: { id: 'zip', label: 'Postal Code', defaultValue: '', enabled: true, cssClass: 'zip', separator: '' },
        country: {
          id: 'country',
          label: 'Country',
          defaultValue: '',
          enabled: true,
          cssClass: 'country',
          separator: ''
        }
      }
    }

    // merge defaults and passed arguments
    let settings = $.extend(defaults, options)

    // Add some functionality to the event methods
    function onBlurWithAfter(e) {
      settings.onBlur(e)
      afterOnEvent(e)
    }

    function onCheckWithAfter(e) {
      settings.onCheck(e)
      afterOnEvent(e)
    }

    // closure scope so its absolutely clear
    let self = {
      $element: $el,
      $inputElement: $('<input type="hidden">')
        .data('val', settings.options)
        .prop('value', JSON.stringify(settings.options))
        .prop('name', 'acfAddressWidget[' + settings.fieldKey + '][address_options]'),
      options: settings.options,
      onBlur: onBlurWithAfter,
      onCheck: onCheckWithAfter
    }

    function afterOnEvent(e) {

      let data = self.$inputElement.data()

      let col = $(e.target).data('col')

      if (e.type === 'change') {
        data.val[e.data.id][col] = e.target.checked
      } else {
        data.val[e.data.id][col] = e.target.value
      }

      self.$inputElement.data(data)

      self.$inputElement.prop('value', JSON.stringify(data.val))
    }

    let makeInput = function (type, value, data) {
      let $input = $('<input type="hidden">')
        .val(value)
        .data(data)

      if (type === 'checkbox') {
        $input.prop('type', 'checkbox')
          .prop('checked', value)
          .on('change', data, self.onCheck)
      }
      if (type === 'text') {
        $input.prop('type', 'text')
          .on('blur', data, self.onBlur)
      }

      return $input
    }

    let init = function () {

      self.$element.append(self.$inputElement)

      let $table = $('<table></table>')
      let $head = $('<tr></tr>')
        .append($('<th>Enabled</th>'))
        .append($('<th>Label</th>'))
        .append($('<th>Default Value</th>'))
        .append($('<th>Css Class</th>'))
        .append($('<th>Separator</th>'))

      $table.append($head)

      $.each(self.options, function (row, obj) {

        let $tr = $('<tr></tr>')

        let $tdEnabled = $('<td></td>').append(makeInput('checkbox', obj.enabled, obj).data('col', 'enabled').attr('id', `${obj.id}-${widgetCount}`))
        let $tdLabel = $('<td></td>').append(makeInput('text', obj.label, obj).data('col', 'label'))
        let $tdDefault = $('<td></td>').append(makeInput('text', obj.defaultValue, obj).data('col', 'defaultValue'))
        let $tdCssClass = $('<td></td>').append(makeInput('text', obj.cssClass, obj).data('col', 'cssClass'))
        let $tdSeparator = $('<td></td>').append(makeInput('text', obj.separator, obj).data('col', 'separator'))

        $tr.append($tdEnabled)
          .append($tdLabel)
          .append($tdDefault)
          .append($tdCssClass)
          .append($tdSeparator)

        $table.append($tr)
      })

      self.$element.append($table)

    }

    init()

    // in this case we will just return the jQuery object
    return self.$element

  }

  $.fn.acfAddressWidget = function (options) {

    let $this = $(this)

    let settings = $.extend({}, options)

    // Call our instance closure
    // to handle multiple elements
    $this.each(function (index, element) {

      let $element = $(element)

      if ($element.data('acfAddressWidgetized') === true) {
        return
      }

      $element.data('acfAddressWidgetized', true)

      let $optionsContainer = $('<div></div>').attr('id', 'options-container')
      let $layoutContainer = $('<div></div>').attr('id', 'layout-container')

      $element.append($optionsContainer)
        .append($layoutContainer)

      settings.fieldKey = $element.data('field')

      settings.layout = window.acfAddressWidgetData.address_layout

      settings.options = window.acfAddressWidgetData.address_options


      let lc = makeLayout(settings, $layoutContainer)

      settings.onBlur = lc.onBlur
      settings.onCheck = lc.onCheck
      makeOptions(settings, $optionsContainer)
    })

    return $this

  }

})(jQuery)
