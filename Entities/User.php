<?php

namespace Entities;

use Entities\Entitie;
use Doctrine\DBAL\Connection;
use PDO;

class User extends Entitie 
{
	private $conn;

	public function userRegister($data)
	{
		$stmt = $this->getConn()->executeQuery('INSERT INTO t_user (`login`, `password`, `email`) VALUES ("'.$data['Login'].'", "'.$data['Password'].'", "'.$data['Email'].'")');
	}

	public function searchByLogin($login)
	{
		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_user WHERE login = "'.$login.'"');
		$data = $stmt->fetchAll();

		return $data[0];
	}

	public function setValue($champ, $value, $id)
	{
		$this->getConn()->executeQuery('UPDATE t_user_infos SET '.$champ.' = "'.$value.'" WHERE t_user_id = '.$id);
	}

	public function getAllInfos($id)
	{
		$result = array();

		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_user WHERE id = '.$id);
		$data = $stmt->fetchAll();

		

		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_user_infos WHERE t_user_id = '.$id);
		$dat = $stmt->fetchAll();


		foreach ($dat as $value) {
			$result = $value;
		}

		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_user_skill WHERE t_user_id = '.$id);
		$da = $stmt->fetchAll();

		$i = 1;
		foreach ($da as $value) {
			$result[$value['skillname']] = $value['skill'];
			$i += 1;
		}

		return $result;
	}

}

