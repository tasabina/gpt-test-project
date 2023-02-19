<?php

namespace GptTestProject\Commands;

use GptTestProject\GPTApplication\GPTRequestHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'chat',
    description: 'Chat with GPT-3.'
)]
class ChatCLI extends BaseCLI
{
    /**
     * The command help shown when running
     * the command with the "--help" option
     */
    protected function configure(): void
    {
        $this->setHelp('This command allows you to play with GPT-3.');
    }

    /**
     * The command execution metod
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** Just in case */
        if (!$output instanceof ConsoleOutputInterface) {
            throw new \LogicException('This command accepts only an instance of "ConsoleOutputInterface".');
        }
        /** Add styled output to response  */
        $inOut = new SymfonyStyle($input, $output);
        
        $phrase = $inOut->ask('Please input your message');

        if(trim($phrase) === '') {
            $inOut->error('You did not provide any words for your message.');
        } else {
            $gptHandler = new GPTRequestHandler();
            $response = $gptHandler->sendRequest($phrase);

            $inOut->success(sprintf('Your result is: %s', $this->responseFormat($response)));
        }

        if ($inOut->confirm('Would you like to translate something again?')) {
            return $this->execute($input, $output);
        }

        return Command::SUCCESS;
    }
    
}