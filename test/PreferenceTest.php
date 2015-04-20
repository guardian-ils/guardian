<?php

namespace Guardian\Test;


use Guardian\Admin\Preference;

class PreferenceTest extends \PHPUnit_Framework_TestCase {

    public function testVariables()
    {
        $preference = Preference::getInstance();
        $vars = $preference->getVariables();
        $this->assertEmpty($vars);
    }
}
