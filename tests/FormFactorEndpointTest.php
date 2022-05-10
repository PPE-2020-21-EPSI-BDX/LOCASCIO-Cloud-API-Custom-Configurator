<?php

namespace App\Tests;

class FormFactorEndpointTest extends ParentTest
{
    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testGetAllElements(): void
    {
        $response = static::createClient()->request('GET', '/api/form_factors', [
            'json' => 'application/ld+json; charset=utf-8'
        ]);
        $this->check_response($response);
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testGetOneElement(): void
    {
        $response = static::createClient()->request('GET', '/api/form_factors/1', [
            'json' => 'application/ld+json; charset=utf-8'
        ]);
        $this->check_response($response);
    }
}
