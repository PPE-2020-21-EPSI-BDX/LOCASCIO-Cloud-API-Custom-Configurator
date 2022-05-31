<?php

namespace App\Command\Provider\Senetic\Table;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class RackPower extends ParentRelationTable
{
    public function __construct(array $detail)
    {
        parent::__construct();
        $this->detail = $detail;
    }

    /**
     * Enables the rack power information to be inserted into DB
     * @param array $rack
     * @return void
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function insertRackPowers(array $rack): void
    {
        if ($this->checkExist($_SERVER['APP_HOST'] . '/api/rack_powers?rack=' . $rack['id'])) {
            $is_included = (isset($this->detail["Bloc d'alimentation inclus"])) ? $this->format->convertYesNoToBool($this->detail["Bloc d'alimentation inclus"]) : 0;
            $is_redundant = (isset($this->detail["Alimentation redondante (RPS)"])) ? $this->format->convertYesNoToBool($this->detail['Alimentation redondante (RPS)']) : 0;

            if (isset($this->detail["Alimentation d'énergie"])) {
                $capacity = intval(str_replace('W', '', $this->format->removeSpaces($this->detail["Alimentation d'énergie"])));
            }
            if (isset($this->detail["Capacite de l'unité d'alimentation (PSU)"])) {
                $capacity = intval(str_replace('W', '', $this->format->removeSpaces($this->detail["Capacite de l'unité d'alimentation (PSU)"])));
            }

            if (isset($capacity)) {
                $power = new Power();
                $element = $power->getPowerCapacity($capacity);
            }

            $data = [
                "rack" => $rack['@id'],
                "power" => (isset($element)) ? $element['@id'] : null,
                "powerSupplyIncluded" => $is_included,
                "redundantPower" => $is_redundant
            ];
            $postUrl = $_SERVER['APP_HOST'] . '/api/rack_powers';

            $this->insertData($postUrl, $data);
        }
    }
}