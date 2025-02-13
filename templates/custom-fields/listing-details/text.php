<?php
/**
 * The Template for listing custom field single value
 *
 * This template can be overridden by copying it to yourtheme/marketengine/custom-fields/listing-details/text.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 *
 * @since 		1.0.1
 *
 * @version     1.0.0
 *
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

?>
<div class="me-row">
	<div class="me-col-sm-3">
		<div class="me-cf-title">
			<p><?php echo esc_html( $field['field_title'] ); ?></p>
			<span><?php echo esc_js( $field['field_description'] ); ?></span>
		</div>
	</div>
	<div class="me-col-sm-9">
		<div class="me-cf-content">
			<p><?php echo esc_html( $value ); ?></p>
		</div>
	</div>
</div>