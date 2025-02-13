<?php
class Tests_ME_Create_Order extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
        $this->listing_category = new WP_UnitTest_Factory_For_Term($this, 'listing_category');
    }

    public function setUp() {
        $this->user_1 = self::factory()->user->create(array('role' => 'author'));
        $this->user_2 = self::factory()->user->create(array('role' => 'author'));
        wp_set_current_user($this->user_1);
        $this->order_data = array(
            //'post_author' => 10,
            'customer_note' => 'Order note',
        );
    }
    /**
     * @cover marketengine_insert_order()
     */
    public function test_create_order_author() {

        $order_id = marketengine_insert_order($this->order_data);

        $post = get_post($order_id);
        $this->assertEquals('me_order', $post->post_type);
        $this->assertEquals($this->user_1, $post->post_author);
        $this->assertEquals('me-pending', $post->post_status);
    }

    public function test_create_order_customer_note() {
        $order_id = marketengine_insert_order($this->order_data);
        $post     = get_post($order_id);
        $this->assertEquals('Order note', $post->post_excerpt);
    }

    public function test_create_order_key() {
        $order_id = marketengine_insert_order($this->order_data);
        $this->assertStringStartsWith('marketengine', get_post_meta($order_id, '_me_order_key', true));
    }

    public function test_create_order_currency_code() {
        add_filter('marketengine_currency_code', array($this, 'get_currency_code'), 9999);
        $order_id = marketengine_insert_order($this->order_data);
        $this->assertEquals('GBP', get_post_meta($order_id, '_order_currency_code', true));
        remove_filter('marketengine_currency_code', array($this, 'get_currency_code'), 9999);
    }

    public function get_currency_code($code) {
        return 'GBP';
    }
    //
}