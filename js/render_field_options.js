jQuery(document).ready(function($) {

  console.log('init');

  // Acf allows us to add an action to whenever it adds something to the dom
  // In this case we want to initialize our sortable ui when it loads our field markup
  if( typeof acf.add_action !== 'undefined' ) {
    acf.add_action('append', function( $el ){

      // We are creating 5 linked sortable lists with jquery ui sortable
      var $sortables = $el.find('.sim_sortable');

      $(".gridster ul").gridster({
        widget_margins: [10, 10],
        widget_base_dimensions: [45, 32],
        max_cols: 6,
        avoid_overlapped_widgets: true,
        autogenerate_stylesheet: true,
        widget_selector: 'li',
        helper: 'clone',
        min_rows: 5,
        resize: {
          enabled: true
        }
      });


      // We need to do something every time a checkbox in our settings area is checked
      var $addressPartsCheckboxes = $el.find('input[type="checkbox"]');

      $addressPartsCheckboxes.on('change', function(e) {

        var enabled = e.target.checked;

        console.log( e.target.value );


      });


    });
  }

});
