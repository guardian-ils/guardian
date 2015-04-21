<?php

namespace Guardian\Parton;

use PDO;
use Guardian\Database\Database;

class Borrower
{
    /**
     * @var string
     */
    private $name;

    public function __construct($id)
    {
        $query = Database::getQueryBuilder();
        $query
            ->select('surname, firstname, title')
            ->from('borrowers')
            ->where('borrower_id = :id')
            ->orWhere('card_number = :id')
            ->orWhere('user_id = :id')
            ->setParameter(':id', $id, PDO::PARAM_STR);
        $stmt = $query->execute();
        if (0 === $stmt->rowCount()) {
            $msg = sprintf('%s %s is not found in %s::%s', __CLASS__, $id, __CLASS__, __METHOD__);
            throw new PartonNotFoundException($msg);
        }
        list ($surname, $firstname, $title) = $stmt->fetch(PDO::FETCH_NUM);
        $this->name = sprintf('%s %s %s', $title, $firstname, $surname);
    }
}