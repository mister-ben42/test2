<?php

namespace MDQ\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserBlockType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('locked', 'choice', array(
				'choices' => array(
					'0' => 'accessible',
					'1' => 'bloqué',					
				),
				'required'    => true,
				'expanded'   =>true,
			))
			->add('allowError', 'choice', array(
				'choices' => array(
					'1' => 'SignalError Autorisé',
					'0' => 'SignalError Interdit',					
				),
				'required'    => true,
				'expanded'   =>true,
			))
	    ->add('supprime', 'choice', array(
				'choices' => array(
					'0' => 'Autoriser le compte',
					'1' => 'Supprimer le compte',
				),
				'required'    => true,
				'expanded'   =>true,
			))
	    ->add('allowPropQ', 'choice', array(
				'choices' => array(
					'0' => 'Autoriser Questions',
					'1' => 'Interdire Questions',
				),
				'required'    => true,
				'expanded'   =>true,
			))
	    ->add('roles', 'collection', array(
				'type'   => 'choice',
				'options'  => array(
				    'choices'  => array(
					'ROLE_USER' => 'User',
					'ROLE_ADMIN'     => 'Admin',
					'ROLE_SUPER_ADMIN'    => 'Super Admin',
				      ),
				'required'    => true,
			)))
		;
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MDQ\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mdq_userbundle_userblock';
    }
}
