# ACF Address Field

An Advanced Custom Field. Adds an address field type. 

-----------------------

## Compatibility

This ACF field type is compatible with:

* ACF 5.3.4 and up
* ACF 4 (no longer supported)

## Installation

### via Composer
1. Add a line to your repositories array:
`{ "type": "git", "url": "https://github.com/strickdj/acf-field-address" }`
2. Add a line to your require block:
`"strickdj/acf-address": "dev-master"`
3. Run: `composer update`

### Manual

1. Copy the plugin folder into your `plugins` folder.
2. Activate the plugin via the plugins admin page.
3. Create a new field via ACF and select the Address type.

## Changelog
5.1.0 - Fixed bug preventing the creation of new Address fields.

  - Fixed bug rendering the field to html
  - Automated testing support
  - Build tools, gulp, webpack, es6, scss

5.0.6 - Now works properly with php >= 5.3

5.0.5 - Added composer support.

5.0.4 - Fixed problem with unicode characters

5.0.3 - Fixed issue with exported fields

5.0.2 - Added backwards compatibility with previously created fields.

5.0.1 - Switched the js files to minified ones.

5.0 - Refactored for ACF 5.0

4.0 - Refactored for AFC 4.0 and above
