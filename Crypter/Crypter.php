<?php

namespace Hascamp\BaseCrypt\Crypter;

class Crypter
{
    public function toHash(?string $str, ?string $key = null): string
    {
        if (! empty($key)) return hash_hmac('sha256', $str, $key);
        return hash('sha256', $str);
    }

    public static function __to_hash(string $name, array $args): string
    {
        $str = $args[0] ?? null;
        $key = $args[1] ?? null;
        return (new static)->toHash($str, $key);
    }

    public function __call(string $name, array $args)
    {
        return static::__to_hash($name, $args);
    }

    public static function __callStatic(string $name, array $args)
    {
        return static::__to_hash($name, $args);
    }
}