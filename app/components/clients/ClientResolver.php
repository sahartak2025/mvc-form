<?php

namespace app\components\clients;

use Exception;

class ClientResolver
{
    public const CLIENT_SMS = 'sms';
    public const CLIENT_EMAIL = 'email';

    /**
     * @throws Exception
     */
    public static function getClient(string $client): ClientInterface
    {
        return match ($client) {
            self::CLIENT_EMAIL => new EmailClient(),
            self::CLIENT_SMS => new SmsClient(),
            default => throw new Exception('Undefined client.'),
        };
    }
}