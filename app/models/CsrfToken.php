<?php
class CsrfToken {
	/**
	 * [Genera token]
	 * @return [string] [Token aleatorio]
	 */
	public static function generaToken() {
		if (!isset($_SESSION['token'])) {
			$randonToken = base64_encode(openssl_random_pseudo_bytes(32));
			return $_SESSION['token'] = $randonToken;
		}
		return $_SESSION['token'];
	}

	/**
	 * [Verifica el token]
	 * @param  [string] $formToken [Token enviado desde el formulario]
	 * @return [boolean] [true el token es correcto]
	 * @return [boolean] [false el token es inválido]
	 */
	public static function varificaToken($formToken) {
		if (isset($_SESSION['token']) && $formToken === $_SESSION['token']) {
			unset($_SESSION['token']);
			return true;
		}
		return false;
	}
}