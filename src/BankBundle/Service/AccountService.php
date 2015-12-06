<?php

namespace BankBundle\Service;

use Symfony\Component\Form\FormFactory;
use BankBundle\Entity\AccountRepository,
	BankBundle\Form\RestAccountType,
	BankBundle\Exception\FormValidationException;

class AccountService
{

	private $accountRepo;
	private $formFactory;

	public function __construct(AccountRepository $accountRepo,
			FormFactory $formFactory)
	{
		$this->accountRepo = $accountRepo;
		$this->formFactory = $formFactory;
	}

	/**
	 * Get collection of Account
	 */
	public function getAccounts()
	{
		return $this->accountRepo->findAll();
	}

	/**
	 * Create new account
	 */
	public function createAccount($request)
	{

		$account = $this->accountRepo->createNew();

		$form = $this->formFactory->create(new RestAccountType(), $account);

		$form->handleRequest($request);


		if (!$form->isValid()) {

			throw new FormValidationException($form);
		}

		$this->accountRepo->save($account);

		return $account;
	}

	/**
	 * Get customer by ID
	 */
	public function getAccount($id)
	{
		$account = $this->accountRepo->find($id);

		if (!$account) {

			throw new NotFoundHttpException('Account does not exist.');
		}

		return $account;
	}

}
