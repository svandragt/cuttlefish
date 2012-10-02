<?php

class Security {

	static function admin_redirect() {
		if (self::is_admin()) {
			header('Location: ' . Theming::root() . Theming::content_url('/admin'));
		};
	}

	static function is_admin() {
		return !is_null(Http::session('admin'));
	}

	static function login() {
		if (is_null(Configuration::ADMIN_PASSWORD)) {
			echo "Please set an admin password under Configuration::ADMIN_PASSWORD.<br>";
		} else {
			$password = HTTP::post('password');
			if (is_null($password)) {
				echo "<form method='post'><input type='password' name='password'><input type='submit'></form>";
			} elseif ($password == Configuration::ADMIN_PASSWORD) {
				Http::set_session(array(
					'admin' => true,
				));	
				echo "logged in.<br>";
			}
		}
	}

	static function logout() {
		session_destroy();
		echo "logged out.<br>";
	}
}