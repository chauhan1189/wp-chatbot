# WP ChatGPT Site Bot

A custom WordPress plugin that integrates OpenAI's ChatGPT into your website with a configurable site-specific prompt. This allows the chatbot to respond with domain-specific knowledge tailored to each site — whether it's about shoes, books, or anything else.

---

## 🧠 Features

- 📝 Define a custom prompt per website (admin settings page).
- 🤖 Ask ChatGPT questions from the frontend via AJAX.
- 🔐 Secure, nonce-protected API requests.
- ⚙️ Uses OpenAI's GPT-3.5 model.
- 💬 Shortcode-based integration: `[gpt_chatbox]`
- 🎨 Basic but clean UI (customizable via CSS).

---

## 🚀 Installation

1. Download the ZIP or clone the repo:
   git clone https://github.com/chauhan1189/wp-chatbot.git
2. Upload the folder to your WordPress site's /wp-content/plugins/ directory.
3. Activate the plugin via Plugins > Installed Plugins.
4. Go to Settings > GPT ChatBot and:
   Set your OpenAI API Key
   Enter your custom System Prompt (site-specific)
5. it will start showing a floating chat icon at the bottom right.

## ⚙️ Configuration
API Key: Required for connection to OpenAI.

Prompt: Customize the behavior of ChatGPT per site. Example:
You are a helpful assistant who only talks about premium sports shoes.
