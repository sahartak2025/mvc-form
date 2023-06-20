<?php

namespace app\models;

use AllowDynamicProperties;

/**
 * @property-read int $id
 * @property string $text
 * @property bool $mail_sent
 * @property bool $sms_sent
 */
#[AllowDynamicProperties] class TestModel extends BaseModel
{
    public function getTable(): string
    {
        return 'test_table';
    }
}