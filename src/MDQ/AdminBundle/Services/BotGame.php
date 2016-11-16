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
}
