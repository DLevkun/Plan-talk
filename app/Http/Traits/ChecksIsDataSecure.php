<?php

namespace App\Http\Traits;

trait ChecksIsDataSecure
{
    protected function getSecureData($data)
    {
        $data = htmlspecialchars(addslashes(trim($data)), ENT_QUOTES);
        return $data;
    }
}
