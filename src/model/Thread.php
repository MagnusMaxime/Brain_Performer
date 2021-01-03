<?php

namespace App\Model;


class ThreadSubject extends SQLTable {
	/*
	 * Renvoie le tableau twig des sujets récents.
	 */
	static public function get_context($n) {
		$context = [];
		$subjects = self::select_recent($n);
		foreach ($subjects as $subject) {
			$context[] = $subject->info();
		}
		return $context;
	}

	/*
	 * Renvoie le tableau des threads.
	 */
	static function select_recent($n) {
		global $DB;
		$query = "SELECT `id` FROM `".static::get_name()."` ORDER BY `created` DESC LIMIT ".strval($n);
		error_log($query);
		$req = $DB->prepare($query);
		$req->execute();
		$ids = $req->fetchAll();
		$subjects = [];
		foreach ($ids as $id) {
			$subjects[] = new static($id);
		}
		return $subjects;
	}

	/*
	 * Retourne le tableau pour twig.
	 */
	public function info() {
		$row = $this->get_row();
		$user = new User($row["user"]);
		$user_row = $user->get_info();

		$this->increment_views();
		return [
			"id" => $row["id"],
			"title" => $row["title"],
			"description" => $row["description"],
			"user" => $user_row,
			"views" => $row["views"],
			"created" => $row["created"],
			"updated" => $row["updated"]
		];
		return $row;
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
	 * Retourne le tableau twig en fonction du titre du sujet.
	 */
	public function get_context($title) {
		global $DB;

	}

	/*
	 * Renvoie le tableau des threads.
	 */
	static function messages($id) {
		global $DB;
		$query = "SELECT `id` FROM `".static::get_name()."` WHERE (`subject`==:subject) ORDER BY `created` DESC LIMIT ".strval($n);
		error_log($query);
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
	 * Retourne le tableau pour twig.
	 */
	public function info() {
		$row = $this->get_row();
		$user= new User($row["user"]);
		$user_row = $user->get_info();
		return [
			"id" => $row["id"],
			"message" => $row["message"],
			"user" => $user_row,
			"created" => $row["created"],
			"updated" => $row["updated"]
		];
		return $row;
	}
}
