<?php

namespace App\Command\Provider\Senetic;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class RelationTable extends Product
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function getRelationElement(string $getUrl, string $postUrl, array $data): array
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $getUrl, ['headers' => ['Content-Type' => 'application/ld+json']]);

        if ($response->getStatusCode() != 200) {
            dump('Error with the Senectic\Rack\getRelationElement Method');
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
                dump('Error with the Senectic\RelationTable\getRelationElement Method');
                dd($response->getContent());
            }

            return $response->toArray();
        }
        return $response['hydra:member'][0];
    }
}