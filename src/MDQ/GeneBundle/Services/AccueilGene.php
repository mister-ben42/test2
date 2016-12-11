<?php

namespace MDQ\GeneBundle\Services;

use MDQ\UserBundle\Entity\ScUserRepository;
use MDQ\GeneBundle\Entity\DateReferenceRepository;



class AccueilGene
{    
      	private $partieRepository;
      	private $scUserRepository;
	private $dateRefRepository;
	private $assets;
	private $router;
	private $tabScDayMq;
	private $tabScDayKM;
	private $tabScDayTM;
	private $tabScDayFf;
	private $tabScDayLx;      	
 
	public function __construct($partieRepository, ScUserRepository $scUserRepository, DateReferenceRepository $dateRefRepository, $assets, $router) {
	  $this->partieRepository=$partieRepository;
	  $this->dateRefRepository=$dateRefRepository->findOneById(1);
	  $this->scUserRepository=$scUserRepository;
	  $this->assets=$assets;
	  $this->router=$router;
	  $this->tabScDayMq=$scUserRepository->recupHighScore('scofDayMq',1,15);
	  $this->tabScDayKM=$scUserRepository->recupHighScore('kingMaster',1,15);	  
	  $this->tabScDayTM=$scUserRepository->recupHighScore('scofDayTM',1,15);
	  $this->tabScDayFf=$scUserRepository->recupHighScore('scofDayFf',1,5);	  
	  $this->tabScDayLx=$scUserRepository->recupHighScore('scofDayLx',1,5);	  
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
      	public function maitreTesthref($type)
	{
	      $txt="";
	      if($type=="Roi"){
		    if($this->dateRefRepository->getRMDQ()!==Null){
		    $route=$this->router->generate('mdquser_profileU', array("id"=>$this->dateRefRepository->getRMDQ()->getId()));
		    $txt="href=".$route;}
	      }
	      elseif($type=="Savant"){
		    if($this->dateRefRepository->getSMDQ()!==Null){
		    $route=$this->router->generate('mdquser_profileU', array("id"=>$this->dateRefRepository->getSMDQ()->getId()));
		    $txt="href=".$route;}
	      }
	      elseif($type=="Ministre"){
		    if($this->dateRefRepository->getMMDQ()!==Null){
		    $route=$this->router->generate('mdquser_profileU', array("id"=>$this->dateRefRepository->getMMDQ()->getId()));
		    $txt="href=".$route;}
	      }
	      elseif($type=="Musicien"){
		    if($this->dateRefRepository->getMuMDQ()!==Null){
		    $route=$this->router->generate('mdquser_profileU', array("id"=>$this->dateRefRepository->getMuMDQ()->getId()));
		    $txt="href=".$route;}
	      }
	      elseif($type=="Peintre"){
		    if($this->dateRefRepository->getArMDQ()!==Null){
		    $route=$this->router->generate('mdquser_profileU', array("id"=>$this->dateRefRepository->getArMDQ()->getId()));
		    $txt="href=".$route;}
	      }
	      elseif($type=="Ecolo"){
		    if($this->dateRefRepository->getFfMDQ()!==Null){
		    $route=$this->router->generate('mdquser_profileU', array("id"=>$this->dateRefRepository->getFfMDQ()->getId()));
		    $txt="href=".$route;}
	      }
	      elseif($type=="Globbe-T"){
		    if($this->dateRefRepository->getLxMDQ()!==Null){
		    $route=$this->router->generate('mdquser_profileU', array("id"=>$this->dateRefRepository->getLxMDQ()->getId()));
		    $txt="href=".$route;}
	      }	      
	      return $txt;	      
	}
	public function maitreImg($type)
	{
	      $isNul=false;
	      if($type=="Roi"){
		    if($this->dateRefRepository->getRMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getRMDQ()->getUsermap()->getSexe()==0){$route=$this->assets->getAssetUrl('bundles/GeneBundle/roi2.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/GeneBundle/reine3.png');}		     
		    $txt="src=".$route;
	      }
	      elseif($type=="Savant"){
		    if($this->dateRefRepository->getSMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getSMDQ()->getUsermap()->getSexe()==0){$route=$this->assets->getAssetUrl('bundles/GeneBundle/savant-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/GeneBundle/savant-F.png');}		     
		    $txt="src=".$route;
	      }
	      elseif($type=="Ministre"){
		    if($this->dateRefRepository->getMMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getMMDQ()->getUsermap()->getSexe()==0){$route=$this->assets->getAssetUrl('bundles/GeneBundle/ministre-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/GeneBundle/ministre-H.png');}		     
		    $txt="src=".$route;
	      }	      	      	      
	      elseif($type=="Musicien"){
		    if($this->dateRefRepository->getMuMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getMuMDQ()->getUsermap()->getSexe()==0){$route=$this->assets->getAssetUrl('bundles/GeneBundle/virtuose-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/GeneBundle/virtuose-F.png');}		     
		    $txt="src=".$route;
	      }	
	      elseif($type=="Peintre"){
		    if($this->dateRefRepository->getArMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getArMDQ()->getUsermap()->getSexe()==0){$route=$this->assets->getAssetUrl('bundles/GeneBundle/peintre-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/GeneBundle/peintre-F.png');}		     
		    $txt="src=".$route;
	      }
	      elseif($type=="Ecolo"){
		    if($this->dateRefRepository->getFfMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getFfMDQ()->getUsermap()->getSexe()==0){$route=$this->assets->getAssetUrl('bundles/GeneBundle/nature-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/GeneBundle/nature-F.png');}		     
		    $txt="src=".$route;
	      }	      
	      elseif($type=="Globe-T"){
		    if($this->dateRefRepository->getLxMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getLxMDQ()->getUsermap()->getSexe()==0){$route=$this->assets->getAssetUrl('bundles/GeneBundle/globeT-H2.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/GeneBundle/globeT-F.png');}		     
		    $txt="src=".$route;
	      }

	      if($isNul===true){$txt=$txt." style=opacity:0.4";}
	      return $txt;
	}
	public function maitreColorSexe($type)
	{
	      $txt="";
	      $isNul=false;
	      if($type=="Roi"){
		    if($this->dateRefRepository->getRMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getRMDQ()->getUsermap()->getSexe()==0){$txt="accueil_maitre_txt_nom_H";}
		    else{$txt="accueil_maitre_txt_nom_F";}
	      }
	      elseif($type=="Savant"){
		    if($this->dateRefRepository->getSMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getSMDQ()->getUsermap()->getSexe()==0){$txt="accueil_maitre_txt_nom_H";}
		    else{$txt="accueil_maitre_txt_nom_F";}
	      }
	      elseif($type=="Ministre"){
		    if($this->dateRefRepository->getMMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getMMDQ()->getUsermap()->getSexe()==0){$txt="accueil_maitre_txt_nom_H";}
		    else{$txt="accueil_maitre_txt_nom_F";}
	      }
	      elseif($type=="Musicien"){
		    if($this->dateRefRepository->getMuMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getMuMDQ()->getUsermap()->getSexe()==0){$txt="accueil_maitre_txt_nom_H";}
		    else{$txt="accueil_maitre_txt_nom_F";}
	      }
	      elseif($type=="Peintre"){
		    if($this->dateRefRepository->getArMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getArMDQ()->getUsermap()->getSexe()==0){$txt="accueil_maitre_txt_nom_H";}
		    else{$txt="accueil_maitre_txt_nom_F";}
	      }	      
	      elseif($type=="Ecolo"){
		    if($this->dateRefRepository->getFfMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getFfMDQ()->getUsermap()->getSexe()==0){$txt="accueil_maitre_txt_nom_H";}
		    else{$txt="accueil_maitre_txt_nom_F";}
	      }
	      elseif($type=="Globe-T"){
		    if($this->dateRefRepository->getLxMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getLxMDQ()->getUsermap()->getSexe()==0){$txt="accueil_maitre_txt_nom_H";}
		    else{$txt="accueil_maitre_txt_nom_F";}
	      }	      	      
	      return $txt;
	}
	public function maitreNom($type)
	{
	      $txt="";
	      $isNul=false;
	      if($type=="Roi"){
		    if($this->dateRefRepository->getRMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getRMDQ()->getUsermap()->getSexe()==0){$txt="Roi";}
		    else{$txt="Reine";}
	      }
	      elseif($type=="Savant"){
		    if($this->dateRefRepository->getSMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getSMDQ()->getUsermap()->getSexe()==0){$txt="Savant";}
		    else{$txt="Savante";}
	      }
	      elseif($type=="Musicien"){
		    if($this->dateRefRepository->getMuMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getMuMDQ()->getUsermap()->getSexe()==0){$txt="Musicien";}
		    else{$txt="Musicienne";}
	      }
	      elseif($type=="Globe-T"){
		    if($this->dateRefRepository->getLxMDQ()===Null){$isNul=true;}
		    if($isNul || $this->dateRefRepository->getLxMDQ()->getUsermap()->getSexe()==0){$txt="Globe-trotter";}
		    else{$txt="Globe-trotteuse";}
	      }
	      return $txt;
	}
	public function maitreUser($type)
	{
	      $txt="";
	      if($type=="Roi"){
		    if($this->dateRefRepository->getRMDQ()!==Null){$txt= $this->dateRefRepository->getRMDQ()->getUsermap()->getUsername();	}		
	      }
	      elseif($type=="Savant"){
		    if($this->dateRefRepository->getSMDQ()!==Null){$txt= $this->dateRefRepository->getSMDQ()->getUsermap()->getUsername();	}		
	      }
	      elseif($type=="Ministre"){
		    if($this->dateRefRepository->getSMDQ()!==Null){$txt= $this->dateRefRepository->getMMDQ()->getUsermap()->getUsername();	}		
	      }
	      elseif($type=="Musicien"){
		    if($this->dateRefRepository->getMuMDQ()!==Null){$txt= $this->dateRefRepository->getMuMDQ()->getUsermap()->getUsername();	}		
	      }
	      elseif($type=="Peintre"){
		    if($this->dateRefRepository->getArMDQ()!==Null){$txt= $this->dateRefRepository->getArMDQ()->getUsermap()->getUsername();	}		
	      }	      
	      elseif($type=="Ecolo"){
		    if($this->dateRefRepository->getFfMDQ()!==Null){$txt= $this->dateRefRepository->getFfMDQ()->getUsermap()->getUsername();	}		
	      }
	      elseif($type=="Globe-T"){
		    if($this->dateRefRepository->getLxMDQ()!==Null){$txt= $this->dateRefRepository->getLxMDQ()->getUsermap()->getUsername();	}		
	      }	      
	      return $txt;
	}
	public function highScHref($type, $rang)
	{
	     $txt="";
	     $rang=$rang-1;
	     if($type=="scofDayMq"){$tab=$this->tabScDayMq;}
	      elseif($type=="kingMaster"){$tab=$this->tabScDayKM;}
	      elseif($type=="scofDayTM"){$tab=$this->tabScDayTM;}
	      elseif($type=="scofDayFf"){$tab=$this->tabScDayFf;}
	      elseif($type=="scofDayLx"){$tab=$this->tabScDayLx;}
	      if(isset($tab[$rang]) && $tab[$rang]!==Null){$txt="href=".$this->router->generate('mdquser_profileU', array("id"=>$tab[$rang]['id']));}	 	
	      return $txt;
	}
	public function highScUser($type, $rang)
	{
	     $txt="";
	     $rang=$rang-1;
	     if($type=="scofDayMq"){$tab=$this->tabScDayMq;}
	      elseif($type=="kingMaster"){$tab=$this->tabScDayKM;}	      
	      elseif($type=="scofDayTM"){$tab=$this->tabScDayTM;}
	      elseif($type=="scofDayFf"){$tab=$this->tabScDayFf;}
	      elseif($type=="scofDayLx"){$tab=$this->tabScDayLx;}
	      if(isset($tab[$rang]) && $tab[$rang]!==Null){$txt=$tab[$rang]['username'];}	      
	      return $txt;
	}
	public function highScScore($type, $rang)
	{
	     $txt="";
	     $rang=$rang-1;
	     if($type=="scofDayMq"){$tab=$this->tabScDayMq;}
	      elseif($type=="kingMaster"){$tab=$this->tabScDayKM;}	      
	      elseif($type=="scofDayTM"){$tab=$this->tabScDayTM;}
	      elseif($type=="scofDayFf"){$tab=$this->tabScDayFf;}
	      elseif($type=="scofDayLx"){$tab=$this->tabScDayLx;}
	      if(isset($tab[$rang]) && $tab[$rang]!==Null){$txt=$tab[$rang][$type];}	     
	      return $txt;
	}

}

