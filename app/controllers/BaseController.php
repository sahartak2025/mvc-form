<?php

namespace app\controllers;

class BaseController
{
    final public function renderView($filePath, $params = []): false|string
    {
        $_obInitialLevel_ = ob_get_level();
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        try {
            require $filePath;
            return ob_get_clean();
        } catch (\Exception|\Throwable $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        }
    }

    public function checkCsrf(): void
    {
        if (!empty($_POST)) {
            $token = filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_STRING);

            if (!$token || $token !== $_SESSION['csrf_token']) {
                header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
                exit;
            } else {
                unset($_SESSION['csrf_token']);
            }
        }
    }

    public function initCsrf(): void
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = md5(uniqid(mt_rand(), true));
        }
    }

    protected function redirect(string $newURL): void
    {
        header('Location: ' . $newURL);
    }
}