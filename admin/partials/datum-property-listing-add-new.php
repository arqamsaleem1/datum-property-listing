<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://arqamsaleem.wordpress.com
 * @since      1.0.0
 *
 * @package    Datum_Property_Listing
 * @subpackage Datum_Property_Listing/admin/partials
 */
?>

<div id="dpl-wrapper" class="datum-property-listing-area">
    <h3><?php esc_html_e( 'Add your property here', 'datum-property-listing' ); ?></h3>
    <form name="datum-property-listing" class="form">
        <div class="error-notices">
            <ul></ul>
        </div>
        <div class="field-group">
            <div class="row">
                <div class="col">
                    <label for="name"><?php esc_html_e( 'Name', 'datum-property-listing' ) ?></label>
                    <input type="text" name="name" class="input-field text-field">
                </div>
                <div class="col">
                    <label for="type"><?php esc_html_e( 'Type', 'datum-property-listing' ) ?></label>
                    <select name="type" class="select-field type-field" placeholder="Select Type">
                        <option value="" disabled selected>Select Type</option>
                        <!--
                            If you are going to update these options, then please 
                            don't forget update them in Datum_Property_Listing class
                            at validate_form_data function, in $allowed_types variable.
                        -->
                        <option value="land"><?php esc_html_e( 'Land', 'datum-property-listing' ) ?></option>
                        <option value="home"><?php esc_html_e( 'Home', 'datum-property-listing' ) ?></option>
                        <option value="condos"><?php esc_html_e( 'Condos', 'datum-property-listing' ) ?></option>
                        <option value="business"><?php esc_html_e( 'Business', 'datum-property-listing' ) ?></option>
                        <option value="commercial"><?php esc_html_e( 'Commercial', 'datum-property-listing' ) ?></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="field-group">
            <label for="price"><?php esc_html_e( 'Price', 'datum-property-listing' ) ?></label>
            <input type="number" name="price" class="input-field number-field">
        </div>
        <div class="field-group">
            <label for="district"><?php esc_html_e( 'District', 'datum-property-listing' ) ?></label>
            <input type="text" name="district" class="input-field district-field">
        </div>
        <div class="field-group">
            <fieldset>
                <legend>Location:</legend>
                <div class="row">
                    <div class="col">
                        <label for="latitude"><?php esc_html_e( 'Latitude', 'datum-property-listing' ) ?></label>
                        <input type="number" name="latitude" class="input-field number-field">
                    </div>
                    <div class="col">
                        <label for="longitude"><?php esc_html_e( 'Longitude', 'datum-property-listing' ) ?></label>
                        <input type="number" name="longitude" class="input-field number-field">
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="field-group">
            <label for="district"><?php esc_html_e( 'Upload Picture', 'datum-property-listing' ) ?></label>
            <input type="hidden" name="dpl_picture_url" id="dpl_picture_url" class="input-field">
            <input type="button" name="dpl-picture-upload-btn" id="dpl-picture-upload-btn" class="button-secondary" value="Upload Image">
        </div>
        <div class="btn-div">
            <button type="button" id="datum-property-listing-submit" class="submit-btn"><?php esc_html_e( 'Submit', 'datum-property-listing' ) ?></button>
        </div>
    </form>

<?php
// jQuery
wp_enqueue_script('jquery');
// This will enqueue the Media Uploader script
wp_enqueue_media();
?>