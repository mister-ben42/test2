<?php

namespace MDQ\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CritEditUType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	    ->add('type',   'choice', array(
				'choices' => array(
					'0'=>'Humains',
					'2' => 'Tous',
					'1'=>'Bots',
				),
				'required'    => true,
				'empty_data'  => '0',
				'label'=>'Types',
			))
	    ->add('compte',   'choice', array(
				'choices' => array(
					'0' => 'Comptes actifs',
					'1'=>'Comptes supprimés',
					'2'=>'Comptes bloqués',
					'3'=>'Tous'
				),
				'required'    => true,
				'empty_data'  => '0',
				'label'=>'Etat du compte',
			))
	    ->add('sexe',   'choice', array(
				'choices' => array(
					'2'=>'Tous',
					'0' => 'Hommes',
					'1'=>'Femmes',
				),
				'required'    => true,
				'empty_data'  => '2',
			))
	     ->add('departement',   'choice', array(
				'choices' => array(
					'0'=>'Tous',
				),
				'required'    => true,
				'empty_data'  => '0',
			))

	    ->add('age',   'choice', array(
				'choices' => array(
					'0'=>'Tous'
				),
				'required'    => true,
				'empty_data'  => '0',
			))
	    ->add('last_login',   'choice', array(
				'choices' => array(
					'0'=>'Tous'
				),
				'required'    => true,
				'empty_data'  => '0',
			))
	     ->add('role',   'choice', array(
				'choices' => array(
					'0'=>'Tous',
				),
				'required'    => true,
				'empty_data'  => '0',
			))
	    ->add('nbP',   'choice', array(
				'choices' => array(
					'none'=>'Tous',
					'=0'=>'0',
					'<10'=>'<10',
					'<50'=>'<50',
					'>50'=>'>50',
					'<100'=>'<100',
					'>100'=>'>100',
					'<1000'=>'<1 000',
					'>1000'=>'>1 000',
					'<10000'=>'<10 000',
				),
				'required'    => true,
				'empty_data'  => 'none',
				'label'=>'Nombres de parties',
			))
            ->add('triUser', 'choice', array(
				'choices' => array(
					'id' => 'none',
					'username' => 'nom',
					'sexe' => 'sexe',
					'departement' => 'département',
					'datecreate' => 'date inscription',
					'datenaissance' => 'date de naissance',
					'last_login' => 'dernière connexion',
				),
				'required'    => true,
				'empty_data'  => 'id',
				'label'=>'Critères de tri',
			))
	      ->add('triStats', 'choice', array(
				'choices' => array(
					'none'=>'none',
					'nbPtot' => 'Nombres de parties jouées',
					'totMed' => 'Nombre total de médailles',
					'mq1' => 'Nombre de médailles d\'or au MasterQuizz',
					'prctBrtotMq' => '% de bonnes réponses au MasterQuizz',
					'scMaxMq' => 'Meilleur score au MasterQuizz',
					'highScKM' => 'Meilleur score au KingMaster',
				),
				'required'    => true,
				'empty_data'  => 'none',
				'label'=>'Tri Stats',
			))
		 ->add('sens', 'choice', array(
				'choices' => array(
					'ASC' => 'croissant',
					'DESC' => 'décroissant'										
				),
				'required'    => true,
				'data'  => 'ASC'
			))
		->add('nbdeU', 'choice', array(
				'choices' => array(
					'0' => 'tous',
					'10' => '10',
					'50' => '50',
					'100' => '100',
					'200' => '200',
					'500' => '500',
					'1000' => '1000',										
				),
				'required'    => true,				
				'data'  => '0',
				'label'=>'Nombre d users',
			))
            ->add('nbmin', 'text', array(
				'data' => '1',
				'label'=>'users de départ',
			));
                
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MDQ\UserBundle\Entity\CritEditU'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mdq_userbundle_criteditu';
    }
}
