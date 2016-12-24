<?php
// src/MDQ/UserBundle/Twig/UserExtension.php

namespace MDQ\GeneBundle\Twig;

class GeneExtension extends \Twig_Extension
{

	public function getFunctions(){
		return array(
		    new \Twig_SimpleFunction('age',array($this, 'calculage')),
		    new \Twig_SimpleFunction('colorSexe',array($this, 'colorSexe')),
	      );
	}
	    public function getFilters()
	{
	    return array(
		new \Twig_SimpleFilter('chgeNull', array($this,'chgeNullto0')),
		new \Twig_SimpleFilter('sexe', array($this,'calculSexe')),		
	    );
	}
	public function calculage($date)
	{	
	$dna=$date;
	  
	  $now = date("d/m/Y");
	   $date1 = explode("/",$dna);// explode decoupe la chaine de caractere et en fait un tableau.
       $date2= explode("/",$now);
        $age = $date2[2] - $date1[2]; // Dans les tableau cree, la case numero 0 est la 1ere, dont l'annee.
		// L'age est la difference des annees ...
        if(($date2[1] < $date1[1]) || ($date2[1] == $date1[1] && $date2[0] < $date1[0])) $age--;
		// A la quelle on retranche une annee selon les situations.
         return $age;	  
	}
	public function calculSexe($sexe)
	{
		if ($sexe==1) {$sex="Femme";}
		else if($sexe==0) {$sex="Homme";}
		else {$sex= "Pas de sexe !";}
		return $sex;
	}
	public function colorSexe($sexe)
	{
		if ($sexe==1) {$sex='id=sexe_femme';}
		else if($sexe==0) {$sex='id=sexe_homme';}
		else {$sex='id=sexe_homme';}
		return $sex;
	}

	public function chgeNullto0($data)
	{
	    if($data===Null){$data=0;}
	    
	    return $data;
	}

	  public function getName()
	  {
		return 'G';
	  }

}


