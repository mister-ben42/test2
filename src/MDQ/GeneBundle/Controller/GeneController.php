<?php

// src/Sdz/BlogBundle/Controller/BlogController.php

namespace MDQ\GeneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use MDQ\GeneBundle\Entity\StatsQuot; //En attendant de le réactiver quand en ligne, avec un service à part


class GeneController extends Controller
{
  public function accueilAction(Request $request)
  {// Rq, je n'ai mis aucun persist et ca marche quand meme ! A etudier.
    $session = $request->getSession();
	$session->set('page', 'accueil');	
	$em=$this->getDoctrine()->getManager();
	/* Remarque : mise a jour journee et mois en meme temps que maj jur partie non validees, du coup si partie non validee en fin de journee, ou si aucune connection ensuite,
	Elle s'inscrit comme parte jouee le lendemain quelque soit l'heure où elle est jouee. A CORRIGER
	En fait il suffir juste de mettre la partie test de la date apres celle de la validation de la partie*/
	// MODIF EFFECTUEE : A tester puis effacer le passage precedent.
	// ******** Controle des parties en bdd et validation le cas echeant + mise a jours de bdd user et partie
	$geneServ = $this->container->get('mdq_gene.accueilGene');
	$geneServ->testNonValidPartie();	
	$em->flush();
	// ********** Controle de nouvelle journee -- A terme a remplacer par un CRON ******** ///
	$datejour= new \DateTime(date('Y-m-d'));
		//Reste un petit pb avec l'objet date : si pas de connexion le lundi, mais le mardi, la date de Maj de la dateref jour est celle du debut de semane, ce qui conduit a une maj automatique du jour lors de l'arrivee suivante sur la page d'accueil.
		$dateref=$em->getRepository('MDQGeneBundle:DateReference')->find(1);
		//$tabrMDQ[0]=$dateref->getRMDQ(); Que si classement mensuel
		$tabMaitres=[$dateref->getRMDQ(), null,null,null,null,null,null];
		if($dateref->getDay()!=$datejour){
			$dateref->setDay($datejour);// Je le mets la ; si je le mets apres l'operation sub dateInter, l'interval est deduit de la date entree en bdd -jsp pourquoi.

			
	//************* Controle nouvelle semaine ************** /////////////////////
		$semref=$dateref->getWeek();
		$int=$datejour->diff($semref);
		if($int->format('%a')>6){
			$tabMaitres=[null,null,null,null,null,null,null];
			$listeUser=$em->getRepository('MDQUserBundle:ScUser')
					->recupUserByCrit('kingMaster');// ****** A FAIRE PAR UNE FONCTION SIMPLIFIEE ***

			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeUser, 'KingMaster', $tabMaitres);
			$week1= new \DateInterval('P7D');
			$dateref->getWeek()->add($week1);
			$dateref->setWeek($datejour->add($int)->add($week1));
		}
	//****************************** Mise a jour, donnees du jour.*******************************
			$listeUserMq=$em->getRepository('MDQUserBundle:ScUser')
					->recupUserByCrit('scofDayMq');				
			
			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeUserMq, 'scofDayMq', $tabMaitres);
		
			$listeUQM=$em->getRepository('MDQUserBundle:ScUser')
							->recupUserByCrit('scofDayCq');
			$jetonServ = $this->container->get('mdq_user.jeton_serv');
			$jetonServ->majQuotJeton($listeUserMq);// A mixer avec le suivant
			$jetonServ->majQuotJeton($listeUQM);
			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeUQM, 'CaQuizz', $tabMaitres);
			$listeUMu=$em->getRepository('MDQUserBundle:ScUser')
						->recupUserByCrit('scofDayMu');
			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeUMu, 'MuQuizz', $tabMaitres);
			$listeUAr=$em->getRepository('MDQUserBundle:ScUser')
						->recupUserByCrit('scofDayAr');
			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeUAr, 'ArQuizz', $tabMaitres);
			$listeUFf=$em->getRepository('MDQUserBundle:ScUser')
						->recupUserByCrit('scofDayFf');
			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeUFf, 'FfQuizz', $tabMaitres);
			$listeULx=$em->getRepository('MDQUserBundle:ScUser')
						->recupUserByCrit('scofDayLx');
			$tabMaitres=$em->getRepository('MDQUserBundle:ScUser')
						->majClassement($listeULx, 'LxQuizz', $tabMaitres);

	//**** mise a jour date_ref ***********************//
					
			$dateref->setRMDQ($tabMaitres[0]);
			$dateref->setSMDQ($tabMaitres[1]);
			$dateref->setCMDQ($tabMaitres[2]);
			$dateref->setMuMDQ($tabMaitres[3]);
			$dateref->setArMDQ($tabMaitres[4]);
			$dateref->setFfMDQ($tabMaitres[5]);
			$dateref->setLxMDQ($tabMaitres[6]);
			$em->flush();
			return $this->redirect($this->generateUrl('mdqgene_accueil'));
		}
	// ************ flush final, execute toutes les mises a jour ******* ////
			
	$tabMaitre1=[$dateref->getRMDQ(),$dateref->getCMDQ(),$dateref->getSMDQ(), $dateref->getFfMDQ(), $dateref->getLxMDQ(), $dateref->getMuMDQ(), $dateref->getArMDQ()];
	$tabMaitre2=$em->getRepository('MDQUserBundle:User')->selectTabMaitres($tabMaitre1);
	$tabMaitre=$geneServ->getTabMaitre($dateref, $tabMaitre2);
	$newsA=$em->getRepository('MDQAdminBundle:News')->recupNews();
	$gestion=$em->getRepository('MDQAdminBundle:Gestion')->find(1);	
	$accueilServ = $this->container->get('mdq_gene.accueilGene');
	return $this->render('MDQGeneBundle:Gene:accueil.html.twig', array(
	  'accueilServ'=>$accueilServ,
	  'news' => $newsA,
	  'datejour'=>$datejour,
	  'gestion'=>$gestion,
	  'tabMaitre'=>$tabMaitre,
    ));
  }
   public function accueilJeuAction(Request $request)
  {
		if(!$this->container->get('mdq_admin.security')->testAutorize("simpleAction", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		$session = $request->getSession();
		$accueilJServ = $this->container->get('mdq_gene.accueilJeu');	
		$session->set('page', 'accueilJeu');
		return $this->render('MDQGeneBundle:Gene:accueilJeu.html.twig', array(
		'accueilJServ'=>$accueilJServ,
		));
  }

	public function accueilHighScoreAction()
	{
		if(!$this->container->get('mdq_admin.security')->testAutorize("simpleAction", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		$accueilHSServ = $this->container->get('mdq_gene.accueilHS');		
		return $this->render('MDQGeneBundle:Gene:accueilHighScore.html.twig', array(
		  'accueilHSServ' => $accueilHSServ,
		));
	}
	public function highScoreAction($crit, $page, $id)
	{
		if(!$this->container->get('mdq_admin.security')->testAutorize("simpleAction", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		$id_connect=0;$nbparPage=20;
		if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {// ca ca marche.
			$id_connect = $this->container->get('security.token_storage')->getToken()->getUser()->getScUser()->getId();
		}
		$data=$this->container->get('mdq_gene.services')->editTxt($crit);
		if ($data['crit']=="none") {return $this->redirect($this->generateUrl('mdqgene_accueilHighScore'));}
		$highScoreTous=$this->getDoctrine()->getManager()->getRepository('MDQUserBundle:ScUser')->recupHighScore($crit,1,0);
		$nbHighScore=count($highScoreTous);
		if($id!=0){$page=$this->container->get('mdq_gene.services')->defPage($id, $highScoreTous, $nbparPage);}
		$pagi=$this->container->get('mdq_gene.services')->pagination($nbparPage, $nbHighScore, $page);
		$highScores=$this->getDoctrine()->getManager()->getRepository('MDQUserBundle:ScUser')->recupHighScore($crit,$page,$nbparPage);
		      return $this->render('MDQGeneBundle:Gene:HighScore/'.$data['nomPage'].'.html.twig', array(
		      'scusers' => $highScores,
		      'pagi' => $pagi,
		      'data' => $data,
		      'id_search'=>$id,
		      'id_connect'=>$id_connect,
		      ));
	}
	public function regleJeuAction()
	{
		if(!$this->container->get('mdq_admin.security')->testAutorize("simpleAction", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		return $this->render('MDQGeneBundle:Gene:regleJeu.html.twig');
	}
	public function afficheNewsAction()
	{
		if(!$this->container->get('mdq_admin.security')->testAutorize("simpleAction", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
		$em=$this->getDoctrine()->getManager();
			$news=$em->createQueryBuilder();
			$news->select('n.titre, n.texte, n.dateCreate')
				->from('MDQAdminBundle:News', 'n')
				->where('n.publication = :publication')
				->setParameter('publication', true)
				->orderBy('n.priorite', 'DESC')
				->addOrderBy('n.id', 'DESC');							
			$newsA=$news->getQuery()
			    ->getResult();	
		return $this->render('MDQGeneBundle:Gene:news.html.twig', array(
		'news'=>$newsA
		));
	}
}
