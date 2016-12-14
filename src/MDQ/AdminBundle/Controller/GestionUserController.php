<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\UserBundle\Entity\User;
use MDQ\UserBundle\Form\Type\UserBlockType;
use MDQ\UserBundle\Entity\CritEditU;
use MDQ\UserBundle\Form\Type\CritEditUType;

class GestionUserController extends Controller
{

	public function profileUAdminAction(User $user)
	{
		 $form = $this->createForm(new UserBlockType(), $user);

		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
		  $form->bind($request);

		  if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			$id=$user->getId();
			return $this->redirect($this->generateUrl('mdqadmin_profileUAdmin', array(
			'id' => $id
			)));
		}}
		$derPartieUser=$this->getDoctrine()
							->getManager()
							->getRepository('MDQQuizzBundle:PartieQuizz')
							->recupDerPartieUser($user->getId());
		$dateref=$this->getDoctrine()->getManager()->getRepository('MDQGeneBundle:DateReference')->find(1);
		return $this->render('MDQAdminBundle:Admin:profileUAdmin.html.twig', array(
		'user'   => $user,	  
		'derParties'=>$derPartieUser,
		'form'    => $form->createView(),
		'dateref'=>$dateref,
		));
	}
	public function critvoirUAction()
	{

		$crits = new CritEditU;
		$form = $this->createForm(new CritEditUType(), $crits);		
		$request = $this->getRequest();		
		if ($request->getMethod() == 'POST') {		  
		  $form->bind($request);		 
		  if ($form->isValid()) {			
			return $this->redirect($this->generateUrl('mdqadmin_voirU', array(		
			'type'=> $crits->getType(),
			'compte'=> $crits->getCompte(),
			'sexe'=> $crits->getSexe(),
			'departement'=> $crits->getDepartement(),
			'age'=>$crits->getAge(),
			'last_login'=>$crits->getLastLogin(),
			'role'=>$crits->getRole(),
			'nbP'=>$crits->getNbP(),
			'triUser'=>$crits->getTriUser(),
			'triStats'=>$crits->getTriStats(),
			'sens'=>$crits->getSens(),
			'nbdeU'=>$crits->getNbdeU(),
			'nbmin'=>$crits->getNbmin()
			)));
		  }
		}
		return $this->render('MDQAdminBundle:Admin:critvoirU.html.twig', array(
		  'form' => $form->createView(),
		));
	}
	public function voirUAction($type, $compte, $sexe, $departement, $age,$last_login, $role, $nbP, $triUser, $triStats, $sens, $nbdeU, $nbmin)
	{	    
		$users = $this->getDoctrine()
						 ->getManager()
						 ->getRepository('MDQUserBundle:User')
						 ->getUsers($type, $compte, $sexe, $departement, $age,$last_login, $role, $nbP, $triUser, $triStats, $sens, $nbdeU, $nbmin);

		return $this->render('MDQAdminBundle:Admin:voirU.html.twig', array(
		  'users'   => $users,
		  'nbusers' => count($users),
		  'adminTwig'=>$this->container->get('mdq_admin.adminTwig'),
		));
	}


}
    

?>
