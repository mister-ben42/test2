<?php

namespace MDQ\GeneBundle\Services;

use MDQ\UserBundle\Entity\ScUserRepository;
use MDQ\GeneBundle\Entity\DateReference;



class AccueilGene
{  
	private $assets;
	private $router;
	private $tabScDayMq;
	private $tabScDayKM;
	private $tabScDayCq;
	private $tabScDayFf;
	private $tabScDayLx;      	
 
	public function __construct(ScUserRepository $scUserRepository, $assets, $router) {
	  $this->scUserRepository=$scUserRepository;
	  $this->assets=$assets;
	  $this->router=$router;
	  $this->tabScDayMq=$scUserRepository->recupHighScore('scofDayMq',1,15);
	  $this->tabScDayKM=$scUserRepository->recupHighScore('kingMaster',1,15);	  
	  $this->tabScDayCq=$scUserRepository->recupHighScore('scofDayCq',1,15);
	  $this->tabScDayFf=$scUserRepository->recupHighScore('scofDayFf',1,5);	  
	  $this->tabScDayLx=$scUserRepository->recupHighScore('scofDayLx',1,5);	  
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
	      elseif($type=="Paparazzi"){
		    if($isNul || $sexe==0){$txt="Paparazzi";}
		    else{$txt="Paparazette";}
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
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/mdqgene/images/roi2.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/mdqgene/images/reine3.png');}		     
		    $txt="src=".$route;
	      }
	      elseif($type=="Savant"){		    
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/mdqgene/images/savant-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/mdqgene/images/savant-F.png');}		     
		    $txt="src=".$route;
	      }	      	      
	      elseif($type=="Musicien"){		    
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/mdqgene/images/virtuose-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/mdqgene/images/virtuose-F.png');}		     
		    $txt="src=".$route;
	      }	
	      elseif($type=="Peintre"){		    
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/mdqgene/images/peintre-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/mdqgene/images/peintre-F.png');}		     
		    $txt="src=".$route;
	      }
	      elseif($type=="Ecolo"){		    
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/mdqgene/images/nature-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/mdqgene/images/nature-F.png');}		     
		    $txt="src=".$route;
	      }	      
	      elseif($type=="Globe-T"){		    
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/mdqgene/images/globeT-H2.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/mdqgene/images/globeT-F.png');}		     
		    $txt="src=".$route;
	      }	      
	      elseif($type=="Paparazzi"){		    
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/mdqgene/images/paparazzi-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/mdqgene/images/paparazzi-F.png');}		     
		    $txt="src=".$route;
	      }
	      elseif($type=="Capitaine"){		    
		    if($sexe==0){$route=$this->assets->getAssetUrl('bundles/mdqgene/images/capitaine-H.png');}
		    else{$route=$this->assets->getAssetUrl('bundles/mdqgene/images/capitaine-F.png');}		     
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
	      elseif($type=="scofDayCq"){$tab=$this->tabScDayCq;}
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
	      elseif($type=="scofDayCq"){$tab=$this->tabScDayCq;}
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
	      elseif($type=="scofDayCq"){$tab=$this->tabScDayCq;}
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
	if($dateref->getCMDQ()===null){$tabMaitre['capitaine']=null;}
	else{
	      $key=array_search($dateref->getCMDQ()->getId(), array_column($tabMaitre2, 'id'));
	      $tabMaitre['capitaine']=$tabMaitre2[$key];
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
	if($dateref->getWzMDQ()===null){$tabMaitre['paparazzi']=null;}
	else{
	      $key=array_search($dateref->getWzMDQ()->getId(), array_column($tabMaitre2, 'id'));
	      $tabMaitre['paparazzi']=$tabMaitre2[$key];
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

