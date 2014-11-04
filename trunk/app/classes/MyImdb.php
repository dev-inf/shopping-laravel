<?php
class MyImdb {
	public static function searchDataMovieByTitle($title){
        require_once(getcwd() . "/vendor/imdb/imdbsearch.class.php");
        require_once(getcwd(). "/vendor/imdb/imdb.class.php");
        $search = new imdbsearch();
		$search->setsearchname($title);
		return $search->results();
	}

	public static function getDetailMovie($id){
		if (isset ($id) && preg_match('/^[0-9]+$/',$id)) {
	        require_once(getcwd(). "/vendor/imdb/imdb.class.php");
	        $movie = new imdb($id);
	  		$movie->setid($id);
			return $movie;
		}
	}

	public static function searchDataPositionByName($name){
		require_once(getcwd() . "/vendor/imdb/imdb_person.class.php");
		$search = new imdbpsearch();
		$search->setsearchname($name);
		return $search->results();
	}

	public static function getDetailPosition($id){
		if (isset ($id) && preg_match('/^[0-9]+$/',$id)) {
			require_once(getcwd(). "/vendor/imdb/imdb_person.class.php");
			$position = new imdb_person($id);
			return $position;
		}
	}
}