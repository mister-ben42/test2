<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\QuestionBundle\Entity\Question;
use MDQ\QuestionBundle\Entity\CritEditQ;
use MDQ\QuestionBundle\Entity\CritEditQaVal;
use MDQ\QuestionBundle\Form\Type\CritEditQType;
use MDQ\QuestionBundle\Form\Type\CritEditQaValType;
use MDQ\QuestionBundle\Form\Type\QuestionEditType;
use Symfony\Component\HttpFoundation\JsonResponse; // pour les requête ajax

class GestionQuestionController extends Controller
{


	public function voirQAction($page, $error, $valid, $diff, $game, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin)
	{
		$em=$this->getDoctrine()->getManager();
			
			$req = $em ->getRepository('MDQQuestionBundle:Question')
						 ->getQuestions($error, $valid, $diff, $game, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin);
			$questions=$req[1];
			$data=array(
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
			  );
			return $this->render('MDQAdminBundle:Admin:voirQ.html.twig', array(
			  'questions'   => $questions,
			  'data' =>$data,
			  'adminTwig'=>$this->container->get('mdq_admin.adminTwig'),			  
			));
	}

	public function voirListFormQAction($page, $error, $valid, $diff, $game, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin)
	{
		$em=$this->getDoctrine()->getManager();
		
		$tabdom2 = $em	 ->getRepository('MDQQuestionBundle:Question')->recupDom2ouDom3('dom2');
		$tabdom3 = $em	 ->getRepository('MDQQuestionBundle:Question')->recupDom2ouDom3('dom3');
		$tabtheme=$em->getRepository('MDQQuestionBundle:Theme')->findAll();
		$tabmedia=['texte','image','citation','audio','citationlitt','suitelog'];


			$nbpp=20;//nb de question par page
			$req = $em ->getRepository('MDQQuestionBundle:Question')
						 ->getQuestions($error, $valid, $diff, $game, $dom1, $theme, $crit, $sens, $nbpp, $nbmin, $page);
			$nbpage=ceil($req[0]/$nbpp);
			$data=array(
			  'nbquestions' => $req[0],
			  'nbpage'=>$nbpage,
			  'nbpp'=>$nbpp,
			  'page'=>$page,
			  'tabdom2' => $tabdom2,
			  'tabdom3' => $tabdom3,
			  'tabtheme'=>$tabtheme,
			  'tabmedia'=>$tabmedia,
			  'valid' =>$valid,
			  'error' => $error,
			  'diff' =>$diff,
			  'game' => $game,
			  'dom1C' => $dom1,
			  'theme' => $theme,
			  'crit' => $crit,
			  'sens' => $sens,
			  'nbdeQ' => $nbdeQ,
			  'nbmin' => $nbmin,
			 );
			
			return $this->render('MDQAdminBundle:Admin:ListForm\listFormQbdd.html.twig', array(
			  'questions'   => $req[1],			  
			  'adminTwig'=>$this->container->get('mdq_admin.adminTwig'),
			  'data'=>$data,
			 ));

	}
	public function critvoirQAction($choice)
	{

		$crits = new CritEditQ;
		$form = $this->createForm(new CritEditQType(), $crits);
		$request = $this->getRequest();
		if($choice=="listForm"){$url='mdqadmin_voirListFormQ';}
		else{$url='mdqadmin_voirQ';}
		if ($request->getMethod() == 'POST') {
		  $form->bind($request);
		  if ($form->isValid()) {
			
				return $this->redirect($this->generateUrl($url, array(
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
		      $idQ=$request->request->get('idQ');
		      $em = $this->getDoctrine()->getManager();
			if($idQ!==null && $request->request->get('valid')!==null)
			{				
				$question=$em->getRepository('MDQQuestionBundle:Question')->findOneById($idQ);				
				$question->setValid($request->request->get('valid'));
			}
			else if($idQ!==null && $request->request->get('intitule')!==null && $request->request->get('brep')!==null)
			{
				$question=$em->getRepository('MDQQuestionBundle:Question')->findOneById($idQ);
				$question=$this->container->get('mdq_admin.gestionQ')->modifQ($question, $request);				
			}
			$em->persist($question);
				$em->flush();
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
						 ;
		$nbpp=20;//nb de question par page
		
		$req = $em ->getRepository('MDQQuestionBundle:QaValider')
						 ->getQuestions($repAdmin, $diff, $dom1, $crit, $sens, $nbpp, $nbmin, $page);
		$nbpage=ceil($req[0]/$nbpp);
		$data=array(
			  'nbquestions' => $req[0],
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
			  'nbmin'=>$nbmin
			  );
		
		return $this->render('MDQAdminBundle:Admin:ListForm\listFormQaval.html.twig', array(
			  'questions'   => $req[1],
			  'adminTwig'=>$this->container->get('mdq_admin.adminTwig'),
			  'data'=>$data,
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
		if($request->isXmlHttpRequest())
		{			

			if($request->request->get('idQ')!==null && $request->request->get('intitule')!==null && $request->request->get('brep')!==null)
			{
				$em = $this->getDoctrine()->getManager();
				// avant je vais tester si cette question existe déjà dans la Bdd
				$doublons=$em->getRepository('MDQQuestionBundle:Question')->testDoublon('bddqcm', 'intitule', $request->request->get('intitule'));
				if($doublons!=[] && $doublon==0){return new JsonResponse($doublons);}
				
				$qaval=$em->getRepository('MDQQuestionBundle:QaValider')->findOneById($request->request->get('idQ'));
				$datecreate=$qaval->getDatecreate();
				$question= new Question();
				$question=$this->container->get('mdq_admin.gestionQ')->inserQaval($question, $request, $datecreate, $qaval->getAuteur());
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



}
    

?>
