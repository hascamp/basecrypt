<?php

namespace Hascamp\BaseCrypt\Encryption;

use Hascamp\BaseCrypt\Encryption\Support\Setting;

abstract class BaseCode
{
    protected function chiper(): string
    {
        return Setting::cipher();
    }

    protected function isValidJson(string $data): bool
    {
        json_decode($data);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    protected function with_encrypt(string $data, string $key): string
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->chiper()));
        $encrypted = openssl_encrypt($data, $this->chiper(), $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }
    
    protected function with_decrypt(string $data, string $key): string
    {
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, $this->chiper(), $key, 0, $iv);
    }
}