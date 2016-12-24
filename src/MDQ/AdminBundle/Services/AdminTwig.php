<?php

namespace MDQ\AdminBundle\Services;


class AdminTwig
{    
 
	private $assets;     	
 
	public function __construct($assets) {
	  $this->assets=$assets;
	}

	
	
	public function txtCompteU($userSup)// pour la page Voir User
	{
	      $txt="Problème dans dans l'état du compte";
	      if($userSup==0){$txt="Compte actif";}
	      elseif($userSup==1){$txt="Compte supprimé";}
	      return $txt;
	 }
	public function arbraBaseCompar($dom1)
	{
	      $txt="";
	      if($dom1=="LxQuizz"){$txt="Base comparative 0 % | 0 % | 33 % | 33 % | 33 %";}
	      elseif($dom1=="FfQuizz"){$txt="Base comparative 10 % | 0 % | 30 % | 30 % | 30 %";}
	      elseif($dom1=="Histoire" || $dom1=="Géographie" || $dom1=="Divers" || $dom1=="Sports et loisirs" || $dom1=="Sciences et nature" || $dom1=="Arts et Littérature"){$txt="Base comparative 8 % | 12 % | 27 % | 27 % | 27 % ";}
	      return $txt;	
	}
	public function routeImg($dom1,$media)
	{
	      $txt="";
	      if($dom1=="TvQuizz"){$route=$this->assets->getAssetUrl('bundles/mdqquestion/images/imgQuestions/TV/'.$media.'.jpg');}
	      elseif($dom1=="FfQuizz"){$route=$this->assets->getAssetUrl('bundles/mdqquestion/images/imgQuestions/Ff/'.$media.'.jpg');}
	      elseif($dom1=="LxQuizz"){$route=$this->assets->getAssetUrl('bundles/mdqquestion/images/imgQuestions/Lx/'.$media.'.jpg');}
	      elseif($dom1=="WzQuizz"){$route=$this->assets->getAssetUrl('bundles/mdqquestion/images/imgQuestions/Wz/'.$media.'.jpg');}
	      elseif($dom1=="ArQuizz"){$route=$this->assets->getAssetUrl('bundles/mdqquestion/images/imgQuestions/Ar/'.$media.'.jpg');}
	      elseif($dom1=="SexyQuizz"){$route=$this->assets->getAssetUrl('bundles/mdqquestion/images/imgQuestions/Sexy/'.$media.'.jpg');}
	      else{$route=$this->assets->getAssetUrl('bundles/mdqquestion/images/imgQuestions/'.$media.'.jpg');}
	      $txt="src=".$route;
	      return $txt;	
	}
	public function testSelected($crit1, $crit2)
	{
	  $txt="";
	  if($crit1==$crit2){$txt='selected style=background-color:pink;';}
	  return $txt;
	}
	public function calcNumQ($loop, $page, $nbParP)
	{
	    $txt=$loop+(($page-1)*$nbParP);
	    return $txt;
	}
	public function backGroundListForm($valid)
	{
	    $txt="";
	    if($valid==0){$txt="style=background-color:rgb(250,50,50);";}
	    elseif($valid==1){$txt="style=background-color:rgb(100,255,100);";}
	    elseif($valid==2){$txt="style=background-color:rgb(100,100,255);";}
	    return $txt;
	}
}

