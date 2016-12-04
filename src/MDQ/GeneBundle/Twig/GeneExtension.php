<?php
// src/MDQ/UserBundle/Twig/UserExtension.php

namespace MDQ\GeneBundle\Twig;

class GeneExtension extends \Twig_Extension
{

	
	private $gestionRepository;
	private $roleService;
 
	public function __construct($gestionRepository, $roleService) {
	  $this->gestionRepository = $gestionRepository ;
	  $this->roleService = $roleService;
	}
	
	public function getFunctions(){
		return array(
		  'flashAJ' => new \Twig_Function_Method($this, 'selectFlashAcJeu'),
		  'testAccessAJ'=> new \Twig_Function_Method($this, 'testAccessAJ'),
	      );
	}
	    public function getFilters()
	{
	    return array(
//		'chgeNull' => new \Twig_Filter_Method($this, 'chgeNullto0'),		
	    );
	}
	public function getName()
	  {
		return 'Gene';
	  }
	public function selectFlashAcJeu($jeu, $user)
	{
	      $txt="";
	      $admin=0;
	      if($user===Null){$txt="affich_flash1";}
	      else
	      {	    
		    $gestion=$this->gestionRepository->findOneById(1);
		    if($this->roleService->isGranted('ROLE_ADMIN', $user)){$admin=1;}
		    if($jeu=="Mq")
		    {
			  if($gestion->getMq()==0 && $admin==0){$txt="affich_flash3";}
			  elseif($user->getScUser()->getNbJDayMq()<1 && $admin==0){$txt="affich_flash2";}	      
		    }
		    elseif($jeu=="Ar")
		    {
			  if($gestion->getAr()==0 && $admin==0){$txt="affich_flash3";}
			  elseif($user->getScUser()->getNbJDayMq()<1 && $admin==0){$txt="affich_flash2";}	      
		    }
		    elseif($jeu=="Ff")
		    {
			  if($gestion->getFf()==0 && $admin==0){$txt="affich_flash3";}
			  elseif($user->getScUser()->getNbJDayMq()<1 && $admin==0){$txt="affich_flash2";}	      
		    }
		    elseif($jeu=="Mu")
		    {
			  if($gestion->getMc()==0 && $admin==0){$txt="affich_flash3";}
			  elseif($user->getScUser()->getNbJDayMq()<1 && $admin==0){$txt="affich_flash2";}	      
		    }		        
		    elseif($jeu=="Lx")
		    {
			  if($gestion->getLx()==0 && $admin==0){$txt="affich_flash3";}
			  elseif($user->getScUser()->getNbJDayMq()<1 && $admin==0){$txt="affich_flash2";}	      
		    }
			    
	      }
	      return $txt;
	}
	public function testAccessAJ($jeu, $user)
	{	      
	      $txt=""; $admin=0;
	      if($user!==Null)
	      {	      
		    $gestion=$this->gestionRepository->findOneById(1);
		    if($this->roleService->isGranted('ROLE_ADMIN', $user)){$admin=1;}
		    if($jeu=="Mq")
		    {
			  if(($gestion->getMq()!=0 && $user->getScUser()->getNbJDayMq()<1) || $admin==1){$txt="href=quizz/preGame/MasterQuizz";}
		    }
		    elseif($jeu=="Ar")
		    {
			  if(($gestion->getAr()!=0 && $user->getScUser()->getNbJDayMq()<1) || $admin==1){$txt="href=quizz/preGame/ArQuizz";}
		    }
		    elseif($jeu=="Ff")
		    {
			  if(($gestion->getFf()!=0 && $user->getScUser()->getNbJDayMq()<1) || $admin==1){$txt="href=quizz/preGame/FfQuizz";}
		    }
		    elseif($jeu=="Mu")
		    {
			  if(($gestion->getMc()!=0 && $user->getScUser()->getNbJDayMq()<1) || $admin==1){$txt="href=quizz/preGame/MuQuizz";}
		    }
		    elseif($jeu=="Lx")
		    {
			  if(($gestion->getLx()!=0 && $user->getScUser()->getNbJDayMq()<1) || $admin==1){$txt="href=quizz/preGame/LxQuizz";}
		    }		    
			    
	      }
	      return $txt;
	}
}


