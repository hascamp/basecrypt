<?php

namespace Hascamp\BaseCrypt\Encryption\Support;

class Setting
{
    public const LARAVEL_LOG = "\\Illuminate\\Support\\Facades\\Log";

    public static function cipher(): string
    {
        return "AES-256-CBC";
    }
}