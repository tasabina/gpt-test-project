<?php

namespace GptTestProject\Commands;

use GptTestProject\GPTApplication\GPTConnector;
use GptTestProject\Utilities\ResponseFormatter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'translate',
    description: 'Translate words.'
)]
class TranslateCommand extends BaseCommand
{
    protected string $question = 'Please input your phrase for translation';
    
    protected string $error_message = 'You did not provide any words for translation';

    protected string $confirm_message = 'Would you like to translate something again?';
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
     * Method defines language
     */
    public function onBeforeRequest(InputInterface &$input, string &$phrase): void
    {
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

        $phrase = $text . $phrase; 
    }

}