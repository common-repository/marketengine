<?php
class Tests_Update_Field extends WP_UnitTestCase
{
    public function __construct($factory = null)
    {
        parent::__construct($factory);

    }

    public function setUp()
    {
        parent::setUp();
        $this->field_data = array(
            'field_name'          => 'field_1',
            'field_title'         => 'Field 1',
            'field_type'          => 'text',
            'field_input_type'    => 'string',
            'field_placeholder'   => 'Field 1',
            'field_description'   => '',
            'field_help_text'     => 'Field help text',
            'field_constraint'    => 'required',
            'field_default_value' => '0',
            'count'               => 0,
        );

        $result = marketengine_cf_insert_field($this->field_data, true);
        $this->field_id = $result;
        $this->field_data['field_id'] = $result;
    }
    public function tearDown() {
        parent::tearDown();
        global $wpdb;

        $field_table = $wpdb->prefix . 'marketengine_custom_fields';
        // delete field
        $deleted = $wpdb->query("DELETE FROM $field_table WHERE 1=1");
    }
    public function test_update_field_success()
    {
        $result = marketengine_cf_update_field($this->field_data, true);
        $this->assertEquals($this->field_id, $result);
    }

    public function test_update_change_field_type() {
        $this->field_data['field_type'] = 'number';

        $result = marketengine_cf_update_field($this->field_data, true);
        $this->assertEquals(new WP_Error('field_type_changed', 'The field type cannot change.'), $result);
    }
}
