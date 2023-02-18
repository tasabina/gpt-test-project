<?php

namespace GptTestProject\GPTApplication;

final class GPTRequestHandler
{
    public const GPT_API_URL = 'https://api.openai.com/v1/completions';
    public const CONTENT_TYPE = 'application/json';

    /**
     * Secret key to get access to GPT-3 API
     */
    private static string $api_secret_key;

    public function __construct()
    {
        $this->gpt_api_token = getenv('GPT_SECRET_KEY');
    }

    public function sendRequest(string $request): void
    {
        curl https://api.openai.com/v1/completions \
  -H 'Content-Type: application/json' \
  -H 'Authorization: Bearer YOUR_API_KEY' \
  -d '{
  "model": "text-davinci-003",
  "prompt": "Say this is a test",
  "max_tokens": 7,
  "temperature": 0
}'

    }




} 