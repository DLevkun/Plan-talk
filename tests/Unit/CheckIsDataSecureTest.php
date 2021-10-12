<?php

namespace Tests\Unit;

use App\Http\Traits\ChecksIsDataSecure;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class CheckIsDataSecureTest extends TestCase
{
    use ChecksIsDataSecure;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testIsRemovesSpaces()
    {
        $data = '    dasha.levkun@gmail.com';
        assertEquals($this->getSecureData($data), 'dasha.levkun@gmail.com');
    }

    public function testIsHtmlChars(){
        $data = "<script>";
        assertEquals($this->getSecureData($data), "&lt;script&gt;");
    }

    public function testIsAddSlashes(){
        $data = "Дар'я";
        assertEquals($this->getSecureData($data), "Дар\'я");
    }
}
