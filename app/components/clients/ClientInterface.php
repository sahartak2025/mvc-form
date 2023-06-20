<?php

namespace app\components\clients;

interface ClientInterface
{
    public function send(array $messageData): bool;
}