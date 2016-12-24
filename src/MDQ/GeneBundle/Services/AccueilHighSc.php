<?php

namespace MDQ\GeneBundle\Services;

use MDQ\UserBundle\Entity\ScUserRepository;


class AccueilHighSc
{    

	private $router;
	private $tabprctBrtotMq;
	private $tabnbBrtot;
	private $tabHighScKM;
	private $tabMedKm;	
	private $tabMedMq;
 	private $tabMedCq;
 	private $tabMedLx;
 	private $tabMedFf;
 	
	public function __construct(ScUserRepository $scUserRepository, $router) {
	  $this->scUserRepository=$scUserRepository;
	  $this->router=$router;
	  $this->tabprctBrtotMq=$scUserRepository->recupHighScore('prctBrtotMq',1,10);
	  $this->tabnbBrtot=$scUserRepository->recupHighScore('nbBrtot',1,10);
	  $this->tabHighScKM=$scUserRepository->recupHighScore('highScKM',1,10);
	  $this->tabMedKm=$scUserRepository->recupHighScore('MedKm',1,10);
	  $this->tabMedMq=$scUserRepository->recupHighScore('MedMq',1,10);
	  $this->tabMedCq=$scUserRepository->recupHighScore('MedCq',1,10);
	  $this->tabMedLx=$scUserRepository->recupHighScore('MedLx',1,10);
	  $this->tabMedFf=$scUserRepository->recupHighScore('MedFf',1,10);
	}

	private function typeToTab($type)
	{
	      if($type=="prctBrtotMq"){$tab=$this->tabprctBrtotMq;}
	      elseif($type=="nbBrtot"){$tab=$this->tabnbBrtot;}
	      elseif($type=="highScKM"){$tab=$this->tabHighScKM;}
	      elseif($type=="MedKm"){$tab=$this->tabMedKm;}
	      elseif($type=="MedMq"){$tab=$this->tabMedMq;}
	      elseif($type=="MedCq"){$tab=$this->tabMedCq;}
	      elseif($type=="MedLx"){$tab=$this->tabMedLx;}
	      elseif($type=="MedFf"){$tab=$this->tabMedFf;} 
	      return $tab;
	}

	public function highScHref($type, $rang)
	{
	     $txt="";
	     $rang=$rang-1;
	      $tab=$this->typeToTab($type);
	      if(isset($tab[$rang]) && $tab[$rang]!==Null){$txt="href=".$this->router->generate('mdquser_profileU', array("id"=>$tab[$rang]['id']));}	 	
	      return $txt;
	}
	public function highScUser($type, $rang)
	{
	     $txt="";
	     $rang=$rang-1;
	      $tab=$this->typeToTab($type);
	      if(isset($tab[$rang]) && $tab[$rang]!==Null){$txt=$tab[$rang]['username'];}	      
	      return $txt;
	}
	public function highScScore($type, $rang)
	{
	     $txt="";
	     $rang=$rang-1;
	      $tab=$this->typeToTab($type);
	      if(isset($tab[$rang]) && $tab[$rang]!==Null){$txt=$tab[$rang][$type];}	     
	      return $txt;
	}
	public function highScMed($type, $rang, $typeMed)
	{
	     $txt="";
	     $rang=$rang-1;
	     if($type=="MedKm"){$tab=$this->tabMedKm;$nomMed="km";}
	      elseif($type=="MedMq"){$tab=$this->tabMedMq; $nomMed="mq";}
	      elseif($type=="MedCq"){$tab=$this->tabMedCq; $nomMed="cq";}
	      elseif($type=="MedLx"){$tab=$this->tabMedLx; $nomMed="lx";}
	      elseif($type=="MedFf"){$tab=$this->tabMedFf; $nomMed="ff";} 
	      if(isset($tab[$rang]) && $tab[$rang]!==Null){$txt=$tab[$rang][$nomMed.$typeMed];}	     
	      return $txt;
	}
}

