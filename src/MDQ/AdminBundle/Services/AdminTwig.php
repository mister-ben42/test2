<?php

namespace MDQ\AdminBundle\Services;


class AdminTwig
{    

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
}
