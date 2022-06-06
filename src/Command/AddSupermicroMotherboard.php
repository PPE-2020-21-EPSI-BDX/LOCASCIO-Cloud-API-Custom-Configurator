<?php

namespace App\Command;

use App\Command\Provider\Senetic\Motherboard as SenecticMotherboard;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

#[AsCommand(
    name: 'add-supermicro-motherboards',
    description: 'Add supermicro motherboards to the Motherboard table.',
    hidden: false
)]
class AddSupermicroMotherboard extends ParentCommand
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            parent::execute($input, $output);
            $this->start();

            $motherboard = new SenecticMotherboard($this->entityManager);
            $nbrProductPage = $motherboard->getNumberPage("https://www.senetic.fr/supermicro/supermicro_motherboards/");

            for ($i = 1; $i < $nbrProductPage + 1; $i++) {
                $motherboard->getInfo("https://www.senetic.fr/supermicro/supermicro_motherboards/?page=" . $i);
            }
            return Command::SUCCESS;
        } catch (Exception|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $exception) {
            $this->display_error($exception);
            return Command::FAILURE;
        }
    }
}