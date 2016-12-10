<?php

namespace MDQ\GeneBundle\Services;


class AccueilHighSc
{    
      	private $partieRepository;
      	private $scUserRepository;
	private $dateRefRepository;
	private $assets;
	private $router;
	private $tabprctBrtotMq;
	private $tabnbBrtot;
	private $tabHighScKM;
 
	public function __construct($partieRepository, $scUserRepository, $dateRefRepository, $assets, $router) {
	  $this->partiequizzRepository=$partieRepository;
	  $this->dateRefRepository=$dateRefRepository->findOneById(1);
	  $this->scUserRepository=$scUserRepository;
	  $this->assets=$assets;
	  $this->router=$router;
	  $this->tabprctBrtotMq=$scUserRepository->recupHighScore('prctBrtotMq',1,10);
	  $this->tabnbBrtot=$scUserRepository->recupHighScore('nbBrtot',1,10);
	  $this->tabHighScKM=$scUserRepository->recupHighScore('highScKM',1,10);
	}

 

	public function highScHref($type, $rang)
	{
	     $txt="";
	     $rang=$rang-1;
	     if($type=="prctBrtotMq"){$tab=$this->tabprctBrtotMq;}
	      elseif($type=="nbBrtot"){$tab=$this->tabnbBrtot;}
	      elseif($type=="highScKM"){$tab=$this->tabHighScKM;}
	      if(isset($tab[$rang]) && $tab[$rang]!==Null){$txt="href=".$this->router->generate('mdquser_profileU', array("id"=>$tab[$rang]['id']));}	 	
	      return $txt;
	}
	public function highScUser($type, $rang)
	{
	     $txt="";
	     $rang=$rang-1;
	     if($type=="prctBrtotMq"){$tab=$this->tabprctBrtotMq;}
	      elseif($type=="nbBrtot"){$tab=$this->tabnbBrtot;}
	      elseif($type=="highScKM"){$tab=$this->tabHighScKM;}
	      if(isset($tab[$rang]) && $tab[$rang]!==Null){$txt=$tab[$rang]['username'];}	      
	      return $txt;
	}
	public function highScScore($type, $rang)
	{
	     $txt="";
	     $rang=$rang-1;
	     if($type=="prctBrtotMq"){$tab=$this->tabprctBrtotMq;}
	      elseif($type=="nbBrtot"){$tab=$this->tabnbBrtot;}
	      elseif($type=="highScKM"){$tab=$this->tabHighScKM;}
	      if(isset($tab[$rang]) && $tab[$rang]!==Null){$txt=$tab[$rang][$type];}	     
	      return $txt;
	}

}

