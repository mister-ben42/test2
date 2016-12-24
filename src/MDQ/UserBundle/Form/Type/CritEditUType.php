<?php

namespace MDQ\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CritEditUType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	    ->add('type',   ChoiceType::class, array(
				'choices' => array(
					'Humains'=>'0',
					'Tous' =>'2',
					'Bots' =>'1',
				),
				'choices_as_values' => true,
				'required'    => true,
				'empty_data'  => '0',
				'label'=>'Types',
			))
	    ->add('compte',   ChoiceType::class, array(
				'choices' => array(
					'Comptes actifs' =>'0',
					'Comptes supprimés' =>'1',
					'Tous'=>'3'
				),
				'choices_as_values' => true,
				'required'    => true,
				'empty_data'  => '0',
				'label'=>'Etat du compte',
			))
	    ->add('sexe',   ChoiceType::class, array(
				'choices' => array(
					'Tous' =>'2',
					'Hommes' =>'0',
					'Femmes' =>'1',
				),
				'choices_as_values' => true,
				'required'    => true,
				'empty_data'  => '2',
			))
	     ->add('departement',   ChoiceType::class, array(
				'choices' => array(
					'Tous' =>'0',
				),
				'choices_as_values' => true,
				'required'    => true,
				'empty_data'  => '0',
			))

	    ->add('age',   ChoiceType::class, array(
				'choices' => array(
					'Tous' =>'0'
				),
				'choices_as_values' => true,
				'required'    => true,
				'empty_data'  => '0',
			))
	    ->add('last_login',   ChoiceType::class, array(
				'choices' => array(
					'Tous'=>'0'
				),
				'choices_as_values' => true,
				'required'    => true,
				'empty_data'  => '0',
			))
	     ->add('role',   ChoiceType::class, array(
				'choices' => array(
					'Tous' =>'0',
				),
				'choices_as_values' => true,
				'required'    => true,
				'empty_data'  => '0',
			))
	    ->add('nbP',   ChoiceType::class, array(
				'choices' => array(
					'Tous'=>'none',
					'0'=>'=0',
					'<10'=>'<10',
					'<50'=>'<50',
					'>50'=>'>50',
					'<100'=>'<100',
					'>100'=>'>100',
					'<1 000'=>'<1000',
					'>1 000'=>'>1000',
					'<10 000'=>'<10000',
				),
				'choices_as_values' => true,
				'required'    => true,
				'empty_data'  => 'none',
				'label'=>'Nombres de parties',
			))
            ->add('triUser', ChoiceType::class, array(
				'choices' => array(
					'none'=> 'id' ,
					 'nom'=> 'username',
					'sexe' => 'sexe',
					'département' => 'departement',
					'date inscription'=> 'datecreate' ,
					'date de naissance'=> 'datenaissance' ,
					 'dernière connexion'=> 'last_login',
				),
				'choices_as_values' => true,
				'required'    => true,
				'empty_data'  => 'id',
				'label'=>'Critères de tri',
			))
	      ->add('triStats', ChoiceType::class, array(
				'choices' => array(
					'none'=>'none',
					 'Nombres de parties jouées'=> 'nbPtot',
					'Nombre total de médailles'=>'totMed',
					'Nombre de médailles d\'or au MasterQuizz'=>'mq1',
					 '% de bonnes réponses au MasterQuizz'=>'prctBrtotMq',
					 'Meilleur score au MasterQuizz'=> 'scMaxMq',
					 'Meilleur score au KingMaster'=>'highScKM',
				),
				'choices_as_values' => true,
				'required'    => true,
				'empty_data'  => 'none',
				'label'=>'Tri Stats',
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
		->add('nbdeU', ChoiceType::class, array(
				'choices' => array(
					'tous' => '0',
					'10' => '10',
					'50' => '50',
					'100' => '100',
					'200' => '200',
					'500' => '500',
					'1000' => '1000',										
				),
				'choices_as_values' => true,
				'required'    => true,				
				'data'  => '0',
				'label'=>'Nombre d users',
			))
            ->add('nbmin', TextType::class, array(
				'data' => '1',
				'label'=>'users de départ',
			));
                
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MDQ\UserBundle\Entity\CritEditU'
        ));
    }


}
