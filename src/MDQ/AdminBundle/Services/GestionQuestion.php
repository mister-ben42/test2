<?php

namespace MDQ\AdminBundle\Services;

use MDQ\QuestionBundle\Entity\Question;
use Symfony\Component\HttpFoundation\Request;


class GestionQuestion
{    
	public function modifQ(Question $question, Request $request)
	{
				$question->setIntitule($request->request->get('intitule'));
				$question->setBrep($request->request->get('brep'));
				$question->setMrep1($request->request->get('mrep1'));
				$question->setMrep2($request->request->get('mrep2'));
				$question->setMrep3($request->request->get('mrep3'));
				$question->setCommentaire($request->request->get('com'));
				$question->setDom1($request->request->get('dom1'));
				$question->setDom2($request->request->get('dom2'));
				$question->setDom3($request->request->get('dom3'));
				$question->setTheme($request->request->get('theme'));
				$question->setDiff($request->request->get('diff'));
				$question->setType($request->request->get('type'));
				$question->setDelai($request->request->get('delai'));
		return $question;		
	}
	public function insetQaval(Question $question, Request $request, $datecreate, $auteur)
	{
				$question->setIntitule($request->request->get('intitule'));
				$question->setBrep($request->request->get('brep'));
				$question->setMrep1($request->request->get('mrep1'));
				$question->setMrep2($request->request->get('mrep2'));
				$question->setMrep3($request->request->get('mrep3'));
				$question->setCommentaire($request->request->get('com'));
				$question->setDom1($request->request->get('dom1'));
				$question->setDom2($request->request->get('dom2'));
				$question->setDom3($request->request->get('dom3'));
				$question->setTheme($request->request->get('theme'));
				$question->setDiff($request->request->get('diff'));
				$question->setType($request->request->get('type'));
				$question->setDelai($request->request->get('delai'));
				if($request->request->get('repAdmin')==100){$valid=1;}
				if($request->request->get('repAdmin')==200){$valid=3;}
				$question->setValid($valid);
				$question->setDatecreate($datecreate);
				$question->setAuteur($auteur);		
		
		return $question;
	}
}

