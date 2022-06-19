<?php

namespace App\Command\Provider\Senetic\Table;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Indicator extends ParentRelationTable
{
    /**
     * Allows to get an indicator
     * @param string $indicator
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getIndicatorName(string $indicator): array
    {
        $postUrl = $_SERVER['APP_HOST'] . '/api/indicators';
        $getUrl = $_SERVER['APP_HOST'] . '/api/indicators?name=' . $indicator;
        $data = ["name" => $indicator];
        return $this->returnSelectOrInsertData($getUrl, $postUrl, $data);
    }
}