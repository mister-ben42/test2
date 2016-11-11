<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\QuestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\QuestionBundle\Entity\Question;
use MDQ\QuestionBundle\Entity\QaValider;
use MDQ\UserBundle\Entity\User;
use MDQ\UserBundle\Entity\ScUser;
use MDQ\QuestionBundle\Form\QuestionType;
use MDQ\QuestionBundle\Form\QaValiderType;
use MDQ\QuestionBundle\Entity\CritEditQ;
use MDQ\QuestionBundle\Form\CritEditQType;
use MDQ\QuestionBundle\Form\QuestionEditType;
use Symfony\Component\HttpFoundation\Request; // pour les requête ajax
use Symfony\Component\HttpFoundation\JsonResponse; // pour les requête ajax

class QuestionController extends Controller
{
	 public function ajouterQAction()
	{
		$em=$this->getDoctrine()->getManager();
		$gestion=$gestion=$em->getRepository('MDQAdminBundle:Gestion')->find(1);
		if($gestion->getPropQ()==0 and !$this->get('security.context')->isGranted('ROLE_ADMIN')){ return $this->redirect($this->generateUrl('mdqgene_accueil'));    }
		if (!$this->get('security.context')->isGranted('ROLE_USER')) {
			return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}
		$user = $this->container->get('security.context')->getToken()->getUser();
        if ($user===null) {// pas s󲠱ue suffisant en terme de sꤵrit頭 bien diff곥nt de test que intance user (cf profilecontroller de FOSUser?
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        }
		
		$nbPMq=$user->getScUser()->getNbPMq();
		$nbQaval7j=$em 	->getRepository('MDQQuestionBundle:QaValider')
						->nbQaval7j($user->getId());
	//	$nbQaval7j=2;
		if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
			if($nbQaval7j>4 or $nbPMq<10){ return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		}
		$quest = new QaValider;
		$quest->setAuteur($user->getScUser());
		$form = $this->createForm(new QaValiderType(), $quest);    
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			$intitule=$quest->getIntitule();
			//$intitule="test doublon";
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
        if ($user===null) {// pas s󲠱ue suffisant en terme de sꤵrit頭 bien diff곥nt de test que intance user (cf profilecontroller de FOSUser?
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        }	
		$iduser=$user->getId();
		$idauteur=$qaval->getAuteur()->getId();		
		$repAdmin=$qaval->getRepAdmin();
		if($repAdmin<10 or $repAdmin>20 or $iduser!=$idauteur)
			{return $this->redirect($this->generateUrl('mdquser_profileUAuto'));}
			// pour ne pas s�lectionner par l'URL des questions valid�es ou refus�es.
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
/*  public function ajouterQAction()
  {
    if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
		// pour l'intant, il faut être admin pour ajouter une question
			return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}
	$question = new Question;

    // On crée le formulaire grâce à l'ArticleType
    $form = $this->createForm(new QuestionType(), $question);

    // On récupère la requête
    $request = $this->getRequest();

    // On vérifie qu'elle est de type POST
    if ($request->getMethod() == 'POST') {
      // On fait le lien Requête <-> Formulaire
      $form->bind($request);

      // On vérifie que les valeurs entrées sont correctes
      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
      if ($form->isValid()) {
        // On enregistre notre objet $article dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($question);
        $em->flush();

        // On définit un message flash
        //$this->get('session')->getFlashBag()->add('info', 'Question bien ajoutée');

		return $this->redirect($this->generateUrl('mdqadmin_accueilAdmin'));
	  }
    }

    // À ce stade :
    // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
    // - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

    return $this->render('MDQQuestionBundle:Question:ajouterQ.html.twig', array(
      'form' => $form->createView(),
    ));
  }
 /* 
  public function voirQAction($error, $diff, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin)
  {
	
    // Pour récupérer la liste de tous les articles : on peut utiliser findAll(), mais
	// la fonction perso getArticles du repository permet de joindre images et coms et
	// de mettre une pagination, tout ça en une seule requête !
    $questions = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('MDQQuestionBundle:Question')
					 ->getQuestions($error, $diff, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin)
					
                     ;
					// ->findAll();
					// ->getArticles(3, $page); // 3 articles par page : c'est totalement arbitraire !

    // On ajoute ici les variables page et nb_page à la vue
    return $this->render('MDQQuestionBundle:Question:voirQ.html.twig', array(
      'questions'   => $questions,
	  'nbquestions' => count($questions),
	  'error' => $error,
	  'diff' =>$diff,
	  'dom1' => $dom1,
	  'theme' => $theme,
	  'crit' => $crit,
	  'sens' => $sens,
	  'nbdeQ' => $nbdeQ,
	  'nbmin' => $nbmin
    ));
  }
  public function critvoirQAction()
  {
/*	if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
	// Sinon on déclenche une exception « Accès interdit »
	// throw new AccessDeniedHttpException('Accès limité aux auteurs');
		return $this->redirect($this->generateUrl('mdqquestion_accueil'));
	}
*/	
 /*   $crits = new CritEditQ;
    $form = $this->createForm(new CritEditQType(), $crits);
    // On récupère la requête
    $request = $this->getRequest();
    // On vérifie qu'elle est de type POST
    if ($request->getMethod() == 'POST') {
      // On fait le lien Requête <-> Formulaire
      $form->bind($request);

      // On vérifie que les valeurs entrées sont correctes
      if ($form->isValid()) {   
        
		return $this->redirect($this->generateUrl('mdqquestion_voirQ', array(
		'error'=> $crits->getError(),
		'diff'=> $crits->getDiff(),
		'dom1'=> $crits->getDom1(),
		'theme'=> $crits->getTheme(),
		'crit'=> $crits->getCrit(),
		'sens'   => $crits->getSens(),
		'nbdeQ'   => $crits->getNbdeQ(),
		'nbmin'   => $crits->getNbmin()
		)));
	  }
    }

    // À ce stade :
    // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
    // - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

    return $this->render('MDQQuestionBundle:Question:critvoirQ.html.twig', array(
      'form' => $form->createView(),
    ));
  }*/
 /*  public function modifQAction(Question $question, $error, $diff, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin)
  {

    $form = $this->createForm(new QuestionEditType(), $question);

    $request = $this->getRequest();

    if ($request->getMethod() == 'POST') {
      $form->bind($request);

      if ($form->isValid()) {
        // On enregistre l'article
        $em = $this->getDoctrine()->getManager();
        $em->persist($question);
        $em->flush();
       
        return $this->redirect($this->generateUrl('mdqquestion_voirQ', array(
		'error'=> $error,
		'diff'=> $diff,
		'dom1'=> $dom1,
		'theme'=> $theme,
		'crit'=> $crit,
		'sens'   => $sens,
		'nbdeQ'   => $nbdeQ,
		'nbmin'   => $nbmin
		)));
    }}

    return $this->render('MDQQuestionBundle:Question:ajouterQ.html.twig', array(
      'form'    => $form->createView()
    ));
   }
   
    public function statQAction()
   {
	$stats= $this->getDoctrine()
                     ->getManager()
                     ->getRepository('MDQQuestionBundle:Question')
					 ->getStatsQ();
	
			
	return $this->render('MDQQuestionBundle:Question:statQ.html.twig', array(
		'stats' => $stats,
 /*     'nbQt'    => $stats['nbQt'],
      'nbQh' => $stats['nbQh'], 'nbQg' => $stats['nbQg'], 'nbQal' => $stats['nbQal'],'nbQsl' => $stats['nbQsl'], 'nbQsn' => $stats['nbQsn'],'nbQd' => $stats['nbQd'],
	  'nbQd1' => $stats['nbQd1'],'nbQd2' => $stats['nbQd2'],'nbQd3' => $stats['nbQd3'],'nbQd4' => $stats['nbQd4'],'nbQd5' => $stats['nbQd5'],
	  'pctQh' => $stats['pctQh'], 'pctQg' => $stats['pctQg'], 'pctQal' => $stats['pctQal'],'pctQsl' => $stats['pctQsl'], 'pctQsn' => $stats['pctQsn'],'pctQd' => $stats['pctQd'],
	  'pctQd1' => $stats['pctQd1'],'pctQd2' => $stats['pctQd2'],'pctQd3' => $stats['pctQd3'],'pctQd4' => $stats['pctQd4'],'pctQd5' => $stats['pctQd5'],
*/
/*	     ));
   }*/
   
   public function adaptFormAction()
	{
	  $request = $this->getRequest();	 
	  if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
	  {
		$id = $request->request->get('id');
		  $selecteur = $request->request->get('select');
			
		  if ($id != null OR $id!=='Domaine')
		  {   
			$data = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('MDQQuestionBundle:Question')
						   ->recupTheme($id);
			
			  //return new JsonResponse($data);
			  /*$data=[];
			  $data[0]='Histoire Theme 1';
			  $data[1]='Histoire Theme 2';*/
			  
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
	  if($gestion->getSignalE()==1 or $this->get('security.context')->isGranted('ROLE_ADMIN'))
	  {
		$scuser=$user->getScUser();
		$request = $this->getRequest();	 
		if($request->isXmlHttpRequest() and $user->getAllowError==1) // pour vérifier la présence d'une requete Ajax
		{
			$idQ = $request->request->get('idQ');	
			$taberror = $request->request->get('taberror');	
			if($idQ!=null and $taberror!=null)
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
				if(in_array($scuser->getId(), $tabIdUser_error)!=true)
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