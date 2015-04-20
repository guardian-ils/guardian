<?php

namespace Guardain\Test;

use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Guardian\Database\Database;

class DatabaseTest extends \PHPUnit_Framework_TestCase {

    public function testType()
    {
        $connection = Database::getConnection();
        $this->assertEquals(true, $connection instanceof Connection);

        $query = Database::getQueryBuilder();
        $this->assertEquals(true, $query instanceof QueryBuilder);
    }
}
