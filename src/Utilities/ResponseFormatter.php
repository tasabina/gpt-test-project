<?php

namespace GptTestProject\Utilities;

trait ResponseFormatter
{
    protected function responseFormat(string $data): string
    {
        $response = json_decode($data);
        return $response->choices[0]->text ?? "There is no results";
    }
}