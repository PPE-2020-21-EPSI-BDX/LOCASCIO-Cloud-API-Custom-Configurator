<?php

namespace App\Command\Provider\Senetic\Table;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class MotherboardInterface extends ParentRelationTable
{
    public function __construct(array $detail)
    {
        parent::__construct();
        $this->detail = $detail;
    }

    /**
     * Allows to insert motherboard connector information into DB
     * @param array $motherboard
     * @return void
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws DecodingExceptionInterface
     */
    public function insertMotherboardInterface(array $motherboard): void
    {
        $connector = new Connector();
        $sas = isset($this->detail['Ports SAS intégrés']) ? intval($this->detail['Ports SAS intégrés']) : null;
        $usb2_0 = isset($this->detail['Connecteurs USB 2.0']) ? intval($this->detail['Connecteurs USB 2.0']) : null;
        $usb3_2 = isset($this->detail['connecteurs USB 3.2 Gen 1 (3.1 Gen 1)']) ? intval($this->detail['connecteurs USB 3.2 Gen 1 (3.1 Gen 1)']) : null;
        $lanRj45 = isset($this->detail["Nombre de port ethernet LAN (RJ-45)"]) ? intval($this->detail["Nombre de port ethernet LAN (RJ-45)"]) : null;
        $lanSpeed = explode(',', $this->detail["Type d'interface Ethernet"]);
        $ipmi = isset($this->detail['Port IPMI LAN (RJ-45)']) ? $this->format->convertYesNoToBool($this->detail['Port IPMI LAN (RJ-45)']) : null;
        $vga = isset($this->detail['Nombre de ports VGA (D-Sub)']) ? intval($this->detail['Nombre de ports VGA (D-Sub)']) : null;
        $com = isset($this->detail['Quantité de ports COM']) ? intval($this->detail['Quantité de ports COM']) : null;

        !is_null($sas) ? $this->saveData($sas, $motherboard["@id"], $connector->getConnectorName($this->detail['Interfaces de lecteur de stockage prises en charge'])["@id"]) : '';
        !is_null($usb2_0) ? $this->saveData($usb2_0, $motherboard["@id"], $connector->getConnectorName("USB-2.0")["@id"]) : '';
        !is_null($usb3_2) ? $this->saveData($usb3_2, $motherboard["@id"], $connector->getConnectorName("USB-3.2")["@id"]) : '';

        $maxTransferSpeed = (count($lanSpeed) > 1 && !is_null($ipmi))
            ? [
                "RJ-45" => $lanSpeed[0],
                "RJ-45-IPMI" => end($lanSpeed)
            ]
            : [
                "RJ-45" => $lanSpeed[0],
                "RJ-45-IPMI" => $lanSpeed[0]
            ];

        !empty($maxTransferSpeed) ? $this->saveData($lanRj45, $motherboard["@id"], '', $maxTransferSpeed) : '';


        !is_null($vga) ? $this->saveData($vga, $motherboard["@id"], $connector->getConnectorName("VGA")["@id"]) : '';
        !is_null($com) ? $this->saveData($com, $motherboard["@id"], $connector->getConnectorName("Port-série-COM")["@id"]) : '';
    }

    /**
     * Allows to insert data in the Motherboard Interface endpoint
     * @param int|null $loop
     * @param string $id_motherboard
     * @param string|null $id_connector
     * @param array|null $additional_information
     * @return void
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function saveData(?int $loop, string $id_motherboard, string $id_connector = null, array $additional_information = null): void
    {
        if (!is_null($loop) && !empty($id_connector)) {
            for ($i = 1; $i <= $loop; $i++) {
                $postUrl = $_SERVER['APP_HOST'] . '/api/motherboard_interfaces';
                $data = [
                    "motherboard" => $id_motherboard,
                    "connector" => $id_connector
                ];
                $this->insertData($postUrl, $data);
            }
        }

        if (empty($id_connector) && !is_null($additional_information)) {

            $postUrlConnector = $_SERVER['APP_HOST'] . '/api/connectors';
            $postUrlMotherboardInterface = $_SERVER['APP_HOST'] . '/api/motherboard_interfaces';

            $keys = array_keys($additional_information);

            // We insert all rj45 connectors in the MotherboardInterface table
            for ($i = 0; $i < $loop; $i++) {
                $getUrlConnector = $_SERVER['APP_HOST'] . '/api/connectors?name=' . $keys[0] . '&max_transfer_speed=' . $additional_information[$keys[0]];
                $connector = $this->returnSelectOrInsertData($getUrlConnector, $postUrlConnector, [
                    "name" => $keys[0],
                    "maxTransferSpeed" => $additional_information[$keys[0]]
                ]);
                $this->insertData($postUrlMotherboardInterface, [
                    "motherboard" => $id_motherboard,
                    "connector" => $connector["@id"]
                ]);
            }

            // We insert the ipmi rj45 connector in the MotherboardInterface table
            $getUrlConnector = $_SERVER['APP_HOST'] . '/api/connectors?name=' . $keys[1] . '&max_transfer_speed=' . $additional_information[$keys[1]];
            $connector = $this->returnSelectOrInsertData($getUrlConnector, $postUrlConnector, [
                "name" => $keys[1],
                "maxTransferSpeed" => $additional_information[$keys[1]]
            ]);
            $this->insertData($postUrlMotherboardInterface, [
                "motherboard" => $id_motherboard,
                "connector" => $connector["@id"]
            ]);

        }
    }
}