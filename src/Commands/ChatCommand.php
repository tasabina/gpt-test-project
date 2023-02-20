<?php

namespace GptTestProject\Commands;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'chat',
    description: 'Chat with GPT-3.'
)]
class ChatCommand extends BaseCommand
{
    /**
     * The command help shown when running
     * the command with the "--help" option
     */
    protected function configure(): void
    {
        $this->setHelp('This command allows you to play with GPT-3.');
    }
    
}