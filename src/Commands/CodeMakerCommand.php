<?php

namespace GptTestProject\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;
use GptTestProject\GPTApplication\GPTConnector;
use GptTestProject\Utilities\ResponseFormatter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'code:make',
    description: 'OpenAI Code Maker',
)]
class CodeMakerCommand extends BaseCommand
{
    use ResponseFormatter;

    protected string $error_message = 'You did not provide some of the required options';

    protected string $confirm_message = 'File created successfully';
    /**
     * The command help shown when running
     * the command with the "--help" option
     */
    protected function configure(): void
    {
        $this->setHelp('This command allows you to create a new code file')
            ->addOption(
                'type',
                't',
                InputOption::VALUE_REQUIRED,
                'What type of file do you want to create?\\n
                The default type is JavaScript "js". Avaliable type options are "js", "php", "bash".',
                'js',
            )
            ->addOption(
                'fname',
                'n',
                InputOption::VALUE_REQUIRED,
                'What name of file do you want to create?',
                '',
            )
            ->addOption(
                'instruction',
                'i',
                InputOption::VALUE_REQUIRED,
                'What type of content do want to add to the file?',
                '',
            )
            ->addOption(
                'directory',
                'd',
                InputOption::VALUE_REQUIRED,
                'Where do you want to create new file?',
                '',
            )
            ->setCode(function (InputInterface $input, OutputInterface $output): int {

                /** Add styled output to response  */
                $inOut = new SymfonyStyle($input, $output);

                $dir = $input->getOption('directory');
                $type = $input->getOption('type');
                $instruction = $input->getOption('instruction');
                $fname = $input->getOption('fname');

                if (!$dir || !$type || !$instruction) {
                    $inOut->error($this->error_message);
                }

                if (!file_exists($dir)) {
                    mkdir($dir);
                }

                $filePath = $_SERVER['DOCUMENT_ROOT'] . "/". $dir . "/" . $fname . $type;
                if (file_exists($filePath)) {
                    $inOut->error('File already exists');
                }

                $gptHandler = new GPTConnector();
                $response = $gptHandler->sendRequest('Please, give me the following code: '. $instruction);
                $formattedResponse = $this->responseFormat($response);

                $fp = fopen($filePath, "wb");
                fwrite($fp, $formattedResponse);
                fclose($fp);
        
                $inOut->success(sprintf('Your result is: %s', $formattedResponse));
        
                return Command::SUCCESS;
            });
    }
    
}