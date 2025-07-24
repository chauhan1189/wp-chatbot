<?php
/**
 * Plugin Name: WP ChatGPT Site Bot
 * Description: A site-specific ChatGPT bot with customizable prompts per site.
 * Version: 1.0.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

define('GPT_CHATBOT_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Include files
require_once GPT_CHATBOT_PLUGIN_PATH . 'includes/chat-handler.php';
require_once GPT_CHATBOT_PLUGIN_PATH . 'admin/settings-page.php';

// Enqueue scripts
function gpt_chatbot_enqueue_assets() {
    wp_enqueue_style('gpt-chatbox-css', plugins_url('public/chatbox.css', __FILE__));
    wp_enqueue_script('gpt-chatbox-js', plugins_url('public/chatbox.js', __FILE__), ['jquery'], null, true);
    wp_localize_script('gpt-chatbox-js', 'gptChatbot', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('gpt_chat_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'gpt_chatbot_enqueue_assets');

// Shortcode
function gpt_chatbot_display_chatbox() {
    ob_start(); ?>
    <div class="gpt-chatbox">
        <div id="gpt-chat-output"></div>
        <textarea id="gpt-chat-input" placeholder="Ask something..."></textarea>
        <button id="gpt-chat-send">Send</button>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('gpt_chatbox', 'gpt_chatbot_display_chatbox');
