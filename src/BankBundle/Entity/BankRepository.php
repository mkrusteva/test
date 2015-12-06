<?php

namespace BankBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BankRepository extends EntityRepository
{

	protected $_limit = 100;
	protected $_offset = 0;
	protected $_order;

	public function createNew()
	{
		$className = $this->getClassName();
		$object = new $className();
		return $object;
	}

	public function save($entity)
	{
		$this->_em->persist($entity);
		$this->_em->flush();
	}

}
