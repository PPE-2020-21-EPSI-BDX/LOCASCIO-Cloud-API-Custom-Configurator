<?php

namespace App\Command\Provider\Senetic;

use Exception;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Memory extends Product
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Allows to save Processor in DB
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    protected function saveProduct(Crawler $product): void
    {
        if ($this->checkExist($_SERVER['APP_HOST'] . '/api/memories?provider_reference=' . $this->providerReference($product))) {

            $httpClient = HttpClient::create();

            $response = $httpClient->request('POST', $_SERVER['APP_HOST'] . '/api/memories', [
                'headers' => ['Content-Type' => 'application/ld+json'],
                'json' => [
                    "name" => $this->getName($product),
                    "brand" => $this->getBrand($product),
                    "availability" => $this->availability($product),
                    "delivery" => $this->delivery($product),
                    "providerReference" => $this->providerReference($product),
                    "capacity" => $this->capacity(),
                    "cas" => $this->cas(),
                    "number" => $this->number(),
                    "type" => $this->type(),
                    "freq" => $this->freq(),
                    "ecc" => $this->ecc($product),
                    "slotType" => $this->slotType(),
                    "application" => $this->application(),
                    "url" => $this->url(),
                    "price" => $this->price($product)
                ],
            ]);

            if ($response->getStatusCode() != 201) {
                dump('Error with the Senectic\Memory\saveProduct Method');
                dd($response->getContent());
            }

            dump("==========================================================================================");
            dump('    SUCCESS - Insert ' . $this->getName($product) . ' in DB !');
            dump("==========================================================================================");
        } else {
            $this->update($product, $_SERVER['APP_HOST'] . '/api/memories/' . $this->productInDB['id']);
        }
    }

    /**
     * Allows to know the memory capacity
     * @return string|null
     */
    private function capacity(): ?string
    {
        return (isset($this->detail['Mémoire interne'])) ? explode('-', $this->detail['Mémoire interne'])[0] : null;
    }

    /**
     * Allows to know the memory cas
     * @return string|null
     */
    private function cas(): ?string
    {
        return (isset($this->detail['Latence CAS'])) ? ($this->detail['Latence CAS']) : null;
    }

    private function number(): ?int
    {
        if (isset($this->detail['Disposition de la mémoire (modules x dimensions)'])) {
            return intval((explode('x', $this->detail['Disposition de la mémoire (modules x dimensions)'])[0]));
        } else {
            return null;
        }
    }

    /**
     * Allows to get the memory type
     * @return string|null
     */
    private function type(): ?string
    {
        return (isset($this->detail['Type de mémoire interne'])) ? ($this->detail['Type de mémoire interne']) : null;
    }

    /**
     * Allows to get the memory frequency
     * @return string|null
     */
    private function freq(): ?string
    {
        return (isset($this->detail['Fréquence de la mémoire'])) ? explode('-', $this->detail['Fréquence de la mémoire'])[0] : null;
    }

    /**
     * Allows to get if a memory have ecc
     * @param Crawler $product
     * @return bool
     */
    private function ecc(Crawler $product): bool
    {
        return in_array('ECC', explode(' ', $this->getName($product)));
    }

    /**
     * Allows to get slot type
     * @return string|null
     */
    private function slotType(): ?string
    {
        return (isset($this->detail['Support de mémoire']))
            ? $this->detail['Support de mémoire']
            : null;
    }
}