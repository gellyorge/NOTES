<?php

namespace App\Services;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operation
{
    public static function decryptId($value)
    {
        try
        {
          $value = Crypt::decrypt($value);
        }
        catch(DecryptException $error)
        {
          return redirect()->route('home');
        }
        return $value;
    }
}