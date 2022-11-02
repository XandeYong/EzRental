<?php
// Author: Tan Yogene

namespace App\Security;

use Illuminate\Support\Facades\Crypt;

/**
 * Description of Encryption
 *
 * @author Tan Yogene
 */
class Encryption
{

    //Encrypt function
    public static function encrypt($value)
    {
        return Crypt::encrypt($value);
    }

    //Decrypt function
    public static function decrypt($value)
    {
        return Crypt::decrypt($value);
    }
}
