<?php

namespace App\Command\Provider\Senetic;

use App\Command\Provider\Senetic\Table\RackFormFactor;
use App\Command\Provider\Senetic\Table\RackIndicator;
use App\Command\Provider\Senetic\Table\RackPower;
use App\Command\Provider\Senetic\Table\RackStorage;
use App\Command\Provider\Senetic\Table\RelationTable;
use Exception;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Rack extends Product
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
     * @throws Exception
     */
    protected function saveProduct(Crawler $product): void
    {
        if ($this->checkExist($_SERVER['APP_HOST'] . '/api/racks?provider_reference=' . $this->providerReference($product))) {

            $httpClient = HttpClient::create();

            $response = $httpClient->request('POST', $_SERVER['APP_HOST'] . '/api/racks', [
                'headers' => ['Content-Type' => 'application/ld+json'],
                'json' => [
                    "name" => $this->getName($product),
                    "brand" => $this->getBrand($product),
                    "picture" => $this->picture($product),
                    "type" => $this->type(),
                    "width" => $this->width(),
                    "depth" => $this->depth(),
                    "height" => $this->height(),
                    "weight" => $this->weight(),
                    "storageBays" => $this->storageBays(),
                    "availability" => $this->availability($product),
                    "delivery" => $this->delivery($product),
                    "providerReference" => $this->providerReference($product),
                    "url" => $this->url(),
                    "price" => $this->price($product),
                ],
            ]);

            if ($response->getStatusCode() != 201) {
                dump('Error with the Senectic\Rack\saveProduct Method');
                dd($response->getContent());
            }
            $data = $response->toArray();

            $rackPower = new RackPower($this->detail);
            $rackIndicator = new RackIndicator($this->detail);
            $rackStorage = new RackStorage($this->detail);
            $rackFormFactor = new RackFormFactor($this->detail);

            $rackPower->insertRackPowers($data);
            $rackIndicator->insertRackIndicators($data);
            $rackStorage->insertRackStorage($data);

            $rackFormFactor->insertRackFormFactor($data);

            dump("==========================================================================================");
            dump('    SUCCESS - Insert ' . $this->getName($product) . ' in DB !');
            dump("==========================================================================================");
        } else {

            $this->update($product, $_SERVER['APP_HOST'] . '/api/racks/' . $this->productInDB['id']);

        }
    }

    /**
     * Allows to obtain the url of the image
     * @param Crawler $product
     * @return string|null
     */
    private function picture(Crawler $product): ?string
    {
        return ($product->selectImage($this->providerReference($product))->count() != 0)
            ? $product->selectImage($this->providerReference($product))->attr('src')
            : null;
    }

    /**
     * Allows to obtain the application
     * @return string|null
     * @throws Exception
     */
    private function type(): ?string
    {
        return (isset($this->detail['Type']))
            ? $this->detail['Type']
            : null;
    }

    /**
     * Allows to obtain the width
     * @return int|null
     */
    private function width(): ?int
    {
        return (isset($this->detail['Largeur']))
            ? intval(explode('-', $this->detail['Largeur'])[0])
            : null;
    }

    /**
     * Allows to obtain the depth
     * @return int|null
     */
    private function depth(): ?int
    {
        return (isset($this->detail['Profondeur']))
            ? intval(explode('-', $this->detail['Profondeur'])[0])
            : null;
    }

    /**
     * Allows to obtain the height
     * @return int|null
     */
    private function height(): ?int
    {
        return (isset($this->detail['  Hauteur']))
            ? intval(explode('-', $this->detail['  Hauteur'])[0])
            : null;
    }

    /**
     * Allows to obtain the weight
     * @return float|null
     */
    private function weight(): ?float
    {
        if (isset($this->detail['Poids du paquett'])) {
            return floatval(explode('-', $this->detail['Poids du paquet'])[0]);
        }
        if (isset($this->detail['Poids'])) {
            return floatval(explode('-', $this->detail['Poids'])[0]);
        }
        return null;
    }

    /**
     * Allows to get the number of storage bays
     * @return int|null
     */
    private function storageBays(): ?int
    {
        if (isset($this->detail["Nombre de consoles 3.5\""])) {
            return intval($this->detail["Nombre de consoles 3.5\""]);
        }
        if (isset($this->detail["Nombre de baies 2,5 \""])) {
            return intval($this->detail["Nombre de baies 2,5 \""]);
        }
        return null;
    }

}