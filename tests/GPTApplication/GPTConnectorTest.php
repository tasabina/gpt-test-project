<?php

namespace GptTestProject\Tests\Commands;

use GptTestProject\GPTApplication\GPTConnector;
use GptTestProject\Utilities\ResponseFormatter;
use PHPUnit\Framework\TestCase;

class GPTConnectorTest extends TestCase
{
    use ResponseFormatter;

    public function testSendRequest()
    {
        $connector = new GPTConnector();
        $response = $connector->sendRequest('Small test message.');

        $this->assertEquals('Mock data response', $this->responseFormat($response));
    }
}