<?php

declare(strict_types=1);

namespace RedsysRest;

use GuzzleHttp\ClientInterface;
use RedsysRest\Exceptions\RedsysError;
use RedsysRest\Exceptions\UnconfiguredClient;
use RedsysRest\Orders\Order;
use stdClass;

class Client
{
    private $client;
    private $builder;
    private $config;

    public function __construct(

        ?Configurator $config = null
    ) {

        $this->client = new \GuzzleHttp\Client;
        $this->builder = new RequestBuilder(new Encrypter);
        $this->config = $config;
    }

    public function withConfig(Configurator $config): self
    {
        return new self($this->builder, $config);
    }

    public function config(): Configurator
    {
        return $this->config;
    }

    public function execute(Order $order): stdClass
    {
        if ($this->config === null) {
            throw UnconfiguredClient::create();
        }

        $params = $this->config->buildParamsFor($order);

        $request = $this->builder->build($this->config, $params);

        $response = $this->client->send($request);

        $responseBody = json_decode($response->getBody()->getContents(), true);

        if (isset($responseBody['errorCode'])) {
            throw RedsysError::create($responseBody["errorCode"]);
        } else {
            if (isset($responseBody["Ds_MerchantParameters"])) {
                $decrypter = new Decrypter();
                $finalResponse = $decrypter->decodeParameters($responseBody["Ds_MerchantParameters"]);
                return $finalResponse;
            } else {
                throw RedsysError::create("SIS-REST-00001");
            }
        }
    }
}
