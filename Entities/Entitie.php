<?php

namespace Entities;

use Doctrine\DBAL\Connection;

abstract class Entitie {

	private $conn;
	protected $table;

    public function __construct(Connection $conn)
    {
        $this->setConn($conn);
    }

    private function setConn(Connection $conn)
    {
        $this->conn = $conn;
    }

    protected function getConn()
    {
        return $this->conn;
    }
}