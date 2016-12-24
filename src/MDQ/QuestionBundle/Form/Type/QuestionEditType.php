<?php
// src/MDQ/QuestionBundle/Form/QuestionEditType.php

namespace MDQ\QuestionBundle\Form\Type;

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


}
