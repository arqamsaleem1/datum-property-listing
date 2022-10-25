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
    <h3><?php esc_html_e( 'All Properties Listing', 'datum-property-listing' ); ?></h3>
    <div class="dpl-table-wrap dpl-entries-div">
        <div class="table-header-row">
            <div class="row header-row">
                <div class="col">
                    <?php esc_html_e( 'Name', 'datum-property-listing' ); ?>
                </div>
                <div class="col">
                    <?php esc_html_e( 'Type', 'datum-property-listing' ); ?>
                </div>
                <div class="col">
                    <?php esc_html_e( 'Price', 'datum-property-listing' ); ?>
                </div>
                <div class="col">
                    <?php esc_html_e( 'District', 'datum-property-listing' ); ?>
                </div>
                <div class="col">
                    <?php esc_html_e( 'Actions', 'datum-property-listing' ); ?>
                </div>
            </div>
        </div>
        <div class="table-body">
            <?php foreach ( $args['entries'] as $row ): ?>
            <div class="row">
                <div class="col">
                    <span><?php esc_html_e( $row->name, 'datum-property-listing' ); ?></span>
                </div>
                <div class="col">
                    <span><?php esc_html_e( $row->type, 'datum-property-listing' ); ?></span>
                </div>
                <div class="col">
                    <span><?php esc_html_e( $row->price, 'datum-property-listing' ); ?></span>
                </div>
                <div class="col">
                    <span><?php esc_html_e( $row->district, 'datum-property-listing' ); ?></span>
                </div>
                <div class="col actions">
                    <button type="button" name="edit-btn" id="edit-property-btn" data-entry-id="<?php echo esc_attr( $row->id ); ?>" class="action-btn button-secondary" >
                        <?php esc_html_e( 'Edit', 'datum-property-listing' ) ?>
                    </button>
                    <button type="button" name="delete-btn" id="delete-property-btn" data-entry-id="<?php echo esc_attr( $row->id ); ?>" class="action-btn button-secondary">
                        <?php esc_html_e( 'Delete', 'datum-property-listing' ) ?>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="dpl-pagination" style="display: none;">
            <?php
            for($page = 1; $page<= $args['total_number_of_pages']; $page++) {

                echo "<a href='?post=$page' class='page-nav' data-page-number='$page'> $page </a>";  
            }  
        ?>
        </div>
    </div>
    <div id="update-form-area" class="update-form-area">
        <h3><?php esc_html_e( 'Update property here', 'datum-property-listing' ); ?></h3>
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
                            <option value="" disabled selected><?php esc_html_e( 'Select Type', 'datum-property-listing' ) ?></option>
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
                            <label for="longitude"><?php esc_html_e( 'Longitude', 'datum-property-listing' ) ?></label>
                            <input type="number" name="longitude" class="input-field number-field">
                        </div>
                        <div class="col">
                            <label for="latitude"><?php esc_html_e( 'Latitude', 'datum-property-listing' ) ?></label>
                            <input type="number" name="latitude" class="input-field number-field">
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="dpl-image-thumb"></div>
            <div class="field-group">
                <label for="dpl_picture_url"><?php esc_html_e( 'Upload Picture', 'datum-property-listing' ) ?></label>
                <input type="hidden" name="dpl_picture_url" id="dpl_picture_url" class="input-field">
                <input type="button" name="dpl-picture-upload-btn" id="dpl-picture-upload-btn" class="button-secondary" value="Upload Image">
            </div>
            <input type="hidden" name="property_id" value="">
            <div class="btn-div">
                <button type="button" id="datum-property-listing-update-submit" class="submit-btn"><?php esc_html_e( 'Submit', 'datum-property-listing' ) ?></button>
            </div>
        </form>
    </div>
</div>

<?php
// jQuery
wp_enqueue_script('jquery');
// This will enqueue the Media Uploader script
wp_enqueue_media();
?>