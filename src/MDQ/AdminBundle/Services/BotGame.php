<?php

namespace MDQ\AdminBundle\Services;


class BotGame
{    

	public function testBr($coef,$diff)// tirage au sort avec applicatio de coefficient sous fore de tableau - pour partie bot.
	{
	
	      $tabcoeffdiff=[1.5,1,0.75,0.50,0.30];				
	      $coefb=25+$coef*$tabcoeffdiff[$diff-1];
	      $coefs=array(0=>(100-$coefb),1=>$coefb);
	      $rang = mt_rand(1, array_sum($coefs));
	    $tot = 0;  
	    foreach ($coefs as $key => $coef)
	    {
	    $tot += $coef;
	    if ($tot >= $rang)
	    return $key;
	    }
	}
    	public function calcScore($score,$diff)// Pour partie bot
	{
		$tabscore=[100,200,500,1000,2000]; 
		$scdebase=$tabscore[$diff-1];
		$tabtpsrep=[3,4,6,10];
		$tpsrep=15-$tabtpsrep[mt_rand(0,3)];				
		$bonus=round(($scdebase/2*$tpsrep/15),0);
		$scoreQ=$scdebase+$bonus;
		$score=$score+$scoreQ;
		return $score;
	}
	
	public function randCoefQM($coefs)// tirage au sort avec applicatio de coefficient sous fore de tableau - pour partie bot.
	{
	$rang = mt_rand(1, array_sum($coefs));
	$tot = 0;  
	    foreach ($coefs as $key => $coef)
	    {
	    $tot += $coef;
	    if ($tot >= $rang)
	    return $key;
	    }
	}
    	public function calcScQ($scoreB)// Pour partie bot
	{
		$tabtpsrep=[3,4,6,10];
		$tpsrep=15-$tabtpsrep[mt_rand(0,3)];				
		$bonus=round(($scoreB/2*$tpsrep/15),0);
		$scoreQ=$scoreB+$bonus;
		return $scoreQ;
	}
	
}
