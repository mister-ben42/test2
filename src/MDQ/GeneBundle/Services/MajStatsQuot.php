<?php

namespace MDQ\GeneBundle\Services;

use MDQ\UserBundle\Entity\UserRepository;
use MDQ\GeneBundle\Entity\StatsQuotRepository;
use MDQ\GeneBundle\Entity\StatsQuot;


class MajStatsQuot
{    
      	private $partieRepository;
      	private $scUserRepository;
      	private $statsQuotRepository;
 
	public function __construct($partieRepository, UserRepository $userRepository, StatsQuotRepository $statsQuotRepository) {
	  $this->partieRepository=$partieRepository;
	  $this->userRepository=$userRepository;
	  $this->statsQuotRepository=$statsQuotRepository;
	}

 

        public function majStatsQuot()
      {
        $datejour= new \DateTime(date('Y-m-d'));
        // Récupérer la date, stat quot valid
        $oldJ=$this->statsQuotRepository->findOneByValid(0);
        $data=[];
        if($oldJ!==Null){
            $oldDate=$oldJ->getDay();
            if($datejour!=$oldDate){
            $data=$this->statsUsers($data,$oldDate);
            
            // mise à jour ancienne ligne
            $oldJ->setNbUserDay($data['nbUserDay']);
            $oldJ->setNbUser7j($data['nbUser7j']);
            $oldJ->setNbUser30j($data['nbUser30j']);
            $oldJ->setNbNewUser($data['nbNewUser']);
            $oldJ->setValid(1);
            $newJ=new StatsQuot;
            return $newJ;
            }
            else{
                return $oldJ; //Si pas de changmeent de date, on renvoit l'actuelle
            }
        }
        $newJ=new StatsQuot;
        return $newJ;
        
        }
        private function statsPartie()
        {
        
        
            return $tabPartie;
        }
        private function statsUsers($data, $date)
        {
            
            $data['nbUserDay']=$this->userRepository->recupNbUser($date, 1);
            $data['nbUser7j']=$this->userRepository->recupNbUser($date, 7);
            $data['nbUser30j']=$this->userRepository->recupNbUser($date, 30);
            $data['nbNewUser']=$this->userRepository->recupNbInscrit($date, 1);
            
            return $data;
        }
}

