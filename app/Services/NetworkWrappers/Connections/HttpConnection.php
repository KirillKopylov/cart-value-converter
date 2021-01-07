<?php


namespace App\Services\NetworkWrappers\Connections;


use App\Services\NetworkWrappers\Interfaces\ConnectionInterface;
use App\Services\NetworkWrappers\Exceptions\RequestException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class HttpConnection implements ConnectionInterface
{
    public function request(string $url, string $method = 'get', array $params = []): string
    {
        $response = null;
        try {
            switch ($method) {
                case 'get':
                {
                    $response = Http::get($url, $params);
                    break;
                }
                case 'post':
                {
                    $response = Http::post($url, $params);
                    break;
                }
                default:
                {
                    throw new RequestException("Request method '{$method}' not implemented yet.");
                }
            }
            if ($response->ok()) {
                return $response->body();
            } else {
                throw new RequestException("Invalid status code: {$response->status()}");
            }
        } catch (ConnectionException $connectionException) {
            throw new RequestException($connectionException->getMessage());
        }
    }
}
