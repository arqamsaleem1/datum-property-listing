<?php
/**
 * Import Property listing page view
 *
 * This file displays a form to import property listings through a CSV file.
 *
 * @link       https://arqamsaleem.wordpress.com
 * @since      1.0.0
 *
 * @package    Datum_Property_Listing
 * @subpackage Datum_Property_Listing/admin/partials
 */
?>

<div id="dpl-wrapper" class="datum-property-listing-area import-page-wrapper">
    <div class="row">
        <div class="col-8">
            <div class="csv-upload">
                <form name="datum-csv-upload" method="post" action="" id="datum-csv-upload" class="form" enctype="multipart/form-data">
                    <div class="field-group">
                        <label for="upload-csv"><?php esc_html_e( 'Upload CSV file', 'datum-property-listing' ) ?></label>
                        
                        <input type="file" name="upload-csv" class="input-field">
                    </div>
                    <div class="btn-div">
                        <button type="button" name="import-submit" id="datum-csv-submit" class="submit-btn">
                            <?php esc_html_e( 'Import', 'datum-property-listing' ) ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-4">
            <div class="dpl-form-sidebar">
                <p><strong><?php esc_html_e( 'Please follow these instructions while preparing csv file:', 'datum-property-listing' ) ?></strong></p>
                <ul>
                    <li><?php esc_html_e( 'Top row should be the header row, it will be ignored while importing data.', 'datum-property-listing' ) ?></li>
                    <li><?php esc_html_e( 'First column should be id or serial number column, it will be ignored during the import.', 'datum-property-listing' ) ?></li>
                    <li><?php esc_html_e( 'Your columns order should be this.', 'datum-property-listing' ) ?>
                        <ul>
                            <li><?php esc_html_e( 'Id', 'datum-property-listing' ) ?></li> 	
                            <li><?php esc_html_e( 'Name', 'datum-property-listing' ) ?></li> 	
                            <li><?php esc_html_e( 'Type: one of these [land, home, condos, business, commercial]', 'datum-property-listing' ) ?></li>	
                            <li><?php esc_html_e( 'Price (Numeric value)', 'datum-property-listing' ) ?></li>	
                            <li><?php esc_html_e( 'District', 'datum-property-listing' ) ?></li>
                            <li><?php esc_html_e( 'Latitude (Numeric value)', 'datum-property-listing' ) ?></li>
                            <li><?php esc_html_e( 'Longitude (Numeric value)', 'datum-property-listing' ) ?></li>
                            <li><?php esc_html_e( 'Picture (Should be a URL)', 'datum-property-listing' ) ?></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>