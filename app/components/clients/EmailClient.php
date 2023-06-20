<?php

namespace app\components\clients;

class EmailClient implements ClientInterface
{
    public function send(array $messageData): bool
    {
        return true;
    }
}