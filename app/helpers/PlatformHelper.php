<?php

namespace App\Helpers;

class PlatformHelper {
    public static function isAndroid(): bool {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }

        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        return stripos($userAgent, 'Android') !== false;
    }
}
