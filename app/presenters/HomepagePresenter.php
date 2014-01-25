<?php

namespace App;

use Nette,
	Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	const CSRF_TOKEN_KEY = '__token__';

	/** @persistent bool */
	public $disabledJavascript = false;


	protected function beforeRender()
	{
		$this->template->disabledJavascript = $this->disabledJavascript;
	}


	public function handleSignal()
	{
		if (!$this->checkCsrfToken($this->getHttpRequest()->getPost(static::CSRF_TOKEN_KEY))) {
			$this->setView('_form');
			$this->template->message = 'Are you sure you want to do some action?';
			$this->template->yesAction = $this->link('signal!');
			$this->template->noAction = $this->link('this');
			return;
		}
		$this->flashMessage('Some action was done.');
		$this->redirect('default');
	}



	public function generateCsrfToken()
	{
		$token = $this->getCsrfToken();
		$random = Nette\Utils\Strings::random(strlen($token));
		return base64_encode($random . Utils\Strings::xorStrings($random, $token));
	}



	public function checkCsrfToken($token)
	{
		$token = base64_decode($token);
		if (!$token) {
			return false;
		}

		$length = strlen($token);
		if ($length === 0 || $length % 2 !== 0) {
			return false;
		}

		$parts = str_split($token, $length / 2);
		return Utils\Strings::xorStrings($parts[0], $parts[1]) === $this->getCsrfToken();
	}



	protected function getCsrfToken()
	{
		$session = $this->getSession()->getSection('App.HomepagePresenter/csrf');
		if (!isset($session->token)) {
			$session->token = Nette\Utils\Strings::random();
		}
		return $session->token;
	}

}
