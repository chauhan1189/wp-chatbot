jQuery(document).ready(function ($) {
    $('#gpt-chat-launcher').click(function () {
        $('.gpt-chatbox-wrapper').fadeToggle();
    });

    $(document).on('click', '#gpt-chat-close', function () {
        $('.gpt-chatbox-wrapper').fadeOut();
    });

    $('#gpt-chat-send').click(function () {
        const message = $('#gpt-chat-input').val();
        if (!message.trim()) return;

        $('#gpt-chat-output').append(`<div class="user-msg">${message}</div>`);
        $('#gpt-chat-input').val('');

        $.post(gptChatbot.ajax_url, {
            action: 'gpt_chat_ask',
            nonce: gptChatbot.nonce,
            message: message
        }, function (response) {
            if (response.success) {
                $('#gpt-chat-output').append(`<div class="bot-msg">${response.data.reply}</div>`);
            } else {
                $('#gpt-chat-output').append(`<div class="bot-msg error">Error: ${response.data.error}</div>`);
            }
        });
    });
});
