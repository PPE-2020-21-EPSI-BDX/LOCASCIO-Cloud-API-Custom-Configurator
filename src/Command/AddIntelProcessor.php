<?php

namespace App\Command;

use App\Command\Provider\Senetic\Processor as SenecticProcessor;
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
    name: 'add-intel-processors',
    description: 'Add Intel processors to the Processor table.',
    hidden: false
)]
class AddIntelProcessor extends ParentCommand
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

            $processor = new SenecticProcessor($this->entityManager);

            $nbrProductPage = $processor->getNumberPage("https://www.senetic.fr/intel/intel_processors/");

            for ($i = 1; $i < $nbrProductPage + 1; $i++) {
                $processor->getInfo("https://www.senetic.fr/intel/intel_processors/?page=" . $i);
            }
            return Command::SUCCESS;
        } catch (Exception|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $exception) {
            $this->display_error($exception);
            return Command::FAILURE;
        }
    }
}