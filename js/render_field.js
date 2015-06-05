jQuery(document).ready(function ($) {
    console.log('in the right place.');

    var $addressWidget = $('.acf-address-field');

    $addressWidget.each(function (index, element) {

        var $el = $(element),
            name = $el.data('name'),
            value = $el.data('value'),
            layout = $el.data('layout'),
            options = $el.data('options');

        value = $.extend({
            street1: null,
            street2: null,
            street3: null,
            city: null,
            state: null,
            zip: null,
            country: null
        }, value);

        $.each(layout, function (rowIndex, row) {

            // loop through layout and render the input fields

            var $ul = $('<ul/>');

            $.each(row, function (col, obj) {

                var $li = $('<li/>');

                var propName = name + '[' + obj.id + ']';

                $li.append($('<label/>')
                    .prop('for', propName)
                    .text(options[obj.id].label));

                $li.append($('<input type="text"/>')
                        .prop('name', propName)
                        .prop('value', value[obj.id])
                        .prop('placeholder', options[obj.id].defaultValue)
                );

                $ul.append($li);

            });

            $el.append($ul);

        });

    });

});
