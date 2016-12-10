<?php

namespace MDQ\UserBundle\Services;

use MDQ\UserBundle\Entity\User;


class JetonServ
{    

 	private $gestionRepository;
 	private $gestion;
 
	public function __construct($gestionRepository) {
	  $this->gestionRepository = $gestionRepository;
	  $this->gestion=$gestionRepository->findOneById(1);
	} 

	public function testJeton(User $user, $game)
	{
	      $gestion=$this->gestion;
	      if($gestion->getJetonsUniques()===true){
		  if(($user->getScUser()->getNbJdayMq()+$user->getScUser()->getNbJMq()+$user->getScUser()->getNbJdayQnF()+$user->getScUser()->getNbJQnF()>0) && ($game=="MuQuizz" || $game=="FfQuizz" || $game=="ArQuizz" || $game=="LxQuizz"|| $game=="MasterQuizz")){
		  return true;}
		  else{return false;}
	      }
	      elseif($game=="MasterQuizz"){
		  if(($user->getScUser()->getNbJdayMq()+$user->getScUser()->getNbJMq())>0){
		  return true;}
		  else{return false;}
	      }
	      elseif($game=="MuQuizz" || $game=="FfQuizz" || $game=="ArQuizz" || $game=="LxQuizz"){
		  if(($user->getScUser()->getNbJdayQnF()+$user->getScUser()->getNbJQnF())>0){
		  return true;}
		  else{return false;}  
	      }
	      else{
		  return false;
	      }
	}
	public function suppJPartie(User $user, $game)
	{
	      $gestion=$this->gestion;
	      $scUser=$user->getScUser();
	      if($gestion->getJetonsUniques()===true){
		  if($scUser->getNbJdayQnF()>0){$scUser->setNbJdayQnF($scUser->getNbJdayQnF()-1);}
		  elseif($scUser->getNbJdayMq()>0){$scUser->setNbJdayMq($scUser->getNbJdayMq()-1);}
		  elseif($scUser->getNbJQnF()>0){$scUser->setNbJQnF($scUser->getNbJQnF()-1);}
		  elseif($scUser->getNbJMq()>0){$scUser->setNbJMq($scUser->getNbJMq()-1);}	      
	      }
	      else{
		  if($game=="MasterQuizz"){
			if($scUser->getNbJdayMq()>0){$scUser->setNbJdayMq($scUser->getNbJdayMq()-1);}
			 elseif($scUser->getNbJMq()>0){$scUser->setNbJMq($scUser->getNbJMq()-1);}	
		  }
		  else{
			if($scUser->getNbJdayQnF()>0){$scUser->setNbJdayQnF($scUser->getNbJdayQnF()-1);}			
			elseif($scUser->getNbJQnF()>0){$scUser->setNbJQnF($scUser->getNbJQnF()-1);}
		  }      
	      }
	      return;
	
	}
	public function majQuotJeton($tabUsers)
	{
		$gestion=$this->gestion;		
		foreach($tabUsers as $scUser)
		{
		    if($scUser->getNbJdayMq()<$gestion->getNbJquotMq())
		    {$scUser->setNbJdayMq($gestion->getNbJquotMq());	
		    }
		    if($scUser->getNbJdayQnF()<$gestion->getNbJquotQM())
		    {$scUser->setNbJdayQnF($gestion->getNbJquotQM());	
		    }
		}
		return;
	}
	
}


