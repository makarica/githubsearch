<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GHSS\Model;

/**
 * Description of GitHubDatasource
 *
 * @author Alexandr Makaric <alexandr@makaric.name>
 */
class GitHubDatasource extends Repository {
	const HOSTNAME = 'https://api.github.com/';
	
	public function getRepositoriesOf($username) {
		return \Unirest\Request::get(self::HOSTNAME. 'users/'. $username. '/repos', $this->headers, array(
			'sort' => 'created',
			'direction' => 'desc'
		));
	}
}
