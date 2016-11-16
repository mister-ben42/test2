<?php

namespace MDQ\AdminBundle\Services;


class BotGame
{    

	public function rand_coef($coefs)// tirage au sort avec applicatio de coefficient sous fore de tableau - pour partie bot.
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
