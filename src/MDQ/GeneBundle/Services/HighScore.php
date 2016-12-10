<?php

namespace MDQ\GeneBundle\Services;


class HighScore
{    

	public function getFunctions(){// voir si possible d'envoyer à twig
		return array(
		  'test'=> new \Twig_Function_Method($this, 'test')
	      );
	}
	public function test($data)
	{
	      return "test concluant !";
	}
	public function editTxt($crit)
	{
	$data['crit']=$crit;
	if ($crit=="scTotMq") {$data['titre1']="Score Total";
			       $data['titre2']="au MasterQuizz";
			       $data['aide']="Somme des scores de toutes les parties au MasterQuizz";
			       $data['nomPage']="highScore";
			       }
	else if ($crit=="scofDayMq") {$data['titre1']="Score du jour";
			            $data['titre2']="au MasterQuizz";
			            $data['aide']="Meilleur score au MasterQuizz dans la journée en cours";
				    $data['nomPage']="highScore";
			            }
	else if ($crit=="scMoyMq") {$data['titre1']="Score moyen";
			            $data['titre2']="au MasterQuizz";
			            $data['aide']="Pour figurer dans ce classement, il faut avoir jouer au moins 10 parties au MasterQuizz";
				    $data['nomPage']="highScore";
			            }
	else if ($crit=="prctBrtotMq") {$data['titre1']="% de bonnes réponses";
			            $data['titre2']="au MasterQuizz";
			            $data['aide']="Pour figurer dans ce classement, il faut avoir répondu à plus de 100 questions au MasterQuizz";
				    $data['nomPage']="highScore";
			            }
	else if ($crit=="scMaxMq") {$data['titre1']="Meilleur score";
			            $data['titre2']="au MasterQuizz";
			            $data['aide']="Score Maximal réalisé lors d'une partie au MasterQuizz";
				    $data['nomPage']="highScore";
			            }	
	else if ($crit=="nbPMq") {$data['titre1']="Nombre de parties jouées";
			            $data['titre2']="au MasterQuizz";
			            $data['aide']="C'est le nombre total de parties jouées au MasterQuizz";
				    $data['nomPage']="highScore";
			            }		
	else if ($crit=="nbQtotMq") {$data['titre1']="Nombre de questions jouées";
			            $data['titre2']="au MasterQuizz";
			            $data['aide']="C'est le nombre total de questions jouées au MasterQuizz";
				    $data['nomPage']="highScore";
			            }	
	else if ($crit=="nbBrtotMq") {$data['titre1']="Nombre de bonnes réponses";
			            $data['titre2']="au MasterQuizz";
			            $data['aide']="C'est le nombre total de bonnes réponses données au MasterQuizz";
				    $data['nomPage']="highScore";
			            }	
	else if ($crit=="prctBrhMq") {$data['titre1']="% de bonnes réponses";
			            $data['titre2']="Catégorie Histoire";
			            $data['aide']="Pour figurer dans ce classement, il faut avoir répondu à 50 questions de la catégorie \"Histoire\" au MasterQuizz";
				    $data['nomPage']="highScore";
			            }	
	else if ($crit=="prctBrgMq") {$data['titre1']="% de bonnes réponses";
			            $data['titre2']="Catégorie Géographie";
			            $data['aide']="Pour figurer dans ce classement, il faut avoir répondu à 50 questions de la catégorie \"Géographie\" au MasterQuizz";
				    $data['nomPage']="highScore";
			            }	
	else if ($crit=="prctBrdMq") {$data['titre1']="% de bonnes réponses";
			            $data['titre2']="Catégorie Divers";
			            $data['aide']="Pour figurer dans ce classement, il faut avoir répondu à 50 questions de la catégorie \"Divers\" au MasterQuizz";
				    $data['nomPage']="highScore";
			            }	
	else if ($crit=="prctBrslMq") {$data['titre1']="% de bonnes réponses";
			            $data['titre2']="Catégorie Sports et loisirs";
			            $data['aide']="Pour figurer dans ce classement, il faut avoir répondu à 50 questions de la catégorie \"Sports et loisirs\" au MasterQuizz";
				    $data['nomPage']="highScore";
			            }	
	else if ($crit=="prctBrsnMq") {$data['titre1']="% de bonnes réponses";
			            $data['titre2']="Catégorie Sciences et nature";
			            $data['aide']="Pour figurer dans ce classement, il faut avoir répondu à 50 questions de la catégorie \"Sciences et nature\" au MasterQuizz";
				    $data['nomPage']="highScore";
			            }	
	else if ($crit=="prctBralMq") {$data['titre1']="% de bonnes réponses";
			            $data['titre2']="Catégorie Art et Littérature";
			            $data['aide']="Pour figurer dans ce classement, il faut avoir répondu à 50 questions de la catégorie \"Art et Littérature\" au MasterQuizz"; 
				    $data['nomPage']="highScore";
			            }	
	else if ($crit=="MedMq") {$data['titre1']="Médailles";
			            $data['titre2']="MasterQuizz";
			            $data['aide']="Tableau des médailles au MasterQuizz"; 
			            $data['nomPage']='medailles'.$crit;
			            }	
	else if ($crit=="MedKm") {$data['titre1']="Médailles";
			           $data['titre2']="KingMaster";
			            $data['aide']="Tableau des médailles au KingMaster";
			            $data['nomPage']='medailles'.$crit; 
			            }	
	else if ($crit=="MedTM") {$data['titre1']="Médailles";
			            $data['titre2']="Expert Media";
			            $data['aide']="Tableau des médailles au classement Expert Média";
			            $data['nomPage']='medailles'.$crit; 
			            }	
	else if ($crit=="MedAr") {$data['titre1']="Médailles";
			            $data['titre2']="Quizz Art";
			            $data['aide']="Tableau des médailles au Quizz Art";
			            $data['nomPage']='medailles'.$crit; 
			            }	
	else if ($crit=="MedFf") {$data['titre1']="Médailles";
			            $data['titre2']="Quizz Nature";
			            $data['aide']="Tableau des médailles au Quizz Nature";
			            $data['nomPage']='medailles'.$crit; 
			            }	
	else if ($crit=="MedLx") {$data['titre1']="Médailles";
			            $data['titre2']="Lieux du Monde";
			            $data['aide']="Tableau des médailles au Quizz Lieux du Monde";
			            $data['nomPage']='medailles'.$crit; 
			            }	
	else if ($crit=="MedMu") {$data['titre1']="Médailles";
			            $data['titre2']="Quizz Musique";
			            $data['aide']="Tableau des médailles au Quizz Musique";
			            $data['nomPage']='Medailles'.$crit; 
			            }	
	else if ($crit=="totMed") {$data['titre1']="Nombre total";
			            $data['titre2']="de Médailles";
			            $data['aide']="Nombre total de médailles tous classements confondus";
			            $data['nomPage']="highScore";
			            }	
/*	else if ($crit=="scTotMq") {$data['titre1']==
			            $data['titre2']==
			            $data['aide']== 
			            }	
	else if ($crit=="scTotMq") {$data['titre1']==
			            $data['titre2']==
			            $data['aide']== 
			            }	
	else if ($crit=="scTotMq") {$data['titre1']==
			            $data['titre2']==
			            $data['aide']== 
			            }	
	else if ($crit=="scTotMq") {$data['titre1']==
			            $data['titre2']==
			            $data['aide']== 
			            }	*/
	else {$data['crit']="none";
	      $data['titre1']="none";
	      $data['titre2']="none";
	      $data['aide']="none";
	      $data['nomPage']="none";
	      }	
	
	  

	  return $data;
	}

/*

		&& $crit!="scofDayLx" && $crit!="scofDayAr"
		&& $crit!="scofDayFf"&& $crit!="scofDayMu" && $crit!="scofDayTM"  
		&& $crit!="scMoyLx" && $crit!="scMoyAr" && $crit!="scMoyFf"&& $crit!="scMoyMu"
		&& $crit!="scMaxLx" && $crit!="scMaxAr" && $crit!="scMaxFf"&& $crit!="scMaxMu"
		&& $crit!="scMaxTM" && $crit!="kingMaster"
 && $crit!="highScKM" && $crit!="nbQvalid"
		&& $crit!="nbBrtot" &&  
*/
	public function pagination($nbParPage, $nbHighSc, $page )
	{
	      $pagi['nbParPage']=$nbParPage;
	      $pagi['page']=$page;
	      if($nbHighSc==0){$pagi['nbPage']=1;}
	      else {$pagi['nbPage']=ceil($nbHighSc/$nbParPage);}
	      if($page<4)
	      {
		      $pagi['page_min']=1;
		      if($pagi['nbPage']<7){$pagi['page_max']=$pagi['nbPage'];}
		      else{$pagi['page_max']=7;}      
	      }
	      elseif ($page>($pagi=['nbPage']-4))
	      {
		      $pagi['page_max']=$pagi['nbPage'];
		      if($pagi['nbPage']<7){$pagi['page_min']=1;}
		      else{$pagi['page_min']=$pagi['nbPage']-6;}	      
	      }
	      else
	      {
		      $pagi['page_min']=$pagi['nbPage']-3;
		      $pagi['page_max']=$pagi['nbPage']+3;
	      }
	      return $pagi;
	}
	public function defPage($id, $highScoreTous, $nbparPage)
	{
	      	$i=0;$j=0;
		foreach($highScoreTous as $user)
			{
				if($j==0){$i++;}
				if($user['id']==$id){$j=1;}
			}
		if($j==0){$i=1;}// en fait si score du joeur pas présent, on commence par les premiers.

		$rang=$i;
		$page=ceil($rang/$nbparPage);//arrondit a l'unite superieure.
		return $page;
	}
}

