<?php

namespace GptTestProject\Commands;

use GptTestProject\GPTApplication\GPTConnector;
use GptTestProject\Utilities\ResponseFormatter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BaseCommand extends Command
{
    use ResponseFormatter;

    protected string $question = 'Please input your question';

    protected string $error_message = 'You did not provide any words for your message';

    protected string $confirm_question = 'Would you like to ask something else?';
    /**
     * The command execution metod
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** Add styled output to response  */
        $inOut = new SymfonyStyle($input, $output);

        $phrase = $inOut->ask($this->question);

        if(trim($phrase) === '') {
            $inOut->error($this->error_message);
        } else {
            $this->onBeforeRequest($input, $phrase);

            $gptHandler = new GPTConnector();
            $response = $gptHandler->sendRequest($phrase);

            $inOut->success(sprintf('Your result is: %s', $this->responseFormat($response)));
        }

        if ($inOut->confirm($this->confirm_question)) {
            return $this->execute($input, $output);
        }

        return Command::SUCCESS;
    }

    public function onBeforeRequest(InputInterface &$input, string &$phrase): void
    {
        // noop...
    }
}