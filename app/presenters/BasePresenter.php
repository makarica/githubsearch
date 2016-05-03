<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Presenters;

/**
 * Description of BasePresenter
 *
 * @author Alexandr Makaric <alexandr@makaric.name>
 */
class BasePresenter extends \Nette\Application\UI\Presenter {
	/** @var \DK\Menu\UI\IControlFactory @inject */
	public $menuFactory;
	
	public function createComponentMenu() {
		return $this->menuFactory->create();
	}
	
	protected function errorFlash($message) {
		$this->flashMessage($message, 'danger');
	}
	
	protected function success($message) {
		$this->flashMessage($message, 'success');
	}
	
	protected function info($message) {
		$this->flashMessage($message);
	}
}
