<?php

namespace Entities;

use Entities\Entitie;
use Doctrine\DBAL\Connection;
use PDO;

class Game extends Entitie 
{
	private $conn;

	public function addGame($data, $id)
	{
		$data['description'] = addslashes($data['description']);
		$data['histoire'] = addslashes($data['histoire']);
		$this->getConn()->executeQuery('INSERT INTO t_game (name, slogan, univers, genre, plateforme, description, histoire, status, image, t_user_id) VALUES ("'.$data['nom'].'", "'.$data['slogan'].'", "'.$data['univers'].'", "'.$data['genre_preference'].'", "'.$data['plateforme_preference'].'", "'.$data['description'].'", "'.$data['histoire'].'", "'.$data['status'].'", "'.$data['image'].'", '.$id.')');
		$data = $this->getConn()->executeQuery('SELECT id FROM t_game WHERE image = "'.$data['image'].'"');
		$id = $data->fetchColumn();
		return $id;
	}

	public function addGameInfos($id, $data)
	{
		$nb = $data[0];
		while ($data[0] > 0)
		{
			$this->getConn()->executeQuery('INSERT INTO t_game_infos (name, content1, content2, content3, content4, t_game_id) VALUES ("termine", "'.$data[$data[0]][0].'", "'.$data[$data[0]][1].'", "'.$data[$data[0]][2].'", "'.$data[$data[0]][3].'", '.$id.')');
			$data[0] -= 1;
		}
		$this->getConn()->executeQuery('INSERT INTO t_game_finish (github, facebook, twitter, siteweb, t_game_id) VALUES ("'.$data[$nb + 1].'", "'.$data[$nb + 2].'", "'.$data[$nb + 3].'", "'.$data[$nb + 4].'", '.$id.')');
	}

	public function getData($id)
	{
		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_game WHERE id = '.$id);
		$data = $stmt->fetchAll();

		return $data[0];
	}

	public function getDataInfos($id)
	{
		$stmt = $this->getConn()->executeQuery('SELECT * FROM t_game_finish WHERE t_game_id = '.$id);
		$data = $stmt->fetchAll();

		return $data[0];
	}

}