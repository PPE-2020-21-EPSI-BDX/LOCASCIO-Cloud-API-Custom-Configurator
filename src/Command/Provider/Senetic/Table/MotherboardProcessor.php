<?php

namespace App\Command\Provider\Senetic\Table;

use App\Entity\Processor;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class MotherboardProcessor extends ParentRelationTable
{
    public function __construct(array $detail)
    {
        parent::__construct();
        $this->detail = $detail;
    }

    /**
     * Allows to insert motherboard processor information into DB
     * @param array $motherboard
     * @param EntityManagerInterface $entityManager
     * @return void
     * @throws Exception
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function insertMotherboardProcessor(array $motherboard, EntityManagerInterface $entityManager): void
    {
        if (isset($this->detail['Socket de processeur (réceptable de processeur)']) && isset($this->detail['Puissance thermique du processeur (max)'])) {
            $socket = $this->detail['Socket de processeur (réceptable de processeur)'];
            $tdp = intval($this->detail['Puissance thermique du processeur (max)']);
            $processors = $entityManager->getRepository(Processor::class)->findAllProcessorsThanSocketAndTdp($socket, $tdp);

            foreach ($processors as $element) {
                $this->insertData($_SERVER['APP_HOST'] . '/api/motherboard_processors', [
                    "motherboard" => $motherboard["@id"],
                    "processor" => '/api/processors/' . $element['id']
                ]);
            }
        }
    }
}