<?php

namespace App\Command\Provider\Senetic\Table;

use App\Command\Provider\Senetic\Product;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ParentRelationTable extends Product
{
    /**
     * Allows to insert data in DB
     * @param string $postUrl
     * @param array $data
     * @return void
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function insertData(string $postUrl, array $data): void
    {
        $httpClient = HttpClient::create();

        $response = $httpClient->request('POST', $postUrl, [
            'headers' => ['Content-Type' => 'application/ld+json'],
            'json' => $data,
        ]);

        if ($response->getStatusCode() != 201) {
            dump('Error with the Senectic\ParentRelationTable\insertData Method');
            dd($response->getContent());
        }
    }

    /**
     * Allows to get or insert information in DB
     * @param string $getUrl
     * @param string $postUrl
     * @param array $data
     * @return array
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws DecodingExceptionInterface
     */
    protected function returnSelectOrInsertData(string $getUrl, string $postUrl, array $data): array
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $getUrl, ['headers' => ['Content-Type' => 'application/ld+json']]);

        if ($response->getStatusCode() != 200) {
            dump('Error with the Senectic\ParentRelationTable\returnSelectOrInsertData Method');
            dd($response->getContent());
        }

        $response = $response->toArray();

        if ($response['hydra:totalItems'] == 0) {
            $httpClient = HttpClient::create();

            $response = $httpClient->request('POST', $postUrl, [
                'headers' => ['Content-Type' => 'application/ld+json'],
                'json' => $data
            ]);

            if ($response->getStatusCode() != 201) {
                dump('Error with the Senectic\ParentRelationTable\returnSelectOrInsertData Method');
                dd($response->getContent());
            }

            return $response->toArray();
        }
        return $response['hydra:member'][0];
    }
}