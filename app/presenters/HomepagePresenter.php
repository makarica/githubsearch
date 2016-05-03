<?php

namespace App\Presenters;

use Nette;

class HomepagePresenter extends BasePresenter {

	const PER_PAGE = 10;

	/** @persistent */
	public $page = 1;

	/** @var \GHSS\Model\GitHubDatasource @inject */
	public $github;

	/** @var \GHSS\Model\SearchesRepository @inject */
	public $searchesRepo;
	private $results = array();

	/** @var \Nette\Http\Request @inject */
	public $httpRequest;

	public function renderDefault() {
		$this->template->results = $this->results;
	}

	public function renderList() {
		$p = new \Nette\Utils\Paginator();
		$p->setItemsPerPage(self::PER_PAGE);

		$searches = $this->searchesRepo->findAll()->order('time DESC')->limit($p->getLength(),
																		$p->getOffset());

		$p->setItemCount($this->searchesRepo->findAll()->count());
		if ($p->getPageCount() < $this->page) {
			$this->page = $p->getPageCount();
		}
		if ($this->page < 1) {
			$this->page = 1;
		}
		
		$p->setPage($this->page);

		$this->template->searches = $searches;
		$this->template->page = $this->page;
		$this->template->paginator = $p;
	}
	
	public function actionManage() {
		if (!$this->user->isLoggedIn()) {
			$this->errorFlash('Nejste přihlášeni!');
			$this->redirect('default');
		}
	}

	protected function createComponentSearchForm() {
		$f = new \Nette\Application\UI\Form();
		$f->addText('query', 'Uživatelské jméno')
				->setRequired()
				->addRule(\Nette\Application\UI\Form::MAX_LENGTH,
			  'Uivatelské jméno nemůže být delší než %d znaků!', 39)
				->addRule(\Nette\Application\UI\Form::PATTERN, 'Může obsahovat pouze znaky a čísla.', '^[a-zA-Z0-9]+$');
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
			'time' => new Nette\Utils\DateTime(),
			'ip' => $this->httpRequest->getRemoteAddress()
		));
	}
	
	protected function createComponentDeleteForm() {
		$f = new \Nette\Application\UI\Form;
		$f->addText('hours', 'Vymazat záznamy starší než X hodin:')
				->setRequired()
				->addRule(\Nette\Application\UI\Form::PATTERN, 'Hodnota musí být číslo!', '^[0-9]+$');
		$f->addSubmit('submit', 'Vymazat');
		
		$f->onSuccess[] = $this->deleteForSubmitted;
		return $f;
	}
	
	public function deleteForSubmitted(\Nette\Application\UI\Form $f) {
		$v = $f->getValues();
		$c = $this->searchesRepo->deleteOlderThan($v->hours);
		
		$this->page = 1;
		
		$this->success("Bylo vymazáno $c záznamů.");
		$this->redirect('this');
	}

}
