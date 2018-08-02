<?php

namespace VanDragt\Carbon;

class Security {

	function login_redirect() {
		if ( ! $this->is_logged_in() ) {
			$url = new Url();
			header( 'Location: ' . $url->index( '/admin' )->abs()->url );
		};
	}

	function is_logged_in() {
		return ! is_null( Http::session( 'admin' ) );
	}

	function login() {
		Log::info( sprintf( "Login attempt from %s", $_SERVER['REMOTE_ADDR'] ) );

		$output = "";

		if ( $admin_password = getenv( 'CARBON_ADMIN_PASSWORD' ) ) {
			$password = HTTP::post( 'password' );
			if ( $password == $admin_password ) {
				Http::set_session( array(
					'admin' => true,
				) );
				$output .= "logged in.<br>";
				Log::info( "Login attempt successful" );
				$url = new Url();
				header( 'Location: ' . $url->index( '/admin' )->abs()->url );
			} else {
				if ( false === empty( $password ) ) {
					Log::warn( "Login attempt unsuccessful." );
					$output .= "Nope.<br>";
				}
				$output .= "<form method='post'><input type='password' name='password'><input type='submit'></form>";

			}
		} else {
			$output .= "To login, create an environment variable called CARBON_ADMIN_PASSWORD and a password as the value.<br>";

		}

		return $output;
	}

	function logout() {
		session_destroy();

		return "logged out.<br>";
	}
}