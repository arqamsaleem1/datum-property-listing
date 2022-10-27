<?php

/**
 * Template Name: Datum Property Listing
 */

get_header();
global $wpdb;
$table_name = $wpdb->prefix . 'datum_property_listing';
$query = "SELECT * FROM $table_name";
$results = $wpdb->get_results($query);
$db_min_price = $wpdb->get_var( "SELECT MIN(price) FROM $table_name" );
$db_max_price = $wpdb->get_var( "SELECT MAX(price) FROM $table_name" );
?>

<div class="dpl-wrap property-listing-wrap">
    <div class="dpl-property-filters">
        <!-- <div class="head">
            <h2>Filter Products</h2>
        </div> -->
        <form name="dpl-filter-form" id="dpl-filter-form" class="dpl-form">
            <div class="dpl-row">
                <div class="dpl-col-3">
                    <label for="name"><?php esc_html_e( 'Name', 'datum-property-listing' ) ?></label>
                    <input type="text" name="name" class="input-field text-field">
                </div>
                <div class="dpl-col-3">
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
                <div class="dpl-col-3">
                    <div class="field-group">
                        <label for="district"><?php esc_html_e( 'District', 'datum-property-listing' ) ?></label>
                        <select name="district" class="select-field type-field" placeholder="Select Type">
                            <option value="" disabled selected>Select District</option>
                            <?php $districts = array();
                            foreach ( $results as $key => $value ) : ?>
                                <?php if ( !in_array( $value->district, $districts ) ) : ?>
                                    <option value="<?php echo esc_attr( $value->district ); ?>">
                                        <?php echo esc_html( $value->district ); ?>
                                    </option>
                            <?php
                                endif;
                                array_push($districts, $value->district);
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="dpl-col-3">
                    <div class="field-group">
                        <label for="price"><?php esc_html_e( 'Price', 'datum-property-listing' ) ?></label>
                        <div class="slider">
                            <div class="progress"></div>
                        </div>
                        <div class="range-input">
                            <input type="range" name="range-min" class="range-min" min="<?php echo esc_attr( $db_min_price ); ?>" max="<?php echo esc_attr( $db_max_price ); ?>" value="<?php echo esc_html( $db_min_price ); ?>" step="100">
                            <input type="range" name="range-max" class="range-max" min="<?php echo esc_attr( $db_min_price ); ?>" max="<?php echo esc_attr( $db_max_price ); ?>" value="<?php echo esc_html( $db_max_price ); ?>" step="100">
                        </div>
                        <div class="price-input">
                            <div class="field">
                                <input type="number" name="price-min" class="input-min" value="<?php echo esc_attr( $db_min_price ); ?>">
                            </div>
                            <div class="separator">to</div>
                            <div class="field">
                                <input type="number" name="price-max" class="input-max" value="<?php echo esc_attr( $db_max_price ); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="dpl-col-2">
                    <div class="btn-div">
                        <button type="button" id="dpl-filter-results" class="submit-btn"><?php //esc_html_e( 'Apply Filter', 'datum-property-listing' ) ?></button>
                    </div>
                </div> -->
            </div>
        </form>
    </div>
    <div class="dpl-main-content">
        <div class="container">
            <div class="dpl-row">
                <div class="dpl-col-6">
                    <div class="dpl-sidebar">
                        <div id="dpl-map" style="width: 100%; height: 100vh;"></div>
                    </div>
                </div>
                <div class="dpl-col-6">
                   <!--  <input type="hidden" id="db_min_price" value="<?php echo $db_min_price; ?>">
                    <input type="hidden" id="db_max_price" value="<?php echo $db_max_price; ?>"> -->
                    <div class="dpl-listing">
                        <div class="dpl-row">
                            <input type="hidden" id="currentPage" value="0">
                        </div>
                        <!-- <div class="dpl-pagination"></div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
