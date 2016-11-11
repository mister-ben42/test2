<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\QuestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\QuestionBundle\Entity\Question;
use MDQ\QuestionBundle\Form\QuestionType;
use MDQ\QuestionBundle\Entity\CritEditQ;
use MDQ\QuestionBundle\Form\CritEditQType;
use MDQ\QuestionBundle\Form\QuestionEditType;

class QuestionController extends Controller
{
     
   public function statQAction()
   {
	$questions = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('MDQQuestionBundle:Question')
					 ->getQuestions('0', '0', 'none', 'none', 'id', 'ASC', '0', '1');
	$tot=0;
	$hist=0;
	foreach ($questions as $question){
		$tot=$tot+1;
		if ($question->getDom1()=='Histoire')
		{
			$hist=$hist+1;
		}
	}
		
	return $this->render('MDQQuestionBundle:Question:statQ.html.twig', array(
      'questions'   => $questions,
	  'tot' => $tot,
	  'hist' => $hist,
	  'nbquestions' => count($questions)
    ));
   }
}