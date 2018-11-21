<?php

namespace Mannysoft\FreshSales;

use Mannysoft\FreshSales\Client;
use Exception;

class Api
{
    public $client;
    public $tags;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function leads($data)
    {
        return $this->client->leads($data);
    }

    public function deleteLead($id)
    {
        return $this->client->deleteLead($id);
    }

    public function contacts($data)
    {
        return $this->client->contacts($data);
    }

    public function deleteContact($id)
    {
        return $this->client->deleteContact($id);
    }

    public function updateContact($data, $id)
    {
        return $this->client->updateContact($data, $id);
    }

    private static function assert($value, $msg)
    {
        if ( ! $value ) {
            throw new Exception($msg);
        } 
    }
}
