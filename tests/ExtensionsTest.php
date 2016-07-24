<?php

namespace App\Tests;


class ExtensionsTest extends \TestCase
{
    public function testPgsql()
    {
        if (!defined('HHVM_VERSION')) {
            $this->markTestSkipped('Just for HHVM');
        } else {
            $this->assertContains('pgsql', get_loaded_extensions());
        }
    }

    public function testApc()
    {
        $this->assertContains('apc', get_loaded_extensions());
    }
}
