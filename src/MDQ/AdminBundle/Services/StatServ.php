<?php

namespace MDQ\AdminBundle\Services;



class StatServ
{    
	public function dataArbraT($questions, $dom)
	{
	      		$i=0; $j=0; $tabdata=[]; $tabtheme=[]; $tabdiff1=array(1=>0, 2=>0, 3=>0, 4=>0, 5=>0);
		foreach($questions as $question)
		{
			$i++;
			if(in_array($question['theme'], $tabtheme)!==true)
			{
				$j++;
				$tabdata[$j]['nomTheme']=$question['theme'];
				array_push($tabtheme, $question['theme']);
				$tabdata[$j]['nbQTheme']=1;
				$tabdata[$j]['nbd1']=0;
				$tabdata[$j]['nbd2']=0;
				$tabdata[$j]['nbd3']=0;
				$tabdata[$j]['nbd4']=0;
				$tabdata[$j]['nbd5']=0;				
				$tabdata[$j]['prctd1']=0;
				$tabdata[$j]['prctd2']=0;
				$tabdata[$j]['prctd3']=0;
				$tabdata[$j]['prctd4']=0;
				$tabdata[$j]['prctd5']=0;
				$tabdata[$j]['nbd'.$question['diff']]=1;				
				$tabdata[$j]['prctd'.$question['diff']]=100;
				
				$key=$j;
			}
			else
			{				
				$key=array_search($question['theme'], array_column($tabdata, 'nomTheme'));
				$key=$key+1;
				$tabdata[$key]['nbQTheme']++;
				$tabdata[$key]['nbd'.$question['diff']]++;
				      for($k=1; $k<6;$k++)
				      {
				      $tabdata[$key]['prctd'.$k]=round($tabdata[$key]['nbd'.$k]*100/$tabdata[$key]['nbQTheme']);	
				      }
			}	
			//Dom3
			if(!isset($tabdata[$key]['tabdom3'][$question['dom3']])){
				$tabdata[$key]['tabdom3'][$question['dom3']]['nomDom3']=$question['dom3'];
				$tabdata[$key]['tabdom3'][$question['dom3']]['nbQDom3']=1;
				     for($k=1; $k<6;$k++)
				      {
					  $tabdata[$key]['tabdom3'][$question['dom3']]['nbd'.$k.'Dom3']=0;
					  $tabdata[$key]['tabdom3'][$question['dom3']]['prctd'.$k.'Dom3']=0;	
				      }
				$tabdata[$key]['tabdom3'][$question['dom3']]['nbd'.$question['diff'].'Dom3']=1;
				$tabdata[$key]['tabdom3'][$question['dom3']]['prctd'.$question['diff'].'Dom3']=100;
			}
			else{
				$tabdata[$key]['tabdom3'][$question['dom3']]['nbd'.$question['diff'].'Dom3']++;				
				$tabdata[$key]['tabdom3'][$question['dom3']]['nbQDom3']++;
				      for($k=1; $k<6;$k++)
				      {
					  $tabdata[$key]['tabdom3'][$question['dom3']]['prctd'.$k.'Dom3']=round($tabdata[$key]['tabdom3'][$question['dom3']]['nbd'.$k.'Dom3']*100/$tabdata[$key]['tabdom3'][$question['dom3']]['nbQDom3']);	
				      }
			}
			//Dom2
			if(!isset($tabdata[$key]['tabdom3'][$question['dom3']]['tabdom2'][$question['dom2']])){
				 $tabdata[$key]['tabdom3'][$question['dom3']]['tabdom2'][$question['dom2']]['nomDom2']=$question['dom2']; 
				 $tabdata[$key]['tabdom3'][$question['dom3']]['tabdom2'][$question['dom2']]['nbQDom2']=1;
			}
			else{
				  $tabdata[$key]['tabdom3'][$question['dom3']]['tabdom2'][$question['dom2']]['nbQDom2']++;
			}
			$tabdiff1[$question['diff']]++;
			
		}
		$dom1['nom']=$dom;
		$dom1['nbQ']=$i;
		for($k=1; $k<6;$k++)
		{
			$dom1['d'.$k]=round($tabdiff1[$k]*100/$i);	
		}
		
	      $data=[$tabdata, $dom1];
	      return $data;
	}
}


