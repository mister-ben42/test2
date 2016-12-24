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
		
		$tabParties=$this->execBotGame($botsSelects, $type);
		
			$em->flush();
		return $this->render('MDQAdminBundle:Admin:botPartie.html.twig', array(
			'Parties' => $tabParties,
			'Bots2'=> $botsSelects2,
			'nbBotsSelect'=>$nbBotsSelect,
		));
	}
	private function execBotGame($botsSelects, $type)
	{
		$tabParties=[];$j=0;
		foreach($botsSelects as $bot)
		{
			if($type=="Mq" || $type=="Tous")
			{
				$partieMq=$this->botgameMq($bot);
				$tabParties[$j]=$partieMq;
				$j++;
			}
			
			if($type=="QM" || $type=="Tous")
			{
				$partieMq=$this->botgameQM($bot);
				$tabParties[$j]=$partieMq;
				$j++;	
			}
		}
		return $tabParties;
	
	}
	private function botgameMq(User $bot)
	{
			$em=$this->getDoctrine()->getManager();
			$gestion=$em->getRepository('MDQAdminBundle:Gestion')	
				->find(1);
			if($gestion->getMq()==0){return ;}			
			$scUser=$bot->getScUser();
			$tabcoef=$scUser->getTabCoefBot();
			$tabdiff=[1,2,2,3,3,3,4,4,5,5];  $score=0; $tabPartie=[];
			$tabNbQ=[0,0,0,0,0,0];
			$tabNbBr=[0,0,0,0,0,0];
			$nbQtotP=10; $nbBrTotP=0;
			for($i=0; $i<10; $i++)
			{
			    $dom1=mt_rand(0, 5);
			    $br=$this->container->get('mdq_admin.botGame')->testBr($tabcoef[$dom1],$tabdiff[$i]);
			    $tabNbQ[$dom1]++;
			    if($br==1){
				      $score=$this->container->get('mdq_admin.botGame')->calcScore($score,$tabdiff[$i]);
				      $nbBrTotP++;				      
				      $tabNbBr[$dom1]++;
			    }
			    $j=$i+1;
			    $tabPartie['scQ'.$j]=$score;
			}
			
			//Création jour partie
			$partie=new PartieQuizz(); 
			$partie->setUsername($bot->getUsername());
			$partie->setQ1(Null)->setQ2(Null)->setQ3(Null)->setQ4(Null)->setQ5(Null)->setQ6(Null)->setQ7(Null)->setQ8(Null)->setQ9(Null)->setQ10(Null);		
			$partie->setUser($bot)->setScore($score)->setValid(true)->setType('MasterQuizz');
			$em->persist($partie);
			
			//Maj user
			$bot->setLastLogin(new \Datetime());

			//Maj Scuser
			$scUser->setNbPMq($scUser->getNbPMq()+1);
			$NbQtotMq=$scUser->getNbQtotMq()+$nbQtotP; $NbBrtot=$scUser->getNbBrtotMq()+$nbBrTotP;
			$NbQH=$scUser->getNbQhMq()+$tabNbQ[0];	$NbBrH=$scUser->getNbBrhMq()+$tabNbBr[0];
			$NbQG=$scUser->getNbQgMq()+$tabNbQ[1];	$NbBrG=$scUser->getNbBrgMq()+$tabNbBr[1];
			$NbQD=$scUser->getNbQdMq()+$tabNbQ[5];	$NbBrD=$scUser->getNbBrdMq()+$tabNbBr[5];
			$NbQAL=$scUser->getNbQalMq()+$tabNbQ[3];$NbBrAL=$scUser->getNbBralMq()+$tabNbBr[3];
			$NbQSL=$scUser->getNbQslMq()+$tabNbQ[4];$NbBrSL=$scUser->getNbBrslMq()+$tabNbBr[4];
			$NbQSN=$scUser->getNbQsnMq()+$tabNbQ[2];$NbBrSN=$scUser->getNbBrsnMq()+$tabNbBr[2];
			$nbBrtot=$scUser->getNbBrtot()+$nbBrTotP;
		//	$nbQtot=$scUser->getNbQtot()+$nbQtotP; // Ca n'existe pas ?
			
			$scUser->setNbQtotMq($NbQtotMq)->setNbBrtotMq($NbBrtot)->setPrctBrtotMq($NbBrtot*100/$NbQtotMq);
			if ($NbQH!=0){$scUser->setNbQhMq($NbQH)->setNbBrhMq($NbBrH)->setPrctBrhMq($NbBrH*100/$NbQH);}
			if ($NbQG!=0){$scUser->setNbQgMq($NbQG)->setNbBrgMq($NbBrG)->setPrctBrgMq($NbBrG*100/$NbQG);}
			if ($NbQD!=0){$scUser->setNbQdMq($NbQD)->setNbBrdMq($NbBrD)->setPrctBrdMq($NbBrD*100/$NbQD);}
			if ($NbQSN!=0){$scUser->setNbQsnMq($NbQSN)->setNbBrsnMq($NbBrSN)->setPrctBrsnMq($NbBrSN*100/$NbQSN);}
			if ($NbQSL!=0){$scUser->setNbQslMq($NbQSL)->setNbBrslMq($NbBrSL)->setPrctBrslMq($NbBrSL*100/$NbQSL);}
			if ($NbQAL!=0){$scUser->setNbQalMq($NbQAL)->setNbBralMq($NbBrAL)->setPrctBralMq($NbBrAL*100/$NbQAL);}
			$scUser->setNbBrtot($nbBrtot);
			
			//Maj scUser fin de Partie
			$em->getRepository('MDQUserBundle:ScUser')->majBddScfinP($scUser, 'MasterQuizz', 'MasterQuizz', $partie);			
			
;			
			$tabPartie['bot']=$bot->getUsername();
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
			$GFf=$gestion->getFf(); $GLx=$gestion->getLx(); $GAr=$gestion->getAr(); $GWz=$gestion->getWz(); 
			if($GFf+$GLx+$GAr+$GWz==0){return;}
			
			// Tirage au sort jeu
			 $tab4game=['ArQuizz','FfQuizz','LxQuizz', 'WzQuizz'];
			 $tabGestion=[$GAr,$GFf,$GLx, $GWz];
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
			
			//$game='WzQuizz';// Pour forcer le tirage de WzQuizz
			$tabPartie2['bot']=$bot->getUsername();
			$tabPartie2['game']=$game;
			$tabcoef=$scUser->getTabCoefBot();
			if($game=='WzQuizz'){$coefJ=$tabcoef[6];}
			else if($game=='ArQuizz'){$coefJ=$tabcoef[7];}
			else if($game=='FfQuizz'){$coefJ=$tabcoef[8];}
			else if($game=='LxQuizz'){$coefJ=$tabcoef[9];}
			$coefs=array(0=>(100-$coefJ),1=>$coefJ);
			$scoreP=0;
			$nbQAr=$scUser->getNbQAr();	$nbBrAr=$scUser->getNbBrAr();
			$nbQFf=$scUser->getNbQFf();	$nbBrFf=$scUser->getNbBrFf();
			$nbQLx=$scUser->getNbQLx();	$nbBrLx=$scUser->getNbBrLx();
			$nbQWz=$scUser->getNbQWz();	$nbBrWz=$scUser->getNbBrWz();
			$nbBrtot=$scUser->getNbBrtot();
			
			for($numQ=1; $numQ<9; $numQ++)
			{
				$botGame = $this->container->get('mdq_admin.botGame');
				$rep=$botGame->randCoefQM($coefs);
				if($rep==1){$nbBrtot++;}
				if($game=='ArQuizz'){	
					$nbQAr++; $scoreQ=0;
					if($rep==1){$nbBrAr++;$scoreQ=$botGame->calcScQ(1000);$scoreP=$scoreP+$scoreQ;}					
				}
				if($game=='FfQuizz'){	
					$nbQFf++; $scoreQ=0;
					if($rep==1){$nbBrFf++;$scoreQ=$botGame->calcScQ(1000);$scoreP=$scoreP+$scoreQ;}					
				}
				if($game=='LxQuizz'){	
					$nbQLx++; $scoreQ=0;
					if($rep==1){$nbBrLx++;$scoreQ=$botGame->calcScQ(1000);$scoreP=$scoreP+$scoreQ;}					
				}
				if($game=='WzQuizz'){	
					$nbQWz++; $scoreQ=0;
					if($rep==1){$nbBrWz++;$scoreQ=$botGame->calcScQ(1000);$scoreP=$scoreP+$scoreQ;}					
				}
				$tabPartie2['scQ'.$numQ]=$scoreP;
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
			elseif($game=='WzQuizz')
			{
				$scUser->setNbPWz($scUser->getNbPWz()+1);
				$scUser->setNbQWz($nbQWz);
				$scUser->setNbBrWz($nbBrWz);
				$scUser->setPrctBrWz($nbBrWz*100/$nbQWz);
			}
			$scUser->setNbBrtot($nbBrtot);
			$partie2=new PartieQuizz(); 
			$partie2->setUsername($bot->getUsername());
			$partie2->setQ1(null)->setQ2(null)->setQ3(null)->setQ4(null)->setQ5(null)->setQ6(null)->setQ7(null)->setQ8(null)->setQ9(null)->setQ10(null);		
			$partie2->setUser($bot)->setScore($scoreP)->setValid(true)->setType($game);
			$em->getRepository('MDQUserBundle:ScUser')
						->majBddScfinP($scUser, $game, 'MediaQuizz', $partie2);
			$tabPartie2['sctot']=$scoreP;
			$tabPartie2['scQ9']="none";$tabPartie2['scQ10']="none";
			$bot->setLastLogin(new \Datetime());
			$em->persist($partie2);
			return $tabPartie2;
	}	


  
}
    

?>
