<?php


namespace MDQ\QuizzBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse; // pour les requête ajax
use Symfony\Component\HttpFoundation\Request;

class QuizzController extends Controller
{
	public function preGameAction($game)
	{
		if(!$this->container->get('mdq_admin.security')->testAutorize("preGame", $game)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		$photo="attenteMq.gif";
		if($game=="SexyQuizz"){$page="preGameSexyQ";}
		else{$page="preGame";}
		return $this->render('MDQQuizzBundle:Quizz:'.$page.'.html.twig', array(
		'game'=>$game,
		'photo'=>$photo,
		));
	}
	public function newGameAction($game)// 9 requete en tout
	{
		if(!$this->container->get('mdq_admin.security')->testAutorize("newGame", $game)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
	$user = $this->container->get('security.token_storage')->getToken()->getUser();
	$em = $this->getDoctrine()->getManager();
	if($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){$admin=1;}
	else{$admin=0;}
        if($this->container->get('mdq_user.jeton_serv')->testJeton($user, $game)===false && $admin!=1){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		$partie=$em->getRepository('MDQQuizzBundle:PartieQuizz')->createNewP($game,$user);		
		$this->container->get('mdq_user.jeton_serv')->suppJPartie($user, $game);
		$em->persist($partie); 
		$em->flush();
		return $this->redirect($this->generateUrl('mdqquizz_jeu', array(
		'game'=>$game,
		)));
	}
	  public function jeuQuizzAction($game)
	{
		if(!$this->container->get('mdq_admin.security')->testAutorize("jeuQuizz", $game)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		
		$quizzServ = $this->container->get('mdq_quizz.services');
		$page=$quizzServ->selectPageJeu($game);
		$signalE=$quizzServ->testSignalE();
		return $this->render('MDQQuizzBundle:Quizz:jeuQuizz\\'.$page.'.html.twig', array(
		    'game'=>$game,
		    'signalE'=>$signalE,
		    ));			
	}
	public function editQuestionAction(Request $request){// 3 requete en tout (2spécifique)
		$user = $this->container->get('security.token_storage')->getToken()->getUser();		
		if($this->container->get('mdq_quizz.ajax')->testSession($request->getSession())==1 || $user===null){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
	  if($request->isXmlHttpRequest())  {
		$numQ = $request->request->get('numQ');	
		 if ($numQ !== null ){   
		//	$idQ = $this->getDoctrine()->getManager()->getRepository('MDQQuizzBundle:PartieQuizz')->recupQ($numQ,$user->getId()); //Plus besoin ; la suite est limite, mais ça marche
			$partie=$this->getDoctrine()->getManager()->getRepository('MDQQuizzBundle:PartieQuizz')->recupPartie($user->getId());
			$function1="getQ".$numQ;
			$idQ=$partie->$function1();
			if($numQ!=$partie->getNbQjoue()+1){$data['id']="error";
							    return new JsonResponse($data);}
			$data = $this->getDoctrine()->getManager()->getRepository('MDQQuestionBundle:Question')->recupDataQ($idQ);
			$datab=$this->container->get('mdq_quizz.ajax')->dataEditQ($data);
			   return new JsonResponse($datab);
		 }
	  }
	  return "erreur";        
	}
	public function verifReponseAction(Request $request){// 9 requetes (8spécifiques) je ne vois pas comment diminuer.
		$quizzServ = $this->container->get('mdq_quizz.ajax');
		$user = $this->container->get('security.token_storage')->getToken()->getUser();		
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
	public function finPartieAction(){//6 dont celle de sécurité.
	
		if(!$this->container->get('mdq_admin.security')->testAutorize("finPartie", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		$user = $this->container->get('security.token_storage')->getToken()->getUser();
		$quizzServ = $this->container->get('mdq_quizz.services');
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
	
	public function signalErrorAction(Request $request)
	{
	  if($this->container->get('mdq_admin.security')->testAutorize("signalError", null))
	  {
		$em=$this->getDoctrine()->getManager();	
		$user = $this->container->get('security.token_storage')->getToken()->getUser();
		if($request->isXmlHttpRequest() && $user->getAllowError()==1) // pour vérifier la présence d'une requete Ajax
		{
			$idQ = $request->request->get('idQ');	
			$taberror = $request->request->get('taberror');	
			if($idQ!==null && $taberror!==null)
			{				
				$question=$em->getRepository('MDQQuestionBundle:Question')->findOneById($idQ);
				$this->container->get('mdq_quizz.ajax')->majSignalError($question, $user->getScUser(), $taberror);
					$em->flush();
			return new JsonResponse($idQ);
			} 
		}
	  }		
		return new JsonResponse("error");  
	}
}
