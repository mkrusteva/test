<?php

namespace BankBundle\Exception;

class FormValidationException extends \Exception
{

	public function __construct($form, $message = '', $code = 400, $previous = NULL)
	{
		parent::__construct($message, $code, $previous);

		$this->form = $form;
	}

	public function getForm()
	{
		return $this->form;
	}

}
