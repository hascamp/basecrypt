<?php

namespace Hascamp\BaseCrypt\Encryption\Support;

class Setting
{
    public const LARAVEL_LOG = "\\Illuminate\\Support\\Facades\\Log";

    public static function cipher(): string
    {
        try {
            return constant('config'('app.cipher'));
        } catch (\Throwable $th) {
            static::LARAVEL_LOG::notice($th->getMessage());
            return "AES-256-CBC";
        }
    }
}