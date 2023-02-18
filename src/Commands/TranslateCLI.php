<?php

namespace GptTestProject\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'trans',
    description: 'Translate words.'
)]
class TranslateCLI extends Command
{
    /**
     * The command help shown when running
     * the command with the "--help" option
     */
    protected function configure(): void
    {
        $this->setHelp('This command allows you to translate words with GPT.');
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