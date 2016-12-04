<?php

namespace MDQ\QuizzBundle\Services;


class QuizzServ
{    
      public function selectPageJeu($game)
      {
	    if($game=="MasterQuizz" || $game=="MuQuizz" || $game=="SexyQuizz")
	    {
	    $page='jeu'.$game;	    
	    }
	    else
	    {
	    $page='photoQuizz';	    
	    }      
	    return $page;
      }
      public function testAutoriseNewG($Gestion, $game, $user, $admin)
      {
	    $test=1;
	     if ($user===null || $game=="MasterQuizz" && $Gestion->getMq()==0 && $admin==0
			 || $game=="FfQuizz" && $Gestion->getFf()==0 && $admin==0
			 || $game=="ArQuizz" && $Gestion->getAr()==0 && $admin==0
			 || $game=="MuQuizz" && $Gestion->getMc()==0 && $admin==0
			 || $game=="LxQuizz"  && $Gestion->getLx()==0 && $admin==0
			 || $game=="SexyQuizz" && $admin==0
			 || $game=="TvQuizz" && $admin==0)
		{$test=0;}
	    if ($game!="MasterQuizz" && $game!="FfQuizz" && $game!="ArQuizz" && $game!="MuQuizz" && $game!="LxQuizz" && $game!="SexyQuizz" && $game!="TvQuizz")
		{$test=0;}
	    return $test;
      }
      public function testJeton($game, $User)
      {
		$game="none"; // en attendant de répartir les jetons selon les jeux.
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
		$nbJ=$User->getScUser()->getNbJdayMq();
		if($nbJ==0){$test=0;}
		else{$test=1;}
		return $test;
      }
      public function comFinP($scofDayUser, $scMaxUser, $score, $game, $highScoreTous, $userId)
      {
				if($game=='MasterQuizz'){$nameGame='MasterQuizz';}
				elseif($game=='MuQuizz'){$nameGame='Quizz Musique';}
				elseif($game=='ArQuizz'){$nameGame='Quizz Art';}
				elseif($game=='FfQuizz'){$nameGame='Quizz Nature';}
				elseif($game=='LxQuizz'){$nameGame='Quizz Monde';}
				elseif($game=='SexyQuizz'){$nameGame='SexyQuizz';}
				elseif($game=='TvQuizz'){$nameGame='Quizz Tv';}
		$com['feu']=0;
		if($score>=10000){$phrase='Bravo pour cette partie exceptionnelle ! Votre avez réalisé un score de ';$com['feu']=1;}
		else{$phrase='Votre avez réalisé un score de ';}
		$com['phrase1']=$phrase.$score.'.';
		if($score==$scMaxUser){$com['phrase2']='C\'est votre meilleur score au '.$nameGame.'.'; $com['feu']=1;}
		elseif($score==$scofDayUser){$com['phrase2']='C\'est votre meilleur score du jour au '.$nameGame.'.';}
		else{$com['phrase2']='Vous n\'avez pas amélioré votre score du jour au '.$nameGame.'.';}
		
				
				$i=0;$j=0;
				foreach($highScoreTous as $userA)
				{
					if($j==0){$i++;}
					if($userA['id']==$userId){$j=1;}
				}
				$rang=$i;
		if($rang==1){$com['phrase3']='Vous êtes à la 1ère place au classement du '.$nameGame.'.';}
		else{$com['phrase3']='Vous êtes à la '.$i.'eme place au classement du '.$nameGame.'.';}
		return $com;
		
      }
      public function defCritFinP($game)
      {
	      if($game=='MasterQuizz'){$crit='scofDayMq';}
				elseif($game=='MuQuizz'){$crit='scofDayMu';}
				elseif($game=='ArQuizz'){$crit='scofDayAr';}
				elseif($game=='FfQuizz'){$crit='scofDayFf';}
				elseif($game=='LxQuizz'){$crit='scofDayLx';}
				elseif($game=='SexyQuizz'){$crit='scofDaySx';}
				elseif($game=='TvQuizz'){$crit='scofDayTv';}
	      return $crit;
      }
      public function testAccessFinP($Session, $User)
      {
	      $test=1;	      
	      if ($User===null){$test=0;}
	      if($Session->get('page')!='Mquizz'){$test=0;}
	     return $test;
      }
      public function recupScFinP($User, $game)
      {
	      	if($game=="MasterQuizz")
		{
			$scofDayUser=$User->getScUser()->getScofDayMq();
			$highscore=$User->getScUser()->getScMaxMq();
		}		
		elseif($game=="MuQuizz")
		{
				$scofDayUser=$User->getScUser()->getScofDayMu();
				$highscore=$User->getScUser()->getScMaxMu();
		}
		elseif($game=="ArQuizz")
		{
				$scofDayUser=$User->getScUser()->getScofDayAr();
				$highscore=$User->getScUser()->getScMaxAr();
		}
		elseif($game=="FfQuizz")
		{
				$scofDayUser=$User->getScUser()->getScofDayFf();
				$highscore=$User->getScUser()->getScMaxFf();
		}
		elseif($game=="LxQuizz")
		{
				$scofDayUser=$User->getScUser()->getScofDayLx();
				$highscore=$User->getScUser()->getScMaxLx();
		}
		elseif($game=="SexyQuizz")
		{
				$scofDayUser=$User->getScUser()->getScofDaySx();
				$highscore=$User->getScUser()->getScMaxSx();
		}
		elseif($game=="TvQuizz")
		{
				$scofDayUser=$User->getScUser()->getScofDayTv();
				$highscore=$User->getScUser()->getScMaxTv();
		}
	      $tabScore['ScDay']=$scofDayUser;
	      $tabScore['ScMax']=$highscore;
	      return $tabScore;
      }
}


