<?php

namespace GptTestProject\GPTApplication;

use Symfony\Component\Dotenv\Dotenv;

final class GPTRequestHandler
{
    public const GPT_API_URL = 'https://api.openai.com/v1/completions';
    public const CONTENT_TYPE_JSON = 'application/json';

    /**
     * Secret key to get access to GPT-3 API
     */
    private string $api_secret_key;

    public function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../../.env');

        $this->api_secret_key = $_ENV['GPT_SECRET_KEY'];
    }

    public function sendRequest(string $request): string
    {
        // $response = $this->prepareString($request);
        $curl_request = curl_init();
        $curl_options = [
            CURLOPT_URL => self::GPT_API_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->prepareString($request),
            CURLOPT_HTTPHEADER => [
                'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
                "Authorization: Bearer " . $this->api_secret_key ."",
                "Content-Type: ". self::CONTENT_TYPE_JSON ."",
            ],
        ];

        curl_setopt_array($curl_request, $curl_options);
        $response = curl_exec($curl_request);
        curl_close($curl_request);

        return $response;
    }

    private function prepareString(string $request): string
    {
        return json_encode(
            [
                "model" => "text-davinci-003",
                "prompt" => $request,
                "max_tokens" => 256,
                "temperature" => 0.5,
                'frequency_penalty' => 0,
                'presence_penalty' => 0.6,
                "stream" => false,
                "logprobs" => null,
                "stop" => ["\\n"],
            ]
        );     
    }
} 