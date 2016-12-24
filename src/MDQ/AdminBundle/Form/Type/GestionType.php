<?php

namespace MDQ\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class GestionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
		$builder
            ->add('blocageTot', CheckboxType::class, array(			
			'required'  => false,
				))
			 ->add('jeuTot', CheckboxType::class, array(			
			'required'  => false,
				))
			 ->add('mq', CheckboxType::class, array(			
			'required'  => false,
				))
			 ->add('ff', CheckboxType::class, array(			
			'required'  => false,
				))
			 ->add('mu', CheckboxType::class, array(			
			'required'  => false,
				))
			 ->add('lx', CheckboxType::class, array(			
			'required'  => false,
				))
			 ->add('wz', CheckboxType::class, array(			
			'required'  => false,
				))
			 ->add('ar', CheckboxType::class, array(			
			'required'  => false,
				))
			 ->add('propQ', CheckboxType::class, array(			
			'required'  => false,
				))
			 ->add('signalE', CheckboxType::class, array(			
			'required'  => false,
				))
			 ->add('inscription', CheckboxType::class, array(			
			'required'  => false,
				))			
			 ->add('jetons_uniques', CheckboxType::class, array(			
			'required'  => false,
				))
			->add('nbJquotMq', TextType::class, array(			
			'required'  => false,
				))
			->add('nbJquotQm', TextType::class, array(			
			'required'  => false,
				))
		;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MDQ\AdminBundle\Entity\Gestion'
        ));
    }


}
