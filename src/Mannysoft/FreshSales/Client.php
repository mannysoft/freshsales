<?php

namespace Mannysoft\FreshSales;

use Mannysoft\FreshSales\CurlTransport;
use stdClass;

class Client
{
    private $curlTrans;

    public function __construct()
    {
        $this->curlTrans = new CurlTransport();
    }

    public function leads($data)
    {
        $body = [];
        $body['lead'] = $this->toObject($data);
        $response = $this->curlTrans->post('leads', $body);
        return $this->response($response, $key = 'lead');
    }

    public function deleteLead($id = null)
    {
        if ($id == null) {
            return;
        }
        return $this->curlTrans->delete('leads/' . $id);
    }

    public function contacts($data)
    {
        $body = [];
        $body['contact'] = $this->toObject($data);
        $response = $this->curlTrans->post('contacts', $body);
        return $this->response($response, $key = 'contact');
    }

    public function deleteContact($id)
    {
        if ($id == null) {
            return;
        }
        return $this->curlTrans->delete('contacts/' . $id);
    }

    public function updateContact($data, $id)
    {
        $body = [];
        $body['contact'] = $this->toObject($data);
        $response = $this->curlTrans->put('contacts/' . $id, $body);
        return $this->response($response, $key = 'contact');
    }

    public function response($response, $key)
    {
        if ($this->curlTrans->statusCode == 200) {
            return $this->toArray($response, $key);
        }
    }

    public function toArray($response, $key)
    {
        $body = json_decode($response->getBody(), true);
        return $body[$key];
    }

    /**
     * Utility method to convert array members to an object
     * @param array $prop
     * @return stdClass
     */
    private function toObject(array $prop)
    {
        $object = new stdClass();
        foreach ($prop as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }
}
