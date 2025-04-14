<?php

namespace Hascamp\BaseCrypt\Crypter;

class Crypter
{
    public function hash(?string $str, ?string $key = null): string
    {
        if (! empty($key)) return hash_hmac('sha256', $str, $key);
        return hash('sha256', $str);
    }

    public static function __callStatic(string $name, array $args)
    {
        if ($name === 'hash') {
            $str = $args[0] ?? null;
            $key = $args[1] ?? null;
            return (new static)->hash($str, $key);
        }
    }
}