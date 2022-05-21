<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'ParentCommand',
    description: 'This the parent class for all custom commands',
    hidden: true
)]
class ParentCommand extends Command
{
    protected SymfonyStyle $io;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);
        return Command::SUCCESS;
    }

    protected function start(){
        $this->io->section('Initialisation du programme');
        sleep(1);
        $this->io->success('Initialisation des variables par défaut réalisées avec succès');
    }

    protected function display_error(\Exception $e = null){
        $this->io->error($e->getMessage());
    }
}