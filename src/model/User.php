<?php


namespace App\Model;


class User {
	public static $grades = [//NE PAS CHANGER CE TABLEAU
		"patient",
		"médecin",
        "gestionnaire",
		"admin",
		"dev",
	];

	/**
	 * Récupère tout les utilisateurs.
	 */
	public static function get_all() {
		global $DB;
		$query = "SELECT `id` FROM `user`";
		$req = $DB->prepare($query);
		$req->execute();
		$ids = $req->fetch();
		$users = [];
		foreach ($ids as $id) {
			array_push($users, new self($id));
		}
		return $users;
	}

	/**
	 * Renvoie un tableau d'informations sur tout les utilisateurs.
	 */
	public static function get_all_info() {
		$users = self::get_all();
		$users_info = [];
		foreach ($users as $user) {
			array_push($users_info, $user->get_info());
		}
		return $users_info;

	}

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
		/* error_log(json_encode($conditions)); */

		$req = $DB->prepare($query);
		$req->execute($conditions);
		/* $results = $req->fetch(); */
		/* error_log(json_encode($results)); */
		/* error_log(!$results); */
		error_log($req->rowCount());
		return $req->rowCount()>=1;
	}


	/**
	 * On suppose que l'on a déjà vérifié si les informations de l'utilisateur lui
	 * permettent de créer un compte.
	 */
	static public function register($data){ //inscrit et connecte un utilisateur
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
                    "grade"=>$data["grade"],
                    "parent"=>$data["parent"],
                    "public"=>$data["publicuser"]=="on" ? 1 : 0
			];

			$req = $DB->prepare(
					"INSERT INTO `user` (`firstname`, `lastname`, `mail`, `sex`, `birthdate`, `token`, `password`, `language`, `urlavatar`, `grade`, `parent`, `public`) VALUES (:firstname, :lastname, :mail, :sex, :birthdate, :token, :password, :language, :urlavatar, :grade, :parent, :public);");
			$req->execute($user_row);
			error_log($user_row["urlavatar"]);
			$user = self::connect($data["mail"], $data["password"]);//Après l'inscription on connecte l'utilisateur d'office
			return $user;
	}

	/**
	 * Vérifie si le mot de passe correspond à l'email donné.
	 */
	static public function match_password($mail, $password) {
			global $DB;
			$sql = "SELECT password FROM `user` WHERE `mail` = :mail";
			error_log($sql);
			$req = $DB->prepare($sql);
			/* $req->execute(["mail" => $mail, "password" => password_hash($password, PASSWORD_DEFAULT)]); */
            $req->execute(["mail"=>$mail]);
			$password_hash = $req->fetch()[0];
			/* $user_exists = $req->rowCount(); */
			/* error_log($user_exists); */
			/* return $user_exists == 1; */
			return password_verify($password, $password_hash);
	}

	/**
	 * Connecte un utilisateur avec son email et mot de passe.
	 * On suppose que ses identifiants sont corrects.
	 */
	static public function connect($mail, $password){
			global $DB;
			$req = $DB->prepare("SELECT * FROM `user` WHERE mail = ?");
			$result = $req->execute([$mail]);
			error_log($result);
			$row_count = $req->rowCount();
			if ($row_count<=0){
				error_log($row_count);
				//La connexion a échouée
				//$
				return false;
			}
			$user_row = $req->fetch();
			$user = new self($user_row["id"]);
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


	public function get_id() {
		return $this->id;
	}

	/**
	 * Renvoie la ligne sql correspondant à l'utilisateur sous forme de tableau php.
	*/
	public function get_row() {
		global $DB;
		$req = $DB->prepare(
			"SELECT * FROM `user` WHERE (`id` = :id)"
		);
		$req->execute(["id" => $this->id]);
		$results = $req->fetch();
		/* var_dump($results); */
		return $results;
	}

	/**
	 * Renvoie les informations publiques d'un utilisateur sous forme de tableau php,
	 * et cela de manière lisible sur une page web.
	 */
	public function get_info() {
		$row = $this->get_row();
		/* var_dump($row); */
		$grade = $row["grade"] !== NULL ? $row["grade"] : 0;//todo parfois ya des NULL dans les grades

		/* error_log($grade); */
        $result=$row;//todo faire une copie
        $result["grade"]=(int) $grade;
        $result["grade_name"]=(self::$grades)[$grade];
        $result["age"]=date_diff(date_create($result["birthdate"]) , date_create('now'))->y;
        return $result;
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
        $_SESSION['grade'] = $info['grade'];
        $_SESSION['public'] = $info['public'];
        $_SESSION['user'] = $info;
	}

	public function update($data){
	    global $DB;

        $user_row = [
            "id"=>$this->id,
            "firstname"=>$data["firstname"],
            "lastname"=>$data["lastname"],
            "mail"=>$data["mail"],
            "sex"=>$data["sex"]=="man" ? 0 : 1,
            "birthdate"=>$data["birthdate"],
            "password"=>$data["password"],//ne hash le mot de passe ici, car il est déjà hash
            "language"=>"fr",//todo
            "urlavatar"=>$data["urlavatar"],
            "public"=>  $data["publicuser"]=="on" ? 1 :0
        ];
        var_dump($user_row);
        $req = $DB->prepare(//todo faire plus propre
            "UPDATE `user` SET `mail` = :mail, `firstname` = :firstname, `lastname` = :lastname, `sex`= :sex, `birthdate`= :birthdate, `password`= :password, `urlavatar` = :urlavatar, `public` = :public, `language`= :language  WHERE `user`.`id` = :id;");

        $result = $req->execute($user_row);
        $this->setup_session();
        return $result;
    }

}

//["first-name"]=> string(2) "ze" ["last-name"]=> string(2) "ze"
//["url-avatar"]=> string(0) "" ["gender"]=> string(3) "man"
//["birthday"]=> string(10) "2020-12-22" ["email"]=> string(2) "ze"
//["password"]=> string(15) "AGsJyF4t6vX7QNX" ["password-repeat"]=> string(15) "AGsJyF4t6vX7QNX"
//["bp-key"]=> string(2) "ze" ["rememberme"]=> string(2) "on" }
