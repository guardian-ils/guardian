<?php

namespace Guardian\Admin;

use PDO;
use Exception;
use Guardian\Database\Database;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

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

    public function get($variable)
    {
        $query = Database::getQueryBuilder();
        $query
            ->select('value')
            ->from('preference')
            ->where('variable=?')
            ->setParameter(0, $variable)
        ;
        $stmt = $query->execute();
        if (0 === $stmt->rowCount()) {
            $msg = sprintf('Config %s is not found in %s::%s', $variable, __CLASS__, __METHOD__);
            throw new NotFoundException($msg);
        }
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
        return $variables;
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
        list($options) = $stmt->fetch(PDO::FETCH_NUM);
        if (empty($options))
            return null;
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
        list($type) = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();

        if (!in_array($type, array(self::TYPE_TEXT, self::TYPE_MC, self::TYPE_BOOL)))
            throw new InvalidTypeException('Preference Type Not Match');

        return $type;

    }

    public function insert($variable, $value, $type = self::TYPE_MC, $descriptions = '', $options = array())
    {
        if (in_array($variable, $this->getVariables()))
            throw new Exception('Variable exists already');

        if (!in_array($type, array(self::TYPE_TEXT, self::TYPE_MC, self::TYPE_BOOL)))
            throw new InvalidTypeException('Preference Type Not Match');

        if (0 === count($options))
            $options = null;
        else
            $options = implode('|', $options);

        $query = Database::getQueryBuilder();
        $query
            ->insert('preference')
            ->values(
                array(
                    'variable' => ':var',
                    'value' => ':value',
                    'type' => ':type',
                    'options' => ':options',
                    'description' => ':description'
                )
            )
            ->setParameter(':var', $variable, PDO::PARAM_STR)
            ->setParameter(':value', $value, PDO::PARAM_STR)
            ->setParameter(':type', $type, PDO::PARAM_STR)
            ->setParameter(':description', $descriptions)
            ->setParameter(':options', $options)
            ;
        $row = $query->execute();
        return 1 === $row;
    }

    public function has($variable)
    {
        $query = Database::getQueryBuilder();
        $query
            ->select('value')
            ->from('preference')
            ->where('variable=?')
            ->setParameter(0, $variable)
            ;
        $stmt = $query->execute();
        return 1 === $stmt->rowCount();
    }

    public function remove($variable)
    {
        $query = Database::getQueryBuilder();
        $query
            ->delete('preference')
            ->where('variable=?')
            ->setParameter(0, $variable)
            ;
        return 1 === $query->execute();
    }

    public function set($variable, $value)
    {
        if (!$this->has($variable))
            return true;
        $query = Database::getQueryBuilder();
        $query
            ->update('preference')
            ->set('value', ':value')
            ->where('variable = :var')
            ->setParameter(':var', $variable)
            ->setParameter(':value', $value)
            ;
        return 1 === $query->execute();
    }

    public function setDescription($variable, $description)
    {
        if (!$this->has($variable))
            return true;
        $query = Database::getQueryBuilder();
        $query
            ->update('preference')
            ->set('description', ':value')
            ->where('variable = :var')
            ->setParameter(':var', $variable)
            ->setParameter(':value', $description)
        ;
        return 1 === $query->execute();
    }
}