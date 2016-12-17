<?php

namespace MDQ\QuestionBundle\Services;



class PropQ
{    
 	
 

      public function affichRepAdmin($rep)
      {
		$txt="";
		if($rep==10){$txt="Corriger les fautes d'orthographe et de syntaxe.";}
		elseif($rep==11){$txt="Revoir la formulation";}
		elseif($rep==12){$txt="Développer le commentaire";}		
		elseif($rep==13){$txt="Choisir des propositions de réponses plus pertienetes.";}
		return $txt;
      }
  
}

