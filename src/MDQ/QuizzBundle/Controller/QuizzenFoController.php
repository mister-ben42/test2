<?php


namespace MDQ\QuizzBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\QuizzBundle\Entity\PartieQuizz;
use MDQ\UserBundle\Entity\User;
use MDQ\QuestionBundle\Entity\Question;
use Symfony\Component\HttpFoundation\Request; // pour les requête ajax
use Symfony\Component\HttpFoundation\JsonResponse; // pour les requête ajax

class QuizzenFoController extends Controller
{
	public function preGameAction()
	{
		return $this->render('MDQQuizzBundle:Quizz:preGame.html.twig');
	}
  public function newGameAction()
  {
	$user = $this->container->get('security.context')->getToken()->getUser();
        if ($user===null) {// pas sûr que suffisant en terme de sécurité - bien différent de test que intance user (cf profilecontroller de FOSUser?
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        }      
		$iduser=$user->getId();// on prend l'id du joueur ayant la connexion sécurisée.
	  $derQjoues = $this->getDoctrine()// on récupère les dernières questions jouées.
                     ->getManager()
                     ->getRepository('MDQQuizzBundle:PartieQuizz')
					 ->getDerQ($iduser);
		$tabDerQ=[];
		foreach($derQjoues as $partie)
		{
			for($numQ=1; $numQ<11; $numQ++)
			{
			$idQ=$partie['q'.$numQ];
			array_push($tabDerQ, $idQ);
			}
		}
		$tabdesQ=[]; $tabdom3=[]; $tabtheme=[]; $tabidQ=[];$tabdom=['x','x','x'];
		/*$tabdom1=['Histoire','Sports et loisirs','Géographie','Arts et Littérature','Sciences et nature','Divers'];
			$nbtire=mt_rand(0,5);
			$dom=$tabdom1[$nbtire];*/
		for($numQ=1; $numQ<11; $numQ++) {
			// ça ne marche pas bien(cf question tiré dans 2 partie consécutives, ... à reprendre).	
			$dom=$this->getDoctrine()// on récupère le dom1 de la question.
                     ->getManager()
                     ->getRepository('MDQQuizzBundle:PartieQuizz')
					 ->tiragedudom($tabdom);
			$qtire=$this->getDoctrine()
						 ->getManager()
						 ->getRepository('MDQQuestionBundle:Question')
						 ->tirageduneQ($numQ, $dom[0], $tabdom3, $tabtheme, $tabDerQ, $tabidQ)					
						 ;
			$tabdom=$dom;			 
			$tabidQ[$numQ-1]=$qtire['id'];			
			$tabdom3[$numQ-1]=$qtire['dom3'];
			$tabtheme[$numQ-1]=$qtire['theme'];
		}
		$pseudo=$user->getUsername();
		$partie=new PartieQuizz();
		$partie->setUsername($pseudo);
		$partie->setQ1($tabidQ[0]);		
		$partie->setQ2($tabidQ[1]);
		$partie->setQ3($tabidQ[2]);
		$partie->setQ4($tabidQ[3]);
		$partie->setQ5($tabidQ[4]);
		$partie->setQ6($tabidQ[5]);
		$partie->setQ7($tabidQ[6]);
		$partie->setQ8($tabidQ[7]);
		$partie->setQ9($tabidQ[8]);
		$partie->setQ10($tabidQ[9]);
		//$partie->setQ1(1);//pour faire des essais sur l'affichage
		//$partie->setQ2(2);//pour faire des essais sur l'affichage
		//$partie->setQ3(3);//pour faire des essais sur l'affichage
		$partie->setUser($user);
		$scUser=$user->getScUser();
		$scUser->setNbPMq($scUser->getNbPMq()+1);
		
			// On récupère l'EntityManager
		$em = $this->getDoctrine()->getManager();
		// Étape 1 : On « persiste » l'entité
		$em->persist($partie);
		// Étape 2 : On « flush » tout ce qui a été persisté avant
		$em->flush();
		$session = $this->getRequest()->getSession();
		$session->set('page', 'tirageQ');
		//Je crée une variable de session qui sera utilisée pour tester la provenance de cette page
		return $this->redirect($this->generateUrl('mdqquizz_jeu'));
 /*   return $this->render('MDQQuizzBundle:Quizz:page1Quizz.html.twig', array(
	'derQjoues'=>$derQjoues,
	'qtire'=>$qtire,
	'qpartie'=>$tabidQ,
	));*/
   }
   public function jeuQuizzAction()
   {
		//test d'arriver de la page tirage des Q par la session
		$session = $this->getRequest()->getSession();
		if($session->get('page')!='tirageQ'){
			$session->set('page', 'Mquizz');
			return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}
		$session->set('page', 'Mquizz');
		$user = $this->container->get('security.context')->getToken()->getUser();
        if ($user===null) {// pas sûr que suffisant en terme de sécurité ?			
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        } 
		
		return $this->render('MDQQuizzBundle:Quizz:jeuQuizz.html.twig');
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
		 if ($numQ != null )
		  {   
			$idQ = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('MDQQuizzBundle:PartieQuizz')
						   ->recupQ($numQ,$iduser);			
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
		// ************ récupération de la question ***********			
			$question = $em	->getRepository('MDQQuestionBundle:Question')				
						->find($idQ);
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
		// *********** mise à jour de la bdd partie ***********
				if ($rep!=$question->getBrep()){				
					$scoreQ=0;
				}
				else {
					$tabscore=[100,200,500,1000,2000];			
					$tabdiff=[1,2,2,3,3,3,4,4,5,5];
					$scdebase=$tabscore[($tabdiff[$numQ-1])-1];
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
				
			
		// ************ mise à jour de la bdd userscore ************
			$scUser=$user->getScUser();
			$NbQtot=$scUser->getNbQtotMq();			
			$NbBrTot=$scUser->getNbBrtotMq();
			$scUser->setNbQtotMq($NbQtot+1);
			if ($rep==$question->getBrep()){
				$NbBrTot=$NbBrTot+1;
				$scUser->setNbBrtotMq($NbBrTot);
			}
			if ($question->getDom1()=='Histoire') {
				$NbQH=$scUser->getNbQhMq();
				$NbBrH=$scUser->getNbBrhMq();
				$scUser->setNbQhMq($NbQH+1);				
				if ($rep==$question->getBrep()){
					$NbBrH=$NbBrH+1;
					$scUser->setNbBrhMq($NbBrH);
				}
				$scUser->setPrctBrhMq($NbBrH*100/($NbQH+1));
			}
			if ($question->getDom1()=='Géographie') {
				$NbQG=$scUser->getNbQgMq();
				$NbBrG=$scUser->getNbBrgMq();
				$scUser->setNbQgMq($NbQG+1);				
				if ($rep==$question->getBrep()){
					$NbBrG=$NbBrG+1;
					$scUser->setNbBrgMq($NbBrG);
				}
				$scUser->setPrctBrgMq($NbBrG*100/($NbQG+1));
			}			
			if ($question->getDom1()=='Divers'){
				$NbQD=$scUser->getNbQdMq();
				$NbBrD=$scUser->getNbBrdMq();
				$scUser->setNbQdMq($NbQD+1);				
				if ($rep==$question->getBrep()){
					$NbBrD=$NbBrD+1;
					$scUser->setNbBrdMq($NbBrD);
				}
				$scUser->setPrctBrdMq($NbBrD*100/($NbQD+1));
			}			
			if ($question->getDom1()=='Arts et Littérature'){
				$NbQAL=$scUser->getNbQalMq();
				$NbBrAL=$scUser->getNbBralMq();
				$scUser->setNbQalMq($NbQAL+1);				
				if ($rep==$question->getBrep()){
					$NbBrAL=$NbBrAL+1;
					$scUser->setNbBralMq($NbBrAL);
				}
				$scUser->setPrctBralMq($NbBrAL*100/($NbQAL+1));
			}
			if ($question->getDom1()=='Sports et loisirs'){
				$NbQSL=$scUser->getNbQslMq();
				$NbBrSL=$scUser->getNbBrslMq();
				$scUser->setNbQslMq($NbQSL+1);				
				if ($rep==$question->getBrep()){
					$NbBrSL=$NbBrSL+1;
					$scUser->setNbBrslMq($NbBrSL);
				}
				$scUser->setPrctBrslMq($NbBrSL*100/($NbQSL+1));
			}
			if ($question->getDom1()=='Sciences et nature'){
				$NbQSN=$scUser->getNbQsnMq();
				$NbBrSN=$scUser->getNbBrsnMq();
				$scUser->setNbQsnMq($NbQSN+1);				
				if ($rep==$question->getBrep()){
					$NbBrSN=$NbBrSN+1;
					$scUser->setNbBrsnMq($NbBrSN);
				}
				$scUser->setPrctBrsnMq($NbBrSN*100/($NbQSN+1));
			}			
			$scUser->setPrctBrtotMq($NbBrTot*100/($NbQtot+1));
		//********* Mise à jour de fin de partie ********** ////
			if($oldnbQjoue+1==10){
				$partie->setValid(true);
				$scTot=$scUser->getScTotMq()+$newscore;
				$scUser->setScTotMq($scTot);
				$scUser->setScMoyMq($scTot/$scUser->getNbPMq());
				if($scUser->getScofDayMq()==NULL OR $newscore>$scUser->getScofDayMq()){
					$scUser->setScofDayMq($newscore);
				}
				if($newscore>$scUser->getScMaxMq()){
					$scUser->setScMaxMq($newscore);
					$scUser->setDatescMaxMq($partie->getDate());
				}
				$top10mois=$scUser->getTop10month();
				//$nbval=count($top10mois);
			/*	if(count($top10mois)<10){
					array_push($top10mois, $newscore);
					sort($top10mois);
					$scUser->setTop10month($top10mois);
					$scUser->setSumtop10month(array_sum($top10mois));
				}
				else if(count($top10mois)==10){*/
					if($newscore>$top10mois[0]){
						$top10mois[0]=$newscore;
					//	sort($top10mois);// J'enlève cette partie : sinon, tous les scores du jours compte, la remise en ordre du tableau n'aura lieu que chaque jour, et ainsi un seul score par jour comtera.
						$scUser->setTop10month($top10mois);
						$scUser->setSumtop10month(array_sum($top10mois));
					}
				//}
			}
		// ************ flush final, exécute toutes les mises à jour ******* ////
			$em->flush();
		// ********** préparation des données à envoyer **********
			$datab['brep']=$question->getBrep();
			$datab['commentaire']=$question->getCommentaire();
			$datab['scoreQ']=$scoreQ;
			$datab['score']=$newscore;
			$datab['id']=$question->getId();
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
	/*	if($session->get('page')!='Mquizz'){
			$session->set('page', 'finPartie');
			return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}*/
		$session->set('page', 'finPartie');
		$user = $this->container->get('security.context')->getToken()->getUser();
        if ($user===null) {// pas sûr que suffisant en terme de sécurité ?			
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        } 
		$partieJoue=$this->getDoctrine()
						 ->getManager()
						 ->getRepository('MDQQuizzBundle:PartieQuizz')
						 ->recupPartie($user->getId());
		$score=$partieJoue->getScore();
		//$tabcomScore=['score catastrophique', 'petit score','score moyen', 'bon score', 'très bon score', 'excellent score', 'score exceptionnel'];
		$scofDayMqUser=$user->getScUser()->getScofDayMq();
		if($scofDayMqUser==$score)
		{
			$rang=$this->getDoctrine()
						->getManager()
						->getRepository('MDQUserBundle:ScUser')
							 ->rangScofDayMq($score);
		}
		else {$rang="none";}
		$tabcomMoy=[', nettement inférieur à vos performances habituelles',
				', inférieur à vos performances habituelles',
				', dans la moyenne de vos performances habituelles',
				', supérieur à vos performances habituelles',
				', nettement supérieur à vos performances habituelles'];
		/*$tabIntro1=[	'Monumental !!! Vous êtes vraiment un virtuose du Masterquizz, avec un',
					'Epoustouflant !!!  Vous avez réalisé une magnifique prestation, avec un',
					'Vous ne seriez pas la réincarnation d\'Albert Einstein ? On peut se le demander avec votre'];
		$tabIntro2=['Vous vous êtes vraiment surpassé avec un',
					'Vous êtes vraiment en super forme !!! Vous avez réalisé un',
					'Vous avez réalisé une prestation sensationnelle, avec un'];
		$tabIntro3=['Vous avez réalisé une belle partie avec un',
				'Vous avez réalisé une belle prestation avec un'];
		$tabIntro4=['Vous avez réalisé une performance tout juste correcte, avec un',
				'Il n\'y a pas de quoi fanfaronné, avec un',
				'Vous n\'avez pas fait d\'étincelles, avec un'];
		$tabIntro5=['Vous n\'êtes décidément pas très en forme ! Vous avez fait un',
					'Vraiment pas terrible aujourd\'hui, vous avez réalisé un'];
		$tabIntro6=['Que vous arrive-t-il ? Vous semblez dans une forme déplorable, avec un',
					'Quelle partie épouvantable !!! Vous avez réalisé un'];
		if($score>=11000){$comScore=$tabcomScore[6];}
		else if($score>=10000){$comScore=$tabcomScore[5];}
		else if($score>=8500){$comScore=$tabcomScore[4];}
		else if($score>=6500){$comScore=$tabcomScore[3];}
		else if($score>=4500){$comScore=$tabcomScore[2];}
		else if($score>=1500){$comScore=$tabcomScore[1];}
		else if($score<1500){$comScore=$tabcomScore[0];}
		*/
		$tabMoy1=[2000,2000,2000,4000];
		$tabMoy2=[1500,750,1500,3000];
		$tabMoy3=[2500,1000,1000,2500];
		$tabMoy4=[2500,1000,750,1500];
		$moy=$user->getScUser()->getScMoyMq();
		if($user->getScUser()->getNbPMq()<4){$scomMoy='';}
		else {			
			if($moy<9000){
				if($moy<2000){$tabMoy=$tabMoy1;}
				else if($moy<4000){$tabMoy=$tabMoy2;}
				else if($moy<7500){$tabMoy=$tabMoy3;}
				else if($moy<9000){$tabMoy=$tabMoy4;}
			/*	if($score<$moy-$tabMoy[0]){$comMoy=$tabcomMoy[0]; $tabIntro=$tabIntro6;}
				else if($score<$moy-$tabMoy[1]){$comMoy=$tabcomMoy[1]; $tabIntro=$tabIntro5;}
				else if($score<$moy+$tabMoy[2]){$comMoy=$tabcomMoy[2]; $tabIntro=$tabIntro4;}
				else if($score<$moy+$tabMoy[3]){$comMoy=$tabcomMoy[3]; $tabIntro=$tabIntro3;}
				else if($score>=$moy+$tabMoy[3]){$comMoy=$tabcomMoy[4]; $tabIntro=$tabIntro2;}*/
				if($score<$moy-$tabMoy[0]){$comMoy=$tabcomMoy[0];}
				else if($score<$moy-$tabMoy[1]){$comMoy=$tabcomMoy[1];}
				else if($score<$moy+$tabMoy[2]){$comMoy=$tabcomMoy[2];}
				else if($score<$moy+$tabMoy[3]){$comMoy=$tabcomMoy[3];}
				else if($score>=$moy+$tabMoy[3]){$comMoy=$tabcomMoy[4];}
			}
			else if ($moy>=9000){
				/*if ($score<$moy-2500){$comMoy=$tabcomMoy[0]; $tabIntro=$tabIntro6;}
				else if($score<$moy-1000){$comMoy=$tabcomMoy[1]; $tabIntro=$tabIntro5;}
				else if($score<($moy+(11500-$moy)/3)){$comMoy=$tabcomMoy[2]; $tabIntro=$tabIntro4;}
				else if($score<($moy+2*(11500-$moy)/3)){$comMoy=$tabcomMoy[3]; $tabIntro=$tabIntro3;}
				else {$comMoy=$tabcomMoy[4]; $tabIntro=$tabIntro2;}*/
				if ($score<$moy-2500){$comMoy=$tabcomMoy[0];}
				else if($score<$moy-1000){$comMoy=$tabcomMoy[1];}
				else if($score<($moy+(11500-$moy)/3)){$comMoy=$tabcomMoy[2];}
				else if($score<($moy+2*(11500-$moy)/3)){$comMoy=$tabcomMoy[3];}
				else {$comMoy=$tabcomMoy[4];}
			}
			if($score>=10000){
				//$tabIntro=$tabIntro1;
				$comIntro='Bravo pour votre partie exceptionnelle ! Votre score final est de ';
				}
			else{$comIntro='Votre score final est de ';}
		/*	$tabIntrolength=count($tabIntro);
			$nbtire=mt_rand(1,$tabIntrolength);
			$comIntro=$tabIntro[$nbtire-1];*/
		}
		
		//$comFinal=$comIntro.' '.$comScore.' de '.$score.$comMoy.'.';
		$comFinal=$comIntro.$score.$comMoy.'.';
		return $this->render('MDQQuizzBundle:Quizz:finPartie.html.twig', array(
			'user'=>$user,
			'comFinal'=>$comFinal,
			'score'=>$score,
			'rang'=>$rang,
			
		));
	}
   
}