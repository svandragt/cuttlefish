<?php

class Http {

	static function get($key) {

		return (isset($_GET[$key])) ? htmlspecialchars($_GET[$key]) : null;
	}

	static function server($key) {

		return (isset($_SERVER[$key])) ? htmlspecialchars($_SERVER[$key]) : null;
	}
}