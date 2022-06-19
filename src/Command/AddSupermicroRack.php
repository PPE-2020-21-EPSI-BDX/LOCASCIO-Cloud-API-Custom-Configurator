<?php

namespace App\Command;

use App\Command\Provider\Senetic\Rack as SeneticRack;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

#[AsCommand(
    name: 'add-supermicro-racks',
    description: 'Add supermicro racks to the Rack table.',
    hidden: false
)]
class AddSupermicroRack extends ParentCommand
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            parent::execute($input, $output);
            $this->start();

            $rack = new SeneticRack();
            $nbrProductPage = $rack->getNumberPage("https://www.senetic.fr/supermicro/supermicro_chassis/rack_1u/");
            unset($rack);

            for ($i = 1; $i < $nbrProductPage + 1; $i++) {
                $rack = new SeneticRack();
                $rack->getInfo("https://www.senetic.fr/supermicro/supermicro_chassis/rack_1u/?page=" . $i);
                unset($rack);
            }
            return Command::SUCCESS;
        } catch (Exception|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $exception) {
            $this->display_error($exception);
            return Command::FAILURE;
        }
    }
}