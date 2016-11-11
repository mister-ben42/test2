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
	   $date1 = explode("/",$dna);// explode d�coupe la chaine de caract�re et en fait un tableau.
       $date2= explode("/",$now);
        $age = $date2[2] - $date1[2]; // Dans les tableau cr�e, la case numero 0 est la 1�re, dont l'ann�e.
		// L'�ge est la diff�rence des ann�es ...
        if(($date2[1] < $date1[1]) || ($date2[1] == $date1[1] && $date2[0] < $date1[0])) $age--;
		// A la quelle on retranche une ann�e selon les situations.
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
   * La m�thode getName() identifie votre extension Twig, elle est obligatoire
   */
	  public function getName()
	  {
		return 'U';
	  }
}