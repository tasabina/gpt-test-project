<?php

namespace GptTestProject\Tests\Commands;

use GptTestProject\Commands\TranslateCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class TranslateCommandTest extends TestCase
{
    public function testExecute()
    {
        $application = new Application();
        $application->add(new TranslateCommand());

        $tester = new CommandTester($application->get('translate'));
        $tester->setInputs(['blue', 'yes', 'red', 'no']);
        $tester->execute([]);

        $tester->assertCommandIsSuccessful();
    }
}