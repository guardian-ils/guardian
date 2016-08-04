<?php

namespace App\Tests\Helper;


use Guardian\Helper\Uuid;

class UuidTest extends \TestCase
{
    public function testGenerateValidUUID()
    {
        $this->assertTrue(Uuid::valid(Uuid::NIL));
    }
}
