<?php

namespace App\Command\Provider\Senetic\Table;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class MotherboardRaidLevel extends ParentRelationTable
{
    public function __construct(array $detail)
    {
        parent::__construct();
        $this->detail = $detail;
    }

    /**
     * Allows to insert motherboard raid level information into DB
     * @param array $motherboard
     * @return void
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function insertMotherboardRaidLevel(array $motherboard): void
    {
        if (isset($this->detail['Niveaux RAID'])) {
            $raids = explode(',', $this->detail['Niveaux RAID']);
            $level = new Level();

            foreach ($raids as $raid) {
                $this->insertData($_SERVER['APP_HOST'] . '/api/motherboard_raid_levels', [
                    "motherboard" => $motherboard["@id"],
                    "level" => $level->getRaidLevel(intval($raid))["@id"]
                ]);
            }
        }
    }
}