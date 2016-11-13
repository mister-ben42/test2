<?php

namespace MDQ\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GestionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
		$builder
            ->add('blocageTot', 'checkbox', array(			
			'required'  => false,
				))
			 ->add('jeuTot', 'checkbox', array(			
			'required'  => false,
				))
			 ->add('mq', 'checkbox', array(			
			'required'  => false,
				))
			 ->add('ff', 'checkbox', array(			
			'required'  => false,
				))
			 ->add('mc', 'checkbox', array(			
			'required'  => false,
				))
			 ->add('lx', 'checkbox', array(			
			'required'  => false,
				))
			 ->add('ar', 'checkbox', array(			
			'required'  => false,
				))
			 ->add('propQ', 'checkbox', array(			
			'required'  => false,
				))
			 ->add('signalE', 'checkbox', array(			
			'required'  => false,
				))
			 ->add('inscription', 'checkbox', array(			
			'required'  => false,
				))			
			 ->add('jetons_uniques', 'checkbox', array(			
			'required'  => false,
				))
			 ->add('nbJinit', 'text', array(			
			'required'  => false,
				))
			->add('nbJquot', 'text', array(			
			'required'  => false,
				))
		;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MDQ\AdminBundle\Entity\Gestion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mdq_adminbundle_gestion';
    }
}
