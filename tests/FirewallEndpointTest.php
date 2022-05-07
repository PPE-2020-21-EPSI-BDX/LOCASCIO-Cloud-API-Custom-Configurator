<?php

namespace App\Tests;

use PHPUnit\Framework\AssertionFailedError;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class FirewallEndpointTest extends ParentTest
{

    /**
     * A method of checking whether all the basic elements can be obtained.
     * @throws TransportExceptionInterface
     */
    public function testGetAllElements(): void
    {
        $response = static::createClient()->request('GET', '/api/firewalls', [
            'json' => 'application/ld+json; charset=utf-8'
        ]);
        $this->check_response($response);
    }

    /**
     * A method of checking whether a specific element can be obtained
     * @throws TransportExceptionInterface
     */
    public function testGetOneElement(): void
    {
        $response = static::createClient()->request('GET', '/api/firewalls/1', [
            'json' => 'application/ld+json; charset=utf-8'
        ]);
        $this->check_response($response);
    }
}
