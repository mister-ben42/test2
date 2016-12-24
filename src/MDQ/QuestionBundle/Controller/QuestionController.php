<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\QuestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\QuestionBundle\Entity\QaValider;
use MDQ\QuestionBundle\Form\Type\QuestionType;
use Symfony\Component\HttpFoundation\JsonResponse; // pour les requête ajax
use Symfony\Component\HttpFoundation\Request;

class QuestionController extends Controller
{
	 public function ajouterQAction(Request $request)
	{
		if(!$this->container->get('mdq_admin.security')->testAutorize("ajoutQ", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		$em=$this->getDoctrine()->getManager();
		$user = $this->container->get('security.token_storage')->getToken()->getUser();
 
/**		// A définir le moment opportun
		nbPMq=$user->getScUser()->getNbPMq();
		$nbQaval7j=$em 	->getRepository('MDQQuestionBundle:QaValider')
						->nbQaval7j($user->getId());
		if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
			if($nbQaval7j>4 || $nbPMq<10){ return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		}
**/		
		$quest = new QaValider;
		$quest->setAuteur($user->getScUser());
		$form = $this->get('form.factory')->create(QuestionType::class, $quest);  
		if ($request->getMethod() == 'POST' && $form->handleRequest($request)->isValid()) {   
/**		// A développe rle moment opportun : tester les doublons?	
			$intitule=$quest->getIntitule();
			$doublons=$em->getRepository('MDQQuestionBundle:Question')
							->testDoublon('bddqaval', 'intitule', $intitule);
			if ($doublons!=[]){
				return $this->render('MDQQuestionBundle:Question:ajouterQ.html.twig', array(
						'form'=>$form->createView(),
						'doublon'=>1,
							));
			}
*/			   $scUser=$user->getScUser();
			   $scUser->setNbQprop($scUser->getNbQprop()+1);
				$em->persist($quest);
				$em->flush();
		return $this->redirect($this->generateUrl('mdquser_profileUAuto'));
		}
		return $this->render('MDQQuestionBundle:Question:ajouterQ.html.twig', array(
		  'form' => $form->createView(),
		  'doublon'=>0,
		));
	}
	public function modifQavalAction(Qavalider $qaval, Request $request)
	{
		if(!$this->container->get('mdq_admin.security')->testAutorize("modifQaval", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		$user = $this->container->get('security.token_storage')->getToken()->getUser(); 
		$idauteur=$qaval->getAuteur()->getId();		
		$repAdmin=$qaval->getRepAdmin();
		if($repAdmin<10 || $repAdmin>20 || $user->getId()!=$idauteur){return $this->redirect($this->generateUrl('mdquser_profileUAuto'));}// pour ne pas sélectionner par l'URL des questions validées ou refusées.
		$form = $this->get('form.factory')->create(QuestionType::class, $qaval);
		if ($request->getMethod() == 'POST' && $form->handleRequest($request)->isValid()) {   
			$qaval->setRetournee(1);
			$this->getDoctrine()->getManager()->flush();   
			return $this->redirect($this->generateUrl('mdquser_profileUAuto'));
		}
	      
		return $this->render('MDQQuestionBundle:Question:ajouterQ.html.twig', array(
		  'form'    => $form->createView(),
		  'repAdmin'=>$repAdmin,
		  'doublon'=>0,
		  'affichRepAdmin'=>$this->container->get('mdq_question.propQ')->affichRepAdmin($repAdmin),
		));
   	}

   
   public function adaptFormAction(Request $request)
	{	 
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

	
}
