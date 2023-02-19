<?php

namespace GptTestProject\Tests\Commands;

use GptTestProject\Commands\ChatCLI;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandCompletionTester;

class ChatCLICommandTest extends TestCase
{
    public function testExecute()
    {
        $application = new Application();
        $application->add(new ChatCLI());

        $tester = new CommandCompletionTester($application->get('chat'));

        $suggestions = $tester->complete(['']);
        // $this->assertSame(['Fabien', 'Fabrice', 'Wouter'], $suggestions);

        $suggestions = $tester->complete(['Fa']);
        // $this->assertSame(['Fabien', 'Fabrice'], $suggestions);
    }
}