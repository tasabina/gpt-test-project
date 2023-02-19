<?php

namespace GptTestProject\Commands;

use GptTestProject\GPTApplication\GPTRequestHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'translate',
    description: 'Translate words.'
)]
class TranslateCLI extends BaseCLI
{
    /**
     * The command configuration method.
     * The command help shown when running the command with the "--help" option.
     * The flag --language (-l) to set language should the phrase be translated into.
     * By default language set as 'en'.
     * Avaliable language options are 'en', 'fr', 'ru'.
     */
    protected function configure(): void
    {
        $this->setHelp('This command allows you to translate words with GPT.')
            ->addOption(
                'language',
                'l',
                InputOption::VALUE_REQUIRED,
                'What language should the phrase be translated into?\\n
                The default language is English "en". Avaliable language options are "en", "fr", "ru".',
                'en',
            );
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
        /** Define language */
        $language = $input->getOption('language') ?? 'en';
        preg_match('/(en|fr|ru)/', $language, $matches, PREG_UNMATCHED_AS_NULL);
        $language = $matches[0] ?? 'en';

        $text = 'Translate phrase to english languge: ';

        switch($language) {
            case 'fr':
                $text = 'Translate phrase to franch languge: ';
                break;
            case 'ru':
                $text = 'Translate phrase to russian languge: ';
                break;
            default:
                break;
        }

        $phrase = $inOut->ask('Please input your phrase for translation:');

        if(trim($phrase) === '') {
            $inOut->error('You did not provide any words for translation.');
        } else {
            $text .= $phrase;
            $gptHandler = new GPTRequestHandler();
            $response = $gptHandler->sendRequest($text);

            $inOut->success(sprintf('Your result is: %s', $this->responseFormat($response)));
        }

        if ($inOut->confirm('Would you like to translate something again?')) {
            return $this->execute($input, $output);
        }

        return Command::SUCCESS;
    }

}