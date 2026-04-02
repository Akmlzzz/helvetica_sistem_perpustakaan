<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class AppSetting
{
    private static $filename = 'settings.json';

    public static function get($key, $default = null)
    {
        if (!Storage::exists(self::$filename)) {
            return $default;
        }

        $settings = json_decode(Storage::get(self::$filename), true);

        return $settings[$key] ?? $default;
    }

    public static function set($key, $value)
    {
        $settings = [];

        if (Storage::exists(self::$filename)) {
            $settings = json_decode(Storage::get(self::$filename), true);
        }

        $settings[$key] = $value;

        Storage::put(self::$filename, json_encode($settings, JSON_PRETTY_PRINT));
    }
}
