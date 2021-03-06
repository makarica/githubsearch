<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GHSS\Model;

/**
 * Description of SearchesRepository
 *
 * @author Alexandr Makaric <alexandr@makaric.name>
 */
class SearchesRepository extends Repository {
	
	public function deleteOlderThan($hours) {
		$time  = new \Nette\Utils\DateTime;
		$time->sub(new \DateInterval('PT'. $hours. 'H'));
		return $this->findBy(array('time <' => $time))->delete();
	}
	
}
