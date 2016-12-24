<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MDQ\AdminBundle\Entity\Gestion;
use MDQ\AdminBundle\Form\Type\GestionType;
use MDQ\QuestionBundle\Entity\Theme;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{

	public function accueilAdminAction()
	{
		return $this->render('MDQAdminBundle:Admin:accueilA.html.twig');	
	}

    public function resetThemeAction()//efface la table et remet l'incrément à 0
	{		
		$connection = $this->getDoctrine()->getManager()->getConnection();
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
		$tabdom1=['Histoire','Géographie','Sciences et nature', 'Arts et Littérature', 'Sports et loisirs', 'Divers', 'MuQuizz', 'ArQuizz', 'LxQuizz', 'WzQuizz', 'FfQuizz','TvQuizz','SexyQuizz'];
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

	public function gestionAction(Gestion $gestion, Request $request)
	{
		$user = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($user===null) {// pas sur que suffisant en terme de sécurité - bien différent de test que intance user (cf profilecontroller de FOSUser?
            return $this->redirect($this->generateUrl('mdqgene_accueil'));
        }
			$form = $this->get('form.factory')->create(GestionType::class, $gestion);  
		if ($request->getMethod() == 'POST' && $form->handleRequest($request)->isValid()) {   
				$em = $this->getDoctrine()->getManager();
				$em->persist($gestion);
				$em->flush();
				return $this->redirect($this->generateUrl('mdqadmin_accueilAdmin'));
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
	  $depts = array();
$depts["01"] = "Ain";
$depts["02"] = "Aisne";
$depts["03"] = "Allier";
$depts["04"] = "Alpes de Haute Provence";
$depts["05"] = "Hautes Alpes";
$depts["06"] = "Alpes Maritimes";
$depts["07"] = "Ardèche";
$depts["08"] = "Ardennes";
$depts["09"] = "Ariège";
$depts["10"] = "Aube";
$depts["11"] = "Aude";
$depts["12"] = "Aveyron";
$depts["13"] = "Bouches du Rhône";
$depts["14"] = "Calvados";
$depts["15"] = "Cantal";
$depts["16"] = "Charente";
$depts["17"] = "Charente Maritime";
$depts["18"] = "Cher";
$depts["19"] = "Corrèze";
$depts["2A"] = "Corse du Sud";
$depts["2B"] = "Haute Corse";
$depts["21"] = "Côte d'Or";
$depts["22"] = "Côtes d'Armor";
$depts["23"] = "Creuse";
$depts["24"] = "Dordogne";
$depts["25"] = "Doubs";
$depts["26"] = "Drôme";
$depts["27"] = "Eure";
$depts["28"] = "Eure et Loir";
$depts["29"] = "Finistère";
$depts["30"] = "Gard";
$depts["31"] = "Haute Garonne";
$depts["32"] = "Gers";
$depts["33"] = "Gironde";
$depts["34"] = "Hérault";
$depts["35"] = "Ille et Vilaine";
$depts["36"] = "Indre";
$depts["37"] = "Indre et Loire";
$depts["38"] = "Isère";
$depts["39"] = "Jura";
$depts["40"] = "Landes";
$depts["41"] = "Loir et Cher";
$depts["42"] = "Loire";
$depts["43"] = "Haute Loire";
$depts["44"] = "Loire Atlantique";
$depts["45"] = "Loiret";
$depts["46"] = "Lot";
$depts["47"] = "Lot et Garonne";
$depts["48"] = "Lozère";
$depts["49"] = "Maine et Loire";
$depts["50"] = "Manche";
$depts["51"] = "Marne";
$depts["52"] = "Haute Marne";
$depts["53"] = "Mayenne";
$depts["54"] = "Meurthe et Moselle";
$depts["55"] = "Meuse";
$depts["56"] = "Morbihan";
$depts["57"] = "Moselle";
$depts["58"] = "Nièvre";
$depts["59"] = "Nord";
$depts["60"] = "Oise";
$depts["61"] = "Orne";
$depts["62"] = "Pas de Calais";
$depts["63"] = "Puy de Dôme";
$depts["64"] = "Pyrénées Atlantiques";
$depts["65"] = "Hautes Pyrénées";
$depts["66"] = "Pyrénées Orientales";
$depts["67"] = "Bas Rhin";
$depts["68"] = "Haut Rhin";
$depts["69"] = "Rhône";
$depts["70"] = "Haute Saône";
$depts["71"] = "Saône et Loire";
$depts["72"] = "Sarthe";
$depts["73"] = "Savoie";
$depts["74"] = "Haute Savoie";
$depts["75"] = "Paris";
$depts["76"] = "Seine Maritime";
$depts["77"] = "Seine et Marne";
$depts["78"] = "Yvelines";
$depts["79"] = "Deux Sèvres";
$depts["80"] = "Somme";
$depts["81"] = "Tarn";
$depts["82"] = "Tarn et Garonne";
$depts["83"] = "Var";
$depts["84"] = "Vaucluse";
$depts["85"] = "Vendée";
$depts["86"] = "Vienne";
$depts["87"] = "Haute Vienne";
$depts["88"] = "Vosges";
$depts["89"] = "Yonne";
$depts["90"] = "Territoire de Belfort";
$depts["91"] = "Essonne";
$depts["92"] = "Hauts de Seine";
$depts["93"] = "Seine St Denis";
$depts["94"] = "Val de Marne";
$depts["95"] = "Val d'Oise";
	
	
	  return $this->render('MDQAdminBundle:Admin:testR.html.twig', array(
		'depts'=>$depts,	
		));
    }
    
	public function resetErrorAction(Request $request)
	{
		if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
		{
			$idQ = $request->request->get('idQ');
			if($idQ!==null)
			{
				$em = $this->getDoctrine()->getManager();
				$question=$em->getRepository('MDQQuestionBundle:Question')
							->findOneById($idQ);
				$users_error=$question->getUsersError();
				foreach ($users_error as $scuser)
				{
					$question->removeUsersError($scuser);					
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
