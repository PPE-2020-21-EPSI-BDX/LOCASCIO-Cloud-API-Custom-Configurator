<?php

namespace App\Command\Provider\Senetic;

use App\Command\Provider\Senetic\Table\FormFactor;
use App\Command\Provider\Senetic\Table\MotherboardInterface;
use App\Command\Provider\Senetic\Table\MotherboardProcessor;
use App\Command\Provider\Senetic\Table\MotherboardRaidLevel;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Motherboard extends Product
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
     * @throws Exception
     */
    protected function saveProduct(Crawler $product): void
    {
        if ($this->checkExist($_SERVER['APP_HOST'] . '/api/motherboards?provider_reference=' . $this->providerReference($product))) {

            $form_factor = $this->getFromFactor();

            $httpClient = HttpClient::create();

            $response = $httpClient->request('POST', $_SERVER['APP_HOST'] . '/api/motherboards', [
                'headers' => ['Content-Type' => 'application/ld+json'],
                'json' => [
                    "name" => $this->getName($product),
                    "tpm" => $this->tpm(),
                    "formFactor" => (!is_null($form_factor)) ? $form_factor["@id"] : null,
                    "availability" => $this->availability($product),
                    "delivery" => $this->delivery($product),
                    "url" => $this->url(),
                    "price" => $this->price($product),
                    "providerReference" => $this->providerReference($product)
                ],
            ]);

            if ($response->getStatusCode() != 201) {
                dump('Error with the Senectic\Motherboard\saveProduct Method');
                dd($response->getContent());
            }
            $data = $response->toArray();

            $motherboardInterface = new MotherboardInterface($this->detail);
            $motherboardRaidLevel = new MotherboardRaidLevel($this->detail);
            $motherboardProcessor = new MotherboardProcessor($this->detail);
            $motherboardInterface->insertMotherboardInterface($data);
            $motherboardRaidLevel->insertMotherboardRaidLevel($data);
            $motherboardProcessor->insertMotherboardProcessor($data, $this->em);

            dd('ok');

            dump("==========================================================================================");
            dump('    SUCCESS - Insert ' . $this->getName($product) . ' in DB !');
            dump("==========================================================================================");
        } else {
            $this->update($product, $_SERVER['APP_HOST'] . '/api/motherboards/' . $this->productInDB['id']);
        }
    }

    /**
     * Allows to get the form factor
     * @return array|null
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function getFromFactor(): array|null
    {
        if (isset($this->detail['Elément de forme de carte mère'])) {
            $form_factor = new FormFactor();
            return $form_factor->getFormFactorName($this->detail['Elément de forme de carte mère']);
        }
        return null;
    }

    /**
     * @return int|null
     */
    private function tpm(): ?int
    {
        return (isset($this->detail['Puce TPM (Trusted Platform Module)']))
            ? $this->format->convertYesNoToBool($this->detail['Puce TPM (Trusted Platform Module)'])
            : null;
    }
}