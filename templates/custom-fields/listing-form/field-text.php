<?php
/**
 * The Template for field text input form
 *
 * This template can be overridden by copying it to yourtheme/marketengine/custom-fields/listing-form/field-text.php.
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
<?php if($field) :?>
<div class="marketengine-group-field">
	<div class="marketengine-input-field">
	    <?php marketengine_get_template('custom-fields/listing-form/field-label', array('field' => $field));  ?>
	    <input <?php //echo marketengine_field_attribute($field); ?> id="<?php echo $field['field_name'] ?>" type="text" placeholder="<?php echo $field['field_placeholder'] ?>" name="<?php echo $field['field_name'] ?>" value="<?php echo $value; ?>" >
	</div>
</div>
<?php endif; ?>