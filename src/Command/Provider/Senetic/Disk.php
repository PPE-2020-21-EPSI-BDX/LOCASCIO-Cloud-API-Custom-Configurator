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

class Disk extends RelationTable
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Allows to save Disk in DB
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    protected function saveProduct(Crawler $product): void
    {
        if ($this->checkExist($_SERVER['APP_HOST'] . '/api/disks?provider_reference=' . $this->providerReference($product))) {

            $httpClient = HttpClient::create();
            $formFactor = $this->getFormFactor();

            $response = $httpClient->request('POST', $_SERVER['APP_HOST'] . '/api/disks', [
                'headers' => ['Content-Type' => 'application/ld+json'],
                'json' => [
                    "interface" => $this->getInterface()["@id"],
                    "formFactor" => !is_null($formFactor) ? $formFactor["@id"] : null,
                    "name" => $this->getName($product),
                    "brand" => $this->getBrand($product),
                    "capacity" => $this->capacity(),
                    "readSpeed" => $this->readSpeed(),
                    "writeSpeed" => $this->writeSpeed(),
                    "shufflePlayback" => $this->shuffle_playback(),
                    "randomWriting" => $this->randomWriting(),
                    "hddRotationSpeed" => $this->hddRotationSpeed(),
                    "availability" => $this->availability($product),
                    "delivery" => $this->delivery($product),
                    "providerReference" => $this->providerReference($product),
                    "application" => $this->application(),
                    "url" => $this->url(),
                    "price" => $this->price($product)
                ],
            ]);

            if ($response->getStatusCode() != 201) {
                dump('Error with the Senectic\Disk\saveProduct Method');
                dump($this->urlProduct);
                dd($response->getContent());
            }

            dump("==========================================================================================");
            dump('    SUCCESS - Insert ' . $this->getName($product) . ' in DB !');
            dump("==========================================================================================");
        } else {
            $this->update($product, $_SERVER['APP_HOST'] . '/api/disks/' . $this->productInDB['id']);
        }
    }

    /**
     * Allows to get or insert the disk interface
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function getInterface(): array
    {
        if (isset($this->detail['Interface'])) {
            $name = str_replace(' ', '-', $this->detail['Interface']);

            if (isset($this->detail['Taux de transfert des données'])) {
                $maxTransferSpeed = str_replace('-', ' ', $this->detail['Taux de transfert des données']);
            }
            if (isset($this->detail["Vitesse de transfert de l'interface de disque dur"])) {
                $maxTransferSpeed = str_replace('-', ' ', $this->detail["Vitesse de transfert de l'interface de disque dur"]);
            }

            $getUrl = $_SERVER['APP_HOST'] . '/api/connectors?name=' . $name;
            $postUrl = $_SERVER['APP_HOST'] . '/api/connectors';
            $data = [
                "name" => $name,
                "maxTransferSpeed" => $maxTransferSpeed ?? null
            ];

            return $this->getRelationElement($getUrl, $postUrl, $data);
        }
    }

    /**
     * Allows to get or insert the disk form factor
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function getFormFactor()
    {
        if (isset($this->detail['Facteur de forme SSD'])) {
            $name = preg_replace('/[^\w.]/', '', $this->detail['Facteur de forme SSD']);
        }
        if (isset($this->detail['Taille du disque dur'])) {
            $name = preg_replace('/[^\w.]/', '', $this->detail['Taille du disque dur']);
        }

        if (isset($name)) {
            $getUrl = $_SERVER['APP_HOST'] . '/api/form_factors?name=' . $name;
            $postUrl = $_SERVER['APP_HOST'] . '/api/form_factors';
            $data = [
                "name" => $name,
            ];
            return $this->getRelationElement($getUrl, $postUrl, $data);
        }
    }

    /**
     * Allows to get the capacity of disk
     * @return string|null
     */
    private function capacity(): ?string
    {
        $temp = null;

        if (isset($this->detail['Capacité du Solid State Drive (SSD)'])) {
            $temp = explode('-', $this->detail['Capacité du Solid State Drive (SSD)'])[0];
        }
        if (isset($this->detail['Capacité disque dur'])) {
            $temp = explode('-', $this->detail['Capacité disque dur'])[0];
        }

        return $temp;
    }

    /**
     * Allows to obtain the reading speed
     * @return string|null
     */
    private function readSpeed(): ?string
    {
        return (isset($this->detail["Vitesse de l'écriture séquentielle"]))
            ? str_replace('-', ' ', $this->detail["Vitesse de l'écriture séquentielle"])
            : null;
    }

    /**
     * Allows to obtain the writing speed
     * @return string|null
     */
    private function writeSpeed(): ?string
    {
        return (isset($this->detail['Lecture séquentielle']))
            ? str_replace('-', ' ', $this->detail['Lecture séquentielle'])
            : null;
    }

    /**
     * Allows to obtain the random playback (100% of range)
     * @return string|null
     */
    private function shuffle_playback(): ?string
    {
        return (isset($this->detail["Lecture aléatoire (100% de l'étendue)"]))
            ? preg_replace('/[^\w-]/', '', $this->detail["Lecture aléatoire (100% de l'étendue)"])
            : null;
    }

    /**
     * Allows to obtain the random writing (100% of the range)
     * @return string|null
     */
    private function randomWriting(): ?string
    {
        return (isset($this->detail["En écriture aléatoire (100% de l'étendue)"]))
            ? preg_replace('/[^\w-]/', '', $this->detail["En écriture aléatoire (100% de l'étendue)"])
            : null;
    }

    /**
     * Allows to obtain the hard disk drive rotation speed
     * @return string|null
     */
    private function hddRotationSpeed(): ?string
    {
        return (isset($this->detail['Vitesse de rotation du disque dur']))
            ? dd($this->detail['Vitesse de rotation du disque dur'])
            : null;
    }
}