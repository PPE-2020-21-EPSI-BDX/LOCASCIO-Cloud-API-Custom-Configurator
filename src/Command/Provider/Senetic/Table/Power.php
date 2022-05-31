<?php

namespace App\Command\Provider\Senetic\Table;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Power extends ParentRelationTable
{
    /**
     * Allows to get a power capacity
     * @param string $power
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getPowerCapacity(int $power): array
    {
        $getUrl = $_SERVER['APP_HOST'] . '/api/powers?capacity=' . $power;
        $postUrl = $_SERVER['APP_HOST'] . '/api/powers';
        $data = ["capacity" => $power];

        return $this->returnSelectOrInsertData($getUrl, $postUrl, $data);
    }
}