<?php

namespace Guardian\Test;

use Exception;
use Guardian\Admin\Preference;

class PreferenceTest extends \PHPUnit_Framework_TestCase {

    public function testInsert()
    {
        $preference = Preference::getInstance();
        try {
            $result = $preference->insert('global.lang', 'en', Preference::TYPE_TEXT, 'Language');
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * @depends testInsert
     */
    public function testVariables()
    {
        $preference = Preference::getInstance();
        $vars = $preference->getVariables();
        $this->assertEquals(1, count($vars));
    }

    /**
     * @depends testInsert
     */
    public function testSetter()
    {
        $preference = Preference::getInstance();
        $result = $preference->set('global.lang', 'en-GB');
        $this->assertEquals(true, $result);
    }

    /**
     * @depends testInsert
     */
    public function testGetter()
    {
        $preference = Preference::getInstance();
        $result = $preference->get('global.lang');
        $this->assertEquals('en-GB', $result);
        $result = $preference->getDescription('global.lang');
        $this->assertEquals('Language', $result, 'Test getDescription');
        $result = $preference->getOptions('global.lang');
        $this->assertNull($result);
    }

    /**
     * @depends testInsert
     */
    public function testRemove()
    {
        $preference = Preference::getInstance();
        $result = $preference->remove('global.lang');
        $this->assertTrue($result);
    }

}
