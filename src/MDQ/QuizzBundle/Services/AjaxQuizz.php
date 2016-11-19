<?php

namespace MDQ\QuizzBundle\Services;


class AjaxQuizz
{    

	public function dataEditQ($data)
	{
		$tablamlg=array($data['brep'],$data['mrep1'],$data['mrep2'],$data['mrep3']);	
		shuffle($tablamlg);
		$datab['id']=$data['id'];
		$datab['intitule']=$data['intitule']; 
		$datab['rep1']=$tablamlg[0];
		$datab['rep2']=$tablamlg[1];
		$datab['rep3']=$tablamlg[2];
		$datab['rep4']=$tablamlg[3];
		$datab['dom1']=$data['dom1'];
		$datab['theme']=$data['theme']; 
		$datab['diff']=$data['diff'];
		$datab['type']=$data['type'];
		$datab['media']=$data['media'];		
	return $datab;
	}
	public function analyseReq($request)
	{
	  $requete['idQ'] = $request->request->get('idQ');
	  $requete['rep'] = $request->request->get('rep');
	  $requete['numQ'] = $request->request->get('numQ');
	  $requete['tpsrep'] = $request->request->get('temps');
	return $requete;
	}
	public function dataVerifQ($question, $newscore, $scoreQ, $finP)
	{
		$datab['brep']=$question->getBrep();
		$prepacom=($question->getCommentaire());
		$datab['commentaire']=$prepacom;//Permet Le/n dans MySql euh non !
		$datab['scoreQ']=$scoreQ;
		$datab['score']=$newscore;
		$datab['id']=$question->getId();
		$datab['finP']=$finP;
		$datab['imageCom']=$question->getImageCom();
		$datab['dom1']=$question->getDom1();
		return $datab;
	}
	public function getTypeVerifR($dom1)
	{
		if($dom1=='Histoire' || $dom1=='Géographie' || $dom1=='Sciences et nature' || $dom1=='Arts et Littérature' || $dom1=='Sports et loisirs' || $dom1=='Divers')
		{$type['game']='MasterQuizz'; $type['nbQparP']=10; $type['dom1']=$dom1;}
		elseif($dom1=='SexyQuizz'){$type['game']='QuizzenFolie'; $type['dom1']='SexyQuizz';$type['nbQparP']=8;}
		elseif($dom1=='TvQuizz'){$type['game']='QuizzenFolie'; $type['dom1']='TvQuizz';$type['nbQparP']=8;}
		elseif($dom1=='MuQuizz'){$type['game']='MediaQuizz'; $type['dom1']='MuQuizz';$type['nbQparP']=8;}
		elseif($dom1=='ArQuizz'){$type['game']='MediaQuizz'; $type['dom1']='ArQuizz';$type['nbQparP']=8;}
		elseif($dom1=='FfQuizz'){$type['game']='MediaQuizz'; $type['dom1']='FfQuizz';$type['nbQparP']=8;}
		elseif($dom1=='LxQuizz'){$type['game']='MediaQuizz'; $type['dom1']='LxQuizz';$type['nbQparP']=8;}
		return $type;
	}
	public function calcScVerifR($requete, $repQ, $game)
	{
		if ($requete['rep']!=$repQ){				
					$scoreQ=0;
				}
				else {						
					if($game=='MasterQuizz')
					{
						$tabscore=[100,200,500,1000,2000];			
						$tabdiff=[1,2,2,3,3,3,4,4,5,5];
						$scdebase=$tabscore[($tabdiff[$requete['numQ']-1])-1];
					}
					else{$scdebase=1000;}
				  $bonus=round(($scdebase/2*$requete['tpsrep']/150),0);
				  $scoreQ=$scdebase+$bonus;
				}
		return $scoreQ;
	}
	public function testfinP($numQ, $nbQgame)
	{
		if($numQ==$nbQgame){$finP=1;}
		else{$finP=0;}
		return $finP;
	}
	public function testSession($session)
	{
		$data=0;
		if($session->get('page')!='Mquizz'){$data=1;}
		return $data;
	}
}


