jQuery(document).ready(function($) {

  console.log('init');

  // Acf allows us to add an action to whenever it adds something to the dom
  // In this case we want to initialize our sortable ui when it loads our field markup
  if( typeof acf.add_action !== 'undefined' ) {
    acf.add_action('append', function( $el ){

      // We are creating 5 linked sortable lists with jquery ui sortable

      // Get a reference to our sortable lists "ul" elements
      var $sortables = $el.find('.sim_grid_row');

      // create a container that will hold the positions of all the grid elements
      var positions = {};


      var setGridPositions = function() {

        $('.sim_grid_row').each(function(rowIndex, row) {

          $(row).find('li').each(function(col, item) {

            // convert item to a jQuery object and store it so we can use it later
            var $item = $(item);

            // create a position object that holds the row and column values
            var position = {
              col: col,
              row: rowIndex
            };

            // set the data properties col and row to the corresponding values
            // note: jQuery.data() does not update the dom with the values
            // it only updates the internal jQuery object
            $item.data(position);

            // save the position of this element in our positions container
            positions[$item.data('item')] = position;

          });

        });

        $('#sim_layout_position').attr('value', JSON.stringify(positions));

      };

      // initialize grid positions
      setGridPositions();

      // Declare them as sortable widgets
      // the connectWith property allows us to link them together
      // the stop property is a function callback that is called whenever the sorting event ends
      $sortables.sortable({
        connectWith: ".sim_grid_row",
        stop: setGridPositions
      }).disableSelection(); // we dont want the sortable elements to be selectable


      // We need to add or remove the items based on their enabled status
      var $addressPartsCheckboxes = $el.find('input[type="checkbox"]');

      var $detachedEls = {};

      $addressPartsCheckboxes.on('change', function(e) {

        var enabled = e.target.checked;

        var detachedKey = e.target.value;


        if ( enabled ) {

          // we want to instatiate the dom element and put back in the dom

          console.log('adding element to dom');

          // check to see if its in the $detachedEls object
          if ( $detachedEls.hasOwnProperty(detachedKey) ) {
            // used the saved one
            console.log('use saved element');

            $sortables.last().append($detachedEls[detachedKey]);

          } else {
            // create the element from scratch
            console.log('creating element from scratch');
          }


        } else {

          // we want to remove the element and store it for later
          $sortables.find('li').each(function (index, el) {

            var $el = $(el);

            if( $el.data('item') === detachedKey ) {
              $detachedEls[detachedKey] = $el;
              $el.detach();
            }

          });

        }


      });


    });
  }

});
