<?php


namespace App\Model;


class SQLTable {

	public function __construct($id) {
			$this->id = $id;
	}

	static public function lower_class_name() {
		$array = explode('\\', get_called_class());
		$class_name = end($array);
		return strtolower($class_name);
	}

	/**
	 * Vérifie si un utilisateur existe dans la base de données SQL
	 * étant donné un tableau de conditions.
	 */
	static public function exist($conditions = []) {
		global $DB;
		$conditions_query_array = [];
		foreach($conditions as $key => $value) {
			$conditions_query_array[] = "`".$key."`=:".$key;
		}
		$conditions_query = join(" AND ", $conditions_query_array);
		if (!$conditions_query) {
			$conditions_query = "1";
		}
		$query = "SELECT * FROM `".self::lower_class_name()."` WHERE (".$conditions_query.")";
		error_log($query);
		$req = $DB->prepare($query);
		$req->execute($conditions);
		return $req->rowCount()>=1;
	}

	/**
	 * Filtre les lignes et renvoie le premier résultat sous forme
	 * d'objet.
	 */
	static public function one($conditions = []) {
		global $DB;
		$conditions_query_array = [];
		foreach($conditions as $key => $value) {
			$conditions_query_array[] = "`".$key."`=:".$key;
		}
		$conditions_query = join(" AND ", $conditions_query_array);
		if (!$conditions_query) {
			$conditions_query = "1";
		}
		$query = "SELECT `id` FROM `".self::lower_class_name()."` WHERE (".$conditions_query.")";
		error_log($query);
		$req = $DB->prepare($query);
		$req->execute($conditions);
		$id = $req->fetch();
		if (!$id) {
			return false;
		} else {
			return new self($id);
		}
	}

	/**
	 * Filtre les lignes et renvoie tous les résultats sous forme
	 * d'objets.
	 */
	static public function all($conditions = []) {
		global $DB;
		$conditions_query_array = [];
		foreach($conditions as $key => $value) {
			$conditions_query_array[] = "`".$key."`=:".$key;
		}
		$conditions_query = join(" AND ", $conditions_query_array);
		if (!$conditions_query) {
			$conditions_query = "1";
		}
		$query = "SELECT `id` FROM `".self::lower_class_name()."` WHERE (".$conditions_query.")";
		error_log($query);
		$req = $DB->prepare($query);
		$req->execute($conditions);
		$ids = $req->fetchAll();
		$objects = [];
		foreach ($ids as $ids) {
			$objects[] = new self($ids["id"]);
		}
		return $objects;
	}

	/**
	 * Filtre les lignes et renvoie le premier résultat.
	 */
	static public function row($conditions = []) {
		global $DB;
		$conditions_query_array = [];
		foreach($conditions as $key => $value) {
			$conditions_query_array[] = "`".$key."`=:".$key;
		}
		$conditions_query = join(" AND ", $conditions_query_array);
		if (!$conditions_query) {
			$conditions_query = "1";
		}
		$query = "SELECT * FROM `".self::lower_class_name()."` WHERE (".$conditions_query.")";
		error_log($query);
		$req = $DB->prepare($query);
		$req->execute($conditions);
		return $req->fetch();
	}


	/**
	 * Filtre les lignes et renvoie tous les résultats.
	 */
	static public function rows($conditions = []) {
		global $DB;
		$conditions_query_array = [];
		foreach($conditions as $key => $value) {
			$conditions_query_array[] = "`".$key."`=:".$key;
		}
		$conditions_query = join(" AND ", $conditions_query_array);
		if (!$conditions_query) {
			$conditions_query = "1";
		}
		$query = "SELECT * FROM `".self::lower_class_name()."` WHERE (".$conditions_query.")";
		error_log($query);
		$req = $DB->prepare($query);
		$req->execute($conditions);

		return $req->fetchAll();
	}
}
