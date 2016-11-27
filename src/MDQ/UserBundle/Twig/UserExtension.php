<?php
// src/MDQ/UserBundle/Twig/UserExtension.php

namespace MDQ\UserBundle\Twig;

class UserExtension extends \Twig_Extension
{
/*	private $dateRef;
	public function __construct(DateRef $dateRef)
	{
	    $this->dateRef = $dateRef;
	}	
*/	
	private $dateRefRepository;
 
	public function __construct($dateRefRepository ) {
	  $this->dateRefRepository = $dateRefRepository ;
	}
	public function getFunctions(){
		return array(
		  'age' => new \Twig_Function_Method($this, 'calculage'),
		  'colorSexe' => new \Twig_Function_Method($this, 'colorSexe'),
		  'tabMed' => new \Twig_Function_Method($this, 'tabMedailles'),
		  'spanMed' => new \Twig_Function_Method($this, 'spanMedailles'),
		  'spanDerPartie' => new \Twig_Function_Method($this, 'spanDerPartie'),
		  'testMaitre' => new \Twig_Function_Method($this, 'testMaitre'),
	      );
	}
	    public function getFilters()
	{
	    return array(
		'chgeNull' => new \Twig_Filter_Method($this, 'chgeNullto0'),
		  'sexe' => new \Twig_Filter_Method($this, 'calculSexe'),
		'affichePartie' => new \Twig_Filter_Method($this, 'affichePartieType')
		
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

	public function tabMedailles($data, $type)
	{
	    if($data==0){$balise="";}
	    elseif($data<6)
	    {
		  $balise='src=../../../../web/bundles/UserBundle/Med'.$type.$data.'.png alt=Med width=60px>';
	    }
	    else
	    {
		  $balise='src=../../../../web/bundles/UserBundle/Med'.$type.'5.png alt=Med width=60px>';
	    }
            return $balise;
	}
	public function spanMedailles($data)
	{
	    if($data<6){$data='';}
	    return $data;
	}
	
	public function chgeNullto0($data)
	{
	    if($data===Null){$data=0;}
	    
	    return $data;
	}
	public function affichePartieType($partieType)
	{
	      if($partieType=="MasterQuizz"){$data='MasterQuizz';}
	      elseif($partieType=="FfQuizz"){$data='Quizz Nature';}
	      elseif($partieType=="LxQuizz"){$data='Lieux du monde';}
	      else{$data='Autre';}
	      return $data;
	}
	public function spanDerPartie($partieType)
	{
	      if($partieType=="MasterQuizz"){$data='style=color:rgb(255,255,0)';}
	      elseif($partieType=="FfQuizz"){$data='style=color:rgb(0,255,0)';}
	      elseif($partieType=="LxQuizz"){$data='style=color:rgb(0,255,255)';}
	      else{$data='style=color:rgb(255,255,255)';}
	      return $data;
	}
	/*
   * La methode getName() identifie votre extension Twig, elle est obligatoire
   */
	  public function getName()
	  {
		return 'U';
	  }
	  public function testMaitre($user)
	  {
		$data='';
		$dateRef=$this->dateRefRepository->findOneById(1);
		if($dateRef->getRMDQ()!==Null && $user->getId()==$dateRef->getRMDQ()->getId()){
			 if($user->getSexe()==1){$data='style=margin-top:-50px src=../../../../web/bundles/GeneBundle/reine3.png alt=reine width=100% title=Reine de MDQ';}
			 else{$data='style=margin-top:-50px src=../../../../web/bundles/GeneBundle/roi2.png alt=roi width=100% title=Roi de MDQ';}
			 }
		elseif($dateRef->getSMDQ()!==Null && $user->getId()==$dateRef->getSMDQ()->getId()){
			 if($user->getSexe()==1){$data='style=margin-top:-50px src=../../../../web/bundles/GeneBundle/savant-F.png alt=Savante width=100% title=Savante de MDQ';}
			 else{$data='style=margin-top:-50px src=../../../../web/bundles/GeneBundle/savant-H.png alt=Savant width=100% title=Savant MDQ';}
			 }
		elseif($dateRef->getMMDQ()!==Null && $user->getId()==$dateRef->getMMDQ()->getId()){
			 if($user->getSexe()==1){$data='style=margin-top:-50px src=../../../../web/bundles/GeneBundle/ministre-F.png alt=ministre-F width=100% title=Ministre de Mdq';}
			 else{$data='style=margin-top:-50px src=../../../../web/bundles/GeneBundle/ministre-H.png alt=ministre-H width=100% title=Ministre de Mdq';}
			 }
		elseif($dateRef->getMuMDQ()!==Null && $user->getId()==$dateRef->getMuMDQ()->getId()){
			 if($user->getSexe()==1){$data='style=margin-top:-50px src=../../../../web/bundles/GeneBundle/virtuose-F.png alt=virtuose-F width=100% title=virtuose de MDQ';}
			 else{$data='style=margin-top:-50px src=../../../../web/bundles/GeneBundle/virtuose-H.png alt=virtuose-H width=100% title=virtuose de MDQ';}
			 }
		elseif($dateRef->getFfMDQ()!==Null && $user->getId()==$dateRef->getFfMDQ()->getId()){
			 if($user->getSexe()==1){$data='style=margin-top:-50px src=../../../../web/bundles/GeneBundle/nature-F.png alt=nature-F width=100% title=Ecologiste de MDQ';}
			 else{$data='style=margin-top:-50px src=../../../../web/bundles/GeneBundle/nature-H.png alt=nature-H width=100% title=Ecologiste de MDQ';}
			 }
		elseif($dateRef->getArMDQ()!==Null && $user->getId()==$dateRef->getArMDQ()->getId()){
			 if($user->getSexe()==1){$data='style=margin-top:-50px src=../../../../web/bundles/GeneBundle/peintre-F.png alt=peintre-F width=100% title=peintre de MDQ';}
			 else{$data='style=margin-top:-50px src=../../../../web/bundles/GeneBundle/peintre-H.png alt=peintre-H width=100% title=peintre de MDQ';}
			 }
		elseif($dateRef->getLxMDQ()!==Null && $user->getId()==$dateRef->getLxMDQ()->getId()){
			 if($user->getSexe()==1){$data='style=margin-top:-50px src=../../../../web/bundles/GeneBundle/globeT-F.png alt=globeT-F width=100% title=Globe-trotter de MDQ';}
			 else{$data='style=margin-top:-50px src=../../../../web/bundles/GeneBundle/globeT-H2.png alt=globeT-H2 width=100% title=Globe-trotter de MDQ';}
			 }
		return $data;
			 
			
	  
	  }
}