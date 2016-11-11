<?php

/*
 je donne le m�me nom que le fichier FOS, dans le m�me r�pertoire, et je le fais h�riter : son contenu vindra en plus
 du ficier FOS.
 */

namespace MDQ\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
   public function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildUserForm($builder, $options);

        // add your custom field
        $builder->add('sexe', 'choice', array(
				'choices' => array(
					'0' => 'Homme',
					'1' => 'Femme',
				),
				'multiple' => false,
				'expanded' => true,				
				))
				->add('datenaissance', 'date', array(
				'years' => range(2010,1930),
				'empty_value' => array('year' => 'année', 'month' => 'mois', 'day' => 'jour')
				))
				->add('departement', 'choice', array(
					'choices' => array(
					'France métropolitaine'=>array(
		''=>'Département','Ain'=> '01- Ain','Aisne' => '02- Aisne','Allier' => '03- Allier','Alpes-de-Haute-Provence'=> '04- Alpes-de-Haute-Provence',
		'Hautes-Alpes'=> '05- Hautes-Alpes','Alpes-Maritimes'=> '06- Alpes-Maritimes','Ardèche'=> '07- Ardèche',
		'Ardennes'=> '08- Ardennes','Ariège'=> '09- Ariège','Aube'=> '10- Aube','Aude'=> '11- Aude',
		'Aveyron'=> '12- Aveyron','Bouches-du-Rhône'=> '13- Bouches-du-Rhône','Calvados'=> '14- Calvados',
		'Cantal'=> '15- Cantal','Charente'=> '16- Charente','Charente-Maritime'=> '17- Charente-Maritime',
		'Cher'=> '18- Cher','Corrèze'=> '19- Corrèze','Corse-du-Sud'=> '2A- Corse-du-Sud','Haute-Corse'=> '2B- Haute-Corse',
		'Côte-d\'Or'=> '21- Côte-d\'Or','Côtes-d\'Armor'=> '22- Côtes-d\'Armor','Creuse'=> '23- Creuse',
		'Dordogne'=> '24- Dordogne','Doubs'=> '25- Doubs','Drôme'=> '26- Drôme','Eure'=> '27- Eure',
		'Eure-et-Loir'=> '28- Eure-et-Loir','Finistère'=> '29- Finistère','Gard'=> '30- Gard','Haute-Garonne'=> '31- Haute-Garonne',
		'Gers'=> '32- Gers','Gironde'=> '33- Gironde','Hérault'=> '34- Hérault','Ille-et-Vilaine'=> '35- Ille-et-Vilaine',
		'Indre'=> '36- Indre','Indre-et-Loire'=> '37- Indre-et-Loire','Isère'=> '38- Isère','Jura'=> '39- Jura',
		'Landes'=> '40- Landes','Loir-et-Cher'=> '41- Loir-et-Cher','Loire'=> '42- Loire','Haute-Loire'=> '43- Haute-Loire',
		'Loire-Atlantique'=> '44- Loire-Atlantique','Loiret'=> '45- Loiret','Lot'=> '46- Lot','Lot-et-Garonne'=> '47- Lot-et-Garonne',
		'Lozère'=> '48- Lozère','Maine-et-Loire'=> '49- Maine-et-Loire','Manche'=> '50- Manche','Marne'=> '51- Marne',
		'Haute-Marne'=> '52- Haute-Marne','Mayenne'=> '53- Mayenne','Meurthe-et-Moselle'=> '54- Meurthe-et-Moselle',
		'Meuse'=> '55- Meuse','Morbihan'=> '56- Morbihan','Moselle'=> '57- Moselle','Nièvre'=> '58- Nièvre',
		'Nord'=> '59- Nord','Oise'=> '60- Oise','Orne'=> '61- Orne','Pas-de-Calais'=> '62- Pas-de-Calais',
		'Puy-de-Dôme'=> '63- Puy-de-Dôme','Pyrénées-Atlantiques'=> '64- Pyrénées-Atlantiques',
		'Hautes-Pyrénées'=> '65- Hautes-Pyrénées','Pyrénées-Orientales'=> '66- Pyrénées-Orientales',
		'Bas-Rhin'=> '67- Bas-Rhin','Haut-Rhin'=> '68- Haut-Rhin','Rhône'=> '69- Rhône','Haute-Saône'=> '70- Haute-Saône',
		'Saône-et-Loire'=> '71- Saône-et-Loire','Sarthe'=> '72- Sarthe','Savoie'=> '73- Savoie',
		'Haute-Savoie'=> '74- Haute-Savoie','Paris'=> '75- Paris','Seine-Maritime'=> '76- Seine-Maritime',
		'Seine-et-Marne'=> '77- Seine-et-Marne','Yvelines'=> '78- Yvelines','Deux-Sèvres'=> '79- Deux-Sèvres',
		'Somme'=> '80- Somme','Tarn'=> '81- Tarn','Tarn-et-Garonne'=> '82- Tarn-et-Garonne','Var'=> '83- Var',
		'Vaucluse'=> '84- Vaucluse','Vendée'=> '85- Vendée','Vienne'=> '86- Vienne','Haute-Vienne'=> '87- Haute-Vienne',
		'Vosges'=> '88- Vosges','Yonne'=> '89- Yonne','Territoire de Belfort'=> '90- Territoire de Belfort',
		'Essonne'=> '91- Essonne','Hauts-de-Seine'=> '92- Hauts-de-Seine','Seine-Saint-Denis'=> '93- Seine-Saint-Denis',
		'Val-de-Marne'=> '94- Val-de-Marne','Val-d\'Oise'=> '95- Val-d\'Oise',),
			'Départements d\'outre-mer'=>array(
		'Guadeloupe'=> '971- Guadeloupe','Martinique'=> '972- Martinique','Guyane'=> '973- Guyane',
		'La Réunion'=> '974- La Réunion','Mayotte'=> '976- Mayotte',),
			'Autre'=>array(
			'Autre pays'=> '1000 Autre pays',),
						),
						'multiple' => false,
						'expanded' => false,				
						))
			//	->add('devise', 'textarea', array(
			//		'required'=>false,
			//	))	
				->remove('username')	
					;
    }

    public function getName()
    {
        return 'mdq_user_profile';
    }
}