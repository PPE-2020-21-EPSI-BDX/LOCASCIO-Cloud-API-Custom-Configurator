<?php

namespace App\Command\Provider\Senetic\Table;

use Doctrine\ORM\EntityManagerInterface;

class Memory extends ParentRelationTable
{
    public function __construct(array $detail)
    {
        parent::__construct();
        $this->detail = $detail;
    }


    public function getCompatibleMemory(EntityManagerInterface $entityManager, array $processor, string $type, int $freq): void
    {
        $memories = $entityManager->getRepository(\App\Entity\Memory::class)->findAllMemoriesThanFreqAndType($type, $freq);

        foreach ($memories as $element) {
            $this->insertData($_SERVER['APP_HOST'] . '/api/processor_memories', [
                "processor" => $processor["@id"],
                "memory" => '/api/memories/' . $element['id']
            ]);
        }
    }
}