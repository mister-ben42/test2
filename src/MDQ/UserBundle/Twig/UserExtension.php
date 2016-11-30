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
		  'testSup99Mq'=> new \Twig_Function_Method($this, 'testSup99Mq'),
		  'testInfobulle99'=> new \Twig_Function_Method($this, 'testInfobulle99'),
		  'testPropQ'=> new \Twig_Function_Method($this, 'testPropQ'),
		  'txtRefusPropQ'=> new \Twig_Function_Method($this, 'txtRefusPropQ'),
		  'phraseQaval'=> new \Twig_Function_Method($this, 'phraseQaval'),
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
	    if($data==0){$balise='bundles/UserBundle/Med0.png';}
	    elseif($data<6)
	    {
		  $balise='bundles/UserBundle/Med'.$type.$data.'.png';
	    }
	    else
	    {
		  $balise='bundles/UserBundle/Med'.$type.'5.png';
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
			 if($user->getSexe()==1){$data='bundles/GeneBundle/reine3.png';}
			 else{$data='bundles/GeneBundle/roi2.png';}
			 }
		elseif($dateRef->getSMDQ()!==Null && $user->getId()==$dateRef->getSMDQ()->getId()){
			 if($user->getSexe()==1){$data='bundles/GeneBundle/savant-F.png';}
			 else{$data='bundles/GeneBundle/savant-H.png';}
			 }
		elseif($dateRef->getMMDQ()!==Null && $user->getId()==$dateRef->getMMDQ()->getId()){
			 if($user->getSexe()==1){$data='bundles/GeneBundle/ministre-F.png';}
			 else{$data='bundles/GeneBundle/ministre-H.png';}
			 }
		elseif($dateRef->getMuMDQ()!==Null && $user->getId()==$dateRef->getMuMDQ()->getId()){
			 if($user->getSexe()==1){$data='bundles/GeneBundle/virtuose-F.png';}
			 else{$data='bundles/GeneBundle/virtuose-H.png';}
			 }
		elseif($dateRef->getFfMDQ()!==Null && $user->getId()==$dateRef->getFfMDQ()->getId()){
			 if($user->getSexe()==1){$data='bundles/GeneBundle/nature-F.png';}
			 else{$data='bundles/GeneBundle/nature-H.png';}
			 }
		elseif($dateRef->getArMDQ()!==Null && $user->getId()==$dateRef->getArMDQ()->getId()){
			 if($user->getSexe()==1){$data='bundles/GeneBundle/peintre-F.png';}
			 else{$data='bundles/GeneBundle/peintre-H.png';}
			 }
		elseif($dateRef->getLxMDQ()!==Null && $user->getId()==$dateRef->getLxMDQ()->getId()){
			 if($user->getSexe()==1){$data='bundles/GeneBundle/globeT-F.png';}
			 else{$data='bundles/GeneBundle/globeT-H2.png';}
			 }
		return $data;			
	  
	  }
	  public function testSup99Mq($nbQMq, $data)
	  {
		if($nbQMq<100){$data="-";}
		return $data;
	  }
	  public function testInfobulle99($nbQMq)
	  {
		if($nbQMq<100){$data='class=infobulle';}
		else{$data="";}
		return $data;
	  }
	  public function testPropQ($nbPMq, $nbQaval7j, $gestionPropQ)
	  {
		$test=1;
		if($nbPMq<5){$test=0;}
		elseif($nbQaval7j>4){$test=0;}
		elseif($gestionPropQ==0){$test=0;}
		return $test;
	  
	  }
	  public function txtRefusPropQ($nbPMq, $nbQaval7j, $gestionPropQ)// il faudra que je rajoute l'autorisation du joueur connecté.
	  {
		if($gestionPropQ==0){$txt="Il n'est pas possible de proposer des questions actuellement.";}
		elseif($nbPMq<5){$txt="Il faut avoir joué au moins 5 parties pour pouvoir proposer des questions.";}
		elseif($nbQaval7j>4){$txt="Vous ne pouvez pas proposer plus de 5 questions par semaine.";}
		else{$txt="Non autorisé.";}
		return $txt;
	  }
	  public function phraseQaval($nbQProp, $nbQval)
	  {
		if($nbQProp==0){$txt="Vous n'avez proposé aucune question.";}
		else{
		      if($nbQProp==1){$txt1='Vous avez proposé 1 question ';}
		      else{$txt1='Vous avez poposé '.$nbQProp.' questions ';}
		      if($nbQval==0){$txt2='et aucune n\'a été validée.';}
		      elseif($nbQval==1){$txt2='et 1 a été validée.';}
		      else{$txt2='et '.$nbQval.' ont été validées.';}
		      $txt=$txt1.$txt2;
		 }
		
		return $txt;
	  
	  
	  }
}


