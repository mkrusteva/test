<?php

namespace BankBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\View\View,
	FOS\RestBundle\Controller\Annotations;
use Symfony\Component\HttpFoundation\RequestStack,
	Symfony\Component\Routing\RouterInterface;
use BankBundle\Service\CustomerService,
	BankBundle\Exception\FormValidationException;
use JMS\Serializer\SerializationContext;

class CustomersController
{

	private $request;
	private $customerService;
	private $router;

	public function __construct(RequestStack $requestStack,
			CustomerService $customerService, RouterInterface $router)
	{
		$this->request = $requestStack->getCurrentRequest();
		$this->customerService = $customerService;
		$this->router = $router;
	}

	/**
	 * @Annotations\View(serializerGroups={"customer_list"})
	 *
	 * @return Collection
	 */
	public function getCustomersAction()
	{
		return $this->customerService->getCustomers($this->request->query->all());
	}

	/**
	 */
	public function postCustomersAction()
	{
		try {
			$customer = $this->customerService->createCustomer($this->request);
		}
		catch (FormValidationException $e) {

			return View::create($e->getForm(), 400);
		}

		$view = View::create($customer, 201)
				->setHeader('Location', $this->router->generate('get_customer', ['id' => $customer->getId()], true));

		$context = new SerializationContext();
		$context->setGroups(array('customer_list'));
		$view->setSerializationContext($context);

		return $view;
	}

	/**
	 * @Annotations\View(serializerGroups={"customer_details"})
	 */
	public function getCustomerAction($id)
	{

		return $this->customerService->getCustomer($id);
	}

}
