<?php

namespace BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * Account
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BankBundle\Entity\AccountRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Account
{

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * 
	 * @JMS\Groups({"customer_list", "customer_details", "account_list", "account_details"})
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="balance", type="decimal", scale=2)
	 * 
	 * @JMS\Groups({"customer_list", "customer_details", "account_list", "account_details"})
	 */
	private $balance = 0;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=true)
	 * 
	 * @JMS\Groups({"customer_list", "customer_details", "account_list", "account_details"})
	 */
	private $createdAt;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="updated_at", type="datetime", nullable=true)
	 * 
	 * @JMS\Groups({"account_list", "account_details"})
	 */
	private $updatedAt;

	/**
	 * @ORM\ManyToOne(targetEntity="Customer", inversedBy="accounts")
	 * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
	 * 
	 * @Assert\NotBlank()
	 * 
	 * @JMS\Groups({"account_list", "account_details"})
	 */
	private $customer;

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set balance
	 *
	 * @param string $balance
	 *
	 * @return Account
	 */
	public function setBalance($balance)
	{
		$this->balance = $balance;

		return $this;
	}

	/**
	 * Get balance
	 *
	 * @return string
	 */
	public function getBalance()
	{
		return $this->balance;
	}

	/**
	 * Set createdAt
	 *
	 * @param \DateTime $createdAt
	 *
	 * @return Account
	 */
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	/**
	 * Get createdAt
	 *
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * Set updatedAt
	 *
	 * @param \DateTime $updatedAt
	 *
	 * @return Account
	 */
	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}

	/**
	 * Get updatedAt
	 *
	 * @return \DateTime
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * Set customer
	 *
	 * @param \BankBundle\Entity\Customer $customer
	 *
	 * @return Account
	 */
	public function setCustomer(\BankBundle\Entity\Customer $customer = null)
	{
		$this->customer = $customer;

		return $this;
	}

	/**
	 * Get customer
	 *
	 * @return \BankBundle\Entity\Customer
	 */
	public function getCustomer()
	{
		return $this->customer;
	}

	/**
	 * @ORM\PrePersist
	 */
	public function setDatesOnPrePersist()
	{
		$this->createdAt = new \DateTime();
		$this->updatedAt = new \DateTime();
	}

}
