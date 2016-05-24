<?php

namespace Entities;

use Entities\Entitie;
use Doctrine\DBAL\Connection;
use PDO;

class Admin extends Entitie 
{
	private $conn;

	public function addPlateforme($name, $shortname)
	{
		$this->getConn()->executeQuery('INSERT INTO t_plateforme (`name`, `shortname`) VALUES ("'.$name.'", "'.$shortname.'")');
	}

	public function getPlateforme()
	{
		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_plateforme');
		$data = $stmt->fetchAll();
		return $data;
	}

	public function getPlateformeName()
	{
		$stmt = $this->getConn()->executeQuery('SELECT name FROM t_plateforme');
		$data = $stmt->fetchAll();

		foreach ($data as $key => $value) {
			$result['name'][] = $value['name'];
			$result['id'][] = $key;
		}
		return $result;
	}

	public function getPlateformeById($id)
	{
		var_dump($id);
		$stmt = $this->getConn()->executeQuery('SELECT shortname FROM t_plateforme WHERE id = '.$id);
		$data = $stmt->fetchColumn();

		return $data;
	}

	public function addGenre($name, $shortname)
	{
		$this->getConn()->executeQuery('INSERT INTO t_genre (`name`, `shortname`) VALUES ("'.$name.'", "'.$shortname.'")');
	}

	public function getGenre()
	{
		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_genre');
		$data = $stmt->fetchAll();
		return $data;
	}


	public function getGenreName()
	{
		$stmt = $this->getConn()->executeQuery('SELECT name FROM t_genre');
		$data = $stmt->fetchAll();

		foreach ($data as $key => $value) {
			$result['name'][] = $value['name'];
			$result['id'][] = $key;
		}
		return $result;
	}

	public function getGenreById($id)
	{
		$stmt = $this->getConn()->executeQuery('SELECT shortname FROM t_genre WHERE id = '.$id);
		$data = $stmt->fetchColumn();

		return $data;
	}

	public function addOS($name)
	{
		$this->getConn()->executeQuery('INSERT INTO t_os (`name`) VALUES ("'.$name.'")');
	}

	public function getOS()
	{
		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_os');
		$data = $stmt->fetchAll();
		return $data;
	}

	public function addProg($name)
	{
		$this->getConn()->executeQuery('INSERT INTO t_programmation (`name`) VALUES ("'.$name.'")');
	}

	public function getProg()
	{
		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_programmation');
		$data = $stmt->fetchAll();
		return $data;
	}

	public function addRole($name)
	{
		$this->getConn()->executeQuery('INSERT INTO t_role (`name`) VALUES ("'.$name.'")');
	}

	public function getRole()
	{
		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_role');
		$data = $stmt->fetchAll();
		return $data;
	}

	public function addSmartphone($name)
	{
		$this->getConn()->executeQuery('INSERT INTO t_smartphone (`name`) VALUES ("'.$name.'")');
	}

	public function getSmartphone()
	{
		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_smartphone');
		$data = $stmt->fetchAll();
		return $data;
	}

	public function addMoteur($name)
	{
		$this->getConn()->executeQuery('INSERT INTO t_moteur (`name`) VALUES ("'.$name.'")');
	}

	public function getMoteur()
	{
		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_moteur');
		$data = $stmt->fetchAll();
		return $data;
	}

	public function addGraphisme($name)
	{
		$this->getConn()->executeQuery('INSERT INTO t_graphisme (`name`) VALUES ("'.$name.'")');
	}

	public function getGraphisme()
	{
		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_graphisme');
		$data = $stmt->fetchAll();
		return $data;
	}

	public function addConception($name)
	{
		$this->getConn()->executeQuery('INSERT INTO t_conception (`name`) VALUES ("'.$name.'")');
	}

	public function getConception()
	{
		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_conception');
		$data = $stmt->fetchAll();
		return $data;
	}

	public function addAutre($name)
	{
		$this->getConn()->executeQuery('INSERT INTO t_autre (`name`) VALUES ("'.$name.'")');
	}

	public function getAutre()
	{
		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_autre');
		$data = $stmt->fetchAll();
		return $data;
	}

	public function setValue($champ, $value, $id)
	{
		$this->getConn()->executeQuery('DELETE FROM t_user_skill WHERE skillname = "'.$champ.'" && t_user_id = '.$id);
		$this->getConn()->executeQuery('INSERT INTO t_user_skill (skill, skillname, t_user_id) VALUES ("'.$value.'", "'.$champ.'", '.$id.')');
	}
}
