<?php

namespace Guardian\Admin;

use PDO;
use Guardian\Database\Database;

class Preference
{

    const TYPE_TEXT = 'text';
    const TYPE_MC = 'choice';
    const TYPE_BOOL = 'bool';

    /**
     * @var \Guardian\Admin\Preference
     */
    private static $instance = null;


    public static function getInstance()
    {
        if (null === self::$instance)
            self::$instance = new static;

        return self::$instance;
    }

    public function getConfig($variable)
    {
        $query = Database::getQueryBuilder();
        $query
            ->select('value')
            ->from('preference')
            ->where('variable=?')
            ->setParameter(0, $variable)
        ;
        $stmt = $query->execute();
        list($value) = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        return $value;
    }

    public function getVariables()
    {
        $query = Database::getQueryBuilder();
        $query
            ->select('variable')
            ->from('preference')
        ;
        $stmt = $query->execute();
        $variables = array();
        while (list($variable) = $stmt->fetch(PDO::FETCH_NUM)) {
            $variables[] = $variable;
        }
        $stmt->closeCursor();
        return $variable;
    }

    public function getDescription($variable)
    {
        $query = Database::getQueryBuilder();
        $query
            ->select('description')
            ->from('preference')
            ->where('variable=?')
            ->setParameter(0, $variable)
        ;
        $stmt = $query->execute();
        list($description) = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        return $description;
    }

    public function getOptions($variable)
    {
        $query = Database::getQueryBuilder();
        $query
            ->select('options')
            ->from('preference')
            ->where('variable=?')
            ->setParameter(0, $variable)
        ;
        $stmt = $query->execute();
        if (0 === $stmt->rowCount())
            return null;
        list($options) = $stmt->fetch(PDO::FETCH_NUM);
        $options = explode('|', $options);
        return $options;
    }

    public function getType($variable)
    {
        $query = Database::getQueryBuilder();
        $query
            ->select('type')
            ->from('preference')
            ->where('variable=?')
            ->setParameter(0, $variable)
        ;
        $stmt = $query->execute();

    }
}