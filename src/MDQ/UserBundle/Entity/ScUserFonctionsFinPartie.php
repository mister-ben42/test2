<?php
			public function MajScTot($scUser, $dom1, $game, $scoreP)
			{
				if($game=='MasterQuizz'){$scTot=$scUser->getScTotMq()+$scoreP;
									$scUser->setScTotMq($scTot);}
				if($dom1=='MuQuizz'){$scTot=$scUser->getScTotMu()+$scoreP;
									$scUser->setScTotMu($scTot);}				
				elseif($dom1=='ArQuizz'){$scTot=$scUser->getScTotAr()+$scoreP;
									$scUser->setScTotAr($scTot);}
				elseif($dom1=='FfQuizz'){$scTot=$scUser->getScTotFf()+$scoreP;
									$scUser->setScTotFf($scTot);}
				elseif($dom1=='LxQuizz'){$scTot=$scUser->getScTotLx()+$scoreP;
									$scUser->setScTotLx($scTot);}
				elseif($dom1=='TvQuizz'){$scTot=$scUser->getScTotTv()+$scoreP;
									$scUser->setScTotTv($scTot);}
				elseif($dom1=='SexyQuizz'){$scTot=$scUser->getScTotSx()+$scoreP;
									$scUser->setScTotSx($scTot);}
				return $scTot;
			}
			public function MajScMoy($scUser, $dom1, $game, $scTot)
			{
				if($game=='MasterQuizz'){$scUser->setScMoyMq($scTot/($scUser->getNbPMq()+1));}
				if($dom1=='MuQuizz'){$scUser->setScMoyMu($scTot/($scUser->getNbPMu()+1));}
				elseif($dom1=='ArQuizz'){$scUser->setScMoyAr($scTot/($scUser->getNbPAr()+1));}
				elseif($dom1=='FfQuizz'){$scUser->setScMoyFf($scTot/($scUser->getNbPFf()+1));}
				elseif($dom1=='LxQuizz'){$scUser->setScMoyLx($scTot/($scUser->getNbPLx()+1));}
				elseif($dom1=='TvQuizz'){$scUser->setScMoyTv($scTot/($scUser->getNbPTv()+1));}
				elseif($dom1=='SexyQuizz'){$scUser->setScMoySx($scTot/($scUser->getNbPSx()+1));}
				return;// VERIFIER FORMULE AU DESSUS, SI BESOIN du +1.
			}
			public function TestScMax($scUser, $dom1, $game, $scP, $date)
			{
				if($game=='MasterQuizz' and $scP>$scUser->getScMaxMQ()){$scUser->setScMaxMQ($scP);
																		$scUser->setDatescMaxMq($date);}
				if($dom1=='MuQuizz' and $scP>$scUser->getScMaxMu()){$scUser->setScMaxMu($scP);}
				elseif($dom1=='ArQuizz' and $scP>$scUser->getScMaxAr()){$scUser->setScMaxAr($scP);}
				elseif($dom1=='FfQuizz' and $scP>$scUser->getScMaxFf()){$scUser->setScMaxFf($scP);}
				elseif($dom1=='LxQuizz' and $scP>$scUser->getScMaxLx()){$scUser->setScMaxLx($scP);}				
				elseif($dom1=='TvQuizz' and $scP>$scUser->getScMaxTv()){$scUser->setScMaxTv($scP);}
				elseif($dom1=='SexyQuizz' and $scP>$scUser->getScMaxSx()){$scUser->setScMaxSx($scP);}
				return;
			}
			public function TestScDayAndWeek($scUser, $dom1, $game, $scP)
			{
				$test=0;
				if($game=='MasterQuizz'){
					if($scUser->getScofDayMq()==NULL or $scP>$scUser->getScofDayMq()){$scUser->setScofDayMq($scP);$test=1;}
				}
				if($dom1=='MuQuizz'){
					if($scUser->getScofDayMu()==NULL or $scP>$scUser->getScofDayMu()){$scUser->setScofDayMu($scP);$test=1;}
					if($scUser->getScofWeekMu()==NULL or $scP>$scUser->getScofWeekMu()){$scUser->setScofWeekMu($scP);}
				}				
				elseif($dom1=='ArQuizz'){
					if($scUser->getScofDayAr()==NULL or $scP>$scUser->getScofDayAr()){$scUser->setScofDayAr($scP);$test=1;}
					if($scUser->getScofWeekAr()==NULL or $scP>$scUser->getScofWeekAr()){$scUser->setScofWeekAr($scP);$test=1;}
				}
				elseif($dom1=='FfQuizz'){
					if($scUser->getScofDayFf()==NULL or $scP>$scUser->getScofDayFf()){$scUser->setScofDayFf($scP);$test=1;}
					if($scUser->getScofWeekFf()==NULL or $scP>$scUser->getScofWeekFf()){$scUser->setScofWeekFf($scP);$test=1;}
				}
				elseif($dom1=='LxQuizz'){
					if($scUser->getScofDayLx()==NULL or $scP>$scUser->getScofDayLx()){$scUser->setScofDayLx($scP);$test=1;}
					if($scUser->getScofWeekLx()==NULL or $scP>$scUser->getScofWeekLx()){$scUser->setScofWeekLx($scP);$test=1;}
				}
				elseif($dom1=='TvQuizz'){
					if($scUser->getScofDayTv()==NULL or $scP>$scUser->getScofDayTv()){$scUser->setScofDayTv($scP);$test=1;}
				}
				elseif($dom1=='SexyQuizz'){
					if($scUser->getScofDaySx()==NULL or $scP>$scUser->getScofDaySx()){$scUser->setScofDaySx($scP);$test=1;}
				}
				return $test;
			}
			public function MajsumTop5($scUser, $scP)
			{
				$top5week=$scUser->getTop5weekMq();	// test du classement semaine			
				if($scP>$top5week[0]){
				$top5week[0]=$scP;
				$scUser->setTop5weekMq($top5week);
				$scUser->setSumtop5weekMq(array_sum($top5week));
				}
				return;
			}
			public function MajTM($scUser, $dom1, $scP)
			{
				if($dom1=='ArQuizz'){$scQM1=$scP;}
				else{$scQM1=$scUser->getScofDayAr();if($scQM1==null){$scQM1==0;}}
				if($dom1=='FfQuizz'){$scQM2=$scP;}
				else{$scQM2=$scUser->getScofDayFf();if($scQM2==null){$scQM2==0;}}
				if($dom1=='MuQuizz'){$scQM3=$scP;}
				else{$scQM3=$scUser->getScofDayMu();if($scQM3==null){$scQM3==0;}}
				if($dom1=='LxQuizz'){$scQM4=$scP;}
				else{$scQM4=$scUser->getScofDayLx();if($scQM4==null){$scQM4==0;}}
				$scTMactu=$scUser->getScofDayTM();if($scTMactu==null){$scTMactu==0;}
				$tab3topsc=[$scQM1,$scQM2,$scQM3,$scQM4];
				rsort($tab3topsc);
				$testTM=$tab3topsc[0]+$tab3topsc[1]+$tab3topsc[2];
				if($testTM>$scTMactu){$scUser->setScofDayTM($testTM);}
				if($scUser->getScMaxTM()==null or $testTM>$scUser->getScMaxTM()){$scUser->setScMaxTM($testTM);}
				return;
			}	
			public function MajKingMaster($scUser)
			{
				if($scUser->getScofWeekMu()!=Null){$tabTM[0]=$scUser->getScofWeekMu();}
				else{$tabTM[0]=0;}
				if($scUser->getScofWeekAr()!=Null){$tabTM[1]=$scUser->getScofWeekAr();}
				else{$tabTM[1]=0;}
				if($scUser->getScofWeekFf()!=Null){$tabTM[2]=$scUser->getScofWeekFf();}
				else{$tabTM[2]=0;}
				if($scUser->getScofWeekLx()!=Null){$tabTM[3]=$scUser->getScofWeekLx();}
				else{$tabTM[3]=0;}
				//$tabTM=[$scUser->getScofWeekMu(),$scUser->getScofWeekAr(),$scUser->getScofWeekFf(),$scUser->getScofWeekLx()];
				rsort($tabTM);
				$kingMaster=$scUser->getSumtop5weekMq()+$tabTM[0]+$tabTM[1]+$tabTM[2];
				if($kingMaster>$scUser->getKingMaster()){$scUser->setKingMaster($kingMaster);}
				if($kingMaster>$scUser->getHighScKM()){$scUser->setHighScKM($kingMaster);}
				return;
			}

?>