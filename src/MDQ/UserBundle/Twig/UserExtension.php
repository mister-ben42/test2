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
		  'sexe' => new \Twig_Function_Method($this, 'calculSexe'),
		  'tabMed' => new \Twig_Function_Method($this, 'tabMedailles'),
		  'affichPartie' => new \Twig_Function_Method($this, 'affichPartieType'),
		  'testMaitre' => new \Twig_Function_Method($this, 'testMaitre'),
	      );
	}
	    public function getFilters()
	{
	    return array(
		'chgeNull' => new \Twig_Filter_Method($this, 'chgeNullto0')
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
		if ($sexe==1) {$sex='<span id="sexe_femme">Femme</span>';}
		else if($sexe==0) {$sex='<span id="sexe_homme">Homme</span>';}
		else {$sex='<span id="sexe_homme">No sex</span>';}
		return $sex;
	}

	public function tabMedailles($data, $type)
	{
	    if($data==0){$balise="";}
	    elseif($data<6)
	    {
		  $balise='<img src="../../../../web/bundles/UserBundle/Med'.$type.$data.'.png" alt="Med" width="60px">';
	    }
	    else
	    {
		  $balise='<img src="../../../../web/bundles/UserBundle/Med'.$type.'5.png" alt="Med" width="60px"><div class="user_tab_med">'.$data.'</div>';
	    }
            return $balise;
	}
	public function chgeNullto0($data)
	{
	    if($data===Null){$data=0;}
	    
	    return $data;
	}
	public function affichPartieType($partieType)
	{
	      if($partieType=="MasterQuizz"){$data='<span style="color:rgb(255,255,0);">MasterQuizz</span>';}
	      elseif($partieType=="FfQuizz"){$data='<span style="color:rgb(0,255,0);">Quizz Nature</span>';}
	      elseif($partieType=="LxQuizz"){$data='<span style="color:rgb(0,255,255);">Lieux du monde</span>';}
	      else{$data='<span style="color:rgb(255,255,255);">Autre</span>';}
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
		if($user->getId()==$dateRef->getRMDQ()->getId()){
			 if($user->getSexe()==1){$data='<img style="margin-top:-50px" src="../../../../web/bundles/GeneBundle/reine3.png" alt="reine" width="100%" title="Reine de MDQ">';}
			 else{$data='<img style="margin-top:-50px" src="../../../../web/bundles/GeneBundle/roi2.png" alt="roi" width=100% title="Roi de MDQ">';}
			 }
		return $data;
			 
			
	  
	  }
}