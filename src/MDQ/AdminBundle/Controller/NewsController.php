<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\UserBundle\Entity\User;
use MDQ\UserBundle\Form\UserBlockType;
use MDQ\UserBundle\Entity\CritEditU;
use MDQ\UserBundle\Form\CritEditUType;
use MDQ\AdminBundle\Entity\News;
use MDQ\AdminBundle\Form\NewsType;
use MDQ\QuestionBundle\Entity\Question;
use MDQ\QuestionBundle\Form\QuestionType;
use MDQ\QuestionBundle\Entity\CritEditQ;
use MDQ\QuestionBundle\Entity\CritEditQaVal;
use MDQ\QuizzBundle\Entity\PartieQuizz;
use MDQ\AdminBundle\Entity\Gestion;
use MDQ\AdminBundle\Form\GestionType;
use MDQ\QuestionBundle\Form\CritEditQType;
use MDQ\QuestionBundle\Form\CritEditQaValType;
use MDQ\QuestionBundle\Form\QuestionEditType;
use MDQ\QuestionBundle\Entity\Theme;
use MDQ\QuestionBundle\Entity\Dom3;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse; // pour les requête ajax

class NewsController extends Controller
{


	public function newNewsAction()
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
	      if ($user===null) { return $this->redirect($this->generateUrl('mdqgene_accueil'));}// pas sur que suffisant /sécurité - différent de test que intance user (cf profilecontroller de FOSUser?           
		
		$username=$user->getUsername();
		 $dateactu=new \Datetime();
			$news = new News;
			$news->setAuteur($username);
			$news->setDateCreate($dateactu);
			$form = $this->createForm(new NewsType(), $news);  
			$request = $this->getRequest();
		if ($request->getMethod() == 'POST') {      
			  $form->bind($request);
			  if ($form->isValid()) {       
				$em = $this->getDoctrine()->getManager();
				$em->persist($news);
				$em->flush();
				return $this->redirect($this->generateUrl('mdqgene_accueil'));
			  }
		}
		return $this->render('MDQAdminBundle:Admin:newNews.html.twig', array(
		  'form' => $form->createView(),
		));
	}
	public function listNewsAction()
	{
		// Toujours ce pb : l'entité news n'est pas reliées à son repository ... bizarre.
		/*$newsA = $this->getDoctrine()
						 ->getManager()
						 ->getRepository('MDQAdminBundle:News')
						 ->recupNews();
		*/
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
	public function modifNewsAction(News $news)
	{
			$form = $this->createForm(new NewsType(), $news);
			$request = $this->getRequest();

		if ($request->getMethod() == 'POST') {
			$form->bind($request);

		  if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($news);
			$em->flush();
		   
			return $this->redirect($this->generateUrl('mdqadmin_listNews'));
		}}

		return $this->render('MDQAdminBundle:Admin:newNews.html.twig', array(
		  'form'    => $form->createView()
		));
	}
	public function formListNewsAction()
	{
		$request = $this->getRequest();	 
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{			
			$tabresult = $request->request->get('tabresult');	
			if($tabresult!=null)
			{
				$em=$this->getDoctrine()->getManager();
			/*	$new=$em->createQueryBuilder()
						->select('n')
						->from('MDQAdminBundle:News', 'n')
						->where('n.id = :idNews')
						->setParameter('idNews', $tabresult[0]);
				$news=$new->getQuery()->getOneResult();
			*/
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