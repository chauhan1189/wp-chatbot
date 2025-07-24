<?php
function gpt_chatbot_register_settings_page() {
    add_options_page('GPT ChatBot Settings', 'GPT ChatBot', 'manage_options', 'gpt-chatbot', 'gpt_chatbot_render_settings');
}
add_action('admin_menu', 'gpt_chatbot_register_settings_page');

function gpt_chatbot_render_settings() {
    ?>
    <div class="wrap">
        <h1>ChatGPT Bot Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('gpt_chatbot_settings');
            do_settings_sections('gpt-chatbot');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function gpt_chatbot_register_settings() {
    register_setting('gpt_chatbot_settings', 'gpt_chatbot_prompt', [
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    register_setting('gpt_chatbot_settings', 'gpt_chatbot_api_key', [
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    add_settings_section('gpt_chatbot_main', '', null, 'gpt-chatbot');

    add_settings_field('gpt_chatbot_prompt', 'Custom Prompt', function() {
        $value = get_option('gpt_chatbot_prompt', '');
        echo "<textarea name='gpt_chatbot_prompt' rows='6' cols='60'>" . esc_textarea($value) . "</textarea>";
    }, 'gpt-chatbot', 'gpt_chatbot_main');

    add_settings_field('gpt_chatbot_api_key', 'OpenAI API Key', function() {
        $value = get_option('gpt_chatbot_api_key', '');
        echo "<input type='text' name='gpt_chatbot_api_key' value='" . esc_attr($value) . "' size='60' />";
    }, 'gpt-chatbot', 'gpt_chatbot_main');
}
add_action('admin_init', 'gpt_chatbot_register_settings');
