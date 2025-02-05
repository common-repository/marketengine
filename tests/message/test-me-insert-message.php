<?php
class Tests_ME_Insert_Message extends WP_UnitTestCase {
    public function __construct($factory = null) {
        parent::__construct($factory);
    }

    public function setUp() {
        $this->user_1 = self::factory()->user->create(array('role' => 'author'));
        $this->user_2 = self::factory()->user->create(array('role' => 'author'));
        wp_set_current_user($this->user_1);
        $defaults = array(
            'sender'                => $this->user_1,
            'receiver'              => $this->user_2,
            'post_content'          => 'Message Content',
            'post_content_filtered' => '',
            'post_title'            => 'Message Title',
            'post_excerpt'          => 'Message Excerpt',
            'post_status'           => 'sent',
            'post_type'             => 'inquiry',
            'post_password'         => '',
            'post_parent'           => 0,
            'guid'                  => '',
        );
        $this->message_data = $defaults;
    }

    public function test_insert_message_success() {
        $message_id = marketengine_insert_message($this->message_data, true);
        $this->assertInternalType("int", $message_id);
    }

    /**
     * Test Without sender input, user current user id
     */
    public function test_insert_message_with_empty_sender() {
        $message_data = $this->message_data;
        $message_data['sender'] = '';

        $message_id = marketengine_insert_message($message_data, true);
        $this->assertInternalType("int", $message_id);

        $message = marketengine_get_message($message_id);
        $this->assertEquals($this->user_1, $message->sender);
    }

    /**
     * Insert message when receiver is null
     */
    public function test_insert_message_with_empty_receiver() {
        $message_data = $this->message_data;
        $message_data['receiver'] = '';
        $message_id = marketengine_insert_message($message_data, true);
        $this->assertEquals(new WP_Error('empty_receiver', __('Receiver is empty.')), $message_id);
    }

    /**
     * Insert message with empty content
     */
    public function test_insert_message_with_empty_content() {
        $message_data = $this->message_data;
        $message_data['post_content'] = '';
        $message_id = marketengine_insert_message($message_data, true);
        $this->assertEquals(new WP_Error('empty_content', __('Content, title, and excerpt are empty.')), $message_id);
    }

    /**
     * Test user can not send message to himself
     */
    public function test_me_insert_message_to_me() {
        $message_data = $this->message_data;
        $message_data['receiver'] = $message_data['sender'];
        $message_id = marketengine_insert_message($message_data, true);
        $this->assertEquals(new WP_Error('send_to_yourself', __('You can not send message to your self.')), $message_id);
    }

}