<?php


namespace App\Services\NetworkWrappers\Interfaces;


interface ConnectionInterface
{
    public function request(string $url, string $method = 'get', array $params = []): string;
}
