<?php

namespace App\Command\Provider\Senetic\Table;


use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class RackFormFactor extends ParentRelationTable
{
    public function __construct(array $detail)
    {
        parent::__construct();
        $this->detail = $detail;
    }

    /**
     * Allows to insert rack form factor information into DB
     * @param array $rack
     * @return void
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function insertRackFormFactor(array $rack): void
    {
        if ($this->checkExist($_SERVER['APP_HOST'] . '/api/rack_form_factors?rack=' . $rack['id'])) {
            if (isset($this->detail['Facteur de forme de carte mère supporté'])) {

                $formFactors = explode(',', $this->detail['Facteur de forme de carte mère supporté']);
                $postUrl = $_SERVER['APP_HOST'] . '/api/rack_form_factors';

                foreach ($formFactors as $element) {
                    $formFactor = new FormFactor();
                    $value = $formFactor->getFormFactorName($element);
                    $data = [
                        "rack" => $rack['@id'],
                        "rackUnit" => (!empty($value)) ? $value['@id'] : null
                    ];
                    $this->insertData($postUrl, $data);
                }
            }
        }
    }
}