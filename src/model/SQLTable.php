<?php

namespace App\Model;


class SQLTable {

	/*
	 * Retrouve les noms des tables à partir telles définies dans la base de données,
	 * en effectuant une conversion de CamelCase à snake_case.
	 */
	static protected function get_name() {
		$array = explode('\\', get_called_class());
		$class_name = end($array);
		return strtolower(preg_replace('/\B([A-Z])/', '_$1', $class_name));
	}

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
		$query = "SELECT * FROM `".static::lower_class_name()."` WHERE (".$conditions_query.")";
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
		$query = "SELECT `id` FROM `".static::lower_class_name()."` WHERE (".$conditions_query.")";
		error_log($query);
		$req = $DB->prepare($query);
		$req->execute($conditions);
		$id = $req->fetch();
		if (!$id) {
			return false;
		} else {
			return new static($id);
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
		$query = "SELECT `id` FROM `".static::lower_class_name()."` WHERE (".$conditions_query.")";
		error_log($query);
		$req = $DB->prepare($query);
		$req->execute($conditions);
		$ids = $req->fetchAll();
		$objects = [];

		/* if (static::lower_class_name() == "user"){ //TODO pour marc : faire un truc plus propre */
		/* 	foreach ($ids as $ids) { */
		/* 		$objects[] = new User($ids["id"]); */
		/* 	} */
		/* } else { */
		foreach ($ids as $ids) {
			$objects[] = new static($ids["id"]);
		}
		/* } */
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
		$query = "SELECT * FROM `".static::lower_class_name()."` WHERE (".$conditions_query.")";
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
		$query = "SELECT * FROM `".static::lower_class_name()."` WHERE (".$conditions_query.")";
		error_log($query);
		$req = $DB->prepare($query);
		$req->execute($conditions);

		return $req->fetchAll();
	}

	/**
	 * Renvoie la ligne SQL d'un objet.
	 */
	public function get_row() {
		global $DB;
		$req = $DB->prepare(
			"SELECT * FROM `".static::get_name()."` WHERE (`id` = :id)"
		);
		$req->execute(["id" => strval($this->id)]);
		$results = $req->fetch();
		var_dump($results);
		return $results;
	}
}
