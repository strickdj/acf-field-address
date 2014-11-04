# ACF Address Field

A field to hold an address: street, city, state, country

-----------------------

### Compatibility

This ACF field type is compatible with:

* ACF 5
* ACF 4

### Installation

1. Copy the `acf-FIELD_NAME` folder into your `wp-content/plugins` folder
2. Activate the FIELD_LABEL plugin via the plugins admin page
3. Create a new field via ACF and select the FIELD_LABEL type
4. Please refer to the description for more info regarding the field type settings


### Structure

* `/css`:  folder for .css files.
* `/images`: folder for image files
* `/js`: folder for .js files
* `/lang`: folder for .pot, .po and .mo files
* `acf-FIELD_NAME.php`: Main plugin file that includes the correct field file based on the ACF version
* `FIELD_NAME-v5.php`: Field class compatible with ACF version 5
* `FIELD_NAME-v4.php`: Field class compatible with ACF version 4
* `readme.txt`: WordPress readme file to be used by the wordpress repository

### Changelog
5.0.2 - Added backwards compatibility with previously created fields.

5.0.1 - Switched the js files to minified ones.

5.0 - Refactored for ACF 5.0

4.0 - Refactored for AFC 4.0 and above