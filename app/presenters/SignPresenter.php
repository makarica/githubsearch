<?php

namespace App\Presenters;

/**
 * Sign in/out presenters.
 * @author Alexandr Makaric <alexandr@makaric.name>
 */
class SignPresenter extends BasePresenter {

	private $goto;

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm() {
		$form = new \Nette\Application\UI\Form;
		$form->addText('username', 'Jméno:')
				->setRequired();

		$form->addPassword('password', 'Heslo:')
				->setRequired();

		$form->addSubmit('send', 'Přihlásit');
		
		// call method signInFormSucceeded() on success
		$form->onSuccess[] = $this->signInFormSucceeded;

		return $form;
	}

	public function signInFormSucceeded($form) {
		$values = $form->getValues();

		try {
			$this->getUser()->login($values->username, $values->password);
		} catch (\Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
			return;
		}

		$this->forwardLoggedIn();
	}


	public function actionOut() {
		$this->getUser()->logout();
		$this->info('Byli jste odhlášeni.');
		$this->redirect('in');
	}

	public function actionIn($goto = NULL) {
		$this->goto = $goto ? urldecode($goto) : NULL;
		$this->forwardLoggedIn();
	}

	private function forwardLoggedIn() {
		if ($this->user->isLoggedIn()) {
			if ($this->goto) {
				$this->redirectUrl($this->goto);
			} else {
				$this->redirect('Homepage:');
			}
		}
	}

}
