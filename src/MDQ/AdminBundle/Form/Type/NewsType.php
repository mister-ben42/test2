<?php

namespace MDQ\AdminBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NewsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
		$builder
            ->add('titre')
            ->add('texte')
            ->add('dateCreate')
            ->add('auteur', TextType::class)
            ->add('publication', CheckboxType::class, array(			
			'required'  => false,
				))
			 ->add('priorite', CheckboxType::class, array(			
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
            'data_class' => 'MDQ\AdminBundle\Entity\News'
        ));
    }


}
