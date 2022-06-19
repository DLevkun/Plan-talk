<?php

namespace App\Http\Traits;

trait ChecksIsDataSecure
{
    /**
     * Prevent SQL injections and XSS attacks
     * @param $data
     * @return string
     */
    protected function getSecureData($data)
    {
        $data = htmlspecialchars(addslashes(trim($data)));
        return $data;
    }
}
