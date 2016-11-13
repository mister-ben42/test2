<?php

namespace MDQ\QuestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CritEditQaValType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('repAdmin', 'choice', array(
				'choices' => array(
					'0' => 'Pas encore étudiées',
					'1' => 'Refusées',
					'2'=> 'Retournées',
					'3'=> 'Retournées et modifiées',
					'4' => 'Toutes'
				),
				'required'    => true,				
				'data'  => '0'
			))
			->add('dom1',   'choice', array(
				'choices' => array(
					'none' => 'tous',
					'Histoire' => 'Histoire',
					'Géographie' => 'Géographie',
					'Sciences et nature' => 'Sciences et nature',
					'Arts et Littérature' => 'Arts et Littérature',
					'Sports et loisirs' => 'Sports et loisirs',
					'Divers' => 'Divers'					
				),
				'required'    => true,
				'data'  => 'none'
			))
            ->add('diff', 'choice', array(
				'choices' => array(
					'0' => 'toutes',
					'1' => 'Très facile',
					'2' => 'Facile',
					'3' => 'Moyen',
					'4' => 'Difficile',
					'5' => 'Très difficile',										
				),
				'required'    => true,				
				'empty_data'  => 0
			))
            
            ->add('crit', 'choice', array(
				'choices' => array(
					'id' => 'id',
					'dom1'=> 'domaine',
					'diff' => 'difficulté',	
				),
				'required'    => true,
				'data'  => 'id'
			))
            ->add('sens', 'choice', array(
				'choices' => array(
					'ASC' => 'croissant',
					'DESC' => 'décroissant'										
				),
				'required'    => true,
				'data'  => 'ASC'
			))
            ->add('nbdeQ', 'choice', array(
				'choices' => array(
					'0' => 'toutes',
					'10' => '10',
					'50' => '50',
					'100' => '100',
					'200' => '200',
					'500' => '500',
					'1000' => '1000',										
				),
				'required'    => true,				
				'data'  => '0'
			))
            ->add('nbmin', 'text', array(
				'data' => '1'
			))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MDQ\QuestionBundle\Entity\CritEditQaVal'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mdq_questionbundle_criteditqaval';
    }
}
