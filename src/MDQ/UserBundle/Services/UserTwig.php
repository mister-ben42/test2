<?php
// src/MDQ/UserBundle/Service/UserTwig.php

namespace MDQ\UserBundle\Services;

use MDQ\UserBundle\Entity\User;

class UserTwig
{

	private $dateRefRepository;
 
	public function __construct($dateRefRepository ) {
	  $this->dateRefRepository = $dateRefRepository ;
	}


	public function tabMedailles($data, $type)
	{
	    if($data==0){$balise='bundles/mdquser/images/Med0.png';}
	    elseif($data<6)
	    {
		  $balise='bundles/mdquser/images/Med'.$type.$data.'.png';
	    }
	    else
	    {
		  $balise='bundles/mdquser/images/Med'.$type.'5.png';
	    }
            return $balise;
	}
	public function spanMed($data)
	{
	    if($data<6){$data='';}
	    return $data;
	}	

	public function affichePartieType($partieType)
	{
	      if($partieType=="MasterQuizz"){$data='MasterQuizz';}
	      elseif($partieType=="FfQuizz"){$data='Quizz Nature';}
	      elseif($partieType=="LxQuizz"){$data='Quizz Géo';}
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
	  public function testMaitre(User $user)
	  {
		$data='';
		$dateRef=$this->dateRefRepository->findOneById(1);
		if($dateRef->getRMDQ()!==Null && $user->getId()==$dateRef->getRMDQ()->getId()){
			 if($user->getSexe()==1){$data='bundles/mdqgene/images/reine3.png';}
			 else{$data='bundles/mdqgene/images/roi2.png';}
			 }
		elseif($dateRef->getSMDQ()!==Null && $user->getId()==$dateRef->getSMDQ()->getId()){
			 if($user->getSexe()==1){$data='bundles/mdqgene/images/savant-F.png';}
			 else{$data='bundles/mdqgene/images/savant-H.png';}
			 }
		elseif($dateRef->getCMDQ()!==Null && $user->getId()==$dateRef->getCMDQ()->getId()){
			 if($user->getSexe()==1){$data='bundles/mdqgene/images/capitaine-F.png';}
			 else{$data='bundles/mdqgene/images/capitaine-H.png';}
			 }
		elseif($dateRef->getMuMDQ()!==Null && $user->getId()==$dateRef->getMuMDQ()->getId()){
			 if($user->getSexe()==1){$data='bundles/mdqgene/images/virtuose-F.png';}
			 else{$data='bundles/mdqgene/images/virtuose-H.png';}
			 }
		elseif($dateRef->getFfMDQ()!==Null && $user->getId()==$dateRef->getFfMDQ()->getId()){
			 if($user->getSexe()==1){$data='bundles/mdqgene/images/nature-F.png';}
			 else{$data='bundles/mdqgene/images/nature-H.png';}
			 }
		elseif($dateRef->getArMDQ()!==Null && $user->getId()==$dateRef->getArMDQ()->getId()){
			 if($user->getSexe()==1){$data='bundles/mdqgene/images/peintre-F.png';}
			 else{$data='bundles/mdqgene/images/peintre-H.png';}
			 }
		elseif($dateRef->getLxMDQ()!==Null && $user->getId()==$dateRef->getLxMDQ()->getId()){
			 if($user->getSexe()==1){$data='bundles/mdqgene/images/globeT-F.png';}
			 else{$data='bundles/mdqgene/images/globeT-H2.png';}
			 }
		elseif($dateRef->getWzMDQ()!==Null && $user->getId()==$dateRef->getWzMDQ()->getId()){
			 if($user->getSexe()==1){$data='bundles/mdqgene/images/paparazzi-F.png';}
			 else{$data='bundles/mdqgene/images/paparazzi-H.png';}
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
	public function retourQavalTxt($repAdmin, $Qretour)
	{
		if($repAdmin==0 || $Qretour>0){$txt="En attente";}
		elseif($repAdmin<10){$txt="Refusée";}
		elseif($repAdmin==100){$txt="Validée";}
		return $txt;	
	}
	public function retourQavalColor($repAdmin, $Qretour)
	{
		if($repAdmin==0 || $Qretour>0){$color="rgb(255,255,0);";}
		elseif($repAdmin<10){$color="rgb(255,0,0);";}
		elseif($repAdmin==100){$color="rgb(0,255,0);";}
		return $color;	
	}	
}


