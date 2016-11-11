<?php

namespace MDQ\QuestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QaValiderType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
              ->add('intitule',      'textarea')
      ->add('brep',     'textarea')
	  ->add('mrep1',     'textarea')
	  ->add('mrep2',     'textarea')
	  ->add('mrep3',     'textarea')
      ->add('commentaire',   'textarea')
	  ->add('diff', 'choice', array(
				'choices' => array(
					'1' => 'Très facile',
					'2' => 'Facile',
					'3' => 'Moyen',
					'4' => 'Difficile',
					'5' => 'Très difficile',										
				),
				'required'    => true,
				'empty_value' => 'Difficulté',
				'empty_data'  => null
			))
	  
	  ->add('dom1',   'choice', array(
				'choices' => array(
					'Histoire' => 'Histoire',
					'Géographie' => 'Géographie',
					'Sciences et nature' => 'Sciences et nature',
					'Arts et Littérature' => 'Arts et Littérature',
					'Sports et loisirs' => 'Sports et loisirs',
					'Divers' => 'Divers'					
				),
				'required'    => true,
				'empty_value' => 'Domaine',
				'empty_data'  => null
			))
        /*    ->add('type')
            ->add('datecreate')
            ->add('valid')
            ->add('auteur')*/
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MDQ\QuestionBundle\Entity\QaValider'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mdq_questionbundle_qavalider';
    }
}
