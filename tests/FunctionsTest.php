<?php
/**
 * api
 *
 * Copyright (C) Tony Yip 2016.
 *
 * Permission is hereby granted, free of charge,
 * to any person obtaining a copy of this software
 * and associated documentation files (the "Software"),
 * to deal in the Software without restriction,
 * including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons
 * to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS",
 * WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @category api
 * @author   Tony Yip <tony@opensource.hk>
 * @license  http://opensource.org/licenses/MIT MIT License
 */

namespace App\Tests;

use Illuminate\Support\Facades\Cache;
use Guardian\Models\Config;

class FunctionsTest extends \TestCase
{
    public function testPreference()
    {
        $this->assertTrue(function_exists('preference'));
        $this->assertEquals(preference('APP_ENV'), env('APP_ENV'));

        $name = "hello_" . bin2hex(random_bytes(10));
        $this->assertEquals("not set", preference($name, "not set"));
        //$this->assertEquals("not set", preference($name, "not set (again)"));

        // need to remove cache to reset default
        Cache::forget("config:{$name}");
        $this->assertNull(Cache::get("config:{$name}"));

        // save preference to config
        $hello = new Config;
        $hello->name = $name;
        $hello->value = "world";
        $hello->save();
        $this->assertEquals("world", preference($name, "not set"));

        // need to remove cache to reset default
        Cache::forget("config:{$name}");
        $this->assertNull(Cache::get("config:{$name}"));

        // delete config
        $hello->delete();

        $this->assertEquals(preference($name, "not set"), "not set");
    }
}
