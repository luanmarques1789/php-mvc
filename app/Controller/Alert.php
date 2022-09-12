<?php

namespace App\Controller;

use App\Utils\View;

class Alert
{
    public static function getSuccess($message)
    {
        return View::render('Admin/Alert/status', [
            'alertType' => 'success',
            'message' => $message
        ]);
    }

    public static function getError($message)
    {
        return View::render('Admin/Alert/status', [
            'alertType' => 'danger',
            'message' => $message
        ]);
    }
}
