<?php

namespace MDQ\QuestionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CritEditQaValType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('repAdmin', ChoiceType::class, array(
				'choices' => array(
					'Pas encore étudiées'=>'0',
					'Refusées'=>'1',
					'Retournées'=>'2',
					'Retournées et modifiées'=>'3',
					'Toutes'=>'4'
				),
				'choices_as_values' => true,
				'required'    => true,				
				'data'  => '0'
			))
			->add('dom1',   ChoiceType::class, array(
				'choices' => array(
					'tous' => 'none',
					'Histoire' => 'Histoire',
					'Géographie' => 'Géographie',
					'Sciences et nature' => 'Sciences et nature',
					'Arts et Littérature' => 'Arts et Littérature',
					'Sports et loisirs' => 'Sports et loisirs',
					'Divers' => 'Divers'					
				),
				'choices_as_values' => true,
				'required'    => true,
				'data'  => 'none'
			))
            ->add('diff', ChoiceType::class, array(
				'choices' => array(
					'Toutes'=>'0',
					'Très facile'=>'1',
					'Facile'=>'2',
					'Moyen'=>'3',
					'Difficile'=>'4',
					'Très difficile'=>'5',											
				),
				'choices_as_values' => true,
				'required'    => true,				
				'empty_data'  => 0
			))
            
            ->add('crit', ChoiceType::class, array(
				'choices' => array(
					'id' => 'id',
					'domaine'=>'dom1',
					'difficulté'=>'diff',
				),
				'choices_as_values' => true,
				'required'    => true,
				'data'  => 'id'
			))
            ->add('sens', ChoiceType::class, array(
				'choices' => array(
					'croissant'=>'ASC',
					'décroissant'=>'DESC'										
				),
				'choices_as_values' => true,
				'required'    => true,
				'data'  => 'ASC'
			))
            ->add('nbdeQ', ChoiceType::class, array(
				'choices' => array(
					'toutes'=>'0',
					'10' => '10',
					'50' => '50',
					'100' => '100',
					'200' => '200',
					'500' => '500',
					'1000' => '1000',										
				),
				'choices_as_values' => true,
				'required'    => true,				
				'data'  => '0'
			))
            ->add('nbmin', TextType::class, array(
				'data' => '1'
			))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MDQ\QuestionBundle\Entity\CritEditQaVal'
        ));
    }

}
