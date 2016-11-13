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
		//test d'arriver de la page tirage des Q par la session
		$session = $this->getRequest()->getSession();
		if($session->get('page')!='tirageQ'){
			$session->set('page', 'Mquizz');
			return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}
		$session->set('page', 'Mquizz');
		$em = $this->getDoctrine()->getManager();
		$gestion=$gestion=$em->getRepository('MDQAdminBundle:Gestion')->find(1);
		$signalE=$gestion->getSignalE();
		$user = $this->container->get('security.context')->getToken()->getUser();
        if ($user===null) {// pas sûr que suffisant en terme de sécurité ?			
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        } 
		
		if($game=="SexyQuizz"){	$bloc_page="bloc_page_SexyQuizz";}
		else{$bloc_page="bloc_page_MasterQuizz";}
		return $this->render('MDQQuizzBundle:Quizz:jeuQuizz.html.twig', array(
		'game'=>$game,
		'bloc_page'=>$bloc_page,
		'signalE'=>$signalE,
		));
   }
   public function editQuestionAction()// va chercher la question dasn la partie concernée.
   {
		$session = $this->getRequest()->getSession();
		if($session->get('page')!='Mquizz'){
			$session->set('page', 'Mquizz');
			return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}
		$user = $this->container->get('security.context')->getToken()->getUser();
        if ($user===null) {// pas sûr que suffisant en terme de sécurité ?
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        }
		$iduser=$user->getId();
		
	  $request = $this->getRequest();	 
	  if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
	  {
		$numQ = $request->request->get('numQ');	
		// dans ma démarche, je vais récupérer l'id dans un table, puis la question correspondante dans une autre. Possibilité de joindre ?
		// j'ai essayer les jointure, avec relation many to many, bcp de choses, sans doute pas loin
		 if ($numQ !== null )
		  {   
			$idQ = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('MDQQuizzBundle:PartieQuizz')
						   ->recupQ($numQ,$iduser);
			$partie=$this->getDoctrine()
					  ->getManager()
					  ->getRepository('MDQQuizzBundle:PartieQuizz')
					  ->recupPartie($iduser);
			//controle - pas sur que efficace si 2 partie du même joeur simultanée
			if($numQ!=$partie->getNbQjoue()+1){$data['id']="error";
							    return new JsonResponse($data);}

			$data = $this->getDoctrine()
						->getManager()
						->getRepository('MDQQuestionBundle:Question')
				// Là, je peux rajouter un erreur si numQ différent du numQ de la bdd et
				//ajouter un numQ dans la bdd - updater la bdd.
						->recupDataQ($idQ);
			$tablamlg=array($data['brep'],$data['mrep1'],$data['mrep2'],$data['mrep3']);	
			shuffle($tablamlg);
			$datab['id']=$data['id'];
			$datab['intitule']=$data['intitule']; 
			$datab['rep1']=$tablamlg[0];
			$datab['rep2']=$tablamlg[1];
			$datab['rep3']=$tablamlg[2];
			$datab['rep4']=$tablamlg[3];
			$datab['dom1']=$data['dom1']; 
			$datab['theme']=$data['theme']; 
			$datab['diff']=$data['diff'];
			$datab['type']=$data['type'];
			$datab['media']=$data['media'];
			
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
        if ($user===null) {// pas sûr que suffisant en terme de sécurité ?
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        }
		$iduser=$user->getId();
		
		$request = $this->getRequest();	 
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{
			$em=$this->getDoctrine()->getManager();
			$idQ = $request->request->get('idQ');
			$rep = $request->request->get('rep');
			$tpsrep = $request->request->get('temps');
			$numQ = $request->request->get('numQ');
			$finP=0;// variable qui permet de controler la fin de Partie.
		// ************ récupération de la question ***********			
			$question = $em	->getRepository('MDQQuestionBundle:Question')				
						->find($idQ);
		// ************ définition du type de jeu **********************
			if($question->getDom1()=='Histoire' || $question->getDom1()=='Géographie' || $question->getDom1()=='Sciences et nature' || $question->getDom1()=='Arts et Littérature' || $question->getDom1()=='Sports et loisirs' || $question->getDom1()=='Divers')
				{$game='MasterQuizz'; $nbQparP=10; $dom1=$question->getDom1();}
			elseif($question->getDom1()=='SexyQuizz'){$game='QuizzenFolie'; $dom1='SexyQuizz';$nbQparP=8;}
			elseif($question->getDom1()=='TvQuizz'){$game='QuizzenFolie'; $dom1='TvQuizz';$nbQparP=8;}
			elseif($question->getDom1()=='MuQuizz'){$game='MediaQuizz'; $dom1='MuQuizz';$nbQparP=8;}
			elseif($question->getDom1()=='ArQuizz'){$game='MediaQuizz'; $dom1='ArQuizz';$nbQparP=8;}
			elseif($question->getDom1()=='FfQuizz'){$game='MediaQuizz'; $dom1='FfQuizz';$nbQparP=8;}
			elseif($question->getDom1()=='LxQuizz'){$game='MediaQuizz'; $dom1='LxQuizz';$nbQparP=8;}
		// ************ mise à jour de la bdd question ***********
			$newnbBrep=$question->getNbBrep();
			$newnbMrep1=$question->getNbMrep1();
			$newnbMrep2=$question->getNbMrep2();
			$newnbMrep3=$question->getNbMrep3();
			$newnbTout=$question->getNbTout();
			$newnbJoue=$question->getNbJoue()+1;
				$question->setNbJoue($newnbJoue);
			if ($rep==$question->getBrep()){$newnbBrep=$question->getNbBrep()+1;
											$question->setNbBrep($newnbBrep);}
			else if ($rep==$question->getMrep1()){$newnbMrep1=$question->getNbMrep1()+1;
											$question->setNbMrep1($newnbMrep1);}
			else if ($rep==$question->getMrep2()){$newnbMrep2=$question->getNbMrep2()+1;
											$question->setNbMrep2($newnbMrep2);}
			else if ($rep==$question->getMrep3()){$newnbMrep3=$question->getNbMrep3()+1;
											$question->setNbMrep3($newnbMrep3);}
			else if ($rep=="none"){$newnbTout=$question->getNbTout()+1;
											$question->setNbTout($newnbTout);}
			$question->setPrctBrep($newnbBrep*100/$newnbJoue);
			$question->setPrctMrep1($newnbMrep1*100/$newnbJoue);
			$question->setPrctMrep2($newnbMrep2*100/$newnbJoue);
			$question->setPrctMrep3($newnbMrep3*100/$newnbJoue);
			$question->setPrctTout($newnbTout*100/$newnbJoue);			
			if ($newnbJoue<101){$question->setPrct100j($newnbBrep*100/$newnbJoue);}
			if ($newnbJoue<501){$question->setPrct500j($newnbBrep*100/$newnbJoue);}
			
		// *********** mise à jour du score de la bdd partie ***********
				if ($rep!=$question->getBrep()){				
					$scoreQ=0;
				}
				else {						
					if($game=='MasterQuizz')
					{
						$tabscore=[100,200,500,1000,2000];			
						$tabdiff=[1,2,2,3,3,3,4,4,5,5];
						$scdebase=$tabscore[($tabdiff[$numQ-1])-1];
					}
					else{$scdebase=1000;}
					$bonus=round(($scdebase/2*$tpsrep/150),0);
					$scoreQ=$scdebase+$bonus;
				}
			
			$partie= $em->getRepository('MDQQuizzBundle:PartieQuizz')
						->recupPartie($iduser);
				$oldnbQjoue=$partie->getNbQjoue();
				$oldscore=$partie->getScore();
				$newscore=$oldscore+$scoreQ;
			$partie->setScore($newscore);
			$partie->setNbQjoue($oldnbQjoue+1);			
			$scUser=$user->getScUser();	
			
		/////// ************ mise à jour de la bdd userscore ************ ///////////////////

			// Je tente avec les fonctions
			if($game=='MediaQuizz' || $game=='QuizzenFolie' || $game=='MasterQuizz')
			{			
			if($rep==$question->getBrep()){$br=1;}
			else{$br=0;}
		
			$majbddscU=$em->getRepository('MDQUserBundle:ScUser')
						->majBddScQ($scUser, $game, $dom1, $br);
						
			if($oldnbQjoue+1==$nbQparP){
				$finP=1;
				$majbddscU=$em->getRepository('MDQUserBundle:ScUser')
						->majBddScfinP($scUser, $dom1, $game, $partie);
			}
			
			}
		// ************ flush final, exécute toutes les mises à jour ******* ////
			$em->flush();
		// ********** préparation des données à envoyer **********
			$datab['brep']=$question->getBrep();
			$prepacom=($question->getCommentaire());
			$datab['commentaire']=$prepacom;//Permet Le/n dans MySql euh non !
			$datab['scoreQ']=$scoreQ;
			$datab['score']=$newscore;
			$datab['id']=$question->getId();
			$datab['finP']=$finP;
			$datab['imageCom']=$question->getImageCom();
			$datab['dom1']=$question->getDom1();
			//$datab['game']=$game;//surtout pour controler
			//$datab['top10mois']=$top10mois;// juste pour tester
			//$datab['nbval']=$nbval;// juste pour tester
			// Envoyer aussi le score quand il sera calculé
				return new JsonResponse($datab);
		}
		$data='error';
		return $data;// il faurait retourner à l'accueil dans ce cas/
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
