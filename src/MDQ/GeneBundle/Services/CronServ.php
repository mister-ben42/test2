<?php

namespace MDQ\GeneBundle\Services;

use MDQ\UserBundle\Entity\ScUserRepository;
use MDQ\GeneBundle\Entity\DateReferenceRepository;



class CronServ
{    
      	private $partieRepository;
      	private $scUserRepository;
      	private $dateRefRepository;
      	private $jetonServ;
 
	public function __construct($partieRepository, ScUserRepository $scUserRepository, DateReferenceRepository $dateRefRepository, $jetonServ) {
	  $this->partieRepository=$partieRepository;
	  $this->scUserRepository=$scUserRepository;
	  $this->dateRefRepository=$dateRefRepository;
	  $this->jetonServ=$jetonServ;
	}

 

        public function testNonValidPartie()
      {
	    $partieNonValide=$this->partieRepository->recupPNonValid();
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
				$this->scUserRepository->majBddScfinP($scUser, $dom1, $game, $partie);

			}
		}
		return ;
      }
        public function majQuot()
        {
        	$datejour= new \DateTime(date('Y-m-d'));
		//Reste un petit pb avec l'objet date : si pas de connexion le lundi, mais le mardi, la date de Maj de la dateref jour est celle du debut de semane, ce qui conduit a une maj automatique du jour lors de l'arrivee suivante sur la page d'accueil.
		$dateref=$this->dateRefRepository->find(1);
		//$tabrMDQ[0]=$dateref->getRMDQ(); Que si classement mensuel
		$tabMaitres=[$dateref->getRMDQ(), null,null,null,null,null,null];
		if($dateref->getDay()!=$datejour){
			$dateref->setDay($datejour);// Je le mets la ; si je le mets apres l'operation sub dateInter, l'interval est deduit de la date entree en bdd -jsp pourquoi.

		$scUserRepository=$this->scUserRepository;	
	//************* Controle nouvelle semaine ************** /////////////////////
		$semref=$dateref->getWeek();
		$int=$datejour->diff($semref);
		if($int->format('%a')>6){
			$tabMaitres=[null,null,null,null,null,null,null];
			$listeUser=$scUserRepository
					->recupUserByCrit('kingMaster');// ****** A FAIRE PAR UNE FONCTION SIMPLIFIEE ***

			$tabMaitres=$scUserRepository
						->majClassement($listeUser, 'KingMaster', $tabMaitres);
			$week1= new \DateInterval('P7D');
			$dateref->getWeek()->add($week1);
			$dateref->setWeek($datejour->add($int)->add($week1));
		}
	//****************************** Mise a jour, donnees du jour.*******************************
			$listeUserMq=$scUserRepository
					->recupUserByCrit('scofDayMq');				
			
			$tabMaitres=$scUserRepository
						->majClassement($listeUserMq, 'scofDayMq', $tabMaitres);
		
			$listeUQM=$scUserRepository
							->recupUserByCrit('scofDayCq');
			$jetonServ = $this->jetonServ;
			$jetonServ->majQuotJeton($listeUserMq);// A mixer avec le suivant
			$jetonServ->majQuotJeton($listeUQM);
			$tabMaitres=$scUserRepository
						->majClassement($listeUQM, 'CaQuizz', $tabMaitres);
			$listeUMu=$scUserRepository
						->recupUserByCrit('scofDayMu');
			$tabMaitres=$scUserRepository
						->majClassement($listeUMu, 'MuQuizz', $tabMaitres);
			$listeUAr=$scUserRepository
						->recupUserByCrit('scofDayAr');
			$tabMaitres=$scUserRepository
						->majClassement($listeUAr, 'ArQuizz', $tabMaitres);
			$listeUFf=$scUserRepository
						->recupUserByCrit('scofDayFf');
			$tabMaitres=$scUserRepository
						->majClassement($listeUFf, 'FfQuizz', $tabMaitres);
			$listeULx=$scUserRepository
						->recupUserByCrit('scofDayLx');
			$tabMaitres=$scUserRepository
						->majClassement($listeULx, 'LxQuizz', $tabMaitres);

	//**** mise a jour date_ref ***********************//
					
			$dateref->setRMDQ($tabMaitres[0]);
			$dateref->setSMDQ($tabMaitres[1]);
			$dateref->setCMDQ($tabMaitres[2]);
			$dateref->setMuMDQ($tabMaitres[3]);
			$dateref->setArMDQ($tabMaitres[4]);
			$dateref->setFfMDQ($tabMaitres[5]);
			$dateref->setLxMDQ($tabMaitres[6]);
		}
        return;
        }
}

