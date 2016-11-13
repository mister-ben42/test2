<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\QuestionBundle\Entity\Question;
use MDQ\QuestionBundle\Entity\CritEditQ;
use MDQ\QuestionBundle\Entity\CritEditQaVal;
use MDQ\QuestionBundle\Form\CritEditQType;
use MDQ\QuestionBundle\Form\CritEditQaValType;
use MDQ\QuestionBundle\Form\QuestionEditType;
use Symfony\Component\HttpFoundation\JsonResponse; // pour les requête ajax

class GestionQuestionController extends Controller
{


	public function voirQAction($choice, $page, $error, $valid, $diff, $game, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin)
	{
		$em=$this->getDoctrine()->getManager();
		
		$tabdom2 = $em	 ->getRepository('MDQQuestionBundle:Question')
						 ->recupDom2ouDom3('dom2');
		$tabdom3 = $em	 ->getRepository('MDQQuestionBundle:Question')
						 ->recupDom2ouDom3('dom3');
		$tabtheme=$em->getRepository('MDQQuestionBundle:Theme')
					->findAll();
		$tabmedia=['texte','image','citation','audio','citationlitt','suitelog'];
		if($choice=="list")
		{
			
			$questions = $em ->getRepository('MDQQuestionBundle:Question')
						 ->getQuestions($error, $valid, $diff, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin)
						 ;
			return $this->render('MDQAdminBundle:Admin:voirQ.html.twig', array(
			  'questions'   => $questions,
			  'nbquestions' => count($questions),
			  'valid' =>$valid,
			  'error' => $error,
			  'diff' =>$diff,
			  'dom1' => $dom1,
			  'theme' => $theme,
			  'crit' => $crit,
			  'sens' => $sens,
			  'nbdeQ' => $nbdeQ,
			  'nbmin' => $nbmin
			));
		}
		else if($choice=="listForm")
		{
			$nbQ=$em ->getRepository('MDQQuestionBundle:Question')
						 ->getNbQuestions($error, $valid, $diff, $game, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin)
						 ;
			$nbpp=20;//nb de question par page
			if($nbQ>$nbpp)
				{$nbmin2=($nbmin+($page-1)*$nbpp);}
			else{$nbmin2=$nbmin;}
			$nbdeQ2=$nbpp;
			$questions = $em ->getRepository('MDQQuestionBundle:Question')
						 ->getQuestions($error, $valid, $diff, $game, $dom1, $theme, $crit, $sens, $nbdeQ2, $nbmin2)
						 ;
			$nbpage=ceil($nbQ/$nbpp);
			return $this->render('MDQAdminBundle:Admin:listFormQ.html.twig', array(
			  'questions'   => $questions,
			  'nbquestions' => $nbQ,
			  'nbpage'=>$nbpage,
			  'nbpp'=>$nbpp,
			  'page'=>$page,
			  'tabdom2' => $tabdom2,
			  'tabdom3' => $tabdom3,
			  'tabtheme'=>$tabtheme,
			  'tabmedia'=>$tabmedia,
			  'choice'=>$choice,
			  'valid' =>$valid,
			  'error' => $error,
			  'diff' =>$diff,
			  'game' => $game,
			  'dom1C' => $dom1,
			  'theme' => $theme,
			  'crit' => $crit,
			  'sens' => $sens,
			  'nbdeQ' => $nbdeQ,
			  'nbmin' => $nbmin
			 ));
		}
		else{return $this->redirect($this->generateUrl('mdqadmin_accueilAdmin'));}
	}
	public function critvoirQAction($choice)
	{
		/*	if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
		// Sinon on déclenche une exception " Accès interdit "
		// throw new AccessDeniedHttpException('Accès limité aux auteurs');
			return $this->redirect($this->generateUrl('mdqquestion_accueil'));
		}
		*/	
		$crits = new CritEditQ;
		$form = $this->createForm(new CritEditQType(), $crits);
		// On récupère la requête
		$request = $this->getRequest();
		// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') {
		  // On fait le lien Requête <-> Formulaire
		  $form->bind($request);

		  // On vérifie que les valeurs entrées sont correctes
		  if ($form->isValid()) {
			
				return $this->redirect($this->generateUrl('mdqadmin_voirQ', array(
				'choice'=>$choice,
				'error'=> $crits->getError(),
				'valid'=> $crits->getValid(),
				'diff'=> $crits->getDiff(),
				'game' => $crits->getGame(),
				'dom1'=> $crits->getDom1(),
				'theme'=> $crits->getTheme()->getNom(),
				'crit'=> $crits->getCrit(),
				'sens'   => $crits->getSens(),
				'nbdeQ'   => $crits->getNbdeQ(),
				'nbmin'   => $crits->getNbmin()				
				)));
			
			
		  }
		}

		// à ce stade :
		// - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
		// - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

		return $this->render('MDQAdminBundle:Admin:critvoirQ.html.twig', array(
		  'form' => $form->createView(),
		));
	}
	public function modifQAction(Question $question, $choice, $error, $valid, $diff, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin)
	{
		$form = $this->createForm(new QuestionEditType(), $question);
		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
		  $form->bind($request);

		  if ($form->isValid()) {
			// On enregistre l'article
			$em = $this->getDoctrine()->getManager();
			$em->persist($question);
			$em->flush();
		   
			return $this->redirect($this->generateUrl('mdqadmin_voirQ', array(
			'choice'=>$choice,
			'error'=> $error,
			'valid'=> $valid,
			'diff'=> $diff,
			'dom1'=> $dom1,
			'theme'=> $theme,
			'crit'=> $crit,
			'sens'   => $sens,
			'nbdeQ'   => $nbdeQ,
			'nbmin'   => $nbmin
			)));
		}}

		return $this->render('MDQAdminBundle:Admin:editQ.html.twig', array(
		  'form'    => $form->createView(),
		  'question' => $question,
		));
	}
	public function modifQajaxAction()
	{
		$request = $this->getRequest();	 
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{
			$valid = $request->request->get('valid');
			$idQ = $request->request->get('idQ');
			$intitule = $request->request->get('intitule');
			$brep = $request->request->get('brep');
			$mrep1 = $request->request->get('mrep1');
			$mrep2 = $request->request->get('mrep2');
			$mrep3 = $request->request->get('mrep3');
			$com = $request->request->get('com');
			$dom1 = $request->request->get('dom1');
			$dom2 = $request->request->get('dom2');
			$dom3 = $request->request->get('dom3');
			$theme = $request->request->get('theme');
			$diff = $request->request->get('diff');
			$type = $request->request->get('type');
			$delai = $request->request->get('delai');
			if($idQ!==null && $valid!==null)
			{
				$em = $this->getDoctrine()->getManager();
				$question=$em->getRepository('MDQQuestionBundle:Question')
							->findOneById($idQ);				
				$question->setValid($valid);
				$em->persist($question);
				$em->flush();
			}
			else if($idQ!==null && $intitule!==null && $brep!==null)
			{
				$em = $this->getDoctrine()->getManager();
				$question=$em->getRepository('MDQQuestionBundle:Question')
							->findOneById($idQ);				
				$question->setIntitule($intitule);
				$question->setBrep($brep);
				$question->setMrep1($mrep1);
				$question->setMrep2($mrep2);
				$question->setMrep3($mrep3);
				$question->setCommentaire($com);
				$question->setDom1($dom1);
				$question->setDom2($dom2);
				$question->setDom3($dom3);
				$question->setTheme($theme);
				$question->setDiff($diff);
				$question->setType($type);
				$question->setDelai($delai);
				$em->persist($question);
				$em->flush();
			}
			return new JsonResponse($idQ);
		}
		$data='error';
		return $data;  
	}
	public function critvoirQaValAction()
	{
		$crits = new CritEditQaVal;
		$form = $this->createForm(new CritEditQaValType(), $crits);		
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST') {
		  $form->bind($request);
		  if ($form->isValid()) {
				return $this->redirect($this->generateUrl('mdqadmin_voirQaVal', array(
				'repAdmin'=> $crits->getRepAdmin(),
				'diff'=> $crits->getDiff(),
				'dom1'=> $crits->getDom1(),
				'crit'=> $crits->getCrit(),
				'sens'   => $crits->getSens(),
				'nbdeQ'   => $crits->getNbdeQ(),
				'nbmin'   => $crits->getNbmin()
				)));						
		  }
		}
		return $this->render('MDQAdminBundle:Admin:critvoirQ.html.twig', array(
		  'form' => $form->createView(),
		));
	}
	public function voirQaValAction($page, $repAdmin, $diff, $dom1, $crit, $sens, $nbdeQ, $nbmin)
	{
		$em=$this->getDoctrine()->getManager();		
		$tabdom2 = $em	 ->getRepository('MDQQuestionBundle:Question')
						 ->recupDom2ouDom3('dom2');
		$tabdom3 = $em	 ->getRepository('MDQQuestionBundle:Question')
						 ->recupDom2ouDom3('dom3');
		$tabtheme=$em->getRepository('MDQQuestionBundle:Theme')
					->findAll();
		$tabmedia=['texte','image','citation','audio','citationlitt','suitelog'];
		$tabrepAdmin=array(
				array('value'=>0,'name'=>'Pas étudiée'),
				array('value'=>100,'name'=>'Validée !'),
				array('value'=>200,'name'=>'Dans Bddqcm, mais en attente de Validation'),
				array('value'=>1,'name'=>'Refus'),
				array('value'=>2,'name'=>'Refus : question similaire déjà présente dans la bdd'),
				array('value'=>3,'name'=>'Refus : fautes d\'orthographe ou de syntaxe'),
				array('value'=>4,'name'=>'Refus : ne correspond pas aux critères définis'),
				array('value'=>5,'name'=>'Refus : question incomplète ou pas assez développée'),
				array('value'=>6,'name'=>'Refus : question jugée inintéressante ou trop simpliste'),
				array('value'=>7,'name'=>'Refus : réponse fausse ou énoncé ambigüe'),
				array('value'=>8,'name'=>'Refus : theme ne correspondant pas aux attentes des admins'),
				array('value'=>10,'name'=>'Retour : corriger les fautes d\'orthographe et de syntaxe'),
				array('value'=>11,'name'=>'Retour : revoir la formulation'),
				array('value'=>12,'name'=>'Retour : développer le commentaire'),
				array('value'=>13,'name'=>'Retour : choisir des propositons de réponse plus pertinentes'),
			
			);
		$nbQ=$em ->getRepository('MDQQuestionBundle:QaValider')
					->getNbQuestions($repAdmin, $diff, $dom1, $crit, $sens, $nbdeQ, $nbmin)
						 ;
		$nbpp=20;//nb de question par page
		if($nbQ>$nbpp)
			{$nbmin2=($nbmin+($page-1)*$nbpp);}
		else{$nbmin2=$nbmin;}
		//$nbmin2=$nbmin;// A SUPPRIMER ENSUITE
		$nbdeQ2=$nbpp;
		$questions = $em ->getRepository('MDQQuestionBundle:QaValider')
						 ->getQuestions($repAdmin, $diff, $dom1, $crit, $sens, $nbdeQ2, $nbmin2)
						 ;
		$nbpage=ceil($nbQ/$nbpp);
		return $this->render('MDQAdminBundle:Admin:listFormQ.html.twig', array(
			  'questions'   => $questions,
			  'nbquestions' => $nbQ,
			  'nbpage'=>$nbpage,
			  'nbpp'=>$nbpp,
			  'page'=>$page,
			  'tabdom2' => $tabdom2,
			  'tabdom3' => $tabdom3,
			  'tabtheme'=>$tabtheme,
			  'tabmedia'=>$tabmedia,
			  'tabrepAdmin'=>$tabrepAdmin,
			  'diff' =>$diff,
			  'dom1C' => $dom1,
			  'repAdmin'=>$repAdmin,
			  'crit'=>$crit,
			  'sens'=>$sens,
			  'nbdeQ'=>$nbdeQ,
			  'nbmin'=>$nbmin,
			 ));		
	}
	public function retourQaValajaxAction()
	{// Qd la Qaval n'est pas ajoutée à la bdd.
		$request = $this->getRequest();	 
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{
			$idQ = $request->request->get('idQ');
			$repAdmin = $request->request->get('repAdmin');
			if($idQ!==null && $repAdmin!==null)
			{
				$em = $this->getDoctrine()->getManager();
				$question=$em->getRepository('MDQQuestionBundle:QaValider')
							->findOneById($idQ);
				$question->setRepAdmin($repAdmin);
				$question->setRetournee(0);
				$em->persist($question);
				$em->flush();
			}
			return new JsonResponse($data);
		}
		$data='error';
		return $data;  
	}
	public function insertQaValajaxAction()
	{// Qd Qaval est insérée dans la bdd
		$request = $this->getRequest();	 
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{			
				$repAdmin = $request->request->get('repAdmin');
				$idQ = $request->request->get('idQ');
				$intitule = $request->request->get('intitule');
				$brep = $request->request->get('brep');
				$mrep1 = $request->request->get('mrep1');
				$mrep2 = $request->request->get('mrep2');
				$mrep3 = $request->request->get('mrep3');
				$com = $request->request->get('com');
				$dom1 = $request->request->get('dom1');
				$dom2 = $request->request->get('dom2');
				$dom3 = $request->request->get('dom3');
				$theme = $request->request->get('theme');
				$diff = $request->request->get('diff');
				$type = $request->request->get('type');
				$delai = $request->request->get('delai');
				$doublon = $request->request->get('doublon');	
			if($idQ!==null && $intitule!==null && $brep!==null)
			{
				$em = $this->getDoctrine()->getManager();
				// avant je vais tester si cette question existe déjà dans la Bdd
				$doublons=$em->getRepository('MDQQuestionBundle:Question')
							->testDoublon('bddqcm', 'intitule', $intitule);
				if($doublons!=[] && $doublon==0){
					return new JsonResponse($doublons);
					}
				if($repAdmin==100){$valid=1;}
				if($repAdmin==200){$valid=3;}
				$qaval=$em->getRepository('MDQQuestionBundle:QaValider')
							->findOneById($idQ);
				$datecreate=$qaval->getDatecreate();
				$auteur=$qaval->getAuteur();
				$question= new Question();
				$question->setIntitule($intitule);
				$question->setBrep($brep);
				$question->setMrep1($mrep1);
				$question->setMrep2($mrep2);
				$question->setMrep3($mrep3);
				$question->setCommentaire($com);
				$question->setDom1($dom1);
				$question->setDom2($dom2);
				$question->setDom3($dom3);
				$question->setTheme($theme);
				$question->setDiff($diff);
				$question->setType($type);
				$question->setDelai($delai);
				$question->setValid($valid);
				$question->setDatecreate($datecreate);
				$question->setAuteur($auteur);
				$em->persist($question);
				$qaval->setRepAdmin(100);
				$qaval->setRetournee(0);
				$auteur=$qaval->getAuteur();
				$auteur->setNbQValid($auteur->getNbQvalid()+1);
				//Ajouter une pertir Qnf à l'auteur concerné.
				$auteur->setNbJQnF($auteur->getNbJQnF()+1);
				$em->persist($auteur);
				$em->persist($qaval);
				$em->flush();
			$data='ok';
			return new JsonResponse($data);
			}
		}
		$data='error';
		return new JsonResponse($data);  
	}


	public function resetErrorAction()
	{
		$request = $this->getRequest();	 
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{
			$idQ = $request->request->get('idQ');
			if($idQ!==null)
			{
				$em = $this->getDoctrine()->getManager();
				$question=$em->getRepository('MDQQuestionBundle:Question')
							->findOneById($idQ);
				$users_error=$question->getUsers_error();
				foreach ($users_error as $scuser)
				{
					$question->removeUser_error($scuser);					
					$scuser->setNbErrorSignal($scuser->getNbErrorSignal()-1);
				}
				$question->setError(0);
				$question->setTaberror([0,0,0]);
				$em->persist($question);
				$em->flush();
			}
			return new JsonResponse($idQ);
		}
		$data='none';
		return $data;  
	}
 	public function testQdoubleAction()
	{
		$repository= $this->getDoctrine()->getManager()->getRepository('MDQQuestionBundle:Question');
		$questions=$repository->findAll();
		$tabIdDouble=[];
		$tabIdInt=[];
		foreach ($questions as $question)
		{
			if (in_array($question->getIntitule(), $tabIdInt))
			{				
				$idDouble = array_search($question->getIntitule(), $tabIdInt);
				$question2=$repository->recupDataQ($idDouble);
				if($question2['brep']==$question->getBrep())
				{
					$tabdoublon[0]=$question->getId();
					$tabdoublon[1]=$idDouble;
					array_push($tabIdDouble,$tabdoublon);
				}
				else
				{
				$tabIdInt[$question->getId()]=$question->getIntitule();
				}
			}
			else
			{
			$tabIdInt[$question->getId()]=$question->getIntitule();
			}
		}
		return $this->render('MDQAdminBundle:Admin:testQdouble.html.twig', array(
			'tabIdDouble' => $tabIdDouble,
		));
	}

}
    

?>
