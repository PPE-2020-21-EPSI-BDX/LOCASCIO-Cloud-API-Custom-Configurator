<?php

namespace App\Command\Provider\Senetic\Table;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class FormFactor extends ParentRelationTable
{

    /**
     * Allows to get a Form Factor
     * @param string $name
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getFormFactorName(string $name): array
    {
        $postUrl = $_SERVER['APP_HOST'] . '/api/form_factors';
        $getUrl = $_SERVER['APP_HOST'] . '/api/form_factors?name=' . $name;
        $data = ["name" => $name];
        return $this->returnSelectOrInsertData($getUrl, $postUrl, $data);
    }
}