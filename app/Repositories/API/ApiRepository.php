<?php

namespace PayAny\Repositories\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use \Illuminate\Http\Response;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

abstract class ApiRepository
{
    protected Client $client;
    protected array $headers;
    protected string $method;
    private string $host;

    public function __construct(string $host)
    {
        $this->client = new Client();
        $this->host = $host;
        $this->headers = [];
        $this->method = '';

        $this->setHeaders(['Content-Type' => 'application/json']);
    }

    /**
     * @throws GuzzleException
     */
    private function dispatch(int $timeout = 60): ResponseInterface
    {
        $options = [
            'headers' => $this->getHeaders(),
            'timeout' => $timeout
        ];
        $response = $this->client->request(
            $this->getMethod(),
            $this->host,
            $options
        );
        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new InvalidArgumentException("Endpoint {$this->host} not response!");
        }
        return $response;
    }

    /**
     * @throws GuzzleException
     */
    public function get(array $headers = []): ResponseInterface
    {
        return $this->setMethod('GET')
            ->setHeaders($headers)
            ->dispatch();
    }

    public function setMethod(string $method): ApiRepository
    {
        $this->method = $method;
        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setHeaders(array $headers): ApiRepository
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
}
