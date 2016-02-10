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

    $html .= "<div class='sim_address_field'>";

    foreach ( $layout as $rowIndex => $row ) {

      if ( empty( $row ) ) {
        continue;
      }

      $html .= "<div class='sim_address_row'>";

      foreach ( $row as $colIndex => $item ) {

        $key = $item->id;

        $html .= sprintf( "<span class='%s'>", $options->{$key}->cssClass );

        $html .= $value[ $key ];

        if ( $options->{$key}->separator !== '' ) {
          $html .= $options->{$key}->separator;
        }

        $html .= "</span>";

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


}
