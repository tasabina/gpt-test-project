<?php

namespace GptTestProject\Tests\Commands;

use GptTestProject\Commands\ChatCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ChatCommandTest extends TestCase
{
    public function testExecute()
    {
        $application = new Application();
        $application->add(new ChatCommand());

        $tester = new CommandTester($application->get('chat'));
        $tester->setInputs([
            'Return to me something',
            'yes',
            'Return to me something new',
            'no'
        ]);
        $tester->execute([]);

        $tester->assertCommandIsSuccessful();
    }
}