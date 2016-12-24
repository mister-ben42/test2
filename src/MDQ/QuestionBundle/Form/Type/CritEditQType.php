<?php

namespace MDQ\QuestionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CritEditQType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('error', ChoiceType::class, array(
				'choices' => array(
					'Toutes'=>'2',
					'non' =>'0',
					'oui'=> '1'
				),
				'choices_as_values' => true,
				'required'    => true,				
				'empty_data'  => '2'
			))
			->add('valid', ChoiceType::class, array(
				'choices'=>array(
					'Non Validées'=>'0',
					'Validées'=>'1',
					'Passées'=>'2',					
					'Pas encore étudiées'=>'3',
					'Toutes'=>'4',
				),
				'choices_as_values' => true,
				'required'    => true,				
				'data'  => '3'
			))		
            ->add('diff', ChoiceType::class, array(
				'choices' => array(
					'none'=>'0',
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
            ->add('game',   ChoiceType::class, array(
				'choices' => array(
					'none' => 'none',
					'MasterQuizz'=>'MasterQuizz',
					'Quizz Média'=>'Quizz Média',
					'Autre'=>'Autre',
				),
				'choices_as_values' => true,
				'required'    => true,
				'empty_data'  => 'none'
			))
            ->add('dom1',   ChoiceType::class, array(
				'choices' => array(
					'none' => 'none',
					'MasterQuizz'=>array(						
						'Histoire' => 'Histoire',
						'Géographie' => 'Géographie',
						'Sciences et nature' => 'Sciences et nature',
						'Arts et Littérature' => 'Arts et Littérature',
						'Sports et loisirs' => 'Sports et loisirs',
						'Divers' => 'Divers'
					),
					'Quizz Média'=>array(
						'Faune et Flore'=>'FfQuizz',
						'Quizz Art'=>'ArQuizz',
						'Musique classique'=>'MuQuizz',
						'Quizz Géo'=>'LxQuizz',
						'Quizz Wouzou'=>'WzQuizz'
						),
					'Quizz en Folie'=>array(
						'TvQuizz'=>'TvQuizz',
						'Regard de star'=>'EyesQuizz',
						'SexyQuizz'=>'SexyQuizz'
					),
				),
				'choices_as_values' => true,
				'required'    => true,
				'empty_data'  => 'none'
			))
            ->add('theme', EntityType::class, array(
					'class' => 'MDQQuestionBundle:Theme',
					'choice_label' =>'nom',					
					'group_by'=>'dom1',
					'required'=>true,
					'empty_data'  => 'none'
			))
            ->add('crit', ChoiceType::class, array(
				'choices' => array(
					'id' => 'id',
					'domaine'=>'dom1',
					'theme' => 'thème',
					'difficulté'=>'diff',
					'nb de fois joué'=>'nbJoue',
					'% de bonnes réponses'=>'prctBrep',
					'type de question'=>'type'			
				),
				'choices_as_values' => true,
				'required'    => true,
				'empty_data'  => 'id'
			))
            ->add('sens', ChoiceType::class, array(
				'choices' => array(
					'croissant'=>'ASC',
					'décroissant'=>'DESC'										
				),
				'choices_as_values' => true,
				'required'    => true,
				'empty_data'  => 'ASC'
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
				'empty_data'  => '0'
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
            'data_class' => 'MDQ\QuestionBundle\Entity\CritEditQ'
        ));
    }


}
