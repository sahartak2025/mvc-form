<?php

namespace app\components\clients;

class SmsClient implements ClientInterface
{

    public function send(array $messageData): bool
    {
        return true;
    }
}