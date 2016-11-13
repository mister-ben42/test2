<?php
// src/MDQ/QuestionBundle/Form/QuestionEditType.php

namespace MDQ\QuestionBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class QuestionEditType extends QuestionType // Ici, on hérite de QuestionType - on hérite du contenu de'ArticleType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    // On fait appel à la méthode buildForm du parent, qui va ajouter tous les champs à $builder
    parent::buildForm($builder, $options);

    $builder->remove('auteur','string')
			;
  }

  // On modifie cette méthode, car les deux formulaires doivent avoir un nom différent
  public function getName()
  {
    return 'mdq_questionbundle_questionedittype';
  }
}
