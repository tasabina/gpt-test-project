<?php

namespace GptTestProject\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BaseCLI extends Command
{
    protected function responseFormat(string $data): string
    {
        $response = json_decode($data);
        return $response->choices[0]->text ?? "There is no results";
    }
}