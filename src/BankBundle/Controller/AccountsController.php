<?php

namespace BankBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\View\View,
	FOS\RestBundle\Controller\Annotations;
use Symfony\Component\HttpFoundation\RequestStack,
	Symfony\Component\Routing\RouterInterface;
use BankBundle\Service\AccountService,
	BankBundle\Exception\FormValidationException;
use JMS\Serializer\SerializationContext;

class AccountsController
{

	private $request;
	private $accountService;
	private $router;

	public function __construct(RequestStack $requestStack,
			AccountService $accountService, RouterInterface $router)
	{
		$this->request = $requestStack->getCurrentRequest();
		$this->accountService = $accountService;
		$this->router = $router;
	}

	/**
	 * @Annotations\View(serializerGroups={"account_list"})
	 *
	 * @return Collection
	 */
	public function getAccountsAction()
	{
		return $this->accountService->getAccounts($this->request->query->all());
	}

	/**
	 * Create new account
	 */
	public function postAccountsAction()
	{
		try {
			$account = $this->accountService->createAccount($this->request);
		}
		catch (FormValidationException $e) {

			return View::create($e->getForm(), 400);
		}

		$view = View::create($account, 201)
				->setHeader('Location', $this->router->generate('get_account', ['id' => $account->getId()], true));

		$context = new SerializationContext();
		$context->setGroups(array('account_list'));
		$view->setSerializationContext($context);

		return $view;
	}

	/**
	 * @Annotations\View(serializerGroups={"account_details"})
	 */
	public function getAccountAction($id)
	{

		return $this->accountService->getAccount($id);
	}

}
