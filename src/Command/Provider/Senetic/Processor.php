<?php

namespace App\Command\Provider\Senetic;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Processor extends Product
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->em = $entityManager;
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
        if ($this->checkExist($_SERVER['APP_HOST'] . '/api/processors?provider_reference=' . $this->providerReference($product))) {

            $httpClient = HttpClient::create();

            $response = $httpClient->request('POST', $_SERVER['APP_HOST'] . '/api/processors', [
                'headers' => ['Content-Type' => 'application/ld+json'],
                'json' => [
                    "name" => $this->getName($product),
                    "brand" => $this->getBrand($product),
                    "availability" => $this->availability($product),
                    "delivery" => $this->delivery($product),
                    "socket" => $this->socket(),
                    "upi" => intval($this->maxProcessors()),
                    "cores" => intval($this->cores()),
                    "threads" => intval($this->threads()),
                    "tdp" => $this->tdp(),
                    "baseFreq" => $this->baseFeq(),
                    "boostFreq" => $this->boostFreq(),
                    "cache" => $this->cache(),
                    "ecc" => $this->ecc(),
                    "graficsProcessor" => $this->graficsProcessor(),
                    "application" => $this->application(),
                    "url" => $this->url(),
                    "price" => $this->price($product),
                    "providerReference" => $this->providerReference($product),
                    "maxMemCapacity" => $this->maxMemCapacity()
                ],
            ]);

            if ($response->getStatusCode() != 201) {
                dump('Error with the Senectic\Processor\saveProduct Method');
                dd($response->getContent());
            }

            if (!is_null($this->maxMemFreq()) && !is_null($this->memType())) {
                $memory = new \App\Command\Provider\Senetic\Table\Memory($this->detail);
                $data = $response->toArray();
                $memory->getCompatibleMemory($this->em, $data, $this->memType(), $this->maxMemFreq());
            }

            dump("==========================================================================================");
            dump('    SUCCESS - Insert ' . $this->getName($product) . ' in DB !');
            dump("==========================================================================================");
        } else {

            $this->update($product, $_SERVER['APP_HOST'] . '/api/processors/' . $this->productInDB['id']);

        }
    }

    /**
     * Allows to give the socket name
     * @return string|null
     */
    private function socket(): ?string
    {
        if (isset($this->detail['Socket de processeur (réceptable de processeur)'])) {
            return ($this->detail['Socket de processeur (réceptable de processeur)']);
        }
        return null;
    }

    /**
     * Allows to give the number of Max CPU Configuration
     * @return int|null
     */
    private function maxProcessors(): ?int
    {
        if (isset($this->detail['Configuration CPU (max)'])) {
            return intval($this->detail['Configuration CPU (max)']);
        }
        return $this->upi();
    }

    /**
     * Allows to give the number of Max CPU Configuration
     * @return int|null
     */
    private function upi(): ?int
    {
        if (isset($this->detail['Nombre de liaisons UPI'])) {
            return intval($this->detail['Nombre de liaisons UPI']);
        }
        return null;
    }

    /**
     * Allows to give the number of cores
     * @return int|null
     */
    private function cores(): ?int
    {
        if (isset($this->detail['Nombre de coeurs de processeurs'])) {
            return intval($this->detail['Nombre de coeurs de processeurs']);
        }
        return null;
    }

    /**
     * Allows to give the number of threads
     * @return int|null
     */
    private function threads(): ?int
    {
        if (isset($this->detail['Nombre de threads du processeur'])) {
            return intval($this->detail['Nombre de threads du processeur']);
        }
        return null;
    }

    /**
     * Allows to give the tdp
     * @return int|null
     */
    private function tdp(): ?int
    {
        if (isset($this->detail['Enveloppe thermique (TDP, Thermal Design Power)'])) {
            return intval(explode('-', $this->detail['Enveloppe thermique (TDP, Thermal Design Power)'])[0]);
        }
        return null;
    }

    /**
     * Allows to give the base frequency
     * @return int|null
     */
    private function baseFeq(): ?int
    {
        if (isset($this->detail['Fréquence de base du processeur'])) {
            return intval(explode('-', $this->detail['Fréquence de base du processeur'])[0]);
        }
        return null;
    }

    /**
     * Allows to give the boost frequency
     * @return int|null
     */
    private function boostFreq(): ?int
    {
        if (isset($this->detail['Fréquence du processeur Turbo'])) {
            return intval(explode('-', $this->detail['Fréquence du processeur Turbo'])[0]);
        }
        return null;
    }

    /**
     * Allows to give the cache of Processor
     * @return int|null
     */
    private function cache(): ?int
    {
        if (isset($this->detail['Mémoire cache du processeur'])) {
            return intval(explode('-', $this->detail['Mémoire cache du processeur'])[0]);
        }
        return null;
    }

    /**
     * Allows to give the max memory size
     * @return int|null
     */
    private function maxMemCapacity(): ?int
    {
        if (isset($this->detail['Mémoire interne maximum prise en charge par le processeur'])) {
            return intval(explode('-', $this->detail['Mémoire interne maximum prise en charge par le processeur'])[0]);
        }
        return null;
    }

    /**
     * Allows to give the max memory speed
     * @return int|null
     */
    private function maxMemFreq(): ?int
    {
        if (isset($this->detail["Vitesses d'horloge de mémoire prises en charge par le processeur"])) {
            $element = $this->detail["Vitesses d'horloge de mémoire prises en charge par le processeur"];
            return intval(explode('-', $element)[0]);
        }
        return null;
    }

    /**
     * Allows to give the memory type
     * @return string|null
     */
    private function memType(): ?string
    {
        if (isset($this->detail['Types de mémoires pris en charge par le processeur'])) {
            return ($this->detail['Types de mémoires pris en charge par le processeur']);
        } elseif (isset($this->detail['Type de mémoire interne'])) {
            return ($this->detail['Type de mémoire interne']);
        }
        return null;
    }

    /**
     * Allows to give the max of memory channel(s)
     * @return int|null
     */
    private function maxMemChannel(): ?int
    {
        if (isset($this->detail['Canaux de mémoire'])) {
            return $this->format->convertLetterChannelToInt($this->detail['Canaux de mémoire']);
        }
        return null;
    }

    /**
     * Allows to identify if it supports ecc
     * @return ?bool
     */
    private function ecc(): bool|null
    {
        if (isset($this->detail['ECC'])) {
            return $this->format->convertYesNoToBool($this->detail['ECC']);
        }
        return null;
    }

    /**
     * Allows identifying if it has a graphic processor
     * @return bool|null
     */
    private function graficsProcessor(): ?bool
    {
        if (isset($this->detail['Carte graphique intégrée'])) {
            return $this->format->convertYesNoToBool($this->detail['Carte graphique intégrée']);
        }
        return null;
    }
}