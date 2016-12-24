<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\AdminBundle\Entity\News;
use MDQ\AdminBundle\Form\Type\NewsType;
use Symfony\Component\HttpFoundation\JsonResponse; // pour les requête ajax
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{


	public function newNewsAction(Request $request)
	{
		$user = $this->container->get('security.token_storage')->getToken()->getUser();
	      if ($user===null) { return $this->redirect($this->generateUrl('mdqgene_accueil'));}// pas sur que suffisant /sécurité - différent de test que intance user (cf profilecontroller de FOSUser?           
		
			$news = new News($user->getUsername()); 
			$form   = $this->get('form.factory')->create(NewsType::class, $news);
		if ($request->getMethod() == 'POST' && $form->handleRequest($request)->isValid()) {    
				$em = $this->getDoctrine()->getManager();
				$em->persist($news);
				$em->flush();
				return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}
		return $this->render('MDQAdminBundle:Admin:newNews.html.twig', array(
		  'form' => $form->createView(),
		));
	}
	public function listNewsAction()
	{
		// Toujours ce pb : l'entité news n'est pas reliées à son repository ... bizarre.
		$em=$this->getDoctrine()->getManager();
		$news=$em->createQueryBuilder()
				->select('n')
				->from('MDQAdminBundle:News', 'n')
				->orderBy('n.publication', 'DESC')
				->addOrderBy('n.priorite', 'DESC')
				->addOrderBy('n.id', 'DESC');						
		$newsA=$news->getQuery()->getResult();	
		return $this->render('MDQAdminBundle:Admin:listNews.html.twig', array(
		'news' => $newsA,
    ));
	}
	public function modifNewsAction(News $news, Request $request)
	{
			$form = $this->get('form.factory')->create(NewsType::class, $news);

		if ($request->getMethod() == 'POST' && $form->handleRequest($request)->isValid()) {   
			$em = $this->getDoctrine()->getManager();
			$em->persist($news);
			$em->flush();
		   
			return $this->redirect($this->generateUrl('mdqadmin_listNews'));
		}

		return $this->render('MDQAdminBundle:Admin:newNews.html.twig', array(
		  'form'    => $form->createView()
		));
	}
	public function formListNewsAction(Request $request)
	{
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{			
			$tabresult = $request->request->get('tabresult');	
			if($tabresult!==null)
			{
				$em=$this->getDoctrine()->getManager();
				$news=$em->getRepository('MDQAdminBundle:News')
							->findOneById($tabresult[0]);
				$news->setPublication($tabresult[1]);
				$news->setPriorite($tabresult[2]);
				$em->persist($news);
				$em->flush();
				return new JsonResponse($tabresult);
			}
			
		}
		$data='error';
		return $data; 
	}

 
}
    

?>
