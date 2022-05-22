<?php

namespace App\Command\Provider\Senetic;

use App\Command\Provider\Format;
use DateTimeImmutable;
use DateTimeZone;
use Exception;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use TypeError;

class Product
{
    protected HttpBrowser $browser;

    protected Format $format;

    protected string $urlProduct;
    protected array $detail;
    private array $specLabel;
    private array $specValue;

    protected function __construct()
    {
        $this->browser = new HttpBrowser(HttpClient::create(['timeout' => 120]));

        $this->format = new Format();

        $this->urlProduct = "";
        $this->specLabel = [];
        $this->specValue = [];
        $this->detail = [];
    }

    /**
     * Returns the max number of product pages
     * @param String $url main page
     * @return int
     */
    public function getNumberPage(string $url): int
    {
        $crawler = $this->browser->request('GET', $url . '?page=1');

        if ($crawler->filter('div.pagination > a')->count() != 0) {
            $element = $crawler->filter('div.pagination > a')->extract(['_text']);
            return intval((array_slice($element, -2, 1)[0]));
        }
    }

    /**
     * Allow to search data for a specif url
     * @param String $url
     * @return void
     * @throws Exception
     */
    public function getInfo(string $url): void
    {
        $this->findURLProduct($url);
    }

    /**
     * Allows to capture the url of a product
     * @throws Exception
     */
    protected function findURLProduct(string $url): void
    {

        $crawler = $this->browser->request('GET', $url);

        $crawler->filter('div.lista_produktow > a.product-item__wrapper.product-link-events')->each(function ($product) {
            $this->urlProduct = $product->attr('href');
            $this->getSpecProduct();
        });
    }

    /**
     * Allows to format a product for the DB
     * @throws Exception
     */
    protected function getSpecProduct(): void
    {
        $crawler = $this->browser->request('GET', $this->urlProduct);

        $crawler->filter('div.product-content')->each(closure: function ($product) {
            $this->generateTempSpec($product);
            $this->saveProduct($product);
        });
    }

    /***
     * Allows to capture the product specifications
     */
    protected function generateTempSpec($product): void
    {
        $product->filter('td.spec-label')->each(function ($element) {
            if ($element->count() != 0) {
                $this->specLabel[] = $element->text();
            }
        });

        $product->filter('td.spec-value')->each(function ($element) {
            if ($element->count() != 0) {
                $this->specValue[] = $element->text();
            }
        });

        $this->detail = array_combine($this->specLabel, $this->specValue);

        $this->specLabel = [];
        $this->specValue = [];
    }

    /**
     * Allows to send data to the API endpoint
     * @throws Exception
     */
    protected function saveProduct(Crawler $product): void
    {
        throw new Exception('Not Implemented Method');
    }

    /**
     * Allows to check whether a product already exists in the database
     * @param String $url
     * @return bool
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function checkExist(string $url): bool
    {
        $httpClient = HttpClient::create();

        $response = $httpClient->request('GET', $url, [
            'headers' => ['Content-Type' => 'application/ld+json']
        ]);

        $data = $response->toArray();

        return !(($data['hydra:totalItems'] > 0));
    }

    /**
     * Allows to give the name
     * @param Crawler $product
     * @return string
     */
    protected function getName(Crawler $product): string
    {
        if ($product->filter('div.basic-info > div.name')->count() != 0) {
            return $this->format->removeSpaces(
                str_replace('Nom du produit: ', '', $product->filter('div.basic-info > div.name')->text())
            );
        }
        throw new TypeError('The product name cannot be null');
    }

    /**
     * Allows to give the brand name
     * @param Crawler $product
     * @return string
     */
    protected function getBrand(Crawler $product): string
    {
        return $product->filter('div.vendor-logo > meta')->attr('content');
    }

    /**
     * Allows to give the availability
     * @param Crawler $crawler
     * @return string|null
     */
    protected function availability(Crawler $crawler): ?string
    {

        if ($crawler->filter('div.stock-info > div.data')->count() != 0) {
            return $this->format->removeSpaces($crawler->filter('div.stock-info > div.data')->text());
        }
        return $this->checkOutOfStock($crawler);
    }

    /**
     * Allows checking if it out of stock
     * @param Crawler $crawler
     * @return string|null
     */
    protected function checkOutOfStock(Crawler $crawler): ?string
    {
        if ($crawler->filter('div.warehouse-box > div.full-width')->count() != 0) {
            return $crawler->filter('div.warehouse-box > div.full-width')->text();
        }
        return null;
    }

    /**
     * Allows to get the date to delivery
     * @param Crawler $crawler
     * @return string|null
     * @throws Exception
     */
    protected function delivery(Crawler $crawler): ?string
    {
        if ($crawler->filter('div.delivery-info > div.data')->count() != 0) {

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
     * Allows to give the url
     * @return string
     */
    protected function url(): string
    {
        return $this->format->removeSpaces($this->urlProduct);
    }

    /**
     * Allows to give the price
     * @param Crawler $product
     * @return float|null
     */
    protected function price(Crawler $product): ?float
    {
        $element = $product->filter('div.prices-box > div.gross-price');
        $deliveryCost = $this->deliveryCost($product);

        if ($element->count() != 0) {
            $price = preg_replace('/[^0-9,]/', '', $element->text());
            $price = str_replace(',', '.', $price);
            $price = floatval($price);
            return $price + $deliveryCost;
        }
        return null;
    }

    /**
     * Allows to get the delivery cost
     * @param Crawler $crawler
     * @return float
     */
    protected function deliveryCost(Crawler $crawler): float
    {
        $element = $crawler->filter('div.shipment-box > div.usp-info');
        $deliveryCost = 0.0;

        if ($element->count() != 0) {
            $deliveryCost = preg_replace('/[^0-9,]/', '', $element->text());
            $deliveryCost = str_replace(',', '.', $deliveryCost);
            $deliveryCost = $this->format->removeSpaces($deliveryCost);
            $deliveryCost = floatval($deliveryCost);
        }

        return $deliveryCost;
    }

    /**
     * Allows to give the provider reference
     * @param Crawler $product
     * @return string|null
     */
    protected function providerReference(Crawler $product): ?string
    {
        if ($product->filter('div.basic-info > div.ean-number')->nextAll()->count() != 0) {
            return $this->format->removeSpaces(
                str_replace('Part number : ', '', $product->filter('div.basic-info > div.ean-number')->nextAll()->text())
            );
        }
        return null;
    }
}