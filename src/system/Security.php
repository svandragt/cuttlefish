<?php

namespace Cuttlefish;

class Security {
	public function maybe_login_redirect() {
		if ( ! $this->is_logged_in() ) {
			$Url = new Url( '/admin' );
			header( 'Location: ' . $Url->url_absolute );
		};
	}

	public function is_logged_in() {
		return ! is_null( Http::session( 'admin' ) );
	}

	public function login() {
		Log::info( sprintf( "Login attempt from %s", $_SERVER['REMOTE_ADDR'] ) );

		$output = "";

		if ( $admin_password = getenv( 'CUTTLEFISH_ADMIN_PASSWORD' ) ) {
			$password = HTTP::post( 'password' );
			if ( $password == $admin_password ) {
				Http::set_session( array(
					'admin' => true,
				) );
				$output .= "logged in.<br>";
				Log::info( "Login attempt successful" );
				$Url = new Url( '/admin' );
				header( 'Location: ' . $Url->url_absolute );
			} else {
				if ( false === empty( $password ) ) {
					Log::warn( "Login attempt unsuccessful." );
					$output .= "Nope.<br>";
				}
				$output .= "<form method='post'><input type='password' name='password'><input type='submit'></form>";

			}
		} else {
			$output .= "To login, create an environment variable called CUTTLEFISH_ADMIN_PASSWORD and a password as the value.<br>";

		}

		return $output;
	}

	public function logout() {
		session_destroy();

		return "logged out.<br>";
	}
}