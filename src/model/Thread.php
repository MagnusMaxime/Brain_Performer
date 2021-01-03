<?php

namespace App\Model;
use PDO;


class ThreadSubject extends SQLTable {

	/*
	 * Instancie sujet avec son titre.
	 */
	static public function from_title($title) {
		global $DB;
		$query = "SELECT `id` FROM `".static::get_name()."` WHERE (`title`=:title)";
		error_log($query);
		$req = $DB->prepare($query);
		$req->execute(["title" => $title]);
		$result = $req->fetch();
		/* var_dump($result); */
		$id = $result["id"];
		error_log($id);
		return new static($id);
	}


	/*
	 * Renvoie le tableau des threads.
	 */
	static public function select_recent($n) {
		global $DB;
		$query = "SELECT `id` FROM `".static::get_name()."` ORDER BY `created` DESC LIMIT ".strval($n);
		error_log($query);
		$req = $DB->prepare($query);
		$req->execute();
		$results = $req->fetchAll(PDO::FETCH_ASSOC);
		$ids = $results[0];
		$subjects = [];
		foreach ($ids as $id => $value) {
			/* echo 'id:'.$id; */
			/* echo 'value:'.$value; */
			$subjects[] = new static($value);
		}
		return $subjects;
	}

	/*
	 * Ajoute un sujet.
	 */
	static public function add($user_id, $title, $description) {
		global $DB;
		$query = "INSERT INTO `".static::get_name()."` (`user`, `title`, `description`) VALUES (:user, :title, :description)";
		error_log($query);
		$req = $DB->prepare($query);
		$req->execute([
			"user" => $user_id,
			"title" => $title,
			"description" => $description
		]);
	}

	/*
	 * Actualise un sujet.
	 */
	static public function update($user_id, $title, $description) {
		global $DB;

	}

	/*
	 * Supprime un sujet.
	 */
	static public function delete($user_id) {
		global $DB;

	}

	/*
	 * Retourne le tableau pour twig.
	 */
	public function info() {
		$row = $this->get_row();
		/* var_dump($row); */
		/* var_dump($row["user"]); */
		$user = new User($row["user"]);
		$user_row = $user->get_info();

		return [
			"id" => $row["id"],
			"title" => $row["title"],
			"description" => $row["description"],
			"user" => $user_row,
			"views" => $row["views"],
			"created" => $row["created"],
			"updated" => $row["updated"]
		];
	}

	/*
	 * Met à jour le nombre de vues.
	 */
	public function increment_views() {
		global $DB;
		$DB->exec('UPDATE views SET views = view + 1 FROM forum_subject');
	}
}


class ThreadMessage extends SQLTable {

	/*
	 * Renvoie le tableau des threads.
	 */
	static function messages($id) {
		global $DB;
		$query = "SELECT `id` FROM `".static::get_name()."` WHERE (`subject`==:subject) ORDER BY `created` DESC";
		/* error_log($query); */
		$req = $DB->prepare($query);
		$req->execute(["subject"=>$subject]);
		$ids = $req->fetchAll();
		$objects = [];
		foreach ($ids as $id) {
			$objects[] = new static($ids["id"]);
		}
		return $objects;
	}

	/*
	 * Ajoute un message.
	 */
	static public function add($user_id, $message, $subject_id) {
		error_log($message);
		global $DB;
		$query = "INSERT INTO `".static::get_name()."` (`user`, `message`, `subject`) VALUES (:user, :message, :subject)";
		error_log($query);
		$req = $DB->prepare($query);
		$req->execute([
			"user" => $user_id,
			"message" => $message,
			"subject" => $subject_id
		]);
	}

	/*
	 * Retourne le tableau pour twig.
	 */
	public function info() {
		$row = $this->get_row();
		$user= new User($row["user"]);
		$user_row = $user->get_info();
		/* $this->increment_views(); */
		return [
			"id" => $row["id"],
			"message" => $row["message"],
			"user" => $user_row,
			"created" => $row["created"],
			"updated" => $row["updated"]
		];
	}
}
