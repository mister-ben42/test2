<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ResetController extends Controller
{

	public function accueilResetAction()
	{
		return $this->render('MDQAdminBundle:Admin:accueilReset.html.twig');	
	}

	public function resetPartieAction()//efface la table et remet l'incrément à 0
	{		
		$connection = $this->getDoctrine()->getManager()->getConnection();

		$connection->query('START TRANSACTION;SET FOREIGN_KEY_CHECKS=0; TRUNCATE partiequizz; SET FOREIGN_KEY_CHECKS=1; COMMIT;');
		
		return $this->redirect($this->generateUrl('mdqadmin_accueilReset'));
	}
	
	public function resetQuestionAction()//pour affiche rla liste des thmes
	{
		
		$em=$this->getDoctrine()->getManager();		
		$em->getRepository('MDQQuestionBundle:Question')->resetQuestion();
		
		return $this->redirect($this->generateUrl('mdqadmin_accueilReset'));
	}
	public function resetScUserAction()//pour affiche rla liste des thmes
	{
		
		$em=$this->getDoctrine()->getManager();	
		$tabUser=$em->getRepository('MDQUserBundle:User')->findById(1);// Par défaut
	//	$tabUser=$em->getRepository('MDQUserBundle:User')->findByBot(1);// pour les bots, fonctionnel
		foreach ($tabUser as $user)
		{
		$em->getRepository('MDQUserBundle:ScUser')->resetScUser($user->getId());
		}
		return $this->redirect($this->generateUrl('mdqadmin_accueilReset'));
	}

}
    

?>
