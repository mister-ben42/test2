<?php

namespace MDQ\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserBlockType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

			->add('allowError', ChoiceType::class, array(
				'choices' => array(
					'SignalError Autorisé' =>'1',
					'SignalError Interdit' =>'0',					
				),
				'choices_as_values' => true,
				'required'    => true,
				'expanded'   =>true,
			))
	    ->add('supprime', ChoiceType::class, array(
				'choices' => array(
					'Autoriser le compte' =>'0',
					'Supprimer le compte' =>'1',
				),
				'choices_as_values' => true,
				'required'    => true,
				'expanded'   =>true,
			))
	    ->add('allowPropQ', ChoiceType::class, array(
				'choices' => array(
					 'Autoriser Questions' =>'0',
					'Interdire Questions' =>'1',
				),
				'choices_as_values' => true,
				'required'    => true,
				'expanded'   =>true,
			))
	    ->add('roles', CollectionType::class, array(
				'entry_type'   => ChoiceType::class,
				'entry_options'  => array(
				    'choices'  => array(
					'User' => 'ROLE_USER',
					'Admin' => 'ROLE_ADMIN' ,
					'Super Admin' => 'ROLE_SUPER_ADMIN',
				      ),
				'choices_as_values' => true,
				'required'    => true,
			)))
		;
        
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MDQ\UserBundle\Entity\User'
        ));
    }


}
