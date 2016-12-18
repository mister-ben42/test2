<?php

namespace MDQ\GeneBundle\Services;

use MDQ\UserBundle\Entity\ScUserRepository;
use MDQ\GeneBundle\Entity\DateReference;



class AccueilGene
{    
      	private $partieRepository;
      	private $scUserRepository;
	private $assets;
	private $router;
	private $tabScDayMq;
	private $tabScDayKM;
	private $tabScDayTM;
	private $tabScDayFf;
	private $tabScDayLx;      	
 
	public function __construct($partieRepository, ScUserRepository $scUserRepository, $assets, $router) {
	  $this->partieRepository=$partieRepository;
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
      	public function maitreTesthref($id)
	{
	      $txt="";
	      if($id!=""){
		  $route=$this->router->generate('mdquser_profileU', array("id"=>$id));
		    $txt="href=".$route;
	      }

	      return $txt;	      
	}
	public function maitreNom($type, $sexe)
	{
	      $txt="";
	      $isNul=false;
		    if($sexe==""){$isNul=true;}
	      if($type=="Roi"){
		    if($isNul || $sexe==0){$txt="Roi";}
		    else{$txt="Reine";}
	      }
	      elseif($type=="Savant"){
		    if($isNul || $sexe==0){$txt="Savant";}
		    else{$txt="Savante";}
	      }
	      elseif($type=="Musicien"){
		    if($isNul || $sexe==0){$txt="Musicien";}
		    else{$txt="Musicienne";}
	      }
	      elseif($type=="Globe-T"){
		    if($isNul || $sexe==0){$txt="Globe-trotter";}
		    else{$txt="Globe-trotteuse";}
	      }
	      return $txt;
	}
	public function maitreImg($type, $sexe, $id)
	{
	      
	      if($type=="Roi"){		    
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/GeneBundle/roi2.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/GeneBundle/reine3.png');}		     
		    $txt="src=".$route;
	      }
	      elseif($type=="Savant"){		    
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/GeneBundle/savant-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/GeneBundle/savant-F.png');}		     
		    $txt="src=".$route;
	      }
	      elseif($type=="Ministre"){		    
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/GeneBundle/ministre-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/GeneBundle/ministre-H.png');}		     
		    $txt="src=".$route;
	      }	      	      	      
	      elseif($type=="Musicien"){		    
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/GeneBundle/virtuose-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/GeneBundle/virtuose-F.png');}		     
		    $txt="src=".$route;
	      }	
	      elseif($type=="Peintre"){		    
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/GeneBundle/peintre-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/GeneBundle/peintre-F.png');}		     
		    $txt="src=".$route;
	      }
	      elseif($type=="Ecolo"){		    
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/GeneBundle/nature-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/GeneBundle/nature-F.png');}		     
		    $txt="src=".$route;
	      }	      
	      elseif($type=="Globe-T"){		    
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/GeneBundle/globeT-H2.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/GeneBundle/globeT-F.png');}		     
		    $txt="src=".$route;
	      }

	      if($id==""){$txt=$txt." style=opacity:0.4";}
	      return $txt;
	}
	public function maitreColorSexe($sexe)
	{
	      $txt="";
	      $isNul=false;
	      if($sexe==""){$isNul=true;}
		    if($isNul || $sexe==0){$txt="accueil_maitre_txt_nom_H";}
		    else{$txt="accueil_maitre_txt_nom_F";}
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
	public function getTabMaitre(DateReference $dateref, $tabMaitre2)
	{
	      	if($dateref->getRMDQ()===null){$tabMaitre['roi']=null;}
	else{
	      $key=array_search($dateref->getRMDQ()->getId(), array_column($tabMaitre2, 'id'));
	      $tabMaitre['roi']=$tabMaitre2[$key];
	 }
	if($dateref->getMMDQ()===null){$tabMaitre['ministre']=null;}
	else{
	      $key=array_search($dateref->getMMDQ()->getId(), array_column($tabMaitre2, 'id'));
	      $tabMaitre['ministre']=$tabMaitre2[$key];
	 }
	if($dateref->getSMDQ()===null){$tabMaitre['savant']=null;}
	else{
	      $key=array_search($dateref->getSMDQ()->getId(), array_column($tabMaitre2, 'id'));
	      $tabMaitre['savant']=$tabMaitre2[$key];
	 }
	if($dateref->getFfMDQ()===null){$tabMaitre['ecolo']=null;}
	else{
	      $key=array_search($dateref->getFfMDQ()->getId(), array_column($tabMaitre2, 'id'));
	      $tabMaitre['ecolo']=$tabMaitre2[$key];
	 }
	if($dateref->getLxMDQ()===null){$tabMaitre['globeT']=null;}
	else{
	      $key=array_search($dateref->getLxMDQ()->getId(), array_column($tabMaitre2, 'id'));
	      $tabMaitre['globeT']=$tabMaitre2[$key];
	 }
	 if($dateref->getArMDQ()===null){$tabMaitre['peintre']=null;}
	  else{
	      $key=array_search($dateref->getArMDQ()->getId(), array_column($tabMaitre2, 'id'));
	      $tabMaitre['peintre']=$tabMaitre2[$key];
	 }	 
	if($dateref->getMuMDQ()===null){$tabMaitre['virtuose']=null;}
	else{
	      $key=array_search($dateref->getMuMDQ()->getId(), array_column($tabMaitre2, 'id'));
	      $tabMaitre['virtuose']=$tabMaitre2[$key];
	 }	 
	      return $tabMaitre;
	}

}

