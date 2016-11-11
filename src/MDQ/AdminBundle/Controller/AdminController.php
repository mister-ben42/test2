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

class AdminController extends Controller
{

	public function accueilAdminAction()
	{
		return $this->render('MDQAdminBundle:Admin:accueilA.html.twig');	
	}
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
	/*	if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
		// Sinon on déclenche une exception " Accès interdit "
		// throw new AccessDeniedHttpException('Accès limité aux auteurs');
			return $this->redirect($this->generateUrl('mdqquestion_accueil'));
		}
	*/	
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
		  'nbusers' => count($users)	  
		));
	}
	public function newNewsAction()
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
        if ($user===null) {// pas sur que suffisant en terme de sécurité - bien différent de test que intance user (cf profilecontroller de FOSUser?
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        }
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
	public function voirQAction($choice, $page, $error, $valid, $diff, $game, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin)
	{
		$em=$this->getDoctrine()->getManager();
		
		$tabdom2 = $em	 ->getRepository('MDQQuestionBundle:Question')
						 ->recupDom2ouDom3('dom2');
		$tabdom3 = $em	 ->getRepository('MDQQuestionBundle:Question')
						 ->recupDom2ouDom3('dom3');
		$tabtheme=$em->getRepository('MDQQuestionBundle:Theme')
					->findAll();
		$tabmedia=['texte','image','citation','audio','citationlitt','suitelog'];
		if($choice=="list")
		{
			
			$questions = $em ->getRepository('MDQQuestionBundle:Question')
						 ->getQuestions($error, $valid, $diff, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin)
						 ;
			return $this->render('MDQAdminBundle:Admin:voirQ.html.twig', array(
			  'questions'   => $questions,
			  'nbquestions' => count($questions),
			  'valid' =>$valid,
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
		else if($choice=="listForm")
		{
			$nbQ=$em ->getRepository('MDQQuestionBundle:Question')
						 ->getNbQuestions($error, $valid, $diff, $game, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin)
						 ;
			$nbpp=20;//nb de question par page
			if($nbQ>$nbpp)
				{$nbmin2=($nbmin+($page-1)*$nbpp);}
			else{$nbmin2=$nbmin;}
			$nbdeQ2=$nbpp;
			$questions = $em ->getRepository('MDQQuestionBundle:Question')
						 ->getQuestions($error, $valid, $diff, $game, $dom1, $theme, $crit, $sens, $nbdeQ2, $nbmin2)
						 ;
			$nbpage=ceil($nbQ/$nbpp);
			return $this->render('MDQAdminBundle:Admin:listFormQ.html.twig', array(
			  'questions'   => $questions,
			  'nbquestions' => $nbQ,
			  'nbpage'=>$nbpage,
			  'nbpp'=>$nbpp,
			  'page'=>$page,
			  'tabdom2' => $tabdom2,
			  'tabdom3' => $tabdom3,
			  'tabtheme'=>$tabtheme,
			  'tabmedia'=>$tabmedia,
			  'choice'=>$choice,
			  'valid' =>$valid,
			  'error' => $error,
			  'diff' =>$diff,
			  'game' => $game,
			  'dom1C' => $dom1,
			  'theme' => $theme,
			  'crit' => $crit,
			  'sens' => $sens,
			  'nbdeQ' => $nbdeQ,
			  'nbmin' => $nbmin
			 ));
		}
		else{return $this->redirect($this->generateUrl('mdqadmin_accueilAdmin'));}
	}
	public function critvoirQAction($choice)
	{
		/*	if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
		// Sinon on déclenche une exception " Accès interdit "
		// throw new AccessDeniedHttpException('Accès limité aux auteurs');
			return $this->redirect($this->generateUrl('mdqquestion_accueil'));
		}
		*/	
		$crits = new CritEditQ;
		$form = $this->createForm(new CritEditQType(), $crits);
		// On récupère la requête
		$request = $this->getRequest();
		// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') {
		  // On fait le lien Requête <-> Formulaire
		  $form->bind($request);

		  // On vérifie que les valeurs entrées sont correctes
		  if ($form->isValid()) {
			
				return $this->redirect($this->generateUrl('mdqadmin_voirQ', array(
				'choice'=>$choice,
				'error'=> $crits->getError(),
				'valid'=> $crits->getValid(),
				'diff'=> $crits->getDiff(),
				'game' => $crits->getGame(),
				'dom1'=> $crits->getDom1(),
				'theme'=> $crits->getTheme()->getNom(),
				'crit'=> $crits->getCrit(),
				'sens'   => $crits->getSens(),
				'nbdeQ'   => $crits->getNbdeQ(),
				'nbmin'   => $crits->getNbmin()				
				)));
			
			
		  }
		}

		// à ce stade :
		// - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
		// - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

		return $this->render('MDQAdminBundle:Admin:critvoirQ.html.twig', array(
		  'form' => $form->createView(),
		));
	}
	public function modifQAction(Question $question, $choice, $error, $valid, $diff, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin)
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
		   
			return $this->redirect($this->generateUrl('mdqadmin_voirQ', array(
			'choice'=>$choice,
			'error'=> $error,
			'valid'=> $valid,
			'diff'=> $diff,
			'dom1'=> $dom1,
			'theme'=> $theme,
			'crit'=> $crit,
			'sens'   => $sens,
			'nbdeQ'   => $nbdeQ,
			'nbmin'   => $nbmin
			)));
		}}

		return $this->render('MDQAdminBundle:Admin:editQ.html.twig', array(
		  'form'    => $form->createView(),
		  'question' => $question,
		));
	}
	public function modifQajaxAction()
	{
		$request = $this->getRequest();	 
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{
			$valid = $request->request->get('valid');
			$idQ = $request->request->get('idQ');
			$intitule = $request->request->get('intitule');
			$brep = $request->request->get('brep');
			$mrep1 = $request->request->get('mrep1');
			$mrep2 = $request->request->get('mrep2');
			$mrep3 = $request->request->get('mrep3');
			$com = $request->request->get('com');
			$dom1 = $request->request->get('dom1');
			$dom2 = $request->request->get('dom2');
			$dom3 = $request->request->get('dom3');
			$theme = $request->request->get('theme');
			$diff = $request->request->get('diff');
			$type = $request->request->get('type');
			$delai = $request->request->get('delai');
			if($idQ!=null and $valid!=null)
			{
				$em = $this->getDoctrine()->getManager();
				$question=$em->getRepository('MDQQuestionBundle:Question')
							->findOneById($idQ);				
				$question->setValid($valid);
				$em->persist($question);
				$em->flush();
			}
			else if($idQ!=null and $intitule!=null and $brep!=null)
			{
				$em = $this->getDoctrine()->getManager();
				$question=$em->getRepository('MDQQuestionBundle:Question')
							->findOneById($idQ);				
				$question->setIntitule($intitule);
				$question->setBrep($brep);
				$question->setMrep1($mrep1);
				$question->setMrep2($mrep2);
				$question->setMrep3($mrep3);
				$question->setCommentaire($com);
				$question->setDom1($dom1);
				$question->setDom2($dom2);
				$question->setDom3($dom3);
				$question->setTheme($theme);
				$question->setDiff($diff);
				$question->setType($type);
				$question->setDelai($delai);
				$em->persist($question);
				$em->flush();
			}
			return new JsonResponse($idQ);
		}
		$data='error';
		return $data;  
	}
	public function critvoirQaValAction()
	{
		$crits = new CritEditQaVal;
		$form = $this->createForm(new CritEditQaValType(), $crits);		
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST') {
		  $form->bind($request);
		  if ($form->isValid()) {
				return $this->redirect($this->generateUrl('mdqadmin_voirQaVal', array(
				'repAdmin'=> $crits->getRepAdmin(),
				'diff'=> $crits->getDiff(),
				'dom1'=> $crits->getDom1(),
				'crit'=> $crits->getCrit(),
				'sens'   => $crits->getSens(),
				'nbdeQ'   => $crits->getNbdeQ(),
				'nbmin'   => $crits->getNbmin()
				)));						
		  }
		}
		return $this->render('MDQAdminBundle:Admin:critvoirQ.html.twig', array(
		  'form' => $form->createView(),
		));
	}
	public function voirQaValAction($page, $repAdmin, $diff, $dom1, $crit, $sens, $nbdeQ, $nbmin)
	{
		$em=$this->getDoctrine()->getManager();		
		$tabdom2 = $em	 ->getRepository('MDQQuestionBundle:Question')
						 ->recupDom2ouDom3('dom2');
		$tabdom3 = $em	 ->getRepository('MDQQuestionBundle:Question')
						 ->recupDom2ouDom3('dom3');
		$tabtheme=$em->getRepository('MDQQuestionBundle:Theme')
					->findAll();
		$tabmedia=['texte','image','citation','audio','citationlitt','suitelog'];
		$tabrepAdmin=array(
				array('value'=>0,'name'=>'Pas étudiée'),
				array('value'=>100,'name'=>'Validée !'),
				array('value'=>200,'name'=>'Dans Bddqcm, mais en attente de Validation'),
				array('value'=>1,'name'=>'Refus'),
				array('value'=>2,'name'=>'Refus : question similaire déjà présente dans la bdd'),
				array('value'=>3,'name'=>'Refus : fautes d\'orthographe ou de syntaxe'),
				array('value'=>4,'name'=>'Refus : ne correspond pas aux critères définis'),
				array('value'=>5,'name'=>'Refus : question incomplète ou pas assez développée'),
				array('value'=>6,'name'=>'Refus : question jugée inintéressante ou trop simpliste'),
				array('value'=>7,'name'=>'Refus : réponse fausse ou énoncé ambigüe'),
				array('value'=>8,'name'=>'Refus : theme ne correspondant pas aux attentes des admins'),
				array('value'=>10,'name'=>'Retour : corriger les fautes d\'orthographe et de syntaxe'),
				array('value'=>11,'name'=>'Retour : revoir la formulation'),
				array('value'=>12,'name'=>'Retour : développer le commentaire'),
				array('value'=>13,'name'=>'Retour : choisir des propositons de réponse plus pertinentes'),
			
			);
		$nbQ=$em ->getRepository('MDQQuestionBundle:QaValider')
					->getNbQuestions($repAdmin, $diff, $dom1, $crit, $sens, $nbdeQ, $nbmin)
						 ;
		$nbpp=20;//nb de question par page
		if($nbQ>$nbpp)
			{$nbmin2=($nbmin+($page-1)*$nbpp);}
		else{$nbmin2=$nbmin;}
		//$nbmin2=$nbmin;// A SUPPRIMER ENSUITE
		$nbdeQ2=$nbpp;
		$questions = $em ->getRepository('MDQQuestionBundle:QaValider')
						 ->getQuestions($repAdmin, $diff, $dom1, $crit, $sens, $nbdeQ2, $nbmin2)
						 ;
		$nbpage=ceil($nbQ/$nbpp);
		return $this->render('MDQAdminBundle:Admin:listFormQ.html.twig', array(
			  'questions'   => $questions,
			  'nbquestions' => $nbQ,
			  'nbpage'=>$nbpage,
			  'nbpp'=>$nbpp,
			  'page'=>$page,
			  'tabdom2' => $tabdom2,
			  'tabdom3' => $tabdom3,
			  'tabtheme'=>$tabtheme,
			  'tabmedia'=>$tabmedia,
			  'tabrepAdmin'=>$tabrepAdmin,
			  'diff' =>$diff,
			  'dom1C' => $dom1,
			  'repAdmin'=>$repAdmin,
			  'crit'=>$crit,
			  'sens'=>$sens,
			  'nbdeQ'=>$nbdeQ,
			  'nbmin'=>$nbmin,
			 ));		
	}
	public function retourQaValajaxAction()
	{// Qd la Qaval n'est pas ajoutée à la bdd.
		$request = $this->getRequest();	 
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{
			$idQ = $request->request->get('idQ');
			$repAdmin = $request->request->get('repAdmin');
			if($idQ!=null and $repAdmin!=null)
			{
				$em = $this->getDoctrine()->getManager();
				$question=$em->getRepository('MDQQuestionBundle:QaValider')
							->findOneById($idQ);
				$question->setRepAdmin($repAdmin);
				$question->setRetournee(0);
				$em->persist($question);
				$em->flush();
			}
			$date='ok';
			return new JsonResponse($data);
		}
		$data='error';
		return $data;  
	}
	public function insertQaValajaxAction()
	{// Qd Qaval est insérée dans la bdd
		$request = $this->getRequest();	 
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{			
				$repAdmin = $request->request->get('repAdmin');
				$idQ = $request->request->get('idQ');
				$intitule = $request->request->get('intitule');
				$brep = $request->request->get('brep');
				$mrep1 = $request->request->get('mrep1');
				$mrep2 = $request->request->get('mrep2');
				$mrep3 = $request->request->get('mrep3');
				$com = $request->request->get('com');
				$dom1 = $request->request->get('dom1');
				$dom2 = $request->request->get('dom2');
				$dom3 = $request->request->get('dom3');
				$theme = $request->request->get('theme');
				$diff = $request->request->get('diff');
				$type = $request->request->get('type');
				$delai = $request->request->get('delai');
				$doublon = $request->request->get('doublon');	
			if($idQ!=null and $intitule!=null and $brep!=null)
			{
				$em = $this->getDoctrine()->getManager();
				// avant je vais tester si cette question existe déjà dans la Bdd
				$doublons=$em->getRepository('MDQQuestionBundle:Question')
							->testDoublon('bddqcm', 'intitule', $intitule);
				if($doublons!=[] and $doublon==0){
					return new JsonResponse($doublons);
					}
				if($repAdmin==100){$valid=1;}
				if($repAdmin==200){$valid=3;}
				$qaval=$em->getRepository('MDQQuestionBundle:QaValider')
							->findOneById($idQ);
				$datecreate=$qaval->getDatecreate();
				$auteur=$qaval->getAuteur();
				$question= new Question();
				$question->setIntitule($intitule);
				$question->setBrep($brep);
				$question->setMrep1($mrep1);
				$question->setMrep2($mrep2);
				$question->setMrep3($mrep3);
				$question->setCommentaire($com);
				$question->setDom1($dom1);
				$question->setDom2($dom2);
				$question->setDom3($dom3);
				$question->setTheme($theme);
				$question->setDiff($diff);
				$question->setType($type);
				$question->setDelai($delai);
				$question->setValid($valid);
				$question->setDatecreate($datecreate);
				$question->setAuteur($auteur);
				$em->persist($question);
				//$em->remove($qaval);
				$qaval->setRepAdmin(100);
				$qaval->setRetournee(0);
				$auteur=$qaval->getAuteur();
				$auteur->setNbQValid($auteur->getNbQvalid()+1);
				//Ajouter une pertir Qnf à l'auteur concerné.
				$auteur->setNbJQnF($auteur->getNbJQnF()+1);
				$em->persist($auteur);
				$em->persist($qaval);
				$em->flush();			
			//return new JsonResponse($idQ);
			$data='ok';
			return new JsonResponse($data);
			}
		}
		$data='error';
		return new JsonResponse($data);  
	}
    public function resetThemeAction()//efface la table et remet l'incrément à 0
	{		
		$connection = $this->getDoctrine()->getManager()->getConnection();
		$platform   = $connection->getDatabasePlatform();  
		$connection->executeUpdate($platform->getTruncateTableSQL('theme', true /* whether to cascade */));
		$connection->executeUpdate($platform->getTruncateTableSQL('dom3', true /* whether to cascade */));
		$em=$this->getDoctrine()->getManager();
		$themenone=new Theme();
		$themenone->setNom("none");
		$themenone->setDom1("Pas de theme");
		$em->persist($themenone);
		$em->flush();
		return $this->redirect($this->generateUrl('mdqadmin_listeTheme'));
	}
	
	public function listeThemeAction()//pour affiche rla liste des thmes
	{
		$tabtheme=[];
		$tabdom1=['Histoire','Géographie','Sciences et nature', 'Arts et Littérature', 'Sports et loisirs', 'Divers', 'MuQuizz', 'ArQuizz', 'LxQuizz', 'FfQuizz','TvQuizz','SexyQuizz'];
		$em=$this->getDoctrine()->getManager();
		for($i=0;$i<10;$i++)
		{
		$dom1=$tabdom1[$i];		
		$themes=$em->getRepository('MDQQuestionBundle:Question')
					->recupTheme($dom1);
			foreach($themes as $theme)
			{
				if(in_array($theme, $tabtheme)!=true)
				{
					$objTheme=new Theme();
					$objTheme->setNom($theme[1]);
					$objTheme->setDom1($dom1);
					array_push($tabtheme, $theme[1]);
					$dom3s=$em->getRepository('MDQQuestionBundle:Question')
					      ->recupDom3($dom1,$theme[1]);
					$objTheme->setDom3($dom3s);
					$req=$em->getRepository('MDQQuestionBundle:Question')->findBy(
											      array('valid'=>1, 'theme'=>$theme[1])
					);
					$nbQ=count($req);
					for($j=1;$j<6;$j++)
					{					
					    $rq[$j]=$em->getRepository('MDQQuestionBundle:Question')->findBy(
											      array('valid'=>1, 'theme'=>$theme[1], 'diff'=>$j));
					    if($nbQ!=0){$prct[$j]=count($rq[$j])*100/$nbQ;}
					    else{$prct[$j]=0;}
					}
					$objTheme->setNbQ($nbQ);
					$objTheme->setprct1($prct[1]);
					$objTheme->setprct2($prct[2]);
					$objTheme->setprct3($prct[3]);
					$objTheme->setprct4($prct[4]);
					$objTheme->setprct5($prct[5]);
					$em->persist($objTheme);
					foreach($dom3s as $dom3)
					{
					     $objDom3=new Dom3();
					   //  $objTheme->addDom3map($objDom3);
					     $objDom3->setNom($dom3[1]);
					     $objDom3->setDom1($dom1);
					    $objDom3->setTheme($objTheme);
					    $req=$em->getRepository('MDQQuestionBundle:Question')->findBy(
											      array('valid'=>1, 'theme'=>$theme[1], 'dom3'=>$dom3[1])
					    );
					    $nbQ=count($req);
					    for($j=1;$j<6;$j++)
					    {					
						$rq[$j]=$em->getRepository('MDQQuestionBundle:Question')->findBy(
											      array('valid'=>1, 'theme'=>$theme[1], 'dom3'=>$dom3[1], 'diff'=>$j));
						if($nbQ!=0){$prct[$j]=count($rq[$j])*100/$nbQ;}
						else{$prct[$j]=0;}
					    }
					    $dom2s=$em->getRepository('MDQQuestionBundle:Question')->recupDom2($dom3,$theme[1]);
					    $objDom3->setNbQ($nbQ);
					    $objDom3->setprct1($prct[1]);
					    $objDom3->setprct2($prct[2]);
					    $objDom3->setprct3($prct[3]);
					    $objDom3->setprct4($prct[4]);
					    $objDom3->setprct5($prct[5]);
					    $objDom3->setDom2($dom2s);
					    $em->persist($objDom3);
					}
				}
			}
		}
					
		$em->flush();
		$tabtheme=$em->getRepository('MDQQuestionBundle:Theme')
					->findAll();
		$tabdom2=$em->getRepository('MDQQuestionBundle:Question')
					->recupDom2ouDom3('dom2');
		$tabdom3=$em->getRepository('MDQQuestionBundle:Question')
					->recupDom2ouDom3('dom3');
		//return $this->redirect($this->generateUrl('mdqadmin_accueilAdmin'));
		return $this->render('MDQAdminBundle:Admin:listeTheme.html.twig', array(
			'tabtheme' => $tabtheme,
			'tabdom2' => $tabdom2,
			'tabdom3' => $tabdom3,
			));
	}
	public function arbrathemeAction($dom1, $entete, $viewDom2)
	{
		$dom1a=$dom1;
		$dom1=[];
		$dom1['nom']=$dom1a;
		if($dom1['nom']!="none")
		{
		     $em=$this->getDoctrine()->getManager();
		     $req=$em->getRepository('MDQQuestionBundle:Theme')->findBy(array('dom1'=>$dom1['nom'])
					);
				$req2=$em->getRepository('MDQQuestionBundle:Question')->findBy(
											      array('valid'=>1, 'dom1'=>$dom1['nom'])
					);
					$dom1['nbQ']=count($req2);
					for($j=1;$j<6;$j++)
					{					
					    $rq[$j]=$em->getRepository('MDQQuestionBundle:Question')->findBy(
											      array('valid'=>1, 'dom1'=>$dom1['nom'], 'diff'=>$j));
					    if($dom1['nbQ']!=0){$dom1['d'.$j]=count($rq[$j])*100/$dom1['nbQ'];}
					    else{$dom1['d'.$j]=0;}
					}
		      	return $this->render('MDQAdminBundle:Admin:arbratheme.html.twig', array(
			'themes' => $req,
			'dom1' => $dom1,
			'entete' =>$entete,
			'viewDom2'=>$viewDom2
			));
		
		}
		else {		      	return $this->render('MDQAdminBundle:Admin:arbratheme.html.twig', array(
			'themes' => $dom1,
			'dom1' => $dom1,
			'entete' =>$entete
			));
			}
	}
	public function resetErrorAction()
	{
		$request = $this->getRequest();	 
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{
			$idQ = $request->request->get('idQ');
			if($idQ!=null)
			{
				$em = $this->getDoctrine()->getManager();
				$question=$em->getRepository('MDQQuestionBundle:Question')
							->findOneById($idQ);
				$users_error=$question->getUsers_error();
				foreach ($users_error as $scuser)
				{
					$question->removeUser_error($scuser);					
					$scuser->setNbErrorSignal($scuser->getNbErrorSignal()-1);
					//$scuser->removeQuestion_error($question);
				}
				$question->setError(0);
				$question->setTaberror([0,0,0]);
				$em->persist($question);
				$em->flush();
			}
			return new JsonResponse($idQ);
		}
		$data='none';
		return $data;  
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
		$tabParties=[];$j=0;
		foreach($botsSelects as $bot)
		{
			if($type=="Mq" or $type=="Tous")
			{
				$partieMq=AdminController::botgameMq($bot);
				$tabParties[$j]=$partieMq;
				$j++;
			}
			
			if($type=="QM" or $type=="Tous")
			{
				$partieMq=AdminController::botgameQM($bot);
				$tabParties[$j]=$partieMq;
				$j++;	
			}
		}
		
		return $this->render('MDQAdminBundle:Admin:botPartie.html.twig', array(
			'Parties' => $tabParties,
			'Bots2'=> $botsSelects2,
			'nbBotsSelect'=>$nbBotsSelect,
		));
	}
	private function calcScQ($scoreB)
	{
		$tabtpsrep=[3,4,6,10];
		$tpsrep=15-$tabtpsrep[mt_rand(0,3)];				
		$bonus=round(($scoreB/2*$tpsrep/15),0);
		$scoreQ=$scoreB+$bonus;
		return $scoreQ;
	}
	private function botgameMq(User $bot)
	{
			$em=$this->getDoctrine()->getManager();
			$gestion=$em->getRepository('MDQAdminBundle:Gestion')	
				->find(1);
			if($gestion->getMq()==0){return ;}
			$tabPartie['bot']=$bot->getUsername();
			$tabdesQ=[]; $tabdom3=[]; $tabtheme=[]; $tabidQ=[];$tabdom=['x','x','x']; $derQjoues=[];
			$tabscore=[100,200,500,1000,2000]; $tabdiff=[1,2,2,3,3,3,4,4,5,5]; $score=0;
			$scUser=$bot->getScUser();			
			$NbQtot=$scUser->getNbQtotMq();	$NbBrtot=$scUser->getNbBrtotMq();
			$NbQH=$scUser->getNbQhMq();	$NbBrH=$scUser->getNbBrhMq();$NbQG=$scUser->getNbQgMq();	$NbBrG=$scUser->getNbBrgMq();
			$NbQD=$scUser->getNbQdMq();	$NbBrD=$scUser->getNbBrdMq(); $NbQAL=$scUser->getNbQalMq();$NbBrAL=$scUser->getNbBralMq();
			$NbQSL=$scUser->getNbQslMq();$NbBrSL=$scUser->getNbBrslMq();$NbQSN=$scUser->getNbQsnMq();$NbBrSN=$scUser->getNbBrsnMq();
			$nbBrtot=$scUser->getNbBrtot();
			for($numQ=1; $numQ<11; $numQ++) {
				$NbQtot++; $scoreQ=0;
				$dom=$em->getRepository('MDQQuizzBundle:PartieQuizz')
							->tiragedudom($tabdom);
				$qtire=$em->getRepository('MDQQuestionBundle:Question')
							 ->tirageduneQMq($numQ, $dom[0], $tabdom3, $tabtheme, $derQjoues, $tabidQ);							 
				$tabdom=$dom; $tabidQ[$numQ-1]=$qtire['id'];$tabdom3[$numQ-1]=$qtire['dom3'];$tabtheme[$numQ-1]=$qtire['theme'];
				//simulation de résultat et de score
				$tabcoef=$scUser->getTabCoefBot();
				$tabdom1=array('Histoire'=>0, 'Géographie'=>1, 'Sciences et nature'=>2, 'Arts et Littérature'=>3, 'Sports et loisirs'=>4, 'Divers'=>5);
				$coefa=$tabcoef[$tabdom1[$dom[0]]];
			/*	$tabcoeffdiff=[40,20,0,-15,-30];
				$coefb=$coefa+$tabcoeffdiff[($tabdiff[$numQ-1])-1];*/
			/*	$tabcoeffdiff=[1.5,1.25,0.9,0.65,0.40];				
				$coefb=25+$coefa*$tabcoeffdiff[($tabdiff[$numQ-1])-1]*75/100;*/
				$tabcoeffdiff=[1.5,1,0.75,0.50,0.30];				
				$coefb=25+$coefa*$tabcoeffdiff[($tabdiff[$numQ-1])-1];
				$coefs=array(0=>(100-$coefb),1=>$coefb);
				$bRep=AdminController::rand_coef($coefs);
				if($bRep==1){
					$nbBrtot++;
					$scdebase=$tabscore[($tabdiff[$numQ-1])-1];
					$scoreQ=AdminController::calcScQ($scdebase);
					$score=$score+$scoreQ;
					$NbBrtot=$NbBrtot+1;
				}
				$tabPartie['scQ'.$numQ]=$scoreQ;
				if ($dom[0]=='Histoire') {				
					$NbQH=$NbQH+1;				
					if ($bRep==1){$NbBrH=$NbBrH+1;}
				}
				if ($dom[0]=='Géographie') {
					$NbQG=$NbQG+1;				
					if ($bRep==1){$NbBrG=$NbBrG+1;}
				}						
				if ($dom[0]=='Divers'){
					$NbQD=$NbQD+1;				
					if ($bRep==1){$NbBrD=$NbBrD+1;}
				}			
				if ($dom[0]=='Arts et Littérature'){
					$NbQAL=$NbQAL+1;				
					if ($bRep==1){$NbBrAL=$NbBrAL+1;}
				}
				if ($dom[0]=='Sports et loisirs'){
					$NbQSL=$NbQSL+1;				
					if ($bRep==1){$NbBrSL=$NbBrSL+1;}
				}
				if ($dom[0]=='Sciences et nature'){
					$NbQSN=$NbQSN+1;				
					if ($bRep==1){$NbBrSN=$NbBrSN+1;}
				}
			}
			
			// FINALISATION / partie et Sc et Bdd.
			$pseudo=$bot->getUsername();
			$partie=new PartieQuizz(); 
			$partie->setUsername($pseudo);
			$partie->setQ1($tabidQ[0])->setQ2($tabidQ[1])->setQ3($tabidQ[2])->setQ4($tabidQ[3])->setQ5($tabidQ[4])->setQ6($tabidQ[5])->setQ7($tabidQ[6])->setQ8($tabidQ[7])->setQ9($tabidQ[8])->setQ10($tabidQ[9]);		
			$partie->setUser($bot)->setScore($score)->setValid(true)->setType('MasterQuizz');
			
			$bot->setLastLogin(new \Datetime());
			$scUser->setNbPMq($scUser->getNbPMq()+1);
			$scUser->setNbQtotMq($NbQtot)->setNbBrtotMq($NbBrtot)->setPrctBrtotMq($NbBrtot*100/$NbQtot);
			if ($NbQH!=0){$scUser->setNbQhMq($NbQH)->setNbBrhMq($NbBrH)->setPrctBrhMq($NbBrH*100/$NbQH);}
			if ($NbQG!=0){$scUser->setNbQgMq($NbQG)->setNbBrgMq($NbBrG)->setPrctBrgMq($NbBrG*100/$NbQG);}
			if ($NbQD!=0){$scUser->setNbQdMq($NbQD)->setNbBrdMq($NbBrD)->setPrctBrdMq($NbBrD*100/$NbQD);}
			if ($NbQSN!=0){$scUser->setNbQsnMq($NbQSN)->setNbBrsnMq($NbBrSN)->setPrctBrsnMq($NbBrSN*100/$NbQSN);}
			if ($NbQSL!=0){$scUser->setNbQslMq($NbQSL)->setNbBrslMq($NbBrSL)->setPrctBrslMq($NbBrSL*100/$NbQSL);}
			if ($NbQAL!=0){$scUser->setNbQalMq($NbQAL)->setNbBralMq($NbBrAL)->setPrctBralMq($NbBrAL*100/$NbQAL);}
			$scUser->setNbBrtot($nbBrtot);
			$majbddscU= $em->getRepository('MDQUserBundle:ScUser')
						->majBddScfinP($scUser, 'MasterQuizz', 'MasterQuizz', $partie);
		/*	$scTot=$scUser->getScTotMq()+$score;
			$scUser->setScTotMq($scTot);
			$scUser->setScMoyMq($scTot/$scUser->getNbPMq());
			if($scUser->getScofDayMq()==NULL OR $score>$scUser->getScofDayMq()){
					$scUser->setScofDayMq($score);
			}
			if($score>$scUser->getScMaxMq()){
					$scUser->setScMaxMq($score);
					$scUser->setDatescMaxMq($partie->getDate());
			}
			$top5weekMq=$scUser->getTop5weekMq();
			if($score>$top5weekMq[0]){
				$top5weekMq[0]=$score;
				$scUser->setTop5weekMq($top5weekMq);
				$scUser->setSumtop5weekMq(array_sum($top5weekMq));
				if($scUser->getHightop5weekMq()==null OR $score>$scUser->getHightop5weekMq()){
					$scUser->setHightop5weekMq($score);
					}
			}
		/*	$top10mois=$scUser->getTop10month();
			if($score>$top10mois[0]){
				$top10mois[0]=$score;
				$scUser->setTop10month($top10mois);
				$scUser->setSumtop10month(array_sum($top10mois));
			}*/
			$em->persist($scUser);
			$em->persist($partie);
			$em->flush();
			$tabPartie['sctot']=$score;
			$tabPartie['game']="MasterQuizz";
			return $tabPartie;
	}

	private function botgameQM(User $bot)
	{
			$em=$this->getDoctrine()->getManager();
			$scUser=$bot->getScUser();
			$gestion=$em->getRepository('MDQAdminBundle:Gestion')	
				->find(1);
			$GFf=$gestion->getFf(); $GLx=$gestion->getLx(); $GMc=$gestion->getMc(); $GAr=$gestion->getAr();
			if($GFf+$GLx+$GMc+$GAr==0){return;}
			 $tab4game=['MuQuizz','ArQuizz','FfQuizz','LxQuizz'];
			 $tabGestion=[$GMc,$GAr,$GFf,$GLx];
			 $nbG=0;
			 $tabgame=[];
			for($i=0; $i<4; $i++)
			{
			    if($tabGestion[$i]==1){
				  $nbG++;
				  array_push($tabgame,$tab4game[$i]);
				  }
			}
			 
			 $nb=mt_rand(0,$nbG-1);
			
			$game=$tabgame[$nb];
			//$game='MuQuizz';// Pour forcer le tirage de MuQuizz
			$tabPartie2['bot']=$bot->getUsername();
			$tabPartie2['game']=$game;
			$tabcoef=$scUser->getTabCoefBot();
			if($game=='MuQuizz'){$coefJ=$tabcoef[6];}
			else if($game=='ArQuizz'){$coefJ=$tabcoef[7];}
			else if($game=='FfQuizz'){$coefJ=$tabcoef[8];}
			else if($game=='LxQuizz'){$coefJ=$tabcoef[9];}
			$coefs=array(0=>(100-$coefJ),1=>$coefJ);
			$tabtheme=['x','x'];$tabidQ=[];$tabDerQ=[];$scoreP=0; $tabdom3=['x','x','x'];
			$nbQAr=$scUser->getNbQAr();	$nbBrAr=$scUser->getNbBrAr();
			$nbQFf=$scUser->getNbQFf();	$nbBrFf=$scUser->getNbBrFf();
			$nbQLx=$scUser->getNbQLx();	$nbBrLx=$scUser->getNbBrLx();
			$nbQMu=$scUser->getNbQMu();	$nbBrMu=$scUser->getNbBrMu();
			$nbBrtot=$scUser->getNbBrtot();
			$testTF=0;
			for($numQ=1; $numQ<9; $numQ++)
			{
				$qtire=$em->getRepository('MDQQuestionBundle:Question')
							->tirageduneQ($game,$tabDerQ,$tabtheme,$tabdom3,$tabidQ, $numQ);
				$tabidQ[($numQ-1)]=$qtire['id'];
				$rep=AdminController::rand_coef($coefs);
				if($rep==1){$nbBrtot++;}
				if($game=='ArQuizz'){	
					$nbQAr++; $scoreQ=0;
					if($rep==1){$nbBrAr++;$scoreQ=AdminController::calcScQ(1000);$scoreP=$scoreP+$scoreQ;}					
				}
				if($game=='FfQuizz'){	
					$nbQFf++; $scoreQ=0;
					if($rep==1){$nbBrFf++;$scoreQ=AdminController::calcScQ(1000);$scoreP=$scoreP+$scoreQ;}					
				}
				if($game=='LxQuizz'){	
					$nbQLx++; $scoreQ=0;
					if($rep==1){$nbBrLx++;$scoreQ=AdminController::calcScQ(1000);$scoreP=$scoreP+$scoreQ;}					
				}
				if($game=='MuQuizz'){	
					$nbQMu++; $scoreQ=0;
					if($rep==1){$nbBrMu++;$scoreQ=AdminController::calcScQ(1000);$scoreP=$scoreP+$scoreQ;}					
				}
				$tabPartie2['scQ'.$numQ]=$scoreQ;
			}	
			if($game=='ArQuizz')
			{
				$scUser->setNbPAr($scUser->getNbPAr()+1);
				$scUser->setNbQAr($nbQAr);
				$scUser->setNbBrAr($nbBrAr);
				$scUser->setPrctBrAr($nbBrAr*100/$nbQAr);
			}
			elseif($game=='FfQuizz')
			{
				$scUser->setNbPFf($scUser->getNbPFf()+1);
				$scUser->setNbQFf($nbQFf);
				$scUser->setNbBrFf($nbBrFf);
				$scUser->setPrctBrFf($nbBrFf*100/$nbQFf);
			}
			elseif($game=='LxQuizz')
			{
				$scUser->setNbPLx($scUser->getNbPLx()+1);
				$scUser->setNbQLx($nbQLx);
				$scUser->setNbBrLx($nbBrLx);
				$scUser->setPrctBrLx($nbBrLx*100/$nbQLx);
			}
			elseif($game=='MuQuizz')
			{
				$scUser->setNbPMu($scUser->getNbPMu()+1);
				$scUser->setNbQMu($nbQMu);
				$scUser->setNbBrMu($nbBrMu);
				$scUser->setPrctBrMu($nbBrMu*100/$nbQMu);
			}
			$scUser->setNbBrtot($nbBrtot);
			$partie2=new PartieQuizz(); 
			$partie2->setUsername($bot->getUsername());
			$partie2->setQ1($tabidQ[0])->setQ2($tabidQ[1])->setQ3($tabidQ[2])->setQ4($tabidQ[3])->setQ5($tabidQ[4])->setQ6($tabidQ[5])->setQ7($tabidQ[6])->setQ8($tabidQ[7])->setQ9(null)->setQ10(null);		
			$partie2->setUser($bot)->setScore($scoreP)->setValid(true)->setType($game);
			$majbddscU= $em->getRepository('MDQUserBundle:ScUser')
						->majBddScfinP($scUser, $game, 'MediaQuizz', $partie2);
			$tabPartie2['sctot']=$scoreP;
			$tabPartie2['scQ9']="none";$tabPartie2['scQ10']="none";
			$bot->setLastLogin(new \Datetime());
			$em->persist($scUser);
			$em->persist($partie2);
			$em->flush();
			return $tabPartie2;
	}
	public function testQdoubleAction()
	{
		$repository= $this->getDoctrine()->getManager()->getRepository('MDQQuestionBundle:Question');
		$questions=$repository->findAll();
		$tabIdDouble=[];
		$tabIdInt=[];
		foreach ($questions as $question)
		{
			if (in_array($question->getIntitule(), $tabIdInt))
			{				
				$idDouble = array_search($question->getIntitule(), $tabIdInt);
				$question2=$repository->recupDataQ($idDouble);
				if($question2['brep']==$question->getBrep())
				{
					$tabdoublon[0]=$question->getId();
					$tabdoublon[1]=$idDouble;
					array_push($tabIdDouble,$tabdoublon);
				}
				else
				{
				$tabIdInt[$question->getId()]=$question->getIntitule();
				}
			}
			else
			{
			$tabIdInt[$question->getId()]=$question->getIntitule();
			}
		}
		return $this->render('MDQAdminBundle:Admin:testQdouble.html.twig', array(
			'tabIdDouble' => $tabIdDouble,
		));
	}
		public function gestionAction(Gestion $gestion)
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
        if ($user===null) {// pas sur que suffisant en terme de sécurité - bien différent de test que intance user (cf profilecontroller de FOSUser?
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        }
			$form = $this->createForm(new GestionType(), $gestion);  
			$request = $this->getRequest();
		if ($request->getMethod() == 'POST') {      
			  $form->bind($request);
			  if ($form->isValid()) {       
				$em = $this->getDoctrine()->getManager();
				$em->persist($gestion);
				$em->flush();
				return $this->redirect($this->generateUrl('mdqadmin_accueilAdmin'));
			  }
		}
		return $this->render('MDQAdminBundle:Admin:gestion.html.twig', array(
		  'form' => $form->createView(),
		));
	}
    private function rand_coef($coefs)// tirage au sort avec applicatio de coefficient sous fore de tableau - pour partie bot.
    {
      $rang = mt_rand(1, array_sum($coefs));
      $tot = 0;  
      foreach ($coefs as $key => $coef)
      {
        $tot += $coef;
        if ($tot >= $rang)
          return $key;
      }
    }
    public function mailAction()
    {
	    mail('bigbenf42@yahoo.fr', 'mail2', 'methode php', null, 'mondeduquizz@gmail.com');
	   $name="Benoit";
	   $message = \Swift_Message::newInstance()
        ->setSubject('Hello Email')
        ->setFrom('mondeduquizz@gmail.com')
        ->setTo('bigbenf42@yahoo.fr')
        ->setBody('Tu l envois ce putain de mail',
           /* $this->renderView(
                'app/Resources/views/Emails/registration.html.twig',
              //  'Emails/registration.html.twig',
                array('name' => $name)
            ),*/
            'text/html'
        )
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'Emails/registration.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        )
        */
    ;
    $this->get('mailer')->send($message);
       
    
      
    return $this->redirect($this->generateUrl('mdqadmin_accueilAdmin'));
    
    }
}
    
/*
Utilisation :

    <?php
    $coefs = array('bleu' => 5, 'jaune' => 1, 'rouge' => 3);
    echo rand_coef($coefs); // Renvoie bleu, jaune ou rouge aléatoirement mais avec plus de chances de tomber sur bleu que sur rouge, et plus de chances de tomber sur rouge que sur jaune
    // Ou encore :
    echo rand_coef(array('pile' => 7, 'face' => 3)); // a 70% de chances de renvoyer pile et 30% de renvoyer face
    ?>
*/
?>