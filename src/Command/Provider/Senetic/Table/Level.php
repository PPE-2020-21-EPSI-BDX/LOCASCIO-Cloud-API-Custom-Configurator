<?php

namespace App\Command\Provider\Senetic\Table;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Level extends ParentRelationTable
{
    /**
     * Allows to get an indicator
     * @param int $level
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getRaidLevel(int $level): array
    {
        $postUrl = $_SERVER['APP_HOST'] . '/api/levels';
        $getUrl = $_SERVER['APP_HOST'] . '/api/levels?level=' . $level;

        $data = ["level" => $level, "minDisk" => $this->minDisk($level)];
        return $this->returnSelectOrInsertData($getUrl, $postUrl, $data);
    }

    /**
     * Returns the number of min discs for a raid level.
     * @param int $level
     * @return int
     */
    private function minDisk(int $level): int
    {
        return match ($level) {
            1, 0 => 2,
            2, 3, 4, 5 => 3,
            6, 10 => 4,
            50, 60 => 6,
            default => $level,
        };
    }
}