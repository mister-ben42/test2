<?php

namespace MDQ\GeneBundle\Services;


class AccueilGene
{    
      	private $partieRepository;
      	private $scUserRepository;
 
	public function __construct($partieRepository, $scUserRepository) {
	  $this->partiequizzRepository=$partieRepository;
	  $this->scuserRepository=$scUserRepository;
	}


      public function testNonValidPartie()
      {
	    $partieNonValide=$this->partiequizzRepository->recupPNonValid();
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
				$this->scuserRepository->majBddScfinP($scUser, $dom1, $game, $partie);

			}
		}
		return ;
      }
}

