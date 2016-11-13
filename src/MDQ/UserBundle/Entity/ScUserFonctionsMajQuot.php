<?php
	function testEqual($clsmt, $scUser, $i, $h, $sc)
		{
			if($clsmt=='KingMaster' && $scUser->getKingMaster()==$sc){$j=$h;}
			elseif($clsmt=='scofDayMq' && $scUser->getScofDayMq()==$sc){$j=$h;}
			elseif($clsmt=='TotalMedia' && $scUser->getScofDayTM()==$sc){$j=$h;}
			elseif($clsmt=='MuQuizz' && $scUser->getScofDayMu()==$sc){$j=$h;}
			elseif($clsmt=='ArQuizz' && $scUser->getScofDayAr()==$sc){$j=$h;}
			elseif($clsmt=='FfQuizz' && $scUser->getScofDayFf()==$sc){$j=$h;}
			elseif($clsmt=='LxQuizz' && $scUser->getScofDayLx()==$sc){$j=$h;}
			else{$j=$i;}
			return $j;
		}
		function majHighScore($clsmt, $scUser, $j)
		{
			if($clsmt=='KingMaster')
			{
				if($scUser->getHighClassKM()===NULL || $j<$scUser->getHighClassKM()){
					$scUser->setHighClassKM($j);
					$scUser->setNumHighClassKM(1);
				}
				else if($j==$scUser->getHighClassKM()){			
					$scUser->setNumHighClassKM($scUser->getNumHighClassKM()+1);					
				}
			}
			elseif($clsmt=='scofDayMq')
			{
				if($scUser->getHighClassDayMq()===NULL || $j<$scUser->getHighClassDayMq()){
					$scUser->setHighClassDayMq($j);
					$scUser->setNumHighClassDayMq(1);
				}
				else if($j==$scUser->getHighClassDayMq()){			
					$scUser->setNumHighClassDayMq($scUser->getNumHighClassDayMq()+1);					
				}
				
			}
			elseif($clsmt=='TotalMedia')
			{
				if($scUser->getHighClassDayTM()===NULL || $j<$scUser->getHighClassDayTM()){
					$scUser->setHighClassDayTM($j);
					$scUser->setNumHighClassDayTM(1);
				}
				else if($j==$scUser->getHighClassDayTM()){			
					$scUser->setNumHighClassDayTM($scUser->getNumHighClassDayTM()+1);					
				}	
			}
			elseif($clsmt=='MuQuizz')
			{
				if($scUser->getHighClassDayMu()===NULL || $j<$scUser->getHighClassDayMu()){
					$scUser->setHighClassDayMu($j);
					$scUser->setNumHighClassDayMu(1);
				}
				else if($j==$scUser->getHighClassDayMu()){			
					$scUser->setNumHighClassDayMu($scUser->getNumHighClassDayMu()+1);					
				}	
			}
			elseif($clsmt=='ArQuizz')
			{
				if($scUser->getHighClassDayAr()===NULL || $j<$scUser->getHighClassDayAr()){
					$scUser->setHighClassDayAr($j);
					$scUser->setNumHighClassDayAr(1);
				}
				else if($j==$scUser->getHighClassDayAr()){			
					$scUser->setNumHighClassDayAr($scUser->getNumHighClassDayAr()+1);					
				}	
			}
			elseif($clsmt=='FfQuizz')
			{
				if($scUser->getHighClassDayFf()===NULL || $j<$scUser->getHighClassDayFf()){
					$scUser->setHighClassDayFf($j);
					$scUser->setNumHighClassDayFf(1);
				}
				else if($j==$scUser->getHighClassDayFf()){			
					$scUser->setNumHighClassDayFf($scUser->getNumHighClassDayFf()+1);					
				}	
			}
			elseif($clsmt=='LxQuizz')
			{
				if($scUser->getHighClassDayLx()===NULL || $j<$scUser->getHighClassDayLx()){
					$scUser->setHighClassDayLx($j);
					$scUser->setNumHighClassDayLx(1);
				}
				else if($j==$scUser->getHighClassDayLx()){			
					$scUser->setNumHighClassDayLx($scUser->getNumHighClassDayLx()+1);					
				}	
			}
		}
		function majMedailles($clsmt, $scUser, $j)
		{
			$med=$scUser->getMedailles();
			$med->setTotMed($med->getTotMed()+1);
			if($clsmt=='KingMaster')
			{
				if($j==1){$med->setKm1($med->getKm1()+1);}
				elseif($j==2){$med->setKm2($med->getKm2()+1);}
				elseif($j==3){$med->setKm3($med->getKm3()+1);}
				elseif($j==4 || $j==5){$med->setKm4($med->getKm4()+1);}
				elseif($j>5 && $j<11){$med->setKm5($med->getKm5()+1);}
			}
			elseif($clsmt=='scofDayMq')
			{
				if($j==1){$med->setMq1($med->getMq1()+1);}
				elseif($j==2){$med->setMq2($med->getMq2()+1);}
				elseif($j==3){$med->setMq3($med->getMq3()+1);}
				elseif($j==4 || $j==5){$med->setMq4($med->getMq4()+1);}
				elseif($j>5 && $j<11){$med->setMq5($med->getMq5()+1);}
			}
			elseif($clsmt=='TotalMedia')
			{
				if($j==1){$med->setTm1($med->getTm1()+1);}
				elseif($j==2){$med->setTm2($med->getTm2()+1);}
				elseif($j==3){$med->setTm3($med->getTm3()+1);}
				elseif($j==4 || $j==5){$med->setTm4($med->getTm4()+1);}
				elseif($j>5 && $j<11){$med->setTm5($med->getTm5()+1);}
			}
			elseif($clsmt=='MuQuizz')
			{
				if($j==1){$med->setMu1($med->getMu1()+1);}
				elseif($j==2){$med->setMu2($med->getMu2()+1);}
				elseif($j==3){$med->setMu3($med->getMu3()+1);}
				elseif($j==4 || $j==5){$med->setMu4($med->getMu4()+1);}
				elseif($j>5 && $j<11){$med->setMu5($med->getMu5()+1);}
			}
			elseif($clsmt=='ArQuizz')
			{
				if($j==1){$med->setAr1($med->getAr1()+1);}
				elseif($j==2){$med->setAr2($med->getAr2()+1);}
				elseif($j==3){$med->setAr3($med->getAr3()+1);}
				elseif($j==4 || $j==5){$med->setAr4($med->getAr4()+1);}
				elseif($j>5 && $j<11){$med->setAr5($med->getAr5()+1);}
			}
			elseif($clsmt=='FfQuizz')
			{
				if($j==1){$med->setFf1($med->getFf1()+1);}
				elseif($j==2){$med->setFf2($med->getFf2()+1);}
				elseif($j==3){$med->setFf3($med->getFf3()+1);}
				elseif($j==4 || $j==5){$med->setFf4($med->getFf4()+1);}
				elseif($j>5 && $j<11){$med->setFf5($med->getFf5()+1);}
			}
			elseif($clsmt=='LxQuizz')
			{
				if($j==1){$med->setLx1($med->getLx1()+1);}
				elseif($j==2){$med->setLx2($med->getLx2()+1);}
				elseif($j==3){$med->setLx3($med->getLx3()+1);}
				elseif($j==4 || $j==5){$med->setLx4($med->getLx4()+1);}
				elseif($j>5 && $j<11){$med->setLx5($med->getLx5()+1);}
			}
		}		
		function remiseAzero($clsmt, $scUser)
		{
			if($clsmt=='KingMaster'){
				$scUser->setSumtop5weekMq(NULL);
				$scUser->setTop5weekMq([0,0,0,0,0]);
				$scUser->setKingMaster(NULL);
				$scUser->setScofWeekMu(NULL);
				$scUser->setScofWeekAr(NULL);
				$scUser->setScofWeekFf(NULL);
				$scUser->setScofWeekLx(NULL);
			}
			elseif($clsmt=='scofDayMq'){
				$scUser->setScofDayMq(NULL);
				// Remise en ordre du tableau top5week en ordre croissant
				$top5weekMq=$scUser->getTop5weekMq();				
					sort($top5weekMq);
					$scUser->setTop5weekMq($top5weekMq);				
			}
			elseif($clsmt=='TotalMedia'){$scUser->setScofDayTM(NULL);}
			elseif($clsmt=='MuQuizz'){$scUser->setScofDayMu(NULL);}
			elseif($clsmt=='ArQuizz'){$scUser->setScofDayAr(NULL);}
			elseif($clsmt=='FfQuizz'){$scUser->setScofDayFf(NULL);}
			elseif($clsmt=='LxQuizz'){$scUser->setScofDayLx(NULL);}
		}
		function calcOldScore($clsmt, $scUser)
		{
			if($clsmt=='KingMaster'){$sc=$scUser->getKingMaster();}
			elseif($clsmt=='scofDayMq'){$sc=$scUser->getScofDayMq();}
			elseif($clsmt=='TotalMedia'){$sc=$scUser->getScofDayTM();}
			elseif($clsmt=='MuQuizz'){$sc=$scUser->getScofDayMu();}
			elseif($clsmt=='ArQuizz'){$sc=$scUser->getScofDayAr();}
			elseif($clsmt=='FfQuizz'){$sc=$scUser->getScofDayFf();}
			elseif($clsmt=='LxQuizz'){$sc=$scUser->getScofDayLx();}
			return $sc;
		}
		function majTabMaitres($clsmt, $tabMaitres, $nbExae, $tab1)
		{
			if($nbExae>0){shuffle($tab1);}
			if($clsmt=='KingMaster'){$tabMaitres[0]=$tab1[0];}
			elseif($clsmt=='scofDayMq'){$tabMaitres[1]=$tab1[0];}
			elseif($clsmt=='TotalMedia'){$tabMaitres[2]=$tab1[0];}
			elseif($clsmt=='MuQuizz'){$tabMaitres[3]=$tab1[0];}
			elseif($clsmt=='ArQuizz'){$tabMaitres[4]=$tab1[0];}
			elseif($clsmt=='FfQuizz'){$tabMaitres[5]=$tab1[0];}
			elseif($clsmt=='LxQuizz'){$tabMaitres[6]=$tab1[0];}
			return $tabMaitres;
		}

?>
