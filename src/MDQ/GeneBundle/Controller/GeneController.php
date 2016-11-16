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
		$id_connect=0;$nbparPage=20;
		if ($this->get('security.context')->isGranted('ROLE_USER')) {// ca ca marche.
			$user_connect = $this->container->get('security.context')->getToken()->getUser();
			$id_connect=$user_connect->getScUser()->getId();
		}
		$highScServ = $this->container->get('mdq_gene.services');
		$data=$highScServ->editTxt($crit);
		if ($data['crit']=="none") {return $this->redirect($this->generateUrl('mdqgene_accueilHighScore'));}		
		$em=$this->getDoctrine()->getManager();
		$highScoreTous=$em->getRepository('MDQUserBundle:ScUser')->recupHighScore($crit,1,0);
		$nbHighScore=count($highScoreTous);
		if($id!=0){$page=$highScServ->defPage($id, $highScoreTous, $nbparPage);}
		$pagi=$highScServ->pagination($nbparPage, $nbHighScore, $page);
		$highScores=$em->getRepository('MDQUserBundle:ScUser')->recupHighScore($crit,$page,$nbparPage);
		      return $this->render('MDQGeneBundle:Gene:HighScore/'.$data['nomPage'].'.html.twig', array(
		      'scusers' => $highScores,
		      'pagi' => $pagi,
		      'data' => $data,
		      'id_search'=>$id,
		      'id_connect'=>$id_connect,
		      ));
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
