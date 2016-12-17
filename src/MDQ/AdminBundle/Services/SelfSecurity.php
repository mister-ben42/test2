<?php

namespace MDQ\AdminBundle\Services;




class SelfSecurity
{    
      	private $gestionRepository;
      	private $securityContext;
      	private $session;
 
	public function __construct($securityContext, $session, $gestionRepository) {
	  $this->gestionRepository=$gestionRepository;
	  $this->securityContext=$securityContext;
	  $this->session=$session;
	}

	public function testAutorize($action, $game) 
	{
	// Gestion/admin, connected(user), jeton ?, 
		$test=true;
		$user=0;
		$blocageTot=0;
		$testGame=0;
		$inscription=0;
		$propQ=0;
		$signalE=0;
		$pagePrec=null;
		if($this->session->has('page')){$sessionPage=$this->session->get('page');}
		else{$sessionPage=null;}
		
		if($action=="simpleAction"){
			$blocageTot=1;
			$this->session->set('page', 'gene');
		}
		elseif($action=="preGame" || $action=="newGame"){
			$blocageTot=1;
			$user=1;
			$testGame=1;
			$this->session->set('page', 'newGame');
		}
		elseif($action=="jeuQuizz"){			
			$blocageTot=1;
			$user=1;
			$testGame=1;
			$pagePrec="newGame";
			$this->session->set('page', 'jeuQuizz');
		}
		elseif($action=="finPartie"){			
			$blocageTot=1;
			$user=1;
			$pagePrec="jeuQuizz";
			$this->session->set('page', 'finPartie');
		}
		elseif($action=="profileUAuto"){
			$blocageTot=1;
			$user=1;			
			$this->session->set('page', 'userAuto');
		}
		elseif($action=="register"){
			$inscription=1;
			$user=2;
		}
		elseif($action=="ajoutQ" || $action=="modifQaval"){			
			$blocageTot=1;
			$user=1;
			$propQ=1;
		}
		elseif($action=="signalError"){			
			$blocageTot=1;
			$user=1;
			$signalE=1;
			$pagePrec="jeuQuizz";
		}	
		$gestion=$this->gestionRepository->findOneById(1);

		if($blocageTot==1 && $gestion->getBlocageTot()==1 && !$this->securityContext->isGranted('ROLE_ADMIN')){return false;}
		
		elseif($user==1 && $this->securityContext->getToken()->getUser()===null){return false;}
		elseif($user==2 && $this->securityContext->getToken()->getUser()!==null){return false;}
		
		elseif($inscription==1 && $gestion->getInscription()==0 && !$this->securityContext->isGranted('ROLE_ADMIN')){return false;}
		elseif($propQ==1 && $gestion->getPropQ()==0 && !$this->securityContext->isGranted('ROLE_ADMIN')){return false;}
		elseif($signalE==1 && $gestion->getSignalE()==0 && !$this->securityContext->isGranted('ROLE_ADMIN')){return false;}
		elseif($pagePrec!==null && $pagePrec!=$sessionPage){return false;}
		
		elseif($testGame==1){ 
		if($game!="MasterQuizz" && $game!="MuQuizz" && $game!="SexyQuizz" && $game!="FfQuizz" && $game!="ArQuizz" && $game!="LxQuizz"  && $game!="TvQuizz"){return false;}
		else{
		if($game=="MasterQuizz" && $gestion->getMq()==0 && !$this->securityContext->isGranted('ROLE_ADMIN')){return false;}
		elseif($game=="FfQuizz" && $gestion->getFf()==0 && !$this->securityContext->isGranted('ROLE_ADMIN')){return false;}
		elseif($game=="ArQuizz" && $gestion->getAr()==0 && !$this->securityContext->isGranted('ROLE_ADMIN')){return false;}
		elseif($game=="LxQuizz" && $gestion->getLx()==0 && !$this->securityContext->isGranted('ROLE_ADMIN')){return false;}
		elseif($game=="MuQuizz" && $gestion->getMc()==0 && !$this->securityContext->isGranted('ROLE_ADMIN')){return false;}
		elseif($game=="TvQuizz" && !$this->securityContext->isGranted('ROLE_ADMIN')){return false;}
		elseif($game=="SexyQuizz" && !$this->securityContext->isGranted('ROLE_ADMIN')){return false;}
		}}
		
	      return $test; //true or false
	}
	
	
	
}

