<?php

namespace Hascamp\BaseCrypt\Encryption\Support;

class Setting
{
    public const LARAVEL_LOG = "\\Illuminate\\Support\\Facades\\Log";
    public const FUNCTION_CONFIG = "\\Illuminate\\Support\\Facades\\Log";

    public static function cipher(): string
    {
        $log = static::LARAVEL_LOG;

        try {
            $config = static::FUNCTION_CONFIG;
            if (function_exists($config)) {
                return $config('app.cipher', 'AES-256-CBC');
            }
        } catch (\Throwable $th) {
            if (class_exists($log)) {
                $log::notice($th->getMessage());
            }
        }

        return "AES-256-CBC";
    }
}