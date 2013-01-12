<?php
namespace ComicRank\View;

abstract class HTTP {
	public $statuscode = 200;
	public $headers;
	
	/**
	 * [__construct description]
	 */
	public function __construct() {
		$this->headers = new \ComicRank\Model\CaseInsensitiveArray;
	}
	
	/**
	 * [outputHeaders description]
	 */
	public function outputHeaders() {
		header(':', true, $this->statuscode);
		foreach ($this->headers as $key => $value) {
			header($key.': '.$value);
		}
	}
	
	
	public function exitRedirectPermanent($url) {
		$this->statuscode = 301;
		if (substr($url, 0, 1) == '/') $url = URL_SITE.$url;
		$this->headers['Location'] = $url;
		$this->outputHeaders();
		exit;
	}
	
	public function exitRedirectTemporary($url) {
		$this->statuscode = 302;
		if (substr($url, 0, 1) == '/') $url = URL_SITE.$url;
		$this->headers['Location'] = $url;
		$this->outputHeaders();
		exit;
	}
	
	public function exitForbidden() {
		$this->statuscode = 403;
		$this->outputHeaders();
		exit;
	}
	
	public function exitNotFound() {
		$this->statuscode = 404;
		$this->outputHeaders();
		exit;
	}
	
	public function exitGone() {
		$this->statuscode = 410;
		$this->outputHeaders();
		exit;
	}
	
	public function exitInternalError() {
		$this->statuscode = 500;
		$this->outputHeaders();
		exit;
	}
	
	public function exitUnavailable() {
		$this->statuscode = 503;
		$this->outputHeaders();
		exit;
	}
	
}
