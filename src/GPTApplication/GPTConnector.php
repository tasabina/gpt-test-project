<?php

namespace GptTestProject\GPTApplication;

use Exception;
use GptTestProject\Providers\EnvironmentProvider;
use stdClass;

final class GPTConnector
{
    use EnvironmentProvider;

    public const GPT_API_URL = 'https://api.openai.com/v1/completions';
    public const CONTENT_TYPE_JSON = 'application/json';

    /**
     * Secret key to get access to GPT-3 API
     */
    private string $api_secret_key;

    public function __construct()
    {
        $this->api_secret_key = $this->getEnvironmentVariable('GPT_SECRET_KEY');
    }

    /**
     * @throws Exception if $api_secret_key wasn't set.
     */
    public function sendRequest(string $request): string
    {
        if (is_null($this->api_secret_key)) {
            throw new Exception('NULL is unexpected. API secret key should be valid string value.');
        }

        if ($this->getEnvironmentVariable('DEV_ENV') === "true") {
            return $this->getMockData();
        }

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

    public function getMockData()
    {
        $response = new stdClass();
        $response->text = 'Mock data response';

        $obj = new stdClass();
        $obj->choices[] = $response;

        return json_encode($obj);
    }
} 