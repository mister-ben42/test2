<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatsController extends Controller
{

	public function arbrathemeAction($dom1, $entete, $viewDom2)
	{
	    if($dom1!="none"){
	    $em=$this->getDoctrine()->getManager();
	    $questions=$em->getRepository('MDQQuestionBundle:Question')->createQueryBuilder('q')->where('q.dom1= :dom1')->setParameter('dom1', $dom1)		
		->andWhere("q.valid=1")->getQuery()->getArrayResult();
		$data=$this->container->get('mdq_admin.stats')->dataArbraT($questions, $dom1);
	    }
	    else{
		$data[0]=[];
		$data[1]['nom']="none";
	    }
		 return $this->render('MDQAdminBundle:Admin:arbratheme.html.twig', array(
			'tabdata' => $data[0],
			'dom1' => $data[1],
			'entete' =>$entete,
			'viewDom2'=>$viewDom2,
			'adminTwig'=>$this->container->get('mdq_admin.adminTwig'),
			));

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
