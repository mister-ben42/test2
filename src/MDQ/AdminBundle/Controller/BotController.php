<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\UserBundle\Entity\User;
use MDQ\QuizzBundle\Entity\PartieQuizz;

class BotController extends Controller
{
	public function botPartieAction($nbBots,$djajoue,$type)
	{
		$em=$this->getDoctrine()->getManager();
		$botsSelects2=$em->getRepository('MDQUserBundle:ScUser')
						 ->getBot($djajoue);//renvoit les id des bots de tous ou de ceux qui n'ont pas encore joué au Mq
		$nbBotsSelect=count($botsSelects2);
		if($nbBotsSelect==0){return $this->redirect($this->generateUrl('mdqadmin_accueilAdmin'));}
		if($nbBots>$nbBotsSelect){$nbBots=$nbBotsSelect;}
		$botsSelects=$em->getRepository('MDQUserBundle:User')
						 ->getBots($nbBots,$nbBotsSelect,$botsSelects2);
		$tabParties=[];$j=0;
		foreach($botsSelects as $bot)
		{
			if($type=="Mq" || $type=="Tous")
			{
				$partieMq=BotController::botgameMq($bot);
				$tabParties[$j]=$partieMq;
				$j++;
			}
			
			if($type=="QM" || $type=="Tous")
			{
				$partieMq=BotController::botgameQM($bot);
				$tabParties[$j]=$partieMq;
				$j++;	
			}
		}
		
		return $this->render('MDQAdminBundle:Admin:botPartie.html.twig', array(
			'Parties' => $tabParties,
			'Bots2'=> $botsSelects2,
			'nbBotsSelect'=>$nbBotsSelect,
		));
	}

	private function calcScQ($scoreB)// Pour partie bot
	{
		$tabtpsrep=[3,4,6,10];
		$tpsrep=15-$tabtpsrep[mt_rand(0,3)];				
		$bonus=round(($scoreB/2*$tpsrep/15),0);
		$scoreQ=$scoreB+$bonus;
		return $scoreQ;
	}
	private function botgameMq(User $bot)
	{
			$em=$this->getDoctrine()->getManager();
			$gestion=$em->getRepository('MDQAdminBundle:Gestion')	
				->find(1);
			if($gestion->getMq()==0){return ;}
			$tabPartie['bot']=$bot->getUsername();
			$tabdom3=[]; $tabtheme=[]; $tabidQ=[];$tabdom=['x','x','x']; $derQjoues=[];
			$tabscore=[100,200,500,1000,2000]; $tabdiff=[1,2,2,3,3,3,4,4,5,5]; $score=0;
			$scUser=$bot->getScUser();			
			$NbQtot=$scUser->getNbQtotMq();	$NbBrtot=$scUser->getNbBrtotMq();
			$NbQH=$scUser->getNbQhMq();	$NbBrH=$scUser->getNbBrhMq();$NbQG=$scUser->getNbQgMq();	$NbBrG=$scUser->getNbBrgMq();
			$NbQD=$scUser->getNbQdMq();	$NbBrD=$scUser->getNbBrdMq(); $NbQAL=$scUser->getNbQalMq();$NbBrAL=$scUser->getNbBralMq();
			$NbQSL=$scUser->getNbQslMq();$NbBrSL=$scUser->getNbBrslMq();$NbQSN=$scUser->getNbQsnMq();$NbBrSN=$scUser->getNbBrsnMq();
			$nbBrtot=$scUser->getNbBrtot();
			for($numQ=1; $numQ<11; $numQ++) {
				$NbQtot++; $scoreQ=0;
				$dom=$em->getRepository('MDQQuizzBundle:PartieQuizz')
							->tiragedudom($tabdom);
				$qtire=$em->getRepository('MDQQuestionBundle:Question')
							 ->tirageduneQMq($numQ, $dom[0], $tabdom3, $tabtheme, $derQjoues, $tabidQ);							 
				$tabdom=$dom; $tabidQ[$numQ-1]=$qtire['id'];$tabdom3[$numQ-1]=$qtire['dom3'];$tabtheme[$numQ-1]=$qtire['theme'];
				//simulation de résultat et de score
				$tabcoef=$scUser->getTabCoefBot();
				$tabdom1=array('Histoire'=>0, 'Géographie'=>1, 'Sciences et nature'=>2, 'Arts et Littérature'=>3, 'Sports et loisirs'=>4, 'Divers'=>5);
				$coefa=$tabcoef[$tabdom1[$dom[0]]];
				$tabcoeffdiff=[1.5,1,0.75,0.50,0.30];				
				$coefb=25+$coefa*$tabcoeffdiff[($tabdiff[$numQ-1])-1];
				$coefs=array(0=>(100-$coefb),1=>$coefb);
				$bRep=BotController::rand_coef($coefs);
				if($bRep==1){
					$nbBrtot++;
					$scdebase=$tabscore[($tabdiff[$numQ-1])-1];
					$scoreQ=BotController::calcScQ($scdebase);
					$score=$score+$scoreQ;
					$NbBrtot=$NbBrtot+1;
				}
				$tabPartie['scQ'.$numQ]=$scoreQ;
				if ($dom[0]=='Histoire') {				
					$NbQH=$NbQH+1;				
					if ($bRep==1){$NbBrH=$NbBrH+1;}
				}
				if ($dom[0]=='Géographie') {
					$NbQG=$NbQG+1;				
					if ($bRep==1){$NbBrG=$NbBrG+1;}
				}						
				if ($dom[0]=='Divers'){
					$NbQD=$NbQD+1;				
					if ($bRep==1){$NbBrD=$NbBrD+1;}
				}			
				if ($dom[0]=='Arts et Littérature'){
					$NbQAL=$NbQAL+1;				
					if ($bRep==1){$NbBrAL=$NbBrAL+1;}
				}
				if ($dom[0]=='Sports et loisirs'){
					$NbQSL=$NbQSL+1;				
					if ($bRep==1){$NbBrSL=$NbBrSL+1;}
				}
				if ($dom[0]=='Sciences et nature'){
					$NbQSN=$NbQSN+1;				
					if ($bRep==1){$NbBrSN=$NbBrSN+1;}
				}
			}
			
			// FINALISATION / partie et Sc et Bdd.
			$pseudo=$bot->getUsername();
			$partie=new PartieQuizz(); 
			$partie->setUsername($pseudo);
			$partie->setQ1($tabidQ[0])->setQ2($tabidQ[1])->setQ3($tabidQ[2])->setQ4($tabidQ[3])->setQ5($tabidQ[4])->setQ6($tabidQ[5])->setQ7($tabidQ[6])->setQ8($tabidQ[7])->setQ9($tabidQ[8])->setQ10($tabidQ[9]);		
			$partie->setUser($bot)->setScore($score)->setValid(true)->setType('MasterQuizz');
			
			$bot->setLastLogin(new \Datetime());
			$scUser->setNbPMq($scUser->getNbPMq()+1);
			$scUser->setNbQtotMq($NbQtot)->setNbBrtotMq($NbBrtot)->setPrctBrtotMq($NbBrtot*100/$NbQtot);
			if ($NbQH!=0){$scUser->setNbQhMq($NbQH)->setNbBrhMq($NbBrH)->setPrctBrhMq($NbBrH*100/$NbQH);}
			if ($NbQG!=0){$scUser->setNbQgMq($NbQG)->setNbBrgMq($NbBrG)->setPrctBrgMq($NbBrG*100/$NbQG);}
			if ($NbQD!=0){$scUser->setNbQdMq($NbQD)->setNbBrdMq($NbBrD)->setPrctBrdMq($NbBrD*100/$NbQD);}
			if ($NbQSN!=0){$scUser->setNbQsnMq($NbQSN)->setNbBrsnMq($NbBrSN)->setPrctBrsnMq($NbBrSN*100/$NbQSN);}
			if ($NbQSL!=0){$scUser->setNbQslMq($NbQSL)->setNbBrslMq($NbBrSL)->setPrctBrslMq($NbBrSL*100/$NbQSL);}
			if ($NbQAL!=0){$scUser->setNbQalMq($NbQAL)->setNbBralMq($NbBrAL)->setPrctBralMq($NbBrAL*100/$NbQAL);}
			$scUser->setNbBrtot($nbBrtot);
			$em->getRepository('MDQUserBundle:ScUser')
						->majBddScfinP($scUser, 'MasterQuizz', 'MasterQuizz', $partie);
	/*	+ 	$scTot=$scUser->getScTotMq()+$score;
		+	$scUser->setScTotMq($scTot);
		+	$scUser->setScMoyMq($scTot/$scUser->getNbPMq());
		+	if($scUser->getScofDayMq()==NULL OR $score>$scUser->getScofDayMq()){
		+			$scUser->setScofDayMq($score);
		+	}
		+	if($score>$scUser->getScMaxMq()){
		+			$scUser->setScMaxMq($score);
		+			$scUser->setDatescMaxMq($partie->getDate());
		+	}
		+	$top5weekMq=$scUser->getTop5weekMq();
		+	if($score>$top5weekMq[0]){
		+		$top5weekMq[0]=$score;
		+		$scUser->setTop5weekMq($top5weekMq);
		+		$scUser->setSumtop5weekMq(array_sum($top5weekMq));
		+		if($scUser->getHightop5weekMq()==null OR $score>$scUser->getHightop5weekMq()){
		+			$scUser->setHightop5weekMq($score);
		+			}
		+	}
		+	$top10mois=$scUser->getTop10month();
		+	if($score>$top10mois[0]){
		+		$top10mois[0]=$score;
		+		$scUser->setTop10month($top10mois);
		+		$scUser->setSumtop10month(array_sum($top10mois));
		+	}*/
			$em->persist($scUser);
			$em->persist($partie);
			$em->flush();
			$tabPartie['sctot']=$score;
			$tabPartie['game']="MasterQuizz";
			return $tabPartie;
	}

	private function botgameQM(User $bot)
	{
			$em=$this->getDoctrine()->getManager();
			$scUser=$bot->getScUser();
			$gestion=$em->getRepository('MDQAdminBundle:Gestion')	
				->find(1);
			$GFf=$gestion->getFf(); $GLx=$gestion->getLx(); $GMc=$gestion->getMc(); $GAr=$gestion->getAr();
			if($GFf+$GLx+$GMc+$GAr==0){return;}
			 $tab4game=['MuQuizz','ArQuizz','FfQuizz','LxQuizz'];
			 $tabGestion=[$GMc,$GAr,$GFf,$GLx];
			 $nbG=0;
			 $tabgame=[];
			for($i=0; $i<4; $i++)
			{
			    if($tabGestion[$i]==1){
				  $nbG++;
				  array_push($tabgame,$tab4game[$i]);
				  }
			}
			 
			 $nb=mt_rand(0,$nbG-1);
			
			$game=$tabgame[$nb];
			//$game='MuQuizz';// Pour forcer le tirage de MuQuizz
			$tabPartie2['bot']=$bot->getUsername();
			$tabPartie2['game']=$game;
			$tabcoef=$scUser->getTabCoefBot();
			if($game=='MuQuizz'){$coefJ=$tabcoef[6];}
			else if($game=='ArQuizz'){$coefJ=$tabcoef[7];}
			else if($game=='FfQuizz'){$coefJ=$tabcoef[8];}
			else if($game=='LxQuizz'){$coefJ=$tabcoef[9];}
			$coefs=array(0=>(100-$coefJ),1=>$coefJ);
			$tabtheme=['x','x'];$tabidQ=[];$tabDerQ=[];$scoreP=0; $tabdom3=['x','x','x'];
			$nbQAr=$scUser->getNbQAr();	$nbBrAr=$scUser->getNbBrAr();
			$nbQFf=$scUser->getNbQFf();	$nbBrFf=$scUser->getNbBrFf();
			$nbQLx=$scUser->getNbQLx();	$nbBrLx=$scUser->getNbBrLx();
			$nbQMu=$scUser->getNbQMu();	$nbBrMu=$scUser->getNbBrMu();
			$nbBrtot=$scUser->getNbBrtot();
			for($numQ=1; $numQ<9; $numQ++)
			{
				$qtire=$em->getRepository('MDQQuestionBundle:Question')
							->tirageduneQ($game,$tabDerQ,$tabtheme,$tabdom3,$tabidQ, $numQ);
				$tabidQ[($numQ-1)]=$qtire['id'];
				$rep=BotController::rand_coef($coefs);
				if($rep==1){$nbBrtot++;}
				if($game=='ArQuizz'){	
					$nbQAr++; $scoreQ=0;
					if($rep==1){$nbBrAr++;$scoreQ=BotController::calcScQ(1000);$scoreP=$scoreP+$scoreQ;}					
				}
				if($game=='FfQuizz'){	
					$nbQFf++; $scoreQ=0;
					if($rep==1){$nbBrFf++;$scoreQ=BotController::calcScQ(1000);$scoreP=$scoreP+$scoreQ;}					
				}
				if($game=='LxQuizz'){	
					$nbQLx++; $scoreQ=0;
					if($rep==1){$nbBrLx++;$scoreQ=BotController::calcScQ(1000);$scoreP=$scoreP+$scoreQ;}					
				}
				if($game=='MuQuizz'){	
					$nbQMu++; $scoreQ=0;
					if($rep==1){$nbBrMu++;$scoreQ=BotController::calcScQ(1000);$scoreP=$scoreP+$scoreQ;}					
				}
				$tabPartie2['scQ'.$numQ]=$scoreQ;
			}	
			if($game=='ArQuizz')
			{
				$scUser->setNbPAr($scUser->getNbPAr()+1);
				$scUser->setNbQAr($nbQAr);
				$scUser->setNbBrAr($nbBrAr);
				$scUser->setPrctBrAr($nbBrAr*100/$nbQAr);
			}
			elseif($game=='FfQuizz')
			{
				$scUser->setNbPFf($scUser->getNbPFf()+1);
				$scUser->setNbQFf($nbQFf);
				$scUser->setNbBrFf($nbBrFf);
				$scUser->setPrctBrFf($nbBrFf*100/$nbQFf);
			}
			elseif($game=='LxQuizz')
			{
				$scUser->setNbPLx($scUser->getNbPLx()+1);
				$scUser->setNbQLx($nbQLx);
				$scUser->setNbBrLx($nbBrLx);
				$scUser->setPrctBrLx($nbBrLx*100/$nbQLx);
			}
			elseif($game=='MuQuizz')
			{
				$scUser->setNbPMu($scUser->getNbPMu()+1);
				$scUser->setNbQMu($nbQMu);
				$scUser->setNbBrMu($nbBrMu);
				$scUser->setPrctBrMu($nbBrMu*100/$nbQMu);
			}
			$scUser->setNbBrtot($nbBrtot);
			$partie2=new PartieQuizz(); 
			$partie2->setUsername($bot->getUsername());
			$partie2->setQ1($tabidQ[0])->setQ2($tabidQ[1])->setQ3($tabidQ[2])->setQ4($tabidQ[3])->setQ5($tabidQ[4])->setQ6($tabidQ[5])->setQ7($tabidQ[6])->setQ8($tabidQ[7])->setQ9(null)->setQ10(null);		
			$partie2->setUser($bot)->setScore($scoreP)->setValid(true)->setType($game);
			$em->getRepository('MDQUserBundle:ScUser')
						->majBddScfinP($scUser, $game, 'MediaQuizz', $partie2);
			$tabPartie2['sctot']=$scoreP;
			$tabPartie2['scQ9']="none";$tabPartie2['scQ10']="none";
			$bot->setLastLogin(new \Datetime());
			$em->persist($scUser);
			$em->persist($partie2);
			$em->flush();
			return $tabPartie2;
	}

    private function rand_coef($coefs)// tirage au sort avec applicatio de coefficient sous fore de tableau - pour partie bot.
    {
      $rang = mt_rand(1, array_sum($coefs));
      $tot = 0;  
      foreach ($coefs as $key => $coef)
      {
        $tot += $coef;
        if ($tot >= $rang)
          return $key;
      }
    }
 
}
    
/*
Utilisation :

    <?php
    $coefs = array('bleu' => 5, 'jaune' => 1, 'rouge' => 3);
    echo rand_coef($coefs); // Renvoie bleu, jaune ou rouge aléatoirement mais avec plus de chances de tomber sur bleu que sur rouge, et plus de chances de tomber sur rouge que sur jaune
    // Ou encore :
    echo rand_coef(array('pile' => 7, 'face' => 3)); // a 70% de chances de renvoyer pile et 30% de renvoyer face
    ?>
*/
?>
