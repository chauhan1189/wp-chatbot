<?php
add_action('wp_ajax_gpt_chat_ask', 'wp_chatbot_handle_query');
add_action('wp_ajax_nopriv_gpt_chat_ask', 'wp_chatbot_handle_query');

function wp_chatbot_handle_query() {
    check_ajax_referer('gpt_chat_nonce', 'nonce');

    $user_message = sanitize_text_field($_POST['message']);
    $api_key = get_option('gpt_chatbot_api_key');
    $system_prompt = get_option('gpt_chatbot_prompt', 'You are a helpful assistant.');

    if (empty($api_key)) {
        wp_send_json_error(['error' => 'OpenAI API key not configured.']);
    }

    $body = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'system', 'content' => $system_prompt],
            ['role' => 'user', 'content' => $user_message],
        ]
    ];

    $response = wp_remote_post('https://api.openai.com/v1/chat/completions', [
        'headers' => [
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type'  => 'application/json',
        ],
        'body' => json_encode($body),
    ]);

    if (is_wp_error($response)) {
        wp_send_json_error(['error' => 'Request to OpenAI failed.']);
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);
    $reply = $data['choices'][0]['message']['content'] ?? 'No reply from OpenAI.';

    wp_send_json_success(['reply' => $reply]);
}
