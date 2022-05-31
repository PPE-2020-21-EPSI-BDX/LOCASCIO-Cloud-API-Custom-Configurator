<?php

namespace App\Command\Provider\Senetic\Table;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class RackIndicator extends ParentRelationTable
{
    public function __construct(array $detail)
    {
        parent::__construct();
        $this->detail = $detail;
    }

    /**
     * Allows to insert rack indicator information into DB
     * @param array $rack
     * @return void
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function insertRackIndicators(array $rack): void
    {
        if ($this->checkExist($_SERVER['APP_HOST'] . '/api/rack_indicators?rack=' . $rack['id'])) {
            if (isset($this->detail['Voyants'])) {
                $indicators = explode(',', $this->detail['Voyants']);
                $indicator = new Indicator();
                $postUrl = $_SERVER['APP_HOST'] . '/api/rack_indicators';

                foreach ($indicators as $element) {
                    $value = $indicator->getIndicatorName($element);
                    $data = [
                        "rack" => $rack['@id'],
                        "indicator" => (!empty($value)) ? $value['@id'] : null
                    ];
                    $this->insertData($postUrl, $data);
                }
            }
        }
    }
}