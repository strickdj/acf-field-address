<?php


/**
 * Class ACFAddressPluginHelper
 */
class ACFAddressPluginHelper
{

  /**
   * AddressPlugin constructor.
   */
  public function __construct() {}

  public function get_assets_uri() {
    return ACF_ADDRESS_PLUGIN_URL . '/dist/';
  }

  /**
   * @return array
   */
  public function get_assets_manifest() {
    return (array) json_decode(file_get_contents($this->get_assets_manifest_path()));
  }

  /**
   * @return string
   */
  public function get_assets_manifest_path() {
    return ACF_ADDRESS_PLUGIN_PATH . 'dist/manifest.json';
  }

  /**
   * @param $value
   * @param $field
   *
   * @return string
   */
  public function valueToHtml( $value, $field ) {

    $html = '';

    $layout = json_decode( $field['address_layout'] );

    $options = json_decode( $field['address_options'] );

    $value = array_filter($value);

    if(empty($value)) {
      return $html;
    }

    $html .= "<div class='sim_address_field'>";

    foreach ( $layout as $rowIndex => $row ) {

      if ( empty( $row ) ) {
        continue;
      }

      $html .= "<div class='sim_address_row'>";

      foreach ( $row as $colIndex => $item ) {

        $key = $item->id;

        $html .= sprintf( "<span class='%s'>", $options->{$key}->cssClass );

        $html .= isset($value[ $key ]) ? $value[ $key ] : '';

        if ( $options->{$key}->separator !== '' ) {
          $html .= $options->{$key}->separator;
        }

        $html .= "</span> ";

      }

      $html .= "</div>";

    }

    $html .= "</div>";

    return $html;
  }

  /**
   * @param $value
   *
   * @return array|mixed
   */
  public function valueToObject( $value ) {
    return json_decode( json_encode( $value ) );
  }

  /**
   * @param $value
   *
   * @return mixed
   */
  public function valueToArray( $value ) {
    return $value;
  }

  /**
   * @param $old_layout
   * @return array
   */
  public function transform_layout( $old_layout ) {

    $map = array(
      'address1'    => 'street1',
      'address2'    => 'street2',
      'address3'    => 'street3',
      'city'        => 'city',
      'state'       => 'state',
      'postal_code' => 'zip',
      'country'     => 'country',
    );

    $labelMap = array(
      'street1' => 'Street 1',
      'street2' => 'Street 2',
      'street3' => 'Street 3',
      'city'    => 'City',
      'state'   => 'State',
      'zip'     => 'Postal Code',
      'country' => 'Country',
    );

    $target = array();

    $i = 0;
    foreach ( $old_layout as $row ) {

      foreach ( $row as $item ) {
        $o              = new stdClass();
        $o->id          = $map[ $item ];
        $o->label       = $labelMap[ $map[ $item ] ];
        $target[ $i ][] = $o;
      }

      $i ++;

    }

    if ( count( $target ) < 5 ) {

      while ( count( $target ) < 5 ) {
        $target[] = array();
      }

    }

    return $target;

  }

  /**
   * @param $old_options
   * @return array|mixed|object
   */
  public function transform_options( $old_options ) {

    $map = array(
      'street1' => array(
        'id'           => 'street1',
        'label'        => $old_options['address1']['label'] ?: '',
        'defaultValue' => $old_options['address1']['default_value'] ?: '',
        'enabled'      => $old_options['address1']['enabled'] ? true : false,
        'cssClass'     => $old_options['address1']['class'] ?: '',
        'separator'    => $old_options['address1']['separator'] ?: '',
      ),
      'street2' => array(
        'id'           => 'street2',
        'label'        => $old_options['address2']['label'] ?: '',
        'defaultValue' => $old_options['address2']['default_value'] ?: '',
        'enabled'      => $old_options['address2']['enabled'] ? true : false,
        'cssClass'     => $old_options['address2']['class'] ?: '',
        'separator'    => $old_options['address2']['separator'] ?: '',
      ),
      'street3' => array(
        'id'           => 'street3',
        'label'        => $old_options['address3']['label'] ?: '',
        'defaultValue' => $old_options['address3']['default_value'] ?: '',
        'enabled'      => $old_options['address3']['enabled'] ? true : false,
        'cssClass'     => $old_options['address3']['class'] ?: '',
        'separator'    => $old_options['address3']['separator'] ?: '',
      ),
      'city'    => array(
        'id'           => 'city',
        'label'        => $old_options['city']['label'] ?: '',
        'defaultValue' => $old_options['city']['default_value'] ?: '',
        'enabled'      => $old_options['city']['enabled'] ? true : false,
        'cssClass'     => $old_options['city']['class'] ?: '',
        'separator'    => $old_options['city']['separator'] ?: '',
      ),
      'state'   => array(
        'id'           => 'state',
        'label'        => $old_options['state']['label'] ?: '',
        'defaultValue' => $old_options['state']['default_value'] ?: '',
        'enabled'      => $old_options['state']['enabled'] ? true : false,
        'cssClass'     => $old_options['state']['class'] ?: '',
        'separator'    => $old_options['state']['separator'] ?: '',
      ),
      'zip'     => array(
        'id'           => 'zip',
        'label'        => $old_options['postal_code']['label'] ?: '',
        'defaultValue' => $old_options['postal_code']['default_value'] ?: '',
        'enabled'      => $old_options['postal_code']['enabled'] ? true : false,
        'cssClass'     => $old_options['postal_code']['class'] ?: '',
        'separator'    => $old_options['postal_code']['separator'] ?: '',
      ),
      'country' => array(
        'id'           => 'country',
        'label'        => $old_options['country']['label'] ?: '',
        'defaultValue' => $old_options['country']['default_value'] ?: '',
        'enabled'      => $old_options['country']['enabled'] ? true : false,
        'cssClass'     => $old_options['country']['class'] ?: '',
        'separator'    => $old_options['country']['separator'] ?: '',
      ),
    );

    return json_decode( json_encode( $map ) );

  }

}
