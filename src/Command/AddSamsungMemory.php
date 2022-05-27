<?php

namespace App\Command;

use App\Command\Provider\Senetic\Memory as SenecticMemory;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

#[AsCommand(
    name: 'add-samsung-memories',
    description: 'Add Samsung memories to the Memory table.',
    hidden: false
)]
class AddSamsungMemory extends ParentCommand
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            parent::execute($input, $output);
            $this->start();

            $memory = new SenecticMemory();
            $nbrProductPage = $memory->getNumberPage("https://www.senetic.fr/samsung_enterprise/memory/");
            unset($processor);

            for ($i = 1; $i < $nbrProductPage + 1; $i++) {
                $memory = new SenecticMemory();
                $memory->getInfo("https://www.senetic.fr/samsung_enterprise/memory/?page=" . $i);
                unset($memory);
            }
            return Command::SUCCESS;
        } catch (Exception|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $exception) {
            $this->display_error($exception);
            return Command::FAILURE;
        }
    }
}

