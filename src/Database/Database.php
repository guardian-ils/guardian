<?php

namespace Guardian\Database;


use Doctrine\DBAL\DriverManager;

final class Database
{

    /**
     * @var \Doctrine\DBAL\Connection
     */
    private static $connection = null;

    private function __construct()
    {

    }

    private static function getConfig()
    {
        return (array) json_decode(file_get_contents(__DIR__ . '/../../config/dataSource.json', true));
    }

    public static function getConnection()
    {
        if (null === self::$connection)
            self::$connection = DriverManager::getConnection(self::getConfig());

        return self::$connection;
    }

    public static function getQueryBuilder()
    {
        $connection = self::getConnection();
        return $connection->createQueryBuilder();
    }
}