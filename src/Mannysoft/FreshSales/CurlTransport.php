<?php

namespace Mannysoft\FreshSales;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientException;
use GuzzleHttp\Psr7\Request;
use Log;

class CurlTransport
{
    private $domain;
   
    private $appToken;

    public $headers = null;

    public $statusCode = null;

    public function __construct()
    {
        $this->domain = config('freshsales.domain');
    }

    public function post($action, $body)
    {
        return $this->call($action, 'POST', $body);
    }

    public function put($action, $body)
    {
        return $this->call($action, 'PUT', $body);
    }

    public function delete($action)
    {
        return $this->call($action, 'DELETE');
    }

    public function call($action, $method = 'GET', $body = null)
    {
        $client = new Client();
        
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Token token=' . config('freshsales.api_key'),
        ];

        $error = '';

        $options = [
            'headers' => $headers,
            'json' => $body
        ];

        if ($method == 'DELETE') {
            unset($options['json']);
        }

        try {
            $response = $client->request($method, $this->constructUrl($action), $options);
            $this->statusCode = $response->getStatusCode();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $error = $e->getMessage();
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $this->statusCode = $response->getStatusCode();
            }
        }

        if ($response->getStatusCode() != 200) {
            throw new Exception('Freshsales encountered an error. CODE: ' . $this->statusCode . ' Error: ' . $error);
        }

        return $response;
    }

    private function constructUrl($action)
    {
        return $this->domain . '/api/'  . $action;
    }
}
