<?php

namespace Hascamp\BaseCrypt\Encryption\Support;

class Setting
{
    public const LARAVEL_LOG = "\\Illuminate\\Support\\Facades\\Log";

    public static function cipher(): string
    {
        $log = static::LARAVEL_LOG;
        
        try {
            return config('app.cipher');
        } catch (\Throwable $th) {
            if (class_exists($log)) {
                $log::notice($th->getMessage());
            }
        }

        return "AES-256-CBC";
    }
}