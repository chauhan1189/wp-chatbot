<?php
/**
 * Plugin Name: WP Chatbot OpenAI
 * Description: A site-specific ChatGPT chatbot with enable/disable setting and floating UI.
 * Version: 1.1.0
 * Author: Mangat Singh
 * Update URI: false
 */

if (!defined('ABSPATH')) exit;

define('WP_CHATBOT_PLUGIN_PATH', plugin_dir_path(__FILE__));

require_once WP_CHATBOT_PLUGIN_PATH . 'includes/chat-handler.php';

// Register settings
function wp_chatbot_register_settings() {
    add_option('wp_chatbot_enabled', '0');
    add_option('gpt_chatbot_api_key', '');
    add_option('gpt_chatbot_prompt', 'You are a helpful assistant.');
    register_setting('wp_chatbot_options_group', 'wp_chatbot_enabled');
    register_setting('wp_chatbot_options_group', 'gpt_chatbot_api_key');
    register_setting('wp_chatbot_options_group', 'gpt_chatbot_prompt');
}
add_action('admin_init', 'wp_chatbot_register_settings');

// Admin menu
function wp_chatbot_register_options_page() {
    add_options_page('WP Chatbot Settings', 'WP Chatbot', 'manage_options', 'wp-chatbot', 'wp_chatbot_options_page');
}
add_action('admin_menu', 'wp_chatbot_register_options_page');

function wp_chatbot_options_page() {
?>
    <div class="wrap">
        <h1>WP Chatbot Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('wp_chatbot_options_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Enable Chatbot</th>
                    <td><input type="checkbox" name="wp_chatbot_enabled" value="1" <?php checked(1, get_option('wp_chatbot_enabled'), true); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">OpenAI API Key</th>
                    <td><input type="text" name="gpt_chatbot_api_key" value="<?php echo esc_attr(get_option('gpt_chatbot_api_key')); ?>" size="60" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">System Prompt</th>
                    <td><textarea name="gpt_chatbot_prompt" rows="4" cols="60"><?php echo esc_textarea(get_option('gpt_chatbot_prompt')); ?></textarea></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// Enqueue assets and render UI
function wp_chatbot_enqueue_assets() {
    if (!get_option('wp_chatbot_enabled')) return;

    wp_enqueue_style('wp-chatbot-style', plugins_url('public/chatbox.css', __FILE__));
    wp_enqueue_script('wp-chatbot-script', plugins_url('public/chatbox.js', __FILE__), ['jquery'], null, true);
    wp_localize_script('wp-chatbot-script', 'gptChatbot', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('gpt_chat_nonce')
    ]);

    echo '
    <div id="gpt-chat-launcher"><img src="' . plugins_url('public/chat-icon.png', __FILE__) . '" alt="Chat" /></div>
    <div class="gpt-chatbox-wrapper" style="display:none;">
        <div class="gpt-chatbox">
            <div id="gpt-chat-close">❌</div>
            <div id="gpt-chat-output"></div>
            <textarea id="gpt-chat-input" placeholder="Ask something..."></textarea>
            <button id="gpt-chat-send">Send</button>
        </div>
    </div>';
}
add_action('wp_footer', 'wp_chatbot_enqueue_assets');
