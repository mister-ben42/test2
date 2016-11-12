<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatsController extends Controller
{

	public function arbrathemeAction($dom1, $entete, $viewDom2)
	{
		$dom1a=$dom1;
		$dom1=[];
		$dom1['nom']=$dom1a;
		if($dom1['nom']!="none")
		{
		     $em=$this->getDoctrine()->getManager();
		     $req=$em->getRepository('MDQQuestionBundle:Theme')->findBy(array('dom1'=>$dom1['nom'])
					);
				$req2=$em->getRepository('MDQQuestionBundle:Question')->findBy(
											      array('valid'=>1, 'dom1'=>$dom1['nom'])
					);
					$dom1['nbQ']=count($req2);
					for($j=1;$j<6;$j++)
					{					
					    $rq[$j]=$em->getRepository('MDQQuestionBundle:Question')->findBy(
											      array('valid'=>1, 'dom1'=>$dom1['nom'], 'diff'=>$j));
					    if($dom1['nbQ']!=0){$dom1['d'.$j]=count($rq[$j])*100/$dom1['nbQ'];}
					    else{$dom1['d'.$j]=0;}
					}
		      	return $this->render('MDQAdminBundle:Admin:arbratheme.html.twig', array(
			'themes' => $req,
			'dom1' => $dom1,
			'entete' =>$entete,
			'viewDom2'=>$viewDom2
			));
		
		}
		else {		      	return $this->render('MDQAdminBundle:Admin:arbratheme.html.twig', array(
			'themes' => $dom1,
			'dom1' => $dom1,
			'entete' =>$entete
			));
			}
	}

    public function statQAction()
	{
		$stats= $this->getDoctrine()
						 ->getManager()
						 ->getRepository('MDQQuestionBundle:Question')
						 ->getStatsQ();
		
				
		return $this->render('MDQAdminBundle:Admin:statQ.html.twig', array(
			'stats' => $stats,
	
	     ));
	}

}
?>