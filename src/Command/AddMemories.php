<?php

namespace App\Command;

use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

#[AsCommand(
    name: 'add-memories',
    description: 'Add Samsung memories to the Memory table.',
    hidden: false
)]
class AddMemories extends ParentCommand
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            parent::execute($input, $output);
            $this->start();

            $this->product("https://www.senetic.fr/samsung_enterprise/memory/");
            $this->product("https://www.senetic.fr/kingston/server/");

            return Command::SUCCESS;
        } catch (Exception|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $exception) {
            $this->display_error($exception);
            return Command::FAILURE;
        }
    }
}

