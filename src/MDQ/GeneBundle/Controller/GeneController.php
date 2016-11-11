<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\GeneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\QuizzBundle\Entity\PartieQuizz;
use MDQ\AdminBundle\Entity\News;
use MDQ\GeneBundle\Entity\DateReference;
use MDQ\GeneBundle\Entity\StatsQuot;
use Symfony\Component\HttpFoundation\Request;


class GeneController extends Controller
{
  public function accueilAction()
  {// Rq, je n'ai mis aucun persist et ça marche quand même ! A étudier.
    $session = $this->getRequest()->getSession();
	$session->set('page', 'accueil');	
	$em=$this->getDoctrine()->getManager();
	/* Remarque : mise à jour journée et mois en même temps que maj jur partie non validées, du coup si partie non validée en fin de journée, ou si aucune connection ensuite,
	Elle s'inscrit comme parte jouée le lendemain quelque soit l'heure où elle est jouée. A CORRIGER
	En fait il suffir juste de mettre la partie test de la date après celle de la validation de la partie*/
	// MODIF EFFECTUEE : A tester puis effacer le passage précédent.
	// ******** Contrôle des parties en bdd et validation le cas échéant + mise à jours de bdd user et partie
	$partieNonValide=$em->getRepository('MDQQuizzBundle:PartieQuizz')
				->recupPNonValid();
		foreach ($partieNonValide as $partie){
			$intcontrol = new \DateInterval('PT10M');// Définition d'un intervalle de 10 minutes
			$dateactu= new \DateTime();
			$datepartie=$partie->getDate();
			//$intreel=new \DateInterval();
			//$intreel=$dateactu->diff($datepartie);
			if($dateactu->sub($intcontrol)>$datepartie){
				$partie->setValid(true);
				$user=$partie->getUser();
				$scUser=$user->getScUser();
				$game=$partie->getType();
				if($game=='MasterQuizz'){$dom1='none';}
				else{$dom1=$game;
					$game='MediaQuizz';}
				$majbddscU=$em->getRepository('MDQUserBundle:ScUser')
							->majBddScfinP($scUser, $dom1, $game, $partie);

			}
		}
	// ********** Contrôle de nouvelle journée -- A terme à remplacer par un CRON ******** ///
	$datejour= new \DateTime(date('Y-m-d'));
		//Reste un petit pb avec l'objet date : si pas de connexion le lundi, mais le mardi, la date de Maj de la datebdd jour est celle du début de semane, ce qui conduit à une maj automatique du jour lors de l'arrivée suivante sur la page d'accueil.
		$datebdd=$em->getRepository('MDQGeneBundle:DateReference')->find(1);
		$tabrMDQ[0]=$datebdd->getRMDQ();
		$tabMaitres=[$datebdd->getRMDQ(), null,null,null,null,null,null];
		if($datebdd->getDay()!=$datejour){
			$datebdd->setDay($datejour);// Je le mets là ; si je le mets après l'opération sub dateInter, l'interval est déduit de la date entrée en bdd -jsp pourquoi.
			//*************************Mise à jour de la bdd StatsQuot****************** ///
			// A voir ou le placer.
			$statsJ=$em->getRepository('MDQGeneBundle:StatsQuot')->findOneBy(array('valid'=>0));
			if($datebdd->getRMDQ()!=null){$statsJ->setRMDQ($datebdd->getRMDQ()->getId());}
			if($datebdd->getMMDQ()!=null){$statsJ->setMMDQ($datebdd->getMMDQ()->getId());}
			if($datebdd->getSMDQ()!=null){$statsJ->setSMDQ($datebdd->getSMDQ()->getId());}
			if($datebdd->getFfMDQ()!=null){$statsJ->setFfMDQ($datebdd->getFfMDQ()->getId());}
			if($datebdd->getLxMDQ()!=null){$statsJ->setLxMDQ($datebdd->getLxMDQ()->getId());}
			if($datebdd->getArMDQ()!=null){$statsJ->setArMDQ($datebdd->getArMDQ()->getId());}
			if($datebdd->getMuMDQ()!=null){$statsJ->setMuMDQ($datebdd->getMuMDQ()->getId());}
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
			
	//************* Contrôle nouvelle semaine ************** /////////////////////
		$semref=$datebdd->getWeek();
		$int=$datejour->diff($semref);
		if($int->format('%a')>6){
			$tabMaitres=[null,null,null,null,null,null,null];
			$listeUser=$em->getRepository('MDQUserBundle:ScUser')
					->recupUserByCrit('kingMaster');// ****** A FAIRE PAR UNE FONCTION SIMPLIFIEE ***

			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeUser, 'KingMaster', $tabMaitres);
			$week1= new \DateInterval('P7D');
			$newW=$datebdd->getWeek()->add($week1);
			$datebdd->setWeek($datejour->add($int)->add($week1));
		}
	//****************************** Mise à jour, données du jour.*******************************
			$listeUserMq=$em->getRepository('MDQUserBundle:ScUser')
					->recupUserByCrit('scofDayMq');				
			
			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeUserMq, 'scofDayMq', $tabMaitres);
		
			$listeUQM=$em->getRepository('MDQUserBundle:ScUser')
							->recupUserByCrit('scofDayTM');
			GeneController::majnbJday($listeUserMq);//Mise à jour Jeton
			GeneController::majnbJday($listeUQM);//Mise à jour jeton
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


	//************ Contrôle du nouveau mois **************** ////////////////////
	/*$moisactu=$datejour->format('m');
		if($moisactu!=$datebdd->getMonth()){
			$listeUser=$em->getRepository('MDQUserBundle:ScUser')
					->recupUserofMonth();		
			$i=0;$j=0;$h=0;$sc=0;$testegal=null;$tabrMDQ=[null];
			$rMDQ=null;
			foreach($listeUser as $scUser){
				$i++;
				$j=$i;//j,h et sc, servent à gérer les situations de exaeco.
				if($scUser->getSumtop10month()==$sc){$j=$h;}
				if($scUser->getHighClassMonthMq()==NULL OR $j<$scUser->getHighClassMonthMq()){
				$scUser->setHighClassMonthMq($j);
				$scUser->setNumHighClassMonthMq(1);
				}
				else if($j==$scUser->getHighClassMonthMq()){			
					$scUser->setNumHighClassMonthMq($scUser->getNumHighClassMonthMq()+1);					
				}
				if($scUser->getMonthHighScMq()==NULL OR $scUser->getSumtop10month()>$scUser->getMonthHighScMq()){
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
	//**** mise à jour date_ref ***********************//
					
			$datebdd->setRMDQ($tabMaitres[0]);
			$datebdd->setSMDQ($tabMaitres[1]);
			$datebdd->setMMDQ($tabMaitres[2]);
			$datebdd->setMuMDQ($tabMaitres[3]);
			$datebdd->setArMDQ($tabMaitres[4]);
			$datebdd->setFfMDQ($tabMaitres[5]);
			$datebdd->setLxMDQ($tabMaitres[6]);
			$em->persist($datebdd);
		}
	// ************ flush final, exécute toutes les mises à jour ******* ////
			$em->flush();
	// ************ recuperation des news à afficher ********************* ////
	// Ca me fait chier ca ne détecte par le repository de l'entité News ; je mets tout ici.
	$news=$em->createQueryBuilder();
			$news->select('n.titre, n.texte, n.dateCreate')
				->from('MDQAdminBundle:News', 'n')
				->where('n.publication = :publication')
				->setParameter('publication', true)
				->orderBy('n.priorite', 'DESC')
				->addOrderBy('n.id', 'DESC');							
	$newsA=$news->getQuery()
			    ->getResult();	
	/*$news=$em->getRepository('MDQAdminBundle:News')	
		    ->recupNews();*/
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
	/*	$scTotMq=$em->getRepository('MDQUserBundle:ScUser')
					->recupHighScore('scTotMq',1,10);
		$scMaxMq=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('scMaxMq',1,10);
		$scMoyMq=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('scMoyMq',1,10);
		$nbBrtotMq=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('nbBrtotMq',1,10);
	*/	$prctBrtotMq=$em->getRepository('MDQUserBundle:ScUser')		
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
/*		$nbPMq=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('nbPMq',1,5);
		$scofDayMq=$em->getRepository('MDQUserBundle:ScUser')		
					->recupHighScore('scofDayMq',1,5);*/
		
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
		if ($this->get('security.context')->isGranted('ROLE_USER')) {// ça ça marche.
			$user_connect = $this->container->get('security.context')->getToken()->getUser();
			$id_connect=$user_connect->getScUser()->getId();
		}
		//idée : imaginer un moyen de voir ou se situe le user dans ce classement
		if ($crit=="none" OR $crit!="scTotMq" AND $crit!="scofDayMq" AND $crit!="scMoyMq" 
		AND $crit!="prctBrtotMq" AND $crit!="scMaxMq" AND $crit!="nbPMq" 
		AND $crit!="nbBrtotMq" AND $crit!="scofDayLx" AND $crit!="scofDayAr"
		AND $crit!="scofDayFf"AND $crit!="scofDayMu" AND $crit!="scofDayTM"  
		AND $crit!="scMoyLx" AND $crit!="scMoyAr" AND $crit!="scMoyFf"AND $crit!="scMoyMu"
		AND $crit!="scMaxLx" AND $crit!="scMaxAr" AND $crit!="scMaxFf"AND $crit!="scMaxMu"
		AND $crit!="scMaxTM" AND $crit!="kingMaster"
		AND $crit!="MedMq" AND $crit!="MedKm" AND $crit!="MedTm" AND $crit!="MedAr" AND $crit!="MedLx"
		AND $crit!="MedFf" AND $crit!="MedMu" AND $crit!="highScKM" AND $crit!="nbQvalid"
		AND $crit!="nbBrtot" AND $crit!="nbQtotMq" AND $crit!="totMed"
		AND $crit!="prctBrhMq" AND $crit!="prctBrgMq" AND $crit!="prctBrdMq" AND $crit!="prctBrslMq"
		AND $crit!="prctBralMq"AND $crit!="prctBrsnMq") 
		{//mettre none en défaut dans l'url et ensuite renvoyer sur la page d'accueil de hall of hame.	
				return $this->redirect($this->generateUrl('mdqgene_accueilHighScore'));
			}
		$nbparPage=20;
		// Reprendre tout ça : D'abord tirage de tous les highs scores, possibilité d'utliser la fonction existante avec un truc spécial si nb par page de 0 apr exemple.
		// puis les passer en revue et compter le rang si un id est rechercher et le nb total avec count ?
		// Enfin, prendre uniquement ceux nécessaire (en fonction de la page).
		$em=$this->getDoctrine()->getManager();
		$highScoreTous=$em->getRepository('MDQUserBundle:ScUser')
							->recupHighScore($crit,1,0);
		$nbHighScore=count($highScoreTous);
		$nbPage=ceil($nbHighScore/$nbparPage);
		if($nbHighScore==0){$nbPage=1;}//gÃ¨re le cas ou aucun highscore.
		if($id!=0)
		{			
			$scUser=$em->getRepository('MDQUserBundle:ScUser')
						->findOneById($id);			
//			$rang=$em->getRepository('MDQUserBundle:ScUser')
//						->rangScofDay2($crit, $scUser);
			$i=0;$j=0;
			foreach($highScoreTous as $user)
			{
				if($j==0){$i++;}
				if($user['id']==$id){$j=1;}
			}
			if($j==0){$i=1;}// en fait si score du joeur pas prÃ©sent, on commence par les premiers.

			$rang=$i;
			$page=ceil($rang/$nbparPage);//arrondit à l'unité supérieure.
		}
		// prquoi pas : nb de questions jouées
		//Virer : ceux qui n'ont pas assez de parties jouer (prct),
		$highScores=$em->getRepository('MDQUserBundle:ScUser')
					->recupHighScore($crit,$page,$nbparPage);
	//	$nbHighScore=$em->getRepository('MDQUserBundle:ScUser')
	//				->nbHighScore($crit);// pas possible plutot de compter le nb d'objets du précédent ?


		
		$tabaide=array(
						'scofDayMq'=>'Meilleur score au MasterQuizz dans la journÃ©e en cours.',
						'scMaxMq'=>'none',
						'kingMaster'=>'Le score au KingMaster est un score hebdomadaire Ã©gal Ã  la somme des 5 meilleurs scores du jour au Masterquizz et des meilleurs scores de la semaine dans 3 Ã©preuves des MÃ©diaQuizz',
						'scMoyMq'=>'Pour figurer dans ce classement, il faut avoir jouer au moins 10 parties de MasterQuizz.',
						'prctBrtotMq'=>'Pour figurer dans ce classement, il faut avoir rÃ©pondu au moins Ã  100 questions au MasterQuizz.',
						'nbBrtotMq'=>'none',
						'scofDayLx'=>'Meilleur score au Quizz Globe dans la journÃ©e en cours.',
						'scofDayAr'=>'Meilleur score au Quizz Art dans la journÃ©e en cours.',
						'scofDayFf'=>'Meilleur score au Quizz Nature dans la journÃ©e en cours.',
						'scofDayMu'=>'Meilleur score au Quizz Musique dans la journÃ©e en cours.',
						'scMoyLx'=>'Pour figurer dans ce classement, il faut avoir jouer au moins 10 parties au Quizz "Lieux du monde".',
						'scMoyAr'=>'Pour figurer dans ce classement, il faut avoir jouer au moins 10 parties au Quizz Art.',
						'scMoyMu'=>'Pour figurer dans ce classement, il faut avoir jouer au moins 10 parties au Quizz Musique.',
						'scMoyFf'=>'Pour figurer dans ce classement, il faut avoir jouer au moins 10 parties au Quizz Nature.',
						'scMaxTM' =>'Le score "Expert MÃ©dia" est la somme des meilleurs scores du jour dans 3 Ã©preuves des Quizz MÃ©dias.',
						'scMaxLx'=>'none','scMaxFf'=>'none','scMaxMu'=>'none','scMaxAr'=>'none',
						'scofDayTM' =>'Le score "Expert MÃ©dia" est la somme des meilleurs scores du jour dans 3 Ã©preuves des Quizz MÃ©dias.',
						'scTotMq'=>'Total de tous les scores rÃ©alisÃ©s au MasterQuizz',
						'MedMq'=>'none','MedKm'=>'none','MedTm'=>'none','MedAr'=>'none','totMed'=>'none',
						'MedFf'=>'none','MedLx'=>'none','MedMu'=>'none','highScKM'=>'none',
						'nbQvalid'=>'none','nbBrtot'=>'none','nbQtotMq'=>'none',
						'prctBrhMq'=>'Pour figurer dans ce classement, il faut avoir rÃ©pondu Ã  50 questions de la catÃ©gorie "Histoire" au MasterQuizz',
						'prctBrgMq'=>'Pour figurer dans ce classement, il faut avoir rÃ©pondu Ã  50 questions de la catÃ©gorie "GÃ©ographie" au MasterQuizz',
						'prctBrdMq'=>'Pour figurer dans ce classement, il faut avoir rÃ©pondu Ã  50 questions de la catÃ©gorie "Divers" au MasterQuizz',
						'prctBralMq'=>'Pour figurer dans ce classement, il faut avoir rÃ©pondu Ã  50 questions de la catÃ©gorie "Arts et LittÃ©rature" au MasterQuizz',
						'prctBrslMq'=>'Pour figurer dans ce classement, il faut avoir rÃ©pondu Ã  50 questions de la catÃ©gorie "Sports et loisirs" au MasterQuizz',
						'prctBrsnMq'=>'Pour figurer dans ce classement, il faut avoir rÃ©pondu Ã  50 questions de la catÃ©gorie "Sciences et nature" au MasterQuizz',
						);
		if($crit=='scMaxMq' or $crit=='scMaxMq' or $crit=='scMaxMu' or $crit=='scMaxLx' or $crit=='scMaxFf' or $crit=='scMaxAr' or $crit=='scMaxTM' or $crit=='highScKM')
		{$linecrit1='Meilleur score';}
		elseif($crit=='MedMq' or $crit=='MedKm'or $crit=='MedTm' or $crit=='MedAr' or $crit=='MedFf' or $crit=='MedLx' or $crit=='MedMu')
		{$linecrit1='MÃ©dailles';}
		elseif($crit=='scofDayMq' or $crit=='scofDayMu' or $crit=='scofDayLx' or $crit=='scofDayFf' or $crit=='scofDayAr' or $crit=='scofDayTM')
		{$linecrit1='Score du jour';}
		elseif($crit=='scMoyMq' or $crit=='scMoyMu' or $crit=='scMoyLx' or $crit=='scMoyFf' or $crit=='scMoyAr')
		{$linecrit1='Score moyen';}
		elseif($crit=='prctBrtotMq' or $crit=='prctBrhMq' or $crit=='prctBrgMq' or $crit=='prctBrdMq' or $crit=='prctBrsnMq' or $crit=='prctBralMq' or $crit=='prctBrslMq')
		{$linecrit1='% de bonnes rÃ©ponses';}		
		else
		{
			$tabcrit1=array(			
			'totMed'=>'Nombre total',
			'nbQvalid'=>'Nombre de questions ajoutÃ©es',
			'nbBrtotMq'=>'Nombre de bonnes rÃ©ponses',
			'scTotMq'=>'Score total',
			'kingMaster'=>'Score actuel',
			'nbQtotMq'=>'Nombre de questions jouÃ©es',
			);		
			$linecrit1=$tabcrit1[$crit];
		}
		
		if($crit=='prctBrtotMq' or $crit=='scMoyMq' or $crit=='scMaxMq' or $crit=='scofDayMq' or $crit=='nbBrtotMq' or $crit=='scTotMq' or $crit=='MedMq' or $crit=='nbQtotMq')
		{$linecrit2='au MasterQuizz';}
		elseif($crit=='scofDayLx' or $crit=='scMoyLx' or $crit=='scMaxLx' or $crit=='MedLx')
		{$linecrit2='au Quizz Lieux du monde';}
		elseif($crit=='scofDayMu' or $crit=='scMoyMu' or $crit=='scMaxMu' or $crit=='MedMu')
		{$linecrit2='au Quizz Musique';}
		elseif($crit=='scofDayFf' or $crit=='scMoyFf' or $crit=='scMaxFf' or $crit=='MedFf')
		{$linecrit2='au Quizz Nature';}
		elseif($crit=='scofDayAr' or $crit=='scMoyAr' or $crit=='scMaxAr' or $crit=='MedAr')
		{$linecrit2='au Quizz Art';}
		elseif($crit=='scofDayTM' or $crit=='scMaxTM' or $crit=='MedTM')
		{$linecrit2='Expert MÃ©dia';}
		elseif($crit=='kingMaster' or $crit=='highScKM' or $crit=='MedKm')
		{$linecrit2='au KingMaster';}
		else
		{
			$tabcrit=array(			
			'totMed'=>'de mÃ©dailles',
			'nbQvalid'=>'dans la base de donnÃ©es',
			'nbBrtot'=>'de bonnes rÃ©ponses',
			'prctBrhMq'=>'catÃ©gorie Histoire',
			'prctBrgMq'=>'catÃ©gorie GÃ©ographie',
			'prctBrdMq'=>'catÃ©gorie Divers',
			'prctBralMq'=>'catÃ©gorie Arts et LittÃ©rature',
			'prctBrslMq'=>'catÃ©gorie Sports et loisirs',
			'prctBrsnMq'=>'catÃ©gorie Sciences et nature',
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