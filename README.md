# OpenAI (GPT-3) test project

A small test project for working with OpenAI. It has two commands for chat and text translation.
The text for this description was translated using OpenAI from Russian to English.

## How to install
Run this composer command
```
composer require tasabina/gpt-test-project
```
Insert new environment variables to your `.env` file.
```
GPT_SECRET_KEY=YOUR_OPENAI_API_KEY
DEV_ENV=0
```
## Usage
- Run in console `vendor/bin/gptdemo chat` to communicate with GPT-3.
- Run in console `vendor/bin/gptdemo translate -l en` or `vendor/bin/gptdemo translate --language en` to translate phrase to English language.
- Run in console `vendor/bin/gptdemo translate -l fr` or `vendor/bin/gptdemo translate --language fr` to translate phrase to Franch language.
- Run in console `vendor/bin/gptdemo translate -l ru` or `vendor/bin/gptdemo translate --language ru` to translate phrase to Russian language.
