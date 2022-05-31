<?php

namespace App\Command\Provider\Senetic\Table;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Connector extends ParentRelationTable
{

    /**
     * Allows to get a Connector
     * @param string $item
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getConnectorName(string $item): array
    {
        $postUrl = $_SERVER['APP_HOST'] . '/api/connectors';
        $getUrl = $_SERVER['APP_HOST'] . '/api/connectors?name=' . $item;
        $data = ["name" => $item];
        return $this->returnSelectOrInsertData($getUrl, $postUrl, $data);
    }
}