<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BotController extends Controller
{

	public function botPartieAction($nbBots,$djajoue,$type)
	{
		$em=$this->getDoctrine()->getManager();
		$botsSelects2=$em->getRepository('MDQUserBundle:ScUser')
						 ->getBot($djajoue);//renvoit les id des bots de tous ou de ceux qui n'ont pas encore joué au Mq
		$nbBotsSelect=count($botsSelects2);
		if($nbBotsSelect==0){return $this->redirect($this->generateUrl('mdqadmin_accueilAdmin'));}
		if($nbBots>$nbBotsSelect){$nbBots=$nbBotsSelect;}
		$botsSelects=$em->getRepository('MDQUserBundle:User')
						 ->getBots($nbBots,$nbBotsSelect,$botsSelects2);
		
		$tabParties=$this->container->get('mdq_admin.botGame')->execBotGame($botsSelects, $type);
		
			$em->flush();
		return $this->render('MDQAdminBundle:Admin:botPartie.html.twig', array(
			'Parties' => $tabParties,
			'Bots2'=> $botsSelects2,
			'nbBotsSelect'=>$nbBotsSelect,
		));
	}


  
}
    

?>
