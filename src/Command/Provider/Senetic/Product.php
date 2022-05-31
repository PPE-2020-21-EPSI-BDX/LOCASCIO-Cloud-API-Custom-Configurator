<?php

namespace App\Command\Provider\Senetic;

use App\Command\Provider\Format;
use ArrayObject;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Exception;
use stdClass;
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
    protected array $productInDB;

    protected function __construct()
    {
        $this->browser = new HttpBrowser(HttpClient::create(['timeout' => 120]));

        $this->format = new Format();

        $this->urlProduct = "";
        $this->specLabel = [];
        $this->specValue = [];
        $this->detail = [];
        $this->productInDB = [];
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
                $temp = preg_replace('/\B\s/', '', $this->format->removeSpaces($element->text()));
                $this->specLabel[] = $element->text();
            }
        });

        $product->filter('td.spec-value')->each(function ($element) {
            if ($element->count() != 0) {
                $this->specValue[] = $this->format->removeSpaces($element->text());
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

        $this->productInDB = ($data['hydra:totalItems'] > 0) ? $data['hydra:member'][0] : [];

        return !(($data['hydra:totalItems'] > 0));
    }

    /**
     * Allows to update the delivery, price an availability of products in DB
     * @throws Exception
     * @throws TransportExceptionInterface
     */
    protected function update(Crawler $product, string $url): bool
    {
        $temp = new stdclass;

        $new_date = new DateTime($this->delivery($product));
        $new_price = floatval($this->price($product));
        $new_availability = intval($this->availability($product));

        if (isset($this->productInDB['delivery'])) {
            $old_date = new DateTime($this->productInDB['delivery']);
            $temp->delivery = ($new_date > $old_date) ? $new_date->format('Y-m-d') : (($old_date > $new_date) ? $old_date->format('Y-m-d') : null);
        } else {
            $temp->delivery = $new_date->format('Y-m-d');
        }

        if (isset($this->productInDB['price'])) {
            $old_price = floatval($this->productInDB['price']);
            $temp->price = ($new_price > $old_price) ? $new_price : (($old_price > $new_price) ? $old_price : null);
        } else {
            $temp->price = $new_price;
        }

        if (isset($this->productInDB['availability'])) {
            $old_availability = intval($this->productInDB['availability']);
            $temp->availability = ($new_availability > $old_availability) ? $new_availability : (($old_availability > $new_availability) ? $old_availability : null);
        } else {
            $temp->availability = $new_availability;
        }

        $update_field = "";

        foreach (get_object_vars($temp) as $key => $value) {
            $array_keys = array_keys(get_object_vars($temp));
            $last_key = end($array_keys);

            if (is_null($value)) {
                unset($temp->$key);
            }

            $update_field .= ($key == $last_key) ? ' ' . $key : ' ' . $key . ',';
        }

        if ((new ArrayObject($temp))->count() > 0) {

            $httpClient = HttpClient::create();

            $response = $httpClient->request('PATCH', $url, [
                'headers' => ['accept' => 'application/ld+json', 'Content-Type' => 'application/merge-patch+json'],
                'json' => $temp,
            ]);

            if ($response->getStatusCode() != 200) {
                dump('Error with the Senectic\Product\update Method');
                dd($response->getContent());
            }
            dump("============================================================================================================================================");
            dump('    SUCCESS - UPDATE The' . $update_field . ' field(s) of the product ' . $this->getName($product) . ' in DB !');
            dump("============================================================================================================================================");
            return true;
        } else {
            dump("============================================================================================================================================");
            dump('    WARNING - All fields of the ' . $this->getName($product) . ' are already updated in DB !');
            dump("============================================================================================================================================");
            return false;
        }
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
     * @return int|null
     * @throws Exception
     */
    protected function availability(Crawler $crawler): ?int
    {
        if ($crawler->filter('div.stock-info > div.data')->count() != 0) {
            return $this->format->convertAvaiability($crawler->filter('div.stock-info > div.data')->text());
        }
        return $this->checkOutOfStock($crawler);
    }

    /**
     * Allows checking if it out of stock
     * @param Crawler $crawler
     * @return int|null
     * @throws Exception
     */
    protected function checkOutOfStock(Crawler $crawler): ?int
    {
        if ($crawler->filter('div.warehouse-box > div.full-width')->count() != 0) {
            return $this->format->convertOutOfStock($crawler->filter('div.warehouse-box > div.full-width')->text());
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

    /**
     * Allows identifying what's it for
     * @return string|null
     */
    protected function application(): ?string
    {
        if (isset($this->detail['composant pour'])) {
            return $this->format->removeSpaces($this->detail['composant pour']);
        }
        return null;
    }
}