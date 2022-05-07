<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use mysql_xdevapi\Exception;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ParentTest extends ApiTestCase
{
    /**
     *  A method of writing data to a text file
     * @param string $msg Custom Response Object
     * @param string $folder Custom Path
     */
    protected function writeDataLog(string $msg, string $folder){
        date_default_timezone_set('Europe/Paris');
        $file = fopen('tests/logs/'. $folder .'/logs-' . date("d-m-Y H-i-s") . '.json', "w");
        fwrite($file, $msg);
        fclose($file);
    }

    /**
     * A method of checking response test
     * @param $response
     */
    protected function check_response($response){
        try {
            $temp = new \stdClass();
            
            $temp->caller = debug_backtrace()[1]['class'] . "::". debug_backtrace()[1]['function'];
            $temp->getInfo = $response->getInfo();

            $response->getStatusCode() != 200 ? $this->writeDataLog(json_encode($temp), "errors") : 'Nothing';

            if ($response->getStatusCode() == 200 && $response->getContent() !== null){
                $temp->getContent = json_decode($response->getContent());
            }elseif($response->getStatusCode() == 200 && $response->getHeaders() !== null){
                $temp->getHeaders = json_decode($response->getHeaders());
            }

            $this->writeDataLog(json_encode($temp), "success");

        } catch (TransportExceptionInterface | ServerExceptionInterface | RedirectionExceptionInterface | ClientExceptionInterface $e) {
            $temp = new \stdClass();
            $temp->caller = debug_backtrace()[1]['class'] . "::". debug_backtrace()[1]['function'];
            $temp->errorMessage = $e->getMessage();
            $temp->getResponse = $e->getResponse();
            $this->writeDataLog(json_encode($temp), "errors");
        }
    }
}