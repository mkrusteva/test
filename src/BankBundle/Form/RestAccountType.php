<?php

namespace BankBundle\Form;

use Symfony\Component\Form\AbstractType,
	Symfony\Component\Form\FormBuilderInterface,
	Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RestAccountType extends AbstractType
{

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
				->add('customer', 'entity', array('class' => 'BankBundle:Customer'))
		;
	}

	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'BankBundle\Entity\Account',
			'csrf_protection' => false,
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return '';
	}

}
