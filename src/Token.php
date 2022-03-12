<?php

namespace Hemend\Library;

use Firebase\JWT\JWT;

class Token {
	static public function encode(Array $tokenConfig = Array(), $key, $alg = 'RS512')
	{
		$tokenConfig = self::getConfig($tokenConfig);

		return JWT::encode($tokenConfig, $key, $alg);
	}

	static public function decode($token, $key, $leeway = null, $allowed_algs = array('RS512'))
	{
		if($leeway !== null) {
			JWT::$leeway = $leeway; // 60 => 60 seconds
		}

		return JWT::decode($token, $key, $allowed_algs);
	}

	public static function getConfig(Array $config = Array())
	{
		if(function_exists('random_bytes')) {
			$tokenId    = bin2hex(random_bytes(32));
		} else {
			$tokenId    = bin2hex(mcrypt_create_iv(32));
		}
		$issuedAt   = time();
		$notBefore  = $issuedAt + 1;             //Adding 1 seconds
		$expire     = $notBefore + 10;            // Adding 10 seconds
		$serverName = $_SERVER['SERVER_NAME'];

		$default_config = [
			'iss'       => $serverName, // Issuer: server name
			'sub'       => null,        // Subject: Usually a user ID
			'aud'       => null,        // Audience: Who the claim is meant for (rarely used)
			'exp'       => $expire,     // Expire: time token expires
			'nbf'       => $notBefore,  // Not before: time token becomes valid
			'iat'       => $issuedAt,   // Issued at: time when the token was generated
			'jti'       => $tokenId,    // Json Token Id: an unique identifier for the token
			//'typ'       => null,        // Type: Mirrors the typ header (rarely used)
		];

		$config = array_merge($default_config, $config);

		$config = array_filter($config, '\Hemend\Library\Token::isNotNull');

		return $config;
	}

	public static function isNotNull($val)
	{
		return !is_null($val);
	}
}
