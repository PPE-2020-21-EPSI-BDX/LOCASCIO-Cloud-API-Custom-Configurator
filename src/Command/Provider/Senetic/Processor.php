<?php

namespace App\Command\Provider\Senetic;

use App\Command\Provider\Format;
use DateTimeImmutable;
use DateTimeZone;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class Processor
{

    private HttpBrowser $browser;
    protected ?String $brand;

    protected String $urlProduct;
    protected Format $format;
    private array $specLabel;
    private array $specValue;
    protected array $tempSpecs;

    public function __construct()
    {
        $this->browser = new HttpBrowser(HttpClient::create(['timeout' => 120]));

        $this->urlProduct = "";
        $this->format = new Format();
        $this->specLabel = [];
        $this->specValue = [];
        $this->tempSpecs = [];
    }

    /**
     * Returns the max number of product pages
     * @param String $url main page
     * @return int
     */
    public function getNumberPage(String $url): int
    {
        $crawler = $this->browser->request('GET', $url.'?page=1');

        if ( $crawler->filter('div.pagination > a')->count() != 0 ){
            $element = $crawler->filter('div.pagination > a')->extract(['_text']);
            return intval((array_slice($element, -2, 1)[0]));
        }
    }

    /**
     * Allow to search data for a specif url
     * @param String $url
     * @param String $brand
     * @return void
     */
    public function getInfo(String $url, String $brand): void
    {
        $this->brand = $brand;
        $this->findURLProduct($url);
    }

    /**
     * Allows to capture the url of a product
     */
    private function findURLProduct(String $url): void
    {

        $crawler = $this->browser->request('GET', $url);

        $crawler->filter('div.lista_produktow > a.product-item__wrapper.product-link-events')->each(function ($product){
            $this->urlProduct = $product->attr('href');
            $this->getSpecProduct();
        });
    }

    /**
     * Allows to format a product for the DB
     */
    protected function getSpecProduct(): void
    {
        $crawler = $this->browser->request('GET', $this->urlProduct);

        $crawler->filter('div.product-content')->each(closure: function ($product){
            $this->generateTempSpec($product);
            $this->saveProcessor($product);
        });
    }

    /***
     * Allows to capture the product specifications
     */
    protected function generateTempSpec($product): void
    {
        $product->filter('td.spec-label')->each(function ($element){
            if ($element->count() != 0){
                $this->specLabel[] = $element->text();
            }
        });

        $product->filter('td.spec-value')->each(function ($element){
            if ($element->count() != 0){
                array_push($this->specValue, $element->text());
            }
        });

        $this->tempSpecs = array_combine($this->specLabel, $this->specValue);

        $this->specLabel = [];
        $this->specValue = [];
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Exception
     */
    private function saveProcessor($product): void
    {
        $httpClient = HttpClient::create();

        $response = $httpClient->request('POST', 'http://127.0.0.1/api/processors', [
            'headers' => ['Content-Type' => 'application/ld+json'],
            'json' => [
              "name" => $this->getName($product),
              "brand" => $this->brand,
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
              "maxMemCapacity" => $this->maxMemCapacity(),
              "maxMemSpeed" => $this->maxMemSpeed(),
              "memType" => $this->memType()
            ],
        ]);

        if ($response->getStatusCode() != 201){
            dump('Error with the saveProcessor Method');
            dd($response->getContent());
        }

        dump('');
        dump('Insert ' . $this->getName($product). ' in DB with success !');
        dump('');
    }

    /**
     * Allows to give the name
     * @param Crawler $product
     * @return string
     */
    private function getName(Crawler $product): string
    {
        if ( $product->filter('div.basic-info > div.name')->count() != 0 ){
            return $this->format->removeSpaces(
                str_replace('Nom du produit: ', '', $product->filter('div.basic-info > div.name')->text())
            );
        }
        throw new \TypeError('The product name cannot be null');
    }

    /**
     * Allows to give the availability
     * @param Crawler $crawler
     * @return string|null
     */
    private function availability(Crawler $crawler): ?string
    {

        if ( $crawler->filter('div.stock-info > div.data')->count() != 0 ){
            return $this->format->removeSpaces($crawler->filter('div.stock-info > div.data')->text());
        }
        return $this->checkOutOfStock($crawler);
    }

    /**
     * Allows checking if it out of stock
     * @param Crawler $crawler
     * @return string|null
     */
    private function checkOutOfStock(Crawler $crawler): ?string
    {
        if ( $crawler->filter('div.warehouse-box > div.full-width')->count() != 0){
            return $crawler->filter('div.warehouse-box > div.full-width')->text();
        }
        return null;
    }

    /**
     * Allows to get the date to delivery
     * @param Crawler $crawler
     * @return string|null
     * @throws \Exception
     */
    private function delivery(Crawler $crawler): ?string
    {
        if ($crawler->filter('div.delivery-info > div.data')->count() != 0){

            $data = explode(' ', $crawler->filter('div.delivery-info > div.data')->text());
            $data[0] = $this->format->convertDayEnglish($data[0]);
            $data[2] = $this->format->convertMonthEnglish($data[2]);

            $new = implode(' ', $data);
            $date = new DateTimeImmutable($new, new DateTimeZone('Europe/Paris'));

            return $this->format->removeSpaces($date->format('Y-m-d'));

        }
        return null;
    }


    /**
     * Allows to give the partNumber
     * @param Crawler $product
     * @return string
     */
    private function partNumber(Crawler $product): string
    {
        if ( $product->filter('div.basic-info > h1.sku-number')->count() != 0 ){
            return $this->format->removeSpaces($product->filter('div.basic-info > h1.sku-number')->text());
        }
        throw new \TypeError('The product part number cannot be null');
    }

    /**
     * Allows to give the socket name
     * @return string|null
     */
    private function socket(): ?string
    {
        if ( isset($this->tempSpecs['Socket de processeur (réceptable de processeur)']) ){
            return $this->format->removeSpaces($this->tempSpecs['Socket de processeur (réceptable de processeur)']);
        }
        return null;
    }

    /**
     * Allows to give the number of Max CPU Configuration
     * @return string|null
     */
    private function maxProcessors(): ?string
    {
        if ( isset($this->tempSpecs['Configuration CPU (max)']) ){
            return $this->format->removeSpaces($this->tempSpecs['Configuration CPU (max)']);
        }
        return $this->upi();
    }

    /**
     * Allows to give the number of Max CPU Configuration
     * @return string|null
     */
    private function upi(): ?string
    {
        if ( isset($this->tempSpecs['Nombre de liaisons UPI']) ){
            return $this->format->removeSpaces($this->tempSpecs['Nombre de liaisons UPI']);
        }
        return null;
    }

    /**
     * Allows to give the number of cores
     * @return string|null
     */
    private function cores(): ?string
    {
        if ( isset($this->tempSpecs['Nombre de coeurs de processeurs']) ){
            return $this->format->removeSpaces($this->tempSpecs['Nombre de coeurs de processeurs']);
        }
        return null;
    }

    /**
     * Allows to give the number of threads
     * @return string|null
     */
    private function threads(): ?string
    {
        if ( isset($this->tempSpecs['Nombre de threads du processeur']) ){
            return $this->format->removeSpaces($this->tempSpecs['Nombre de threads du processeur']);
        }
        return null;
    }

    /**
     * Allows to give the tdp
     * @return string|null
     */
    private function tdp(): ?string
    {
        if ( isset($this->tempSpecs['Enveloppe thermique (TDP, Thermal Design Power)']) ){
            return $this->format->removeSpaces($this->tempSpecs['Enveloppe thermique (TDP, Thermal Design Power)']);
        }
        return null;
    }

    /**
     * Allows to give the base frequency
     * @return string|null
     */
    private function baseFeq(): ?string
    {
        if ( isset($this->tempSpecs['Fréquence de base du processeur']) ){
            return $this->format->removeSpaces($this->tempSpecs['Fréquence de base du processeur']);
        }
        return null;
    }

    /**
     * Allows to give the boost frequency
     * @return string|null
     */
    private function boostFreq(): ?string
    {
        if ( isset($this->tempSpecs['Fréquence du processeur Turbo']) ){
            return $this->format->removeSpaces($this->tempSpecs['Fréquence du processeur Turbo']);
        }
        return null;
    }

    /**
     * Allows to give the cache of Processor
     * @return string|null
     */
    private function cache(): ?string
    {
        if ( isset($this->tempSpecs['Mémoire cache du processeur']) ){
            return $this->format->removeSpaces($this->tempSpecs['Mémoire cache du processeur']);
        }
        return null;
    }

    /**
     * Allows to give the max memory size
     * @return string|null
     */
    private function maxMemCapacity(): ?string
    {
        if( isset($this->tempSpecs['Mémoire interne maximum prise en charge par le processeur']) ){
            return $this->format->removeSpaces($this->tempSpecs['Mémoire interne maximum prise en charge par le processeur']);
        }
        return null;
    }

    /**
     * Allows to give the max memory speed
     * @return string|null
     */
    private function maxMemSpeed(): ?string
    {
        if( isset($this->tempSpecs["Vitesses d'horloge de mémoire prises en charge par le processeur"]) ){
            return $this->format->removeSpaces($this->tempSpecs["Vitesses d'horloge de mémoire prises en charge par le processeur"]);
        }
        return null;
    }

    /**
     * Allows to give the memory type
     * @return string|null
     */
    private function memType(): ?string
    {
        if( isset($this->tempSpecs['Types de mémoires pris en charge par le processeur']) ){
            return $this->format->removeSpaces($this->tempSpecs['Types de mémoires pris en charge par le processeur']);
        }elseif ( isset($this->tempSpecs['Type de mémoire interne']) ){
            return $this->format->removeSpaces($this->tempSpecs['Type de mémoire interne']);
        }
        return null;
    }

    /**
     * Allows to give the max of memory channel(s)
     * @return int|null
     */
    private function maxMemChannel(): ?int
    {
        if( isset($this->tempSpecs['Canaux de mémoire']) ){
            return $this->format->convertLetterChannelToInt($this->tempSpecs['Canaux de mémoire']);
        }
        return null;
    }

    /**
     * Allows to identify if it supports ecc
     * @return ?bool
     */
    private function ecc(): bool|null
    {
        if( isset($this->tempSpecs['ECC']) ){
            return $this->format->convertYesNoToBool($this->tempSpecs['ECC']);
        }
        return null;
    }

    /**
     * Allows identifying if it has a graphic processor
     * @return bool|null
     */
    private function graficsProcessor(): ?bool
    {
        if ( isset($this->tempSpecs['Carte graphique intégrée']) ){
            return $this->format->convertYesNoToBool($this->tempSpecs['Carte graphique intégrée']);
        }
        return null;
    }

    /**
     * Allows identifying what's it for
     * @return string|null
     */
    private function application(): ?string
    {
        if ( isset($this->tempSpecs['composant pour'])  ){
            return $this->format->removeSpaces($this->tempSpecs['composant pour']);
        }
        return null;
    }

    /**
     * Allows to give the url
     * @return string
     */
    private function url(): string
    {
        return $this->format->removeSpaces($this->urlProduct);
    }

    /**
     * Allows to give the price
     * @param Crawler $product
     * @return float|null
     */
    private function price(Crawler $product): ?float
    {
        $element = $product->filter('div.prices-box > div.gross-price');
        $deliveryCost = $this->deliveryCost($product);

        if( $element->count() !=0 ){
            $price = preg_replace('/[^0-9,]/', '', $element->text());
            $price = str_replace(',', '.', $price);
            $price = floatval($price);
            return $price + $deliveryCost;
        }
        return null;
    }

    /**
     * Allows to give the provider reference
     * @param Crawler $product
     * @return string|null
     */
    private function providerReference(Crawler $product): ?string
    {
        if ( $product->filter('div.basic-info > div.ean-number')->nextAll()->count() != 0 ){
            return $this->format->removeSpaces(
                str_replace('Part number : ', '', $product->filter('div.basic-info > div.ean-number')->nextAll()->text())
            );
        }
        return null;
    }

    /**
     * Allows to get the delivery cost
     * @param Crawler $crawler
     * @return float
     */
    private function deliveryCost(Crawler $crawler): float
    {
        $element = $crawler->filter('div.shipment-box > div.usp-info');
        $deliveryCost = 0.0;

        if ( $element->count() != 0 ){
            $deliveryCost = preg_replace('/[^0-9,]/', '', $element->text());
            $deliveryCost = str_replace(',', '.', $deliveryCost);
            $deliveryCost = $this->format->removeSpaces($deliveryCost);
            $deliveryCost = floatval($deliveryCost);
        }

        return $deliveryCost;
    }
}