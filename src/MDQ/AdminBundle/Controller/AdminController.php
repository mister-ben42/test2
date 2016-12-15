<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\AdminBundle\Entity\Gestion;
use MDQ\AdminBundle\Form\Type\GestionType;
use MDQ\QuestionBundle\Entity\Theme;
use MDQ\QuestionBundle\Entity\Dom3;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminController extends Controller
{

	public function accueilAdminAction()
	{
		return $this->render('MDQAdminBundle:Admin:accueilA.html.twig');	
	}

    public function resetThemeAction()//efface la table et remet l'incrément à 0
	{		
		$connection = $this->getDoctrine()->getManager()->getConnection();
		$platform   = $connection->getDatabasePlatform();
		$em=$this->getDoctrine()->getManager();
		
	//	$connection->query('START TRANSACTION;SET FOREIGN_KEY_CHECKS=0; TRUNCATE dom3; TRUNCATE theme; SET FOREIGN_KEY_CHECKS=1; COMMIT;');// Avec dom3
		$connection->query('START TRANSACTION;SET FOREIGN_KEY_CHECKS=0; TRUNCATE theme; SET FOREIGN_KEY_CHECKS=1; COMMIT;');
		
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
					$em->persist($objTheme);
				}
			}
		}
					
		$em->flush();
		$tabtheme=$em->getRepository('MDQQuestionBundle:Theme')
					->findAll();
		return $this->render('MDQAdminBundle:Admin:listeTheme.html.twig', array(
			'tabtheme' => $tabtheme,
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
    public function testRequeteAction()
    {
	  return $this->render('MDQAdminBundle:Admin:testR.html.twig');
    }
    
	public function resetErrorAction()
	{
		$request = $this->getRequest();	 
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{
			$idQ = $request->request->get('idQ');
			if($idQ!==null)
			{
				$em = $this->getDoctrine()->getManager();
				$question=$em->getRepository('MDQQuestionBundle:Question')
							->findOneById($idQ);
				$users_error=$question->getUsers_error();
				foreach ($users_error as $scuser)
				{
					$question->removeUser_error($scuser);					
					$scuser->setNbErrorSignal($scuser->getNbErrorSignal()-1);
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
}
    

?>
