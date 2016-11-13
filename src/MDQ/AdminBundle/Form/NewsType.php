<?php

namespace MDQ\AdminBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ->add('auteur', 'text')
            ->add('publication', 'checkbox', array(			
			'required'  => false,
				))
			 ->add('priorite', 'checkbox', array(			
			'required'  => false,
				))
		/*	->add('captcha', 'captcha', array(
					'as_url' => true,
					'reload' => true,
					'mapped' => false,
					'width' => 150,
					'height' => 50,
					'length' => 3,
						))*/
		;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MDQ\AdminBundle\Entity\News'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mdq_adminbundle_news';
    }
}
