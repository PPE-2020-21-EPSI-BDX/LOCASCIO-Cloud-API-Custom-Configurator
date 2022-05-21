<?php

namespace App\Tests;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;

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
