<?php

namespace MDQ\QuestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CritEditQType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('error', 'choice', array(
				'choices' => array(
					'2'=>'Toutes',
					'0' => 'non',
					'1' => 'oui'
				),
				'required'    => true,				
				'empty_data'  => '2'
			))
			->add('valid', 'choice', array(
				'choices'=>array(
					'0'=>'Non Validées',
					'1'=>'Validées',
					'2'=>'Passées',					
					'3'=>'Pas encore étudiées',
					'4'=>'Toutes',
				),
				'required'    => true,				
				'data'  => '3'
			))		
            ->add('diff', 'choice', array(
				'choices' => array(
					'0' => 'none',
					'1' => 'Très facile',
					'2' => 'Facile',
					'3' => 'Moyen',
					'4' => 'Difficile',
					'5' => 'Très difficile',										
				),
				'required'    => true,				
				'empty_data'  => 0
			))
            ->add('game',   'choice', array(
				'choices' => array(
					'none' => 'none',
					'MasterQuizz'=>'MasterQuizz',
					'Quizz Média'=>'Quizz Média',
					'Autre'=>'Autre',
				),
				'required'    => true,
				'empty_data'  => 'none'
			))
            ->add('dom1',   'choice', array(
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
						'FfQuizz'=>'Faune et Flore',
						'ArQuizz'=>'Quizz Art',
						'McQuizz'=>'Musique classique',
						'LxQuizz'=>'Lieux du monde'
						),
					'Quizz en Folie'=>array(
						'TvQuizz'=>'TvQuizz',
						'EyesQuizz'=>'Regard de star',
						'SexyQuizz'=>'SexyQuizz'
					),
				),
				'required'    => true,
				'empty_data'  => 'none'
			))
            ->add('theme', 'entity', array(
					'class' => 'MDQQuestionBundle:Theme',
					'property' =>'nom',					
					'group_by'=>'dom1',
					'required'=>true,
					'empty_data'  => 'none'
			))
            ->add('crit', 'choice', array(
				'choices' => array(
					'id' => 'id',
					'dom1'=> 'domaine',
					'theme' => 'thème',
					'type' => 'type',
					'diff' => 'difficulté',
					'nbJoue' => 'nb de fois joué',
					'prctBrep' => '% de bonnes réponses',
					'type' => 'type de question'			
				),
				'required'    => true,
				'empty_data'  => 'id'
			))
            ->add('sens', 'choice', array(
				'choices' => array(
					'ASC' => 'croissant',
					'DESC' => 'décroissant'										
				),
				'required'    => true,
				'empty_data'  => 'ASC'
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
				'empty_data'  => '0'
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
            'data_class' => 'MDQ\QuestionBundle\Entity\CritEditQ'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mdq_questionbundle_criteditq';
    }
}
