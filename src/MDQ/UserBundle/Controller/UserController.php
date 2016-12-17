<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\UserBundle\Entity\User;



class UserController extends Controller
{	
	public function profileUAction(User $user)
	{
		if(!$this->container->get('mdq_admin.security')->testAutorize("simpleAction", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		$user_connect = $this->container->get('security.context')->getToken()->getUser();
		if ($user_connect===$user && $user_connect->getId()==$user->getId()) {
			return $this->redirect($this->generateUrl('mdquser_profileUAuto'));
        }
		$session = $this->getRequest()->getSession();
		$em=$this->getDoctrine()->getManager();
		$derPartieUser=$em->getRepository('MDQQuizzBundle:PartieQuizz')
						  ->recupDerPartieUser($user->getId());
		return $this->render('MDQUserBundle:User:profileU.html.twig', array(
	   'user'   => $user,
	  'derParties'=>$derPartieUser,
    ));
	}

	public function profileUAutoAction()
	{
		if(!$this->container->get('mdq_admin.security')->testAutorize("profileUAuto", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		$user = $this->container->get('security.context')->getToken()->getUser();
		$em=$this->getDoctrine()->getManager();
		$derPartieUser=$em	->getRepository('MDQQuizzBundle:PartieQuizz')
							->recupDerPartieUser($user->getId());
		$qavalUser=$em	->getRepository('MDQQuestionBundle:QaValider')
						->recupQaval($user->getId());
		$nbQaval7j=$em 	->getRepository('MDQQuestionBundle:QaValider')
						->nbQaval7j($user->getId());
		$gestionQProp=$em->getRepository('MDQAdminBundle:Gestion')->findOneById(1)->getPropQ();
		return $this->render('MDQUserBundle:User:profileUAuto.html.twig', array(
		  'user'   => $user,	  
		  'derParties'=>$derPartieUser,
		  'qaval'=>$qavalUser,
		  'nbQaval7j'=>$nbQaval7j,
		  'gestionQProp'=>$gestionQProp,
		));	
	}
	public function profileUAutoEditAction()
	{
		if(!$this->container->get('mdq_admin.security')->testAutorize("profileUAuto", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		return $this->redirect($this->generateUrl('fos_user_profile_edit'));
	}
	public function profileUPasswordAction()
	{
		if(!$this->container->get('mdq_admin.security')->testAutorize("profileUAuto", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
	return $this->redirect($this->generateUrl('fos_user_change_password'));

	}
	public function loginAction()
	{
	return $this->redirect($this->generateUrl('fos_user_security_login'));

	}
	public function loginBisAction()// A garder, pour le render le page accueil
	{
		
		$csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
	 
		return $this->container->get('templating')->renderResponse('FOSUserBundle:Security:login_content.html.twig', array(
			'last_username' => null,
			'error'         => null,
			'csrf_token'    => $csrfToken
		));
	}
}
