<?php

namespace BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation as JMS;

/**
 * Customer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BankBundle\Entity\CustomerRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("username")
 */
class Customer
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
	 * @ORM\Column(name="username", type="string", length=60)
	 * @Assert\NotBlank()
	 * @Assert\Length(min=6, max=60)
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9_]+$/", message="Username can contain leters, numbers and _")	 
	 * 
	 * @JMS\Groups({"customer_list", "customer_details", "account_list", "account_details"})
	 */
	private $username;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=true)
	 * 
	 * @JMS\Groups({"customer_list", "customer_details", "account_list", "account_details"})
	 */
	private $createdAt;

	/**
	 * @ORM\OneToMany(targetEntity="Account", mappedBy="customer", cascade={"persist"})
	 * 
	 * @JMS\Groups({"customer_list", "customer_details"})
	 */
	private $accounts;

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
	 * Set username
	 *
	 * @param string $username
	 *
	 * @return Customer
	 */
	public function setUsername($username)
	{
		$this->username = $username;

		return $this;
	}

	/**
	 * Get username
	 *
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Set createdAt
	 *
	 * @param \DateTime $createdAt
	 *
	 * @return Customer
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
	 * Constructor
	 */
	public function __construct()
	{
		$this->accounts = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Add account
	 *
	 * @param \BankBundle\Entity\Account $account
	 *
	 * @return Customer
	 */
	public function addAccount(\BankBundle\Entity\Account $account)
	{
		$this->accounts[] = $account;

		return $this;
	}

	/**
	 * Remove account
	 *
	 * @param \BankBundle\Entity\Account $account
	 */
	public function removeAccount(\BankBundle\Entity\Account $account)
	{
		$this->accounts->removeElement($account);
	}

	/**
	 * Get accounts
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getAccounts()
	{
		return $this->accounts;
	}

	/**
	 * @ORM\PrePersist
	 */
	public function setDateOnPrePersist()
	{
		$this->createdAt = new \DateTime();
	}

}
