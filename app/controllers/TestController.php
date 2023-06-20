<?php

namespace app\controllers;

use app\models\TestModel;
use app\services\EmailService;
use app\services\SmsService;
use Throwable;

class TestController extends BaseController
{
    /**
     * @throws Throwable
     */
    public function form(): void
    {
        echo $this->renderView(ROOT_PATH . '/app/views/form.php');
    }

    /**
     * @throws Throwable
     */
    public function list(): void
    {
        echo $this->renderView(ROOT_PATH . '/app/views/list.php', ['list' => (new TestModel())->getAll()]);
    }

    public function save(): void
    {
        $data = $_POST;
        unset($data['csrf_token']);
        $data['mail_sent'] = 0;
        $data['sms_sent'] = 0;
        $model = new TestModel();
        $model->load($data);
        $model->save();

        $emailService = new EmailService();
        if ($emailService->send($model->text)) {
            $model->mail_sent = true;
            $model->save();
        }

        $smsService = new SmsService();
        if ($smsService->send($model->text)) {
            $model->sms_sent = true;
            $model->save();
        }

        $this->redirect('/list');
    }
}