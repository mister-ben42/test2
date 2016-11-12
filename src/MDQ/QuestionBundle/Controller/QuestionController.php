<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\QuestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\QuestionBundle\Entity\QaValider;
use MDQ\QuestionBundle\Form\QaValiderType;
use Symfony\Component\HttpFoundation\JsonResponse; // pour les requête ajax

class QuestionController extends Controller
{
	 public function ajouterQAction()
	{
		$em=$this->getDoctrine()->getManager();
		$gestion=$gestion=$em->getRepository('MDQAdminBundle:Gestion')->find(1);
		if($gestion->getPropQ()==0 && !$this->get('security.context')->isGranted('ROLE_ADMIN')){ return $this->redirect($this->generateUrl('mdqgene_accueil'));    }
		if (!$this->get('security.context')->isGranted('ROLE_USER')) {
			return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}
		$user = $this->container->get('security.context')->getToken()->getUser();
        if ($user===null) {// pas sûr que suffisant en terme de sécurité bien different de test que intance user (cf profilecontroller de FOSUser?
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        }
		
		$nbPMq=$user->getScUser()->getNbPMq();
		$nbQaval7j=$em 	->getRepository('MDQQuestionBundle:QaValider')
						->nbQaval7j($user->getId());
		if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
			if($nbQaval7j>4 || $nbPMq<10){ return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		}
		$quest = new QaValider;
		$quest->setAuteur($user->getScUser());
		$form = $this->createForm(new QaValiderType(), $quest);    
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			$intitule=$quest->getIntitule();
			$doublons=$em->getRepository('MDQQuestionBundle:Question')
							->testDoublon('bddqaval', 'intitule', $intitule);
			if ($doublons!=[]){
				return $this->render('MDQQuestionBundle:Question:ajouterQ.html.twig', array(
						'form' => $form->createView(),
						'doublon' =>1,
							));
			}
			if ($form->isValid()) {
               $em = $this->getDoctrine()->getManager();
			   $scUser=$user->getScUser();
			   $scUser->setNbQprop($scUser->getNbQprop()+1);
				$em->persist($quest);
				$em->persist($scUser);
				$em->flush();
		return $this->redirect($this->generateUrl('mdquser_profileUAuto'));
			}
		}
		return $this->render('MDQQuestionBundle:Question:ajouterQ.html.twig', array(
		  'form' => $form->createView(),
		  'doublon' =>0,
		));
	}
	public function modifQavalAction(Qavalider $qaval)
	{
		if (!$this->get('security.context')->isGranted('ROLE_USER')) {
			return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}
		$user = $this->container->get('security.context')->getToken()->getUser();
        if ($user===null) {// pas sûr que suffisant en terme de sécurité bien différent de test que intance user (cf profilecontroller de FOSUser?
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        }	
		$iduser=$user->getId();
		$idauteur=$qaval->getAuteur()->getId();		
		$repAdmin=$qaval->getRepAdmin();
		if($repAdmin<10 || $repAdmin>20 || $iduser!=$idauteur)
			{return $this->redirect($this->generateUrl('mdquser_profileUAuto'));}
			// pour ne pas sélectionner par l'URL des questions validées ou refusées.
		$form = $this->createForm(new QaValiderType(), $qaval);
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST') {
		  $form->bind($request);
		  if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$qaval->setRetournee(1);
			$em->persist($qaval);
			$em->flush();
		   
			return $this->redirect($this->generateUrl('mdquser_profileUAuto'));
		}}

		return $this->render('MDQQuestionBundle:Question:ajouterQ.html.twig', array(
		  'form'    => $form->createView(),
		  'repAdmin'=>$repAdmin,
		));
   	}

   
   public function adaptFormAction()
	{
	  $request = $this->getRequest();	 
	  if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
	  {
		$id = $request->request->get('id');
			
		  if ($id !==null || $id!=='Domaine')
		  {   
			$data = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('MDQQuestionBundle:Question')
						   ->recupTheme($id);			

			   return new JsonResponse($data);
		  }
	  }
	  $data='none';
	  return $data;        
	}
	public function signalErrorAction()
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
	  if ($user===null) {// pas sûr que suffisant en terme de sécurité ?
	      return $this->redirect($this->generateUrl('mdqgene_accueil'));
	  }
		$em = $this->getDoctrine()->getManager();
		$gestion=$gestion=$em->getRepository('MDQAdminBundle:Gestion')->find(1);
	  if($gestion->getSignalE()==1 || $this->get('security.context')->isGranted('ROLE_ADMIN'))
	  {
		$scuser=$user->getScUser();
		$request = $this->getRequest();	 
		if($request->isXmlHttpRequest() && $user->getAllowError==1) // pour vérifier la présence d'une requete Ajax
		{
			$idQ = $request->request->get('idQ');	
			$taberror = $request->request->get('taberror');	
			if($idQ!==null && $taberror!==null)
			{
				
				$question=$em->getRepository('MDQQuestionBundle:Question')
							->findOneById($idQ);
				$users_error=$question->getUsers_error();
				$tabIdUser_error=[];
				foreach ($users_error as $scuserb)
				{
					$id=$scuserb->getId();
					array_push($tabIdUser_error, $id);
				}
				if(in_array($scuser->getId(), $tabIdUser_error)!==true)
				{
					$taberrorQ=$question->getTaberror();
					$taberrorQ[0]=$taberrorQ[0]+$taberror[0];
					$taberrorQ[1]=$taberrorQ[1]+$taberror[1];
					$taberrorQ[2]=$taberrorQ[2]+$taberror[2];
					$question->setError($question->getError()+1);
					$question->setTaberror($taberrorQ);
					$question->addUser_error($user->getScUser());
					$scuser->setNbErrorSignalTot($scuser->getNbErrorSignalTot()+1);
					$scuser->setNbErrorSignal($scuser->getNbErrorSignal()+1);
					$em->persist($question);
					$em->persist($scuser);
					$em->flush();
				}
			return new JsonResponse($idQ);
			}
			
		}
	  }
		$data='error';
		return new JsonResponse($data);  
	}
	
}