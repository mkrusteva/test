<?php

namespace BankBundle\Service;

use Symfony\Component\Form\FormFactory;
use BankBundle\Entity\CustomerRepository,
	BankBundle\Form\RestCustomerType,
	BankBundle\Exception\FormValidationException,
	BankBundle\Entity\Account;

class CustomerService
{

	private $customerRepo;
	private $formFactory;

	public function __construct(CustomerRepository $customerRepo,
			FormFactory $formFactory)
	{
		$this->customerRepo = $customerRepo;
		$this->formFactory = $formFactory;
	}

	/**
	 * Get collection of Customer
	 */
	public function getCustomers()
	{
		return $this->customerRepo->findAll();
	}

	/**
	 * Create new customer
	 */
	public function createCustomer($request)
	{

		$customer = $this->customerRepo->createNew();

		$form = $this->formFactory->create(new RestCustomerType(), $customer);

		$form->handleRequest($request);

		if (!$form->isValid()) {

			throw new FormValidationException($form);
		}

		$customer->addAccount(new Account());
		$this->customerRepo->save($customer);

		return $customer;
	}

	/**
	 * Get customer by ID
	 */
	public function getCustomer($id)
	{
		$customer = $this->customerRepo->find($id);

		if (!$customer) {

			throw new NotFoundHttpException('Customer does not exist.');
		}

		return $customer;
	}

}
