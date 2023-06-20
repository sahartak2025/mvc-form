<?php

namespace app\services;

use app\components\clients\ClientInterface;
use app\components\clients\ClientResolver;
use Exception;

class SmsService
{
    protected ClientInterface $client;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->client = ClientResolver::getClient(ClientResolver::CLIENT_SMS);
    }

    public function send(string $message): bool
    {
        $data = [
            'number' => '0000000000',
            'message' => $message
        ];

        return $this->client->send($data);
    }
}