<?php


namespace App\Services\NetworkWrappers;


use App\Services\NetworkWrappers\Interfaces\ConnectionInterface;
use App\Services\NetworkWrappers\Connections\HttpConnection;

class RequestWrapper
{
    private $connection;

    public function __construct(ConnectionInterface $connection = null)
    {
        if (is_null($connection)) {
            $this->connection = new HttpConnection;
        } else {
            $this->connection = $connection;
        }
    }

    public function get(string $url, array $params = []): string
    {
        return $this->connection->request($url, 'get', $params);
    }

    public function post(string $url, array $params = []): string
    {
        return $this->connection->request($url, 'post', $params);
    }
}
