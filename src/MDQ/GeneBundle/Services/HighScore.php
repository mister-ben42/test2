<?php

namespace MDQ\GeneBundle\Services;


class HighScore
{    


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
			            $data['aide']="Score maximal réalisé lors d'une partie au MasterQuizz";
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
	else if ($crit=="MedCq") {$data['titre1']="Médailles";
			            $data['titre2']="Quizz du Capitaine";
			            $data['aide']="Tableau des médailles au classement du Quizz du Capitaine";
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
			            $data['titre2']="Quizz Géo";
			            $data['aide']="Tableau des médailles au Quizz Géo";
			            $data['nomPage']='medailles'.$crit; 
			            }	
	else if ($crit=="MedWz") {$data['titre1']="Médailles";
			            $data['titre2']="Quizz Wouzou";
			            $data['aide']="Tableau des médailles au Quizz Wouzou";
			            $data['nomPage']='medailles'.$crit; 
			            }		
	else if ($crit=="MedMu") {$data['titre1']="Médailles";
			            $data['titre2']="Quizz Musique";
			            $data['aide']="Tableau des médailles au Quizz Musique";
			            $data['nomPage']='medailles'.$crit; 
			            }	
	else if ($crit=="totMed") {$data['titre1']="Nombre total";
			            $data['titre2']="de Médailles";
			            $data['aide']="Nombre total de médailles tous classements confondus";
			            $data['nomPage']="highScore";
			            }	
	else if ($crit=="scofDayCq") {$data['titre1']="Score du jour";
			            $data['titre2']="au Score du Capitaine";
			            $data['aide']="Le score du Capitaine est égal à la somme des scores aux Quizz Géo, Nature, Art et Wouzou";
			            $data['nomPage']="highScore";
			            }	
	else if ($crit=="scMaxCq") {$data['titre1']="Meilleur score";
			            $data['titre2']="au Score du Capitaine";
			            $data['aide']="Le score du Capitaine est égal à la somme des scores aux Quizz Géo, Nature, Art et Wouzou";
			            $data['nomPage']="highScore";
			            }	
	else if ($crit=="scofDayFf") {$data['titre1']="Score du jour";
			            $data['titre2']="au Quizz Nature";
			            $data['aide']="Meilleur score au Quizz Nature dans la journée en cours";
			            $data['nomPage']="highScore";
			            }	
	else if ($crit=="scMaxFf") {$data['titre1']="Meilleur score";
			            $data['titre2']="au Quizz Nature";
			            $data['aide']="Score Maximal réalisé lors d'une partie au Quizz Nature";
			            $data['nomPage']="highScore";
			            }
	else if ($crit=="scofDayLx") {$data['titre1']="Score du jour";
			            $data['titre2']="au Quizz Géo";
			            $data['aide']="Meilleur score au Quizz Nature dans la journée en cours";
			            $data['nomPage']="highScore";
			            }	
	else if ($crit=="scMaxLx") {$data['titre1']="Meilleur score";
			            $data['titre2']="au Quizz Géo";
			            $data['aide']="Score Maximal réalisé lors d'une partie au Quizz Nature";
			            $data['nomPage']="highScore";			            
			            }
	else if ($crit=="scofDayWz") {$data['titre1']="Score du jour";
			            $data['titre2']="au Quizz Wouzou";
			            $data['aide']="Meilleur score au Quizz Nature dans la journée en cours";
			            $data['nomPage']="highScore";
			            }	
	else if ($crit=="scMaxWz") {$data['titre1']="Meilleur score";
			            $data['titre2']="au Quizz Wouzou";
			            $data['aide']="Score Maximal réalisé lors d'une partie au Quizz Wouzou";
			            $data['nomPage']="highScore";
			            }
	else if ($crit=="scofDayAr") {$data['titre1']="Score du jour";
			            $data['titre2']="au Quizz Art";
			            $data['aide']="Meilleur score au Quizz Nature dans la journée en cours";
			            $data['nomPage']="highScore";
			            }	
	else if ($crit=="scMaxAr") {$data['titre1']="Meilleur score";
			            $data['titre2']="au Quizz Art";
			            $data['aide']="Score Maximal réalisé lors d'une partie au Quizz Nature";
			            $data['nomPage']="highScore";
			            }	
	else if ($crit=="kingMaster") {$data['titre1']="Score actuel";
			            $data['titre2']="au Tournoi Royal";
			            $data['aide']="Score actuel au Tournoi Royal";
			            $data['nomPage']="highScore";
			            }	
	else if ($crit=="highScKM") {$data['titre1']="Meilleur score";
			            $data['titre2']="au Tournoi Royal";
			            $data['aide']="Score Maximal réalisé au Tournoi Royal";
			            $data['nomPage']="highScore";
			            }	
	else if ($crit=="nbBrTot") {$data['titre1']="Nombre total";
			            $data['titre2']="de bonnes réponses";
			            $data['aide']="Nombre total de bonnes réponses données dans tous les jeux du Monde Du Quizz";
			            $data['nomPage']="highScore";
			            }				
			            /*	else if ($crit=="scTotMq") {$data['titre1']=
			            $data['titre2']=
			            $data['aide']=
			            }	
	else if ($crit=="scTotMq") {$data['titre1']=
			            $data['titre2']=
			            $data['aide']=
			            }	*/
	else {$data['crit']="none";
	      $data['titre1']="none";
	      $data['titre2']="none";
	      $data['aide']="none";
	      $data['nomPage']="none";
	      }	
	
	  

	  return $data;
	}

	public function pagination($nbParPage, $nbHighSc, $page )
	{
	      $pagi['nbParPage']=$nbParPage;
	      $pagi['page']=$page;
	      if($nbHighSc==0){$pagi['nbPage']=1;}
	      else {$pagi['nbPage']=ceil($nbHighSc/$nbParPage);}
	      if($page<4)
	      {
		      $pagi['page_min']=1;
		      if($pagi['nbPage']<5){$pagi['page_max']=$pagi['nbPage'];}
		      else{$pagi['page_max']=5;}      
	      }
	      elseif($page>($pagi['nbPage']-3))
	      {
		      $pagi['page_max']=$pagi['nbPage'];
		      if($pagi['nbPage']<5){$pagi['page_min']=1;}
		      else{$pagi['page_min']=$pagi['nbPage']-4;}	      
	      }
	      else
	      {
		      $pagi['page_min']=$pagi['page']-2;
		      $pagi['page_max']=$pagi['page']+2;
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

