<?php

namespace MDQ\GeneBundle\Services;

use MDQ\UserBundle\Entity\UserRepository;
use MDQ\GeneBundle\Entity\StatsQuotRepository;
use MDQ\GeneBundle\Entity\DateReferenceRepository;
use MDQ\QuestionBundle\Entity\QuestionRepository;
use MDQ\GeneBundle\Entity\StatsQuot;


class MajStatsQuot
{    
      	private $partieRepository;
      	private $scUserRepository;
      	private $statsQuotRepository;
      	private $dateRefRepository;
      	private $questionRepository;
 
	public function __construct($partieRepository, UserRepository $userRepository, StatsQuotRepository $statsQuotRepository, DateReferenceRepository $dateRefRepository, QuestionRepository $questionRepository) {
	  $this->partieRepository=$partieRepository;
	  $this->userRepository=$userRepository;
	  $this->statsQuotRepository=$statsQuotRepository;
	  $this->dateRefRepository=$dateRefRepository;
	  $this->questionRepository=$questionRepository;
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
            $data=$this->statsParties($data,$oldDate);
            $data=$this->statsQuestions($data);
            // mise à jour ancienne ligne
            $oldJ->setNbUserDay($data['nbUserDay']);
            $oldJ->setNbUser7j($data['nbUser7j']);
            $oldJ->setNbUser30j($data['nbUser30j']);
            $oldJ->setNbNewUser($data['nbNewUser']);
            $oldJ->setNbPtot($data['nbPtot']);
            $oldJ->setNbPTotBot($data['nbPTotBot']);
            $oldJ->setNbPMq($data['nbPMq']);
            $oldJ->setNbPMqBot($data['nbPMqBot']);
            $oldJ->setNbPFf($data['nbPFf']);
            $oldJ->setNbPLx($data['nbPLx']);
            $oldJ->setNbPAr($data['nbPAr']);
            $oldJ->setNbPWz($data['nbPWz']);
            $oldJ->setNbPMu($data['nbPMu']);
            $oldJ->setScMoyP($data['scMoyTot']);
            $oldJ->setScMoyPbot($data['scMoyTotBot']);
            $oldJ->setScMoyMq($data['scMoyMq']);
            $oldJ->setScMoyFf($data['scMoyFf']);
            $oldJ->setScMoyLx($data['scMoyLx']);
            $oldJ->setScMoyAr($data['scMoyAr']);
            $oldJ->setScMoyWz($data['scMoyWz']);  
            $oldJ->setNbQMqV($data['nbQMq']);  
            $oldJ->setNbQLxV($data['nbQLx']);  
            $oldJ->setNbQWzV($data['nbQWz']);  
            $oldJ->setNbQFfV($data['nbQFf']);  
            $oldJ->setNbQArV($data['nbQAr']);  
            $oldJ->setNbQMuV($data['nbQMu']);
            $oldJ->setValid(1);
            
            $newJ=new StatsQuot;
            $dateRef=$this->dateRefRepository->findOneById(1);
            if($dateRef->getRMDQ()!==Null){$newJ->setRMDQ($dateRef->getRMDQ()->getId());}
            if($dateRef->getCMDQ()!==Null){$newJ->setCMDQ($dateRef->getCMDQ()->getId());}
            if($dateRef->getSMDQ()!==Null){$newJ->setSMDQ($dateRef->getSMDQ()->getId());}
            if($dateRef->getFfMDQ()!==Null){$newJ->setFfMDQ($dateRef->getFfMDQ()->getId());}
            if($dateRef->getArMDQ()!==Null){$newJ->setArMDQ($dateRef->getArMDQ()->getId());}
            if($dateRef->getLxMDQ()!==Null){$newJ->setLxMDQ($dateRef->getLxMDQ()->getId());}
            if($dateRef->getWzMDQ()!==Null){$newJ->setWzMDQ($dateRef->getWzMDQ()->getId());}
            return $newJ;
            }
            else{
                return $oldJ; //Si pas de changmeent de date, on renvoit l'actuelle
            }
        }
        $newJ=new StatsQuot;
        return $newJ;
        
        }
        private function statsParties($data, $date)
        {
            $parties=$this->partieRepository->recupParties("tous", $date, 1, 2);
            $nbPtot=0; $nbPTotBot=0; $nbPMq=0; $nbPMqBot=0;$nbPFf=0; $nbPLx=0; $nbPAr=0; $nbPWz=0; $nbPMu=0; //PMU = parties autre en général.
            $scTot=0; $scTotBot=0; $scMq=0; $scFf=0; $scLx=0; $scAr=0; $scWz=0;
            foreach ($parties as $partie)
            {
                if($partie['type']=="MasterQuizz"){
                    if($partie['bot']==1){$nbPMqBot++;}
                    else{$nbPMq++;}                
                }
                elseif($partie['type']=="FfQuizz"){
                    if($partie['bot']==0){$nbPFf++;}
                }
                elseif($partie['type']=="LxQuizz"){
                    if($partie['bot']==0){$nbPLx++;}
                }
                elseif($partie['type']=="ArQuizz"){
                    if($partie['bot']==0){$nbPFf++;}
                }
                elseif($partie['type']=="WzQuizz"){
                    if($partie['bot']==0){$nbPFf++;}
                }
                else{
                    if($partie['bot']==0){$nbPMu++;}
                }
                if($partie['bot']==1){$nbPTotBot++; $scTotBot=$scTotBot+$partie['score'];}
                    else{$nbPtot++; $scTot=$scTot+$partie['score'];}    
                
            }
            $data['nbPtot']=$nbPtot;
             $data['nbPTotBot']=$nbPTotBot;
            $data['nbPMq']=$nbPMq;
            $data['nbPMqBot']=$nbPMqBot;
            $data['nbPFf']=$nbPFf;
            $data['nbPLx']=$nbPLx;
            $data['nbPAr']=$nbPAr;
            $data['nbPWz']=$nbPWz;
            $data['nbPMu']=$nbPMu;
            if($nbPtot<11){$data['scMoyTot']=0;}
            else{$data['scMoyTot']=round((100*$scTot/$nbPtot),2);}
            if($nbPTotBot==0){$data['scMoyTotBot']=0;}
            else{$data['scMoyTotBot']=round((100*$scTotBot/$nbPTotBot),2);}
            if($nbPMq<11){$data['scMoyMq']=0;}
            else{$data['scMoyMq']=round((100*$scMq/$nbPMq),2);} 
            if($nbPFf<11){$data['scMoyFf']=0;}
            else{$data['scMoyFf']=round((100*$scFf/$nbPFf),2);}          
            if($nbPAr<11){$data['scMoyAr']=0;}
            else{$data['scMoyAr']=round((100*$scAr/$nbPAr),2);}          
            if($nbPLx<11){$data['scMoyLx']=0;}
            else{$data['scMoyLx']=round((100*$scLx/$nbPLx),2);}          
            if($nbPWz<11){$data['scMoyWz']=0;}
            else{$data['scMoyWz']=round((100*$scWz/$nbPWz),2);}                   
             
            return $data;
        }
        private function statsUsers($data, $date)
        {
            
            $data['nbUserDay']=$this->userRepository->recupNbUser($date, 1);
            $data['nbUser7j']=$this->userRepository->recupNbUser($date, 7);
            $data['nbUser30j']=$this->userRepository->recupNbUser($date, 30);
            $data['nbNewUser']=$this->userRepository->recupNbInscrit($date, 1);
            
            return $data;
        }
        
        private function statsQuestions($data)
        {
            $requete=$this->questionRepository->getQuestions(2, 1, 0, "none", "none", "none", "id", "ASC", 20000, 1, 1);
            $nbQtot=$requete[0];
            $nbQMq=0; $nbQFf=0; $nbQAr=0; $nbQLx=0; $nbQWz=0; $nbQMu=0;
            foreach($requete[1] as $question)
            {
                if($question->getDom1()=="FfQuizz"){$nbQFf++;}
                elseif($question->getDom1()=="ArQuizz"){$nbQAr++;}
                elseif($question->getDom1()=="LxQuizz"){$nbQLx++;}
                elseif($question->getDom1()=="WzQuizz"){$nbQWz++;}
                elseif($question->getDom1()=="Histoire" || $question->getDom1()=="Géographie" || $question->getDom1()=="Divers" || $question->getDom1()=="Sports et loisirs" || $question->getDom1()=="Sciences et nature" || $question->getDom1()=="Arts et Littérature"){$nbQMq++;}
                else{$nbQMu++;}// = Autre
            }
            $data['nbQMq']=$nbQMq;
            $data['nbQFf']=$nbQFf;
            $data['nbQLx']=$nbQLx;
            $data['nbQAr']=$nbQAr;
            $data['nbQWz']=$nbQWz;
            $data['nbQMu']=$nbQMu;
            
            return $data;
        }
}

