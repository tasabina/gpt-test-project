<?php

namespace GptTestProject\Tests\Commands;

use GptTestProject\Commands\TranslateCLI;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandCompletionTester;
use Symfony\Component\Console\Tester\CommandTester;

class TranslateCLICommandTest extends TestCase
{
    public function testExecute()
    {
        $application = new Application();
        $application->add(new TranslateCLI());

        $tester = new CommandTester($application->get('translate'));
        $tester->setInputs(['blue', 'yes', 'red', 'no']);
        $tester->execute([]);

        $tester->assertCommandIsSuccessful();
    }
}