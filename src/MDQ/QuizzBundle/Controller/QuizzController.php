<?php


namespace MDQ\QuizzBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\QuizzBundle\Entity\PartieQuizz;
use Symfony\Component\HttpFoundation\JsonResponse; // pour les requête ajax

class QuizzController extends Controller
{
	public function preGameAction($game)
	{
		$bloc_page="bloc_page_MasterQuizz";
		$photo="attenteMq.gif";
		if($game=="SexyQuizz"){	$photo="attenteMq.gif";
					$bloc_page="bloc_page_SexyQuizz";}
		return $this->render('MDQQuizzBundle:Quizz:preGame.html.twig', array(
		'game'=>$game,
		'photo'=>$photo,
		'bloc_page'=>$bloc_page,
		));
	}
  public function newGameAction($game)
  {
	$user = $this->container->get('security.context')->getToken()->getUser();
	$em = $this->getDoctrine()->getManager();
		$gestion=$gestion=$em->getRepository('MDQAdminBundle:Gestion')->find(1);
        if ($user===null || $game=="MasterQuizz" && $gestion->getMq()==0 && !$this->get('security.context')->isGranted('ROLE_ADMIN')
			 || $game=="FfQuizz" && $gestion->getFf()==0 && !$this->get('security.context')->isGranted('ROLE_ADMIN')
			 || $game=="ArQuizz" && $gestion->getAr()==0 && !$this->get('security.context')->isGranted('ROLE_ADMIN')
			 || $game=="McQuizz" && $gestion->getMc()==0 && !$this->get('security.context')->isGranted('ROLE_ADMIN')
			 || $game=="LxQuizz" && $gestion->getLx()==0 && !$this->get('security.context')->isGranted('ROLE_ADMIN'))
        {// pas sûr que suffisant en terme de sécurité - bien différent de test que intance user (cf profilecontroller de FOSUser?
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        }
		// **************** Gestion des Jetons ********* //////////////
	/*ss	$nbJtotMq=$user->getScUser()->getNbJdayMq()+$user->getScUser()->getNbJMq();
	ss	$nbJtotQnF=$user->getScUser()->getNbJdayQnF()+$user->getScUser()->getNbJQnF();
	ss	if($game=="MasterQuizz" && $nbJtotMq==0){return $this->redirect($this->generateUrl('mdqgene_accueil'));
	ss	}
	ss	elseif($game=="MasterQuizz" && $user->getScUser()->getNbJdayMq()!=0){$user->getScUser()->setNbJdayMq($user->getScUser()->getNbJdayMq()-1);}
	ss	elseif($game=="MasterQuizz" && $user->getScUser()->getNbJMq()!=0){$user->getScUser()->setNbJMq($user->getScUser()->getNbJMq()-1);}
	ss	elseif($nbJtotQnF==0){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
	ss	elseif($user->getScUser()->getNbJdayQnF()!=0){$user->getScUser()->setNbJdayQnF($user->getScUser()->getNbJdayQnF()-1);}
	ss	else{$user->getScUser()->setNbJQnF($user->getScUser()->getNbJQnF()-1);}
	*/
		$nbJ=$user->getScUser()->getNbJdayMq();
		if($nbJ==0){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		else{$user->getScUser()->setNbJdayMq($nbJ-1);}
		$iduser=$user->getId();// on prend l'id du joueur ayant la connexion sécurisée.
			// On récupère l'EntityManager
		
	    if($game=="MasterQuizz"){$nbP=5;$nbQ=10;}
		elseif($game=="MuQuizz" || $game=="FfQuizz" || $game=="ArQuizz" || $game=="LxQuizz"){$nbP=1;$nbQ=8;}
		elseif($game=="SexyQuizz" || $game=="TvQuizz"){$nbP=1;$nbQ=8;}
		if($game=="FfQuizz" || $game=="LxQuizz"){$nbP=4;}// Temporaire à modifier ensuite
		$derPjoues = $em->getRepository('MDQQuizzBundle:PartieQuizz')
					 ->getDerParties($iduser,$game,$nbP);
		$tabDerQ=[];
		foreach($derPjoues as $partie)
		{
			for($numQ=1; $numQ<($nbQ+1); $numQ++)
			{
			$idQ=$partie['q'.$numQ];
			array_push($tabDerQ, $idQ);
			}
		}
		if($game=="MasterQuizz")
		{
			$tabdom3=[]; $tabtheme=[]; $tabidQ=[];$tabdom=['x','x','x'];
			for($numQ=1; $numQ<11; $numQ++) {
				$dom=$em->getRepository('MDQQuizzBundle:PartieQuizz')
						 ->tiragedudom($tabdom);
				$qtire=$em->getRepository('MDQQuestionBundle:Question')
							 ->tirageduneQMq($numQ, $dom[0], $tabdom3, $tabtheme, $tabDerQ, $tabidQ)					
							 ;
				$tabdom=$dom;			 
				$tabidQ[$numQ-1]=$qtire['id'];			
				$tabdom3[$numQ-1]=$qtire['dom3'];
				$tabtheme[$numQ-1]=$qtire['theme'];
			}
			$scUser=$user->getScUser();
			$scUser->setNbPMq($scUser->getNbPMq()+1);
		}
		else
		{
			$scUser=$user->getScUser();
			if($game=="TvQuizz"){$scUser->setNbPTv($scUser->getNbPTv()+1);}
			elseif($game=="SexyQuizz"){$scUser->setNbPSx($scUser->getNbPSx()+1);}
			elseif($game=="MuQuizz"){$scUser->setNbPMu($scUser->getNbPMu()+1);}
			elseif($game=="FfQuizz"){$scUser->setNbPFf($scUser->getNbPFf()+1);}
			elseif($game=="ArQuizz"){$scUser->setNbPAr($scUser->getNbPAr()+1);}
			elseif($game=="LxQuizz"){$scUser->setNbPLx($scUser->getNbPLx()+1);}
			$tabtheme=['x','x'];$tabidQ=[]; $tabdom3=[]; $tabMedia=[];
			for($numQ=1; $numQ<$nbQ+1; $numQ++)
			{
				$qtire=$em->getRepository('MDQQuestionBundle:Question')
							->tirageduneQ($game,$tabDerQ,$tabtheme, $tabdom3, $tabidQ, $numQ, $tabMedia);
				$tabidQ[($numQ-1)]=$qtire['id'];
				$tabdom3[$numQ-1]=$qtire['dom3'];
				$tabtheme[1]=$tabtheme[0];
				$tabtheme[0]=$qtire['theme'];	
				$tabMedia[($numQ-1)]=$qtire['media'];
			}
		}
		$scUser->setNbPtot($scUser->getNbPtot()+1);
		$pseudo=$user->getUsername();
		$partie=new PartieQuizz();
		$partie->setUsername($pseudo);
	
	/*	function func($partie, $score)// fonctionne visiblement pas possible de définir une égalité entre fonctions.
		{
			$partie->setQ1($score);
			return;
		}
		func($partie, $tabidQ[0]);*/

		$partie->setQ1($tabidQ[0]);			
		$partie->setQ2($tabidQ[1]);
		$partie->setQ3($tabidQ[2]);
		$partie->setQ4($tabidQ[3]);
		$partie->setQ5($tabidQ[4]);
		$partie->setQ6($tabidQ[5]);
		$partie->setQ7($tabidQ[6]);
		$partie->setQ8($tabidQ[7]);
		if($nbQ>8){$partie->setQ9($tabidQ[8]);}
		if($nbQ>9){$partie->setQ10($tabidQ[9]);}
		//$partie->setQ1(1);//pour faire des essais sur l'affichage
		//$partie->setQ2(2);//pour faire des essais sur l'affichage
		//$partie->setQ3(3);//pour faire des essais sur l'affichage
		$partie->setType($game);
		$partie->setUser($user);
		
		
		
		// Étape 1 : On « persiste » l'entité
		$em->persist($partie);
		// Étape 2 : On « flush » tout ce qui a été persisté avant
		$em->flush();
		$session = $this->getRequest()->getSession();
		$session->set('page', 'tirageQ');
		//Je crée une variable de session qui sera utilisée pour tester la provenance de cette page
		return $this->redirect($this->generateUrl('mdqquizz_jeu', array(
		'game'=>$game,
		)));

   }
   public function jeuQuizzAction($game)
   {
		$session = $this->getRequest()->getSession();
		if($session->get('page')!='tirageQ' or $game!="MasterQuizz" && $game!="MuQuizz" && $game!="SexyQuizz" && $game!="FfQuizz" && $game!="ArQuizz" && $game!="LxQuizz"  && $game!="TvQuizz"){
			$session->set('page', 'Mquizz');
			return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}
		$session->set('page', 'Mquizz');
		$em = $this->getDoctrine()->getManager();
		$gestion=$gestion=$em->getRepository('MDQAdminBundle:Gestion')->find(1);
		$signalE=$gestion->getSignalE();
		$user = $this->container->get('security.context')->getToken()->getUser();
	      if ($user===null) {return $this->redirect($this->generateUrl('mdqgene_accueil'));	} 		

		if($game=="MasterQuizz" || $game=="MuQuizz" || $game=="SexyQuizz")
		{
				return $this->render('MDQQuizzBundle:Quizz:jeuQuizz\jeu'.$game.'.html.twig', array(
		    'game'=>$game,
		    'signalE'=>$signalE,
		    ));		
		}
		else {
		return $this->render('MDQQuizzBundle:Quizz:jeuQuizz\photoQuizz.html.twig', array(
		'game'=>$game,
		'signalE'=>$signalE,
		));}
   }
   public function editQuestionAction()// va chercher la question dasn la partie concernée.
   {
		$session = $this->getRequest()->getSession();
		if($session->get('page')!='Mquizz'){
			$session->set('page', 'Mquizz');
			return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}
		$user = $this->container->get('security.context')->getToken()->getUser();
        if ($user===null) { return $this->redirect($this->generateUrl('mdqgene_accueil')); }
		$iduser=$user->getId();
		
	  $request = $this->getRequest();	 
	  if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
	  {
		$numQ = $request->request->get('numQ');	
		$em=$this->getDoctrine()->getManager();
		 if ($numQ !== null )
		  {   
			$idQ = $em->getRepository('MDQQuizzBundle:PartieQuizz')->recupQ($numQ,$iduser);
			$partie=$em->getRepository('MDQQuizzBundle:PartieQuizz')->recupPartie($iduser);
			//controle - pas sur que efficace si 2 partie du même joeur simultanée
			if($numQ!=$partie->getNbQjoue()+1){$data['id']="error";
							    return new JsonResponse($data);}
			$data = $em->getRepository('MDQQuestionBundle:Question')->recupDataQ($idQ);
			$quizzServ = $this->container->get('mdq_quizz.services');
			$datab=$quizzServ->dataEditQ($data);
			   return new JsonResponse($datab);
		 }
	  }
	  $data='error';
	  return $data;        
	}
	public function verifReponseAction(){// Va chercher la bonne réponse, et traite le résultat coté serveur. Envoyer aussi le score ?
		$session = $this->getRequest()->getSession();
		if($session->get('page')!='Mquizz'){
			$session->set('page', 'Mquizz');
			return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}
		$user = $this->container->get('security.context')->getToken()->getUser();
		if ($user===null) {return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		$iduser=$user->getId();		
		$request = $this->getRequest();	 
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{
			$em=$this->getDoctrine()->getManager();			
			$quizzServ = $this->container->get('mdq_quizz.services');
			$requete=$quizzServ->analyseReq($request);
			$question = $em	->getRepository('MDQQuestionBundle:Question')->majVerifRep($requete);			
		// ************ définition du type de jeu **********************
			$gameType=$quizzServ->getTypeVerifR($question->getDom1());
		// *********** mise à jour du score de la bdd partie ***********
			$scoreQ=$quizzServ->calcScVerifR($requete, $question->getBrep(), $gameType['game']);
			$partie= $em->getRepository('MDQQuizzBundle:PartieQuizz')->majFinPartie($iduser, $scoreQ);
			$finP=$quizzServ->testfinP($partie->getNbQjoue(), $gameType['nbQparP']);
		/////// ************ mise à jour de la bdd userscore ************ ///////////////////				
			$scUser=$user->getScUser();
			$majbddscU=$em->getRepository('MDQUserBundle:ScUser')->majBddVerifRep($scUser, $gameType['game'], $gameType['dom1'], $requete['rep'], $question->getBrep(), $partie, $finP);
		// ************ flush final, exécute toutes les mises à jour ******* ////
			$em->flush();
		// ********** préparation des données à envoyer **********
			$datab=$quizzServ->dataVerifQ($question, $partie->getScore(), $scoreQ, $finP);
				return new JsonResponse($datab);
		}
		$data='error';
		return $data;// il faudrait retourner à l'accueil dans ce cas/
	}
	public function finPartieAction(){
		$session = $this->getRequest()->getSession();
		if($session->get('page')!='Mquizz'){
			$session->set('page', 'finPartie');
			return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}
		$session->set('page', 'finPartie');
		$user = $this->container->get('security.context')->getToken()->getUser();
        if ($user===null) {// pas sûr que suffisant en terme de sécurité ?			
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        }
		$partieJoue=$this->getDoctrine()->getManager()
						 ->getRepository('MDQQuizzBundle:PartieQuizz')
						 ->recupPartie($user->getId());
		$score=$partieJoue->getScore();
		$game=$partieJoue->getType();
		$bloc_page="bloc_page_MasterQuizz";
		$comI1='Bravo pour votre partie exceptionnelle ! Votre score final est de ';
		$comI2='Votre avez réalisé un score de ';
		if($game=="MasterQuizz")
		{
			$scofDayUser=$user->getScUser()->getScofDayMq();
			$highscore=$user->getScUser()->getScMaxMq();
		}		
		elseif($game=="MuQuizz")
		{
				$scofDayUser=$user->getScUser()->getScofDayMu();
				$highscore=$user->getScUser()->getScMaxMu();
		}
		elseif($game=="ArQuizz")
		{
				$scofDayUser=$user->getScUser()->getScofDayAr();
				$highscore=$user->getScUser()->getScMaxAr();
		}
		elseif($game=="FfQuizz")
		{
				$scofDayUser=$user->getScUser()->getScofDayFf();
				$highscore=$user->getScUser()->getScMaxFf();
		}
		elseif($game=="LxQuizz")
		{
				$scofDayUser=$user->getScUser()->getScofDayLx();
				$highscore=$user->getScUser()->getScMaxLx();
		}
		elseif($game=="SexyQuizz")
		{
				$scofDayUser=$user->getScUser()->getScofDaySx();
				$highscore=$user->getScUser()->getScMaxSx();
				$bloc_page="bloc_page_SexyQuizz";
		}
		elseif($game=="TvQuizz")
		{
				$scofDayUser=$user->getScUser()->getScofDayTv();
				$highscore=$user->getScUser()->getScMaxTv();
		}
		if($score>=10000){$comIntro=$comI1;}
		else{$comIntro=$comI2;}
		$comFinal=$comIntro.$score.'.';
		if($scofDayUser==$score)
			{
				if($game=='MasterQuizz'){$crit='scofDayMq';}
				elseif($game=='MuQuizz'){$crit='scofDayMu';}
				elseif($game=='ArQuizz'){$crit='scofDayAr';}
				elseif($game=='FfQuizz'){$crit='scofDayFf';}
				elseif($game=='LxQuizz'){$crit='scofDayLx';}
				elseif($game=='SexyQuizz'){$crit='scofDaySx';}
				elseif($game=='TvQuizz'){$crit='scofDayTv';}
				$highScoreTous=$this->getDoctrine()->getManager()
							->getRepository('MDQUserBundle:ScUser')
							->recupHighScore($crit,1,0);
				$i=0;$j=0;
				foreach($highScoreTous as $userA)
				{
					if($j==0){$i++;}
					if($userA['id']==$user->getId()){$j=1;}
				}
				$rang=$i;
			}
		else {$rang="none";}

		return $this->render('MDQQuizzBundle:Quizz:finPartie.html.twig', array(
			'user'=>$user,
			'comFinal'=>$comFinal,
			'score'=>$score,
			'rang'=>$rang,
			'game'=>$game,
			'highscore'=>$highscore,
			'bloc_page'=>$bloc_page,
		));
	}

}
