<?php

namespace MDQ\QuizzBundle\Services;

use MDQ\AdminBundle\Entity\GestionRepository;
use MDQ\UserBundle\Entity\User;

class QuizzServ
{    
       	    	
	private $gestion;
 
	public function __construct(GestionRepository $gestionRepository) {
	  $this->gestionRepository=$gestionRepository;
	  $this->gestion=$gestionRepository->findOneById(1);
	} 
      
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

      public function comFinP($scofDayUser, $scMaxUser, $score, $game, $highScoreTous, $userId)
      {
				if($game=='MasterQuizz'){$nameGame='MasterQuizz';}
				elseif($game=='MuQuizz'){$nameGame='Quizz Musique';}
				elseif($game=='ArQuizz'){$nameGame='Quizz Art';}
				elseif($game=='FfQuizz'){$nameGame='Quizz Nature';}
				elseif($game=='LxQuizz'){$nameGame='Quizz Géo';}
				elseif($game=='WzQuizz'){$nameGame='Quizz Wouzou';}
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
				elseif($game=='WzQuizz'){$crit='scofDayWz';}
				elseif($game=='SexyQuizz'){$crit='scofDaySx';}
				elseif($game=='TvQuizz'){$crit='scofDayTv';}
	      return $crit;
      }

      public function recupScFinP(User $user, $game)
      {
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
		elseif($game=="WzQuizz")
		{
				$scofDayUser=$user->getScUser()->getScofDayWz();
				$highscore=$user->getScUser()->getScMaxWz();
		}
		elseif($game=="SexyQuizz")
		{
				$scofDayUser=$user->getScUser()->getScofDaySx();
				$highscore=$user->getScUser()->getScMaxSx();
		}
		elseif($game=="TvQuizz")
		{
				$scofDayUser=$user->getScUser()->getScofDayTv();
				$highscore=$user->getScUser()->getScMaxTv();
		}
	      $tabScore['ScDay']=$scofDayUser;
	      $tabScore['ScMax']=$highscore;
	      return $tabScore;
      }
      public function testSignalE()
      {
		$gestion=$this->gestion;
		return $gestion->getSignalE();
      }
}


