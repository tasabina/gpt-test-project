<?php

namespace GptTestProject\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'chat',
    description: 'Chat with GPT-3.'
)]
class ChatCLI extends Command
{
    /**
     * The command help shown when running
     * the command with the "--help" option
     */
    protected function configure(): void
    {
        $this->setHelp('This command allows you to play with GPT-3.')
            ->addOption(
                // this is the name that users must type to pass this option (e.g. --iterations=5)
                'iterations',
                // this is the optional shortcut of the option name, which usually is just a letter
                // (e.g. `i`, so users pass it as `-i`); use it for commonly used options
                // or options with long names
                null,
                // this is the type of option (e.g. requires a value, can be passed more than once, etc.)
                InputOption::VALUE_REQUIRED,
                // the option description displayed when showing the command help
                'How many times should the message be printed?',
                // the default value of the option (for those which allow to pass values)
                1
            );
    }

    /**
     * The command execution metod
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inOut = new SymfonyStyle($input, $output);

        $answer = (int) $inOut->ask(sprintf('What is %s + %s', 2, 3));

        if ($answer === 5) {
            $inOut->success('Well done!');
        } else {
            $inOut->error(sprintf('Aww, so close. The answer was %s', 5));
        }

        if ($inOut->confirm('Play again?')) {
            return $this->execute($input, $output);
        }

        return Command::SUCCESS;
    }


}