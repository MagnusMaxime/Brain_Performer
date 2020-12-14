<?php


namespace App\Model;


class User {
	public static $grades = [
		"patient",
		"médecin",
		"admin",
		"dev"
	];

	/**
	 * Vérifie si un utilisateur existe dans la base de données sql
	 * étant donné un tableau de conditions.
	 */
	static public function does_exist($conditions) {
		global $DB;
		$conditions_query_array = [];
		foreach($conditions as $key => $value) {
			array_push($conditions_query_array, "`".$key."`= :".$key);
		}
		$conditions_query = join(", ", $conditions_query_array);
		$query = "SELECT * FROM `user` WHERE (".$conditions_query.")";
		error_log($query);
		console_log($query);
		$req = $DB->prepare($query);
		$results = $req->execute($conditions);
		error_log($results);
		return !$results;
	}

	/**
	 * On suppose que l'on a déjà vérifié si les informations de l'utilisateur lui
	 * permettent de créer un compte.
	 */
	static public function register($data){
			global $DB;
			$user_row = [
					"firstname"=>$data["firstname"],
					"lastname"=>$data["lastname"],
					"mail"=>$data["mail"],
					"sex"=>$data["sex"]=="man" ? 0 : 1,
					"birthdate"=>$data["birthdate"],
					"token"=>$data["token"],
					"password"=>password_hash($data["password"], PASSWORD_DEFAULT),//https://www.php.net/manual/fr/function.password-hash.php
					"language"=>"fr",//todo
					"urlavatar"=>$data["urlavatar"],
			];

			$req = $DB->prepare(
					"INSERT INTO `user` (`firstname`, `lastname`, `mail`, `sex`, `birthdate`, `token`, `password`, `language`, `urlavatar`) VALUES (:firstname, :lastname, :mail, :sex, :birthdate, :token, :password, :language, :urlavatar);");
			$req->execute($user_row);
			$user = new User($id);
			return $user;
	}

	/**
	 * Vérifie si le mot de passe correspond à l'email donné.
	 */
	static public function match_password($mail, $password) {
			global $DB;
			$req = $DB->prepare("SELECT * FROM `user` WHERE mail = ? AND password = ?");
			$req->execute([$mail, password_hash($password, PASSWORD_DEFAULT)]);
			$user_exists = $req->rowCount();
			return $user_exists == 1;
	}

	/**
	 * Connecte un utilisateur avec son email et mot de passe.
	 * On suppose que ses identifiants sont corrects.
	 */
	static public function connect($mail, $password){
			global $DB;
			$req = $DB->prepare("SELECT * FROM `user` WHERE mail = ? AND password = ?");
			$req->execute([$mail, password_hash($password, PASSWORD_DEFAULT)]);
			$user_row = $req->fetch();
			$user = new User($user_row["id"]);
			$user->setup_session();
			return $user;
	}

	/**
	 * On suppose que l'utilisateur existe.
	*/
	public function __construct($id) {
				$this->id = $id;
				/* $user_row = $results[0]; */
				/* $this->id = $id; */
				/* $this->firstname = $user_row["firstname"]; */
				/* $this->lastname = $user_row["lastname"]; */
				/* $this->mail = $user_row["mail"]; */
				/* $this->created = $user_row["created"]; */
				/* $this->updated = $user_row["updated"]; */
				/* $this->grade = $user_row["grade"]; */
	}


	public function getId() {
		return $this->id;
	}

	/**
	 * Renvoie la ligne sql correspondant à l'utilisateur sous forme de tableau php.
	*/
	public function get_row() {
		global $DB;
		$req = $DB->prepare(
			"SELECT * FROM `user` WHERE (`id`==:id)"
		);
		$results = $req->execute(["id" => $this->id]);
		return $results[0];
	}

	/**
	 * Renvoie les informations publiques d'un utilisateur sous forme de tableau php,
	 * et cela de manière lisible sur une page web.
	 */
	public function get_info() {
		$row = $this->get_row();
		return [
			"firstname" => $row["firstname"],
			"lastname" => $row["lastname"],
			"mail" => $row["mail"],
			"birthdate" => $row["birthdate"],
			"created" => date('d/m/Y H:i:s', $row["created"]),
			"updated" => date('d/m/Y H:i:s', $row["updated"]),
			"grade" => User::$grades[$row["grade"]]
		];
	}

	/*
	 * Met en place les variables de sessions grâce aux informations
	 * publiques d'un utilisateur.
	 */
	public function setup_session() {
		$info = $this->get_info();
		$_SESSION['id'] = $info['id'];
		$_SESSION['firstname'] = $info['firstname'];
		$_SESSION['lastname'] = $info['lastname'];
		$_SESSION['mail'] = $info['mail'];
		$_SESSION['sex'] = $info['sex'];
		$_SESSION['language'] = $info['language'];
		$_SESSION['urlavatar'] = $info['urlavatar'];
		$_SESSION['updated'] = $info['updated'];
		$_SESSION['created'] = $info['created'];
	}
}

//["first-name"]=> string(2) "ze" ["last-name"]=> string(2) "ze"
//["url-avatar"]=> string(0) "" ["gender"]=> string(3) "man"
//["birthday"]=> string(10) "2020-12-22" ["email"]=> string(2) "ze"
//["password"]=> string(15) "AGsJyF4t6vX7QNX" ["password-repeat"]=> string(15) "AGsJyF4t6vX7QNX"
//["bp-key"]=> string(2) "ze" ["rememberme"]=> string(2) "on" }
