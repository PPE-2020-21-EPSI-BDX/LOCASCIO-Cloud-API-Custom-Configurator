<?php

namespace App\Command;

use App\Command\Provider\Senetic\Disk as SenecticDisk;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

#[AsCommand(
    name: 'add-intel-disks',
    description: 'Add intel ssd to the disk table.',
    hidden: false
)]
class AddIntelDisk extends ParentCommand
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            parent::execute($input, $output);
            $this->start();

            $disk = new SenecticDisk();
            $nbrProductPage = $disk->getNumberPage("https://www.senetic.fr/intel/intel_ssd/");
            unset($disk);

            $progressBar = new ProgressBar($output, $nbrProductPage);
            $progressBar->start();

            for ($i = 1; $i < $nbrProductPage + 1; $i++) {
                $disk = new SenecticDisk();
                $disk->getInfo("https://www.senetic.fr/intel/intel_ssd/?page=" . $i);
                unset($disk);
                $progressBar->advance();
            }
            $progressBar->finish();
            return Command::SUCCESS;
        } catch (Exception|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $exception) {
            $this->display_error($exception);
            return Command::FAILURE;
        }
    }
}