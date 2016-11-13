<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\UserBundle\Entity\User;
use MDQ\UserBundle\Form\UserBlockType;
use MDQ\UserBundle\Entity\CritEditU;
use MDQ\UserBundle\Form\CritEditUType;
use MDQ\AdminBundle\Entity\Gestion;
use MDQ\AdminBundle\Form\GestionType;
use MDQ\QuestionBundle\Entity\Theme;
use MDQ\QuestionBundle\Entity\Dom3;

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
				if(in_array($theme, $tabtheme)!==true)
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
		return $this->render('MDQAdminBundle:Admin:listeTheme.html.twig', array(
			'tabtheme' => $tabtheme,
			'tabdom2' => $tabdom2,
			'tabdom3' => $tabdom3,
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
 
    public function mailAction()
    {
	    mail('bigbenf42@yahoo.fr', 'mail2', 'methode php', null, 'mondeduquizz@gmail.com');
	  // $name="Benoit";
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
    

?>
