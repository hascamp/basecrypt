<?php

namespace Hascamp\BaseCrypt\Encryption;

use Hascamp\BaseCrypt\Encryption\BaseCode;
use Hascamp\BaseCrypt\Encryption\Support\Setting;

class BaseCrypt extends BaseCode
{
    private static self $crypt;

    public static function code(
        string|array $data,
        string $key,
        string $mode = 'encrypt'
    ): string|array|null
    {
        if(!isset(self::$crypt)) self::$crypt = new self();

        $instance = self::$crypt;

        if(is_string($data)){
            $data = (string) $data;
        }
        elseif(is_array($data)){
            $data = json_encode($data);
        }
        else{
            $data = null;
        }

        try {
            if($mode === 'encrypt'){
                $return = $instance->with_encrypt($data, $key);
                return (string) $return;
            }
            elseif($mode === 'decrypt'){
                $return = $instance->with_decrypt($data, $key);
                $jsonValidate = function ($d) use ($instance){
                    if($instance->isValidJson($d)){
                        return (array) json_decode($d, true);
                    }
                    return (string) $d;
                };
                return $jsonValidate($return);
            }
            else{
                throw new \Exception("Invalid data type result. #code");
            }
        } catch (\Throwable $th) {
            $s = Setting::LARAVEL_LOG;
            if(class_exists($s)) {
                $s::error($th->getMessage(), ['exception' => $th]);
            }
            return null;
        }

        return null;
    }

    public static function __callStatic($name, $args)
    {
        $_enc = "encrypt";
        $_dec = "decrypt";
        $data = null;
        $key = null;
        
        if(isset($args[0]) && isset($args[1])) {
            $data = $args[0];
            $key = $args[1];
        }

        if ($name === $_enc) {
            return new static($data, $key, $_enc);
        }
        else if ($name === $_dec) {
            return new static($data, $key, $_dec);
        }

        return null;
    }

    private function __clone()
    {}

    public function __wakeup() {
        throw new \Exception("Cannot deserialize a basecrypt. #__wakeup");
    }
}