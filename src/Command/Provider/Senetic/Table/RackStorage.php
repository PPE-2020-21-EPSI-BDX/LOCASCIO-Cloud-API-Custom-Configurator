<?php

namespace App\Command\Provider\Senetic\Table;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class RackStorage extends ParentRelationTable
{
    public function __construct(array $detail)
    {
        parent::__construct();
        $this->detail = $detail;
    }

    /**
     * Allows to insert rack storage information into DB
     * @param array $rack
     * @return void
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function insertRackStorage(array $rack): void
    {
        if ($this->checkExist($_SERVER['APP_HOST'] . '/api/rack_storages?rack=' . $rack['id'])) {
            if (isset($this->detail['Tailles de disques durs supportées'])) {
                $diskFormFactor = $this->detail['Tailles de disques durs supportées'];
            }
            if (isset($this->detail['Interfaces de disque dur soutenues'])) {
                $storageConnector = $this->detail['Interfaces de disque dur soutenues'];
            }
            if (isset($this->detail["D'interface pour unité de stockage"])) {
                $storageConnector = $this->detail["D'interface pour unité de stockage"];
            }

            $formFactor = new FormFactor();
            $connector = new Connector();
            $postUrl = $_SERVER['APP_HOST'] . '/api/rack_storages';

            if (isset($diskFormFactor)) {
                $diskFormFactors = explode(',', $diskFormFactor);
                foreach ($diskFormFactors as $item) {
                    $disksIRIes[] = $formFactor->getFormFactorName($item)["@id"];
                }
            }

            if (isset($storageConnector)) {
                $storageConnectors = explode(',', $storageConnector);
                foreach ($storageConnectors as $item) {
                    $connectorIRIes[] = $connector->getConnectorName($item)["@id"];
                }
            }

            if (isset($disksIRIes) && isset($connectorIRIes)) {
                foreach ($disksIRIes as $disksIRIe) {
                    foreach ($connectorIRIes as $connectorIRIe) {
                        $data = [
                            "rack" => $rack["@id"],
                            "diskFormFactor" => $disksIRIe ?? null,
                            "storageConnector" => $connectorIRIe ?? null
                        ];

                        $this->insertData($postUrl, $data);
                    }
                }
            }
        }
    }
}