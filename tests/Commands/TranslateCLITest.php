<?php

namespace GptTestProject\Tests\Commands;

use GptTestProject\Commands\TranslateCLI;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandCompletionTester;

class TranslateCLICommandTest extends TestCase
{
    public function testExecute()
    {
        $application = new Application();
        $application->add(new TranslateCLI());

        $tester = new CommandCompletionTester($application->get('translate'));

        $suggestions = $tester->complete(['']);
        // $this->assertSame(['Fabien', 'Fabrice', 'Wouter'], $suggestions);

        $suggestions = $tester->complete(['Fa']);
        // $this->assertSame(['Fabien', 'Fabrice'], $suggestions);
    }
}