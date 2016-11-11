<?php
// src/MDQ/UserBundle/Twig/UserExtension.php

namespace MDQ\UserBundle\Twig;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;

class UserExtension extends \Twig_Extension
{
	public function getFunctions(){
     return array(
          'age' => new \Twig_Function_Method($this, 'calculage'),
		  'sexe' => new \Twig_Function_Method($this, 'calculSexe'),
     );
	}
	public function calculage($date)
	{	
	 // sscanf($date, "%4s/%2s/%2s", $an, $mois, $jour);
	$dna=$date;
	  
	  $now = date("d/m/Y");
	   $date1 = explode("/",$dna);// explode découpe la chaine de caractère et en fait un tableau.
       $date2= explode("/",$now);
        $age = $date2[2] - $date1[2]; // Dans les tableau crée, la case numero 0 est la 1ère, dont l'année.
		// L'âge est la différence des années ...
        if(($date2[1] < $date1[1]) || ($date2[1] == $date1[1] && $date2[0] < $date1[0])) $age--;
		// A la quelle on retranche une année selon les situations.
         return $age;	  
	}
	public function calculSexe($sexe)
	{
		if ($sexe==1) {$sex="femme";}
		else if($sexe==0) {$sex="homme";}
		else {$sex= "Pas de sexe !";}
		return $sex;
	}
	/*
   * La méthode getName() identifie votre extension Twig, elle est obligatoire
   */
	  public function getName()
	  {
		return 'U';
	  }
}