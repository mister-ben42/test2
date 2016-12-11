<?php


namespace MDQ\QuizzBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse; // pour les requête ajax

class QuizzController extends Controller
{
	public function preGameAction($game)
	{
		$photo="attenteMq.gif";
		if($game=="SexyQuizz"){$page="preGameSexyQ";}
		else{$page="preGame";}
		return $this->render('MDQQuizzBundle:Quizz:'.$page.'.html.twig', array(
		'game'=>$game,
		'photo'=>$photo,
		));
	}
	public function newGameAction($game)
	{
	$user = $this->container->get('security.context')->getToken()->getUser();
	$em = $this->getDoctrine()->getManager();
	$quizzServ = $this->container->get('mdq_quizz.services');	
	if($this->get('security.context')->isGranted('ROLE_ADMIN')){$admin=1;}
	else{$admin=0;}
        if(!$quizzServ->testAutoriseNewG($game, $user, $admin)) {return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		$partie=$em->getRepository('MDQQuizzBundle:PartieQuizz')->createNewP($game,$user);		
		$this->container->get('mdq_user.jeton_serv')->suppJPartie($user, $game);
		$em->persist($partie); 
		$em->flush();
		$this->getRequest()->getSession()->set('page', 'tirageQ');
		return $this->redirect($this->generateUrl('mdqquizz_jeu', array(
		'game'=>$game,
		)));
	}
	  public function jeuQuizzAction($game)
	{
		$session = $this->getRequest()->getSession();
		if($session->get('page')!='tirageQ' || $game!="MasterQuizz" && $game!="MuQuizz" && $game!="SexyQuizz" && $game!="FfQuizz" && $game!="ArQuizz" && $game!="LxQuizz"  && $game!="TvQuizz"){
			$session->set('page', 'Mquizz');
			return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}
		$session->set('page', 'Mquizz');
		$user = $this->container->get('security.context')->getToken()->getUser();
	      if ($user===null) {return $this->redirect($this->generateUrl('mdqgene_accueil'));	} 		
		$quizzServ = $this->container->get('mdq_quizz.services');
		$page=$quizzServ->selectPageJeu($game);
		$signalE=$quizzServ->testSignalE();
		return $this->render('MDQQuizzBundle:Quizz:jeuQuizz\\'.$page.'.html.twig', array(
		    'game'=>$game,
		    'signalE'=>$signalE,
		    ));			
	}
	public function editQuestionAction(){
		$request = $this->getRequest();	 	
		$quizzServ = $this->container->get('mdq_quizz.ajax');
		$user = $this->container->get('security.context')->getToken()->getUser();		
		if($quizzServ->testSession($request->getSession())==1 || $user===null){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
	  if($request->isXmlHttpRequest())  {
		$numQ = $request->request->get('numQ');	
		$em=$this->getDoctrine()->getManager();
		 if ($numQ !== null ){   
			$idQ = $em->getRepository('MDQQuizzBundle:PartieQuizz')->recupQ($numQ,$user->getId());
			$partie=$em->getRepository('MDQQuizzBundle:PartieQuizz')->recupPartie($user->getId());
			if($numQ!=$partie->getNbQjoue()+1){$data['id']="error";
							    return new JsonResponse($data);}
			$data = $em->getRepository('MDQQuestionBundle:Question')->recupDataQ($idQ);
			$datab=$quizzServ->dataEditQ($data);
			   return new JsonResponse($datab);
		 }
	  }
	  return "erreur";        
	}
	public function verifReponseAction(){
		$request = $this->getRequest();	 		
		$quizzServ = $this->container->get('mdq_quizz.ajax');
		$user = $this->container->get('security.context')->getToken()->getUser();		
		if($quizzServ->testSession($request->getSession())==1 || $user===null){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		if($request->isXmlHttpRequest())		{
			$em=$this->getDoctrine()->getManager();					
			$requete=$quizzServ->analyseReq($request);
			$question = $em	->getRepository('MDQQuestionBundle:Question')->majVerifRep($requete);
			$gameType=$quizzServ->getTypeVerifR($question->getDom1());
			$scoreQ=$quizzServ->calcScVerifR($requete, $question->getBrep(), $gameType['game']);
			$partie= $em->getRepository('MDQQuizzBundle:PartieQuizz')->majFinPartie($user->getId(), $scoreQ);
			$finP=$quizzServ->testfinP($partie->getNbQjoue(), $gameType['nbQparP']);
			$em->getRepository('MDQUserBundle:ScUser')->majBddVerifRep($user->getScUser(), $gameType['game'], $gameType['dom1'], $requete['rep'], $question->getBrep(), $partie, $finP);
			$em->flush();
			$datab=$quizzServ->dataVerifQ($question, $partie->getScore(), $scoreQ, $finP);
			return new JsonResponse($datab);
		}
		return "erreur";// il faudrait retourner à l'accueil dans ce cas/
	}
	public function finPartieAction(){
		$quizzServ = $this->container->get('mdq_quizz.services');
		$user = $this->container->get('security.context')->getToken()->getUser();
		if(!$quizzServ->testAccessFinP($this->getRequest()->getSession(), $user)){$this->getRequest()->getSession()->set('page', 'finPartie');
									      return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		$this->getRequest()->getSession()->set('page', 'finPartie');
		$partieJoue=$this->getDoctrine()->getManager()->getRepository('MDQQuizzBundle:PartieQuizz')->recupPartie($user->getId());
		$game=$partieJoue->getType();
		if($game=='SexyQuizz'){$bloc_page="bloc_page_SexyQuizz";}
		else{$bloc_page="bloc_page_MasterQuizz";}
		$tabScore=$quizzServ->recupScFinP($user, $game);		
		$highScoreTous=$this->getDoctrine()->getManager()->getRepository('MDQUserBundle:ScUser')->recupHighScore($quizzServ->defCritFinP($game),1,0);
		$com=$quizzServ->comFinP($tabScore['ScDay'], $tabScore['ScMax'], $partieJoue->getScore(), $game, $highScoreTous, $user->getId());

		return $this->render('MDQQuizzBundle:Quizz:finPartie.html.twig', array(
			'com'=>$com,
			'bloc_page'=>$bloc_page,
		));
	}

}
