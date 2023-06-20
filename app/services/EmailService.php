<?php

namespace app\services;

use app\components\clients\ClientInterface;
use app\components\clients\ClientResolver;
use Exception;

class EmailService
{
    protected ClientInterface $client;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->client = ClientResolver::getClient(ClientResolver::CLIENT_EMAIL);
    }

    public function send(string $message): bool
    {
        $data = [
            'email' => 'test@mail.com',
            'message' => $message
        ];

        return $this->client->send($data);
    }
}