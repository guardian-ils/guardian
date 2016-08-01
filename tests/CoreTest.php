<?php

namespace App\Tests;

use Illuminate\Support\Facades\Cache;
use Guardian\Models\Config;
use Guardian\Core;

class CoreTest extends \TestCase
{
    public function testPreference()
    {
        $this->assertEquals(Core::preference('APP_ENV'), env('APP_ENV'));

        $name = "hello_" . bin2hex(random_bytes(10));
        $this->assertEquals("not set", Core::preference($name, "not set"));
        $this->assertEquals("not set", Core::preference($name, "not set (again)"));

        // need to remove cache to reset default
        Cache::forget("config:{$name}");
        $this->assertNull(Cache::get("config:{$name}"));

        // save preference to config
        $hello = new Config;
        $hello->name = $name;
        $hello->value = "world";
        $hello->save();
        $this->assertEquals("world", Core::preference($name, "not set"));

        // need to remove cache to reset default
        Cache::forget("config:{$name}");
        $this->assertNull(Cache::get("config:{$name}"));

        // delete config
        $hello->delete();

        $this->assertEquals(Core::preference($name, "not set"), "not set");
    }
}
