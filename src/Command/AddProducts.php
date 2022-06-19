<?php

namespace App\Command;

use App\Command\Provider\Senetic\Disk as SenecticDisk;
use App\Command\Provider\Senetic\Memory as SenecticMemory;
use App\Command\Provider\Senetic\Motherboard as SenecticMotherboard;
use App\Command\Provider\Senetic\Processor as SenecticProcessor;
use App\Command\Provider\Senetic\Rack as SeneticRack;
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
    name: 'add-products',
    description: 'Add All Products.',
    hidden: false
)]
class AddProducts extends ParentCommand
{

    private int $totalProduct;
    private EntityManagerInterface $entityManager;
    /**
     * @var array[]
     */
    private array $data;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->totalProduct = 0;
        $this->data = [
            ['instance' => new SenecticProcessor($this->entityManager), 'url' => "https://www.senetic.fr/intel/intel_processors/"],
            ['instance' => new SenecticProcessor($this->entityManager), 'url' => "https://www.senetic.fr/amd/"],
            ['instance' => new SenecticMemory(), 'url' => "https://www.senetic.fr/samsung_enterprise/memory/"],
            ['instance' => new SenecticMemory(), 'url' => "https://www.senetic.fr/kingston/server/"],
            ['instance' => new SenecticDisk(), 'url' => "https://www.senetic.fr/intel/intel_ssd/"],
            ['instance' => new SeneticRack(), 'url' => "https://www.senetic.fr/supermicro/supermicro_chassis/"],
            ['instance' => new SenecticMotherboard($this->entityManager), 'url' => "https://www.senetic.fr/supermicro/supermicro_motherboards/"],
        ];
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            parent::execute($input, $output);
            $this->start();

            $this->setTotalProductPage();

            $this->browseProduct();

            return Command::SUCCESS;

        } catch (Exception|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $exception) {
            $this->display_error($exception);
            return Command::FAILURE;
        }
    }

    /**
     * Allows to set the total product pages
     * @return void
     * @throws Exception
     */
    private function setTotalProductPage(): void
    {

        for ($i=0; $i < count($this->data); $i++){
            $productNumber = $this->data[$i]["instance"]->getNumberProduct($this->data[$i]["url"])[1];
            if($productNumber > 0){
                $this->data[$i]['nbrProductPage'] = $productNumber;
                $this->totalProduct += $productNumber;
            }else{
                throw new Exception('The product number can not be null');
            }
        }
    }

    /**
     * Allows to browse any product on a page
     * @return void
     */
    private function browseProduct(): void
    {
        foreach ($this->data as $item){
            for ($i = 1; $i < $item["nbrProductPage"] + 1; $i++) {
                $item["instance"]->getInfo($item["nbrProductPage"]. "?page=" . $i);
            }
        }
    }
}