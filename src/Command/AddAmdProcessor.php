<?php

namespace App\Command;

use App\Command\Provider\Senetic\Processor as SenecticProcessor;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

#[AsCommand(
    name: 'add-amd-processors',
    description: 'Add AMD processors to the Processor table.',
    hidden: false
)]
class AddAmdProcessor extends ParentCommand
{

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            parent::execute($input, $output);
            $this->start();

            $processor = new SenecticProcessor();
            $nbrProductPage = $processor->getNumberPage("https://www.senetic.fr/amd/");
            unset($processor);

            for ($i = 1; $i < $nbrProductPage + 1; $i++) {
                $processor = new SenecticProcessor();
                $processor->getInfo("https://www.senetic.fr/amd/?page=" . $i);
                unset($processor);
            }
            return Command::SUCCESS;
        } catch (Exception|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $exception) {
            $this->display_error($exception);
            return Command::FAILURE;
        }
    }
}