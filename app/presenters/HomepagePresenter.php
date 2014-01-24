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
		if ($this->getHttpRequest()->getPost(static::CSRF_TOKEN_KEY) !== $this->getCsrfToken()) {
			$this->setView('_form');
			$this->template->message = 'Are you sure you want to do some action?';
			$this->template->yesAction = $this->link('signal!');
			$this->template->noAction = $this->link('this');
			return;
		}
		$this->flashMessage('Some action was done.');
		$this->redirect('default');
	}


	public function getCsrfToken()
	{
		$session = $this->getSession()->getSection('App.HomepagePresenter/csrf');
		if (!isset($session['token'])) {
			$session['token'] = Nette\Utils\Strings::random();
		}
		return $session['token'];
	}

}
