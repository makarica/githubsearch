<?php

namespace GHSS\Model;

use Nette;


/**
 * Users management.
 */
class Authenticator extends Nette\Object implements Nette\Security\IAuthenticator
{



	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		if ($username != 'admin' && $username != 'manager') {
			throw new Nette\Security\AuthenticationException('Nesprávné jméno.', self::IDENTITY_NOT_FOUND);

		} elseif ($username != $password) {
			throw new Nette\Security\AuthenticationException('Nesprávné heslo.', self::INVALID_CREDENTIAL);
		}

		
		return new Nette\Security\Identity($username, $username, array('username' => $username, 'password' => $password));
	}

}
