<?php

namespace App\Presenters;

use Nette;

class HomepagePresenter extends BasePresenter {

	/** @var \GHSS\Model\GitHubDatasource @inject */
	public $github;	
	
	/** @var \GHSS\Model\SearchesRepository @inject */
	public $searchesRepo;
	
	private $results = array();

	public function renderDefault() {
		$this->template->results = $this->results;
	}
	
	protected function createComponentSearchForm() {
		$f = new \Nette\Application\UI\Form();
		$f->addText('query', 'Uživatelské jméno')
				->setRequired()
				->addRule(\Nette\Application\UI\Form::MAX_LENGTH, 'Uivatelské jméno nemůže být delší než %d znaků!', 39);
		$f->addSubmit('submit', 'Hledat');
		
		$f->onSuccess[] = $this->searchFormSubmitted;	
		
		return $f;
	}
	
	public function searchFormSubmitted(\Nette\Application\UI\Form $form) {
		$v = $form->getValues();
		$data = $this->github->getRepositoriesOf($v->query);
		
		if ($data->code == 200) {
			$this->results = $data->body;
		} else {
			$this->results = array();
			$this->errorFlash($data->body['message']);
		}
		
		$this->searchesRepo->create(array(
			'query' => $v->query,
			'time' => new Nette\Utils\DateTime()
		));
	
	}


}
