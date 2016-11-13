<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\GeneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\GeneBundle\Entity\StatsQuot;


class GeneController extends Controller
{
  public function accueilAction()
  {// Rq, je n'ai mis aucun persist et ca marche quand meme ! A etudier.
    $session = $this->getRequest()->getSession();
	$session->set('page', 'accueil');	
	$em=$this->getDoctrine()->getManager();
	/* Remarque : mise a jour journee et mois en meme temps que maj jur partie non validees, du coup si partie non validee en fin de journee, ou si aucune connection ensuite,
	Elle s'inscrit comme parte jouee le lendemain quelque soit l'heure où elle est jouee. A CORRIGER
	En fait il suffir juste de mettre la partie test de la date apres celle de la validation de la partie*/
	// MODIF EFFECTUEE : A tester puis effacer le passage precedent.
	// ******** Controle des parties en bdd et validation le cas echeant + mise a jours de bdd user et partie
	$partieNonValide=$em->getRepository('MDQQuizzBundle:PartieQuizz')
				->recupPNonValid();
		foreach ($partieNonValide as $partie){
			$intcontrol = new \DateInterval('PT10M');// Definition d'un intervalle de 10 minutes
			$dateactu= new \DateTime();
			$datepartie=$partie->getDate();
			if($dateactu->sub($intcontrol)>$datepartie){
				$partie->setValid(true);
				$user=$partie->getUser();
				$scUser=$user->getScUser();
				$game=$partie->getType();
				if($game=='MasterQuizz'){$dom1='none';}
				else{$dom1=$game;
					$game='MediaQuizz';}
				$em->getRepository('MDQUserBundle:ScUser')
							->majBddScfinP($scUser, $dom1, $game, $partie);

			}
		}
	// ********** Controle de nouvelle journee -- A terme a remplacer par un CRON ******** ///
	$datejour= new \DateTime(date('Y-m-d'));
		//Reste un petit pb avec l'objet date : si pas de connexion le lundi, mais le mardi, la date de Maj de la datebdd jour est celle du debut de semane, ce qui conduit a une maj automatique du jour lors de l'arrivee suivante sur la page d'accueil.
		$datebdd=$em->getRepository('MDQGeneBundle:DateReference')->find(1);
		//$tabrMDQ[0]=$datebdd->getRMDQ(); Que si classement mensuel
		$tabMaitres=[$datebdd->getRMDQ(), null,null,null,null,null,null];
		if($datebdd->getDay()!=$datejour){
			$datebdd->setDay($datejour);// Je le mets la ; si je le mets apres l'operation sub dateInter, l'interval est deduit de la date entree en bdd -jsp pourquoi.
			//*************************Mise a jour de la bdd StatsQuot****************** ///
			// A voir ou le placer.
			$statsJ=$em->getRepository('MDQGeneBundle:StatsQuot')->findOneBy(array('valid'=>0));
			if($datebdd->getRMDQ()!==null){$statsJ->setRMDQ($datebdd->getRMDQ()->getId());}
			if($datebdd->getMMDQ()!==null){$statsJ->setMMDQ($datebdd->getMMDQ()->getId());}
			if($datebdd->getSMDQ()!==null){$statsJ->setSMDQ($datebdd->getSMDQ()->getId());}
			if($datebdd->getFfMDQ()!==null){$statsJ->setFfMDQ($datebdd->getFfMDQ()->getId());}
			if($datebdd->getLxMDQ()!==null){$statsJ->setLxMDQ($datebdd->getLxMDQ()->getId());}
			if($datebdd->getArMDQ()!==null){$statsJ->setArMDQ($datebdd->getArMDQ()->getId());}
			if($datebdd->getMuMDQ()!==null){$statsJ->setMuMDQ($datebdd->getMuMDQ()->getId());}
		//	$nbPMq=$em->getRepository('MDQQuizzBundle:PartieQuizz')->nbParties('MasterQuizz',0,1); // 0 pour la date = depuis tjrs.
			$nbPMq=$em->getRepository('MDQQuizzBundle:PartieQuizz')->nbParties('MasterQuizz',$datebdd->getDay(),0);
			$nbPFf=$em->getRepository('MDQQuizzBundle:PartieQuizz')->nbParties('FfQuizz',$datebdd->getDay(),0);
			$nbPLx=$em->getRepository('MDQQuizzBundle:PartieQuizz')->nbParties('LxQuizz',$datebdd->getDay(),0);
			$nbPAr=$em->getRepository('MDQQuizzBundle:PartieQuizz')->nbParties('ArQuizz',$datebdd->getDay(),0);
			$nbPMu=$em->getRepository('MDQQuizzBundle:PartieQuizz')->nbParties('MuQuizz',$datebdd->getDay(),0);
			$nbPMqbot=$em->getRepository('MDQQuizzBundle:PartieQuizz')->nbParties('MasterQuizz',$datebdd->getDay(),1);
			$nbPTotbot=$em->getRepository('MDQQuizzBundle:PartieQuizz')->nbParties('tous',$datebdd->getDay(),1);
			$nbUserDay=$em->getRepository('MDQUserBundle:User')->recupNbUser($datebdd->getDay(),1);
			$nbUser7j=$em->getRepository('MDQUserBundle:User')->recupNbUser($datebdd->getDay(),7);
			$nbUser30j=$em->getRepository('MDQUserBundle:User')->recupNbUser($datebdd->getDay(),30);
			$nbInscritDay=$em->getRepository('MDQUserBundle:User')->recupNbInscrit($datebdd->getDay(),1);
			$scMoy=$em->getRepository('MDQQuizzBundle:PartieQuizz')->recupScMoy("tous",$datebdd->getDay(),1,0);
			$scMoyBot=$em->getRepository('MDQQuizzBundle:PartieQuizz')->recupScMoy("tous",$datebdd->getDay(),1,1);
			$nbQMq=$em->getRepository('MDQQuestionBundle:Question')->getNbQuestions(2, 1, 0, "MasterQuizz", "none", "none", "id", "ASC", 0, 1);
			$nbQFf=$em->getRepository('MDQQuestionBundle:Question')->getNbQuestions(2, 1, 0, "none", "FfQuizz", "none", "id", "ASC", 0, 1);
			$nbQLx=$em->getRepository('MDQQuestionBundle:Question')->getNbQuestions(2, 1, 0, "none", "LxQuizz",  "none", "id", "ASC", 0, 1);
			$nbQAr=$em->getRepository('MDQQuestionBundle:Question')->getNbQuestions(2, 1, 0, "none", "ArQuizz",  "none", "id", "ASC", 0, 1);
			$nbQMu=$em->getRepository('MDQQuestionBundle:Question')->getNbQuestions(2, 1, 0, "none", "MuQuizz",  "none", "id", "ASC", 0, 1);
			$statsJ->setNbPMQ($nbPMq); 
			$statsJ->setNbPFf($nbPFf);
			$statsJ->setNbPLx($nbPLx);
			$statsJ->setNbPAr($nbPAr);
			$statsJ->setNbPMu($nbPMu);
			$statsJ->setNbPtot($nbPMq+$nbPFf+$nbPLx+$nbPAr+$nbPMu);
			$statsJ->setNbPMQbot($nbPMqbot);
			$statsJ->setNbPTotbot($nbPTotbot); 
			$statsJ->setNbUserDay($nbUserDay);
			$statsJ->setNbUser7j($nbUser7j); 
			$statsJ->setNbUser30j($nbUser30j); 
			$statsJ->setNbNewUser($nbInscritDay); 
			$statsJ->setScMoyP($scMoy); 
			$statsJ->setScMoyPbot($scMoyBot); 
			$statsJ->setNbQMqV($nbQMq); 
			$statsJ->setNbQFfV($nbQFf); 
			$statsJ->setNbQLxV($nbQLx); 
			$statsJ->setNbQArV($nbQAr); 
			$statsJ->setNbQMuV($nbQMu); 
			$statsJ->setDay($datebdd->getDay());
			$statsJ->setValid(1);		
			$statsnewJ=new StatsQuot();			
			$em->persist($statsnewJ);
			
	//************* Controle nouvelle semaine ************** /////////////////////
		$semref=$datebdd->getWeek();
		$int=$datejour->diff($semref);
		if($int->format('%a')>6){
			$tabMaitres=[null,null,null,null,null,null,null];
			$listeUser=$em->getRepository('MDQUserBundle:ScUser')
					->recupUserByCrit('kingMaster');// ****** A FAIRE PAR UNE FONCTION SIMPLIFIEE ***

			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeUser, 'KingMaster', $tabMaitres);
			$week1= new \DateInterval('P7D');
			$datebdd->getWeek()->add($week1);
			$datebdd->setWeek($datejour->add($int)->add($week1));
		}
	//****************************** Mise a jour, donnees du jour.*******************************
			$listeUserMq=$em->getRepository('MDQUserBundle:ScUser')
					->recupUserByCrit('scofDayMq');				
			
			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeUserMq, 'scofDayMq', $tabMaitres);
		
			$listeUQM=$em->getRepository('MDQUserBundle:ScUser')
							->recupUserByCrit('scofDayTM');
			GeneController::majnbJday($listeUserMq);//Mise a jour Jeton
			GeneController::majnbJday($listeUQM);//Mise a jour jeton
			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeUQM, 'TotalMedia', $tabMaitres);
			$listeUMu=$em->getRepository('MDQUserBundle:ScUser')
						->recupUserByCrit('scofDayMu');
			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeUMu, 'MuQuizz', $tabMaitres);
			$listeUAr=$em->getRepository('MDQUserBundle:ScUser')
						->recupUserByCrit('scofDayAr');
			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeUAr, 'ArQuizz', $tabMaitres);
			$listeUFf=$em->getRepository('MDQUserBundle:ScUser')
						->recupUserByCrit('scofDayFf');
			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeUFf, 'FfQuizz', $tabMaitres);
			$listeULx=$em->getRepository('MDQUserBundle:ScUser')
						->recupUserByCrit('scofDayLx');
			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeULx, 'LxQuizz', $tabMaitres);


	//************ Controle du nouveau mois **************** ////////////////////
	/*$moisactu=$datejour->format('m');
		if($moisactu!=$datebdd->getMonth()){
			$listeUser=$em->getRepository('MDQUserBundle:ScUser')
					->recupUserofMonth();		
			$i=0;$j=0;$h=0;$sc=0;$testegal=null;$tabrMDQ=[null];
			$rMDQ=null;
			foreach($listeUser as $scUser){
				$i++;
				$j=$i;//j,h et sc, servent a gerer les situations de exaeco.
				if($scUser->getSumtop10month()==$sc){$j=$h;}
				if($scUser->getHighClassMonthMq()==NULL || $j<$scUser->getHighClassMonthMq()){
				$scUser->setHighClassMonthMq($j);
				$scUser->setNumHighClassMonthMq(1);
				}
				else if($j==$scUser->getHighClassMonthMq()){			
					$scUser->setNumHighClassMonthMq($scUser->getNumHighClassMonthMq()+1);					
				}
				if($scUser->getMonthHighScMq()==NULL || $scUser->getSumtop10month()>$scUser->getMonthHighScMq()){
					$scUser->setMonthHighScMq($scUser->getSumtop10month());
				}
				$sc=$scUser->getSumtop10month();
				$h=$j;
				$scUser->setSumtop10month(NULL);
				$scUser->setTop10month([0,0,0,0,0,0,0,0,0,0]);
				if($i==1){$tabrMDQ[0]=$scUser;}
				elseif($i==2){$tabrMDQ[1]=$scUser;
							if($j==1){$testegal=1;}
				}
				elseif($i==3){$tabrMDQ[2]=$scUser;
							if($j==1){$testegal=2;}
				}			
			}
			if($testegal==2){shuffle($tabrMDQ);}			
			elseif($testegal==1){
				$tirage=mt_rand(0,1);
				if($tirage==1){$val=$tabrMDQ[1];
								$tabrMDQ[1]=$tabrMDQ[0];
								$tabrMDQ[0]=$val;
								}
			}
			$datebdd->setMonth($moisactu);
			$datebdd->setRMDQ($tabrMDQ[0]);
		}*/
	//**** mise a jour date_ref ***********************//
					
			$datebdd->setRMDQ($tabMaitres[0]);
			$datebdd->setSMDQ($tabMaitres[1]);
			$datebdd->setMMDQ($tabMaitres[2]);
			$datebdd->setMuMDQ($tabMaitres[3]);
			$datebdd->setArMDQ($tabMaitres[4]);
			$datebdd->setFfMDQ($tabMaitres[5]);
			$datebdd->setLxMDQ($tabMaitres[6]);
			$em->persist($datebdd);
		}
	// ************ flush final, execute toutes les mises a jour ******* ////
			$em->flush();
	// ************ recuperation des news a afficher ********************* ////
	// Ca me fait chier ca ne detecte par le repository de l'entite News ; je mets tout ici.
	$news=$em->createQueryBuilder();
			$news->select('n.titre, n.texte, n.dateCreate')
				->from('MDQAdminBundle:News', 'n')
				->where('n.publication = :publication')
				->setParameter('publication', true)
				->orderBy('n.priorite', 'DESC')
				->addOrderBy('n.id', 'DESC');							
	$newsA=$news->getQuery()
			    ->getResult();	

	$highScDay=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('scofDayMq',1,15);
//	$highScDayTv=$em->getRepository('MDQUserBundle:ScUser')		
//					->recupHighScore('scofDayTv',1,5);
	$highScDayLx=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('scofDayLx',1,5);
	$highScDayMu=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('scofDayMu',1,5);
	$highScDayFf=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('scofDayFf',1,5);
	$highScDayAr=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('scofDayAr',1,5);
	//$top10month=$em->getRepository('MDQUserBundle:ScUser')		
	//				->recupHighScore('sumtop10month',1,15);
	$kingMaster=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('kingMaster',1,15);
	$highScDayTM=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('scofDayTM',1,15);
	$dateref=$em->getRepository('MDQGeneBundle:DateReference')	
				->find(1);
	$tabMaitre=[$dateref->getRMDQ(),$dateref->getSMDQ(),$dateref->getMMDQ(),$dateref->getMuMDQ(),
	$dateref->getArMDQ(),$dateref->getFfMDQ(),$dateref->getLxMDQ()];
	$gestion=$em->getRepository('MDQAdminBundle:Gestion')	
				->find(1);
	return $this->render('MDQGeneBundle:Gene:accueil.html.twig', array(
      'highScDay' => $highScDay,
	  'news' => $newsA,
	//  'top10month' => $top10month,
//	  'top5weekMq' => $top5weekMq,
	//  'highScDayTv'=>$highScDayTv,
	  'kingMaster'=>$kingMaster,
	  'highScDayAr'=>$highScDayAr,
	  'highScDayMu'=>$highScDayMu,
	  'highScDayLx'=>$highScDayLx,
	  'highScDayFf'=>$highScDayFf,
	  'highScDayTM'=>$highScDayTM,
	  'tabMaitre'=>$tabMaitre,
	  'datejour'=>$datejour,//juste pour tester
	  'gestion'=>$gestion,
    ));
  }
	private function majnbJday($tabUsers)
	{
		$em=$this->getDoctrine()->getManager();
		$gestion=$em->getRepository('MDQAdminBundle:Gestion')	
				->find(1);
		foreach($tabUsers as $scUser)
		{
		    if($scUser->getNbJdayMq()<$gestion->getNbJquot())
		    {$scUser->setNbJdayMq($gestion->getNbJquot());		
			$em->persist($scUser);
		    }
		}		
		$em->flush();
		return;
	}
   public function accueilJeuAction()
  {
		$session = $this->getRequest()->getSession();
		$session->set('page', 'accueilJeu');
		$em=$this->getDoctrine()->getManager();
		$gestion=$em->getRepository('MDQAdminBundle:Gestion')	
				->find(1);
		return $this->render('MDQGeneBundle:Gene:accueilJeu.html.twig', array(
		'gestion'=>$gestion,
		));
  }
	public function accueilAdminAction()
	{
		return $this->render('MDQGeneBundle:Gene:accueilA.html.twig');	
	}
	public function accueilHighScoreAction()
	{
		$em=$this->getDoctrine()->getManager();
		$highScKM=$em->getRepository('MDQUserBundle:ScUser')
					->recupHighScore('highScKM',1,10);

		$prctBrtotMq=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('prctBrtotMq',1,10);	
		$medMq=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('MedMq',1,10);
		$medAr=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('MedAr',1,10);		
		$medKM=$em->getRepository('MDQUserBundle:ScUser')
					->recupHighScore('MedKm',1,10);
		$medLx=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('MedLx',1,10);
		$medMu=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('MedMu',1,10);
		$medFf=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('MedFf',1,10);
		$medTM=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('MedTm',1,10);
		$nbQvalid=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('nbQvalid',1,10);
		$nbBrtot=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('nbBrtot',1,10);

		
		return $this->render('MDQGeneBundle:Gene:accueilHighScore.html.twig', array(
	//	  'scTotMq' => $scTotMq,
	//	  'scMaxMq' => $scMaxMq,
	//	  'scMoyMq' => $scMoyMq,
		  'prctBrtotMq'=>$prctBrtotMq,
	//	  'nbBrtotMq'=>$nbBrtotMq,
		  'MedMq'=>$medMq,
		  'MedAr'=>$medAr,
		 'MedFf'=>$medFf,
		  'MedLx'=>$medLx,
		  'MedMu'=>$medMu,
		  'MedTm'=>$medTM,
		  'highScKm'=>$highScKM,
		  'MedKm'=>$medKM,
		  'nbQvalid'=>$nbQvalid,
		  'nbBrtot'=>$nbBrtot,
	/*	  'scofDayMq' =>$scofDayMq,
		  'sumtop10month' =>$sumtop10month,*/
		));
	}
	public function highScoreAction($crit, $page, $id)
	{
		$id_connect=0;
		if ($this->get('security.context')->isGranted('ROLE_USER')) {// ca ca marche.
			$user_connect = $this->container->get('security.context')->getToken()->getUser();
			$id_connect=$user_connect->getScUser()->getId();
		}
		//idee : imaginer un moyen de voir ou se situe le user dans ce classement
		if ($crit=="none" || $crit!="scTotMq" && $crit!="scofDayMq" && $crit!="scMoyMq" 
		&& $crit!="prctBrtotMq" && $crit!="scMaxMq" && $crit!="nbPMq" 
		&& $crit!="nbBrtotMq" && $crit!="scofDayLx" && $crit!="scofDayAr"
		&& $crit!="scofDayFf"&& $crit!="scofDayMu" && $crit!="scofDayTM"  
		&& $crit!="scMoyLx" && $crit!="scMoyAr" && $crit!="scMoyFf"&& $crit!="scMoyMu"
		&& $crit!="scMaxLx" && $crit!="scMaxAr" && $crit!="scMaxFf"&& $crit!="scMaxMu"
		&& $crit!="scMaxTM" && $crit!="kingMaster"
		&& $crit!="MedMq" && $crit!="MedKm" && $crit!="MedTm" && $crit!="MedAr" && $crit!="MedLx"
		&& $crit!="MedFf" && $crit!="MedMu" && $crit!="highScKM" && $crit!="nbQvalid"
		&& $crit!="nbBrtot" && $crit!="nbQtotMq" && $crit!="totMed"
		&& $crit!="prctBrhMq" && $crit!="prctBrgMq" && $crit!="prctBrdMq" && $crit!="prctBrslMq"
		&& $crit!="prctBralMq"&& $crit!="prctBrsnMq") 
		{//mettre none en defaut dans l'url et ensuite renvoyer sur la page d'accueil de hall of hame.	
				return $this->redirect($this->generateUrl('mdqgene_accueilHighScore'));
			}
		$nbparPage=20;
		// Reprendre tout ca : D'abord tirage de tous les highs scores, possibilite d'utliser la fonction existante avec un truc special si nb par page de 0 apr exemple.
		// puis les passer en revue et compter le rang si un id est rechercher et le nb total avec count ?
		// Enfin, prendre uniquement ceux necessaire (en fonction de la page).
		$em=$this->getDoctrine()->getManager();
		$highScoreTous=$em->getRepository('MDQUserBundle:ScUser')
							->recupHighScore($crit,1,0);
		$nbHighScore=count($highScoreTous);
		$nbPage=ceil($nbHighScore/$nbparPage);
		if($nbHighScore==0){$nbPage=1;}//gère le cas ou aucun highscore.
		if($id!=0)
		{			

			$i=0;$j=0;
			foreach($highScoreTous as $user)
			{
				if($j==0){$i++;}
				if($user['id']==$id){$j=1;}
			}
			if($j==0){$i=1;}// en fait si score du joeur pas présent, on commence par les premiers.

			$rang=$i;
			$page=ceil($rang/$nbparPage);//arrondit a l'unite superieure.
		}
		// prquoi pas : nb de questions jouees
		//Virer : ceux qui n'ont pas assez de parties jouer (prct),
		$highScores=$em->getRepository('MDQUserBundle:ScUser')
					->recupHighScore($crit,$page,$nbparPage);
	//	$nbHighScore=$em->getRepository('MDQUserBundle:ScUser')
	//				->nbHighScore($crit);// pas possible plutot de compter le nb d'objets du precedent ?


		
		$tabaide=array(
						'scofDayMq'=>'Meilleur score au MasterQuizz dans la journée en cours.',
						'scMaxMq'=>'none',
						'kingMaster'=>'Le score au KingMaster est un score hebdomadaire égal à la somme des 5 meilleurs scores du jour au Masterquizz et des meilleurs scores de la semaine dans 3 épreuves des MédiaQuizz',
						'scMoyMq'=>'Pour figurer dans ce classement, il faut avoir jouer au moins 10 parties de MasterQuizz.',
						'prctBrtotMq'=>'Pour figurer dans ce classement, il faut avoir répondu au moins à 100 questions au MasterQuizz.',
						'nbBrtotMq'=>'none',
						'scofDayLx'=>'Meilleur score au Quizz Globe dans la journée en cours.',
						'scofDayAr'=>'Meilleur score au Quizz Art dans la journée en cours.',
						'scofDayFf'=>'Meilleur score au Quizz Nature dans la journée en cours.',
						'scofDayMu'=>'Meilleur score au Quizz Musique dans la journée en cours.',
						'scMoyLx'=>'Pour figurer dans ce classement, il faut avoir jouer au moins 10 parties au Quizz "Lieux du monde".',
						'scMoyAr'=>'Pour figurer dans ce classement, il faut avoir jouer au moins 10 parties au Quizz Art.',
						'scMoyMu'=>'Pour figurer dans ce classement, il faut avoir jouer au moins 10 parties au Quizz Musique.',
						'scMoyFf'=>'Pour figurer dans ce classement, il faut avoir jouer au moins 10 parties au Quizz Nature.',
						'scMaxTM' =>'Le score "Expert Média" est la somme des meilleurs scores du jour dans 3 épreuves des Quizz Médias.',
						'scMaxLx'=>'none','scMaxFf'=>'none','scMaxMu'=>'none','scMaxAr'=>'none',
						'scofDayTM' =>'Le score "Expert Média" est la somme des meilleurs scores du jour dans 3 épreuves des Quizz Médias.',
						'scTotMq'=>'Total de tous les scores réalisés au MasterQuizz',
						'MedMq'=>'none','MedKm'=>'none','MedTm'=>'none','MedAr'=>'none','totMed'=>'none',
						'MedFf'=>'none','MedLx'=>'none','MedMu'=>'none','highScKM'=>'none',
						'nbQvalid'=>'none','nbBrtot'=>'none','nbQtotMq'=>'none',
						'prctBrhMq'=>'Pour figurer dans ce classement, il faut avoir répondu à 50 questions de la catégorie "Histoire" au MasterQuizz',
						'prctBrgMq'=>'Pour figurer dans ce classement, il faut avoir répondu à 50 questions de la catégorie "Géographie" au MasterQuizz',
						'prctBrdMq'=>'Pour figurer dans ce classement, il faut avoir répondu à 50 questions de la catégorie "Divers" au MasterQuizz',
						'prctBralMq'=>'Pour figurer dans ce classement, il faut avoir répondu à 50 questions de la catégorie "Arts et Littérature" au MasterQuizz',
						'prctBrslMq'=>'Pour figurer dans ce classement, il faut avoir répondu à 50 questions de la catégorie "Sports et loisirs" au MasterQuizz',
						'prctBrsnMq'=>'Pour figurer dans ce classement, il faut avoir répondu à 50 questions de la catégorie "Sciences et nature" au MasterQuizz',
						);
		if($crit=='scMaxMq' || $crit=='scMaxMq' || $crit=='scMaxMu' || $crit=='scMaxLx' || $crit=='scMaxFf' || $crit=='scMaxAr' || $crit=='scMaxTM' || $crit=='highScKM')
		{$linecrit1='Meilleur score';}
		elseif($crit=='MedMq' || $crit=='MedKm' || $crit=='MedTm' || $crit=='MedAr' || $crit=='MedFf' || $crit=='MedLx' || $crit=='MedMu')
		{$linecrit1='Médailles';}
		elseif($crit=='scofDayMq' || $crit=='scofDayMu' || $crit=='scofDayLx' || $crit=='scofDayFf' || $crit=='scofDayAr' || $crit=='scofDayTM')
		{$linecrit1='Score du jour';}
		elseif($crit=='scMoyMq' || $crit=='scMoyMu' || $crit=='scMoyLx' || $crit=='scMoyFf' || $crit=='scMoyAr')
		{$linecrit1='Score moyen';}
		elseif($crit=='prctBrtotMq' || $crit=='prctBrhMq' || $crit=='prctBrgMq' || $crit=='prctBrdMq' || $crit=='prctBrsnMq' || $crit=='prctBralMq' || $crit=='prctBrslMq')
		{$linecrit1='% de bonnes réponses';}		
		else
		{
			$tabcrit1=array(			
			'totMed'=>'Nombre total',
			'nbQvalid'=>'Nombre de questions ajoutées',
			'nbBrtotMq'=>'Nombre de bonnes réponses',
			'scTotMq'=>'Score total',
			'kingMaster'=>'Score actuel',
			'nbQtotMq'=>'Nombre de questions jouées',
			);		
			$linecrit1=$tabcrit1[$crit];
		}
		
		if($crit=='prctBrtotMq' || $crit=='scMoyMq' || $crit=='scMaxMq' || $crit=='scofDayMq' || $crit=='nbBrtotMq' || $crit=='scTotMq' || $crit=='MedMq' || $crit=='nbQtotMq')
		{$linecrit2='au MasterQuizz';}
		elseif($crit=='scofDayLx' || $crit=='scMoyLx' || $crit=='scMaxLx' || $crit=='MedLx')
		{$linecrit2='au Quizz Lieux du monde';}
		elseif($crit=='scofDayMu' || $crit=='scMoyMu' || $crit=='scMaxMu' || $crit=='MedMu')
		{$linecrit2='au Quizz Musique';}
		elseif($crit=='scofDayFf' || $crit=='scMoyFf' || $crit=='scMaxFf' || $crit=='MedFf')
		{$linecrit2='au Quizz Nature';}
		elseif($crit=='scofDayAr' || $crit=='scMoyAr' || $crit=='scMaxAr' || $crit=='MedAr')
		{$linecrit2='au Quizz Art';}
		elseif($crit=='scofDayTM' || $crit=='scMaxTM' || $crit=='MedTM')
		{$linecrit2='Expert Média';}
		elseif($crit=='kingMaster' || $crit=='highScKM' || $crit=='MedKm')
		{$linecrit2='au KingMaster';}
		else
		{
			$tabcrit=array(			
			'totMed'=>'de médailles',
			'nbQvalid'=>'dans la base de données',
			'nbBrtot'=>'de bonnes réponses',
			'prctBrhMq'=>'catégorie Histoire',
			'prctBrgMq'=>'catégorie Géographie',
			'prctBrdMq'=>'catégorie Divers',
			'prctBralMq'=>'catégorie Arts et Littérature',
			'prctBrslMq'=>'catégorie Sports et loisirs',
			'prctBrsnMq'=>'catégorie Sciences et nature',
			);		
			$linecrit2=$tabcrit[$crit];
		}
		$aide=$tabaide[$crit];
		return $this->render('MDQGeneBundle:Gene:highScore.html.twig', array(
		  'scusers' => $highScores,
		  'page' => $page,
		  'nombrePage' => $nbPage,
		  'crit'=>$crit,
		  'aide'=>$aide,
		  'linecrit1'=>$linecrit1,
		  'linecrit2'=>$linecrit2,
		  'nbparPage' =>$nbparPage,
		  'id_search'=>$id,
		  'id_connect'=>$id_connect,
		//  'rang'=>$rang,
		));
	
	//	return $this->render('MDQGeneBundle:Gene:test.html.twig', array(
	//	  'rang' => $rang,
	//	));
	}
	public function regleJeuAction()
	{
		return $this->render('MDQGeneBundle:Gene:regleJeu.html.twig');
	}
	public function afficheNewsAction()
	{
		$em=$this->getDoctrine()->getManager();
			$news=$em->createQueryBuilder();
			$news->select('n.titre, n.texte, n.dateCreate')
				->from('MDQAdminBundle:News', 'n')
				->where('n.publication = :publication')
				->setParameter('publication', true)
				->orderBy('n.priorite', 'DESC')
				->addOrderBy('n.id', 'DESC');							
			$newsA=$news->getQuery()
			    ->getResult();	
		return $this->render('MDQGeneBundle:Gene:news.html.twig', array(
		'news'=>$newsA
		));
	}
}
