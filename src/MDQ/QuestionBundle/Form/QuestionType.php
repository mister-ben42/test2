<?php


namespace MDQ\QuestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('intitule',      'textarea')
      ->add('brep',     'text')
	  ->add('mrep1',     'text')
	  ->add('mrep2',     'text')
	  ->add('mrep3',     'text')
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
	//->add('theme',   'text')
		->add('theme',   'choice', array(
				'choices' => array(
'Préhistoire et Antiquité'=>'Préhistoire et Antiquité', 'Histoire : Divers'=>'Histoire : Divers', 'Histoire du Monde'=>'Histoire du Monde', 'Histoire de France'=>'Histoire de France', 'Le XXeme siècle dans le monde'=>'Le XXeme siècle dans le monde', 'Géographie physique'=>'Géographie physique', 'Géographie de la France'=>'Géographie de la France', 'Géographie du monde'=>'Géographie du monde', 'Hymnes, capitales et drapeaux'=>'Hymnes, capitales et drapeaux', 'Lieux et monuments célèbres'=>'Lieux et monuments célèbres', 'Sciences et nature : divers'=>'Sciences et nature : divers', 'Médecine'=>'Médecine', 'Les animaux'=>'Les animaux', 'Corps humain'=>'Corps humain', 'Astronomie'=>'Astronomie', 'Monde végétal'=>'Monde végétal', 'Musique'=>'Musique', 'Arts et Littérature : Généralités'=>'Arts et Littérature : Généralités', 'Cinéma'=>'Cinéma', 'Littérature'=>'Littérature', 'Peinture et sculpture'=>'Peinture et sculpture', 'Bande dessinée'=>'Bande dessinée', 'Architecture et monuments'=>'Architecture et monuments', 'Football'=>'Football', 'Sports et loisirs : Divers'=>'Sports et loisirs : Divers', 'Jeux et loisirs'=>'Jeux et loisirs', 'Sports collectifs'=>'Sports collectifs', 'Jeux Olympiques'=>'Jeux Olympiques', 'Cyclisme'=>'Cyclisme', 'Tennis'=>'Tennis', 'Langue française'=>'Langue française', 'Suites logiques'=>'Suites logiques', 'Sciences et techniques'=>'Sciences et techniques', 'Droit et politique'=>'Droit et politique', 'Société'=>'Société', 'Mode de vie et tradition'=>'Mode de vie et tradition', 'Divers : Généralités'=>'Divers : Généralités', 'Télévision'=>'Télévision', 
				),
				'required'    => true,
				'empty_value' => 'Theme',
				'empty_data'  => null
			))
	  ->add('dom2',   'text')
	  ->add('dom3',   'text')
      ->add('auteur',    'text')
	  ->add('type', 'choice', array(
				'choices' => array(
					'texte' => 'Texte',
					'image' => 'Image',
					'citation' => 'Citation',
					'citationlitt' => 'Citation littéraire',
					'musique' => 'Musique' 
				),
				'required'    => false,
				'empty_value' => 'Choix du type',
				'empty_data'  => null
			))
	  ->add('media', 'text', array(
				'required' => false
			))
      
      /*
       * Rappel :
       ** - 1er argument : nom du champ, ici « categories » car c'est le nom de l'attribut
       ** - 2e argument : type du champ, ici « collection » qui est une liste de quelque chose
       ** - 3e argument : tableau d'options du champ
       */
      /*->add('categories',  'collection', array('type'         => new CategorieType(),
                                               'allow_add'    => true,
                                               'allow_delete' => true))*/
      /*->add('categories', 'entity', array(
        'class'    => 'SdzBlogBundle:Categorie',
        'property' => 'nom',
        'multiple' => true,
        'expanded' => false
      ))*/
    ;
	
	/* *** Je ne sais plus vraiment à quoi set cette partie.
    // On récupère la factory (usine)
    $factory = $builder->getFormFactory();

    // On ajoute une fonction qui va écouter l'évènement PRE_SET_DATA
    $builder->addEventListener(
      FormEvents::PRE_SET_DATA, // Ici, on définit l'évènement qui nous intéresse
      function(FormEvent $event) use ($factory) { // Ici, on définit une fonction qui sera exécutée lors de l'évènement
        $article = $event->getData();
        // Cette condition est importante, on en reparle plus loin
        if (null === $article) {
          return; // On sort de la fonction lorsque $article vaut null
        }
        // Si l'article n'est pas encore publié, on ajoute le champ publication
        if (false === $article->getPublication()) {
          $event->getForm()->add(
            $factory->createNamed('publication', 'checkbox', null, array('required' => false))
          );
        } else { // Sinon, on le supprime
          $event->getForm()->remove('publication');
        }
      }
    );*/
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'MDQ\QuestionBundle\Entity\Question'
    ));
  }

  public function getName()
  {
    return 'MDQ_questionbundle_questiontype';
  }
}
