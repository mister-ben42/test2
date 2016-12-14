<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\AdminBundle\Entity\Gestion;
use MDQ\AdminBundle\Form\Type\GestionType;
use MDQ\QuestionBundle\Entity\Theme;
use MDQ\QuestionBundle\Entity\Dom3;

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
		
		$connection->query('START TRANSACTION;SET FOREIGN_KEY_CHECKS=0; TRUNCATE dom3; TRUNCATE theme; SET FOREIGN_KEY_CHECKS=1; COMMIT;');
	//	$connection->executeUpdate($platform->getTruncateTableSQL('dom3', true /* whether to cascade */));
	//	$connection->executeUpdate($platform->getTruncateTableSQL('theme', true /* whether to cascade */));
		
		
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
