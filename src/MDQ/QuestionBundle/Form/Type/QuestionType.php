<?php


namespace MDQ\QuestionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuestionType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('intitule',      TextareaType::class)
      ->add('brep',     TextareaType::class)
	  ->add('mrep1',     TextareaType::class)
	  ->add('mrep2',     TextareaType::class)
	  ->add('mrep3',     TextareaType::class)
      ->add('commentaire',   TextareaType::class)
	  ->add('diff', ChoiceType::class, array(
				'choices' => array(
					'Très facile'=>'1',
					'Facile'=>'2',
					'Moyen'=>'3',
					'Difficile'=>'4',
					'Très difficile'=>'5',										
				),
				'choices_as_values' => true,
				'required'    => true,
				'placeholder' => 'Difficulté',
				'empty_data'  => null
			))
	  
	  ->add('dom1',   ChoiceType::class, array(
				'choices' => array(
					'Histoire' => 'Histoire',
					'Géographie' => 'Géographie',
					'Sciences et nature' => 'Sciences et nature',
					'Arts et Littérature' => 'Arts et Littérature',
					'Sports et loisirs' => 'Sports et loisirs',
					'Divers' => 'Divers'					
				),
				'choices_as_values' => true,
				'required'    => true,
				'placeholder' => 'Domaine',
				'empty_data'  => null


			));
      
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'MDQ\QuestionBundle\Entity\QaValider'
    ));
  }


}
