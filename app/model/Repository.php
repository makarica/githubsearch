<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GHSS\Model;

/**
 * Description of GitHubAPI
 *
 * @author Alexandr Makaric <alexandr@makaric.name>
 */
class Repository {
	protected $headers = array("Accept" => "application/json");

	public function __construct() {
		\Unirest\Request::jsonOpts(true);
	}

}
