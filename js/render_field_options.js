jQuery(document).ready(function($) {

  console.log('init');

  // Acf allows us to add an action to whenever it adds something to the dom
  // In this case we want to initialize our sortable ui when it loads our field markup
  if( typeof acf.add_action !== 'undefined' ) {
    acf.add_action('append', function( $el ){

      var $grid = $el.find('#sim_grid');

      // We are creating 5 linked sortable lists with jquery ui sortable
      var $sortables = $grid.find('.sim_grid_row');

      $sortables.sortable({
        connectWith: ".sim_grid_row"
      }).disableSelection();


      // We need to do something every time a checkbox in our settings area is checked
      var $addressPartsCheckboxes = $el.find('input[type="checkbox"]');

      $addressPartsCheckboxes.on('change', function(e) {

        var enabled = e.target.checked;

        console.log( e.target.value );


      });


    });
  }

});
